@extends('Frontend.layouts.technician')

@section('title', 'Technician Profile & Service Rates — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Partner Profile & Settings</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Manage your public marketplace presence, skills, service radius, and working schedule.</p>
    </div>

    <!-- Header Card matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="position: relative;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;">✓</span>
            </div>
            <div>
                <h2 style="font-size: 22px; font-weight: 900; color: #111; margin: 0 0 4px 0;">Ali Khan</h2>
                <span style="font-size: 14px; color: #666; display: block; margin-bottom: 6px;">Master Plumber • 8 Years Experience</span>
                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; border: 1px solid #A7F3D0;">
                    ✓ NADRA Verified Partner
                </span>
            </div>
        </div>
        <button class="btn-yellow" style="padding: 8px 20px; font-size: 13px; font-weight: 800;">Edit Profile</button>
    </div>

    <!-- Profile Sections matching Mockup 2 & 3 -->
    <div style="display: flex; flex-direction: column; gap: 18px;">
        
        <!-- Skills & Services -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Skills & Services</h3>
                <span style="font-size: 12px; color: #B45309; font-weight: 700; cursor: pointer;">Manage Skills</span>
            </div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <span style="background: #F3F4F6; color: #111; font-weight: 600; font-size: 13px; padding: 6px 12px; border-radius: 8px;">Plumbing</span>
                <span style="background: #F3F4F6; color: #111; font-weight: 600; font-size: 13px; padding: 6px 12px; border-radius: 8px;">Pipe Repair</span>
                <span style="background: #F3F4F6; color: #111; font-weight: 600; font-size: 13px; padding: 6px 12px; border-radius: 8px;">Sink Repair</span>
                <span style="background: #F3F4F6; color: #111; font-weight: 600; font-size: 13px; padding: 6px 12px; border-radius: 8px;">Bathroom Sanitary</span>
                <span style="background: #F3F4F6; color: #111; font-weight: 600; font-size: 13px; padding: 6px 12px; border-radius: 8px;">Water Motor Pump</span>
            </div>
        </div>

        <!-- Service Area & Dispatch Radius matching Mockup 2 & 3 -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Service Area & Dispatch Radius</h3>
                <span style="font-size: 12px; color: #B45309; font-weight: 700; cursor: pointer;">Edit Radius</span>
            </div>
            <div style="font-size: 14px; color: #4B5563; line-height: 1.6;">
                <strong>Primary City:</strong> Karachi<br>
                <strong>Covered Neighborhoods:</strong> DHA (Phase 1-8), Clifton (Block 1-9), Gulshan-e-Iqbal, PECHS<br>
                <strong>Maximum Travel Radius:</strong> 15 km from current GPS position
            </div>
        </div>

        <!-- Working Hours & Availability matching Mockup 2 & 3 -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Working Hours & Availability</h3>
                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">Currently Online</span>
            </div>
            <div style="font-size: 14px; color: #4B5563; line-height: 1.6;">
                <strong>Working Days:</strong> Monday to Saturday<br>
                <strong>Operating Shift:</strong> 9:00 AM – 7:00 PM<br>
                <strong>Emergency Callouts:</strong> Enabled (Urgent 30-min dispatches)
            </div>
        </div>

        <!-- Base Pricing matching Mockup 2 & 3 -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Base Pricing Structure</h3>
                <span style="font-size: 12px; color: #B45309; font-weight: 700; cursor: pointer;">Edit Rates</span>
            </div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                <div style="background: #F9FAFB; padding: 12px; border-radius: 10px;">
                    <span style="font-size: 11px; color: #777;">Inspection Visit</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Rs. 500</strong>
                </div>
                <div style="background: #F9FAFB; padding: 12px; border-radius: 10px;">
                    <span style="font-size: 11px; color: #777;">Sink / Tap Repair</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Rs. 500 – 800</strong>
                </div>
                <div style="background: #F9FAFB; padding: 12px; border-radius: 10px;">
                    <span style="font-size: 11px; color: #777;">Motor / Sanitary Fix</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Rs. 1,200 – 2,500</strong>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
