<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'FixMate AI — Smart Home Services Made Simple')</title>
    <meta name="description" content="@yield('meta_desc', 'AI-powered home service platform connecting you with verified professionals in Pakistan.')">
    <!-- Application Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fixmate.css') }}">

    <style>
        /* Exact Header Styling matching User's Mockup */
        .site-header-custom {
            background: #FFFFFF !important;
            border-bottom: 1px solid #F1F5F9 !important;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .custom-nav-link {
            font-size: 14.5px;
            font-weight: 500;
            color: #64748B;
            text-decoration: none;
            padding: 8px 0;
            position: relative;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            transition: color 0.18s ease;
            white-space: nowrap;
        }

        .custom-nav-link:hover {
            color: #0F172A;
        }

        .custom-nav-link.active {
            color: #0F172A !important;
            font-weight: 700 !important;
        }

        .custom-nav-link .nav-active-bar {
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 22px;
            height: 3px;
            background: #FFB800;
            border-radius: 2px;
        }

        .header-search-icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #475569;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .header-search-icon-btn:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .custom-btn-login {
            font-size: 14px;
            font-weight: 700;
            color: #1E293B;
            text-decoration: none;
            padding: 8.5px 22px;
            border: 1.5px solid #CBD5E1;
            border-radius: 10px;
            background: #FFFFFF;
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .custom-btn-login:hover {
            background: #F8FAFC;
            border-color: #94A3B8;
            color: #0F172A;
        }

        .custom-btn-signup {
            font-size: 14px;
            font-weight: 800;
            color: #0F172A;
            text-decoration: none;
            background: #FFB800;
            border: 1.5px solid transparent;
            padding: 8.5px 22px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(255, 184, 0, 0.25);
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .custom-btn-signup:hover {
            background: #FFAE00;
            box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35);
            transform: translateY(-1px);
            color: #0F172A;
        }

        .mobile-hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: #1E293B;
            padding: 6px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
        }

        .mobile-hamburger-btn:hover {
            background: #F1F5F9;
        }

        .mobile-nav-link {
            display: block;
            padding: 10px 14px;
            border-radius: 8px;
            color: #475569;
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 600;
            transition: all 0.15s ease;
        }

        .mobile-nav-link:hover, .mobile-nav-link.active {
            background: #FEF3C7;
            color: #92400E;
            font-weight: 700;
        }

        @media (max-width: 1040px) {
            .desktop-nav-menu {
                display: none !important;
            }
            .mobile-hamburger-btn {
                display: flex !important;
            }
            .custom-btn-login {
                padding: 8px 16px;
            }
            .custom-btn-signup {
                padding: 8px 16px;
            }
        }

        @media (max-width: 520px) {
            .custom-btn-login {
                display: none;
            }
            .header-custom-inner {
                padding: 0 16px !important;
            }
        }
    </style>

    @yield('extra_css')
