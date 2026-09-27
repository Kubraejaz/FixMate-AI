@extends('Frontend.layouts.auth')

@section('title', 'Verify OTP Code — FixMate AI')

@section('content')
<div class="auth-form-card" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; box-shadow: var(--card-shadow); width: 100%; max-width: 960px; min-height: 560px; display: grid; grid-template-columns: 1.15fr 0.85fr; overflow: hidden; margin: 20px 0;">
    
    <!-- Left Column: OTP Verification Form -->
    <div style="padding: 48px 48px; display: flex; flex-direction: column; justify-content: center;">
        
        <!-- Brand Header matching Login page -->
        <div style="margin-bottom: 24px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #FFC107; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <path d="M9 22V12h6v10"></path>
                    </svg>
                </div>
                <span style="font-size: 20px; font-weight: 800; color: #0F172A; letter-spacing: -0.01em;">FixMate <span style="color: #FFB300;">AI</span></span>
            </div>

            <h1 style="font-size: 28px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em; margin-bottom: 6px;">Verify Security Code</h1>
            <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.5;">
                We sent a 6-digit verification code to <br>
                <strong style="color: #0F172A;">+92 300 1234567</strong> or your email.
            </p>
        </div>

        @php
            $targetUrl = request('flow') === 'reset' ? url('/reset-password') : (request('role') === 'technician' ? url('/technician/verification') : url('/customer/dashboard'));
        @endphp

        <!-- Form with 6 digit boxes -->
        <form action="{{ $targetUrl }}" method="GET">
            
            <div style="margin-bottom: 24px;">
                <label class="app-label" style="margin-bottom: 10px; font-size: 12.5px;">Enter 6-Digit Code</label>
                <div style="display: flex; gap: 8px; justify-content: flex-start;" id="otpBoxContainer">
                    <input type="text" maxlength="1" value="5" class="app-input otp-digit" style="width: 48px; height: 52px; text-align: center; font-size: 20px; font-weight: 800; padding: 0;">
                    <input type="text" maxlength="1" value="8" class="app-input otp-digit" style="width: 48px; height: 52px; text-align: center; font-size: 20px; font-weight: 800; padding: 0;">
                    <input type="text" maxlength="1" value="2" class="app-input otp-digit" style="width: 48px; height: 52px; text-align: center; font-size: 20px; font-weight: 800; padding: 0;">
                    <input type="text" maxlength="1" value="9" class="app-input otp-digit" style="width: 48px; height: 52px; text-align: center; font-size: 20px; font-weight: 800; padding: 0;">
                    <input type="text" maxlength="1" value="4" class="app-input otp-digit" style="width: 48px; height: 52px; text-align: center; font-size: 20px; font-weight: 800; padding: 0;">
                    <input type="text" maxlength="1" value="1" class="app-input otp-digit" style="width: 48px; height: 52px; text-align: center; font-size: 20px; font-weight: 800; padding: 0;">
                </div>
            </div>

            <button type="submit" class="app-btn-primary" style="margin-bottom: 20px;">
                <span>Verify & Continue →</span>
            </button>
        </form>

        <!-- Resend and change phone -->
        <div style="font-size: 13px; color: #64748B;">
            Didn't receive the SMS code? 
            <span style="color: #94A3B8; font-size: 12px; margin-left: 4px;">Resend in <strong style="color: #0F172A;" id="countdownText">45s</strong></span>
            <div style="margin-top: 8px;">
                <a href="{{ url('/register') }}" style="color: #B45309; font-weight: 700; text-decoration: none; font-size: 12.5px;">← Edit Phone Number</a>
            </div>
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
                    <span style="color: #FFC107; font-weight: 800;">🛡️</span>
                    <span>2-Step Verification for Secure Access</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: #FFC107; font-weight: 800;">✓</span>
                    <span>Verified Homeowners & Technicians</span>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    // Auto-focus next input on digit entry
    const digits = document.querySelectorAll('.otp-digit');
    digits.forEach((input, index) => {
        input.addEventListener('keyup', (e) => {
            if (e.key >= '0' && e.key <= '9') {
                if (index < digits.length - 1) {
                    digits[index + 1].focus();
                }
            } else if (e.key === 'Backspace') {
                if (index > 0 && !input.value) {
                    digits[index - 1].focus();
                }
            }
        });
    });

    // Countdown simulation
    let timeLeft = 45;
    const countdownEl = document.getElementById('countdownText');
    const timer = setInterval(() => {
        timeLeft--;
        if (timeLeft <= 0) {
            clearInterval(timer);
            if (countdownEl) countdownEl.innerHTML = '<a href="#" style="color:#FFB300; font-weight:700; text-decoration:underline;">Resend Code</a>';
        } else {
            if (countdownEl) countdownEl.textContent = timeLeft + 's';
        }
    }, 1000);
</script>
@endsection
