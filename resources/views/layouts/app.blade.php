<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Dashboard App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body { padding-top: 70px; overflow-x: hidden; }
        body.dashboard-admin { padding-top: 0; overflow-x: hidden; }
        body.auth-page { padding-top: 0; min-height: 100vh; background: radial-gradient(circle at top left, rgba(255,255,255,.25), transparent 25%), linear-gradient(135deg, #f78ca0, #f7b42c); display: flex; align-items: center; justify-content: center; margin: 0; }
        body.auth-page::before { content: ''; position: fixed; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,.14), rgba(255,255,255,0)); pointer-events: none; }
        body.auth-page .container { min-height: 100vh; width: 100%; max-width: 100%; padding: 0; display: flex; align-items: center; justify-content: center; }
        .auth-card { width: 100%; max-width: 420px; border-radius: 30px; background: rgba(255,255,255,.98); box-shadow: 0 30px 60px rgba(0,0,0,.14); padding: 2rem; margin: 2rem; box-sizing: border-box; }
        .auth-icon { width: 100px; height: 100px; border-radius: 50%; background: #ffffff; display: grid; place-items: center; margin: 0 auto 1.25rem; box-shadow: 0 15px 40px rgba(0,0,0,.12); }
        .auth-icon svg { width: 42px; height: 42px; }
        .auth-input { border-radius: 999px; padding-left: 3rem; }
        .input-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #d63384; pointer-events: none; }
        .auth-footer a { color: #d63384; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        @media (max-width: 576px) {
            body.auth-page { padding: 1rem 0 2rem; }
            body.auth-page .container { padding: 0 1rem; align-items: flex-start; }
            .auth-card { max-width: 100%; margin: 1rem auto; padding: 1.5rem; border-radius: 24px; }
            .auth-icon { width: 84px; height: 84px; margin-bottom: 1rem; }
            .auth-icon svg { width: 36px; height: 36px; }
            .auth-card h2 { font-size: 1.5rem; }
            .auth-card p { font-size: 0.95rem; margin-bottom: 1.25rem; }
            .auth-input { padding-left: 3.5rem; }
            .auth-footer { font-size: 0.95rem; }
            .auth-footer a { display: inline-block; margin-top: 0.5rem; }
        }
        .sidebar-link { color: #fff; }
        .sidebar { background: #343a40; min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,.85); }
        .sidebar .nav-link:hover { color: #fff; }
        .sidebar-panel {
            width: 280px;
            background: #ffffff;
            border-radius: 28px;
            padding: 1.5rem;
            box-shadow: 0 30px 60px rgba(15, 23, 42, .08);
        }
        .sidebar-panel .brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.5rem;
        }
        .sidebar-panel .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 16px;
            background: #4f46e5;
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
        }
        .sidebar-panel .search-input {
            background: #f8f9ff;
            border: 1px solid transparent;
            border-radius: 18px;
            padding: .85rem 1rem .85rem 3.25rem;
            width: 100%;
            color: #334155;
        }
        .sidebar-panel .search-input::placeholder {
            color: #94a3b8;
        }
        .sidebar-panel .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #c2410c;
        }
        .sidebar-panel .nav-link {
            display: flex;
            align-items: center;
            gap: .9rem;
            color: #64748b;
            border-radius: 18px;
            padding: .85rem 1rem;
            margin-bottom: .35rem;
            transition: background .2s, color .2s;
        }
        .sidebar-panel .nav-link:hover,
        .sidebar-panel .nav-link.active {
            background: #eef2ff;
            color: #3730a3;
        }
        .sidebar-panel .nav-link-icon {
            width: 1.35rem;
            height: 1.35rem;
            display: grid;
            place-items: center;
        }
        .sidebar-panel .nav-footer {
            border-top: 1px solid #e2e8f0;
            margin-top: 1.5rem;
            padding-top: 1rem;
        }
        .sidebar-panel .toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .5rem;
        }
        .sidebar-panel .toggle-switch {
            width: 44px;
            height: 24px;
            border-radius: 999px;
            background: #e2e8f0;
            position: relative;
        }
        .sidebar-panel .toggle-switch::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #fff;
            transition: transform .2s;
        }
        .sidebar-panel .toggle-switch.active::after {
            transform: translateX(20px);
        }
        .dashboard-shell {
            position: relative;
            display: block;
            padding: 2rem 0 0;
            min-height: 100vh;
        }
        .dashboard-sidebar,
        .dashboard-sidebar * {
            box-sizing: border-box;
        }
        .dashboard-sidebar {
            width: 96px;
            min-height: 100vh;
            background: #0f172a;
            border-radius: 0 32px 32px 0;
            padding: 1.75rem 1rem;
            color: #e2e8f0;
            box-shadow: 0 35px 80px rgba(0, 0, 0, .18);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1050;
            transition: width .25s ease, padding .25s ease, transform .25s ease, opacity .25s ease;
            overflow: visible;
            display: flex;
            flex-direction: column;
            min-width: 96px;
        }
        .dashboard-sidebar.open {
            width: 280px;
            padding: 1.75rem;
            min-width: 280px;
        }
        .dashboard-sidebar .sidebar-header,
        .dashboard-sidebar .sidebar-menu,
        .dashboard-sidebar .sidebar-footer {
            width: 100%;
        }
        .dashboard-sidebar .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            gap: .75rem;
            margin-bottom: 1.5rem;
            padding-top: 0.25rem;
            position: relative;
            text-align: center;
        }
        .dashboard-sidebar .sidebar-toggle {
            position: absolute;
            top: 0.5rem;
            right: -75px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.16);
            color: #ffffff;
            background: rgba(15, 23, 42, .95);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .15);
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }
        .dashboard-sidebar .sidebar-toggle:hover {
            background: rgba(255,255,255,.08);
            transform: translateX(2px);
        }
        .dashboard-sidebar .sidebar-brand-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            width: 100%;
            text-align: center;
            color: inherit;
        }
        .dashboard-sidebar .sidebar-brand-center:hover .brand-title {
            color: #ffffff;
        }
        .dashboard-sidebar .sidebar-brand-center:hover .brand-subtitle {
            color: #cbd5e1;
        }
        .dashboard-sidebar .brand-mark {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            display: grid;
            place-items: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.15rem;
            box-shadow: 0 10px 24px rgba(99, 102, 241, .35);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .dashboard-sidebar .sidebar-brand-center:hover .brand-mark {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(99, 102, 241, .45);
        }
        .dashboard-sidebar .brand-text {
            color: #f8fafc;
            opacity: 0;
            display: none;
            width: 100%;
            overflow: hidden;
            transform: translateY(-6px);
            transition: opacity .25s ease, transform .25s ease;
        }
        .dashboard-sidebar.open .brand-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.15rem;
            opacity: 1;
            transform: translateY(0);
        }
        .dashboard-sidebar .brand-title {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #f8fafc;
            line-height: 1.2;
        }
        .dashboard-sidebar .brand-subtitle {
            font-size: 0.78rem;
            font-weight: 500;
            color: #94a3b8;
            letter-spacing: 0.02em;
        }
        .dashboard-sidebar .search-input {
            width: 100%;
            background: #111a36;
            border-color: #243257;
            color: #e2e8f0;
            padding-left: 3rem;
            transition: opacity .25s ease, width .25s ease;
            opacity: 0;
            width: 0;
        }
        .dashboard-sidebar.open .search-input {
            opacity: 1;
            width: 100%;
        }
        .dashboard-sidebar .search-input::placeholder {
            color: #94a3b8;
        }
        .dashboard-sidebar .search-icon {
            position: absolute;
            top: 0.95rem;
            left: 1.1rem;
            color: #a78bfa;
            opacity: 0;
            transition: opacity .25s ease;
        }
        .dashboard-sidebar.open .search-icon {
            opacity: 1;
        }
        .dashboard-sidebar .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: .35rem;
            margin-top: 1rem;
            align-items: center;
        }
        .dashboard-sidebar.open .sidebar-menu {
            align-items: stretch;
        }
        .dashboard-sidebar .nav-link,
        .dashboard-sidebar .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #cbd5e1;
            border-radius: 16px;
            padding: 1rem;
            width: 100%;
            transition: background .2s, color .2s, transform .2s;
            background: transparent;
            border: none;
            text-decoration: none;
            cursor: pointer;
            justify-content: center;
        }
        .dashboard-sidebar.open .nav-link,
        .dashboard-sidebar.open .dropdown-toggle {
            justify-content: flex-start;
        }
        .dashboard-sidebar .nav-link:hover,
        .dashboard-sidebar .dropdown-toggle:hover {
            background: rgba(255, 255, 255, .08);
            color: #ffffff;
            transform: translateX(2px);
        }
        .dashboard-sidebar .nav-link.active,
        .dashboard-sidebar .dropdown-toggle.active {
            background: rgba(255, 255, 255, .14);
            color: #ffffff;
            font-weight: 600;
        }
        .dashboard-sidebar .nav-link-icon {
            width: 20px;
            height: 20px;
            display: grid;
            place-items: center;
            font-size: 1rem;
        }
        .dashboard-sidebar .nav-link-text {
            display: none;
            opacity: 0;
            width: 0;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity .25s ease, width .25s ease, margin .25s ease;
            margin-left: 0;
        }
        .dashboard-sidebar.open .nav-link-text {
            display: inline;
            opacity: 1;
            width: auto;
            margin-left: .25rem;
        }
        .dashboard-sidebar .dropdown-arrow {
            display: none;
            margin-left: auto;
            opacity: 0;
            transform: rotate(0deg);
            transition: opacity .2s ease, transform .2s ease;
        }
        .dashboard-sidebar.open .dropdown-arrow {
            display: inline;
            opacity: 1;
        }
        .dashboard-sidebar .sidebar-item.open .dropdown-arrow {
            transform: rotate(180deg);
        }
        .dashboard-sidebar .sidebar-submenu {
            display: none;
            flex-direction: column;
            padding-left: 2.25rem;
            gap: .35rem;
            margin-bottom: .75rem;
        }
        .dashboard-sidebar.open .sidebar-item.open .sidebar-submenu {
            display: flex;
        }
        .dashboard-sidebar:not(.open) .sidebar-submenu {
            display: none !important;
        }
        .dashboard-sidebar .subnav-link {
            color: #94a3b8;
            border-radius: 14px;
            padding: .85rem 1rem;
            transition: background .2s, color .2s;
            text-decoration: none;
            display: block;
        }
        .dashboard-sidebar:not(.open) .dropdown-toggle {
            justify-content: center;
        }
        .dashboard-sidebar:not(.open) .dropdown-toggle .nav-link-text,
        .dashboard-sidebar:not(.open) .dropdown-toggle .dropdown-arrow {
            opacity: 0;
            width: 0;
            margin: 0;
        }
        .dashboard-sidebar .search-input {
            width: 100%;
            background: #111a36;
            border-color: #243257;
            color: #e2e8f0;
            padding-left: 3rem;
            transition: opacity .25s ease, width .25s ease;
            opacity: 0;
            width: 0;
            pointer-events: none;
        }
        .dashboard-sidebar.open .search-input {
            opacity: 1;
            width: 100%;
            pointer-events: auto;
        }
        .dashboard-sidebar .subnav-link:hover,
        .dashboard-sidebar .subnav-link.active {
            background: rgba(255, 255, 255, .08);
            color: #ffffff;
        }
        .dashboard-sidebar .sidebar-footer {
            margin-top: auto;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
            width: 100%;
        }
        .dashboard-sidebar .sidebar-user-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: .65rem;
            width: 100%;
            padding: 1rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, .08);
        }
        .dashboard-sidebar         .sidebar-user-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dashboard-sidebar .footer-info {
            display: none;
            opacity: 0;
            width: 100%;
            overflow: hidden;
            transition: opacity .25s ease;
        }
        .dashboard-sidebar.open .footer-info {
            display: block;
            opacity: 1;
        }
        .dashboard-sidebar:not(.open) .sidebar-footer .footer-info,
        .dashboard-sidebar:not(.open) .sidebar-footer form {
            display: none;
        }
        .dashboard-sidebar:not(.open) .sidebar-user-card {
            padding: .75rem;
        }
        .dashboard-shell {
            position: relative;
            display: block;
            padding: 2rem 0 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .dashboard-main {
            width: calc(100vw - 96px);
            min-height: calc(100vh - 70px);
            margin-left: 96px;
            padding: 2rem 1.5rem 2rem 1.5rem;
            transition: margin-left .25s ease, width .25s ease;
            min-width: 0;
            box-sizing: border-box;
        }
        .dashboard-sidebar.open ~ .dashboard-main {
            width: calc(100vw - 280px);
            margin-left: 280px;
        }
        .dashboard-main .page-card {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }
        .dashboard-main .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .dashboard-main .topbar > div {
            min-width: 0;
        }
        .dashboard-main .topbar .profile-chip {
            flex: 0 0 auto;
            max-width: 100%;
            width: auto;
        }
        .dashboard-main .dashboard-chart-card {
            width: 100%;
            overflow: hidden;
            min-height: 280px;
        }
        .dashboard-main .dashboard-chart-card canvas {
            width: 100% !important;
            height: auto !important;
        }
        @media (max-width: 1200px) {
            .dashboard-main {
                padding: 1.75rem 1rem 1.75rem 1rem;
            }
        }
        @media (max-width: 992px) {
            .dashboard-shell {
                flex-wrap: wrap;
                padding-top: 0;
            }
            .dashboard-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1050;
                width: 260px;
                min-height: 100vh;
                height: 100vh;
                transform: translateX(-100%);
                opacity: 0;
                border-radius: 0 24px 24px 0;
            }
            .dashboard-sidebar.open {
                transform: translateX(0);
                opacity: 1;
            }
            .dashboard-main {
                width: 100%;
                margin-left: 0;
                padding-top: 4rem;
            }
            .sidebar-toggle {
                display: inline-flex;
            }
        }
        @media (max-width: 576px) {
            .dashboard-sidebar {
                padding: 1.25rem;
            }
            .dashboard-sidebar .nav-link,
            .dashboard-sidebar .dropdown-toggle {
                padding: .9rem 1rem;
            }
        }
        .dashboard-main .page-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 1.75rem;
            box-shadow: 0 25px 55px rgba(15, 23, 42, .08);
            border: 1px solid #eef2ff;
        }
        .dashboard-main .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
            gap: 1rem;
        }
        .dashboard-main .topbar-search input {
            width: 100%;
            max-width: 420px;
            padding: .95rem 1.25rem  .95rem 3rem;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .dashboard-main .topbar .profile-chip {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            padding: .5rem 1rem .5rem .5rem;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
        }
        .profile-chip-text {
            line-height: 1.25;
            min-width: 0;
        }
        .profile-chip-name {
            color: #0f172a;
            font-size: .9rem;
        }
        .profile-chip-email {
            font-size: .78rem;
        }
        .user-avatar-img,
        .user-avatar-fallback {
            border-radius: 50%;
            flex-shrink: 0;
        }
        .user-avatar-img {
            object-fit: cover;
            display: block;
        }
        .user-avatar-fallback {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #64748b;
            color: #ffffff;
            font-weight: 600;
        }
        .sidebar-user-avatar .user-avatar-img,
        .sidebar-user-avatar .user-avatar-fallback {
            width: 42px !important;
            height: 42px !important;
            font-size: 1rem !important;
        }
        .toolbar-add-btn {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: #2563eb;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            flex-shrink: 0;
            transition: background .2s ease, transform .15s ease;
        }
        .toolbar-add-btn:hover {
            background: #1d4ed8;
            color: #fff;
            transform: scale(1.04);
        }
        .profile-avatar-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .profile-avatar-wrap .user-avatar-img,
        .profile-avatar-wrap .user-avatar-fallback {
            margin: 0 auto;
        }
        .profile-form {
            max-width: 480px;
            margin: 0 auto;
        }
        .profile-account-picture {
            max-width: 520px;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eef2ff;
        }
        .profile-page-card .form-control,
        .profile-page-card .form-select {
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }
        .profile-page-card .form-control:hover,
        .profile-page-card .form-select:hover {
            border-color: #94a3b8;
            background-color: #f8fafc;
        }
        .profile-page-card .form-control:focus,
        .profile-page-card .form-select:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, .08);
            background-color: #fff;
        }
        .profile-page-card .btn {
            transition: background-color .2s ease, color .2s ease, border-color .2s ease, transform .15s ease, box-shadow .2s ease;
        }
        .profile-page-card .btn:hover {
            transform: translateY(-1px);
        }
        .profile-page-card .btn:active {
            transform: translateY(0);
        }
        .profile-btn-primary {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.35rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .profile-btn-primary:hover {
            background: #1d4ed8;
            color: #fff;
            box-shadow: 0 8px 20px rgba(37, 99, 235, .28);
        }
        .profile-section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }
        .profile-field-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0.45rem;
        }
        .profile-field-input {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            color: #0f172a;
            background: #fff;
        }
        .profile-field-input:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, .08);
        }
        .profile-age-display {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
        }
        .profile-btn-dark {
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.35rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .profile-btn-dark:hover {
            background: #1e293b;
            color: #fff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .22);
        }
        .profile-field-input:hover {
            border-color: #94a3b8;
            background-color: #f8fafc;
        }
        .profile-password-wrap {
            position: relative;
        }
        .profile-password-input {
            padding-right: 2.75rem;
        }
        .profile-password-toggle {
            position: absolute;
            right: 0.65rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            padding: 0.25rem;
            line-height: 1;
            cursor: pointer;
        }
        .profile-password-toggle:hover {
            color: #475569;
            background: rgba(148, 163, 184, .12);
            border-radius: 6px;
        }
        .profile-password-toggle.is-visible .profile-eye-icon {
            opacity: 0.55;
        }
        .profile-picture-section,
        .profile-account-section,
        .profile-password-section {
            padding-top: 0.25rem;
        }
        .profile-picture-form .profile-account-picture {
            margin-bottom: 1.25rem;
        }
        .dashboard-main .table-card {
            background: #ffffff;
            border-radius: 26px;
            border: 1px solid #eef2ff;
            box-shadow: 0 18px 40px rgba(15, 23, 42, .04);
        }
        .dashboard-main .table-card .table thead th {
            border-bottom: none;
            color: #475569;
            font-weight: 600;
        }
        .dashboard-main .table-card .table tbody tr {
            border-bottom: 1px solid #eef2ff;
        }
        .dashboard-main .table-card > .table-responsive {
            overflow: visible;
        }
        @media (max-width: 767.98px) {
            .dashboard-main .table-card > .table-responsive {
                overflow-x: auto;
            }
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .35rem .8rem;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 700;
        }
        .status-active { background: #ecfdf5; color: #166534; }
        .status-inactive { background: #fef2f2; color: #b91c1c; }
        .role-pill {
            display: inline-flex;
            align-items: center;
            padding: .3rem .7rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .role-pill-super_admin {
            background: #fef3c7;
            color: #92400e;
        }
        .role-pill-admin {
            background: #ede9fe;
            color: #5b21b6;
        }
        .role-pill-staff {
            background: #e0f2fe;
            color: #075985;
        }
        .customers-table .customer-address,
        .customers-table .customer-contract {
            max-width: 200px;
            color: #475569;
        }
        .customers-table .customer-address {
            line-height: 1.4;
        }
        .dashboard-shell .btn-accent {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: #ffffff;
            border: none;
        }
        .dashboard-shell .btn-accent:hover {
            background: linear-gradient(135deg, #6d28d9, #9333ea);
        }
        .dashboard-shell .btn-filter {
            border-radius: 18px;
        }
        .toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 1080; }
        .row-actions-dropdown .btn-kebab {
            width: 36px;
            height: 36px;
            padding: 0;
            border: none;
            border-radius: 10px;
            background: #0f172a;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            transition: background .2s ease, transform .15s ease;
        }
        .row-actions-dropdown .btn-kebab:hover,
        .row-actions-dropdown .btn-kebab:focus,
        .row-actions-dropdown .btn-kebab.show {
            background: #1e293b;
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .18);
        }
        .row-actions-dropdown .btn-kebab:focus-visible {
            outline: 2px solid #a855f7;
            outline-offset: 2px;
        }
        .row-actions-dropdown {
            position: relative;
        }
        .row-actions-dropdown .dropdown-menu {
            min-width: 9rem;
            padding: .35rem;
            border-radius: 14px;
            z-index: 1090;
        }
        .row-actions-dropdown .dropdown-item {
            border-radius: 10px;
            padding: .5rem .85rem;
            font-size: .9rem;
        }
        .row-actions-dropdown .dropdown-item:active {
            background: #eef2ff;
        }
        .row-actions-dropdown form {
            margin: 0;
        }
        body.customers-page .dashboard-main {
            background: #f1f5f9;
            padding-top: 1.5rem;
        }
        .customers-board {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
            padding: 1.5rem 1.75rem 1rem;
        }
        .customers-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }
        .customers-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            letter-spacing: -.02em;
        }
        .customers-count {
            font-weight: 500;
            color: #94a3b8;
            font-size: 1.1rem;
        }
        .customers-toolbar-actions {
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-wrap: wrap;
            margin-left: auto;
        }
        .customers-search {
            position: relative;
            display: flex;
            align-items: center;
        }
        .customers-search svg {
            position: absolute;
            left: .9rem;
            color: #94a3b8;
            pointer-events: none;
        }
        .customers-search-input {
            width: 220px;
            max-width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: .55rem 1rem .55rem 2.35rem;
            font-size: .9rem;
            background: #fff;
            color: #334155;
        }
        .customers-search-input:focus {
            outline: none;
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
        }
        .customers-filter {
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: .55rem 2rem .55rem 1rem;
            font-size: .9rem;
            color: #475569;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right .85rem center;
            appearance: none;
            min-width: 150px;
        }
        .customers-table-wrap {
            margin: 0 -0.25rem;
        }
        .customers-table thead th {
            border-bottom: 1px solid #e2e8f0;
            padding: .85rem .75rem;
            font-weight: 600;
            vertical-align: middle;
        }
        .customers-table .th-label {
            font-size: .68rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 600;
            white-space: nowrap;
        }
        .customers-table .sort-icon {
            font-size: .55rem;
            opacity: .7;
        }
        .customers-table tbody td {
            padding: 1rem .75rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: .92rem;
        }
        .customers-table tbody tr:last-child td {
            border-bottom: none;
        }
        .customer-name-cell {
            display: flex;
            align-items: center;
            gap: .85rem;
        }
        .customer-avatar {
            width: var(--avatar-size, 40px);
            height: var(--avatar-size, 40px);
            border-radius: 50%;
            color: #fff;
            font-size: calc(var(--avatar-size, 40px) * 0.32);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            letter-spacing: .02em;
        }
        .customer-name {
            font-weight: 500;
            color: #0f172a;
        }
        .customer-email {
            color: #475569;
        }
        .customer-phone {
            color: #475569;
        }
        .customer-contact-cell {
            display: flex;
            align-items: center;
            gap: .65rem;
        }
        .customer-contact-date {
            color: #475569;
        }
        .customer-contact-avatar {
            font-size: .65rem !important;
        }
        .table-pagination {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem 1.5rem;
            padding: 1.25rem 0.25rem 0.5rem;
            margin-top: 0.5rem;
            border-top: 1px solid #e2e8f0;
        }
        .table-pagination-summary {
            font-size: 0.875rem;
            color: #64748b;
            flex: 1 1 100%;
        }
        .table-pagination-controls {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 0.25rem;
            margin-left: auto;
        }
        .table-pagination-controls .page-link {
            border-radius: 8px;
            padding: 0.45rem 0.9rem;
            font-size: 0.875rem;
            color: #334155;
            border-color: #e2e8f0;
        }
        .table-pagination-controls .page-item.active .page-link {
            background: #f1f5f9;
            border-color: #e2e8f0;
            color: #64748b;
            font-weight: 500;
        }
        .table-pagination-controls .page-item.disabled .page-link {
            color: #94a3b8;
            background: #f8fafc;
        }
        .table-pagination-controls .page-item:not(.disabled):not(.active) .page-link:hover {
            background: #f1f5f9;
            color: #1d4ed8;
        }
        @media (min-width: 576px) {
            .table-pagination-summary {
                flex: 1 1 auto;
            }
        }
        @media (max-width: 992px) {
            .customers-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }
            .customers-toolbar-actions {
                margin-left: 0;
                width: 100%;
            }
            .customers-search-input {
                width: 100%;
                min-width: 180px;
            }
        }
        .classroom-modal-dialog {
            max-width: 560px;
        }
        .classroom-modal-dialog--compact {
            max-width: 480px;
        }
        .classroom-modal-dialog--compact .classroom-modal-fields {
            padding: 0.85rem 1rem;
        }
        .classroom-modal-dialog--compact .classroom-input,
        .classroom-modal-dialog--compact .form-select.classroom-input {
            padding: 0.75rem 0.95rem;
            font-size: 0.92rem;
        }
        .classroom-modal .modal-content {
            border: none;
            border-radius: 20px;
            background: #f1f3f4;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(0, 0, 0, .2);
        }
        .classroom-modal .modal-header {
            border-bottom: 1px solid #dadce0;
            background: #f1f3f4;
            padding: 1.15rem 1.5rem;
        }
        .classroom-modal .modal-title {
            font-size: 1.125rem;
            font-weight: 500;
            color: #202124;
        }
        .classroom-modal .modal-body {
            padding: 1rem 1.5rem 1.25rem;
            background: #f1f3f4;
        }
        .classroom-modal-fields {
            background: #ffffff;
            border: 1px solid #dadce0;
            border-radius: 12px;
            padding: 1rem 1.15rem;
        }
        .classroom-input {
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: .85rem 1rem;
            font-size: .95rem;
        }
        .classroom-input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26, 115, 232, .2);
        }
        .classroom-input::placeholder {
            color: #80868b;
        }
        .classroom-modal .modal-footer {
            border-top: 1px solid #dadce0;
            background: #f1f3f4;
            padding: .85rem 1.5rem 1.15rem;
            justify-content: flex-end;
            gap: .25rem;
        }
        .classroom-modal-cancel {
            background: transparent;
            border: none;
            color: #1a73e8;
            font-weight: 500;
            padding: .5rem 1rem;
            border-radius: 999px;
        }
        .classroom-modal-cancel:hover {
            background: rgba(26, 115, 232, .08);
            color: #174ea6;
        }
        .classroom-modal-submit {
            background: #1a73e8;
            color: #ffffff;
            border: none;
            border-radius: 999px;
            padding: .5rem 1.35rem;
            font-weight: 500;
        }
        .classroom-modal-submit:hover {
            background: #1765cc;
            color: #ffffff;
        }
        .modal-backdrop.show {
            opacity: .5;
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="@yield('bodyClass')">
@auth
@if(!View::hasSection('hideNavbar'))
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">CellsApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('customers.index') }}">Customers</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('records.index') }}">Records</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Profile</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><span class="navbar-text text-white me-3">{{ auth()->user()->name }}</span></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif
@endauth

