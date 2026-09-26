@extends('Frontend.layouts.admin')

@section('title', 'Service & Problem Categories Management — FixMate AI Admin')

@section('content')
<div>
    
    <!-- Title matching Mockup 2 & 3 -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">Problem Categories & Catalog</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Manage diagnostic categories, base pricing rules, and trade classifications.</p>
        </div>
        <button class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; font-weight: 800;">
            + Add Category
        </button>
    </div>

    <!-- Category Cards Grid matching Mockup 2 & 3 -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        
        <!-- Plumbing -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 204, 0, 0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    🔧
                </div>
                <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    1,248 Inquiries
                </span>
            </div>
            <strong style="display: block; font-size: 17px; color: #FFFFFF; margin-bottom: 6px;">Plumbing</strong>
            <p style="font-size: 12.5px; color: #AAA; line-height: 1.5; margin-bottom: 14px;">
                Leakage, pipe repair, bathroom sanitary, sink drain, motor pumps.
            </p>
            <div style="border-top: 1px solid #2B2B2B; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                <span style="color: #777;">Base Fee: <strong style="color: #FFCC00;">Rs. 500</strong></span>
                <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Edit Catalog →</a>
            </div>
        </div>

        <!-- Electrical -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    ⚡
                </div>
                <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    892 Inquiries
                </span>
            </div>
            <strong style="display: block; font-size: 17px; color: #FFFFFF; margin-bottom: 6px;">Electrical</strong>
            <p style="font-size: 12.5px; color: #AAA; line-height: 1.5; margin-bottom: 14px;">
                Wiring, short-circuit troubleshooting, breaker panels, ceiling fans.
            </p>
            <div style="border-top: 1px solid #2B2B2B; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                <span style="color: #777;">Base Fee: <strong style="color: #FFCC00;">Rs. 600</strong></span>
                <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Edit Catalog →</a>
            </div>
        </div>

        <!-- AC & Cooling -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    ❄️
                </div>
                <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    740 Inquiries
                </span>
            </div>
            <strong style="display: block; font-size: 17px; color: #FFFFFF; margin-bottom: 6px;">AC & Cooling</strong>
            <p style="font-size: 12.5px; color: #AAA; line-height: 1.5; margin-bottom: 14px;">
                Split AC service, gas refill, inverter troubleshooting, cooling coil.
            </p>
            <div style="border-top: 1px solid #2B2B2B; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                <span style="color: #777;">Base Fee: <strong style="color: #FFCC00;">Rs. 1,200</strong></span>
                <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Edit Catalog →</a>
            </div>
        </div>

        <!-- Appliance Repair -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(239, 68, 68, 0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    🧺
                </div>
                <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    480 Inquiries
                </span>
            </div>
            <strong style="display: block; font-size: 17px; color: #FFFFFF; margin-bottom: 6px;">Appliance Repair</strong>
            <p style="font-size: 12.5px; color: #AAA; line-height: 1.5; margin-bottom: 14px;">
                Refrigerator, washing machine, microwave oven, water dispenser.
            </p>
            <div style="border-top: 1px solid #2B2B2B; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                <span style="color: #777;">Base Fee: <strong style="color: #FFCC00;">Rs. 900</strong></span>
                <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Edit Catalog →</a>
            </div>
        </div>

        <!-- Carpentry -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    🪚
                </div>
                <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    350 Inquiries
                </span>
            </div>
            <strong style="display: block; font-size: 17px; color: #FFFFFF; margin-bottom: 6px;">Carpentry</strong>
            <p style="font-size: 12.5px; color: #AAA; line-height: 1.5; margin-bottom: 14px;">
                Door locks, handles, wardrobe hinges, wooden polishing, shelves.
            </p>
            <div style="border-top: 1px solid #2B2B2B; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                <span style="color: #777;">Base Fee: <strong style="color: #FFCC00;">Rs. 800</strong></span>
                <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Edit Catalog →</a>
            </div>
        </div>

        <!-- Cleaning -->
        <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 14px; padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(168, 85, 247, 0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    🧹
                </div>
                <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    520 Inquiries
                </span>
            </div>
            <strong style="display: block; font-size: 17px; color: #FFFFFF; margin-bottom: 6px;">Deep Cleaning</strong>
            <p style="font-size: 12.5px; color: #AAA; line-height: 1.5; margin-bottom: 14px;">
                Full house deep cleaning, sofas, carpets, water tank disinfection.
            </p>
            <div style="border-top: 1px solid #2B2B2B; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                <span style="color: #777;">Base Fee: <strong style="color: #FFCC00;">Rs. 1,500</strong></span>
                <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Edit Catalog →</a>
            </div>
        </div>

    </div>

</div>
@endsection
