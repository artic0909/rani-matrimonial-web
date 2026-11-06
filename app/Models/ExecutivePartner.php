<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExecutivePartner extends Model
{
    use HasFactory;

    protected $table = 'executive_partners';

    protected $fillable = [
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
     * Auto-generate sequential unique EP code, e.g. EP001, EP002
     */
    public static function generateUniqueCode(): string
    {
        $last = static::orderByDesc('id')->first();
        $nextNum = $last ? ($last->id + 1) : 1;
        $code = 'EP' . str_pad((string) $nextNum, 3, '0', STR_PAD_LEFT);

        while (static::where('code', $code)->exists()) {
            $nextNum++;
            $code = 'EP' . str_pad((string) $nextNum, 3, '0', STR_PAD_LEFT);
        }

        return $code;
    }

    /**
     * Related Ground Partners
     */
    public function groundPartners(): HasMany
    {
        return $this->hasMany(GroundPartner::class, 'ep_id');
    }

    /**
     * Short alias for groundPartners
     */
    public function gps(): HasMany
    {
        return $this->groundPartners();
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

