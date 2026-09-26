@extends('Frontend.layouts.technician')

@section('title', 'Technician Dashboard — FixMate AI Partner Portal')

@section('content')
<div>
    
    <!-- Welcome Header matching Mockup 2 & 3 -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Good Morning, Ali</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">You have 1 active dispatched job and 1 incoming request nearby.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 12px; color: #666;">Current Status:</span>
            <span style="background: #ECFDF5; color: #047857; font-weight: 800; font-size: 12px; padding: 4px 12px; border-radius: 20px; border: 1px solid #A7F3D0;">
                ● Online & Receiving Requests
            </span>
        </div>
    </div>

    <!-- 4 Stats Cards matching Mockup 2 & 3 -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
        
        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Today's Jobs</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">3</strong>
                <span style="font-size: 11px; background: #FFFBEB; color: #B45309; font-weight: 800; padding: 2px 8px; border-radius: 12px;">1 In Progress</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Today's Earnings</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 26px; font-weight: 900; color: #111;">Rs. 4,950</strong>
                <span style="font-size: 11px; color: #059669; font-weight: 700;">+18% vs avg</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Pending Escrow</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 26px; font-weight: 900; color: #B45309;">Rs. 12,490</strong>
                <span style="font-size: 11px; background: #FEF3C7; color: #92400E; font-weight: 800; padding: 2px 8px; border-radius: 12px;">In Escrow</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Customer Rating</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">4.9 ★</strong>
                <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Top Rated</span>
            </div>
        </div>

    </div>

    <!-- Incoming Urgent Job Request Alert (Matching Mockup 2 & 3 Dispatch Machine) -->
    <div class="portal-card" style="padding: 24px 28px; background: #FFFDF0; border: 2px solid #FFCC00; border-radius: 18px; margin-bottom: 28px; box-shadow: 0 8px 24px rgba(255, 204, 0, 0.15);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="background: #DC2626; color: #FFF; font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">New Request</span>
                <span style="font-size: 13px; color: #666;">Expires in <strong style="color: #DC2626;" id="timer60">52s</strong></span>
            </div>
            <span style="font-size: 12px; color: #888;">AI Match Score: <strong style="color: #047857;">98%</strong></span>
        </div>

        <div style="display: grid; grid-template-columns: 80px 1fr auto; gap: 20px; align-items: center;">
            <img src="{{ asset('assets/images/image_6.png') }}" alt="Problem Photo" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
            
            <div>
                <h3 style="font-size: 18px; font-weight: 900; color: #111; margin: 0 0 4px 0;">Kitchen Sink Leakage</h3>
                <div style="font-size: 13px; color: #555; margin-bottom: 6px;">
                    Customer: <strong>Ayesha Khan</strong> • 📍 Phase 6, DHA (2.1 km away)
                </div>
                <div style="display: flex; gap: 12px; font-size: 12px; color: #666;">
                    <span>🤖 AI Detection: <strong>P-trap seal leak</strong></span>
                    <span>⏱️ Est Duration: <strong>45 mins</strong></span>
                    <span style="color: #047857; font-weight: 800;">Est. Payout: <strong>Rs. 500 – 800</strong></span>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="{{ url('/technician/jobs/FM-10245') }}" class="btn-outline" style="padding: 10px 18px; font-size: 13px;">View Details</a>
                <button class="btn-outline" style="padding: 10px 16px; font-size: 13px; border-color: #EF4444; color: #DC2626;">Reject</button>
                <a href="{{ url('/technician/active-job') }}" class="btn-yellow" style="padding: 10px 24px; font-size: 13.5px; font-weight: 800;">
                    Accept Job
                </a>
            </div>
        </div>

    </div>

    <!-- Two Columns: Active Job & Recent Completed Jobs -->
    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px;">
        
        <!-- Left: Today's Active Job State -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0;">Currently En Route</h3>
                <span style="font-size: 11px; background: #FFF9E6; color: #B45309; font-weight: 800; padding: 2px 8px; border-radius: 10px;">In Progress</span>
            </div>

            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 18px; margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                    <strong style="font-size: 15px; color: #111;">Sink Repair & Valve Fitting</strong>
                    <span style="font-size: 12px; color: #1D4ED8; font-weight: 700;">#FM-10245</span>
                </div>
                <p style="font-size: 13px; color: #666; margin-bottom: 12px;">
                    Customer: Ahmed Khan • House 42-B, Street 18, Phase 6, DHA
                </p>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 12px;">
                    <span style="font-size: 12px; color: #888;">Handshake OTP Required upon arrival</span>
                    <a href="{{ url('/technician/active-job') }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px;">
                        Open Active Job Screen →
                    </a>
                </div>
            </div>

            <div style="text-align: right;">
                <a href="{{ url('/technician/schedule') }}" style="font-size: 13px; color: #111; font-weight: 700; text-decoration: none;">View Day Schedule (3 appointments) →</a>
            </div>
        </div>

        <!-- Right: Payouts & Verification Status Card -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- KYC Badge Card -->
            <div class="portal-card" style="padding: 20px; background: #FFFFFF; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #ECFDF5; border: 1px solid #A7F3D0; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        🛡️
                    </div>
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">NADRA Verification Active</strong>
                        <span style="font-size: 11.5px; color: #047857; font-weight: 700;">Verified Trade Pro • 5-Star Partner</span>
                    </div>
                </div>
                <a href="{{ url('/technician/verification') }}" class="btn-outline" style="padding: 5px 12px; font-size: 11.5px;">View Docs</a>
            </div>

            <!-- Earnings Ticker Card -->
            <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px;">
                    <span style="font-size: 13px; color: #666;">Available for Bank Payout</span>
                    <strong style="font-size: 22px; color: #111;">Rs. 48,750</strong>
                </div>
                <a href="{{ url('/technician/earnings') }}" class="btn-yellow" style="display: block; text-align: center; padding: 10px 0; font-size: 13.5px; font-weight: 800;">
                    Withdraw to JazzCash / Bank
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
