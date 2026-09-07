<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'wallet_id',
        'avl_balance',
        'currency',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'avl_balance' => 'decimal:2',
        ];
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id')->orderByDesc('id');
    }

    /**
     * Credit amount into wallet
     */
    public function credit(float $amount, string $title, ?string $description = null, ?string $category = 'Recharge', ?string $paymentMethod = null): WalletTransaction
    {
        return DB::transaction(function () use ($amount, $title, $description, $category, $paymentMethod) {
            $this->avl_balance += $amount;
            $this->save();

            return $this->transactions()->create([
                'candidate_id' => $this->candidate_id,
                'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
                'type' => 'credit',
                'amount' => $amount,
                'balance_after' => $this->avl_balance,
                'title' => $title,
                'description' => $description,
                'category' => $category,
                'status' => 'completed',
                'payment_method' => $paymentMethod,
            ]);
        });
    }

    /**
     * Debit amount from wallet
     */
    public function debit(float $amount, string $title, ?string $description = null, ?string $category = 'Service', ?string $paymentMethod = 'Wallet'): WalletTransaction
    {
        if ($this->avl_balance < $amount) {
            throw new \Exception('Insufficient wallet balance.');
        }

        return DB::transaction(function () use ($amount, $title, $description, $category, $paymentMethod) {
            $this->avl_balance -= $amount;
            $this->save();

            return $this->transactions()->create([
                'candidate_id' => $this->candidate_id,
                'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
                'type' => 'debit',
                'amount' => $amount,
                'balance_after' => $this->avl_balance,
                'title' => $title,
                'description' => $description,
                'category' => $category,
                'status' => 'completed',
                'payment_method' => $paymentMethod,
            ]);
        });
    }

    /**
     * Format wallet number into 4-digit card chunks (e.g. RM88 4920 1839 0001)
     */
    public function getFormattedCardNumberAttribute(): string
    {
        $clean = preg_replace('/[^A-Za-z0-9]/', '', $this->wallet_id ?? '');
        return trim(chunk_split($clean, 4, ' '));
    }
}
