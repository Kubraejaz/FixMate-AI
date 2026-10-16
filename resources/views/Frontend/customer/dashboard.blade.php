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
                <!-- "Let's Talk" Video Meeting Button for uneducated/voice-first customers -->
                <a href="{{ route('video-meeting.initiate', ['booking_id' => $nearUpcomingBooking->id]) }}" 
                   style="background: #0F172A; color: #FFB800; border: 1.5px solid #FFB800; padding: 10px 18px; font-size: 13px; font-weight: 800; text-decoration: none; border-radius: 8px; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);"
                   title="Start live video call with assigned technician">
                    <span style="font-size: 15px;">📹</span> <span>Let's Talk (Video Call)</span>
                </a>

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

    <!-- FixMate Home Care VIP Pass Banner & Status Card -->
    @php
        $isCustVip = $user->isVip();
        $vipAnnualSavings = max(0, ($vipMonthlyPrice * 12) - $vipAnnualPrice);
        $vipAnnualSavingsPct = $vipMonthlyPrice > 0 ? (int) round(($vipAnnualSavings / ($vipMonthlyPrice * 12)) * 100) : 0;
    @endphp

    <div id="vipSubscriptionSection" style="background: {{ $isCustVip ? 'linear-gradient(135deg, #0F172A 0%, #1E293B 100%)' : 'linear-gradient(135deg, #18181B 0%, #27272A 100%)' }}; border: 2px solid {{ $isCustVip ? '#F59E0B' : '#EAB308' }}; border-radius: 18px; padding: 22px 26px; margin-bottom: 24px; color: #FFFFFF; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 18px; flex: 1; min-width: 290px;">
            <div style="width: 56px; height: 56px; border-radius: 16px; background: {{ $isCustVip ? 'linear-gradient(135deg, #F59E0B, #D97706)' : 'linear-gradient(135deg, #FACC15, #CA8A04)' }}; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4); flex-shrink: 0;">
                👑
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px; flex-wrap: wrap;">
                    <h3 style="font-size: 18px; font-weight: 900; color: #FDE047; margin: 0;">
                        {{ $isCustVip ? 'FixMate Home Care VIP Member (Active)' : 'FixMate Home Care VIP Pass — Waive All Booking Fees' }}
                    </h3>
                    @if($isCustVip)
                        <span style="background: #10B981; color: #FFFFFF; font-size: 11px; font-weight: 900; padding: 2px 10px; border-radius: 20px; text-transform: uppercase;">
                            ● 0% Convenience Fee Active
                        </span>
                    @else
                        <span style="background: #EAB308; color: #000000; font-size: 11px; font-weight: 900; padding: 2px 10px; border-radius: 20px; text-transform: uppercase;">
                            Save Rs. 50 On Every Request
                        </span>
                    @endif
                </div>
                <p style="font-size: 13.5px; color: #E4E4E7; margin: 0; line-height: 1.45;">
                    @if($isCustVip)
                        Your VIP Pass is active until <strong>{{ $user->subscribed_until->format('M d, Y') }}</strong>! You enjoy <strong>0% booking fees</strong>, <strong>15-minute priority dispatch</strong>, and <strong>30-day extended repair warranty</strong>.
                    @else
                        Join FixMate Home Care VIP Club for only <strong>Rs. {{ number_format($vipMonthlyPrice) }}/mo</strong>! Get <strong>Rs. 0 platform fees</strong>, guaranteed <strong>15-minute priority technician dispatch</strong>, and <strong>30-day extended repair warranty</strong>.
                    @endif
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <button type="button" onclick="document.getElementById('customerSubscriptionModal').style.display='flex';" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: #000000; font-weight: 900; font-size: 13.5px; padding: 12px 24px; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);">
                <span>👑</span>
                <span>{{ $isCustVip ? 'Extend VIP Membership' : 'Join VIP Club (Rs. ' . number_format($vipMonthlyPrice) . '/mo) →' }}</span>
            </button>
        </div>
    </div>

    <!-- Customer VIP Subscription Modal -->
    <div id="customerSubscriptionModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 99999; align-items: center; justify-content: center; padding: 16px;">
        <div style="background: #FFFFFF; border-radius: 20px; max-width: 520px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); position: relative; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 26px;">👑</span>
                    <h3 style="font-size: 20px; font-weight: 900; color: #111; margin: 0;">FixMate Home Care VIP Pass</h3>
                </div>
                <button type="button" onclick="document.getElementById('customerSubscriptionModal').style.display='none';" style="background: #F3F4F6; border: none; font-size: 18px; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;">✕</button>
            </div>

            <div style="background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 12px; padding: 14px; margin-bottom: 20px;">
                <div style="font-size: 13.5px; font-weight: 800; color: #92400E; margin-bottom: 6px;">Exclusive VIP Member Perks:</div>
                <ul style="font-size: 13px; color: #78350F; margin: 0; padding-left: 20px; line-height: 1.6;">
                    <li><strong>0% Platform Convenience Fees:</strong> Save Rs. 50 on every single booking!</li>
                    <li><strong>15-Minute Priority Dispatch:</strong> Top queue priority for certified plumbers, electricians & AC pros.</li>
                    <li><strong>30-Day Extended Repair Warranty:</strong> FixMate guarantees free re-inspection if issue reoccurs.</li>
                    <li><strong>Unlimited AI Diagnostics & Video Meets:</strong> Direct remote expert assistance whenever you need it.</li>
                </ul>
            </div>

            <form action="{{ route('customer.subscription.upgrade') }}" method="POST">
                @csrf
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 8px;">Select VIP Membership Plan:</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <label style="border: 2px solid #F59E0B; border-radius: 12px; padding: 14px; cursor: pointer; background: #FFFDF5; display: block;">
                            <input type="radio" name="plan_name" value="vip_monthly" checked style="margin-right: 6px;">
                            <strong style="font-size: 14px; color: #111; display: block; margin-top: 4px;">Monthly VIP</strong>
                            <span style="font-size: 18px; font-weight: 900; color: #D97706;">Rs. {{ number_format($vipMonthlyPrice) }}</span>
                            <span style="font-size: 11px; color: #6B7280; display: block;">Billed monthly</span>
                        </label>
                        <label style="border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 14px; cursor: pointer; background: #FFFFFF; display: block;">
                            <input type="radio" name="plan_name" value="vip_annual" style="margin-right: 6px;">
                            <strong style="font-size: 14px; color: #111; display: block; margin-top: 4px;">Annual VIP Pass</strong>
                            <span style="font-size: 18px; font-weight: 900; color: #047857;">Rs. {{ number_format($vipAnnualPrice) }}</span>
                            <span style="font-size: 11px; color: #10B981; font-weight: 800; display: block;">Save {{ $vipAnnualSavingsPct }}% (Rs. {{ number_format($vipAnnualSavings) }} off)</span>
                        </label>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 8px;">Payment Method:</label>
                    <select name="payment_method" id="custVipPaymentMethod" onchange="onCustVipPaymentChange(this.value)" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 700; background: #FFF;">
                        <option value="jazzcash">JazzCash Mobile Account</option>
                        <option value="easypaisa">EasyPaisa Mobile Account</option>
                        <option value="card">Debit / Credit Card (Visa / Mastercard)</option>
                    </select>
                </div>

                <div id="custVipMobileBox" style="margin-bottom: 18px; background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 10px; padding: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #374151; margin-bottom: 6px;">Mobile Account Number <span style="color: #DC2626;">*</span></label>
                    <input type="text" name="account_number" maxlength="25" placeholder="03001234567" value="{{ $user->phone ?? '' }}" style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700; margin-bottom: 10px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #374151; margin-bottom: 6px;">Verification OTP / MPIN <span style="color: #DC2626;">*</span></label>
                    <input type="text" inputmode="numeric" name="mpin" maxlength="10" placeholder="Enter OTP / MPIN" style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700; letter-spacing: 2px;">
                </div>

                <div id="custVipCardBox" style="display: none; margin-bottom: 18px; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #374151; margin-bottom: 6px;">Name on Card <span style="color: #DC2626;">*</span></label>
                    <input type="text" name="card_name" maxlength="100" placeholder="Cardholder Name" value="{{ $user->name ?? '' }}" style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700; text-transform: uppercase; margin-bottom: 10px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #374151; margin-bottom: 6px;">Card Number <span style="color: #DC2626;">*</span></label>
                    <input type="text" name="card_number" maxlength="19" placeholder="4242 4242 4242 4242" style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 800; letter-spacing: 1px; margin-bottom: 10px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="display: block; font-size: 11.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">Expiry (MM/YY) <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="card_expiry" maxlength="5" placeholder="12/28" style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">CVC <span style="color: #DC2626;">*</span></label>
                            <input type="password" name="card_cvc" maxlength="4" placeholder="•••" style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700;">
                        </div>
                    </div>
                    <label style="display: block; font-size: 11.5px; font-weight: 800; color: #374151; margin: 10px 0 6px;">Bank OTP (only if prompted)</label>
                    <input type="text" inputmode="numeric" name="card_otp" maxlength="10" placeholder="OTP from your bank" style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700; letter-spacing: 2px;">
                    <small style="display: block; font-size: 11px; color: #64748B; margin-top: 6px; font-weight: 600;">Processed securely by PayFast. If your bank sends an OTP, enter it and submit again.</small>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="document.getElementById('customerSubscriptionModal').style.display='none';" style="flex: 1; padding: 12px; border-radius: 10px; border: 1.5px solid #E5E7EB; background: #F9FAFB; font-weight: 700; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" style="flex: 2; padding: 12px; border-radius: 10px; border: none; background: #111827; color: #FDE047; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        Activate VIP Membership Now →
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function onCustVipPaymentChange(method) {
            const mobileBox = document.getElementById('custVipMobileBox');
            const cardBox = document.getElementById('custVipCardBox');
            if (!mobileBox || !cardBox) return;
            mobileBox.style.display = method === 'card' ? 'none' : 'block';
            cardBox.style.display = method === 'card' ? 'block' : 'none';
        }
    </script>

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
                        <div style="display: flex; gap: 6px; margin-top: 6px;">
                            <a href="{{ route('video-meeting.initiate', ['technician_id' => $tech->id]) }}" class="btn-outline" style="flex: 1; font-size: 11px; padding: 6px 4px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 3px;" title="Let's Talk Video Call">
                                📹 Talk
                            </a>
                            <a href="{{ route('customer.booking', ['tech_id' => $tech->id]) }}" class="btn-yellow" style="flex: 1; font-size: 11.5px; padding: 6px 4px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                Book
                            </a>
                        </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.hash === '#vipSubscription' || window.location.hash === '#subscriptionModal') {
            const modal = document.getElementById('customerSubscriptionModal');
            if (modal) {
                modal.style.display = 'flex';
                modal.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
</script>
@endsection
