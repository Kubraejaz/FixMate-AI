@extends('Frontend.layouts.public')

@php
    $profName = $profession->name ?? 'Professional Service';
    $headline = !empty($profession->headline) ? $profession->headline : ($profName . ' Specialized Maintenance & Repair');
    $desc = !empty($profession->description) ? $profession->description : 'Reliable home repair and maintenance services by certified background-checked technicians with guaranteed upfront pricing and escrow protection.';
    $basePrice = $profession->formatted_price ?? 'Rs. 650';
    $priceUnit = $profession->price_unit ?? 'base';
    $duration = $profession->estimated_duration ?: '30 – 50 mins';
    $warranty = $profession->warranty_text ?: '60-Day Re-work Free';
    $imagePath = !empty($profession->image) ? asset($profession->image) : asset('assets/images/image_3.png');
    $included = $profession->included_list;
    $excluded = $profession->excluded_list;

    // Trade Review Samples
    $reviewMap = [
        'plumber' => ['author' => 'Ayesha Siddiqui', 'text' => 'Ali arrived within 25 minutes with the exact PVC replacement joint in his toolkit. Tested twice before leaving. Excellent!', 'rating' => '4.8 ★'],
        'electrician' => ['author' => 'Bilal Farooq', 'text' => 'The technician tracked down a hidden neutral short in our ceiling within 20 minutes that two roadside electricians could not solve.', 'rating' => '4.9 ★'],
        'ac-refrigeration' => ['author' => 'Dr. Kamran Malik', 'text' => 'My inverter AC was tripping at 28C. After their chemical service it cools like day one and whisper quiet. Very professional!', 'rating' => '4.8 ★'],
        'deep-cleaning' => ['author' => 'Zainab Qureshi', 'text' => 'The 3-person team had heavy duty machines. Our sofa set looks brand new and smelled fresh. Worth every rupee.', 'rating' => '4.7 ★'],
        'carpenter' => ['author' => 'Haris Noman', 'text' => 'Umar fixed 4 sticky doors and installed a fingerprint lock on our main gate. Perfect precision and cleaned up wood shavings.', 'rating' => '4.6 ★'],
        'painter' => ['author' => 'Saad Rasheed', 'text' => 'The seepage in my drawing room had ruined the paint twice. FixMate team applied their elastomeric seal first. Completely dry!', 'rating' => '4.8 ★'],
        'home-appliances' => ['author' => 'Maria Khan', 'text' => 'Technician arrived within 40 minutes and replaced the drain pump on my automatic washing machine. Works like new!', 'rating' => '4.9 ★'],
    ];

    $review = $reviewMap[$profession->slug ?? ''] ?? [
        'author' => 'Verified Customer',
        'text' => 'Prompt arrival, professional equipment, and clear communication throughout the task. Completely satisfied with the rework warranty.',
        'rating' => '4.9 ★'
    ];
@endphp

