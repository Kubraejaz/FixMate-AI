@extends('Frontend.layouts.master')

@section('title', 'Customer Dashboard — FixMate')
@section('meta_desc', 'Track your active requests, upcoming bookings, and recent maintenance services on FixMate.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Dashboard Top Bar (Mockup 1 & 2) -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                <h1 style="font-size: 26px; font-weight: 800; color: #111;">Welcome, Ahmed Khan</h1>
                <span class="badge badge-gold">Customer</span>
            </div>
            <p style="font-size: 14px; color: #757575;">Here's what's happening with your home maintenance requests.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ url('/describe-problem') }}" class="btn-yellow" style="padding: 10px 20px;">
                + Describe New Problem
            </a>
            <a href="{{ url('/customer/bookings') }}" class="btn-outline" style="padding: 10px 18px;">
                📋 View My Bookings
            </a>
        </div>
    </div>

    <!-- 4 Status Metric Cards (Mockup 1 & 2) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 30px;">
        <div class="card-box" style="padding: 20px; text-align: center;">
            <span style="font-size: 12px; color: #757575; font-weight: 600; text-transform: uppercase;">Active Requests</span>
            <strong style="font-size: 32px; font-weight: 900; color: #111; display: block; margin: 4px 0;">2</strong>
            <span style="font-size: 11px; color: #10B981; font-weight: 700;">1 Technician en-route</span>
        </div>
        <div class="card-box" style="padding: 20px; text-align: center;">
            <span style="font-size: 12px; color: #757575; font-weight: 600; text-transform: uppercase;">Upcoming Bookings</span>
            <strong style="font-size: 32px; font-weight: 900; color: #111; display: block; margin: 4px 0;">1</strong>
            <span style="font-size: 11px; color: #777;">Scheduled for 3:00 PM</span>
        </div>
        <div class="card-box" style="padding: 20px; text-align: center;">
            <span style="font-size: 12px; color: #757575; font-weight: 600; text-transform: uppercase;">Completed Services</span>
            <strong style="font-size: 32px; font-weight: 900; color: #111; display: block; margin: 4px 0;">12</strong>
            <span style="font-size: 11px; color: #777;">All warranties active</span>
        </div>
        <div class="card-box" style="padding: 20px; text-align: center;">
            <span style="font-size: 12px; color: #757575; font-weight: 600; text-transform: uppercase;">Pending Requests</span>
            <strong style="font-size: 32px; font-weight: 900; color: #111; display: block; margin: 4px 0;">1</strong>
            <span style="font-size: 11px; color: #B45309; font-weight: 700;">Awaiting quote</span>
        </div>
    </div>

    <!-- Yellow Callout Banner (Mockup 1 & 2) -->
    <div style="background: #FFFDF0; border: 1.5px solid #FFECB3; border-radius: 20px; padding: 24px 32px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 36px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                💡
            </div>
            <div>
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 2px;">Describe Your Problem</h3>
                <p style="font-size: 13.5px; color: #666;">Let AI find the right solution and verified technician for you.</p>
            </div>
        </div>
        <a href="{{ url('/describe-problem') }}" class="btn-yellow" style="padding: 10px 22px;">
            Start Now
        </a>
    </div>

    <!-- Two-Column Layout: Recommended Technicians + Recent Bookings (Mockup 1 & 2) -->
    <div style="display: grid; grid-template-columns: 1.25fr 1fr; gap: 28px;">
        
        <!-- Left: Recommended Technicians -->
        <div class="card-box" style="padding: 26px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111;">Recommended Technicians</h3>
                <a href="{{ url('/find-technician') }}" style="font-size: 12.5px; font-weight: 700; color: #111; text-decoration: underline;">View All</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <!-- Tech 1 -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 14px;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                        <div>
                            <strong style="font-size: 14.5px; color: #111;">Ali Khan</strong>
                            <span style="font-size: 12px; color: #555; display: block;">Plumber • 5 Yrs Exp</span>
                            <div style="font-size: 11.5px; color: #111; font-weight: 700;">★ 4.8 (247 jobs) • 3.2 km</div>
                        </div>
                    </div>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px;">Book Now</a>
                </div>

                <!-- Tech 2 -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 14px;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #E5E7EB;">
                        <div>
                            <strong style="font-size: 14.5px; color: #111;">Riaz Ahmed</strong>
                            <span style="font-size: 12px; color: #555; display: block;">Electrician • 7 Yrs Exp</span>
                            <div style="font-size: 11.5px; color: #111; font-weight: 700;">★ 4.7 (189 jobs) • 4.1 km</div>
                        </div>
                    </div>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px;">Book Now</a>
                </div>

                <!-- Tech 3 -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 14px;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <img src="{{ asset('assets/images/image_5.png') }}" alt="Imran Shah" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #E5E7EB;">
                        <div>
                            <strong style="font-size: 14.5px; color: #111;">Imran Shah</strong>
                            <span style="font-size: 12px; color: #555; display: block;">AC Technician • 6 Yrs Exp</span>
                            <div style="font-size: 11.5px; color: #111; font-weight: 700;">★ 4.9 (312 jobs) • 2.8 km</div>
                        </div>
                    </div>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px;">Book Now</a>
                </div>
            </div>
        </div>

        <!-- Right: Recent Bookings (Mockup 1 & 2) -->
        <div class="card-box" style="padding: 26px;">
            <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 18px;">Recent Bookings</h3>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                <!-- Booking 1 -->
                <div style="border: 1px solid #FFECB3; background: #FFFDF0; border-radius: 14px; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: #111;">Sink Repair</strong>
                        <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Confirmed</span>
                    </div>
                    <p style="font-size: 12.5px; color: #555; margin-bottom: 8px;">Sep 26, 2026 • 3:00 PM • Ali Khan</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; font-weight: 700; color: #111;">Rs. 500 – 800</span>
                        <a href="{{ url('/customer/bookings') }}" style="font-size: 12px; font-weight: 700; color: #B45309; text-decoration: underline;">View Booking →</a>
                    </div>
                </div>

                <!-- Booking 2 -->
                <div style="border: 1px solid #EEEEEE; background: #FAFAFA; border-radius: 14px; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: #111;">AC Service</strong>
                        <span style="background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Pending</span>
                    </div>
                    <p style="font-size: 12.5px; color: #555;">Sep 28, 2026 • 11:00 AM • Imran Shah</p>
                </div>

                <!-- Booking 3 -->
                <div style="border: 1px solid #EEEEEE; background: #FAFAFA; border-radius: 14px; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: #111;">Electrical Repair</strong>
                        <span style="background: #E5E7EB; color: #374151; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Completed</span>
                    </div>
                    <p style="font-size: 12.5px; color: #555;">Sep 18, 2026 • 4:30 PM • Riaz Ahmed</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
