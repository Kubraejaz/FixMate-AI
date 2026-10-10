@extends('Frontend.layouts.technician')

@section('title', 'Earnings & Payouts Ledger — FixMate Partner Portal')

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

    <!-- FixMate Pro VIP Technician Subscription Banner & Status Card -->
    @php
        $isPro = $pro->hasActiveProSubscription();
        $monthlyPrice = (int) cache('subscription_monthly_price', 500);
        $annualPrice = (int) cache('subscription_annual_price', 4999);
    @endphp

    <div id="techSubscriptionBanner" style="background: {{ $isPro ? 'linear-gradient(135deg, #0F172A 0%, #1E293B 100%)' : 'linear-gradient(135deg, #18181B 0%, #27272A 100%)' }}; border: 2px solid {{ $isPro ? '#F59E0B' : '#EAB308' }}; border-radius: 18px; padding: 22px 26px; margin-bottom: 28px; color: #FFFFFF; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
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
