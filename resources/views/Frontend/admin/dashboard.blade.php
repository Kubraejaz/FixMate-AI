@extends('Frontend.layouts.admin')

@section('title', 'Admin Dashboard & System Analytics — FixMate AI')

@section('content')
<div>
    
    <!-- Header matching Mockup 1 & 2 -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">Admin Dashboard</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Overview of platform activities, AI diagnostics, and key revenue metrics.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ url('/admin/categories') }}" class="btn-yellow" style="padding: 9px 18px; font-size: 13px; font-weight: 800;">
                + Manage Categories
            </a>
            <a href="{{ url('/admin/technicians/verification') }}" class="btn-outline" style="border-color: #333; color: #FFF; padding: 9px 16px; font-size: 13px;">
                Review Pending KYC (3)
            </a>
        </div>
    </div>

    <!-- 8 KPI Metrics Cards matching Mockup 1 & 2 -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
        
        <!-- Total Customers -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 18px 20px;">
            <span style="font-size: 12px; color: #9CA3AF; font-weight: 700; display: block; margin-bottom: 4px;">Total Customers</span>
            <strong style="font-size: 28px; font-weight: 900; color: #FFFFFF;">2,548</strong>
            <span style="font-size: 11px; color: #10B981; font-weight: 700; display: block; margin-top: 4px;">↑ +14% this month</span>
        </div>

        <!-- Total Technicians -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 18px 20px;">
            <span style="font-size: 12px; color: #9CA3AF; font-weight: 700; display: block; margin-bottom: 4px;">Total Technicians</span>
            <strong style="font-size: 28px; font-weight: 900; color: #FFFFFF;">1,203</strong>
            <span style="font-size: 11px; color: #FFCC00; font-weight: 700; display: block; margin-top: 4px;">987 Verified (82%)</span>
        </div>

        <!-- Total Bookings -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 18px 20px;">
            <span style="font-size: 12px; color: #9CA3AF; font-weight: 700; display: block; margin-bottom: 4px;">Total Bookings</span>
            <strong style="font-size: 28px; font-weight: 900; color: #FFFFFF;">4,892</strong>
            <span style="font-size: 11px; color: #10B981; font-weight: 700; display: block; margin-top: 4px;">3,902 Completed</span>
        </div>

        <!-- Gross Platform GMV / Revenue -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 18px 20px;">
            <span style="font-size: 12px; color: #9CA3AF; font-weight: 700; display: block; margin-bottom: 4px;">Platform Revenue</span>
            <strong style="font-size: 28px; font-weight: 900; color: #FFCC00;">Rs. 1,245,000</strong>
            <span style="font-size: 11px; color: #10B981; font-weight: 700; display: block; margin-top: 4px;">12% Net Commission</span>
        </div>

    </div>

    <!-- Charts Row matching Mockup 1 & 2 -->
    <div style="display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 20px; margin-bottom: 24px;">
        
        <!-- Monthly Bookings Trend Chart Graphic -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #FFFFFF; margin: 0;">Monthly Bookings Growth</h3>
                <span style="font-size: 12px; color: #9CA3AF;">Jan 2026 – Sep 2026</span>
            </div>

            <!-- SVG Vector Line / Area Chart -->
            <div style="height: 220px; width: 100%;">
                <svg width="100%" height="100%" viewBox="0 0 500 200" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#FFCC00" stop-opacity="0.35"/>
                            <stop offset="100%" stop-color="#FFCC00" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>
                    <!-- Grid Lines -->
                    <line x1="0" y1="40" x2="500" y2="40" stroke="#2B2B2B" stroke-dasharray="3 3"/>
                    <line x1="0" y1="90" x2="500" y2="90" stroke="#2B2B2B" stroke-dasharray="3 3"/>
                    <line x1="0" y1="140" x2="500" y2="140" stroke="#2B2B2B" stroke-dasharray="3 3"/>
                    <line x1="0" y1="190" x2="500" y2="190" stroke="#333333"/>

                    <!-- Area Fill -->
                    <path d="M 0 160 Q 70 140 140 130 T 280 80 T 420 50 L 500 30 L 500 190 L 0 190 Z" fill="url(#chartGrad)"/>
                    <!-- Trend Stroke -->
                    <path d="M 0 160 Q 70 140 140 130 T 280 80 T 420 50 L 500 30" fill="none" stroke="#FFCC00" stroke-width="3.5"/>
                    
                    <!-- Data Points -->
                    <circle cx="140" cy="130" r="4" fill="#FFCC00"/>
                    <circle cx="280" cy="80" r="4" fill="#FFCC00"/>
                    <circle cx="420" cy="50" r="4" fill="#FFCC00"/>
                    <circle cx="500" cy="30" r="5" fill="#FFFFFF" stroke="#FFCC00" stroke-width="2"/>
                </svg>
            </div>
            
            <div style="display: flex; justify-content: space-between; font-size: 11px; color: #777; margin-top: 10px;">
                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep (Peak 4,892)</span>
            </div>
        </div>

        <!-- Bookings by City Donut Breakdown matching Mockup 1 -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; padding: 24px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #FFFFFF; margin: 0 0 18px 0;">Bookings by Location</h3>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span style="color: #DDD;">Karachi</span>
                        <strong style="color: #FFCC00;">45% (2,201)</strong>
                    </div>
                    <div style="height: 6px; background: #2B2B2B; border-radius: 3px; overflow: hidden;">
                        <div style="width: 45%; height: 100%; background: #FFCC00;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span style="color: #DDD;">Lahore</span>
                        <strong style="color: #3B82F6;">28% (1,370)</strong>
                    </div>
                    <div style="height: 6px; background: #2B2B2B; border-radius: 3px; overflow: hidden;">
                        <div style="width: 28%; height: 100%; background: #3B82F6;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span style="color: #DDD;">Islamabad</span>
                        <strong style="color: #10B981;">18% (880)</strong>
                    </div>
                    <div style="height: 6px; background: #2B2B2B; border-radius: 3px; overflow: hidden;">
                        <div style="width: 18%; height: 100%; background: #10B981;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span style="color: #DDD;">Rawalpindi & Others</span>
                        <strong style="color: #A855F7;">9% (441)</strong>
                    </div>
                    <div style="height: 6px; background: #2B2B2B; border-radius: 3px; overflow: hidden;">
                        <div style="width: 9%; height: 100%; background: #A855F7;"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Most Requested Services & Live AI Diagnostics Inspection matching Mockup 1 & 2 -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <!-- Most Requested Services Bar Chart -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #FFFFFF; margin: 0;">Most Requested Services</h3>
                <a href="{{ url('/admin/categories') }}" style="font-size: 12px; color: #FFCC00; text-decoration: none;">Manage All →</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; color: #AAA; margin-bottom: 4px;">
                        <span>Plumbing (Pipes & Sinks)</span>
                        <span style="color: #FFF; font-weight: 700;">1,248 Jobs</span>
                    </div>
                    <div style="height: 8px; background: #2B2B2B; border-radius: 4px; overflow: hidden;">
                        <div style="width: 85%; height: 100%; background: #FFCC00;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; color: #AAA; margin-bottom: 4px;">
                        <span>Electrical (Wiring & DB)</span>
                        <span style="color: #FFF; font-weight: 700;">892 Jobs</span>
                    </div>
                    <div style="height: 8px; background: #2B2B2B; border-radius: 4px; overflow: hidden;">
                        <div style="width: 65%; height: 100%; background: #3B82F6;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; color: #AAA; margin-bottom: 4px;">
                        <span>AC & Cooling (Inverter Wash)</span>
                        <span style="color: #FFF; font-weight: 700;">740 Jobs</span>
                    </div>
                    <div style="height: 8px; background: #2B2B2B; border-radius: 4px; overflow: hidden;">
                        <div style="width: 55%; height: 100%; background: #10B981;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; color: #AAA; margin-bottom: 4px;">
                        <span>Deep Cleaning & Sanitation</span>
                        <span style="color: #FFF; font-weight: 700;">520 Jobs</span>
                    </div>
                    <div style="height: 8px; background: #2B2B2B; border-radius: 4px; overflow: hidden;">
                        <div style="width: 40%; height: 100%; background: #A855F7;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Diagnostics Real-Time Engine Health -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #FFFFFF; margin: 0;">AI Diagnostics Accuracy</h3>
                <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    94.2% Precision
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #2B2B2B; padding-bottom: 8px;">
                    <span style="color: #AAA;">Total Images Processed</span>
                    <strong style="color: #FFF;">14,920 Scans</strong>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #2B2B2B; padding-bottom: 8px;">
                    <span style="color: #AAA;">Mean Analysis Latency</span>
                    <strong style="color: #10B981;">1.24 seconds</strong>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #2B2B2B; padding-bottom: 8px;">
                    <span style="color: #AAA;">Cost Prediction Accuracy</span>
                    <strong style="color: #FFCC00;">91.8% within bounds</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #AAA;">Customer Acceptance Rate</span>
                    <strong style="color: #FFF;">87% Confirmed</strong>
                </div>
            </div>
            
            <a href="{{ url('/admin/analytics') }}" style="display: block; text-align: center; margin-top: 18px; color: #FFCC00; font-size: 13px; font-weight: 700; text-decoration: none;">
                Open Recommendation Analytics Suite →
            </a>
        </div>

    </div>

</div>
@endsection
