@extends('Frontend.layouts.customer')

@section('title', 'Rate & Review Service — FixMate AI')

@section('content')
<div style="max-width: 620px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px; text-align: center;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Service Rating & Review</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">How was your service experience with Ali Khan?</p>
    </div>

    <!-- Review Form Card matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 32px; background: #FFFFFF; border-radius: 18px;">
        
        <!-- Technician Header -->
        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 18px;">
            <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
            <div>
                <strong style="display: block; font-size: 16px; color: #111;">Ali Khan</strong>
                <span style="font-size: 12.5px; color: #666;">Plumbing — Sink / Pipe Repair • Booking #FM-10245</span>
            </div>
        </div>

        <form action="{{ url('/customer/bookings') }}" method="GET">
            
            <!-- Overall Star Rating -->
            <div style="text-align: center; margin-bottom: 24px;">
                <label style="font-size: 13px; font-weight: 700; color: #666; display: block; margin-bottom: 8px;">Overall Satisfaction</label>
                <div style="font-size: 36px; color: #FFCC00; cursor: pointer; letter-spacing: 6px;">
                    ★★★★★
                </div>
                <span style="font-size: 13px; font-weight: 800; color: #111;">5.0 — Excellent</span>
            </div>

            <!-- Specific Categories Breakdown matching Mockup 2 & 3 -->
            <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13.5px;">
                    <span style="color: #4B5563;">Service Quality</span>
                    <div style="color: #F59E0B; font-size: 16px;">★★★★★</div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13.5px;">
                    <span style="color: #4B5563;">Punctuality & Arrival Time</span>
                    <div style="color: #F59E0B; font-size: 16px;">★★★★★</div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13.5px;">
                    <span style="color: #4B5563;">Professional Behavior & Cleanliness</span>
                    <div style="color: #F59E0B; font-size: 16px;">★★★★★</div>
                </div>
            </div>

            <!-- Review Textarea matching Mockup 2 & 3 -->
            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #374151;">Write a Review (Optional)</label>
                <textarea class="form-input" rows="3" style="padding: 12px 14px; font-size: 13.5px;" placeholder="Tell other homeowners about your experience...">Very professional and arrived promptly. Cleaned up the kitchen cabinet after replacing the P-trap pipe seal. 10/10!</textarea>
            </div>

            <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px;">
                Submit Review
            </button>
        </form>

    </div>

</div>
@endsection
