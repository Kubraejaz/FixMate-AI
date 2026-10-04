@extends('Frontend.layouts.customer')

@section('title', 'Notifications & Alerts — FixMate Customer Portal')

@section('content')
<div style="max-width: 860px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                <span style="font-size: 26px;">🔔</span>
                <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0;">Notifications &amp; Activity</h1>
            </div>
            <p style="font-size: 14px; color: #666; margin: 0;">Live booking confirmations, technician arrival OTPs, chat replies, and escrow receipts.</p>
        </div>
        
        @if($unreadCount > 0)
            <form action="{{ route('customer.notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="btn-outline" style="padding: 8px 16px; font-size: 13px; font-weight: 800; cursor: pointer; border-radius: 8px; background: #FFFFFF;">
                    ✓ Mark All Read ({{ $unreadCount }})
                </button>
            </form>
        @endif
    </div>

    <!-- Filter Tabs -->
    <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
        <a href="{{ route('customer.notifications', ['filter' => 'all']) }}" 
           class="{{ $filter === 'all' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none; font-weight: 700;">
            All ({{ $notifications->total() }})
        </a>
        <a href="{{ route('customer.notifications', ['filter' => 'unread']) }}" 
           class="{{ $filter === 'unread' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none; font-weight: 700;">
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
                    'booking_created', 'booking_confirmed', 'en_route', 'technician_arrived' => '⚡',
                    'chat_message' => '💬',
                    'escrow_held', 'payment_success', 'payment' => '💳',
                    'dispute_opened', 'dispute_resolved' => '⚖️',
                    'review_requested' => '⭐',
                    default => '🔔',
                };
            @endphp
            
            <div class="portal-card" style="padding: 18px 22px; background: {{ $bgColor }}; border: 1.5px solid {{ $borderColor }}; border-radius: 12px; display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; transition: transform 0.15s ease;">
                
                <div style="display: flex; gap: 14px; align-items: flex-start; flex: 1;">
                    <div style="width: 42px; height: 42px; border-radius: 12px; background: #FFFFFF; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
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
                            <a href="{{ route('customer.notifications.open', $notif->id) }}" class="btn-yellow" style="display: inline-block; padding: 6px 16px; font-size: 12px; font-weight: 800; text-decoration: none; border-radius: 6px;">
                                Open Details & Action &rarr;
                            </a>
                        @endif
                    </div>
                </div>

                @if(! $notif->is_read)
                    <form action="{{ route('customer.notifications.single-read', $notif->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-outline" style="padding: 5px 12px; font-size: 11.5px; font-weight: 700; white-space: nowrap; border-radius: 6px;" title="Mark as Read">
                            Mark Read
                        </button>
                    </form>
                @endif

            </div>
        @empty
            <div class="portal-card" style="padding: 48px; text-align: center; background: #FFFFFF; border-radius: 14px;">
                <span style="font-size: 36px; display: block; margin-bottom: 10px;">✨</span>
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0 0 6px 0;">No notifications found</h3>
                <p style="font-size: 13.5px; color: #666; margin: 0 0 16px 0;">
                    {{ $filter === 'unread' ? 'You have caught up with all your unread alerts!' : 'When you book repairs, chat with technicians, or verify services, alerts will appear here.' }}
                </p>
                @if($filter === 'unread')
                    <a href="{{ route('customer.notifications', ['filter' => 'all']) }}" class="btn-outline" style="display: inline-block; padding: 8px 18px; font-size: 13px; text-decoration: none; border-radius: 8px;">
                        View All Activity
                    </a>
                @else
                    <a href="{{ route('customer.diagnose') }}" class="btn-yellow" style="display: inline-block; padding: 8px 18px; font-size: 13px; text-decoration: none; border-radius: 8px;">
                        Book a Service &rarr;
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div style="margin-top: 24px; display: flex; justify-content: flex-end;">
            {{ $notifications->links() }}
        </div>
    @endif

</div>
@endsection
