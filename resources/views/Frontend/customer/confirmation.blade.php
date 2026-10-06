@extends('Frontend.layouts.customer')

@section('title', 'Booking Confirmed #' . $booking->booking_number . ' — FixMate')

@section('content')
<div style="max-width: 680px; margin: 0 auto; text-align: center;">
    
    <!-- Confirmation Banner matching Mockup 1 & 2 -->
    <div class="portal-card" style="padding: 40px 32px; background: #FFFFFF; border-radius: 20px;">
        
        <!-- Big Green Check -->
        <div style="width: 72px; height: 72px; border-radius: 50%; background: #ECFDF5; border: 3px solid #10B981; display: flex; align-items: center; justify-content: center; font-size: 36px; color: #10B981; margin: 0 auto 16px auto;">
            ✓
        </div>

        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 6px;">Booking Confirmed!</h1>
        <p style="font-size: 14px; color: #666; margin-bottom: 24px;">Your service booking has been created and assigned.</p>

        <!-- Arrival OTP Card (Critical Security Feature from SRS) -->
        <div style="background: #FFFDF0; border: 2px dashed #FEF08A; border-radius: 14px; padding: 18px 24px; text-align: center; margin-bottom: 24px;">
            <span style="font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; letter-spacing: 0.5px;">Arrival Verification OTP</span>
            <strong style="display: block; font-size: 32px; font-weight: 900; letter-spacing: 6px; color: #111; margin: 6px 0;">{{ $booking->arrival_otp }}</strong>
            <span style="font-size: 12px; color: #777;">Provide this 4-digit code ONLY when the technician arrives at your door</span>
        </div>

        <!-- Booking Summary Card -->
        <div style="background: #FAFAFA; border: 1px solid var(--border-color); border-radius: 14px; padding: 20px; text-align: left; margin-bottom: 28px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
                <div>
                    <span style="font-size: 11.5px; color: #777;">Booking ID</span>
                    <strong style="display: block; font-size: 15px; color: #111;">#{{ $booking->booking_number }}</strong>
                </div>
                <div>
                    <span style="font-size: 11.5px; color: #777;">Assigned Technician</span>
                    <strong style="display: block; font-size: 15px; color: #111;">{{ $booking->professional ? $booking->professional->name . ' (' . ($booking->profession->name ?? 'Pro') . ')' : 'FixMate Standard Dispatch' }}</strong>
                </div>
                <div>
                    <span style="font-size: 11.5px; color: #777;">Service</span>
                    <strong style="display: block; font-size: 15px; color: #111;">{{ $booking->service_title }}</strong>
                </div>
                <div>
                    <span style="font-size: 11.5px; color: #777;">Date & Time</span>
                    <strong style="display: block; font-size: 15px; color: #111;">{{ $booking->service_date ? $booking->service_date->format('M d, Y') : 'Scheduled' }} • {{ $booking->service_time_slot }}</strong>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span style="font-size: 11.5px; color: #777;">Location</span>
                    <strong style="display: block; font-size: 14px; color: #111;">{{ $booking->service_address }}, {{ $booking->city }}</strong>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 11.5px; color: #777;">Escrow Amount</span>
                    <strong style="display: block; font-size: 15px; color: #047857;">Rs. {{ number_format($booking->total_price) }}</strong>
                </div>
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
                        <strong style="font-size: 13.5px; color: #111;">Booking Confirmed & Dispatched</strong>
                        <span style="font-size: 11px; color: #888; display: block;">{{ $booking->created_at->format('M d, Y • h:i A') }}</span>
                    </div>
                </div>

                <!-- Status 2 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #10B981; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">✓</div>
                    <div>
                        <strong style="font-size: 13.5px; color: #111;">Technician Handshake Ready</strong>
                        <span style="font-size: 11px; color: #888; display: block;">Arrival OTP generated: <strong>{{ $booking->arrival_otp }}</strong></span>
                    </div>
                </div>

                <!-- Status 3 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #FFCC00; color: #000; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">●</div>
                    <div>
                        <strong style="font-size: 13.5px; color: #111;">Dispatch & Status Updates</strong>
                        <span style="font-size: 11px; color: #059669; font-weight: 700; display: block;">Track service progress in My Bookings</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons matching Mockup 1 & 2 -->
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('customer.bookings') }}" class="btn-yellow" style="flex: 1; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px; text-decoration: none;">
                📋 View My Bookings →
            </a>
            <a href="{{ route('customer.services') }}" class="btn-outline" style="flex: 1; padding: 12px 0; font-size: 14px; border-radius: 10px; text-decoration: none;">
                Browse More Services
            </a>
        </div>

    </div>

</div>
@endsection
