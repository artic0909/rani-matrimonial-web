<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HelpSupportController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WalletController;
use App\Models\Story;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stories = Story::active()->take(9)->get();
    return view('frontend.pages.index', compact('stories'));
})->name('login');

// About Us Page (Publicly available)
Route::get('/about', function () {
    return view('frontend.pages.about');
})->name('about');

// Success Stories Page (Publicly available)
Route::get('/success-stories', function () {
    $stories = Story::active()->paginate(12);
    return view('frontend.pages.stories', compact('stories'));
})->name('stories');

// Help Center & Contact Us (Publicly available)
Route::get('/help-center', [HelpSupportController::class, 'helpCenter'])->name('help.center');
Route::get('/contact-us', [HelpSupportController::class, 'helpCenter'])->name('contact.us');
Route::post('/help-center/submit', [HelpSupportController::class, 'submitHelp'])->name('help.submit');

// Search Routes (Available for both authenticated candidates and visitors)
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/api/search/filter', [SearchController::class, 'filter'])->name('search.filter');

// Legal & Compliance Pages (SUmatra Sales Private Limited / Rani Matrimonial)
Route::get('/privacy-policy', function () {
    return view('frontend.pages.privacy_policy');
})->name('privacy.policy');

Route::get('/terms-and-conditions', function () {
    return view('frontend.pages.terms_conditions');
})->name('terms.conditions');

// Candidate Registration Pages & Web Logout
Route::get('/register/selfie-capture', [AuthController::class, 'showSelfieCapture'])->name('register.selfie.capture');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.page');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Candidate Dashboard, Profile, Photos, Wallet & Matches
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-profile', [AuthController::class, 'myProfile'])->name('my-profile');
    Route::get('/my-photos', [AuthController::class, 'myPhotos'])->name('my-photos');

    // Matches Routes
    Route::get('/matches', [MatchesController::class, 'index'])->name('matches');
    Route::get('/profile/{id}', [MatchesController::class, 'showProfile'])->name('matches.view-profile');

    // Inbox Routes (Received Connection Requests)
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox');

    // Wallet Routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/wallet/all', [WalletController::class, 'allView'])->name('wallet.all');
    Route::get('/wallet/credit', [WalletController::class, 'creditView'])->name('wallet.credit');
    Route::get('/wallet/debit', [WalletController::class, 'debitView'])->name('wallet.debit');
    Route::get('/wallet/transaction/{id}/receipt', [WalletController::class, 'downloadReceipt'])->name('wallet.transaction.receipt');

    // Profile Updates
    Route::post('/api/my-profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/api/my-profile/upload-photo', [AuthController::class, 'uploadProfilePicture'])->name('profile.upload-photo');

    // Gallery Photos Management
    Route::post('/api/my-photos/upload', [AuthController::class, 'uploadGalleryPhotos'])->name('photos.upload');
    Route::post('/api/my-photos/crop', [AuthController::class, 'cropGalleryPhoto'])->name('photos.crop');
    Route::post('/api/my-photos/set-profile', [AuthController::class, 'setProfilePhoto'])->name('photos.set-profile');
    Route::post('/api/my-photos/delete', [AuthController::class, 'deletePhoto'])->name('photos.delete');
    Route::post('/api/my-photos/settings', [AuthController::class, 'updatePhotoSettings'])->name('photos.settings');

    // Blue Tick Verification Routes
    Route::get('/bluetick-verification', [AuthController::class, 'showBlueTickVerification'])->name('bluetick.verify');
    Route::post('/api/bluetick/validate-aadhar', [AuthController::class, 'validateAadhar'])->name('bluetick.validate-aadhar');
    Route::post('/api/bluetick/submit', [AuthController::class, 'submitBlueTickVerification'])->name('bluetick.submit');

    // Candidate Support & Tickets
    Route::get('/support', [HelpSupportController::class, 'support'])->name('support.index');
    Route::post('/support/ticket', [HelpSupportController::class, 'storeTicket'])->name('support.store');

    // Notifications API
    Route::post('/api/notifications/{id}/read', [AuthController::class, 'markNotificationRead'])->name('notifications.read');
});
