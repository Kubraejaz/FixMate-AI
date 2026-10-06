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
<div class="adm-kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 24px;">
    
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
            <span class="kpi-label">Returned for Revision</span>
            <span class="kpi-icon" style="background: #FFF7ED; color: #C2410C;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 14 4 9 9 4"></polyline>
                    <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: #C2410C;">{{ $stats['returned'] ?? 0 }}</div>
        <div class="kpi-foot">Pending technician fixes</div>
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

        <div style="width: 190px;">
            <select name="status" class="adm-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned for Revision</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected &amp; Blocked</option>
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
    
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <strong style="font-size: 15px; color: var(--adm-ink);">Technician Applicant Roster</strong>
            <span style="font-size: 12px; font-weight: 600; color: var(--adm-muted);">({{ $applications->total() }} total)</span>
        </div>
        <span style="font-size: 12px; color: var(--adm-muted);">View all candidate submissions with 3 instant decisions: Return, Approve, or Reject &amp; Block</span>
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
                    <th style="padding: 12px 20px; text-align: right;">Actions</th>
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
                                {{ $app->experience_years }} years exp &middot; {{ ucwords(str_replace('_', ' ', $app->workshop_type ?? 'Freelance')) }}
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
                                    <span style="font-size: 12px; color: #94A3B8;">CNIC &amp; Biometrics</span>
                                @endforelse
                            </div>
                        </td>

                        <!-- Status -->
                        <td style="padding: 16px 20px;">
                            <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 20px; white-space: nowrap; display: inline-block;">
                                {{ $badge['label'] }}
                            </span>
                        </td>

                        <!-- Actions: View Details + 3 Action Buttons -->
                        <td style="padding: 16px 20px; text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 6px; flex-wrap: nowrap;">
                                
                                <!-- Primary View Details Button -->
                                <button type="button" class="adm-btn adm-btn-primary adm-btn-sm" style="font-size: 12px; height: 32px; padding: 0 11px; display: inline-flex; align-items: center; gap: 5px; font-weight: 700;" onclick='openDossierModal(@json($app), @json($app->profession?->name))'>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    View Details
                                </button>

                                <!-- 1. Return Button -->
                                <button type="button" class="adm-btn adm-btn-sm" style="font-size: 12px; height: 32px; padding: 0 10px; background: #FFF7ED; color: #C2410C; border: 1.5px solid #FDBA74; font-weight: 700;" title="Return to technician for revision" onclick="openReturnModal({{ $app->id }}, '{{ addslashes($app->name) }}')">
                                    ↩ Return
                                </button>

                                <!-- 2. Approve Button -->
                                <button type="button" class="adm-btn adm-btn-sm" style="font-size: 12px; height: 32px; padding: 0 10px; background: #ECFDF5; color: #047857; border: 1.5px solid #86EFAC; font-weight: 700;" title="Approve partner" onclick="openApproveModal({{ $app->id }}, '{{ addslashes($app->name) }}')">
                                    ✓ Approve
                                </button>

                                <!-- 3. Reject Button -->
                                <button type="button" class="adm-btn adm-btn-sm" style="font-size: 12px; height: 32px; padding: 0 10px; background: #FFF1F2; color: #BE123C; border: 1.5px solid #FECDD3; font-weight: 700;" title="Reject and block profile" onclick="openRejectModal({{ $app->id }}, '{{ addslashes($app->name) }}')">
                                    ✕ Reject
                                </button>

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

<!-- Modal 1: Approve Partner -->
<div id="approveModal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 480px; padding: 26px; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.25);">
        <div style="width: 52px; height: 52px; background: #ECFDF5; border-radius: 50%; color: #047857; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 26px;">✓</div>
        <strong style="font-size: 19px; color: var(--adm-ink); display: block; margin-bottom: 6px;">Approve Technician Partner?</strong>
        <p id="approveApplicantName" style="font-size: 13.5px; color: var(--adm-muted); margin: 0 0 18px 0;"></p>
        
        <form id="approveForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="text-align: left; margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Inspector Verification Note</label>
                <input type="text" name="admin_notes" value="NADRA biometric & practical assessment verified." class="adm-input" required>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border);" onclick="closeApproveModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary" style="background: #047857; border-color: #047857; color: #FFF; font-weight: 800;">✓ Confirm &amp; Approve Partner</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Return for Revision -->
