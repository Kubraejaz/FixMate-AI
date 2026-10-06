@extends('Frontend.layouts.admin')

@section('title', 'Civic Hazards & Community Squads — FixMate Admin')

@section('content')

<!-- Page Heading & Actions -->
<div class="adm-page-head">
    <div>
        <h1>Neighborhood Hazards &amp; Dispatch Console</h1>
        <p>Monitor public civic maintenance reports, coordinate emergency squad dispatch, track community upvotes, and broadcast progress updates.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ route('community') }}" target="_blank" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border); color: var(--adm-ink);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
            Live Public Feed
        </a>
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
        <strong style="display: block; margin-bottom: 6px;">Please correct the validation errors:</strong>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Summary KPIs -->
<div class="adm-kpi-grid" style="grid-template-columns: repeat(5, 1fr); margin-bottom: 24px;">
    
    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Total Reports</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft); color: #B45309;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </span>
        </div>
        <div class="kpi-val">{{ $stats['total'] ?? 0 }}</div>
        <div class="kpi-foot">All logged incidents</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Critical Alerts</span>
            <span class="kpi-icon" style="background: #FEE2E2; color: #DC2626;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 2 22 22 22 12 2"></polygon>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: #DC2626;">{{ $stats['active_alerts'] ?? 0 }}</div>
        <div class="kpi-foot" style="color: #DC2626;">Immediate safety risk</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Squads Mobilized</span>
            <span class="kpi-icon" style="background: var(--adm-info-soft); color: var(--adm-info);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-info);">{{ $stats['in_progress'] ?? 0 }}</div>
        <div class="kpi-foot">In progress &amp; scheduled</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Resolved</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft); color: var(--adm-success);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-success);">{{ $stats['resolved'] ?? 0 }}</div>
        <div class="kpi-foot up">Completed repairs</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Citizen Upvotes</span>
            <span class="kpi-icon" style="background: #FEF3C7; color: #D97706;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: #B45309;">{{ $stats['total_upvotes'] ?? 0 }}</div>
        <div class="kpi-foot">Civic engagement</div>
    </div>

</div>

