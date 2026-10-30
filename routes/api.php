<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HelpSupportController;
use App\Http\Controllers\Api\InboxController;
use App\Http\Controllers\Api\MatchesController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Mobile Application
|--------------------------------------------------------------------------
|
| Base URL: https://ranimatrimonial.com/api/
| All protected endpoints require Header:
| Authorization: Bearer <sanctum_token>
| Accept: application/json
|
*/

// Public Authentication & Pre-registration Endpoints
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/check-user-exists', [AuthController::class, 'checkUserExists'])->name('check.user.exists');

// Registration Flows
Route::post('/send-registration-otp', [AuthController::class, 'sendRegistrationOtp'])->name('send.registration.otp');
Route::post('/verify-registration-otp', [AuthController::class, 'verifyRegistrationOtp'])->name('verify.registration.otp');
Route::post('/send-selfie-link', [AuthController::class, 'sendSelfieLink'])->name('send.selfie.link');
Route::post('/save-phone-selfie', [AuthController::class, 'savePhoneSelfie'])->name('save.phone.selfie');
Route::get('/check-selfie-status', [AuthController::class, 'checkSelfieStatus'])->name('check.selfie.status');
Route::get('/registration-options', [AuthController::class, 'registrationOptions'])->name('registration.options');
Route::post('/register', [AuthController::class, 'registerFinal']);
Route::post('/register/final', [AuthController::class, 'registerFinal'])->name('register.final');

// Public Help & Stories
Route::get('/help-center', [HelpSupportController::class, 'helpCenter']);
Route::post('/help-center/submit', [HelpSupportController::class, 'submitHelp']);
Route::get('/success-stories', [HelpSupportController::class, 'stories']);

// Protected Routes (Token Authenticated Candidates)
Route::middleware(\App\Http\Middleware\AuthenticateApiToken::class)->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Candidate Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard']);

    // Candidate Profile
    Route::get('/my-profile', [AuthController::class, 'myProfile']);
    Route::get('/user', [AuthController::class, 'myProfile']); // standard alias
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/upload-profile-picture', [AuthController::class, 'uploadProfilePicture']);

    // Gallery Photos & Settings
    Route::get('/my-photos', [AuthController::class, 'myPhotos']);
    Route::post('/upload-gallery-photos', [AuthController::class, 'uploadGalleryPhotos']);
    Route::post('/crop-gallery-photo', [AuthController::class, 'cropGalleryPhoto']);
    Route::post('/set-profile-photo', [AuthController::class, 'setProfilePhoto']);
    Route::post('/delete-photo', [AuthController::class, 'deletePhoto']);
    Route::post('/update-photo-settings', [AuthController::class, 'updatePhotoSettings']);

    // Blue Tick Aadhaar Verification
    Route::get('/bluetick-verification', [AuthController::class, 'showBlueTickVerification']);
    Route::post('/validate-aadhar', [AuthController::class, 'validateAadhar']);
    Route::post('/submit-bluetick-verification', [AuthController::class, 'submitBlueTickVerification']);

    // Notifications & Push
    Route::post('/save-fcm-token', [AuthController::class, 'saveFcmToken']);
    Route::post('/notifications/clear-all', [AuthController::class, 'clearAllNotifications']);
    Route::post('/notifications/{id}/read', [AuthController::class, 'markNotificationRead']);

    // Matches & Connections
    Route::get('/matches', [MatchesController::class, 'index']);
    Route::get('/matches/profile/{id}', [MatchesController::class, 'showProfile']);
    Route::post('/matches/send-interest', [MatchesController::class, 'sendInterest'])->name('matches.send-interest');
    Route::post('/matches/respond-interest', [MatchesController::class, 'respondInterest'])->name('matches.respond-interest');
    Route::post('/matches/toggle-shortlist', [MatchesController::class, 'toggleShortlist'])->name('matches.shortlist');
    Route::post('/matches/shortlist', [MatchesController::class, 'toggleShortlist']);
    Route::post('/matches/request-whatsapp-chat', [MatchesController::class, 'requestWhatsAppChat'])->name('matches.request-whatsapp-chat');
    Route::post('/matches/respond-whatsapp-chat', [MatchesController::class, 'respondWhatsAppChat'])->name('matches.respond-whatsapp-chat');

    // Inbox
    Route::get('/inbox', [InboxController::class, 'index']);

    // Search & Filters
    Route::get('/search/options', [SearchController::class, 'options']);
    Route::post('/search/filter', [SearchController::class, 'filter']);

    // Royal Wallet
    Route::get('/wallet', [WalletController::class, 'index']);
    Route::get('/wallet/transactions', [WalletController::class, 'transactions']);
    Route::post('/wallet/add-money', [WalletController::class, 'addMoney'])->name('wallet.add-money');
    Route::post('/wallet/spend-money', [WalletController::class, 'spendMoney'])->name('wallet.spend-money');
    Route::post('/wallet/razorpay/create-order', [WalletController::class, 'createRazorpayOrder'])->name('wallet.razorpay.create-order');
    Route::post('/wallet/razorpay/verify-payment', [WalletController::class, 'verifyRazorpayPayment'])->name('wallet.razorpay.verify-payment');

    // Support & Tickets
    Route::get('/support/tickets', [HelpSupportController::class, 'support']);
    Route::post('/support/tickets/create', [HelpSupportController::class, 'storeTicket']);
});
