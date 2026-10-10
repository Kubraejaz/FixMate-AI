<?php

use App\Http\Controllers\Api\V1\AI\AiDiagnosisController;
use App\Http\Controllers\Api\V1\Customer\BookingController;
use App\Http\Controllers\Api\V1\Customer\ChatController;
use App\Http\Controllers\Api\V1\Customer\ComplaintController;
use App\Http\Controllers\Api\V1\Customer\DashboardController;
use App\Http\Controllers\Api\V1\Customer\NotificationController;
use App\Http\Controllers\Api\V1\Customer\ProfileController;
use App\Http\Controllers\Api\V1\Customer\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer portal (auth:sanctum + customer role)
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->middleware(['auth:sanctum', 'api.role:customer'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('api.customer.dashboard');

    // Bookings
    Route::get('bookings', [BookingController::class, 'index'])->name('api.customer.bookings.index');
    Route::post('bookings', [BookingController::class, 'store'])->name('api.customer.bookings.store');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('api.customer.bookings.show');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('api.customer.bookings.cancel');
    Route::get('bookings/{booking}/tracking', [BookingController::class, 'tracking'])->name('api.customer.bookings.tracking');
    Route::post('bookings/{booking}/payment', [BookingController::class, 'processPayment'])->name('api.customer.bookings.payment');

    // Reviews
    Route::get('reviews', [ReviewController::class, 'index'])->name('api.customer.reviews.index');
    Route::post('bookings/{booking}/review', [ReviewController::class, 'store'])->name('api.customer.reviews.store');

    // Complaints / disputes
    Route::get('complaints', [ComplaintController::class, 'index'])->name('api.customer.complaints.index');
    Route::post('complaints', [ComplaintController::class, 'store'])->name('api.customer.complaints.store');

    // Chat
    Route::get('chat/threads', [ChatController::class, 'threads'])->name('api.customer.chat.threads');
    Route::get('chat/{technician}/messages', [ChatController::class, 'messages'])->name('api.customer.chat.messages');
    Route::post('chat/messages', [ChatController::class, 'send'])->name('api.customer.chat.send');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('api.customer.notifications.index');
    Route::post('notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('api.customer.notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('api.customer.notifications.read-all');

    // Profile & settings
    Route::get('profile', [ProfileController::class, 'show'])->name('api.customer.profile.show');
    Route::match(['put', 'patch'], 'profile', [ProfileController::class, 'update'])->name('api.customer.profile.update');
    Route::post('password', [ProfileController::class, 'updatePassword'])->name('api.customer.password.update');
    Route::post('notification-settings', [ProfileController::class, 'updateNotificationSettings'])->name('api.customer.notification-settings');

    // AI defect diagnosis
    Route::post('ai/diagnose', [AiDiagnosisController::class, 'diagnose'])->name('api.customer.ai.diagnose');
});
