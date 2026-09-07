<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    /**
     * Display candidate's royal wallet page
     */
    public function index()
    {
        /** @var \App\Models\Candidate $candidate */
        $candidate = Auth::user();
        $wallet = $candidate->getOrCreateWallet();

        // Calculate summary metrics
        $totalCredit = (float) $wallet->transactions()
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');

        $totalDebit = (float) $wallet->transactions()
            ->where('type', 'debit')
            ->where('status', 'completed')
            ->sum('amount');

        // Fetch transactions for all tabs
        $allTransactions = $wallet->transactions()->orderByDesc('id')->get();
        $creditTransactions = $wallet->transactions()->where('type', 'credit')->orderByDesc('id')->get();
        $debitTransactions = $wallet->transactions()->where('type', 'debit')->orderByDesc('id')->get();

        return view('frontend.pages.wallet', compact(
            'candidate',
            'wallet',
            'totalCredit',
            'totalDebit',
            'allTransactions',
            'creditTransactions',
            'debitTransactions'
        ));
    }

    /**
     * Add funds / Recharge wallet via AJAX
     */
    public function addMoney(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
            'payment_method' => 'nullable|string|max:50',
            'custom_note' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\Candidate $candidate */
        $candidate = Auth::user();
        $wallet = $candidate->getOrCreateWallet();

        $amount = (float) $request->amount;
        $method = $request->payment_method ?? 'UPI';
        $title = 'Wallet Top-up';
        $desc = $request->custom_note ?? ('Recharge via ' . $method);

        $transaction = $wallet->credit(
            amount: $amount,
            title: $title,
            description: $desc,
            category: 'Recharge',
            paymentMethod: $method
        );

        $totalCredit = (float) $wallet->transactions()
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');

        $totalDebit = (float) $wallet->transactions()
            ->where('type', 'debit')
            ->where('status', 'completed')
            ->sum('amount');

        return response()->json([
            'success' => true,
            'message' => '₹' . number_format($amount, 2) . ' successfully added to your wallet!',
            'wallet' => [
                'id' => $wallet->wallet_id,
                'avl_balance' => (float) $wallet->avl_balance,
                'formatted_balance' => '₹ ' . number_format($wallet->avl_balance, 2),
                'total_credit' => $totalCredit,
                'total_debit' => $totalDebit,
            ],
            'transaction' => [
                'id' => $transaction->id,
                'transaction_id' => $transaction->transaction_id,
                'type' => $transaction->type,
                'amount' => (float) $transaction->amount,
                'balance_after' => (float) $transaction->balance_after,
                'title' => $transaction->title,
                'description' => $transaction->description,
                'category' => $transaction->category,
                'status' => $transaction->status,
                'payment_method' => $transaction->payment_method,
                'created_at_formatted' => $transaction->created_at->format('d M Y, h:i A'),
            ]
        ]);
    }

    /**
     * Debit funds / Spend simulation (e.g. unlocking contact or booster)
     */
    public function spendMoney(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'title' => 'required|string|max:100',
            'category' => 'nullable|string|max:50',
        ]);

        /** @var \App\Models\Candidate $candidate */
        $candidate = Auth::user();
        $wallet = $candidate->getOrCreateWallet();

        $amount = (float) $request->amount;

        if ($wallet->avl_balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance. Please recharge your wallet.'
            ], 422);
        }

        $transaction = $wallet->debit(
            amount: $amount,
            title: $request->title,
            description: $request->description ?? 'Service charge deducted from wallet',
            category: $request->category ?? 'Service',
            paymentMethod: 'Wallet Balance'
        );

        $totalCredit = (float) $wallet->transactions()
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');

        $totalDebit = (float) $wallet->transactions()
            ->where('type', 'debit')
            ->where('status', 'completed')
            ->sum('amount');

        return response()->json([
            'success' => true,
            'message' => '₹' . number_format($amount, 2) . ' debited successfully.',
            'wallet' => [
                'id' => $wallet->wallet_id,
                'avl_balance' => (float) $wallet->avl_balance,
                'formatted_balance' => '₹ ' . number_format($wallet->avl_balance, 2),
                'total_credit' => $totalCredit,
                'total_debit' => $totalDebit,
            ],
            'transaction' => [
                'id' => $transaction->id,
                'transaction_id' => $transaction->transaction_id,
                'type' => $transaction->type,
                'amount' => (float) $transaction->amount,
                'balance_after' => (float) $transaction->balance_after,
                'title' => $transaction->title,
                'description' => $transaction->description,
                'category' => $transaction->category,
                'status' => $transaction->status,
                'payment_method' => $transaction->payment_method,
                'created_at_formatted' => $transaction->created_at->format('d M Y, h:i A'),
            ]
        ]);
    }
}
