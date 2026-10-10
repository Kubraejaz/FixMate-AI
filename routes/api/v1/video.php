<?php

use App\Http\Controllers\Api\V1\VideoMeetingApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Video consultations (auth:sanctum)
|--------------------------------------------------------------------------
| "Let's Talk" live video meetings between customers and technicians.
*/

Route::prefix('video-meetings')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [VideoMeetingApiController::class, 'initiate'])->name('api.video.meetings.initiate');
    Route::get('{code}', [VideoMeetingApiController::class, 'status'])->name('api.video.meetings.status');
    Route::post('{code}/join', [VideoMeetingApiController::class, 'join'])->name('api.video.meetings.join');
    Route::post('{code}/snapshot', [VideoMeetingApiController::class, 'snapshot'])->name('api.video.meetings.snapshot');
    Route::post('{code}/end', [VideoMeetingApiController::class, 'end'])->name('api.video.meetings.end');
});
