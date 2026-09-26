@extends('Frontend.layouts.public')

@section('title', 'Community Issues — FixMate AI | Neighborhood Maintenance')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">PUBLIC NEIGHBORHOOD FEED</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Community Issues</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">Report or view neighborhood water leaks, streetlights, or electrical hazards.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 36px 0 60px 0;">
        <div class="container" style="max-width: 820px;">
            
            <!-- Action / Report Bar -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div style="font-size: 14px; color: #64748B;">
                    Showing <strong>3 active community reports</strong>
                </div>
                <a href="{{ url('/login?redirect=community') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 9px 20px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    + Report an Issue
                </a>
            </div>

            <!-- Issues Feed List -->
            <div style="display: flex; flex-direction: column; gap: 16px;">
                
                <!-- Issue 1 -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px 24px; display: grid; grid-template-columns: 60px 1fr auto; gap: 18px; align-items: flex-start; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 8px 4px; text-align: center;">
                        <span style="color: #64748B; font-size: 14px; cursor: pointer;">▲</span>
                        <strong style="display: block; font-size: 14px; color: #0F172A; margin: 2px 0;">34</strong>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">Water Supply</span>
                            <span style="font-size: 12px; color: #64748B;">📍 DHA Phase 6, Karachi</span>
                        </div>
                        <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">
                            Main line water leak near street park gate
                        </h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 10px 0; line-height: 1.5;">
                            Water overflowing into lane 3 since morning. Low pressure in adjacent houses.
                        </p>
                        <span style="font-size: 12px; color: #059669; font-weight: 700;">● Technician Dispatched</span>
                    </div>
                    <div>
                        <span style="background: #FEF3C7; color: #92400E; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 12px;">In Progress</span>
                    </div>
                </div>

                <!-- Issue 2 -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px 24px; display: grid; grid-template-columns: 60px 1fr auto; gap: 18px; align-items: flex-start; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 8px 4px; text-align: center;">
                        <span style="color: #64748B; font-size: 14px; cursor: pointer;">▲</span>
                        <strong style="display: block; font-size: 14px; color: #0F172A; margin: 2px 0;">58</strong>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: #FEE2E2; color: #991B1B; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">Electrical</span>
                            <span style="font-size: 12px; color: #64748B;">📍 Gulshan Block 13D, Karachi</span>
                        </div>
                        <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">
                            Sparking transformer pole near primary school
                        </h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 10px 0; line-height: 1.5;">
                            Heavy sparking during afternoon peak hours. Reported to emergency electric squad.
                        </p>
                        <span style="font-size: 12px; color: #DC2626; font-weight: 700;">● Urgent Investigation</span>
                    </div>
                    <div>
                        <span style="background: #FEE2E2; color: #991B1B; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 12px;">Alert Active</span>
                    </div>
                </div>

                <!-- Issue 3 (Resolved) -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px 24px; display: grid; grid-template-columns: 60px 1fr auto; gap: 18px; align-items: flex-start; opacity: 0.9;">
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 8px 4px; text-align: center;">
                        <span style="color: #10B981; font-size: 14px;">✓</span>
                        <strong style="display: block; font-size: 14px; color: #0F172A; margin: 2px 0;">89</strong>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">Street Light</span>
                            <span style="font-size: 12px; color: #64748B;">📍 F-7/2, Street 31, Islamabad</span>
                        </div>
                        <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">
                            Underground light pole cable repaired
                        </h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0; line-height: 1.5;">
                            FixMate certified electrical crew repaired burnt underground cabling. All lights active.
                        </p>
                    </div>
                    <div>
                        <span style="background: #ECFDF5; color: #047857; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 12px;">✓ Resolved</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>
@endsection
