<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Technician Portal — FixMate AI')</title>
    <!-- Application Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fixmate.css') }}">

    @yield('extra_css')
</head>
<body>

    <!-- Technician Header -->
    <header class="site-header">
        <div class="container site-nav">
            <!-- Brand Logo -->
            <a href="{{ url('/technician/dashboard') }}" class="brand-logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 38px; width: auto; object-fit: contain; display: block;">
                <span style="color: #B45309; font-weight: 800; background: #FFF9E6; border: 1px solid #FFECB3; padding: 2px 7px; border-radius: 6px; font-size: 11px;">Technician Pro</span>
            </a>

            <!-- Header Search Bar -->
            <form action="{{ url('/technician/jobs') }}" method="GET" class="header-search-box">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" placeholder="Search job ID, customer, address..." value="{{ request('q') }}">
                <span style="font-size: 10px; background: #E5E7EB; color: #555; padding: 2px 5px; border-radius: 4px; font-weight: 700;">⌘K</span>
            </form>

            <!-- Technician Status & Profile -->
            <div style="display: flex; align-items: center; gap: 16px;">
                <!-- Availability Indicator -->
                <div style="display: flex; align-items: center; gap: 8px; background: #ECFDF5; border: 1px solid #A7F3D0; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; color: #047857;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #10B981;"></span>
                    <span>Online & Dispatchable</span>
                </div>

                <!-- Earnings Quick Metric -->
                @php
                    $techUser = auth()->user();
                    $techProId = $techUser?->professional?->id;
                    $techWalletTotal = $techProId
                        ? (int) round(\App\Models\Booking::where('professional_id', $techProId)->where('status', 'completed')->sum('total_price') * 0.90)
                        : 0;
                @endphp
                <div style="text-align: right; line-height: 1.2;">
                    <span style="font-size: 10px; color: #777; font-weight: 700; text-transform: uppercase;">Wallet Balance</span>
                    <strong style="display: block; font-size: 15px; color: #047857;">Rs. {{ number_format($techWalletTotal) }}</strong>
                </div>

                <!-- Notification Bell -->
                @php
                    $techNotifications = auth()->check() ? auth()->user()->notifications()->latest()->take(6)->get() : collect();
                    $techUnreadCount = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0;
                @endphp
                <div style="position: relative;" id="techNotifContainer">
                    <button type="button" id="techNotifBtn" class="btn-outline" style="padding: 7px 11px; position: relative; border-radius: 8px; cursor: pointer;" title="Job & KYC Notifications">
                        <span>🔔</span>
                        @if($techUnreadCount > 0)
                            <span id="techNotifBadge" style="position: absolute; top: -4px; right: -4px; width: 17px; height: 17px; border-radius: 50%; background: #EF4444; color: #FFF; font-size: 10px; font-weight: 800; display: flex; align-items: center; justify-content: center;">
                                {{ $techUnreadCount }}
                            </span>
                        @endif
                    </button>

                    <div id="techNotifPanel" style="display: none; position: absolute; right: 0; top: 44px; width: 360px; background: #FFFFFF; border: 1px solid var(--border-color); border-radius: 14px; box-shadow: 0 12px 30px rgba(0,0,0,0.12); z-index: 1000; overflow: hidden;">
                        <div style="padding: 12px 16px; background: #111827; color: #FFF; display: flex; justify-content: space-between; align-items: center;">
                            <strong style="font-size: 13px;">Pro Alerts (<span id="techNotifCountText">{{ $techUnreadCount }}</span> Unread)</strong>
                            <form id="techMarkAllForm" action="{{ route('technician.notifications.read-all') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" id="techMarkAllBtn" style="background: none; border: none; color: #FFB800; font-size: 11px; font-weight: 700; cursor: pointer; text-decoration: underline;">
                                    Mark all read
                                </button>
                            </form>
                        </div>
                        <div id="techNotifList" style="max-height: 300px; overflow-y: auto;">
                            @forelse($techNotifications as $tn)
                                <a href="{{ route('technician.notifications.open', $tn->id) }}" class="tech-notif-item" data-id="{{ $tn->id }}" style="text-decoration: none; display: block; padding: 12px 16px; border-bottom: 1px solid #F1F5F9; background: {{ $tn->is_read ? '#FFF' : '#FFFDF0' }}; transition: background 0.15s ease;">
                                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            @if($tn->type === 'chat_message')
                                                <span style="font-size: 13px;">💬</span>
                                            @elseif(str_contains($tn->type, 'kyc'))
                                                <span style="font-size: 13px;">🛡️</span>
                                            @elseif(str_contains($tn->type, 'booking'))
                                                <span style="font-size: 13px;">💼</span>
                                            @else
                                                <span style="font-size: 13px;">⚡</span>
                                            @endif
                                            <strong style="font-size: 12.5px; color: #111;">{{ $tn->title }}</strong>
                                        </div>
                                        <span style="font-size: 10px; color: #94A3B8;">{{ $tn->created_at->diffForHumans(null, true) }}</span>
                                    </div>
                                    <p style="font-size: 12px; color: #555; margin: 4px 0 0 20px; line-height: 1.4;">{{ $tn->message }}</p>
                                    @if(!$tn->is_read)
                                        <span class="unread-pill" style="display: inline-block; margin-left: 20px; margin-top: 4px; font-size: 10px; font-weight: 800; color: #D97706; background: #FEF3C7; padding: 1px 6px; border-radius: 4px;">UNREAD</span>
                                    @endif
                                </a>
                            @empty
                                <div style="padding: 24px; text-align: center; color: #888; font-size: 12.5px;">
                                    <span>✨</span>
                                    <p style="margin: 4px 0 0 0;">No new notifications</p>
                                </div>
                            @endforelse
                        </div>
                        <div style="padding: 10px 16px; background: #F8FAFC; border-top: 1px solid #E2E8F0; text-align: center; display: flex; justify-content: space-between; align-items: center;">
                            <a href="{{ route('technician.notifications') }}" style="font-size: 11.5px; color: #D97706; text-decoration: none; font-weight: 800;">🔔 View All Alerts</a>
                            <a href="{{ route('technician.messages') }}" style="font-size: 11.5px; color: #0284C7; text-decoration: none; font-weight: 800;">💬 Open Chat</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Avatar -->
                @php
                    $techProHeader = auth()->user()->professional;
                    $techAvgRatingHeader = $techProHeader ? \App\Models\Review::where('professional_id', $techProHeader->id)->avg('rating') : null;
                @endphp
                <a href="{{ url('/technician/profile') }}" style="display: flex; align-items: center; gap: 8px; border-left: 1px solid var(--border-color); padding-left: 14px; text-decoration: none;">
                    <img src="{{ asset(auth()->user()->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ auth()->user()->name ?? 'Pro' }}" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                    <div>
                        <strong style="font-size: 13px; color: #111; display: block;">{{ auth()->user()->name ?? 'Technician Pro' }}</strong>
                        <span style="font-size: 11px; color: #757575;">
                            @if(auth()->user()->is_verified)
                                {{ $techAvgRatingHeader ? 'Verified Pro ★ ' . number_format($techAvgRatingHeader, 1) : 'Verified Partner Pro' }}
                            @else
                                Under Review
                            @endif
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- Dynamic KYC Verification Alert Banner -->
    @if(auth()->check() && !auth()->user()->is_verified)
        @php
            $techPro = auth()->user()->professional;
            $verStatus = $techPro?->verification_status ?? 'pending';
        @endphp
        @if($verStatus === 'rejected')
            <div style="background: #FFF1F2; border-bottom: 2px solid #FECDD3; padding: 10px 24px; display: flex; align-items: center; justify-content: space-between; font-size: 13px; color: #9F1239;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 16px;">⚠️</span>
                    <span><strong>Verification Revision Required:</strong> {{ $techPro->rejection_reason ?: 'Your document submission requires update.' }}</span>
                </div>
                <a href="{{ route('technician.verification') }}" style="background: #E11D48; color: #FFF; padding: 5px 14px; border-radius: 6px; text-decoration: none; font-weight: 700; font-size: 12px;">Re-upload Documents &rarr;</a>
            </div>
        @elseif($verStatus === 'under_review')
            <div style="background: #EFF6FF; border-bottom: 2px solid #BFDBFE; padding: 10px 24px; display: flex; align-items: center; justify-content: space-between; font-size: 13px; color: #1E40AF;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 16px;">⏳</span>
                    <span><strong>Verification Under Review:</strong> Your CNIC, live biometric photo, and trade credentials are being audited by FixMate compliance team.</span>
                </div>
                <a href="{{ route('technician.verification') }}" style="color: #1D4ED8; font-weight: 700; text-decoration: underline; font-size: 12px;">Check KYC Status &rarr;</a>
            </div>
        @else
            <div style="background: #FFFBEB; border-bottom: 2px solid #FDE68A; padding: 10px 24px; display: flex; align-items: center; justify-content: space-between; font-size: 13px; color: #92400E;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 16px;">🛡️</span>
                    <span><strong>Account Action Needed:</strong> Submit your CNIC, trade license, and live biometric selfie to activate full dispatch eligibility and instant withdrawals.</span>
                </div>
                <a href="{{ route('technician.verification') }}" style="background: #D97706; color: #FFF; padding: 5px 14px; border-radius: 6px; text-decoration: none; font-weight: 700; font-size: 12px;">Complete Biometric Verification &rarr;</a>
            </div>
        @endif
    @endif

    <!-- Technician Grid Layout -->
    <div class="container portal-layout">
        
        <!-- Sidebar Navigation (Section 5 of Specification) -->
        <aside class="portal-sidebar">
            <div style="padding: 0 10px 14px 10px; border-bottom: 1px solid var(--border-color); margin-bottom: 12px;">
                <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Pro Workspace</span>
            </div>

            <nav style="display: flex; flex-direction: column;">
                <a href="{{ url('/technician/dashboard') }}" class="portal-nav-link {{ Request::is('technician/dashboard*') ? 'active' : '' }}">
                    <span>📊</span> <span>Dashboard</span>
                </a>
                <a href="{{ url('/technician/jobs') }}" class="portal-nav-link {{ Request::is('technician/jobs*') ? 'active' : '' }}">
                    <span>💼</span> <span>Job Requests</span>
                </a>
                <a href="{{ route('technician.notifications') }}" class="portal-nav-link {{ Request::is('technician/notifications*') ? 'active' : '' }}">
                    <span>🔔</span> <span>Notifications</span>
                    @if($techUnreadCount > 0)
                        <span style="margin-left: auto; background: #EF4444; color: #FFF; font-size: 10px; font-weight: 800; padding: 1px 6px; border-radius: 10px;">{{ $techUnreadCount }}</span>
                    @endif
                </a>
                <a href="{{ url('/technician/schedule') }}" class="portal-nav-link {{ Request::is('technician/schedule*') || Request::is('technician/availability*') ? 'active' : '' }}">
                    <span>📅</span> <span>My Schedule</span>
                </a>
                <a href="{{ url('/technician/earnings') }}" class="portal-nav-link {{ Request::is('technician/earnings*') || Request::is('technician/payouts*') ? 'active' : '' }}">
                    <span>💰</span> <span>Earnings & Payouts</span>
                </a>
                <a href="{{ url('/technician/verification') }}" class="portal-nav-link {{ Request::is('technician/verification*') ? 'active' : '' }}">
                    <span>🛡️</span> <span>KYC Verification</span>
                </a>
                <a href="{{ url('/technician/skills') }}" class="portal-nav-link {{ Request::is('technician/skills*') ? 'active' : '' }}">
                    <span>🔧</span> <span>Skills & Services</span>
                </a>
                <a href="{{ url('/technician/reviews') }}" class="portal-nav-link {{ Request::is('technician/reviews*') ? 'active' : '' }}">
                    <span>⭐</span> <span>Customer Reviews</span>
                </a>
                <a href="{{ url('/technician/messages') }}" class="portal-nav-link {{ Request::is('technician/messages*') ? 'active' : '' }}">
                    <span>💬</span> <span>Messages</span>
                </a>
                <a href="{{ url('/technician/profile') }}" class="portal-nav-link {{ Request::is('technician/profile*') || Request::is('technician/settings*') ? 'active' : '' }}">
                    <span>👤</span> <span>Profile & Bio</span>
                </a>

                <div style="margin-top: 20px; padding-top: 14px; border-top: 1px solid var(--border-color);">
                    <a href="{{ url('/') }}" class="portal-nav-link" style="color: #6B7280; font-size: 13px;">
                        <span>🌐</span> <span>Public Website</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="techLogoutForm" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('techLogoutForm').submit();" class="portal-nav-link" style="color: #EF4444; font-size: 13px;">
                        <span>🚪</span> <span>Sign Out</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Workspace -->
        <main>
            @yield('content')
        </main>

    </div>

    <!-- Toast Notification -->
    <div id="fmToast" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; transform: translateY(30px); opacity: 0; pointer-events: none; transition: all 0.25s ease;">
        <div style="background: #111111; color: #FFFFFF; padding: 12px 20px; border-radius: 12px; box-shadow: 0 10px 24px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 600; border: 1px solid #333;">
            <span id="fmToastIcon" style="color: #FFCC00;">✓</span>
            <span id="fmToastMsg">Action completed</span>
        </div>
    </div>

    <script>
        // Technician Notification Dropdown
        var techNotifBtn = document.getElementById('techNotifBtn');
        var techNotifPanel = document.getElementById('techNotifPanel');
        if (techNotifBtn && techNotifPanel) {
            techNotifBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                techNotifPanel.style.display = techNotifPanel.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', function(e) {
                if (!techNotifPanel.contains(e.target) && e.target !== techNotifBtn) {
                    techNotifPanel.style.display = 'none';
                }
            });
        }

        var techMarkAllBtn = document.getElementById('techMarkAllBtn');
        if (techMarkAllBtn) {
            techMarkAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                fetch("{{ route('technician.notifications.read-all') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    var badge = document.getElementById('techNotifBadge');
                    if (badge) badge.remove();
                    var countTxt = document.getElementById('techNotifCountText');
                    if (countTxt) countTxt.textContent = '0';
                    document.querySelectorAll('.tech-notif-item').forEach(el => {
                        el.style.background = '#FFFFFF';
                    });
                    document.querySelectorAll('.unread-pill').forEach(el => {
                        el.remove();
                    });
                    showToast('All notifications marked as read', true);
                })
                .catch(() => {
                    document.getElementById('techMarkAllForm').submit();
                });
            });
        }

        function showToast(msg, isSuccess = true) {
            const toast = document.getElementById('fmToast');
            document.getElementById('fmToastMsg').textContent = msg;
            document.getElementById('fmToastIcon').textContent = isSuccess ? '✓' : '⚠️';
            document.getElementById('fmToastIcon').style.color = isSuccess ? '#10B981' : '#EF4444';
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
            toast.style.pointerEvents = 'auto';
            setTimeout(() => {
                toast.style.transform = 'translateY(30px)';
                toast.style.opacity = '0';
                toast.style.pointerEvents = 'none';
            }, 3000);
        }
    </script>

    @yield('extra_js')
</body>
</html>
