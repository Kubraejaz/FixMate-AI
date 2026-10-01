@extends('Frontend.layouts.admin')

@section('title', 'Customer Inquiries & Support Tickets — FixMate AI Admin')

@section('content')

<!-- Page Heading & Actions -->
<div class="adm-page-head">
    <div>
        <h1>Support Inquiries &amp; Portal Tickets</h1>
        <p>Monitor public contact messages, update dispute resolution states, log manual phone complaints, and record internal notes.</p>
    </div>
    <div class="adm-page-actions">
        <button type="button" class="adm-btn adm-btn-primary" onclick="openLogInquiryModal()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Log Manual Inquiry
        </button>
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

@if(session('error'))
    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; font-weight: 600;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #991B1B;">&times;</button>
    </div>
@endif

@if($errors->any())
    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-size: 13px;">
        <strong style="display: block; margin-bottom: 6px;">Please correct the errors below:</strong>
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
            <span class="kpi-label">Total Inquiries</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft); color: #B45309;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-val">{{ $stats['total'] ?? 0 }}</div>
        <div class="kpi-foot">All customer tickets</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">New &amp; Unread</span>
            <span class="kpi-icon" style="background: #FEF3C7; color: #D97706;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: #D97706;">{{ $stats['new'] ?? 0 }}</div>
        <div class="kpi-foot up">Requires operator response</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">In Progress</span>
            <span class="kpi-icon" style="background: var(--adm-info-soft); color: var(--adm-info);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-info);">{{ $stats['in_progress'] ?? 0 }}</div>
        <div class="kpi-foot">Under investigation / contact</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Resolved</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft); color: var(--adm-success);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-success);">{{ $stats['resolved'] ?? 0 }}</div>
        <div class="kpi-foot up">Closed with resolution note</div>
    </div>

</div>

<!-- Filter Bar -->
<div class="adm-card" style="padding: 16px 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.inquiries') }}" style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 260px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Ref #, customer name, phone, city, or query..." class="adm-input" style="padding-left: 38px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="position: absolute; left: 13px; top: 13px; color: var(--adm-faint);">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>

        <div style="width: 170px;">
            <select name="status" class="adm-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New / Unread</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div style="width: 210px;">
            <select name="department" class="adm-select" onchange="this.form.submit()">
                <option value="">All Departments</option>
                <option value="booking" {{ request('department') === 'booking' ? 'selected' : '' }}>Booking &amp; Status</option>
                <option value="emergency" {{ request('department') === 'emergency' ? 'selected' : '' }}>Emergency Breakdown</option>
                <option value="escrow" {{ request('department') === 'escrow' ? 'selected' : '' }}>Escrow &amp; Dispute</option>
                <option value="technician" {{ request('department') === 'technician' ? 'selected' : '' }}>Technician KYC</option>
                <option value="corporate" {{ request('department') === 'corporate' ? 'selected' : '' }}>Corporate / AMC</option>
                <option value="general" {{ request('department') === 'general' ? 'selected' : '' }}>General Feedback</option>
            </select>
        </div>

        <button type="submit" class="adm-btn adm-btn-secondary" style="height: 42px;">
            Filter
        </button>

        @if(request('search') || request('status') || request('department'))
            <a href="{{ route('admin.inquiries') }}" class="adm-btn" style="height: 42px; text-decoration: none; color: var(--adm-muted); background: #F1F5F9;">
                Clear
            </a>
        @endif

    </form>
</div>