</head>
<body style="background: #FFFFFF; color: #1E293B; font-family: 'Plus Jakarta Sans', sans-serif;">

    <!-- Site Header matching user's exact mockup -->
    <header class="site-header-custom" style="background: #FFFFFF; border-bottom: 1px solid #F1F5F9; position: sticky; top: 0; z-index: 1000; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div class="header-custom-inner" style="max-width: 1360px; margin: 0 auto; padding: 0 28px; display: flex; align-items: center; justify-content: space-between; height: 74px;">
            
            <!-- Brand Logo with Application Logo.png -->
            <a href="{{ url('/') }}" class="brand-logo-wrap" style="display: flex; align-items: center; text-decoration: none; flex-shrink: 0;" title="FixMate AI">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 42px; width: auto; object-fit: contain; display: block;">
            </a>

            <!-- Centered Desktop Nav Menu with Yellow Active Bar matching mockup -->
            <nav class="desktop-nav-menu">
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
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 10px; font-size: 12.5px; color: #64748B; flex-wrap: wrap;">
                    <span style="font-weight: 600;">Popular:</span>
                    <a href="{{ url('/services/plumbing') }}" style="color: #0F172A; text-decoration: none; background: #F1F5F9; padding: 3px 10px; border-radius: 6px; font-weight: 500;">Plumbing</a>
                    <a href="{{ url('/services/electrical') }}" style="color: #0F172A; text-decoration: none; background: #F1F5F9; padding: 3px 10px; border-radius: 6px; font-weight: 500;">Electrician</a>
                    <a href="{{ url('/services/ac-cooling') }}" style="color: #0F172A; text-decoration: none; background: #F1F5F9; padding: 3px 10px; border-radius: 6px; font-weight: 500;">AC Repair</a>
                    <a href="{{ url('/services/carpentry') }}" style="color: #0F172A; text-decoration: none; background: #F1F5F9; padding: 3px 10px; border-radius: 6px; font-weight: 500;">Carpentry</a>
                </div>
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

    <!-- Main View Content -->
    <main>
        @yield('content')
    </main>

    <!-- Clean, elegant modern footer -->
    <footer style="background: #0B1120; color: #94A3B8; padding: 60px 0 30px 0; margin-top: 60px;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px;">
                <div>
                    <a href="{{ url('/') }}" style="display: inline-block; background: #FFFFFF; padding: 6px 14px; border-radius: 10px; margin-bottom: 16px; text-decoration: none;">
                        <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate AI" style="height: 34px; width: auto; object-fit: contain; display: block;">
                    </a>
                    <p style="font-size: 13.5px; line-height: 1.6; color: #94A3B8; max-width: 300px; margin-bottom: 16px;">
                        Smart diagnosis. Right technician. Hassle free. AI-powered home service platform connecting Pakistani homeowners with verified trade experts.
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ url('/customer/dashboard') }}" style="font-size: 11px; background: #1E293B; color: #F1F5F9; padding: 4px 10px; border-radius: 6px; text-decoration: none;">Customer Portal</a>
                        <a href="{{ url('/technician/dashboard') }}" style="font-size: 11px; background: #1E293B; color: #FFC107; padding: 4px 10px; border-radius: 6px; text-decoration: none;">Technician Portal</a>
                    </div>
                </div>

                <div>
                    <strong style="color: #FFFFFF; font-size: 14px; display: block; margin-bottom: 14px;">Services</strong>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13.5px; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="{{ url('/services/plumbing') }}" style="color: #94A3B8; text-decoration: none;">Plumbing</a></li>
                        <li><a href="{{ url('/services/electrical') }}" style="color: #94A3B8; text-decoration: none;">Electrical</a></li>
                        <li><a href="{{ url('/services/ac-cooling') }}" style="color: #94A3B8; text-decoration: none;">AC Repair</a></li>
                        <li><a href="{{ url('/services/cleaning') }}" style="color: #94A3B8; text-decoration: none;">Cleaning</a></li>
                        <li><a href="{{ url('/services/carpentry') }}" style="color: #94A3B8; text-decoration: none;">Carpentry</a></li>
                    </ul>
                </div>

                <div>
                    <strong style="color: #FFFFFF; font-size: 14px; display: block; margin-bottom: 14px;">Quick Links</strong>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13.5px; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="{{ url('/how-it-works') }}" style="color: #94A3B8; text-decoration: none;">How It Works</a></li>
                        <li><a href="{{ url('/technicians') }}" style="color: #94A3B8; text-decoration: none;">Find Technicians</a></li>
                        <li><a href="{{ url('/about') }}" style="color: #94A3B8; text-decoration: none;">About Us</a></li>
                        <li><a href="{{ url('/community') }}" style="color: #94A3B8; text-decoration: none;">Community Issues</a></li>
                        <li><a href="{{ url('/become-technician') }}" style="color: #94A3B8; text-decoration: none;">Become a Technician</a></li>
                    </ul>
                </div>

                <div>
                    <strong style="color: #FFFFFF; font-size: 14px; display: block; margin-bottom: 14px;">Support & Legal</strong>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13.5px; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="{{ url('/faqs') }}" style="color: #94A3B8; text-decoration: none;">FAQs</a></li>
                        <li><a href="{{ url('/contact') }}" style="color: #94A3B8; text-decoration: none;">Contact Us</a></li>
                        <li><a href="{{ url('/privacy-policy') }}" style="color: #94A3B8; text-decoration: none;">Privacy Policy</a></li>
                        <li><a href="{{ url('/terms') }}" style="color: #94A3B8; text-decoration: none;">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div style="border-top: 1px solid #1E293B; padding-top: 24px; display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; color: #64748B;">
                <div>© 2026 FixMate AI. All rights reserved.</div>
                <div style="display: flex; gap: 16px;">
                    <span>English (Pakistan)</span>
                    <span>•</span>
                    <a href="{{ url('/privacy-policy') }}" style="color: #64748B; text-decoration: none;">Privacy</a>
                    <span>•</span>
                    <a href="{{ url('/terms') }}" style="color: #64748B; text-decoration: none;">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleHeaderSearch() {
            const dropdown = document.getElementById('headerSearchDropdown');
            if (!dropdown) return;
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
                const input = document.getElementById('headerSearchQuery');
                if (input) input.focus();
            } else {
                dropdown.style.display = 'none';
            }
        }

        function toggleMobileNav() {
            const drawer = document.getElementById('headerMobileDrawer');
            if (!drawer) return;
            drawer.style.display = (drawer.style.display === 'none' || drawer.style.display === '') ? 'block' : 'none';
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const search = document.getElementById('headerSearchDropdown');
                const drawer = document.getElementById('headerMobileDrawer');
                if (search) search.style.display = 'none';
                if (drawer) drawer.style.display = 'none';
            }
        });
    </script>
</body>
</html>
