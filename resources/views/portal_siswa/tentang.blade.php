<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang SIRASI-BK & Layanan BK — SMP Negeri 2 Dramaga</title>


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
            --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 12px 28px -6px rgba(15, 23, 42, 0.08), 0 8px 12px -6px rgba(15, 23, 42, 0.04);
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
            line-height: 1.65;
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
            background:
                linear-gradient(135deg, rgba(10, 39, 94, 0.90) 0%, rgba(24, 66, 143, 0.84) 52%, rgba(7, 29, 73, 0.94) 100%),
                url("https://bogor24jam.com/uploads/posts/mig_697e50aa0c831_116970d3dae3da7..jpg") center center / cover no-repeat;
            color: #ffffff;
            padding: 52px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
        }

        .page-banner-inner {
            max-width: 1120px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 24px;
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
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: #f8fafc;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 12px;
        }

        .page-banner h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
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
            font-size: 15px;
            color: rgba(241, 245, 249, 0.92);
            max-width: 680px;
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
            padding: 11px 18px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-back-home:hover {
            background: rgba(255, 255, 255, 0.24);
        }

        /* =========================================================
           4. MAIN CONTENT
           ========================================================= */
        .main-content {
            max-width: 1120px;
            width: 100%;
            margin: 0 auto;
            padding: 48px 24px 76px;
            flex: 1;
        }

        .about-intro-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 38px 36px;
            margin-bottom: 36px;
            box-shadow: var(--shadow-sm);
            display: grid;
            grid-template-columns: 1.25fr 0.75fr;
            gap: 36px;
            align-items: center;
        }

        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--primary);
            background: var(--primary-soft);
            border: 1px solid var(--primary-light);
            padding: 5px 13px;
            border-radius: 999px;
            margin-bottom: 12px;
        }

        .about-intro-card h2 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 12px;
            letter-spacing: -0.4px;
            line-height: 1.28;
        }

        .about-intro-card p {
            font-size: 14.5px;
            color: var(--text-secondary);
            margin-bottom: 14px;
            line-height: 1.72;
        }

        .about-highlight-box {
            background: linear-gradient(145deg, #0f368d 0%, #1a56db 100%);
            border-radius: 20px;
            padding: 28px 26px;
            color: #ffffff;
            text-align: center;
        }

        .about-highlight-logo {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.95);
            padding: 8px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .about-highlight-logo img {
            display: block;
            width: 190px;
            height: 190px;
            flex: 0 0 190px;
            object-fit: contain;
            object-position: center bottom;
        }

        .about-highlight-box h3 {
            font-size: 19px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .about-highlight-box p {
            font-size: 13px;
            color: rgba(241, 245, 249, 0.9);
            margin-bottom: 0;
        }

        /* Tujuan Sistem Grid */
        .tujuan-section {
            margin-bottom: 42px;
        }

        .section-heading-center {
            text-align: center;
            max-width: 660px;
            margin: 0 auto 28px;
        }

        .section-heading-center h2 {
            font-size: 25px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .section-heading-center p {
            font-size: 14.5px;
            color: var(--text-muted);
        }

        .tujuan-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .tujuan-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: all 0.22s ease;
        }

        .tujuan-card:hover {
            border-color: #93c5fd;
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .tujuan-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .tujuan-card h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .tujuan-card p {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Prinsip & Layanan BK SMPN 2 Dramaga */
        .prinsip-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 36px 32px;
            margin-bottom: 38px;
            box-shadow: var(--shadow-sm);
        }

        .prinsip-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 24px;
        }

        .prinsip-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 22px 20px;
        }

        .prinsip-item-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .prinsip-item h4 {
            font-size: 15.5px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .prinsip-item p {
            font-size: 13.2px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* CTA Box */
        .about-cta-box {
            background: linear-gradient(135deg, #0f368d 0%, #1a56db 60%, #0284c7 100%);
            border-radius: 22px;
            padding: 34px 36px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .about-cta-box h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .about-cta-box p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 580px;
        }

        .btn-cta-white {
            background: #ffffff;
            color: var(--primary-dark);
            font-size: 14px;
            font-weight: 800;
            padding: 13px 22px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-cta-white:hover {
            background: #f8fafc;
            transform: translateY(-2px);
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
            .about-intro-card {
                grid-template-columns: 1fr;
            }

            .prinsip-grid,
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

            .tujuan-grid,
            .prinsip-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .about-intro-card,
            .prinsip-card {
                padding: 24px 20px;
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

            .cta-banner-about {
                flex-direction: column;
                align-items: flex-start;
                padding: 24px 20px;
            }

            .btn-cta-white {
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
                        <a href="{{ route('portal.siswa.create') }}" class="nav-link">
                            <i data-lucide="user-check" style="width: 15px; height: 15px;"></i>
                            Izin Wali Kelas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portal.siswa.jadwal') }}" class="nav-link">
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
                        <a href="{{ route('portal.siswa.tentang') }}" class="nav-link active">
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
                    <i data-lucide="info" style="width: 14px; height: 14px;"></i>
                    <span>Mengenal Lebih Dekat • SIRASI-BK SMP Negeri 2 Dramaga</span>
                </div>
                <h1>Tentang SIRASI-BK &amp; Layanan Konseling</h1>
                <p>
                    Informasi lengkap mengenai Sistem Informasi Riwayat Administrasi dan Penjadwalan Bimbingan Konseling (SIRASI-BK) di SMP Negeri 2 Dramaga.
                </p>
            </div>
        </div>
    </section>

    {{-- -------------------------------------------------------------
         3. MAIN CONTENT
         ------------------------------------------------------------- --}}
    <main class="main-content">

        {{-- Pengenalan Lengkap SIRASI-BK --}}
        <section class="about-intro-card">
            <div>
                <span class="section-tag">
                    <i data-lucide="book-open-check" style="width: 13px; height: 13px;"></i>
                    Apa Itu SIRASI-BK?
                </span>
                <h2>Jembatan Digital Antara Siswa, Wali Kelas, dan Guru BK</h2>
                <p>
                    <strong>SIRASI-BK</strong> (Sistem Informasi Riwayat Administrasi dan Penjadwalan Bimbingan Konseling) adalah platform layanan bimbingan konseling di <strong>SMP Negeri 2 Dramaga</strong> yang dirancang untuk memudahkan siswa mendapatkan pendampingan tanpa prosedur yang rumit.
                </p>
                <p style="margin-bottom: 0;">
                    Melalui Portal Siswa SIRASI-BK, setiap siswa dapat langsung mengajukan jadwal bimbingan dari perangkat masing-masing tanpa harus membuat akun atau menghafal NIS, sementara proses izin jam pelajaran bersama Wali Kelas dan penjadwalan oleh Guru BK tetap terkoordinasi secara rapi dan aman.
                </p>
            </div>

            <div class="about-highlight-box">
                <div class="about-highlight-logo">
                    <img src="{{ asset('images/logo-smpn2-dramaga.png') }}?v=2" alt="Logo SMP Negeri 2 Dramaga">
                </div>
                <h3>SMP Negeri 2 Dramaga</h3>
                <p style="margin-bottom: 12px;">Kabupaten Bogor, Jawa Barat</p>
                <div style="background: rgba(255,255,255,0.14); border-radius: 12px; padding: 12px; font-size: 12.5px; line-height: 1.55;">
                    “Membentuk peserta didik yang berkarakter mulia, percaya diri, dan siap menghadapi masa depan melalui layanan bimbingan yang humanis.”
                </div>
            </div>
        </section>

        {{-- Tujuan Sistem SIRASI-BK --}}
        <section class="tujuan-section">
            <div class="section-heading-center">
                <span class="section-tag">Tujuan Sistem</span>
                <h2>Mengapa SIRASI-BK Dihadirkan?</h2>
                <p>
                    SIRASI-BK dikembangkan untuk mendukung kenyamanan siswa sekaligus ketertiban layanan konseling di lingkungan sekolah.
                </p>
            </div>

            <div class="tujuan-grid">
                <div class="tujuan-card">
                    <div class="tujuan-icon">
                        <i data-lucide="smile-plus" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div>
                        <h3>Memudahkan Akses Bimbingan bagi Siswa</h3>
                        <p>
                            Menghilangkan rasa sungkan atau takut siswa untuk datang ke Ruang BK dengan menyediakan formulir pengajuan online yang ramah dan mudah diakses tanpa login.
                        </p>
                    </div>
                </div>

                <div class="tujuan-card">
                    <div class="tujuan-icon" style="background: #ecfdf5; color: #059669;">
                        <i data-lucide="user-check" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div>
                        <h3>Koordinasi Tertib dengan Wali Kelas</h3>
                        <p>
                            Setiap pengajuan jadwal bimbingan diteruskan kepada Wali Kelas terlebih dahulu agar izin meninggalkan jam pelajaran diketahui dan disetujui secara resmi.
                        </p>
                    </div>
                </div>

                <div class="tujuan-card">
                    <div class="tujuan-icon" style="background: #fff7ed; color: #d97706;">
                        <i data-lucide="calendar-check-2" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div>
                        <h3>Penjadwalan yang Teratur &amp; Tidak Bentrok</h3>
                        <p>
                            Membantu Guru BK mengelola jadwal sesi konseling secara sistematis sehingga tidak terjadi bentrok waktu antar-siswa dan setiap siswa mendapat perhatian penuh.
                        </p>
                    </div>
                </div>

                <div class="tujuan-card">
                    <div class="tujuan-icon" style="background: #eef2ff; color: #4338ca;">
                        <i data-lucide="shield-check" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div>
                        <h3>Menjaga Kerahasiaan &amp; Privasi Siswa</h3>
                        <p>
                            Catatan dan riwayat konseling pribadi siswa hanya dapat diakses oleh Guru BK yang berwenang dan tidak pernah ditampilkan pada halaman pengecekan status publik.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Asas, Waktu Operasional, & Lokasi Ruang BK --}}
        <section class="prinsip-card">
            <div class="section-heading-center" style="margin-bottom: 16px;">
                <span class="section-tag">Layanan BK Sekolah</span>
                <h2>Prinsip &amp; Informasi Ruang BK SMP Negeri 2 Dramaga</h2>
                <p>
                    Komitmen Guru BK dalam melayani dan mendampingi seluruh siswa kelas VII, VIII, dan IX.
                </p>
            </div>

            <div class="prinsip-grid">
                <div class="prinsip-item">
                    <div class="prinsip-item-icon">
                        <i data-lucide="lock" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4>Asas Kerahasiaan (Confidentiality)</h4>
                    <p>
                        Seluruh cerita, keluh kesah, dan permasalahan yang kamu sampaikan kepada Guru BK dijamin kerahasiaannya sesuai kode etik profesi Bimbingan dan Konseling.
                    </p>
                </div>

                <div class="prinsip-item">
                    <div class="prinsip-item-icon" style="color: var(--green);">
                        <i data-lucide="clock" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4>Jam Layanan Tatap Muka</h4>
                    <p>
                        Ruang BK melayani sesi bimbingan setiap hari sekolah <strong>Senin s.d. Jumat</strong> pukul <strong>07.30 &ndash; 15.00 WIB</strong> sesuai jadwal yang telah disepakati.
                    </p>
                </div>

                <div class="prinsip-item">
                    <div class="prinsip-item-icon" style="color: var(--orange);">
                        <i data-lucide="map-pin" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4>Lokasi Ruang BK</h4>
                    <p>
                        Berada di lingkungan kampus <strong>SMP Negeri 2 Dramaga</strong> (Jl. Raya Dramaga KM. 07, Desa Dramaga, Kabupaten Bogor) dengan suasana yang tenang dan nyaman.
                    </p>
                </div>
            </div>
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
        lucide.createIcons();

        const mobileToggle = document.getElementById('mobileNavToggle');
        const navMenu = document.getElementById('portalNavMenu');
        if (mobileToggle && navMenu) {
            mobileToggle.addEventListener('click', function () {
                navMenu.classList.toggle('show');
            });
        }
    </script>
</body>

</html>