<!-- Inquiries Table Card -->
<div class="adm-card" style="padding: 0; overflow: hidden; margin-bottom: 30px;">
    
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--adm-border); display: flex; justify-content: space-between; align-items: center; background: #FAFBFD;">
        <h3 style="font-size: 15px; font-weight: 800; color: var(--adm-ink); margin: 0;">
            Inquiry Records &amp; Escalations
            <span style="font-size: 12px; font-weight: 600; color: var(--adm-muted); margin-left: 8px;">({{ $inquiries->total() }} total)</span>
        </h3>
        <span style="font-size: 12px; color: var(--adm-muted);">Sorted by latest received</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="adm-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid var(--adm-border); font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--adm-muted);">
                    <th style="padding: 14px 20px;">Ref # &amp; Date</th>
                    <th style="padding: 14px 20px;">Customer / Sender</th>
                    <th style="padding: 14px 20px;">Department</th>
                    <th style="padding: 14px 20px;">Message Snippet</th>
                    <th style="padding: 14px 20px;">Status</th>
                    <th style="padding: 14px 20px;">Admin Notes</th>
                    <th style="padding: 14px 20px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inq)
                    @php
                        $badge = $inq->status_badge;
                    @endphp
                    <tr style="border-bottom: 1px solid var(--adm-border-soft); font-size: 13.5px; transition: background 0.15s ease;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                        
                        <!-- Reference & Date -->
                        <td style="padding: 16px 20px; vertical-align: top; white-space: nowrap;">
                            <span style="display: inline-block; font-family: monospace; font-weight: 800; color: #1E293B; background: #EEF2F6; padding: 3px 7px; border-radius: 6px; font-size: 12px;">
                                {{ $inq->reference_no }}
                            </span>
                            <div style="font-size: 11px; color: var(--adm-muted); margin-top: 5px;">
                                {{ $inq->created_at->format('M d, Y · h:i A') }}
                            </div>
                        </td>

                        <!-- Customer Details -->
                        <td style="padding: 16px 20px; vertical-align: top;">
                            <div style="font-weight: 700; color: var(--adm-ink); margin-bottom: 2px;">
                                {{ $inq->name }}
                            </div>
                            <div style="font-size: 12px; color: var(--adm-body); display: flex; align-items: center; gap: 4px; margin-bottom: 2px;">
                                <span>📞</span> <a href="tel:{{ $inq->phone }}" style="color: inherit; text-decoration: none;">{{ $inq->phone }}</a>
                            </div>
                            @if($inq->email)
                                <div style="font-size: 12px; color: var(--adm-muted); display: flex; align-items: center; gap: 4px;">
                                    <span>✉️</span> <a href="mailto:{{ $inq->email }}" style="color: var(--adm-info); text-decoration: none;">{{ $inq->email }}</a>
                                </div>
                            @endif
                            <div style="font-size: 11px; color: var(--adm-faint); margin-top: 3px;">
                                📍 {{ $inq->city }}
                            </div>
                        </td>

                        <!-- Department -->
                        <td style="padding: 16px 20px; vertical-align: top; white-space: nowrap;">
                            <span style="font-size: 12px; font-weight: 600; color: #334155; background: #F1F5F9; padding: 4px 9px; border-radius: 6px; display: inline-block;">
                                {{ $inq->department_label }}
                            </span>
                        </td>

                        <!-- Message Snippet -->
                        <td style="padding: 16px 20px; vertical-align: top; max-width: 280px;">
                            <div style="color: var(--adm-body); font-size: 13px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $inq->message }}">
                                {{ $inq->message }}
                            </div>
                            <button type="button" onclick="viewInquiryDetails({{ json_encode($inq) }})" style="background: none; border: none; padding: 0; margin-top: 4px; color: var(--adm-info); font-size: 11.5px; font-weight: 700; cursor: pointer; text-decoration: underline;">
                                Read full query &rarr;
                            </button>
                        </td>

                        <!-- Status Badge -->
                        <td style="padding: 16px 20px; vertical-align: top; white-space: nowrap;">
                            <span style="display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 999px; background: {{ $badge['bg'] }}; color: {{ $badge['color'] }};">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                {{ $badge['label'] }}
                            </span>
                        </td>

                        <!-- Admin Notes -->
                        <td style="padding: 16px 20px; vertical-align: top; max-width: 200px;">
                            @if($inq->admin_notes)
                                <div style="font-size: 12px; color: #475569; background: #F8FAFC; border: 1px dashed #CBD5E1; padding: 6px 10px; border-radius: 6px; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $inq->admin_notes }}">
                                    📝 {{ $inq->admin_notes }}
                                </div>
                            @else
                                <span style="font-size: 11.5px; color: var(--adm-faint); font-style: italic;">No notes yet</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td style="padding: 16px 20px; vertical-align: top; text-align: right; white-space: nowrap;">
                            <div style="display: inline-flex; gap: 6px;">
                                
                                <!-- Edit / Update Button -->
                                <button type="button" class="adm-btn adm-btn-secondary" style="font-size: 12px; padding: 6px 10px; height: 32px;" onclick="openUpdateModal({{ json_encode($inq) }})" title="Update status and notes">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Update
                                </button>

                                <!-- Delete Button -->
                                <button type="button" class="adm-btn adm-btn-danger" style="font-size: 12px; padding: 6px 8px; height: 32px;" onclick="confirmDeleteInquiry({{ $inq->id }}, '{{ addslashes($inq->reference_no) }}', '{{ addslashes($inq->name) }}')" title="Delete inquiry record">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 48px 24px; text-align: center;">
                            <div style="max-width: 320px; margin: 0 auto; color: var(--adm-muted);">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" style="margin-bottom: 12px; color: var(--adm-faint);">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    <line x1="9" y1="10" x2="15" y2="10"></line>
                                </svg>
                                <div style="font-weight: 700; font-size: 15px; color: var(--adm-ink); margin-bottom: 4px;">No Inquiries Found</div>
                                <div style="font-size: 13px;">No inquiries match the current search filter. Try clearing filters or submit a test from the Contact page.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inquiries->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--adm-border); background: #FAFBFD;">
            {{ $inquiries->links() }}
        </div>
    @endif

