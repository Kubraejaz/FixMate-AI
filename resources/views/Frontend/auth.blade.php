@extends('Frontend.layouts.master')

@section('title', 'Sign In & Dynamic Role Selection — FixMate AI')
@section('meta_desc', 'Sign in to FixMate AI as Customer or Service Provider. Supports Google OAuth, Phone OTP, and email credentials.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 80px; display: flex; justify-content: center;">

    <div class="fm-card" style="width: 100%; max-width: 480px; padding: 36px; box-shadow: 0 16px 40px rgba(0,0,0,0.06); border: 2px solid #FFECB3;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 24px;">
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 14px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 48px; width: auto; object-fit: contain; margin: 0 auto; display: block;">
            </a>
            <h1 style="font-size: 24px; font-weight: 800; color: #111; margin-bottom: 4px;">Welcome to FixMate AI</h1>
            <p class="text-secondary" style="font-size: 13.5px;">Intelligent Home Repairs & Verified Pro Dispatch</p>
        </div>

        <!-- Dynamic Role Selector (FR-1.2) -->
        <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 18px; padding: 5px; display: grid; grid-template-columns: 1fr 1fr; gap: 4px; margin-bottom: 24px;">
            <button type="button" id="roleBtnCustomer" onclick="selectRole('customer')" style="padding: 10px; font-size: 13px; font-weight: 800; border-radius: 14px; background: #FFCC00; color: #000; box-shadow: 0 2px 8px rgba(255,204,0,0.3); transition: all 0.2s;">
                🏠 Customer (Owner)
            </button>
            <button type="button" id="roleBtnProvider" onclick="selectRole('provider')" style="padding: 10px; font-size: 13px; font-weight: 700; border-radius: 14px; background: transparent; color: #666; transition: all 0.2s;">
                🔧 Service Provider
            </button>
        </div>

        <!-- Auth Method Tabs: Password vs Phone OTP (FR-1.1) -->
        <div style="display: flex; border-bottom: 1px solid #EEEEEE; margin-bottom: 20px;">
            <button type="button" id="tabEmailBtn" onclick="switchAuthTab('email')" style="flex: 1; padding: 10px; font-size: 13px; font-weight: 700; color: #111; border-bottom: 2px solid #FFCC00;">
                Email & Password
            </button>
            <button type="button" id="tabOtpBtn" onclick="switchAuthTab('otp')" style="flex: 1; padding: 10px; font-size: 13px; font-weight: 600; color: #757575;">
                Phone OTP
            </button>
        </div>

        <!-- Google OAuth 2.0 Single Sign-On (FR-1.1) -->
        <button type="button" class="btn-secondary" onclick="simulateOAuth()" style="width: 100%; padding: 12px; font-size: 14px; margin-bottom: 18px; border-color: #E2E8F0;">
            <svg width="18" height="18" viewBox="0 0 24 24" style="margin-right: 6px;">
                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.05h3.87c2.26-2.09 3.67-5.17 3.67-9.15z"/>
                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.87-3.05c-1.08.72-2.45 1.16-4.06 1.16-3.13 0-5.78-2.11-6.73-4.96H1.25v3.15C3.26 21.36 7.34 24 12 24z"/>
                <path fill="#FBBC05" d="M5.27 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.61H1.25C.45 8.22 0 10.06 0 12s.45 3.78 1.25 5.39l4.02-3.15z"/>
                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.61l4.02 3.15c.95-2.85 3.6-4.96 6.73-4.96z"/>
            </svg>
            <span id="oauthLabel">Continue with Google (SSO)</span>
        </button>

        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px;">
            <div style="flex: 1; height: 1px; background: #EEEEEE;"></div>
            <span style="font-size: 11px; color: #888; font-weight: 600; text-transform: uppercase;">Or with credentials</span>
            <div style="flex: 1; height: 1px; background: #EEEEEE;"></div>
        </div>

        <!-- Email & Password Form -->
        <form id="emailAuthForm" onsubmit="handleAuthSubmit(event)">
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Email Address</label>
                <input type="email" required value="sarah.jenkins@example.com" style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 18px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <label style="font-size: 13px; font-weight: 700; color: #111;">Password</label>
                    <a href="javascript:void(0)" onclick="sendMagicLink()" style="font-size: 12px; color: #B45309; font-weight: 600;">Magic Link Reset?</a>
                </div>
                <input type="password" required value="••••••••••••" style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 14px; outline: none;">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 15px; justify-content: center; margin-bottom: 16px;">
                <span id="submitBtnText">Sign In as Customer</span>
            </button>
        </form>

        <!-- Phone OTP Form (Hidden by default) -->
        <form id="otpAuthForm" onsubmit="handleAuthSubmit(event)" style="display: none;">
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Mobile Phone Number</label>
                <input type="tel" placeholder="+1 (555) 000-0000" value="+1 (917) 555-0192" style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">6-Digit SMS Code</label>
                <input type="text" placeholder="6 5 4 3 2 1" maxlength="6" style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 16px; letter-spacing: 4px; outline: none;">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 15px; justify-content: center; margin-bottom: 16px;">
                Verify OTP & Enter
            </button>
        </form>

        <!-- Terms Footer -->
        <p style="text-align: center; font-size: 11.5px; color: #777; line-height: 1.5;">
            By signing in you agree to FixMate AI's <a href="#" style="text-decoration: underline;">Terms of Escrow</a> and <a href="#" style="text-decoration: underline;">Privacy Policy</a>. Protected with TLS 1.3 & Supabase Auth.
        </p>

    </div>

</div>
@endsection

@section('extra_js')
<script>
    let currentRole = 'customer';

    function selectRole(role) {
        currentRole = role;
        const custBtn = document.getElementById('roleBtnCustomer');
        const provBtn = document.getElementById('roleBtnProvider');
        const submitText = document.getElementById('submitBtnText');

        if (role === 'customer') {
            custBtn.style.background = '#FFCC00';
            custBtn.style.color = '#000';
            custBtn.style.boxShadow = '0 2px 8px rgba(255,204,0,0.3)';
            provBtn.style.background = 'transparent';
            provBtn.style.color = '#666';
            provBtn.style.boxShadow = 'none';
            submitText.textContent = "Sign In as Customer";
        } else {
            provBtn.style.background = '#FFCC00';
            provBtn.style.color = '#000';
            provBtn.style.boxShadow = '0 2px 8px rgba(255,204,0,0.3)';
            custBtn.style.background = 'transparent';
            custBtn.style.color = '#666';
            custBtn.style.boxShadow = 'none';
            submitText.textContent = "Sign In to Provider Portal";
        }
    }

    function switchAuthTab(type) {
        const emailBtn = document.getElementById('tabEmailBtn');
        const otpBtn = document.getElementById('tabOtpBtn');
        const emailForm = document.getElementById('emailAuthForm');
        const otpForm = document.getElementById('otpAuthForm');

        if (type === 'email') {
            emailBtn.style.color = '#111';
            emailBtn.style.borderBottom = '2px solid #FFCC00';
            otpBtn.style.color = '#757575';
            otpBtn.style.borderBottom = 'none';
            emailForm.style.display = 'block';
            otpForm.style.display = 'none';
        } else {
            otpBtn.style.color = '#111';
            otpBtn.style.borderBottom = '2px solid #FFCC00';
            emailBtn.style.color = '#757575';
            emailBtn.style.borderBottom = 'none';
            otpForm.style.display = 'block';
            emailForm.style.display = 'none';
        }
    }

    function handleAuthSubmit(e) {
        e.preventDefault();
        if (currentRole === 'provider') {
            showToast("Authenticated as Verified Provider! Redirecting to dashboard...");
            setTimeout(() => { window.location.href = "{{ url('/provider') }}"; }, 800);
        } else {
            showToast("Signed in as Customer! Welcome Sarah.");
            setTimeout(() => { window.location.href = "{{ url('/') }}"; }, 800);
        }
    }

    function simulateOAuth() {
        showToast("Google OAuth 2.0 authorization successful!");
        setTimeout(() => {
            window.location.href = currentRole === 'provider' ? "{{ url('/provider') }}" : "{{ url('/') }}";
        }, 800);
    }

    function sendMagicLink() {
        showToast("Password reset magic link token sent to your email!");
    }
</script>
@endsection
