@extends('Frontend.layouts.technician')

@section('title', 'Direct Customer Chat — FixMate AI Partner Portal')

@section('content')
<div style="height: 660px; display: grid; grid-template-columns: 300px 1fr; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden;">

    <!-- Left Conversation List -->
    <div style="border-right: 1px solid var(--border-color); display: flex; flex-direction: column;">
        <div style="padding: 16px; border-bottom: 1px solid var(--border-color);">
            <strong style="font-size: 16px; color: #111; display: block; margin-bottom: 4px;">Customer Conversations</strong>
            <span style="font-size: 12px; color: #666;">Active Booking Customers ({{ $customers->count() }})</span>
        </div>

        <div style="overflow-y: auto; flex: 1;">
            @forelse($customers as $c)
                @php
                    $isSelected = $selectedCustomer && $selectedCustomer->id === $c->id;
                    $lastMsg = \App\Models\Message::where(function($q) use ($user, $c) {
                        $q->where('sender_id', $user->id)->where('receiver_id', $c->id);
                    })->orWhere(function($q) use ($user, $c) {
                        $q->where('sender_id', $c->id)->where('receiver_id', $user->id);
                    })->latest()->first();
                @endphp
                <a href="{{ route('technician.messages', ['client_id' => $c->id]) }}" style="text-decoration: none; padding: 14px 16px; border-bottom: 1px solid var(--border-color); background: {{ $isSelected ? '#FFFDF0' : '#FFFFFF' }}; display: flex; gap: 12px; align-items: center; border-left: {{ $isSelected ? '4px solid #FFCC00' : '4px solid transparent' }};">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; flex-shrink: 0;">
                        {{ strtoupper(substr($c->name, 0, 2)) }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px; gap: 8px;">
                            <strong style="font-size: 13.5px; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $c->name }}</strong>
                            @if($lastMsg)
                                <span style="font-size: 10px; color: #888;">{{ $lastMsg->created_at->format('h:i A') }}</span>
                            @endif
                        </div>
                        <p style="font-size: 12px; color: #555; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $lastMsg ? $lastMsg->message : 'No messages yet' }}
                        </p>
                    </div>
                </a>
            @empty
                <div style="padding: 30px 20px; text-align: center; color: #888; font-size: 13px;">
                    <div style="font-size: 28px; margin-bottom: 6px;">💬</div>
                    No active booking chats yet. When customers book your services, direct message threads will appear here.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Chat Area -->
    <div style="display: flex; flex-direction: column; background: #FAFAFA;">
        @if($selectedCustomer)
            <!-- Chat Header -->
            <div style="padding: 14px 20px; background: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; flex-shrink: 0;">
                        {{ strtoupper(substr($selectedCustomer->name, 0, 2)) }}
                    </div>
                    <div style="min-width: 0;">
                        <strong style="font-size: 14.5px; color: #111; display: block;">{{ $selectedCustomer->name }}</strong>
                        <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">● Active Customer &bull; {{ $selectedCustomer->city ?? 'Karachi' }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px; flex-shrink: 0;">
                    @if($selectedCustomer->phone)
                        <a href="tel:{{ $selectedCustomer->phone }}" class="btn-outline" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">
                            📞 Call Customer
                        </a>
                    @endif
                    @if($activeBooking)
                        <a href="{{ route('technician.jobs.details', $activeBooking->booking_number) }}" class="btn-yellow" style="padding: 6px 14px; font-size: 12px; text-decoration: none; font-weight: 800;">
                            View Job #{{ $activeBooking->booking_number }} &rarr;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Job Context Strip -->
            @if($activeBooking)
                <div style="padding: 9px 20px; background: #FFFBEB; border-bottom: 1px solid #FDE68A; font-size: 12px; color: #92400E; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span style="font-weight: 800;">#{{ $activeBooking->booking_number }}</span>
                    <span>&bull;</span>
                    <span>{{ $activeBooking->service_title }}</span>
                    <span>&bull;</span>
                    <span>📍 {{ $activeBooking->service_address }}</span>
                </div>
            @endif

            <!-- Chat Stream -->
            <div id="techChatStream" style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px;">
                @forelse($chatMessages as $msg)
                    @php
                        $isMe = $msg->sender_id === $user->id;
                    @endphp
                    <div class="tech-msg-row" data-msg-id="{{ $msg->id }}" style="display: flex; gap: 10px; max-width: 75%; align-self: {{ $isMe ? 'flex-end' : 'flex-start' }};">
                        <div style="background: {{ $isMe ? '#FFCC00' : '#FFFFFF' }}; color: #111; padding: 12px 16px; border-radius: {{ $isMe ? '14px 14px 2px 14px' : '14px 14px 14px 2px' }}; border: {{ $isMe ? 'none' : '1px solid var(--border-color)' }}; font-size: 13.5px; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            {{ $msg->message }}
                            <span style="display: block; font-size: 10px; color: {{ $isMe ? '#555' : '#888' }}; margin-top: 4px; text-align: right;">
                                {{ $msg->created_at->format('h:i A') }} {{ $isMe ? '✓' : '' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div id="emptyChatNotice" style="padding: 40px; text-align: center; color: #888; font-size: 13.5px;">
                        No messages exchanged yet with {{ $selectedCustomer->name }}. Send a greeting or update below!
                    </div>
                @endforelse
            </div>

            <!-- Chat Input Bar -->
            <form id="techChatForm" action="{{ route('technician.messages.send') }}" method="POST" style="padding: 14px 20px; background: #FFFFFF; border-top: 1px solid var(--border-color); display: flex; gap: 10px; align-items: center; margin: 0;">
                @csrf
                <input type="hidden" name="receiver_id" id="techReceiverId" value="{{ $selectedCustomer->id }}">
                @if($activeBooking)
                    <input type="hidden" name="booking_id" value="{{ $activeBooking->id }}">
                @endif
                <input type="text" name="message" id="techMessageInput" required placeholder="Type a message to {{ $selectedCustomer->name }}..." class="form-input" autocomplete="off" style="flex: 1; padding: 10px 14px; font-size: 13.5px;">
                <button type="submit" id="techSendBtn" class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer;">
                    Send
                </button>
            </form>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stream = document.getElementById('techChatStream');
                const form = document.getElementById('techChatForm');
                const input = document.getElementById('techMessageInput');
                const sendBtn = document.getElementById('techSendBtn');
                const clientId = "{{ $selectedCustomer->id }}";
                const streamUrl = "{{ route('technician.messages.stream') }}";

                if (stream) {
                    stream.scrollTop = stream.scrollHeight;
                }

                let lastMsgId = 0;
                document.querySelectorAll('.tech-msg-row').forEach(el => {
                    const id = parseInt(el.getAttribute('data-msg-id'), 10);
                    if (id > lastMsgId) lastMsgId = id;
                });

                function playChatChime() {
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(587.33, ctx.currentTime);
                        osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.15);
                        gain.gain.setValueAtTime(0.08, ctx.currentTime);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.25);
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start();
                        osc.stop(ctx.currentTime + 0.25);
                    } catch (e) {}
                }

                function appendMessageBubble(msg, isMe) {
                    if (!stream) return;
                    const emptyNotice = document.getElementById('emptyChatNotice');
                    if (emptyNotice) emptyNotice.remove();

                    const row = document.createElement('div');
                    row.className = 'tech-msg-row';
                    row.setAttribute('data-msg-id', msg.id);
                    row.style.display = 'flex';
                    row.style.gap = '10px';
                    row.style.maxWidth = '75%';
                    row.style.alignSelf = isMe ? 'flex-end' : 'flex-start';

                    const safeMsg = escapeHtml(msg.message);
                    row.innerHTML = `
                        <div style="background: ${isMe ? '#FFCC00' : '#FFFFFF'}; color: #111; padding: 12px 16px; border-radius: ${isMe ? '14px 14px 2px 14px' : '14px 14px 14px 2px'}; border: ${isMe ? 'none' : '1px solid var(--border-color)'}; font-size: 13.5px; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            ${safeMsg}
                            <span style="display: block; font-size: 10px; color: ${isMe ? '#555' : '#888'}; margin-top: 4px; text-align: right;">
                                ${msg.time || 'Just now'} ${isMe ? '✓' : ''}
                            </span>
                        </div>
                    `;
                    stream.appendChild(row);
                    stream.scrollTop = stream.scrollHeight;
                }

                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                if (form && input) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const text = input.value.trim();
                        if (!text) return;

                        if (sendBtn) sendBtn.disabled = true;
                        const formData = new FormData(form);

                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                        .then(r => r.json())
                        .then(res => {
                            if (sendBtn) sendBtn.disabled = false;
                            input.value = '';
                            input.focus();

                            if (res.success && res.message) {
                                if (res.message.id > lastMsgId) {
                                    lastMsgId = res.message.id;
                                }
                                appendMessageBubble(res.message, true);
                            }
                        })
                        .catch(err => {
                            if (sendBtn) sendBtn.disabled = false;
                            form.submit();
                        });
                    });
                }

                // Poll every 3 seconds for messages from this customer
                if (clientId && streamUrl) {
                    setInterval(function() {
                        fetch(`${streamUrl}?client_id=${clientId}&after_id=${lastMsgId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(r => r.json())
                        .then(res => {
                            if (res.messages && res.messages.length > 0) {
                                let hasIncoming = false;
                                res.messages.forEach(msg => {
                                    if (msg.id > lastMsgId) {
                                        lastMsgId = msg.id;
                                        appendMessageBubble(msg, msg.is_me);
                                        if (!msg.is_me) hasIncoming = true;
                                    }
                                });
                                if (hasIncoming) playChatChime();
                            }
                        })
                        .catch(err => console.debug('Tech chat poll:', err));
                    }, 3000);
                }
            });
            </script>
        @else
            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #888; font-size: 14px; text-align: center; padding: 20px;">
                Select a customer conversation on the left to start chatting.
            </div>
        @endif
    </div>

</div>
@endsection
