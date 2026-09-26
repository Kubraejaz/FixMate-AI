<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'FixMate AI — Smart Solutions for a Better Home')</title>
    <meta name="description" content="@yield('meta_desc', 'AI-powered home service platform that connects you with verified professionals for all your home maintenance needs.')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FixMate Official Design System -->
    <link rel="stylesheet" href="{{ asset('css/fixmate.css') }}">

    @yield('extra_css')
</head>
<body>

    <!-- Site Header -->
    <header class="site-header">
        <div class="container site-nav">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-logo">
                <div class="brand-icon-sq">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <span style="font-weight: 800; letter-spacing: -0.3px;">FixMate</span>
                <span style="color: #FFCC00; font-weight: 900; background: #111; padding: 2px 6px; border-radius: 6px; font-size: 12px; margin-left: -2px;">AI</span>
            </a>

            <!-- Navigation Links -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="{{ url('/') }}" class="nav-item-link {{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="nav-item-link {{ Request::is('about*') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ url('/services') }}" class="nav-item-link {{ Request::is('services*') ? 'active' : '' }}">Services</a></li>
                    <li><a href="{{ url('/how-it-works') }}" class="nav-item-link {{ Request::is('how-it-works*') ? 'active' : '' }}">How It Works</a></li>
                    <li><a href="{{ url('/find-technician') }}" class="nav-item-link {{ Request::is('find-technician*') ? 'active' : '' }}">Find Technician</a></li>
                    <li><a href="{{ url('/technician-register') }}" class="nav-item-link {{ Request::is('technician*') ? 'active' : '' }}">Become a Technician</a></li>
                    <li><a href="{{ url('/contact') }}" class="nav-item-link {{ Request::is('contact*') ? 'active' : '' }}">Contact</a></li>
                </ul>
            </nav>

            <!-- Auth Action Buttons -->
            <div style="display: flex; align-items: center; gap: 14px;">
                <!-- Fast Role Portal Link -->
                <a href="{{ url('/customer-dashboard') }}" class="nav-item-link" style="font-size: 13px; font-weight: 600; color: #555;" title="Customer Dashboard">
                    Dashboard
                </a>

                <a href="{{ url('/login') }}" style="font-size: 14px; font-weight: 600; color: #111; padding: 8px 12px;">
                    Login
                </a>
                <a href="{{ url('/register') }}" class="btn-yellow" style="padding: 9px 20px; font-size: 14px;">
                    Sign Up
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main style="flex: 1 0 auto;">
        @yield('content')
    </main>

    <!-- Site Footer (matching mockup) -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Col 1: Logo & Info -->
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px;">
                        <div class="brand-icon-sq" style="width: 30px; height: 30px; font-size: 16px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            </svg>
                        </div>
                        <span style="font-size: 20px; font-weight: 800; color: #FFFFFF;">FixMate</span>
                        <span style="color: #FFCC00; font-weight: 900; background: #222; padding: 2px 6px; border-radius: 6px; font-size: 12px;">AI</span>
                    </div>
                    <p style="color: #9CA3AF; font-size: 13.5px; line-height: 1.6; max-width: 320px; margin-bottom: 20px;">
                        Intelligent Home Service Platform. Smart Diagnosis. Right Technician. Hassle Free.
                    </p>
                    <div style="display: flex; gap: 12px; font-size: 16px;">
                        <a href="#" style="color: #9CA3AF;">🌐</a>
                        <a href="#" style="color: #9CA3AF;">📷</a>
                        <a href="#" style="color: #9CA3AF;">💼</a>
                        <a href="#" style="color: #9CA3AF;">🐦</a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="footer-heading">Quick Links</h4>
                    <a href="{{ url('/') }}" class="footer-link">Home</a>
                    <a href="{{ url('/about') }}" class="footer-link">About Us</a>
                    <a href="{{ url('/services') }}" class="footer-link">Services</a>
                    <a href="{{ url('/how-it-works') }}" class="footer-link">How It Works</a>
                    <a href="{{ url('/contact') }}" class="footer-link">Contact</a>
                </div>

                <!-- Col 3: Services -->
                <div>
                    <h4 class="footer-heading">Services</h4>
                    <a href="{{ url('/services?cat=plumbing') }}" class="footer-link">Plumbing</a>
                    <a href="{{ url('/services?cat=electrical') }}" class="footer-link">Electrical</a>
                    <a href="{{ url('/services?cat=ac') }}" class="footer-link">AC Repair</a>
                    <a href="{{ url('/services?cat=cleaning') }}" class="footer-link">Cleaning</a>
                    <a href="{{ url('/services?cat=carpentry') }}" class="footer-link">Carpentry</a>
                </div>

                <!-- Col 4: Support -->
                <div>
                    <h4 class="footer-heading">Support</h4>
                    <a href="{{ url('/contact') }}" class="footer-link">FAQs</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms & Conditions</a>
                    <a href="{{ url('/admin') }}" class="footer-link">Admin Portal</a>
                    <a href="{{ url('/technician-dashboard') }}" class="footer-link">Technician Portal</a>
                </div>
            </div>

            <!-- Bottom Line -->
            <div style="border-top: 1px solid #222222; padding-top: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; font-size: 12.5px; color: #6B7280;">
                <div>
                    © 2026 FixMate AI. All rights reserved.
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span>🌐</span>
                    <span>English (Pakistan)</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Toast Alert -->
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
