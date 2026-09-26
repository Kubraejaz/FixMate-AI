@extends('Frontend.layouts.master')

@section('title', 'Booking Details — FixMate AI')
@section('meta_desc', 'Confirm booking details with verified technician Ali Khan. Escrow protected with upfront pricing.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px; display: flex; justify-content: center;">

    <!-- Booking Details Card (Exact matching Mockup 1 & 2) -->
    <div class="card-box" style="width: 100%; max-width: 580px; padding: 36px;">
        
        <div style="margin-bottom: 22px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span style="font-size: 12px; font-weight: 700; color: #8C6B00; background: #FFF9E6; border: 1px solid #FFECB3; padding: 2px 8px; border-radius: 6px;">STEP 3 OF 3</span>
                <span style="font-size: 12px; color: #757575;">Booking Checkout</span>
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #111; margin-bottom: 4px;">Booking Details</h1>
            <p style="font-size: 13.5px; color: #757575;">Review appointment time, address, and upfront escrow authorization.</p>
        </div>

        <form action="{{ url('/booking-confirmation') }}" method="GET">
            
            <!-- Assigned Technician Preview -->
            <div style="background: #FAFAFA; border: 1px solid var(--border-color); border-radius: 16px; padding: 16px; display: flex; align-items: center; gap: 14px; margin-bottom: 20px;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <strong style="font-size: 15px; color: #111;">Ali Khan</strong>
                        <span style="color: #10B981; font-size: 13px;">✓ Verified Plumber</span>
                    </div>
                    <span style="font-size: 12px; color: #666; display: block;">Kitchen Sink & Pipe Leak Specialist</span>
                    <span style="font-size: 12px; font-weight: 700; color: #111;">★ 4.8 (247 jobs)</span>
                </div>
            </div>

            <!-- Date & Time Picker (Mockup 1) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px;">
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #111; margin-bottom: 6px;">Date</label>
                    <input type="text" value="Today, 26 Sep 2026" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 10px; padding: 10px 12px; font-size: 13.5px; font-weight: 600; outline: none; background: #FFF;">
                </div>
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #111; margin-bottom: 6px;">Time Window</label>
                    <select style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 10px; padding: 10px 12px; font-size: 13.5px; font-weight: 600; outline: none; background: #FFF;">
                        <option>3:00 PM – 4:00 PM (Earliest)</option>
                        <option>4:00 PM – 5:00 PM</option>
                        <option>5:00 PM – 6:00 PM</option>
                    </select>
                </div>
            </div>

            <!-- Location -->
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #111; margin-bottom: 6px;">Location</label>
                <input type="text" value="House #42, Street 8, Phase 5, DHA, Karachi" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 10px; padding: 10px 12px; font-size: 13.5px; outline: none;">
            </div>

            <!-- Estimated Cost -->
            <div style="background: #FFFDF0; border: 1px solid #FFECB3; border-radius: 14px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <div>
                    <span style="font-size: 11px; font-weight: 700; color: #8C6B00; text-transform: uppercase;">Estimated Cost</span>
                    <strong style="font-size: 18px; font-weight: 900; color: #111; display: block;">Rs. 500 – 800 ($75.00)</strong>
                </div>
                <span class="badge badge-verified" style="font-size: 11px;">100% Escrow Safe</span>
            </div>

            <!-- Additional Instructions (Mockup 1) -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #111; margin-bottom: 6px;">Additional Instructions</label>
                <textarea rows="3" placeholder="e.g. Please ring doorbell twice or call when arrived at the gate..." style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 10px; padding: 10px 12px; font-size: 13.5px; outline: none;">Cabinet space is cleared. Water shutoff is under the sink.</textarea>
            </div>

            <!-- Confirm Booking Button (Yellow) -->
            <button type="submit" class="btn-yellow" style="width: 100%; padding: 14px; font-size: 15px; border-radius: 12px;">
                Confirm Booking
            </button>

        </form>

    </div>

</div>
@endsection