<div class="toast-container">
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
</div>

@hasSection('showSidebar')
<div class="dashboard-shell">
    <aside class="dashboard-sidebar open" id="dashboardSidebar">
        <div class="sidebar-header mb-4">
            <a href="{{ route('dashboard') }}" class="sidebar-brand-center text-decoration-none">
                <div class="brand-mark">C</div>
                <div class="brand-text">
                    <div class="brand-title">CellsLab</div>
                    <div class="brand-subtitle">Admin Panel</div>
                </div>
            </a>
            <button class="sidebar-toggle" type="button" id="sidebarToggle">
                <span>&#x2630;</span>
            </button>
        </div>

        <div class="position-relative mb-4">
            <span class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.656a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/></svg>
            </span>
            <input type="search" class="form-control search-input" placeholder="Search menu...">
        </div>

        <nav class="sidebar-menu mb-4">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-link-icon">&#x1F4CA;</span>
                <span class="nav-link-text">Dashboard</span>
            </a>

            <div class="sidebar-item {{ request()->routeIs('customers.*') ? 'open' : '' }}">
                <button type="button" class="dropdown-toggle {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <span class="nav-link-icon">&#x1F4E6;</span>
                    <span class="nav-link-text">Customer</span>
                    <span class="dropdown-arrow">&#x25BC;</span>
                </button>
                <div class="sidebar-submenu">
                    <a href="{{ route('customers.index') }}" class="subnav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}">Customer List</a>
                </div>
            </div>

            <div class="sidebar-item {{ request()->routeIs('records.*') ? 'open' : '' }}">
                <button type="button" class="dropdown-toggle {{ request()->routeIs('records.*') ? 'active' : '' }}">
                    <span class="nav-link-icon">&#x1F4C1;</span>
                    <span class="nav-link-text">Records</span>
                    <span class="dropdown-arrow">&#x25BC;</span>
                </button>
                <div class="sidebar-submenu">
                    <a href="{{ route('records.index') }}" class="subnav-link {{ request()->routeIs('records.index') ? 'active' : '' }}">Record List</a>
                </div>
            </div>

            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span class="nav-link-icon">&#x1F465;</span>
                <span class="nav-link-text">Users</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="nav-link-icon">&#x2699;&#xFE0F;</span>
                <span class="nav-link-text">Profile</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user-card">
                <div class="sidebar-user-avatar">
                    <x-user-avatar :size="42" />
                </div>
                <div class="footer-info">
                    <div class="fw-semibold text-white">{{ auth()->user()->name }}</div>
                    <div class="small text-muted">{{ auth()->user()->roleLabel() }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">Logout</button>
            </form>
        </div>
    </aside>
    <main class="dashboard-main">
        @yield('content')
    </main>

</div>
@else
<div class="container">@yield('content')</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toast.show').forEach(function(toastEl) {
        setTimeout(function() { toastEl.classList.remove('show'); }, 4500);
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sidebar-item .dropdown-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                this.parentElement.classList.toggle('open');
            });
        });

        document.querySelectorAll('.sidebar-toggle').forEach(function(button) {
            button.addEventListener('click', function() {
                document.querySelector('.dashboard-sidebar').classList.toggle('open');
            });
        });

        document.querySelectorAll('.row-actions-dropdown [data-bs-toggle="dropdown"]').forEach(function(toggle) {
            bootstrap.Dropdown.getOrCreateInstance(toggle, {
                popperConfig: function(defaultBsPopperConfig) {
                    var config = typeof defaultBsPopperConfig === 'function'
                        ? defaultBsPopperConfig()
                        : (defaultBsPopperConfig || {});
                    config.strategy = 'fixed';
                    config.placement = 'bottom-end';
                    config.modifiers = (config.modifiers || []).concat([
                        { name: 'offset', options: { offset: [0, 8] } },
                        { name: 'preventOverflow', options: { boundary: 'viewport', padding: 8 } }
                    ]);
                    return config;
                }
            });
        });

    });
</script>
@stack('scripts')
</body>
</html>


