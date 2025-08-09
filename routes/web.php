<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Affiliate;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Public routes
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Program catalog (public)
Route::controller(ProgramController::class)->group(function () {
    Route::get('/programs', 'index')->name('programs.index');
    Route::get('/programs/{program}', 'show')->name('programs.show');
});

// Registration (public)
Route::controller(RegistrationController::class)->group(function () {
    Route::get('/programs/{program}/register', 'create')->name('registration.create');
    Route::post('/programs/{program}/register', 'store')->name('registration.store');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard route - redirects based on user role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isAffiliate()) {
            return redirect()->route('affiliate.dashboard');
        }
        
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // Admin routes
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Affiliate management
        Route::resource('affiliates', Admin\AffiliateController::class);
        
        // Program management
        Route::resource('programs', Admin\ProgramController::class);
        
        // Referral management
        Route::controller(Admin\ReferralController::class)->prefix('referrals')->name('referrals.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{referral}', 'show')->name('show');
            Route::patch('/{referral}', 'update')->name('update');
        });
        
        // Payout management
        Route::resource('payouts', Admin\PayoutController::class);
    });
    
    // Affiliate routes
    Route::middleware([\App\Http\Middleware\AffiliateMiddleware::class])->prefix('affiliate')->name('affiliate.')->group(function () {
        Route::get('/dashboard', [Affiliate\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/referrals', [Affiliate\ReferralController::class, 'index'])->name('referrals');
        Route::get('/payouts', [Affiliate\PayoutController::class, 'index'])->name('payouts');
        Route::get('/marketing', [Affiliate\MarketingController::class, 'index'])->name('marketing');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';