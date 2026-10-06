@extends('Frontend.layouts.public')
 
@section('title', 'FixMate — Trusted Home Services Made Simple')
 
@section('content')
<div>
 
    <!-- Hero Section matching user's exact mockup image with dynamic content -->
    <section style="background: #FFFFFF; padding: 40px 0 60px 0; overflow: hidden; position: relative;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 40px; align-items: center;">
                
                <!-- Left Hero Content -->
                <div>
                    <!-- Pill Tag -->
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 6px 14px; border-radius: 50px; margin-bottom: 20px;">
                        <span style="color: #FFB800; font-size: 14px;">✨</span>
                        <span style="font-size: 13px; font-weight: 700; color: #92400E;">{{ $hero['badge'] ?? 'Verified On-Demand Home Service Platform' }}</span>
                    </div>

                    <!-- Main Headline matching mockup -->
                    <h1 style="font-size: 54px; font-weight: 900; line-height: 1.12; color: #0F172A; margin: 0 0 18px 0; letter-spacing: -0.03em;">
                        {{ $hero['title_main'] ?? 'Smart Home Services' }}<br>Made <span style="color: #FFB800;">{{ $hero['title_highlight'] ?? 'Simple' }}</span>
                    </h1>

                    <!-- Description -->
                    <p style="font-size: 16px; line-height: 1.6; color: #64748B; margin: 0 0 32px 0; max-width: 530px;">
                        {{ $hero['subtitle'] ?? 'Describe your problem or choose a trade, and let FixMate find verified technicians with transparent upfront pricing.' }}
                    </p>

                    <!-- Service Search Bar -->
                    <form action="{{ url('/services') }}" method="GET" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 50px; box-shadow: 0 12px 30px rgba(0,0,0,0.06); padding: 8px 10px 8px 22px; display: flex; align-items: center; gap: 12px; max-width: 580px; margin-bottom: 36px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="2.3">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" name="search" placeholder='Search services (e.g. "plumbing", "AC repair", "electrician")' style="flex: 1; border: none; outline: none; font-size: 14.5px; color: #1E293B; font-family: inherit; font-weight: 500;">
                        <button type="submit" style="background: #FFC107; border: none; outline: none; padding: 12px 26px; border-radius: 50px; font-size: 14px; font-weight: 800; color: #0F172A; cursor: pointer; display: flex; align-items: center; gap: 6px; white-space: nowrap; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);">
                            <span>Find Service</span>
                        </button>
                    </form>

                    <!-- 4 Value Props Row matching mockup -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                        
                        <!-- Upfront Pricing -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                🏷️
                            </div>
                            <div style="line-height: 1.2;">
                                <strong style="display: block; font-size: 13.5px; color: #0F172A;">Upfront Rates</strong>
                                <span style="font-size: 11px; color: #64748B;">Instant cost estimate</span>
                            </div>
                        </div>

                        <!-- Verified Technicians -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                🧑‍🔧
                            </div>
                            <div style="line-height: 1.2;">
                                <strong style="display: block; font-size: 13.5px; color: #0F172A;">{{ $stats['verified_technicians'] ?? 2400 }}+ Vetted</strong>
                                <span style="font-size: 11px; color: #64748B;">NADRA &amp; Police checked</span>
                            </div>
                        </div>

                        <!-- Fast Dispatch -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                ⏱️
                            </div>
                            <div style="line-height: 1.2;">
                                <strong style="display: block; font-size: 13.5px; color: #0F172A;">Fast Dispatch</strong>
                                <span style="font-size: 11px; color: #64748B;">{{ $stats['avg_arrival_mins'] ?? 24 }}m avg arrival time</span>
                            </div>
                        </div>

                        <!-- Secure Payments -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                💳
                            </div>
                            <div style="line-height: 1.2;">
                                <strong style="display: block; font-size: 13.5px; color: #0F172A;">Escrow Pay</strong>
                                <span style="font-size: 11px; color: #64748B;">{{ $stats['warranty_days'] ?? 30 }}-day warranty</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Hero Visual with Dynamic Image Asset -->
                <div style="position: relative; text-align: center;">
                    
                    <!-- Yellow Organic Backdrop Shape -->
                    <div style="position: absolute; right: 10px; bottom: 0; width: 380px; height: 420px; background: #FFB800; border-radius: 190px 190px 40px 40px; z-index: 1;"></div>

                    <!-- Dynamic Technician Photo Image -->
                    <img src="{{ $hero['image'] ?? asset('assets/images/image_8.png') }}" alt="FixMate Certified Technician" style="position: relative; z-index: 2; height: 460px; width: auto; object-fit: contain; display: inline-block;">

                    <!-- Floating Card Top Right matching mockup -->
                    <div style="position: absolute; top: 10px; right: 0; z-index: 3; background: #FFFFFF; border-radius: 14px; padding: 14px 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1px solid #F1F5F9; text-align: left; width: 230px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <div style="width: 24px; height: 24px; border-radius: 6px; background: #FFF9E6; color: #FFB800; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 900;">
                                🛡️
                            </div>
                            <strong style="font-size: 12px; color: #0F172A; line-height: 1.2;">{{ $hero['trusted_tag'] ?? 'Trusted Professionals for Your Home' }}</strong>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 6px; font-size: 11px; color: #475569;">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="color: #10B981; font-weight: 800;">✓</span>
                                <span>{{ $stats['verified_technicians'] ?? 2150 }}+ NADRA Background Checked</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="color: #10B981; font-weight: 800;">✓</span>
                                <span>{{ $stats['avg_rating'] ?? 4.9 }}★ Customer Rating Average</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="color: #10B981; font-weight: 800;">✓</span>
                                <span>{{ $stats['completed_jobs'] ?? '18,500+' }} Repairs Completed</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Right Script: "Your Home Our Priority" matching mockup -->
                    <div style="position: absolute; bottom: 35px; right: 10px; z-index: 3; text-align: right; transform: rotate(-6deg);">
                        <span style="font-family: 'Caveat', cursive; font-size: 26px; font-weight: 700; color: #FFFFFF; text-shadow: 0 2px 8px rgba(0,0,0,0.25); display: block; line-height: 1.1;">
                            {{ $hero['script_text'] ?? "Your Home\nOur Priority" }}
                        </span>
                        <svg width="60" height="24" viewBox="0 0 60 24" fill="none" stroke="#FFFFFF" stroke-width="2" style="margin-top: -6px; opacity: 0.9;">
                            <path d="M 5 5 Q 30 20 55 10" />
                            <path d="M 45 6 L 55 10 L 48 18" />
                        </svg>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Popular Services Section matching user's exact mockup with dynamic data -->
    <section style="background: #F8FAFC; padding: 48px 0; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9;">
        <div class="container">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px;">
                <div>
                    <h2 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 0 0 6px 0;">Popular Services</h2>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Choose from {{ $stats['total_professions'] ?? 6 }} specialized trade disciplines with verified specialists.</p>
                </div>
                <a href="{{ url('/services') }}" style="font-size: 13.5px; font-weight: 700; color: #2563EB; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    View All Services →
                </a>
            </div>

            @php
                $iconMap = [
                    'plumber' => ['icon' => '💧', 'bg' => '#E0F2FE', 'border' => '#93C5FD'],
                    'electrician' => ['icon' => '⚡', 'bg' => '#FEF3C7', 'border' => '#FDE68A'],
                    'ac-refrigeration' => ['icon' => '❄️', 'bg' => '#E0F7FA', 'border' => '#A5F3FC'],
                    'deep-cleaning' => ['icon' => '🧹', 'bg' => '#DCFCE7', 'border' => '#86EFAC'],
                    'painter' => ['icon' => '🖌️', 'bg' => '#FFEDD5', 'border' => '#FDBA74'],
                    'carpenter' => ['icon' => '🔨', 'bg' => '#F3E8FF', 'border' => '#D8B4FE'],
                    'home-appliances' => ['icon' => '🧺', 'bg' => '#CCFBF1', 'border' => '#99F6E4'],
                ];
            @endphp

            <!-- Dynamic Services from database -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px;">
                @foreach(($professions ?? collect()) as $prof)
                    @php
                        $style = $iconMap[$prof->slug] ?? ['icon' => '🔧', 'bg' => '#F1F5F9', 'border' => '#CBD5E1'];
                        $techCount = $prof->professionals_count ?? 0;
                    @endphp
                    <a href="{{ url('/services/' . $prof->slug) }}" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px 14px; text-align: center; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='{{ $style['border'] }}';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0';">
                        <div style="width: 50px; height: 50px; border-radius: 14px; background: {{ $style['bg'] }}; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 12px auto;">
                            {{ $style['icon'] }}
                        </div>
                        <strong style="display: block; font-size: 14px; color: #0F172A; margin-bottom: 4px;">{{ $prof->name }}</strong>
                        <span style="font-size: 11.5px; color: #64748B;">{{ $techCount > 0 ? $techCount . '+ Active' : 'Available' }}</span>
                    </a>
                @endforeach
            </div>

        </div>
    </section>

    <!-- How FixMate Works Section matching user's exact mockup with dynamic steps -->
    <section style="background: #FFFFFF; padding: 48px 0;">
        <div class="container">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;">
                <div>
                    <h2 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 0 0 6px 0;">How FixMate Works</h2>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Get your home service done in just a few simple steps with upfront transparent pricing.</p>
                </div>
                <a href="{{ url('/how-it-works') }}" style="font-size: 13.5px; font-weight: 700; color: #2563EB; text-decoration: none;">
                    Learn More →
                </a>
            </div>

            <!-- Horizontal Steps with Arrow Dividers matching mockup -->
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 36px; flex-wrap: wrap;">
                @foreach(($workflowSteps ?? []) as $index => $step)
                    <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 170px;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: {{ $step['badge_color'] }}; color: #0F172A; font-size: 12px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            {{ $step['step'] }}
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                            {{ $step['icon'] }}
                        </div>
                        <div style="line-height: 1.25;">
                            <strong style="display: block; font-size: 13.5px; color: #0F172A;">{{ $step['title'] }}</strong>
                            <span style="font-size: 11.5px; color: #64748B;">{{ $step['desc'] }}</span>
                        </div>
                    </div>

                    @if(!$loop->last)
                        <div style="color: #CBD5E1; font-size: 16px; font-weight: 700; padding: 0 6px;">›</div>
                    @endif
                @endforeach
            </div>

            <!-- FixMate Guarantee Banner matching user's exact mockup -->
            <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 18px; padding: 20px 28px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;">
                
                <!-- Guarantee Title & Subtitle -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #FFC107; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                        🛡️
                    </div>
                    <div>
                        <strong style="display: block; font-size: 15px; color: #0F172A;">{{ $hero['guarantee_title'] ?? 'FixMate Guarantee' }}</strong>
                        <span style="font-size: 12px; color: #64748B;">Trusted service. Verified professionals. {{ $stats['warranty_days'] ?? 30 }}-day warranty on all completed jobs.</span>
                    </div>
                </div>

                <!-- Center 3 Pillars -->
                <div style="display: flex; align-items: center; gap: 28px; font-size: 13px; font-weight: 700; color: #0F172A; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span>🛡️</span>
                        <span>Verified &amp; Background Checked</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span>🏷️</span>
                        <span>Upfront Pricing</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span>✓</span>
                        <span>Satisfaction Guarantee</span>
                    </div>
                </div>

                <!-- Right CTA button -->
                <a href="{{ url('/become-technician') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 22px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);">
                    Become a Technician →
                </a>

            </div>

        </div>
    </section>

    <!-- Featured Technicians Section matching user's exact mockup -->
    <section style="background: #F8FAFC; padding: 48px 0; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9;">
        <div class="container">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px;">
                <div>
                    <h2 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 0 0 6px 0;">Featured Technicians</h2>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Top-rated certified professionals ready for rapid dispatch.</p>
                </div>
                <a href="{{ url('/technicians') }}" style="font-size: 13.5px; font-weight: 700; color: #2563EB; text-decoration: none;">
                    View All {{ $stats['total_technicians'] ?? 2400 }} Technicians →
                </a>
            </div>

            <!-- Featured Technicians Cards dynamically loaded from database -->
            @php
                $avatarList = [
                    asset('assets/images/image_1.png'),
                    asset('assets/images/image_2.png'),
                    asset('assets/images/image_3.png'),
                    asset('assets/images/image_4.png'),
                ];
            @endphp

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;">
                @forelse(($featuredProfessionals ?? collect()) as $idx => $pro)
                    @php
                        $avatar = $avatarList[$idx % count($avatarList)];
                    @endphp
                    <a href="{{ url('/technicians/' . $pro->id) }}" style="text-decoration: none; color: inherit; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#FFC107'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)';">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <img src="{{ $avatar }}" alt="{{ $pro->name }}" style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid #FFC107;">
                            <div>
                                <strong style="display: block; font-size: 15px; color: #0F172A; margin-bottom: 2px;">{{ $pro->name }}</strong>
                                <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 4px;">{{ $pro->profession?->name ?? 'Specialist' }}</span>
                                <div style="font-size: 11.5px; color: #64748B; display: flex; align-items: center; gap: 4px;">
                                    <span style="color: #F59E0B;">★ {{ $stats['avg_rating'] ?? 4.9 }}</span>
                                    <span>• {{ $pro->experience ?? '5+ yrs' }}</span>
                                </div>
                            </div>
                        </div>
                        @if($pro->is_verified ?? true)
                            <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px; border: 1px solid #A7F3D0; white-space: nowrap;">
                                ✓ Verified
                            </span>
                        @endif
                    </a>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 24px; color: #64748B;">
                        No technicians currently listed.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- Dynamic Verified Homeowner Stories & Testimonials -->
    @if(isset($testimonials) && count($testimonials) > 0)
    <section style="background: #FFFFFF; padding: 56px 0;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; flex-wrap: wrap; gap: 14px;">
                <div>
                    <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Community Feedback</span>
                    <h2 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 4px 0 0 0;">What Homeowners Say</h2>
                </div>
                <div style="font-size: 13.5px; color: #64748B;">
                    ★ Over <strong style="color: #0F172A;">{{ $stats['completed_jobs'] ?? '18,500+' }}</strong> jobs completed across Pakistan
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                @foreach($testimonials as $t)
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03); display: flex; flex-direction: column; justify-content: space-between; gap: 16px; transition: all 0.2s;" onmouseover="this.style.borderColor='#FFC107'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)';">
                        <div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <div style="color: #F59E0B; font-size: 14px;">★★★★★</div>
                                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px; border: 1px solid #A7F3D0;">
                                    ✓ Verified Customer
                                </span>
                            </div>
                            <p style="font-size: 13.5px; color: #334155; line-height: 1.65; font-style: italic; margin: 0;">
                                "{{ $t['comment'] }}"
                            </p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; border-top: 1px solid #F1F5F9; padding-top: 14px;">
                            <img src="{{ $t['avatar'] }}" alt="{{ $t['name'] }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 1.5px solid #FFB800;">
                            <div>
                                <strong style="font-size: 14px; color: #0F172A; display: block;">{{ $t['name'] }}</strong>
                                <span style="font-size: 12px; color: #64748B;">{{ $t['location'] }} &middot; {{ $t['trade'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</div>
@endsection
