@extends('Frontend.layouts.public')

@section('title', 'Terms & Conditions — FixMate AI')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 80vh; padding: 50px 0 70px 0;">
    <div class="container" style="max-width: 820px; margin: 0 auto;">
        <div class="portal-card" style="padding: 40px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 800; color: #B45309; text-transform: uppercase;">Terms of Service</span>
            <h1 style="font-size: 32px; font-weight: 900; color: #111; margin: 6px 0 16px 0;">Terms & Conditions</h1>
            <p style="font-size: 13.5px; color: #777; margin-bottom: 24px;">Effective: September 2026</p>

            <div style="font-size: 14.5px; color: #4B5563; line-height: 1.8; display: flex; flex-direction: column; gap: 20px;">
                <p>
                    By accessing or registering with FixMate AI, you agree to comply with the following contractual terms and service standards.
                </p>

                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-top: 10px;">1. Service Provider Relationship</h3>
                <p>
                    Technicians operating on FixMate AI are independent verified service providers. FixMate AI validates trade credentials and NADRA CNIC records, and provides automated AI diagnostics, schedule tracking, and escrow payment intermediation.
                </p>

                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-top: 10px;">2. Two-Factor Service OTP Handshake</h3>
                <p>
                    Upon arrival, the customer provides a 4-digit verification OTP to the technician before service execution begins. A completion signature or post-service confirmation triggers escrow payment release.
                </p>

                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-top: 10px;">3. 30-Day Workmanship Warranty</h3>
                <p>
                    Bookings paid through FixMate AI are eligible for our 30-day rework warranty. If any repaired component fails within 30 days of the documented booking completion, a verified technician will be dispatched for inspection at zero additional diagnostic charge.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
