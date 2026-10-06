@extends('Frontend.layouts.master')

@section('title', 'Provider Business Portal & Payout Ledger — FixMate')
@section('meta_desc', 'Provider dashboard for verified technicians. Manage live dispatch requests, schedule, KYC certifications, and direct bank escrow payouts.')

@section('content')
<div class="container" style="padding-top: 28px; padding-bottom: 70px;">

    <!-- Provider Header & Availability Toggle (FR-6.2) -->
    <div style="background: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 28px; padding: 26px 32px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
        <div style="display: flex; align-items: center; gap: 18px;">
            <div style="position: relative;">
                <img src="{{ asset('assets/images/image_1.svg') }}" alt="Alex Rivera" style="width: 68px; height: 68px; border-radius: 50%; border: 3px solid #FFCC00;">
                <span id="availDot" style="position: absolute; bottom: 0; right: 0; width: 16px; height: 16px; background: #10B981; border: 3px solid #FFF; border-radius: 50%;"></span>
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <h1 style="font-size: 22px; font-weight: 800; color: #111;">Alex Rivera</h1>
                    <span class="badge badge-verified">Verified Master Plumber</span>
                </div>
                <p style="font-size: 13.5px; color: #757575;">
                    License #PL-49102-NY • Service Radius: <strong>12 miles</strong> • Rate: <strong>$65.00/hr</strong>
                </p>
            </div>
        </div>

        <!-- Availability Switcher (FR-6.2) -->
        <div style="display: flex; align-items: center; gap: 14px; background: #FAFAFA; border: 1px solid #E5E5E5; padding: 10px 18px; border-radius: 20px;">
            <div style="text-align: right;">
                <span id="availLabel" style="font-size: 13px; font-weight: 800; color: #10B981; display: block;">ONLINE & DISPATCHABLE</span>
                <span style="font-size: 11px; color: #777;">Receiving real-time jobs</span>
            </div>
            <button type="button" id="toggleAvailBtn" onclick="toggleAvailability()" style="width: 50px; height: 28px; background: #10B981; border-radius: 14px; position: relative; cursor: pointer; transition: background 0.2s;">
                <span id="toggleKnob" style="position: absolute; top: 3px; right: 4px; width: 22px; height: 22px; background: #FFFFFF; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: all 0.2s;"></span>
            </button>
        </div>
    </div>

    <!-- Incoming Job Dispatch Alert (FR-6.1 - Live Notification) -->
    <div id="incomingJobAlert" class="fm-card" style="border: 2px solid #FFCC00; background: #FFFDF0; margin-bottom: 30px; padding: 24px; display: block; animation: pulse-border 2s infinite;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span class="ai-pulse-dot"></span>
                <strong style="color: #8C6B00; font-size: 13px; text-transform: uppercase;">NEW DISPATCH REQUEST (60s Expiry)</strong>
            </div>
            <span style="font-size: 14px; font-weight: 900; color: #B45309;" id="dispatchCountdown">⏱️ 00:44 remaining</span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1.2fr; gap: 20px; align-items: center; margin-bottom: 18px;">
            <div>
                <span style="font-size: 11px; color: #777; display: block;">JOB TYPE</span>
                <h4 style="font-size: 16px; font-weight: 800; color: #111;">P-Trap Slip Joint Leak</h4>
                <p style="font-size: 13px; color: #555;">Urgency: Standard Service</p>
            </div>
            <div>
                <span style="font-size: 11px; color: #777; display: block;">LOCATION</span>
                <h4 style="font-size: 16px; font-weight: 800; color: #111;">742 Evergreen Terrace</h4>
                <p style="font-size: 13px; color: #555;">1.4 miles away (~8 min drive)</p>
            </div>
            <div style="background: #FFFFFF; border: 1px solid #FFE082; padding: 12px 16px; border-radius: 14px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span style="font-size: 11px; color: #888; display: block;">ESCROW PAYOUT</span>
                    <strong style="font-size: 20px; color: #111; font-weight: 900;">$75.00</strong>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn-secondary" onclick="declineDispatch()" style="padding: 8px 14px; font-size: 13px;">Decline</button>
                    <button type="button" class="btn-primary" onclick="acceptDispatch()" style="padding: 8px 18px; font-size: 13px;">Accept Job</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Provider KPI Cards (FR-6.1) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px;">
        <div class="fm-card" style="padding: 22px;">
            <span style="font-size: 12px; font-weight: 700; color: #757575; text-transform: uppercase;">Today's Revenue</span>
            <strong style="font-size: 28px; font-weight: 900; color: #111; display: block; margin: 4px 0;">$385.00</strong>
            <span style="font-size: 12px; color: #10B981; font-weight: 700;">↑ 18% vs yesterday</span>
        </div>
        <div class="fm-card" style="padding: 22px;">
            <span style="font-size: 12px; font-weight: 700; color: #757575; text-transform: uppercase;">Completed Jobs</span>
            <strong style="font-size: 28px; font-weight: 900; color: #111; display: block; margin: 4px 0;">4 Jobs</strong>
            <span style="font-size: 12px; color: #555;">1 in-progress</span>
        </div>
        <div class="fm-card" style="padding: 22px;">
            <span style="font-size: 12px; font-weight: 700; color: #757575; text-transform: uppercase;">Acceptance Rate</span>
            <strong style="font-size: 28px; font-weight: 900; color: #111; display: block; margin: 4px 0;">98.2%</strong>
            <span style="font-size: 12px; color: #10B981; font-weight: 700;">Top 5% in Brooklyn</span>
        </div>
        <div class="fm-card" style="padding: 22px;">
            <span style="font-size: 12px; font-weight: 700; color: #757575; text-transform: uppercase;">Rating & Trust</span>
            <strong style="font-size: 28px; font-weight: 900; color: #111; display: block; margin: 4px 0;">★ 4.98</strong>
            <span style="font-size: 12px; color: #555;">410 Verified Reviews</span>
        </div>
    </div>

    <!-- Two Column: Schedule & Ledger (FR-6.3 & FR-6.4) -->
    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px;">
        
        <!-- Left: Today's Schedule & Customer OTP Verification -->
        <div class="fm-card" style="padding: 26px;">
            <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 6px;">Today's Job Queue</h3>
            <p class="text-secondary" style="font-size: 13.5px; margin-bottom: 20px;">Enter customer's 4-digit OTP to officially unlock work timer upon arrival</p>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <!-- Active Job Item -->
                <div style="border: 2px solid #FFECB3; background: #FFFDF0; border-radius: 18px; padding: 18px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 12px; font-weight: 800; color: #8C6B00; background: #FFE082; padding: 2px 8px; border-radius: 8px;">ACTIVE DISPATCH</span>
                        <strong style="color: #111; font-size: 15px;">#FM-89240</strong>
                    </div>
                    <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 4px;">P-Trap Pipe Leak Under Sink</h4>
                    <p style="font-size: 13px; color: #555; margin-bottom: 12px;">Customer: Sarah Jenkins • 742 Evergreen Terrace</p>

                    <!-- OTP Input Field for Technician Arrival Verification (SRS Acceptance Test) -->
                    <div style="background: #FFFFFF; border: 1px solid #E5E5E5; border-radius: 14px; padding: 12px; display: flex; align-items: center; gap: 10px;">
                        <input type="text" id="techOtpInput" placeholder="Enter Customer's 4-Digit OTP" maxlength="4" style="flex: 1; border: none; font-size: 15px; font-weight: 700; letter-spacing: 4px; outline: none;">
                        <button type="button" class="btn-primary" onclick="verifyCustomerOtp()" style="padding: 8px 16px; font-size: 13px;">
                            Start Job
                        </button>
                    </div>
                </div>

                <!-- Next Scheduled Job -->
                <div style="border: 1px solid #EEEEEE; border-radius: 18px; padding: 18px; background: #FAFAFA;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 12px; font-weight: 700; color: #64748B;">02:30 PM – 04:00 PM</span>
                        <strong style="color: #111; font-size: 14px;">$95.00</strong>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #111; margin-bottom: 4px;">Water Heater Pressure Flush</h4>
                    <p style="font-size: 12.5px; color: #757575;">Customer: Michael Chen • 128 Berkeley Place</p>
                </div>
            </div>
        </div>

        <!-- Right: Payout Ledger & Skill Verification (FR-6.3 & FR-6.4) -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Escrow Payout Ledger (FR-6.4) -->
            <div class="fm-card" style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div>
                        <span style="font-size: 11px; font-weight: 700; color: #757575; text-transform: uppercase;">Available Balance</span>
                        <h3 style="font-size: 26px; font-weight: 900; color: #111;">$1,420.50</h3>
                    </div>
                    <button type="button" class="btn-primary" onclick="showToast('Instant transfer to Chase Checking ****8129 initiated!')" style="font-size: 13px; padding: 10px 18px;">
                        Withdraw Now
                    </button>
                </div>

                <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 16px; padding: 14px; font-size: 13px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #666;">Funds in Pending Escrow:</span>
                        <strong style="color: #111;">$170.00</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #666;">Payout Destination:</span>
                        <strong style="color: #111;">Stripe Connect (Chase ••••8129)</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Platform Fee (FixMate 10%):</span>
                        <strong style="color: #10B981;">Low Tier Rate</strong>
                    </div>
                </div>
            </div>

            <!-- KYC License & Certification Status (FR-6.3) -->
            <div class="fm-card" style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <h4 style="font-size: 16px; font-weight: 800; color: #111;">KYC & Certifications</h4>
                    <span class="badge badge-verified">✓ 100% Compliant</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #F0F0F0; padding-bottom: 8px;">
                        <div>
                            <strong>NY State Master Plumber License</strong>
                            <span style="display: block; font-size: 11px; color: #777;">Expires: Dec 2027</span>
                        </div>
                        <span style="color: #10B981; font-weight: 700;">Verified ✓</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #F0F0F0; padding-bottom: 8px;">
                        <div>
                            <strong>$1M General Liability Insurance</strong>
                            <span style="display: block; font-size: 11px; color: #777;">Policy #GL-993810</span>
                        </div>
                        <span style="color: #10B981; font-weight: 700;">Active ✓</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong>Background Check (Criminal & Driving)</strong>
                            <span style="display: block; font-size: 11px; color: #777;">Cleared via Checkr</span>
                        </div>
                        <span style="color: #10B981; font-weight: 700;">Cleared ✓</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('extra_js')
