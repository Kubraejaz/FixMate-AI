@extends('Frontend.layouts.public')

@section('title', 'Forgot Password — FixMate AI')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 40px 0;">
    <div class="container" style="max-width: 460px;">
        
        <div class="portal-card" style="padding: 36px 32px; background: #FFFFFF; border-radius: 20px;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="display: inline-flex; width: 44px; height: 44px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FFECB3; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                    🔑
                </div>
                <h1 style="font-size: 24px; font-weight: 900; color: #111; margin-bottom: 6px;">Reset Password</h1>
                <p style="font-size: 13.5px; color: #666; margin: 0;">Enter your registered email address or mobile phone to receive a reset code.</p>
            </div>

            <form action="{{ url('/reset-password') }}" method="GET">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Email or Phone Number</label>
                    <input type="text" class="form-input" placeholder="e.g. customer@fixmate.ai" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px; margin-bottom: 16px;">
                    Send Reset Link
                </button>
            </form>

            <div style="text-align: center; font-size: 13px; color: #666;">
                Remember your password? <a href="{{ url('/login') }}" style="color: #111; font-weight: 800; text-decoration: none;">Back to Login</a>
            </div>
        </div>

    </div>
</div>
@endsection
