@extends('Frontend.layouts.admin')

@section('title', 'KYC Verifications — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>KYC Verification Pipeline</h1>
        <p>Review CNIC documents, trade licenses, and background police verification certificates.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge dark">3 applications pending review</span>
    </div>
</div>

<!-- Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Technician</th>
                    <th>Trade / Skill</th>
                    <th>CNIC Number</th>
                    <th>Documents Attached</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="border-color: var(--adm-accent);">
                            <div>
                                <div class="pname">Ali Khan</div>
                                <div class="pmeta">Karachi (DHA) &middot; 0300-1234567</div>
                            </div>
                        </div>
                    </td>
                    <td>Plumbing (8 yrs)</td>
                    <td><strong style="font-family: ui-monospace, monospace;">42201-1234567-1</strong></td>
                    <td>
                        <span class="adm-badge grey">CNIC</span>
                        <span class="adm-badge grey">Diploma</span>
                        <span class="adm-badge grey">Police Cert</span>
                    </td>
                    <td><span class="adm-badge yellow">Pending Review</span></td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 6px;">
                            <button type="button" class="adm-btn adm-btn-primary adm-btn-sm" onclick="showToast('Ali Khan approved as verified partner')">Approve</button>
                            <button type="button" class="adm-btn adm-btn-ghost adm-btn-sm" style="color: var(--adm-danger); border-color: #FECDD3;" onclick="showToast('Rejection reason requested', false)">Reject</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="border-color: var(--adm-accent);">
                            <div>
                                <div class="pname">Riaz Ahmed</div>
                                <div class="pmeta">Karachi (Clifton) &middot; 0321-9876543</div>
                            </div>
                        </div>
                    </td>
                    <td>Electrical (6 yrs)</td>
                    <td><strong style="font-family: ui-monospace, monospace;">42301-7654321-3</strong></td>
                    <td>
                        <span class="adm-badge grey">CNIC</span>
                        <span class="adm-badge grey">License</span>
                    </td>
                    <td><span class="adm-badge green">Approved</span></td>
                    <td style="text-align: right;"><button type="button" class="adm-btn adm-btn-ghost adm-btn-sm">View Dossier</button></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="border-color: var(--adm-accent);">
                            <div>
                                <div class="pname">Imran Shah</div>
                                <div class="pmeta">Karachi (Gulshan) &middot; 0333-5551234</div>
                            </div>
                        </div>
                    </td>
                    <td>HVAC &amp; AC (7 yrs)</td>
                    <td><strong style="font-family: ui-monospace, monospace;">42101-9988776-5</strong></td>
                    <td>
                        <span class="adm-badge grey">CNIC</span>
                        <span class="adm-badge grey">HVAC Cert</span>
                    </td>
                    <td><span class="adm-badge green">Approved</span></td>
                    <td style="text-align: right;"><button type="button" class="adm-btn adm-btn-ghost adm-btn-sm">View Dossier</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
