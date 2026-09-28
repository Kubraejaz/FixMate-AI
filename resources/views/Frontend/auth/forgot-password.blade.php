@extends('Frontend.layouts.auth')

@section('title', 'Forgot Password — FixMate AI')

@section('content')
<div class="auth-form-card" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; box-shadow: var(--card-shadow); width: 100%; max-width: 960px; min-height: 560px; display: grid; grid-template-columns: 1.15fr 0.85fr; overflow: hidden; margin: 20px 0;">
    
    <!-- Left Column: Forgot Password Form -->
    <div style="padding: 48px 48px; display: flex; flex-direction: column; justify-content: center;">
        
        <!-- Brand Header matching Login page -->
        <div style="margin-bottom: 24px;">
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 20px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 42px; width: auto; object-fit: contain; display: block;">
            </a>

            <h1 style="font-size: 28px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em; margin-bottom: 6px;">Forgot Password?</h1>
            <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.5;">Enter your registered email or phone number. We'll send you a secure verification code to reset your password.</p>
        </div>

        <!-- Form -->
        <form action="{{ url('/verify-otp') }}" method="GET">
            <input type="hidden" name="flow" value="reset">

            <div style="margin-bottom: 20px;">
                <label class="app-label" for="resetIdentifier">Email Address or Phone Number</label>
                <input type="text" id="resetIdentifier" class="app-input" required placeholder="e.g. customer@fixmate.ai or 0300-1234567" value="customer@fixmate.ai">
            </div>

            <button type="submit" class="app-btn-primary" style="margin-bottom: 20px;">
                <span>Send Verification Code →</span>
            </button>
        </form>

        <!-- Back to Login -->
        <div style="text-align: center; font-size: 13.5px; color: #64748B;">
            Remembered your credentials? 
            <a href="{{ url('/login') }}" style="color: #0F172A; font-weight: 700; text-decoration: none;">Back to Login</a>
        </div>

    </div>

    <!-- Right Column: Visual Banner matching Login mockup -->
    <div class="auth-side-banner" style="position: relative; background: #0F172A; display: flex; flex-direction: column; justify-content: flex-end; padding: 36px; overflow: hidden;">
        
        <!-- Real Living Room Asset from Mockup -->
        <img src="{{ asset('assets/images/image_7.png') }}" alt="Your Home Our Priority" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        
        <!-- Elegant Gradient Overlay -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.5) 55%, rgba(15, 23, 42, 0.92) 100%);"></div>

        <!-- Bottom Tagline Box matching mockup -->
        <div style="position: relative; z-index: 2; color: #FFFFFF;">
            
            <div style="font-size: 32px; font-weight: 800; line-height: 1.15; color: #FFFFFF; letter-spacing: -0.02em;">
                Your Home
            </div>
            
            <div style="font-family: 'Caveat', cursive; font-size: 40px; font-weight: 700; color: #FFC107; line-height: 1.1; margin: -2px 0 10px 0;">
                Our Priority
            </div>

            <div style="font-size: 13.5px; font-weight: 500; color: #E2E8F0; letter-spacing: 0.02em; margin-bottom: 18px;">
                Trusted • Fast • Professional
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12px; color: #E2E8F0; border-top: 1px solid rgba(255, 255, 255, 0.15); padding-top: 14px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: #FFC107; font-weight: 800;">🔒</span>
                    <span>256-Bit Encrypted Password Reset</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: #FFC107; font-weight: 800;">⚡</span>
                    <span>Instant SMS / Email OTP Delivery</span>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