</div>


<!-- ======================================================== -->
<!-- MODAL 1: LOG MANUAL INQUIRY (CREATE)                     -->
<!-- ======================================================== -->
<div id="logInquiryModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 20px; max-width: 580px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: #FEF3C7; color: #B45309; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    📝
                </div>
                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--adm-ink); margin: 0;">Log Customer Inquiry</h3>
                    <p style="font-size: 12px; color: var(--adm-muted); margin: 0;">Create a support record received via phone call, email, or direct contact.</p>
                </div>
            </div>
            <button type="button" onclick="closeLogInquiryModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>

        <form action="{{ route('admin.inquiries.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Customer Name *</label>
                    <input type="text" name="name" required class="adm-input" placeholder="e.g. Tariq Mehmood" value="{{ old('name') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Phone Number *</label>
                    <input type="text" name="phone" required class="adm-input" placeholder="0300-1234567" value="{{ old('phone') }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Email Address</label>
                    <input type="email" name="email" class="adm-input" placeholder="customer@example.com" value="{{ old('email') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">City / Region *</label>
                    <input type="text" name="city" required class="adm-input" placeholder="e.g. Lahore / DHA" value="{{ old('city', 'Lahore') }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Department / Category *</label>
                    <select name="department" required class="adm-select">
                        <option value="booking">Booking &amp; Status Tracking</option>
                        <option value="emergency">Emergency Breakdown Squad</option>
                        <option value="escrow">Escrow &amp; Payment Dispute</option>
                        <option value="technician">Technician Onboarding / KYC</option>
                        <option value="corporate">Corporate / Housing AMC</option>
                        <option value="general" selected>General Feedback / Inquiry</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Initial Ticket Status *</label>
                    <select name="status" required class="adm-select">
                        <option value="new" selected>New / Unread</option>
                        <option value="in_progress">In Progress (Investigating)</option>
                        <option value="resolved">Resolved Immediately</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Inquiry / Complaint Details *</label>
                <textarea name="message" required class="adm-input" rows="3" placeholder="Enter customer issue, booking reference discussed, or service query..." style="height: auto; padding: 10px 14px;">{{ old('message') }}</textarea>
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Internal Staff Notes / Next Steps</label>
                <textarea name="admin_notes" class="adm-input" rows="2" placeholder="e.g. Called customer at 3:15pm, promised callback with technician lead..." style="height: auto; padding: 10px 14px;">{{ old('admin_notes') }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="adm-btn adm-btn-secondary" onclick="closeLogInquiryModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary">Save &amp; Log Inquiry</button>
            </div>
        </form>

    </div>
</div>


<!-- ======================================================== -->
<!-- MODAL 2: UPDATE STATUS & NOTES (UPDATE)                  -->
<!-- ======================================================== -->
<div id="updateInquiryModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 20px; max-width: 520px; width: 100%; padding: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--adm-ink); margin: 0;">Update Inquiry Status</h3>
                <p style="font-size: 12px; color: var(--adm-muted); margin: 0;" id="editModalRefDisplay">Ref: FM-INQ-XXXXXX</p>
            </div>
            <button type="button" onclick="closeUpdateModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>

        <form id="updateInquiryForm" method="POST" action="">
            @csrf
            @method('PUT')

            <!-- Customer Summary Box -->
            <div style="background: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 12px; padding: 12px 16px; margin-bottom: 16px; font-size: 12.5px;">
                <div style="font-weight: 700; color: var(--adm-ink);" id="editModalCustomerName">Customer Name</div>
                <div style="color: var(--adm-muted); margin-top: 2px;" id="editModalCustomerContact">0300-1234567 · Lahore</div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Routing Department</label>
                <select name="department" id="editModalDepartment" class="adm-select">
                    <option value="booking">Booking &amp; Status Tracking</option>
                    <option value="emergency">Emergency Breakdown Squad</option>
                    <option value="escrow">Escrow &amp; Payment Dispute</option>
                    <option value="technician">Technician Onboarding / KYC</option>
                    <option value="corporate">Corporate / Housing AMC</option>
                    <option value="general">General Feedback / Inquiry</option>
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Ticket Status *</label>
                <select name="status" id="editModalStatus" required class="adm-select">
                    <option value="new">New / Unread</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Internal Staff Notes / Resolution Summary</label>
                <textarea name="admin_notes" id="editModalNotes" class="adm-input" rows="4" placeholder="Detail actions taken, customer resolution agreement, or refund confirmation..." style="height: auto; padding: 10px 14px;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="adm-btn adm-btn-secondary" onclick="closeUpdateModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary">Save Changes</button>
            </div>
        </form>

    </div>
</div>


<!-- ======================================================== -->
<!-- MODAL 3: VIEW DETAILS MODAL                              -->
<!-- ======================================================== -->
<div id="viewInquiryModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 20px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 18px; border-bottom: 1px solid var(--adm-border); padding-bottom: 14px;">
            <div>
                <span id="viewModalRefBadge" style="font-family: monospace; font-weight: 800; color: #1E293B; background: #EEF2F6; padding: 3px 8px; border-radius: 6px; font-size: 12px;">FM-INQ-000000</span>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--adm-ink); margin: 6px 0 2px;" id="viewModalName">Sender Name</h3>
                <div style="font-size: 12px; color: var(--adm-muted);" id="viewModalDate">Submitted on...</div>
            </div>
            <button type="button" onclick="closeViewModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>

        <!-- Contact Strip -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #FAFBFD; border: 1px solid var(--adm-border-soft); border-radius: 12px; padding: 14px; margin-bottom: 18px; font-size: 13px;">
            <div>
                <span style="font-size: 11px; text-transform: uppercase; color: var(--adm-faint); font-weight: 700; display: block;">Phone Number</span>
                <strong id="viewModalPhone" style="color: var(--adm-ink);">--</strong>
            </div>
            <div>
                <span style="font-size: 11px; text-transform: uppercase; color: var(--adm-faint); font-weight: 700; display: block;">Email Address</span>
                <strong id="viewModalEmail" style="color: var(--adm-ink);">--</strong>
            </div>
            <div>
                <span style="font-size: 11px; text-transform: uppercase; color: var(--adm-faint); font-weight: 700; display: block;">City / Area</span>
                <strong id="viewModalCity" style="color: var(--adm-ink);">--</strong>
            </div>
            <div>
                <span style="font-size: 11px; text-transform: uppercase; color: var(--adm-faint); font-weight: 700; display: block;">Department</span>
                <strong id="viewModalDept" style="color: var(--adm-ink);">--</strong>
            </div>
        </div>

        <!-- Customer Message -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 8px;">Customer Inquiry Message:</label>
            <div id="viewModalMessage" style="background: #FFFFFF; border: 1px solid var(--adm-border); border-radius: 12px; padding: 14px 16px; font-size: 13.5px; line-height: 1.6; color: #1E293B; white-space: pre-wrap;"></div>
        </div>

        <!-- Admin Notes Strip -->
        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--adm-ink); margin-bottom: 8px;">Internal Resolution Notes:</label>
            <div id="viewModalNotes" style="background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 12px; padding: 14px 16px; font-size: 13px; line-height: 1.5; color: #475569; font-style: italic;">
                No notes logged yet.
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" class="adm-btn adm-btn-secondary" onclick="closeViewModal()">Close</button>
            <button type="button" class="adm-btn adm-btn-primary" id="viewModalQuickEditBtn">Update Status</button>
        </div>

    </div>
