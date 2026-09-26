@extends('Frontend.layouts.customer')

@section('title', 'Customer Dashboard — FixMate AI')

@section('content')
<div>
    
    <!-- Welcome Header matching Mockup 1 -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Welcome, Ahmed Khan</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Here's what's happening with your services.</p>
    </div>

    <!-- 4 Stats Cards matching Mockup 1 -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
        
        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Active Requests</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">2</strong>
                <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 8px; border-radius: 12px;">In Progress</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Upcoming Bookings</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">1</strong>
                <span style="font-size: 11px; background: #EFF6FF; color: #1D4ED8; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Tomorrow</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Completed Services</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">12</strong>
                <span style="font-size: 11px; background: #F3F4F6; color: #374151; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Total</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Pending Requests</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">1</strong>
                <span style="font-size: 11px; background: #FFFBEB; color: #B45309; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Awaiting Pro</span>
            </div>
        </div>

    </div>

    <!-- Quick "Describe Your Problem" Banner matching Mockup 1 -->
    <div style="background: #FFF9E6; border: 1px solid #FFECB3; border-radius: 16px; padding: 24px 30px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
        <div style="display: flex; align-items: center; gap: 18px;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                🔍
            </div>
            <div>
                <strong style="display: block; font-size: 18px; color: #111; margin-bottom: 4px;">Describe Your Problem</strong>
                <span style="font-size: 13.5px; color: #666;">Let AI find the right solution & estimate repair costs for you.</span>
            </div>
        </div>
        <a href="{{ url('/customer/diagnose') }}" class="btn-yellow" style="padding: 11px 26px; font-size: 14px; font-weight: 800;">
            Start Now
        </a>
    </div>

    <!-- Two Columns: Recommended Technicians & Recent Bookings (Matching Mockup 1) -->
    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 24px;">
        
        <!-- Left: Recommended Technicians -->
        <div class="portal-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0;">Recommended Technicians</h3>
                <a href="{{ url('/customer/technicians') }}" style="font-size: 13px; color: #B45309; font-weight: 700; text-decoration: none;">View All →</a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                
                <!-- Ali Khan -->
                <div style="border: 1px solid var(--border-color); border-radius: 14px; padding: 16px 12px; text-align: center;">
                    <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 58px; height: 58px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00; margin: 0 auto 8px auto; display: block;">
                    <strong style="display: block; font-size: 14px; color: #111;">Ali Khan</strong>
                    <span style="font-size: 11.5px; color: #757575; display: block; margin-bottom: 6px;">Plumber</span>
                    <div style="font-size: 11.5px; color: #F59E0B; margin-bottom: 10px;">
                        ★ 4.9 <span style="color: #888;">(247)</span> • 2.1km
                    </div>
                    <a href="{{ url('/customer/booking?tech=ali-khan') }}" class="btn-yellow" style="display: block; font-size: 12px; padding: 6px 0; border-radius: 6px;">Book Now</a>
                </div>

                <!-- Riaz Ahmed -->
                <div style="border: 1px solid var(--border-color); border-radius: 14px; padding: 16px 12px; text-align: center;">
                    <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="width: 58px; height: 58px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00; margin: 0 auto 8px auto; display: block;">
                    <strong style="display: block; font-size: 14px; color: #111;">Riaz Ahmed</strong>
                    <span style="font-size: 11.5px; color: #757575; display: block; margin-bottom: 6px;">Electrician</span>
                    <div style="font-size: 11.5px; color: #F59E0B; margin-bottom: 10px;">
                        ★ 4.8 <span style="color: #888;">(189)</span> • 3.4km
                    </div>
                    <a href="{{ url('/customer/booking?tech=riaz-ahmed') }}" class="btn-yellow" style="display: block; font-size: 12px; padding: 6px 0; border-radius: 6px;">Book Now</a>
                </div>

                <!-- Imran Shah -->
                <div style="border: 1px solid var(--border-color); border-radius: 14px; padding: 16px 12px; text-align: center;">
                    <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="width: 58px; height: 58px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00; margin: 0 auto 8px auto; display: block;">
                    <strong style="display: block; font-size: 14px; color: #111;">Imran Shah</strong>
                    <span style="font-size: 11.5px; color: #757575; display: block; margin-bottom: 6px;">AC Tech</span>
                    <div style="font-size: 11.5px; color: #F59E0B; margin-bottom: 10px;">
                        ★ 4.9 <span style="color: #888;">(312)</span> • 1.8km
                    </div>
                    <a href="{{ url('/customer/booking?tech=imran-shah') }}" class="btn-yellow" style="display: block; font-size: 12px; padding: 6px 0; border-radius: 6px;">Book Now</a>
                </div>

            </div>
        </div>

        <!-- Right: Recent Bookings matching Mockup 1 -->
        <div class="portal-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0;">Recent Bookings</h3>
                <a href="{{ url('/customer/bookings') }}" style="font-size: 13px; color: #B45309; font-weight: 700; text-decoration: none;">All →</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                
                <!-- Booking 1 -->
                <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <strong style="font-size: 14px; color: #111;">Sink Repair</strong>
                        <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 7px; border-radius: 10px;">Confirmed</span>
                    </div>
                    <div style="font-size: 12px; color: #777; margin-bottom: 6px;">Sep 27, 2026 • 10:00 AM (Ali Khan)</div>
                    <a href="{{ url('/customer/tracking') }}" style="font-size: 12px; color: #1D4ED8; font-weight: 700; text-decoration: none;">📍 Live Track Technician →</a>
                </div>

                <!-- Booking 2 -->
                <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <strong style="font-size: 14px; color: #111;">AC Master Service</strong>
                        <span style="font-size: 11px; background: #FFFBEB; color: #B45309; font-weight: 800; padding: 2px 7px; border-radius: 10px;">Pending</span>
                    </div>
                    <div style="font-size: 12px; color: #777;">Oct 01, 2026 • 2:00 PM</div>
                </div>

                <!-- Booking 3 -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <strong style="font-size: 14px; color: #111;">Electrical Repair</strong>
                        <span style="font-size: 11px; background: #EFF6FF; color: #1D4ED8; font-weight: 800; padding: 2px 7px; border-radius: 10px;">Scheduled</span>
                    </div>
                    <div style="font-size: 12px; color: #777;">Oct 05, 2026 • 11:30 AM</div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
