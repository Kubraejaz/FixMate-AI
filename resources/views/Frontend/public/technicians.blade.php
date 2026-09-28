@extends('Frontend.layouts.public')

@section('title', 'Find Verified Technicians — FixMate AI')
@section('meta_desc', 'Browse NADRA-verified, background-checked plumbers, electricians, AC technicians, and carpenters near you in Pakistan.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Executive Header -->
    <section style="padding: 48px 0 36px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 780px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">VERIFIED LOCAL PROS</span>
            </div>
            <h1 style="font-size: 38px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                Find Top-Rated Technicians Near You
            </h1>
            <p style="font-size: 15.5px; color: #64748B; margin: 0; line-height: 1.6;">
                Every specialist is NADRA biometric-screened, skills-certified, and insured with FixMate Escrow payment release.
            </p>
        </div>
    </section>

    <!-- Search & Filter Bar Section -->
    <section style="padding: 32px 0 20px 0;">
        <div class="container">
            
            <!-- Filter Bar -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 12px 18px; display: flex; gap: 14px; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.03); flex-wrap: wrap;">
                <div style="flex: 1; min-width: 240px; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 18px; color: #94A3B8;">🔍</span>
                    <input type="text" placeholder="Search by name, skill (e.g. Inverter AC, Leak repair)..." style="width: 100%; border: none; background: transparent; outline: none; font-size: 14px; font-family: inherit;">
                </div>
                <div style="border-left: 1px solid #CBD5E1; padding-left: 14px;">
                    <select style="border: none; background: transparent; outline: none; font-size: 13.5px; font-weight: 700; color: #0F172A; cursor: pointer;">
                        <option>All Specialities</option>
                        <option>Master Plumber</option>
                        <option>Licensed Electrician</option>
                        <option>HVAC / AC Technician</option>
                        <option>Finish Carpenter</option>
                        <option>Deep Cleaning Specialist</option>
                    </select>
                </div>
                <div style="border-left: 1px solid #CBD5E1; padding-left: 14px;">
                    <select style="border: none; background: transparent; outline: none; font-size: 13.5px; font-weight: 700; color: #0F172A; cursor: pointer;">
                        <option>All Cities (Pakistan)</option>
                        <option>Islamabad / Rawalpindi</option>
                        <option>Lahore</option>
                        <option>Karachi</option>
                        <option>Peshawar</option>
                        <option>Faisalabad</option>
                    </select>
                </div>
                <button style="background: #FFB800; border: none; outline: none; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 800; color: #0F172A; cursor: pointer; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                    Find Pro
                </button>
            </div>

            <!-- Quick Filter Chips -->
            <div style="display: flex; gap: 10px; margin-top: 14px; flex-wrap: wrap; font-size: 13px;">
                <span style="font-weight: 700; color: #64748B; align-self: center;">Quick Filters:</span>
                <span style="background: #0F172A; color: #FFF; padding: 4px 14px; border-radius: 50px; font-weight: 700; cursor: pointer;">All (2,400+)</span>
                <span style="background: #F1F5F9; color: #334155; padding: 4px 14px; border-radius: 50px; font-weight: 600; cursor: pointer;">⚡ Available Now (&lt; 30 mins)</span>
                <span style="background: #F1F5F9; color: #334155; padding: 4px 14px; border-radius: 50px; font-weight: 600; cursor: pointer;">★ Top Rated (4.8+)</span>
                <span style="background: #F1F5F9; color: #334155; padding: 4px 14px; border-radius: 50px; font-weight: 600; cursor: pointer;">🛡️ Emergency Squad Certified</span>
            </div>

        </div>
    </section>

    <!-- Technicians Grid Section -->
    <section style="padding: 24px 0 60px 0;">
        <div class="container">
            
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px;">
                
                <!-- 1. Ali Khan -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="position: relative; width: 76px; height: 76px; margin: 0 auto 12px auto;">
                            <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2.5px solid #FFB800;">
                            <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;" title="NADRA Verified Pro">✓</span>
                        </div>
                        <div style="display: inline-block; background: #DCFCE7; color: #15803D; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 20px; margin-bottom: 6px;">● ONLINE NOW</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Ali Khan</strong>
                        <span style="font-size: 12.5px; color: #64748B; display: block; margin-bottom: 6px;">Master Plumber • 8 yrs exp</span>
                        
                        <div style="font-size: 12px; color: #64748B; margin-bottom: 12px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                            <span style="color: #D97706; font-weight: 800;">★ 4.8</span>
                            <span>(124 jobs)</span>
                            <span>•</span>
                            <span style="color: #0F172A; font-weight: 600;">📍 2.8 km</span>
                        </div>

                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 10px; padding: 8px; font-size: 12px; color: #475569; margin-bottom: 14px; text-align: left;">
                            <div>• Pipe leak detection & repair</div>
                            <div>• Geyser thermostat & element</div>
                            <div>• High-rise bathroom fittings</div>
                        </div>
                    </div>

                    <a href="{{ url('/register/role') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 0; border-radius: 10px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                        Book Technician →
                    </a>
                </div>

                <!-- 2. Rida Ahmed -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="position: relative; width: 76px; height: 76px; margin: 0 auto 12px auto;">
                            <img src="{{ asset('assets/images/image_2.png') }}" alt="Rida Ahmed" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2.5px solid #FFB800;">
                            <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;" title="NADRA Verified Pro">✓</span>
                        </div>
                        <div style="display: inline-block; background: #DCFCE7; color: #15803D; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 20px; margin-bottom: 6px;">● ONLINE NOW</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Rida Ahmed</strong>
                        <span style="font-size: 12.5px; color: #64748B; display: block; margin-bottom: 6px;">Senior Electrician • 6 yrs exp</span>
                        
                        <div style="font-size: 12px; color: #64748B; margin-bottom: 12px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                            <span style="color: #D97706; font-weight: 800;">★ 4.9</span>
                            <span>(98 jobs)</span>
                            <span>•</span>
                            <span style="color: #0F172A; font-weight: 600;">📍 1.9 km</span>
                        </div>

                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 10px; padding: 8px; font-size: 12px; color: #475569; margin-bottom: 14px; text-align: left;">
                            <div>• DB Short-circuit fault tracing</div>
                            <div>• UPS / Inverter panel wiring</div>
                            <div>• Smart home lighting switches</div>
                        </div>
                    </div>

                    <a href="{{ url('/register/role') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 0; border-radius: 10px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                        Book Technician →
                    </a>
                </div>

                <!-- 3. Imran Shah -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="position: relative; width: 76px; height: 76px; margin: 0 auto 12px auto;">
                            <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2.5px solid #FFB800;">
                            <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;" title="NADRA Verified Pro">✓</span>
                        </div>
                        <div style="display: inline-block; background: #DCFCE7; color: #15803D; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 20px; margin-bottom: 6px;">● ONLINE NOW</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Imran Shah</strong>
                        <span style="font-size: 12.5px; color: #64748B; display: block; margin-bottom: 6px;">HVAC & AC Lead • 7 yrs exp</span>
                        
                        <div style="font-size: 12px; color: #64748B; margin-bottom: 12px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                            <span style="color: #D97706; font-weight: 800;">★ 4.7</span>
                            <span>(142 jobs)</span>
                            <span>•</span>
                            <span style="color: #0F172A; font-weight: 600;">📍 3.4 km</span>
                        </div>

                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 10px; padding: 8px; font-size: 12px; color: #475569; margin-bottom: 14px; text-align: left;">
                            <div>• Inverter AC PCB troubleshooting</div>
                            <div>• Master chemical pressure wash</div>
                            <div>• Pure R410a gas charging</div>
                        </div>
                    </div>

                    <a href="{{ url('/register/role') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 0; border-radius: 10px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                        Book Technician →
                    </a>
                </div>

                <!-- 4. Umar Tariq -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="position: relative; width: 76px; height: 76px; margin: 0 auto 12px auto;">
                            <img src="{{ asset('assets/images/image_4.png') }}" alt="Umar Tariq" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2.5px solid #FFB800;">
                            <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;" title="NADRA Verified Pro">✓</span>
                        </div>
                        <div style="display: inline-block; background: #DCFCE7; color: #15803D; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 20px; margin-bottom: 6px;">● ONLINE NOW</div>
                        <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Umar Tariq</strong>
                        <span style="font-size: 12.5px; color: #64748B; display: block; margin-bottom: 6px;">Finish Carpenter • 5 yrs exp</span>
                        
                        <div style="font-size: 12px; color: #64748B; margin-bottom: 12px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                            <span style="color: #D97706; font-weight: 800;">★ 4.6</span>
                            <span>(89 jobs)</span>
                            <span>•</span>
                            <span style="color: #0F172A; font-weight: 600;">📍 4.1 km</span>
                        </div>

                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 10px; padding: 8px; font-size: 12px; color: #475569; margin-bottom: 14px; text-align: left;">
                            <div>• Hydraulic kitchen cabinet hinges</div>
                            <div>• Main entrance deadbolt & smart lock</div>
                            <div>• Custom wooden door polish</div>
                        </div>
                    </div>

                    <a href="{{ url('/register/role') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 0; border-radius: 10px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                        Book Technician →
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- 5-Step Technician Vetting Section -->
    <section style="padding: 50px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 980px;">
            <div style="text-align: center; margin-bottom: 36px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase;">SAFETY PROTOCOL</span>
                <h2 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 4px 0 8px 0;">How We Vet Every Handyman</h2>
                <p style="font-size: 14.5px; color: #64748B; margin: 0;">Only the top 12% of applicants qualify to enter your home under the FixMate AI standard.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">1</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">NADRA Biometric</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Every technician’s national CNIC and criminal records are verified with police registration.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">2</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">In-Field Practical Test</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Hands-on testing on simulated plumbing manifolds, electrical panels, and inverter boards.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">3</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">Gate Arrival OTP</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Technicians cannot start a job without customer pin verification, preventing unauthorized entry.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">4</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">4.5★ Retention Rule</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Partners whose average drops below 4.5 are automatically suspended until retraining.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Partner CTA Strip -->
    <section style="padding: 40px 0; background: #FFFFFF;">
        <div class="container" style="max-width: 840px;">
            <div style="background: #0F172A; border-radius: 18px; padding: 30px 36px; display: flex; align-items: center; justify-content: space-between; color: #FFFFFF; gap: 24px;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 900; margin: 0 0 6px 0; color: #FFFFFF;">Are you a skilled plumber, electrician, or AC tech?</h3>
                    <p style="font-size: 13.5px; color: #94A3B8; margin: 0;">Get high-paying jobs in your area and earn up to Rs. 120,000+ monthly with guaranteed weekly payouts.</p>
                </div>
                <a href="{{ url('/become-technician') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 12px 26px; border-radius: 50px; text-decoration: none; white-space: nowrap;">
                    Join as Partner →
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
