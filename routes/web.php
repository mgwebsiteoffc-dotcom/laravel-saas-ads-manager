<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\MasterController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Onboarding
    Route::prefix('onboarding')->name('onboarding.')->group(function () {
        Route::get('/', [OnboardingController::class, 'index'])->name('index');
        Route::post('/industry', [OnboardingController::class, 'selectIndustry'])->name('industry');
        Route::post('/meta', [OnboardingController::class, 'connectMeta'])->name('meta');
        Route::post('/skip', [OnboardingController::class, 'skip'])->name('skip');
        Route::post('/complete', [OnboardingController::class, 'complete'])->name('complete');
    });
    
    // Main App
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('campaigns', CampaignController::class);
    
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [LeadController::class, 'index'])->name('index');
        Route::get('/{lead}', [LeadController::class, 'show'])->name('show');
        Route::put('/{lead}/status', [LeadController::class, 'updateStatus'])->name('update-status');
        Route::put('/{lead}/assign', [LeadController::class, 'assign'])->name('assign');
    });
    
    // Super Admin
    Route::prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/organizations', [SuperAdminDashboardController::class, 'organizations'])->name('organizations');
        
        // Masters
        Route::get('/industries', [MasterController::class, 'industries'])->name('industries');
        Route::post('/industries', [MasterController::class, 'storeIndustry'])->name('industries.store');
        Route::put('/industries/{industry}', [MasterController::class, 'updateIndustry'])->name('industries.update');
        Route::delete('/industries/{industry}', [MasterController::class, 'destroyIndustry'])->name('industries.destroy');
        
        Route::get('/lead-statuses', [MasterController::class, 'leadStatuses'])->name('lead-statuses');
        Route::post('/lead-statuses', [MasterController::class, 'storeLeadStatus'])->name('lead-statuses.store');
        Route::put('/lead-statuses/{status}', [MasterController::class, 'updateLeadStatus'])->name('lead-statuses.update');
        Route::delete('/lead-statuses/{status}', [MasterController::class, 'destroyLeadStatus'])->name('lead-statuses.destroy');
    });
});

// Public API for lead capture
Route::post('/api/leads', [LeadController::class, 'store'])->name('api.leads.store');