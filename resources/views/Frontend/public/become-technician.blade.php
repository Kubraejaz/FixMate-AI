@extends('Frontend.layouts.public')

@section('title', 'Become a Technician Partner — FixMate AI')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">PARTNER WITH FIXMATE AI</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Become a Technician</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">Join Pakistan's leading network of verified home service providers and grow your earnings.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 48px 0;">
        <div class="container" style="max-width: 860px;">
            
            <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 36px; align-items: center; margin-bottom: 40px;">
                <div>
                    <h2 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 0 0 14px 0;">
                        Work on your own terms. Earn with dignity.
                    </h2>
                    <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 0 0 20px 0;">
                        Get verified local customer jobs dispatched directly to your phone. See AI problem photos and estimated costs before accepting, and receive guaranteed payouts.
                    </p>
                    <a href="{{ url('/register/technician') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 14.5px; padding: 12px 28px; border-radius: 50px; text-decoration: none; display: inline-block; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);">
                        Register as Technician →
                    </a>
                </div>
                <div style="text-align: center;">
                    <img src="{{ asset('assets/images/image_8.png') }}" alt="Technician Partner" style="height: 320px; width: auto; object-fit: contain;">
                </div>
            </div>

            <!-- 3 Partner Benefits -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px;">
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px;">
                    <div style="font-size: 24px; margin-bottom: 8px;">💰</div>
                    <strong style="display: block; font-size: 15px; color: #0F172A; margin-bottom: 4px;">Guaranteed Payouts</strong>
                    <span style="font-size: 12.5px; color: #64748B;">Escrow-secured payments directly to JazzCash or Bank.</span>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px;">
                    <div style="font-size: 24px; margin-bottom: 8px;">📍</div>
                    <strong style="display: block; font-size: 15px; color: #0F172A; margin-bottom: 4px;">Jobs Near You</strong>
                    <span style="font-size: 12.5px; color: #64748B;">Smart GPS dispatch saves fuel and commute time.</span>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px;">
                    <div style="font-size: 24px; margin-bottom: 8px;">🛡️</div>
                    <strong style="display: block; font-size: 15px; color: #0F172A; margin-bottom: 4px;">Verified Customers</strong>
                    <span style="font-size: 12.5px; color: #64748B;">OTP arrival handshakes protect your safety and time.</span>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
