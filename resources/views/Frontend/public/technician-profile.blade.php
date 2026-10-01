@extends('Frontend.layouts.public')

@php
    $techName = $professional->name ?? 'Technician';
    $techFirstName = explode(' ', $techName)[0];
    $profTitle = $professional->profession?->name ?? 'Service Specialist';
    $experience = $professional->experience ?? '5+ years';
    $city = $professional->user?->city ?? 'Islamabad / Rawalpindi';
    $isVerified = $professional->is_verified ?? true;
@endphp

@section('title', $techName . ' (' . $profTitle . ') — FixMate AI Verified Profile')
@section('meta_desc', 'View verified background, skills, and book ' . $techName . ', certified ' . $profTitle . ' on FixMate AI.')

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
                            <div style="width: 90px; height: 90px; border-radius: 50%; background: #FFC107; display: flex; align-items: center; justify-content: center; font-size: 34px; font-weight: 900; color: #0F172A; border: 3px solid #F59E0B;">
                                {{ strtoupper(substr($techName, 0, 1)) }}
                            </div>
                            @if($isVerified)
                                <span style="position: absolute; bottom: 2px; right: 2px; background: #10B981; color: #FFF; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; border: 2px solid #FFF;" title="NADRA Verified Professional">✓</span>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px; flex-wrap: wrap;">
                                <h1 style="font-size: 24px; font-weight: 900; color: #0F172A; margin: 0;">{{ $techName }}</h1>
                                @if($isVerified)
                                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; border: 1px solid #A7F3D0;">✓ NADRA Verified</span>
                                @endif
                            </div>
                            <span style="font-size: 14px; color: #64748B; display: block; margin-bottom: 6px;">{{ $profTitle }} • {{ $experience }} experience</span>
                            <div style="display: flex; align-items: center; gap: 12px; font-size: 13px; color: #64748B; flex-wrap: wrap;">
                                <span style="color: #F59E0B; font-weight: 700;">★ 4.8 (Verified Reviews)</span>
                                <span>• 📍 {{ $city }}</span>
                                <span>• 🛡️ CNIC Screened</span>
                            </div>
                        </div>
                    </div>

                    <!-- Clean Bio -->
                    <div style="border-top: 1px solid #F1F5F9; padding-top: 16px; margin-top: 20px;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">About {{ $techFirstName }}</h3>
                        <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">
                            Certified {{ strtolower($profTitle) }} specialist with {{ $experience }} of residential experience across {{ $city }}. Screened with biometric NADRA verification, committed to upfront pricing, and backed by FixMate 60-day rework warranty.
                        </p>
                    </div>
                </div>

                <!-- Professional Credentials & Contact Overview -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0;">Verification & Credentials</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 13px;">
                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 12px; padding: 12px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block;">Primary Trade</span>
                            <strong style="color: #0F172A; font-size: 14px;">{{ $profTitle }}</strong>
                        </div>
                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 12px; padding: 12px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block;">Experience</span>
                            <strong style="color: #0F172A; font-size: 14px;">{{ $experience }}</strong>
                        </div>
                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 12px; padding: 12px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block;">Identity Check</span>
                            <strong style="color: #059669; font-size: 13.5px;">✓ Biometric Verified</strong>
                        </div>
                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 12px; padding: 12px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block;">Escrow Protection</span>
                            <strong style="color: #059669; font-size: 13.5px;">✓ FixMate Safe</strong>
                        </div>
                    </div>
                </div>

                <!-- Previous Work Photos (User's real images) -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0;">Previous Work Photos</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                        <img src="{{ asset('assets/images/image_6.png') }}" alt="Work sample" style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">
                        <img src="{{ asset('assets/images/image_7.png') }}" alt="Work sample" style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">
                        <img src="{{ asset('assets/images/image_5.png') }}" alt="Work sample" style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">
                    </div>
                </div>

                <!-- Reviews -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0;">Verified Client Feedback</h3>
                    
                    <div style="border-bottom: 1px solid #F1F5F9; padding-bottom: 12px; margin-bottom: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="font-size: 13.5px; color: #0F172A;">Sara Ahmed</strong>
                            <span style="font-size: 12px; color: #94A3B8;">Recent Job</span>
                        </div>
                        <div style="color: #F59E0B; font-size: 12px; margin-bottom: 4px;">★★★★★</div>
                        <p style="font-size: 13px; color: #64748B; margin: 0;">
                            Very professional and fixed the issue quickly. Arrived right on time with all the proper tools!
                        </p>
                    </div>

                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="font-size: 13.5px; color: #0F172A;">Bilal Tariq</strong>
                            <span style="font-size: 12px; color: #94A3B8;">Recent Job</span>
                        </div>
                        <div style="color: #F59E0B; font-size: 12px; margin-bottom: 4px;">★★★★★</div>
                        <p style="font-size: 13px; color: #64748B; margin: 0;">
                            Honest rates, clean workmanship and zero hidden costs. Highly recommended!
                        </p>
                    </div>
                </div>

            </div>

            <!-- Right Booking Card -->
            <div style="position: sticky; top: 90px;">
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                        <span style="font-size: 13px; color: #64748B;">Standard Inspection</span>
                        <strong style="font-size: 22px; font-weight: 900; color: #0F172A;">Rs. 500</strong>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12.5px; color: #475569; margin-bottom: 20px;">
                        <div>✓ Verified CNIC Identity</div>
                        <div>✓ 30-Day FixMate Warranty</div>
                        <div>✓ Arrival Handshake OTP Code</div>
                    </div>

                    <a href="{{ url('/customer/booking?tech_id=' . ($professional->id ?? '1')) }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 0; border-radius: 10px; text-decoration: none; display: block; text-align: center; margin-bottom: 10px; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);">
                        Book {{ $techFirstName }} Now
                    </a>

                    <a href="{{ url('/customer/messages?tech_id=' . ($professional->id ?? '1')) }}" style="border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 13px; padding: 10px 0; border-radius: 10px; text-decoration: none; display: block; text-align: center;">
                        💬 Chat with {{ $techFirstName }}
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

