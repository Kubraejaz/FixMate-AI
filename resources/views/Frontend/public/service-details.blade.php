@extends('Frontend.layouts.public')

@php
    $servicesData = [
        'plumbing' => [
            'title' => 'Plumbing, Pipe Leaks & Sanitary Repair',
            'category' => 'Plumbing Specialty',
            'image' => asset('assets/images/image_3.png'),
            'badge' => 'Plumbing Specialty',
            'active_in' => 'Active in Islamabad, Lahore & Karachi',
            'headline' => 'Kitchen Sink, Mixer Faucets & Water Pipe Leak Repair',
            'desc' => 'Precision leak detection and rapid repair for dripping mixer taps, kitchen sink P-trap joint leaks, concealed wall pipe seepage, and water suction motors. Carried out by licensed master plumbers with a 60-day rework warranty.',
            'base_price' => 'Rs. 650',
            'duration' => '30 – 50 mins',
            'included' => [
                'Full ultrasonic & joint leak pressure inspection',
                'Slip-joint washer and Teflon thread seal replacement',
                'Sanitary pipe tightening and valve calibration',
                'Drain siphon flow test & 60-day rework guarantee'
            ],
            'excluded' => [
                'New brass mixer units or replacement pipes (billed at receipt)',
                'Excavation beyond 2 feet of concrete slab'
            ],
            'review_author' => 'Ayesha Siddiqui',
            'review_text' => 'Ali arrived within 25 minutes with the exact PVC replacement joint in his toolkit. Tested twice before leaving. Excellent!',
            'rating' => '4.8 ★'
        ],
        'electrical' => [
            'title' => 'Electrical Short-Circuit, DB Box & Wiring Repair',
            'category' => 'Electrical Specialty',
            'image' => asset('assets/images/image_2.png'),
            'badge' => 'Electrical Specialty',
            'active_in' => 'Active in Islamabad, Lahore & Karachi',
            'headline' => 'Circuit Breaker Tripping, DB Box & UPS Wiring Diagnosis',
            'desc' => 'Certified high-voltage electricians for tracing short-circuits, fixing burned main breakers, rewiring UPS/solar changeover switches, and mounting modern SMD lights and chandeliers with total insulation safety.',
            'base_price' => 'Rs. 700',
            'duration' => '40 – 60 mins',
            'included' => [
                'Digital multimeter voltage & phase grounding audit',
                'Main DB circuit breaker diagnostic & replacement labor',
                'Heat-resistant sleeve wiring and terminal tightening',
                'Post-repair load test across all phases'
            ],
            'excluded' => [
                'Replacement Schneider/Terasaki circuit breakers',
                'UPS batteries or solar inverter equipment'
            ],
            'review_author' => 'Bilal Farooq',
            'review_text' => 'The technician tracked down a hidden neutral short in our ceiling within 20 minutes that two roadside electricians could not solve.',
            'rating' => '4.9 ★'
        ],
        'ac-cooling' => [
            'title' => 'Inverter AC Jet Foam Wash & Refrigerant Refill',
            'category' => 'HVAC & Cooling Specialty',
            'image' => asset('assets/images/image_1.png'),
            'badge' => 'HVAC & Cooling',
            'active_in' => 'Active in Islamabad, Lahore & Karachi',
            'headline' => 'High-Pressure Chemical Coil Wash & R410a Gas Charging',
            'desc' => 'Restore optimum 16°C chilling with an industrial master jet wash. Removes stubborn bacteria, dirt, and mold from indoor cooling fins and outdoor condenser coils, drastically cutting your electric units consumption.',
            'base_price' => 'Rs. 1,499',
            'duration' => '60 – 75 mins',
            'included' => [
                'Waterproof wall protection jacket installation',
                'High-pressure chemical jet wash indoor cooling coils',
                'Outdoor condenser fin hydro-descaling',
                'Operating amp current & gas pressure verification'
            ],
            'excluded' => [
                'Pure R410a/R32 gas top-up (billed if pressure low)',
                'PCB motherboard capacitor replacements'
            ],
            'review_author' => 'Dr. Kamran Malik',
            'review_text' => 'My inverter AC was tripping at 28C. After their chemical service it cools like day one and whisper quiet. Very professional!',
            'rating' => '4.8 ★'
        ],
        'cleaning' => [
            'title' => 'Full Home Deep Cleaning & Upholstery Sanitization',
            'category' => 'Hygiene Specialty',
            'image' => asset('assets/images/image_4.png'),
            'badge' => 'Deep Cleaning Specialty',
            'active_in' => 'Active in Islamabad, Lahore & Karachi',
            'headline' => 'Hospital-Grade Chemical Sanitization, Sofa & Floor Descaling',
            'desc' => 'Complete deep cleaning service for pre-move in homes, post-renovation dust removal, tile grout restoration, and industrial extraction shampooing for 5-seater sofa sets and heavy carpets.',
            'base_price' => 'Rs. 2,499',
            'duration' => '2 – 3 hours',
            'included' => [
                'Industrial wet/dry suction extraction equipment',
                'Tile grout chemical descaling and stain lift',
                'Kitchen grease de-greaser on chimney and cabinets',
                'Hospital-grade antibacterial room misting'
            ],
            'excluded' => [
                'Exterior glass cleaning above 2nd floor height',
                'Disposal of construction rubble'
            ],
            'review_author' => 'Zainab Qureshi',
            'review_text' => 'The 3-person team had heavy duty machines. Our sofa set looks brand new and smelled fresh. Worth every rupee.',
            'rating' => '4.7 ★'
        ],
        'carpentry' => [
            'title' => 'Door Locks, Modular Cabinets & Woodwork',
            'category' => 'Carpentry Specialty',
            'image' => asset('assets/images/image_3.png'),
            'badge' => 'Carpentry Specialty',
            'active_in' => 'Active in Islamabad, Lahore & Karachi',
            'headline' => 'Smart Lock Fitting, Cabinet Hydraulic Hinges & Repairs',
            'desc' => 'Master finish carpenters equipped with precision routing tools for fitting digital door locks, re-aligning sagging wooden doors, installing soft-close kitchen drawer runners, and bespoke shelving.',
            'base_price' => 'Rs. 800',
            'duration' => '45 – 70 mins',
            'included' => [
                'Precision mortise cut and strike plate alignment',
                'Hydraulic soft-close hinge calibration',
                'Wood swelling planing and clear latch clearance',
                'Screw anchor reinforcement into solid brick/wood'
            ],
            'excluded' => [
                'Smart lock electronic hardware or new wooden doors',
                'Lacquering / French polish materials'
            ],
            'review_author' => 'Haris Noman',
            'review_text' => 'Umar fixed 4 sticky doors and installed a fingerprint lock on our main gate. Perfect precision and cleaned up wood shavings.',
            'rating' => '4.6 ★'
        ],
        'painting' => [
            'title' => 'Wall Putty, Anti-Fungal Paint & Waterproofing',
            'category' => 'Painting Specialty',
            'image' => asset('assets/images/image_2.png'),
            'badge' => 'Painting Specialty',
            'active_in' => 'Active in Islamabad, Lahore & Karachi',
            'headline' => 'Seepage Chemical Treatment & Premium Wall Finish',
            'desc' => 'Experienced painters skilled in scraping efflorescence, applying elastomeric waterproofing coats on damp walls, double-coat putty sanding, and spray lacquer finishes.',
            'base_price' => 'Rs. 25 / sq.ft',
            'duration' => '1 – 2 days',
            'included' => [
                'Floor masking and furniture protective plastic covering',
                'Chemical dampness treatment and anti-salt scraper',
                'Two coats of ultra-smooth wall putty filling',
                'Application of Berger / ICI Dulux paint with rollers'
            ],
            'excluded' => [
                'Paint gallons and primer buckets (client choice)',
                'Scaffolding for 3+ story building exteriors'
            ],
            'review_author' => 'Saad Rasheed',
            'review_text' => 'The seepage in my drawing room had ruined the paint twice. FixMate team applied their elastomeric seal first. 4 months later, completely dry!',
            'rating' => '4.8 ★'
        ]
    ];

    $currentSlug = strtolower($slug ?? 'plumbing');
    $service = $servicesData[$currentSlug] ?? $servicesData['plumbing'];
