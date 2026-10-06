@extends('Frontend.layouts.admin')

@section('title', 'KYC Verifications — FixMate Admin')

@section('content')

<!-- Page Heading & Actions -->
<div class="adm-page-head">
    <div>
        <h1>KYC Verification Pipeline</h1>
        <p>Review technician CNIC identity documents, trade diplomas, tool inventories, and background police clearances.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge dark" style="padding: 7px 14px; font-size: 13px;">
            {{ $stats['pending'] }} applications pending review
        </span>
    </div>
</div>

<!-- Flash Notifications -->
@if(session('success'))
    <div style="background: #F0FDF4; border: 1.5px solid #86EFAC; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; font-weight: 600;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">✓</span>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #166534;">&times;</button>
    </div>
@endif

@if($errors->any())
    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-size: 13px;">
        <strong style="display: block; margin-bottom: 6px;">Please fix the following:</strong>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Summary KPIs -->
<div class="adm-kpi-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 24px;">
    
    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Pending Review</span>
            <span class="kpi-icon" style="background: #FEF3C7; color: #D97706;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: #D97706;">{{ $stats['pending'] }}</div>
        <div class="kpi-foot up">Requires trade assessment</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Under Inspection</span>
            <span class="kpi-icon" style="background: #EFF6FF; color: var(--adm-info);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-info);">{{ $stats['under_review'] }}</div>
        <div class="kpi-foot">NADRA / Tool verification</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Verified Partners</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft); color: var(--adm-success);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-success);">{{ $stats['approved'] }}</div>
        <div class="kpi-foot up">Active on dispatch radar</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Total Applications</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft); color: #B45309;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </span>
        </div>
        <div class="kpi-val">{{ $stats['total'] }}</div>
        <div class="kpi-foot">Lifetime partner leads</div>
    </div>

</div>

