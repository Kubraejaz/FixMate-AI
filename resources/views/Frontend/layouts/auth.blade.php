<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FixMate AI - Smart Home Services Authentication">
    <title>@yield('title', 'Authentication — FixMate AI')</title>
    
    <!-- Modern Application Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #FFC107;
            --primary-hover: #FFB300;
            --primary-dark: #FFA000;
            --primary-light: #FFFBEB;
            --dark: #0F172A;
            --slate: #334155;
            --muted: #64748B;
            --light-bg: #F8FAFC;
            --border: #E2E8F0;
            --card-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.07), 0 0 1px 1px rgba(15, 23, 42, 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Minimal Application Bar */
        .auth-topbar {
            background: #FFFFFF;
            border-bottom: 1px solid #F1F5F9;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #FFC107;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.35);
        }

        .brand-text {
            font-size: 21px;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.02em;
        }

        .brand-text span {
            color: #FFB300;
        }

        .auth-nav-link {
            font-size: 13.5px;
            font-weight: 600;
            color: #64748B;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 20px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            transition: all 0.2s ease;
        }

        .auth-nav-link:hover {
            color: #0F172A;
            border-color: #CBD5E1;
            background: #FFFFFF;
        }

        /* Main Workspace Wrapper */
        .auth-main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* Form Inputs & Controls */
        .app-input {
            width: 100%;
            height: 48px;
            padding: 12px 16px;
            font-size: 14px;
            font-family: inherit;
            color: #0F172A;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
        }

        .app-input:focus {
            border-color: #FFC107;
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.15);
        }

        .app-input::placeholder {
            color: #94A3B8;
        }

        .app-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 6px;
        }

        .app-btn-primary {
            width: 100%;
            height: 48px;
            background: #FFC107;
            color: #0F172A;
            font-size: 15px;
            font-weight: 800;
            font-family: inherit;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(255, 193, 7, 0.35);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .app-btn-primary:hover {
            background: #FFB300;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(255, 179, 0, 0.4);
        }

        .app-btn-primary:active {
            transform: translateY(0);
        }

        .app-btn-social {
            width: 100%;
            height: 46px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            color: #1E293B;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
        }

        .app-btn-social:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            transform: translateY(-1px);
        }

        /* Bottom Minimal Application Bar */
        .auth-footer {
            padding: 16px 24px;
            text-align: center;
            font-size: 12.5px;
            color: #94A3B8;
            border-top: 1px solid #F1F5F9;
            background: #FFFFFF;
        }

        .auth-footer a {
            color: #64748B;
            text-decoration: none;
            margin: 0 6px;
            font-weight: 600;
        }

        .auth-footer a:hover {
            color: #0F172A;
        }

        @media (max-width: 900px) {
            .auth-side-banner {
                display: none !important;
            }
            .auth-form-card {
                grid-template-columns: 1fr !important;
                max-width: 480px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Minimal Header -->
    <header class="auth-topbar">
        <a href="{{ url('/') }}" class="auth-brand">
            <div class="brand-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <path d="M9 22V12h6v10"></path>
                </svg>
            </div>
            <span class="brand-text">FixMate <span>AI</span></span>
        </a>

        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ url('/') }}" class="auth-nav-link">
                <span>←</span>
                <span>Back to Home</span>
            </a>
            <a href="{{ url('/faqs') }}" class="auth-nav-link" style="display: none; @media(min-width: 640px){display: inline-flex;}">
                <span>Help & FAQ</span>
            </a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="auth-main-wrapper">
        @yield('content')
    </main>

    <!-- Minimal Footer -->
    <footer class="auth-footer">
        <div>
            <span>&copy; 2026 FixMate AI Platform. All rights reserved.</span>
            <span>•</span>
            <a href="{{ url('/privacy-policy') }}">Privacy</a>
            <span>•</span>
            <a href="{{ url('/terms') }}">Terms</a>
            <span>•</span>
            <a href="{{ url('/contact') }}">Support</a>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
