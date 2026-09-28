@extends('Frontend.layouts.public')

@section('title', 'Community Issues & Civic Maintenance — FixMate AI')
@section('meta_desc', 'Report and track neighborhood maintenance issues like water pipeline leaks, sparking power lines, and broken streetlights across Pakistan.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Executive Header -->
    <section style="padding: 48px 0 36px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 780px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">PUBLIC CIVIC & NEIGHBORHOOD FEED</span>
            </div>
            <h1 style="font-size: 38px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                Neighborhood Maintenance Feed
            </h1>
            <p style="font-size: 15.5px; color: #64748B; margin: 0; line-height: 1.6;">
                FixMate AI enables residents to report, upvote, and coordinate rapid technician squad dispatch for communal hazards like main line water leaks, transformer sparking, and street dark zones.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 36px 0 60px 0;">
        <div class="container" style="max-width: 880px;">
            
            <!-- Civic Guarantee Banner -->
            <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 16px; padding: 18px 24px; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <span style="font-size: 26px;">🏘️</span>
                    <div>
                        <strong style="font-size: 14px; color: #0F172A; display: block;">Civic Partnership Program</strong>
                        <p style="font-size: 12.5px; color: #64748B; margin: 0;">Community issues with 25+ upvotes are escalated immediately to registered housing societies or municipal dispatch teams.</p>
                    </div>
                </div>
                <a href="{{ url('/login?redirect=community') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 22px; border-radius: 50px; text-decoration: none; white-space: nowrap; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                    + Report Civic Hazard
                </a>
            </div>

            <!-- Feed Filter Tabs -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; gap: 8px;">
                    <button style="background: #0F172A; color: #FFF; border: none; padding: 6px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; cursor: pointer;">All Cities (4)</button>
                    <button style="background: #F1F5F9; color: #475569; border: none; padding: 6px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; cursor: pointer;">Karachi</button>
                    <button style="background: #F1F5F9; color: #475569; border: none; padding: 6px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; cursor: pointer;">Islamabad</button>
                    <button style="background: #F1F5F9; color: #475569; border: none; padding: 6px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; cursor: pointer;">Lahore</button>
                </div>
                <span style="font-size: 13px; color: #64748B;">Showing <strong>4 active community issues</strong></span>
            </div>

            <!-- Issues Feed List -->
            <div style="display: flex; flex-direction: column; gap: 16px;">
                
                <!-- Issue 1 -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px 24px; display: grid; grid-template-columns: 60px 1fr auto; gap: 18px; align-items: flex-start; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 8px 4px; text-align: center;">
                        <span style="color: #64748B; font-size: 14px; cursor: pointer;">▲</span>
                        <strong style="display: block; font-size: 15px; color: #0F172A; margin: 2px 0;">34</strong>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Water Supply</span>
                            <span style="font-size: 12px; color: #64748B;">📍 DHA Phase 6, Lane 3, Karachi</span>
                        </div>
                        <h3 style="font-size: 16.5px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">
                            Main line water leak overflowing into neighborhood park gate
                        </h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 10px 0; line-height: 1.5;">
                            Fresh drinking water overflowing into lane 3 since 7 AM. Pressure severely dropped in adjacent 12 homes.
                        </p>
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 12px;">
                            <span style="color: #059669; font-weight: 700;">● Rapid Response Squad Dispatched</span>
                            <span style="color: #94A3B8;">•</span>
                            <span style="color: #64748B;">Reported by Ahmed R. (Resident)</span>
                        </div>
                    </div>
                    <div>
                        <span style="background: #FEF3C7; color: #92400E; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 12px;">In Progress</span>
                    </div>
                </div>

                <!-- Issue 2 -->
                <div style="background: #FFFFFF; border: 1px solid #FECDD3; border-radius: 16px; padding: 22px 24px; display: grid; grid-template-columns: 60px 1fr auto; gap: 18px; align-items: flex-start; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="background: #FFF1F2; border: 1px solid #FECDD3; border-radius: 10px; padding: 8px 4px; text-align: center;">
                        <span style="color: #BE123C; font-size: 14px; cursor: pointer;">▲</span>
                        <strong style="display: block; font-size: 15px; color: #BE123C; margin: 2px 0;">58</strong>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: #FEE2E2; color: #991B1B; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Electrical Hazard</span>
                            <span style="font-size: 12px; color: #64748B;">📍 Gulshan-e-Iqbal Block 13D, Karachi</span>
                        </div>
                        <h3 style="font-size: 16.5px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">
                            Heavy sparking on transformer pole near primary school
                        </h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 10px 0; line-height: 1.5;">
                            Continuous arcing and electrical sparks during afternoon peak loads. Pedestrian area cordoned off.
                        </p>
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 12px;">
                            <span style="color: #DC2626; font-weight: 700;">● Critical Priority Alert</span>
                            <span style="color: #94A3B8;">•</span>
                            <span style="color: #64748B;">Reported by Sarah M.</span>
                        </div>
                    </div>
                    <div>
                        <span style="background: #FEE2E2; color: #991B1B; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 12px;">Alert Active</span>
                    </div>
                </div>

                <!-- Issue 3 (Lahore Sewerage) -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px 24px; display: grid; grid-template-columns: 60px 1fr auto; gap: 18px; align-items: flex-start; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 8px 4px; text-align: center;">
                        <span style="color: #64748B; font-size: 14px; cursor: pointer;">▲</span>
                        <strong style="display: block; font-size: 15px; color: #0F172A; margin: 2px 0;">41</strong>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Sewerage Drainage</span>
                            <span style="font-size: 12px; color: #64748B;">📍 Johar Town Block G, Lahore</span>
                        </div>
                        <h3 style="font-size: 16.5px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">
                            Clogged stormwater drain causing street waterlogging
                        </h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 10px 0; line-height: 1.5;">
                            Debris blockage in roadside catch basin causing water backup during rain.
                        </p>
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 12px;">
                            <span style="color: #0369A1; font-weight: 700;">● Society Maintenance Notified</span>
                            <span style="color: #94A3B8;">•</span>
                            <span style="color: #64748B;">Reported by Usman Ali</span>
                        </div>
                    </div>
                    <div>
                        <span style="background: #E0F2FE; color: #0369A1; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 12px;">Scheduled</span>
                    </div>
                </div>

                <!-- Issue 4 (Resolved Islamabad) -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px 24px; display: grid; grid-template-columns: 60px 1fr auto; gap: 18px; align-items: flex-start; opacity: 0.9;">
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 8px 4px; text-align: center;">
                        <span style="color: #10B981; font-size: 14px;">✓</span>
                        <strong style="display: block; font-size: 15px; color: #0F172A; margin: 2px 0;">89</strong>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Street Light</span>
                            <span style="font-size: 12px; color: #64748B;">📍 F-7/2, Street 31, Islamabad</span>
                        </div>
                        <h3 style="font-size: 16.5px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">
                            Underground streetlight power cable burnt & replaced
                        </h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 8px 0; line-height: 1.5;">
                            FixMate certified electrical crew repaired 40 meters of underground armoured cable. 6 street lamps fully operational.
                        </p>
                        <span style="font-size: 12px; color: #059669; font-weight: 700;">Completed on Sept 26 • Verified by Community Head</span>
                    </div>
                    <div>
                        <span style="background: #ECFDF5; color: #047857; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 12px;">✓ Resolved</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>
@endsection
