@extends('Frontend.layouts.technician')

@section('title', 'Weekly Schedule & Calendar — FixMate AI')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Schedule & Bookings</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">View today's calendar and manage time slots for upcoming service dispatches.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn-yellow" style="padding: 8px 16px; font-size: 13px;">Today (Sep 27)</button>
            <button class="btn-outline" style="padding: 8px 16px; font-size: 13px;">Weekly View</button>
        </div>
    </div>

    <!-- Day Schedule Timeline Card -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 20px;">Today's Timeline (Saturday, September 27)</h3>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Slot 1 -->
            <div style="display: grid; grid-template-columns: 100px 1fr auto; gap: 20px; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
                <div style="font-size: 13px; font-weight: 800; color: #111;">
                    10:00 AM<br>
                    <span style="font-size: 11px; color: #888; font-weight: normal;">11:00 AM</span>
                </div>
                <div>
                    <strong style="font-size: 14.5px; color: #111; display: block;">Bathroom Sanitary Inspection (#FM-10188)</strong>
                    <span style="font-size: 12.5px; color: #666;">Customer: Tariq J. • DHA Phase 5 • Fee: Rs. 1,000</span>
                </div>
                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 8px;">✓ Done</span>
            </div>

            <!-- Slot 2 (Current) -->
            <div style="display: grid; grid-template-columns: 100px 1fr auto; gap: 20px; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 16px; background: #FFFDF0; border-radius: 10px; padding: 12px 14px;">
                <div style="font-size: 13px; font-weight: 800; color: #B45309;">
                    2:30 PM<br>
                    <span style="font-size: 11px; color: #B45309; font-weight: normal;">3:30 PM</span>
                </div>
                <div>
                    <strong style="font-size: 14.5px; color: #111; display: block;">Kitchen Sink P-trap Leak (#FM-10245)</strong>
                    <span style="font-size: 12.5px; color: #666;">Customer: Ahmed Khan • DHA Phase 6 • Est: Rs. 500 – 800</span>
                </div>
                <a href="{{ url('/technician/active-job') }}" class="btn-yellow" style="padding: 6px 14px; font-size: 12px;">Active Now →</a>
            </div>

            <!-- Slot 3 -->
            <div style="display: grid; grid-template-columns: 100px 1fr auto; gap: 20px; align-items: center; padding-top: 4px;">
                <div style="font-size: 13px; font-weight: 800; color: #666;">
                    5:00 PM<br>
                    <span style="font-size: 11px; color: #888; font-weight: normal;">6:30 PM</span>
                </div>
                <div>
                    <strong style="font-size: 14.5px; color: #111; display: block;">Drain Unblock & Motor Seal (#FM-10220)</strong>
                    <span style="font-size: 12.5px; color: #666;">Customer: Zubair M. • Clifton Block 2 • Fee: Rs. 1,200</span>
                </div>
                <span style="background: #EFF6FF; color: #1D4ED8; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 8px;">Upcoming</span>
            </div>

        </div>
    </div>

</div>
@endsection