<!-- Filter Bar -->
<div class="adm-card" style="padding: 16px 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.technicians.verification') }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 220px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidate name, CNIC, phone, or ref #..." class="adm-input" style="padding-left: 38px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="position: absolute; left: 13px; top: 13px; color: var(--adm-faint);">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>

        <div style="width: 200px;">
            <select name="profession_id" class="adm-select" onchange="this.form.submit()">
                <option value="">All Trade Specialties</option>
                @foreach($professions as $prof)
                    <option value="{{ $prof->id }}" {{ request('profession_id') == $prof->id ? 'selected' : '' }}>
                        {{ $prof->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="width: 170px;">
            <select name="status" class="adm-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <button type="submit" class="adm-btn adm-btn-primary" style="height: 42px;">Filter</button>

        @if(request()->hasAny(['search', 'profession_id', 'status']))
            <a href="{{ route('admin.technicians.verification') }}" class="adm-btn" style="height: 42px; text-decoration: none; color: var(--adm-muted); background: #F1F5F9;">
                Reset
            </a>
        @endif

    </form>
</div>

<!-- Table -->
<div class="adm-card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
    
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <strong style="font-size: 15px; color: var(--adm-ink);">Technician Applicant Roster</strong>
            <span style="font-size: 12px; font-weight: 600; color: var(--adm-muted);">({{ $applications->total() }} total)</span>
        </div>
        <span style="font-size: 12px; color: var(--adm-muted);">100% of technicians undergo NADRA biometric validation before active deployment</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="adm-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid var(--adm-border); font-size: 12px; color: var(--adm-muted); text-transform: uppercase; letter-spacing: 0.04em;">
                    <th style="padding: 12px 20px;">Technician Candidate</th>
                    <th style="padding: 12px 20px;">Trade / Skill</th>
                    <th style="padding: 12px 20px;">CNIC Number</th>
                    <th style="padding: 12px 20px;">Credentials</th>
                    <th style="padding: 12px 20px;">Status</th>
                    <th style="padding: 12px 20px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    @php
                        $badge = $app->status_badge;
                        $docs = array_filter(array_map('trim', explode(',', $app->documents_list)));
                    @endphp
                    <tr style="border-bottom: 1px solid var(--adm-border-soft); transition: background 0.15s ease;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                        
                        <!-- Technician Info -->
                        <td style="padding: 16px 20px;">
                            <div class="adm-person">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: #0F172A; color: #FFB800; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; border: 2px solid var(--adm-accent);">
                                    {{ strtoupper(substr($app->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="pname" style="font-weight: 700; font-size: 14px; color: var(--adm-ink);">{{ $app->name }}</div>
                                    <div class="pmeta" style="font-size: 12px; color: var(--adm-muted);">
                                        {{ $app->city }} &middot; {{ $app->phone }} &middot; <span style="font-family: monospace;">#{{ $app->reference_no }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Trade / Skill -->
                        <td style="padding: 16px 20px;">
                            <div style="font-weight: 700; font-size: 13.5px; color: var(--adm-ink);">
                                {{ $app->profession?->name ?? 'General Specialist' }}
                            </div>
                            <div style="font-size: 12px; color: var(--adm-muted);">
                                {{ $app->experience_years }} years exp &middot; {{ ucwords(str_replace('_', ' ', $app->workshop_type)) }}
                            </div>
                        </td>

                        <!-- CNIC Number -->
                        <td style="padding: 16px 20px;">
                            <strong style="font-family: ui-monospace, monospace; font-size: 13px; color: #0F172A; background: #F1F5F9; padding: 4px 8px; border-radius: 6px; letter-spacing: 0.04em;">
                                {{ $app->cnic_number }}
                            </strong>
                        </td>

                        <!-- Documents Attached -->
                        <td style="padding: 16px 20px;">
                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                @forelse($docs as $doc)
                                    <span class="adm-badge grey" style="font-size: 11px; padding: 2px 7px; background: #F1F5F9; border-radius: 4px; color: #475569;">{{ $doc }}</span>
                                @empty
                                    <span style="font-size: 12px; color: #94A3B8;">None specified</span>
                                @endforelse
                            </div>
                        </td>

                        <!-- Status -->
                        <td style="padding: 16px 20px;">
                            <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 20px; white-space: nowrap; display: inline-block;">
                                {{ $badge['label'] }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td style="padding: 16px 20px; text-align: right;">
                            <div style="display: inline-flex; gap: 6px;">
                                @if($app->status === 'approved')
                                    <button type="button" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 12px; height: 32px;" onclick='openDossierModal(@json($app), @json($app->profession?->name))'>
                                        View Dossier
                                    </button>
                                @elseif($app->status === 'rejected')
                                    <button type="button" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 12px; height: 32px; color: var(--adm-muted);" onclick='openDossierModal(@json($app), @json($app->profession?->name))'>
                                        Reason
                                    </button>
                                @else
                                    <button type="button" class="adm-btn adm-btn-primary adm-btn-sm" style="font-size: 12px; height: 32px; padding: 0 12px;" onclick="openApproveModal({{ $app->id }}, '{{ addslashes($app->name) }}')">
                                        Approve
                                    </button>
                                    <button type="button" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 12px; height: 32px; color: var(--adm-danger); border-color: #FECDD3;" onclick="openRejectModal({{ $app->id }}, '{{ addslashes($app->name) }}')">
                                        Reject
                                    </button>
                                @endif
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 50px 20px; text-align: center; color: var(--adm-muted);">
                            No technician applications found matching current criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($applications->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--adm-border); display: flex; justify-content: flex-end;">
            {{ $applications->links() }}
        </div>
    @endif

</div>

<!-- Modal: Approve Partner -->
<div id="approveModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 480px; padding: 24px; text-align: center;">
        <div style="width: 50px; height: 50px; background: #ECFDF5; border-radius: 50%; color: #047857; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 24px;">✓</div>
        <strong style="font-size: 18px; color: var(--adm-ink); display: block; margin-bottom: 6px;">Approve Technician Partner?</strong>
        <p id="approveApplicantName" style="font-size: 13.5px; color: var(--adm-muted); margin: 0 0 16px 0;"></p>
        
        <form id="approveForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="text-align: left; margin-bottom: 18px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: var(--adm-ink); margin-bottom: 4px;">Inspector Verification Note</label>
                <input type="text" name="admin_notes" value="NADRA biometric & practical assessment verified." class="adm-input" required>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border);" onclick="closeApproveModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary">Confirm &amp; Activate Partner</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reject Application -->
<div id="rejectModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 480px; padding: 24px; text-align: center;">
        <div style="width: 50px; height: 50px; background: #FFF1F2; border-radius: 50%; color: var(--adm-danger); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 22px;">✕</div>
        <strong style="font-size: 18px; color: var(--adm-ink); display: block; margin-bottom: 6px;">Reject Partner Application</strong>
        <p id="rejectApplicantName" style="font-size: 13px; color: var(--adm-muted); margin: 0 0 16px 0;"></p>
        
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="text-align: left; margin-bottom: 18px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: var(--adm-ink); margin-bottom: 4px;">Rejection Justification <span style="color: var(--adm-danger);">*</span></label>
                <textarea name="reason" rows="3" class="adm-input" placeholder="e.g. Could not provide valid NADRA CNIC or failed practical wiring assessment..." required style="height: auto; resize: vertical; padding: 10px;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border);" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="adm-btn" style="background: var(--adm-danger); color: #FFF; border: none;">Record Rejection</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: View Dossier -->
<div id="dossierModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 640px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
        <div style="padding: 18px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between; background: #F8FAFC; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 20px;">📋</span>
                <strong style="font-size: 16px; color: var(--adm-ink);" id="dossierRef">Technician Dossier & Biometrics</strong>
            </div>
            <button type="button" onclick="closeDossierModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>
        <div style="padding: 24px; display: flex; flex-direction: column; gap: 16px; font-size: 13.5px;" id="dossierContent">
            <!-- Populated via JS -->
        </div>
        <div style="padding: 14px 24px; background: #F8FAFC; border-top: 1px solid var(--adm-border); display: flex; justify-content: flex-end; position: sticky; bottom: 0;">
            <button type="button" class="adm-btn adm-btn-primary" onclick="closeDossierModal()">Close Dossier</button>
        </div>
    </div>
</div>

@endsection

@section('extra_js')
<script>
    function getDocUrl(path) {
        if (!path) return null;
        if (path.startsWith('http://') || path.startsWith('https://')) return path;
        return "{{ asset('storage') }}/" + path.replace(/^\//, '');
    }

    function openApproveModal(id, name) {
        document.getElementById('approveForm').action = "{{ url('/admin/technicians/verification') }}/" + id + "/approve";
        document.getElementById('approveApplicantName').textContent = "Confirm verification for candidate: " + name;
        document.getElementById('approveModal').style.display = 'flex';
    }

    function closeApproveModal() {
        document.getElementById('approveModal').style.display = 'none';
    }

    function openRejectModal(id, name) {
        document.getElementById('rejectForm').action = "{{ url('/admin/technicians/verification') }}/" + id + "/reject";
        document.getElementById('rejectApplicantName').textContent = "Recording rejection for candidate: " + name;
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function openDossierModal(app, tradeName) {
        document.getElementById('dossierRef').textContent = "Dossier: #" + app.reference_no;
        var bioUrl = getDocUrl(app.biometric_selfie_path);
        var cnicFrontUrl = getDocUrl(app.cnic_front_path);
        var cnicBackUrl = getDocUrl(app.cnic_back_path);
        var policeUrl = getDocUrl(app.police_certificate_path);
        var tradeUrl = getDocUrl(app.trade_license_path);
        var addrUrl = getDocUrl(app.proof_of_address_path);

        var html = `
            <!-- Biometric Card -->
            <div style="display: grid; grid-template-columns: 140px 1fr; gap: 16px; background: #F8FAFC; padding: 14px; border-radius: 12px; border: 1.5px solid #E2E8F0; align-items: center;">
                <div>
                    ${bioUrl ? `<img src="${bioUrl}" style="width: 100%; height: 130px; object-fit: cover; border-radius: 8px; border: 2px solid #FFCC00;">` : `<div style="height: 110px; display: flex; align-items: center; justify-content: center; background: #FFF; border: 1px dashed #CBD5E1; border-radius: 8px; font-size: 11px; color: #94A3B8; text-align: center; padding: 8px;">No Biometric Selfie Uploaded</div>`}
                </div>
                <div style="font-size: 13px;">
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                        <span style="font-size: 16px;">🤳</span>
                        <strong style="color: #0F172A;">Biometric Facial Verification Photo</strong>
                    </div>
                    <p style="font-size: 12px; color: #64748B; margin: 0 0 8px 0; line-height: 1.4;">Live selfie holding physical CNIC card for automated and manual facial comparison.</p>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="background: ${app.biometric_status === 'verified' ? '#ECFDF5' : '#FFFBEB'}; color: ${app.biometric_status === 'verified' ? '#047857' : '#B45309'}; font-weight: 800; font-size: 11px; padding: 2px 8px; border-radius: 6px;">
                            ${(app.biometric_status || 'Pending').toUpperCase()}
                        </span>
                        ${bioUrl ? `<a href="${bioUrl}" target="_blank" style="font-size: 12px; color: #0284C7; text-decoration: underline; font-weight: 700;">Inspect Full Image &rarr;</a>` : ''}
                    </div>
                </div>
            </div>

            <!-- Candidate Details -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px;">
                <div><strong>Full Name:</strong> ${app.name}</div>
                <div><strong>CNIC No:</strong> <span style="font-family: monospace; font-weight: 700;">${app.cnic_number}</span></div>
                <div><strong>Phone:</strong> ${app.phone}</div>
                <div><strong>Email:</strong> ${app.email || 'N/A'}</div>
                <div><strong>City:</strong> ${app.city}</div>
                <div><strong>Trade:</strong> ${tradeName || 'General'} (${app.experience_years || 1} yrs exp)</div>
                <div><strong>Emergency Contact:</strong> ${app.emergency_contact_name || 'Not provided'}</div>
                <div><strong>Emergency Phone:</strong> ${app.emergency_contact_phone || 'Not provided'}</div>
            </div>

            <!-- Uploaded Document Links -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px;">
                <strong style="font-size: 13px; color: #0F172A; display: block; margin-bottom: 10px;">Submitted Document Artifacts</strong>
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12.5px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E2E8F0; padding-bottom: 6px;">
                        <span>1. CNIC Front Side:</span>
                        ${cnicFrontUrl ? `<a href="${cnicFrontUrl}" target="_blank" style="color: #0284C7; font-weight: 700; text-decoration: underline;">✓ View CNIC Front</a>` : `<span style="color: #94A3B8;">Not uploaded</span>`}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E2E8F0; padding-bottom: 6px;">
                        <span>2. CNIC Back Side:</span>
                        ${cnicBackUrl ? `<a href="${cnicBackUrl}" target="_blank" style="color: #0284C7; font-weight: 700; text-decoration: underline;">✓ View CNIC Back</a>` : `<span style="color: #94A3B8;">Not uploaded</span>`}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E2E8F0; padding-bottom: 6px;">
                        <span>3. Police Character Certificate:</span>
                        ${policeUrl ? `<a href="${policeUrl}" target="_blank" style="color: #0284C7; font-weight: 700; text-decoration: underline;">✓ View Police Certificate</a>` : `<span style="color: #94A3B8;">Not uploaded</span>`}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E2E8F0; padding-bottom: 6px;">
                        <span>4. Trade License / Diploma:</span>
                        ${tradeUrl ? `<a href="${tradeUrl}" target="_blank" style="color: #0284C7; font-weight: 700; text-decoration: underline;">✓ View Trade Certificate</a>` : `<span style="color: #94A3B8;">Not uploaded</span>`}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>5. Proof of Address / Bill:</span>
                        ${addrUrl ? `<a href="${addrUrl}" target="_blank" style="color: #0284C7; font-weight: 700; text-decoration: underline;">✓ View Utility Bill</a>` : `<span style="color: #94A3B8;">Not uploaded</span>`}
                    </div>
                </div>
            </div>

            <!-- Status & Notes -->
            <div>
                <strong>Current Compliance Status:</strong> 
                <span style="font-weight: 800; text-transform: uppercase;">${app.status}</span>
            </div>
            ${app.admin_notes || app.rejection_reason ? `<div style="background: #FFFBEB; padding: 12px; border-radius: 8px; border: 1px solid #FDE68A; font-size: 12.5px; color: #92400E;"><strong>Notes / Rejection Reason:</strong><br>${app.rejection_reason || app.admin_notes}</div>` : ''}
        `;
        document.getElementById('dossierContent').innerHTML = html;
        document.getElementById('dossierModal').style.display = 'flex';
    }

    function closeDossierModal() {
        document.getElementById('dossierModal').style.display = 'none';
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApproveModal();
            closeRejectModal();
            closeDossierModal();
        }
    });
</script>
@endsection
