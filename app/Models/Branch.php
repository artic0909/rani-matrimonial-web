<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'phone',
        'city',
        'state',
        'full_address',
        'aadhar_front',
        'aadhar_back',
        'designation',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($branch) {
            if (empty($branch->code)) {
                $branch->code = static::generateUniqueCode();
            }
        });
    }

    /**
     * Auto-generate sequential unique branch code, e.g. BRM001, BRM002
     */
    public static function generateUniqueCode(): string
    {
        $lastBranch = static::orderByDesc('id')->first();
        $nextNum = $lastBranch ? ($lastBranch->id + 1) : 1;
        $code = 'BRM' . str_pad((string) $nextNum, 3, '0', STR_PAD_LEFT);

        while (static::where('code', $code)->exists()) {
            $nextNum++;
            $code = 'BRM' . str_pad((string) $nextNum, 3, '0', STR_PAD_LEFT);
        }

        return $code;
    }

    public function getAadharFrontUrlAttribute(): ?string
    {
        if (empty($this->aadhar_front)) {
            return null;
        }

        if (str_starts_with($this->aadhar_front, 'http')) {
            return $this->aadhar_front;
        }

        return asset('storage/' . $this->aadhar_front);
    }

    public function getAadharBackUrlAttribute(): ?string
    {
        if (empty($this->aadhar_back)) {
            return null;
        }

        if (str_starts_with($this->aadhar_back, 'http')) {
            return $this->aadhar_back;
        }

        return asset('storage/' . $this->aadhar_back);
    }

    /**
     * Referrals recorded under this branch.
     */
    public function referrals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Referral::class, 'branch_id');
    }
}
