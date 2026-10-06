@extends('Frontend.layouts.auth')

@section('title', 'Choose Account Type — FixMate')

@section('content')
<div class="auth-form-card" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; box-shadow: var(--card-shadow); width: 100%; max-width: 960px; display: grid; grid-template-columns: 1.15fr 0.85fr; overflow: hidden; margin: 20px 0;">

    <!-- Left Column: Account Type Choice -->
    <div style="padding: 48px; display: flex; flex-direction: column; justify-content: center;">

        <!-- Brand Header -->
        <div style="margin-bottom: 28px;">
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 20px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 42px; width: auto; object-fit: contain; display: block;">
            </a>

            <h1 style="font-size: 28px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em; margin-bottom: 6px;">Join FixMate</h1>
            <p style="font-size: 14px; color: #64748B; margin: 0;">Tell us how you will use the platform so we can set up the right account for you.</p>
        </div>

        <!-- Role Choice Cards -->
        <div style="display: grid; gap: 14px; margin-bottom: 24px;">

            <!-- Customer Card -->
            <a href="{{ route('register.customer') }}" class="role-card">
                <div style="display: flex; align-items: flex-start; gap: 16px;">
                    <div class="role-icon" style="background: #EFF6FF; border: 1px solid #DBEAFE;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <path d="M9 22V12h6v10"></path>
                        </svg>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <span class="role-tag" style="background: #ECFDF5; color: #047857;">I need home repairs</span>
                        <h3>Customer</h3>
                        <p>Browse standardized service categories, get upfront cost estimates, book certified technicians, and track them live with arrival OTPs.</p>
                        <span class="role-cta">
                            <span>Register as Customer</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Technician Card -->
            <a href="{{ route('register.technician') }}" class="role-card">
                <div style="display: flex; align-items: flex-start; gap: 16px;">
                    <div class="role-icon" style="background: #FFFBEB; border: 1px solid #FDE68A;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6z"></path>
                            <path d="M17.5 3.5l3 3"></path>
                        </svg>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <span class="role-tag" style="background: #FFFBEB; color: #B45309;">I provide trade services</span>
                        <h3>Technician Partner</h3>
                        <p>Receive instant nearby job dispatches, review customer issue details before accepting, and get guaranteed payouts.</p>
                        <span class="role-cta">
                            <span>Register as Technician</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>

        </div>

        <!-- Login Link -->
        <div style="text-align: center; font-size: 13.5px; color: #64748B;">
            Already have an account?
            <a href="{{ route('login') }}" style="color: #0F172A; font-weight: 700; text-decoration: none;">Login</a>
        </div>

    </div>

    <!-- Right Column: Visual Banner -->
    <div class="auth-side-banner" style="position: relative; background: #0F172A; display: flex; flex-direction: column; justify-content: flex-end; padding: 36px; overflow: hidden;">

        <img src="{{ asset('assets/images/image_7.png') }}" alt="FixMate home services" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">

        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.5) 55%, rgba(15, 23, 42, 0.92) 100%);"></div>

        <div style="position: relative; z-index: 2; color: #FFFFFF;">

            <div style="font-size: 32px; font-weight: 800; line-height: 1.15; color: #FFFFFF; letter-spacing: -0.02em;">
                One Platform
            </div>

            <div style="font-family: 'Caveat', cursive; font-size: 40px; font-weight: 700; color: #FFC107; line-height: 1.1; margin: -2px 0 16px 0;">
                Two Ways to Grow
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Transparent upfront pricing with zero roadside bargaining</span>
                </div>
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Verified technicians with background and CNIC checks</span>
                </div>
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Live tracking and guaranteed payouts for partners</span>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
