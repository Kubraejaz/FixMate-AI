@extends('Frontend.layouts.master')

@section('title', 'About Us — FixMate AI | Smart Solutions for a Better Home')
@section('meta_desc', 'Learn how FixMate AI connects homeowners with verified professionals across Pakistan through intelligent AI diagnostics and trust.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- About Us Hero (Exact Layout from Mockup 1) -->
    <div style="background: #FFFFFF; border: 1px solid var(--border-color); border-radius: 28px; padding: 48px; margin-bottom: 36px; display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 40px; align-items: center; box-shadow: var(--shadow-sm);">
        <div>
            <span style="font-size: 13px; font-weight: 700; color: #8C6B00; background: #FFF9E6; border: 1px solid #FFECB3; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 14px;">
                About Us
            </span>
            <h1 style="font-size: 36px; font-weight: 800; color: #111; line-height: 1.2; margin-bottom: 16px;">
                Smart Solutions for a Better Home
            </h1>
            <p style="font-size: 15px; color: #666; line-height: 1.7; margin-bottom: 24px;">
                FixMate AI is an intelligent home service platform that connects you with verified professionals for all your home maintenance needs. We use AI to understand your problem, find the right solution, and match you with the best technician — fast.
            </p>

            <!-- 3 Pill Values -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 16px; padding: 16px; text-align: center;">
                    <div style="font-size: 22px; margin-bottom: 4px;">🤝</div>
                    <strong style="font-size: 14px; color: #111; display: block;">Trust</strong>
                    <span style="font-size: 11.5px; color: #777;">Verified Professionals</span>
                </div>
                <div style="background: #FFFDF0; border: 1px solid #FFECB3; border-radius: 16px; padding: 16px; text-align: center;">
                    <div style="font-size: 22px; margin-bottom: 4px;">🧠</div>
                    <strong style="font-size: 14px; color: #111; display: block;">Smart</strong>
                    <span style="font-size: 11.5px; color: #777;">AI-Powered Matching</span>
                </div>
                <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 16px; padding: 16px; text-align: center;">
                    <div style="font-size: 22px; margin-bottom: 4px;">⏱️</div>
                    <strong style="font-size: 14px; color: #111; display: block;">Reliable</strong>
                    <span style="font-size: 11.5px; color: #777;">On-Time Service</span>
                </div>
            </div>
        </div>

        <!-- Right Side: User Added Image -->
        <div style="border-radius: 24px; overflow: hidden; box-shadow: var(--shadow-md); border: 2px solid #F3F4F6;">
            <img src="{{ asset('assets/images/image_8.png') }}" alt="Modern beautiful home" style="width: 100%; height: 340px; object-fit: cover;">
        </div>
    </div>

    <!-- Mission & Vision Cards (From Mockup 1) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 48px;">
        <div class="card-box" style="padding: 36px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 16px;">
                🎯
            </div>
            <h3 style="font-size: 20px; font-weight: 800; color: #111; margin-bottom: 10px;">Our Mission</h3>
            <p style="font-size: 14.5px; color: #666; line-height: 1.6;">
                To make home services simple, safe and stress-free for everyone in Pakistan through technology and trust. We eliminate price ambiguity and connect customers directly with skilled tradespeople.
            </p>
        </div>

        <div class="card-box" style="padding: 36px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 16px;">
                🔭
            </div>
            <h3 style="font-size: 20px; font-weight: 800; color: #111; margin-bottom: 10px;">Our Vision</h3>
            <p style="font-size: 14.5px; color: #666; line-height: 1.6;">
                To become the most trusted and intelligent home service platform in Pakistan and beyond, setting new standards for transparent escrow payments, rapid technician dispatch, and digital work verification.
            </p>
        </div>
    </div>

    <!-- Bottom CTA -->
    <div class="become-tech-banner">
        <div>
            <h3 style="font-size: 22px; font-weight: 800; color: #111; margin-bottom: 6px;">Need a home fix today?</h3>
            <p style="font-size: 14px; color: #666; margin-bottom: 16px;">Let our AI diagnostic engine identify your issue in seconds.</p>
            <a href="{{ url('/describe-problem') }}" class="btn-yellow">Describe Your Problem</a>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ url('/services') }}" class="btn-outline">Browse All Services</a>
        </div>
    </div>

</div>
@endsection
