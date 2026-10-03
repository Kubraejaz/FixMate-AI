@extends('Frontend.layouts.customer')

@section('title', 'Select Payment Method — FixMate AI Escrow')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px; text-align: center;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Secure Payment Escrow</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Payment is held safely in escrow and only released after technician completes the job and you provide verification OTP.</p>
    </div>

    <form action="{{ auth()->user() && auth()->user()->bookings()->latest()->first() ? route('customer.booking.confirm', auth()->user()->bookings()->latest()->first()->id) : route('customer.bookings') }}" method="GET">
        <div class="portal-card" style="padding: 32px; background: #FFFFFF; margin-bottom: 24px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Choose Payment Option</h3>

            <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
                
                <!-- JazzCash -->
                <label style="border: 2px solid #FFCC00; background: #FFFDF0; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <input type="radio" name="payment_method" value="jazzcash" checked style="accent-color: #FFCC00;">
                        <div>
                            <strong style="display: block; font-size: 15px; color: #111;">JazzCash Mobile Wallet</strong>
                            <span style="font-size: 12px; color: #666;">Pay via JazzCash app or MPIN instant escrow</span>
                        </div>
                    </div>
                    <span style="background: #E11D48; color: #FFF; font-weight: 900; font-size: 11px; padding: 2px 8px; border-radius: 4px;">JazzCash</span>
                </label>

                <!-- EasyPaisa -->
                <label style="border: 1px solid var(--border-color); background: #FFF; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <input type="radio" name="payment_method" value="easypaisa" style="accent-color: #FFCC00;">
                        <div>
                            <strong style="display: block; font-size: 15px; color: #111;">EasyPaisa Wallet</strong>
                            <span style="font-size: 12px; color: #666;">Instant debit from your EasyPaisa account</span>
                        </div>
                    </div>
                    <span style="background: #059669; color: #FFF; font-weight: 900; font-size: 11px; padding: 2px 8px; border-radius: 4px;">EasyPaisa</span>
                </label>

                <!-- Credit/Debit Card -->
                <label style="border: 1px solid var(--border-color); background: #FFF; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <input type="radio" name="payment_method" value="card" style="accent-color: #FFCC00;">
                        <div>
                            <strong style="display: block; font-size: 15px; color: #111;">Visa / MasterCard / PayPak</strong>
                            <span style="font-size: 12px; color: #666;">Encrypted 3D Secure bank payment</span>
                        </div>
                    </div>
                    <span style="font-size: 18px;">💳</span>
                </label>

                <!-- Cash on Completion -->
                <label style="border: 1px solid var(--border-color); background: #FFF; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <input type="radio" name="payment_method" value="cash" style="accent-color: #FFCC00;">
                        <div>
                            <strong style="display: block; font-size: 15px; color: #111;">Cash on Completion (COD)</strong>
                            <span style="font-size: 12px; color: #666;">Pay cash directly to technician once work is inspected</span>
                        </div>
                    </div>
                    <span style="font-size: 18px;">💵</span>
                </label>

            </div>

            <!-- Amount Due -->
            <div style="background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div>
                    <span style="font-size: 12px; color: #666;">Inspection Base Rate (Held in Escrow)</span>
                    <strong style="display: block; font-size: 18px; color: #111;">Rs. 500</strong>
                </div>
                <span style="font-size: 12px; background: #ECFDF5; color: #047857; font-weight: 700; padding: 4px 10px; border-radius: 20px;">
                    100% Refundable if technician does not show
                </span>
            </div>

            <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px 0; font-size: 15px; font-weight: 900; border-radius: 12px;">
                Confirm & Pay Rs. 500 →
            </button>
        </div>
    </form>

</div>
@endsection
