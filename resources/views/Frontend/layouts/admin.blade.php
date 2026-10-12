<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Admin Console — FixMate')</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">

    <style>
        :root {
            --adm-accent: #FFC107;
            --adm-accent-hover: #FFB300;
            --adm-accent-soft: #FFFBEB;
            --adm-ink: #0F172A;
            --adm-body: #334155;
            --adm-muted: #64748B;
            --adm-faint: #94A3B8;
            --adm-bg: #F1F5F9;
            --adm-surface: #FFFFFF;
            --adm-border: #E2E8F0;
            --adm-border-soft: #F1F5F9;
            --adm-success: #16A34A;
            --adm-success-soft: #F0FDF4;
            --adm-danger: #E11D48;
            --adm-danger-soft: #FFF1F2;
            --adm-info: #2563EB;
            --adm-info-soft: #EFF6FF;
            --adm-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 8px 24px -12px rgba(15, 23, 42, 0.10);
            --adm-radius: 14px;
            --adm-radius-sm: 10px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--adm-bg);
            color: var(--adm-ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
        }

        /* ============ Top Bar ============ */
        .adm-topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: var(--adm-surface);
            border-bottom: 1px solid var(--adm-border);
            padding: 0 26px;
            height: 66px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .adm-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .adm-brand img {
            height: 32px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .adm-console-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--adm-ink);
            background: var(--adm-accent);
            padding: 4px 9px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .adm-search {
            flex: 1;
            max-width: 460px;
            position: relative;
            display: flex;
            align-items: center;
        }

        .adm-search svg {
            position: absolute;
            left: 14px;
            color: var(--adm-faint);
            pointer-events: none;
        }

        .adm-search input {
            width: 100%;
            height: 42px;
            padding: 0 54px 0 42px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--adm-ink);
            background: var(--adm-bg);
            border: 1.5px solid transparent;
            border-radius: 10px;
            outline: none;
            transition: all 0.18s ease;
        }

        .adm-search input:focus {
            background: var(--adm-surface);
            border-color: var(--adm-accent);
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.14);
        }

        .adm-search input::placeholder {
            color: var(--adm-faint);
        }

        .adm-search kbd {
            position: absolute;
            right: 12px;
            font-size: 10px;
            font-weight: 700;
            font-family: inherit;
            color: var(--adm-faint);
            background: var(--adm-surface);
            border: 1px solid var(--adm-border);
            border-radius: 5px;
            padding: 2px 6px;
        }

        .adm-topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .adm-health {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 700;
            color: var(--adm-success);
            background: var(--adm-success-soft);
            border: 1px solid #BBF7D0;
            padding: 6px 11px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .adm-health .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--adm-success);
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
        }

        .adm-operator {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 14px;
            border-left: 1px solid var(--adm-border);
        }

        .adm-operator .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--adm-ink);
            color: var(--adm-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
        }

        .adm-operator .who {
            line-height: 1.25;
        }

        .adm-operator .who strong {
            display: block;
            font-size: 13px;
            color: var(--adm-ink);
        }

        .adm-operator .who span {
            font-size: 11px;
            color: var(--adm-muted);
        }

        /* ============ Shell ============ */
        .adm-shell {
            display: grid;
            grid-template-columns: 254px 1fr;
            gap: 26px;
            max-width: 1560px;
            margin: 0 auto;
            padding: 26px;
            align-items: start;
        }

        .adm-sidebar {
            position: sticky;
            top: 92px;
            background: var(--adm-surface);
            border: 1px solid var(--adm-border);
            border-radius: 18px;
            padding: 18px 14px;
            box-shadow: var(--adm-shadow);
        }

        .adm-sidebar-heading {
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--adm-faint);
            padding: 0 10px;
            margin: 4px 0 10px;
        }

        .adm-private-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: var(--adm-ink);
            color: #E2E8F0;
            font-size: 11.5px;
            line-height: 1.45;
            padding: 11px 12px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .adm-private-note svg {
            flex-shrink: 0;
            color: var(--adm-accent);
            margin-top: 1px;
        }

        .adm-nav {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .adm-nav-group {
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--adm-faint);
            padding: 14px 10px 6px;
        }

        .adm-nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            border-radius: 9px;
            border-left: 3px solid transparent;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--adm-body);
            text-decoration: none;
            transition: all 0.16s ease;
        }

        .adm-nav-link svg {
            flex-shrink: 0;
            color: var(--adm-faint);
            transition: color 0.16s ease;
        }

        .adm-nav-link:hover {
            background: var(--adm-border-soft);
            color: var(--adm-ink);
        }

        .adm-nav-link:hover svg {
            color: var(--adm-body);
        }

        .adm-nav-link.active {
            background: var(--adm-accent-soft);
            border-left-color: var(--adm-accent);
            color: var(--adm-ink);
            font-weight: 700;
        }

        .adm-nav-link.active svg {
            color: #B45309;
        }

        .adm-nav-link .count {
            margin-left: auto;
            font-size: 11px;
            font-weight: 800;
            background: var(--adm-accent);
            color: var(--adm-ink);
            border-radius: 20px;
            padding: 1px 7px;
        }

        .adm-nav-sep {
            height: 1px;
            background: var(--adm-border);
            margin: 12px 8px;
        }

        .adm-nav-link.danger {
            color: var(--adm-danger);
        }

        .adm-nav-link.danger svg {
            color: var(--adm-danger);
        }

        .adm-main {
            min-width: 0;
        }

        /* ============ Page Header ============ */
        .adm-page-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .adm-page-head h1 {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--adm-ink);
        }

        .adm-page-head p {
            font-size: 13.5px;
            color: var(--adm-muted);
            margin-top: 4px;
        }

        .adm-page-actions {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
        }

        /* ============ Buttons ============ */
        .adm-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 40px;
            padding: 0 17px;
            font-size: 13px;
            font-weight: 700;
            font-family: inherit;
            border-radius: 10px;
            border: 1.5px solid transparent;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.18s ease;
        }

        .adm-btn-primary {
            background: var(--adm-accent);
            color: var(--adm-ink);
            box-shadow: 0 3px 10px rgba(255, 193, 7, 0.32);
        }

        .adm-btn-primary:hover {
            background: var(--adm-accent-hover);
            transform: translateY(-1px);
        }

        .adm-btn-ghost {
            background: var(--adm-surface);
            border-color: var(--adm-border);
            color: var(--adm-ink);
        }

        .adm-btn-ghost:hover {
            border-color: #CBD5E1;
            background: var(--adm-border-soft);
        }

        .adm-btn-sm {
            height: 33px;
            padding: 0 12px;
            font-size: 12px;
            border-radius: 8px;
        }

        /* ============ Cards ============ */
        .adm-card {
            background: var(--adm-surface);
            border: 1px solid var(--adm-border);
            border-radius: 16px;
            padding: 20px 22px;
            box-shadow: var(--adm-shadow);
        }

        .adm-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .adm-card-head h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--adm-ink);
        }

        .adm-card-head .sub {
            font-size: 12px;
            color: var(--adm-faint);
        }

        .adm-card-link {
            font-size: 12px;
            font-weight: 700;
            color: #B45309;
            text-decoration: none;
        }

        .adm-card-link:hover {
            text-decoration: underline;
        }

        /* ============ KPI Cards ============ */
        .adm-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .adm-kpi {
            background: var(--adm-surface);
            border: 1px solid var(--adm-border);
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: var(--adm-shadow);
        }

        .adm-kpi .kpi-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .adm-kpi .kpi-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--adm-muted);
        }

        .adm-kpi .kpi-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .adm-kpi .kpi-value {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--adm-ink);
            line-height: 1.1;
        }

        .adm-kpi .kpi-value.accent {
            color: #B45309;
        }

        .adm-kpi .kpi-foot {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--adm-faint);
            margin-top: 6px;
        }

        .adm-kpi .kpi-foot.up {
            color: var(--adm-success);
        }

        .adm-kpi .kpi-foot.warn {
            color: #B45309;
        }

        /* ============ Grid Helpers ============ */
        .adm-grid-2 {
            display: grid;
            grid-template-columns: 1.35fr 0.65fr;
            gap: 18px;
            margin-bottom: 20px;
        }

        .adm-grid-2-even {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 20px;
        }

        .adm-stack {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-bottom: 20px;
        }

        /* ============ Bars & Progress ============ */
        .adm-bar-row {
            margin-bottom: 14px;
        }

        .adm-bar-row:last-child {
            margin-bottom: 0;
        }

        .adm-bar-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
            margin-bottom: 6px;
        }

        .adm-bar-head .name {
            color: var(--adm-body);
            font-weight: 500;
        }

        .adm-bar-head .val {
            color: var(--adm-ink);
            font-weight: 700;
        }

        .adm-bar {
            height: 7px;
            background: var(--adm-border-soft);
            border-radius: 4px;
            overflow: hidden;
        }

        .adm-bar > span {
            display: block;
            height: 100%;
            border-radius: 4px;
        }

        .adm-bar.yellow > span { background: var(--adm-accent); }
        .adm-bar.green > span  { background: var(--adm-success); }
        .adm-bar.blue > span   { background: var(--adm-info); }
        .adm-bar.purple > span { background: #A855F7; }

        /* ============ Stat Rows ============ */
        .adm-stat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            font-size: 13px;
            padding: 10px 0;
            border-bottom: 1px solid var(--adm-border-soft);
        }

        .adm-stat-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .adm-stat-row .label {
            color: var(--adm-muted);
        }

        .adm-stat-row .value {
            font-weight: 700;
            color: var(--adm-ink);
        }

        /* ============ Badges ============ */
        .adm-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.02em;
            padding: 4px 9px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .adm-badge.yellow { background: var(--adm-accent-soft); color: #B45309; }
        .adm-badge.green  { background: var(--adm-success-soft); color: #15803D; }
        .adm-badge.blue   { background: var(--adm-info-soft); color: #1D4ED8; }
        .adm-badge.red    { background: var(--adm-danger-soft); color: #BE123C; }
        .adm-badge.grey   { background: var(--adm-border-soft); color: var(--adm-muted); }
        .adm-badge.dark   { background: var(--adm-ink); color: var(--adm-accent); }

        /* ============ Tables ============ */
        .adm-table-wrap {
            overflow-x: auto;
        }

        .adm-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .adm-table th {
            text-align: left;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--adm-faint);
            padding: 0 14px 11px;
            border-bottom: 1px solid var(--adm-border);
            white-space: nowrap;
        }

        .adm-table td {
            padding: 13px 14px;
            border-bottom: 1px solid var(--adm-border-soft);
            color: var(--adm-body);
            vertical-align: middle;
        }

        .adm-table tr:last-child td {
            border-bottom: none;
        }

        .adm-table tbody tr:hover {
            background: #FBFCFE;
        }

        .adm-table td strong {
            color: var(--adm-ink);
            font-weight: 700;
        }

        .adm-person {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .adm-person img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--adm-border);
            flex-shrink: 0;
        }

        .adm-person .pname {
            font-weight: 700;
            color: var(--adm-ink);
            line-height: 1.3;
        }

        .adm-person .pmeta {
            font-size: 11.5px;
            color: var(--adm-faint);
        }

        /* ============ Media ============ */
        .adm-media {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .adm-media img {
            width: 52px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--adm-border);
            flex-shrink: 0;
        }

        /* ============ Inputs ============ */
        .adm-field {
            margin-bottom: 16px;
        }

        .adm-field label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--adm-ink);
            margin-bottom: 7px;
        }

        .adm-input,
        .adm-select,
        .adm-textarea {
            width: 100%;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--adm-ink);
            background: var(--adm-surface);
            border: 1.5px solid var(--adm-border);
            border-radius: 10px;
            outline: none;
            padding: 0 14px;
            height: 42px;
            transition: all 0.18s ease;
        }

        .adm-textarea {
            height: auto;
            padding: 11px 14px;
            resize: vertical;
        }

        .adm-input:focus,
        .adm-select:focus,
        .adm-textarea:focus {
            border-color: var(--adm-accent);
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.14);
        }

        .adm-select {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 38px;
        }

        .adm-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 16px;
        }

        /* ============ Chart ============ */
        .adm-chart {
            width: 100%;
            height: 218px;
        }

        .adm-axis {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--adm-faint);
            margin-top: 10px;
        }

        /* ============ Empty ============ */
        .adm-empty {
            text-align: center;
            padding: 44px 20px;
            color: var(--adm-muted);
        }

        .adm-empty svg {
            color: var(--adm-border);
            margin-bottom: 12px;
        }

        .adm-empty p {
            font-size: 13.5px;
        }

        .adm-empty .sub {
            font-size: 12.5px;
            color: var(--adm-faint);
            margin-top: 5px;
        }

        /* ============ Toast ============ */
        #fmToast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            transform: translateY(30px);
            opacity: 0;
            pointer-events: none;
            transition: all 0.25s ease;
        }

        #fmToast .toast-body {
            background: var(--adm-ink);
            color: #FFFFFF;
            padding: 12px 20px;
            border-radius: 12px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.22);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 600;
        }

        /* ============ Responsive ============ */
        @media (max-width: 1180px) {
            .adm-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .adm-grid-2,
            .adm-grid-2-even {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 980px) {
            .adm-shell {
                grid-template-columns: 1fr;
            }
            .adm-sidebar {
                position: static;
            }
            .adm-search {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .adm-kpi-grid,
            .adm-form-grid {
                grid-template-columns: 1fr;
            }
            .adm-shell {
                padding: 16px;
            }
            .adm-topbar {
                padding: 0 16px;
            }
            .adm-health {
                display: none;
            }
        }

        /* ============ Pagination Component ============ */
        .adm-pagination-wrap {
            margin-top: 24px;
            padding: 16px 20px;
            background: var(--adm-surface);
            border: 1px solid var(--adm-border);
            border-radius: 14px;
            box-shadow: var(--adm-shadow);
        }

        nav[role="navigation"] {
            display: flex;
            flex-direction: column;
            gap: 14px;
            width: 100%;
        }

        @media (min-width: 640px) {
            nav[role="navigation"] {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        nav[role="navigation"] > div:first-child:not(:only-child) {
            display: none !important;
        }

        nav[role="navigation"] > div:last-child {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 14px;
            flex-wrap: wrap;
        }

        nav[role="navigation"] p {
            font-size: 13px !important;
            color: var(--adm-muted) !important;
            margin: 0 !important;
            font-weight: 500 !important;
        }

        nav[role="navigation"] p span {
            font-weight: 700 !important;
            color: var(--adm-ink) !important;
        }

        nav[role="navigation"] svg {
            width: 15px !important;
            height: 15px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        nav[role="navigation"] span.relative,
        nav[role="navigation"] .shadow-sm {
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span[aria-current="page"] > span,
        nav[role="navigation"] span[aria-disabled="true"] > span {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 11px !important;
            font-size: 12.5px !important;
            font-weight: 700 !important;
            font-family: inherit !important;
            border-radius: 8px !important;
            border: 1px solid var(--adm-border) !important;
            background: var(--adm-surface) !important;
            color: var(--adm-ink) !important;
            text-decoration: none !important;
            transition: all 0.16s ease !important;
            line-height: 1 !important;
        }

        nav[role="navigation"] a:hover {
            background: var(--adm-accent-soft) !important;
            border-color: var(--adm-accent) !important;
            color: #B45309 !important;
            transform: translateY(-1px);
        }

        nav[role="navigation"] span[aria-current="page"] > span {
            background: var(--adm-accent) !important;
            color: var(--adm-ink) !important;
            border-color: var(--adm-accent) !important;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35) !important;
        }

        nav[role="navigation"] span[aria-disabled="true"] > span {
            opacity: 0.45 !important;
            background: var(--adm-border-soft) !important;
            cursor: not-allowed !important;
        }
    </style>

    @yield('extra_css')
</head>
<body>

    <!-- Top Bar -->
    <header class="adm-topbar">
        <a href="{{ url('/admin/dashboard') }}" class="adm-brand">
            <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate">
            <span class="adm-console-badge">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Admin</span>
            </span>
        </a>

        <form action="{{ url('/admin/bookings') }}" method="GET" class="adm-search">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search user, booking #FM, dispute...">
            <kbd>Ctrl K</kbd>
        </form>

        <div class="adm-topbar-right">
            @php
                $adminNotifications = auth()->check() ? auth()->user()->notifications()->latest()->take(6)->get() : collect();
                $adminUnreadCount = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0;
            @endphp
            <div style="position: relative;" id="adminNotifContainer">
                <button type="button" id="adminNotifBtn" style="background: #FFFFFF; border: 1.5px solid var(--adm-border); width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative;" title="Platform Verification Alerts">
                    <span style="font-size: 16px;">🔔</span>
                    @if($adminUnreadCount > 0)
                        <span id="adminNotifBadge" style="position: absolute; top: -4px; right: -4px; background: var(--adm-danger); color: #FFF; font-size: 10px; font-weight: 800; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            {{ $adminUnreadCount }}
                        </span>
                    @endif
                </button>

                <div id="adminNotifPanel" style="display: none; position: absolute; right: 0; top: 48px; width: 360px; background: #FFFFFF; border: 1px solid var(--adm-border); border-radius: 14px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12); z-index: 1000; overflow: hidden;">
                    <div style="padding: 12px 16px; background: var(--adm-ink); color: #FFF; display: flex; justify-content: space-between; align-items: center;">
                        <strong style="font-size: 13px;">Platform Alerts (<span id="adminNotifCountText">{{ $adminUnreadCount }}</span> New)</strong>
                        <form id="adminMarkAllForm" action="{{ route('admin.notifications.read-all') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" id="adminMarkAllBtn" style="background: none; border: none; color: var(--adm-accent); font-size: 11px; font-weight: 700; cursor: pointer; text-decoration: underline;">
                                Mark all read
                            </button>
                        </form>
                    </div>
                    <div id="adminNotifList" style="max-height: 320px; overflow-y: auto;">
                        @forelse($adminNotifications as $an)
                            @php
                                $aIcon = match($an->type) {
                                    'technician_registered', 'kyc_submitted', 'kyc_approved', 'kyc_rejected' => '🛡️',
                                    'booking_dispatched', 'booking_created' => '⚡',
                                    'escrow_held', 'payment' => '💰',
                                    'inquiry_received', 'complaint_filed' => '💬',
                                    default => '🔔',
                                };
                            @endphp
                            <a href="{{ route('admin.notifications.open', $an->id) }}" class="admin-notif-item" data-id="{{ $an->id }}" style="text-decoration: none; display: block; padding: 12px 16px; border-bottom: 1px solid var(--adm-border-soft); background: {{ $an->is_read ? '#FFF' : '#FFFDF0' }}; transition: background 0.15s ease;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 3px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span style="font-size: 13px;">{{ $aIcon }}</span>
                                        <strong style="font-size: 12.5px; color: var(--adm-ink);">{{ $an->title }}</strong>
                                    </div>
                                    <span style="font-size: 10px; color: var(--adm-faint);">{{ $an->created_at->diffForHumans(null, true) }}</span>
                                </div>
                                <p style="font-size: 12px; color: var(--adm-body); margin: 3px 0 0 20px; line-height: 1.4;">{{ $an->message }}</p>
                                @if(!$an->is_read)
                                    <span class="unread-pill-admin" style="display: inline-block; margin-left: 20px; margin-top: 4px; font-size: 9.5px; font-weight: 800; color: #D97706; background: #FEF3C7; padding: 1px 6px; border-radius: 4px;">UNREAD</span>
                                @endif
                            </a>
                        @empty
                            <div style="padding: 24px; text-align: center; color: var(--adm-muted); font-size: 12.5px;">
                                ✨ All verification queues clear
                            </div>
                        @endforelse
                    </div>
                    <div style="padding: 10px 16px; background: var(--adm-bg); border-top: 1px solid var(--adm-border); display: flex; justify-content: space-between; align-items: center;">
                        <a href="{{ route('admin.notifications') }}" style="font-size: 11.5px; font-weight: 800; color: #D97706; text-decoration: none;">
                            🔔 View All Alerts
                        </a>
                        <a href="{{ route('admin.technicians.verification') }}" style="font-size: 11.5px; font-weight: 700; color: var(--adm-ink); text-decoration: none;">
                            🛡️ Check KYC →
                        </a>
                    </div>
                </div>
            </div>

            <span class="adm-health">
                <span class="dot"></span>
                Systems Online
            </span>

            <div class="adm-operator">
                <span class="avatar">OP</span>
                <span class="who">
                    <strong>Platform Operator</strong>
                    <span>Single administrator</span>
                </span>
            </div>
        </div>
    </header>

    <!-- Shell -->
    <div class="adm-shell">

        <!-- Sidebar -->
        <aside class="adm-sidebar">
            <div class="adm-private-note">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Private console. Restricted to the single platform administrator.</span>
            </div>

            <nav class="adm-nav">
                <span class="adm-sidebar-heading">Overview</span>

                <a href="{{ url('/admin/dashboard') }}" class="adm-nav-link {{ Request::is('admin', 'admin/dashboard*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="5" rx="1.5"></rect>
                        <rect x="14" y="12" width="7" height="9" rx="1.5"></rect>
                        <rect x="3" y="16" width="7" height="5" rx="1.5"></rect>
                    </svg>
                    <span>Dashboard &amp; KPIs</span>
                </a>

                <a href="{{ route('admin.notifications') }}" class="adm-nav-link {{ Request::is('admin/notifications*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span>System Alerts</span>
                    @if($adminUnreadCount > 0)
                        <span class="count">{{ $adminUnreadCount }}</span>
                    @endif
                </a>

                <a href="{{ url('/admin/analytics') }}" class="adm-nav-link {{ Request::is('admin/analytics*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18"></path>
                        <path d="M7 15l4-5 3 3 5-7"></path>
                    </svg>
                    <span>Growth Analytics</span>
                </a>

                <span class="adm-nav-group">People</span>

                <a href="{{ url('/admin/customers') }}" class="adm-nav-link {{ Request::is('admin/customers', 'admin/users') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    </svg>
                    <span>Customer Accounts</span>
                </a>

                <a href="{{ url('/admin/technicians') }}" class="adm-nav-link {{ Request::is('admin/technicians') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6z"></path>
                        <path d="M17.5 3.5l3 3"></path>
                    </svg>
                    <span>Technicians Pool</span>
                </a>

                <a href="{{ route('admin.technicians.verification') }}" class="adm-nav-link {{ Request::is('admin/technicians/verification*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M9 12l2 2 4-4"></path>
                    </svg>
                    <span>KYC Verifications</span>
                    @php
                        $pendingAppsCount = \App\Models\TechnicianApplication::where('status', 'pending')->count();
                    @endphp
                    @if($pendingAppsCount > 0)
                        <span class="count">{{ $pendingAppsCount }}</span>
                    @endif
                </a>

                <span class="adm-nav-group">Operations</span>

                <a href="{{ route('admin.services') }}" class="adm-nav-link {{ Request::is('admin/categories*', 'admin/services*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    <span>Services &amp; Categories</span>
                </a>

                <a href="{{ url('/admin/bookings') }}" class="adm-nav-link {{ Request::is('admin/bookings*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <path d="M16 2v4"></path>
                        <path d="M8 2v4"></path>
                        <path d="M3 10h18"></path>
                    </svg>
                    <span>All Bookings</span>
                </a>


                <a href="{{ url('/admin/payments') }}" class="adm-nav-link {{ Request::is('admin/payments*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2.5"></rect>
                        <path d="M2 10h20"></path>
                    </svg>
                    <span>Escrow &amp; Settlements</span>
                </a>

                <a href="{{ route('admin.inquiries') }}" class="adm-nav-link {{ Request::is('admin/inquiries*', 'admin/complaints*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Support &amp; Inquiries</span>
                    @php
                        $newInquiriesCount = \App\Models\ContactInquiry::where('status', 'new')->count();
                    @endphp
                    @if($newInquiriesCount > 0)
                        <span class="count">{{ $newInquiriesCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.faqs') }}" class="adm-nav-link {{ Request::is('admin/faqs*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>FAQs &amp; Help Center</span>
                </a>

                <a href="{{ route('admin.community') }}" class="adm-nav-link {{ Request::is('admin/community*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Civic Hazards &amp; Squads</span>
                    @php
                        $alertCount = \App\Models\CommunityIssue::where('status', 'alert_active')->count();
                    @endphp
                    @if($alertCount > 0)
                        <span class="count" style="background: #FEE2E2; color: #991B1B;">{{ $alertCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.homepage') }}" class="adm-nav-link {{ Request::is('admin/homepage*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="3" y1="9" x2="21" y2="9"></line>
                        <line x1="9" y1="21" x2="9" y2="9"></line>
                    </svg>
                    <span>Homepage CMS</span>
                </a>

                <span class="adm-nav-group">System</span>

                <a href="{{ url('/admin/settings') }}" class="adm-nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9c.14.63.68 1.09 1.51 1H21a2 2 0 1 1 0 4h-.09c-.83 0-1.37.46-1.51 1z"></path>
                    </svg>
                    <span>Platform Settings</span>
                </a>

                <div class="adm-nav-sep"></div>

                <a href="{{ url('/') }}" class="adm-nav-link">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M3 12h18"></path>
                        <path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z"></path>
                    </svg>
                    <span>Public Website</span>
                </a>

                <a href="{{ url('/login') }}" class="adm-nav-link danger">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <path d="M16 17l5-5-5-5"></path>
                        <path d="M21 12H9"></path>
                    </svg>
                    <span>Sign Out</span>
                </a>
            </nav>
        </aside>

        <!-- Main Workspace -->
        <main class="adm-main">
            @yield('content')
        </main>

    </div>

    <!-- Toast -->
    <div id="fmToast">
        <div class="toast-body">
            <span id="fmToastIcon" style="color: var(--adm-accent);">&#10003;</span>
            <span id="fmToastMsg">Action completed</span>
        </div>
    </div>

    <script>
        function showToast(msg, isSuccess = true) {
            var toast = document.getElementById('fmToast');
            document.getElementById('fmToastMsg').textContent = msg;
            var icon = document.getElementById('fmToastIcon');
            icon.textContent = isSuccess ? '✓' : '⚠';
            icon.style.color = isSuccess ? '#16A34A' : '#E11D48';
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
            toast.style.pointerEvents = 'auto';
            setTimeout(function () {
                toast.style.transform = 'translateY(30px)';
                toast.style.opacity = '0';
                toast.style.pointerEvents = 'none';
            }, 3000);
        }

        // Admin Notification Dropdown
        var adminNotifBtn = document.getElementById('adminNotifBtn');
        var adminNotifPanel = document.getElementById('adminNotifPanel');
        if (adminNotifBtn && adminNotifPanel) {
            adminNotifBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                adminNotifPanel.style.display = adminNotifPanel.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', function(e) {
                if (!adminNotifPanel.contains(e.target) && e.target !== adminNotifBtn) {
                    adminNotifPanel.style.display = 'none';
                }
            });
        }

        var adminMarkAllBtn = document.getElementById('adminMarkAllBtn');
        if (adminMarkAllBtn) {
            adminMarkAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                fetch("{{ route('admin.notifications.read-all') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    var badge = document.getElementById('adminNotifBadge');
                    if (badge) badge.remove();
                    var countTxt = document.getElementById('adminNotifCountText');
                    if (countTxt) countTxt.textContent = '0';
                    document.querySelectorAll('.admin-notif-item').forEach(el => {
                        el.style.background = '#FFFFFF';
                    });
                    document.querySelectorAll('.unread-pill-admin').forEach(el => {
                        el.remove();
                    });
                    showToast('All platform notifications marked as read', true);
                })
                .catch(() => {
                    document.getElementById('adminMarkAllForm').submit();
                });
            });
        }

        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                var input = document.querySelector('.adm-search input');
                if (input) { input.focus(); }
            }
        });
    </script>

    @yield('extra_js')
</body>
</html>
