<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    // Admin Dashboard & Static Template Pages
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/tables-basic', fn() => view('admin.tables-basic'))->name('tables.basic');
    Route::get('/ui-forms', fn() => view('admin.ui-forms'))->name('ui.forms');
    Route::get('/ui-buttons', fn() => view('admin.ui-buttons'))->name('ui.buttons');
    Route::get('/page-blank', fn() => view('admin.page-blank'))->name('page.blank');
    Route::get('/page-404', fn() => view('admin.page-404'))->name('page.404');

    // Blue Tick Verification Features
    Route::get('/blueticks', [AdminController::class, 'bluetickRequests'])->name('blueticks');
    Route::post('/bluetick/{id}/approve', [AdminController::class, 'approveBluetick'])->name('bluetick.approve');
    Route::post('/bluetick/{id}/reject', [AdminController::class, 'rejectBluetick'])->name('bluetick.reject');
});
