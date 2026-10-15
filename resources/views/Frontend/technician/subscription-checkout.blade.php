@extends('Frontend.layouts.technician')

@section('title', 'FixMate Pro VIP Checkout — Secure Payment')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('technician.dashboard') }}" style="color: #64748B; text-decoration: none; font-size: 13.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
            <span>&larr;</span> <span>Back to Dashboard</span>
        </a>
    </div>

    <!-- Header Banner -->
    <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: 2px solid #F59E0B; border-radius: 20px; padding: 26px 30px; margin-bottom: 28px; color: #FFFFFF; box-shadow: 0 12px 30px rgba(0,0,0,0.18); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 18px;">
            <div style="width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, #F59E0B, #D97706); display: flex; align-items: center; justify-content: center; font-size: 30px; box-shadow: 0 4px 16px rgba(245, 158, 11, 0.4); flex-shrink: 0;">
                👑
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <h1 style="font-size: 22px; font-weight: 900; color: #FDE047; margin: 0;">
                        FixMate Pro VIP Partner Checkout
                    </h1>
                    <span style="background: #10B981; color: #FFFFFF; font-size: 11px; font-weight: 900; padding: 2px 10px; border-radius: 20px; text-transform: uppercase;">
                        0% Commission
                    </span>
                </div>
                <p style="font-size: 14px; color: #E2E8F0; margin: 0; line-height: 1.5;">
                    Complete secure payment to activate <strong>0% platform commission</strong>, keep 100% of your customer payouts, and get priority dispatches.
                </p>
            </div>
        </div>
        <div style="text-align: right;">
            <span style="font-size: 12px; color: #94A3B8; display: block;">Escrow Wallet Balance</span>
            <strong style="font-size: 20px; color: #10B981; font-weight: 900;">Rs. {{ number_format($availableWallet) }}</strong>
        </div>
    </div>

    @if(session('error'))
        <div style="background: #FEF2F2; border: 2px solid #EF4444; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 22px;">⚠️</span>
            <div style="color: #991B1B; font-size: 14px; font-weight: 700;">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div style="background: #FEF2F2; border: 2px solid #EF4444; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px;">
            <strong style="color: #991B1B; font-size: 14px; display: block; margin-bottom: 6px;">Please correct the payment errors below:</strong>
            <ul style="color: #B91C1C; font-size: 13px; margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('technician.subscription.upgrade') }}" method="POST" id="checkoutSubscriptionForm">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start;">
            
            <!-- Left Column: Plan & Payment Methods -->
            <div>
                <!-- 1. Select Plan -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-radius: 16px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <span>1.</span> Select Your Pro VIP Tier
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <!-- Monthly -->
                        <label id="labelPlanMonthly" style="border: 2px solid {{ $plan === 'pro_monthly' ? '#F59E0B' : '#E2E8F0' }}; background: {{ $plan === 'pro_monthly' ? '#FFFDF5' : '#FFFFFF' }}; border-radius: 14px; padding: 16px; cursor: pointer; display: block; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                                <input type="radio" name="plan_name" value="pro_monthly" {{ $plan === 'pro_monthly' ? 'checked' : '' }} onchange="updatePlanSelection('pro_monthly', {{ $monthlyPrice }})" style="accent-color: #F59E0B; transform: scale(1.2); margin-top: 4px;">
                                <span style="background: #FEF3C7; color: #92400E; font-size: 10px; font-weight: 900; padding: 2px 8px; border-radius: 8px; text-transform: uppercase;">Flexible</span>
                            </div>
                            <strong style="font-size: 15px; color: #111; display: block; margin-top: 8px;">Monthly VIP Pass</strong>
                            <div style="font-size: 22px; font-weight: 900; color: #D97706; margin-top: 2px;">
                                Rs. {{ number_format($monthlyPrice) }}
                            </div>
                            <span style="font-size: 11.5px; color: #64748B; display: block; margin-top: 4px;">Valid for 30 full days</span>
                        </label>

                        <!-- Annual -->
                        <label id="labelPlanAnnual" style="border: 2px solid {{ $plan === 'pro_annual' ? '#F59E0B' : '#E2E8F0' }}; background: {{ $plan === 'pro_annual' ? '#FFFDF5' : '#FFFFFF' }}; border-radius: 14px; padding: 16px; cursor: pointer; display: block; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                                <input type="radio" name="plan_name" value="pro_annual" {{ $plan === 'pro_annual' ? 'checked' : '' }} onchange="updatePlanSelection('pro_annual', {{ $annualPrice }})" style="accent-color: #F59E0B; transform: scale(1.2); margin-top: 4px;">
                                <span style="background: #ECFDF5; color: #047857; font-size: 10px; font-weight: 900; padding: 2px 8px; border-radius: 8px; text-transform: uppercase;">Save 17%</span>
                            </div>
                            <strong style="font-size: 15px; color: #111; display: block; margin-top: 8px;">Annual VIP Pass</strong>
                            <div style="font-size: 22px; font-weight: 900; color: #047857; margin-top: 2px;">
                                Rs. {{ number_format($annualPrice) }}
                            </div>
                            <span style="font-size: 11.5px; color: #059669; font-weight: 800; display: block; margin-top: 4px;">Save Rs. 1,001 yearly</span>
                        </label>
                    </div>
                </div>

                <!-- 2. Payment Method -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-radius: 16px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <span>2.</span> Choose Secure Payment Gateway
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
                        
                        <!-- FixMate Wallet -->
                        <label id="optWallet" style="border: 2px solid {{ old('payment_method') === 'wallet' || !old('payment_method') ? '#F59E0B' : '#E2E8F0' }}; background: {{ old('payment_method') === 'wallet' || !old('payment_method') ? '#FFFDF5' : '#FFFFFF' }}; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="wallet" {{ old('payment_method') === 'wallet' || !old('payment_method') ? 'checked' : '' }} onchange="switchPaymentMethod('wallet')" style="accent-color: #F59E0B; transform: scale(1.3);">
                                <div>
                                    <strong style="display: block; font-size: 14px; color: #0F172A;">💰 Deduct from FixMate Wallet Balance</strong>
                                    <span style="font-size: 12px; color: #64748B;">
                                        Available: <strong>Rs. {{ number_format($availableWallet) }}</strong>
                                        @if($availableWallet >= $price)
                                            <span style="color: #059669; font-weight: 800; margin-left: 6px;">✓ Sufficient Balance</span>
                                        @else
                                            <span style="color: #DC2626; font-weight: 800; margin-left: 6px;">⚠️ Insufficient Balance</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <span style="font-size: 11px; background: #FEF3C7; color: #92400E; font-weight: 900; padding: 3px 8px; border-radius: 6px;">Instant</span>
                        </label>

                        <!-- JazzCash -->
                        <label id="optJazzcash" style="border: 2px solid {{ old('payment_method') === 'jazzcash' ? '#F59E0B' : '#E2E8F0' }}; background: {{ old('payment_method') === 'jazzcash' ? '#FFFDF5' : '#FFFFFF' }}; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="jazzcash" {{ old('payment_method') === 'jazzcash' ? 'checked' : '' }} onchange="switchPaymentMethod('jazzcash')" style="accent-color: #F59E0B; transform: scale(1.3);">
                                <div>
                                    <strong style="display: block; font-size: 14px; color: #0F172A;">📱 JazzCash Mobile Account</strong>
                                    <span style="font-size: 12px; color: #64748B;">Direct debit via JazzCash OTP / MPIN prompt</span>
                                </div>
                            </div>
                            <span style="background: #E11D48; color: #FFF; font-weight: 900; font-size: 11px; padding: 3px 9px; border-radius: 6px;">JazzCash</span>
                        </label>

                        <!-- EasyPaisa -->
                        <label id="optEasypaisa" style="border: 2px solid {{ old('payment_method') === 'easypaisa' ? '#F59E0B' : '#E2E8F0' }}; background: {{ old('payment_method') === 'easypaisa' ? '#FFFDF5' : '#FFFFFF' }}; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="easypaisa" {{ old('payment_method') === 'easypaisa' ? 'checked' : '' }} onchange="switchPaymentMethod('easypaisa')" style="accent-color: #F59E0B; transform: scale(1.3);">
                                <div>
                                    <strong style="display: block; font-size: 14px; color: #0F172A;">📱 EasyPaisa Mobile Account</strong>
                                    <span style="font-size: 12px; color: #64748B;">Direct digital debit from your registered EasyPaisa wallet</span>
                                </div>
                            </div>
                            <span style="background: #059669; color: #FFF; font-weight: 900; font-size: 11px; padding: 3px 9px; border-radius: 6px;">EasyPaisa</span>
                        </label>

                        <!-- Debit/Credit Card -->
                        <label id="optCard" style="border: 2px solid {{ old('payment_method') === 'card' ? '#F59E0B' : '#E2E8F0' }}; background: {{ old('payment_method') === 'card' ? '#FFFDF5' : '#FFFFFF' }}; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="card" {{ old('payment_method') === 'card' ? 'checked' : '' }} onchange="switchPaymentMethod('card')" style="accent-color: #F59E0B; transform: scale(1.3);">
                                <div>
                                    <strong style="display: block; font-size: 14px; color: #0F172A;">💳 Debit / Credit Card (Visa, Mastercard, PayPak)</strong>
                                    <span style="font-size: 12px; color: #64748B;">Instant 256-bit bank encrypted card settlement</span>
                                </div>
                            </div>
                            <span style="font-size: 20px;">💳</span>
                        </label>

                    </div>

                    <!-- Dynamic Payment Input Containers -->
                    <!-- 1. Wallet Box -->
                    <div id="boxWallet" style="display: {{ old('payment_method') === 'wallet' || !old('payment_method') ? 'block' : 'none' }}; background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 18px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <span style="font-size: 13px; font-weight: 700; color: #475569;">Available Escrow Balance:</span>
                            <strong style="font-size: 16px; color: #0F172A;">Rs. {{ number_format($availableWallet) }}</strong>
                        </div>
                        @if($availableWallet >= $price)
                            <p style="font-size: 12.5px; color: #059669; margin: 0; line-height: 1.5;">
                                ✓ Your wallet has enough funds. <strong>Rs. <span class="lblPrice">{{ number_format($price) }}</span></strong> will be deducted upon clicking Confirm Payment.
                            </p>
                        @else
                            <div style="background: #FEF2F2; border: 1px solid #FECDD3; border-radius: 8px; padding: 10px 12px; color: #991B1B; font-size: 12.5px; line-height: 1.4;">
                                ⚠️ <strong>Insufficient Balance:</strong> You need Rs. <span class="lblPrice">{{ number_format($price) }}</span>, but only have Rs. {{ number_format($availableWallet) }}. Please choose <strong>JazzCash, EasyPaisa, or Debit/Credit Card</strong> to pay.
                            </div>
                        @endif
                    </div>

                    <!-- 2. JazzCash Box -->
                    <div id="boxJazzcash" style="display: {{ old('payment_method') === 'jazzcash' ? 'block' : 'none' }}; background: #FFFDF0; border: 1.5px solid #FDE68A; border-radius: 12px; padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <h4 style="font-size: 14px; font-weight: 800; color: #78350F; margin: 0;">JazzCash Account Details</h4>
                            <span style="font-size: 11px; background: #FEF3C7; color: #92400E; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid #FCD34D;">⚡ Real-time API Direct Integration</span>
                        </div>
                        
                        <div style="margin-bottom: 14px;">
                            <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                JazzCash Registered Mobile Number <span style="color: #DC2626;">*</span>
                            </label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" name="jazzcash_mobile" id="jazzcash_mobile" value="{{ old('jazzcash_mobile', $user->phone ?? '') }}" placeholder="03001234567" style="flex: 1; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 700; background: #FFF;">
                                <button type="button" id="btnJcVerify" onclick="triggerGatewayPrompt('jazzcash')" style="background: #E11D48; color: #FFF; border: none; border-radius: 10px; padding: 0 16px; font-size: 12.5px; font-weight: 800; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;">
                                    <span>📲 Send USSD Push</span>
                                </button>
                            </div>
                            <span style="font-size: 11.5px; color: #64748B; display: block; margin-top: 4px;">Enter the 11-digit mobile number linked to your JazzCash wallet.</span>
                        </div>

                        <!-- Live Gateway Status Box -->
                        <div id="jcGatewayStatus" style="display: none; margin-bottom: 14px; border-radius: 10px; padding: 10px 14px; font-size: 12px; line-height: 1.4;"></div>
                        <input type="hidden" name="transaction_reference" id="jc_txn_ref" value="{{ old('transaction_reference') }}">

                        <div>
                            <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                JazzCash 6-Digit Verification OTP <span style="color: #DC2626;">*</span>
                            </label>
                            <input type="text" inputmode="numeric" name="jazzcash_mpin" id="jazzcash_mpin" maxlength="6" placeholder="e.g. 6-digit code" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 15px; font-weight: 800; background: #FFF; letter-spacing: 4px;">
                            <span style="font-size: 11.5px; color: #64748B; display: block; margin-top: 4px;">Click "Send USSD Push" above to generate your verification code. Random OTPs will be rejected.</span>
                        </div>
                    </div>

                    <!-- 3. EasyPaisa Box -->
                    <div id="boxEasypaisa" style="display: {{ old('payment_method') === 'easypaisa' ? 'block' : 'none' }}; background: #F0FDF4; border: 1.5px solid #BBF7D0; border-radius: 12px; padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <h4 style="font-size: 14px; font-weight: 800; color: #166534; margin: 0;">EasyPaisa Account Details</h4>
                            <span style="font-size: 11px; background: #DCFCE7; color: #166534; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid #86EFAC;">⚡ Direct REST API Integration</span>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                EasyPaisa Mobile Number <span style="color: #DC2626;">*</span>
                            </label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" name="easypaisa_mobile" id="easypaisa_mobile" value="{{ old('easypaisa_mobile', $user->phone ?? '') }}" placeholder="03451234567" style="flex: 1; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 700; background: #FFF;">
                                <button type="button" id="btnEpVerify" onclick="triggerGatewayPrompt('easypaisa')" style="background: #059669; color: #FFF; border: none; border-radius: 10px; padding: 0 16px; font-size: 12.5px; font-weight: 800; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;">
                                    <span>📲 Send App Prompt</span>
                                </button>
                            </div>
                            <span style="font-size: 11.5px; color: #64748B; display: block; margin-top: 4px;">Enter the 11-digit mobile number linked to your EasyPaisa wallet.</span>
                        </div>

                        <!-- Live Gateway Status Box -->
                        <div id="epGatewayStatus" style="display: none; margin-bottom: 14px; border-radius: 10px; padding: 10px 14px; font-size: 12px; line-height: 1.4;"></div>
                        <input type="hidden" name="transaction_reference" id="ep_txn_ref" value="{{ old('transaction_reference') }}">

                        <div>
                            <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                EasyPaisa 6-Digit Verification OTP <span style="color: #DC2626;">*</span>
                            </label>
                            <input type="text" inputmode="numeric" name="easypaisa_mpin" id="easypaisa_mpin" maxlength="6" placeholder="e.g. 6-digit code" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 15px; font-weight: 800; background: #FFF; letter-spacing: 4px;">
                            <span style="font-size: 11.5px; color: #64748B; display: block; margin-top: 4px;">Click "Send App Prompt" above to generate your verification code. Random OTPs will be rejected.</span>
                        </div>
                    </div>

                    <!-- 4. Card Box -->
                    <div id="boxCard" style="display: {{ old('payment_method') === 'card' ? 'block' : 'none' }}; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 20px;">
                        <h4 style="font-size: 14px; font-weight: 800; color: #1E293B; margin: 0 0 12px 0;">Debit / Credit Card Credentials</h4>
                        
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                Name on Card <span style="color: #DC2626;">*</span>
                            </label>
                            <input type="text" name="card_name" value="{{ old('card_name', $pro->name ?? '') }}" placeholder="e.g. MUHAMMAD ALI" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 700; background: #FFF; text-transform: uppercase;">
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                Card Number (Visa / Mastercard) <span style="color: #DC2626;">*</span>
                            </label>
                            <input type="text" name="card_number" id="card_number" maxlength="19" placeholder="4242 •••• •••• 4242" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 800; background: #FFF; letter-spacing: 2px;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                    Expiry Date (MM/YY) <span style="color: #DC2626;">*</span>
                                </label>
                                <input type="text" name="card_expiry" id="card_expiry" maxlength="5" placeholder="12/28" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 700; background: #FFF;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12.5px; font-weight: 800; color: #374151; margin-bottom: 6px;">
                                    CVC / CVV <span style="color: #DC2626;">*</span>
                                </label>
                                <input type="password" name="card_cvc" maxlength="4" placeholder="•••" style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #D1D5DB; font-size: 14px; font-weight: 700; background: #FFF;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Column: Order Summary & Pay Action -->
            <div>
                <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); position: sticky; top: 20px;">
                    <h3 style="font-size: 16px; font-weight: 900; color: #111; margin: 0 0 16px 0;">Order Summary</h3>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 13.5px;">
                        <span style="color: #64748B;">Plan Selected:</span>
                        <strong id="summaryPlanName" style="color: #111;">{{ $plan === 'pro_monthly' ? 'Monthly Pass' : 'Annual Pass' }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 13.5px;">
                        <span style="color: #64748B;">Billing Period:</span>
                        <span id="summaryDuration" style="font-weight: 700; color: #0F172A;">{{ $plan === 'pro_monthly' ? '30 Days' : '365 Days' }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 13.5px;">
                        <span style="color: #64748B;">Platform Commission:</span>
                        <span style="color: #059669; font-weight: 900; background: #ECFDF5; padding: 2px 8px; border-radius: 6px;">0% (Waived!)</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 13.5px;">
                        <span style="color: #64748B;">GST / Transaction Tax:</span>
                        <span style="color: #10B981; font-weight: 800;">Rs. 0 (Waived)</span>
                    </div>

                    <div style="border-top: 2px dashed #E2E8F0; margin: 16px 0; padding-top: 14px; display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-size: 14px; font-weight: 800; color: #111;">Total Payable:</span>
                        <strong id="summaryTotal" style="font-size: 24px; font-weight: 900; color: #D97706;">Rs. {{ number_format($price) }}</strong>
                    </div>

                    <!-- Perks Included List -->
                    <div style="background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 12px; padding: 12px 14px; margin-bottom: 20px;">
                        <div style="font-size: 12px; font-weight: 800; color: #92400E; margin-bottom: 4px;">VIP Partner Perks Activated:</div>
                        <ul style="font-size: 11.5px; color: #78350F; margin: 0; padding-left: 16px; line-height: 1.5;">
                            <li>Keep 100% of all customer payouts</li>
                            <li>Top search position in your city</li>
                            <li>Gold Pro Verified Partner badge</li>
                            <li>Priority 15-min dispatches</li>
                        </ul>
                    </div>

                    <button type="submit" id="btnSubmitPayment" style="width: 100%; padding: 14px; border-radius: 12px; border: none; background: #111827; color: #FDE047; font-weight: 900; font-size: 15px; cursor: pointer; box-shadow: 0 4px 14px rgba(0,0,0,0.2); transition: all 0.2s ease;">
                        Pay Rs. <span class="lblPrice">{{ number_format($price) }}</span> &amp; Activate VIP &rarr;
                    </button>

                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 14px; color: #64748B; font-size: 11px;">
                        <span>🔒 256-Bit SSL Encrypted</span>
                        <span>&bull;</span>
                        <span>Verified Gateway</span>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
    let currentPrice = {{ $price }};
    const availableWallet = {{ $availableWallet }};

    function updatePlanSelection(plan, price) {
        currentPrice = price;
        const formatted = new Intl.NumberFormat().format(price);
        
        document.querySelectorAll('.lblPrice').forEach(el => el.textContent = formatted);
        document.getElementById('summaryTotal').textContent = 'Rs. ' + formatted;

        if (plan === 'pro_monthly') {
            document.getElementById('labelPlanMonthly').style.borderColor = '#F59E0B';
            document.getElementById('labelPlanMonthly').style.background = '#FFFDF5';
            document.getElementById('labelPlanAnnual').style.borderColor = '#E2E8F0';
            document.getElementById('labelPlanAnnual').style.background = '#FFFFFF';
            document.getElementById('summaryPlanName').textContent = 'Monthly Pass';
            document.getElementById('summaryDuration').textContent = '30 Days';
        } else {
            document.getElementById('labelPlanAnnual').style.borderColor = '#F59E0B';
            document.getElementById('labelPlanAnnual').style.background = '#FFFDF5';
            document.getElementById('labelPlanMonthly').style.borderColor = '#E2E8F0';
            document.getElementById('labelPlanMonthly').style.background = '#FFFFFF';
            document.getElementById('summaryPlanName').textContent = 'Annual Pass';
            document.getElementById('summaryDuration').textContent = '365 Days';
        }
    }

    function switchPaymentMethod(method) {
        const methods = ['wallet', 'jazzcash', 'easypaisa', 'card'];
        methods.forEach(m => {
            const opt = document.getElementById('opt' + m.charAt(0).toUpperCase() + m.slice(1));
            const box = document.getElementById('box' + m.charAt(0).toUpperCase() + m.slice(1));
            if (m === method) {
                if (opt) {
                    opt.style.borderColor = '#F59E0B';
                    opt.style.background = '#FFFDF5';
                }
                if (box) box.style.display = 'block';
            } else {
                if (opt) {
                    opt.style.borderColor = '#E2E8F0';
                    opt.style.background = '#FFFFFF';
                }
                if (box) box.style.display = 'none';
            }
        });
    }

    // Live card formatting
    const cardInput = document.getElementById('card_number');
    if (cardInput) {
        cardInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '').substring(0, 16);
            let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
            e.target.value = formatted;
        });
    }

    const expiryInput = document.getElementById('card_expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '').substring(0, 4);
            if (val.length >= 3) {
                e.target.value = val.substring(0, 2) + '/' + val.substring(2);
            } else {
                e.target.value = val;
            }
        });
    }

    // Live Gateway USSD / App Push API Trigger
    async function triggerGatewayPrompt(gateway) {
        const isJc = gateway === 'jazzcash';
        const mobileInput = document.getElementById(isJc ? 'jazzcash_mobile' : 'easypaisa_mobile');
        const btn = document.getElementById(isJc ? 'btnJcVerify' : 'btnEpVerify');
        const statusBox = document.getElementById(isJc ? 'jcGatewayStatus' : 'epGatewayStatus');
        const txnRefInput = document.getElementById(isJc ? 'jc_txn_ref' : 'ep_txn_ref');

        const phone = mobileInput ? mobileInput.value.trim() : '';
        if (!phone || phone.length < 10) {
            alert('Please enter a valid Pakistani mobile number (e.g. 03001234567 or 03451234567).');
            if (mobileInput) mobileInput.focus();
            return;
        }

        const originalBtnHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>⏳ Communicating API...</span>';

        statusBox.style.display = 'block';
        statusBox.style.background = '#EFF6FF';
        statusBox.style.border = '1px solid #BFDBFE';
        statusBox.style.color = '#1E40AF';
        statusBox.innerHTML = '<strong>Connecting to ' + (isJc ? 'JazzCash MWALLET' : 'EasyPaisa Direct') + ' Gateway...</strong> Sending instant push notification to ' + phone + '...';

        try {
            const response = await fetch("{{ route('technician.subscription.verify-gateway') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    gateway: gateway,
                    phone: phone,
                    amount: currentPrice
                })
            });

            const data = await response.json();

            if (data.success) {
                statusBox.style.background = '#ECFDF5';
                statusBox.style.border = '1.5px solid #6EE7B7';
                statusBox.style.color = '#065F46';
                
                let otpHtml = '';
                if (data.otp && !data.sms_dispatched) {
                    otpHtml = `
                        <div style="background: #FFFBEB; border: 1.5px solid #FCD34D; border-radius: 8px; padding: 10px 12px; margin-top: 8px;">
                            <div style="font-size: 11.5px; font-weight: 800; color: #92400E; margin-bottom: 4px;">
                                🔑 FixMate Authorization Code (Sandbox OTP):
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                <span style="font-size: 20px; font-weight: 900; letter-spacing: 4px; color: #B45309; font-family: monospace;">${data.otp}</span>
                                <button type="button" onclick="autoFillOtp('${gateway}', '${data.otp}')" style="background: #D97706; color: #FFF; border: none; border-radius: 6px; padding: 5px 12px; font-size: 11.5px; font-weight: 800; cursor: pointer; white-space: nowrap;">
                                    📋 Auto-Fill OTP
                                </button>
                            </div>
                            <div style="font-size: 10.5px; color: #78350F; margin-top: 4px;">
                                ℹ️ SMS gateway is not configured in .env. Enter this exact 6-digit OTP below; random numbers will be strictly rejected!
                            </div>
                        </div>
                    `;
                } else if (data.sms_dispatched) {
                    otpHtml = `
                        <div style="background: #F0FDF4; border: 1px solid #86EFAC; border-radius: 8px; padding: 8px 10px; margin-top: 8px; font-size: 12px; color: #166534;">
                            📲 Real SMS sent to ${phone}! Please check your phone messages and enter the 6-digit OTP below.
                        </div>
                    `;
                }

                statusBox.innerHTML = `
                    <div style="font-weight: 800; font-size: 13px;">✓ ${isJc ? 'JazzCash' : 'EasyPaisa'} Gateway Handshake Successful!</div>
                    <div style="margin-top: 2px;">${data.message}</div>
                    <div style="margin-top: 4px; font-size: 11px;">Gateway Ref: <strong style="background: #D1FAE5; padding: 1px 6px; border-radius: 4px;">${data.reference_id}</strong></div>
                    ${otpHtml}
                `;
                
                if (txnRefInput) txnRefInput.value = data.reference_id;
                btn.innerHTML = '<span>✓ OTP Dispatched</span>';
                btn.style.background = '#059669';
                btn.disabled = false;
            } else {
                statusBox.style.background = '#FEF2F2';
                statusBox.style.border = '1.5px solid #FCA5A5';
                statusBox.style.color = '#991B1B';
                statusBox.innerHTML = '⚠️ <strong>Gateway Error:</strong> ' + (data.message || 'Payment initiation failed. Please check your mobile number and retry.');
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
            }
        } catch (err) {
            statusBox.style.background = '#FEF2F2';
            statusBox.style.border = '1.5px solid #FCA5A5';
            statusBox.style.color = '#991B1B';
            statusBox.innerHTML = '⚠️ <strong>Network / Connection Error:</strong> Unable to reach payment gateway service. Please try again.';
            btn.disabled = false;
            btn.innerHTML = originalBtnHtml;
        }
    }

    function autoFillOtp(gateway, otp) {
        const isJc = gateway === 'jazzcash';
        const input = document.getElementById(isJc ? 'jazzcash_mpin' : 'easypaisa_mpin');
        if (input) {
            input.value = otp;
            input.focus();
            input.style.borderColor = '#059669';
            input.style.boxShadow = '0 0 0 3px rgba(5, 150, 105, 0.2)';
        }
    }

    // Client side pre-submission check
    document.getElementById('checkoutSubscriptionForm').addEventListener('submit', function (e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
        if (selectedMethod === 'wallet' && availableWallet < currentPrice) {
            e.preventDefault();
            alert('⚠️ Insufficient Wallet Balance! Your wallet has Rs. ' + new Intl.NumberFormat().format(availableWallet) + ', but the plan costs Rs. ' + new Intl.NumberFormat().format(currentPrice) + '.\n\nPlease select JazzCash, EasyPaisa, or Debit/Credit Card to complete payment.');
            return false;
        }

        if (selectedMethod === 'jazzcash') {
            const jcMobile = document.getElementById('jazzcash_mobile').value.trim();
            if (!jcMobile || jcMobile.length < 10) {
                e.preventDefault();
                alert('Please enter your 11-digit JazzCash mobile account number (e.g. 03001234567).');
                document.getElementById('jazzcash_mobile').focus();
                return false;
            }
            const jcOtp = document.getElementById('jazzcash_mpin').value.trim();
            if (!jcOtp || jcOtp.length < 4) {
                e.preventDefault();
                alert('Please click "Send USSD Push" and enter your verification OTP before confirming payment.');
                document.getElementById('jazzcash_mpin').focus();
                return false;
            }
        }

        if (selectedMethod === 'easypaisa') {
            const epMobile = document.getElementById('easypaisa_mobile').value.trim();
            if (!epMobile || epMobile.length < 10) {
                e.preventDefault();
                alert('Please enter your 11-digit EasyPaisa mobile account number (e.g. 03451234567).');
                document.getElementById('easypaisa_mobile').focus();
                return false;
            }
            const epOtp = document.getElementById('easypaisa_mpin').value.trim();
            if (!epOtp || epOtp.length < 4) {
                e.preventDefault();
                alert('Please click "Send App Prompt" and enter your verification OTP before confirming payment.');
                document.getElementById('easypaisa_mpin').focus();
                return false;
            }
        }

        if (selectedMethod === 'card') {
            const cardNum = document.getElementById('card_number').value.replace(/\s/g, '');
            if (!cardNum || cardNum.length < 12) {
                e.preventDefault();
                alert('Please enter a valid 16-digit debit or credit card number.');
                document.getElementById('card_number').focus();
                return false;
            }
        }
    });
</script>
@endsection
