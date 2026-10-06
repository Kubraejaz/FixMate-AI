@extends('Frontend.layouts.admin')

@section('title', 'Technicians Pool — FixMate Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Registered Technicians Pool</h1>
        <p>{{ $totalCount }} registered specialists &middot; {{ $verifiedCount }} NADRA verified.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ route('admin.technicians.verification') }}" class="adm-btn adm-btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            Review Pending KYC ({{ $pendingKycCount }})
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
        <span>✓ {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#166534;cursor:pointer;font-weight:700;">×</button>
    </div>
@endif

<!-- Filter Bar -->
<div class="adm-card" style="padding: 14px 18px; margin-bottom: 18px;">
    <form method="GET" action="{{ route('admin.technicians') }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <input type="text" name="q" value="{{ request('q') }}" class="adm-input" style="flex: 1; min-width: 220px;" placeholder="Search technician name, phone, experience...">
        
        <select name="profession_id" class="adm-select" style="width: 200px;" onchange="this.form.submit()">
            <option value="">All Professions</option>
            @foreach($professions as $p)
                <option value="{{ $p->id }}" {{ request('profession_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="adm-select" style="width: 160px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified Only</option>
            <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Unverified Only</option>
        </select>

        <button type="submit" class="adm-btn adm-btn-primary">Apply</button>
        @if(request()->hasAny(['q', 'profession_id', 'status']))
            <a href="{{ route('admin.technicians') }}" class="adm-btn adm-btn-ghost">Reset</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Technician</th>
                    <th>Trade Discipline</th>
                    <th>Experience</th>
                    <th>Contact Phone</th>
                    <th>KYC Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($technicians as $tech)
                    <tr>
                        <td>
                            <div class="adm-person">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: #FFFBEB; color: #B45309; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; border: 1.5px solid var(--adm-accent); flex-shrink: 0;">
                                    {{ strtoupper(substr($tech->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="pname">{{ $tech->name }}</div>
                                    <div class="pmeta">{{ $tech->user?->city ?? 'Karachi' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong style="color: var(--adm-ink);">{{ $tech->profession?->name ?? 'General Technician' }}</strong>
                        </td>
                        <td>{{ $tech->experience ?? '5+ Years' }}</td>
                        <td>{{ $tech->phone ?? $tech->user?->phone ?? '—' }}</td>
                        <td>
                            <span class="adm-badge {{ $tech->is_verified ? 'green' : 'yellow' }}">
                                {{ $tech->is_verified ? '✓ Verified' : 'Pending Review' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 8px;">
                                <a href="{{ url('/technicians/' . $tech->id) }}" target="_blank" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 11.5px; height: 28px; padding: 0 10px;">
                                    Public Profile
                                </a>
                                <form method="POST" action="{{ route('admin.technicians.verify', $tech) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="adm-btn adm-btn-sm" style="background: {{ $tech->is_verified ? '#F1F5F9' : '#ECFDF5' }}; color: {{ $tech->is_verified ? '#475569' : '#047857' }}; border: 1px solid {{ $tech->is_verified ? '#CBD5E1' : '#A7F3D0' }}; font-size: 11.5px; height: 28px; padding: 0 10px;">
                                        {{ $tech->is_verified ? 'Revoke' : 'Verify' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.technicians.destroy', $tech) }}" onsubmit="return confirm('Remove technician from pool?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="adm-btn adm-btn-sm" style="background: #FFF1F2; color: #E11D48; border-color: #FECDD3; font-size: 11.5px; height: 28px; padding: 0 10px;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 36px; color: var(--adm-muted);">
                            No technicians found matching the filter criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($technicians->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--adm-border);">
            {{ $technicians->links() }}
        </div>
    @endif
</div>

@endsection
