<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GpReferral extends Model
{
    use HasFactory;

    protected $table = 'gp_referrals';

    protected $fillable = [
        'gp_id',
        'candidate_id',
        'payment_id',
        'amount',
        'payment_status',
        'register_date',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'register_date' => 'datetime',
        'payment_date' => 'datetime',
    ];

    /**
     * Associated Ground Partner
     */
    public function groundPartner(): BelongsTo
    {
        return $this->belongsTo(GroundPartner::class, 'gp_id');
    }

    /**
     * Short alias for groundPartner
     */
    public function gp(): BelongsTo
    {
        return $this->groundPartner();
    }

    /**
     * Associated Candidate
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    /**
     * Check if payment is completed
     */
    public function isPaid(): bool
    {
        return strtolower((string) $this->payment_status) === 'paid';
    }

    /**
     * Scope for paid referrals
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope for pending referrals
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }
}