</div>


<!-- ======================================================== -->
<!-- MODAL 4: DELETE CONFIRMATION (DELETE)                    -->
<!-- ======================================================== -->
<div id="deleteInquiryModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 20px; max-width: 440px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative; text-align: center;">
        
        <div style="width: 52px; height: 52px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px;">
            🗑️
        </div>

        <h3 style="font-size: 18px; font-weight: 800; color: var(--adm-ink); margin-bottom: 8px;">Delete Inquiry Record?</h3>
        <p style="font-size: 13.5px; color: var(--adm-muted); line-height: 1.5; margin-bottom: 20px;">
            Are you sure you want to permanently remove inquiry <strong id="deleteInquiryRef" style="color: var(--adm-ink);">#FM-INQ</strong> from <strong id="deleteInquiryName">Customer</strong>? This cannot be undone.
        </p>

        <form id="deleteInquiryForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; justify-content: center; gap: 12px;">
                <button type="button" class="adm-btn adm-btn-secondary" onclick="closeDeleteModal()" style="min-width: 100px;">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-danger" style="min-width: 130px;">Yes, Delete</button>
            </div>
        </form>

    </div>
</div>

@endsection

@section('extra_js')
<script>
    // 1. Log Inquiry Modal
    function openLogInquiryModal() {
        document.getElementById('logInquiryModal').style.display = 'flex';
    }
    function closeLogInquiryModal() {
        document.getElementById('logInquiryModal').style.display = 'none';
    }

    // 2. Update Modal
    function openUpdateModal(inquiry) {
        document.getElementById('updateInquiryForm').action = "{{ route('admin.inquiries') }}/" + inquiry.id;
        document.getElementById('editModalRefDisplay').textContent = "Ticket Ref: " + inquiry.reference_no;
        document.getElementById('editModalCustomerName').textContent = inquiry.name;
        document.getElementById('editModalCustomerContact').textContent = (inquiry.phone || '') + " · " + (inquiry.city || '');
        document.getElementById('editModalDepartment').value = inquiry.department || 'general';
        document.getElementById('editModalStatus').value = inquiry.status || 'new';
        document.getElementById('editModalNotes').value = inquiry.admin_notes || '';
        document.getElementById('updateInquiryModal').style.display = 'flex';
    }
    function closeUpdateModal() {
        document.getElementById('updateInquiryModal').style.display = 'none';
    }

    // 3. View Modal
    function viewInquiryDetails(inquiry) {
        document.getElementById('viewModalRefBadge').textContent = inquiry.reference_no;
        document.getElementById('viewModalName').textContent = inquiry.name;
        document.getElementById('viewModalDate').textContent = "Submitted: " + (inquiry.created_at ? inquiry.created_at.substring(0, 10) : 'Recently');
        document.getElementById('viewModalPhone').textContent = inquiry.phone || 'N/A';
        document.getElementById('viewModalEmail').textContent = inquiry.email || 'N/A';
        document.getElementById('viewModalCity').textContent = inquiry.city || 'N/A';
        document.getElementById('viewModalDept').textContent = inquiry.department_label || inquiry.department || 'General';
        document.getElementById('viewModalMessage').textContent = inquiry.message || '';
        
        var notesEl = document.getElementById('viewModalNotes');
        if (inquiry.admin_notes) {
            notesEl.textContent = inquiry.admin_notes;
            notesEl.style.fontStyle = 'normal';
        } else {
            notesEl.textContent = 'No internal staff notes recorded for this ticket yet.';
            notesEl.style.fontStyle = 'italic';
        }

        document.getElementById('viewModalQuickEditBtn').onclick = function() {
            closeViewModal();
            openUpdateModal(inquiry);
        };

        document.getElementById('viewInquiryModal').style.display = 'flex';
    }
    function closeViewModal() {
        document.getElementById('viewInquiryModal').style.display = 'none';
    }

    // 4. Delete Modal
    function confirmDeleteInquiry(id, ref, name) {
        document.getElementById('deleteInquiryForm').action = "{{ route('admin.inquiries') }}/" + id;
        document.getElementById('deleteInquiryRef').textContent = ref;
        document.getElementById('deleteInquiryName').textContent = name;
        document.getElementById('deleteInquiryModal').style.display = 'flex';
    }
    function closeDeleteModal() {
        document.getElementById('deleteInquiryModal').style.display = 'none';
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        var logM = document.getElementById('logInquiryModal');
        var updM = document.getElementById('updateInquiryModal');
        var viewM = document.getElementById('viewInquiryModal');
        var delM = document.getElementById('deleteInquiryModal');
        if (e.target === logM) closeLogInquiryModal();
        if (e.target === updM) closeUpdateModal();
        if (e.target === viewM) closeViewModal();
        if (e.target === delM) closeDeleteModal();
    });
</script>
@endsection
