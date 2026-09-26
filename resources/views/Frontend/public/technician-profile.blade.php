@extends('Frontend.layouts.public')

@section('title', 'Ali Khan (Plumbing Specialist) — FixMate AI Verified Profile')

@section('content')
<div style="background: #FFFFFF; min-height: 85vh; padding: 36px 0 60px 0;">
    <div class="container" style="max-width: 920px;">
        
        <!-- Back link -->
        <div style="margin-bottom: 20px;">
            <a href="{{ url('/technicians') }}" style="color: #64748B; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                <span>←</span> <span>Back to Technicians</span>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1.25fr 0.75fr; gap: 32px; align-items: flex-start;">
            
            <!-- Left Profile Body -->
            <div>
                
                <!-- Main Header Card -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 28px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div style="position: relative;">
                            <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid #FFC107;">
                            <span style="position: absolute; bottom: 2px; right: 2px; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;">✓</span>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                                <h1 style="font-size: 24px; font-weight: 900; color: #0F172A; margin: 0;">Ali Khan</h1>
                                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; border: 1px solid #A7F3D0;">✓ Verified</span>
                            </div>
                            <span style="font-size: 14px; color: #64748B; display: block; margin-bottom: 6px;">Master Plumber • 8 years experience</span>
                            <div style="display: flex; align-items: center; gap: 12px; font-size: 13px; color: #64748B;">
                                <span style="color: #F59E0B; font-weight: 700;">★ 4.8 (120 reviews)</span>
                                <span>• 📍 3.2 km away</span>
                            </div>
                        </div>
                    </div>

                    <!-- Clean Bio -->
                    <div style="border-top: 1px solid #F1F5F9; padding-top: 16px; margin-top: 20px;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">About Ali</h3>
                        <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">
                            Certified sanitary and plumbing specialist with over 8 years of residential experience across Karachi. Specialized in kitchen sink repairs, non-destructive leak troubleshooting, pipe replacements, and water motor fitting.
                        </p>
                    </div>
                </div>

                <!-- Skills & Services -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0;">Skills & Services</h3>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <span style="background: #F8FAFC; border: 1px solid #E2E8F0; color: #0F172A; font-weight: 600; font-size: 12.5px; padding: 6px 12px; border-radius: 8px;">Plumbing</span>
                        <span style="background: #F8FAFC; border: 1px solid #E2E8F0; color: #0F172A; font-weight: 600; font-size: 12.5px; padding: 6px 12px; border-radius: 8px;">Kitchen Sink Repair</span>
                        <span style="background: #F8FAFC; border: 1px solid #E2E8F0; color: #0F172A; font-weight: 600; font-size: 12.5px; padding: 6px 12px; border-radius: 8px;">Pipe Leakage</span>
                        <span style="background: #F8FAFC; border: 1px solid #E2E8F0; color: #0F172A; font-weight: 600; font-size: 12.5px; padding: 6px 12px; border-radius: 8px;">Toilet & Sanitary</span>
                        <span style="background: #F8FAFC; border: 1px solid #E2E8F0; color: #0F172A; font-weight: 600; font-size: 12.5px; padding: 6px 12px; border-radius: 8px;">Water Motor Pump</span>
                    </div>
                </div>

                <!-- Previous Work Photos (User's real images) -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0;">Previous Work Photos</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                        <img src="{{ asset('assets/images/image_6.png') }}" alt="Kitchen sink repair" style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">
                        <img src="{{ asset('assets/images/image_7.png') }}" alt="Sanitary fitting" style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">
                        <img src="{{ asset('assets/images/image_5.png') }}" alt="Valve repair" style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">
                    </div>
                </div>

                <!-- Reviews -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0;">Customer Reviews</h3>
                    
                    <div style="border-bottom: 1px solid #F1F5F9; padding-bottom: 12px; margin-bottom: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="font-size: 13.5px; color: #0F172A;">Sara Ahmed</strong>
                            <span style="font-size: 12px; color: #94A3B8;">Sep 18, 2026</span>
                        </div>
                        <div style="color: #F59E0B; font-size: 12px; margin-bottom: 4px;">★★★★★</div>
                        <p style="font-size: 13px; color: #64748B; margin: 0;">
                            Very professional and fixed the pipe leakage issue quickly. Arrived on time!
                        </p>
                    </div>

                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="font-size: 13.5px; color: #0F172A;">Bilal Tariq</strong>
                            <span style="font-size: 12px; color: #94A3B8;">Sep 12, 2026</span>
                        </div>
                        <div style="color: #F59E0B; font-size: 12px; margin-bottom: 4px;">★★★★★</div>
                        <p style="font-size: 13px; color: #64748B; margin: 0;">
                            Honest rates, no extra hidden costs. Highly recommended for any plumbing work.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Right Booking Card -->
            <div style="position: sticky; top: 90px;">
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                        <span style="font-size: 13px; color: #64748B;">Base Inspection Fee</span>
                        <strong style="font-size: 22px; font-weight: 900; color: #0F172A;">Rs. 500</strong>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12.5px; color: #475569; margin-bottom: 20px;">
                        <div>✓ Verified CNIC Identity</div>
                        <div>✓ 30-Day FixMate Warranty</div>
                        <div>✓ Handshake OTP Verification</div>
                    </div>

                    <a href="{{ url('/customer/booking?tech=ali-khan') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 0; border-radius: 10px; text-decoration: none; display: block; text-align: center; margin-bottom: 10px; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);">
                        Book Now
                    </a>

                    <a href="{{ url('/customer/messages?tech=ali-khan') }}" style="border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 13px; padding: 10px 0; border-radius: 10px; text-decoration: none; display: block; text-align: center;">
                        💬 Chat with Ali
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
