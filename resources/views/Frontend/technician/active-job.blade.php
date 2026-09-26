@extends('Frontend.layouts.technician')

@section('title', 'Active Service Execution & Customer OTP — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <!-- Active Status Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Active Job #FM-10245</h1>
            <span style="font-size: 13.5px; color: #666;">Customer: Ahmed Khan • DHA Phase 6, Karachi</span>
        </div>
        <span style="background: #FFF9E6; color: #B45309; border: 1px solid #FFECB3; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px;">
            ● Service In Progress
        </span>
    </div>

    <!-- Job Lifecycle Stepper State Machine (SRS Provider Lifecycle) -->
    <div class="portal-card" style="padding: 20px; background: #FFFFFF; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; text-align: center;">
            <div style="flex: 1;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">✓</div>
                <strong style="font-size: 12px; color: #111; display: block;">1. Accepted</strong>
            </div>
            <div style="flex: 1;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">✓</div>
                <strong style="font-size: 12px; color: #111; display: block;">2. En Route</strong>
            </div>
            <div style="flex: 1;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">✓</div>
                <strong style="font-size: 12px; color: #111; display: block;">3. Arrived</strong>
            </div>
            <div style="flex: 1;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #FFCC00; color: #000; font-size: 12px; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; box-shadow: 0 0 0 4px rgba(255,204,0,0.3);">●</div>
                <strong style="font-size: 12px; color: #B45309; display: block;">4. Verify OTP</strong>
            </div>
            <div style="flex: 1; opacity: 0.5;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #E5E7EB; color: #666; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">5</div>
                <strong style="font-size: 12px; color: #666; display: block;">5. In Progress</strong>
            </div>
            <div style="flex: 1; opacity: 0.5;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #E5E7EB; color: #666; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">6</div>
                <strong style="font-size: 12px; color: #666; display: block;">6. Completed</strong>
            </div>
        </div>
    </div>

    <!-- Two-Factor Arrival OTP Input Card (SRS Requirement) -->
    <div class="portal-card" style="padding: 32px; background: #FFFFFF; margin-bottom: 24px; border: 2px solid #FFCC00;">
        <div style="text-align: center; max-width: 480px; margin: 0 auto;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px auto;">
                🔐
            </div>
            <h3 style="font-size: 20px; font-weight: 900; color: #111; margin-bottom: 6px;">Customer Handshake OTP</h3>
            <p style="font-size: 13.5px; color: #666; line-height: 1.5; margin-bottom: 20px;">
                Ask the customer <strong>Ahmed Khan</strong> for their 4-digit arrival OTP shown on their phone screen to unlock the job.
            </p>

            <form action="{{ url('/technician/active-job?verified=1') }}" method="GET">
                <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px;">
                    <input type="text" maxlength="1" value="5" class="form-input" style="width: 50px; height: 54px; text-align: center; font-size: 22px; font-weight: 900;">
                    <input type="text" maxlength="1" value="8" class="form-input" style="width: 50px; height: 54px; text-align: center; font-size: 22px; font-weight: 900;">
                    <input type="text" maxlength="1" value="2" class="form-input" style="width: 50px; height: 54px; text-align: center; font-size: 22px; font-weight: 900;">
                    <input type="text" maxlength="1" value="9" class="form-input" style="width: 50px; height: 54px; text-align: center; font-size: 22px; font-weight: 900;">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn-yellow" style="flex: 1; padding: 12px 0; font-size: 14px; font-weight: 900; border-radius: 10px;">
                        ✓ Verify OTP & Start Service
                    </button>
                    <a href="{{ url('/technician/earnings') }}" class="btn-outline" style="padding: 12px 20px; font-size: 13.5px;">
                        Finish & Release Escrow
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Problem & Quick Navigation Card -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <h4 style="font-size: 14px; font-weight: 800; color: #111; margin-bottom: 8px;">Customer Contact</h4>
            <div style="font-size: 13px; color: #555; line-height: 1.6;">
                <strong>Ahmed Khan</strong><br>
                📞 +92 300 1234567<br>
                📍 House 42-B, Street 18, Phase 6, DHA
            </div>
            <div style="display: flex; gap: 8px; margin-top: 10px;">
                <a href="tel:03001234567" class="btn-outline" style="padding: 6px 14px; font-size: 12px;">Call</a>
                <a href="{{ url('/technician/messages?client=ahmed-khan') }}" class="btn-yellow" style="padding: 6px 14px; font-size: 12px;">Chat</a>
            </div>
        </div>

        <div>
            <h4 style="font-size: 14px; font-weight: 800; color: #111; margin-bottom: 8px;">Job Summary</h4>
            <div style="font-size: 13px; color: #555; line-height: 1.6;">
                🔧 Kitchen Sink P-Trap Leakage<br>
                💵 Est. Payment: <strong>Rs. 500 – 800</strong><br>
                🛡️ FixMate Escrow Protection Active
            </div>
        </div>
    </div>

</div>
@endsection
