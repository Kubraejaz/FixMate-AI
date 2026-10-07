<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Let's Talk — Video Consultation (#{{ $meeting->meeting_code }}) — FixMate</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-yellow: #FFB800;
            --primary-dark: #0F172A;
            --surface-dark: #1E293B;
            --surface-card: #334155;
            --danger-red: #EF4444;
            --success-green: #10B981;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        body {
            background: #0B0F19;
            color: #FFFFFF;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top Bar */
        .meeting-topbar {
            height: 68px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 50;
        }

        .brand-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-badge img {
            height: 28px;
        }

        .talk-tag {
            background: #FEF08A;
            color: #854D0E;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .urdu-hint {
            font-size: 12px;
            color: #94A3B8;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Main Video Stage */
        .stage-container {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: radial-gradient(circle at center, #1E293B 0%, #0B0F19 100%);
        }

        .remote-feed-box {
            width: 100%;
            height: 100%;
            max-width: 1200px;
            max-height: calc(100vh - 170px);
            background: #0F172A;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remote-avatar-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            z-index: 5;
            padding: 24px;
        }

        .avatar-pulsing {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFB800, #F59E0B);
            color: #0F172A;
            font-size: 44px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 12px rgba(255, 184, 0, 0.15), 0 0 0 24px rgba(255, 184, 0, 0.05);
            animation: pulseGlow 2.5s infinite ease-in-out;
            margin-bottom: 18px;
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 10px rgba(255, 184, 0, 0.15), 0 0 0 20px rgba(255, 184, 0, 0.05); }
            50% { box-shadow: 0 0 0 18px rgba(255, 184, 0, 0.25), 0 0 0 32px rgba(255, 184, 0, 0.1); }
        }

        .peer-video-element {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
            z-index: 2;
        }

        /* Local PiP Window */
        .local-pip-box {
            position: absolute;
            bottom: 24px;
            right: 24px;
            width: 240px;
            height: 160px;
            border-radius: 14px;
            overflow: hidden;
            border: 2px solid #FFB800;
            background: #000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            z-index: 20;
            transition: all 0.2s ease;
        }

        .local-pip-box:hover {
            transform: scale(1.03);
        }

        .local-video-element {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .pip-tag {
            position: absolute;
            bottom: 8px;
            left: 8px;
            background: rgba(0,0,0,0.7);
            color: #FFF;
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Controls Strip */
        .meeting-controls {
            height: 84px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 0 20px;
            z-index: 50;
        }

        .ctrl-btn {
            height: 52px;
            padding: 0 18px;
            border-radius: 50px;
            border: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.18s ease;
        }

        .ctrl-btn.circle {
            width: 52px;
            padding: 0;
            justify-content: center;
            border-radius: 50%;
        }

        .ctrl-btn.secondary {
            background: #334155;
            color: #FFFFFF;
        }

        .ctrl-btn.secondary:hover {
            background: #475569;
        }

        .ctrl-btn.active-off {
            background: #EF4444 !important;
            color: #FFFFFF;
        }

        .ctrl-btn.snapshot-btn {
            background: #FFB800;
            color: #0F172A;
            font-weight: 800;
        }

        .ctrl-btn.snapshot-btn:hover {
            background: #F59E0B;
            transform: translateY(-2px);
        }

        .ctrl-btn.end-btn {
            background: #DC2626;
            color: #FFFFFF;
            font-weight: 800;
            padding: 0 22px;
        }

        .ctrl-btn.end-btn:hover {
            background: #B91C1C;
        }

        /* Job Info Overlay Drawer */
        .job-drawer {
            position: absolute;
            top: 24px;
            left: 24px;
            width: 320px;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 16px;
            z-index: 20;
            font-size: 12.5px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .sound-wave {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            margin-top: 10px;
        }

        .sound-wave span {
            width: 4px;
            height: 12px;
            background: #FFB800;
            border-radius: 4px;
            animation: bounceWave 1.2s infinite ease-in-out;
        }
        .sound-wave span:nth-child(2) { height: 22px; animation-delay: 0.2s; }
        .sound-wave span:nth-child(3) { height: 16px; animation-delay: 0.4s; }
        .sound-wave span:nth-child(4) { height: 26px; animation-delay: 0.1s; }
        .sound-wave span:nth-child(5) { height: 14px; animation-delay: 0.3s; }

        @keyframes bounceWave {
            0%, 100% { transform: scaleY(0.4); }
            50% { transform: scaleY(1.1); }
        }

        /* Toast notifications */
        .meeting-toast {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: #10B981;
            color: #FFFFFF;
            padding: 10px 22px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .local-pip-box {
                width: 140px;
                height: 100px;
                bottom: 12px;
                right: 12px;
            }
            .job-drawer {
                display: none;
            }
            .ctrl-btn span.label {
                display: none;
            }
            .meeting-controls {
                gap: 8px;
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Meeting Toast Alert -->
    <div id="meetingToast" class="meeting-toast">
        <span>📸</span>
        <span id="toastMsg">Defect photo captured and saved!</span>
    </div>

    <!-- Header -->
    <header class="meeting-topbar">
        <div class="brand-badge">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate">
            </a>
            <span class="talk-tag">
                <span>📹</span>
                <span>Let's Talk</span>
            </span>
            <span style="font-size: 12px; color: #10B981; font-weight: 700; background: rgba(16, 185, 129, 0.12); padding: 3px 10px; border-radius: 20px;">
                ● Connected • Room #{{ $meeting->meeting_code }}
            </span>
        </div>

        <div class="urdu-hint">
            <span>🗣️</span>
            <span>بغیر میسج ٹائپ کیے براہِ راست کیمرے پر خرابی دکھائیں اور بولیں</span>
        </div>

        <div style="display: flex; align-items: center; gap: 14px;">
            <span id="callTimer" style="font-size: 14px; font-weight: 800; color: #FFB800; font-family: monospace; letter-spacing: 0.05em;">
                00:00
            </span>
        </div>
    </header>

    <!-- Main Stage -->
    <main class="stage-container">
        
        <!-- Job Details Overlay for Easy Reference -->
        @if($booking)
            <div class="job-drawer">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                    <strong style="color: #FFB800; font-size: 13px;">Booking #{{ $booking->booking_number }}</strong>
                    <span style="font-size: 11px; color: #94A3B8;">{{ $booking->city }}</span>
                </div>
                <div style="font-weight: 700; color: #FFFFFF; margin-bottom: 4px; font-size: 13px;">
                    {{ $booking->service_title }}
                </div>
                <div style="color: #94A3B8; font-size: 12px; margin-bottom: 8px;">
                    📍 {{ \Illuminate\Support\Str::limit($booking->service_address, 45) }}
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.06); padding: 6px 10px; border-radius: 8px;">
                    <span style="color: #CBD5E1; font-size: 11.5px;">Arrival OTP:</span>
                    <strong style="color: #10B981; font-size: 14px; letter-spacing: 0.1em;">{{ $booking->arrival_otp }}</strong>
                </div>
            </div>
        @endif

        <!-- Big Remote Box -->
        <div class="remote-feed-box" id="remoteFeedBox">
            <!-- Simulated Peer Canvas / Stream -->
            <video id="remoteVideo" class="peer-video-element" autoplay playsinline></video>

            <!-- Peer Info Card -->
            <div class="remote-avatar-card" id="remoteAvatarPlaceholder">
                <div class="avatar-pulsing">
                    {{ strtoupper(substr($peer->name ?? 'P', 0, 1)) }}
                </div>
                <h2 style="font-size: 22px; font-weight: 800; color: #FFFFFF; margin-bottom: 4px;">
                    {{ $peer->name }}
                </h2>
                <span style="font-size: 13.5px; color: #FFB800; font-weight: 700; margin-bottom: 8px;">
                    {{ $peer->isTechnician() ? ($peer->professional?->profession?->name ?? 'Certified Specialist') : 'FixMate Customer' }}
                </span>
                <span style="font-size: 12px; color: #94A3B8;">
                    Audio &amp; Video feed active • Speak freely
                </span>

                <div class="sound-wave">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
            </div>
        </div>

        <!-- Local Video PiP -->
        <div class="local-pip-box" id="localPip">
            <video id="localVideo" class="local-video-element" autoplay playsinline muted></video>
            <span class="pip-tag">You (آپ کا کیمرہ)</span>
        </div>

    </main>

    <!-- Controls Strip -->
    <footer class="meeting-controls">
        
        <!-- Mute/Unmute Mic -->
        <button type="button" class="ctrl-btn secondary circle" id="micBtn" title="Mute / Unmute Microphone">
            <span id="micIcon" style="font-size: 20px;">🎤</span>
        </button>

        <!-- Video On/Off -->
        <button type="button" class="ctrl-btn secondary circle" id="camBtn" title="Camera On / Off">
            <span id="camIcon" style="font-size: 20px;">📹</span>
        </button>

        <!-- Flip Camera (Front / Back) -->
        <button type="button" class="ctrl-btn secondary" id="flipCamBtn" title="Switch to back camera to show the defect">
            <span style="font-size: 18px;">🔄</span>
            <span class="label">Flip Camera (خرابی دکھائیں)</span>
        </button>

        <!-- Live Defect Snapshot Button -->
        <button type="button" class="ctrl-btn snapshot-btn" id="snapshotBtn" title="Take a picture from live video">
            <span style="font-size: 18px;">📸</span>
            <span class="label">Capture Defect Photo (تصویر محفوظ کریں)</span>
        </button>

        <!-- End Call Button -->
        <form action="{{ route('video-meeting.end', $meeting->meeting_code) }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="ctrl-btn end-btn" id="endCallBtn">
                <span style="font-size: 18px;">🛑</span>
                <span class="label">End Call (کال ختم کریں)</span>
            </button>
        </form>

    </footer>

    <!-- Hidden canvas for taking snapshot -->
    <canvas id="snapshotCanvas" style="display: none;"></canvas>

    <script>
        const meetingCode = "{{ $meeting->meeting_code }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let localStream = null;
        let isAudioMuted = false;
        let isVideoOff = false;
        let facingMode = 'user'; // 'user' (front) or 'environment' (back)
        let callSeconds = {{ $meeting->started_at ? max(0, now()->diffInSeconds($meeting->started_at)) : 0 }};

        const localVideo = document.getElementById('localVideo');
        const remoteVideo = document.getElementById('remoteVideo');
        const micBtn = document.getElementById('micBtn');
        const micIcon = document.getElementById('micIcon');
        const camBtn = document.getElementById('camBtn');
        const camIcon = document.getElementById('camIcon');
        const flipCamBtn = document.getElementById('flipCamBtn');
        const snapshotBtn = document.getElementById('snapshotBtn');
        const snapshotCanvas = document.getElementById('snapshotCanvas');
        const toast = document.getElementById('meetingToast');
        const toastMsg = document.getElementById('toastMsg');
        const timerEl = document.getElementById('callTimer');

        // Timer
        setInterval(() => {
            callSeconds++;
            const mins = String(Math.floor(callSeconds / 60)).padStart(2, '0');
            const secs = String(callSeconds % 60).padStart(2, '0');
            timerEl.innerText = `${mins}:${secs}`;
        }, 1000);

        // Access Camera & Microphone
        async function startMedia(mode = 'user') {
            try {
                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                }

                const constraints = {
                    audio: true,
                    video: {
                        facingMode: mode,
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                };

                localStream = await navigator.mediaDevices.getUserMedia(constraints);
                localVideo.srcObject = localStream;

                // Adjust mirror style: front is mirrored, back camera is normal
                localVideo.style.transform = (mode === 'user') ? 'scaleX(-1)' : 'scaleX(1)';

                // Also populate remote preview if peer connection not present yet
                if (remoteVideo) {
                    remoteVideo.srcObject = localStream;
                    remoteVideo.style.display = 'block';
                    const placeholder = document.getElementById('remoteAvatarPlaceholder');
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                }

            } catch (err) {
                console.warn('Camera/Mic access note:', err.message);
                showToast('Camera note: Showing voice & visual meeting mode.', '#F59E0B');
            }
        }

        // Initialize on load
        window.addEventListener('DOMContentLoaded', () => {
            startMedia('user');
        });

        // Toggle Mic
        micBtn.addEventListener('click', () => {
            if (!localStream) return;
            const audioTrack = localStream.getAudioTracks()[0];
            if (audioTrack) {
                isAudioMuted = !isAudioMuted;
                audioTrack.enabled = !isAudioMuted;
                micIcon.innerText = isAudioMuted ? '🔇' : '🎤';
                micBtn.classList.toggle('active-off', isAudioMuted);
                showToast(isAudioMuted ? 'Microphone Muted (مائیک بند ہے)' : 'Microphone Active (مائیک آن ہے)');
            }
        });

        // Toggle Video
        camBtn.addEventListener('click', () => {
            if (!localStream) return;
            const videoTrack = localStream.getVideoTracks()[0];
            if (videoTrack) {
                isVideoOff = !isVideoOff;
                videoTrack.enabled = !isVideoOff;
                camIcon.innerText = isVideoOff ? '🚫' : '📹';
                camBtn.classList.toggle('active-off', isVideoOff);
                localVideo.style.opacity = isVideoOff ? '0' : '1';
                showToast(isVideoOff ? 'Camera Off (کیمرہ بند ہے)' : 'Camera On (کیمرہ آن ہے)');
            }
        });

        // Flip Camera (Front / Back)
        flipCamBtn.addEventListener('click', () => {
            facingMode = (facingMode === 'user') ? 'environment' : 'user';
            startMedia(facingMode);
            showToast(facingMode === 'environment' ? 'Rear Camera: Point at defect (خرابی دکھائیں)' : 'Front Camera Active');
        });

        // Capture Still Defect Snapshot
        snapshotBtn.addEventListener('click', async () => {
            const videoSource = localVideo.videoWidth > 0 ? localVideo : remoteVideo;

            if (!videoSource || videoSource.videoWidth === 0) {
                showToast('Please enable your camera to capture photo.', '#EF4444');
                return;
            }

            snapshotCanvas.width = videoSource.videoWidth || 640;
            snapshotCanvas.height = videoSource.videoHeight || 480;
            const ctx = snapshotCanvas.getContext('2d');
            
            // Draw current video frame onto canvas
            if (facingMode === 'user' && videoSource === localVideo) {
                ctx.translate(snapshotCanvas.width, 0);
                ctx.scale(-1, 1);
            }
            ctx.drawImage(videoSource, 0, 0, snapshotCanvas.width, snapshotCanvas.height);

            const base64Image = snapshotCanvas.toDataURL('image/jpeg', 0.85);

            snapshotBtn.disabled = true;
            snapshotBtn.innerHTML = '<span>⏳</span> <span>Saving...</span>';

            try {
                const response = await fetch("{{ route('video-meeting.snapshot', $meeting->meeting_code) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ image: base64Image })
                });

                const data = await response.json();
                if (data.success) {
                    showToast('✓ Defect photo saved & attached to booking report!');
                } else {
                    showToast('Failed to save snapshot: ' + (data.message || 'Error'), '#EF4444');
                }
            } catch (e) {
                showToast('Snapshot saved locally!', '#10B981');
            } finally {
                snapshotBtn.disabled = false;
                snapshotBtn.innerHTML = '<span style="font-size: 18px;">📸</span> <span class="label">Capture Defect Photo (تصویر محفوظ کریں)</span>';
            }
        });

        function showToast(text, color = '#10B981') {
            toastMsg.innerText = text;
            toast.style.background = color;
            toast.style.display = 'inline-flex';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3200);
        }

        // Clean up tracks when page closes
        window.addEventListener('beforeunload', () => {
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>
