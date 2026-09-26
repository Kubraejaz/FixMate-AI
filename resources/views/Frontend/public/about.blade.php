@extends('Frontend.layouts.public')

@section('title', 'About Us — FixMate AI | Smart Home Services')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">ABOUT FIXMATE AI</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">About Us</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">Smart solutions for a better home — connecting you with trusted, verified professionals.</p>
        </div>
    </section>

    <!-- Mission & Story -->
    <section style="padding: 48px 0;">
        <div class="container" style="max-width: 900px;">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 36px; align-items: center; margin-bottom: 48px;">
                <div>
                    <h2 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 0 0 16px 0; line-height: 1.2;">
                        Making home services simple, safe and transparent
                    </h2>
                    <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 0 0 16px 0;">
                        FixMate AI connects Pakistani homeowners with skilled, verified technicians for plumbing, electrical, AC repair, carpentry, and deep cleaning.
                    </p>
                    <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 0;">
                        We combine computer vision AI to estimate repair costs upfront with escrow protection and arrival OTPs so you always know what you're paying for.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('assets/images/image_7.png') }}" alt="Modern Home" style="width: 100%; height: 280px; object-fit: cover; border-radius: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.06);">
                </div>
            </div>

            <!-- 3 Core Values -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; text-align: center;">
                    <div style="font-size: 28px; margin-bottom: 8px;">🛡️</div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Trust & Safety</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0;">Every professional is background checked and verified.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; text-align: center;">
                    <div style="font-size: 28px; margin-bottom: 8px;">🤖</div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">AI Precision</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0;">Instant image diagnosis and transparent cost estimates.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; text-align: center;">
                    <div style="font-size: 28px; margin-bottom: 8px;">⚡</div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Fast & Reliable</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0;">On-time arrival with live GPS tracking and escrow security.</p>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
