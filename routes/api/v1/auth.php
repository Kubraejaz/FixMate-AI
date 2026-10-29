<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication (public, rate limited)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::middleware('throttle:api-auth')->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('api.auth.register');
        Route::post('register/customer', [AuthController::class, 'registerCustomer'])->name('api.auth.register.customer');
        Route::post('register/technician', [AuthController::class, 'registerTechnician'])->name('api.auth.register.technician');
        Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
        Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('api.auth.verify-otp');
        Route::post('resend-otp', [AuthController::class, 'resendOtp'])->name('api.auth.resend-otp');
        Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('api.auth.forgot-password');
        Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('api.auth.reset-password');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('api.auth.me');
        Route::post('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('logout-all', [AuthController::class, 'logoutAll'])->name('api.auth.logout-all');
    });
});
