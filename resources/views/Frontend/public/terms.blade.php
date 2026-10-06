@extends('Frontend.layouts.public')

@section('title', 'Terms & Conditions — FixMate')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 80vh; padding: 50px 0 70px 0;">
    <div class="container" style="max-width: 860px; margin: 0 auto;">
        <div class="portal-card" style="padding: 40px 48px; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 12px; font-weight: 800; color: #B45309; text-transform: uppercase; letter-spacing: 0.05em;">Terms of Service</span>
                <span style="font-size: 12px; color: #059669; font-weight: 700; background: #DCFCE7; padding: 3px 10px; border-radius: 12px;">
                    ● Active User Agreement
                </span>
            </div>

            <h1 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Terms &amp; Service Conditions</h1>
            <p style="font-size: 13.5px; color: #64748B; margin-bottom: 28px; padding-bottom: 16px; border-bottom: 1px solid #F1F5F9;">
                Effective: {{ now()->format('F Y') }} • Binding contract for all customers and registered partner technicians.
            </p>

            <div style="font-size: 14.5px; color: #4B5563; line-height: 1.8; display: flex; flex-direction: column; gap: 22px;">
                <p>
                    By registering an account or initiating a service booking on FixMate, you agree to comply with the platform terms and consumer protection policies stated below.
                </p>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">1. Verified Service Provider Relationship</h3>
                    <p style="margin: 0;">
                        Tradespeople operating on FixMate are background-screened independent technicians. FixMate validates NADRA CNIC biometric records and provides standardized labor tariffs, real-time schedule tracking, and escrow payment intermediation.
                    </p>
                </div>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">2. Arrival OTP Authentication Code</h3>
                    <p style="margin: 0;">
                        Upon arrival at your residence, the customer must request and authenticate the technician's unique 4-digit Arrival OTP generated on the platform before work commences. This ensures only vetted and dispatched professionals enter private premises.
                    </p>
                </div>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">3. Transparent Upfront Tariff &amp; No On-Site Bidding</h3>
                    <p style="margin: 0;">
                        Technicians are contractually bound to the platform's standardized labor rates. Technicians are strictly prohibited from demanding higher labor fees upon arrival. Any spare parts required are charged at market invoice value.
                    </p>
                </div>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">4. {{ $settings?->warranty_days ?? 30 }}-Day Workmanship Guarantee</h3>
                    <p style="margin: 0;">
                        All services completed through FixMate are protected by our <strong>{{ $settings?->warranty_days ?? 30 }}-day re-work warranty</strong>. If a repair fails or leaks recur within the warranty period, a supervisor technician will be re-dispatched at zero diagnostic charge.
                    </p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px 22px; margin-top: 10px;">
                    <strong style="color: #0F172A; font-size: 14px; display: block; margin-bottom: 4px;">Dispute Arbitration &amp; Escrow Releases</strong>
                    <span style="font-size: 13.5px; color: #64748B;">If you are unsatisfied with a service, submit a ticket via our <a href="{{ route('contact') }}" style="color: #0F172A; font-weight: 700;">Dispute Arbitration Center</a>. Escrow funds will remain frozen until an arbitration manager inspects the completed work.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
