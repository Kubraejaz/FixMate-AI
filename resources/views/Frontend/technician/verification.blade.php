@extends('Frontend.layouts.technician')

@section('title', 'KYC & Trade Verification Status — FixMate AI')

@section('content')
<div style="max-width: 720px; margin: 0 auto;">
    
    <!-- Title matching Mockup 2 -->
    <div style="margin-bottom: 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 12px auto;">
            🛡️
        </div>
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Verification Status</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Provider KYC verification pipeline for government ID and trade license validation.</p>
    </div>

    <!-- Status Banner matching Mockup 2 -->
    <div class="portal-card" style="padding: 24px 28px; background: #FFFDF0; border: 2px solid #FFCC00; border-radius: 16px; margin-bottom: 24px; text-align: center;">
        <span style="background: #FEF3C7; color: #92400E; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 8px;">
            ● Verification Pending / Under Review
        </span>
        <h3 style="font-size: 18px; font-weight: 800; color: #111; margin: 0 0 6px 0;">Your documents are being reviewed</h3>
        <p style="font-size: 13.5px; color: #666; margin: 0;">
            Our compliance team is verifying your credentials with NADRA & trade authorities. You'll receive an SMS notification once approved (typically within 4 to 12 hours).
        </p>
    </div>

    <!-- Submitted Documents Checklist matching Mockup 2 -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Submitted Verification Artifacts</h3>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            
            <!-- CNIC Verification -->
            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">🪪</span>
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">National Identity Card (CNIC)</strong>
                        <span style="font-size: 12px; color: #666;">Front and back copies (42201-1234567-1)</span>
                    </div>
                </div>
                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 10px;">✓ Submitted</span>
            </div>

            <!-- Profile Photo -->
            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ asset('assets/images/image_1.png') }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 1px solid #FFCC00;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">Profile Photo (Selfie)</strong>
                        <span style="font-size: 12px; color: #666;">Clear face portrait for customer security</span>
                    </div>
                </div>
                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 10px;">✓ Submitted</span>
            </div>

            <!-- Trade License / Diploma -->
            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">📜</span>
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">Trade License / Technical Diploma</strong>
                        <span style="font-size: 12px; color: #666;">Government Vocational Certificate in Plumbing</span>
                    </div>
                </div>
                <span style="background: #FFFBEB; color: #B45309; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 10px;">⏳ Under Review</span>
            </div>

            <!-- Police Clearance Certificate -->
            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">👮</span>
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">Police Character Certificate</strong>
                        <span style="font-size: 12px; color: #666;">Khidmat Markaz background check</span>
                    </div>
                </div>
                <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 10px;">✓ Submitted</span>
            </div>

        </div>
    </div>

    <!-- Contact Support Button matching Mockup 2 -->
    <div style="text-align: center;">
        <a href="{{ url('/contact') }}" class="btn-outline" style="padding: 10px 24px; font-size: 13.5px;">
            Contact Verification Support
        </a>
    </div>

</div>
@endsection
