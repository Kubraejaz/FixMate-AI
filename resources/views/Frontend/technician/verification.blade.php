@extends('Frontend.layouts.technician')

@section('title', 'KYC &amp; Biometric Document Verification — FixMate AI Partner Portal')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- Title & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                <span style="font-size: 26px;">🛡️</span>
                <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0;">Partner Verification &amp; Biometrics</h1>
            </div>
            <p style="font-size: 14px; color: #666; margin: 0;">Government CNIC identity, live biometric facial validation, criminal check, and trade license verification.</p>
        </div>
        <div>
            @if($user->is_verified || $pro->verification_status === 'verified')
                <span style="background: #ECFDF5; color: #047857; border: 1.5px solid #A7F3D0; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #10B981;"></span>
                    ✓ 100% Verified Pro
                </span>
            @elseif($pro->verification_status === 'under_review')
                <span style="background: #EFF6FF; color: #1D4ED8; border: 1.5px solid #BFDBFE; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #3B82F6;"></span>
                    ⏳ Audit in Progress
                </span>
            @elseif($pro->verification_status === 'rejected')
                <span style="background: #FFF1F2; color: #BE123C; border: 1.5px solid #FECDD3; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #EF4444;"></span>
                    ⚠️ Revision Required
                </span>
            @else
                <span style="background: #FFFBEB; color: #B45309; border: 1.5px solid #FDE68A; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #F59E0B;"></span>
                    ● Verification Pending
                </span>
            @endif
        </div>
    </div>

    <!-- Alert Status Banners -->
    @if($user->is_verified || $pro->verification_status === 'verified')
        <div class="portal-card" style="padding: 22px 26px; background: #ECFDF5; border: 1.5px solid #10B981; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #10B981; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">✓</div>
            <div>
                <h3 style="font-size: 16.5px; font-weight: 800; color: #065F46; margin: 0 0 4px 0;">All Compliance & Biometric Checks Approved</h3>
                <p style="font-size: 13.5px; color: #047857; margin: 0; line-height: 1.5;">
                    Your computerized CNIC, live facial biometric photo, and trade credentials have been audited and verified by FixMate Compliance. You are entitled to automated customer job assignment and priority payouts.
                </p>
            </div>
        </div>
    @elseif($pro->verification_status === 'rejected')
        <div class="portal-card" style="padding: 22px 26px; background: #FFF1F2; border: 1.5px solid #F43F5E; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #E11D48; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">⚠️</div>
            <div>
                <h3 style="font-size: 16.5px; font-weight: 800; color: #9F1239; margin: 0 0 4px 0;">Action Required: Document Revision Needed</h3>
                <p style="font-size: 13.5px; color: #BE123C; margin: 0 0 8px 0; line-height: 1.5;">
                    <strong>Inspector Feedback:</strong> {{ $pro->rejection_reason ?: ($application?->rejection_reason ?: 'Some uploaded photos were blurry or incomplete. Please re-upload clear photos below.') }}
                </p>
                <span style="font-size: 12px; color: #881337;">Please update the flagged documents below and submit for re-inspection.</span>
            </div>
        </div>
    @elseif($pro->verification_status === 'under_review')
        <div class="portal-card" style="padding: 22px 26px; background: #EFF6FF; border: 1.5px solid #3B82F6; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #2563EB; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">⏳</div>
            <div>
                <h3 style="font-size: 16.5px; font-weight: 800; color: #1E40AF; margin: 0 0 4px 0;">Verification Dossier Under Active Audit</h3>
                <p style="font-size: 13.5px; color: #1D4ED8; margin: 0; line-height: 1.5;">
                    Your uploaded documents and live biometric photo are currently queued with the FixMate Compliance Desk. Review usually concludes within 4 to 12 hours. You will receive an instant notification on decision.
                </p>
            </div>
        </div>
    @else
        <div class="portal-card" style="padding: 22px 26px; background: #FFFDF0; border: 1.5px solid #F59E0B; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #D97706; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">📋</div>
            <div>
                <h3 style="font-size: 16.5px; font-weight: 800; color: #92400E; margin: 0 0 4px 0;">Complete Mandatory Verification to Accept Jobs</h3>
                <p style="font-size: 13.5px; color: #78350F; margin: 0; line-height: 1.5;">
                    FixMate enforces biometric facial matching and government CNIC verification for all field service technicians to ensure customer safety and fraud prevention. Complete your submission below to unlock immediate dispatch.
                </p>
            </div>
        </div>
    @endif

    <!-- Upload & Document Management Form -->
    <form action="{{ route('technician.verification.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Biometric Facial Verification Box -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-radius: 16px; margin-bottom: 24px; border: 2px solid {{ $pro->biometric_status === 'verified' ? '#10B981' : ($pro->biometric_status === 'submitted' ? '#3B82F6' : '#FFCC00') }};">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #FFF9E6; border: 1px solid #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        🤳
                    </div>
                    <div>
                        <strong style="font-size: 16px; color: #111; display: block;">Live Biometric Facial Verification</strong>
                        <span style="font-size: 12.5px; color: #666;">Hold your Computerized CNIC next to your face in a well-lit photo</span>
                    </div>
                </div>

                @if($pro->biometric_status === 'verified')
                    <span style="background: #ECFDF5; color: #047857; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                        ✓ Biometric Match Verified
                    </span>
                @elseif($pro->biometric_status === 'submitted')
                    <span style="background: #EFF6FF; color: #1D4ED8; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                        ⏳ Biometric Submitted (Under Review)
                    </span>
                @else
                    <span style="background: #FEF3C7; color: #92400E; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                        ● Action Required
                    </span>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: 240px 1fr; gap: 20px; align-items: center;" class="bio-grid">
                <!-- Preview / Current Photo -->
                <div style="text-align: center;">
                    @php
                        $bioUrl = $pro->getDocumentUrl($pro->biometric_selfie_path);
                    @endphp
                    <div style="width: 100%; height: 180px; border: 2px dashed #D1D5DB; border-radius: 12px; overflow: hidden; background: #F9FAFB; display: flex; align-items: center; justify-content: center; position: relative;">
                        @if($bioUrl)
                            <img id="bioPreviewImg" src="{{ $bioUrl }}" alt="Biometric Selfie" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div id="bioPlaceholder" style="padding: 16px; text-align: center; color: #9CA3AF;">
                                <span style="font-size: 32px; display: block; margin-bottom: 6px;">📸</span>
                                <span style="font-size: 12px; font-weight: 700;">No Biometric Selfie Uploaded</span>
                            </div>
                            <img id="bioPreviewImg" src="" alt="Biometric Selfie Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    @if($bioUrl)
                        <a href="{{ $bioUrl }}" target="_blank" style="font-size: 11.5px; color: #0284C7; font-weight: 700; display: inline-block; margin-top: 6px; text-decoration: underline;">
                            🔍 View Full Biometric Photo
                        </a>
                    @endif
                </div>

                <!-- Instructions & Upload Control -->
                <div>
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px; margin-bottom: 14px; font-size: 12.5px; color: #475569; line-height: 1.5;">
                        <strong style="color: #0F172A; display: block; margin-bottom: 4px;">Biometric Verification Guidelines:</strong>
                        <ul style="margin: 0; padding-left: 18px;">
                            <li>Ensure good lighting; do not wear dark sunglasses or face masks.</li>
                            <li>Hold your original physical CNIC card clearly beside your chin.</li>
                            <li>The CNIC number and your facial features must be distinctly visible.</li>
                        </ul>
                    </div>

                    <div>
                        <label style="display: inline-block; font-size: 12.5px; font-weight: 800; color: #111; margin-bottom: 6px;">
                            Upload / Re-take Biometric Selfie Photo (JPG, PNG max 5MB):
                        </label>
                        <input type="file" name="biometric_selfie" id="bioInput" accept="image/*" class="form-input" style="padding: 8px 12px; font-size: 12.5px;" onchange="previewFile(this, 'bioPreviewImg', 'bioPlaceholder')">
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Artifacts Grid (6 Key Verification Documents) -->
        <h3 style="font-size: 17px; font-weight: 900; color: #111; margin-bottom: 16px;">
            Required Government & Trade Credentials
        </h3>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px;" class="docs-grid">
            
            <!-- Document 1: CNIC Front -->
            @php $cnicFrontUrl = $pro->getDocumentUrl($pro->cnic_front_path); @endphp
            <div class="portal-card" style="padding: 18px; background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">1. CNIC Front Side</strong>
                        <span style="font-size: 11.5px; color: #666;">Showing name, photo & CNIC number</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $cnicFrontUrl ? '#ECFDF5' : '#FFFBEB' }}; color: {{ $cnicFrontUrl ? '#047857' : '#B45309' }};">
                        {{ $cnicFrontUrl ? '✓ Uploaded' : 'Missing' }}
                    </span>
                </div>

                <div style="height: 110px; background: #F9FAFB; border: 1px dashed #D1D5DB; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                    @if($cnicFrontUrl)
                        <img id="cnicFrontPreview" src="{{ $cnicFrontUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span id="cnicFrontHolder" style="font-size: 11.5px; color: #9CA3AF;">🪪 Upload CNIC Front Photo</span>
                        <img id="cnicFrontPreview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>

                @if($cnicFrontUrl)
                    <div style="margin-bottom: 6px;">
                        <a href="{{ $cnicFrontUrl }}" target="_blank" style="font-size: 11px; color: #0284C7; font-weight: 700; text-decoration: underline;">🔍 Inspect Uploaded CNIC Front</a>
                    </div>
                @endif

                <input type="file" name="cnic_front" accept="image/*,application/pdf" class="form-input" style="font-size: 11.5px; padding: 6px;" onchange="previewFile(this, 'cnicFrontPreview', 'cnicFrontHolder')">
            </div>

            <!-- Document 2: CNIC Back -->
            @php $cnicBackUrl = $pro->getDocumentUrl($pro->cnic_back_path); @endphp
            <div class="portal-card" style="padding: 18px; background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">2. CNIC Back Side</strong>
                        <span style="font-size: 11.5px; color: #666;">Showing permanent address & family number</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $cnicBackUrl ? '#ECFDF5' : '#FFFBEB' }}; color: {{ $cnicBackUrl ? '#047857' : '#B45309' }};">
                        {{ $cnicBackUrl ? '✓ Uploaded' : 'Missing' }}
                    </span>
                </div>

                <div style="height: 110px; background: #F9FAFB; border: 1px dashed #D1D5DB; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                    @if($cnicBackUrl)
                        <img id="cnicBackPreview" src="{{ $cnicBackUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span id="cnicBackHolder" style="font-size: 11.5px; color: #9CA3AF;">🪪 Upload CNIC Back Photo</span>
                        <img id="cnicBackPreview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>

                @if($cnicBackUrl)
                    <div style="margin-bottom: 6px;">
                        <a href="{{ $cnicBackUrl }}" target="_blank" style="font-size: 11px; color: #0284C7; font-weight: 700; text-decoration: underline;">🔍 Inspect Uploaded CNIC Back</a>
                    </div>
                @endif

                <input type="file" name="cnic_back" accept="image/*,application/pdf" class="form-input" style="font-size: 11.5px; padding: 6px;" onchange="previewFile(this, 'cnicBackPreview', 'cnicBackHolder')">
            </div>

            <!-- Document 3: Police Character Certificate -->
            @php $policeUrl = $pro->getDocumentUrl($pro->police_certificate_path); @endphp
            <div class="portal-card" style="padding: 18px; background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">3. Police Character Certificate</strong>
                        <span style="font-size: 11.5px; color: #666;">Criminal record clearance or police stamp</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $policeUrl ? '#ECFDF5' : '#FFFBEB' }}; color: {{ $policeUrl ? '#047857' : '#B45309' }};">
                        {{ $policeUrl ? '✓ Attached' : 'Optional / Recommended' }}
                    </span>
                </div>

                <div style="height: 110px; background: #F9FAFB; border: 1px dashed #D1D5DB; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                    @if($policeUrl)
                        <img id="policePreview" src="{{ $policeUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span id="policeHolder" style="font-size: 11.5px; color: #9CA3AF;">📜 Police Clearance (Image or PDF)</span>
                        <img id="policePreview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>

                @if($policeUrl)
                    <div style="margin-bottom: 6px;">
                        <a href="{{ $policeUrl }}" target="_blank" style="font-size: 11px; color: #0284C7; font-weight: 700; text-decoration: underline;">🔍 Inspect Police Certificate</a>
                    </div>
                @endif

                <input type="file" name="police_certificate" accept="image/*,application/pdf" class="form-input" style="font-size: 11.5px; padding: 6px;" onchange="previewFile(this, 'policePreview', 'policeHolder')">
            </div>

            <!-- Document 4: Trade License / Technical Diploma -->
            @php $tradeUrl = $pro->getDocumentUrl($pro->trade_license_path); @endphp
            <div class="portal-card" style="padding: 18px; background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">4. Trade License or Diploma</strong>
                        <span style="font-size: 11.5px; color: #666;">NAVTTC, TEVTA, City & Guilds, or Workshop Reg.</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $tradeUrl ? '#ECFDF5' : '#FFFBEB' }}; color: {{ $tradeUrl ? '#047857' : '#B45309' }};">
                        {{ $tradeUrl ? '✓ Attached' : 'Recommended' }}
                    </span>
                </div>

                <div style="height: 110px; background: #F9FAFB; border: 1px dashed #D1D5DB; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                    @if($tradeUrl)
                        <img id="tradePreview" src="{{ $tradeUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span id="tradeHolder" style="font-size: 11.5px; color: #9CA3AF;">🎓 Skill Certificate / Diploma</span>
                        <img id="tradePreview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>

                @if($tradeUrl)
                    <div style="margin-bottom: 6px;">
                        <a href="{{ $tradeUrl }}" target="_blank" style="font-size: 11px; color: #0284C7; font-weight: 700; text-decoration: underline;">🔍 Inspect Trade Certificate</a>
                    </div>
                @endif

                <input type="file" name="trade_license" accept="image/*,application/pdf" class="form-input" style="font-size: 11.5px; padding: 6px;" onchange="previewFile(this, 'tradePreview', 'tradeHolder')">
            </div>

            <!-- Document 5: Proof of Address / Utility Bill -->
            @php $addrUrl = $pro->getDocumentUrl($pro->proof_of_address_path); @endphp
            <div class="portal-card" style="padding: 18px; background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">5. Proof of Address / Utility Bill</strong>
                        <span style="font-size: 11.5px; color: #666;">Electricity, Gas or PTCL bill matching area</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $addrUrl ? '#ECFDF5' : '#FFFBEB' }}; color: {{ $addrUrl ? '#047857' : '#B45309' }};">
                        {{ $addrUrl ? '✓ Attached' : 'Recommended' }}
                    </span>
                </div>

                <div style="height: 110px; background: #F9FAFB; border: 1px dashed #D1D5DB; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                    @if($addrUrl)
                        <img id="addrPreview" src="{{ $addrUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span id="addrHolder" style="font-size: 11.5px; color: #9CA3AF;">⚡ Electricity / Gas Bill</span>
                        <img id="addrPreview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>

                @if($addrUrl)
                    <div style="margin-bottom: 6px;">
                        <a href="{{ $addrUrl }}" target="_blank" style="font-size: 11px; color: #0284C7; font-weight: 700; text-decoration: underline;">🔍 Inspect Address Proof</a>
                    </div>
                @endif

                <input type="file" name="proof_of_address" accept="image/*,application/pdf" class="form-input" style="font-size: 11.5px; padding: 6px;" onchange="previewFile(this, 'addrPreview', 'addrHolder')">
            </div>

            <!-- Verification Metadata Summary Card -->
            <div class="portal-card" style="padding: 18px; background: #F8FAFC; border-radius: 12px; border: 1px solid #E2E8F0; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <strong style="font-size: 14px; color: #0F172A; display: block; margin-bottom: 8px;">Compliance Safety Score</strong>
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12.5px; color: #475569;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>National CNIC Verification:</span>
                            <strong style="color: {{ $user->cnic_number ? '#047857' : '#DC2626' }};">{{ $user->cnic_number ? 'Recorded' : 'Pending' }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Biometric Facial Match:</span>
                            <strong style="color: {{ $pro->biometric_status === 'verified' ? '#047857' : '#D97706' }};">{{ ucfirst($pro->biometric_status) }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Trade Specialty:</span>
                            <strong>{{ $pro->profession?->name ?? 'General Specialist' }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Account Level:</span>
                            <strong style="color: #D97706;">FixMate Partner Tier 1</strong>
                        </div>
                    </div>
                </div>

                <div style="padding-top: 12px; border-top: 1px solid #CBD5E1; font-size: 11.5px; color: #64748B;">
                    🔒 All documents encrypted & stored under Pakistan Digital Data Privacy Standards.
                </div>
            </div>

        </div>

        <!-- Personal & Emergency Contact Records -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-radius: 14px; margin-bottom: 24px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">
                Legal Information & Emergency Contact
            </h3>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 16px;" class="info-grid">
                <div>
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">
                        Government CNIC Number (13 Digits) *
                    </label>
                    <input type="text" name="cnic_number" value="{{ old('cnic_number', $pro->cnic_number ?: ($user->cnic_number ?: '42101-1234567-1')) }}" required class="form-input" style="padding: 9px 12px; font-size: 13px;" placeholder="42101-*******-1">
                </div>

                <div>
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">
                        Operational City / Territory *
                    </label>
                    <input type="text" name="city" value="{{ old('city', $user->city ?? 'Karachi') }}" required class="form-input" style="padding: 9px 12px; font-size: 13px;" placeholder="Karachi, Lahore, etc.">
                </div>

                <div>
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">
                        Emergency Contact Person Name
                    </label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $pro->emergency_contact_name ?? '') }}" class="form-input" style="padding: 9px 12px; font-size: 13px;" placeholder="e.g. Brother, Father, Spouse">
                </div>

                <div>
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">
                        Emergency Contact Phone Number
                    </label>
                    <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $pro->emergency_contact_phone ?? '') }}" class="form-input" style="padding: 9px 12px; font-size: 13px;" placeholder="0300-1234567">
                </div>

                <div>
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">
                        Total Practical Trade Experience
                    </label>
                    <input type="text" name="experience" value="{{ old('experience', $pro->experience ?: ($user->experience ?: '5 Years')) }}" class="form-input" style="padding: 9px 12px; font-size: 13px;" placeholder="e.g. 5+ Years">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 14px; border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn-yellow" style="padding: 12px 28px; font-size: 14px; font-weight: 900; border: none; cursor: pointer; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px;">
                    <span>🛡️</span>
                    <span>Submit Documents & Biometrics for Audit</span>
                </button>
            </div>
        </div>

    </form>

</div>
@endsection

@section('extra_js')
<script>
    function previewFile(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(previewId);
                    if (img) {
                        img.src = e.target.result;
                        img.style.display = 'block';
                    }
                    const holder = document.getElementById(placeholderId);
                    if (holder) {
                        holder.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                const holder = document.getElementById(placeholderId);
                if (holder) {
                    holder.innerHTML = '📄 PDF File Selected: ' + file.name;
                    holder.style.display = 'block';
                    holder.style.color = '#0284C7';
                }
                const img = document.getElementById(previewId);
                if (img) {
                    img.style.display = 'none';
                }
            }
        }
    }
</script>
<style>
    @media (max-width: 768px) {
        .bio-grid {
            grid-template-columns: 1fr !important;
        }
        .docs-grid {
            grid-template-columns: 1fr !important;
        }
        .info-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
