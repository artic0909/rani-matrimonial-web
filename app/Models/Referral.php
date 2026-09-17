<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    protected $fillable = [
        'branch_id',
        'candidate_id',
        'first_wallet_recharge_amount',
        'first_amount_add_date',
    ];

    protected $casts = [
        'first_wallet_recharge_amount' => 'decimal:2',
        'first_amount_add_date' => 'datetime',
    ];

    /**
     * The branch that referred the candidate.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * The candidate that was referred.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
