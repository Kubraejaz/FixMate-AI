@extends('Frontend.layouts.master')

@section('title', 'Encrypted In-App Chat & Masked Calling — FixMate')
@section('meta_desc', 'Communicate securely with your assigned technician with in-app chat, photo sharing, and privacy-protecting masked call relay.')

@section('content')
<div class="container" style="padding-top: 28px; padding-bottom: 70px;">

    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 18px;">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <a href="{{ url('/tracking') }}">Active Job #FM-89240</a>
        <span>/</span>
        <span style="color: #111111; font-weight: 600;">Secure Chat & Relay</span>
    </div>

    <!-- Chat Messenger Container (FR-5.1 & FR-5.2) -->
    <div class="fm-card" style="padding: 0; display: grid; grid-template-columns: 320px 1fr; height: 680px; overflow: hidden; border-radius: 28px;">

        <!-- Left Column: Conversations List -->
        <div style="background: #FAFAFA; border-right: 1px solid #EEEEEE; display: flex; flex-direction: column;">
            <div style="padding: 20px; border-bottom: 1px solid #EEEEEE;">
                <h2 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 12px;">Messages</h2>
                <div style="background: #FFFFFF; border: 1px solid #E5E5E5; border-radius: 14px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Search conversations..." style="border: none; outline: none; font-size: 13px; width: 100%;">
                </div>
            </div>

            <!-- Active Thread Item -->
            <div style="background: #FFF9E6; border-left: 4px solid #FFCC00; padding: 16px 18px; display: flex; gap: 12px; cursor: pointer; transition: background 0.2s;">
                <div style="position: relative;">
                    <img src="{{ asset('assets/images/image_1.svg') }}" alt="Alex" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #FFCC00;">
                    <span style="position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; background: #10B981; border: 2px solid #FFF; border-radius: 50%;"></span>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 3px;">
                        <h4 style="font-size: 14.5px; font-weight: 700; color: #111;">Alex Rivera</h4>
                        <span style="font-size: 11px; color: #888;">Just now</span>
                    </div>
                    <p style="font-size: 12.5px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        I have the 1.5" PVC kit and am ~5 mins out!
                    </p>
                    <span style="display: inline-block; font-size: 10px; font-weight: 700; background: #111; color: #FFCC00; padding: 2px 6px; border-radius: 6px; margin-top: 4px;">Active Job #FM-89240</span>
                </div>
            </div>

            <!-- FixMate Support Thread -->
            <div style="padding: 16px 18px; display: flex; gap: 12px; cursor: pointer; border-bottom: 1px solid #F0F0F0;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 16px; flex-shrink: 0;">
                    AI
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 3px;">
                        <h4 style="font-size: 14.5px; font-weight: 700; color: #111;">FixMate Concierge</h4>
                        <span style="font-size: 11px; color: #888;">10:14 AM</span>
                    </div>
                    <p style="font-size: 12.5px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Escrow pre-authorization of $75.00 successful.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column: Active Chat Thread (FR-5.1) -->
        <div style="display: flex; flex-direction: column; background: #FFFFFF;">
            
            <!-- Thread Top Bar -->
            <div style="padding: 16px 24px; border-bottom: 1px solid #EEEEEE; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ asset('assets/images/image_1.svg') }}" alt="Alex" style="width: 44px; height: 44px; border-radius: 50%; border: 2px solid #FFCC00;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <h3 style="font-size: 16px; font-weight: 800; color: #111;">Alex Rivera (Technician)</h3>
                            <span style="color: #10B981; font-size: 14px;">✓ Verified Pro</span>
                        </div>
                        <p style="font-size: 12px; color: #757575;">En Route • ETA 8 Mins • Master Plumbing</p>
                    </div>
                </div>

                <!-- Masked Calling Relay Buttons (FR-5.3) -->
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn-secondary" onclick="openMaskedCallModal()" style="font-size: 13px; padding: 8px 14px; background: #FFF9E6; border-color: #FFECB3;">
                        📞 Masked Voice Call
                    </button>
                    <a href="{{ url('/tracking') }}" class="btn-primary" style="font-size: 13px; padding: 8px 14px;">
                        📍 Live Map
                    </a>
                </div>
            </div>

            <!-- Messages Stream -->
            <div id="messagesContainer" style="flex: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px; background: #FDFDFC;">
                
                <!-- Encryption Notice -->
                <div style="align-self: center; background: #F1F5F9; border-radius: 14px; padding: 6px 14px; font-size: 11.5px; color: #64748B;">
                    🔒 End-to-end encrypted session. Your phone number is masked for privacy.
                </div>

                <!-- Message 1 (System) -->
                <div style="align-self: center; background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 12px; padding: 8px 16px; font-size: 12px; color: #92400E;">
                    ⚡ Dispatch initiated. 4-Digit Arrival Start OTP is <strong>4829</strong>.
                </div>

                <!-- Message 2 (Tech) -->
                <div style="align-self: flex-start; max-width: 70%; display: flex; gap: 10px;">
                    <img src="{{ asset('assets/images/image_1.svg') }}" style="width: 32px; height: 32px; border-radius: 50%; align-self: flex-end;">
                    <div>
                        <div style="background: #F1F5F9; color: #1E293B; padding: 12px 16px; border-radius: 18px 18px 18px 4px; font-size: 14px; line-height: 1.4;">
                            Hello! I received your booking for the P-trap kitchen leak. I have the replacement 1.5-inch PVC kit and Teflon seals with me in the van.
                        </div>
                        <span style="font-size: 11px; color: #94A3B8; margin-top: 4px; display: block; margin-left: 6px;">10:16 AM</span>
                    </div>
                </div>

                <!-- Message 3 (Customer / User) -->
                <div style="align-self: flex-end; max-width: 70%;">
                    <div style="background: #111111; color: #FFFFFF; padding: 12px 16px; border-radius: 18px 18px 4px 18px; font-size: 14px; line-height: 1.4;">
                        Great, thank you Alex! The cabinet is cleared out and there is a bucket underneath catching the drips.
                    </div>
                    <span style="font-size: 11px; color: #94A3B8; margin-top: 4px; display: block; text-align: right; margin-right: 6px;">10:18 AM • Read ✓✓</span>
                </div>

                <!-- Message 4 (Tech with Photo Attachment FR-5.2) -->
                <div style="align-self: flex-start; max-width: 70%; display: flex; gap: 10px;">
                    <img src="{{ asset('assets/images/image_1.svg') }}" style="width: 32px; height: 32px; border-radius: 50%; align-self: flex-end;">
                    <div>
                        <div style="background: #F1F5F9; color: #1E293B; padding: 12px 16px; border-radius: 18px 18px 18px 4px; font-size: 14px; line-height: 1.4;">
                            <p style="margin-bottom: 8px;">Perfect. I am turning onto Evergreen Terrace now. I will knock and ask for the 4-digit OTP to start!</p>
                            <img src="{{ asset('assets/images/image_3.svg') }}" style="width: 220px; height: 110px; border-radius: 10px; object-fit: cover; border: 1px solid #CBD5E1;">
                        </div>
                        <span style="font-size: 11px; color: #94A3B8; margin-top: 4px; display: block; margin-left: 6px;">Just now</span>
                    </div>
                </div>

            </div>

            <!-- Quick Response Chips (FR-5.2) -->
            <div style="padding: 10px 20px; background: #FFFFFF; border-top: 1px solid #F0F0F0; display: flex; gap: 8px; overflow-x: auto;">
                <button type="button" class="btn-secondary" onclick="sendQuickReply('I am at the front door!')" style="font-size: 12px; padding: 5px 12px; white-space: nowrap;">
                    👋 I'm at the front door
                </button>
                <button type="button" class="btn-secondary" onclick="sendQuickReply('Please ring the bell upon arrival.')" style="font-size: 12px; padding: 5px 12px; white-space: nowrap;">
                    🔔 Please ring the bell
                </button>
                <button type="button" class="btn-secondary" onclick="sendQuickReply('Water shutoff valve is in the basement.')" style="font-size: 12px; padding: 5px 12px; white-space: nowrap;">
                    🚰 Shutoff valve in basement
                </button>
            </div>

            <!-- Input Box -->
            <div style="padding: 16px 20px; border-top: 1px solid #EEEEEE; background: #FFFFFF; display: flex; align-items: center; gap: 12px;">
                <button type="button" class="btn-secondary" style="padding: 10px; border-radius: 50%;" title="Attach Photo or Video" onclick="showToast('Photo attachment dialog opened')">
                    📎
                </button>
                <input type="text" id="chatInput" placeholder="Type a secure message to Alex..." style="flex: 1; border: 1px solid #DCDCDC; border-radius: 20px; padding: 12px 18px; font-size: 14px; outline: none;" onkeydown="if(event.key==='Enter') sendMessage()">
                <button type="button" class="btn-primary" onclick="sendMessage()" style="padding: 12px 20px;">
                    <span>Send</span>
                    <span>➤</span>
                </button>
            </div>

        </div>

    </div>

    <!-- Masked Calling Modal (FR-5.3 Simulation) -->
    <div id="maskedCallModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: #111111; color: #FFFFFF; border-radius: 28px; width: 360px; padding: 32px 24px; text-align: center; border: 1px solid #333333; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
            <div style="width: 72px; height: 72px; border-radius: 50%; border: 3px solid #FFCC00; margin: 0 auto 16px auto; overflow: hidden;">
                <img src="{{ asset('assets/images/image_1.svg') }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 4px;">Calling Alex Rivera</h3>
            <p style="font-size: 12.5px; color: #AAAAAA; margin-bottom: 12px;">Protected via FixMate Voice Relay</p>
            <div style="background: #222222; border-radius: 12px; padding: 8px 12px; font-size: 12px; color: #FFCC00; margin-bottom: 24px;">
                🔒 Both real phone numbers remain 100% private
            </div>

            <!-- Call Controls -->
            <div style="display: flex; justify-content: center; gap: 20px;">
                <button type="button" onclick="closeMaskedCallModal()" style="width: 56px; height: 56px; border-radius: 50%; background: #EF4444; color: #FFF; font-size: 24px; display: flex; align-items: center; justify-content: center;">
                    ✕
                </button>
                <button type="button" style="width: 56px; height: 56px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 24px; display: flex; align-items: center; justify-content: center;">
                    🎤
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@section('extra_js')
<script>
    function openMaskedCallModal() {
        const modal = document.getElementById('maskedCallModal');
        modal.style.display = 'flex';
    }

    function closeMaskedCallModal() {
        const modal = document.getElementById('maskedCallModal');
        modal.style.display = 'none';
    }

    function sendQuickReply(text) {
        document.getElementById('chatInput').value = text;
        sendMessage();
    }

    function sendMessage() {
        const input = document.getElementById('chatInput');
        const text = input.value.trim();
        if (!text) return;

        const container = document.getElementById('messagesContainer');
        const bubble = document.createElement('div');
        bubble.style.cssText = "align-self: flex-end; max-width: 70%;";
        bubble.innerHTML = `
            <div style="background: #111111; color: #FFFFFF; padding: 12px 16px; border-radius: 18px 18px 4px 18px; font-size: 14px; line-height: 1.4;">
                ${escapeHtml(text)}
            </div>
            <span style="font-size: 11px; color: #94A3B8; margin-top: 4px; display: block; text-align: right; margin-right: 6px;">Just now • Sent ✓</span>
        `;
        container.appendChild(bubble);
        input.value = '';
        container.scrollTop = container.scrollHeight;

        // Simulated Auto-Reply from Tech after 1.5s
        setTimeout(() => {
            const reply = document.createElement('div');
            reply.style.cssText = "align-self: flex-start; max-width: 70%; display: flex; gap: 10px;";
            reply.innerHTML = `
                <img src="{{ asset('assets/images/image_1.svg') }}" style="width: 32px; height: 32px; border-radius: 50%; align-self: flex-end;">
                <div>
                    <div style="background: #F1F5F9; color: #1E293B; padding: 12px 16px; border-radius: 18px 18px 18px 4px; font-size: 14px; line-height: 1.4;">
                        Got it! I am just pulling up into the driveway now. See you in a minute!
                    </div>
                    <span style="font-size: 11px; color: #94A3B8; margin-top: 4px; display: block; margin-left: 6px;">Just now</span>
                </div>
            `;
            container.appendChild(reply);
            container.scrollTop = container.scrollHeight;
        }, 1200);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endsection
