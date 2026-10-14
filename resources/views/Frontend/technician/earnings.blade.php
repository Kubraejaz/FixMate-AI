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
            <button type="button" onclick="document.getElementById('techSubscriptionModal').style.display='flex';" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: #000000; font-weight: 900; font-size: 13.5px; padding: 12px 20px; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);">
                <span>👑</span>
                <span>{{ $isPro ? 'Extend VIP Plan' : 'Upgrade to Pro VIP →' }}</span>
            </button>
            <a href="{{ route('technician.subscription.checkout') }}" style="background: rgba(255,255,255,0.1); color: #FDE047; font-weight: 800; font-size: 13px; padding: 11px 18px; border-radius: 10px; border: 1.5px solid #F59E0B; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>💳</span> Secure Checkout &rarr;
            </a>
        </div>
    </div>

    <!-- Technician Subscription Modal -->
    <div id="techSubscriptionModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(5px); z-index: 99999; align-items: center; justify-content: center; padding: 16px;">
        <div style="background: #FFFFFF; border-radius: 20px; max-width: 540px; width: 100%; padding: 26px 28px; box-shadow: 0 20px 45px rgba(0,0,0,0.35); position: relative; max-height: 92vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 26px;">👑</span>
                    <div>
                        <h3 style="font-size: 19px; font-weight: 900; color: #111; margin: 0;">Upgrade to FixMate Pro VIP</h3>
                        <span style="font-size: 12px; color: #059669; font-weight: 800;">Keep 100% of all customer payouts (0% Commission)</span>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('techSubscriptionModal').style.display='none';" style="background: #F3F4F6; border: none; font-size: 18px; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;">✕</button>
            </div>

            <div style="background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 12px; padding: 12px 14px; margin-bottom: 16px;">
                <div style="font-size: 12.5px; font-weight: 800; color: #92400E; margin-bottom: 4px;">VIP Partner Perks Included:</div>
                <ul style="font-size: 12px; color: #78350F; margin: 0; padding-left: 18px; line-height: 1.5;">
                    <li><strong>0% Platform Commission:</strong> Keep 100% of earnings!</li>
                    <li><strong>#1 Search Placement:</strong> Appear first in technician search.</li>
                    <li><strong>Verified Gold Pro Badge:</strong> 3x higher booking requests.</li>
                </ul>
            </div>

            <form action="{{ route('technician.subscription.upgrade') }}" method="POST" id="modalSubscriptionForm">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 6px;">Select VIP Plan:</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <label id="modalPlanMonthlyLabel" style="border: 2px solid #F59E0B; border-radius: 12px; padding: 12px; cursor: pointer; background: #FFFDF5; display: block;">
                            <input type="radio" name="plan_name" value="pro_monthly" checked onchange="onModalPlanChange('pro_monthly', {{ $monthlyPrice }})" style="margin-right: 4px; accent-color: #F59E0B;">
                            <strong style="font-size: 13.5px; color: #111;">Monthly Pass</strong>
                            <div style="font-size: 17px; font-weight: 900; color: #D97706; margin-top: 2px;">Rs. {{ number_format($monthlyPrice) }}</div>
                            <span style="font-size: 10.5px; color: #6B7280; display: block;">Billed monthly</span>
                        </label>
                        <label id="modalPlanAnnualLabel" style="border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 12px; cursor: pointer; background: #FFFFFF; display: block;">
                            <input type="radio" name="plan_name" value="pro_annual" onchange="onModalPlanChange('pro_annual', {{ $annualPrice }})" style="margin-right: 4px; accent-color: #F59E0B;">
                            <strong style="font-size: 13.5px; color: #111;">Annual Pass</strong>
                            <div style="font-size: 17px; font-weight: 900; color: #047857; margin-top: 2px;">Rs. {{ number_format($annualPrice) }}</div>
                            <span style="font-size: 10.5px; color: #10B981; font-weight: 800; display: block;">Save 17%</span>
                        </label>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 6px;">Payment Method:</label>
                    <select name="payment_method" id="modalPaymentMethod" onchange="onModalPaymentMethodChange(this.value)" style="width: 100%; padding: 10px 12px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700; background: #FFF;">
                        <option value="wallet">💰 Deduct from FixMate Wallet (Available: Rs. {{ number_format($availableWallet) }})</option>
                        <option value="jazzcash">📱 JazzCash Mobile Account</option>
                        <option value="easypaisa">📱 EasyPaisa Mobile Account</option>
                        <option value="card">💳 Debit / Credit Card (Visa / Mastercard)</option>
                    </select>
                </div>

                <!-- Modal Payment Inputs -->
                <!-- 1. Wallet Balance Info -->
                <div id="modalBoxWallet" style="display: block; background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; margin-bottom: 4px;">
                        <span style="color: #64748B;">Wallet Balance:</span>
                        <strong style="color: #0F172A;">Rs. {{ number_format($availableWallet) }}</strong>
                    </div>
                    @if($availableWallet >= $monthlyPrice)
                        <span style="font-size: 11.5px; color: #059669; font-weight: 700;">✓ Sufficient funds available. Will be deducted immediately.</span>
                    @else
                        <span style="font-size: 11.5px; color: #DC2626; font-weight: 700;">⚠️ Insufficient balance for this plan. Select JazzCash, EasyPaisa, or Card.</span>
                    @endif
                </div>

                <!-- 2. JazzCash Input -->
                <div id="modalBoxJazzcash" style="display: none; background: #FFFDF0; border: 1.5px solid #FDE68A; border-radius: 10px; padding: 14px; margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #78350F; margin-bottom: 4px;">
                        JazzCash Mobile Number <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="text" name="jazzcash_mobile" id="modal_jazzcash_mobile" placeholder="03001234567" value="{{ auth()->user()->phone ?? '' }}" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700; margin-bottom: 8px;">
                    
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #78350F; margin-bottom: 4px;">
                        JazzCash MPIN / OTP
                    </label>
                    <input type="password" name="jazzcash_mpin" maxlength="6" placeholder="Enter 4-digit MPIN" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; letter-spacing: 2px;">
                </div>

                <!-- 3. EasyPaisa Input -->
                <div id="modalBoxEasypaisa" style="display: none; background: #F0FDF4; border: 1.5px solid #BBF7D0; border-radius: 10px; padding: 14px; margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #166534; margin-bottom: 4px;">
                        EasyPaisa Mobile Number <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="text" name="easypaisa_mobile" id="modal_easypaisa_mobile" placeholder="03451234567" value="{{ auth()->user()->phone ?? '' }}" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; font-weight: 700; margin-bottom: 8px;">
                    
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #166534; margin-bottom: 4px;">
                        EasyPaisa MPIN / OTP
                    </label>
                    <input type="password" name="easypaisa_mpin" maxlength="6" placeholder="Enter 5-digit PIN" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13.5px; letter-spacing: 2px;">
                </div>

                <!-- 4. Card Input -->
                <div id="modalBoxCard" style="display: none; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 14px; margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #374151; margin-bottom: 4px;">Name on Card <span style="color: #DC2626;">*</span></label>
                    <input type="text" name="card_name" placeholder="Cardholder Name" value="{{ $pro->name }}" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">

                    <label style="display: block; font-size: 12px; font-weight: 800; color: #374151; margin-bottom: 4px;">Card Number <span style="color: #DC2626;">*</span></label>
                    <input type="text" name="card_number" id="modal_card_number" maxlength="19" placeholder="4242 •••• •••• 4242" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13px; font-weight: 800; letter-spacing: 1px; margin-bottom: 8px;">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <div>
                            <label style="display: block; font-size: 11.5px; font-weight: 800; color: #374151; margin-bottom: 4px;">Expiry (MM/YY) <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="card_expiry" maxlength="5" placeholder="12/28" style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13px; font-weight: 700;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11.5px; font-weight: 800; color: #374151; margin-bottom: 4px;">CVC <span style="color: #DC2626;">*</span></label>
                            <input type="password" name="card_cvc" maxlength="4" placeholder="•••" style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1.5px solid #D1D5DB; font-size: 13px; font-weight: 700;">
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; font-size: 12px;">
                    <a href="{{ route('technician.subscription.checkout') }}" style="color: #D97706; font-weight: 800; text-decoration: underline;">
                        Prefer dedicated full-screen checkout? Click here &rarr;
                    </a>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="document.getElementById('techSubscriptionModal').style.display='none';" style="flex: 1; padding: 11px; border-radius: 10px; border: 1.5px solid #E5E7EB; background: #F9FAFB; font-weight: 700; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" id="btnModalPaySubmit" style="flex: 2; padding: 11px; border-radius: 10px; border: none; background: #111827; color: #FDE047; font-weight: 900; font-size: 13.5px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        Pay Rs. <span id="lblModalBtnPrice">{{ number_format($monthlyPrice) }}</span> &amp; Activate &rarr;
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

    <!-- VIP Subscription Invoices & Payment Ledger -->
    @if(isset($subscriptionsHistory) && $subscriptionsHistory->isNotEmpty())
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; margin-top: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 16.5px; font-weight: 800; color: #111; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <span>👑</span> FixMate Pro VIP Invoices &amp; Payments
                </h3>
                <span style="font-size: 11.5px; color: #64748B;">{{ $subscriptionsHistory->count() }} Subscriptions</span>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="border-bottom: 2px solid #F1F5F9; text-align: left; color: #64748B; font-size: 11.5px; text-transform: uppercase;">
                            <th style="padding: 10px 12px;">Reference #</th>
                            <th style="padding: 10px 12px;">Plan</th>
                            <th style="padding: 10px 12px;">Method</th>
                            <th style="padding: 10px 12px;">Amount</th>
                            <th style="padding: 10px 12px;">Valid Until</th>
                            <th style="padding: 10px 12px; text-align: right;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptionsHistory as $sub)
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 12px; font-weight: 800; color: #0F172A;">
                                    {{ $sub->transaction_reference }}
                                </td>
                                <td style="padding: 12px; text-transform: capitalize;">
                                    {{ str_replace('_', ' ', $sub->plan_name) }}
                                </td>
                                <td style="padding: 12px; text-transform: capitalize;">
                                    <span style="background: #F1F5F9; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 11.5px;">
                                        {{ $sub->payment_method }}
                                    </span>
                                </td>
                                <td style="padding: 12px; font-weight: 800; color: #047857;">
                                    Rs. {{ number_format($sub->price) }}
                                </td>
                                <td style="padding: 12px; color: #64748B;">
                                    {{ $sub->expires_at ? $sub->expires_at->format('M d, Y') : 'Active' }}
                                </td>
                                <td style="padding: 12px; text-align: right;">
                                    @if($sub->status === 'active')
                                        <span style="background: #ECFDF5; color: #065F46; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px;">
                                            ● Active
                                        </span>
                                    @else
                                        <span style="background: #F1F5F9; color: #64748B; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 12px;">
                                            {{ ucfirst($sub->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<script>
    let modalPrice = {{ $monthlyPrice }};
    const modalAvailableWallet = {{ $availableWallet }};

    function onModalPlanChange(plan, price) {
        modalPrice = price;
        const formatted = new Intl.NumberFormat().format(price);
        const lbl = document.getElementById('lblModalBtnPrice');
        if (lbl) lbl.textContent = formatted;

        const monthlyLbl = document.getElementById('modalPlanMonthlyLabel');
        const annualLbl = document.getElementById('modalPlanAnnualLabel');

        if (plan === 'pro_monthly') {
            if (monthlyLbl) {
                monthlyLbl.style.borderColor = '#F59E0B';
                monthlyLbl.style.background = '#FFFDF5';
            }
            if (annualLbl) {
                annualLbl.style.borderColor = '#E5E7EB';
                annualLbl.style.background = '#FFFFFF';
            }
        } else {
            if (annualLbl) {
                annualLbl.style.borderColor = '#F59E0B';
                annualLbl.style.background = '#FFFDF5';
            }
            if (monthlyLbl) {
                monthlyLbl.style.borderColor = '#E5E7EB';
                monthlyLbl.style.background = '#FFFFFF';
            }
        }
    }

    function onModalPaymentMethodChange(method) {
        const boxes = ['wallet', 'jazzcash', 'easypaisa', 'card'];
        boxes.forEach(b => {
            const el = document.getElementById('modalBox' + b.charAt(0).toUpperCase() + b.slice(1));
            if (el) el.style.display = (b === method) ? 'block' : 'none';
        });
    }

    // Modal Card formatting
    const modalCardInput = document.getElementById('modal_card_number');
    if (modalCardInput) {
        modalCardInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '').substring(0, 16);
            let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
            e.target.value = formatted;
        });
    }

    // Modal Pre-submission validation
    const modalForm = document.getElementById('modalSubscriptionForm');
    if (modalForm) {
        modalForm.addEventListener('submit', function (e) {
            const method = document.getElementById('modalPaymentMethod').value;
            if (method === 'wallet' && modalAvailableWallet < modalPrice) {
                e.preventDefault();
                alert('⚠️ Insufficient Wallet Balance! Your wallet has Rs. ' + new Intl.NumberFormat().format(modalAvailableWallet) + ', but this plan costs Rs. ' + new Intl.NumberFormat().format(modalPrice) + '.\n\nPlease select JazzCash, EasyPaisa, or Debit/Credit Card.');
                return false;
            }
            if (method === 'jazzcash') {
                const jc = document.getElementById('modal_jazzcash_mobile').value.trim();
                if (!jc || jc.length < 10) {
                    e.preventDefault();
                    alert('Please enter your 11-digit JazzCash mobile number (e.g. 03001234567).');
                    document.getElementById('modal_jazzcash_mobile').focus();
                    return false;
                }
            }
            if (method === 'easypaisa') {
                const ep = document.getElementById('modal_easypaisa_mobile').value.trim();
                if (!ep || ep.length < 10) {
                    e.preventDefault();
                    alert('Please enter your 11-digit EasyPaisa mobile number (e.g. 03451234567).');
                    document.getElementById('modal_easypaisa_mobile').focus();
                    return false;
                }
            }
            if (method === 'card') {
                const card = document.getElementById('modal_card_number').value.replace(/\s/g, '');
                if (!card || card.length < 12) {
                    e.preventDefault();
                    alert('Please enter a valid 16-digit debit or credit card number.');
                    document.getElementById('modal_card_number').focus();
                    return false;
                }
            }
        });
    }

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
