@extends('Frontend.layouts.public')

@section('title', 'Services — FixMate AI | Smart Home Services Made Simple')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header matching design -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">ALL CATEGORIES</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Our Services</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">Wide range of home services, from repair to maintenance, all with verified professionals.</p>
        </div>
    </section>

    <!-- Services Grid -->
    <section style="padding: 48px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                
                <!-- Plumbing -->
                <a href="{{ url('/services/plumbing') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#93C5FD';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #E0F2FE; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        💧
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Plumbing</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">120+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

                <!-- Electrical -->
                <a href="{{ url('/services/electrical') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#FDE68A';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #FEF3C7; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        ⚡
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Electrical</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">98+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

                <!-- AC Repair -->
                <a href="{{ url('/services/ac-cooling') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#A5F3FC';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #E0F7FA; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        ❄️
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">AC Repair</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">76+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

                <!-- Cleaning -->
                <a href="{{ url('/services/cleaning') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#86EFAC';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #DCFCE7; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        🧹
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Cleaning</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">64+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

                <!-- Painting -->
                <a href="{{ url('/services/painting') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#FDBA74';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #FFEDD5; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        🖌️
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Painting</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">52+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

                <!-- Carpentry -->
                <a href="{{ url('/services/carpentry') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#D8B4FE';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #F3E8FF; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        🔨
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Carpentry</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">48+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

                <!-- Appliance Repair -->
                <a href="{{ url('/services/appliance-repair') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#99F6E4';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #CCFBF1; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        🧺
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Appliance Repair</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">73+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

                <!-- Internet / Networking -->
                <a href="{{ url('/customer/diagnose?q=WiFi+Networking') }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#FDE68A';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #FFF9C4; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        🌐
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 4px;">Internet & WiFi</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 14px;">35+ Verified Technicians</span>
                    <span style="font-size: 13px; font-weight: 800; color: #2563EB;">View Details →</span>
                </a>

            </div>

            <!-- Clean Bottom CTA Banner matching guarantee -->
            <div style="margin-top: 48px; background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 18px; padding: 24px 32px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 4px 0;">Not sure what you need?</h3>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Describe your problem and let our AI find the right service and technician.</p>
                </div>
                <a href="{{ url('/customer/diagnose') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 24px; border-radius: 50px; text-decoration: none;">
                    Describe Problem →
                </a>
            </div>

        </div>
    </section>

</div>
@endsection