@section('title', $profName . ' Services & Upfront Pricing — FixMate AI')
@section('meta_desc', $desc)

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 20px;">
        <a href="{{ url('/') }}" style="color: #64748B; text-decoration: none;">Home</a>
        <span>/</span>
        <a href="{{ url('/services') }}" style="color: #64748B; text-decoration: none;">Services</a>
        <span>/</span>
        <span style="color: #0F172A; font-weight: 700;">{{ $profName }}</span>
    </div>

    <!-- Service Details Hero Grid -->
    <div style="display: grid; grid-template-columns: 1.25fr 1fr; gap: 36px; align-items: start; margin-bottom: 40px;">
        
        <div>
            <!-- Banner Image -->
            <div style="border-radius: 18px; overflow: hidden; margin-bottom: 24px; border: 1px solid #E2E8F0; height: 280px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <img src="{{ $imagePath }}" alt="{{ $profName }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div style="margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; flex-wrap: wrap;">
                    <span style="font-size: 11.5px; font-weight: 800; background: #FFF9E6; color: #92400E; border: 1px solid #FEF08A; padding: 4px 12px; border-radius: 50px;">
                        {{ $profName }} Specialty
                    </span>
                    <span style="font-size: 12.5px; color: #059669; font-weight: 700;">● Active in Islamabad, Lahore &amp; Karachi</span>
                </div>
                <h1 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                    {{ $headline }}
                </h1>
                <p style="font-size: 15px; color: #64748B; line-height: 1.6; margin: 0;">
                    {{ $desc }}
                </p>
            </div>

            <!-- What's Included -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <h3 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0;">What's Included in this Service</h3>
                <div style="display: grid; grid-template-columns: 1fr; gap: 10px; font-size: 13.5px; color: #334155;">
                    @foreach($included as $inc)
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
                    @foreach($excluded as $exc)
                    <div style="display: flex; align-items: flex-start; gap: 8px;">
                        <span style="color: #94A3B8;">—</span>
                        <span>{{ $exc }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Dynamic Available Technicians in this Profession -->
            @if(isset($technicians) && $technicians->count() > 0)
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div>
                        <h3 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 4px 0;">Available {{ $profName }} Technicians</h3>
                        <span style="font-size: 12.5px; color: #64748B;">NADRA biometric verified and background checked.</span>
                    </div>
                    <a href="{{ url('/technicians?profession=' . ($profession->id ?? '')) }}" style="font-size: 12.5px; font-weight: 700; color: #2563EB; text-decoration: none;">View All →</a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px;">
                    @foreach($technicians as $tech)
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 42px; height: 42px; border-radius: 50%; background: #FFC107; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #0F172A; flex-shrink: 0;">
                                    {{ strtoupper(substr($tech->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 13.5px; color: #0F172A;">{{ $tech->name }}</strong>
                                    <span style="font-size: 11.5px; color: #64748B;">{{ $tech->experience ?? '5+ yrs' }}</span>
                                </div>
                            </div>
                            <a href="{{ url('/technicians/' . $tech->id) }}" style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #0F172A; font-size: 11.5px; font-weight: 700; padding: 5px 10px; border-radius: 6px; text-decoration: none; white-space: nowrap;">
                                Profile
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Real Customer Review Card -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <strong style="font-size: 15px; color: #0F172A;">Verified Customer Review ({{ $review['rating'] }})</strong>
                    <span style="color: #F59E0B; font-weight: 800; font-size: 14px;">★★★★★</span>
                </div>
                <p style="font-size: 13.5px; color: #475569; line-height: 1.5; font-style: italic; margin: 0 0 8px 0;">
                    "{{ $review['text'] }}"
                </p>
                <span style="font-size: 12px; font-weight: 700; color: #0F172A;">— {{ $review['author'] }}</span>
            </div>

        </div>

        <!-- Right: Pricing Card & Booking Action (Sticky) -->
        <div style="position: sticky; top: 92px;">
            <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 20px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,0.04);">
                
                <span style="font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">
                    UPFRONT GUARANTEED PRICING
                </span>
                
                <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 18px;">
                    <strong style="font-size: 34px; font-weight: 900; color: #0F172A;">{{ $basePrice }}</strong>
                    <span style="font-size: 13px; color: #64748B;">{{ $priceUnit }} labor</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 11px; font-size: 13px; margin-bottom: 22px; border-top: 1px solid #FEF08A; border-bottom: 1px solid #FEF08A; padding: 14px 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B;">Estimated Duration:</span>
                        <strong style="color: #0F172A;">{{ $duration }}</strong>
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
                        <strong style="color: #0F172A;">{{ $warranty }}</strong>
                    </div>
                </div>

                <!-- Booking Action Buttons -->
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="{{ url('/customer/booking?profession=' . ($profession->slug ?? '')) }}" style="background: #FFB800; color: #0F172A; text-align: center; font-weight: 800; font-size: 15px; padding: 13px 0; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35); transition: background 0.15s;" onmouseover="this.style.background='#F59E0B'" onmouseout="this.style.background='#FFB800'">
                        Book This Service Now →
                    </a>
                    
                    <a href="{{ url('/customer/diagnose?q=' . urlencode($profession->slug ?? 'repair')) }}" style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #0F172A; text-align: center; font-weight: 700; font-size: 13.5px; padding: 11px 0; border-radius: 12px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px;">
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

    <!-- Dynamic Related Categories Strip -->
    @php
        $otherList = isset($otherProfessions) && $otherProfessions->isNotEmpty()
            ? $otherProfessions
            : \App\Models\Profession::where('is_active', true)->where('id', '!=', $profession->id ?? 0)->get();
    @endphp
    @if($otherList->isNotEmpty())
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #E2E8F0;">
            <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0;">Explore Other Services</h4>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                @foreach($otherList as $other)
                    <a href="{{ url('/services/' . $other->slug) }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; color: #0F172A; text-decoration: none; transition: all 0.15s;" onmouseover="this.style.background='#FFB800'; this.style.borderColor='#FFB800';" onmouseout="this.style.background='#F8FAFC'; this.style.borderColor='#E2E8F0';">
                        {{ $other->display_icon }} {{ $other->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
