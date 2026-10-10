<?php

use App\Http\Controllers\Api\V1\Admin\AnalyticsController;
use App\Http\Controllers\Api\V1\Admin\BookingController;
use App\Http\Controllers\Api\V1\Admin\CommunityIssueController;
use App\Http\Controllers\Api\V1\Admin\CustomerController;
use App\Http\Controllers\Api\V1\Admin\DashboardController;
use App\Http\Controllers\Api\V1\Admin\FaqController;
use App\Http\Controllers\Api\V1\Admin\HomepageController;
use App\Http\Controllers\Api\V1\Admin\InquiryController;
use App\Http\Controllers\Api\V1\Admin\ServiceController;
use App\Http\Controllers\Api\V1\Admin\SettingsController;
use App\Http\Controllers\Api\V1\Admin\TechnicianController;
use App\Http\Controllers\Api\V1\Admin\TechnicianVerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin portal (auth:sanctum + admin role)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth:sanctum', 'api.role:admin'])->group(function () {

    // Dashboard & notifications
    Route::get('dashboard', [DashboardController::class, 'index'])->name('api.admin.dashboard');
    Route::get('notifications', [DashboardController::class, 'notifications'])->name('api.admin.notifications.index');
    Route::post('notifications/{notification}/read', [DashboardController::class, 'markNotificationRead'])->name('api.admin.notifications.read');
    Route::post('notifications/read-all', [DashboardController::class, 'markAllNotificationsRead'])->name('api.admin.notifications.read-all');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('api.admin.analytics');

    // Bookings
    Route::get('bookings', [BookingController::class, 'index'])->name('api.admin.bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('api.admin.bookings.show');

    // KYC verification pipeline
    Route::get('technicians/verification', [TechnicianVerificationController::class, 'index'])->name('api.admin.technicians.verification.index');
    Route::patch('technicians/verification/{application}/approve', [TechnicianVerificationController::class, 'approve'])->name('api.admin.technicians.verification.approve');
    Route::patch('technicians/verification/{application}/return', [TechnicianVerificationController::class, 'returnApplication'])->name('api.admin.technicians.verification.return');
    Route::patch('technicians/verification/{application}/reject', [TechnicianVerificationController::class, 'reject'])->name('api.admin.technicians.verification.reject');
    Route::patch('technicians/verification/{application}/review', [TechnicianVerificationController::class, 'review'])->name('api.admin.technicians.verification.review');

    // Technicians pool
    Route::get('technicians', [TechnicianController::class, 'index'])->name('api.admin.technicians.index');
    Route::patch('technicians/{professional}/verify', [TechnicianController::class, 'toggleVerify'])->name('api.admin.technicians.verify');
    Route::delete('technicians/{professional}', [TechnicianController::class, 'destroy'])->name('api.admin.technicians.destroy');

    // Customers
    Route::get('customers', [CustomerController::class, 'index'])->name('api.admin.customers.index');
    Route::patch('customers/{customer}/toggle', [CustomerController::class, 'toggle'])->name('api.admin.customers.toggle');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('api.admin.customers.destroy');

    // Services / categories
    Route::get('services', [ServiceController::class, 'index'])->name('api.admin.services.index');
    Route::post('services', [ServiceController::class, 'store'])->name('api.admin.services.store');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('api.admin.services.update');
    Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('api.admin.services.destroy');
    Route::patch('services/{service}/toggle', [ServiceController::class, 'toggle'])->name('api.admin.services.toggle');

    // FAQs
    Route::get('faqs', [FaqController::class, 'index'])->name('api.admin.faqs.index');
    Route::post('faqs', [FaqController::class, 'store'])->name('api.admin.faqs.store');
    Route::put('faqs/{faq}', [FaqController::class, 'update'])->name('api.admin.faqs.update');
    Route::delete('faqs/{faq}', [FaqController::class, 'destroy'])->name('api.admin.faqs.destroy');
    Route::patch('faqs/{faq}/toggle', [FaqController::class, 'toggle'])->name('api.admin.faqs.toggle');

    // Community hazards
    Route::get('community', [CommunityIssueController::class, 'index'])->name('api.admin.community.index');
    Route::put('community/{issue}', [CommunityIssueController::class, 'update'])->name('api.admin.community.update');
    Route::patch('community/{issue}/toggle', [CommunityIssueController::class, 'toggle'])->name('api.admin.community.toggle');
    Route::delete('community/{issue}', [CommunityIssueController::class, 'destroy'])->name('api.admin.community.destroy');

    // Contact inquiries / complaints
    Route::get('inquiries', [InquiryController::class, 'index'])->name('api.admin.inquiries.index');
    Route::post('inquiries', [InquiryController::class, 'store'])->name('api.admin.inquiries.store');
    Route::put('inquiries/{inquiry}', [InquiryController::class, 'update'])->name('api.admin.inquiries.update');
    Route::delete('inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('api.admin.inquiries.destroy');

    // Homepage CMS
    Route::get('homepage', [HomepageController::class, 'index'])->name('api.admin.homepage.index');
    Route::post('homepage/hero', [HomepageController::class, 'updateHero'])->name('api.admin.homepage.hero');
    Route::post('homepage/testimonials', [HomepageController::class, 'storeTestimonial'])->name('api.admin.homepage.testimonials.store');
    Route::put('homepage/testimonials/{testimonial}', [HomepageController::class, 'updateTestimonial'])->name('api.admin.homepage.testimonials.update');
    Route::delete('homepage/testimonials/{testimonial}', [HomepageController::class, 'destroyTestimonial'])->name('api.admin.homepage.testimonials.destroy');
    Route::post('homepage/steps', [HomepageController::class, 'storeStep'])->name('api.admin.homepage.steps.store');
    Route::put('homepage/steps/{step}', [HomepageController::class, 'updateStep'])->name('api.admin.homepage.steps.update');
    Route::delete('homepage/steps/{step}', [HomepageController::class, 'destroyStep'])->name('api.admin.homepage.steps.destroy');

    // Settings & finance
    Route::get('settings', [SettingsController::class, 'settings'])->name('api.admin.settings');
    Route::post('settings', [SettingsController::class, 'updateSettings'])->name('api.admin.settings.update');
    Route::post('settings/test-gemini', [SettingsController::class, 'testGemini'])->name('api.admin.settings.test-gemini');
    Route::get('payments', [SettingsController::class, 'payments'])->name('api.admin.payments');
});
