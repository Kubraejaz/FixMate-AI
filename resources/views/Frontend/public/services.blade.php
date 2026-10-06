@extends('Frontend.layouts.public')

@section('title', 'All Services & Upfront Pricing — FixMate')
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
                No roadside negotiations or surprise invoices. Book licensed tradespeople with fixed transparent pricing, verified technicians, and 60-day rework warranty.
            </p>

            <!-- Action Bar -->
            <div style="margin-top: 24px; display: inline-flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                <a href="{{ route('technicians') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 24px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(255, 184, 0, 0.35);">
                    <span>👷</span>
                    <span>Find Local Technicians</span>
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
            
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h2 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Available Service Categories</h2>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Select a trade to view pre-screened certified technicians in your neighborhood.</p>
                </div>
                <span style="font-size: 13px; font-weight: 700; color: #059669; background: #DCFCE7; padding: 4px 12px; border-radius: 20px;">
                    ● 2,400+ Verified Pros Active
                </span>
            </div>

            @php
                $activeServices = ($professions ?? \App\Models\Profession::where('is_active', true)->get());
                $palettes = [
                    'plumber' => ['bg' => '#E0F2FE', 'border' => '#93C5FD', 'textColor' => '#0369A1'],
                    'electrician' => ['bg' => '#FEF3C7', 'border' => '#FDE68A', 'textColor' => '#92400E'],
                    'ac-refrigeration' => ['bg' => '#E0F7FA', 'border' => '#A5F3FC', 'textColor' => '#0E7490'],
                    'deep-cleaning' => ['bg' => '#DCFCE7', 'border' => '#86EFAC', 'textColor' => '#15803D'],
                    'painter' => ['bg' => '#FFEDD5', 'border' => '#FDBA74', 'textColor' => '#C2410C'],
                    'carpenter' => ['bg' => '#F3E8FF', 'border' => '#D8B4FE', 'textColor' => '#7E22CE'],
                    'home-appliances' => ['bg' => '#CCFBF1', 'border' => '#99F6E4', 'textColor' => '#0F766E'],
                    'solar-ups' => ['bg' => '#FEF3C7', 'border' => '#FDE68A', 'textColor' => '#D97706'],
                    'handyman-masonry' => ['bg' => '#F1F5F9', 'border' => '#CBD5E1', 'textColor' => '#334155'],
                    'pest-control' => ['bg' => '#ECFDF5', 'border' => '#A7F3D0', 'textColor' => '#047857'],
                ];
            @endphp

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @forelse($activeServices as $prof)
                    @php
                        $style = $palettes[$prof->slug] ?? ['bg' => '#FFF9E6', 'border' => '#FEF08A', 'textColor' => '#B45309'];
                        $techCount = $prof->professionals_count ?? $prof->professionals()->count();
                    @endphp
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 26px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: all 0.2s; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.borderColor='{{ $style['border'] }}'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                                <div style="width: 52px; height: 52px; border-radius: 14px; background: {{ $style['bg'] }}; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                                    {{ $prof->display_icon }}
                                </div>
                                <span style="font-size: 11.5px; font-weight: 700; color: {{ $style['textColor'] }}; background: {{ $style['bg'] }}; padding: 3px 10px; border-radius: 12px;">
                                    {{ $techCount > 0 ? $techCount . '+ Technicians' : 'Available' }}
                                </span>
                            </div>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">{{ $prof->name }}</h3>
                            <p style="font-size: 13.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
                                {{ $prof->description ?? 'Reliable home repair and maintenance services by certified background-checked technicians.' }}
                            </p>
                            
                            <!-- Dynamic Scope Points from Database -->
                            <div style="border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 12px 0; margin-bottom: 16px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px;">
                                @foreach($prof->feature_points_list as $pt)
                                    <div>✓ {{ $pt }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                <span style="font-size: 12px; color: #64748B;">Starting from</span>
                                <strong style="font-size: 16px; color: #0F172A;">
                                    {{ $prof->formatted_price }} 
                                    <span style="font-size: 11px; font-weight: normal; color: #64748B;">{{ $prof->price_unit }}</span>
                                </strong>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <a href="{{ url('/services/' . $prof->slug) }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Details</a>
                                <a href="{{ url('/customer/booking?profession=' . $prof->slug) }}" style="text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">Book Now</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #F8FAFC; border-radius: 16px;">
                        <p style="font-size: 16px; color: #64748B; margin: 0;">No active services currently listed.</p>
                    </div>
                @endforelse
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
                            <th style="padding: 16px 20px;">Warranty Coverage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeServices as $index => $row)
                            <tr style="border-bottom: 1px solid #F1F5F9; {{ $index % 2 === 1 ? 'background: #FAFAFA;' : '' }}">
                                <td style="padding: 14px 20px; font-weight: 600; color: #0F172A;">
                                    <span style="font-size: 18px; margin-right: 6px;">{{ $row->display_icon }}</span>
                                    {{ $row->headline ?: $row->name . ' Service & Maintenance' }}
                                </td>
                                <td style="padding: 14px 20px; color: #64748B;">{{ $row->estimated_duration ?: '30 – 60 mins' }}</td>
                                <td style="padding: 14px 20px; font-weight: 800; color: #0F172A;">
                                    Rs. {{ number_format($row->base_price) }}
                                    <span style="font-size: 11px; font-weight: normal; color: #64748B;">{{ $row->price_unit }}</span>
                                </td>
                                <td style="padding: 14px 20px;">
                                    <span style="color: #059669; font-weight: 700;">{{ $row->warranty_text ?: '60 Days Escrow' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 20px; text-align: center; color: #64748B;">No pricing benchmarks available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <p style="text-align: center; font-size: 13px; color: #64748B; margin-top: 14px;">
                💡 <em>All prices are verified fixed labor rates. Technicians are prohibited from negotiating higher rates upon arrival.</em>
            </p>
        </div>
    </section>

    <!-- The FixMate Quality Standards Strip -->
    <section style="padding: 50px 0; background: #FFFFFF;">
        <div class="container">
            <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 20px; padding: 36px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 36px; align-items: center;">
                    <div>
                        <span style="font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase;">THE FIXMATE PROMISE</span>
                        <h3 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 4px 0 12px 0;">Never Worry About Unreliable Handymen Again</h3>
                        <p style="font-size: 14.5px; color: #475569; line-height: 1.6; margin: 0 0 20px 0;">
                            In conventional local markets, finding an electrician or plumber means uncertain pricing, no background checks, and zero warranty when things break again. FixMate redesigns the entire experience with accountability.
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
