@extends('Frontend.layouts.admin')

@section('title', 'System Alerts & Notifications — FixMate Admin')

@section('content')

<!-- Page Heading & Actions -->
<div class="adm-page-head">
    <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
            <span style="font-size: 24px;">🔔</span>
            <h1 style="margin: 0;">Platform Alerts &amp; System Notifications</h1>
        </div>
        <p>Live event streaming for partner KYC applications, booking dispatches, escrow transactions, and support tickets.</p>
    </div>
    <div class="adm-page-actions">
        @if($unreadCount > 0)
            <form action="{{ route('admin.notifications.read-all') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="adm-btn adm-btn-primary" style="font-size: 13px; height: 38px;">
                    ✓ Mark All Read ({{ $unreadCount }})
                </button>
            </form>
        @else
            <span class="adm-badge green" style="padding: 7px 14px; font-size: 12.5px;">
                ✓ All queues caught up
            </span>
        @endif
    </div>
</div>

<!-- Filter Tabs -->
<div style="display: flex; gap: 10px; margin-bottom: 22px; border-bottom: 1px solid var(--adm-border); padding-bottom: 12px;">
    <a href="{{ route('admin.notifications', ['filter' => 'all']) }}" 
       class="adm-btn {{ $filter === 'all' ? 'adm-btn-primary' : 'adm-btn-ghost' }}" 
       style="font-size: 13px; height: 34px; padding: 0 16px; border-radius: 20px;">
        All Alerts ({{ $notifications->total() }})
    </a>
    <a href="{{ route('admin.notifications', ['filter' => 'unread']) }}" 
       class="adm-btn {{ $filter === 'unread' ? 'adm-btn-primary' : 'adm-btn-ghost' }}" 
       style="font-size: 13px; height: 34px; padding: 0 16px; border-radius: 20px;">
        Unread Only ({{ $unreadCount }})
    </a>
</div>

<!-- Notifications Feed -->
<div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
    @forelse($notifications as $notif)
        @php
            $isUnread = !$notif->is_read;
            $bgColor = $isUnread ? '#FFFDF0' : '#FFFFFF';
            $borderColor = $isUnread ? '#FDE68A' : 'var(--adm-border)';
            $icon = match($notif->type) {
                'technician_registered', 'kyc_submitted', 'kyc_approved', 'kyc_rejected' => '🛡️',
                'booking_dispatched', 'booking_created' => '⚡',
                'escrow_held', 'payment' => '💰',
                'inquiry_received', 'complaint_filed' => '💬',
                default => '🔔',
            };
        @endphp
        
        <div class="adm-card" style="padding: 18px 22px; background: {{ $bgColor }}; border: 1.5px solid {{ $borderColor }}; border-radius: 12px; display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            
            <div style="display: flex; gap: 14px; align-items: flex-start; flex: 1;">
                <div style="width: 42px; height: 42px; border-radius: 10px; background: #FFFFFF; border: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.04);">
                    {{ $icon }}
                </div>
                
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                        <strong style="font-size: 14px; color: var(--adm-ink);">{{ $notif->title }}</strong>
                        @if($isUnread)
                            <span style="background: var(--adm-danger); color: #FFF; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px; letter-spacing: 0.04em;">
                                NEW
                            </span>
                        @endif
                        <span style="font-size: 11.5px; color: var(--adm-faint);">&bull; {{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <p style="font-size: 13px; color: var(--adm-body); margin: 0 0 12px 0; line-height: 1.5;">
                        {{ $notif->message }}
                    </p>

                    @if($notif->link)
                        <a href="{{ route('admin.notifications.open', $notif->id) }}" class="adm-btn adm-btn-primary adm-btn-sm" style="font-size: 12px; height: 30px; display: inline-flex; align-items: center; gap: 6px; padding: 0 14px;">
                            <span>Inspect &amp; Action</span>
                            <span>&rarr;</span>
                        </a>
                    @endif
                </div>
            </div>

            @if($isUnread)
                <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 11.5px; height: 28px; white-space: nowrap; border-radius: 6px;" title="Mark as Read">
                        Mark Read
                    </button>
                </form>
            @endif

        </div>
    @empty
        <div class="adm-card" style="padding: 50px 20px; text-align: center; color: var(--adm-muted);">
            <span style="font-size: 36px; display: block; margin-bottom: 10px;">✨</span>
            <strong style="font-size: 15px; color: var(--adm-ink); display: block; margin-bottom: 6px;">No notifications found</strong>
            <p style="font-size: 13px; margin: 0;">
                {{ $filter === 'unread' ? 'All unread system alerts have been reviewed.' : 'Platform alerts and audit triggers will appear here in real-time.' }}
            </p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($notifications->hasPages())
    <div style="display: flex; justify-content: flex-end;">
        {{ $notifications->links() }}
    </div>
@endif

@endsection
