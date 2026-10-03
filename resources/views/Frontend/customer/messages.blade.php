@extends('Frontend.layouts.customer')

@section('title', 'Direct Messages & Technician Chat — FixMate AI')

@section('content')
<div style="height: 660px; display: grid; grid-template-columns: 300px 1fr; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
    
    <!-- Left Conversation List -->
    <div style="border-right: 1px solid var(--border-color); display: flex; flex-direction: column; background: #FFFFFF;">
        <div style="padding: 16px; border-bottom: 1px solid var(--border-color);">
            <strong style="font-size: 16px; color: #111; display: block; margin-bottom: 8px;">Technician Chats ({{ $assignedTechnicians->count() }})</strong>
            <form action="{{ route('customer.messages') }}" method="GET">
                <input type="text" name="q" placeholder="Filter conversations..." value="{{ request('q') }}" class="form-input" style="padding: 7px 10px; font-size: 12.5px;">
            </form>
        </div>

        <div style="overflow-y: auto; flex: 1;">
            @forelse($assignedTechnicians as $tech)
                @php $isSelected = $selectedTech && $selectedTech->id === $tech->id; @endphp
                <a href="{{ route('customer.messages', ['tech_id' => $tech->id]) }}" style="text-decoration: none; padding: 14px 16px; border-bottom: 1px solid var(--border-color); background: {{ $isSelected ? '#FFFDF0' : '#FFFFFF' }}; cursor: pointer; display: flex; gap: 12px; align-items: center; border-left: {{ $isSelected ? '4px solid #FFCC00' : '4px solid transparent' }};">
                    <img src="{{ asset($tech->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $tech->name }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                            <strong style="font-size: 13.5px; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $tech->name }}</strong>
                            <span style="font-size: 10px; color: #059669; font-weight: 700;">● Online</span>
                        </div>
                        <p style="font-size: 12px; color: #666; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $tech->profession->name ?? 'Verified Professional' }}
                        </p>
                    </div>
                </a>
            @empty
                <div style="padding: 32px 16px; text-align: center; color: #888;">
                    <span style="font-size: 28px; display: block; margin-bottom: 6px;">💬</span>
                    <strong style="display: block; font-size: 14px; color: #111; margin-bottom: 4px;">No Assigned Technicians</strong>
                    <span style="font-size: 12px;">When you book a service, your assigned professional will appear here.</span>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Chat Area -->
    <div style="display: flex; flex-direction: column; background: #FAFAFA;">
        
        @if($selectedTech)
            <!-- Chat Header -->
            <div style="padding: 14px 20px; background: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ asset($selectedTech->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $selectedTech->name }}" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">{{ $selectedTech->name }}</strong>
                        <span style="font-size: 11px; color: #047857; font-weight: 700;">
                            ● Active Verified • {{ $selectedTech->profession->name ?? 'Technician' }}
                        </span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px;">
                    <a href="tel:{{ $selectedTech->phone ?? '03001234567' }}" class="btn-outline" style="padding: 6px 14px; font-size: 12px; text-decoration: none; border-radius: 6px;">📞 Call</a>
                    @if($activeBooking)
                        <a href="{{ route('customer.booking.tracking', $activeBooking->id) }}" class="btn-yellow" style="padding: 6px 14px; font-size: 12px; text-decoration: none; border-radius: 6px;">📍 Live Route</a>
                    @else
                        <a href="{{ route('customer.booking', ['tech_id' => $selectedTech->id]) }}" class="btn-yellow" style="padding: 6px 14px; font-size: 12px; text-decoration: none; border-radius: 6px;">Book Service</a>
                    @endif
                </div>
            </div>

            <!-- Chat Stream -->
            <div style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px;">
                
                <!-- Welcome Handshake Bubble -->
                <div style="display: flex; gap: 10px; max-width: 75%;">
                    <div style="background: #FFFFFF; border: 1px solid var(--border-color); padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13.5px; color: #111; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                        Assalam o Alaikum <strong>{{ $user->name }}</strong>! I am {{ $selectedTech->name }} ({{ $selectedTech->profession->name ?? 'Professional' }}). Let me know if you need specific spare parts or have directions to your gate/address.
                        <span style="display: block; font-size: 10px; color: #888; margin-top: 4px; text-align: right;">FixMate Verified Handshake</span>
                    </div>
                </div>

                @if($activeBooking)
                    <!-- Active Booking Context Bubble -->
                    <div style="display: flex; gap: 10px; max-width: 75%;">
                        <div style="background: #FFFDF0; border: 1px solid #FEF08A; padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13.5px; color: #92400E; line-height: 1.5;">
                            📌 Regarding Booking <strong>#{{ $activeBooking->booking_number }}</strong> ({{ $activeBooking->service_title }}): Scheduled for {{ $activeBooking->service_date ? $activeBooking->service_date->format('M d, Y') : 'Today' }} • {{ $activeBooking->service_time_slot }}.
                            <span style="display: block; font-size: 11px; margin-top: 4px;">Status: <strong>{{ $activeBooking->status_label }}</strong></span>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Chat Input Bar -->
            <form action="{{ route('customer.messages.send') }}" method="POST" style="padding: 14px 20px; background: #FFFFFF; border-top: 1px solid var(--border-color); display: flex; gap: 10px; align-items: center;">
                @csrf
                <input type="hidden" name="technician_id" value="{{ $selectedTech->id }}">
                <input type="text" name="message" placeholder="Type a message to {{ $selectedTech->name }}..." class="form-input" required style="flex: 1; padding: 10px 14px; font-size: 13.5px;">
                <button type="submit" class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                    Send
                </button>
            </form>
        @else
            <div style="flex: 1; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #888; padding: 32px;">
                <span style="font-size: 40px; margin-bottom: 12px;">✉️</span>
                <strong style="font-size: 16px; color: #111; margin-bottom: 4px;">Select a conversation</strong>
                <span style="font-size: 13px;">Choose a technician from the left list to begin messaging.</span>
            </div>
        @endif

    </div>

</div>
@endsection
