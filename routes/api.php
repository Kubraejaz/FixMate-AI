<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — FixMate Mobile Application
|--------------------------------------------------------------------------
| Versioned REST API secured with Laravel Sanctum bearer tokens. All
| endpoints return the standard envelope: { success, message, data, meta }.
|
| Modules live under routes/api/v1 and share the "api" middleware group.
*/

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'FixMate Platform API — RESTful Gateway v1.0',
        'data' => [
            'name' => 'FixMate Mobile & Web API',
            'version' => 'v1.0.0',
            'status' => 'operational',
            'documentation' => url('/api/v1'),
            'timestamp' => now()->toIso8601String(),
        ],
    ]);
})->name('api.root');

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'success' => true,
            'message' => 'FixMate API v1 Endpoints Directory',
            'data' => [
                'version' => '1.0.0',
                'envelope' => '{ success, message, data, meta }',
                'modules' => [
                    'public' => [
                        'prefix' => '/api/v1',
                        'endpoints' => ['/home', '/about', '/how-it-works', '/services', '/technicians', '/faqs', '/community'],
                    ],
                    'auth' => [
                        'prefix' => '/api/v1/auth',
                        'endpoints' => ['/register/customer', '/register/technician', '/login', '/verify-otp', '/resend-otp', '/forgot-password', '/reset-password', '/me', '/logout'],
                    ],
                    'customer' => [
                        'prefix' => '/api/v1/customer',
                        'endpoints' => ['/dashboard', '/bookings', '/bookings/{id}/tracking', '/bookings/{id}/payment', '/reviews', '/complaints', '/chat', '/notifications', '/subscription', '/profile', '/ai/diagnose'],
                    ],
                    'technician' => [
                        'prefix' => '/api/v1/technician',
                        'endpoints' => ['/dashboard', '/verification', '/jobs', '/jobs/{id}/start-route', '/jobs/{id}/location', '/jobs/{id}/verify-otp', '/jobs/{id}/complete', '/earnings', '/schedule', '/subscription', '/skills', '/reviews', '/chat', '/notifications', '/profile'],
                    ],
                    'video_consultations' => [
                        'prefix' => '/api/v1/video-meetings',
                        'endpoints' => ['/', '/{code}', '/{code}/join', '/{code}/snapshot', '/{code}/end'],
                    ],
                    'admin' => [
                        'prefix' => '/api/v1/admin',
                        'endpoints' => ['/dashboard', '/notifications', '/analytics', '/bookings', '/technicians/verification', '/technicians', '/customers', '/services', '/faqs', '/community', '/inquiries', '/homepage', '/settings', '/payments'],
                    ],
                ],
            ],
        ]);
    })->name('api.v1.index');

    require __DIR__.'/api/v1/public.php';
    require __DIR__.'/api/v1/auth.php';
    require __DIR__.'/api/v1/customer.php';
    require __DIR__.'/api/v1/technician.php';
    require __DIR__.'/api/v1/video.php';
    require __DIR__.'/api/v1/admin.php';
});
