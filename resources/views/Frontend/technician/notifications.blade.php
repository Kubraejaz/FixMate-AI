@extends('Frontend.layouts.technician')

@section('title', 'Notifications & Alerts — FixMate AI Partner Portal')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Notifications & Alerts</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">Instant dispatch alerts, customer messages, escrow releases, and KYC updates.</p>
        </div>
        
        @if($unreadCount > 0)
            <form action="{{ route('technician.notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="btn-outline" style="padding: 8px 16px; font-size: 13px; font-weight: 700;">
                    ✓ Mark All Read ({{ $unreadCount }})
                </button>
            </form>
        @endif
    </div>

    <!-- Filter Tabs -->
    <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
        <a href="{{ route('technician.notifications', ['filter' => 'all']) }}" 
           class="{{ $filter === 'all' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
            All ({{ $notifications->total() }})
        </a>
        <a href="{{ route('technician.notifications', ['filter' => 'unread']) }}" 
           class="{{ $filter === 'unread' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
            Unread ({{ $unreadCount }})
        </a>
    </div>

    <!-- Notifications List -->
    <div style="display: flex; flex-direction: column; gap: 12px;">
        @forelse($notifications as $notif)
            @php
                $bgColor = $notif->is_read ? '#FFFFFF' : '#FFFDF0';
                $borderColor = $notif->is_read ? 'var(--border-color)' : '#FDE68A';
                $icon = match($notif->type) {
                    'booking_assigned', 'new_job_available' => '💼',
                    'chat_message' => '💬',
                    'escrow_released', 'payout' => '💰',
                    'kyc_submitted', 'technician_approved', 'technician_verified' => '🛡️',
                    default => '🔔',
                };
            @endphp
            
            <div class="portal-card" style="padding: 18px 22px; background: {{ $bgColor }}; border: 1px solid {{ $borderColor }}; display: flex; justify-content: space-between; align-items: flex-start; gap: 16px;">
                
                <div style="display: flex; gap: 14px; align-items: flex-start; flex: 1;">
                    <div style="width: 42px; height: 42px; border-radius: 12px; background: #FFF; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                        {{ $icon }}
                    </div>
                    
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                            <strong style="font-size: 14.5px; color: #111;">{{ $notif->title }}</strong>
                            @if(! $notif->is_read)
                                <span style="background: #EF4444; color: #FFF; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px;">
                                    NEW
                                </span>
                            @endif
                            <span style="font-size: 11.5px; color: #888;">&bull; {{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <p style="font-size: 13.5px; color: #4B5563; margin: 0 0 10px 0; line-height: 1.5;">
                            {{ $notif->message }}
                        </p>

                        @if($notif->link)
                            <a href="{{ route('technician.notifications.open', $notif->id) }}" class="btn-yellow" style="display: inline-block; padding: 6px 16px; font-size: 12px; font-weight: 800; text-decoration: none; border-radius: 6px;">
                                Open Details & Action &rarr;
                            </a>
                        @endif
                    </div>
                </div>

                @if(! $notif->is_read)
                    <form action="{{ route('technician.notifications.read', $notif->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background: none; border: 1px solid #CBD5E1; color: #64748B; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 6px; cursor: pointer;" title="Mark as read">
                            ✓ Read
                        </button>
                    </form>
                @endif

            </div>
        @empty
            <div class="portal-card" style="padding: 48px; text-align: center; background: #FFFFFF;">
                <div style="font-size: 36px; margin-bottom: 12px;">🎉</div>
                <h3 style="font-size: 18px; font-weight: 900; color: #111; margin: 0 0 6px 0;">All Caught Up!</h3>
                <p style="font-size: 13.5px; color: #666; margin: 0;">You have no new notifications at the moment. As soon as a customer books or dispatches a job, you will be notified instantly.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 24px;">
        {{ $notifications->links() }}
    </div>

</div>
@endsection
