<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredCustomerController;
use App\Http\Controllers\Auth\RegisteredTechnicianController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\Admin\CommunityIssueController as AdminCommunityController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\HomepageController as AdminHomepageController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\TechnicianManagementController;
use App\Http\Controllers\Admin\TechnicianVerificationController;
use App\Http\Controllers\BecomeTechnicianController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Customer\CustomerPortalController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\Technician\TechnicianPortalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — FixMate Web Platform
| Architecture:
| 1. Public Website (No Login Required)
| 2. Authentication Pages (Login, Register, Role Choice, Phone OTP, Reset)
| 3. Customer Portal (Login Required - Protected Layout)
| 4. Technician Portal (Technician Login Required - Protected Layout)
| 5. Admin Portal (Super Admin Only - Protected Layout)
| 6. Community Module (Partially Public)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC WEBSITE — NO LOGIN REQUIRED
// ==========================================
Route::get('/', [PublicPageController::class, 'home'])->name('home');

Route::get('/about', [PublicPageController::class, 'about'])->name('about');

Route::get('/services', [PublicPageController::class, 'services'])->name('services');

Route::get('/services/{slug}', [PublicPageController::class, 'serviceDetails'])->name('service-details');

Route::get('/how-it-works', [PublicPageController::class, 'howItWorks'])->name('how-it-works');

Route::get('/technicians', [PublicPageController::class, 'technicians'])->name('technicians');

Route::get('/find-technician', [PublicPageController::class, 'technicians']);

Route::get('/technicians/{id}', [PublicPageController::class, 'technicianProfile'])->name('technician-profile');

Route::get('/technician-profile/{id?}', [PublicPageController::class, 'technicianProfile']);

Route::get('/community', [CommunityController::class, 'index'])->name('community');
Route::post('/community/report', [CommunityController::class, 'store'])->name('community.report');
Route::post('/community/{issue}/upvote', [CommunityController::class, 'upvote'])->name('community.upvote');

Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/become-technician', [BecomeTechnicianController::class, 'index'])->name('become-technician');
Route::post('/become-technician', [BecomeTechnicianController::class, 'store'])->name('become-technician.store');

