<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::middleware(['guest'])->group(function () {
    // ------------------------------------------------------------------------
    // register
    Route::post('register', [Controllers\Auth\UserRegistrationController::class, 'store'])
        ->name('register.store');

    Route::get('register', [Controllers\Auth\UserRegistrationController::class, 'index'])
        ->name('register.index');

    // ------------------------------------------------------------------------
    // login
    // Route::post('login', [Controllers\Auth\AuthenticationController::class, 'store'])
    //     ->name('login.store');

    // Route::get('login', [Controllers\Auth\AuthenticationController::class, 'index'])
    //     ->name('login');

    // ------------------------------------------------------------------------
    // password reset
    Route::get('/forgot-password', [Controllers\Auth\ForgotPasswordController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [Controllers\Auth\ForgotPasswordController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [Controllers\Auth\ResetPasswordController::class, 'edit'])
        ->name('password.reset');

    Route::post('/reset-password', [Controllers\Auth\ResetPasswordController::class, 'update'])
        ->name('password.update');

    // ------------------------------------------------------------------------
    // otp support
    Route::get('/otp/challenge', [Controllers\Auth\OTPVerificationController::class, 'create'])
        ->name('otp.challenge');

    Route::post('/otp/verify', [Controllers\Auth\OTPVerificationController::class, 'store'])
        ->middleware('throttle:otp')
        ->name('otp.verify');
});
