<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SSOAuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    
    // ========= LOGIN ROUTES ==========
    // Default login shows choice page
    Route::get('login', function() {
        return view('auth.login-choice');
    })->name('login');

    // Uncomment the following lines and remove the above to make SSO the default login method
    /*
    Route::get('login', function() {
        return redirect()->route('auth.sso');
    })->name('login');
    */
    
    // Legacy login
    Route::get('login/legacy', [AuthenticatedSessionController::class, 'create'])
            ->name('login.legacy');
    Route::post('login/legacy', [AuthenticatedSessionController::class, 'store']);
    
    // ========= REGISTRATION ROUTES ==========
    // Default registration redirects to SSO
    Route::get('register', function() {
        return redirect(config('sso.auth_server') . '/register');
    })->name('register');
    
    // Legacy registration (commented out - uncomment if you want to keep it)
    // Route::get('register/legacy', [RegisteredUserController::class, 'create'])->name('register.legacy');
    // Route::post('register/legacy', [RegisteredUserController::class, 'store']);
    
    // ========= PASSWORD RESET ROUTES ==========
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.update');
});


Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
            ->name('verification.notice');
    
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
    
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
    
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');
    
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
    // Updated logout to handle SSO
    Route::get('logout', [SSOAuthController::class, 'logout'])
            ->name('logout');
    Route::post('logout', [SSOAuthController::class, 'logout']);
    
    Route::post('change-password', [SettingsController::class, 'changePassword'])
            ->name('password.change');
});


// ========= SSO AUTH ROUTES ==========
Route::middleware('guest')->group(function() {
    Route::get('/auth/sso', [SSOAuthController::class, 'redirectToSSO'])->name('auth.sso');
    Route::get('/auth/sso/callback', [SSOAuthController::class, 'handleCallback'])->name('auth.sso.callback');
});