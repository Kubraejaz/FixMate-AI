@extends('Frontend.layouts.master')

@section('title', 'Login — FixMate')
@section('meta_desc', 'Sign in to your FixMate account to manage bookings, track technicians, and view repair history.')

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 70px; display: flex; justify-content: center;">

    <!-- Split Screen Login Card (Exact Layout from Mockup 1 & 2) -->
    <div class="card-box" style="width: 100%; max-width: 900px; padding: 0; overflow: hidden; display: grid; grid-template-columns: 1.15fr 0.85fr; box-shadow: var(--shadow-lg);">
        
        <!-- Left: Form -->
        <div style="padding: 44px 40px;">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 24px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 38px; width: auto; object-fit: contain; display: block;">
            </a>

            <h1 style="font-size: 24px; font-weight: 800; color: #111; margin-bottom: 4px;">Welcome Back</h1>
            <p style="font-size: 13.5px; color: #757575; margin-bottom: 24px;">Sign in to your account</p>

            <form action="{{ url('/customer-dashboard') }}" method="GET">
                
                <!-- Email or Phone (Mockup 1) -->
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Email or Phone</label>
                    <input type="text" required placeholder="Enter your email or phone" value="ahmed.khan@example.com" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
                </div>

                <!-- Password (Mockup 1) -->
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Password</label>
                    <input type="password" required placeholder="Enter your password" value="••••••••••••" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
                </div>

                <!-- Remember Me & Forgot Password -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 12.5px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #555;">
                        <input type="checkbox" checked style="accent-color: #FFCC00;"> Remember me
                    </label>
                    <a href="javascript:void(0)" onclick="showToast('Password reset link sent to your email')" style="color: #B45309; font-weight: 600;">Forgot password?</a>
                </div>

                <!-- Login Button (Yellow) -->
                <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px; font-size: 14.5px; margin-bottom: 18px; border-radius: 12px;">
                    Login
                </button>

                <!-- Divider -->
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px;">
                    <div style="flex: 1; height: 1px; background: #EEEEEE;"></div>
                    <span style="font-size: 12px; color: #9CA3AF; text-transform: uppercase;">or</span>
                    <div style="flex: 1; height: 1px; background: #EEEEEE;"></div>
                </div>

                <!-- Social Sign In (Mockup 1) -->
                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 22px;">
                    <button type="button" class="btn-outline" style="width: 100%; padding: 10px; font-size: 13px; justify-content: center; gap: 10px;" onclick="window.location.href='{{ url('/customer-dashboard') }}'">
                        <span>🌐</span>
                        <span>Continue with Google</span>
                    </button>
                    <button type="button" class="btn-outline" style="width: 100%; padding: 10px; font-size: 13px; justify-content: center; gap: 10px;" onclick="window.location.href='{{ url('/customer-dashboard') }}'">
                        <span>📘</span>
                        <span>Continue with Facebook</span>
                    </button>
                </div>

                <!-- Register Link -->
                <p style="text-align: center; font-size: 13px; color: #666;">
                    Don't have an account? <a href="{{ url('/register') }}" style="color: #111; font-weight: 700; text-decoration: underline;">Register</a>
                </p>

            </form>
        </div>

        <!-- Right Side: Lifestyle Photo with Overlay (Mockup 2) -->
        <div style="position: relative; background: #111;">
            <img src="{{ asset('assets/images/image_8.png') }}" alt="Your Home Our Priority" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85;">
            
            <div style="position: absolute; bottom: 32px; left: 32px; right: 32px; background: rgba(17,17,17,0.75); backdrop-filter: blur(8px); padding: 24px; border-radius: 18px; border: 1px solid rgba(255,255,255,0.15); color: #FFF;">
                <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 6px;">Your Home Our Priority</h3>
                <p style="font-size: 13px; color: #E5E7EB; line-height: 1.5;">
                    Trusted • Fast • Professional. Book verified technicians with 100% peace of mind.
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
