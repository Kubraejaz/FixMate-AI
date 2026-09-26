@extends('Frontend.layouts.customer')

@section('title', 'Booking Confirmed — FixMate AI')

@section('content')
<div style="max-width: 640px; margin: 0 auto; text-align: center;">
    
    <!-- Confirmation Banner matching Mockup 1 & 2 -->
    <div class="portal-card" style="padding: 40px 32px; background: #FFFFFF; border-radius: 20px;">
        
        <!-- Big Green Check -->
        <div style="width: 72px; height: 72px; border-radius: 50%; background: #ECFDF5; border: 3px solid #10B981; display: flex; align-items: center; justify-content: center; font-size: 36px; color: #10B981; margin: 0 auto 16px auto;">
            ✓
        </div>

        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 6px;">Booking Confirmed!</h1>
        <p style="font-size: 14px; color: #666; margin-bottom: 28px;">Your booking has been successfully created and dispatched.</p>

        <!-- Booking Summary Card -->
        <div style="background: #FAFAFA; border: 1px solid var(--border-color); border-radius: 14px; padding: 20px; text-align: left; margin-bottom: 28px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
                <div>
                    <span style="font-size: 11.5px; color: #777;">Booking ID</span>
                    <strong style="display: block; font-size: 15px; color: #111;">#FM-10245</strong>
                </div>
                <div>
                    <span style="font-size: 11.5px; color: #777;">Technician</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Ali Khan (Plumber)</strong>
                </div>
                <div>
                    <span style="font-size: 11.5px; color: #777;">Service</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Sink / Pipe Repair</strong>
                </div>
                <div>
                    <span style="font-size: 11.5px; color: #777;">Date & Time</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Today • 2:30 PM - 3:30 PM</strong>
                </div>
            </div>

            <div>
                <span style="font-size: 11.5px; color: #777;">Location</span>
                <strong style="display: block; font-size: 14px; color: #111;">House 42-B, Street 18, Phase 6, DHA, Karachi</strong>
            </div>
        </div>

        <!-- Booking Lifecycle Timeline matching Mockup 1 -->
        <div style="text-align: left; margin-bottom: 32px; padding: 0 10px;">
            <span style="font-size: 12px; font-weight: 800; color: #6B7280; text-transform: uppercase; margin-bottom: 14px; display: block;">Booking Status Timeline</span>
            
            <div style="display: flex; flex-direction: column; gap: 14px; position: relative;">
                
                <!-- Status 1 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #10B981; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">✓</div>
                    <div>
                        <strong style="font-size: 13.5px; color: #111;">Booking Requested</strong>
                        <span style="font-size: 11px; color: #888; display: block;">Sep 27, 2026 • 10:00 AM</span>
                    </div>
                </div>

                <!-- Status 2 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #10B981; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">✓</div>
                    <div>
                        <strong style="font-size: 13.5px; color: #111;">Technician Accepted</strong>
                        <span style="font-size: 11px; color: #888; display: block;">Ali Khan accepted job • 10:02 AM</span>
                    </div>
                </div>

                <!-- Status 3 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #FFCC00; color: #000; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">●</div>
                    <div>
                        <strong style="font-size: 13.5px; color: #111;">Technician On The Way</strong>
                        <span style="font-size: 11px; color: #059669; font-weight: 700; display: block;">En route (ETA ~10 mins)</span>
                    </div>
                </div>

                <!-- Status 4 -->
                <div style="display: flex; align-items: center; gap: 14px; opacity: 0.6;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #E5E7EB; color: #888; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">○</div>
                    <div>
                        <strong style="font-size: 13.5px; color: #111;">Service Started (OTP Verified)</strong>
                        <span style="font-size: 11px; color: #888; display: block;">Pending technician arrival</span>
                    </div>
                </div>

                <!-- Status 5 -->
                <div style="display: flex; align-items: center; gap: 14px; opacity: 0.6;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #E5E7EB; color: #888; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">○</div>
                    <div>
                        <strong style="font-size: 13.5px; color: #111;">Completed & Payment Released</strong>
                        <span style="font-size: 11px; color: #888; display: block;">Pending service completion</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons matching Mockup 1 & 2 -->
        <div style="display: flex; gap: 12px;">
            <a href="{{ url('/customer/tracking') }}" class="btn-yellow" style="flex: 1; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px;">
                Track Live Booking →
            </a>
            <a href="{{ url('/customer/bookings') }}" class="btn-outline" style="flex: 1; padding: 12px 0; font-size: 14px; border-radius: 10px;">
                View My Bookings
            </a>
        </div>

    </div>

</div>
@endsection
