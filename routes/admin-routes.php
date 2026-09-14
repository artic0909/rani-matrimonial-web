<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    // Admin Dashboard & Blue Tick Management
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/blueticks', [AdminController::class, 'bluetickRequests'])->name('blueticks');
    Route::post('/bluetick/{id}/approve', [AdminController::class, 'approveBluetick'])->name('bluetick.approve');
    Route::post('/bluetick/{id}/reject', [AdminController::class, 'rejectBluetick'])->name('bluetick.reject');
});
