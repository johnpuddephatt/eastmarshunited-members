<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserApprovalController;


Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/register/complete', [RegisteredUserController::class, 'complete'])
    ->middleware('auth','approved')
    ->name('register.complete');

Route::get('/register/payment', [RegisteredUserController::class, 'payment'])
    ->middleware('auth')
    ->name('register.payment');

Route::post('/register/paid', [RegisteredUserController::class, 'paid'])
    ->name('register.paid');

Route::post('/register/checkout', [RegisteredUserController::class, 'checkout'])
    ->middleware('auth')
    ->name('register.checkout');

Route::get('/register/{type}', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register.type');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/approve-user/{user}', [UserApprovalController::class, 'approve'])
    ->middleware(config('filament.middleware.auth'))
    ->name('user.approve');

Route::get('/account-unapproved', [UserApprovalController::class, 'unapproved'])
->middleware(['auth','unapproved'])
->name('user.unapproved');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
