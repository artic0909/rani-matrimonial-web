<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('frontend.pages.index');
})->name('login');

// Candidate Auth Routes
Route::post('/api/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/api/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/api/send-registration-otp', [AuthController::class, 'sendRegistrationOtp'])->name('send.registration.otp');
Route::post('/api/verify-registration-otp', [AuthController::class, 'verifyRegistrationOtp'])->name('verify.registration.otp');
Route::post('/api/register', [AuthController::class, 'register'])->name('register');
Route::post('/api/register-phase-1', [AuthController::class, 'registerPhase1'])->name('register.phase1');
Route::post('/register/step1', [AuthController::class, 'registerStep1'])->name('register.step1');
Route::get('/register/complete-profile', [AuthController::class, 'completeProfile'])->name('register.complete');
Route::post('/register/final', [AuthController::class, 'registerFinal'])->name('register.final');

// Candidate Dashboard
Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
