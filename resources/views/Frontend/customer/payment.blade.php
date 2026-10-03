@extends('Frontend.layouts.customer')

@section('title', 'Select Payment & Escrow Method — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Escrow & Payment Vault</h1>
                <p style="font-size: 14px; color: #666; margin: 0;">100% Protected Escrow Payments — Funds are released to technician only after job completion.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 6px; background: #ECFDF5; border: 1px solid #A7F3D0; padding: 6px 12px; border-radius: 20px;">
                <span style="font-size: 14px;">🛡️</span>
                <span style="font-size: 12px; font-weight: 800; color: #065F46;">FixMate Escrow Protected</span>
            </div>
        </div>
    </div>

    @if(! $booking)
        <!-- No active booking selected -->
        <div class="portal-card" style="padding: 40px; text-align: center; background: #FFFFFF; border-radius: 16px; margin-bottom: 28px;">
            <div style="font-size: 44px; margin-bottom: 12px;">💳</div>
            <h2 style="font-size: 20px; font-weight: 900; color: #111; margin-bottom: 6px;">No Active Booking Awaiting Payment</h2>
            <p style="font-size: 14px; color: #666; margin-bottom: 20px; max-width: 480px; margin-left: auto; margin-right: auto;">
                All your previous bookings have assigned payment terms, or you haven't created a booking yet.
            </p>
            <a href="{{ route('customer.booking') }}" class="btn-yellow" style="padding: 11px 26px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 10px; display: inline-block;">
                + Create New Service Booking
            </a>
        </div>
    @else
        <!-- Active Escrow Configuration Card -->
        <div style="margin-bottom: 24px;">
            <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 14px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div>
                    <span style="font-size: 11px; font-weight: 800; color: #B45309; text-transform: uppercase;">Active Booking Checkout</span>
                    <strong style="display: block; font-size: 16px; color: #111;">Booking #{{ $booking->booking_number }} — {{ $booking->service_title }}</strong>
                    <span style="font-size: 12.5px; color: #666;">Date: {{ $booking->service_date ? $booking->service_date->format('M d, Y') : 'Today' }} • Slot: {{ $booking->service_time_slot }}</span>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 11px; color: #666; display: block;">Escrow Hold Total</span>
                    <strong style="font-size: 22px; color: #047857; font-weight: 900;">Rs. {{ number_format($booking->total_price) }}</strong>
                </div>
            </div>
        </div>

        <form action="{{ route('customer.payment.process', $booking->id) }}" method="POST">
            @csrf

            <div class="portal-card" style="padding: 30px; background: #FFFFFF; margin-bottom: 28px;">
                <h3 style="font-size: 16.5px; font-weight: 800; color: #111; margin-bottom: 16px;">Select Payment & Escrow Method</h3>

                <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
                    
                    <!-- JazzCash -->
                    <label style="border: 2px solid {{ old('payment_method', $booking->payment_method) === 'jazzcash' || !old('payment_method') ? '#FFB800' : '#E2E8F0' }}; background: {{ old('payment_method', $booking->payment_method) === 'jazzcash' || !old('payment_method') ? '#FFFDF0' : '#FFFFFF' }}; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <input type="radio" name="payment_method" value="jazzcash" {{ old('payment_method', $booking->payment_method) === 'jazzcash' || !old('payment_method') ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.3);">
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: #111;">JazzCash Mobile Wallet Escrow</strong>
                                <span style="font-size: 12px; color: #64748B;">Instant debit via JazzCash OTP/MPIN. Held safely in FixMate Escrow until verified arrival.</span>
                            </div>
                        </div>
                        <span style="background: #E11D48; color: #FFF; font-weight: 900; font-size: 11px; padding: 3px 9px; border-radius: 6px;">JazzCash</span>
                    </label>

                    <!-- EasyPaisa -->
                    <label style="border: 2px solid {{ old('payment_method', $booking->payment_method) === 'easypaisa' ? '#FFB800' : '#E2E8F0' }}; background: {{ old('payment_method', $booking->payment_method) === 'easypaisa' ? '#FFFDF0' : '#FFFFFF' }}; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <input type="radio" name="payment_method" value="easypaisa" {{ old('payment_method', $booking->payment_method) === 'easypaisa' ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.3);">
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: #111;">EasyPaisa Wallet Escrow</strong>
                                <span style="font-size: 12px; color: #64748B;">Direct digital payment from your EasyPaisa wallet. 100% money-back guarantee.</span>
                            </div>
                        </div>
                        <span style="background: #059669; color: #FFF; font-weight: 900; font-size: 11px; padding: 3px 9px; border-radius: 6px;">EasyPaisa</span>
                    </label>

                    <!-- Credit / Debit Card -->
                    <label style="border: 2px solid {{ old('payment_method', $booking->payment_method) === 'card' ? '#FFB800' : '#E2E8F0' }}; background: {{ old('payment_method', $booking->payment_method) === 'card' ? '#FFFDF0' : '#FFFFFF' }}; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <input type="radio" name="payment_method" value="card" {{ old('payment_method', $booking->payment_method) === 'card' ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.3);">
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: #111;">Debit / Credit Card (Visa, MasterCard, PayPak)</strong>
                                <span style="font-size: 12px; color: #64748B;">256-bit encrypted 3D Secure bank pre-authorization held until job completion.</span>
                            </div>
                        </div>
                        <span style="font-size: 22px;">💳</span>
                    </label>

                    <!-- Cash on Completion -->
                    <label style="border: 2px solid {{ old('payment_method', $booking->payment_method) === 'cash' ? '#FFB800' : '#E2E8F0' }}; background: {{ old('payment_method', $booking->payment_method) === 'cash' ? '#FFFDF0' : '#FFFFFF' }}; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s ease;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <input type="radio" name="payment_method" value="cash" {{ old('payment_method', $booking->payment_method) === 'cash' ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.3);">
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: #111;">Cash on Completion (Verified Physical Handover)</strong>
                                <span style="font-size: 12px; color: #64748B;">Inspect the completed repair first, then pay cash directly to the technician.</span>
                            </div>
                        </div>
                        <span style="font-size: 22px;">💵</span>
                    </label>

                </div>

                <!-- Escrow Protection Guarantee Bar -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <span style="font-size: 12px; color: #64748B;">FixMate Escrow Security</span>
                        <strong style="display: block; font-size: 19px; color: #047857;">Rs. {{ number_format($booking->total_price) }} Protected</strong>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 12px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 5px 12px; border-radius: 20px; border: 1px solid #A7F3D0;">
                            ✓ 100% Refund Guarantee If Technician No-Show
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px 0; font-size: 15px; font-weight: 900; border-radius: 12px; border: none; cursor: pointer;">
                    Confirm & Secure Rs. {{ number_format($booking->total_price) }} in Escrow →
                </button>
            </div>
        </form>
    @endif

    <!-- Escrow Ledger & Booking Payment History -->
    @if(isset($allBookings) && $allBookings->isNotEmpty())
        <div class="portal-card" style="padding: 28px; background: #FFFFFF; border-radius: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Your Escrow Accounts & Payment Ledger</h3>
                <span style="font-size: 12px; color: #64748B;">Recent {{ $allBookings->count() }} Bookings</span>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                    <thead>
                        <tr style="border-bottom: 2px solid #F1F5F9; text-align: left; color: #64748B; font-size: 12px; text-transform: uppercase;">
                            <th style="padding: 10px 12px;">Booking #</th>
                            <th style="padding: 10px 12px;">Service</th>
                            <th style="padding: 10px 12px;">Method</th>
                            <th style="padding: 10px 12px;">Amount</th>
                            <th style="padding: 10px 12px;">Escrow Status</th>
                            <th style="padding: 10px 12px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allBookings as $b)
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 12px; font-weight: 700; color: #0F172A;">
                                    #{{ $b->booking_number }}
                                </td>
                                <td style="padding: 12px; color: #334155;">
                                    {{ Str::limit($b->service_title, 26) }}
                                </td>
                                <td style="padding: 12px; text-transform: capitalize;">
                                    <span style="background: #F1F5F9; padding: 2px 8px; border-radius: 4px; font-size: 11.5px; font-weight: 700;">
                                        {{ $b->payment_method ?: 'Escrow' }}
                                    </span>
                                </td>
                                <td style="padding: 12px; font-weight: 800; color: #047857;">
                                    Rs. {{ number_format($b->total_price) }}
                                </td>
                                <td style="padding: 12px;">
                                    @if($b->payment_status === 'escrow_held')
                                        <span style="background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px;">
                                            🛡️ Held in Escrow
                                        </span>
                                    @elseif($b->payment_status === 'cash_on_delivery')
                                        <span style="background: #EFF6FF; color: #1D4ED8; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px;">
                                            💵 Pay on Handover
                                        </span>
                                    @elseif($b->payment_status === 'released' || $b->payment_status === 'paid')
                                        <span style="background: #ECFDF5; color: #065F46; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px;">
                                            ✓ Released to Pro
                                        </span>
                                    @else
                                        <span style="background: #F1F5F9; color: #475569; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 12px;">
                                            {{ ucfirst($b->payment_status ?: 'Pending') }}
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 12px; text-align: right;">
                                    <a href="{{ route('customer.payment', $b->id) }}" style="font-size: 12px; font-weight: 700; color: #B45309; text-decoration: underline;">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
