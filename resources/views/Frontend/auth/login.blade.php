@extends('Frontend.layouts.public')

@section('title', 'Login to FixMate AI — Customer, Technician & Admin')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: calc(100vh - 140px); display: flex; align-items: center; justify-content: center; padding: 40px 0;">
    <div class="container" style="max-width: 960px;">
        
        <!-- Split Login Container (Matching Mockup 1 & 2) -->
        <div class="portal-card" style="padding: 0; overflow: hidden; display: grid; grid-template-columns: 1.1fr 0.9fr; background: #FFFFFF; box-shadow: 0 20px 45px rgba(0,0,0,0.08); border-radius: 20px;">
            
            <!-- Left Form Side -->
            <div style="padding: 44px 40px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FFCC00; display: flex; align-items: center; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        </svg>
                    </div>
                    <strong style="font-size: 20px; font-weight: 900; color: #111;">FixMate <span style="color: #FFCC00; background: #111; padding: 2px 6px; border-radius: 6px; font-size: 11px;">AI</span></strong>
                </div>

                <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 6px;">Welcome Back</h1>
                <p style="font-size: 13.5px; color: #666; margin-bottom: 28px;">Sign in to your account to manage your services.</p>

                <form action="{{ url('/customer/dashboard') }}" method="GET" id="loginForm">
                    <!-- Email or Phone -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Email or Phone</label>
                        <input type="text" id="loginIdentifier" class="form-input" placeholder="Enter your email or phone" value="customer@fixmate.ai" required style="padding: 11px 14px; font-size: 14px;">
                    </div>

                    <!-- Password -->
                    <div class="form-group" style="margin-bottom: 14px;">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Password</label>
                        <input type="password" class="form-input" placeholder="Enter your password" value="••••••••" required style="padding: 11px 14px; font-size: 14px;">
                    </div>

                    <!-- Remember & Forgot Password -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; font-size: 12.5px;">
                        <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: #4B5563;">
                            <input type="checkbox" checked style="accent-color: #FFCC00;">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ url('/forgot-password') }}" style="color: #B45309; font-weight: 700; text-decoration: none;">Forgot password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px; margin-bottom: 18px;">
                        Login
                    </button>
                </form>

                <!-- Role Quick-Login Helper for Demo -->
                <div style="background: #FFFDF0; border: 1px dashed #FEF08A; border-radius: 10px; padding: 10px 14px; margin-bottom: 20px; font-size: 11.5px;">
                    <span style="font-weight: 800; color: #92400E; display: block; margin-bottom: 4px;">⚡ Demo Fast Role Redirect:</span>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ url('/customer/dashboard') }}" style="color: #047857; font-weight: 700;">Customer →</a>
                        <span style="color: #CCC;">|</span>
                        <a href="{{ url('/technician/dashboard') }}" style="color: #B45309; font-weight: 700;">Technician →</a>
                        <span style="color: #CCC;">|</span>
                        <a href="{{ url('/admin/dashboard') }}" style="color: #111; font-weight: 700;">Admin Console →</a>
                    </div>
                </div>

                <!-- Divider -->
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px;">
                    <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
                    <span style="font-size: 12px; color: #9CA3AF;">or</span>
                    <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
                </div>

                <!-- Social OAuth Buttons (Matching Mockup 1) -->
                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 22px;">
                    <button type="button" class="btn-outline" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 10px 0; font-size: 13.5px;">
                        <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.55 0 2.94.55 4.03 1.45l3.02-3.02C17.21 1.7 14.77 1 12 1 7.42 1 3.53 3.61 1.67 7.41l3.69 2.87C6.25 7.15 8.9 5 12 5z"/><path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.19-2.27H12v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58l3.7 2.87c2.16-2 3.72-4.94 3.72-8.69z"/><path fill="#FBBC05" d="M5.36 14.72A7.3 7.3 0 0 1 5 12c0-.95.16-1.87.45-2.72L1.76 6.41A11.96 11.96 0 0 0 0 12c0 1.92.45 3.74 1.25 5.37l4.11-2.65z"/><path fill="#34A853" d="M12 23c3.24 0 5.96-1.07 7.95-2.92l-3.7-2.87c-1.08.72-2.45 1.16-4.25 1.16-3.1 0-5.75-2.15-6.64-5.28L1.67 15.74C3.53 19.54 7.42 23 12 23z"/></svg>
                        <span>Continue with Google</span>
                    </button>
                    <button type="button" class="btn-outline" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 10px 0; font-size: 13.5px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Continue with Facebook</span>
                    </button>
                </div>

                <!-- Registration link -->
                <div style="text-align: center; font-size: 13px; color: #666;">
                    Don't have an account? <a href="{{ url('/register/role') }}" style="color: #111; font-weight: 800; text-decoration: none;">Register</a>
                </div>
            </div>

            <!-- Right Visual Side (Matching Mockup 1 & 2) -->
            <div style="position: relative; background: #111; overflow: hidden; display: flex; flex-direction: column; justify-content: flex-end; padding: 40px; color: #FFFFFF;">
                <img src="{{ asset('assets/images/image_7.png') }}" alt="Your Home Our Priority" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.65;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.85) 100%);"></div>

                <div style="position: relative; z-index: 2;">
                    <div style="background: rgba(255,204,0,0.2); border: 1px solid rgba(255,204,0,0.4); display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; color: #FFCC00; margin-bottom: 12px;">
                        FIXMATE GUARANTEE
                    </div>
                    <h2 style="font-size: 28px; font-weight: 900; line-height: 1.2; margin-bottom: 8px;">Your Home<br>Our Priority</h2>
                    <p style="font-size: 13.5px; color: #D1D5DB; margin: 0;">Trusted • Fast • Professional • AI-Verified</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