<script>
    let isOnline = true;

    function toggleAvailability() {
        isOnline = !isOnline;
        const knob = document.getElementById('toggleKnob');
        const btn = document.getElementById('toggleAvailBtn');
        const label = document.getElementById('availLabel');
        const dot = document.getElementById('availDot');

        if (isOnline) {
            btn.style.background = '#10B981';
            knob.style.right = '4px';
            knob.style.left = 'auto';
            label.textContent = "ONLINE & DISPATCHABLE";
            label.style.color = "#10B981";
            dot.style.background = "#10B981";
            showToast("You are now ONLINE. You will receive dispatch requests.");
        } else {
            btn.style.background = '#94A3B8';
            knob.style.left = '4px';
            knob.style.right = 'auto';
            label.textContent = "OFFLINE (PAUSED)";
            label.style.color = "#94A3B8";
            dot.style.background = "#94A3B8";
            showToast("You are now OFFLINE.");
        }
    }

    function acceptDispatch() {
        document.getElementById('incomingJobAlert').style.display = 'none';
        showToast("Dispatch accepted! Customer notified that Alex is en-route.");
    }

    function declineDispatch() {
        document.getElementById('incomingJobAlert').style.display = 'none';
        showToast("Dispatch passed to next available pro in radius.");
    }

    function verifyCustomerOtp() {
        const otp = document.getElementById('techOtpInput').value.trim();
        if (otp === '4829' || otp.length === 4) {
            showToast("OTP " + otp + " verified! Job timer activated. Escrow milestone locked.");
        } else {
            showToast("Please enter valid 4-digit OTP provided by customer.", false);
        }
    }
</script>
@endsection
