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
                <div style="text-align: right; line-height: 1.2;">
                    <span style="font-size: 10px; color: #777; font-weight: 700; text-transform: uppercase;">Today's Payouts</span>
                    <strong style="display: block; font-size: 15px; color: #111;">Rs. 12,490</strong>
                </div>

                <!-- Profile Avatar (Using user's image_1.png) -->
                <a href="{{ url('/technician/profile') }}" style="display: flex; align-items: center; gap: 8px; border-left: 1px solid var(--border-color); padding-left: 14px;">
                    <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                    <div>
                        <strong style="font-size: 13px; color: #111; display: block;">Ali Khan</strong>
                        <span style="font-size: 11px; color: #757575;">Plumber • 4.8 ★</span>
                    </div>
                </a>
            </div>
        </div>
    </header>

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
                    <span>🔔</span> <span>Job Requests</span>
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
                    <a href="{{ url('/login') }}" class="portal-nav-link" style="color: #EF4444; font-size: 13px;">
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
