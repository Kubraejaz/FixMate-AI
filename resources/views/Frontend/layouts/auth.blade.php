<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FixMate - Trusted Home Services Authentication">
    <title>@yield('title', 'Authentication — FixMate')</title>
    
    <!-- Application Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/Logo.png') }}">
    
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
            margin-bottom: 7px;
        }

        .app-label .req {
            color: #E11D48;
            margin-left: 2px;
        }

        /* Field Wrapper With Leading Icon */
        .app-field {
            position: relative;
            display: flex;
            align-items: center;
        }

        .app-field-icon {
            position: absolute;
            left: 15px;
            display: flex;
            align-items: center;
            color: #94A3B8;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .app-field:focus-within .app-field-icon {
            color: #FFA000;
        }

        .app-field .app-input.has-icon {
            padding-left: 44px;
        }

        .app-field .app-input.has-trailing {
            padding-right: 46px;
        }

        .app-hint {
            font-size: 12px;
            color: #94A3B8;
            margin: 6px 0 0;
            line-height: 1.45;
        }

        /* Select Field With Custom Chevron */
        .app-select {
            width: 100%;
            height: 48px;
            padding: 12px 42px 12px 16px;
            font-size: 14px;
            font-family: inherit;
            font-weight: 500;
            color: #0F172A;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            transition: all 0.2s ease;
        }

        .app-select.has-icon {
            padding-left: 44px;
        }

        .app-select:focus {
            border-color: #FFC107;
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.15);
        }

        .app-select:invalid,
        .app-select.is-placeholder {
            color: #94A3B8;
        }

        /* Two Column Field Grid */
        .app-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media (max-width: 480px) {
            .app-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Password Strength Meter */
        .pw-meter {
            display: flex;
            gap: 5px;
            margin-top: 8px;
        }

        .pw-meter span {
            flex: 1;
            height: 4px;
            border-radius: 3px;
            background: #E2E8F0;
            transition: background 0.25s ease;
        }

        .pw-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #94A3B8;
            margin-top: 6px;
        }

        /* Role Selection Cards */
        .role-card {
            display: block;
            padding: 22px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.22s ease;
        }

        .role-card:hover {
            border-color: #FFC107;
            box-shadow: 0 10px 26px -10px rgba(15, 23, 42, 0.16);
            transform: translateY(-3px);
        }

        .role-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .role-tag {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 4px 9px;
            border-radius: 6px;
            margin-bottom: 9px;
        }

        .role-card h3 {
            font-size: 17px;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.01em;
            margin-bottom: 6px;
        }

        .role-card p {
            font-size: 13px;
            color: #64748B;
            line-height: 1.55;
            margin: 0 0 14px;
        }

        .role-cta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            color: #0F172A;
        }

        .role-card:hover .role-cta {
            color: #B45309;
        }

        /* Feature Bullet List Used In Side Panels */
        .auth-feature {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #E2E8F0;
            line-height: 1.5;
        }

        .auth-feature .tick {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(255, 193, 7, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFC107;
            margin-top: 1px;
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

        .auth-nav-link-hide {
            display: none;
        }

        @media (min-width: 640px) {
            .auth-nav-link-hide {
                display: inline-flex;
            }
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
        <a href="{{ url('/') }}" class="auth-brand" style="text-decoration: none;">
            <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 38px; width: auto; object-fit: contain; display: block;">
        </a>

        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ url('/') }}" class="auth-nav-link">
                <span>←</span>
                <span>Back to Home</span>
            </a>
            <a href="{{ url('/faqs') }}" class="auth-nav-link auth-nav-link-hide">
                <span>Help &amp; FAQ</span>
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
            <span>&copy; 2026 FixMate. All rights reserved.</span>
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
