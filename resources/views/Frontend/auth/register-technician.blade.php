@extends('Frontend.layouts.auth')

@section('title', 'Technician Registration — FixMate Partner Network')

@section('content')
<div class="auth-form-card" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; box-shadow: var(--card-shadow); width: 100%; max-width: 1060px; display: grid; grid-template-columns: 1.4fr 0.6fr; overflow: hidden; margin: 20px 0;">

    <!-- Left Column: Registration Form -->
    <div style="padding: 48px; display: flex; flex-direction: column; justify-content: center;">

        <!-- Brand Header -->
        <div style="margin-bottom: 26px;">
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 20px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 42px; width: auto; object-fit: contain; display: block;">
            </a>

            <div style="display: inline-flex; align-items: center; gap: 7px; background: #FFFBEB; border: 1px solid #FDE68A; color: #B45309; font-size: 11px; font-weight: 800; letter-spacing: 0.04em; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; margin-bottom: 12px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6z"></path>
                    <path d="M17.5 3.5l3 3"></path>
                </svg>
                <span>Technician Partner</span>
            </div>

            <h1 style="font-size: 28px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em; margin-bottom: 6px;">Become a partner</h1>
            <p style="font-size: 14px; color: #64748B; margin: 0;">Get nearby job dispatches and guaranteed weekly payouts.</p>
        </div>

        <!-- Registration Form -->
        @include('Frontend.auth.partials.errors')
        <form action="{{ route('register.technician.store') }}" method="POST" novalidate>
            @csrf

            <!-- Full Legal Name -->
            <div style="margin-bottom: 15px;">
                <label class="app-label" for="techName">Full Legal Name <span class="req">*</span></label>
                <div class="app-field">
                    <span class="app-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <input type="text" id="techName" name="name" class="app-input has-icon" required placeholder="As printed on your CNIC" autocomplete="name" value="{{ old('name') }}">
                </div>
            </div>

            <!-- Email Address -->
            <div style="margin-bottom: 15px;">
                <label class="app-label" for="techEmail">Email Address <span class="req">*</span></label>
                <div class="app-field">
                    <span class="app-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2.5"></rect>
                            <path d="M2.5 6.5l9.5 7 9.5-7"></path>
                        </svg>
                    </span>
                    <input type="email" id="techEmail" name="email" class="app-input has-icon" required placeholder="you@example.com" autocomplete="email" value="{{ old('email') }}">
                </div>
                <p class="app-hint">Use this to sign in. Job alerts also go to your mobile number.</p>
            </div>

            <!-- Mobile Number -->
            <div style="margin-bottom: 15px;">
                <label class="app-label" for="techPhone">Mobile Number <span class="req">*</span></label>
                <div class="app-field">
                    <span class="app-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="5" y="2" width="14" height="20" rx="2.5"></rect>
                            <path d="M11 18h2"></path>
                        </svg>
                    </span>
                    <input type="tel" id="techPhone" name="phone" class="app-input has-icon" required placeholder="03XX-XXXXXXX" autocomplete="tel" value="{{ old('phone') }}">
                </div>
                <p class="app-hint">Job dispatches and arrival OTPs are sent to this number.</p>
            </div>

            <!-- CNIC + Experience -->
            <div class="app-grid-2" style="margin-bottom: 6px;">
                <div>
                    <label class="app-label" for="techCnic">CNIC Number <span class="req">*</span></label>
                    <div class="app-field">
                        <span class="app-field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2.5"></rect>
                                <circle cx="8.5" cy="11" r="2.5"></circle>
                                <path d="M5 16.5c.6-1.6 2-2.5 3.5-2.5s2.9.9 3.5 2.5"></path>
                                <path d="M15 10h4"></path>
                                <path d="M15 14h4"></path>
                            </svg>
                        </span>
                        <input type="text" id="techCnic" name="cnic" class="app-input has-icon" required placeholder="42201-1234567-1" inputmode="numeric">
                    </div>
                    <p class="app-hint">Format: 00000-0000000-0</p>
                </div>
                <div>
                    <label class="app-label" for="techExperience">Experience <span class="req">*</span></label>
                    <div class="app-field">
                        <span class="app-field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2.5"></rect>
                                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path>
                                <path d="M2 13h20"></path>
                            </svg>
                        </span>
                        <select id="techExperience" name="experience" class="app-select has-icon" required>
                            <option value="" selected>Select experience</option>
                            <option>Less than 1 year</option>
                            <option>1 - 2 Years</option>
                            <option>3 - 5 Years</option>
                            <option>5 - 8 Years</option>
                            <option>8+ Years</option>
                        </select>
                    </div>
                    <p class="app-hint">Hands-on trade experience only.</p>
                </div>
            </div>

            <!-- Primary Profession -->
            <div style="margin: 15px 0;">
                <label class="app-label" for="techTrade">Primary Profession / Trade <span class="req">*</span></label>
                <div class="app-field">
                    <span class="app-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6z"></path>
                            <path d="M17.5 3.5l3 3"></path>
                        </svg>
                    </span>
                    <select id="techTrade" name="trade" class="app-select has-icon is-placeholder" required>
                        <option value="" selected>Select your primary profession</option>
                        @foreach(\App\Models\Profession::where('is_active', true)->get() as $prof)
                            <option value="{{ $prof->id }}" {{ old('trade') == $prof->id ? 'selected' : '' }}>
                                {{ $prof->name }} {{ $prof->description ? '— ' . $prof->description : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="app-hint">You will receive dispatches matching this profession first.</p>
            </div>

            <!-- Password + Confirm -->
            <div class="app-grid-2" style="margin-bottom: 6px;">
                <div>
                    <label class="app-label" for="techPassword">Create Password <span class="req">*</span></label>
                    <div class="app-field">
                        <span class="app-field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input type="password" id="techPassword" name="password" class="app-input has-icon has-trailing" required placeholder="At least 8 characters" autocomplete="new-password" oninput="scorePassword(this.value)">
                        <button type="button" onclick="toggleField('techPassword','techEye')" style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #94A3B8; padding: 4px; display: flex; align-items: center;" title="Toggle Password">
                            <svg id="techEye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="app-label" for="techConfirm">Confirm Password <span class="req">*</span></label>
                    <div class="app-field">
                        <span class="app-field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <path d="M9 12l2 2 4-4"></path>
                            </svg>
                        </span>
                        <input type="password" id="techConfirm" name="password_confirmation" class="app-input has-icon" required placeholder="Re-enter password" autocomplete="new-password">
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
                <input type="checkbox" id="techTerms" required style="width: 17px; height: 17px; border-radius: 5px; accent-color: #FFC107; cursor: pointer; margin-top: 2px; flex-shrink: 0;">
                <label for="techTerms" style="font-size: 13px; color: #475569; line-height: 1.55; cursor: pointer;">
                    I agree to the
                    <a href="{{ route('terms') }}" target="_blank" style="color: #0F172A; font-weight: 700; text-decoration: none;">Partner Terms</a>,
                    <a href="{{ route('terms') }}" target="_blank" style="color: #0F172A; font-weight: 700; text-decoration: none;">Commission &amp; Payout Policy</a>
                    and
                    <a href="{{ route('privacy-policy') }}" target="_blank" style="color: #0F172A; font-weight: 700; text-decoration: none;">Privacy Policy</a>.
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="app-btn-primary" style="margin-bottom: 16px;">
                <span>Register &amp; Get Verified</span>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="M12 5l7 7-7 7"></path>
                </svg>
            </button>
        </form>

        <!-- Login Link -->
        <div style="text-align: center; font-size: 13.5px; color: #64748B;">
            Already registered as a partner?
            <a href="{{ route('login') }}" style="color: #0F172A; font-weight: 700; text-decoration: none;">Login</a>
            <span style="color: #CBD5E1; margin: 0 8px;">|</span>
            <a href="{{ route('register.role') }}" style="color: #64748B; font-weight: 600; text-decoration: none;">Register as customer</a>
        </div>

    </div>

    <!-- Right Column: Visual Banner -->
    <div class="auth-side-banner" style="position: relative; background: #0F172A; display: flex; flex-direction: column; justify-content: flex-end; padding: 32px; overflow: hidden;">

        <img src="{{ asset('assets/images/Cleaning_Professional.png') }}" alt="Verified FixMate technician" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; object-position: center 25%;">

        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 23, 42, 0.05) 0%, rgba(15, 23, 42, 0.45) 50%, rgba(15, 23, 42, 0.95) 100%);"></div>

        <div style="position: relative; z-index: 2; color: #FFFFFF;">

            <div style="font-size: 28px; font-weight: 800; line-height: 1.15; color: #FFFFFF; letter-spacing: -0.02em;">
                More Jobs,
            </div>

            <div style="font-family: 'Caveat', cursive; font-size: 36px; font-weight: 700; color: #FFC107; line-height: 1.1; margin: -2px 0 16px 0;">
                Guaranteed Pay
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Accept only jobs you want, no forced dispatch</span>
                </div>
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Weekly payouts with no commission surprises</span>
                </div>
                <div class="auth-feature">
                    <span class="tick">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </span>
                    <span>Verified badge after CNIC and trade review</span>
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
