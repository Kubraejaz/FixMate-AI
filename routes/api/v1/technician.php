<?php

use App\Http\Controllers\Api\V1\Technician\ChatController;
use App\Http\Controllers\Api\V1\Technician\DashboardController;
use App\Http\Controllers\Api\V1\Technician\EarningsController;
use App\Http\Controllers\Api\V1\Technician\JobController;
use App\Http\Controllers\Api\V1\Technician\NotificationController;
use App\Http\Controllers\Api\V1\Technician\ProfileController;
use App\Http\Controllers\Api\V1\Technician\ReviewController;
use App\Http\Controllers\Api\V1\Technician\ScheduleController;
use App\Http\Controllers\Api\V1\Technician\SkillController;
use App\Http\Controllers\Api\V1\Technician\SubscriptionController;
use App\Http\Controllers\Api\V1\Technician\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Technician portal (auth:sanctum + technician role)
|--------------------------------------------------------------------------
*/

Route::prefix('technician')->middleware(['auth:sanctum', 'api.role:technician'])->group(function () {

    // KYC verification must stay reachable while the profile is not yet verified.
    Route::get('verification', [VerificationController::class, 'show'])->name('api.technician.verification.show');
    Route::post('verification', [VerificationController::class, 'submit'])->name('api.technician.verification.submit');

    Route::middleware('api.verified')->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('api.technician.dashboard');

        // Jobs
        Route::get('jobs', [JobController::class, 'index'])->name('api.technician.jobs.index');
        Route::get('jobs/{booking}', [JobController::class, 'show'])->name('api.technician.jobs.show');
        Route::post('jobs/{booking}/accept', [JobController::class, 'accept'])->name('api.technician.jobs.accept');
        Route::post('jobs/{booking}/start-route', [JobController::class, 'startRoute'])->name('api.technician.jobs.start-route');
        Route::get('active-job', [JobController::class, 'activeJob'])->name('api.technician.active-job');
        Route::post('jobs/{booking}/location', [JobController::class, 'updateLocation'])->name('api.technician.jobs.location');
        Route::post('jobs/{booking}/verify-otp', [JobController::class, 'verifyOtp'])->name('api.technician.jobs.verify-otp');
        Route::post('jobs/{booking}/complete', [JobController::class, 'complete'])->name('api.technician.jobs.complete');

        // Earnings & schedule
        Route::get('earnings', [EarningsController::class, 'index'])->name('api.technician.earnings');
        Route::get('schedule', [ScheduleController::class, 'index'])->name('api.technician.schedule');

        // Subscriptions & FixMate Pro VIP (Phase 2)
        Route::get('subscription', [SubscriptionController::class, 'show'])->name('api.technician.subscription.show');
        Route::post('subscription/initiate-payment', [SubscriptionController::class, 'initiatePayment'])->name('api.technician.subscription.initiate-payment');
        Route::post('subscription/upgrade', [SubscriptionController::class, 'upgrade'])->name('api.technician.subscription.upgrade');
        Route::post('subscription/cancel', [SubscriptionController::class, 'cancel'])->name('api.technician.subscription.cancel');

        // Skills
        Route::get('skills', [SkillController::class, 'index'])->name('api.technician.skills.index');
        Route::post('skills', [SkillController::class, 'update'])->name('api.technician.skills.update');

        // Profile
        Route::get('profile', [ProfileController::class, 'show'])->name('api.technician.profile.show');
        Route::match(['put', 'patch'], 'profile', [ProfileController::class, 'update'])->name('api.technician.profile.update');

        // Reviews
        Route::get('reviews', [ReviewController::class, 'index'])->name('api.technician.reviews.index');
        Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('api.technician.reviews.reply');

        // Chat
        Route::get('chat/threads', [ChatController::class, 'threads'])->name('api.technician.chat.threads');
        Route::get('chat/{customer}/messages', [ChatController::class, 'messages'])->name('api.technician.chat.messages');
        Route::post('chat/messages', [ChatController::class, 'send'])->name('api.technician.chat.send');

        // Notifications
        Route::get('notifications', [NotificationController::class, 'index'])->name('api.technician.notifications.index');
        Route::post('notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('api.technician.notifications.read');
        Route::post('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('api.technician.notifications.read-all');
    });
});
