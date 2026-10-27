<?php

use App\Http\Controllers\Api\AuthController;
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
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/check-user-exists', [AuthController::class, 'checkUserExists']);

// Registration Flows
Route::post('/send-registration-otp', [AuthController::class, 'sendRegistrationOtp']);
Route::post('/verify-registration-otp', [AuthController::class, 'verifyRegistrationOtp']);
Route::post('/send-selfie-link', [AuthController::class, 'sendSelfieLink']);
Route::post('/save-phone-selfie', [AuthController::class, 'savePhoneSelfie']);
Route::get('/check-selfie-status', [AuthController::class, 'checkSelfieStatus']);
Route::get('/registration-options', [AuthController::class, 'registrationOptions']);
Route::post('/register', [AuthController::class, 'registerFinal']);

// Protected Routes (Sanctum Authenticated Candidates)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Candidate Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard']);

    // Candidate Profile
    Route::get('/my-profile', [AuthController::class, 'myProfile']);
    Route::get('/user', [AuthController::class, 'myProfile']); // standard /api/user alias
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

    // Notifications
    Route::post('/notifications/{id}/read', [AuthController::class, 'markNotificationRead']);
});
