<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidate extends Authenticatable
{
    protected $fillable = [
        'candidate_code', 'profile_id',
        'mobile', 'profile_for', 'gender', 'first_name', 'last_name', 'dob', 'religion',
        'email', 'community', 'sub_community', 'country', 'state', 'city',
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
        'album_privacy'
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
                $code = 'RM' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $code = 'RM' . str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
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

    protected function casts(): array
    {
        return [
            'hobbies_interests' => 'array',
            'selfie_verified' => 'boolean',
        ];
    }

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CandidatePhoto::class, 'candidate_id')->orderBy('sort_order')->orderByDesc('id');
    }

    public function wallet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Wallet::class, 'candidate_id');
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
        $walletNumber = 'RM' . str_pad((string)$this->id, 2, '0', STR_PAD_LEFT) . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
        while (Wallet::where('wallet_id', $walletNumber)->exists()) {
            $walletNumber = 'RM' . rand(10, 99) . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
        }

        $wallet = Wallet::create([
            'candidate_id' => $this->id,
            'wallet_id' => $walletNumber,
            'avl_balance' => 0.00,
            'currency' => 'INR',
            'status' => 'active',
        ]);

        // Add welcome bonus of ₹500
        $wallet->credit(500.00, 'Welcome Bonus Credits', 'Special joining bonus credited to your Rani Matrimonial Royal Wallet', 'Bonus', 'System');

        $this->setRelation('wallet', $wallet);

        return $wallet;
    }

    public function getDisplayCodeAttribute(): string
    {
        return $this->candidate_code ?? $this->profile_id ?? ('RM' . str_pad($this->id, 5, '0', STR_PAD_LEFT));
    }
}
