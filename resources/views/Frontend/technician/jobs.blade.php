@extends('Frontend.layouts.technician')

@section('title', 'My Jobs & Dispatched Requests — FixMate AI')

@section('content')
<div>
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Jobs</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Manage your active dispatches, upcoming appointments, and job history.</p>
    </div>

    <!-- Tabs matching Mockup 2: Pending, Accepted, In Progress, Completed -->
    <div style="display: flex; gap: 10px; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
        <button class="btn-yellow" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">All Jobs (4)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Pending Request (1)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">In Progress (1)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Completed (2)</button>
    </div>

    <!-- Jobs Cards List matching Mockup 2 -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        
        <!-- Job 1 (Incoming / Pending) -->
        <div class="portal-card" style="padding: 20px 24px; background: #FFFDF0; border: 2px solid #FFCC00; display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: center;">
            <img src="{{ asset('assets/images/image_6.png') }}" style="width: 70px; height: 70px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <strong style="font-size: 16px; color: #111;">Kitchen Sink Leakage (#FM-10245)</strong>
                    <span style="background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">Pending Acceptance</span>
                </div>
                <div style="font-size: 13px; color: #666; margin-bottom: 4px;">
                    Customer: <strong>Ayesha Khan</strong> • 📍 Phase 6, DHA (2.1 km away)
                </div>
                <div style="font-size: 12px; color: #777;">
                    Slot: Today, Sep 27 • 2:30 PM | AI Severity: Normal | Est: Rs. 500 – 800
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ url('/technician/jobs/FM-10245') }}" class="btn-outline" style="padding: 8px 16px; font-size: 13px;">Details</a>
                <a href="{{ url('/technician/active-job') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px;">Accept Job</a>
            </div>
        </div>

        <!-- Job 2 (In Progress) -->
        <div class="portal-card" style="padding: 20px 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: center; border-left: 5px solid #10B981;">
            <div style="width: 70px; height: 70px; border-radius: 12px; background: #EFF6FF; border: 1px solid #DBEAFE; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                🔧
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <strong style="font-size: 16px; color: #111;">Drain Unclog & Motor Valve (#FM-10220)</strong>
                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">In Progress</span>
                </div>
                <div style="font-size: 13px; color: #666; margin-bottom: 4px;">
                    Customer: <strong>Zubair M.</strong> • 📍 Clifton Block 2 (3.8 km away)
                </div>
                <div style="font-size: 12px; color: #777;">
                    Slot: Today • 5:00 PM | Agreed Rate: Rs. 1,200
                </div>
            </div>
            <div>
                <a href="{{ url('/technician/active-job') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px;">View State</a>
            </div>
        </div>

        <!-- Job 3 (Completed) -->
        <div class="portal-card" style="padding: 20px 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: center; opacity: 0.85;">
            <div style="width: 70px; height: 70px; border-radius: 12px; background: #F3F4F6; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                ✓
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <strong style="font-size: 16px; color: #111;">Bathroom Sanitary Replacement (#FM-09942)</strong>
                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">✓ Completed</span>
                </div>
                <div style="font-size: 13px; color: #666; margin-bottom: 4px;">
                    Customer: <strong>Sara Ahmed</strong> • Payout: Rs. 2,100 (Released to Wallet)
                </div>
                <div style="font-size: 12px; color: #777;">
                    Rated: ★★★★★ (5.0) • Sep 25, 2026
                </div>
            </div>
            <div>
                <span style="font-size: 12px; color: #059669; font-weight: 700;">Paid</span>
            </div>
        </div>

    </div>

</div>
@endsection
