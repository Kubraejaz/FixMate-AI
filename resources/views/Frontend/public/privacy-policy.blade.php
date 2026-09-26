@extends('Frontend.layouts.public')

@section('title', 'Privacy Policy — FixMate AI')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 80vh; padding: 50px 0 70px 0;">
    <div class="container" style="max-width: 820px; margin: 0 auto;">
        <div class="portal-card" style="padding: 40px; background: #FFFFFF;">
            <span style="font-size: 12px; font-weight: 800; color: #B45309; text-transform: uppercase;">Legal Compliance</span>
            <h1 style="font-size: 32px; font-weight: 900; color: #111; margin: 6px 0 16px 0;">Privacy Policy</h1>
            <p style="font-size: 13.5px; color: #777; margin-bottom: 24px;">Last updated: September 2026 • Effective for all FixMate AI Web & Cloud Platform users</p>

            <div style="font-size: 14.5px; color: #4B5563; line-height: 1.8; display: flex; flex-direction: column; gap: 20px;">
                <p>
                    FixMate AI ("we", "our", or "us") respects your privacy and is dedicated to securing personal data collected through our web portals, AI computer vision diagnostic scanner, and customer-provider matching infrastructure.
                </p>

                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-top: 10px;">1. Information We Collect</h3>
                <p>
                    <strong>A. Customer Data:</strong> Full name, phone number, email address, physical service addresses, problem descriptions, and uploaded photographs/videos of repair issues for computer-vision diagnosis.<br>
                    <strong>B. Technician Data:</strong> Government CNIC number, trade certificates, background check history, GPS real-time location during active jobs, and bank account/JazzCash details for payouts.<br>
                    <strong>C. Telemetry & AI Logs:</strong> Device type, browser metadata, and visual features extracted by the FixMate AI diagnostic pipeline.
                </p>

                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-top: 10px;">2. How AI Computer Vision Processes Images</h3>
                <p>
                    Photographs and videos uploaded to FixMate AI are processed solely to determine repair category, defect severity, required tradesperson, and cost estimation. Images are securely stored in encrypted cloud storage and are never sold to external advertising networks.
                </p>

                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-top: 10px;">3. Security & OWASP Compliance</h3>
                <p>
                    In accordance with OWASP Top 10 recommendations, authentication is strictly enforced for file uploads, passwords are encrypted using bcrypt, and role-based access control (RBAC) isolates customer, technician, and administrator data.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
