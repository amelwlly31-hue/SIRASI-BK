<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cek Status Konseling — SIRASI-BK SMP Negeri 2 Dramaga</title>


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
            max-width: 940px;
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
            max-width: 640px;
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
           4. MAIN CONTENT & STATUS CHECK CARD
           ========================================================= */
        .main-content {
            max-width: 940px;
            width: 100%;
            margin: 0 auto;
            padding: 36px 24px 72px;
            flex: 1;
        }

        .workspace-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            box-shadow: var(--shadow-sm);
        }

        .workspace-card-header {
            display: flex;
            align-items: center;
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

        /* Identity Lock Notice */
        .identity-lock-banner {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 14px;
            padding: 13px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 12.8px;
            color: var(--primary-dark);
        }

        .access-denied-box {
            background: var(--red-bg);
            border: 1.5px solid #fca5a5;
            color: #991b1b;
            border-radius: 16px;
            padding: 22px 20px;
            margin-top: 22px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Form Search Grid */
        .search-student-grid {
            display: grid;
            grid-template-columns: 0.9fr 1.15fr 0.95fr auto;
            gap: 14px;
            align-items: end;
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
            padding: 11.5px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 11px;

            font-size: 13.8px;
            color: var(--text-main);
            background: #ffffff;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.12);
        }

        .btn-search-status {
            background: var(--primary);
            color: #ffffff;
            border: none;
            height: 45px;
            padding: 0 24px;
            border-radius: 11px;

            font-size: 13.8px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.22);
        }

        .btn-search-status:hover {
            background: var(--primary-dark);
        }

        /* Student Summary Header */
        .student-result-header {
            margin-top: 28px;
            padding: 16px 20px;
            background: var(--primary-soft);
            border: 1px solid var(--primary-light);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .student-result-name {
            font-size: 15.5px;
            font-weight: 800;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .student-result-count {
            font-size: 12px;
            font-weight: 700;
            background: #ffffff;
            color: var(--primary);
            border: 1px solid var(--primary-light);
            padding: 4px 12px;
            border-radius: 999px;
        }

        /* Submission List & Individual Cards */
        .submission-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 18px;
        }

        .status-result-card {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 22px 24px;
            transition: all 0.2s ease;
        }

        .status-result-card:hover {
            border-color: #cbd5e1;
            box-shadow: var(--shadow-sm);
        }

        .status-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 16px;
        }

        .submission-number-pill {
            font-size: 13px;
            font-weight: 800;
            color: var(--primary-dark);
            background: var(--primary-light);
            padding: 5px 13px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-Diajukan {
            background: var(--orange-bg);
            color: var(--orange);
        }

        .status-Disetujui_Wali {
            background: #e0f2fe;
            color: #0369a1;
        }

        .status-Ditolak_Wali,
        .status-Dibatalkan {
            background: var(--red-bg);
            color: var(--red);
        }

        .status-Terjadwal {
            background: var(--primary-light);
            color: var(--primary);
        }

        .status-Selesai {
            background: var(--green-bg);
            color: var(--green);
        }

        /* Visual Progress Steps */
        .progress-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 0 0 16px;
        }

        .progress-step-box {
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: #ffffff;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
        }

        .progress-step-box.done {
            background: #ecfdf5;
            border-color: #6ee7b7;
            color: #047857;
        }

        .progress-step-box.active {
            background: var(--primary-soft);
            border-color: #93c5fd;
            color: var(--primary-dark);
        }

        .progress-step-box.rejected {
            background: var(--red-bg);
            border-color: #fca5a5;
            color: var(--red);
        }

        /* 3 Core Allowed Data Fields: Tanggal Pengajuan/Jadwal, Waktu Jadwal, Status Pengajuan */
        .status-info-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 14px;
        }

        .status-info-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 13px 15px;
        }

        .status-info-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .status-info-value {
            font-size: 13.8px;
            font-weight: 700;
            color: var(--text-main);
        }

        .privacy-guard-note {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 12px;
            color: var(--text-muted);
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            padding: 11px 14px;
            border-radius: 10px;
            margin-top: 18px;
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

            .search-student-grid,
            .progress-steps,
            .status-info-list,
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

            .student-result-header,
            .status-top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .status-result-card {
                padding: 18px 16px;
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
                        <a href="{{ route('portal.siswa.create') }}" class="nav-link">
                            <i data-lucide="user-check" style="width: 15px; height: 15px;"></i>
                            Izin Wali Kelas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portal.siswa.jadwal', $lockedSiswa ? ['id_kelas' => $lockedSiswa->id_kelas, 'id_siswa' => $lockedSiswa->id_siswa, 'kode_pengajuan' => $kodePengajuanInput] : []) }}" class="nav-link">
                            <i data-lucide="calendar-plus" style="width: 15px; height: 15px;"></i>
                            Jadwal Konseling
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portal.siswa.status') }}" class="nav-link active">
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
                    <i data-lucide="clipboard-list" style="width: 14px; height: 14px;"></i>
                    <span>Pantau Jadwal Konseling • Tanpa Login &amp; Tanpa Kode Unik</span>
                </div>
                <h1>Cek Status Konseling</h1>
                <p>
                    Pilih kelas dan nama kamu untuk melihat status persetujuan Wali Kelas serta jadwal bimbingan resmi dari Guru BK.
                </p>
            </div>
        </div>
    </section>

    {{-- -------------------------------------------------------------
         3. MAIN CONTENT
         ------------------------------------------------------------- --}}
    <main class="main-content">

        <section class="workspace-card">
            <div class="workspace-card-header">
                <h2>
                    <i data-lucide="user-Check" style="width: 22px; height: 22px; color: var(--primary);"></i>
                    Cek Status Berdasarkan Kelas, Nama &amp; Kode Izin
                </h2>
                <span style="font-size: 12px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 5px 12px; border-radius: 999px;">
                    Privasi Terlindungi
                </span>
            </div>

            <p class="workspace-subtitle">
                Pilih <strong>Kelas</strong>, <strong>Nama Siswa</strong>, dan masukkan <strong>Kode Izin</strong> (contoh: <code>BK-XXXXXX</code>) untuk melihat status persetujuan izin Wali Kelas dan jadwal bimbingan Guru BK.
            </p>

            {{-- Informasi penguncian akses perangkat untuk mencegah siswa melihat pengajuan siswa lain --}}
            @if ($lockedSiswa)
                <div class="identity-lock-banner">
                    <div style="display: flex; align-items: center; gap: 9px;">
                        <i data-lucide="lock" style="width: 16px; height: 16px; color: var(--primary); flex-shrink: 0;"></i>
                        <span>
                            Sesi perangkat ini terhubung dengan: <strong>{{ $lockedSiswa->nama_siswa }}</strong> (Kelas {{ $lockedSiswa->kelas->nama_kelas ?? '-' }}). Demi privasi, akses ke data siswa lain dibatasi.
                        </span>
                    </div>
                </div>
            @endif

            {{-- Form Pencarian Berdasarkan Kelas, Nama Siswa & Kode Izin --}}
            <form id="formCekStatus" method="POST" action="{{ route('portal.siswa.status', [], false) }}">
                @csrf
                <div class="search-student-grid">
                    {{-- Pilihan Kelas --}}
                    <div class="input-group-item">
                        <label for="kelasSelect">Pilih Kelas <span>*</span></label>
                        <select
                            id="kelasSelect"
                            name="id_kelas"
                            class="form-field"
                            required
                            onchange="populateSiswaDropdown()"
                        >
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelasList as $kls)
                                <option
                                    value="{{ $kls->id_kelas }}"
                                    {{ (string) $selectedKelasId === (string) $kls->id_kelas ? 'selected' : '' }}
                                >
                                    Kelas {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilihan Nama Siswa dari Database --}}
                    <div class="input-group-item">
                        <label for="siswaSelect">Pilih Nama Siswa <span>*</span></label>
                        <select
                            id="siswaSelect"
                            name="id_siswa"
                            class="form-field"
                            required
                        >
                            <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        </select>
                    </div>

                    {{-- Kode Izin / Kode Pengajuan --}}
                    <div class="input-group-item">
                        <label for="kodePengajuanInput">Kode Izin <span>*</span></label>
                        <input
                            type="text"
                            id="kodePengajuanInput"
                            name="kode_pengajuan"
                            class="form-field"
                            placeholder="Contoh: BK-XXXXXX"
                            value="{{ $kodePengajuanInput ?? '' }}"
                            style="text-transform: uppercase; font-weight: 700;"
                        >
                    </div>

                    {{-- Tombol Cari --}}
                    <div>
                        <button type="submit" class="btn-search-status">
                            <i data-lucide="search" style="width: 17px; height: 17px;"></i>
                            <span>Tampilkan Status</span>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Peringatan apabila pengguna mencoba mengganti nama/kelas ke siswa lain atau tanpa Kode Izin --}}
            @if ($aksesDitolak)
                <div class="access-denied-box">
                    <i data-lucide="shield-alert" style="width: 24px; height: 24px; flex-shrink: 0; margin-top: 2px;"></i>
                    <div>
                        <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 4px;">Akses Dibatasi / Verifikasi Kode Izin Diperlukan</h4>
                        <p style="font-size: 13.2px; line-height: 1.55; margin-bottom: 10px;">
                            {{ $pesanAksesDitolak }}
                        </p>
                        @if ($lockedSiswa)
                            <a href="{{ route('portal.siswa.status') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 700; background: #ffffff; color: #991b1b; padding: 7px 14px; border-radius: 8px; border: 1px solid #fca5a5;">
                                <i data-lucide="rotate-ccw" style="width: 14px; height: 14px;"></i>
                                <span>Kembali ke Daftar Pengajuan {{ $lockedSiswa->nama_siswa }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            @elseif ($pencarianDilakukan)
                @if ($siswaTerpilih)
                    {{-- Header Identitas Siswa Terpilih --}}
                    <div class="student-result-header">
                        <div class="student-result-name">
                            <i data-lucide="user" style="width: 18px; height: 18px;"></i>
                            <span>{{ $siswaTerpilih->nama_siswa }} &mdash; Kelas {{ $siswaTerpilih->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                        <span class="student-result-count">
                            {{ $daftarPengajuan->count() }} Pengajuan Ditemukan
                        </span>
                    </div>

                    @if ($daftarPengajuan->count() > 0)
                        {{-- Daftar Pengajuan Milik Siswa (Ditampilkan Terpisah jika Memiliki Beberapa Pengajuan) --}}
                        <div class="submission-list">
                            @foreach ($daftarPengajuan as $index => $item)
                                @php
                                    $sudahAjukanJadwal = $item->hasSubmittedSchedule();
                                    $jadwalResmi = in_array($item->status, ['Terjadwal', 'Selesai'], true);
                                @endphp
                                <div class="status-result-card" data-kode="{{ $item->kode_pengajuan }}" data-status="{{ $item->status }}" data-submitted="{{ $sudahAjukanJadwal ? '1' : '0' }}">
                                    <div class="status-top-bar">
                                        <span class="submission-number-pill">
                                            <i data-lucide="calendar-check" style="width: 15px; height: 15px;"></i>
                                            Kode Izin: {{ $item->kode_pengajuan ?? ('#' . ($daftarPengajuan->count() - $index)) }}
                                        </span>

                                        <span class="status-badge status-{{ $item->status }}">
                                            @if ($item->status === 'Diajukan')
                                                Menunggu Persetujuan Wali Kelas
                                            @elseif ($item->status === 'Disetujui_Wali' && !$sudahAjukanJadwal)
                                                Izin Diterima (Siap Ajukan Jadwal)
                                            @elseif ($item->status === 'Disetujui_Wali' && $sudahAjukanJadwal)
                                                Izin Diterima (Menunggu Jadwal BK)
                                            @elseif ($item->status === 'Ditolak_Wali')
                                                Izin Ditolak
                                            @elseif ($item->status === 'Terjadwal')
                                                Terjadwal Resmi dengan Guru BK
                                            @elseif ($item->status === 'Selesai')
                                                Sesi Konseling Selesai
                                            @elseif ($item->status === 'Dibatalkan')
                                                Jadwal Dibatalkan
                                            @else
                                                {{ str_replace('_', ' ', $item->status) }}
                                            @endif
                                        </span>
                                    </div>

                                    {{-- Tahapan Visual Status --}}
                                    <div class="progress-steps">
                                        <div class="progress-step-box done">
                                            1. Permohonan Izin Terkirim
                                        </div>
                                        <div class="progress-step-box {{ in_array($item->status, ['Disetujui_Wali', 'Terjadwal', 'Selesai']) ? 'done' : ($item->status === 'Ditolak_Wali' ? 'rejected' : 'active') }}">
                                            2. Izin Wali Kelas
                                        </div>
                                        <div class="progress-step-box {{ in_array($item->status, ['Terjadwal', 'Selesai']) ? 'done' : ($item->status === 'Disetujui_Wali' ? 'active' : ($item->status === 'Dibatalkan' ? 'rejected' : '')) }}">
                                            3. Jadwal Konseling Guru BK
                                        </div>
                                    </div>

                                    {{-- HANYA Menampilkan: Tanggal Pengajuan/Jadwal, Waktu Jadwal, dan Status Pengajuan --}}
                                    {{-- TIDAK Menampilkan alasan konseling, keterangan siswa, hasil/riwayat konseling, atau catatan internal Guru BK --}}
                                    <div class="status-info-list">
                                        <div class="status-info-item">
                                            <div class="status-info-label">{{ $jadwalResmi ? 'Tanggal Jadwal Bimbingan' : 'Tanggal Permohonan Izin' }}</div>
                                            <div class="status-info-value">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                                @if ($item->created_at)
                                                    <span style="display: block; font-size: 11.5px; font-weight: 500; color: var(--text-muted); margin-top: 2px;">
                                                        Diajukan: {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMM Y, HH:mm') }} WIB
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($jadwalResmi)
                                            <div class="status-info-item">
                                                <div class="status-info-label">Waktu Jadwal</div>
                                                <div class="status-info-value" style="color: var(--primary);">
                                                    @if ($item->waktu_mulai && $item->waktu_mulai !== '00:00:00')
                                                        Pukul {{ substr($item->waktu_mulai, 0, 5) }} - {{ substr($item->waktu_selesai, 0, 5) }} WIB
                                                    @else
                                                        Sesuai Jam Pelajaran
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="status-info-item">
                                            <div class="status-info-label">Status Izin &amp; Jadwal</div>
                                            <div class="status-info-value">
                                                @if ($item->status === 'Diajukan')
                                                    Menunggu Persetujuan Wali Kelas
                                                @elseif ($item->status === 'Disetujui_Wali' && !$sudahAjukanJadwal)
                                                    Izin Diterima (Siap Pilih Jadwal)
                                                @elseif ($item->status === 'Disetujui_Wali' && $sudahAjukanJadwal)
                                                    Izin Diterima (Menunggu Guru BK)
                                                @elseif ($item->status === 'Ditolak_Wali')
                                                    Izin Ditolak
                                                @elseif ($item->status === 'Terjadwal')
                                                    Terjadwal Resmi oleh Guru BK
                                                @elseif ($item->status === 'Selesai')
                                                    Selesai Dilaksanakan
                                                @elseif ($item->status === 'Dibatalkan')
                                                    Jadwal Dibatalkan
                                                @else
                                                    {{ str_replace('_', ' ', $item->status) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Keterangan Status Tahapan --}}
                                    <div style="background: var(--primary-soft); border-radius: 11px; padding: 14px 16px; font-size: 13px; color: var(--primary-dark); line-height: 1.55;">
                                        @if ($item->status === 'Diajukan')
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <i data-lucide="clock" style="width: 16px; height: 16px; flex-shrink: 0; color: var(--orange);"></i>
                                                <span><strong>Status Izin:</strong> Menunggu Persetujuan Wali Kelas. Halaman ini akan diperbarui otomatis saat Wali Kelas memberikan persetujuan.</span>
                                            </div>
                                        @elseif ($item->status === 'Disetujui_Wali' && !$sudahAjukanJadwal)
                                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                                <div>
                                                    <strong style="color: var(--green);">Izin Diterima!</strong> Wali Kelas telah menyetujui izinmu! Sekarang kamu dapat melanjutkan ke pengajuan jadwal bimbingan kepada Guru BK menggunakan Kode Izin <strong>{{ $item->kode_pengajuan }}</strong>.
                                                </div>
                                                <a href="{{ route('portal.siswa.jadwal', ['id_kelas' => $siswaTerpilih->id_kelas, 'id_siswa' => $siswaTerpilih->id_siswa, 'kode_pengajuan' => $item->kode_pengajuan]) }}" style="display: inline-flex; align-items: center; gap: 6px; background: var(--primary); color: #ffffff; font-size: 12.5px; font-weight: 700; padding: 9px 16px; border-radius: 9px; box-shadow: 0 4px 10px rgba(26, 86, 219, 0.2);">
                                                    <i data-lucide="calendar-plus" style="width: 15px; height: 15px;"></i>
                                                    <span>Lanjut Jadwal Konseling</span>
                                                </a>
                                            </div>
                                        @elseif ($item->status === 'Disetujui_Wali' && $sudahAjukanJadwal)
                                            <strong>Keterangan Tahap:</strong> Izin Wali Kelas telah diterima dan usulan jadwalmu telah dikirim. Saat ini Guru BK sedang memeriksa ketersediaan dan menetapkan jadwal resmi bimbingan.
                                        @elseif ($item->status === 'Terjadwal')
                                            <strong>Keterangan Tahap:</strong> Jadwal bimbingan telah resmi ditetapkan oleh Guru BK. Silakan hadir di Ruang BK sesuai tanggal dan waktu di atas.
                                        @elseif ($item->status === 'Selesai')
                                            <strong>Keterangan Tahap:</strong> Sesi bimbingan konseling pada jadwal ini telah selesai dilaksanakan.
                                        @elseif ($item->status === 'Ditolak_Wali')
                                            <div>
                                                <div style="color: var(--red); font-weight: 700; margin-bottom: 4px;">
                                                    <i data-lucide="x-circle" style="width: 15px; height: 15px; vertical-align: middle;"></i>
                                                    Izin Belum Disetujui / Ditolak oleh Wali Kelas
                                                </div>
                                                <p style="font-size: 12.8px; margin-bottom: 8px;">
                                                    Wali Kelas belum dapat memberikan izin untuk meninggalkan jam pelajaran pada tanggal dan waktu tersebut. Kamu tidak dapat melanjutkan pengajuan jadwal konseling dengan izin ini.
                                                </p>
                                                @if (!empty($item->catatan_wali))
                                                    <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 9px 12px; border-radius: 8px; font-size: 12.5px; margin-bottom: 10px;">
                                                        <strong>Alasan Wali Kelas:</strong> "{{ $item->catatan_wali }}"
                                                    </div>
                                                @endif
                                                <a href="{{ route('portal.siswa.create') }}" style="display: inline-flex; align-items: center; gap: 6px; background: var(--primary); color: #ffffff; font-size: 12px; font-weight: 700; padding: 8px 14px; border-radius: 8px; text-decoration: none;">
                                                    <i data-lucide="rotate-ccw" style="width: 13px; height: 13px;"></i>
                                                    <span>Ajukan Permohonan Izin Baru</span>
                                                </a>
                                            </div>
                                        @elseif ($item->status === 'Dibatalkan')
                                            <strong>Keterangan Tahap:</strong> Jadwal pengajuan ini telah dibatalkan. Silakan buat permohonan izin baru apabila masih memerlukan sesi bimbingan.
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; color: var(--text-muted); padding: 36px 20px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px; margin-top: 18px;">
                            <i data-lucide="calendar-x" style="width: 38px; height: 38px; margin: 0 auto 10px; display: block; color: var(--text-muted);"></i>
                            <h4 style="font-size: 15.5px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">Belum Ada Pengajuan Bimbingan</h4>
                            <p style="font-size: 13.5px; max-width: 440px; margin: 0 auto 16px;">
                                Belum terdapat data pengajuan bimbingan untuk <strong>{{ $siswaTerpilih->nama_siswa }}</strong> (Kelas {{ $siswaTerpilih->kelas->nama_kelas ?? '-' }}).
                            </p>
                            <a href="{{ route('portal.siswa.create') }}" style="display: inline-flex; align-items: center; gap: 7px; background: var(--primary); color: #ffffff; font-size: 13px; font-weight: 700; padding: 10px 18px; border-radius: 10px;">
                                <i data-lucide="calendar-plus" style="width: 15px; height: 15px;"></i>
                                <span>Izin Wali Kelas</span>
                            </a>
                        </div>
                    @endif

                    <div class="privacy-guard-note">
                        <i data-lucide="shield-check" style="width: 17px; height: 17px; color: var(--primary); flex-shrink: 0;"></i>
                        <span>Demi melindungi kerahasiaan siswa, alasan konseling, keterangan tambahan, hasil konseling, riwayat konseling, dan catatan internal Guru BK tidak ditampilkan di halaman ini.</span>
                    </div>
                @else
                    <div style="text-align: center; background: var(--red-bg); border: 1px solid #fecaca; color: var(--red); border-radius: 16px; padding: 28px 20px; margin-top: 22px;">
                        <i data-lucide="user-x" style="width: 38px; height: 38px; margin: 0 auto 10px; display: block;"></i>
                        <h4 style="font-size: 15.5px; font-weight: 800; margin-bottom: 6px;">Data Siswa Tidak Ditemukan</h4>
                        <p style="font-size: 13.5px;">
                            Pastikan kamu memilih Kelas dan Nama Siswa yang sesuai dari daftar yang tersedia.
                        </p>
                    </div>
                @endif
            @else
                <div style="text-align: center; color: var(--text-muted); padding: 42px 20px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px; margin-top: 24px;">
                    <i data-lucide="clipboard-check" style="width: 42px; height: 42px; margin: 0 auto 12px; display: block; color: var(--primary); opacity: 0.7;"></i>
                    <h4 style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">Pilih Kelas &amp; Nama Kamu</h4>
                    <p style="font-size: 13.5px; max-width: 460px; margin: 0 auto; line-height: 1.6;">
                        Silakan pilih <strong>Kelas</strong> dan <strong>Nama Siswa</strong> pada kolom di atas, lalu klik tombol <strong>Tampilkan Status</strong> untuk melihat jadwal dan status pengajuan bimbinganmu.
                    </p>
                </div>
            @endif
        </section>

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
        const initialSelectedSiswaId = "{{ $selectedSiswaId ?? '' }}";

        lucide.createIcons();

        const mobileToggle = document.getElementById('mobileNavToggle');
        const navMenu = document.getElementById('portalNavMenu');
        if (mobileToggle && navMenu) {
            mobileToggle.addEventListener('click', function () {
                navMenu.classList.toggle('show');
            });
        }

        function populateSiswaDropdown(preserveSelected = false) {
            const kelasSelect = document.getElementById('kelasSelect');
            const siswaSelect = document.getElementById('siswaSelect');
            if (!kelasSelect || !siswaSelect) return;

            const selectedKelasId = kelasSelect.value;
            siswaSelect.innerHTML = '';

            if (!selectedKelasId) {
                const defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.textContent = '-- Pilih Kelas Terlebih Dahulu --';
                siswaSelect.appendChild(defaultOpt);
                return;
            }

            const placeholderOpt = document.createElement('option');
            placeholderOpt.value = '';
            placeholderOpt.textContent = '-- Pilih Nama Siswa --';
            siswaSelect.appendChild(placeholderOpt);

            const listSiswa = siswaPerKelasData[selectedKelasId] || [];
            listSiswa.forEach(function (siswa) {
                const opt = document.createElement('option');
                opt.value = siswa.id_siswa;
                opt.textContent = siswa.nama_siswa;
                if (preserveSelected && String(siswa.id_siswa) === String(initialSelectedSiswaId)) {
                    opt.selected = true;
                }
                siswaSelect.appendChild(opt);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            populateSiswaDropdown(true);
            refreshCsrfToken();

            const formStatus = document.getElementById('formCekStatus');
            if (formStatus) {
                let isSubmittingStatus = false;
                formStatus.addEventListener('submit', async function (e) {
                    const kodeInput = document.getElementById('kodePengajuanInput');
                    const kelasSelect = document.getElementById('kelasSelect');
                    const siswaSelect = document.getElementById('siswaSelect');
                    if (kodeInput && kodeInput.value.trim() !== '') {
                        kelasSelect.removeAttribute('required');
                        siswaSelect.removeAttribute('required');
                    } else {
                        kelasSelect.setAttribute('required', 'required');
                        siswaSelect.setAttribute('required', 'required');
                    }

                    if (isSubmittingStatus) return;
                    e.preventDefault();
                    isSubmittingStatus = true;

                    try {
                        await refreshCsrfToken();
                    } catch (err) {
                        // Lanjutkan submit apabila endpoint tidak terjangkau
                    }

                    HTMLFormElement.prototype.submit.call(formStatus);
                });
            }

            // Auto-polling pembaruan status izin & jadwal otomatis tanpa refresh manual
            const activeCards = document.querySelectorAll('.status-result-card[data-status="Diajukan"], .status-result-card[data-status="Disetujui_Wali"], .status-result-card[data-status="Terjadwal"]');
            if (activeCards.length > 0) {
                const pollInterval = setInterval(async function () {
                    try {
                        const url = new URL(window.location.href);
                        url.searchParams.set('poll', '1');
                        const res = await fetch(url.toString(), {
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
                        if (data && data.success && Array.isArray(data.items)) {
                            let statusChanged = false;
                            data.items.forEach(function (serverItem) {
                                const card = document.querySelector(`.status-result-card[data-kode="${serverItem.kode_pengajuan}"]`);
                                const serverSubmitted = serverItem.has_submitted_schedule ? '1' : '0';
                                if (card && (card.getAttribute('data-status') !== serverItem.status || card.getAttribute('data-submitted') !== serverSubmitted)) {
                                    statusChanged = true;
                                }
                            });
                            if (statusChanged) {
                                clearInterval(pollInterval);
                                window.location.reload();
                            }
                        }
                    } catch (e) {
                        // Abaikan jika network error sementara
                    }
                }, 4000);
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
