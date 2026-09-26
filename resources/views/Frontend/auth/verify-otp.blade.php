@extends('Frontend.layouts.public')

@section('title', 'Verify Phone OTP — FixMate AI')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 40px 0;">
    <div class="container" style="max-width: 480px;">
        
        <div class="portal-card" style="padding: 40px 32px; background: #FFFFFF; text-align: center; border-radius: 20px;">
            <div style="display: inline-flex; width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
                📱
            </div>

            <h1 style="font-size: 24px; font-weight: 900; color: #111; margin-bottom: 6px;">Phone OTP Verification</h1>
            <p style="font-size: 13.5px; color: #666; line-height: 1.5; margin-bottom: 24px;">
                We sent a 6-digit one-time verification code to <br><strong style="color: #111;">+92 300 1234567</strong>
            </p>

            @php
                $targetUrl = request('role') === 'technician' ? url('/technician/verification') : url('/customer/dashboard');
            @endphp

            <form action="{{ $targetUrl }}" method="GET">
                <!-- 6-digit Inputs -->
                <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 24px;">
                    <input type="text" maxlength="1" value="5" class="form-input" style="width: 46px; height: 50px; text-align: center; font-size: 20px; font-weight: 800;">
                    <input type="text" maxlength="1" value="8" class="form-input" style="width: 46px; height: 50px; text-align: center; font-size: 20px; font-weight: 800;">
                    <input type="text" maxlength="1" value="2" class="form-input" style="width: 46px; height: 50px; text-align: center; font-size: 20px; font-weight: 800;">
                    <input type="text" maxlength="1" value="9" class="form-input" style="width: 46px; height: 50px; text-align: center; font-size: 20px; font-weight: 800;">
                    <input type="text" maxlength="1" value="4" class="form-input" style="width: 46px; height: 50px; text-align: center; font-size: 20px; font-weight: 800;">
                    <input type="text" maxlength="1" value="1" class="form-input" style="width: 46px; height: 50px; text-align: center; font-size: 20px; font-weight: 800;">
                </div>

                <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px; margin-bottom: 18px;">
                    Verify & Continue
                </button>
            </form>

            <div style="font-size: 13px; color: #666;">
                Didn't receive the SMS code? <br>
                <span style="color: #9CA3AF; font-size: 12px;">Resend code in <strong style="color: #111;" id="countdown">45s</strong></span>
                <br>
                <a href="#" style="color: #B45309; font-weight: 700; text-decoration: none; font-size: 12.5px; display: inline-block; margin-top: 6px;">Change Phone Number</a>
            </div>
        </div>

    </div>
</div>
@endsection
