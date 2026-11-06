<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroundPartner extends Model
{
    use HasFactory;

    protected $table = 'ground_partners';

    protected $fillable = [
        'ep_id',
        'name',
        'code',
        'mobile',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    protected static function booted(): void
    {
        static::creating(function ($partner) {
            if (empty($partner->code)) {
                $partner->code = static::generateUniqueCode();
            }
        });
    }

    /**
     * Auto-generate sequential unique GP code, e.g. GP001, GP002
     */
    public static function generateUniqueCode(): string
    {
        $last = static::orderByDesc('id')->first();
        $nextNum = $last ? ($last->id + 1) : 1;
        $code = 'GP' . str_pad((string) $nextNum, 3, '0', STR_PAD_LEFT);

        while (static::where('code', $code)->exists()) {
            $nextNum++;
            $code = 'GP' . str_pad((string) $nextNum, 3, '0', STR_PAD_LEFT);
        }

        return $code;
    }

    /**
     * Parent Executive Partner
     */
    public function executivePartner(): BelongsTo
    {
        return $this->belongsTo(ExecutivePartner::class, 'ep_id');
    }

    /**
     * Short alias for executivePartner
     */
    public function ep(): BelongsTo
    {
        return $this->executivePartner();
    }

    /**
     * Referrals recorded under this ground partner
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(GpReferral::class, 'gp_id');
    }

    /**
     * Paid referrals recorded under this ground partner
     */
    public function paidReferrals(): HasMany
    {
        return $this->hasMany(GpReferral::class, 'gp_id')->where('payment_status', 'paid');
    }

    /**
     * Check if partner is active
     */
    public function isActive(): bool
    {
        return strtolower((string) $this->status) === 'active';
    }

    /**
     * Scope for active partners
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for inactive partners
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}

