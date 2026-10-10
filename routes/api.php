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

Route::prefix('v1')->group(function () {
    require __DIR__.'/api/v1/public.php';
    require __DIR__.'/api/v1/auth.php';
    require __DIR__.'/api/v1/customer.php';
    require __DIR__.'/api/v1/technician.php';
    require __DIR__.'/api/v1/video.php';
    require __DIR__.'/api/v1/admin.php';
});
