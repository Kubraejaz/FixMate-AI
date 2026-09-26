@extends('Frontend.layouts.technician')

@section('title', 'Job Details — Kitchen Sink Leakage (#FM-10245)')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <!-- Header with Back Link matching Mockup 2 & 3 -->
    <div style="margin-bottom: 20px;">
        <a href="{{ url('/technician/jobs') }}" style="font-size: 13px; color: #666; text-decoration: none; display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
            ← Back to Job Requests
        </a>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0;">Job #FM-10245 Details</h1>
            <span style="background: #FFF9E6; color: #B45309; border: 1px solid #FFECB3; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                Incoming Request
            </span>
        </div>
    </div>

    <!-- Main Job Card matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        
        <!-- Customer Info Strip -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 16px;">
                    AK
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0 0 2px 0;">Ahmed Khan</h3>
                    <span style="font-size: 13px; color: #666;">Customer Rating: 5.0 ★ • Verified Homeowner</span>
                </div>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 12px; color: #777;">Scheduled Slot</span>
                <strong style="display: block; font-size: 14px; color: #111;">Today • 2:30 PM - 3:30 PM</strong>
            </div>
        </div>

        <!-- Problem & AI Diagnosis Result -->
        <div style="margin-bottom: 24px;">
            <span style="font-size: 11.5px; font-weight: 800; color: #B45309; text-transform: uppercase;">Problem Description & AI Scanner</span>
            <h2 style="font-size: 20px; font-weight: 900; color: #111; margin: 4px 0 10px 0;">Kitchen Sink Leakage</h2>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 16px;">
                "Water is leaking from the pipe under the cabinet whenever the tap is turned on. Need P-trap inspection and rubber seal replacement."
            </p>

            <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                <div>
                    <span style="font-size: 11px; color: #777; text-transform: uppercase;">AI Classification</span>
                    <strong style="display: block; font-size: 14px; color: #111;">Plumbing (P-trap)</strong>
                </div>
                <div>
                    <span style="font-size: 11px; color: #777; text-transform: uppercase;">Confidence</span>
                    <strong style="display: block; font-size: 14px; color: #047857;">92% Match</strong>
                </div>
                <div>
                    <span style="font-size: 11px; color: #777; text-transform: uppercase;">Est. Compensation</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Rs. 500 – 800</strong>
                </div>
            </div>

            <!-- Uploaded Photos from User matching Mockup 2 & 3 -->
            <span style="font-size: 12.5px; font-weight: 700; color: #374151; display: block; margin-bottom: 10px;">Customer Uploaded Photos:</span>
            <div style="display: flex; gap: 14px;">
                <div style="width: 140px; height: 110px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color);">
                    <img src="{{ asset('assets/images/image_6.png') }}" alt="Kitchen sink leak" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="width: 140px; height: 110px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color);">
                    <img src="{{ asset('assets/images/image_7.png') }}" alt="Cabinet interior" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- Location & Directions -->
        <div style="border-top: 1px solid var(--border-color); padding-top: 20px; margin-bottom: 28px;">
            <span style="font-size: 11.5px; font-weight: 800; color: #6B7280; text-transform: uppercase;">Service Address & Navigation</span>
            <strong style="display: block; font-size: 15px; color: #111; margin: 4px 0 6px 0;">House 42-B, Street 18, Phase 6, DHA, Karachi</strong>
            <p style="font-size: 13px; color: #666; margin: 0;">Instructions: "Gate is open, kitchen is on the right. Ring doorbell." (2.1 km away • approx 8 min ride)</p>
        </div>

        <!-- Action Row matching Mockup 2 & 3 -->
        <div style="display: flex; gap: 14px;">
            <a href="{{ url('/technician/jobs') }}" class="btn-outline" style="flex: 1; text-align: center; padding: 12px 0; font-size: 14px; border-color: #EF4444; color: #DC2626;">
                Reject Job
            </a>
            <a href="{{ url('/technician/active-job') }}" class="btn-yellow" style="flex: 2; text-align: center; padding: 12px 0; font-size: 14.5px; font-weight: 900;">
                Accept Job & Start Route →
            </a>
        </div>

    </div>

</div>
@endsection
