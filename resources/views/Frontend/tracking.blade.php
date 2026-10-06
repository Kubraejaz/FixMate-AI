@extends('Frontend.layouts.master')

@section('title', 'Live Tracking & Booking Details — FixMate')
@section('meta_desc', 'Track technician Ali Khan in real-time on the live GPS map. Booking #FM-10245.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Top Alert & Order Details (Mockup 2) -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span class="badge badge-gold" style="font-size: 12px;">Booking #FM-10245</span>
                <span style="font-size: 13px; font-weight: 700; color: #10B981; background: #ECFDF5; padding: 2px 10px; border-radius: 10px;">
                    ● Technician On the Way
                </span>
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #111;">Live Tracking & Booking Details</h1>
            <p style="font-size: 13.5px; color: #757575;">Plumbing • Sink & Pipe Repair</p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ url('/customer-dashboard') }}" class="btn-outline" style="font-size: 13px; padding: 9px 16px;">
                ← Back to My Bookings
            </a>
            <a href="{{ url('/chat') }}" class="btn-yellow" style="font-size: 13px; padding: 9px 18px;">
                💬 Chat with Ali
            </a>
        </div>
    </div>

    <!-- Stepper Timeline (Exact from Mockup 2) -->
    <div class="card-box" style="margin-bottom: 28px; padding: 20px 30px;">
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; text-align: center;">
            <div>
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #10B981; color: #FFF; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; font-size: 14px; font-weight: 800;">
                    ✓
                </div>
                <span style="display: block; font-size: 12px; font-weight: 700; color: #111;">Booking Placed</span>
                <span style="font-size: 10.5px; color: #888;">10:00 AM</span>
            </div>

            <div>
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #10B981; color: #FFF; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; font-size: 14px; font-weight: 800;">
                    ✓
                </div>
                <span style="display: block; font-size: 12px; font-weight: 700; color: #111;">Accepted</span>
                <span style="font-size: 10.5px; color: #888;">10:02 AM</span>
            </div>

            <div id="stepEnRoute">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #FFCC00; color: #000; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; font-size: 15px; font-weight: 800; box-shadow: 0 0 10px rgba(255,204,0,0.5);">
                    🚗
                </div>
                <span style="display: block; font-size: 12px; font-weight: 800; color: #B45309;">On The Way</span>
                <span style="font-size: 10.5px; color: #10B981; font-weight: 700;">ETA 8 mins</span>
            </div>

            <div id="stepStarted" style="opacity: 0.5;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #E5E7EB; color: #555; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; font-size: 12px; font-weight: 800;">
                    4
                </div>
                <span style="display: block; font-size: 12px; font-weight: 600; color: #555;">Service Started</span>
                <span style="font-size: 10.5px; color: #888;">Arrival OTP</span>
            </div>

            <div id="stepCompleted" style="opacity: 0.5;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #E5E7EB; color: #555; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; font-size: 12px; font-weight: 800;">
                    5
                </div>
                <span style="display: block; font-size: 12px; font-weight: 600; color: #555;">Completed</span>
                <span style="font-size: 10.5px; color: #888;">Verified & Paid</span>
            </div>
        </div>
    </div>

    <!-- Map & Details Split (Mockup 2) -->
    <div style="display: grid; grid-template-columns: 1.35fr 1fr; gap: 28px; align-items: start;">
        
        <!-- Left: Live Map Simulation -->
        <div class="card-box" style="padding: 0; overflow: hidden; border-radius: 24px;">
            <div style="padding: 16px 20px; background: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="width: 10px; height: 10px; border-radius: 50%; background: #10B981;"></span>
                    <strong style="font-size: 13.5px; color: #111;">Live GPS Tracking</strong>
                </div>
                <span style="font-size: 12px; color: #666;">Technician is 2.1 km away</span>
            </div>

            <!-- Vector Map with moving vehicle and route -->
            <div style="height: 380px; background: #EBF2FA; position: relative;">
                <svg width="100%" height="100%" viewBox="0 0 600 380" preserveAspectRatio="none">
                    <rect width="600" height="380" fill="#E8EEF5"/>
                    <rect x="30" y="30" width="140" height="110" rx="10" fill="#E2E8F0" opacity="0.7"/>
                    <rect x="210" y="30" width="180" height="110" rx="10" fill="#E2E8F0" opacity="0.7"/>
                    <rect x="430" y="30" width="140" height="110" rx="10" fill="#E2E8F0" opacity="0.7"/>
                    <rect x="30" y="210" width="220" height="130" rx="10" fill="#E2E8F0" opacity="0.7"/>
                    <rect x="290" y="210" width="280" height="130" rx="10" fill="#E2E8F0" opacity="0.7"/>

                    <!-- Streets -->
                    <line x1="0" y1="170" x2="600" y2="170" stroke="#CBD5E1" stroke-width="22"/>
                    <line x1="0" y1="170" x2="600" y2="170" stroke="#FFFFFF" stroke-width="16"/>
                    <line x1="190" y1="0" x2="190" y2="380" stroke="#CBD5E1" stroke-width="20"/>
                    <line x1="190" y1="0" x2="190" y2="380" stroke="#FFFFFF" stroke-width="14"/>
                    <line x1="410" y1="0" x2="410" y2="380" stroke="#CBD5E1" stroke-width="20"/>
                    <line x1="410" y1="0" x2="410" y2="380" stroke="#FFFFFF" stroke-width="14"/>

                    <!-- Golden Route Path -->
                    <path d="M120 170 L190 170 L190 280 L410 280 L410 170 L490 170" stroke="#FFCC00" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" fill="none" stroke-dasharray="6 4"/>

                    <!-- Destination Pin -->
                    <circle cx="490" cy="170" r="14" fill="#EF4444" opacity="0.2"/>
                    <circle cx="490" cy="170" r="8" fill="#EF4444"/>

                    <!-- Vehicle Icon -->
                    <g transform="translate(190, 230)">
                        <circle cx="0" cy="0" r="18" fill="#FFCC00" opacity="0.35"/>
                        <circle cx="0" cy="0" r="12" fill="#111111"/>
                        <circle cx="0" cy="0" r="4" fill="#FFCC00"/>
                        <rect x="10" y="-12" width="70" height="24" rx="8" fill="#111111"/>
                        <text x="45" y="4" font-family="sans-serif" font-size="10" font-weight="700" fill="#FFCC00" text-anchor="middle">Ali (Pro)</text>
                    </g>
                </svg>
            </div>

            <!-- Bottom ETA bar -->
            <div style="padding: 16px 24px; background: #FFFFFF; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span style="font-size: 11px; font-weight: 700; color: #777; text-transform: uppercase;">Estimated Arrival</span>
                    <strong style="font-size: 17px; color: #111; display: block;" id="etaText">2:50 PM (~8 mins)</strong>
                </div>
                <button type="button" class="btn-yellow" onclick="simulateArrival()" style="padding: 9px 18px; font-size: 13px;" id="btnArrivalSim">
                    Simulate Tech Arrival (Enter OTP)
                </button>
            </div>
        </div>

        <!-- Right: Technician Card & Booking Summary (Mockup 2) -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Assigned Pro Card (Mockup 2) -->
            <div class="card-box" style="padding: 24px;">
                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 16px;">
                    <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <h3 style="font-size: 16px; font-weight: 800; color: #111;">Ali Khan</h3>
                            <span style="color: #10B981; font-size: 13px;">✓ Verified</span>
                        </div>
                        <span style="font-size: 12.5px; color: #555; display: block;">Plumber</span>
                        <div style="font-size: 12px; color: #111; font-weight: 700;">★ 4.8 (247 jobs)</div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 16px;">
                    <a href="tel:+923001234567" class="btn-outline" style="flex: 1; padding: 9px; font-size: 13px;">
                        📞 Call
                    </a>
                    <a href="{{ url('/chat') }}" class="btn-yellow" style="flex: 1; padding: 9px; font-size: 13px;">
                        💬 Chat
                    </a>
                </div>

                <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 12px; padding: 12px; font-size: 12.5px; color: #555;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span>Service:</span>
                        <strong style="color: #111;">Sink / Pipe Repair</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Estimated Cost:</span>
                        <strong style="color: #111;">Rs. 500 – 800</strong>
                    </div>
                </div>
            </div>

            <!-- Arrival OTP Card -->
            <div class="card-box" style="border: 2px solid #FFECB3; background: #FFFDF0; padding: 22px;">
                <span style="font-size: 11px; font-weight: 700; color: #8C6B00; text-transform: uppercase; display: block; margin-bottom: 4px;">
                    SERVICE START CODE
                </span>
                <h4 style="font-size: 15px; font-weight: 800; color: #111; margin-bottom: 6px;">Your 4-Digit Arrival OTP</h4>
                <p style="font-size: 12.5px; color: #666; margin-bottom: 14px;">
                    Share this OTP with Ali Khan only when he physically arrives at your home.
                </p>

                <div style="background: #FFFFFF; border: 2px dashed #FFCC00; border-radius: 14px; padding: 14px; text-align: center;">
                    <strong style="font-size: 32px; font-weight: 900; letter-spacing: 8px; color: #111;">4829</strong>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('extra_js')
<script>
    function simulateArrival() {
        showToast("Ali Khan has arrived at your location! Entered OTP 4829.");
        document.getElementById('stepEnRoute').className = '';
        document.getElementById('stepEnRoute').querySelector('div').style.background = '#10B981';
        document.getElementById('stepEnRoute').querySelector('div').textContent = '✓';
        document.getElementById('stepEnRoute').querySelector('div').style.color = '#FFF';

        document.getElementById('stepStarted').style.opacity = '1';
        document.getElementById('stepStarted').querySelector('div').style.background = '#FFCC00';
        document.getElementById('stepStarted').querySelector('div').textContent = '⚙️';
        document.getElementById('stepStarted').querySelector('div').style.color = '#000';

        document.getElementById('etaText').textContent = "ON-SITE (Repairing Sink)";
        document.getElementById('btnArrivalSim').textContent = "Work In Progress...";
        document.getElementById('btnArrivalSim').disabled = true;
    }
</script>
@endsection
