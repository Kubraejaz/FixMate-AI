<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Admin Console — FixMate AI')</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fixmate.css') }}">

    @yield('extra_css')
</head>
<body>

    <!-- Admin Header -->
    <header class="site-header" style="background: #111111; color: #FFFFFF; border-bottom: 1px solid #222222;">
        <div class="container site-nav">
            <!-- Brand Logo -->
            <a href="{{ url('/admin/dashboard') }}" class="brand-logo" style="color: #FFF;">
                <div class="brand-icon-sq" style="background: #FFCC00; color: #000;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    </svg>
                </div>
                <span>FixMate</span>
                <span style="color: #000; font-weight: 900; background: #FFCC00; padding: 2px 7px; border-radius: 6px; font-size: 11px;">Admin Console</span>
            </a>

            <!-- Header Search Bar -->
            <form action="{{ url('/admin/bookings') }}" method="GET" class="header-search-box" style="background: #1C1C1C; border-color: #333333;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" placeholder="Search user, booking #FM, dispute..." value="{{ request('q') }}" style="color: #FFFFFF;">
                <span style="font-size: 10px; background: #2B2B2B; color: #AAA; padding: 2px 5px; border-radius: 4px; font-weight: 700;">⌘K</span>
            </form>

            <!-- Admin Status -->
            <div style="display: flex; align-items: center; gap: 16px;">
                <span style="font-size: 12px; color: #10B981; font-weight: 700; background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); padding: 4px 10px; border-radius: 20px;">
                    ● Systems Online 99.9%
                </span>

                <div style="display: flex; align-items: center; gap: 8px; border-left: 1px solid #333; padding-left: 14px;">
                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #FFCC00; color: #000; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 13px;">
                        OP
                    </div>
                    <div style="line-height: 1.2;">
                        <strong style="font-size: 13px; color: #FFF; display: block;">Operator #1</strong>
                        <span style="font-size: 11px; color: #9CA3AF;">Super Administrator</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Admin Portal Grid Layout -->
    <div class="container portal-layout">
        
        <!-- Sidebar Navigation (Section 7 of Specification) -->
        <aside class="portal-sidebar">
            <div style="padding: 0 10px 14px 10px; border-bottom: 1px solid var(--border-color); margin-bottom: 12px;">
                <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Platform Controls</span>
            </div>

            <nav style="display: flex; flex-direction: column;">
                <a href="{{ url('/admin/dashboard') }}" class="portal-nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                    <span>📈</span> <span>Dashboard & KPIs</span>
                </a>
                <a href="{{ url('/admin/customers') }}" class="portal-nav-link {{ Request::is('admin/customers*') ? 'active' : '' }}">
                    <span>👥</span> <span>Customer Accounts</span>
                </a>
                <a href="{{ url('/admin/technicians') }}" class="portal-nav-link {{ Request::is('admin/technicians') ? 'active' : '' }}">
                    <span>🔧</span> <span>Technicians Pool</span>
                </a>
                <a href="{{ url('/admin/technicians/verification') }}" class="portal-nav-link {{ Request::is('admin/technicians/verification*') ? 'active' : '' }}">
                    <span>🛡️</span> <span>KYC Verifications</span>
                </a>
                <a href="{{ url('/admin/categories') }}" class="portal-nav-link {{ Request::is('admin/categories*') || Request::is('admin/services*') ? 'active' : '' }}">
                    <span>📦</span> <span>Categories & Pricing</span>
                </a>
                <a href="{{ url('/admin/bookings') }}" class="portal-nav-link {{ Request::is('admin/bookings*') ? 'active' : '' }}">
                    <span>📋</span> <span>All Bookings</span>
                </a>
                <a href="{{ url('/admin/ai-diagnostics') }}" class="portal-nav-link {{ Request::is('admin/ai-diagnostics*') ? 'active' : '' }}">
                    <span>🧠</span> <span>AI Diagnostic Logs</span>
                </a>
                <a href="{{ url('/admin/payments') }}" class="portal-nav-link {{ Request::is('admin/payments*') ? 'active' : '' }}">
                    <span>💳</span> <span>Escrow & Settlements</span>
                </a>
                <a href="{{ url('/admin/complaints') }}" class="portal-nav-link {{ Request::is('admin/complaints*') ? 'active' : '' }}">
                    <span>⚖️</span> <span>Dispute Arbitration</span>
                </a>
                <a href="{{ url('/admin/community') }}" class="portal-nav-link {{ Request::is('admin/community*') ? 'active' : '' }}">
                    <span>🏙️</span> <span>Community Issues</span>
                </a>
                <a href="{{ url('/admin/analytics') }}" class="portal-nav-link {{ Request::is('admin/analytics*') ? 'active' : '' }}">
                    <span>📊</span> <span>Growth Analytics</span>
                </a>
                <a href="{{ url('/admin/settings') }}" class="portal-nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}">
                    <span>⚙️</span> <span>Platform Settings</span>
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
