@extends('Frontend.layouts.master')

@section('title', 'Booking Confirmed — FixMate AI')
@section('meta_desc', 'Your booking #FM-10245 has been confirmed. Technician Ali Khan has accepted the dispatch.')

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 70px; display: flex; justify-content: center;">

    <!-- Booking Confirmation Card (Matching Mockup 1 & 2) -->
    <div class="card-box" style="width: 100%; max-width: 600px; padding: 40px; text-align: center;">
        
        <!-- Big Green Confirmation Icon -->
        <div style="width: 72px; height: 72px; border-radius: 50%; background: #10B981; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 900; margin: 0 auto 16px auto; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);">
            ✓
        </div>

        <h1 style="font-size: 26px; font-weight: 800; color: #111; margin-bottom: 4px;">Booking Confirmed!</h1>
        <p style="font-size: 14px; color: #757575; margin-bottom: 28px;">
            Your booking has been successfully created and accepted by the technician.
        </p>

        <!-- Booking Details Card -->
        <div style="background: #FAFAFA; border: 1px solid var(--border-color); border-radius: 20px; padding: 24px; text-align: left; margin-bottom: 28px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #EEEEEE; padding-bottom: 12px; margin-bottom: 14px;">
                <span style="font-size: 12px; font-weight: 700; color: #757575; text-transform: uppercase;">BOOKING ID</span>
                <strong style="font-size: 15px; color: #111;">#FM-10245</strong>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13.5px;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">Technician:</span>
                    <strong style="color: #111;">Ali Khan (Plumber)</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">Service:</span>
                    <strong style="color: #111;">Sink / Pipe Repair</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">Date & Time:</span>
                    <strong style="color: #111;">Today, 26 Sep 2026 • 3:00 PM</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">Location:</span>
                    <strong style="color: #111;">House #42, Street 8, DHA, Karachi</strong>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px dashed #DDD; padding-top: 10px;">
                    <span style="color: #666;">Estimated Cost (Escrow Pre-Authorized):</span>
                    <strong style="color: #111; font-size: 16px;">Rs. 500 – 800 ($75.00)</strong>
                </div>
            </div>

            <!-- Booking Status Timeline (Mockup 2) -->
            <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid #EEEEEE;">
                <span style="font-size: 12px; font-weight: 700; color: #111; display: block; margin-bottom: 12px;">Booking Status</span>
                
                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 12.5px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="color: #10B981; font-weight: 800;">●</span>
                        <span style="font-weight: 700; color: #111;">Booking Requested</span>
                        <span style="color: #888; font-size: 11px; margin-left: auto;">Sep 26, 10:00 AM</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="color: #10B981; font-weight: 800;">●</span>
                        <span style="font-weight: 700; color: #111;">Technician Accepted</span>
                        <span style="color: #888; font-size: 11px; margin-left: auto;">Sep 26, 10:02 AM</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="color: #FFCC00; font-weight: 800;">●</span>
                        <span style="font-weight: 700; color: #B45309;">Technician On The Way</span>
                        <span style="color: #10B981; font-weight: 700; font-size: 11px; margin-left: auto;">En Route (~8m)</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; opacity: 0.5;">
                        <span style="color: #AAA;">○</span>
                        <span>Service Started (Pending OTP)</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; opacity: 0.5;">
                        <span style="color: #AAA;">○</span>
                        <span>Completed & Paid</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 14px;">
            <a href="{{ url('/tracking') }}" class="btn-yellow" style="flex: 2; padding: 13px; font-size: 14.5px;">
                Track Live Technician GPS
            </a>
            <a href="{{ url('/customer-dashboard') }}" class="btn-outline" style="flex: 1; padding: 13px; font-size: 14px;">
                My Dashboard
            </a>
        </div>

    </div>

</div>
@endsection
