<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display candidate's royal wallet page
     */
    public function index()
    {
        /** @var Candidate $candidate */
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

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $wallet = $candidate->getOrCreateWallet();

        $amount = (float) $request->amount;
        $method = $request->payment_method ?? 'UPI';
        $title = 'Wallet Top-up';
        $desc = $request->custom_note ?? ('Recharge via '.$method);

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
            'message' => '₹'.number_format($amount, 2).' successfully added to your wallet!',
            'wallet' => [
                'id' => $wallet->wallet_id,
                'avl_balance' => (float) $wallet->avl_balance,
                'formatted_balance' => '₹ '.number_format($wallet->avl_balance, 2),
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
            ],
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

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $wallet = $candidate->getOrCreateWallet();

        $amount = (float) $request->amount;

        if ($wallet->avl_balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance. Please recharge your wallet.',
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
            'message' => '₹'.number_format($amount, 2).' debited successfully.',
            'wallet' => [
                'id' => $wallet->wallet_id,
                'avl_balance' => (float) $wallet->avl_balance,
                'formatted_balance' => '₹ '.number_format($wallet->avl_balance, 2),
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
            ],
        ]);
    }

    /**
     * Create Razorpay Order for Wallet Recharge
     */
    public function createRazorpayOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
        ]);

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $amount = (float) $request->amount;
        $amountInPaise = (int) round($amount * 100);

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay payment gateway credentials are not configured.',
            ], 500);
        }

        try {
            $api = new \Razorpay\Api\Api($key, $secret);
            $receiptId = 'rm_w_' . $candidate->id . '_' . time();

            $order = $api->order->create([
                'receipt' => $receiptId,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => [
                    'candidate_id' => (string) $candidate->id,
                    'candidate_code' => $candidate->display_code,
                    'purpose' => 'Wallet Recharge',
                ],
            ]);

            return response()->json([
                'success' => true,
                'key' => $key,
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'] ?? 'INR',
                'name' => 'Rani Matrimonial',
                'description' => 'Royal Wallet Top-up (₹' . number_format($amount, 2) . ')',
                'prefill' => [
                    'name' => trim(($candidate->first_name ?? '') . ' ' . ($candidate->last_name ?? '')),
                    'contact' => $candidate->phone ?? '',
                    'email' => $candidate->email ?? '',
                ],
                'theme' => [
                    'color' => '#750000',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify Razorpay Payment Signature and Credit Wallet Balance
     */
    public function verifyRazorpayPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay credentials not configured.',
            ], 500);
        }

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $wallet = $candidate->getOrCreateWallet();

        $paymentId = $request->razorpay_payment_id;
        $orderId = $request->razorpay_order_id;
        $signature = $request->razorpay_signature;
        $amount = (float) $request->amount;

        // Idempotency: Check if transaction already processed for this payment ID
        $existingTxn = \App\Models\WalletTransaction::where('description', 'like', '%' . $paymentId . '%')->first();
        if ($existingTxn) {
            $totalCredit = (float) $wallet->transactions()->where('type', 'credit')->where('status', 'completed')->sum('amount');
            $totalDebit = (float) $wallet->transactions()->where('type', 'debit')->where('status', 'completed')->sum('amount');

            return response()->json([
                'success' => true,
                'message' => 'Payment already verified and credited!',
                'wallet' => [
                    'id' => $wallet->wallet_id,
                    'avl_balance' => (float) $wallet->avl_balance,
                    'formatted_balance' => '₹ ' . number_format($wallet->avl_balance, 2),
                    'total_credit' => $totalCredit,
                    'total_debit' => $totalDebit,
                ],
                'transaction' => [
                    'id' => $existingTxn->id,
                    'transaction_id' => $existingTxn->transaction_id,
                    'type' => $existingTxn->type,
                    'amount' => (float) $existingTxn->amount,
                    'balance_after' => (float) $existingTxn->balance_after,
                    'title' => $existingTxn->title,
                    'description' => $existingTxn->description,
                    'category' => $existingTxn->category,
                    'status' => $existingTxn->status,
                    'payment_method' => $existingTxn->payment_method,
                    'created_at_formatted' => $existingTxn->created_at->format('d M Y, h:i A'),
                ],
            ]);
        }

        // Verify Razorpay Signature
        try {
            $api = new \Razorpay\Api\Api($key, $secret);
            $attributes = [
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ];
            $api->utility->verifyPaymentSignature($attributes);
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment signature. Verification failed.',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Signature verification error: ' . $e->getMessage(),
            ], 400);
        }

        // Credit to candidate's wallet
        $transaction = $wallet->credit(
            amount: $amount,
            title: 'Wallet Recharge',
            description: 'Razorpay Payment ID: ' . $paymentId . ' (Order: ' . $orderId . ')',
            category: 'Recharge',
            paymentMethod: 'Razorpay'
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
            'message' => '₹' . number_format($amount, 2) . ' successfully added to your wallet via Razorpay!',
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
            ],
        ]);
    }
}