<div id="returnModal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 520px; padding: 26px; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.25);">
        <div style="width: 52px; height: 52px; background: #FFF7ED; border-radius: 50%; color: #C2410C; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 24px;">↩</div>
        <strong style="font-size: 19px; color: var(--adm-ink); display: block; margin-bottom: 6px;">Return Application to Technician?</strong>
        <p id="returnApplicantName" style="font-size: 13px; color: var(--adm-muted); margin: 0 0 16px 0;">The application will be sent back to the technician. Their profile remains active so they can update their submitted information/documents and resubmit.</p>
        
        <form id="returnForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="text-align: left; margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Revision Instructions for Technician <span style="color: #C2410C;">*</span></label>
                <textarea name="reason" rows="3" class="adm-input" placeholder="e.g. CNIC photo is blurry. Please re-upload clear photos of front and back of your CNIC, and update your emergency contact..." required style="height: auto; resize: vertical; padding: 10px;"></textarea>
                <span style="display: block; font-size: 11.5px; color: var(--adm-muted); margin-top: 4px;">The technician will see this feedback in their portal along with an edit &amp; resubmit form.</span>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border);" onclick="closeReturnModal()">Cancel</button>
                <button type="submit" class="adm-btn" style="background: #C2410C; color: #FFF; border: none; font-weight: 800;">↩ Return to Technician</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Reject Application & Block Profile -->
<div id="rejectModal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 520px; padding: 26px; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.25);">
        <div style="width: 52px; height: 52px; background: #FFF1F2; border-radius: 50%; color: var(--adm-danger); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 24px;">🚫</div>
        <strong style="font-size: 19px; color: var(--adm-danger); display: block; margin-bottom: 6px;">Reject Application &amp; Block Profile?</strong>
        <p id="rejectApplicantName" style="font-size: 13px; color: var(--adm-muted); margin: 0 0 16px 0;">This will reject the candidate and <strong>BLOCK</strong> their technician profile. The technician will be shown an alert instructing them to contact the FixMate team.</p>
        
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="text-align: left; margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Rejection &amp; Blocking Justification <span style="color: var(--adm-danger);">*</span></label>
                <textarea name="reason" rows="3" class="adm-input" placeholder="e.g. Failed background criminal check or fake CNIC credentials submitted..." required style="height: auto; resize: vertical; padding: 10px;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border);" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="adm-btn" style="background: var(--adm-danger); color: #FFF; border: none; font-weight: 800;">🚫 Reject &amp; Block Profile</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 4: View Complete Submission Dossier with 3 Action Buttons -->
