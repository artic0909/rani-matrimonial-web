<?php

use App\Models\Candidate;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

uses(RefreshDatabase::class);

test('newly registered candidate has wallet with zero balance and no bonus transactions', function () {
    $candidate = Candidate::create([
        'mobile' => '9876543210',
        'first_name' => 'Aditi',
        'last_name' => 'Sharma',
        'gender' => 'Female',
    ]);

    $wallet = $candidate->getOrCreateWallet();

    expect($wallet)->toBeInstanceOf(Wallet::class)
        ->and((float) $wallet->avl_balance)->toBe(0.00)
        ->and($wallet->transactions()->count())->toBe(0);
});

test('candidate cannot create razorpay order without authentication', function () {
    $response = $this->postJson('/api/wallet/razorpay/create-order', [
        'amount' => 500,
    ]);

    $response->assertStatus(401);
});

test('candidate cannot create razorpay order with invalid amount', function () {
    $candidate = Candidate::create([
        'mobile' => '9876543219',
        'first_name' => 'Pooja',
        'last_name' => 'Mehra',
        'gender' => 'Female',
    ]);

    $this->actingAs($candidate)->postJson('/api/wallet/razorpay/create-order', [
        'amount' => 0,
    ])->assertStatus(422)
      ->assertJsonValidationErrors(['amount']);

    $this->actingAs($candidate)->postJson('/api/wallet/razorpay/create-order', [
        'amount' => -10,
    ])->assertStatus(422)
      ->assertJsonValidationErrors(['amount']);
});

test('candidate cannot verify razorpay payment without authentication', function () {
    $response = $this->postJson('/api/wallet/razorpay/verify-payment', [
        'razorpay_payment_id' => 'pay_test123',
        'razorpay_order_id' => 'order_test123',
        'razorpay_signature' => 'sig_test123',
        'amount' => 500,
    ]);

    $response->assertStatus(401);
});

test('candidate can verify valid razorpay payment and wallet balance increases accordingly', function () {
    $secret = 'test_secret_key_123';
    Config::set('services.razorpay.key', 'rzp_test_key_123');
    Config::set('services.razorpay.secret', $secret);

    $candidate = Candidate::create([
        'mobile' => '9876543211',
        'first_name' => 'Rohan',
        'last_name' => 'Verma',
        'gender' => 'Male',
    ]);

    $orderId = 'order_test_88888';
    $paymentId = 'pay_test_99999';
    $amount = 1500.00;

    // Generate valid HMAC SHA256 signature
    $signature = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);

    $response = $this->actingAs($candidate)->postJson('/api/wallet/razorpay/verify-payment', [
        'razorpay_payment_id' => $paymentId,
        'razorpay_order_id' => $orderId,
        'razorpay_signature' => $signature,
        'amount' => $amount,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'wallet' => [
                'avl_balance' => 1500,
                'total_credit' => 1500,
                'total_debit' => 0,
            ],
        ]);

    $wallet = $candidate->wallet;
    expect((float) $wallet->avl_balance)->toBe(1500.00)
        ->and($wallet->transactions()->count())->toBe(1);

    $txn = $wallet->transactions()->first();
    expect($txn->type)->toBe('credit')
        ->and((float) $txn->amount)->toBe(1500.00)
        ->and($txn->category)->toBe('Recharge')
        ->and($txn->payment_method)->toBe('Razorpay')
        ->and($txn->description)->toContain($paymentId);
});

test('razorpay payment verification fails with invalid signature', function () {
    $secret = 'test_secret_key_123';
    Config::set('services.razorpay.key', 'rzp_test_key_123');
    Config::set('services.razorpay.secret', $secret);

    $candidate = Candidate::create([
        'mobile' => '9876543212',
        'first_name' => 'Kunal',
        'last_name' => 'Roy',
        'gender' => 'Male',
    ]);

    $response = $this->actingAs($candidate)->postJson('/api/wallet/razorpay/verify-payment', [
        'razorpay_payment_id' => 'pay_test_fake',
        'razorpay_order_id' => 'order_test_fake',
        'razorpay_signature' => 'invalid_signature_hash',
        'amount' => 500,
    ]);

    $response->assertStatus(400)
        ->assertJson([
            'success' => false,
        ]);
});

test('idempotent payment verification does not double credit', function () {
    $secret = 'test_secret_key_123';
    Config::set('services.razorpay.key', 'rzp_test_key_123');
    Config::set('services.razorpay.secret', $secret);

    $candidate = Candidate::create([
        'mobile' => '9876543213',
        'first_name' => 'Simran',
        'last_name' => 'Kaur',
        'gender' => 'Female',
    ]);

    $orderId = 'order_test_idem_1';
    $paymentId = 'pay_test_idem_1';
    $amount = 500.00;
    $signature = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);

    // First request
    $this->actingAs($candidate)->postJson('/api/wallet/razorpay/verify-payment', [
        'razorpay_payment_id' => $paymentId,
        'razorpay_order_id' => $orderId,
        'razorpay_signature' => $signature,
        'amount' => $amount,
    ])->assertStatus(200);

    // Second request with same payment ID
    $secondResponse = $this->actingAs($candidate)->postJson('/api/wallet/razorpay/verify-payment', [
        'razorpay_payment_id' => $paymentId,
        'razorpay_order_id' => $orderId,
        'razorpay_signature' => $signature,
        'amount' => $amount,
    ]);

    $secondResponse->assertStatus(200);

    $wallet = $candidate->wallet()->first();
    expect((float) $wallet->avl_balance)->toBe(500.00)
        ->and($wallet->transactions()->count())->toBe(1);
});
