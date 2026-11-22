<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $portalStep === 'izin' ? 'Izin Wali Kelas' : 'Jadwal Konseling' }} — SIRASI-BK SMP Negeri 2 Dramaga</title>


    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* =========================================================
           1. ROOT VARIABLES & GLOBAL RESET
           ========================================================= */
        :root {
            --primary: #1a56db;
            --primary-dark: #0f368d;
            --primary-light: #e0e7ff;
            --primary-soft: #f0f5ff;
            --accent: #0284c7;
            --bg-body: #f8fafc;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --green: #059669;
            --green-bg: #d1fae5;
            --orange: #d97706;
            --orange-bg: #fef3c7;
            --red: #dc2626;
            --red-bg: #fee2e2;
            --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 10px 25px -5px rgba(15, 23, 42, 0.07), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {

            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =========================================================
           2. TOP HORIZONTAL NAVBAR (IDENTIK DENGAN BERANDA)
           ========================================================= */
        .portal-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 10px rgba(15, 23, 42, 0.04);
        }

        .navbar-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-logo-wrap {
            width: 62px;
            height: 62px;
            border-radius: 12px;
            background: var(--primary-soft);
            border: 1px solid var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            flex-shrink: 0;
            overflow: hidden;
        }

        .brand-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transform: scale(1.25);
        }

        .brand-text-name {
            font-size: 17px;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.3px;
            line-height: 1.2;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-text-badge {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            background: var(--primary-light);
            color: var(--primary);
            padding: 2px 8px;
            border-radius: 999px;
            letter-spacing: 0.5px;
        }

        .brand-text-sub {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .nav-menu-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
        }

        .nav-link {
            padding: 9px 15px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .nav-link:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-link.active {
            background: rgba(37, 99, 235, 0.15);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, 0.2);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            font-weight: 700;
        }

        .dark-mode .nav-link.active,
        .dark .nav-link.active {
            background: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
            border-color: rgba(96, 165, 250, 0.2);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login-petugas {
            width: 42px;
            height: 42px;
            padding: 4px;
            border: 0;
            border-radius: 50%;
            color: var(--primary-dark);
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease, transform 0.2s ease;
            text-decoration: none;
            flex-shrink: 0;
        }

        .btn-login-petugas:hover {
            color: var(--primary);
            background: transparent;
            border-color: transparent;
            transform: translateY(-1px);
            box-shadow: none;
        }

        .nav-toggle-btn {
            display: none;
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            cursor: pointer;
        }

        /* =========================================================
           3. PAGE HEADER BANNER
           ========================================================= */
        .page-banner {
            background: linear-gradient(135deg, #0a275e 0%, #18428f 55%, #071d49 100%);
            color: #ffffff;
            padding: 36px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .page-banner-inner {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            text-align: center;
        }

        .page-banner-inner > div {
            width: 100%;
            text-align: center;
        }

        .page-banner-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #f8fafc;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 13px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .page-banner h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.4px;
            margin-bottom: 6px;
        }

        .page-banner h1::after {
            content: "";
            display: block;
            width: 76px;
            height: 2px;
            margin: 8px auto 6px;
            border-radius: 999px;
            background: rgba(147, 197, 253, 0.85);
        }

        .page-banner p {
            font-size: 14px;
            color: rgba(241, 245, 249, 0.9);
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-back-home:hover {
            background: rgba(255, 255, 255, 0.24);
        }

        /* =========================================================
           4. MAIN CONTENT & FORM CARD
           ========================================================= */
        .main-content {
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
            padding: 36px 24px 72px;
            flex: 1;
        }

        .alert-box {
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* Confirmation & Unique Code Banner after Submission */
        .confirmation-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #eff6ff 100%);
            border: 2px solid #34d399;
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 32px;
            text-align: center;
            box-shadow: var(--shadow-md);
        }

        .confirmation-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #059669;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 12px;
        }

        .confirmation-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .confirmation-desc {
            font-size: 13.5px;
            color: var(--text-secondary);
            max-width: 560px;
            margin: 0 auto 16px;
        }

        .code-display-box {
            display: inline-block;
            background: #ffffff;
            border: 2px dashed var(--primary);
            color: var(--primary-dark);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2.5px;
            padding: 12px 32px;
            border-radius: 14px;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.1);
        }

        .confirmation-summary {
            max-width: 520px;
            margin: 0 auto 18px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            color: var(--text-secondary);
            text-align: left;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }

        .confirmation-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-copy-code {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #ffffff;
            color: var(--primary-dark);
            border: 1.5px solid var(--primary);
            padding: 10px 18px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-copy-code:hover {
            background: var(--primary-soft);
        }

        .btn-goto-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--primary);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-goto-status:hover {
            background: var(--primary-dark);
        }

        /* Guide / Petunjuk Pengisian Singkat */
        .guide-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .guide-title {
            font-size: 14.5px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .guide-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .guide-step-item {
            background: var(--primary-soft);
            border: 1px solid var(--primary-light);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .guide-step-item strong {
            display: block;
            color: var(--primary-dark);
            font-size: 13px;
            margin-bottom: 2px;
        }

        /* Workspace Form Card */
        .workspace-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            box-shadow: var(--shadow-sm);
        }

        .workspace-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 8px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
        }

        .workspace-card-header h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .workspace-subtitle {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 22px;
        }

        /* Slot Checker Box */
        .slot-checker-box {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 16px 18px;
            margin-bottom: 26px;
        }

        .slot-checker-form {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .busy-slot-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
            padding: 8px 12px;
            border-radius: 9px;
            font-size: 12.5px;
            margin-top: 8px;
        }

        /* Form Controls */
        .input-group-item {
            margin-bottom: 18px;
        }

        .input-group-item label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .input-group-item label span {
            color: var(--red);
        }

        .form-field {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 11px;

            font-size: 13.5px;
            color: var(--text-main);
            background: #ffffff;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.12);
        }

        .form-field.is-invalid {
            border-color: var(--red) !important;
        }

        .form-field.is-invalid:focus {
            border-color: var(--red) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15) !important;
        }

        .field-error-message {
            color: var(--red);
            font-size: 12px;
            margin-top: 4px;
            font-weight: 500;
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .slot-fields-row .input-group-item { margin-bottom: 8px; }

        #catatanInput {
            height: 76px;
            min-height: 76px;
            resize: vertical;
            line-height: 1.5;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .field-helper {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .wali-preview-pill {
            display: none;
            align-items: center;
            gap: 7px;
            margin-top: 7px;
            padding: 7px 11px;
            background: var(--primary-soft);
            border: 1px solid var(--primary-light);
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .btn-submit-ajukan {
            width: 100%;
            background: var(--primary);
            color: #ffffff;
            border: none;
            padding: 14px 20px;
            border-radius: 12px;

            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.22);
        }

        .btn-submit-ajukan:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* =========================================================
           5. PROFESSIONAL 4-COLUMN FOOTER
           ========================================================= */
        .portal-footer {
            background: #0b132b;
            color: #cbd5e1;
            padding: 34px 24px 20px;
            border-top: 4px solid var(--primary);
            margin-top: auto;
        }

        .footer-grid {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.25fr 1.2fr 0.95fr;
            gap: 36px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.16);
        }

        .footer-col-title {
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 800;
            letter-spacing: 0.2px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-brand-row {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 14px;
        }

        .footer-logo-box {
            width: 62px;
            height: 62px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            flex-shrink: 0;
        }

        .footer-logo-box img {
            width: 112%;
            height: 112%;
            object-fit: contain;
            max-width: none;
        }

        .footer-brand-title {
            color: #ffffff;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.2;
        }

        .footer-brand-sub {
            color: #93c5fd;
            font-size: 12.5px;
            font-weight: 700;
            margin-top: 2px;
        }

        .footer-desc {
            font-size: 13.2px;
            color: #94a3b8;
            line-height: 1.65;
            margin-bottom: 14px;
        }

        .footer-npsn-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 700;
            color: #bfdbfe;
            background: rgba(26, 86, 219, 0.25);
            border: 1px solid rgba(147, 197, 253, 0.3);
            padding: 4px 11px;
            border-radius: 8px;
        }

        .footer-nav-list,
        .footer-info-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-nav-list a {
            font-size: 13.5px;
            color: #94a3b8;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .footer-nav-list a:hover {
            color: #ffffff;
            transform: translateX(3px);
        }

        .footer-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.55;
        }

        .footer-info-item a {
            color: #bfdbfe;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .footer-info-item a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .footer-map-btn {
            margin-top: 6px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #ffffff !important;
            font-size: 12.5px;
            font-weight: 700;
            padding: 8px 13px;
            border-radius: 9px;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }

        .footer-map-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .footer-social-list {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
        }

        .footer-social-card {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            color: #ffffff;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .footer-social-card:hover {
            color: #bfdbfe;
            transform: translateY(-2px);
        }

        .footer-social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .footer-bottom {
            max-width: 1240px;
            margin: 24px auto 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12.5px;
            color: #64748b;
        }

        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                height: 68px;
                padding: 0 16px;
            }

            .nav-toggle-btn {
                display: inline-flex;
            }

            .nav-menu-links {
                display: none;
                position: absolute;
                top: 68px;
                left: 0;
                right: 0;
                background: #ffffff;
                flex-direction: column;
                padding: 16px;
                border-bottom: 1px solid var(--border-color);
                box-shadow: var(--shadow-md);
                align-items: stretch;
            }

            .nav-menu-links.show {
                display: flex;
            }

            .guide-steps,
            .form-row-2,
            .confirmation-summary,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .workspace-card {
                padding: 22px 18px;
            }

            .page-banner {
                padding: 30px 18px;
            }

            .page-banner-inner {
                flex-direction: column;
                align-items: center;
                gap: 14px;
                text-align: center;
            }

            .page-banner h1 {
                font-size: 24px;
            }

            .workspace-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .confirmation-card {
                padding: 22px 16px;
            }

            .code-display-box {
                font-size: 20px;
                letter-spacing: 2px;
                padding: 10px 16px;
                max-width: 100%;
                word-break: break-all;
            }

            .confirmation-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-copy-code,
            .btn-goto-status {
                width: 100%;
                justify-content: center;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .brand-logo-wrap {
                width: 46px;
                height: 46px;
            }

            .brand-text-name {
                font-size: 16px;
            }

            .brand-text-sub {
                font-size: 10.5px;
            }

            .main-content {
                padding: 24px 14px 48px;
            }
        }
    </style>
    @include('layouts.page_title_system')
    @include('partials.portal_theme')
