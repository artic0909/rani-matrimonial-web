<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\ExecutivePartnerController;
use App\Http\Controllers\Admin\GroundPartnerController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected Admin Routes (Requires Admin Authentication)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Main Modules: Candidates, Transactions, Branches, Blue Ticks
        Route::get('/candidates', [AdminController::class, 'candidates'])->name('candidates.index');
        Route::get('/candidates/{id}', [AdminController::class, 'candidateDetails'])->name('candidates.show');
        Route::post('/candidates/{id}/toggle-status', [AdminController::class, 'toggleCandidateStatus'])->name('candidates.toggle-status');
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions.index');
        Route::get('/transactions/{id}/receipt', [AdminController::class, 'downloadTransactionReceipt'])->name('transactions.receipt');
        // Branches
        Route::get('/branches', [AdminController::class, 'branches'])->name('branches.index');
        Route::post('/branches', [AdminController::class, 'storeBranch'])->name('branches.store');
        Route::get('/branches/{id}', [AdminController::class, 'showBranch'])->name('branches.show');
        Route::put('/branches/{id}', [AdminController::class, 'updateBranch'])->name('branches.update');
        Route::post('/branches/{id}/toggle-status', [AdminController::class, 'toggleBranchStatus'])->name('branches.toggle-status');
        Route::delete('/branches/{id}', [AdminController::class, 'destroyBranch'])->name('branches.destroy');

        // Executive Partners (EP) Management
        Route::get('/executive-partners', [ExecutivePartnerController::class, 'index'])->name('executive-partners.index');
        Route::post('/executive-partners', [ExecutivePartnerController::class, 'store'])->name('executive-partners.store');
        Route::get('/executive-partners/{id}', [ExecutivePartnerController::class, 'show'])->name('executive-partners.show');
        Route::put('/executive-partners/{id}', [ExecutivePartnerController::class, 'update'])->name('executive-partners.update');
        Route::post('/executive-partners/{id}/toggle-status', [ExecutivePartnerController::class, 'toggleStatus'])->name('executive-partners.toggle-status');
        Route::delete('/executive-partners/{id}', [ExecutivePartnerController::class, 'destroy'])->name('executive-partners.destroy');

        // Ground Partners (GP) Management
        Route::get('/ground-partners', [GroundPartnerController::class, 'index'])->name('ground-partners.index');
        Route::post('/ground-partners', [GroundPartnerController::class, 'store'])->name('ground-partners.store');
        Route::get('/ground-partners/{id}', [GroundPartnerController::class, 'show'])->name('ground-partners.show');
        Route::put('/ground-partners/{id}', [GroundPartnerController::class, 'update'])->name('ground-partners.update');
        Route::post('/ground-partners/{id}/toggle-status', [GroundPartnerController::class, 'toggleStatus'])->name('ground-partners.toggle-status');
        Route::delete('/ground-partners/{id}', [GroundPartnerController::class, 'destroy'])->name('ground-partners.destroy');

        // Shorthand redirect aliases for /admin/ep and /admin/gp
        Route::redirect('/ep', '/admin/executive-partners');
        Route::redirect('/gp', '/admin/ground-partners');
        Route::get('/blueticks', [AdminController::class, 'bluetickRequests'])->name('blueticks');
        Route::post('/bluetick/{id}/approve', [AdminController::class, 'approveBluetick'])->name('bluetick.approve');
        Route::post('/bluetick/{id}/reject', [AdminController::class, 'rejectBluetick'])->name('bluetick.reject');

        // Success Stories Management
        Route::get('/stories', [AdminController::class, 'stories'])->name('stories.index');
        Route::post('/stories', [AdminController::class, 'storeStory'])->name('stories.store');
        Route::get('/stories/{id}', [AdminController::class, 'showStory'])->name('stories.show');
        Route::put('/stories/{id}', [AdminController::class, 'updateStory'])->name('stories.update');
        Route::delete('/stories/{id}', [AdminController::class, 'destroyStory'])->name('stories.destroy');
        Route::post('/stories/{id}/toggle-status', [AdminController::class, 'toggleStoryStatus'])->name('stories.toggle-status');

        // Help & Contact Us Inquiries Management
        Route::get('/helps', [AdminController::class, 'helps'])->name('helps.index');
        Route::get('/helps/{id}', [AdminController::class, 'showHelp'])->name('helps.show');
        Route::post('/helps/{id}/reply', [AdminController::class, 'replyHelp'])->name('helps.reply');
        Route::delete('/helps/{id}', [AdminController::class, 'destroyHelp'])->name('helps.destroy');

        // Candidate Support Tickets Management
        Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets.index');
        Route::get('/tickets/{id}', [AdminController::class, 'showTicket'])->name('tickets.show');
        Route::post('/tickets/{id}/reply', [AdminController::class, 'replyTicket'])->name('tickets.reply');
        Route::delete('/tickets/{id}', [AdminController::class, 'destroyTicket'])->name('tickets.destroy');

        // Account Deletion Requests Management
        Route::get('/delete-requests', [AdminController::class, 'deleteRequests'])->name('delete-requests.index');
        Route::post('/delete-requests/{id}/approve', [AdminController::class, 'approveDeleteRequest'])->name('delete-requests.approve');
        Route::post('/delete-requests/{id}/reject', [AdminController::class, 'rejectDeleteRequest'])->name('delete-requests.reject');
        Route::delete('/delete-requests/{id}', [AdminController::class, 'destroyDeleteRequest'])->name('delete-requests.destroy');

        // Admin Profile & Security Settings
        Route::get('/profile', [AdminController::class, 'profileSettings'])->name('profile');
        Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password');

        // Dynamic Master Data CRUD Routes (12 Database Master Tables)
        Route::prefix('masters')->name('masters.')->group(function () {
            Route::get('/{type}', [MasterDataController::class, 'index'])->name('index');
            Route::get('/{type}/data', [MasterDataController::class, 'data'])->name('data');
            Route::get('/{type}/parents', [MasterDataController::class, 'parents'])->name('parents');
            Route::post('/{type}', [MasterDataController::class, 'store'])->name('store');
            Route::put('/{type}/{id}', [MasterDataController::class, 'update'])->name('update');
            Route::delete('/{type}/{id}', [MasterDataController::class, 'destroy'])->name('destroy');
        });

        // Template Pages
        Route::get('/tables-basic', fn() => view('admin.tables-basic'))->name('tables.basic');
        Route::get('/ui-forms', fn() => view('admin.ui-forms'))->name('ui.forms');
        Route::get('/ui-buttons', fn() => view('admin.ui-buttons'))->name('ui.buttons');
        Route::get('/page-blank', fn() => view('admin.page-blank'))->name('page.blank');
        Route::get('/page-404', fn() => view('admin.page-404'))->name('page.404');
    });
});