<!-- Filter Bar -->
<div class="adm-card" style="padding: 16px 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.community') }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 220px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Ref #, hazard, location, reporter..." class="adm-input" style="padding-left: 38px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="position: absolute; left: 13px; top: 13px; color: var(--adm-faint);">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>

        <div style="width: 150px;">
            <select name="city" class="adm-select" onchange="this.form.submit()">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>

        <div style="width: 180px;">
            <select name="category" class="adm-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $key => $cat)
                    <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>
                        {{ $cat['icon'] }} {{ $cat['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="width: 160px;">
            <select name="status" class="adm-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="reported" {{ request('status') === 'reported' ? 'selected' : '' }}>Reported</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="alert_active" {{ request('status') === 'alert_active' ? 'selected' : '' }}>Alert Active</option>
                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>

        <button type="submit" class="adm-btn adm-btn-primary" style="height: 42px;">Filter</button>

        @if(request()->hasAny(['search', 'city', 'category', 'status', 'priority']))
            <a href="{{ route('admin.community') }}" class="adm-btn" style="height: 42px; text-decoration: none; color: var(--adm-muted); background: #F1F5F9;">
                Reset
            </a>
        @endif

    </form>
</div>

<!-- Table Card -->
<div class="adm-card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
    
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <strong style="font-size: 15px; color: var(--adm-ink);">Civic Hazard Reports</strong>
            <span style="font-size: 12px; font-weight: 600; color: var(--adm-muted);">({{ $issues->total() }} total)</span>
        </div>
        <span style="font-size: 12px; color: var(--adm-muted);">Issues exceeding 25 votes are prioritized for dispatch squad coordination</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="adm-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid var(--adm-border); font-size: 12px; color: var(--adm-muted); text-transform: uppercase; letter-spacing: 0.04em;">
                    <th style="padding: 12px 18px; width: 110px;">Ref #</th>
                    <th style="padding: 12px 18px; width: 30%;">Incident Details</th>
                    <th style="padding: 12px 18px; width: 15%;">Location &amp; City</th>
                    <th style="padding: 12px 18px; width: 80px; text-align: center;">Votes</th>
                    <th style="padding: 12px 18px; width: 18%;">Dispatch Status</th>
                    <th style="padding: 12px 18px; width: 10%;">Feed Visibility</th>
                    <th style="padding: 12px 18px; width: 110px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issues as $issue)
                    @php
                        $badge = $issue->status_badge;
                        $cat = $issue->category_meta;
                    @endphp
                    <tr style="border-bottom: 1px solid var(--adm-border-soft); transition: background 0.15s ease;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                        
                        <!-- Reference No -->
                        <td style="padding: 16px 18px; font-family: monospace; font-size: 13px; font-weight: 700; color: var(--adm-ink);">
                            {{ $issue->reference_no }}
                        </td>

                        <!-- Title & Description -->
                        <td style="padding: 16px 18px;">
                            <div style="font-weight: 700; font-size: 14px; color: var(--adm-ink); margin-bottom: 4px; line-height: 1.35;">
                                {{ $issue->title }}
                            </div>
                            <div style="font-size: 12px; color: var(--adm-muted); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 6px;">
                                {{ $issue->description }}
                            </div>
                            <div style="font-size: 11.5px; color: var(--adm-faint);">
                                By <strong>{{ $issue->reporter_name }}</strong> ({{ $issue->reporter_role }}) · {{ $issue->created_at->diffForHumans() }}
                            </div>
                        </td>

                        <!-- Category & City -->
                        <td style="padding: 16px 18px;">
                            <div style="display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 700; color: {{ $cat['badge_color'] }}; background: {{ $cat['badge_bg'] }}; padding: 3px 8px; border-radius: 6px; margin-bottom: 4px;">
                                <span>{{ $cat['icon'] }}</span>
                                <span>{{ $cat['label'] }}</span>
                            </div>
                            <div style="font-size: 12.5px; font-weight: 700; color: var(--adm-ink);">{{ $issue->city }}</div>
                            <div style="font-size: 11px; color: var(--adm-muted);">{{ $issue->location }}</div>
                        </td>

                        <!-- Upvotes -->
                        <td style="padding: 16px 18px; text-align: center;">
                            <div style="display: inline-block; background: {{ $issue->upvotes_count >= 25 ? '#FEF3C7' : '#F1F5F9' }}; border: 1px solid {{ $issue->upvotes_count >= 25 ? '#F59E0B' : '#E2E8F0' }}; border-radius: 10px; padding: 4px 10px; text-align: center;">
                                <span style="font-size: 11px; color: #D97706;">▲</span>
                                <strong style="font-size: 14px; color: #0F172A; display: block;">{{ $issue->upvotes_count }}</strong>
                            </div>
                        </td>

                        <!-- Dispatch Status & Update -->
                        <td style="padding: 16px 18px;">
                            <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; border: 1px solid {{ $badge['border'] }}; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; display: inline-block; margin-bottom: 6px;">
                                {{ $badge['label'] }}
                            </span>
                            @if(!empty($issue->status_update))
                                <div style="font-size: 12px; color: var(--adm-body); font-weight: 600; line-height: 1.35;">
                                    {{ $issue->status_update }}
                                </div>
                            @endif
                        </td>

                        <!-- Feed Visibility Toggle -->
                        <td style="padding: 16px 18px;">
                            <label style="position: relative; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" onchange="toggleIssueStatus({{ $issue->id }}, this)" {{ $issue->is_approved ? 'checked' : '' }} style="display: none;">
                                <div class="toggle-pill" style="width: 36px; height: 20px; background: {{ $issue->is_approved ? 'var(--adm-success)' : '#CBD5E1' }}; border-radius: 20px; position: relative; transition: background 0.2s ease;">
                                    <div class="toggle-circle" style="width: 14px; height: 14px; background: #FFFFFF; border-radius: 50%; position: absolute; top: 3px; left: {{ $issue->is_approved ? '19px' : '3px' }}; transition: left 0.2s ease;"></div>
                                </div>
                                <span class="status-text" style="font-size: 12px; font-weight: 700; color: {{ $issue->is_approved ? 'var(--adm-success)' : 'var(--adm-muted)' }};">
                                    {{ $issue->is_approved ? 'Live' : 'Hidden' }}
                                </span>
                            </label>
                        </td>

                        <!-- Actions -->
                        <td style="padding: 16px 18px; text-align: right;">
                            <div style="display: inline-flex; gap: 6px;">
                                <button type="button" class="adm-btn adm-btn-primary" style="height: 32px; padding: 0 10px; font-size: 12px;" onclick='openUpdateModal(@json($issue))'>
                                    Dispatch
                                </button>
                                <button type="button" class="adm-btn" style="height: 32px; padding: 0 8px; font-size: 12px; background: #FFF1F2; border: 1px solid #FECDD3; color: var(--adm-danger);" onclick="confirmDelete({{ $issue->id }}, '{{ addslashes($issue->reference_no) }}')">
                                    &times;
                                </button>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 40px 20px; text-align: center; color: var(--adm-muted);">
                            No civic reports found matching current filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($issues->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--adm-border); display: flex; justify-content: flex-end;">
            {{ $issues->links() }}
        </div>
    @endif

</div>

<!-- Modal: Update Dispatch Status -->
<div id="updateIssueModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 18px; width: 100%; max-width: 600px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden;">
        
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between; background: #F8FAFC;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 22px;">⚡</span>
                <strong style="font-size: 16px; color: var(--adm-ink);" id="modalIssueRefTitle">Update Dispatch Status</strong>
            </div>
            <button type="button" onclick="closeUpdateModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>

        <form id="updateIssueForm" method="POST">
            @csrf
            @method('PUT')
            <div style="padding: 24px; display: flex; flex-direction: column; gap: 16px; max-height: 75vh; overflow-y: auto;">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Status</label>
                        <select id="modal_status" name="status" class="adm-select" required>
                            <option value="reported">Reported</option>
                            <option value="in_progress">In Progress</option>
                            <option value="alert_active">Alert Active</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Priority</label>
                        <select id="modal_priority" name="priority" class="adm-select" required>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Dispatch Note / Broadcast Update</label>
                    <input type="text" id="modal_status_update" name="status_update" class="adm-input" placeholder="e.g. Squad #3 dispatched to Gulshan transformer pole">
                    <span style="font-size: 11.5px; color: var(--adm-muted); display: block; margin-top: 3px;">This update appears live to neighborhood residents on the community feed.</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">City</label>
                        <select id="modal_city" name="city" class="adm-select" required>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Category</label>
                        <select id="modal_category" name="category" class="adm-select" required>
                            @foreach($categories as $key => $cat)
                                <option value="{{ $key }}">{{ $cat['icon'] }} {{ $cat['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Location Address</label>
                    <input type="text" id="modal_location" name="location" class="adm-input" required>
                </div>

                <div>
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: var(--adm-ink); cursor: pointer;">
                        <input type="checkbox" id="modal_is_approved" name="is_approved" value="1" style="width: 16px; height: 16px; accent-color: var(--adm-accent);">
                        <span>Approve for Public Feed Display</span>
                    </label>
                </div>

            </div>

            <div style="padding: 16px 24px; background: #F8FAFC; border-top: 1px solid var(--adm-border); display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border); color: var(--adm-muted);" onclick="closeUpdateModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary">Update Status &amp; Broadcast</button>
            </div>
        </form>

    </div>
</div>

<!-- Modal: Delete Confirmation -->
<div id="deleteIssueModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 16px; width: 100%; max-width: 440px; padding: 24px; text-align: center;">
        <div style="width: 48px; height: 48px; background: #FFF1F2; border-radius: 50%; color: var(--adm-danger); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto; font-size: 22px;">🗑️</div>
        <strong style="font-size: 17px; color: var(--adm-ink); display: block; margin-bottom: 6px;">Delete Civic Report?</strong>
        <p id="deleteIssueRefText" style="font-size: 13px; color: var(--adm-muted); margin: 0 0 20px 0;"></p>
        <form id="deleteIssueForm" method="POST">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border);" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="adm-btn" style="background: var(--adm-danger); color: #FFF; border: none;">Delete Report</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('extra_js')
<script>
    function openUpdateModal(issue) {
        document.getElementById('updateIssueForm').action = "{{ url('/admin/community') }}/" + issue.id;
        document.getElementById('modalIssueRefTitle').textContent = "Dispatch: #" + issue.reference_no;
        document.getElementById('modal_status').value = issue.status;
        document.getElementById('modal_priority').value = issue.priority;
        document.getElementById('modal_status_update').value = issue.status_update || '';
        document.getElementById('modal_city').value = issue.city;
        document.getElementById('modal_category').value = issue.category;
        document.getElementById('modal_location').value = issue.location;
        document.getElementById('modal_is_approved').checked = !!issue.is_approved;

        document.getElementById('updateIssueModal').style.display = 'flex';
    }

    function closeUpdateModal() {
        document.getElementById('updateIssueModal').style.display = 'none';
    }

    function confirmDelete(id, ref) {
        document.getElementById('deleteIssueForm').action = "{{ url('/admin/community') }}/" + id;
        document.getElementById('deleteIssueRefText').textContent = "Are you sure you want to permanently delete report " + ref + "?";
        document.getElementById('deleteIssueModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteIssueModal').style.display = 'none';
    }

    function toggleIssueStatus(id, inputEl) {
        var pill = inputEl.nextElementSibling;
        var circle = pill.querySelector('.toggle-circle');
        var text = inputEl.parentElement.querySelector('.status-text');

        fetch("{{ url('/admin/community') }}/" + id + "/toggle", {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.is_approved) {
                    pill.style.background = 'var(--adm-success)';
                    circle.style.left = '19px';
                    text.textContent = 'Live';
                    text.style.color = 'var(--adm-success)';
                } else {
                    pill.style.background = '#CBD5E1';
                    circle.style.left = '3px';
                    text.textContent = 'Hidden';
                    text.style.color = 'var(--adm-muted)';
                }
                showToast(data.message, true);
            }
        })
        .catch(err => {
            inputEl.checked = !inputEl.checked;
            showToast('Failed to toggle visibility', false);
        });
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeUpdateModal();
            closeDeleteModal();
        }
    });
</script>
@endsection
