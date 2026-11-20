<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'amount',
        'end_date',
        'is_active',
        'usage_count',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'end_date' => 'date',
            'is_active' => 'boolean',
            'usage_count' => 'integer',
        ];
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id')->latest('id');
    }

    /**
     * Check if the coupon is currently valid and not expired
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->end_date) {
            return false;
        }

        return Carbon::parse($this->end_date)->endOfDay()->isFuture();
    }

    /**
     * Auto-apply active coupon or specified code on candidate registration
     */
    public static function applyRegistrationCoupon(Candidate $candidate, ?string $specifiedCode = null): ?self
    {
        try {
            $today = now()->toDateString();
            $coupon = null;

            // 1. If a specific coupon code was provided
            if (!empty($specifiedCode)) {
                $code = strtoupper(trim($specifiedCode));
                $coupon = self::where('code', $code)
                    ->where('is_active', true)
                    ->whereDate('end_date', '>=', $today)
                    ->first();
            }

            // 2. If no coupon code was provided or wasn't found, pick the currently active registration coupon
            if (!$coupon) {
                $coupon = self::where('is_active', true)
                    ->whereDate('end_date', '>=', $today)
                    ->latest('id')
                    ->first();
            }

            if (!$coupon || (float) $coupon->amount <= 0) {
                return null;
            }

            // 3. Prevent duplicate credit for the same candidate
            $alreadyUsed = CouponUsage::where('coupon_id', $coupon->id)
                ->where('candidate_id', $candidate->id)
                ->exists();

            if ($alreadyUsed) {
                return null;
            }

            $wallet = $candidate->getOrCreateWallet();
            $amount = (float) $coupon->amount;
            $formattedAmount = number_format($amount, 2);

            $title = 'Coupon Applied: ' . $coupon->code;
            $description = 'Registration bonus coupon ' . $coupon->code . ' applied successfully. ₹' . $formattedAmount . ' credited to your Royal Wallet.';

            $txn = $wallet->credit(
                amount: $amount,
                title: $title,
                description: $description,
                category: 'Coupon',
                paymentMethod: 'Coupon Code'
            );

            CouponUsage::create([
                'coupon_id' => $coupon->id,
                'candidate_id' => $candidate->id,
                'amount' => $amount,
                'wallet_transaction_id' => $txn->id ?? null,
            ]);

            $coupon->increment('usage_count');

            Log::info("Coupon {$coupon->code} of ₹{$amount} applied to candidate ID {$candidate->id} ({$candidate->candidate_code})");

            return $coupon;
        } catch (\Throwable $e) {
            Log::error('Error applying registration coupon: ' . $e->getMessage());
            return null;
        }
    }
}
