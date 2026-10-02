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
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\TechnicianManagementController;
use App\Http\Controllers\Admin\TechnicianVerificationController;
use App\Http\Controllers\BecomeTechnicianController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — FixMate AI Web & Cloud Platform
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

Route::get('/privacy-policy', function () {
    return view('Frontend.public.privacy-policy');
})->name('privacy-policy');

Route::get('/terms', function () {
    return view('Frontend.public.terms');
})->name('terms');


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
    Route::get('/dashboard', function () {
        return view('Frontend.customer.dashboard');
    })->name('dashboard');

    // AI Problem Diagnosis Scanner Flow
    Route::get('/diagnose', function () {
        return view('Frontend.customer.diagnose');
    })->name('diagnose');

    Route::get('/ai-result', function () {
        return view('Frontend.customer.ai-result');
    })->name('ai-result');

    // Recommended Technicians & Booking Flow
    Route::get('/technicians', function () {
        return view('Frontend.customer.technicians');
    })->name('technicians');

    Route::get('/technicians/{id}', function ($id = 'ali-khan') {
        return view('Frontend.public.technician-profile', ['techId' => $id]);
    })->name('technician.details');

    Route::get('/booking', function () {
        return view('Frontend.customer.booking');
    })->name('booking');

    Route::get('/payment', function () {
        return view('Frontend.customer.payment');
    })->name('payment');

    Route::get('/booking/{id}/confirm', function ($id = 'FM-10245') {
        return view('Frontend.customer.confirmation', ['bookingId' => $id]);
    })->name('booking.confirm');

    // Live Tracking & Service State
    Route::get('/tracking', function () {
        return view('Frontend.customer.tracking');
    })->name('tracking');

    Route::get('/booking/{id}/tracking', function ($id = 'FM-10245') {
        return view('Frontend.customer.tracking', ['bookingId' => $id]);
    })->name('booking.tracking');

    // Customer Account Pages
    Route::get('/bookings', function () {
        return view('Frontend.customer.bookings');
    })->name('bookings');

    Route::get('/messages', function () {
        return view('Frontend.customer.messages');
    })->name('messages');

    Route::get('/reviews', function () {
        return view('Frontend.customer.reviews');
    })->name('reviews');

    Route::get('/complaints', function () {
        return view('Frontend.customer.complaints');
    })->name('complaints');

    Route::get('/profile', function () {
        return view('Frontend.customer.profile');
    })->name('profile');

    Route::get('/settings', function () {
        return view('Frontend.customer.settings');
    })->name('settings');

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
    Route::get('/dashboard', function () {
        return view('Frontend.technician.dashboard');
    })->name('dashboard');

    // Jobs & Dispatches
    Route::get('/jobs', function () {
        return view('Frontend.technician.jobs');
    })->name('jobs');

    Route::get('/jobs/{id}', function ($id = 'FM-10245') {
        return view('Frontend.technician.job-details', ['jobId' => $id]);
    })->name('jobs.details');

    // Active Service Execution & Handshake OTP
    Route::get('/active-job', function () {
        return view('Frontend.technician.active-job');
    })->name('active-job');

    // KYC Verification Pipeline
    Route::get('/verification', function () {
        return view('Frontend.technician.verification');
    })->name('verification');

    // Earnings & Payout Ledger
    Route::get('/earnings', function () {
        return view('Frontend.technician.earnings');
    })->name('earnings');

    Route::get('/payouts', function () {
        return view('Frontend.technician.earnings');
    })->name('payouts');

    // Schedule & Availability
    Route::get('/schedule', function () {
        return view('Frontend.technician.schedule');
    })->name('schedule');

    Route::get('/availability', function () {
        return view('Frontend.technician.profile');
    })->name('availability');

    Route::get('/skills', function () {
        return view('Frontend.technician.profile');
    })->name('skills');

    // Profile & Settings
    Route::get('/profile', function () {
        return view('Frontend.technician.profile');
    })->name('profile');

    Route::get('/settings', function () {
        return view('Frontend.technician.profile');
    })->name('settings');

    // Customer Reviews
    Route::get('/reviews', function () {
        return view('Frontend.technician.reviews');
    })->name('reviews');

    Route::get('/messages', function () {
        return view('Frontend.technician.messages');
    })->name('messages');

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

    // Catalog & Category / Services Management (Full CRUD)
    Route::get('/categories', [ServiceController::class, 'index'])->name('categories');
    Route::post('/categories', [ServiceController::class, 'store'])->name('categories.store');
    Route::put('/categories/{service}', [ServiceController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{service}', [ServiceController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{service}/toggle', [ServiceController::class, 'toggle'])->name('categories.toggle');

    Route::get('/services', [ServiceController::class, 'index'])->name('services');

    // AI Diagnostics & Growth Analytics
    Route::get('/analytics', [AnalyticsController::class, 'analytics'])->name('analytics');
    Route::get('/ai-diagnostics', [AnalyticsController::class, 'aiDiagnostics'])->name('ai-diagnostics');

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

});

// Global alias for admin shortcut
Route::get('/admin-dashboard', function () {
    return redirect('/admin/dashboard');
});
