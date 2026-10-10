@extends('Frontend.layouts.technician')

@section('title', 'Technician Dashboard — FixMate Partner Portal')

@section('content')
<div>
    
    <!-- Welcome Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">
                Welcome back, {{ explode(' ', $user->name)[0] }}!
            </h1>
            <p style="font-size: 14px; color: #666; margin: 0;">
                Specialty: <strong>{{ $pro->profession?->name ?? 'Technician' }}</strong> &bull; Location: <strong>{{ $user->city ?? 'All Pakistan' }}</strong>
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 12px; color: #666;">Current Status:</span>
            @if(! $user->is_active || $pro->verification_status === 'rejected')
                <span style="background: #FFF1F2; color: #BE123C; font-weight: 800; font-size: 12px; padding: 4px 12px; border-radius: 20px; border: 1px solid #FECDD3;">
                    ● Profile Blocked
                </span>
            @elseif($pro->verification_status === 'returned')
                <span style="background: #FFF7ED; color: #C2410C; font-weight: 800; font-size: 12px; padding: 4px 12px; border-radius: 20px; border: 1px solid #FED7AA;">
                    ● Revision Required
                </span>
            @else
                <span style="background: #ECFDF5; color: #047857; font-weight: 800; font-size: 12px; padding: 4px 12px; border-radius: 20px; border: 1px solid #A7F3D0;">
                    ● Online &amp; Receiving Requests
                </span>
            @endif
        </div>
    </div>

    <!-- Profile Blocked Alert Banner -->
    @if(! $user->is_active || $pro->verification_status === 'rejected')
        <div style="background: #FFF1F2; border: 2px solid #E11D48; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #E11D48; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                    🚫
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 900; color: #9F1239; margin: 0 0 4px 0;">Profile Blocked: Verification Rejected</h3>
                    <p style="font-size: 13.5px; color: #BE123C; margin: 0; line-height: 1.4;">
                        Your technician profile has been blocked by FixMate administration.
                        @if($pro->rejection_reason)
                            <strong>Reason:</strong> {{ $pro->rejection_reason }} &bull;
                        @endif
                        Please contact the FixMate team for assistance.
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('contact') }}" style="background: #E11D48; color: #FFF; padding: 10px 22px; font-size: 13.5px; font-weight: 800; text-decoration: none; border-radius: 8px; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;">
                    <span>📞</span> Contact FixMate Team &rarr;
                </a>
            </div>
        </div>
    @elseif($pro->verification_status === 'returned')
        <div style="background: #FFF7ED; border: 2px solid #F97316; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #EA580C; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                    ↩
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 900; color: #9A3412; margin: 0 0 4px 0;">Verification Dossier Returned for Revision</h3>
                    <p style="font-size: 13.5px; color: #C2410C; margin: 0; line-height: 1.4;">
                        Admin requested changes: <strong>{{ $pro->rejection_reason ?: 'Please review and re-upload documents.' }}</strong>
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('technician.verification') }}" style="background: #C2410C; color: #FFF; padding: 10px 22px; font-size: 13.5px; font-weight: 800; text-decoration: none; border-radius: 8px; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;">
                    <span>↩</span> Update Documents &rarr;
                </a>
            </div>
        </div>
    @endif

    <!-- Upcoming Job Date Near Reminder Banner -->
    @if(isset($nearJob) && $nearJob && (! $activeJob || $activeJob->id !== $nearJob->id))
        @php
            $isToday = $nearJob->service_date->isToday();
            $isTomorrow = $nearJob->service_date->isTomorrow();
            $dayBadge = $isToday ? 'TODAY' : ($isTomorrow ? 'TOMORROW' : $nearJob->service_date->format('M d'));
            $borderCol = $isToday ? '#EF4444' : '#F59E0B';
            $badgeBg = $isToday ? '#DC2626' : '#D97706';
        @endphp
        <div style="background: #FFFBEB; border: 2px solid {{ $borderCol }}; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #FFFFFF; border: 2px solid {{ $borderCol }}; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                    ⏰
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <span style="background: {{ $badgeBg }}; color: #FFFFFF; font-size: 11px; font-weight: 900; padding: 2px 10px; border-radius: 12px;">
                            UPCOMING JOB {{ $dayBadge }}
                        </span>
                        <strong style="font-size: 15px; color: #0F172A;">{{ $nearJob->service_title }} (#{{ $nearJob->booking_number }})</strong>
                    </div>
                    <div style="font-size: 13px; color: #334155;">
                        Customer: <strong>{{ $nearJob->user?->name ?? 'Customer' }}</strong> • 🗓️ <strong>{{ $nearJob->service_date->format('l, M d') }}</strong> at <strong>{{ $nearJob->service_time_slot }}</strong>
                        <span style="display: block; font-size: 12px; color: #64748B; margin-top: 2px;">📍 {{ $nearJob->service_address }}, {{ $nearJob->city }}</span>
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('technician.jobs') }}" class="btn-yellow" style="padding: 10px 18px; font-size: 13px; font-weight: 800; text-decoration: none; border-radius: 8px; white-space: nowrap;">
                    View Schedule &amp; Job →
                </a>
            </div>
        </div>
    @endif

    <!-- FixMate Pro VIP Technician Subscription Banner & Status Card -->
    @php
        $isPro = $pro->hasActiveProSubscription();
        $monthlyPrice = (int) cache('subscription_monthly_price', 500);
        $annualPrice = (int) cache('subscription_annual_price', 4999);
    @endphp

    <div id="techSubscriptionBanner" style="background: {{ $isPro ? 'linear-gradient(135deg, #0F172A 0%, #1E293B 100%)' : 'linear-gradient(135deg, #18181B 0%, #27272A 100%)' }}; border: 2px solid {{ $isPro ? '#F59E0B' : '#EAB308' }}; border-radius: 18px; padding: 22px 26px; margin-bottom: 24px; color: #FFFFFF; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 18px; flex: 1; min-width: 290px;">
            <div style="width: 56px; height: 56px; border-radius: 16px; background: {{ $isPro ? 'linear-gradient(135deg, #F59E0B, #D97706)' : 'linear-gradient(135deg, #FACC15, #CA8A04)' }}; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4); flex-shrink: 0;">
                👑
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px; flex-wrap: wrap;">
                    <h3 style="font-size: 18px; font-weight: 900; color: #FDE047; margin: 0;">
                        {{ $isPro ? 'FixMate Pro VIP Partner (Active)' : 'FixMate Pro VIP Pass — 0% Commission' }}
                    </h3>
                    @if($isPro)
                        <span style="background: #10B981; color: #FFFFFF; font-size: 11px; font-weight: 900; padding: 2px 10px; border-radius: 20px; text-transform: uppercase;">
                            ● 0% Fee Active
                        </span>
                    @else
                        <span style="background: #EAB308; color: #000000; font-size: 11px; font-weight: 900; padding: 2px 10px; border-radius: 20px; text-transform: uppercase;">
                            Save 10% on Every Job
                        </span>
                    @endif
                </div>
                <p style="font-size: 13.5px; color: #E4E4E7; margin: 0; line-height: 1.45;">
                    @if($isPro)
                        You are keeping <strong>100% of your earnings</strong> with zero commission deductions! Valid until <strong>{{ $pro->subscribed_until->format('M d, Y') }}</strong>.
                    @else
                        Standard tier pays 10% commission. Upgrade to <strong>Pro VIP (Rs. {{ number_format($monthlyPrice) }}/mo)</strong> to keep <strong>100% of your earnings</strong>, get <strong>Top of Search placement</strong>, and receive <strong>Priority Dispatches</strong>!
                    @endif
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <button type="button" onclick="document.getElementById('techSubscriptionModal').style.display='flex';" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: #000000; font-weight: 900; font-size: 13.5px; padding: 12px 24px; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);">
                <span>👑</span>
                <span>{{ $isPro ? 'Extend VIP Plan' : 'Upgrade to Pro VIP →' }}</span>
            </button>
        </div>
    </div>

    <!-- Technician Subscription Modal -->
    <div id="techSubscriptionModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 99999; align-items: center; justify-content: center; padding: 16px;">
        <div style="background: #FFFFFF; border-radius: 20px; max-width: 520px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); position: relative; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 26px;">👑</span>
                    <h3 style="font-size: 20px; font-weight: 900; color: #111; margin: 0;">Upgrade to FixMate Pro VIP</h3>
                </div>
                <button type="button" onclick="document.getElementById('techSubscriptionModal').style.display='none';" style="background: #F3F4F6; border: none; font-size: 18px; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;">✕</button>
            </div>

            <div style="background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 12px; padding: 14px; margin-bottom: 20px;">
                <div style="font-size: 13.5px; font-weight: 800; color: #92400E; margin-bottom: 6px;">VIP Partner Perks Included:</div>
                <ul style="font-size: 13px; color: #78350F; margin: 0; padding-left: 20px; line-height: 1.6;">
                    <li><strong>0% Platform Commission:</strong> Keep 100% of all customer payments!</li>
                    <li><strong>#1 Search Placement:</strong> Appear first in the customer technician directory.</li>
                    <li><strong>FixMate Pro Verified Gold Badge:</strong> 3x higher customer booking conversion.</li>
                    <li><strong>Priority Dispatches:</strong> Instant notification for all emergency jobs.</li>
                </ul>
            </div>

            <form action="{{ route('technician.subscription.upgrade') }}" method="POST">
                @csrf
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 8px;">Select VIP Plan:</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <label style="border: 2px solid #F59E0B; border-radius: 12px; padding: 14px; cursor: pointer; background: #FFFDF5; display: block;">
                            <input type="radio" name="plan_name" value="pro_monthly" checked style="margin-right: 6px;">
                            <strong style="font-size: 14px; color: #111; display: block; margin-top: 4px;">Monthly Pass</strong>
                            <span style="font-size: 18px; font-weight: 900; color: #D97706;">Rs. {{ number_format($monthlyPrice) }}</span>
                            <span style="font-size: 11px; color: #6B7280; display: block;">Billed monthly</span>
                        </label>
                        <label style="border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 14px; cursor: pointer; background: #FFFFFF; display: block;">
                            <input type="radio" name="plan_name" value="pro_annual" style="margin-right: 6px;">
                            <strong style="font-size: 14px; color: #111; display: block; margin-top: 4px;">Annual Pass</strong>
                            <span style="font-size: 18px; font-weight: 900; color: #047857;">Rs. {{ number_format($annualPrice) }}</span>
                            <span style="font-size: 11px; color: #10B981; font-weight: 800; display: block;">Save 17% (Rs. 1,000 off)</span>
                        </label>
                    </div>
                </div>

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 8px;">Payment Method:</label>
                    <select name="payment_method" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 700; background: #FFF;">
                        <option value="wallet">💰 Deduct from FixMate Wallet Balance (Instant)</option>
                        <option value="jazzcash">📱 JazzCash Mobile Account</option>
                        <option value="easypaisa">📱 EasyPaisa Mobile Account</option>
                        <option value="card">💳 Debit / Credit Card (Visa / Mastercard)</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="document.getElementById('techSubscriptionModal').style.display='none';" style="flex: 1; padding: 12px; border-radius: 10px; border: 1.5px solid #E5E7EB; background: #F9FAFB; font-weight: 700; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" style="flex: 2; padding: 12px; border-radius: 10px; border: none; background: #111827; color: #FDE047; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        Activate Pro VIP Now →
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        
        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Today's Dispatches</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 28px; font-weight: 900; color: #111;">{{ $todayJobsCount }}</strong>
                <span style="font-size: 11px; background: #FFFBEB; color: #B45309; font-weight: 800; padding: 2px 8px; border-radius: 12px;">
                    {{ $activeJob ? '1 Active' : 'Standby' }}
                </span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Today's Payouts</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 26px; font-weight: 900; color: #111;">Rs. {{ number_format($todayEarnings) }}</strong>
                <span style="font-size: 11px; color: #059669; font-weight: 700;">90% Share</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Pending In Escrow</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: 26px; font-weight: 900; color: #B45309;">Rs. {{ number_format($pendingEscrow) }}</strong>
                <span style="font-size: 11px; background: #FEF3C7; color: #92400E; font-weight: 800; padding: 2px 8px; border-radius: 12px;">Held Safe</span>
            </div>
        </div>

        <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 700; color: #6B7280; display: block; margin-bottom: 6px;">Customer Rating</span>
            <div style="display: flex; align-items: baseline; justify-content: space-between;">
                <strong style="font-size: {{ $totalReviews > 0 ? '28px' : '20px' }}; font-weight: 900; color: #111;">
                    {{ $totalReviews > 0 ? $ratingFormatted . ' ★' : 'New Partner' }}
                </strong>
                <span style="font-size: 11px; background: {{ $totalReviews > 0 ? '#ECFDF5' : '#F1F5F9' }}; color: {{ $totalReviews > 0 ? '#047857' : '#64748B' }}; font-weight: 800; padding: 2px 8px; border-radius: 12px;">
                    {{ $totalReviews }} {{ \Illuminate\Support\Str::plural('Review', $totalReviews) }}
                </span>
            </div>
        </div>

    </div>

    <!-- Incoming Urgent Job Request Alert -->
    @if($incomingJob)
        <div class="portal-card" style="padding: 24px 28px; background: #FFFDF0; border: 2px solid #FFCC00; border-radius: 18px; margin-bottom: 28px; box-shadow: 0 8px 24px rgba(255, 204, 0, 0.15);">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="background: #DC2626; color: #FFF; font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">New Request</span>
                    <span style="font-size: 13px; color: #666;">Requested Slot: <strong style="color: #0F172A;">{{ $incomingJob->service_time_slot }}</strong></span>
                </div>
                <span style="font-size: 12px; color: #888;">Order ID: <strong style="color: #111;">#{{ $incomingJob->booking_number }}</strong></span>
            </div>

            <div style="display: grid; grid-template-columns: 80px 1fr auto; gap: 20px; align-items: center;">
                <img src="{{ asset($incomingJob->problem_image ?: 'assets/images/image_6.png') }}" alt="Defect" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
                
                <div>
                    <h3 style="font-size: 18px; font-weight: 900; color: #111; margin: 0 0 4px 0;">{{ $incomingJob->service_title }}</h3>
                    <div style="font-size: 13px; color: #555; margin-bottom: 6px;">
                        Customer: <strong>{{ $incomingJob->user?->name ?? 'Verified Customer' }}</strong> &bull; 📍 {{ $incomingJob->service_address }}, {{ $incomingJob->city }}
                    </div>
                    <div style="display: flex; gap: 14px; font-size: 12px; color: #666; flex-wrap: wrap;">
                        <span>📅 Date: <strong>{{ $incomingJob->service_date->format('M d, Y') }}</strong></span>
                        <span>🛡️ Escrow: <strong>Held</strong></span>
                        <span style="color: #047857; font-weight: 800;">Estimated Payout: <strong>Rs. {{ number_format(round($incomingJob->total_price * 0.90)) }}</strong></span>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <a href="{{ route('video-meeting.initiate', ['booking_id' => $incomingJob->id]) }}" 
                       style="background: #0F172A; color: #FFB800; border: 1.5px solid #FFB800; padding: 10px 16px; font-size: 13px; font-weight: 800; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);" 
                       title="Call customer via live video before dispatch">
                        <span>📹</span> <span>Let's Talk (Video Call)</span>
                    </a>
                    <a href="{{ route('technician.jobs.details', $incomingJob->booking_number) }}" class="btn-outline" style="padding: 10px 18px; font-size: 13px; text-decoration: none;">View Details</a>
                    <form action="{{ route('technician.jobs.accept', $incomingJob->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-yellow" style="padding: 10px 24px; font-size: 13.5px; font-weight: 900; border: none; cursor: pointer;">
                            Accept Job →
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @endif

    <!-- Two Columns: Active Job & Status Ledger -->
    <div style="grid-template-columns: 1.1fr 0.9fr; gap: 24px; display: grid;">
        
        <!-- Left: Today's Active Job State -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0;">Current Active Service</h3>
                @if($activeJob)
                    <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 10px; border-radius: 10px;">
                        {{ $activeJob->status_label }}
                    </span>
                @else
                    <span style="font-size: 11px; background: #F1F5F9; color: #64748B; font-weight: 800; padding: 2px 10px; border-radius: 10px;">
                        No Active Job
                    </span>
                @endif
            </div>

            @if($activeJob)
                <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 18px; margin-bottom: 16px; background: #F8FAFC;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                        <strong style="font-size: 15px; color: #111;">{{ $activeJob->service_title }}</strong>
                        <span style="font-size: 12px; color: #1D4ED8; font-weight: 700;">#{{ $activeJob->booking_number }}</span>
                    </div>
                    <p style="font-size: 13px; color: #666; margin-bottom: 12px;">
                        Customer: <strong>{{ $activeJob->user?->name }}</strong> &bull; {{ $activeJob->service_address }}, {{ $activeJob->city }}
                    </p>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 12px; flex-wrap: wrap; gap: 10px;">
                        <span style="font-size: 12px; color: #888;">
                            {{ $activeJob->status === 'in_progress' ? 'Service In Progress' : 'Handshake OTP Required upon arrival' }}
                        </span>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <a href="{{ route('video-meeting.initiate', ['booking_id' => $activeJob->id]) }}" 
                               style="background: #0F172A; color: #FFB800; border: 1.5px solid #FFB800; padding: 7px 14px; font-size: 12px; font-weight: 800; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);"
                               title="Start live video call with customer">
                                <span>📹</span> <span>Let's Talk</span>
                            </a>
                            <a href="{{ route('technician.active-job') }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px; text-decoration: none;">
                                Open Active Job Screen →
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div style="padding: 30px; text-align: center; color: #888;">
                    <p style="margin: 0 0 10px 0; font-size: 13.5px;">You have no active ongoing jobs right now.</p>
                    <a href="{{ route('technician.jobs') }}" class="btn-outline" style="padding: 8px 18px; font-size: 12.5px; text-decoration: none;">
                        Browse Job Requests Directory
                    </a>
                </div>
            @endif

            <div style="text-align: right;">
                <a href="{{ route('technician.schedule') }}" style="font-size: 13px; color: #111; font-weight: 700; text-decoration: none;">View Full Day Schedule →</a>
            </div>
        </div>

        <!-- Right: Payouts & Verification Status Card -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- KYC Badge Card -->
            <div class="portal-card" style="padding: 20px; background: #FFFFFF; display: flex; align-items: center; justify-content: space-between;">
                @if(! $user->is_active || $pro->verification_status === 'rejected')
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #FFF1F2; border: 1px solid #FECDD3; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            🚫
                        </div>
                        <div>
                            <strong style="font-size: 14px; color: #9F1239; display: block;">
                                Profile Blocked
                            </strong>
                            <span style="font-size: 11.5px; color: #BE123C; font-weight: 700;">
                                Account restricted &bull; Contact team
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}" class="btn-outline" style="padding: 5px 12px; font-size: 11.5px; text-decoration: none; border-color: #FECDD3; color: #BE123C;">Contact</a>
                @elseif($pro->verification_status === 'returned')
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #FFF7ED; border: 1px solid #FED7AA; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            ⚠️
                        </div>
                        <div>
                            <strong style="font-size: 14px; color: #9A3412; display: block;">
                                Revision Required
                            </strong>
                            <span style="font-size: 11.5px; color: #C2410C; font-weight: 700;">
                                Returned by admin &bull; Fix documents
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('technician.verification') }}" class="btn-outline" style="padding: 5px 12px; font-size: 11.5px; text-decoration: none; border-color: #FED7AA; color: #C2410C;">Fix Now</a>
                @else
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: {{ $user->is_verified ? '#ECFDF5' : '#FFFBEB' }}; border: 1px solid {{ $user->is_verified ? '#A7F3D0' : '#FDE68A' }}; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            🛡️
                        </div>
                        <div>
                            <strong style="font-size: 14px; color: #111; display: block;">
                                {{ $user->is_verified ? 'Verified Pro Badge Active' : 'KYC Verification In Progress' }}
                            </strong>
                            <span style="font-size: 11.5px; color: {{ $user->is_verified ? '#047857' : '#B45309' }}; font-weight: 700;">
                                {{ $user->is_verified ? 'Identity & Trade Credential Cleared' : 'CNIC & Certificate under review' }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('technician.verification') }}" class="btn-outline" style="padding: 5px 12px; font-size: 11.5px; text-decoration: none;">Manage</a>
                @endif
            </div>

            <!-- Earnings Ticker Card -->
            <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px;">
                    <span style="font-size: 13px; color: #666;">Available in Partner Wallet</span>
                    <strong style="font-size: 22px; color: #047857;">Rs. {{ number_format($todayEarnings + $pendingEscrow) }}</strong>
                </div>
                <a href="{{ route('technician.earnings') }}" class="btn-yellow" style="display: block; text-align: center; padding: 10px 0; font-size: 13.5px; font-weight: 800; text-decoration: none;">
                    View Earnings Ledger &amp; Withdrawals
                </a>
            </div>

            <!-- Technician Profile & Description Card -->
            <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 16px;">📝</span>
                        <strong style="font-size: 14px; color: #111;">Technician Description</strong>
                    </div>
                    <a href="{{ route('technician.profile') }}" style="font-size: 11.5px; color: #B45309; font-weight: 800; text-decoration: underline;">Edit Bio</a>
                </div>
                @php
                    $techDesc = $user->description ?: ($pro->description ?: '');
                @endphp
                @if($techDesc)
                    <p style="font-size: 13px; color: #475569; margin: 0 0 10px 0; line-height: 1.5; font-style: italic; background: #F8FAFC; padding: 10px 12px; border-radius: 8px; border: 1px solid #E2E8F0;">
                        "{{ \Illuminate\Support\Str::limit($techDesc, 180) }}"
                    </p>
                @else
                    <div style="background: #FFFDF0; border: 1px dashed #FDE68A; padding: 12px; border-radius: 8px; margin-bottom: 10px;">
                        <span style="font-size: 12px; color: #92400E; display: block; line-height: 1.4;">
                            No technician description added yet. Add a short bio to introduce your trade skills and attract customer bookings!
                        </span>
                    </div>
                @endif
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11.5px; color: #64748B;">
                    <span>Specialty: <strong>{{ $pro->profession?->name ?? 'General Specialist' }}</strong></span>
                    <a href="{{ route('technician.profile') }}" class="btn-outline" style="padding: 4px 10px; font-size: 11px; text-decoration: none;">Update Profile</a>
                </div>
            </div>

        </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.hash === '#techSubscription' || window.location.hash === '#techSubscriptionModal') {
            const modal = document.getElementById('techSubscriptionModal');
            if (modal) {
                modal.style.display = 'flex';
                modal.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
</script>
@endsection
