@extends('Frontend.layouts.master')

@section('title', 'Book Master Plumbing Service — FixMate AI')
@section('meta_desc', 'Schedule guaranteed P-Trap & Pipe Leak Repair with verified technician Alex Rivera. Real-time GPS tracking and 100% escrow protection.')

@section('content')
<div class="container" style="padding-top: 28px; padding-bottom: 70px;">

    <!-- Breadcrumbs -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 20px;">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <a href="{{ url('/services') }}">Plumbing</a>
        <span>/</span>
        <span style="color: #111111; font-weight: 600;">Pipe Leak & P-Trap Repair</span>
    </div>

    <!-- Booking Overview Grid -->
    <div style="display: grid; grid-template-columns: 1.25fr 1fr; gap: 36px; align-items: start;">

        <!-- Left Column: Service Details & Schedule Flow (FR-3.3, FR-3.4) -->
        <div>
            <!-- Banner / Hero Media -->
            <div style="position: relative; border-radius: 28px; overflow: hidden; margin-bottom: 24px; border: 1px solid #EEEEEE;">
                <img src="{{ asset('assets/images/image_3.svg') }}" alt="Plumbing service" style="width: 100%; height: 260px; object-fit: cover;">
                <div style="position: absolute; top: 16px; left: 16px; background: rgba(17,17,17,0.85); backdrop-filter: blur(8px); color: #FFF; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                    🛡️ Escrow Guaranteed
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <span class="badge badge-gold">Master Plumbing</span>
                    <span style="font-size: 13px; color: #10B981; font-weight: 700;">✓ Available for Dispatch Today</span>
                </div>
                <h1 style="font-size: 28px; font-weight: 800; color: #111; margin-bottom: 8px;">
                    P-Trap & Pipe Leak Repair (Emergency / Scheduled)
                </h1>
                <p class="text-secondary" style="font-size: 15px; line-height: 1.6;">
                    Certified diagnostic and repair for under-sink joint leaks, corrosion, seal failures, and drainage clogs. All services performed by state-licensed technicians using code-compliant materials.
                </p>
            </div>

            <!-- What's Included (Checklist) -->
            <div class="fm-card" style="margin-bottom: 24px; padding: 22px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 14px;">What's Included in this Service</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13.5px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>Complete video & pressure inspection</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>Slip-joint O-ring & gasket replacement</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>Teflon thread sealing & clamp tightening</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>60-Day Re-work Escrow Warranty</span>
                    </div>
                </div>
            </div>

            <!-- 1. Select Date & Time Slot (FR-3.3) -->
            <div class="fm-card" style="margin-bottom: 24px; padding: 22px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 6px;">1. Choose Date & Arrival Window</h3>
                <p class="text-secondary" style="font-size: 13px; margin-bottom: 16px;">Provider calendar synchronized in real-time</p>

                <!-- Date selector tabs -->
                <div style="display: flex; gap: 10px; margin-bottom: 16px; overflow-x: auto;">
                    <button type="button" class="btn-secondary" style="background: #FFF9E6; border-color: #FFCC00; padding: 10px 18px; text-align: center; border-radius: 16px;">
                        <span style="display: block; font-size: 11px; text-transform: uppercase; color: #8C6B00; font-weight: 700;">Today</span>
                        <strong style="font-size: 15px; color: #111;">Sept 26</strong>
                    </button>
                    <button type="button" class="btn-secondary" style="padding: 10px 18px; text-align: center; border-radius: 16px;">
                        <span style="display: block; font-size: 11px; text-transform: uppercase; color: #777; font-weight: 700;">Sun</span>
                        <strong style="font-size: 15px; color: #111;">Sept 27</strong>
                    </button>
                    <button type="button" class="btn-secondary" style="padding: 10px 18px; text-align: center; border-radius: 16px;">
                        <span style="display: block; font-size: 11px; text-transform: uppercase; color: #777; font-weight: 700;">Mon</span>
                        <strong style="font-size: 15px; color: #111;">Sept 28</strong>
                    </button>
                    <button type="button" class="btn-secondary" style="padding: 10px 18px; text-align: center; border-radius: 16px;">
                        <span style="display: block; font-size: 11px; text-transform: uppercase; color: #777; font-weight: 700;">Tue</span>
                        <strong style="font-size: 15px; color: #111;">Sept 29</strong>
                    </button>
                </div>

                <!-- Time slot buttons -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px;">
                    <button type="button" class="btn-secondary" style="background: #FFF9E6; border-color: #FFCC00; font-size: 13px; font-weight: 700; padding: 10px;">
                        ⚡ Urgent (&lt;45m)
                    </button>
                    <button type="button" class="btn-secondary" style="font-size: 13px; padding: 10px;">
                        02:00 PM – 04:00 PM
                    </button>
                    <button type="button" class="btn-secondary" style="font-size: 13px; padding: 10px;">
                        04:00 PM – 06:00 PM
                    </button>
                    <button type="button" class="btn-secondary" style="font-size: 13px; padding: 10px;">
                        Evening (06:00 PM+)
                    </button>
                </div>
            </div>

            <!-- 2. Address & Geolocation Map Picker (FR-3.4) -->
            <div class="fm-card" style="padding: 22px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 6px;">2. Service Location</h3>
                <p class="text-secondary" style="font-size: 13px; margin-bottom: 14px;">Where should the technician arrive?</p>

                <div style="display: flex; gap: 10px; margin-bottom: 14px;">
                    <div style="flex: 1; position: relative;">
                        <input type="text" value="742 Evergreen Terrace, Brooklyn, NY 11201" style="width: 100%; border: 1px solid #DCDCDC; border-radius: 16px; padding: 12px 14px 12px 38px; font-size: 14px; font-weight: 600; color: #111; outline: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FFCC00" stroke-width="2.5" style="position: absolute; left: 14px; top: 15px;">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <button type="button" class="btn-secondary" style="padding: 10px 16px; font-size: 13px;" onclick="showToast('GPS Pin synchronized')">
                        Current GPS
                    </button>
                </div>

                <!-- Simulated Location Map Snippet -->
                <div style="border-radius: 16px; overflow: hidden; height: 120px; background: #E2E8F0; position: relative; border: 1px solid #CBD5E1;">
                    <!-- Map background graphics -->
                    <svg width="100%" height="100%" viewBox="0 0 500 120" preserveAspectRatio="none">
                        <rect width="500" height="120" fill="#E2E8F0"/>
                        <path d="M0 40 Q250 80 500 30" stroke="#CBD5E1" stroke-width="12" fill="none"/>
                        <path d="M150 0 L150 120 M350 0 L350 120" stroke="#CBD5E1" stroke-width="8"/>
                        <!-- Target Pin -->
                        <circle cx="260" cy="55" r="10" fill="#EF4444" opacity="0.3"/>
                        <circle cx="260" cy="55" r="5" fill="#EF4444"/>
                    </svg>
                    <div style="position: absolute; bottom: 8px; right: 12px; background: rgba(255,255,255,0.9); padding: 3px 8px; border-radius: 8px; font-size: 11px; font-weight: 600; color: #333;">
                        Brooklyn, NY • Geolocation confirmed
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Assigned Tech, Payment Gateway & Escrow Checkout (FR-3.5) -->
        <div style="position: sticky; top: 96px;">
            <div class="fm-card" style="padding: 26px; border: 2px solid #FFECB3; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #EEEEEE;">
                    <div>
                        <span style="font-size: 11px; font-weight: 700; color: #8C6B00; text-transform: uppercase;">Guaranteed Upfront Pricing</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: #111;">Booking Summary</h3>
                    </div>
                    <span class="badge badge-verified">Escrow Hold</span>
                </div>

                <!-- Assigned Technician Preview -->
                <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 18px; padding: 14px; display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <img src="{{ asset('assets/images/image_1.svg') }}" alt="Alex Rivera" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #FFCC00;">
                    <div style="flex: 1;">
                        <h4 style="font-size: 14.5px; font-weight: 700; color: #111;">Alex Rivera (Assigned Pro)</h4>
                        <p style="font-size: 12px; color: #757575;">Master Plumber • 410 Reviews (★ 4.98)</p>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #10B981; background: #ECFDF5; padding: 3px 8px; border-radius: 8px;">1.4 mi</span>
                </div>

                <!-- Price Breakdown Line Items -->
                <div style="font-size: 13.5px; display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Labor & Diagnosis (1 hr)</span>
                        <span style="font-weight: 700; color: #111;">$65.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">PVC Gasket & Fitting Kit Deposit</span>
                        <span style="font-weight: 700; color: #111;">$10.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Escrow Protection & Warranty Fee</span>
                        <span style="font-weight: 700; color: #10B981;">FREE ($0)</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-top: 1px dashed #DCDCDC; padding-top: 10px; font-size: 16px;">
                        <strong style="color: #111;">Total Escrow Authorization:</strong>
                        <strong style="color: #111; font-size: 20px;">$75.00</strong>
                    </div>
                </div>

                <!-- Payment Methods (FR-3.5: Stripe / Escrow / Cards / Apple Pay / Google Pay / Cash on Delivery) -->
                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #757575; margin-bottom: 8px;">
                        Select Payment Method
                    </label>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="display: flex; align-items: center; justify-content: space-between; background: #FFF9E6; border: 1.5px solid #FFCC00; border-radius: 14px; padding: 10px 14px; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="paymentMethod" checked>
                                <span style="font-size: 13.5px; font-weight: 700; color: #111;">💳 Credit / Debit Card (Stripe Escrow)</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 700; color: #8C6B00;">Recommended</span>
                        </label>
                        <label style="display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 14px; padding: 10px 14px; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="paymentMethod">
                                <span style="font-size: 13.5px; font-weight: 600; color: #111;"> Apple Pay / Google Pay</span>
                            </div>
                            <span style="font-size: 11px; color: #777;">1-Touch</span>
                        </label>
                        <label style="display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 14px; padding: 10px 14px; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="paymentMethod">
                                <span style="font-size: 13.5px; font-weight: 600; color: #111;">💵 Cash on Delivery (After OTP Check)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Escrow Notice Box -->
                <div style="background: #F8FAFC; border-radius: 14px; padding: 12px; margin-bottom: 20px; font-size: 12px; color: #555; line-height: 1.4;">
                    🔒 <strong>Funds Protected:</strong> Your card is only pre-authorized. Funds are held in escrow and released to the technician only after you verify the job with your 4-digit arrival OTP and completion sign-off.
                </div>

                <!-- Confirm Button Trigger -->
                <a href="{{ url('/tracking') }}" class="btn-primary" style="width: 100%; padding: 14px 20px; font-size: 15px; justify-content: center; margin-bottom: 12px;">
                    <span>Authorize Escrow & Dispatch Pro ($75.00)</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>

                <p style="text-align: center; font-size: 11.5px; color: #888;">
                    Free cancellation up to 30 mins before arrival • No surprise fees
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
