<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidate extends Authenticatable
{
    protected $fillable = [
        'candidate_code', 'profile_id',
        'mobile', 'profile_for', 'gender', 'first_name', 'last_name', 'dob', 'religion',
        'email', 'community', 'sub_community', 'country', 'state', 'city',
        'police_st', 'pincode',
        'marital_status', 'height', 'diet', 'highest_qualification', 'college_name',

        'middle_name', 'living_in', 'college_address', 'income_type',
        'profession', 'designation', 'company_name', 'company_address',
        'about_yourself', 'profile_picture', 'hobbies_interests', 'selfie_verified',
        'full_address', 'aadhar_number',

        // Basics & Lifestyle
        'grew_up_in', 'blood_group', 'health_info', 'disability',
        // Religious Background
        'gothra', 'mother_tongue',
        // Astro Details
        'manglik', 'time_of_birth', 'city_of_birth',
        // Family Details
        'mother_profession', 'father_profession', 'family_location', 'sisters_count', 'brothers_count', 'family_financial_status',
        // Education & Career
        'annual_income', 'working_with',
        // Location
        'residency_status', 'zip_code',
        // Partner Preferences
        'pref_age_min', 'pref_age_max', 'pref_height_min', 'pref_height_max',
        'pref_marital_status', 'pref_religion', 'pref_community', 'pref_mother_tongue',
        'pref_country', 'pref_state', 'pref_city', 'pref_education',
        'pref_working_with', 'pref_profession', 'pref_annual_income', 'pref_diet',
        'pref_profile_managed_by',
        // Contact Details
        'contact_display_option',
        // Photo Settings
        'photo_privacy',
        'album_privacy',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected static function booted(): void
    {
        static::creating(function ($candidate) {
            if (empty($candidate->candidate_code) && empty($candidate->profile_id)) {
                $uniqueCode = static::generateUniqueProfileId();
                $candidate->candidate_code = $uniqueCode;
                $candidate->profile_id = $uniqueCode;
            } elseif (empty($candidate->candidate_code)) {
                $candidate->candidate_code = $candidate->profile_id;
            } elseif (empty($candidate->profile_id)) {
                $candidate->profile_id = $candidate->candidate_code;
            }

            if (!isset($candidate->is_active)) {
                $candidate->is_active = true;
            }
        });
    }

    /**
     * Generate a guaranteed unique Profile ID / Candidate Code (RM00001 format)
     */
    public static function generateUniqueProfileId(): string
    {
        $lastId = static::max('id') ?? 0;
        $attempt = 1;

        do {
            if ($attempt === 1) {
                $code = 'RM'.str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $code = 'RM'.str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            }
            $exists = static::where('candidate_code', $code)->orWhere('profile_id', $code)->exists();
            $attempt++;
        } while ($exists);

        return $code;
    }

    public static function generateCandidateCode(): string
    {
        return static::generateUniqueProfileId();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected function casts(): array
    {
        return [
            'hobbies_interests' => 'array',
            'selfie_verified' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(CandidatePhoto::class, 'candidate_id')->orderBy('sort_order')->orderByDesc('id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'candidate_id');
    }

    public function shortlists(): HasMany
    {
        return $this->hasMany(Shortlisted::class, 'candidate_id');
    }

    public function sentConnectionRequests(): HasMany
    {
        return $this->hasMany(ConnectionRequest::class, 'sender_id');
    }

    public function receivedConnectionRequests(): HasMany
    {
        return $this->hasMany(ConnectionRequest::class, 'receiver_id');
    }

    public function sentWhatsAppRequests(): HasMany
    {
        return $this->hasMany(WhatsAppChatRequest::class, 'sender_id');
    }

    public function receivedWhatsAppRequests(): HasMany
    {
        return $this->hasMany(WhatsAppChatRequest::class, 'receiver_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'candidate_id')->orderByDesc('id');
    }

    public function bluetick(): HasOne
    {
        return $this->hasOne(Bluetick::class, 'candidate_id')->latestOfMany();
    }

    public function blueticks(): HasMany
    {
        return $this->hasMany(Bluetick::class, 'candidate_id')->orderByDesc('id');
    }

    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->profile_picture)) {
            if (str_starts_with($this->profile_picture, 'http')) {
                return $this->profile_picture;
            }
            if (str_starts_with($this->profile_picture, 'img/')) {
                return asset($this->profile_picture);
            }
            return asset('storage/' . $this->profile_picture);
        }

        $photo = $this->photos ? ($this->photos->firstWhere('is_profile_picture', true) ?? $this->photos->first()) : null;
        if ($photo && !empty($photo->photo_path)) {
            return asset('storage/' . $photo->photo_path);
        }

        $defaultImg = strtolower($this->gender ?? '') === 'female' ? 'img/female/correct1.png' : 'img/male/correct1.png';
        if (file_exists(public_path($defaultImg))) {
            return asset($defaultImg);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode(($this->first_name ?? 'C') . ' ' . ($this->last_name ?? '')) . '&background=0d6efd&color=fff';
    }

    public function getIsBluetickVerifiedAttribute(): bool
    {
        return (bool) ($this->bluetick && (int) $this->bluetick->is_accept === 1);
    }

    /**
     * Get existing wallet or initialize a new one with a welcome bonus
     */
    public function getOrCreateWallet(): Wallet
    {
        $wallet = Wallet::where('candidate_id', $this->id)->first();
        if ($wallet) {
            $this->setRelation('wallet', $wallet);

            return $wallet;
        }

        // Generate 16-character card-style wallet id: RM + 14 digits e.g. RM88492018390001
        $walletNumber = 'RM'.str_pad((string) $this->id, 2, '0', STR_PAD_LEFT).rand(1000, 9999).rand(1000, 9999).rand(1000, 9999);
        while (Wallet::where('wallet_id', $walletNumber)->exists()) {
            $walletNumber = 'RM'.rand(10, 99).rand(1000, 9999).rand(1000, 9999).rand(1000, 9999);
        }

        $wallet = Wallet::create([
            'candidate_id' => $this->id,
            'wallet_id' => $walletNumber,
            'avl_balance' => 0.00,
            'currency' => 'INR',
            'status' => 'active',
        ]);

        $this->setRelation('wallet', $wallet);

        return $wallet;
    }

    public function getDisplayCodeAttribute(): string
    {
        return $this->candidate_code ?? $this->profile_id ?? ('RM'.str_pad($this->id, 5, '0', STR_PAD_LEFT));
    }

    /**
     * Referral record linking to the branch that onboarded/referred this candidate.
     */
    public function referral(): HasOne
    {
        return $this->hasOne(Referral::class, 'candidate_id');
    }
}
