@extends('Frontend.layouts.master')

@section('title', 'Admin Dashboard — FixMate AI')
@section('meta_desc', 'Platform administration: oversee platform metrics, bookings, technician verification, and analytics.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Admin Header (Mockup 2) -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 26px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span class="badge badge-gold">ADMIN CONSOLE</span>
                <span style="font-size: 12px; color: #10B981; font-weight: 700;">● Cloud Platform Live</span>
            </div>
            <h1 style="font-size: 28px; font-weight: 800; color: #111;">Admin Dashboard</h1>
            <p style="font-size: 13.5px; color: #757575;">Overview of platform activities and key metrics.</p>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="button" class="btn-outline" style="font-size: 13px;" onclick="showToast('Exported platform statistics')">
                Export Data
            </button>
            <button type="button" class="btn-yellow" style="font-size: 13px;" onclick="showToast('Platform metrics refreshed')">
                Refresh Stats
            </button>
        </div>
    </div>

    <!-- 8 Metrics Counters (Exact values from Mockup 2) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px;">
        <div class="card-box" style="padding: 20px;">
            <span style="font-size: 12px; color: #757575; font-weight: 600;">Total Users</span>
            <strong style="font-size: 26px; font-weight: 900; color: #111; display: block; margin: 4px 0;">2,548</strong>
            <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">Active customers</span>
        </div>
        <div class="card-box" style="padding: 20px;">
            <span style="font-size: 12px; color: #757575; font-weight: 600;">Total Technicians</span>
            <strong style="font-size: 26px; font-weight: 900; color: #111; display: block; margin: 4px 0;">1,203</strong>
            <span style="font-size: 11.5px; color: #555;">Registered pros</span>
        </div>
        <div class="card-box" style="padding: 20px;">
            <span style="font-size: 12px; color: #757575; font-weight: 600;">Verified Technicians</span>
            <strong style="font-size: 26px; font-weight: 900; color: #10B981; display: block; margin: 4px 0;">987</strong>
            <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">82% verification rate</span>
        </div>
        <div class="card-box" style="padding: 20px;">
            <span style="font-size: 12px; color: #757575; font-weight: 600;">Total Bookings</span>
            <strong style="font-size: 26px; font-weight: 900; color: #111; display: block; margin: 4px 0;">4,892</strong>
            <span style="font-size: 11.5px; color: #555;">Lifetime volume</span>
        </div>
    </div>

    <!-- Secondary Metric Strip (Mockup 2) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 32px;">
        <div class="card-box" style="padding: 18px; background: #FAFAFA;">
            <span style="font-size: 11.5px; color: #777; font-weight: 600;">Completed Services</span>
            <strong style="font-size: 22px; font-weight: 800; color: #111; display: block;">3,902</strong>
        </div>
        <div class="card-box" style="padding: 18px; background: #FAFAFA;">
            <span style="font-size: 11.5px; color: #777; font-weight: 600;">Pending Requests</span>
            <strong style="font-size: 22px; font-weight: 800; color: #B45309; display: block;">421</strong>
        </div>
        <div class="card-box" style="padding: 18px; background: #FAFAFA;">
            <span style="font-size: 11.5px; color: #777; font-weight: 600;">Total Revenue</span>
            <strong style="font-size: 22px; font-weight: 800; color: #111; display: block;">Rs. 1,245,000</strong>
        </div>
        <div class="card-box" style="padding: 18px; background: #FAFAFA;">
            <span style="font-size: 11.5px; color: #777; font-weight: 600;">Customer Rating</span>
            <strong style="font-size: 22px; font-weight: 800; color: #10B981; display: block;">★ 4.8 / 5.0</strong>
        </div>
    </div>

    <!-- Charts & Analytics (Mockup 2) -->
    <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 28px; margin-bottom: 32px;">
        
        <!-- Monthly Bookings Trend Chart (Mockup 2) -->
        <div class="card-box" style="padding: 26px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111;">Monthly Bookings Growth</h3>
                <span style="font-size: 12px; color: #10B981; font-weight: 700;">+38% this quarter</span>
            </div>

            <!-- Vector Line Chart Simulation -->
            <div style="height: 180px; width: 100%; position: relative;">
                <svg width="100%" height="100%" viewBox="0 0 500 180" preserveAspectRatio="none">
                    <line x1="0" y1="40" x2="500" y2="40" stroke="#F3F4F6" stroke-width="1"/>
                    <line x1="0" y1="90" x2="500" y2="90" stroke="#F3F4F6" stroke-width="1"/>
                    <line x1="0" y1="140" x2="500" y2="140" stroke="#F3F4F6" stroke-width="1"/>

                    <!-- Area gradient -->
                    <defs>
                        <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#FFCC00" stop-opacity="0.35"/>
                            <stop offset="100%" stop-color="#FFCC00" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0 150 Q 80 130, 140 100 T 260 70 T 380 45 T 500 25 L 500 180 L 0 180 Z" fill="url(#chartGrad)"/>
                    <path d="M0 150 Q 80 130, 140 100 T 260 70 T 380 45 T 500 25" stroke="#FFCC00" stroke-width="3.5" fill="none"/>
                </svg>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 8px;">
                <span>May</span>
                <span>Jun</span>
                <span>Jul</span>
                <span>Aug</span>
                <span>Sep (Current)</span>
            </div>
        </div>

        <!-- Bookings by Location (Mockup 2 Donut & Percentage Breakdown) -->
        <div class="card-box" style="padding: 26px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Bookings by Location</h3>
            
            <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px;">
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span>Karachi</span>
                        <strong style="color: #111;">45%</strong>
                    </div>
                    <div style="height: 6px; background: #EEE; border-radius: 4px; overflow: hidden;">
                        <div style="width: 45%; height: 100%; background: #FFCC00;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span>Lahore</span>
                        <strong style="color: #111;">25%</strong>
                    </div>
                    <div style="height: 6px; background: #EEE; border-radius: 4px; overflow: hidden;">
                        <div style="width: 25%; height: 100%; background: #3B82F6;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span>Islamabad</span>
                        <strong style="color: #111;">18%</strong>
                    </div>
                    <div style="height: 6px; background: #EEE; border-radius: 4px; overflow: hidden;">
                        <div style="width: 18%; height: 100%; background: #10B981;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span>Others (Rawalpindi / Faisalabad)</span>
                        <strong style="color: #111;">12%</strong>
                    </div>
                    <div style="height: 6px; background: #EEE; border-radius: 4px; overflow: hidden;">
                        <div style="width: 12%; height: 100%; background: #8B5CF6;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Most Requested Services (Mockup 2 Bar Chart) -->
    <div class="card-box" style="padding: 26px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Most Requested Services</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px; text-align: center;">
            <div style="background: #FFFDF0; border: 1px solid #FFECB3; padding: 14px; border-radius: 14px;">
                <span style="font-size: 22px;">🚰</span>
                <strong style="display: block; font-size: 14px; color: #111; margin: 4px 0;">Plumbing</strong>
                <span style="font-size: 12px; color: #B45309; font-weight: 700;">1,420 bookings</span>
            </div>
            <div style="background: #FAFAFA; border: 1px solid #EEEEEE; padding: 14px; border-radius: 14px;">
                <span style="font-size: 22px;">⚡</span>
                <strong style="display: block; font-size: 14px; color: #111; margin: 4px 0;">Electrical</strong>
                <span style="font-size: 12px; color: #555; font-weight: 700;">1,110 bookings</span>
            </div>
            <div style="background: #FAFAFA; border: 1px solid #EEEEEE; padding: 14px; border-radius: 14px;">
                <span style="font-size: 22px;">❄️</span>
                <strong style="display: block; font-size: 14px; color: #111; margin: 4px 0;">AC Repair</strong>
                <span style="font-size: 12px; color: #555; font-weight: 700;">940 bookings</span>
            </div>
            <div style="background: #FAFAFA; border: 1px solid #EEEEEE; padding: 14px; border-radius: 14px;">
                <span style="font-size: 22px;">🧹</span>
                <strong style="display: block; font-size: 14px; color: #111; margin: 4px 0;">Cleaning</strong>
                <span style="font-size: 12px; color: #555; font-weight: 700;">780 bookings</span>
            </div>
            <div style="background: #FAFAFA; border: 1px solid #EEEEEE; padding: 14px; border-radius: 14px;">
                <span style="font-size: 22px;">🪚</span>
                <strong style="display: block; font-size: 14px; color: #111; margin: 4px 0;">Carpentry</strong>
                <span style="font-size: 12px; color: #555; font-weight: 700;">642 bookings</span>
            </div>
        </div>
    </div>

</div>
@endsection
