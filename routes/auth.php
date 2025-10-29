<?php

use App\Http\Controllers\Shared\AuthenticatedSessionController;
use App\Http\Controllers\Shared\NewPasswordController;
use App\Http\Controllers\Shared\PasswordResetLinkController;
use App\Http\Controllers\Alumni\RegistrationController;
use App\Http\Controllers\Alumni\GuestController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('terms-and-privacy', [GuestController::class, 'showTermsAndPrivacy'])
        ->name('terms.privacy');

    Route::get('alumni/login', [AuthenticatedSessionController::class, 'showAlumniLogin'])
        ->name('alumni.login');

    Route::get('admin/login', [AuthenticatedSessionController::class, 'showAdminLogin'])
        ->name('admin.login');

    Route::post('alumni/login', [AuthenticatedSessionController::class, 'login'])
        ->name('alumni.login.submit');

    Route::post('admin/login', [AuthenticatedSessionController::class, 'login'])
        ->name('admin.login.submit');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'showForgotPassword'])->name('password.email');
    Route::get('verification-code', [PasswordResetLinkController::class, 'showVerifyCode'])->name('password.code');

    Route::get('reset-password', [NewPasswordController::class, 'showNewPassword'])->name('password.store');

    Route::prefix('alumni/register')->group(function () {
        Route::prefix('personal-information')->group(function () {
            Route::get('/', [RegistrationController::class, 'showPersonalForm'])->name('register.personal');
            Route::post('/', [RegistrationController::class, 'storePersonal'])->name('register.personal.submit');
        });

        Route::prefix('education-background')->group(function () {
            Route::get('/', [RegistrationController::class, 'showEducationForm'])->name('register.education');
            Route::post('/', [RegistrationController::class, 'storeEducation'])->name('register.education.submit');
        });

        Route::prefix('career-information')->group(function () {
            Route::get('/', [RegistrationController::class, 'showCareerForm'])->name('register.employment');
            Route::post('/', [RegistrationController::class, 'storeCareer'])->name('register.employment.submit');
        });

        Route::prefix('credentials')->group(function () {
            Route::get('/', [RegistrationController::class, 'showCredentialsForm'])->name('register.credentials');
            Route::post('/', [RegistrationController::class, 'storeCredentials'])->name('register.credentials.submit');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::post('alumni/logout', [AuthenticatedSessionController::class, 'logout'])
        ->name('alumni.logout');

    Route::post('admin/logout', [AuthenticatedSessionController::class, 'logout'])
        ->name('admin.logout');
});
