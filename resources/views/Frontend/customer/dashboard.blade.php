@extends('Frontend.layouts.customer')

@section('title', 'Customer Dashboard — FixMate')

@section('content')
<div>
    
    <!-- Welcome Header -->
    <div style="margin-bottom: 20px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Welcome, {{ $user->name }}</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Here's what's happening with your home services, active requests and verified technicians.</p>
    </div>

    <!-- 1. Live Ongoing Job Alert Banner (Dynamic when a job is en-route or in-progress) -->
    @if($activeEnRouteBooking)
        <div style="background: linear-gradient(135deg, #FFF9E6 0%, #FEF3C7 100%); border: 2px solid #FFCC00; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(255,204,0,0.15); flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 0 0 4px rgba(255,204,0,0.3);">
                    🛵
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <span style="background: #111; color: #FFCC00; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">
                            {{ $activeEnRouteBooking->status_label }}
                        </span>
                        <strong style="font-size: 15px; color: #111;">{{ $activeEnRouteBooking->service_title }}</strong>
                    </div>
                    <span style="font-size: 13px; color: #4B5563;">
                        Assigned Pro: <strong>{{ $activeEnRouteBooking->professional?->name ?? 'FixMate Dedicated Pro' }}</strong> ({{ $activeEnRouteBooking->profession?->name ?? 'Technician' }})
                    </span>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 16px;">
                <!-- Handshake OTP -->
                <div style="background: #FFFFFF; border: 1.5px dashed #B45309; border-radius: 10px; padding: 6px 14px; text-align: center;">
                    <span style="font-size: 10px; font-weight: 800; color: #92400E; display: block; text-transform: uppercase;">Arrival OTP</span>
                    <strong style="font-size: 18px; font-weight: 900; letter-spacing: 2px; color: #111;">{{ $activeEnRouteBooking->arrival_otp }}</strong>
                </div>

                <a href="{{ route('customer.bookings') }}" class="btn-yellow" style="padding: 10px 20px; font-size: 13px; font-weight: 800; text-decoration: none; border-radius: 8px;">
                    📋 View Booking →
                </a>
            </div>
        </div>
    @endif

    <!-- 2. Upcoming Booking Date Near Alert Banner -->
    @if(isset($nearUpcomingBooking) && $nearUpcomingBooking && (! $activeEnRouteBooking || $activeEnRouteBooking->id !== $nearUpcomingBooking->id))
        @php
            $isToday = $nearUpcomingBooking->service_date->isToday();
            $isTomorrow = $nearUpcomingBooking->service_date->isTomorrow();
            $dayBadge = $isToday ? 'TODAY' : ($isTomorrow ? 'TOMORROW' : $nearUpcomingBooking->service_date->format('M d'));
            $bgGradient = $isToday 
                ? 'linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%)' 
                : 'linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%)';
            $borderColor = $isToday ? '#EF4444' : '#F59E0B';
            $badgeBg = $isToday ? '#DC2626' : '#D97706';
            $pulseColor = $isToday ? 'rgba(239, 68, 68, 0.4)' : 'rgba(245, 158, 11, 0.4)';
        @endphp
        <div id="nearBookingAlert" style="background: {{ $bgGradient }}; border: 2px solid {{ $borderColor }}; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 16px {{ $pulseColor }}; flex-wrap: wrap; gap: 16px; position: relative;">
            <div style="display: flex; align-items: center; gap: 14px; flex: 1; min-width: 280px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #FFFFFF; border: 2px solid {{ $borderColor }}; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    ⏰
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                        <span style="background: {{ $badgeBg }}; color: #FFFFFF; font-size: 11px; font-weight: 900; padding: 2px 10px; border-radius: 12px; letter-spacing: 0.5px;">
                            SERVICE SCHEDULED FOR {{ $dayBadge }}
                        </span>
                        <strong style="font-size: 15px; color: #0F172A;">{{ $nearUpcomingBooking->service_title }}</strong>
                        <span style="font-size: 12px; color: #64748B;">(#{{ $nearUpcomingBooking->booking_number }})</span>
                    </div>
                    <div style="font-size: 13px; color: #334155; line-height: 1.4;">
                        🗓️ <strong>{{ $nearUpcomingBooking->service_date->format('l, M d, Y') }}</strong> during <strong>{{ $nearUpcomingBooking->service_time_slot }}</strong>
                        @if($nearUpcomingBooking->professional)
                            • Assigned Pro: <strong>{{ $nearUpcomingBooking->professional->name }}</strong>
                        @endif
                        <span style="display: block; font-size: 12px; color: #64748B; margin-top: 2px;">📍 {{ $nearUpcomingBooking->service_address }}, {{ $nearUpcomingBooking->city }}</span>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                @if($nearUpcomingBooking->arrival_otp)
                    <div style="background: #FFFFFF; border: 1.5px dashed {{ $borderColor }}; border-radius: 10px; padding: 6px 14px; text-align: center;">
                        <span style="font-size: 10px; font-weight: 800; color: #64748B; display: block; text-transform: uppercase;">Arrival OTP</span>
                        <strong style="font-size: 16px; font-weight: 900; letter-spacing: 2px; color: #0F172A;">{{ $nearUpcomingBooking->arrival_otp }}</strong>
                    </div>
                @endif
                <a href="{{ route('customer.bookings') }}" class="btn-yellow" style="padding: 10px 18px; font-size: 13px; font-weight: 800; text-decoration: none; border-radius: 8px; white-space: nowrap;">
                    View Booking Details →
                </a>
            </div>
        </div>
    @endif

    <!-- 4 Stats Cards matching Mockup 1 -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
        
        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Active Requests</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">{{ $stats['active'] ?? 0 }}</strong>
                <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 8px; border-radius: 12px;">In Progress</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Upcoming Bookings</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">{{ $stats['upcoming'] ?? 0 }}</strong>
                <span style="font-size: 11px; background: #EFF6FF; color: #1D4ED8; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Scheduled</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Completed Services</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">{{ $stats['completed'] ?? 0 }}</strong>
                <span style="font-size: 11px; background: #F3F4F6; color: #374151; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Verified</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Pending Requests</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">{{ $stats['pending'] ?? 0 }}</strong>
                <span style="font-size: 11px; background: #FFFBEB; color: #B45309; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Awaiting Pro</span>
            </div>
        </div>

    </div>

    <!-- Quick Book by Trade Category Grid (100% Dynamic Professions) -->
    <div style="margin-bottom: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Quick Book by Trade</h3>
            <a href="{{ route('customer.technicians') }}" style="font-size: 13px; color: #B45309; font-weight: 700; text-decoration: none;">View All Trades →</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px;">
            @php
                $tradeIcons = [
                    'plumber' => '🚰',
                    'electrician' => '⚡',
                    'ac-refrigeration' => '❄️',
                    'carpenter' => '🪚',
                    'painter' => '🎨',
                    'deep-cleaning' => '🧹',
                    'home-appliances' => '🔧',
                ];
            @endphp
            @foreach($quickTrades as $trade)
                <a href="{{ route('customer.booking', ['profession' => $trade->slug]) }}" class="portal-card" style="padding: 16px 10px; text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <span style="font-size: 24px;">{{ $tradeIcons[$trade->slug] ?? '🛠️' }}</span>
                    <strong style="font-size: 13px; color: #111; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">{{ $trade->name }}</strong>
                    <span style="font-size: 10.5px; color: #047857; font-weight: 700;">From Rs. {{ number_format($trade->base_price) }}</span>
                </a>
            @endforeach
        </div>
    </div>


    <!-- Local Civic Alerts if available in customer city -->
    @if($cityAlerts->isNotEmpty())
        <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 14px; padding: 14px 20px; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; font-size: 13px; color: #1E40AF;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 20px;">📢</span>
                <div>
                    <strong>Civic Alert for {{ $user->city ?? 'Karachi' }}:</strong>
                    {{ $cityAlerts->first()->title }} ({{ $cityAlerts->first()->upvotes_count ?? 12 }} residents confirmed)
                </div>
            </div>
            <a href="{{ route('community') }}" style="color: #1D4ED8; font-weight: 800; text-decoration: none; white-space: nowrap;">Community Board →</a>
        </div>
    @endif

    <!-- Two Columns: Recommended Technicians & Recent Bookings -->
    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 24px;">
        
        <!-- Left: Recommended Technicians -->
        <div class="portal-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0;">Recommended Technicians</h3>
                <a href="{{ route('customer.technicians') }}" style="font-size: 13px; color: #B45309; font-weight: 700; text-decoration: none;">View All →</a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                @forelse($recommendedTechnicians as $tech)
                    <div style="border: 1px solid var(--border-color); border-radius: 14px; padding: 16px 12px; text-align: center; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <img src="{{ asset($tech->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $tech->name }}" style="width: 58px; height: 58px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00; margin: 0 auto 8px auto; display: block;">
                            <strong style="display: block; font-size: 14px; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $tech->name }}</strong>
                            <span style="font-size: 11.5px; color: #757575; display: block; margin-bottom: 6px;">{{ $tech->profession->name ?? 'Verified Pro' }}</span>
                            <div style="font-size: 11.5px; color: #F59E0B; margin-bottom: 10px;">
                                ★ {{ number_format($tech->rating ?? 4.9, 1) }} <span style="color: #888;">({{ $tech->jobs_completed ?? 42 }})</span>
                            </div>
                        </div>
                        <a href="{{ route('customer.booking', ['tech_id' => $tech->id]) }}" class="btn-yellow" style="display: block; font-size: 12px; padding: 6px 0; border-radius: 6px; text-decoration: none;">Book Now</a>
                    </div>
                @empty
                    <div style="grid-column: span 3; text-align: center; color: #888; padding: 24px 0;">
                        No technicians found. <a href="{{ route('customer.booking') }}" style="color: #B45309; font-weight: 700;">Create a direct booking</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Recent Bookings -->
        <div class="portal-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0;">Recent Bookings</h3>
                <a href="{{ route('customer.bookings') }}" style="font-size: 13px; color: #B45309; font-weight: 700; text-decoration: none;">All →</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                @forelse($recentBookings as $bk)
                    <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="font-size: 14px; color: #111;">{{ $bk->service_title }}</strong>
                            <span style="font-size: 11px; {{ $bk->status === 'completed' ? 'background: #ECFDF5; color: #047857;' : ($bk->status === 'cancelled' ? 'background: #FEE2E2; color: #B91C1C;' : 'background: #FFFBEB; color: #B45309;') }} font-weight: 800; padding: 2px 7px; border-radius: 10px;">
                                {{ $bk->status_label }}
                            </span>
                        </div>
                        <div style="font-size: 12px; color: #777; margin-bottom: 6px;">
                            {{ $bk->service_date ? $bk->service_date->format('M d, Y') : 'Date TBD' }} • {{ $bk->service_time_slot }}
                            @if($bk->professional)
                                ({{ $bk->professional->name }})
                            @endif
                        </div>
                        <a href="{{ route('customer.bookings') }}" style="font-size: 12px; color: #1D4ED8; font-weight: 700; text-decoration: none;">View Details →</a>
                    </div>
                @empty
                    <div style="text-align: center; padding: 24px 0; color: #888;">
                        <span style="font-size: 28px; display: block; margin-bottom: 6px;">🛠️</span>
                        <strong style="display: block; font-size: 14px; color: #111; margin-bottom: 4px;">No bookings yet</strong>
                        <span style="font-size: 12px; color: #666; display: block; margin-bottom: 12px;">Book certified plumbers, electricians or AC technicians in minutes.</span>
                        <a href="{{ route('customer.booking') }}" class="btn-yellow" style="font-size: 12px; padding: 7px 16px; border-radius: 6px; text-decoration: none; display: inline-block;">Book Service</a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
