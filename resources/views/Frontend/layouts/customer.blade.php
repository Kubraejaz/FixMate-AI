<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Customer Portal — FixMate AI')</title>
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

    <!-- Customer Portal Header -->
    <header class="site-header">
        <div class="container site-nav">
            <!-- Brand Logo with Portal Badge -->
            <a href="{{ url('/customer/dashboard') }}" class="brand-logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 38px; width: auto; object-fit: contain; display: block;">
                <span style="color: #047857; font-weight: 800; background: #ECFDF5; border: 1px solid #A7F3D0; padding: 2px 7px; border-radius: 6px; font-size: 11px;">Customer</span>
            </a>

            <!-- Header Search Bar (Per User Requirement) -->
            <form action="{{ url('/customer/technicians') }}" method="GET" class="header-search-box">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" placeholder="Search my bookings or find pro..." value="{{ request('q') }}">
                <span style="font-size: 10px; background: #E5E7EB; color: #555; padding: 2px 5px; border-radius: 4px; font-weight: 700;">⌘K</span>
            </form>

            <!-- Customer Header Action Items -->
            <div style="display: flex; align-items: center; gap: 14px;">
                <!-- Fast AI Diagnosis Trigger -->
                <a href="{{ url('/customer/diagnose') }}" class="btn-yellow" style="font-size: 13px; padding: 8px 16px;">
                    <span>+ Describe Problem</span>
                </a>

                <!-- Messages -->
                <a href="{{ url('/customer/messages') }}" class="btn-outline" style="padding: 8px 12px; position: relative;" title="Messages">
                    <span>💬</span>
                    <span style="position: absolute; top: -4px; right: -4px; width: 16px; height: 16px; border-radius: 50%; background: #EF4444; color: #FFF; font-size: 10px; font-weight: 800; display: flex; align-items: center; justify-content: center;">1</span>
                </a>

                <!-- User Profile Pill -->
                <div style="display: flex; align-items: center; gap: 8px; border-left: 1px solid var(--border-color); padding-left: 14px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; text-transform: uppercase;">
                        {{ auth()->check() ? mb_substr(auth()->user()->name, 0, 2) : 'CU' }}
                    </div>
                    <div style="line-height: 1.2;">
                        <strong style="font-size: 13px; color: #111; display: block;">{{ auth()->user()->name ?? 'Customer' }}</strong>
                        <span style="font-size: 11px; color: #757575;">{{ auth()->user()->city ?? 'Karachi, PK' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Customer Portal Grid Layout -->
    <div class="container portal-layout">
        
        <!-- Sidebar Navigation (Matching Section 3 & 4 of Specification) -->
        <aside class="portal-sidebar">
            <div style="padding: 0 10px 14px 10px; border-bottom: 1px solid var(--border-color); margin-bottom: 12px;">
                <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Customer Menu</span>
            </div>

            <nav style="display: flex; flex-direction: column;">
                <a href="{{ route('customer.dashboard') }}" class="portal-nav-link {{ Request::is('customer/dashboard*') ? 'active' : '' }}">
                    <span>🏠</span> <span>Dashboard</span>
                </a>
                <a href="{{ route('customer.diagnose') }}" class="portal-nav-link {{ Request::is('customer/diagnose*') ? 'active' : '' }}">
                    <span>🔍</span> <span>AI Problem Diagnosis</span>
                </a>
                <a href="{{ route('customer.technicians') }}" class="portal-nav-link {{ Request::is('customer/technicians*') ? 'active' : '' }}">
                    <span>👷</span> <span>Find Technicians</span>
                </a>
                <a href="{{ route('customer.bookings') }}" class="portal-nav-link {{ Request::is('customer/bookings*') || Request::is('customer/booking*') ? 'active' : '' }}">
                    <span>📅</span> <span>My Bookings</span>
                </a>
                <a href="{{ route('customer.tracking') }}" class="portal-nav-link {{ Request::is('*tracking*') ? 'active' : '' }}">
                    <span>📍</span> <span>Live Tracking</span>
                </a>
                <a href="{{ route('customer.messages') }}" class="portal-nav-link {{ Request::is('customer/messages*') ? 'active' : '' }}">
                    <span>💬</span> <span>Messages</span>
                </a>
                <a href="{{ route('customer.reviews') }}" class="portal-nav-link {{ Request::is('customer/reviews*') ? 'active' : '' }}">
                    <span>⭐</span> <span>Service Reviews</span>
                </a>
                <a href="{{ route('customer.complaints') }}" class="portal-nav-link {{ Request::is('customer/complaints*') ? 'active' : '' }}">
                    <span>⚖️</span> <span>Disputes & Help</span>
                </a>
                <a href="{{ route('customer.profile') }}" class="portal-nav-link {{ Request::is('customer/profile*') || Request::is('customer/settings*') ? 'active' : '' }}">
                    <span>⚙️</span> <span>Settings & Profile</span>
                </a>

                <div style="margin-top: 20px; padding-top: 14px; border-top: 1px solid var(--border-color);">
                    <a href="{{ url('/') }}" class="portal-nav-link" style="color: #6B7280; font-size: 13px;">
                        <span>🌐</span> <span>Public Website</span>
                    </a>
                    <a href="javascript:void(0);" onclick="document.getElementById('customer-logout-form').submit();" class="portal-nav-link" style="color: #EF4444; font-size: 13px;">
                        <span>🚪</span> <span>Sign Out</span>
                    </a>
                    <form id="customer-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Portal Workspace -->
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
            }, 4000);
        }

        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast(@json(session('success')), true);
            });
        @endif

        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast(@json(session('error')), false);
            });
        @endif
    </script>

    @yield('extra_js')
</body>
</html>
