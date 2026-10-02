@extends('Frontend.layouts.public')

@section('title', 'About Us — FixMate AI | Intelligent Home Services')
@section('meta_desc', 'Learn about FixMate AI — Pakistan’s premier AI-powered home service platform uniting verified tradespeople with homeowners through smart computer vision diagnosis and escrow security.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Hero Header -->
    <section style="padding: 56px 0 44px 0; background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%); border-bottom: 1px solid #F1F5F9; text-align: center;">
        <div class="container" style="max-width: 860px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #FFB800;"></span>
                <span style="font-size: 12.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">About FixMate AI</span>
            </div>
            <h1 style="font-size: 42px; font-weight: 900; color: #0F172A; margin: 0 0 16px 0; letter-spacing: -0.03em; line-height: 1.15;">
                Transforming Home Maintenance with <span style="color: #FFB800;">AI Precision & Trust</span>
            </h1>
            <p style="font-size: 16.5px; color: #64748B; margin: 0 auto; line-height: 1.7; max-width: 700px;">
                FixMate AI is built on a simple conviction: hiring a home technician should be transparent, secure, and stress-free. We unite state-of-the-art computer vision diagnosis with verified local craftsmanship across Pakistan.
            </p>
        </div>
    </section>

    <!-- Platform Impact Numbers Banner (Dynamic) -->
    <section style="padding: 28px 0; background: #0F172A; color: #FFFFFF;">
        <div class="container" style="max-width: 1200px;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;">
                <div style="padding: 12px 16px; border-right: 1px solid rgba(255,255,255,0.08);">
                    <div style="font-size: 34px; font-weight: 900; color: #FFB800; letter-spacing: -0.02em;">{{ $stats['completed_jobs'] }}</div>
                    <div style="font-size: 13.5px; color: #94A3B8; font-weight: 500; margin-top: 4px;">Completed Jobs</div>
                </div>
                <div style="padding: 12px 16px; border-right: 1px solid rgba(255,255,255,0.08);">
                    <div style="font-size: 34px; font-weight: 900; color: #FFFFFF; letter-spacing: -0.02em;">{{ number_format($stats['verified_technicians']) }}+</div>
                    <div style="font-size: 13.5px; color: #94A3B8; font-weight: 500; margin-top: 4px;">Verified Technicians</div>
                </div>
                <div style="padding: 12px 16px; border-right: 1px solid rgba(255,255,255,0.08);">
                    <div style="font-size: 34px; font-weight: 900; color: #FFB800; letter-spacing: -0.02em;">{{ $stats['satisfaction_rate'] }}</div>
                    <div style="font-size: 13.5px; color: #94A3B8; font-weight: 500; margin-top: 4px;">Satisfaction Score</div>
                </div>
                <div style="padding: 12px 16px;">
                    <div style="font-size: 34px; font-weight: 900; color: #FFFFFF; letter-spacing: -0.02em;">{{ $stats['avg_arrival_mins'] }} Mins</div>
                    <div style="font-size: 13.5px; color: #94A3B8; font-weight: 500; margin-top: 4px;">Avg. Arrival Time</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story & Mission -->
    <section style="padding: 70px 0 60px 0;">
        <div class="container" style="max-width: 1160px;">
            <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 50px; align-items: center; margin-bottom: 70px;">
                <div>
                    <div style="display: inline-block; font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;">Our Mission</div>
                    <h2 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 0 0 20px 0; letter-spacing: -0.02em; line-height: 1.25;">
                        Solving the Broken Home Repair Experience in Pakistan
                    </h2>
                    <p style="font-size: 15px; color: #475569; line-height: 1.75; margin: 0 0 16px 0;">
                        For decades, booking a tradesperson in Pakistan was a gamble. Homeowners faced unverified workers entering their private spaces, unpredictable pricing with arbitrary quotes, and zero accountability if the problem recurred the next day.
                    </p>
                    <p style="font-size: 15px; color: #475569; line-height: 1.75; margin: 0 0 24px 0;">
                        FixMate AI changes this landscape completely. By deploying neural vision models to analyze defect photos before dispatch, we give homeowners accurate price benchmarks upfront. We back every technician with Nadra CNIC vetting, police record verification, and a 30-day workmanship warranty.
                    </p>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <div style="background: #F8FAFC; border-left: 3px solid #FFB800; padding: 12px 18px; border-radius: 0 10px 10px 0; flex: 1; min-width: 220px;">
                            <strong style="color: #0F172A; font-size: 14.5px; display: block; margin-bottom: 2px;">Zero Overcharging</strong>
                            <span style="color: #64748B; font-size: 13px;">AI sets transparent, standardized labor rates.</span>
                        </div>
                        <div style="background: #F8FAFC; border-left: 3px solid #10B981; padding: 12px 18px; border-radius: 0 10px 10px 0; flex: 1; min-width: 220px;">
                            <strong style="color: #0F172A; font-size: 14.5px; display: block; margin-bottom: 2px;">Protected Escrow</strong>
                            <span style="color: #64748B; font-size: 13px;">Funds are only released once the job is approved.</span>
                        </div>
                    </div>
                </div>
                <div style="position: relative;">
                    <img src="{{ asset('assets/images/image_7.png') }}" alt="Modern Home living with FixMate AI services" style="width: 100%; height: 380px; object-fit: cover; border-radius: 24px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);">
                    <div style="position: absolute; bottom: 20px; left: 20px; right: 20px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px); padding: 16px 20px; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 10px 25px rgba(0,0,0,0.06); display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: #FFB800; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                🛡️
                            </div>
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #0F172A;">FixMate Certified Protection</div>
                                <div style="font-size: 12px; color: #64748B;">NADRA Verified • Police Cleared</div>
                            </div>
                        </div>
                        <span style="background: #ECFDF5; color: #047857; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 50px;">100% Guaranteed</span>
                    </div>
                </div>
            </div>

            <!-- Dynamic Section: Certified Trade Disciplines -->
            @if($professions->isNotEmpty())
            <div style="margin-bottom: 70px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Our Coverage</span>
                        <h3 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 6px 0 0 0; letter-spacing: -0.02em;">
                            {{ $stats['total_professions'] }} Certified Trade Disciplines
                        </h3>
                    </div>
                    <a href="{{ url('/services') }}" style="color: #0F172A; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        Explore All Services <span style="color: #FFB800;">→</span>
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
                    @foreach($professions as $prof)
                    <a href="{{ url('/services/' . $prof->slug) }}" style="text-decoration: none; color: inherit; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px 16px; text-align: center; transition: all 0.2s;" onmouseover="this.style.borderColor='#FFB800'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.04)';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 20px; margin: 0 auto 12px auto;">
                            @if(str_contains(strtolower($prof->name), 'plumb')) 🔧
                            @elseif(str_contains(strtolower($prof->name), 'electr')) ⚡
                            @elseif(str_contains(strtolower($prof->name), 'ac') || str_contains(strtolower($prof->name), 'refrig')) ❄️
                            @elseif(str_contains(strtolower($prof->name), 'carpent')) 🪚
                            @elseif(str_contains(strtolower($prof->name), 'paint')) 🎨
                            @elseif(str_contains(strtolower($prof->name), 'clean')) 🧹
                            @else 🛠️
                            @endif
                        </div>
                        <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 4px;">{{ $prof->name }}</strong>
                        <span style="font-size: 12px; color: #64748B;">{{ $prof->professionals_count ?? 0 }} Specialists</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Dynamic Section: Featured Master Technicians -->
            @if($featuredProfessionals->isNotEmpty())
            <div style="margin-bottom: 70px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Vetted Craftsmanship</span>
                        <h3 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 6px 0 0 0; letter-spacing: -0.02em;">
                            Meet Our Certified Master Technicians
                        </h3>
                    </div>
                    <a href="{{ url('/technicians') }}" style="color: #0F172A; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        View All {{ $stats['total_technicians'] }} Technicians <span style="color: #FFB800;">→</span>
                    </a>
                </div>

                @php
                    $avatarList = [
                        asset('assets/images/image_1.png'),
                        asset('assets/images/image_2.png'),
                        asset('assets/images/image_3.png'),
                        asset('assets/images/image_4.png'),
                        asset('assets/images/image_5.png'),
                    ];
                @endphp

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;">
                    @foreach($featuredProfessionals as $idx => $pro)
                        @php
                            $avatar = $avatarList[$idx % count($avatarList)];
                        @endphp
                        <a href="{{ url('/technicians/' . $pro->id) }}" style="text-decoration: none; color: inherit; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; gap: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#FFB800'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.06)';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.02)';">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <img src="{{ $avatar }}" alt="{{ $pro->name }}" style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover; border: 2px solid #FFB800;">
                                <div style="flex: 1;">
                                    <strong style="display: block; font-size: 15.5px; color: #0F172A; margin-bottom: 2px;">{{ $pro->name }}</strong>
                                    <span style="font-size: 12.5px; color: #64748B; display: block; margin-bottom: 4px;">{{ $pro->profession?->name ?? 'Specialist' }}</span>
                                    <div style="font-size: 12px; color: #64748B; display: flex; align-items: center; gap: 6px;">
                                        <span style="color: #F59E0B; font-weight: 700;">★ 4.9</span>
                                        <span>• {{ $pro->experience ?? '5+ Years' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #F1F5F9; padding-top: 12px; margin-top: 2px;">
                                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px; border: 1px solid #A7F3D0; display: inline-flex; align-items: center; gap: 4px;">
                                    ✓ NADRA Verified
                                </span>
                                <span style="font-size: 12px; font-weight: 700; color: #0F172A;">
                                    View Profile →
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- How Our AI Works Deep Dive -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 24px; padding: 48px; margin-bottom: 70px;">
                <div style="text-align: center; max-width: 640px; margin: 0 auto 40px auto;">
                    <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Proprietary Technology</span>
                    <h3 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 8px 0 12px 0; letter-spacing: -0.02em;">How Our AI Diagnostics Engine Works</h3>
                    <p style="font-size: 14.5px; color: #64748B; margin: 0; line-height: 1.6;">Trained on over 250,000+ domestic repairs across electrical circuits, water pipelines, HVAC compressors, and furniture structures.</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 26px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                            👁️
                        </div>
                        <h4 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">1. Visual Defect Detection</h4>
                        <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">Our vision algorithm identifies corrosion, frayed wires, seal failures, or broken valves from a simple camera snapshot.</p>
                    </div>

                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 26px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #EFF6FF; border: 1px solid #DBEAFE; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                            📊
                        </div>
                        <h4 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">2. Pre-calculated Cost Index</h4>
                        <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">Estimates required replacement components and standard labor hours based on real-time hardware store index pricing.</p>
                    </div>

                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 26px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #ECFDF5; border: 1px solid #A7F3D0; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                            ⚡
                        </div>
                        <h4 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">3. Proximity Radar Dispatch</h4>
                        <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">Matches you with the closest qualified specialist with the exact tool inventory required to resolve your specific problem.</p>
                    </div>
                </div>
            </div>

            <!-- 4 Pillars of Excellence -->
            <div style="margin-bottom: 70px;">
                <div style="text-align: center; max-width: 600px; margin: 0 auto 36px auto;">
                    <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Our Standards</span>
                    <h3 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 8px 0 10px 0; letter-spacing: -0.02em;">Built on Trust, Backed by Technology</h3>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <div style="border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; background: #FFFFFF; text-align: center;">
                        <div style="font-size: 32px; margin-bottom: 12px;">🪪</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 6px;">CNIC & Police Vetting</strong>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">100% NADRA identity verification and background checks before any technician enters a home.</p>
                    </div>

                    <div style="border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; background: #FFFFFF; text-align: center;">
                        <div style="font-size: 32px; margin-bottom: 12px;">🔐</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 6px;">Arrival OTP Handshake</strong>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">Only share your 4-digit code when the technician arrives, verifying identity on the spot.</p>
                    </div>

                    <div style="border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; background: #FFFFFF; text-align: center;">
                        <div style="font-size: 32px; margin-bottom: 12px;">💳</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 6px;">Escrow Fund Security</strong>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">Your payment is safely held in escrow and released only after your final satisfaction approval.</p>
                    </div>

                    <div style="border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; background: #FFFFFF; text-align: center;">
                        <div style="font-size: 32px; margin-bottom: 12px;">🛠️</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 6px;">30-Day Work Warranty</strong>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">If an issue recurs within a month, we send a technician back for free re-inspection and repair.</p>
                    </div>
                </div>
            </div>

            <!-- Call to Action Banner -->
            <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 24px; padding: 48px; color: #FFFFFF; display: flex; align-items: center; justify-content: space-between; gap: 30px; flex-wrap: wrap;">
                <div>
                    <h3 style="font-size: 26px; font-weight: 900; margin: 0 0 10px 0; color: #FFFFFF; letter-spacing: -0.02em;">Ready for smarter, stress-free home maintenance?</h3>
                    <p style="font-size: 14.5px; color: #94A3B8; margin: 0; max-width: 580px; line-height: 1.6;">Experience the convenience of AI diagnosis and certified professional dispatch in Lahore, Karachi, and Islamabad.</p>
                </div>
                <div style="display: flex; gap: 14px; flex-shrink: 0;">
                    <a href="{{ url('/technicians') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14.5px; padding: 13px 26px; border-radius: 10px; text-decoration: none; transition: all 0.2s;">
                        Find a Technician
                    </a>
                    <a href="{{ url('/become-technician') }}" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; font-weight: 700; font-size: 14.5px; padding: 13px 24px; border-radius: 10px; text-decoration: none; transition: all 0.2s;">
                        Become a Partner
                    </a>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
