@extends('Frontend.layouts.customer')

@section('title', 'Recommended Technicians — FixMate AI')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <!-- Title & Subtitle matching Mockup 1 & 2 -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 6px;">Recommended Technicians</h1>
        <p style="font-size: 14.5px; color: #666; margin: 0;">Based on your problem (Kitchen Sink Leakage), location, availability and ratings.</p>
    </div>

    <!-- Filter Tabs matching Mockup 1: Nearby, Top Rated, Most Experienced -->
    <div style="display: flex; gap: 10px; margin-bottom: 24px;">
        <button class="btn-yellow" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">✓ Nearby (Within 5 km)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Top Rated (4.8+ ★)</button>
        <button class="btn-outline" style="padding: 7px 18px; font-size: 13px; border-radius: 20px;">Most Experienced (6+ yrs)</button>
    </div>

    <!-- Technicians List Cards matching Mockup 1 -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        
        <!-- Ali Khan (Top Match) -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center; border: 2px solid #FFCC00;">
            <div style="position: relative;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;">✓</span>
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: #111; margin: 0;">Ali Khan</h3>
                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px; border: 1px solid #A7F3D0;">Best Match (98%)</span>
                    <span style="font-size: 12px; color: #777;">• 📍 2.1 km away</span>
                </div>
                <span style="font-size: 13.5px; color: #666; font-weight: 600; display: block; margin-bottom: 8px;">Master Plumber • 8 years exp</span>

                <div style="display: flex; align-items: center; gap: 14px; font-size: 12.5px; color: #666; margin-bottom: 8px;">
                    <span style="color: #F59E0B;">★ <strong style="color: #111;">4.9</strong> (247 jobs)</span>
                    <span style="color: #059669; font-weight: 700;">● Completed 38 similar sink jobs in your area</span>
                </div>

                <div style="display: flex; gap: 6px;">
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Plumbing</span>
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Sink Repair</span>
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Pipe Repair</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                <div style="text-align: right; line-height: 1.2;">
                    <span style="font-size: 11px; color: #888;">Base Fee</span>
                    <strong style="display: block; font-size: 16px; color: #111;">Rs. 500</strong>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ url('/technicians/ali-khan') }}" class="btn-outline" style="padding: 8px 14px; font-size: 12.5px;">View Profile</a>
                    <a href="{{ url('/customer/booking?tech=ali-khan') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px;">Book Now</a>
                </div>
            </div>
        </div>

        <!-- Riaz Ahmed -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center;">
            <div style="position: relative;">
                <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;">✓</span>
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: #111; margin: 0;">Riaz Ahmed</h3>
                    <span style="font-size: 12px; color: #777;">• 📍 3.4 km away</span>
                </div>
                <span style="font-size: 13.5px; color: #666; font-weight: 600; display: block; margin-bottom: 8px;">General Plumber & Electrician • 6 years exp</span>

                <div style="display: flex; align-items: center; gap: 14px; font-size: 12.5px; color: #666; margin-bottom: 8px;">
                    <span style="color: #F59E0B;">★ <strong style="color: #111;">4.8</strong> (189 jobs)</span>
                    <span style="color: #555;">Completed 22 similar jobs in your area</span>
                </div>

                <div style="display: flex; gap: 6px;">
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Plumbing</span>
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Toilet Repair</span>
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Leak Detection</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                <div style="text-align: right; line-height: 1.2;">
                    <span style="font-size: 11px; color: #888;">Base Fee</span>
                    <strong style="display: block; font-size: 16px; color: #111;">Rs. 500</strong>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ url('/technicians/riaz-ahmed') }}" class="btn-outline" style="padding: 8px 14px; font-size: 12.5px;">View Profile</a>
                    <a href="{{ url('/customer/booking?tech=riaz-ahmed') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px;">Book Now</a>
                </div>
            </div>
        </div>

        <!-- Imran Shah -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center;">
            <div style="position: relative;">
                <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;">✓</span>
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: #111; margin: 0;">Imran Shah</h3>
                    <span style="font-size: 12px; color: #777;">• 📍 2.8 km away</span>
                </div>
                <span style="font-size: 13.5px; color: #666; font-weight: 600; display: block; margin-bottom: 8px;">Senior Pipe Mechanic • 7 years exp</span>

                <div style="display: flex; align-items: center; gap: 14px; font-size: 12.5px; color: #666; margin-bottom: 8px;">
                    <span style="color: #F59E0B;">★ <strong style="color: #111;">4.9</strong> (312 jobs)</span>
                    <span style="color: #555;">Completed 45 similar jobs in your area</span>
                </div>

                <div style="display: flex; gap: 6px;">
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Plumbing</span>
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Drain Unblock</span>
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">P-trap replacement</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                <div style="text-align: right; line-height: 1.2;">
                    <span style="font-size: 11px; color: #888;">Base Fee</span>
                    <strong style="display: block; font-size: 16px; color: #111;">Rs. 600</strong>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ url('/technicians/imran-shah') }}" class="btn-outline" style="padding: 8px 14px; font-size: 12.5px;">View Profile</a>
                    <a href="{{ url('/customer/booking?tech=imran-shah') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px;">Book Now</a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
