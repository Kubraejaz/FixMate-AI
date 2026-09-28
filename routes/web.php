<?php

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
Route::get('/', function () {
    return view('Frontend.public.home');
})->name('home');

Route::get('/about', function () {
    return view('Frontend.public.about');
})->name('about');

Route::get('/services', function () {
    return view('Frontend.public.services');
})->name('services');

Route::get('/services/{slug}', function ($slug = 'plumbing') {
    return view('Frontend.public.service-details', ['slug' => $slug]);
})->name('service-details');

Route::get('/how-it-works', function () {
    return view('Frontend.public.how-it-works');
})->name('how-it-works');

Route::get('/technicians', function () {
    return view('Frontend.public.technicians');
})->name('technicians');

Route::get('/find-technician', function () {
    return view('Frontend.public.technicians');
});

Route::get('/technicians/{id}', function ($id = 'ali-khan') {
    return view('Frontend.public.technician-profile', ['techId' => $id]);
})->name('technician-profile');

Route::get('/technician-profile/{id?}', function ($id = 'ali-khan') {
    return view('Frontend.public.technician-profile', ['techId' => $id]);
});

Route::get('/community', function () {
    return view('Frontend.public.community');
})->name('community');

Route::get('/faqs', function () {
    return view('Frontend.public.faqs');
})->name('faqs');

Route::get('/contact', function () {
    return view('Frontend.public.contact');
})->name('contact');

Route::get('/become-technician', function () {
    return view('Frontend.public.become-technician');
})->name('become-technician');

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

Route::get('/register', function () {
    return view('Frontend.auth.role-selection');
})->name('register');

Route::get('/register/role', function () {
    return view('Frontend.auth.role-selection');
})->name('register.role');

Route::get('/register/customer', function () {
    return view('Frontend.auth.register-customer');
})->name('register.customer');

Route::get('/register/technician', function () {
    return view('Frontend.auth.register-technician');
})->name('register.technician');

Route::get('/technician-register', function () {
    return view('Frontend.auth.register-technician');
});

Route::get('/verify-otp', function () {
    return view('Frontend.auth.verify-otp');
})->name('verify-otp');

Route::get('/forgot-password', function () {
    return view('Frontend.auth.forgot-password');
})->name('forgot-password');

Route::get('/reset-password', function () {
    return view('Frontend.auth.reset-password');
})->name('reset-password');


// ==========================================
// 3. CUSTOMER PORTAL — LOGIN REQUIRED
// ==========================================
Route::prefix('customer')->name('customer.')->group(function () {
    
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
Route::prefix('technician')->name('technician.')->group(function () {
    
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
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/', function () {
        return view('Frontend.admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('Frontend.admin.dashboard');
    })->name('dashboard');

    // Catalog & Category Management
    Route::get('/categories', function () {
        return view('Frontend.admin.categories');
    })->name('categories');

    Route::get('/services', function () {
        return view('Frontend.admin.categories');
    })->name('services');

    // AI Diagnostics Analytics
    Route::get('/analytics', function () {
        return view('Frontend.admin.analytics');
    })->name('analytics');

    Route::get('/ai-diagnostics', function () {
        return view('Frontend.admin.ai-diagnostics');
    })->name('ai-diagnostics');

    // KYC Verification Pipeline
    Route::get('/technicians/verification', function () {
        return view('Frontend.admin.verification');
    })->name('technicians.verification');

    // Bookings & Transactions
    Route::get('/bookings', function () {
        return view('Frontend.admin.bookings');
    })->name('bookings');

    // Users Directory
    Route::get('/customers', function () {
        return view('Frontend.admin.customers');
    })->name('customers');

    Route::get('/users', function () {
        return view('Frontend.admin.customers');
    })->name('users');

    Route::get('/technicians', function () {
        return view('Frontend.admin.technicians');
    })->name('technicians');

    // Settings & Others
    Route::get('/settings', function () {
        return view('Frontend.admin.dashboard');
    })->name('settings');

    Route::get('/payments', function () {
        return view('Frontend.admin.dashboard');
    })->name('payments');

    Route::get('/complaints', function () {
        return view('Frontend.admin.dashboard');
    })->name('complaints');

});

// Global alias for admin shortcut
Route::get('/admin-dashboard', function () {
    return redirect('/admin/dashboard');
});