Route::get('/privacy-policy', [PublicPageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms', [PublicPageController::class, 'terms'])->name('terms');


// ==========================================
// 2. AUTHENTICATION PAGES
// ==========================================
Route::get('/login', function () {
    return view('Frontend.auth.login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('login.store');

Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

Route::get('/register', function () {
    return view('Frontend.auth.role-selection');
})->name('register');

Route::get('/register/role', function () {
    return view('Frontend.auth.role-selection');
})->name('register.role');

Route::get('/register/customer', function () {
    return view('Frontend.auth.register-customer');
})->name('register.customer');

Route::post('/register/customer', [RegisteredCustomerController::class, 'store'])
    ->name('register.customer.store');

Route::get('/register/technician', function () {
    return view('Frontend.auth.register-technician');
})->name('register.technician');

Route::post('/register/technician', [RegisteredTechnicianController::class, 'store'])
    ->name('register.technician.store');

Route::get('/technician-register', function () {
    return view('Frontend.auth.register-technician');
});

Route::get('/verify-otp', [OtpVerificationController::class, 'show'])->name('verify-otp');

Route::post('/verify-otp', [OtpVerificationController::class, 'store'])
    ->middleware('throttle:10,1');

Route::post('/verify-otp/resend', [OtpVerificationController::class, 'resend'])
    ->middleware('throttle:3,1')
    ->name('verify-otp.resend');

Route::get('/forgot-password', function () {
    return view('Frontend.auth.forgot-password');
})->name('forgot-password');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('forgot-password.store');

Route::get('/reset-password', [NewPasswordController::class, 'create'])->name('reset-password');

Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('reset-password.store');


// ==========================================
// 3. CUSTOMER PORTAL — LOGIN REQUIRED
// ==========================================
Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
    
    // Customer Dashboard
    Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');

    // Customer Services Catalog & Categories
    Route::get('/services', [CustomerPortalController::class, 'services'])->name('services');

    // Service Request / Problem Diagnosis Flow
    Route::get('/diagnose', [CustomerPortalController::class, 'diagnose'])->name('diagnose');
    Route::get('/request-service', [CustomerPortalController::class, 'diagnose'])->name('request-service');
    Route::match(['get', 'post'], '/ai-result', [CustomerPortalController::class, 'aiResult'])->name('ai-result');
    Route::match(['get', 'post'], '/service-summary', [CustomerPortalController::class, 'aiResult'])->name('service-summary');

    // Recommended Technicians & Booking Flow
    Route::get('/technicians', [CustomerPortalController::class, 'technicians'])->name('technicians');
    Route::get('/technicians/{id}', function ($id = 'ali-khan') {
        return view('Frontend.public.technician-profile', ['techId' => $id]);
    })->name('technician.details');

    Route::get('/booking', [CustomerPortalController::class, 'bookingForm'])->name('booking');
    Route::post('/booking', [CustomerPortalController::class, 'storeBooking'])->name('booking.store');

    Route::get('/payment/{booking?}', [CustomerPortalController::class, 'payment'])->name('payment');
    Route::post('/payment/{booking}', [CustomerPortalController::class, 'processPayment'])->name('payment.process');

    Route::get('/booking/{booking}/confirm', [CustomerPortalController::class, 'bookingConfirm'])->name('booking.confirm');

    // Live Tracking & Service State
    Route::get('/tracking', [CustomerPortalController::class, 'tracking'])->name('tracking');
    Route::get('/booking/{booking}/tracking', [CustomerPortalController::class, 'tracking'])->name('booking.tracking');
    Route::get('/booking/{booking}/tracking-data', [CustomerPortalController::class, 'trackingData'])->name('booking.tracking-data');

    // Customer Bookings Management
    Route::get('/bookings', [CustomerPortalController::class, 'bookings'])->name('bookings');
    Route::post('/booking/{booking}/cancel', [CustomerPortalController::class, 'cancelBooking'])->name('booking.cancel');

    // Messages & Communication
    Route::get('/messages', [CustomerPortalController::class, 'messages'])->name('messages');
    Route::get('/messages/stream', [CustomerPortalController::class, 'messagesStream'])->name('messages.stream');
    Route::post('/messages', [CustomerPortalController::class, 'sendMessage'])->name('messages.send');

    // Ratings & Reviews
    Route::get('/reviews', [CustomerPortalController::class, 'reviews'])->name('reviews');
    Route::post('/booking/{booking}/review', [CustomerPortalController::class, 'storeReview'])->name('review.store');

    // Complaints & Dispute Center
    Route::get('/complaints', [CustomerPortalController::class, 'complaints'])->name('complaints');
    Route::post('/complaints', [CustomerPortalController::class, 'storeComplaint'])->name('complaints.store');

    // Profile, Settings & Notifications
    Route::get('/profile', [CustomerPortalController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerPortalController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [CustomerPortalController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [CustomerPortalController::class, 'updatePassword'])->name('password.update');
    Route::post('/settings/notifications', [CustomerPortalController::class, 'updateNotificationSettings'])->name('settings.notifications');
    Route::get('/notifications', [CustomerPortalController::class, 'notifications'])->name('notifications');
    Route::get('/notifications/{notification}/open', [CustomerPortalController::class, 'openNotification'])->name('notifications.open');
    Route::match(['patch', 'post'], '/notifications/{notification}/read', [CustomerPortalController::class, 'markSingleNotificationRead'])->name('notifications.single-read');
    Route::post('/notifications/read', [CustomerPortalController::class, 'markNotificationsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [CustomerPortalController::class, 'markNotificationsRead'])->name('notifications.read-all');

});

// Global alias redirects for customer shortcuts
Route::get('/dashboard', function () {
    return redirect('/customer/dashboard');
});
Route::get('/customer-dashboard', function () {
    return redirect('/customer/dashboard');
});
Route::get('/describe-problem', function () {
    return redirect('/customer/diagnose');
});
Route::get('/request-service', function () {
    return redirect('/customer/diagnose');
});
Route::get('/ai-scanner', function () {
    return redirect('/customer/diagnose');
});
Route::get('/ai-analysis-result', function () {
    return redirect('/customer/ai-result');
});
Route::get('/recommended-technicians', function () {
    return redirect('/customer/technicians');
});
Route::get('/booking-page', function () {
    return redirect('/customer/booking');
});
Route::get('/booking-confirmation', function () {
    return redirect('/customer/booking/FM-10245/confirm');
});
Route::get('/tracking', function () {
    return redirect('/customer/tracking');
});
Route::get('/chat', function () {
    return redirect('/customer/messages');
});


// ==========================================
// 4. TECHNICIAN PORTAL — TECHNICIAN ONLY
// ==========================================
Route::prefix('technician')->name('technician.')->middleware(['auth', 'role:technician'])->group(function () {
    
    // Technician Dashboard
    Route::get('/dashboard', [TechnicianPortalController::class, 'dashboard'])->name('dashboard');

    // Jobs & Dispatches
    Route::get('/jobs', [TechnicianPortalController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/{id}', [TechnicianPortalController::class, 'jobDetails'])->name('jobs.details');
    Route::post('/jobs/{booking}/accept', [TechnicianPortalController::class, 'acceptJob'])->name('jobs.accept');
    Route::post('/jobs/{booking}/start-route', [TechnicianPortalController::class, 'startRoute'])->name('jobs.start-route');

    // Active Service Execution & Handshake OTP
    Route::get('/active-job', [TechnicianPortalController::class, 'activeJob'])->name('active-job');
    Route::post('/active-job/{booking}/location', [TechnicianPortalController::class, 'updateLocation'])->name('active-job.location');
    Route::post('/active-job/{booking}/simulate-step', [TechnicianPortalController::class, 'simulateStep'])->name('active-job.simulate-step');
    Route::post('/active-job/{booking}/verify-otp', [TechnicianPortalController::class, 'verifyOtp'])->name('active-job.verify-otp');
    Route::post('/active-job/{booking}/complete', [TechnicianPortalController::class, 'completeJob'])->name('active-job.complete');

    // KYC Verification Pipeline
    Route::get('/verification', [TechnicianPortalController::class, 'verification'])->name('verification');
    Route::post('/verification', [TechnicianPortalController::class, 'submitVerification'])->name('verification.submit');

    // Earnings & Payout Ledger
    Route::get('/earnings', [TechnicianPortalController::class, 'earnings'])->name('earnings');
    Route::get('/payouts', [TechnicianPortalController::class, 'earnings'])->name('payouts');

    // Schedule & Availability
    Route::get('/schedule', [TechnicianPortalController::class, 'schedule'])->name('schedule');
    Route::get('/availability', [TechnicianPortalController::class, 'schedule'])->name('availability');

    // Skills & Services
    Route::get('/skills', [TechnicianPortalController::class, 'skills'])->name('skills');
    Route::post('/skills', [TechnicianPortalController::class, 'updateSkills'])->name('skills.update');

    // Profile & Settings
    Route::get('/profile', [TechnicianPortalController::class, 'profile'])->name('profile');
    Route::post('/profile', [TechnicianPortalController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [TechnicianPortalController::class, 'profile'])->name('settings');

    // Customer Reviews
    Route::get('/reviews', [TechnicianPortalController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/{review}/reply', [TechnicianPortalController::class, 'replyReview'])->name('reviews.reply');


    // Direct Messages with Customers
    Route::get('/messages', [TechnicianPortalController::class, 'messages'])->name('messages');
    Route::get('/messages/stream', [TechnicianPortalController::class, 'messagesStream'])->name('messages.stream');
    Route::post('/messages/send', [TechnicianPortalController::class, 'sendMessage'])->name('messages.send');
    Route::post('/messages', [TechnicianPortalController::class, 'sendMessage']);

    // Dedicated Speedy Notifications Page
    Route::get('/notifications', [TechnicianPortalController::class, 'notifications'])->name('notifications');
    Route::get('/notifications/{notification}/open', [TechnicianPortalController::class, 'openNotification'])->name('notifications.open');
    Route::match(['patch', 'post'], '/notifications/{notification}/read', [TechnicianPortalController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [TechnicianPortalController::class, 'markAllNotificationsRead'])->name('notifications.read-all');

});

// Global alias for technician shortcuts
Route::get('/technician-dashboard', function () {
    return redirect('/technician/dashboard');
});
Route::get('/provider', function () {
    return redirect('/technician/dashboard');
});
Route::get('/provider-dashboard', function () {
    return redirect('/technician/dashboard');
});


// ==========================================
// 5. ADMIN PORTAL — ADMIN ONLY
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    
    // Admin Dashboard
    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // System Alerts & Dedicated Speedy Notifications
    Route::get('/notifications', [AdminDashboardController::class, 'notifications'])->name('notifications');
    Route::get('/notifications/{notification}/open', [AdminDashboardController::class, 'openNotification'])->name('notifications.open');
    Route::match(['patch', 'post'], '/notifications/{notification}/read', [AdminDashboardController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [AdminDashboardController::class, 'markAllNotificationsRead'])->name('notifications.read-all');

    // Catalog & Category / Services Management (Full CRUD)
    Route::get('/categories', [ServiceController::class, 'index'])->name('categories');
    Route::post('/categories', [ServiceController::class, 'store'])->name('categories.store');
    Route::put('/categories/{service}', [ServiceController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{service}', [ServiceController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{service}/toggle', [ServiceController::class, 'toggle'])->name('categories.toggle');

    Route::get('/services', [ServiceController::class, 'index'])->name('services');

    // Growth Analytics
    Route::get('/analytics', [AnalyticsController::class, 'analytics'])->name('analytics');
    Route::get('/ai-diagnostics', function () {
        return redirect()->route('admin.analytics');
    })->name('ai-diagnostics');

    // KYC Verification Pipeline
    Route::get('/technicians/verification', [TechnicianVerificationController::class, 'index'])->name('technicians.verification');
    Route::patch('/technicians/verification/{application}/approve', [TechnicianVerificationController::class, 'approve'])->name('technicians.verification.approve');
    Route::patch('/technicians/verification/{application}/reject', [TechnicianVerificationController::class, 'reject'])->name('technicians.verification.reject');
    Route::patch('/technicians/verification/{application}/review', [TechnicianVerificationController::class, 'review'])->name('technicians.verification.review');

    // Bookings & Dispatches Board
    Route::get('/bookings', [BookingManagementController::class, 'index'])->name('bookings');

    // People: Customer Accounts Management
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers');
    Route::get('/users', [AdminCustomerController::class, 'index'])->name('users');
    Route::patch('/customers/{customer}/toggle', [AdminCustomerController::class, 'toggle'])->name('customers.toggle');
    Route::delete('/customers/{customer}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');

    // People: Technicians Pool Management
    Route::get('/technicians', [TechnicianManagementController::class, 'index'])->name('technicians');
    Route::patch('/technicians/{professional}/verify', [TechnicianManagementController::class, 'toggleVerify'])->name('technicians.verify');
    Route::delete('/technicians/{professional}', [TechnicianManagementController::class, 'destroy'])->name('technicians.destroy');

    // Financial Escrow & Platform Settings
    Route::get('/payments', [AdminSettingsController::class, 'payments'])->name('payments');
    Route::get('/settings', [AdminSettingsController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'updateSettings'])->name('settings.update');
    Route::post('/settings/test-gemini', [AdminSettingsController::class, 'testGemini'])->name('settings.test-gemini');

    // Contact Inquiries & Dispute Arbitration (Full CRUD)
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries');
    Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
    Route::put('/inquiries/{inquiry}', [InquiryController::class, 'update'])->name('inquiries.update');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    Route::get('/complaints', [InquiryController::class, 'index'])->name('complaints');

    // FAQ & Help Center Knowledgebase (Full CRUD)
    Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faqs');
    Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/{faq}', [AdminFaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [AdminFaqController::class, 'destroy'])->name('faqs.destroy');
    Route::patch('/faqs/{faq}/toggle', [AdminFaqController::class, 'toggle'])->name('faqs.toggle');

    // Community & Civic Hazards Dispatch Management
    Route::get('/community', [AdminCommunityController::class, 'index'])->name('community');
    Route::put('/community/{issue}', [AdminCommunityController::class, 'update'])->name('community.update');
    Route::patch('/community/{issue}/toggle', [AdminCommunityController::class, 'toggle'])->name('community.toggle');
    Route::delete('/community/{issue}', [AdminCommunityController::class, 'destroy'])->name('community.destroy');

    // Homepage CMS & Content Editor (Full CRUD for Hero, Testimonials, Steps)
    Route::get('/homepage', [AdminHomepageController::class, 'index'])->name('homepage');
    Route::post('/homepage/hero', [AdminHomepageController::class, 'updateHero'])->name('homepage.hero');
    Route::post('/homepage/testimonials', [AdminHomepageController::class, 'storeTestimonial'])->name('homepage.testimonials.store');
    Route::put('/homepage/testimonials/{testimonial}', [AdminHomepageController::class, 'updateTestimonial'])->name('homepage.testimonials.update');
    Route::delete('/homepage/testimonials/{testimonial}', [AdminHomepageController::class, 'destroyTestimonial'])->name('homepage.testimonials.destroy');
    Route::post('/homepage/steps', [AdminHomepageController::class, 'storeStep'])->name('homepage.steps.store');
    Route::put('/homepage/steps/{step}', [AdminHomepageController::class, 'updateStep'])->name('homepage.steps.update');
    Route::delete('/homepage/steps/{step}', [AdminHomepageController::class, 'destroyStep'])->name('homepage.steps.destroy');

});

// Global alias for admin shortcut
Route::get('/admin-dashboard', function () {
    return redirect('/admin/dashboard');
});
