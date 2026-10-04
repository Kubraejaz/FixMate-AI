@extends('Frontend.layouts.technician')

@section('title', 'Earnings & Payouts Ledger — FixMate AI Partner Portal')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <!-- Title -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Earnings & Escrow Ledger</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">Track your completed job earnings, escrow settlements, and partner payouts.</p>
        </div>
        <button type="button" class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer;" onclick="alert('Withdrawal request initiated. Payouts are transferred automatically to your registered bank account or JazzCash within 2 hours.');">
            Withdraw Funds
        </button>
    </div>

    <!-- 3 Metrics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
        
        <!-- Total Earnings -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-left: 4px solid #111;">
            <span style="font-size: 12px; color: #777; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 6px;">Total Lifetime Earnings</span>
            <strong style="font-size: 30px; font-weight: 900; color: #111; display: block; margin-bottom: 4px;">
                Rs. {{ number_format($lifetimeEarnings) }}
            </strong>
            <span style="font-size: 11.5px; color: #059669; font-weight: 700;">Across {{ $completedBookings->count() }} completed jobs</span>
        </div>

        <!-- Available in Wallet -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-left: 4px solid #10B981;">
            <span style="font-size: 12px; color: #777; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 6px;">Available for Withdrawal</span>
            <strong style="font-size: 30px; font-weight: 900; color: #047857; display: block; margin-bottom: 4px;">
                Rs. {{ number_format($availableWithdrawal) }}
            </strong>
            <span style="font-size: 11.5px; color: #666;">Ready for instant transfer</span>
        </div>

        <!-- Pending Escrow -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-left: 4px solid #FFCC00;">
            <span style="font-size: 12px; color: #777; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 6px;">Pending Escrow Payouts</span>
            <strong style="font-size: 30px; font-weight: 900; color: #B45309; display: block; margin-bottom: 4px;">
                Rs. {{ number_format($pendingEscrow) }}
            </strong>
            <span style="font-size: 11.5px; color: #777;">Releases upon job OTP completion</span>
        </div>

    </div>

    <!-- Payout Destination -->
    <div class="portal-card" style="padding: 20px 24px; background: #FFFFFF; display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #FEF2F2; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                🏦
            </div>
            <div>
                <strong style="font-size: 14.5px; color: #111; display: block;">Habib Bank Limited (HBL) / JazzCash</strong>
                <span style="font-size: 12px; color: #666;">Account Title: <strong>{{ $pro->name }}</strong> &bull; Verified Payout Profile</span>
            </div>
        </div>
        <a href="{{ route('technician.profile') }}" class="btn-outline" style="padding: 7px 16px; font-size: 12.5px; text-decoration: none;">Edit Payout Details</a>
    </div>

    <!-- Recent Transactions Ledger -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
        <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 18px;">Recent Earnings & Payout Ledger</h3>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            @forelse($completedBookings as $bk)
                @php
                    $payout = (int) round($bk->total_price * 0.90);
                @endphp
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <strong style="font-size: 14.5px; color: #111; display: block;">
                            {{ $bk->service_title }} (#{{ $bk->booking_number }})
                        </strong>
                        <span style="font-size: 12px; color: #666;">
                            Customer: {{ $bk->user?->name ?? 'Customer' }} &bull; Completed: {{ $bk->completed_at ? $bk->completed_at->format('M d, Y &bull; h:i A') : $bk->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <div style="text-align: right;">
                        <strong style="font-size: 15px; color: #047857; display: block;">+ Rs. {{ number_format($payout) }}</strong>
                        <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 7px; border-radius: 8px;">Completed & Released</span>
                    </div>
                </div>
            @empty
                <div style="padding: 28px; text-align: center; color: #888;">
                    <p style="margin: 0; font-size: 13.5px;">No completed payouts yet. Once you complete a service and verify the customer OTP, earnings will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
