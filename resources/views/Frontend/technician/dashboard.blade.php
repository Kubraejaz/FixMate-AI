@extends('Frontend.layouts.technician')

@section('title', 'Technician Dashboard — FixMate AI Partner Portal')

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
            <span style="background: #ECFDF5; color: #047857; font-weight: 800; font-size: 12px; padding: 4px 12px; border-radius: 20px; border: 1px solid #A7F3D0;">
                ● Online & Receiving Requests
            </span>
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

                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('technician.jobs.details', $incomingJob->booking_number) }}" class="btn-outline" style="padding: 10px 18px; font-size: 13px; text-decoration: none;">View Details</a>
                    <form action="{{ route('technician.jobs.accept', $incomingJob->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-yellow" style="padding: 10px 24px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer;">
                            Accept Job →
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @endif

    <!-- Two Columns: Active Job & Status Ledger -->
    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px;">
        
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

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 12px;">
                        <span style="font-size: 12px; color: #888;">
                            {{ $activeJob->status === 'in_progress' ? 'Service In Progress' : 'Handshake OTP Required upon arrival' }}
                        </span>
                        <a href="{{ route('technician.active-job') }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px; text-decoration: none;">
                            Open Active Job Screen →
                        </a>
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
            </div>

            <!-- Earnings Ticker Card -->
            <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px;">
                    <span style="font-size: 13px; color: #666;">Available in Partner Wallet</span>
                    <strong style="font-size: 22px; color: #047857;">Rs. {{ number_format($todayEarnings + $pendingEscrow) }}</strong>
                </div>
                <a href="{{ route('technician.earnings') }}" class="btn-yellow" style="display: block; text-align: center; padding: 10px 0; font-size: 13.5px; font-weight: 800; text-decoration: none;">
                    View Earnings Ledger & Withdrawals
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
