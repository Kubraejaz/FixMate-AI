<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'FixMate AI — Smart Home Services Made Simple')</title>
    <meta name="description" content="@yield('meta_desc', 'AI-powered home service platform connecting you with verified professionals in Pakistan.')">
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fixmate.css') }}">

    @yield('extra_css')
</head>
<body style="background: #FFFFFF; color: #1E293B; font-family: 'Plus Jakarta Sans', sans-serif;">

    <!-- Site Header matching user's exact mockup -->
    <header style="background: #FFFFFF; border-bottom: 1px solid #F1F5F9; position: sticky; top: 0; z-index: 100;">
        <div class="container" style="display: flex; align-items: center; justify-content: space-between; height: 72px;">
            
            <!-- Brand Logo matching mockup -->
            <a href="{{ url('/') }}" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #FFC107; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(255, 193, 7, 0.3);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <path d="M9 22V12h6v10"></path>
                    </svg>
                </div>
                <div style="display: flex; align-items: baseline; gap: 2px;">
                    <span style="font-size: 20px; font-weight: 900; color: #0F172A; letter-spacing: -0.02em;">FixMate</span>
                    <span style="font-size: 16px; font-weight: 900; color: #FFB800;">AI</span>
                </div>
            </a>

            <!-- Centered Nav Menu with Yellow Active Bar matching mockup -->
            <nav>
                <ul style="display: flex; align-items: center; gap: 28px; list-style: none; margin: 0; padding: 0;">
                    <li>
                        <a href="{{ url('/') }}" style="font-size: 14.5px; font-weight: 700; color: #0F172A; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            Home
                            @if(Request::is('/'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/services') }}" style="font-size: 14.5px; font-weight: 600; color: {{ Request::is('services*') ? '#0F172A' : '#64748B' }}; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            Services
                            @if(Request::is('services*'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/how-it-works') }}" style="font-size: 14.5px; font-weight: 600; color: {{ Request::is('how-it-works*') ? '#0F172A' : '#64748B' }}; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            How It Works
                            @if(Request::is('how-it-works*'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/technicians') }}" style="font-size: 14.5px; font-weight: 600; color: {{ Request::is('technicians*') ? '#0F172A' : '#64748B' }}; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            Find Technicians
                            @if(Request::is('technicians*'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/about') }}" style="font-size: 14.5px; font-weight: 600; color: {{ Request::is('about*') ? '#0F172A' : '#64748B' }}; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            About
                            @if(Request::is('about*'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/community') }}" style="font-size: 14.5px; font-weight: 600; color: {{ Request::is('community*') ? '#0F172A' : '#64748B' }}; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            Community
                            @if(Request::is('community*'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/faqs') }}" style="font-size: 14.5px; font-weight: 600; color: {{ Request::is('faqs*') ? '#0F172A' : '#64748B' }}; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            FAQs
                            @if(Request::is('faqs*'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" style="font-size: 14.5px; font-weight: 600; color: {{ Request::is('contact*') ? '#0F172A' : '#64748B' }}; text-decoration: none; padding: 6px 0; position: relative; display: inline-block;">
                            Contact
                            @if(Request::is('contact*'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: #FFB800; border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Right Actions: Search icon, Login, Sign Up matching mockup -->
            <div style="display: flex; align-items: center; gap: 14px;">
                <button type="button" onclick="document.getElementById('headerSearchBox')?.classList.toggle('active')" style="background: none; border: none; cursor: pointer; color: #475569; padding: 6px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" title="Search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <a href="{{ url('/login') }}" style="font-size: 14px; font-weight: 700; color: #1E293B; text-decoration: none; padding: 9px 18px; border: 1px solid #CBD5E1; border-radius: 10px; transition: all 0.2s;">
                    Login
                </a>

                <a href="{{ url('/register/role') }}" style="font-size: 14px; font-weight: 800; color: #0F172A; text-decoration: none; background: #FFC107; padding: 9px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35); transition: all 0.2s;">
                    Sign Up
                </a>
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
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #FFC107; display: flex; align-items: center; justify-content: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2.5">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            </svg>
                        </div>
                        <span style="font-size: 20px; font-weight: 900; color: #FFFFFF;">FixMate</span>
                        <span style="font-size: 15px; font-weight: 900; color: #FFC107;">AI</span>
                    </div>
                    <p style="font-size: 13.5px; line-height: 1.6; color: #94A3B8; max-width: 300px; margin-bottom: 16px;">
                        Smart diagnosis. Right technician. Hassle free. AI-powered home service platform connecting Pakistani homeowners with verified trade experts.
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ url('/customer/dashboard') }}" style="font-size: 11px; background: #1E293B; color: #F1F5F9; padding: 4px 10px; border-radius: 6px; text-decoration: none;">Customer Portal</a>
                        <a href="{{ url('/technician/dashboard') }}" style="font-size: 11px; background: #1E293B; color: #FFC107; padding: 4px 10px; border-radius: 6px; text-decoration: none;">Technician Portal</a>
                        <a href="{{ url('/admin/dashboard') }}" style="font-size: 11px; background: #1E293B; color: #94A3B8; padding: 4px 10px; border-radius: 6px; text-decoration: none;">Admin Console</a>
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

</body>
</html>
