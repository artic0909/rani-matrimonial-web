<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('frontend.pages.index');
})->name('login');

// Candidate Auth Routes
Route::post('/api/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/api/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/api/check-user-exists', [AuthController::class, 'checkUserExists'])->name('check.user.exists');
Route::post('/api/send-registration-otp', [AuthController::class, 'sendRegistrationOtp'])->name('send.registration.otp');
Route::post('/api/verify-registration-otp', [AuthController::class, 'verifyRegistrationOtp'])->name('verify.registration.otp');
Route::post('/api/send-selfie-link', [AuthController::class, 'sendSelfieLink'])->name('send.selfie.link');

Route::get('/register/selfie-capture', [AuthController::class, 'showSelfieCapture'])->name('register.selfie.capture');
Route::post('/api/save-phone-selfie', [AuthController::class, 'savePhoneSelfie'])->name('save.phone.selfie');
Route::get('/api/check-selfie-status', [AuthController::class, 'checkSelfieStatus'])->name('check.selfie.status');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.page');
Route::post('/api/register/final', [AuthController::class, 'registerFinal'])->name('register.final');

// Candidate Dashboard & Profile
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-profile', [AuthController::class, 'myProfile'])->name('my-profile');
    
    // Profile Updates
    Route::post('/api/my-profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/api/my-profile/upload-photo', [AuthController::class, 'uploadProfilePicture'])->name('profile.upload-photo');
});
