@extends('Frontend.layouts.auth')

@section('title', 'Sign In — FixMate')

@section('content')
<div class="auth-form-card" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; box-shadow: var(--card-shadow); width: 100%; max-width: 960px; min-height: 580px; display: grid; grid-template-columns: 1.15fr 0.85fr; overflow: hidden; margin: 20px 0;">
    
    <!-- Left Column: Login Form -->
    <div style="padding: 48px 48px; display: flex; flex-direction: column; justify-content: center;">
        
        <!-- Brand Header matching user's design board -->
        <div style="margin-bottom: 28px;">
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 20px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 42px; width: auto; object-fit: contain; display: block;">
            </a>

            <h1 style="font-size: 28px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em; margin-bottom: 6px;">Welcome Back</h1>
            <p style="font-size: 14px; color: #64748B; margin: 0;">Sign in to your account to continue</p>
        </div>

        <!-- Login Form -->
        @include('Frontend.auth.partials.errors')
        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <!-- Email or Phone -->
            <div style="margin-bottom: 16px;">
                <label class="app-label" for="loginIdentifier">Email or Phone</label>
                <input type="text" id="loginIdentifier" name="identifier" class="app-input" required placeholder="Enter your email or phone" value="{{ old('identifier') }}" autocomplete="username">
            </div>

            <!-- Password -->
            <div style="margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label class="app-label" for="loginPassword" style="margin-bottom: 0;">Password</label>
                    <a href="{{ route('forgot-password') }}" style="font-size: 12.5px; font-weight: 600; color: #B45309; text-decoration: none;">Forgot password?</a>
                </div>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="password" id="loginPassword" name="password" class="app-input" required placeholder="Enter your password" style="padding-right: 44px;" autocomplete="current-password">
                    <button type="button" onclick="togglePassVisibility()" style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #94A3B8; padding: 4px; display: flex; align-items: center;" title="Toggle Password">
                        <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div style="display: flex; align-items: center; justify-content: flex-start; margin-bottom: 22px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; color: #475569; user-select: none;">
                    <input type="checkbox" name="remember" value="1" checked style="accent-color: #FFC107; width: 16px; height: 16px; border-radius: 4px; cursor: pointer;">
                    <span>Remember me</span>
                </label>
            </div>

            <!-- Main Submit Button -->
            <button type="submit" class="app-btn-primary" style="margin-bottom: 18px;">
                <span>Login</span>
            </button>
        </form>

        <!-- Register Link -->
        <div style="text-align: center; margin-bottom: 20px; font-size: 13.5px; color: #64748B;">
            Don't have an account? 
            <a href="{{ url('/register') }}" style="color: #0F172A; font-weight: 700; text-decoration: none;">Register</a>
        </div>

        <!-- Or Divider -->
        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 18px;">
            <div style="flex: 1; height: 1px; background: #E2E8F0;"></div>
            <span style="font-size: 12.5px; color: #94A3B8; text-transform: lowercase;">or</span>
            <div style="flex: 1; height: 1px; background: #E2E8F0;"></div>
        </div>

        <!-- Social Buttons -->
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button type="button" class="app-btn-social" onclick="window.location.href='{{ url('/customer/dashboard') }}'">
                <svg width="18" height="18" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12 5c1.55 0 2.94.55 4.03 1.45l3.02-3.02C17.21 1.7 14.77 1 12 1 7.42 1 3.53 3.61 1.67 7.41l3.69 2.87C6.25 7.15 8.9 5 12 5z"/>
                    <path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.19-2.27H12v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58l3.7 2.87c2.16-2 3.72-4.94 3.72-8.69z"/>
                    <path fill="#FBBC05" d="M5.36 14.72A7.3 7.3 0 0 1 5 12c0-.95.16-1.87.45-2.72L1.76 6.41A11.96 11.96 0 0 0 0 12c0 1.92.45 3.74 1.25 5.37l4.11-2.65z"/>
                    <path fill="#34A853" d="M12 23c3.24 0 5.96-1.07 7.95-2.92l-3.7-2.87c-1.08.72-2.45 1.16-4.25 1.16-3.1 0-5.75-2.15-6.64-5.28L1.67 15.74C3.53 19.54 7.42 23 12 23z"/>
                </svg>
                <span>Continue with Google</span>
            </button>

            <button type="button" class="app-btn-social" onclick="window.location.href='{{ url('/customer/dashboard') }}'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                <span>Continue with Facebook</span>
            </button>
        </div>

    </div>

    <!-- Right Column: Visual Banner from Mockup -->
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

            <div style="font-size: 13.5px; font-weight: 500; color: #E2E8F0; letter-spacing: 0.02em;">
                Trusted • Fast • Professional
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function togglePassVisibility() {
        const pass = document.getElementById('loginPassword');
        const eyeIcon = document.getElementById('eyeIcon');
        if (pass.type === 'password') {
            pass.type = 'text';
            eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            pass.type = 'password';
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }
</script>
@endsection
