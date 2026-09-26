@extends('Frontend.layouts.technician')

@section('title', 'Earnings & Payouts Ledger — FixMate AI Partner')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <!-- Title matching Mockup 2 & 3 -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Earnings & Escrow Ledger</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">Track your completed job earnings, escrow settlements, and withdraw directly to JazzCash or Bank.</p>
        </div>
        <button class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; font-weight: 800;">
            Withdraw Funds
        </button>
    </div>

    <!-- 3 Metrics Cards matching Mockup 2 & 3 -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 28px;">
        
        <!-- Total Earnings -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-left: 4px solid #111;">
            <span style="font-size: 12px; color: #777; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 6px;">Total Lifetime Earnings</span>
            <strong style="font-size: 30px; font-weight: 900; color: #111; display: block; margin-bottom: 4px;">Rs. 48,750</strong>
            <span style="font-size: 11.5px; color: #059669; font-weight: 700;">Across 48 completed jobs</span>
        </div>

        <!-- Available in Wallet -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-left: 4px solid #10B981;">
            <span style="font-size: 12px; color: #777; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 6px;">Available for Withdrawal</span>
            <strong style="font-size: 30px; font-weight: 900; color: #047857; display: block; margin-bottom: 4px;">Rs. 12,490</strong>
            <span style="font-size: 11.5px; color: #666;">Ready for instant transfer</span>
        </div>

        <!-- Pending Escrow -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-left: 4px solid #FFCC00;">
            <span style="font-size: 12px; color: #777; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 6px;">Pending Escrow Payouts</span>
            <strong style="font-size: 30px; font-weight: 900; color: #B45309; display: block; margin-bottom: 4px;">Rs. 3,100</strong>
            <span style="font-size: 11.5px; color: #777;">Releases upon job OTP</span>
        </div>

    </div>

    <!-- Payout Destination -->
    <div class="portal-card" style="padding: 20px 24px; background: #FFFFFF; display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #FEF2F2; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                🏦
            </div>
            <div>
                <strong style="font-size: 14.5px; color: #111; display: block;">Habib Bank Limited (HBL)</strong>
                <span style="font-size: 12px; color: #666;">Account: **** **** **** 4912 • Title: Ali Khan</span>
            </div>
        </div>
        <button class="btn-outline" style="padding: 7px 16px; font-size: 12.5px;">Edit Bank Details</button>
    </div>

    <!-- Recent Transactions Ledger matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
        <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 18px;">Recent Earnings & Payout Ledger</h3>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            
            <!-- Tx 1 -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
                <div>
                    <strong style="font-size: 14.5px; color: #111; display: block;">Kitchen Sink P-trap Repair (#FM-10245)</strong>
                    <span style="font-size: 12px; color: #666;">Customer: Ahmed Khan • Sep 27, 2026 • 2:30 PM</span>
                </div>
                <div style="text-align: right;">
                    <strong style="font-size: 15px; color: #047857; display: block;">+ Rs. 800</strong>
                    <span style="font-size: 11px; background: #FEF3C7; color: #92400E; font-weight: 800; padding: 2px 7px; border-radius: 8px;">Pending Escrow</span>
                </div>
            </div>

            <!-- Tx 2 -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
                <div>
                    <strong style="font-size: 14.5px; color: #111; display: block;">Bathroom Sanitary & Mixer Tap Replacement</strong>
                    <span style="font-size: 12px; color: #666;">Customer: Sara Ahmed • Sep 25, 2026</span>
                </div>
                <div style="text-align: right;">
                    <strong style="font-size: 15px; color: #047857; display: block;">+ Rs. 2,100</strong>
                    <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 7px; border-radius: 8px;">Completed</span>
                </div>
            </div>

            <!-- Tx 3 -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
                <div>
                    <strong style="font-size: 14.5px; color: #111; display: block;">Withdrawal to HBL Bank (Payout Batch #PO-881)</strong>
                    <span style="font-size: 12px; color: #666;">Transfer to HBL ****4912 • Sep 20, 2026</span>
                </div>
                <div style="text-align: right;">
                    <strong style="font-size: 15px; color: #DC2626; display: block;">- Rs. 15,000</strong>
                    <span style="font-size: 11px; background: #EFF6FF; color: #1D4ED8; font-weight: 800; padding: 2px 7px; border-radius: 8px;">Transferred</span>
                </div>
            </div>

            <!-- Tx 4 -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="font-size: 14.5px; color: #111; display: block;">Water Tank Valve & Motor Seal Fix</strong>
                    <span style="font-size: 12px; color: #666;">Customer: Tariq J. • Sep 18, 2026</span>
                </div>
                <div style="text-align: right;">
                    <strong style="font-size: 15px; color: #047857; display: block;">+ Rs. 1,500</strong>
                    <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 7px; border-radius: 8px;">Completed</span>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
