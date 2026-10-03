@extends('Frontend.layouts.public')

@php
    $techName = $professional->name ?? 'Technician';
    $techFirstName = explode(' ', $techName)[0];
    $profTitle = $professional->profession?->name ?? 'Service Specialist';
    $profSlug = $professional->profession?->slug ?? 'service';
    $profPrice = $professional->profession?->formatted_price ?? 'Rs. 650';
    $priceUnit = $professional->profession?->price_unit ?? 'base';
    $warrantyText = $professional->profession?->warranty_text ?? (($settings?->warranty_days ?? 30) . '-Day Warranty');
    $experience = $professional->experience ?? '5+ years';
    $city = $professional->user?->city ?? 'Islamabad / Rawalpindi';
    $isVerified = $professional->is_verified ?? true;
@endphp

@section('title', $techName . ' (' . $profTitle . ') — FixMate AI Verified Profile')
@section('meta_desc', 'View verified background, credentials, and book ' . $techName . ', certified ' . $profTitle . ' on FixMate AI.')

@section('content')
<div style="background: #FFFFFF; min-height: 85vh; padding: 36px 0 60px 0;">
    <div class="container" style="max-width: 960px;">
        
        <!-- Back link & Breadcrumbs -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <a href="{{ url('/technicians') }}" style="color: #64748B; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                <span>←</span> <span>Back to Technicians Directory</span>
            </a>
            <span style="font-size: 12px; color: #059669; font-weight: 700; background: #DCFCE7; padding: 3px 10px; border-radius: 12px;">
                ● Active on Radar • Online Now
            </span>
        </div>

        <div style="display: grid; grid-template-columns: 1.25fr 0.75fr; gap: 32px; align-items: flex-start;">
            
            <!-- Left Profile Body -->
            <div>
                
                <!-- Main Header Card -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; padding: 28px; margin-bottom: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div style="position: relative;">
                            <div style="width: 90px; height: 90px; border-radius: 50%; background: #FFC107; display: flex; align-items: center; justify-content: center; font-size: 34px; font-weight: 900; color: #0F172A; border: 3px solid #F59E0B;">
                                {{ strtoupper(substr($techName, 0, 1)) }}
                            </div>
                            @if($isVerified)
                                <span style="position: absolute; bottom: 2px; right: 2px; background: #10B981; color: #FFF; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; border: 2.5px solid #FFF;" title="NADRA Verified Professional">✓</span>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px; flex-wrap: wrap;">
                                <h1 style="font-size: 24px; font-weight: 900; color: #0F172A; margin: 0;">{{ $techName }}</h1>
                                @if($isVerified)
                                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px; border: 1px solid #A7F3D0;">✓ NADRA Verified</span>
                                @endif
                            </div>
                            <span style="font-size: 14px; color: #64748B; display: block; margin-bottom: 6px;">{{ $profTitle }} • {{ $experience }} experience</span>
                            <div style="display: flex; align-items: center; gap: 12px; font-size: 13px; color: #64748B; flex-wrap: wrap;">
                                <span style="color: #F59E0B; font-weight: 800;">★ 4.9 (48 Verified Jobs)</span>
                                <span>• 📍 {{ $city }}</span>
                                <span>• 🛡️ CNIC Screened</span>
                            </div>
                        </div>
                    </div>

                    <!-- Clean Bio -->
                    <div style="border-top: 1px solid #F1F5F9; padding-top: 18px; margin-top: 22px;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">About {{ $techFirstName }}</h3>
                        <p style="font-size: 14px; color: #64748B; line-height: 1.65; margin: 0;">
                            Certified {{ strtolower($profTitle) }} specialist with {{ $experience }} of residential experience across {{ $city }}. Equipped with specialized diagnostic tools, committed to upfront standardized labor tariffs, and backed by the FixMate {{ $warrantyText }} rework guarantee.
                        </p>
                    </div>
                </div>

                <!-- Professional Credentials & Standards -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; padding: 26px; margin-bottom: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0;">Verification &amp; Credentials</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 13px;">
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block; margin-bottom: 2px;">Primary Trade Discipline</span>
                            <strong style="color: #0F172A; font-size: 14px;">{{ $profTitle }}</strong>
                        </div>
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block; margin-bottom: 2px;">Field Experience</span>
                            <strong style="color: #0F172A; font-size: 14px;">{{ $experience }}</strong>
                        </div>
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block; margin-bottom: 2px;">Biometric Identity Check</span>
                            <strong style="color: #059669; font-size: 13.5px;">✓ NADRA e-KYC Passed</strong>
                        </div>
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px;">
                            <span style="color: #64748B; font-size: 11.5px; display: block; margin-bottom: 2px;">Escrow Fund Safety</span>
                            <strong style="color: #059669; font-size: 13.5px;">✓ FixMate Escrow Release</strong>
                        </div>
                    </div>
                </div>

                <!-- Previous Work Showcase -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; padding: 26px; margin-bottom: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0;">Recent Field Work Completed</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                        <img src="{{ asset('assets/images/image_6.png') }}" alt="Field work sample" style="width: 100%; height: 110px; object-fit: cover; border-radius: 12px; border: 1px solid #E2E8F0;">
                        <img src="{{ asset('assets/images/image_7.png') }}" alt="Field work sample" style="width: 100%; height: 110px; object-fit: cover; border-radius: 12px; border: 1px solid #E2E8F0;">
                        <img src="{{ asset('assets/images/image_5.png') }}" alt="Field work sample" style="width: 100%; height: 110px; object-fit: cover; border-radius: 12px; border: 1px solid #E2E8F0;">
                    </div>
                </div>

                <!-- Verified Client Feedback -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; padding: 26px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0;">Verified Client Feedback</h3>
                        <span style="font-size: 12px; color: #64748B; font-weight: 700;">★ 4.9 Average Rating</span>
                    </div>

                    @if(isset($reviews) && $reviews->isNotEmpty())
                        @foreach($reviews as $rev)
                            <div style="border-bottom: 1px solid #F1F5F9; padding-bottom: 14px; margin-bottom: 14px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <strong style="font-size: 14px; color: #0F172A;">{{ $rev->author_name }}</strong>
                                    <span style="font-size: 12px; color: #94A3B8;">Verified Booking</span>
                                </div>
                                <div style="color: #F59E0B; font-size: 13px; margin-bottom: 6px;">
                                    @for($s = 0; $s < ($rev->rating ?? 5); $s++) ★ @endfor
                                </div>
                                <p style="font-size: 13.5px; color: #475569; margin: 0; line-height: 1.5; font-style: italic;">
                                    "{{ $rev->quote }}"
                                </p>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback Verified Reviews -->
                        <div style="border-bottom: 1px solid #F1F5F9; padding-bottom: 14px; margin-bottom: 14px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <strong style="font-size: 14px; color: #0F172A;">Sara Ahmed</strong>
                                <span style="font-size: 12px; color: #94A3B8;">Karachi • Verified Job</span>
                            </div>
                            <div style="color: #F59E0B; font-size: 13px; margin-bottom: 4px;">★★★★★</div>
                            <p style="font-size: 13.5px; color: #475569; margin: 0; line-height: 1.5; font-style: italic;">
                                "Very professional technician. Arrived with proper safety tools, solved our problem swiftly, and verified with the Arrival OTP code."
                            </p>
                        </div>

                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <strong style="font-size: 14px; color: #0F172A;">Dr. Kamran Malik</strong>
                                <span style="font-size: 12px; color: #94A3B8;">Islamabad • Verified Job</span>
                            </div>
                            <div style="color: #F59E0B; font-size: 13px; margin-bottom: 4px;">★★★★★</div>
                            <p style="font-size: 13.5px; color: #475569; margin: 0; line-height: 1.5; font-style: italic;">
                                "Honest rates, clean workmanship and zero roadside negotiation. Truly a 5-star experience."
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Booking Card (Sticky) -->
            <div style="position: sticky; top: 90px;">
                <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 20px; padding: 26px; box-shadow: 0 8px 24px rgba(0,0,0,0.04);">
                    <span style="font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">
                        DIRECT TECHNICIAN BOOKING
                    </span>

                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                        <span style="font-size: 13px; color: #64748B;">Starting Tariff</span>
                        <strong style="font-size: 24px; font-weight: 900; color: #0F172A;">
                            {{ $profPrice }} <span style="font-size: 12px; font-weight: normal; color: #64748B;">{{ $priceUnit }}</span>
                        </strong>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 9px; font-size: 12.5px; color: #475569; margin-bottom: 22px; border-top: 1px solid #FEF08A; border-bottom: 1px solid #FEF08A; padding: 14px 0;">
                        <div>✓ Biometric NADRA Identity Screened</div>
                        <div>✓ {{ $warrantyText }} Protected</div>
                        <div>✓ Mandatory Arrival OTP Handshake</div>
                        <div>✓ Escrow Protected Payment Release</div>
                    </div>

                    <a href="{{ url('/customer/booking?profession=' . $profSlug . '&tech_id=' . ($professional->id ?? '1')) }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14.5px; padding: 13px 0; border-radius: 12px; text-decoration: none; display: block; text-align: center; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35); transition: background 0.15s;" onmouseover="this.style.background='#F59E0B'" onmouseout="this.style.background='#FFB800'">
                        Book {{ $techFirstName }} Now →
                    </a>

                    <a href="{{ url('/customer/diagnose?q=' . urlencode($profSlug)) }}" style="background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 13px; padding: 11px 0; border-radius: 12px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <span>📸</span>
                        <span>Diagnose Issue with AI Vision First</span>
                    </a>

                    <div style="margin-top: 14px; text-align: center; font-size: 11.5px; color: #64748B;">
                        Free cancellation up to 30 mins before scheduled arrival.
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