<div id="dossierModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 780px; max-height: 92vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35);">
        
        <!-- Modal Top Bar -->
        <div style="padding: 18px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between; background: #F8FAFC; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 22px;">📋</span>
                <div>
                    <strong style="font-size: 16.5px; color: var(--adm-ink); display: block;" id="dossierRef">Technician Application Dossier</strong>
                    <span style="font-size: 12px; color: var(--adm-muted);" id="dossierCandidateSub">Submitted verification credentials &amp; document portfolio</span>
                </div>
            </div>
            <button type="button" onclick="closeDossierModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>

        <!-- Modal Body: Populated dynamically via openDossierModal -->
        <div style="padding: 24px; display: flex; flex-direction: column; gap: 20px; font-size: 13.5px;" id="dossierContent">
            <!-- Populated via JS -->
        </div>

        <!-- Modal Footer: Three Action Buttons (Return, Approve, Reject) + Close -->
        <div style="padding: 16px 24px; background: #F8FAFC; border-top: 1px solid var(--adm-border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; position: sticky; bottom: 0; z-index: 10;">
            <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border);" onclick="closeDossierModal()">
                Close
            </button>
            <div style="display: flex; align-items: center; gap: 8px;">
                <!-- 1. Return Button -->
                <button type="button" id="dossierReturnBtn" class="adm-btn" style="background: #FFF7ED; color: #C2410C; border: 1.5px solid #FDBA74; font-weight: 800; font-size: 13px;">
                    ↩ Return for Revision
                </button>
                <!-- 2. Approve Button -->
                <button type="button" id="dossierApproveBtn" class="adm-btn" style="background: #047857; color: #FFFFFF; border: none; font-weight: 800; font-size: 13px;">
                    ✓ Approve Partner
                </button>
                <!-- 3. Reject Button -->
                <button type="button" id="dossierRejectBtn" class="adm-btn" style="background: var(--adm-danger); color: #FFFFFF; border: none; font-weight: 800; font-size: 13px;">
                    🚫 Reject &amp; Block Profile
                </button>
            </div>
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
        document.getElementById('approveApplicantName').textContent = "Confirm verification & activation for technician: " + name;
        document.getElementById('approveModal').style.display = 'flex';
    }

    function closeApproveModal() {
        document.getElementById('approveModal').style.display = 'none';
    }

    function openReturnModal(id, name) {
        document.getElementById('returnForm').action = "{{ url('/admin/technicians/verification') }}/" + id + "/return";
        document.getElementById('returnApplicantName').textContent = "Return dossier to technician: " + name + ". They will be alerted to fix flagged documents and resubmit.";
        document.getElementById('returnModal').style.display = 'flex';
    }

    function closeReturnModal() {
        document.getElementById('returnForm').style.display = 'none';
        document.getElementById('returnModal').style.display = 'none';
    }

    function openRejectModal(id, name) {
        document.getElementById('rejectForm').action = "{{ url('/admin/technicians/verification') }}/" + id + "/reject";
        document.getElementById('rejectApplicantName').innerHTML = "Rejecting candidate: <strong>" + name + "</strong>. Their profile will be blocked and they will see an alert to contact the FixMate team.";
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function openDossierModal(app, tradeName) {
        document.getElementById('dossierRef').textContent = "Application: #" + app.reference_no + " (" + app.name + ")";
        document.getElementById('dossierCandidateSub').textContent = (tradeName || 'Specialist') + " &bull; " + (app.city || 'Pakistan') + " &bull; Submitted: " + (app.created_at ? new Date(app.created_at).toLocaleDateString() : 'Recent');

        // Bind the 3 bottom actions to this candidate
        document.getElementById('dossierReturnBtn').onclick = function() {
            closeDossierModal();
            openReturnModal(app.id, app.name);
        };
        document.getElementById('dossierApproveBtn').onclick = function() {
            closeDossierModal();
            openApproveModal(app.id, app.name);
        };
        document.getElementById('dossierRejectBtn').onclick = function() {
            closeDossierModal();
            openRejectModal(app.id, app.name);
        };

        var bioUrl = getDocUrl(app.biometric_selfie_path);
        var cnicFrontUrl = getDocUrl(app.cnic_front_path);
        var cnicBackUrl = getDocUrl(app.cnic_back_path);
        var policeUrl = getDocUrl(app.police_certificate_path);
        var tradeUrl = getDocUrl(app.trade_license_path);
        var addrUrl = getDocUrl(app.proof_of_address_path);

        var statusBg = '#FFFBEB';
        var statusColor = '#B45309';
        var statusLabel = 'Pending Review';

        if (app.status === 'approved') {
            statusBg = '#ECFDF5'; statusColor = '#047857'; statusLabel = 'Approved & Verified';
        } else if (app.status === 'rejected') {
            statusBg = '#FFF1F2'; statusColor = '#BE123C'; statusLabel = 'Rejected & Blocked';
        } else if (app.status === 'returned') {
            statusBg = '#FFF7ED'; statusColor = '#C2410C'; statusLabel = 'Returned for Revision';
        } else if (app.status === 'under_review') {
            statusBg = '#EFF6FF'; statusColor = '#1D4ED8'; statusLabel = 'Under Review';
        }

        var html = `
            <!-- Top Status Bar in Dossier -->
            <div style="display: flex; justify-content: space-between; align-items: center; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 12px 16px; border-radius: 12px;">
                <div>
                    <span style="font-size: 11.5px; color: #64748B; text-transform: uppercase; font-weight: 700;">Current Compliance Status</span>
                    <div style="font-weight: 900; font-size: 14px; color: #0F172A; text-transform: uppercase;">${app.status || 'pending'}</div>
                </div>
                <span style="background: ${statusBg}; color: ${statusColor}; font-weight: 800; font-size: 12px; padding: 5px 14px; border-radius: 20px;">
                    ${statusLabel}
                </span>
            </div>

            <!-- Biometric Facial Verification Banner -->
            <div style="display: grid; grid-template-columns: 140px 1fr; gap: 16px; background: #FFFDF0; padding: 16px; border-radius: 12px; border: 1.5px solid #FFCC00; align-items: center;">
                <div>
                    ${bioUrl ? `<a href="${bioUrl}" target="_blank" title="Inspect full image"><img src="${bioUrl}" style="width: 100%; height: 130px; object-fit: cover; border-radius: 8px; border: 2px solid #FFCC00;"></a>` : `<div style="height: 110px; display: flex; align-items: center; justify-content: center; background: #FFF; border: 1px dashed #CBD5E1; border-radius: 8px; font-size: 11px; color: #94A3B8; text-align: center; padding: 8px;">No Biometric Selfie Uploaded</div>`}
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                        <span style="font-size: 18px;">🤳</span>
                        <strong style="color: #0F172A; font-size: 14.5px;">Biometric Facial Verification Selfie</strong>
                    </div>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0 0 8px 0; line-height: 1.4;">Live selfie photograph holding original physical CNIC next to face for facial matching &amp; impersonation prevention.</p>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="background: ${app.biometric_status === 'verified' ? '#ECFDF5' : '#FFFBEB'}; color: ${app.biometric_status === 'verified' ? '#047857' : '#B45309'}; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 6px;">
                            ${(app.biometric_status || 'Pending').toUpperCase()}
                        </span>
                        ${bioUrl ? `<a href="${bioUrl}" target="_blank" style="font-size: 12px; color: #0284C7; text-decoration: underline; font-weight: 700;">🔍 View Full Biometric Photo &rarr;</a>` : ''}
                    </div>
                </div>
            </div>

            <!-- Complete Candidate Details Grid -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px;">
                <strong style="font-size: 13.5px; color: #0F172A; display: block; margin-bottom: 12px; border-bottom: 1px solid #F1F5F9; padding-bottom: 8px;">Technician Personal &amp; Professional Profile</strong>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                    <div><span style="color: #64748B;">Full Name:</span> <strong style="color: #0F172A; display: block;">${app.name}</strong></div>
                    <div><span style="color: #64748B;">CNIC Number:</span> <strong style="font-family: monospace; color: #0F172A; display: block; font-size: 14px;">${app.cnic_number}</strong></div>
                    <div><span style="color: #64748B;">Primary Phone:</span> <strong style="color: #0F172A; display: block;">${app.phone}</strong></div>
                    <div><span style="color: #64748B;">Email Address:</span> <strong style="color: #0F172A; display: block;">${app.email || 'N/A'}</strong></div>
                    <div><span style="color: #64748B;">City / Base:</span> <strong style="color: #0F172A; display: block;">${app.city || 'N/A'}</strong></div>
                    <div><span style="color: #64748B;">Trade Specialty:</span> <strong style="color: #0F172A; display: block;">${tradeName || 'General Specialist'} (${app.experience_years || 1} yrs exp)</strong></div>
                    <div><span style="color: #64748B;">Workshop Setup:</span> <strong style="color: #0F172A; display: block;">${(app.workshop_type || 'Freelance').replace('_', ' ').toUpperCase()}</strong></div>
                    <div><span style="color: #64748B;">Tool Inventory:</span> <strong style="color: #0F172A; display: block;">${(app.tools_available || 'Standard Tools').replace('_', ' ').toUpperCase()}</strong></div>
                    <div><span style="color: #64748B;">Emergency Contact:</span> <strong style="color: #0F172A; display: block;">${app.emergency_contact_name || 'Not provided'}</strong></div>
                    <div><span style="color: #64748B;">Emergency Phone:</span> <strong style="color: #0F172A; display: block;">${app.emergency_contact_phone || 'Not provided'}</strong></div>
                </div>
            </div>

            <!-- Uploaded Document Links with Previews -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px;">
                <strong style="font-size: 13.5px; color: #0F172A; display: block; margin-bottom: 12px; border-bottom: 1px solid #E2E8F0; padding-bottom: 8px;">Submitted Verification Artifacts &amp; Certificates</strong>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    
                    <!-- CNIC Front -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 10px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748B; display: block; margin-bottom: 4px;">1. CNIC Front Side</span>
                        ${cnicFrontUrl ? `
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 12px; color: #047857; font-weight: 700;">✓ Document Uploaded</span>
                                <a href="${cnicFrontUrl}" target="_blank" style="font-size: 12px; color: #0284C7; font-weight: 700; text-decoration: underline;">Open Document &rarr;</a>
                            </div>
                        ` : `<span style="font-size: 12px; color: #94A3B8;">Not submitted</span>`}
                    </div>

                    <!-- CNIC Back -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 10px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748B; display: block; margin-bottom: 4px;">2. CNIC Back Side</span>
                        ${cnicBackUrl ? `
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 12px; color: #047857; font-weight: 700;">✓ Document Uploaded</span>
                                <a href="${cnicBackUrl}" target="_blank" style="font-size: 12px; color: #0284C7; font-weight: 700; text-decoration: underline;">Open Document &rarr;</a>
                            </div>
                        ` : `<span style="font-size: 12px; color: #94A3B8;">Not submitted</span>`}
                    </div>

                    <!-- Police Certificate -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 10px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748B; display: block; margin-bottom: 4px;">3. Police Character Clearance</span>
                        ${policeUrl ? `
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 12px; color: #047857; font-weight: 700;">✓ Document Uploaded</span>
                                <a href="${policeUrl}" target="_blank" style="font-size: 12px; color: #0284C7; font-weight: 700; text-decoration: underline;">Open Document &rarr;</a>
                            </div>
                        ` : `<span style="font-size: 12px; color: #94A3B8;">Not submitted</span>`}
                    </div>

                    <!-- Trade License / Diploma -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 10px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748B; display: block; margin-bottom: 4px;">4. Trade License / Diploma</span>
                        ${tradeUrl ? `
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 12px; color: #047857; font-weight: 700;">✓ Document Uploaded</span>
                                <a href="${tradeUrl}" target="_blank" style="font-size: 12px; color: #0284C7; font-weight: 700; text-decoration: underline;">Open Document &rarr;</a>
                            </div>
                        ` : `<span style="font-size: 12px; color: #94A3B8;">Not submitted</span>`}
                    </div>

                    <!-- Proof of Address -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 10px; grid-column: span 2;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748B; display: block; margin-bottom: 4px;">5. Proof of Address / Utility Bill</span>
                        ${addrUrl ? `
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 12px; color: #047857; font-weight: 700;">✓ Document Uploaded</span>
                                <a href="${addrUrl}" target="_blank" style="font-size: 12px; color: #0284C7; font-weight: 700; text-decoration: underline;">Open Document &rarr;</a>
                            </div>
                        ` : `<span style="font-size: 12px; color: #94A3B8;">Not submitted</span>`}
                    </div>

                </div>
            </div>

            <!-- Notes & Revision Reason -->
            ${(app.rejection_reason || app.admin_notes) ? `
                <div style="background: #FFF7ED; padding: 14px 16px; border-radius: 10px; border: 1px solid #FED7AA; font-size: 13px; color: #9A3412;">
                    <strong>Inspector Notes / Revision Feedback:</strong>
                    <p style="margin: 4px 0 0 0; line-height: 1.4;">${app.rejection_reason || app.admin_notes}</p>
                </div>
            ` : ''}
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
            closeReturnModal();
            closeRejectModal();
            closeDossierModal();
        }
    });
</script>
@endsection

