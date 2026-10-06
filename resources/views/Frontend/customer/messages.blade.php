@extends('Frontend.layouts.customer')

@section('title', 'Direct Messages & Technician Chat — FixMate')

@section('content')
<div style="height: 680px; display: grid; grid-template-columns: 300px 1fr; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
    
    <!-- Left Conversation List -->
    <div style="border-right: 1px solid var(--border-color); display: flex; flex-direction: column; background: #FFFFFF;">
        <div style="padding: 16px; border-bottom: 1px solid var(--border-color);">
            <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 8px;">Technician Chats ({{ $assignedTechnicians->count() }})</strong>
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
            @php
                $rawPhone = $selectedTech->phone ?: '03001234567';
                $waPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                if (str_starts_with($waPhone, '0')) {
                    $waPhone = '92' . substr($waPhone, 1);
                }
            @endphp

            <!-- Chat Header -->
            <div style="padding: 14px 20px; background: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ asset($selectedTech->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $selectedTech->name }}" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                    <div>
                        <strong style="font-size: 14px; color: #111; display: block;">{{ $selectedTech->name }}</strong>
                        <span style="font-size: 11px; color: #047857; font-weight: 700;">
                            ● Active Verified • {{ $selectedTech->profession->name ?? 'Technician' }} • {{ $rawPhone }}
                        </span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px; align-items: center;">
                    <!-- Interactive Call Button Trigger -->
                    <button type="button" id="openCallModalBtn" class="btn-outline" style="padding: 7px 14px; font-size: 12.5px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span>📞</span> <span>Call Technician</span>
                    </button>

                    @if($activeBooking)
                        <a href="{{ route('customer.bookings') }}" class="btn-yellow" style="padding: 7px 14px; font-size: 12.5px; text-decoration: none; border-radius: 8px; font-weight: 700;">
                            📋 View Booking
                        </a>
                    @else
                        <a href="{{ route('customer.booking', ['tech_id' => $selectedTech->id]) }}" class="btn-yellow" style="padding: 7px 14px; font-size: 12.5px; text-decoration: none; border-radius: 8px; font-weight: 700;">
                            Book Service
                        </a>
                    @endif
                </div>
            </div>

            <!-- Chat Stream -->
            <div id="chatMessageStream" style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px;">
                
                <!-- Welcome Handshake Bubble -->
                <div style="display: flex; gap: 10px; max-width: 80%; align-self: flex-start;">
                    <div style="background: #FFFFFF; border: 1px solid var(--border-color); padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13.5px; color: #111; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                        Assalam o Alaikum <strong>{{ $user->name }}</strong>! I am {{ $selectedTech->name }} ({{ $selectedTech->profession->name ?? 'Professional' }}). Let me know if you need specific spare parts or have directions to your gate/address.
                        <span style="display: block; font-size: 10px; color: #888; margin-top: 4px; text-align: right;">FixMate Verified Handshake</span>
                    </div>
                </div>

                @if($activeBooking)
                    <!-- Active Booking Context Bubble -->
                    <div style="display: flex; gap: 10px; max-width: 80%; align-self: flex-start;">
                        <div style="background: #FFFDF0; border: 1px solid #FEF08A; padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13px; color: #92400E; line-height: 1.5;">
                            📌 Regarding Booking <strong>#{{ $activeBooking->booking_number }}</strong> ({{ $activeBooking->service_title }}): Scheduled for {{ $activeBooking->service_date ? $activeBooking->service_date->format('M d, Y') : 'Today' }} • {{ $activeBooking->service_time_slot }}.
                            <span style="display: block; font-size: 11px; margin-top: 4px;">Arrival OTP: <strong>{{ $activeBooking->arrival_otp }}</strong></span>
                        </div>
                    </div>
                @endif

                <!-- Dynamic Chat Conversation from Database -->
                @foreach($chatMessages as $msg)
                    @php $isMine = $msg->sender_id === auth()->id(); @endphp
                    <div class="chat-bubble-row" data-msg-id="{{ $msg->id }}" style="display: flex; gap: 10px; max-width: 75%; align-self: {{ $isMine ? 'flex-end' : 'flex-start' }};">
                        <div style="background: {{ $isMine ? '#FFB800' : '#FFFFFF' }}; color: #0F172A; border: {{ $isMine ? 'none' : '1px solid var(--border-color)' }}; padding: 10px 14px; border-radius: {{ $isMine ? '14px 14px 2px 14px' : '14px 14px 14px 2px' }}; font-size: 13.5px; line-height: 1.45; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            <p style="margin: 0; white-space: pre-wrap;">{{ $msg->message }}</p>
                            <span style="display: block; font-size: 10px; color: {{ $isMine ? '#78350F' : '#94A3B8' }}; margin-top: 4px; text-align: right;">
                                {{ $msg->created_at->format('h:i A') }} • {{ $isMine ? 'Sent' : $selectedTech->name }}
                            </span>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Chat Input Bar -->
            <form id="chatSendForm" action="{{ route('customer.messages.send') }}" method="POST" style="padding: 14px 20px; background: #FFFFFF; border-top: 1px solid var(--border-color); display: flex; gap: 10px; align-items: center;">
                @csrf
                <input type="hidden" name="technician_id" id="chatTechId" value="{{ $selectedTech->id }}">
                @if($activeBooking)
                    <input type="hidden" name="booking_id" value="{{ $activeBooking->id }}">
                @endif
                <input type="text" name="message" id="messageInput" placeholder="Type a message to {{ $selectedTech->name }}..." class="form-input" required autocomplete="off" style="flex: 1; padding: 10px 14px; font-size: 13.5px;">
                <button type="submit" id="chatSendBtn" class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                    Send
                </button>
            </form>

            <!-- Call & Contact Modal -->
            <div id="callModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
                <div style="background: #FFFFFF; border-radius: 16px; width: 90%; max-width: 420px; padding: 26px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative; text-align: center;">
                    
                    <button type="button" id="closeCallModalBtn" style="position: absolute; top: 14px; right: 14px; background: none; border: none; font-size: 18px; color: #94A3B8; cursor: pointer;">✕</button>

                    <img src="{{ asset($selectedTech->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $selectedTech->name }}" style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 3px solid #FFB800; margin: 0 auto 12px auto; display: block;">
                    
                    <h3 style="font-size: 18px; font-weight: 900; color: #0F172A; margin-bottom: 2px;">{{ $selectedTech->name }}</h3>
                    <p style="font-size: 13px; color: #64748B; margin: 0 0 16px 0;">{{ $selectedTech->profession->name ?? 'Technician' }} • FixMate Verified</p>

                    <!-- Phone Number Display Card -->
                    <div style="background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 12px; padding: 14px; margin-bottom: 20px;">
                        <span style="font-size: 11px; text-transform: uppercase; color: #64748B; font-weight: 700; display: block; margin-bottom: 4px;">Direct Contact Number</span>
                        <strong id="displayPhoneNum" style="font-size: 20px; font-weight: 900; color: #0F172A; letter-spacing: 0.5px; display: block;">{{ $rawPhone }}</strong>
                    </div>

                    <!-- Action Grid -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <!-- Copy Button -->
                        <button type="button" id="copyPhoneBtn" class="btn-outline" style="width: 100%; padding: 11px 0; font-size: 13.5px; font-weight: 700; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <span id="copyIcon">📋</span> <span id="copyText">Copy Phone Number</span>
                        </button>

                        <!-- WhatsApp Direct Link -->
                        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode('Hello ' . $selectedTech->name . ', I am contacting you regarding my FixMate service booking.') }}" target="_blank" rel="noopener noreferrer" style="background: #25D366; color: #FFFFFF; font-weight: 800; font-size: 13.5px; padding: 11px 0; border-radius: 10px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <span>💬</span> <span>Open in WhatsApp</span>
                        </a>

                        <!-- Direct Phone Dialer -->
                        <a href="tel:{{ $rawPhone }}" style="background: #0F172A; color: #FFFFFF; font-weight: 800; font-size: 13.5px; padding: 11px 0; border-radius: 10px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <span>📞</span> <span>Dial via Phone App</span>
                        </a>
                    </div>

                    <p style="font-size: 11px; color: #94A3B8; margin: 16px 0 0 0;">
                        Calls may be monitored by FixMate Quality Arbitration for customer safety.
                    </p>
                </div>
            </div>

        @else
            <div style="flex: 1; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #888; padding: 32px;">
                <span style="font-size: 40px; margin-bottom: 12px;">✉️</span>
                <strong style="font-size: 16px; color: #111; margin-bottom: 4px;">Select a conversation</strong>
                <span style="font-size: 13px;">Choose a technician from the left list to begin messaging.</span>
            </div>
        @endif

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Scroll chat to bottom
    const stream = document.getElementById('chatMessageStream');
    if (stream) {
        stream.scrollTop = stream.scrollHeight;
    }

    // Web Audio Chime for new incoming messages
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

    // 2. Real-Time Asynchronous Chat Engine
    const chatForm = document.getElementById('chatSendForm');
    const msgInput = document.getElementById('messageInput');
    const techName = "{{ $selectedTech->name ?? 'Technician' }}";
    const streamUrl = "{{ route('customer.messages.stream') }}";
    const techId = "{{ $selectedTech->id ?? '' }}";

    // Track highest message ID rendered on screen
    let lastMsgId = 0;
    document.querySelectorAll('.chat-bubble-row').forEach(el => {
        const id = parseInt(el.getAttribute('data-msg-id'), 10);
        if (id > lastMsgId) lastMsgId = id;
    });

    function appendMessageBubble(msg, isMine) {
        if (!stream) return;
        const row = document.createElement('div');
        row.className = 'chat-bubble-row';
        row.setAttribute('data-msg-id', msg.id);
        row.style.display = 'flex';
        row.style.gap = '10px';
        row.style.maxWidth = '75%';
        row.style.alignSelf = isMine ? 'flex-end' : 'flex-start';

        row.innerHTML = `
            <div style="background: ${isMine ? '#FFB800' : '#FFFFFF'}; color: #0F172A; border: ${isMine ? 'none' : '1px solid var(--border-color)'}; padding: 10px 14px; border-radius: ${isMine ? '14px 14px 2px 14px' : '14px 14px 14px 2px'}; font-size: 13.5px; line-height: 1.45; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                <p style="margin: 0; white-space: pre-wrap;">${escapeHtml(msg.message)}</p>
                <span style="display: block; font-size: 10px; color: ${isMine ? '#78350F' : '#94A3B8'}; margin-top: 4px; text-align: right;">
                    ${msg.time || 'Just now'} • ${isMine ? 'Sent' : techName}
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

    if (chatForm && msgInput) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = msgInput.value.trim();
            if (!text) return;

            const sendBtn = document.getElementById('chatSendBtn');
            const originalBtnText = sendBtn ? sendBtn.textContent : 'Send';
            if (sendBtn) sendBtn.disabled = true;

            const formData = new FormData(chatForm);

            fetch(chatForm.action, {
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
                msgInput.value = '';
                msgInput.focus();

                if (res.success && res.message) {
                    if (res.message.id > lastMsgId) {
                        lastMsgId = res.message.id;
                    }
                    appendMessageBubble(res.message, true);
                }
            })
            .catch(err => {
                if (sendBtn) sendBtn.disabled = false;
                // If network fails, submit standard form
                chatForm.submit();
            });
        });
    }

    // Poll for incoming messages from technician every 3 seconds
    if (techId && streamUrl) {
        setInterval(function() {
            fetch(`${streamUrl}?tech_id=${techId}&after_id=${lastMsgId}`, {
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
            .catch(err => console.debug('Chat poll:', err));
        }, 3000);
    }

    // 3. Call Modal triggers
    const openBtn = document.getElementById('openCallModalBtn');
    const closeBtn = document.getElementById('closeCallModalBtn');
    const modal = document.getElementById('callModal');
    const copyBtn = document.getElementById('copyPhoneBtn');
    const phoneNum = "{{ $selectedTech->phone ?? '03001234567' }}";

    if (openBtn && modal) {
        openBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
        });

        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(phoneNum).then(function() {
                const icon = document.getElementById('copyIcon');
                const text = document.getElementById('copyText');
                icon.textContent = '✓';
                text.textContent = 'Copied to Clipboard!';
                copyBtn.style.background = '#ECFDF5';
                copyBtn.style.borderColor = '#10B981';
                copyBtn.style.color = '#047857';
                setTimeout(function() {
                    icon.textContent = '📋';
                    text.textContent = 'Copy Phone Number';
                    copyBtn.style.background = '';
                    copyBtn.style.borderColor = '';
                    copyBtn.style.color = '';
                }, 2500);
            }).catch(function() {
                alert('Phone number: ' + phoneNum);
            });
        });
    }
});
</script>
@endsection
