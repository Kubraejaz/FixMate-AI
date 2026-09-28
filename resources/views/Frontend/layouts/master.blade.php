<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'FixMate AI — Smart Solutions for a Better Home')</title>
    <meta name="description" content="@yield('meta_desc', 'AI-powered home service platform that connects you with verified professionals for all your home maintenance needs.')">
    <!-- Application Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/Logo.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FixMate Official Design System -->
    <link rel="stylesheet" href="{{ asset('css/fixmate.css') }}">

    @yield('extra_css')
</head>
<body>

    <!-- Site Header matching user's exact mockup -->
    <header class="site-header-custom" style="background: #FFFFFF; border-bottom: 1px solid #F1F5F9; position: sticky; top: 0; z-index: 1000; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div class="header-custom-inner" style="max-width: 1360px; margin: 0 auto; padding: 0 28px; display: flex; align-items: center; justify-content: space-between; height: 74px;">
            
            <!-- Brand Logo with Application Logo.png -->
            <a href="{{ url('/') }}" class="brand-logo-wrap" style="display: flex; align-items: center; text-decoration: none; flex-shrink: 0;" title="FixMate AI">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 42px; width: auto; object-fit: contain; display: block;">
            </a>

            <!-- Centered Desktop Nav Menu with Yellow Active Bar matching mockup -->
            <nav class="desktop-nav-menu" style="margin-left: 48px;">
                <ul style="display: flex; align-items: center; gap: 28px; list-style: none; margin: 0; padding: 0;">
                    <li>
                        <a href="{{ url('/') }}" class="custom-nav-link {{ Request::is('/') ? 'active' : '' }}">
                            <span>Home</span>
                            @if(Request::is('/'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/services') }}" class="custom-nav-link {{ Request::is('services*') ? 'active' : '' }}">
                            <span>Services</span>
                            @if(Request::is('services*'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/how-it-works') }}" class="custom-nav-link {{ Request::is('how-it-works*') ? 'active' : '' }}">
                            <span>How It Works</span>
                            @if(Request::is('how-it-works*'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/technicians') }}" class="custom-nav-link {{ (Request::is('technicians*') || Request::is('find-technician*')) ? 'active' : '' }}">
                            <span>Find Technicians</span>
                            @if(Request::is('technicians*') || Request::is('find-technician*'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/about') }}" class="custom-nav-link {{ Request::is('about*') ? 'active' : '' }}">
                            <span>About</span>
                            @if(Request::is('about*'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/community') }}" class="custom-nav-link {{ Request::is('community*') ? 'active' : '' }}">
                            <span>Community</span>
                            @if(Request::is('community*'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/faqs') }}" class="custom-nav-link {{ Request::is('faqs*') ? 'active' : '' }}">
                            <span>FAQs</span>
                            @if(Request::is('faqs*'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="custom-nav-link {{ Request::is('contact*') ? 'active' : '' }}">
                            <span>Contact</span>
                            @if(Request::is('contact*'))
                                <span class="nav-active-bar"></span>
                            @endif
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Right Actions: Search icon, Login, Sign Up matching mockup -->
            <div class="header-action-group" style="display: flex; align-items: center; gap: 14px; flex-shrink: 0;">
                <button type="button" class="header-search-icon-btn" onclick="toggleHeaderSearch()" title="Search services or technicians" aria-label="Search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <a href="{{ url('/login') }}" class="custom-btn-login">
                    Login
                </a>

                <a href="{{ url('/register/role') }}" class="custom-btn-signup">
                    Sign Up
                </a>

                <!-- Mobile Menu Button -->
                <button type="button" class="mobile-hamburger-btn" onclick="toggleMobileNav()" aria-label="Toggle Navigation Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>

        </div>

        <!-- Interactive Search Dropdown Bar -->
        <div id="headerSearchDropdown" style="display: none; background: #FFFFFF; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #E2E8F0; padding: 14px 28px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
            <div style="max-width: 720px; margin: 0 auto;">
                <form action="{{ url('/technicians') }}" method="GET" style="display: flex; align-items: center; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 6px 14px; gap: 10px; transition: border-color 0.2s;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="query" id="headerSearchQuery" placeholder="Search services (e.g. Electrician, AC Repair, Plumbing)..." style="flex: 1; border: none; background: transparent; font-size: 14px; outline: none; color: #0F172A; font-family: inherit;">
                    <button type="submit" style="background: #FFB800; color: #0F172A; font-weight: 700; border: none; padding: 7px 16px; border-radius: 8px; font-size: 13.5px; cursor: pointer; transition: all 0.2s;">Search</button>
                    <button type="button" onclick="toggleHeaderSearch()" style="background: none; border: none; color: #94A3B8; cursor: pointer; padding: 4px; display: flex; align-items: center;" title="Close search">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Responsive Mobile Drawer Navigation -->
        <div id="headerMobileDrawer" style="display: none; background: #FFFFFF; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #E2E8F0; padding: 18px 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <nav style="margin-bottom: 18px;">
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px;">
                    <li><a href="{{ url('/') }}" class="mobile-nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ url('/services') }}" class="mobile-nav-link {{ Request::is('services*') ? 'active' : '' }}">Services</a></li>
                    <li><a href="{{ url('/how-it-works') }}" class="mobile-nav-link {{ Request::is('how-it-works*') ? 'active' : '' }}">How It Works</a></li>
                    <li><a href="{{ url('/technicians') }}" class="mobile-nav-link {{ (Request::is('technicians*') || Request::is('find-technician*')) ? 'active' : '' }}">Find Technicians</a></li>
                    <li><a href="{{ url('/about') }}" class="mobile-nav-link {{ Request::is('about*') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ url('/community') }}" class="mobile-nav-link {{ Request::is('community*') ? 'active' : '' }}">Community</a></li>
                    <li><a href="{{ url('/faqs') }}" class="mobile-nav-link {{ Request::is('faqs*') ? 'active' : '' }}">FAQs</a></li>
                    <li><a href="{{ url('/contact') }}" class="mobile-nav-link {{ Request::is('contact*') ? 'active' : '' }}">Contact</a></li>
                </ul>
            </nav>
            <div style="display: flex; gap: 12px; padding-top: 12px; border-top: 1px solid #F1F5F9;">
                <a href="{{ url('/login') }}" class="custom-btn-login" style="flex: 1; text-align: center; justify-content: center;">Login</a>
                <a href="{{ url('/register/role') }}" class="custom-btn-signup" style="flex: 1; text-align: center; justify-content: center;">Sign Up</a>
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
                    <a href="{{ url('/') }}" style="display: inline-block; background: #FFFFFF; padding: 6px 14px; border-radius: 10px; margin-bottom: 16px; text-decoration: none;">
                        <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 34px; width: auto; object-fit: contain; display: block;">
                    </a>
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