@endphp

@section('title', $service['title'] . ' — FixMate AI')
@section('meta_desc', $service['desc'])

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 20px;">
        <a href="{{ url('/') }}" style="color: #64748B; text-decoration: none;">Home</a>
        <span>/</span>
        <a href="{{ url('/services') }}" style="color: #64748B; text-decoration: none;">Services</a>
        <span>/</span>
        <span style="color: #0F172A; font-weight: 700;">{{ $service['title'] }}</span>
    </div>

    <!-- Service Details Hero Grid -->
    <div style="display: grid; grid-template-columns: 1.25fr 1fr; gap: 36px; align-items: start; margin-bottom: 40px;">
        
        <div>
            <!-- Banner Image -->
            <div style="border-radius: 18px; overflow: hidden; margin-bottom: 24px; border: 1px solid #E2E8F0; height: 280px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div style="margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <span style="font-size: 11.5px; font-weight: 800; background: #FFF9E6; color: #92400E; border: 1px solid #FEF08A; padding: 4px 12px; border-radius: 50px;">
                        {{ $service['badge'] }}
                    </span>
                    <span style="font-size: 12.5px; color: #059669; font-weight: 700;">● {{ $service['active_in'] }}</span>
                </div>
                <h1 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                    {{ $service['headline'] }}
                </h1>
                <p style="font-size: 15px; color: #64748B; line-height: 1.6; margin: 0;">
                    {{ $service['desc'] }}
                </p>
            </div>

            <!-- What's Included -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <h3 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0;">What's Included in this Service</h3>
                <div style="display: grid; grid-template-columns: 1fr; gap: 10px; font-size: 13.5px; color: #334155;">
                    @foreach($service['included'] as $inc)
                    <div style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="color: #059669; font-weight: 900; font-size: 16px; line-height: 1;">✓</span>
                        <span>{{ $inc }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- What's Excluded (Transparency) -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px; margin-bottom: 24px;">
                <h4 style="font-size: 14px; font-weight: 800; color: #64748B; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 0.04em;">Excluded / Separate Charges:</h4>
                <div style="display: flex; flex-direction: column; gap: 6px; font-size: 13px; color: #64748B;">
                    @foreach($service['excluded'] as $exc)
                    <div style="display: flex; align-items: flex-start; gap: 8px;">
                        <span style="color: #94A3B8;">—</span>
                        <span>{{ $exc }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Real Customer Review Card -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <strong style="font-size: 15px; color: #0F172A;">Verified Customer Review ({{ $service['rating'] }})</strong>
                    <span style="color: #F59E0B; font-weight: 800; font-size: 14px;">★★★★★</span>
                </div>
                <p style="font-size: 13.5px; color: #475569; line-height: 1.5; font-style: italic; margin: 0 0 8px 0;">
                    "{{ $service['review_text'] }}"
                </p>
                <span style="font-size: 12px; font-weight: 700; color: #0F172A;">— {{ $service['review_author'] }}</span>
            </div>

        </div>

        <!-- Right: Pricing Card & Booking Action (Sticky) -->
        <div style="position: sticky; top: 92px;">
            <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 20px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,0.04);">
                
                <span style="font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">
                    UPFRONT GUARANTEED PRICING
                </span>
                
                <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 18px;">
                    <strong style="font-size: 34px; font-weight: 900; color: #0F172A;">{{ $service['base_price'] }}</strong>
                    <span style="font-size: 13px; color: #64748B;">Base Fixed Labor</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 11px; font-size: 13px; margin-bottom: 22px; border-top: 1px solid #FEF08A; border-bottom: 1px solid #FEF08A; padding: 14px 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B;">Estimated Duration:</span>
                        <strong style="color: #0F172A;">{{ $service['duration'] }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B;">Earliest Arrival:</span>
                        <strong style="color: #059669;">Today &lt; 30 mins</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B;">Payment Protection:</span>
                        <strong style="color: #0F172A;">FixMate Escrow Safe</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B;">Warranty Coverage:</span>
                        <strong style="color: #0F172A;">60-Day Re-work Free</strong>
                    </div>
                </div>

                <!-- Booking Action Buttons -->
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="{{ url('/customer/booking') }}" style="background: #FFB800; color: #0F172A; text-align: center; font-weight: 800; font-size: 15px; padding: 13px 0; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35); transition: background 0.15s;" onmouseover="this.style.background='#F59E0B'" onmouseout="this.style.background='#FFB800'">
                        Book This Service Now →
                    </a>
                    
                    <a href="{{ url('/customer/diagnose?q=' . urlencode($currentSlug)) }}" style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #0F172A; text-align: center; font-weight: 700; font-size: 13.5px; padding: 11px 0; border-radius: 12px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <span>📸</span>
                        <span>Diagnose Problem with AI First</span>
                    </a>
                </div>

                <div style="margin-top: 16px; display: flex; flex-direction: column; gap: 6px; font-size: 11.5px; color: #64748B; text-align: center;">
                    <div>✓ Free cancellation up to 30 mins before arrival</div>
                    <div>✓ Arrival OTP mandatory before entering home</div>
                </div>

            </div>
        </div>

    </div>

    <!-- Related Categories Strip -->
    <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #E2E8F0;">
        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0;">Explore Other Services</h4>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ url('/services/plumbing') }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; color: #0F172A; text-decoration: none;">💧 Plumbing</a>
            <a href="{{ url('/services/electrical') }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; color: #0F172A; text-decoration: none;">⚡ Electrical</a>
            <a href="{{ url('/services/ac-cooling') }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; color: #0F172A; text-decoration: none;">❄️ AC Cooling</a>
            <a href="{{ url('/services/cleaning') }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; color: #0F172A; text-decoration: none;">🧹 Deep Cleaning</a>
            <a href="{{ url('/services/carpentry') }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; color: #0F172A; text-decoration: none;">🔨 Carpentry</a>
            <a href="{{ url('/services/painting') }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; color: #0F172A; text-decoration: none;">🖌️ Painting</a>
        </div>
    </div>

</div>
@endsection
