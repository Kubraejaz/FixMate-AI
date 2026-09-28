@extends('Frontend.layouts.public')

@section('title', 'All Services & Upfront Pricing — FixMate AI')
@section('meta_desc', 'Explore verified home repair and maintenance services in Pakistan. Transparent pricing for Plumbing, Electrical, AC, Carpentry, Painting, and Cleaning.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Executive Header -->
    <section style="padding: 48px 0 36px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 780px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">VERIFIED HOME REPAIR DIRECTORY</span>
            </div>
            <h1 style="font-size: 38px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                Professional Services, Guaranteed Quality
            </h1>
            <p style="font-size: 15.5px; color: #64748B; margin: 0; line-height: 1.6;">
                No roadside negotiations or surprise invoices. Book licensed tradespeople with fixed transparent pricing, live tracking, and 60-day rework warranty.
            </p>

            <!-- Problem Quick Search & AI Scan Bar -->
            <div style="margin-top: 24px; display: inline-flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                <a href="{{ url('/customer/diagnose') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 24px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(255, 184, 0, 0.35);">
                    <span>📸</span>
                    <span>Diagnose Problem with AI Vision</span>
                </a>
                <a href="#price-guide" style="background: #FFFFFF; color: #0F172A; border: 1px solid #CBD5E1; font-weight: 700; font-size: 14px; padding: 11px 22px; border-radius: 50px; text-decoration: none;">
                    View Standard Price Guide ↓
                </a>
            </div>
        </div>
    </section>

    <!-- Services Grid Section -->
    <section style="padding: 48px 0 60px 0;">
        <div class="container">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px;">
                <div>
                    <h2 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Available Service Categories</h2>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Select a trade to view pre-screened certified technicians in your neighborhood.</p>
                </div>
                <span style="font-size: 13px; font-weight: 700; color: #059669; background: #DCFCE7; padding: 4px 12px; border-radius: 20px;">
                    ● 2,400+ Verified Pros Active
                </span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                
                <!-- 1. Plumbing -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 26px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#93C5FD'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #E0F2FE; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                            💧
                        </div>
                        <span style="font-size: 11.5px; font-weight: 700; color: #0369A1; background: #E0F2FE; padding: 3px 10px; border-radius: 12px;">120+ Technicians</span>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Plumbing & Sanitary</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
                        Leak detection, pipe repairs, geyser servicing, commode fittings, water pump fixes, and unclogging.
                    </p>
                    <div style="border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 12px 0; margin-bottom: 16px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px;">
                        <div>✓ Pipe leak repair & Teflon sealing</div>
                        <div>✓ Electric/Gas geyser heating element & thermostat</div>
                        <div>✓ Water pressure motor & suction pump overhaul</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748B;">Starting from</span>
                        <strong style="font-size: 16px; color: #0F172A;">Rs. 650 <span style="font-size: 11px; font-weight: normal; color: #64748B;">base</span></strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ url('/services/plumbing') }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Details</a>
                        <a href="{{ url('/register/role') }}" style="text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">Book with AI</a>
                    </div>
                </div>

                <!-- 2. Electrical -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 26px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#FDE68A'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #FEF3C7; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                            ⚡
                        </div>
                        <span style="font-size: 11.5px; font-weight: 700; color: #92400E; background: #FEF3C7; padding: 3px 10px; border-radius: 12px;">98+ Technicians</span>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Electrical & Power Backup</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
                        Short-circuit tracing, circuit breaker replacement, DB wiring, ceiling fans, UPS, and inverter setups.
                    </p>
                    <div style="border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 12px 0; margin-bottom: 16px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px;">
                        <div>✓ Short circuit detection & breaker trip repair</div>
                        <div>✓ UPS/Inverter wiring & battery maintenance</div>
                        <div>✓ SMD light & modern chandelier installations</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748B;">Starting from</span>
                        <strong style="font-size: 16px; color: #0F172A;">Rs. 700 <span style="font-size: 11px; font-weight: normal; color: #64748B;">base</span></strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ url('/services/electrical') }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Details</a>
                        <a href="{{ url('/register/role') }}" style="text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">Book with AI</a>
                    </div>
                </div>

                <!-- 3. AC & HVAC Cooling -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 26px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#A5F3FC'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #E0F7FA; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                            ❄️
                        </div>
                        <span style="font-size: 11.5px; font-weight: 700; color: #0E7490; background: #E0F7FA; padding: 3px 10px; border-radius: 12px;">76+ Technicians</span>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">AC & HVAC Cooling</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
                        Inverter AC servicing, chemical master jet wash, refrigerant gas refill, compressor troubleshooting, and mounting.
                    </p>
                    <div style="border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 12px 0; margin-bottom: 16px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px;">
                        <div>✓ High-pressure foam deep wash indoor & outdoor</div>
                        <div>✓ Genuine DuPont / Honeywell R410a / R32 gas refill</div>
                        <div>✓ Inverter PCB board sensor diagnosis & repair</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748B;">Starting from</span>
                        <strong style="font-size: 16px; color: #0F172A;">Rs. 1,499 <span style="font-size: 11px; font-weight: normal; color: #64748B;">service</span></strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ url('/services/ac-cooling') }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Details</a>
                        <a href="{{ url('/register/role') }}" style="text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">Book with AI</a>
                    </div>
                </div>

                <!-- 4. Deep Home Cleaning -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 26px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#86EFAC'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #DCFCE7; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                            🧹
                        </div>
                        <span style="font-size: 11.5px; font-weight: 700; color: #15803D; background: #DCFCE7; padding: 3px 10px; border-radius: 12px;">64+ Teams</span>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Deep Cleaning & Fumigation</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
                        Full home pre-move in scrubbing, sofa & carpet extraction, tile descaling, kitchen grease removal, and pest control.
                    </p>
                    <div style="border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 12px 0; margin-bottom: 16px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px;">
                        <div>✓ Hospital-grade eco-friendly disinfectant wash</div>
                        <div>✓ Industrial vacuum upholstery steam cleaning</div>
                        <div>✓ Post-construction deep residue stripping</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748B;">Starting from</span>
                        <strong style="font-size: 16px; color: #0F172A;">Rs. 2,499 <span style="font-size: 11px; font-weight: normal; color: #64748B;">package</span></strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ url('/services/cleaning') }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Details</a>
                        <a href="{{ url('/register/role') }}" style="text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">Book with AI</a>
                    </div>
                </div>

                <!-- 5. Painting & Waterproofing -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 26px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#FDBA74'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #FFEDD5; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                            🖌️
                        </div>
                        <span style="font-size: 11.5px; font-weight: 700; color: #C2410C; background: #FFEDD5; padding: 3px 10px; border-radius: 12px;">52+ Painters</span>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Painting & Waterproofing</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
                        Interior wall repainting, exterior weather-sheeting, ceiling seepage treatment, primer coating, and polish.
                    </p>
                    <div style="border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 12px 0; margin-bottom: 16px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px;">
                        <div>✓ Roof chemical elastomeric waterproofing</div>
                        <div>✓ Wall putty smooth finish & anti-fungal paint</div>
                        <div>✓ Wood door lacquer & deco paint finish</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748B;">Starting from</span>
                        <strong style="font-size: 16px; color: #0F172A;">Rs. 25 <span style="font-size: 11px; font-weight: normal; color: #64748B;">/ sq.ft</span></strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ url('/services/painting') }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Details</a>
                        <a href="{{ url('/register/role') }}" style="text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">Book with AI</a>
                    </div>
                </div>

                <!-- 6. Carpentry & Furniture Repair -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 26px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#D8B4FE'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #F3E8FF; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                            🔨
                        </div>
                        <span style="font-size: 11.5px; font-weight: 700; color: #7E22CE; background: #F3E8FF; padding: 3px 10px; border-radius: 12px;">48+ Carpenters</span>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Carpentry & Woodwork</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
                        Door lock replacement, hinge tightening, wardrobe channel repair, custom shelving, and wooden furniture repairs.
                    </p>
                    <div style="border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 12px 0; margin-bottom: 16px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px;">
                        <div>✓ Main door smart lock & deadbolt fittings</div>
                        <div>✓ Kitchen cabinet hydraulic hinges & runners</div>
                        <div>✓ Wooden bed frame & sofa structure repair</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748B;">Starting from</span>
                        <strong style="font-size: 16px; color: #0F172A;">Rs. 800 <span style="font-size: 11px; font-weight: normal; color: #64748B;">base</span></strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ url('/services/carpentry') }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Details</a>
                        <a href="{{ url('/register/role') }}" style="text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">Book with AI</a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Transparent Price Guide Table -->
    <section id="price-guide" style="padding: 50px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 960px;">
            <div style="text-align: center; margin-bottom: 36px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase;">TRANSPARENT TARIFF</span>
                <h2 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 4px 0 8px 0;">Standard Service Pricing Benchmark</h2>
                <p style="font-size: 14.5px; color: #64748B; margin: 0;">Verified labor benchmarks across Islamabad, Lahore, and Karachi. Parts billed at actual market receipt.</p>
            </div>

            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background: #0F172A; color: #FFFFFF; font-size: 13px; text-transform: uppercase; letter-spacing: 0.04em;">
                            <th style="padding: 16px 20px;">Service Name</th>
                            <th style="padding: 16px 20px;">Estimated Time</th>
                            <th style="padding: 16px 20px;">Standard Rate (PKR)</th>
                            <th style="padding: 16px 20px;">Warranty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 14px 20px; font-weight: 600; color: #0F172A;">💧 Kitchen / Basin Tap Replacement</td>
                            <td style="padding: 14px 20px; color: #64748B;">30 – 45 mins</td>
                            <td style="padding: 14px 20px; font-weight: 800; color: #0F172A;">Rs. 600 – 850</td>
                            <td style="padding: 14px 20px;"><span style="color: #059669; font-weight: 700;">60 Days Escrow</span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9; background: #FAFAFA;">
                            <td style="padding: 14px 20px; font-weight: 600; color: #0F172A;">⚡ Ceiling / Exhaust Fan Installation</td>
                            <td style="padding: 14px 20px; color: #64748B;">45 mins</td>
                            <td style="padding: 14px 20px; font-weight: 800; color: #0F172A;">Rs. 650 – 950</td>
                            <td style="padding: 14px 20px;"><span style="color: #059669; font-weight: 700;">60 Days Escrow</span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 14px 20px; font-weight: 600; color: #0F172A;">❄️ AC Split Master Jet Foam Wash</td>
                            <td style="padding: 14px 20px; color: #64748B;">60 – 75 mins</td>
                            <td style="padding: 14px 20px; font-weight: 800; color: #0F172A;">Rs. 1,499 – 2,199</td>
                            <td style="padding: 14px 20px;"><span style="color: #059669; font-weight: 700;">30 Days Cooling</span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9; background: #FAFAFA;">
                            <td style="padding: 14px 20px; font-weight: 600; color: #0F172A;">⚡ DB Box Breaker / Short Circuit Diagnosis</td>
                            <td style="padding: 14px 20px; color: #64748B;">60 mins</td>
                            <td style="padding: 14px 20px; font-weight: 800; color: #0F172A;">Rs. 1,200 – 1,800</td>
                            <td style="padding: 14px 20px;"><span style="color: #059669; font-weight: 700;">60 Days Escrow</span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 14px 20px; font-weight: 600; color: #0F172A;">💧 Gas / Electric Geyser Seasonal Servicing</td>
                            <td style="padding: 14px 20px; color: #64748B;">60 – 90 mins</td>
                            <td style="padding: 14px 20px; font-weight: 800; color: #0F172A;">Rs. 1,200 – 1,800</td>
                            <td style="padding: 14px 20px;"><span style="color: #059669; font-weight: 700;">60 Days Escrow</span></td>
                        </tr>
                        <tr style="background: #FAFAFA;">
                            <td style="padding: 14px 20px; font-weight: 600; color: #0F172A;">🔨 Main Door Smart Lock Installation</td>
                            <td style="padding: 14px 20px; color: #64748B;">60 – 90 mins</td>
                            <td style="padding: 14px 20px; font-weight: 800; color: #0F172A;">Rs. 1,500 – 2,200</td>
                            <td style="padding: 14px 20px;"><span style="color: #059669; font-weight: 700;">90 Days Escrow</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <p style="text-align: center; font-size: 13px; color: #64748B; margin-top: 14px;">
                💡 <em>All prices are verified fixed labor rates. Technicians are prohibited from negotiating higher rates upon arrival.</em>
            </p>
        </div>
    </section>

    <!-- The FixMate AI Quality Standards Strip -->
    <section style="padding: 50px 0; background: #FFFFFF;">
        <div class="container">
            <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 20px; padding: 36px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 36px; align-items: center;">
                    <div>
                        <span style="font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase;">THE FIXMATE PROMISE</span>
                        <h3 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 4px 0 12px 0;">Never Worry About Unreliable Handymen Again</h3>
                        <p style="font-size: 14.5px; color: #475569; line-height: 1.6; margin: 0 0 20px 0;">
                            In conventional local markets, finding an electrician or plumber means uncertain pricing, no background checks, and zero warranty when things break again. FixMate AI redesigns the entire experience with accountability.
                        </p>
                        <div style="display: flex; gap: 12px;">
                            <a href="{{ url('/how-it-works') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 22px; border-radius: 50px; text-decoration: none;">
                                How It Works →
                            </a>
                            <a href="{{ url('/about') }}" style="border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 13.5px; padding: 10px 20px; border-radius: 50px; text-decoration: none;">
                                Our Safety Standards
                            </a>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div style="background: #FFFFFF; border: 1px solid #FEF08A; border-radius: 14px; padding: 18px;">
                            <span style="font-size: 22px;">🪪</span>
                            <strong style="display: block; font-size: 14px; color: #0F172A; margin: 6px 0 4px 0;">NADRA e-KYC</strong>
                            <p style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;">Every technician is biometrically verified against national ID databases.</p>
                        </div>

                        <div style="background: #FFFFFF; border: 1px solid #FEF08A; border-radius: 14px; padding: 18px;">
                            <span style="font-size: 22px;">🔑</span>
                            <strong style="display: block; font-size: 14px; color: #0F172A; margin: 6px 0 4px 0;">Gate Arrival OTP</strong>
                            <p style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;">Job begins only after you authenticate the technician's 4-digit code.</p>
                        </div>

                        <div style="background: #FFFFFF; border: 1px solid #FEF08A; border-radius: 14px; padding: 18px;">
                            <span style="font-size: 22px;">🛡️</span>
                            <strong style="display: block; font-size: 14px; color: #0F172A; margin: 6px 0 4px 0;">Escrow Protection</strong>
                            <p style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;">Funds held in trust and released solely when you approve the finished job.</p>
                        </div>

                        <div style="background: #FFFFFF; border: 1px solid #FEF08A; border-radius: 14px; padding: 18px;">
                            <span style="font-size: 22px;">🔁</span>
                            <strong style="display: block; font-size: 14px; color: #0F172A; margin: 6px 0 4px 0;">60-Day Rework</strong>
                            <p style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;">If the repair fails, a supervisor is re-dispatched at zero extra fee.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
