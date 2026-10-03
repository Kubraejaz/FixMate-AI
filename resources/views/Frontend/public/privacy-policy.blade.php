@extends('Frontend.layouts.public')

@section('title', 'Privacy Policy — FixMate AI')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 80vh; padding: 50px 0 70px 0;">
    <div class="container" style="max-width: 860px; margin: 0 auto;">
        <div class="portal-card" style="padding: 40px 48px; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 12px; font-weight: 800; color: #B45309; text-transform: uppercase; letter-spacing: 0.05em;">Legal Compliance</span>
                <span style="font-size: 12px; color: #059669; font-weight: 700; background: #DCFCE7; padding: 3px 10px; border-radius: 12px;">
                    ● In Effect &amp; Active
                </span>
            </div>
            
            <h1 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Privacy &amp; Data Protection Policy</h1>
            <p style="font-size: 13.5px; color: #64748B; margin-bottom: 28px; padding-bottom: 16px; border-bottom: 1px solid #F1F5F9;">
                Last updated: {{ now()->format('F Y') }} • Applies to all FixMate AI Web &amp; Mobile Platform users across Pakistan.
            </p>

            <div style="font-size: 14.5px; color: #4B5563; line-height: 1.8; display: flex; flex-direction: column; gap: 22px;">
                <p>
                    <strong>FixMate AI</strong> ("we", "our", or "us") respects your personal privacy and is committed to protecting data collected through our customer portal, technician network, computer vision defect diagnostic scanner, and escrow payment intermediation.
                </p>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">1. Information We Collect</h3>
                    <p style="margin: 0 0 10px 0;">
                        <strong>A. Customer Accounts:</strong> Name, authenticated phone number, email address, service location coordinates, and uploaded photographs/audio of repair issues for computer-vision diagnostics.<br>
                        <strong>B. Technician Verification:</strong> National Database &amp; Registration Authority (NADRA) CNIC numbers, trade diplomas, police clearance checks, real-time GPS telemetry during dispatches, and bank/JazzCash account details.<br>
                        <strong>C. AI Telemetry:</strong> Device identifiers, diagnostic inference metadata, and model performance logs to refine repair cost accuracy.
                    </p>
                </div>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">2. How Computer Vision Processes Defect Photos</h3>
                    <p style="margin: 0;">
                        Photographs uploaded to our AI scanner are analyzed solely to detect damaged components (e.g. leaking joints, tripped breaker switches, burned PCB traces), estimate labor and materials cost benchmarks, and dispatch the correct trade discipline. Photos are stored securely in encrypted private buckets and are never shared or sold to advertising brokers.
                    </p>
                </div>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">3. Escrow &amp; Workmanship Protection</h3>
                    <p style="margin: 0;">
                        Funds paid through the platform are held in secure escrow. Payment release requires customer satisfaction verification or Arrival OTP validation. All completed tasks are accompanied by a <strong>{{ $settings?->warranty_days ?? 30 }}-day re-work protection warranty</strong>.
                    </p>
                </div>

                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">4. Security &amp; OWASP Compliance</h3>
                    <p style="margin: 0;">
                        In accordance with OWASP Top 10 recommendations, user passwords are encrypted using bcrypt, multi-factor phone OTP validation is required for account creation, and strict role-based access control (RBAC) isolates customer and technician profile data.
                    </p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px 22px; margin-top: 10px;">
                    <strong style="color: #0F172A; font-size: 14px; display: block; margin-bottom: 4px;">Data Protection &amp; Dispute Inquiries</strong>
                    <span style="font-size: 13.5px; color: #64748B;">For privacy inquiries, account deletion requests, or data audits, reach out to our legal officer at <a href="mailto:privacy@fixmate.pk" style="color: #FFB800; font-weight: 700; text-decoration: none;">privacy@fixmate.pk</a> or visit our <a href="{{ route('contact') }}" style="color: #0F172A; font-weight: 700;">Help &amp; Arbitration Portal</a>.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
