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
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.page');
Route::post('/api/register/final', [AuthController::class, 'registerFinal'])->name('register.final');

// Candidate Dashboard
Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
