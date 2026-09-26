@extends('Frontend.layouts.customer')

@section('title', 'My Bookings — FixMate AI')

@section('content')
<div>
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Bookings</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Track ongoing repair services and review your service history.</p>
    </div>

    <!-- Tabs matching Section 4: Upcoming, Active, Completed, Cancelled -->
    <div style="display: flex; gap: 10px; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
        <button class="btn-yellow" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Active (1)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Upcoming (1)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Completed (12)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Cancelled (0)</button>
    </div>

    <!-- Bookings Cards List -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        
        <!-- Active Booking #FM-10245 -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center; border-left: 5px solid #FFCC00;">
            <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
            
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <strong style="font-size: 17px; color: #111;">Plumbing — Sink Repair</strong>
                    <span style="background: #FFF9E6; color: #B45309; border: 1px solid #FFECB3; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px;">● On The Way (ETA 10 min)</span>
                </div>
                <div style="font-size: 13px; color: #666; margin-bottom: 6px;">
                    Booking <strong>#FM-10245</strong> • Assigned to <strong>Ali Khan</strong> (Plumber)
                </div>
                <div style="font-size: 12px; color: #888;">
                    Scheduled: Today, Sep 27 • 2:30 PM | Address: House 42-B, Phase 6, DHA
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                <strong style="font-size: 16px; color: #047857;">Rs. 500 – 800</strong>
                <a href="{{ url('/customer/tracking') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 12.5px;">
                    📍 Live Tracking
                </a>
            </div>
        </div>

        <!-- Upcoming Booking #FM-10190 -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center;">
            <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
            
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <strong style="font-size: 17px; color: #111;">AC Master Service & Gas Refill</strong>
                    <span style="background: #EFF6FF; color: #1D4ED8; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Scheduled</span>
                </div>
                <div style="font-size: 13px; color: #666; margin-bottom: 6px;">
                    Booking <strong>#FM-10190</strong> • Assigned to <strong>Imran Shah</strong> (AC Specialist)
                </div>
                <div style="font-size: 12px; color: #888;">
                    Scheduled: Oct 01, 2026 • 2:00 PM | Address: House 42-B, Phase 6, DHA
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                <strong style="font-size: 16px; color: #111;">Rs. 1,800</strong>
                <a href="{{ url('/customer/messages?tech=imran-shah') }}" class="btn-outline" style="padding: 8px 18px; font-size: 12.5px;">
                    💬 Chat Pro
                </a>
            </div>
        </div>

        <!-- Completed Booking #FM-09942 -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center; opacity: 0.9;">
            <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border-color);">
            
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <strong style="font-size: 17px; color: #111;">Breaker Replacement & Short-Circuit Fix</strong>
                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px;">✓ Completed</span>
                </div>
                <div style="font-size: 13px; color: #666; margin-bottom: 6px;">
                    Booking <strong>#FM-09942</strong> • Done by <strong>Riaz Ahmed</strong> (Electrician)
                </div>
                <div style="font-size: 12px; color: #888;">
                    Completed: Sep 18, 2026 • Rating Given: ★★★★★ (5.0)
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                <strong style="font-size: 16px; color: #111;">Rs. 1,200 (Paid)</strong>
                <a href="{{ url('/customer/reviews?booking=FM-09942') }}" class="btn-outline" style="padding: 8px 18px; font-size: 12.5px;">
                    View Invoice
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
