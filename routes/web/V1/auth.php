<?php

use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function() {

        Route::post('/register', 'register')
            ->middleware('guest');

        Route::post('/login', 'login')
            ->middleware('guest');

        Route::post('/logout', 'logout')
            ->middleware('auth');

    });

/*
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');
*/
