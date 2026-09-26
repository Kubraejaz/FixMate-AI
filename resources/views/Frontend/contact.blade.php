@extends('Frontend.layouts.master')

@section('title', 'Contact Us & FAQs — FixMate AI')
@section('meta_desc', 'Get in touch with FixMate AI customer support or explore answers to frequently asked questions.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px; max-width: 960px;">

    <!-- Contact Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 32px; font-weight: 800; color: #111; margin-bottom: 8px;">Contact & Support</h1>
        <p style="font-size: 15px; color: #757575;">We're here to help you 24/7 with bookings, disputes, and technician inquiries.</p>
    </div>

    <!-- Contact Info Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
        <div class="card-box" style="text-align: center; padding: 26px;">
            <div style="font-size: 28px; margin-bottom: 8px;">📞</div>
            <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 4px;">Phone Helpline</strong>
            <span style="font-size: 13.5px; color: #555;">+92 (21) 111-FIX-MATE</span>
            <span style="font-size: 11px; color: #10B981; font-weight: 700; display: block; margin-top: 4px;">Toll-free 24/7</span>
        </div>
        <div class="card-box" style="text-align: center; padding: 26px;">
            <div style="font-size: 28px; margin-bottom: 8px;">✉️</div>
            <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 4px;">Email Support</strong>
            <span style="font-size: 13.5px; color: #555;">support@fixmate.ai</span>
            <span style="font-size: 11px; color: #777; display: block; margin-top: 4px;">Response &lt; 2 hrs</span>
        </div>
        <div class="card-box" style="text-align: center; padding: 26px;">
            <div style="font-size: 28px; margin-bottom: 8px;">📍</div>
            <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 4px;">Headquarters</strong>
            <span style="font-size: 13.5px; color: #555;">DHA Phase 6, Karachi</span>
            <span style="font-size: 11px; color: #777; display: block; margin-top: 4px;">Pakistan</span>
        </div>
    </div>

    <!-- Frequently Asked Questions -->
    <div class="card-box" style="padding: 36px; margin-bottom: 40px;">
        <h2 style="font-size: 22px; font-weight: 800; color: #111; margin-bottom: 20px;">Frequently Asked Questions (FAQs)</h2>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div style="border-bottom: 1px solid #EEEEEE; padding-bottom: 14px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #111; margin-bottom: 4px;">How does the AI Problem Diagnostic work?</h4>
                <p style="font-size: 13.5px; color: #666; line-height: 1.5;">
                    You upload a photo or describe the issue. Our computer vision AI identifies the fault, estimates the required parts and costs, and automatically matches certified technicians in your area.
                </p>
            </div>

            <div style="border-bottom: 1px solid #EEEEEE; padding-bottom: 14px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #111; margin-bottom: 4px;">When is payment released to the technician?</h4>
                <p style="font-size: 13.5px; color: #666; line-height: 1.5;">
                    Your payment remains locked in FixMate smart escrow. Funds are released to the technician only after you confirm satisfaction with your 4-digit completion code.
                </p>
            </div>

            <div>
                <h4 style="font-size: 15px; font-weight: 700; color: #111; margin-bottom: 4px;">Are all technicians background checked?</h4>
                <p style="font-size: 13.5px; color: #666; line-height: 1.5;">
                    Yes. All service providers must submit government CNIC identification, verified trade licenses, and pass criminal record checks before accepting jobs.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
