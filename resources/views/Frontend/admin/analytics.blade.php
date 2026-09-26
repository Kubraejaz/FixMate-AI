@extends('Frontend.layouts.admin')

@section('title', 'AI Recommendation & Matching Analytics — FixMate AI Admin')

@section('content')
<div>
    
    <!-- Title matching Mockup 2 -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">Recommendation & AI Matching Analytics</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Performance of computer vision diagnostics, technician recommendation algorithms, and conversion metrics.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="background: rgba(255, 204, 0, 0.2); color: #FFCC00; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                Average Matching Score: 87%
            </span>
        </div>
    </div>

    <!-- 3 Metrics Cards matching Mockup 2 -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 28px;">
        
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <span style="font-size: 12px; color: #9CA3AF; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px;">Total Inquiries (AI Scans)</span>
            <strong style="font-size: 32px; font-weight: 900; color: #FFFFFF; display: block; margin-bottom: 4px;">1,248</strong>
            <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">Processed by computer vision</span>
        </div>

        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <span style="font-size: 12px; color: #9CA3AF; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px;">Successful Matches</span>
            <strong style="font-size: 32px; font-weight: 900; color: #3B82F6; display: block; margin-bottom: 4px;">892</strong>
            <span style="font-size: 11.5px; color: #AAA;">71.4% match confidence</span>
        </div>

        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <span style="font-size: 12px; color: #9CA3AF; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px;">Confirmed Bookings</span>
            <strong style="font-size: 32px; font-weight: 900; color: #FFCC00; display: block; margin-bottom: 4px;">356</strong>
            <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">39.9% booking conversion</span>
        </div>

    </div>

    <!-- Two Columns: Most Recommended Technicians & Common Problems matching Mockup 2 -->
    <div style="display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 24px;">
        
        <!-- Left: Most Recommended Technicians Table matching Mockup 2 -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; padding: 24px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #FFFFFF; margin: 0 0 18px 0;">Most Recommended Technicians</h3>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                
                <!-- Row 1: Ali Khan -->
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2B2B2B; padding-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('assets/images/image_1.png') }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                        <div>
                            <strong style="font-size: 14.5px; color: #FFFFFF; display: block;">1. Ali Khan</strong>
                            <span style="font-size: 12px; color: #9CA3AF;">Plumber • 4.9 ★ Rating</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <strong style="font-size: 14px; color: #FFCC00; display: block;">124 Inquiries</strong>
                        <span style="font-size: 11px; color: #10B981; font-weight: 700;">98% Match Rate</span>
                    </div>
                </div>

                <!-- Row 2: Riaz Ahmed -->
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2B2B2B; padding-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('assets/images/image_2.png') }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                        <div>
                            <strong style="font-size: 14.5px; color: #FFFFFF; display: block;">2. Riaz Ahmed</strong>
                            <span style="font-size: 12px; color: #9CA3AF;">Electrician • 4.8 ★ Rating</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <strong style="font-size: 14px; color: #FFCC00; display: block;">98 Inquiries</strong>
                        <span style="font-size: 11px; color: #10B981; font-weight: 700;">94% Match Rate</span>
                    </div>
                </div>

                <!-- Row 3: Imran Shah -->
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2B2B2B; padding-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('assets/images/image_3.png') }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                        <div>
                            <strong style="font-size: 14.5px; color: #FFFFFF; display: block;">3. Imran Shah</strong>
                            <span style="font-size: 12px; color: #9CA3AF;">AC Specialist • 4.9 ★ Rating</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <strong style="font-size: 14px; color: #FFCC00; display: block;">82 Inquiries</strong>
                        <span style="font-size: 11px; color: #10B981; font-weight: 700;">96% Match Rate</span>
                    </div>
                </div>

                <!-- Row 4: Usman Tariq -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('assets/images/image_4.png') }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                        <div>
                            <strong style="font-size: 14.5px; color: #FFFFFF; display: block;">4. Usman Tariq</strong>
                            <span style="font-size: 12px; color: #9CA3AF;">Cleaner • 4.8 ★ Rating</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <strong style="font-size: 14px; color: #FFCC00; display: block;">65 Inquiries</strong>
                        <span style="font-size: 11px; color: #10B981; font-weight: 700;">91% Match Rate</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right: Common Detected Problems matching Mockup 2 -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; padding: 24px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #FFFFFF; margin: 0 0 18px 0;">Common Detected Problems</h3>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                
                <div style="background: #242424; border-radius: 10px; padding: 12px 14px;">
                    <strong style="font-size: 13.5px; color: #FFFFFF; display: block; margin-bottom: 2px;">Kitchen Sink Leakage</strong>
                    <span style="font-size: 11.5px; color: #9CA3AF;">382 scans • 92% AI precision</span>
                </div>

                <div style="background: #242424; border-radius: 10px; padding: 12px 14px;">
                    <strong style="font-size: 13.5px; color: #FFFFFF; display: block; margin-bottom: 2px;">AC Not Cooling (Gas / Filter)</strong>
                    <span style="font-size: 11.5px; color: #9CA3AF;">294 scans • 89% AI precision</span>
                </div>

                <div style="background: #242424; border-radius: 10px; padding: 12px 14px;">
                    <strong style="font-size: 13.5px; color: #FFFFFF; display: block; margin-bottom: 2px;">Circuit Breaker Tripping</strong>
                    <span style="font-size: 11.5px; color: #9CA3AF;">188 scans • 94% AI precision</span>
                </div>

                <div style="background: #242424; border-radius: 10px; padding: 12px 14px;">
                    <strong style="font-size: 13.5px; color: #FFFFFF; display: block; margin-bottom: 2px;">Sofa & Carpet Stain Wash</strong>
                    <span style="font-size: 11.5px; color: #9CA3AF;">142 scans • 88% AI precision</span>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