</head>

<body class="sirasi-portal">

    {{-- -------------------------------------------------------------
         1. HORIZONTAL NAVBAR
         ------------------------------------------------------------- --}}
    <header class="portal-navbar">
        <div class="navbar-container">
            <a href="{{ route('portal.siswa.index') }}" class="nav-brand">
                <div class="brand-logo-wrap p-0 overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('images/logo-smpn2-dramaga.png') }}?v=2" alt="Logo SMP Negeri 2 Dramaga" style="width: 100%; height: 100%; object-fit: contain; transform: scale(3) translateY(12%); transform-origin: center;">
                </div>
                <div>
                    <div class="brand-text-name">
                        SIRASI-BK
                        <span class="brand-text-badge">Siswa</span>
                    </div>
                    <div class="brand-text-sub">SMP Negeri 2 Dramaga</div>
                </div>
            </a>

            <nav>
                <ul class="nav-menu-links" id="portalNavMenu">
                    <li>
                        <a href="{{ route('portal.siswa.index') }}" class="nav-link">
                            <i data-lucide="home" style="width: 15px; height: 15px;"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portal.siswa.create') }}" class="nav-link {{ $portalStep === 'izin' ? 'active' : '' }}">
                            <i data-lucide="user-check" style="width: 15px; height: 15px;"></i>
                            Izin Wali Kelas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portal.siswa.jadwal', $lockedSiswa ? ['id_kelas' => $lockedSiswa->id_kelas, 'id_siswa' => $lockedSiswa->id_siswa, 'kode_pengajuan' => $kodePengajuanInput] : []) }}" class="nav-link {{ $portalStep === 'jadwal' ? 'active' : '' }}">
                            <i data-lucide="calendar-plus" style="width: 15px; height: 15px;"></i>
                            Jadwal Konseling
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portal.siswa.status') }}" class="nav-link">
                            <i data-lucide="clipboard-list" style="width: 15px; height: 15px;"></i>
                            Cek Status
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portal.siswa.tentang') }}" class="nav-link">
                            <i data-lucide="info" style="width: 15px; height: 15px;"></i>
                            Tentang
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn-login-petugas" title="Halaman Masuk Khusus Petugas / Guru BK / Wali Kelas">
                    <i data-lucide="circle-user-round" aria-hidden="true" style="width: 28px; height: 28px;"></i>
                </a>

                <button type="button" class="nav-toggle-btn" id="mobileNavToggle" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width: 20px; height: 20px;"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- -------------------------------------------------------------
         2. PAGE HEADER BANNER
         ------------------------------------------------------------- --}}
    <section class="page-banner">
        <div class="page-banner-inner">
            <div>
                <div class="page-banner-badge">
                    <i data-lucide="calendar-plus" style="width: 14px; height: 14px;"></i>
                    <span>{{ $portalStep === 'izin' ? 'Tahap 1 • Persetujuan Wali Kelas' : 'Tahap 2 • Penjadwalan oleh Guru BK' }}</span>
                </div>
                <h1>{{ $portalStep === 'izin' ? 'Izin Wali Kelas' : 'Jadwal Konseling' }}</h1>
                <p>
                    @if ($portalStep === 'izin')
                        Ajukan izin kepada Wali Kelas sebelum melanjutkan ke pengajuan jadwal konseling.
                    @else
                        Izin Wali Kelas sudah disetujui. Pilih slot konseling yang tersedia untuk diajukan kepada Guru BK.
                    @endif
                </p>
            </div>
        </div>
    </section>

    {{-- -------------------------------------------------------------
         3. MAIN CONTENT
         ------------------------------------------------------------- --}}
    <main class="main-content">

        {{-- Error Alert --}}
        @if (session('error'))
            <div class="alert-box alert-danger">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (session('success') && !session('izin_berhasil') && !session('pengajuan_berhasil'))
            <div class="alert-box alert-success">
                <i data-lucide="check-circle-2" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- Konfirmasi Setelah Permohonan Izin Wali Kelas Berhasil Dikirim (Tahap 1) --}}
        @if ($portalStep === 'izin' && $izinTerkirim && $izinRingkasan)
            <div class="confirmation-card" id="konfirmasiIzin">
                <div class="confirmation-badge">
                    <i data-lucide="check-circle-2" style="width: 15px; height: 15px;"></i>
                    <span>Tahap 1: Permohonan Izin Wali Kelas Terkirim</span>
                </div>

                <h3 class="confirmation-title">Permohonan Izin Mengikuti Konseling Telah Diterima!</h3>
                <p class="confirmation-desc">
                    Permohonan izin berhasil dikirim, menunggu persetujuan Wali Kelas. Simpan <strong>Kode Izin</strong> di bawah ini. Kode unik ini dapat kamu gunakan untuk melacak status persetujuan izin secara langsung di halaman Cek Status.
                </p>

                @if (!empty($izinRingkasan['kode_pengajuan']))
                    <div class="code-display-box" id="kodeIzinDisplay">{{ $izinRingkasan['kode_pengajuan'] }}</div>
                @endif

                <div class="confirmation-summary">
                    <div>
                        <span style="font-size: 11px; color: var(--text-muted); display: block;">Nama Siswa</span>
                        <strong>{{ $izinRingkasan['nama_siswa'] ?? '-' }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 11px; color: var(--text-muted); display: block;">Kelas &amp; Wali Kelas</span>
                        <strong>Kelas {{ $izinRingkasan['kelas'] ?? '-' }} ({{ $izinRingkasan['wali_kelas'] ?? 'Wali Kelas' }})</strong>
                    </div>
                    @if (!empty($izinRingkasan['tanggal']))
                    <div>
                        <span style="font-size: 11px; color: var(--text-muted); display: block;">Tanggal yang Diminta</span>
                        <strong>{{ $izinRingkasan['tanggal'] }}</strong>
                    </div>
                    @endif
                    @if (!empty($izinRingkasan['waktu']))
                    <div>
                        <span style="font-size: 11px; color: var(--text-muted); display: block;">Jam / Periode Pelajaran Diminta</span>
                        <strong>{{ $izinRingkasan['waktu'] }}</strong>
                    </div>
                    @endif
                </div>

                <div class="confirmation-actions">
                    <button type="button" class="btn-copy-code" onclick="copyKodeIzin()">
                        <i data-lucide="copy" style="width: 15px; height: 15px;"></i>
                        <span id="copyBtnText">Salin Kode Izin</span>
                    </button>
                    <a href="{{ route('portal.siswa.status', ['kode_pengajuan' => $izinRingkasan['kode_pengajuan'] ?? '']) }}" class="btn-goto-status">
                        <i data-lucide="clipboard-list" style="width: 15px; height: 15px;"></i>
                        <span>Lacak Status Pengajuan Sekarang</span>
                    </a>
                </div>
            </div>
        @endif

        {{-- Konfirmasi Setelah Pengajuan Jadwal Konseling Berhasil (Tahap 2) --}}
        @if ($portalStep === 'jadwal' && session('pengajuan_berhasil'))
            <div class="confirmation-card" id="konfirmasiPengajuan">
                <div class="confirmation-badge">
                    <i data-lucide="check-circle-2" style="width: 15px; height: 15px;"></i>
                    <span>Tahap 2: Pengajuan Jadwal Konseling Terkirim</span>
                </div>

                <h3 class="confirmation-title">Pengajuan Jadwal Konseling Kamu Telah Diterima!</h3>
                <p class="confirmation-desc">
                    Izin dari Wali Kelas telah terverifikasi dan usulan jadwal konselingmu sedang diperiksa oleh <strong>Guru BK</strong> untuk ditetapkan menjadi jadwal resmi. Persetujuan izin Wali Kelas berbeda dengan penetapan jadwal oleh Guru BK.
                </p>

                @if (session('pengajuan_ringkasan'))
                    @php $ringkasan = session('pengajuan_ringkasan'); @endphp
                    @if (!empty($ringkasan['kode_pengajuan']))
                        <div class="code-display-box">{{ $ringkasan['kode_pengajuan'] }}</div>
                    @endif
                    <div class="confirmation-summary">
                        <div>
                            <span style="font-size: 11px; color: var(--text-muted); display: block;">Nama Siswa</span>
                            <strong>{{ $ringkasan['nama_siswa'] ?? '-' }}</strong>
                        </div>
                        <div>
                            <span style="font-size: 11px; color: var(--text-muted); display: block;">Kelas</span>
                            <strong>Kelas {{ $ringkasan['kelas'] ?? '-' }}</strong>
                        </div>
                        <div>
                            <span style="font-size: 11px; color: var(--text-muted); display: block;">Tanggal Diinginkan</span>
                            <strong>{{ $ringkasan['tanggal'] ?? '-' }}</strong>
                        </div>
                        <div>
                            <span style="font-size: 11px; color: var(--text-muted); display: block;">Waktu Diinginkan</span>
                            <strong>{{ $ringkasan['waktu'] ?? '-' }}</strong>
                        </div>
                    </div>
                @endif

                <div class="confirmation-actions">
                    <a href="{{ route('portal.siswa.status') }}" class="btn-goto-status">
                        <i data-lucide="clipboard-list" style="width: 15px; height: 15px;"></i>
                        <span>Cek Status Jadwal Guru BK</span>
                    </a>
                </div>
            </div>
        @endif

        {{-- Petunjuk halaman aktif --}}
        <div class="guide-card">
            <div class="guide-title">
                <i data-lucide="lightbulb" style="width: 18px; height: 18px; color: var(--primary);"></i>
                <span>{{ $portalStep === 'izin' ? 'Tahap 1 — Ajukan Izin kepada Wali Kelas' : 'Tahap 2 — Ajukan Jadwal kepada Guru BK' }}</span>
            </div>
            <div class="guide-steps">
                @if ($portalStep === 'izin')
                <div class="guide-step-item">
                    <strong>1. Ajukan Izin ke Wali Kelas</strong>
                    Pilih kelas dan namamu untuk meminta izin mengikuti bimbingan konseling kepada Wali Kelas, lalu simpan <strong>Kode Izin</strong>.
                </div>
                <div class="guide-step-item">
                    <strong>2. Tunggu Persetujuan Wali Kelas</strong>
                    Wali Kelas memeriksa dan menyetujui izinmu. Siswa yang izinnya masih menunggu atau ditolak belum dapat mengajukan jadwal.
                </div>
                <div class="guide-step-item">
                    <strong>3. Ajukan Jadwal ke Guru BK</strong>
                    Setelah izin disetujui Wali Kelas, masukkan Kode Izin dan pilih tanggal serta jam bimbingan untuk ditetapkan oleh Guru BK.
                </div>
                @else
                <div class="guide-step-item">
                    <strong>Izin Disetujui</strong>
                    Kode Izin: <strong>{{ $izinAktif->kode_pengajuan }}</strong>. Izin dari Wali Kelas sudah disetujui.
                </div>
                <div class="guide-step-item">
                    <strong>Pilih Slot Guru BK</strong>
                    Pilih slot yang dibuka Guru BK. Pengajuan jadwal akan menunggu pemeriksaan dan penetapan resmi.
                </div>
                @endif
            </div>
        </div>

        @php
            if ($portalStep === 'jadwal') {
                $defaultKelasId = old('id_kelas', '');
                $defaultSiswaId = old('id_siswa', '');
                $defaultLayanan = old('jenis_bimbingan', '');
                $defaultKodeIzin = old('kode_pengajuan', '');
            } elseif ($portalStep === 'izin') {
                $defaultKelasId = $errors->any() ? old('id_kelas', '') : '';
                $defaultSiswaId = $errors->any() ? old('id_siswa', '') : '';
                $defaultLayanan = $errors->any() ? old('jenis_bimbingan', 'Konseling Individu') : ($selectedLayanan ?: 'Konseling Individu');
                $defaultKodeIzin = old('kode_pengajuan', $kodePengajuanInput ?? ($izinAktif->kode_pengajuan ?? ''));
            } else {
                $defaultKelasId = old('id_kelas', $lockedSiswa->id_kelas ?? ($izinAktif->siswa->id_kelas ?? ($izinAktif->id_kelas ?? '')));
                $defaultSiswaId = old('id_siswa', $lockedSiswa->id_siswa ?? ($izinAktif->id_siswa ?? ''));
                $defaultLayanan = old('jenis_bimbingan', $izinAktif->jenis_bimbingan ?? ($selectedLayanan ?: 'Konseling Individu'));
                $defaultKodeIzin = old('kode_pengajuan', $kodePengajuanInput ?? ($izinAktif->kode_pengajuan ?? ''));
            }

            $defaultSlotIzin = $portalStep === 'izin' ? ($errors->any() ? old('id_slot', '') : old('id_slot', request('id_slot', ''))) : '';
            $preselectedSlotIzin = ($defaultSlotIzin !== '' && isset($slotTersediaMendatang))
                ? $slotTersediaMendatang->firstWhere('id_slot', (int) $defaultSlotIzin)
                : null;
            $defaultTanggalIzin = $portalStep === 'izin' ? ($errors->any() ? old('tanggal', '') : old('tanggal', request('tanggal', $preselectedSlotIzin->tanggal ?? ''))) : '';
            $defaultJamPelajaran = $portalStep === 'izin' ? ($errors->any() ? old('jam_pelajaran', '') : '') : '';
            $defaultWaktuMulaiIzin = $portalStep === 'izin' ? ($errors->any() ? old('waktu_mulai', '') : old('waktu_mulai', request('waktu_mulai', $preselectedSlotIzin ? substr($preselectedSlotIzin->waktu_mulai, 0, 5) : ''))) : '';
            $defaultWaktuSelesaiIzin = $portalStep === 'izin' ? ($errors->any() ? old('waktu_selesai', '') : old('waktu_selesai', request('waktu_selesai', $preselectedSlotIzin ? substr($preselectedSlotIzin->waktu_selesai, 0, 5) : ''))) : '';

            $isIzinApprovedAndReady = $izinAktif && $izinAktif->status === 'Disetujui_Wali' && !$izinAktif->hasSubmittedSchedule();

            // Tahap 2: Pengajuan Jadwal Konseling
            // Tanggal Slot, Waktu Mulai, dan Waktu Selesai WAJIB KOSONG saat halaman pertama kali dibuka.
            // Nilai HANYA boleh terisi jika siswa benar-benar memilih slot konseling yang tersedia.
            $oldSlotJadwalId = old('id_slot', '');
            $selectedSlotJadwal = ($oldSlotJadwalId !== '' && isset($slotTersediaMendatang))
                ? $slotTersediaMendatang->firstWhere('id_slot', (int) $oldSlotJadwalId)
                : null;
            $defaultTanggalJadwal = $selectedSlotJadwal ? $selectedSlotJadwal->tanggal : '';
            $defaultWaktuMulaiJadwal = $selectedSlotJadwal ? substr($selectedSlotJadwal->waktu_mulai, 0, 5) : '';
            $defaultWaktuSelesaiJadwal = $selectedSlotJadwal ? substr($selectedSlotJadwal->waktu_selesai, 0, 5) : '';
        @endphp

        {{-- =============================================================
             TAHAP 1: FORMULIR PERMOHONAN IZIN KEPADA WALI KELAS
             ============================================================= --}}
        @if ($portalStep === 'izin')
        <section class="workspace-card" style="margin-bottom: 28px;">
            <div class="workspace-card-header">
                <h2>
                    <i data-lucide="user-check" style="width: 22px; height: 22px; color: var(--primary);"></i>
                    Tahap 1 — Ajukan Permohonan Izin kepada Wali Kelas
                </h2>
                <span style="font-size: 12px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 5px 12px; border-radius: 999px;">
                    Langkah Wajib Pertama
                </span>
            </div>

            <p class="workspace-subtitle">
                Isi formulir izin di bawah ini untuk meminta izin kepada Wali Kelas sebelum melanjutkan ke pengajuan jadwal bimbingan konseling. Semua kolom wajib diisi lengkap sesuai pengajuan barumu.
            </p>

            @if ($izinAktif)
                <div style="margin-bottom: 20px; padding: 14px 18px; border-radius: 12px; border: 1px solid {{ $izinAktif->status === 'Disetujui_Wali' ? '#6ee7b7' : ($izinAktif->status === 'Ditolak_Wali' ? '#fca5a5' : '#fde68a') }}; background: {{ $izinAktif->status === 'Disetujui_Wali' ? '#ecfdf5' : ($izinAktif->status === 'Ditolak_Wali' ? '#fef2f2' : '#fffbeb') }};">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 4px;">
                        <strong style="font-size: 13.5px; color: var(--text-main);">
                            Status Permohonan Terakhir ({{ $lockedSiswa->nama_siswa ?? 'Siswa' }}) — Kode Izin: <span style="color: var(--primary-dark);">{{ $izinAktif->kode_pengajuan }}</span>
                        </strong>
                        <span style="font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 999px; background: #ffffff;">
                            @if ($izinAktif->status === 'Diajukan')
                                Menunggu Persetujuan Izin Wali Kelas
                            @elseif ($izinAktif->status === 'Disetujui_Wali' && !$izinAktif->hasSubmittedSchedule())
                                Izin Disetujui Wali Kelas — Silakan Lanjut ke Tahap 2
                            @elseif ($izinAktif->status === 'Disetujui_Wali' && $izinAktif->hasSubmittedSchedule())
                                Jadwal Terkirim — Menunggu Penetapan Guru BK
                            @elseif ($izinAktif->status === 'Ditolak_Wali')
                                Izin Ditolak Wali Kelas
                            @elseif ($izinAktif->status === 'Terjadwal')
                                Terjadwal Resmi oleh Guru BK
                            @else
                                {{ str_replace('_', ' ', $izinAktif->status) }}
                            @endif
                        </span>
                    </div>
                    @if (!empty($izinAktif->catatan_wali))
                        <div style="font-size: 12.5px; color: var(--text-secondary); margin-top: 4px;">
                            <strong>Keterangan Wali Kelas:</strong> {{ $izinAktif->catatan_wali }}
                        </div>
                    @endif
                </div>
            @endif

            <form id="formAjukanIzin" action="{{ route('portal.siswa.izin', [], false) }}" method="POST" autocomplete="off" novalidate>
                @csrf
                <div class="form-row-2">
                    <div class="input-group-item">
                        <label for="izinKelasSelect">Kelas <span>*</span></label>
                        <select
                            id="izinKelasSelect"
                            name="id_kelas"
                            class="form-field {{ $errors->has('id_kelas') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('id_kelas') ? 'border-color: var(--red);' : '' }}"
                            required
                            onchange="updateIzinSiswaOptions(false)"
                        >
                            <option value="">-- Pilih Kelas Kamu --</option>
                            @foreach ($kelasList as $kls)
                                <option
                                    value="{{ $kls->id_kelas }}"
                                    data-wali="{{ $kls->waliKelas->nama ?? 'Wali Kelas' }}"
                                    {{ (string) $defaultKelasId === (string) $kls->id_kelas ? 'selected' : '' }}
                                >
                                    Kelas {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <div class="field-error-message" id="error-izinKelasSelect" style="display: {{ $errors->has('id_kelas') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('id_kelas') }}</div>
                        <div id="izinWaliKelasPreview" class="wali-preview-pill">
                            <i data-lucide="user-check" style="width: 14px; height: 14px; flex-shrink: 0;"></i>
                            <span id="izinWaliKelasPreviewText">Wali Kelas: -</span>
                        </div>
                    </div>

                    <div class="input-group-item">
                        <label for="izinSiswaSelect">Nama Siswa <span>*</span></label>
                        <select
                            id="izinSiswaSelect"
                            name="id_siswa"
                            class="form-field {{ $errors->has('id_siswa') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('id_siswa') ? 'border-color: var(--red);' : '' }}"
                            required
                        >
                            <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        </select>
                        <div class="field-error-message" id="error-izinSiswaSelect" style="display: {{ $errors->has('id_siswa') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('id_siswa') }}</div>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="input-group-item">
                        <label for="izinJenisBimbinganSelect">Bidang Layanan Bimbingan <span>*</span></label>
                        <select id="izinJenisBimbinganSelect" name="jenis_bimbingan" class="form-field {{ $errors->has('jenis_bimbingan') ? 'is-invalid' : '' }}" style="{{ $errors->has('jenis_bimbingan') ? 'border-color: var(--red);' : '' }}" required>
                            <option value="">-- Pilih Bidang Layanan Bimbingan --</option>
                            <option value="Bimbingan Pribadi" {{ $defaultLayanan == 'Bimbingan Pribadi' ? 'selected' : '' }}>Bimbingan Pribadi</option>
                            <option value="Bimbingan Sosial" {{ $defaultLayanan == 'Bimbingan Sosial' ? 'selected' : '' }}>Bimbingan Sosial</option>
                            <option value="Bimbingan Belajar" {{ $defaultLayanan == 'Bimbingan Belajar' ? 'selected' : '' }}>Bimbingan Belajar</option>
                            <option value="Bimbingan Karier" {{ $defaultLayanan == 'Bimbingan Karier' ? 'selected' : '' }}>Bimbingan Karier</option>
                            <option value="Konseling Individu" {{ $defaultLayanan == 'Konseling Individu' ? 'selected' : '' }}>Konseling Individu</option>
                        </select>
                        <div class="field-error-message" id="error-izinJenisBimbinganSelect" style="display: {{ $errors->has('jenis_bimbingan') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('jenis_bimbingan') }}</div>
                    </div>

                    <div class="input-group-item">
                        <label for="izinTanggalInput">Tanggal yang Diinginkan <span>*</span></label>
                        <input
                            type="date"
                            id="izinTanggalInput"
                            name="tanggal"
                            class="form-field {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('tanggal') ? 'border-color: var(--red);' : '' }}"
                            min="{{ date('Y-m-d') }}"
                            value="{{ $defaultTanggalIzin }}"
                            required
                        >
                        <div class="field-error-message" id="error-izinTanggalInput" style="display: {{ $errors->has('tanggal') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('tanggal') }}</div>
                    </div>
                </div>

                {{-- Pilihan Slot Konseling yang Dibuka Guru BK --}}
                <div class="input-group-item">
                    <label for="izinSlotSelect">Pilih Slot Konseling Guru BK yang Tersedia (08:00 &ndash; 15:00 WIB) <span>*</span></label>
                    <select id="izinSlotSelect" name="id_slot" class="form-field {{ $errors->has('id_slot') ? 'is-invalid' : '' }}" style="{{ $errors->has('id_slot') ? 'border-color: var(--red);' : '' }}" required onchange="onIzinSlotChange(this)">
                        <option value="">-- Pilih Slot Konseling Guru BK yang Tersedia --</option>
                        @foreach (($slotTersediaMendatang ?? collect()) as $slotItem)
                            @php
                                $effSlotStatus = $slotItem->effective_status;
                                $isSlotClickable = $effSlotStatus === 'Tersedia';
                                $slotTglLabel = \Carbon\Carbon::parse($slotItem->tanggal)->isoFormat('dddd, D MMMM Y');
                                $slotMulaiLabel = substr($slotItem->waktu_mulai, 0, 5);
                                $slotSelesaiLabel = substr($slotItem->waktu_selesai, 0, 5);
                            @endphp
                            <option
                                value="{{ $slotItem->id_slot }}"
                                data-tanggal="{{ $slotItem->tanggal }}"
                                data-mulai="{{ $slotMulaiLabel }}"
                                data-selesai="{{ $slotSelesaiLabel }}"
                                {{ (string) $defaultSlotIzin === (string) $slotItem->id_slot ? 'selected' : '' }}
                                {{ !$isSlotClickable ? 'disabled' : '' }}
                            >
                                {{ $slotTglLabel }} • Pukul {{ $slotMulaiLabel }} - {{ $slotSelesaiLabel }} WIB ({{ $slotItem->status_label }})
                            </option>
                        @endforeach
                    </select>
                    <div class="field-error-message" id="error-izinSlotSelect" style="display: {{ $errors->has('id_slot') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('id_slot') }}</div>
                </div>

                {{-- Jam/Periode Pelajaran yang Ingin Ditinggalkan --}}
                <div class="input-group-item">
                    <label for="izinJamPelajaranSelect">Jam / Periode Pelajaran yang Ingin Ditinggalkan <span>*</span></label>
                    <select id="izinJamPelajaranSelect" name="jam_pelajaran" class="form-field {{ $errors->has('jam_pelajaran') ? 'is-invalid' : '' }}" style="{{ $errors->has('jam_pelajaran') ? 'border-color: var(--red);' : '' }}" required onchange="onIzinPeriodeChange(this)">
                        <option value="">-- Pilih Periode Jam Pelajaran --</option>
                        <option value="Jam Ke-1 (07:30 - 08:15 WIB)" data-mulai="07:30" data-selesai="08:15" {{ $defaultJamPelajaran == 'Jam Ke-1 (07:30 - 08:15 WIB)' ? 'selected' : '' }}>Jam Ke-1 (07:30 - 08:15 WIB)</option>
                        <option value="Jam Ke-2 (08:15 - 08:55 WIB)" data-mulai="08:15" data-selesai="08:55" {{ $defaultJamPelajaran == 'Jam Ke-2 (08:15 - 08:55 WIB)' ? 'selected' : '' }}>Jam Ke-2 (08:15 - 08:55 WIB)</option>
                        <option value="Jam Ke-3 (08:55 - 09:35 WIB)" data-mulai="08:55" data-selesai="09:35" {{ $defaultJamPelajaran == 'Jam Ke-3 (08:55 - 09:35 WIB)' ? 'selected' : '' }}>Jam Ke-3 (08:55 - 09:35 WIB)</option>
                        <option value="Jam Ke-4 (09:50 - 10:30 WIB)" data-mulai="09:50" data-selesai="10:30" {{ $defaultJamPelajaran == 'Jam Ke-4 (09:50 - 10:30 WIB)' ? 'selected' : '' }}>Jam Ke-4 (09:50 - 10:30 WIB)</option>
                        <option value="Jam Ke-5 (10:30 - 11:10 WIB)" data-mulai="10:30" data-selesai="11:10" {{ $defaultJamPelajaran == 'Jam Ke-5 (10:30 - 11:10 WIB)' ? 'selected' : '' }}>Jam Ke-5 (10:30 - 11:10 WIB)</option>
                        <option value="Jam Ke-6 (11:10 - 11:50 WIB)" data-mulai="11:10" data-selesai="11:50" {{ $defaultJamPelajaran == 'Jam Ke-6 (11:10 - 11:50 WIB)' ? 'selected' : '' }}>Jam Ke-6 (11:10 - 11:50 WIB)</option>
                        <option value="Jam Ke-7 (12:30 - 13:10 WIB)" data-mulai="12:30" data-selesai="13:10" {{ $defaultJamPelajaran == 'Jam Ke-7 (12:30 - 13:10 WIB)' ? 'selected' : '' }}>Jam Ke-7 (12:30 - 13:10 WIB)</option>
                        <option value="Jam Ke-8 (13:10 - 13:50 WIB)" data-mulai="13:10" data-selesai="13:50" {{ $defaultJamPelajaran == 'Jam Ke-8 (13:10 - 13:50 WIB)' ? 'selected' : '' }}>Jam Ke-8 (13:10 - 13:50 WIB)</option>
                        <option value="Jam Ke-9 (13:50 - 14:30 WIB)" data-mulai="13:50" data-selesai="14:30" {{ $defaultJamPelajaran == 'Jam Ke-9 (13:50 - 14:30 WIB)' ? 'selected' : '' }}>Jam Ke-9 (13:50 - 14:30 WIB)</option>
                        <option value="Jam Ke-10 (14:30 - 15:10 WIB)" data-mulai="14:30" data-selesai="15:10" {{ $defaultJamPelajaran == 'Jam Ke-10 (14:30 - 15:10 WIB)' ? 'selected' : '' }}>Jam Ke-10 (14:30 - 15:10 WIB)</option>
                        <option value="Kustom" data-mulai="" data-selesai="" {{ $defaultJamPelajaran == 'Kustom' ? 'selected' : '' }}>Waktu Kustom Lainnya...</option>
                    </select>
                    <div class="field-error-message" id="error-izinJamPelajaranSelect" style="display: {{ $errors->has('jam_pelajaran') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('jam_pelajaran') }}</div>
                </div>

                <div class="form-row-2">
                    <div class="input-group-item">
                        <label for="izinWaktuMulai">Waktu Mulai Jam Pelajaran <span>*</span></label>
                        <input
                            type="time"
                            id="izinWaktuMulai"
                            name="waktu_mulai"
                            class="form-field {{ $errors->has('waktu_mulai') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('waktu_mulai') ? 'border-color: var(--red);' : '' }}"
                            value="{{ $defaultWaktuMulaiIzin }}"
                            required
                        >
                        <div class="field-error-message" id="error-izinWaktuMulai" style="display: {{ $errors->has('waktu_mulai') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('waktu_mulai') }}</div>
                    </div>

                    <div class="input-group-item">
                        <label for="izinWaktuSelesai">Waktu Selesai Jam Pelajaran <span>*</span></label>
                        <input
                            type="time"
                            id="izinWaktuSelesai"
                            name="waktu_selesai"
                            class="form-field {{ $errors->has('waktu_selesai') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('waktu_selesai') ? 'border-color: var(--red);' : '' }}"
                            value="{{ $defaultWaktuSelesaiIzin }}"
                            required
                        >
                        <div class="field-error-message" id="error-izinWaktuSelesai" style="display: {{ $errors->has('waktu_selesai') ? 'block' : 'none' }}; color: var(--red); font-size: 12px; margin-top: 4px;">{{ $errors->first('waktu_selesai') }}</div>
                    </div>
                </div>

                <button type="submit" class="btn-submit-ajukan">
                    <i data-lucide="file-check-2" style="width: 17px; height: 17px;"></i>
                    <span>Ajukan Izin kepada Wali Kelas</span>
                </button>
            </form>
        </section>
        @endif

        {{-- =============================================================
             TAHAP 2: FORMULIR PENGAJUAN JADWAL KONSELING KEPADA GURU BK
             (Hanya Dapat Diajukan Setelah Izin Wali Kelas Disetujui)
             ============================================================= --}}
        @if ($portalStep === 'jadwal')
        <section class="workspace-card" id="tahapJadwalKonseling">
            <div class="workspace-card-header">
                <h2>
                    <i data-lucide="calendar-plus" style="width: 22px; height: 22px; color: var(--primary);"></i>
                    Tahap 2 — Jadwal Konseling kepada Guru BK
                </h2>
                @if ($isIzinApprovedAndReady)
                    <span style="font-size: 12px; font-weight: 700; color: var(--green); background: var(--green-bg); padding: 5px 12px; border-radius: 999px;">
                        Izin Wali Kelas Disetujui • Siap Pilih Jadwal
                    </span>
                @elseif ($izinAktif && $izinAktif->status === 'Disetujui_Wali' && $izinAktif->hasSubmittedSchedule())
                    <span style="font-size: 12px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 5px 12px; border-radius: 999px;">
                        Jadwal Sudah Diajukan • Menunggu Guru BK
                    </span>
                @else
                    <span style="font-size: 12px; font-weight: 700; color: var(--orange); background: var(--orange-bg); padding: 5px 12px; border-radius: 999px;">
                        Wajib Disetujui Wali Kelas Terlebih Dahulu
                    </span>
                @endif
            </div>

            <p class="workspace-subtitle">
                Formulir jadwal konseling ini hanya dapat dikirim setelah permohonan izinmu berstatus <strong>Disetujui Wali Kelas</strong>. Masukkan <strong>Kode Izin</strong> yang kamu peroleh pada Tahap 1.
            </p>

            @error('izin_wali')
                <div class="alert-box alert-danger" style="margin-bottom: 20px;">
                    <i data-lucide="shield-alert" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                    <div>{{ $message }}</div>
                </div>
            @enderror

            @if ($isIzinApprovedAndReady)

            {{-- Form Pengajuan Jadwal Konseling --}}
            <form id="formAjukanBimbingan" action="{{ route('portal.siswa.ajukan', [], false) }}" method="POST" autocomplete="off">
                @csrf

                <div class="input-group-item">
                    <label for="kodePengajuanInput">Kode Izin Wali Kelas (Kode Pengajuan) <span>*</span></label>
                    <input
                        type="text"
                        id="kodePengajuanInput"
                        name="kode_pengajuan"
                        class="form-field"
                        placeholder="Contoh: BK-8F3K9A (diperoleh saat mengajukan izin ke Wali Kelas)"
                        value="{{ $defaultKodeIzin }}"
                        style="text-transform: uppercase; font-weight: 700; letter-spacing: 0.8px;"
                        required
                    >
                    <div class="field-helper">
                        <i data-lucide="shield-check" style="width: 12px; height: 12px; color: var(--primary);"></i>
                        <span>Kode Izin wajib sesuai dengan nama siswa dan sudah berstatus Disetujui Wali Kelas.</span>
                    </div>
                    @error('kode_pengajuan')
                        <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row-2">
                    {{-- Pilihan Kelas --}}
                    <div class="input-group-item">
                        <label for="kelasSelect">Kelas <span>*</span></label>
                        <select
                            id="kelasSelect"
                            name="id_kelas"
                            class="form-field"
                            required
                            onchange="updateSiswaSuggestions()"
                        >
                            <option value="">-- Pilih Kelas Kamu --</option>
                            @foreach ($kelasList as $kls)
                                <option
                                    value="{{ $kls->id_kelas }}"
                                    data-wali="{{ $kls->waliKelas->nama ?? 'Wali Kelas' }}"
                                    {{ (string) $defaultKelasId === (string) $kls->id_kelas ? 'selected' : '' }}
                                >
                                    Kelas {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kelas')
                            <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                        @enderror

                        <div id="waliKelasPreview" class="wali-preview-pill">
                            <i data-lucide="user-check" style="width: 14px; height: 14px; flex-shrink: 0;"></i>
                            <span id="waliKelasPreviewText">Wali Kelas: -</span>
                        </div>
                    </div>

                    {{-- Pilihan Nama Siswa dari Database --}}
                    <div class="input-group-item">
                        <label for="siswaSelect">Nama Siswa <span>*</span></label>
                        <select
                            id="siswaSelect"
                            name="id_siswa"
                            class="form-field"
                            required
                        >
                            <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        </select>
                        <div class="field-helper">
                            <i data-lucide="info" style="width: 12px; height: 12px;"></i>
                            <span>Pilih kelas terlebih dahulu untuk menampilkan daftar nama siswa di kelasmu.</span>
                        </div>
                        @error('id_siswa')
                            <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Keperluan Konseling --}}
                <div class="form-row-2 slot-fields-row">
                <div class="input-group-item">
                    <label for="jenisBimbinganSelect">Keperluan Konseling <span>*</span></label>
                    <select id="jenisBimbinganSelect" name="jenis_bimbingan" class="form-field" required>
                        <option value="">-- Pilih Keperluan Konseling --</option>
                        <option value="Konseling Pribadi" {{ $defaultLayanan == 'Konseling Pribadi' ? 'selected' : '' }}>Bimbingan Pribadi (Emosi, kepercayaan diri, kebiasaan diri)</option>
                        <option value="Konseling Sosial" {{ $defaultLayanan == 'Konseling Sosial' ? 'selected' : '' }}>Bimbingan Sosial (Pertemanan, adaptasi lingkungan, komunikasi)</option>
                        <option value="Konseling Belajar" {{ $defaultLayanan == 'Konseling Belajar' ? 'selected' : '' }}>Bimbingan Belajar (Kesulitan belajar, manajemen waktu, motivasi)</option>
                        <option value="Bimbingan Karier" {{ $defaultLayanan == 'Bimbingan Karier' ? 'selected' : '' }}>Bimbingan Karier (Minat bakat, rencana sekolah lanjutan SMA/SMK/MA)</option>
                        <option value="Konseling Individu" {{ $defaultLayanan == 'Konseling Individu' ? 'selected' : '' }}>Konseling Individu Umum</option>
                    </select>
                    @error('jenis_bimbingan')
                        <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilihan Slot Ketersediaan Konseling yang Dibuka Guru BK --}}
                <div class="input-group-item">
                    <label for="slotSelectInput">Pilih Slot Ketersediaan Konseling Guru BK (08.00 – 15.00 WIB) <span>*</span></label>
                    <select id="slotSelectInput" name="id_slot" class="form-field" required onchange="onSlotDropdownChange(this)">
                        <option value="">-- Pilih Slot Konseling yang Telah Dibuka Guru BK --</option>
                        @if (isset($slotTersediaMendatang))
                            @foreach ($slotTersediaMendatang as $slotItem)
                                @php $slotEff = $slotItem->effective_status; @endphp
                                <option
                                    value="{{ $slotItem->id_slot }}"
                                    data-tanggal="{{ $slotItem->tanggal }}"
                                    data-mulai="{{ substr($slotItem->waktu_mulai, 0, 5) }}"
                                    data-selesai="{{ substr($slotItem->waktu_selesai, 0, 5) }}"
                                    {{ $slotEff !== 'Tersedia' ? 'disabled' : '' }}
                                    {{ (string) old('id_slot') === (string) $slotItem->id_slot ? 'selected' : '' }}
                                >
                                    {{ \Carbon\Carbon::parse($slotItem->tanggal)->isoFormat('dddd, D MMMM Y') }} — Pukul {{ substr($slotItem->waktu_mulai, 0, 5) }} - {{ substr($slotItem->waktu_selesai, 0, 5) }} WIB ({{ $slotItem->formatted_duration }}) — [{{ str_replace('_', ' ', $slotEff) }}]
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('id_slot')
                        <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>
                </div>

                {{-- Tanggal yang Diinginkan --}}
                <div class="input-group-item">
                    <label for="tanggalInput">Tanggal Slot Konseling <span>*</span></label>
                    <input
                        type="date"
                        id="tanggalInput"
                        name="tanggal"
                        class="form-field"
                        min="{{ date('Y-m-d') }}"
                        value="{{ $defaultTanggalJadwal }}"
                        readonly
                        required
                    >
                    @error('tanggal')
                        <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Waktu yang Diinginkan (Waktu Mulai & Selesai sesuai Slot) --}}
                <div class="form-row-2">
                    <div class="input-group-item">
                        <label for="waktuMulaiInput">Waktu Mulai Slot (08:00 - 15:00) <span>*</span></label>
                        <input
                            type="time"
                            id="waktuMulaiInput"
                            name="waktu_mulai"
                            min="08:00"
                            max="15:00"
                            class="form-field"
                            value="{{ $defaultWaktuMulaiJadwal }}"
                            readonly
                            required
                        >
                        @error('waktu_mulai')
                            <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group-item">
                        <label for="waktuSelesaiInput">Waktu Selesai Slot (08:00 - 15:00) <span>*</span></label>
                        <input
                            type="time"
                            id="waktuSelesaiInput"
                            name="waktu_selesai"
                            min="08:00"
                            max="15:00"
                            class="form-field"
                            value="{{ $defaultWaktuSelesaiJadwal }}"
                            readonly
                            required
                        >
                        @error('waktu_selesai')
                            <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Keterangan Tambahan (Opsional & Rahasia khusus Guru BK) --}}
                <div class="input-group-item">
                    <label for="catatanInput">Keterangan Tambahan untuk Guru BK (Opsional)</label>
                    <textarea
                        id="catatanInput"
                        name="catatan"
                        class="form-field"
                        rows="3"
                        placeholder="Tuliskan keterangan singkat bila diperlukan (hanya dapat dibaca oleh Guru BK, tidak ditampilkan kepada Wali Kelas maupun publik)..."
                    >{{ old('catatan') }}</textarea>
                    <div class="field-helper">
                        <i data-lucide="lock" style="width: 12px; height: 12px; color: var(--green);"></i>
                        <span>Keterangan ini bersifat rahasia hanya untuk Guru BK (tidak ditampilkan kepada Wali Kelas maupun halaman publik).</span>
                    </div>
                    @error('catatan')
                        <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit-ajukan">
                    <i data-lucide="send" style="width: 17px; height: 17px;"></i>
                    <span>Kirim Pengajuan Jadwal Konseling</span>
                </button>
            </form>
            @else
                <div class="alert-box alert-success" style="margin-bottom: 0;">
                    <i data-lucide="clock-3" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                    <div>Jadwal untuk Kode Izin ini sudah diajukan dan sedang menunggu penetapan dari Guru BK. Kamu dapat memantau perkembangannya di <a href="{{ route('portal.siswa.status', ['kode_pengajuan' => $izinAktif->kode_pengajuan]) }}" style="font-weight: 700; color: inherit;">Cek Status</a>.</div>
                </div>
            @endif
        </section>
        @endif

    </main>

    {{-- -------------------------------------------------------------
         4. FOOTER PORTAL
         ------------------------------------------------------------- --}}
    <footer class="portal-footer">
        <div class="footer-grid">
            {{-- Kolom 1 — Identitas --}}
            <div>
                <div class="footer-brand-row">
                    <div class="footer-logo-box">
                        <img src="{{ asset('images/logo-smpn2-dramaga.png') }}?v=2" alt="Logo SMP Negeri 2 Dramaga">
                    </div>
                    <div>
                        <div class="footer-brand-title">SIRASI-BK</div>
                        <div class="footer-brand-sub">SMP Negeri 2 Dramaga</div>
                    </div>
                </div>
                <p class="footer-desc">
                    Sistem Informasi Riwayat Administrasi dan Penjadwalan Bimbingan Konseling Siswa SMP Negeri 2 Dramaga yang ramah, aman, dan menjaga kerahasiaan siswa.
                </p>
                <span class="footer-npsn-badge">
                    <i data-lucide="award" style="width: 13px; height: 13px;"></i>
                    NPSN: 20254670
                </span>
            </div>

            {{-- Kolom 2 — Informasi Sekolah --}}
            <div>
                <h4 class="footer-col-title">
                    <i data-lucide="building-2" style="width: 16px; height: 16px; color: #60a5fa;"></i>
                    Informasi Sekolah
                </h4>
                <ul class="footer-info-list">
                    <li class="footer-info-item">
                        <i data-lucide="map-pin" style="width: 16px; height: 16px; color: #60a5fa; flex-shrink: 0; margin-top: 3px;"></i>
                        <span>Jl. Raya Dramaga KM. 07, Desa Dramaga, Kec. Dramaga, Kabupaten Bogor, Jawa Barat 16680</span>
                    </li>
                    <li class="footer-info-item">
                        <i data-lucide="globe" style="width: 16px; height: 16px; color: #60a5fa; flex-shrink: 0; margin-top: 3px;"></i>
                        <a href="http://smpn2dramaga.org" target="_blank" rel="noopener noreferrer">smpn2dramaga.org</a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps/search/?api=1&query=SMP+Negeri+2+Dramaga+Bogor" target="_blank" rel="noopener noreferrer" class="footer-map-btn">
                            <i data-lucide="map" style="width: 14px; height: 14px;"></i>
                            <span>Lihat Lokasi di Google Maps</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3 — Media Sosial Resmi --}}
            <div>
                <h4 class="footer-col-title">
                    <i data-lucide="share-2" style="width: 16px; height: 16px; color: #60a5fa;"></i>
                    Media Sosial Resmi
                </h4>
                <div class="footer-social-list">
                    <a href="https://www.instagram.com/smpn2dramaga.official/" target="_blank" rel="noopener noreferrer" class="footer-social-card" aria-label="Akun Instagram resmi SMP Negeri 2 Dramaga">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.75" fill="currentColor" stroke="none"/></svg>
                    </a>

                    <a href="https://x.com/search?q=SMP%20Negeri%202%20Dramaga" target="_blank" rel="noopener noreferrer" class="footer-social-card" aria-label="Cari SMP Negeri 2 Dramaga di X">
                        <svg viewBox="0 0 24 24" width="19" height="19" aria-hidden="true" focusable="false" fill="currentColor"><path d="M18.9 2H22l-6.78 7.75L23.2 22h-6.25l-4.9-7.62L5.4 22H2.27l7.25-8.29L1.8 2h6.4l4.43 6.96L18.9 2Zm-1.1 18h1.73L7.27 3.9H5.41L17.8 20Z"/></svg>
                    </a>
                    <a href="mailto:negeriduadramaga@gmail.com" class="footer-social-card" aria-label="Email SMP Negeri 2 Dramaga">
                        <i data-lucide="mail" style="width: 18px; height: 18px;"></i>
                    </a>
                </div>
            </div>
        </div>

        <a class="whatsapp-float"
           href="https://wa.me/6281284053871?text=Halo%20Guru%20BK%20SMPN%202%20Dramaga,%20saya%20ingin%20berkonsultasi."
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Chat Guru BK melalui WhatsApp">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.52 3.48A11.86 11.86 0 0 0 12.08 0C5.5 0 .14 5.35.14 11.94c0 2.1.55 4.15 1.6 5.96L.04 24l6.25-1.64a11.9 11.9 0 0 0 5.78 1.47h.01c6.58 0 11.94-5.36 11.94-11.94 0-3.19-1.24-6.19-3.5-8.41ZM12.08 21.8h-.01a9.88 9.88 0 0 1-5.03-1.37l-.36-.21-3.71.97.99-3.62-.24-.37a9.88 9.88 0 0 1-1.52-5.26c0-5.46 4.44-9.9 9.9-9.9 2.65 0 5.14 1.03 7.01 2.91a9.84 9.84 0 0 1 2.9 7c0 5.46-4.44 9.9-9.9 9.9Zm5.43-7.42c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.2 5.09 4.49.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.08-.12-.27-.2-.57-.35Z"/></svg>
            <span class="whatsapp-float-tooltip">Chat Guru BK</span>
        </a>

        <div class="footer-bottom">
            <div>
                &copy; {{ date('Y') }} <strong>SIRASI-BK &mdash; SMP Negeri 2 Dramaga</strong>. Hak Cipta Dilindungi Undang-Undang.
            </div>
            <div>
                Layanan Bimbingan dan Konseling Ramah Siswa &bull; Kabupaten Bogor
            </div>
        </div>
    </footer>

    <script>
        const siswaPerKelasData = @json($siswaPerKelas);
        const initialSelectedSiswaId = "{{ $defaultSiswaId ?? '' }}";

        lucide.createIcons();

        const mobileToggle = document.getElementById('mobileNavToggle');
        const navMenu = document.getElementById('portalNavMenu');
        if (mobileToggle && navMenu) {
            mobileToggle.addEventListener('click', function () {
                navMenu.classList.toggle('show');
            });
        }

        function populateSiswaSelectElement(kelasSelectId, siswaSelectId, waliPreviewId, waliTextId, preserveSelected = false) {
            const kelasSelect = document.getElementById(kelasSelectId);
            const siswaSelect = document.getElementById(siswaSelectId);
            const waliPreview = document.getElementById(waliPreviewId);
            const waliText = document.getElementById(waliTextId);

            if (!kelasSelect || !siswaSelect) return;

            siswaSelect.innerHTML = '';
            const selectedKelasId = kelasSelect.value;
            const selectedOption = kelasSelect.options[kelasSelect.selectedIndex];

            if (selectedKelasId && selectedOption) {
                if (kelasSelectId === 'izinKelasSelect' && typeof clearFieldError === 'function') {
                    clearFieldError(kelasSelect);
                }

                const namaWali = selectedOption.getAttribute('data-wali') || '-';
                if (waliPreview && waliText) {
                    waliText.textContent = 'Wali Kelas Binaan: ' + namaWali;
                    waliPreview.style.display = 'inline-flex';
                }

                const placeholderOpt = document.createElement('option');
                placeholderOpt.value = '';
                placeholderOpt.textContent = '-- Pilih Nama Siswa --';
                siswaSelect.appendChild(placeholderOpt);

                const listSiswa = siswaPerKelasData[selectedKelasId] || [];
                listSiswa.forEach(function (item) {
                    const option = document.createElement('option');
                    option.value = item.id_siswa;
                    option.textContent = item.nama_siswa;
                    if (preserveSelected && String(item.id_siswa) === String(initialSelectedSiswaId)) {
                        option.selected = true;
                    }
                    siswaSelect.appendChild(option);
                });
            } else {
                const defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.textContent = '-- Pilih Kelas Terlebih Dahulu --';
                siswaSelect.appendChild(defaultOpt);

                if (waliPreview) {
                    waliPreview.style.display = 'none';
                }
            }
        }

        function updateIzinSiswaOptions(preserveSelected = false) {
            populateSiswaSelectElement('izinKelasSelect', 'izinSiswaSelect', 'izinWaliKelasPreview', 'izinWaliKelasPreviewText', preserveSelected);
        }

        function updateSiswaSuggestions(preserveSelected = false) {
            populateSiswaSelectElement('kelasSelect', 'siswaSelect', 'waliKelasPreview', 'waliKelasPreviewText', preserveSelected);
        }

        function onSlotDropdownChange(selectEl) {
            if (!selectEl) return;
            const opt = selectEl.options[selectEl.selectedIndex];
            const tglInput = document.getElementById('tanggalInput') || document.getElementById('inputTanggalBimbingan');
            const mulaiInput = document.getElementById('waktuMulaiInput') || document.getElementById('inputWaktuMulai');
            const selesaiInput = document.getElementById('waktuSelesaiInput') || document.getElementById('inputWaktuSelesai');

            if (!opt || !opt.value) {
                if (tglInput) tglInput.value = '';
                if (mulaiInput) mulaiInput.value = '';
                if (selesaiInput) selesaiInput.value = '';
                return;
            }
            const tgl = opt.getAttribute('data-tanggal');
            const mulai = opt.getAttribute('data-mulai');
            const selesai = opt.getAttribute('data-selesai');
            if (tgl && tglInput) tglInput.value = tgl;
            if (mulai && mulaiInput) mulaiInput.value = mulai;
            if (selesai && selesaiInput) selesaiInput.value = selesai;

            if (typeof clearFieldError === 'function') {
                clearFieldError(selectEl);
                if (tglInput) clearFieldError(tglInput);
                if (mulaiInput) clearFieldError(mulaiInput);
                if (selesaiInput) clearFieldError(selesaiInput);
            }
        }

        function pickOpenedSlot(idSlot, tanggal, mulai, selesai) {
            const slotSelect = document.getElementById('slotSelectInput') || document.getElementById('selectSlotKonseling');
            const tglInput = document.getElementById('tanggalInput') || document.getElementById('inputTanggalBimbingan');
            const mulaiInput = document.getElementById('waktuMulaiInput') || document.getElementById('inputWaktuMulai');
            const selesaiInput = document.getElementById('waktuSelesaiInput') || document.getElementById('inputWaktuSelesai');

            if (slotSelect) {
                slotSelect.value = String(idSlot);
                if (typeof clearFieldError === 'function') {
                    clearFieldError(slotSelect);
                }
            }
            if (tglInput) {
                tglInput.value = tanggal || '';
                if (typeof clearFieldError === 'function') clearFieldError(tglInput);
            }
            if (mulaiInput) {
                mulaiInput.value = mulai || '';
                if (typeof clearFieldError === 'function') clearFieldError(mulaiInput);
            }
            if (selesaiInput) {
                selesaiInput.value = selesai || '';
                if (typeof clearFieldError === 'function') clearFieldError(selesaiInput);
            }

            const formEl = document.getElementById('formAjukanBimbingan');
            if (formEl) {
                formEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function onIzinSlotChange(selectEl) {
            if (!selectEl) return;
            const opt = selectEl.options[selectEl.selectedIndex];
            if (!opt || !opt.value) return;
            const tgl = opt.getAttribute('data-tanggal');
            const mulai = opt.getAttribute('data-mulai');
            const selesai = opt.getAttribute('data-selesai');
            const inputTgl = document.getElementById('izinTanggalInput');
            const inputMulai = document.getElementById('izinWaktuMulai');
            const inputSelesai = document.getElementById('izinWaktuSelesai');
            if (tgl && inputTgl) {
                inputTgl.value = tgl;
                clearFieldError(inputTgl);
            }
            if (mulai && inputMulai) {
                inputMulai.value = mulai;
                clearFieldError(inputMulai);
            }
            if (selesai && inputSelesai) {
                inputSelesai.value = selesai;
                clearFieldError(inputSelesai);
            }
            clearFieldError(selectEl);
        }

        function onIzinPeriodeChange(selectEl) {
            if (!selectEl) return;
            const opt = selectEl.options[selectEl.selectedIndex];
            if (!opt) return;
            const slotSelect = document.getElementById('izinSlotSelect');
            if (slotSelect && slotSelect.value) {
                if (opt.value) clearFieldError(selectEl);
                return;
            }
            const mulai = opt.getAttribute('data-mulai') || '';
            const selesai = opt.getAttribute('data-selesai') || '';
            const inputMulai = document.getElementById('izinWaktuMulai');
            const inputSelesai = document.getElementById('izinWaktuSelesai');
            if (mulai && inputMulai) {
                inputMulai.value = mulai;
                clearFieldError(inputMulai);
            }
            if (selesai && inputSelesai) {
                inputSelesai.value = selesai;
                clearFieldError(inputSelesai);
            }
            if (opt.value) {
                clearFieldError(selectEl);
            }
        }

        function showFieldError(field, message) {
            if (!field) return;
            field.classList.add('is-invalid');
            field.style.borderColor = 'var(--red)';

            let errorEl = document.getElementById('error-' + field.id);
            if (!errorEl) {
                errorEl = field.parentElement ? field.parentElement.querySelector('.field-error-message') : null;
            }
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'field-error-message';
                errorEl.id = 'error-' + field.id;
                errorEl.style.color = 'var(--red)';
                errorEl.style.fontSize = '12px';
                errorEl.style.marginTop = '4px';
                field.insertAdjacentElement('afterend', errorEl);
            }
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        }

        function clearFieldError(field) {
            if (!field) return;
            field.classList.remove('is-invalid');
            field.style.borderColor = '';

            let errorEl = document.getElementById('error-' + field.id);
            if (!errorEl) {
                errorEl = field.parentElement ? field.parentElement.querySelector('.field-error-message') : null;
            }
            if (errorEl) {
                errorEl.textContent = '';
                errorEl.style.display = 'none';
            }
        }

        function validateFormAjukanIzin() {
            const form = document.getElementById('formAjukanIzin');
            if (!form) return true;

            let isValid = true;
            let firstInvalid = null;

            function markInvalid(field, msg) {
                showFieldError(field, msg);
                isValid = false;
                if (!firstInvalid) {
                    firstInvalid = field;
                }
            }

            // 1. Kelas
            const kelas = document.getElementById('izinKelasSelect');
            if (kelas) {
                const val = (kelas.value || '').trim();
                if (!val) {
                    markInvalid(kelas, 'Kelas wajib dipilih.');
                } else {
                    clearFieldError(kelas);
                }
            }

            // 2. Nama Siswa
            const siswa = document.getElementById('izinSiswaSelect');
            if (siswa) {
                const val = (siswa.value || '').trim();
                if (!val) {
                    markInvalid(siswa, 'Nama siswa wajib dipilih.');
                } else {
                    clearFieldError(siswa);
                }
            }

            // 3. Bidang Layanan Bimbingan
            const jenis = document.getElementById('izinJenisBimbinganSelect');
            if (jenis) {
                const val = (jenis.value || '').trim();
                if (!val) {
                    markInvalid(jenis, 'Bidang layanan bimbingan wajib dipilih.');
                } else {
                    clearFieldError(jenis);
                }
            }

            // 4. Tanggal yang Diinginkan
            const tanggal = document.getElementById('izinTanggalInput');
            if (tanggal) {
                const val = (tanggal.value || '').trim();
                if (!val) {
                    markInvalid(tanggal, 'Tanggal yang diinginkan wajib diisi.');
                } else {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const todayStr = `${year}-${month}-${day}`;
                    if (val < todayStr) {
                        markInvalid(tanggal, 'Tanggal yang diinginkan tidak boleh di masa lalu.');
                    } else {
                        clearFieldError(tanggal);
                    }
                }
            }

            // 5. Slot Konseling Guru BK yang Tersedia
            const slot = document.getElementById('izinSlotSelect');
            if (slot) {
                const val = (slot.value || '').trim();
                if (!val) {
                    markInvalid(slot, 'Slot konseling Guru BK wajib dipilih.');
                } else {
                    clearFieldError(slot);
                }
            }

            // 6. Jam / Periode Pelajaran yang Ingin Ditinggalkan
            const jam = document.getElementById('izinJamPelajaranSelect');
            if (jam) {
                const val = (jam.value || '').trim();
                if (!val) {
                    markInvalid(jam, 'Jam / periode pelajaran wajib dipilih.');
                } else {
                    clearFieldError(jam);
                }
            }

            // 7. Waktu Mulai Jam Pelajaran
            const waktuMulai = document.getElementById('izinWaktuMulai');
            if (waktuMulai) {
                const val = (waktuMulai.value || '').trim();
                if (!val) {
                    markInvalid(waktuMulai, 'Waktu mulai jam pelajaran wajib diisi.');
                } else {
                    clearFieldError(waktuMulai);
                }
            }

            // 8. Waktu Selesai Jam Pelajaran
            const waktuSelesai = document.getElementById('izinWaktuSelesai');
            if (waktuSelesai) {
                const valSelesai = (waktuSelesai.value || '').trim();
                const valMulai = waktuMulai ? (waktuMulai.value || '').trim() : '';
                if (!valSelesai) {
                    markInvalid(waktuSelesai, 'Waktu selesai jam pelajaran wajib diisi.');
                } else if (valMulai && valSelesai <= valMulai) {
                    markInvalid(waktuSelesai, 'Waktu selesai harus lebih besar daripada waktu mulai.');
                } else {
                    clearFieldError(waktuSelesai);
                }
            }

            if (!isValid && firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            return isValid;
        }

        function initFormAjukanIzinValidation() {
            const formIzin = document.getElementById('formAjukanIzin');
            if (!formIzin) return;

            const fields = [
                'izinKelasSelect',
                'izinSiswaSelect',
                'izinJenisBimbinganSelect',
                'izinTanggalInput',
                'izinSlotSelect',
                'izinJamPelajaranSelect',
                'izinWaktuMulai',
                'izinWaktuSelesai'
            ];

            fields.forEach(function (fieldId) {
                const el = document.getElementById(fieldId);
                if (!el) return;

                const onInputOrChange = function () {
                    if (el.value && el.value.trim() !== '') {
                        if (el.id === 'izinWaktuSelesai') {
                            const mulaiEl = document.getElementById('izinWaktuMulai');
                            if (mulaiEl && mulaiEl.value && el.value <= mulaiEl.value) {
                                showFieldError(el, 'Waktu selesai harus lebih besar daripada waktu mulai.');
                                return;
                            }
                        } else if (el.id === 'izinTanggalInput') {
                            const now = new Date();
                            const todayStr = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
                            if (el.value < todayStr) {
                                showFieldError(el, 'Tanggal yang diinginkan tidak boleh di masa lalu.');
                                return;
                            }
                        }
                        clearFieldError(el);
                    }
                };

                el.addEventListener('input', onInputOrChange);
                el.addEventListener('change', onInputOrChange);
            });

            const waktuMulaiEl = document.getElementById('izinWaktuMulai');
            const waktuSelesaiEl = document.getElementById('izinWaktuSelesai');
            if (waktuMulaiEl && waktuSelesaiEl) {
                const syncTime = function () {
                    if (waktuSelesaiEl.value && waktuMulaiEl.value && waktuSelesaiEl.value > waktuMulaiEl.value) {
                        clearFieldError(waktuSelesaiEl);
                    }
                };
                waktuMulaiEl.addEventListener('input', syncTime);
                waktuMulaiEl.addEventListener('change', syncTime);
            }
        }

        function copyKodeIzin() {
            const display = document.getElementById('kodeIzinDisplay');
            if (!display) return;
            const text = display.innerText.trim();
            navigator.clipboard.writeText(text).then(function () {
                const btnText = document.getElementById('copyBtnText');
                if (btnText) {
                    btnText.innerText = 'Kode Disalin!';
                    setTimeout(() => { btnText.innerText = 'Salin Kode Izin'; }, 2000);
                }
            });
        }

        function initSlotKonselingJadwal() {
            const slotSelect = document.getElementById('slotSelectInput');
            const tglInput = document.getElementById('tanggalInput');
            const mulaiInput = document.getElementById('waktuMulaiInput');
            const selesaiInput = document.getElementById('waktuSelesaiInput');

            if (!slotSelect) return;

            // Pastikan jika belum ada slot yang dipilih, kolom tanggal dan waktu dikosongkan
            if (!slotSelect.value) {
                if (tglInput) tglInput.value = '';
                if (mulaiInput) mulaiInput.value = '';
                if (selesaiInput) selesaiInput.value = '';
            } else {
                onSlotDropdownChange(slotSelect);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateIzinSiswaOptions({{ $errors->any() ? 'true' : 'false' }});
            updateSiswaSuggestions(true);
            refreshCsrfToken();
            initFormAjukanIzinValidation();
            initSlotKonselingJadwal();

            @if ($portalStep === 'jadwal' && !$errors->any())
                const kodeEl = document.getElementById('kodePengajuanInput');
                const klsEl = document.getElementById('kelasSelect');
                const jnsEl = document.getElementById('jenisBimbinganSelect');
                if (kodeEl) kodeEl.value = '';
                if (klsEl) {
                    klsEl.value = '';
                    updateSiswaSuggestions(false);
                }
                if (jnsEl) jnsEl.value = '';
            @endif

            const formIzin = document.getElementById('formAjukanIzin');
            if (formIzin) {
                let isSubmitting = false;
                formIzin.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    const isValid = validateFormAjukanIzin();
                    if (!isValid) {
                        return;
                    }

                    if (isSubmitting) return;
                    isSubmitting = true;

                    const submitBtn = formIzin.querySelector('.btn-submit-ajukan');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.style.opacity = '0.75';
                        submitBtn.style.cursor = 'wait';
                    }

                    try {
                        await refreshCsrfToken();
                    } catch (err) {
                        // Lanjutkan submit apabila endpoint tidak terjangkau
                    }

                    HTMLFormElement.prototype.submit.call(formIzin);
                });
            }

            const formBimbingan = document.getElementById('formAjukanBimbingan');
            if (formBimbingan) {
                let isSubmitting = false;
                formBimbingan.addEventListener('submit', async function (e) {
                    const slotSelect = document.getElementById('slotSelectInput');
                    const tglInput = document.getElementById('tanggalInput');
                    const mulaiInput = document.getElementById('waktuMulaiInput');
                    const selesaiInput = document.getElementById('waktuSelesaiInput');

                    if (slotSelect && (!slotSelect.value || slotSelect.value.trim() === '')) {
                        e.preventDefault();
                        showFieldError(slotSelect, 'Slot konseling Guru BK wajib dipilih.');
                        slotSelect.focus();
                        return;
                    }

                    if (tglInput && (!tglInput.value || tglInput.value.trim() === '')) {
                        e.preventDefault();
                        showFieldError(slotSelect, 'Silakan pilih slot konseling untuk mengisi tanggal dan waktu konseling.');
                        slotSelect.focus();
                        return;
                    }

                    if (mulaiInput && (!mulaiInput.value || mulaiInput.value.trim() === '')) {
                        e.preventDefault();
                        showFieldError(slotSelect, 'Silakan pilih slot konseling untuk mengisi waktu mulai.');
                        slotSelect.focus();
                        return;
                    }

                    if (selesaiInput && (!selesaiInput.value || selesaiInput.value.trim() === '')) {
                        e.preventDefault();
                        showFieldError(slotSelect, 'Silakan pilih slot konseling untuk mengisi waktu selesai.');
                        slotSelect.focus();
                        return;
                    }

                    if (isSubmitting) return;
                    e.preventDefault();
                    isSubmitting = true;

                    const submitBtn = formBimbingan.querySelector('.btn-submit-ajukan');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.style.opacity = '0.75';
                        submitBtn.style.cursor = 'wait';
                    }

                    try {
                        await refreshCsrfToken();
                    } catch (err) {
                        // Lanjutkan submit apabila endpoint tidak terjangkau
                    }

                    HTMLFormElement.prototype.submit.call(formBimbingan);
                });
            }
        });

        async function refreshCsrfToken() {
            try {
                const res = await fetch("{{ route('portal.siswa.csrf', [], false) }}", {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    cache: 'no-store'
                });
                if (!res.ok) return;
                const data = await res.json();
                if (data && data.token) {
                    document.querySelectorAll('input[name="_token"]').forEach(function (input) {
                        input.value = data.token;
                    });
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    if (meta) meta.setAttribute('content', data.token);
                }
            } catch (e) {
                // Abaikan jika gagal koneksi sementara
            }
        }

        window.addEventListener('focus', refreshCsrfToken);
        window.addEventListener('pageshow', refreshCsrfToken);
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                refreshCsrfToken();
            }
        });
    </script>
</body>

</html>
