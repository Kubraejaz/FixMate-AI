@extends('Frontend.layouts.customer')

@section('title', 'Schedule Service Booking — FixMate AI')

@section('content')
<div style="max-width: 840px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Confirm Your Booking</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Select your preferred time slot and confirm visit address.</p>
    </div>

    <form action="{{ url('/customer/payment') }}" method="GET">
        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 24px; align-items: flex-start;">
            
            <!-- Left: Schedule & Address Form -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- Selected Professional -->
                <div class="portal-card" style="padding: 20px; background: #FFFFFF; display: flex; align-items: center; gap: 16px;">
                    <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 15px; color: #111;">Ali Khan</strong>
                        <span style="font-size: 12.5px; color: #666;">Master Plumber • 4.9 ★ (247 jobs)</span>
                    </div>
                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px;">Assigned Pro</span>
                </div>

                <!-- Select Date & Time Slot (Matching Mockup 2 & 3) -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Select Date & Time</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 16px;">
                        <label style="border: 2px solid #FFCC00; background: #FFFDF0; padding: 10px; border-radius: 10px; text-align: center; cursor: pointer;">
                            <input type="radio" name="booking_date" checked style="display: none;">
                            <strong style="display: block; font-size: 13px; color: #111;">Today</strong>
                            <span style="font-size: 11px; color: #666;">Sep 27</span>
                        </label>
                        <label style="border: 1px solid var(--border-color); background: #FFF; padding: 10px; border-radius: 10px; text-align: center; cursor: pointer;">
                            <input type="radio" name="booking_date" style="display: none;">
                            <strong style="display: block; font-size: 13px; color: #111;">Tomorrow</strong>
                            <span style="font-size: 11px; color: #666;">Sep 28</span>
                        </label>
                        <label style="border: 1px solid var(--border-color); background: #FFF; padding: 10px; border-radius: 10px; text-align: center; cursor: pointer;">
                            <input type="radio" name="booking_date" style="display: none;">
                            <strong style="display: block; font-size: 13px; color: #111;">Sunday</strong>
                            <span style="font-size: 11px; color: #666;">Sep 29</span>
                        </label>
                    </div>

                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 6px;">Available Time Slots</label>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                        <button type="button" class="btn-yellow" style="padding: 8px 0; font-size: 12px; border-radius: 6px;">2:30 PM - 3:30 PM</button>
                        <button type="button" class="btn-outline" style="padding: 8px 0; font-size: 12px; border-radius: 6px;">4:00 PM - 5:00 PM</button>
                        <button type="button" class="btn-outline" style="padding: 8px 0; font-size: 12px; border-radius: 6px;">6:00 PM - 7:00 PM</button>
                    </div>
                </div>

                <!-- Service Address -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 14px;">Service Address</h3>
                    
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Street & House Number</label>
                        <input type="text" class="form-input" value="House 42-B, Street 18, Phase 6, DHA" required style="padding: 10px 12px; font-size: 13.5px;">
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Instructions for Technician</label>
                        <input type="text" class="form-input" placeholder="e.g. Ring the bell on gate 2, second floor" value="Gate is open, kitchen is on the right." style="padding: 10px 12px; font-size: 13.5px;">
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary -->
            <div class="portal-card" style="padding: 24px; background: #FFFFFF; position: sticky; top: 100px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Booking Summary</h3>

                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13.5px; margin-bottom: 18px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Service</span>
                        <strong style="color: #111;">Plumbing — Sink Repair</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Diagnosis Severity</span>
                        <strong style="color: #047857;">Normal (Leakage)</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Inspection Base Rate</span>
                        <strong style="color: #111;">Rs. 500</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Est. Parts & Labor Range</span>
                        <strong style="color: #111;">Rs. 500 – 800</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Platform Trust Fee</span>
                        <strong style="color: #10B981;">FREE (Rs. 0)</strong>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 14px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-size: 14px; font-weight: 800; color: #111;">Estimated Total</span>
                        <strong style="font-size: 20px; font-weight: 900; color: #047857;">Rs. 500 – 800</strong>
                    </div>
                    <span style="font-size: 11px; color: #888; display: block; margin-top: 4px;">Pay securely after service OTP verification</span>
                </div>

                <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px; margin-bottom: 12px;">
                    Proceed to Payment →
                </button>

                <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 11.5px; color: #059669;">
                    <span>🛡️ 30-Day FixMate Warranty Included</span>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection
