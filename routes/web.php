<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.pages.index');
})->name('login');

// Legal & Compliance Pages (SUmatra Sales Private Limited / Rani Matrimonial)
Route::get('/privacy-policy', function () {
    return view('frontend.pages.privacy_policy');
})->name('privacy.policy');

Route::get('/terms-and-conditions', function () {
    return view('frontend.pages.terms_conditions');
})->name('terms.conditions');

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
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Candidate Dashboard, Profile, Photos, Wallet & Matches
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-profile', [AuthController::class, 'myProfile'])->name('my-profile');
    Route::get('/my-photos', [AuthController::class, 'myPhotos'])->name('my-photos');

    // Matches Routes
    Route::get('/matches', [MatchesController::class, 'index'])->name('matches');
    Route::get('/profile/{id}', [MatchesController::class, 'showProfile'])->name('matches.view-profile');
    Route::post('/api/matches/send-interest', [MatchesController::class, 'sendInterest'])->name('matches.send-interest');
    Route::post('/api/matches/respond-interest', [MatchesController::class, 'respondInterest'])->name('matches.respond-interest');
    Route::post('/api/matches/shortlist', [MatchesController::class, 'toggleShortlist'])->name('matches.shortlist');
    Route::post('/api/matches/request-whatsapp-chat', [MatchesController::class, 'requestWhatsAppChat'])->name('matches.request-whatsapp-chat');
    Route::post('/api/matches/respond-whatsapp-chat', [MatchesController::class, 'respondWhatsAppChat'])->name('matches.respond-whatsapp-chat');

    // Inbox Routes (Received Connection Requests)
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox');

    // Wallet Routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('/api/wallet/add-money', [WalletController::class, 'addMoney'])->name('wallet.add-money');
    Route::post('/api/wallet/razorpay/create-order', [WalletController::class, 'createRazorpayOrder'])->name('wallet.razorpay.create-order');
    Route::post('/api/wallet/razorpay/verify-payment', [WalletController::class, 'verifyRazorpayPayment'])->name('wallet.razorpay.verify-payment');
    Route::post('/api/wallet/spend-money', [WalletController::class, 'spendMoney'])->name('wallet.spend-money');

    // Profile Updates
    Route::post('/api/my-profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/api/my-profile/upload-photo', [AuthController::class, 'uploadProfilePicture'])->name('profile.upload-photo');

    // Gallery Photos Management
    Route::post('/api/my-photos/upload', [AuthController::class, 'uploadGalleryPhotos'])->name('photos.upload');
    Route::post('/api/my-photos/set-profile', [AuthController::class, 'setProfilePhoto'])->name('photos.set-profile');
    Route::post('/api/my-photos/delete', [AuthController::class, 'deletePhoto'])->name('photos.delete');
    Route::post('/api/my-photos/settings', [AuthController::class, 'updatePhotoSettings'])->name('photos.settings');
});
