@extends('Frontend.layouts.admin')

@section('title', 'Customer Accounts — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Registered Customers</h1>
        <p>{{ $totalCount }} total registered accounts &middot; {{ $activeCount }} active.</p>
    </div>
    <div class="adm-page-actions">
        <form method="GET" action="{{ route('admin.customers') }}" style="display: flex; gap: 8px; align-items: center;">
            <input type="text" name="q" value="{{ request('q') }}" class="adm-input" style="width: 250px;" placeholder="Search name, phone, city...">
            <select name="status" class="adm-select" style="width: 130px;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Suspended</option>
            </select>
            <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm">Filter</button>
            @if(request()->hasAny(['q', 'status', 'city']))
                <a href="{{ route('admin.customers') }}" class="adm-btn adm-btn-ghost adm-btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

@if(session('success'))
    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
        <span>✓ {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#166534;cursor:pointer;font-weight:700;">×</button>
    </div>
@endif

<!-- Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact Phone</th>
                    <th>Email</th>
                    <th>City / Area</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td>
                            <div class="adm-person">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; border: 1px solid #DBEAFE; flex-shrink: 0;">
                                    {{ strtoupper(substr($c->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="pname">{{ $c->name }}</div>
                                    <div class="pmeta">Joined {{ $c->created_at?->format('M Y') ?? 'Recently' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->email ?? '—' }}</td>
                        <td>{{ $c->city ?? 'Karachi' }} {{ $c->area ? '· ' . $c->area : '' }}</td>
                        <td>
                            <span class="adm-badge {{ $c->is_active ? 'green' : 'yellow' }}">
                                {{ $c->is_active ? 'Active' : 'Suspended' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 8px;">
                                <form method="POST" action="{{ route('admin.customers.toggle', $c) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 11.5px; height: 28px; padding: 0 10px;">
                                        {{ $c->is_active ? 'Suspend' : 'Activate' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.customers.destroy', $c) }}" onsubmit="return confirm('Delete customer account permanently?');">
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
                            No customers match the current search or filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--adm-border);">
            {{ $customers->links() }}
        </div>
    @endif
</div>

@endsection
