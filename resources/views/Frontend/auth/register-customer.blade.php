@extends('Frontend.layouts.auth')

@section('title', 'Customer Registration — FixMate')

@section('content')
<div class="auth-form-card" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; box-shadow: var(--card-shadow); width: 100%; max-width: 1000px; display: grid; grid-template-columns: 1.25fr 0.75fr; overflow: hidden; margin: 20px 0;">

    <!-- Left Column: Registration Form -->
    <div style="padding: 48px; display: flex; flex-direction: column; justify-content: center;">

        <!-- Brand Header -->
        <div style="margin-bottom: 26px;">
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 20px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 42px; width: auto; object-fit: contain; display: block;">
            </a>

            <div style="display: inline-flex; align-items: center; gap: 7px; background: #EFF6FF; border: 1px solid #DBEAFE; color: #2563EB; font-size: 11px; font-weight: 800; letter-spacing: 0.04em; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; margin-bottom: 12px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg>
                <span>Customer Account</span>
            </div>

            <h1 style="font-size: 28px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em; margin-bottom: 6px;">Create your account</h1>
            <p style="font-size: 14px; color: #64748B; margin: 0;">Book verified technicians and get transparent upfront pricing in minutes.</p>
        </div>

        <!-- Registration Form -->
        @include('Frontend.auth.partials.errors')
        <form action="{{ route('register.customer.store') }}" method="POST" novalidate>
            @csrf

            <!-- Full Name -->
            <div style="margin-bottom: 15px;">
                <label class="app-label" for="custName">Full Name <span class="req">*</span></label>
                <div class="app-field">
                    <span class="app-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <input type="text" id="custName" name="name" class="app-input has-icon" required placeholder="e.g. Ayesha Khan" autocomplete="name">
                </div>
            </div>

            <!-- Email or Phone -->
            <div style="margin-bottom: 15px;">
                <label class="app-label" for="custIdentifier">Email or Phone Number <span class="req">*</span></label>
                <div class="app-field">
                    <span class="app-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16v16H4z"></path>
                            <path d="M4 6l8 6 8-6"></path>
                        </svg>
                    </span>
                    <input type="text" id="custIdentifier" name="identifier" class="app-input has-icon" required placeholder="0300-1234567 or name@email.com" autocomplete="username" value="{{ old('identifier') }}">
                </div>
                <p class="app-hint">We send a verification code to this contact within a minute.</p>
            </div>

            <!-- City & Area -->
            <div style="margin-bottom: 15px;">
                <label class="app-label" for="custCity">City &amp; Area <span class="req">*</span></label>
                <div class="app-field">
                    <span class="app-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </span>
                    <select id="custCity" name="city" class="app-select has-icon is-placeholder" required>
                        <option value="" selected>Select your city and area</option>
                        <option>Karachi — DHA, Clifton, Gulshan, Nazimabad</option>
                        <option>Lahore — Gulberg, DHA, Cantt, Johar Town</option>
                        <option>Islamabad / Rawalpindi — F-Sectors, Bahria, Saddar</option>
                        <option>Faisalabad — D Ground, Madina Town</option>
                        <option>Other City</option>
                    </select>
                </div>
                <p class="app-hint">Sets your default service area so we match nearby technicians.</p>
            </div>

            <!-- Password + Confirm -->
            <div class="app-grid-2" style="margin-bottom: 6px;">
                <div>
                    <label class="app-label" for="custPassword">Password <span class="req">*</span></label>
                    <div class="app-field">
                        <span class="app-field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input type="password" id="custPassword" name="password" class="app-input has-icon has-trailing" required placeholder="At least 8 characters" autocomplete="new-password" oninput="scorePassword(this.value)">
                        <button type="button" onclick="toggleField('custPassword','custEye')" style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #94A3B8; padding: 4px; display: flex; align-items: center;" title="Toggle Password">
                            <svg id="custEye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="app-label" for="custConfirm">Confirm Password <span class="req">*</span></label>
                    <div class="app-field">
                        <span class="app-field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <path d="M9 12l2 2 4-4"></path>
                            </svg>
                        </span>
                        <input type="password" id="custConfirm" name="password_confirmation" class="app-input has-icon" required placeholder="Re-enter password" autocomplete="new-password">
                    </div>
                </div>
            </div>

            <!-- Password Strength -->
            <div style="margin-bottom: 18px;">
                <div class="pw-meter">
                    <span id="pwBar1"></span>
                    <span id="pwBar2"></span>
                    <span id="pwBar3"></span>
                    <span id="pwBar4"></span>
                </div>
                <span class="pw-label" id="pwLabel">Use 8+ characters with a number and a capital letter</span>
            </div>

            <!-- Terms & Conditions -->
            <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 20px;">
                <input type="checkbox" id="custTerms" required style="width: 17px; height: 17px; border-radius: 5px; accent-color: #FFC107; cursor: pointer; margin-top: 2px; flex-shrink: 0;">
                <label for="custTerms" style="font-size: 13px; color: #475569; line-height: 1.55; cursor: pointer;">
                    I agree to the
                    <a href="{{ route('terms') }}" target="_blank" style="color: #0F172A; font-weight: 700; text-decoration: none;">Terms &amp; Conditions</a>
                    and
                    <a href="{{ route('privacy-policy') }}" target="_blank" style="color: #0F172A; font-weight: 700; text-decoration: none;">Privacy Policy</a>.
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="app-btn-primary" style="margin-bottom: 16px;">
                <span>Create Account</span>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="M12 5l7 7-7 7"></path>
                </svg>
            </button>
        </form>

        <!-- Login Link -->
        <div style="text-align: center; font-size: 13.5px; color: #64748B;">
            Already have an account?
            <a href="{{ route('login') }}" style="color: #0F172A; font-weight: 700; text-decoration: none;">Login</a>
            <span style="color: #CBD5E1; margin: 0 8px;">|</span>
            <a href="{{ route('register.role') }}" style="color: #64748B; font-weight: 600; text-decoration: none;">Register as technician</a>
        </div>

    </div>

    <!-- Right Column: Visual Banner -->
    <div class="auth-side-banner" style="position: relative; background: #0F172A; display: flex; flex-direction: column; justify-content: flex-end; padding: 36px; overflow: hidden;">

        <img src="{{ asset('assets/images/image_7.png') }}" alt="Your home, our priority" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">

        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.5) 55%, rgba(15, 23, 42, 0.92) 100%);"></div>

        <div style="position: relative; z-index: 2; color: #FFFFFF;">

            <div style="font-size: 32px; font-weight: 800; line-height: 1.15; color: #FFFFFF; letter-spacing: -0.02em;">
                Your Home
            </div>

            <div style="font-family: 'Caveat', cursive; font-size: 40px; font-weight: 700; color: #FFC107; line-height: 1.1; margin: -2px 0 16px 0;">
                Our Priority
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Browse transparent service categories with upfront cost estimates</span>
                </div>
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Book a verified technician at a fair, upfront price</span>
                </div>
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Track arrival live with technician OTP verification</span>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    const PW_COLORS = ['#E11D48', '#F97316', '#EAB308', '#16A34A'];
    const PW_LABELS = [
        'Use 8+ characters with a number and a capital letter',
        'Weak password — add more characters',
        'Fair — mix in a number or symbol',
        'Good password',
        'Strong password'
    ];

    function scorePassword(value) {
        let score = 0;
        if (value.length >= 8) score++;
        if (/[A-Z]/.test(value) && /[a-z]/.test(value)) score++;
        if (/\d/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value) || value.length >= 12) score++;

        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('pwBar' + i);
            bar.style.background = i <= score ? PW_COLORS[score - 1] : '#E2E8F0';
        }

        const label = document.getElementById('pwLabel');
        label.textContent = value.length ? PW_LABELS[score] : PW_LABELS[0];
        label.style.color = value.length ? PW_COLORS[score - 1] : '#94A3B8';
    }

    function toggleField(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }
</script>
@endsection
