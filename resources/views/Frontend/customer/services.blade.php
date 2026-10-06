@extends('Frontend.layouts.customer')

@section('title', 'All Services & Home Categories — FixMate')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Top Header & Filter Banner -->
    <div class="portal-card" style="padding: 28px 32px; background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #FFFFFF; border-radius: 18px; border: none; box-shadow: 0 10px 25px rgba(15,23,42,0.12);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
            <div style="max-width: 620px;">
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,193,7,0.15); border: 1px solid rgba(255,193,7,0.3); padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; color: #FFC107; text-transform: uppercase; letter-spacing: 0.05em;">Home Maintenance Catalog</span>
                    <span style="font-size: 11px; color: #94A3B8;">• Standardized Upfront Tariffs</span>
                </div>
                <h1 style="font-size: 28px; font-weight: 900; color: #FFFFFF; margin: 0 0 8px 0; letter-spacing: -0.02em;">
                    All Services &amp; Trade Categories
                </h1>
                <p style="font-size: 14px; color: #94A3B8; margin: 0; line-height: 1.6;">
                    Explore verified home services across Pakistan with zero roadside price bargaining. Select any trade to book an upfront fixed-price appointment with background-verified technicians.
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('customer.services') }}" method="GET" style="display: flex; gap: 8px; width: 100%; max-width: 360px; margin-top: 10px;">
                @if($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                <div style="position: relative; flex: 1;">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search repair, plumbing, ac..." 
                           style="width: 100%; padding: 12px 14px 12px 38px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFFFFF; font-size: 13.5px; outline: none;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 14px; color: #94A3B8;">🔍</span>
                </div>
                <button type="submit" class="btn-yellow" style="padding: 10px 18px; font-size: 13.5px; border-radius: 10px; font-weight: 800;">
                    Search
                </button>
            </form>
        </div>

        <!-- Filter Pill Tabs -->
        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('customer.services', array_filter(['search' => $search])) }}" 
               style="text-decoration: none; font-size: 12.5px; font-weight: 700; padding: 7px 16px; border-radius: 20px; transition: all 0.2s; {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'background: #FFC107; color: #0F172A;' : 'background: rgba(255,255,255,0.08); color: #E2E8F0;' }}">
                All Categories ({{ $allCategories->count() }})
            </a>
            @foreach($allCategories as $cat)
                <a href="{{ route('customer.services', array_filter(['category' => $cat->slug, 'search' => $search])) }}" 
                   style="text-decoration: none; font-size: 12.5px; font-weight: 700; padding: 7px 16px; border-radius: 20px; transition: all 0.2s; {{ $selectedCategory === $cat->slug ? 'background: #FFC107; color: #0F172A;' : 'background: rgba(255,255,255,0.08); color: #CBD5E1;' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    @if($search || $selectedCategory)
        <div style="display: flex; justify-content: space-between; align-items: center; background: #F8FAFC; padding: 10px 18px; border-radius: 10px; border: 1px solid #E2E8F0;">
            <span style="font-size: 13.5px; color: #475569;">
                Showing results for 
                @if($search) <strong>"{{ $search }}"</strong> @endif
                @if($selectedCategory) in category <strong>{{ ucfirst(str_replace('-', ' ', $selectedCategory)) }}</strong> @endif
                ({{ $professions->count() }} trade categories found)
            </span>
            <a href="{{ route('customer.services') }}" style="font-size: 12.5px; color: #EF4444; font-weight: 700; text-decoration: none;">
                ✕ Clear Filters
            </a>
        </div>
    @endif

    <!-- Services Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 22px;">
        @forelse($professions as $prof)
            <div class="portal-card" style="padding: 24px; border: 1px solid #E2E8F0; border-radius: 16px; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s; background: #FFFFFF;"
                 onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                
                <div>
                    <!-- Header with Icon & Verified Count -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                        <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1.5px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            @php
                                $icons = [
                                    'plumber' => '🔧',
                                    'electrician' => '⚡',
                                    'ac-refrigeration' => '❄️',
                                    'carpenter' => '🪚',
                                    'painter' => '🎨',
                                    'deep-cleaning' => '🧹',
                                    'home-appliances' => '🔌',
                                    'solar-ups' => '☀️',
                                    'handyman-masonry' => '🔨',
                                    'pest-control' => '🛡️',
                                ];
                                $tradeIcon = $icons[$prof->slug] ?? '🛠️';
                            @endphp
                            {{ $tradeIcon }}
                        </div>

                        <div style="text-align: right;">
                            <span style="font-size: 11px; font-weight: 700; background: #F1F5F9; color: #475569; padding: 4px 10px; border-radius: 12px; display: inline-block;">
                                👷 {{ $prof->professionals_count }} Verified Pros
                            </span>
                        </div>
                    </div>

                    <!-- Category Title & Description -->
                    <h2 style="font-size: 19px; font-weight: 900; color: #0F172A; margin: 0 0 6px 0;">
                        {{ $prof->name }}
                    </h2>
                    
                    @if($prof->headline)
                        <span style="font-size: 12px; font-weight: 700; color: #B45309; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 8px;">
                            {{ $prof->headline }}
                        </span>
                    @endif

                    <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.55; min-height: 42px;">
                        {{ $prof->description }}
                    </p>

                    <!-- Sub-Categories Badges -->
                    @if(!empty($prof->sub_categories_list))
                        <div style="margin-bottom: 16px;">
                            <span style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">
                                Sub-Categories &amp; Scope:
                            </span>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                @foreach($prof->sub_categories_list as $subCat)
                                    <span style="font-size: 11.5px; font-weight: 600; color: #1E293B; background: #F1F5F9; border: 1px solid #E2E8F0; padding: 3px 9px; border-radius: 6px;">
                                        {{ $subCat }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Feature Bullet Points -->
                    @if(!empty($prof->feature_points) && is_array($prof->feature_points))
                        <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                            <span style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; display: block; margin-bottom: 6px;">
                                Common Inclusions
                            </span>
                            <ul style="margin: 0; padding-left: 18px; font-size: 12.5px; color: #334155; line-height: 1.6;">
                                @foreach(array_slice($prof->feature_points, 0, 3) as $point)
                                    <li>{{ $point }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Pricing & Warranty Strip -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-top: 1px dashed #E2E8F0; border-bottom: 1px dashed #E2E8F0; margin-bottom: 18px;">
                        <div>
                            <span style="font-size: 11px; color: #94A3B8; text-transform: uppercase; font-weight: 700; display: block;">Standard Tariff</span>
                            <strong style="font-size: 16px; color: #0F172A;">
                                Rs. {{ number_format($prof->base_price ?? 800) }}
                            </strong>
                            <span style="font-size: 11px; color: #64748B;">/ {{ $prof->price_unit ?? 'job' }}</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 11px; color: #059669; font-weight: 700; background: #DCFCE7; padding: 3px 8px; border-radius: 6px;">
                                ✓ {{ $prof->warranty_text ?? '30-Day Guarantee' }}
                            </span>
                            @if($prof->estimated_duration)
                                <span style="font-size: 11px; color: #94A3B8; display: block; margin-top: 3px;">
                                    ⏱️ {{ $prof->estimated_duration }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 8px;">
                    <a href="{{ route('customer.technicians', ['profession' => $prof->slug]) }}" 
                       class="btn-outline" 
                       style="text-align: center; padding: 10px 12px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 9px;">
                        View Pros
                    </a>
                    <a href="{{ route('customer.booking', ['profession' => $prof->slug]) }}" 
                       class="btn-yellow" 
                       style="text-align: center; padding: 10px 12px; font-size: 13px; font-weight: 800; text-decoration: none; border-radius: 9px;">
                        Book Now &rarr;
                    </a>
                </div>

            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #FFFFFF; border-radius: 16px; border: 1px solid #E2E8F0;">
                <div style="font-size: 42px; margin-bottom: 12px;">🔍</div>
                <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">No services found matching your filter</h3>
                <p style="font-size: 14px; color: #64748B; margin: 0 0 20px 0;">Try adjusting your keyword or reset category selection.</p>
                <a href="{{ route('customer.services') }}" class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; text-decoration: none; border-radius: 8px;">
                    View All Services
                </a>
            </div>
        @endforelse
    </div>

    <!-- Assurance Banner for Customer Portal -->
    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px 28px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div style="display: flex; gap: 12px; align-items: flex-start;">
            <span style="font-size: 22px;">🔒</span>
            <div>
                <strong style="font-size: 13.5px; color: #0F172A; display: block; margin-bottom: 2px;">Smart Escrow Protection</strong>
                <span style="font-size: 12px; color: #64748B;">Payments remain frozen until you provide your 4-digit arrival and satisfaction OTP codes.</span>
            </div>
        </div>
        <div style="display: flex; gap: 12px; align-items: flex-start;">
            <span style="font-size: 22px;">🪪</span>
            <div>
                <strong style="font-size: 13.5px; color: #0F172A; display: block; margin-bottom: 2px;">NADRA Verified Pros</strong>
                <span style="font-size: 12px; color: #64748B;">All technicians pass government biometric CNIC checks and criminal background screenings.</span>
            </div>
        </div>
        <div style="display: flex; gap: 12px; align-items: flex-start;">
            <span style="font-size: 22px;">🛡️</span>
            <div>
                <strong style="font-size: 13.5px; color: #0F172A; display: block; margin-bottom: 2px;">Standardized Price Tariffs</strong>
                <span style="font-size: 12px; color: #64748B;">Transparent labor charges with zero roadside bargaining and zero surprise add-ons.</span>
            </div>
        </div>
    </div>

</div>
@endsection
