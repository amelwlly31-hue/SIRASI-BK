<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRASI-BK — Portal Layanan Bimbingan Konseling Siswa SMP Negeri 2 Dramaga</title>


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
            --shadow-md: 0 12px 28px -6px rgba(15, 23, 42, 0.08), 0 8px 12px -6px rgba(15, 23, 42, 0.04);
            --shadow-lg: 0 20px 35px -10px rgba(26, 86, 219, 0.14);
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
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Subtle entrance animation */
        @keyframes fadeUpSoft {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatGentle {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-6px);
            }
        }

        /* =========================================================
           2. TOP HORIZONTAL NAVBAR (NO SIDEBAR)
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
            border-radius: 14px;
            background: var(--primary-soft);
            border: 1px solid var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            flex-shrink: 0;
            transition: transform 0.2s ease;
            overflow: hidden;
        }

        .brand-logo-wrap:hover {
            transform: scale(1.02);
        }

        .brand-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transform: scale(1.25);
        }

        .brand-text-name {
            font-size: 17.5px;
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
            line-height: 1.2;
        }

        .nav-menu-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
            text-decoration: none;
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
            flex-shrink: 0;
        }

        .btn-login-petugas {
            width: 42px;
            height: 42px;
            padding: 4px;
            border: 0;
            border-radius: 50%;
            color: #475569;
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
            text-decoration: none;
            flex-shrink: 0;
        }

        .btn-login-petugas:hover {
            color: var(--primary-dark);
            background: #f1f5f9;
            border-color: transparent;
            transform: translateY(-1px);
            box-shadow: none;
        }

        .nav-toggle-btn {
            display: none;
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            border-radius: 11px;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-toggle-btn:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        /* =========================================================
           3. HERO SECTION (FULL-WIDTH SCHOOL HERO BANNER)
           ========================================================= */
        .hero-section {
            position: relative;
            width: 100%;
            min-height: 550px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(135deg, rgba(10, 39, 94, 0.88) 0%, rgba(24, 66, 143, 0.78) 48%, rgba(7, 29, 73, 0.92) 100%),
                url("https://bogor24jam.com/uploads/posts/mig_697e50aa0c831_116970d3dae3da7..jpg") center center / cover no-repeat;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            overflow: hidden;
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 84px 24px 92px;
        }

        .hero-content {
            max-width: 780px;
            color: #ffffff;
            animation: fadeUpSoft 0.55s ease-out both;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: #f8fafc;
            font-size: 12.5px;
            font-weight: 700;
            padding: 7px 16px;
            border-radius: 999px;
            margin-bottom: 22px;
            letter-spacing: 0.2px;
        }

        .hero-title {
            font-size: 44px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.18;
            letter-spacing: -0.8px;
            margin-bottom: 18px;
            text-shadow: 0 2px 16px rgba(7, 19, 48, 0.45);
        }

        .hero-desc {
            font-size: 17px;
            color: rgba(241, 245, 249, 0.95);
            margin-bottom: 34px;
            line-height: 1.72;
            max-width: 690px;
            text-shadow: 0 1px 8px rgba(7, 19, 48, 0.35);
        }

        .hero-btn-group {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: #ffffff;
            color: var(--primary-dark);
            font-size: 15px;
            font-weight: 800;
            padding: 15px 28px;
            border-radius: 13px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 24px -4px rgba(7, 19, 48, 0.4);
            transition: all 0.22s ease;
        }

        .btn-hero-primary:hover {
            background: #eff6ff;
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -4px rgba(7, 19, 48, 0.5);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            padding: 15px 26px;
            border-radius: 13px;
            border: 1.5px solid rgba(255, 255, 255, 0.48);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.22s ease;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        .hero-trust-pills {
            margin-top: 28px;
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            font-size: 13px;
            font-weight: 600;
            color: rgba(226, 232, 240, 0.95);
        }

        .hero-trust-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        /* =========================================================
           SEARCH BAR CEK SLOT (FLOATING TRANSPARAN DI PERBATASAN HERO)
           ========================================================= */
        .hero-search-boundary-wrap {
            position: relative;
            z-index: 40;
            width: 100%;
            height: 0;
        }

        .hero-search-boundary-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .hero-search-bar {
            transform: translateY(-50%);
            max-width: 760px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            padding: 14px 22px;
            box-shadow: 0 16px 36px -6px rgba(10, 39, 94, 0.22), 0 4px 14px rgba(15, 23, 42, 0.08);
            transition: all 0.25s ease;
        }

        .hero-search-bar:hover {
            background: rgba(255, 255, 255, 0.88);
            box-shadow: 0 20px 42px -6px rgba(10, 39, 94, 0.28), 0 6px 18px rgba(15, 23, 42, 0.1);
        }

        .hero-search-form {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        .hero-search-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-search-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: rgba(26, 86, 219, 0.12);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .hero-search-text {
            display: flex;
            flex-direction: column;
        }

        .hero-search-title {
            font-size: 14.5px;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.2px;
            line-height: 1.25;
        }

        .hero-search-sub {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            line-height: 1.25;
        }

        .hero-search-inputs-group {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            justify-content: flex-end;
            min-width: 320px;
        }

        .hero-search-input-wrap {
            position: relative;
            flex: 1;
            max-width: 190px;
            min-width: 155px;
        }

        .hero-search-input {
            width: 100%;
            padding: 9.5px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 11px;

            font-size: 13.5px;
            color: var(--text-main);
            background: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        .hero-search-input:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15);
        }

        .hero-search-input-wrap .input-inline-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            color: var(--primary);
            pointer-events: none;
        }

        .hero-search-btn {
            background: var(--primary);
            color: #ffffff;
            border: none;
            padding: 10px 18px;
            border-radius: 11px;

            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(26, 86, 219, 0.25);
            white-space: nowrap;
        }

        .hero-search-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(26, 86, 219, 0.32);
        }

        /* Pesan Singkat Ketersediaan Slot Tepat di Bawah Search Bar (Teks Biasa Tanpa Card/Border) */
        .hero-search-msg {
            margin-top: 10px;
        }

        .hero-search-msg-text {
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            margin: 0;
            background: none;
            border: none;
            padding: 0;
        }

        .hero-search-msg-text.text-warning {
            color: #b45309;
        }

        .hero-search-msg-text.text-orange {
            color: #c2410c;
        }

        .hero-search-msg-text.text-danger {
            color: #b91c1c;
        }

        .hero-search-msg-text.text-success {
            color: #047857;
        }

        .hero-search-msg-link {
            color: var(--primary);
            font-weight: 700;
            text-decoration: underline;
        }

        .hero-search-msg-link:hover {
            color: var(--primary-dark);
        }

        /* =========================================================
           4. MAIN CONTENT CONTAINER & SECTION HEADERS
           ========================================================= */
        .main-content {
            max-width: 1240px;
            margin: 0 auto;
            padding: 92px 24px 80px;
        }

        .section-header {
            text-align: center;
            max-width: 680px;
            margin: 0 auto 38px;
        }

        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--primary);
            background: var(--primary-soft);
            border: 1px solid var(--primary-light);
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            margin-bottom: 10px;
            line-height: 1.25;
        }

        .section-desc {
            font-size: 15px;
            color: var(--text-muted);
        }

        /* =========================================================
           5. BAGIAN AJAKAN UNTUK SISWA ("CERITA KAMU BERHARGA")
           ========================================================= */
        .empathy-section {
            background: linear-gradient(135deg, #ffffff 0%, #f0f6ff 100%);
            border: 1px solid #dbeafe;
            border-radius: 28px;
            padding: 44px 42px;
            margin-bottom: 64px;
            box-shadow: var(--shadow-md);
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            gap: 44px;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .empathy-visual-col {
            position: relative;
            background: linear-gradient(145deg, #1e40af 0%, #1d4ed8 55%, #0284c7 100%);
            border-radius: 22px;
            padding: 34px 30px;
            color: #ffffff;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .empathy-visual-col::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -70px;
            right: -60px;
        }

        .empathy-illustration-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            animation: floatGentle 4.5s ease-in-out infinite;
        }

        .empathy-quote-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .empathy-visual-title {
            font-size: 22px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .empathy-visual-desc {
            font-size: 14px;
            color: rgba(241, 245, 249, 0.92);
            line-height: 1.65;
        }

        .empathy-text-col {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .empathy-heading {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            line-height: 1.25;
        }

        .empathy-lead {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .empathy-points {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: 4px;
        }

        .empathy-point-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 18px;
            display: flex;
            align-items: flex-start;
            gap: 13px;
            transition: all 0.22s ease;
        }

        .empathy-point-card:hover {
            border-color: #93c5fd;
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .empathy-point-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .empathy-point-card h4 {
            font-size: 14px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 3px;
        }

        .empathy-point-card p {
            font-size: 12.8px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* =========================================================
           6. BAGIAN LAYANAN BK (4 KARTU DALAM GRID)
           ========================================================= */
        .layanan-section {
            margin-bottom: 68px;
        }

        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .layanan-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 28px 24px;
            box-shadow: var(--shadow-sm);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .layanan-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: #93c5fd;
        }

        .layanan-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .layanan-card-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .layanan-card-desc {
            font-size: 13.8px;
            color: var(--text-muted);
            line-height: 1.65;
            margin-bottom: 22px;
        }

        .layanan-btn-cta {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--primary);
            background: var(--primary-soft);
            padding: 11px 16px;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .layanan-btn-cta:hover {
            background: var(--primary);
            color: #ffffff;
        }

        /* =========================================================
           7. BAGIAN CARA MENGAJUKAN BIMBINGAN (4 LANGKAH SEDERHANA)
           ========================================================= */
        .alur-section {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 26px;
            padding: 46px 38px;
            margin-bottom: 64px;
            box-shadow: var(--shadow-sm);
        }

        .alur-steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
            margin-top: 28px;
            position: relative;
        }

        .step-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 26px 20px 22px;
            text-align: center;
            position: relative;
            transition: all 0.22s ease;
        }

        .step-card:hover {
            background: #ffffff;
            border-color: #93c5fd;
            transform: translateY(-4px);
            box-shadow: var(--shadow-sm);
        }

        .step-number-pill {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: var(--primary);
            color: #ffffff;
            font-size: 14px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.25);
        }

        .step-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #ffffff;
            border: 1px solid var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }

        .step-title {
            font-size: 15.5px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .step-desc {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.58;
        }

        /* =========================================================
           8. PROFESSIONAL 4-COLUMN FOOTER
           ========================================================= */
        .portal-footer {
            position:relative;
            background: #0b132b;
            color: #cbd5e1;
            padding: 34px 24px 20px;
            border-top: 4px solid var(--primary);
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
            padding: 0;
            flex-shrink: 0;
            overflow: hidden;
        }

        .footer-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transform: scale(3) translateY(12%);
            transform-origin: center;
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
            align-items: flex-start;
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
            align-items: flex-start;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 18px;
            text-align: left;
        }

        .footer-social-column { display:flex; flex-direction:column; align-items:flex-start; text-align:left; }

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

        .whatsapp-float {
            position:absolute;
            right:24px;
            bottom:72px;
            z-index:50;
            display:flex;
            width:52px;
            height:52px;
            align-items:center;
            justify-content:center;
            border:3px solid rgba(255,255,255,.92);
            border-radius:50%;
            background:#25D366;
            color:#fff;
            box-shadow:0 10px 28px rgba(0,0,0,.28);
            transition:transform .2s ease, box-shadow .2s ease;
            animation:whatsappFloatIn .55s ease-out;
        }
        .whatsapp-float:hover { transform:scale(1.05); box-shadow:0 14px 34px rgba(0,0,0,.34); }
        .whatsapp-float svg { width:28px; height:28px; fill:currentColor; }
        .whatsapp-float-tooltip {
            position:absolute;
            right:calc(100% + 12px);
            padding:8px 11px;
            border-radius:9px;
            background:#0f172a;
            color:#fff;
            font-size:12px;
            font-weight:700;
            white-space:nowrap;
            opacity:0;
            transform:translateX(5px);
            pointer-events:none;
            transition:opacity .18s ease, transform .18s ease;
        }
        .whatsapp-float:hover .whatsapp-float-tooltip,
        .whatsapp-float:focus-visible .whatsapp-float-tooltip { opacity:1; transform:translateX(0); }
        @keyframes whatsappFloatIn { from { opacity:0; transform:translateY(10px) scale(.94); } to { opacity:1; transform:translateY(0) scale(1); } }
        @media (max-width:600px) { .whatsapp-float { right:18px; bottom:72px; width:48px; height:48px; border-width:2px; } .whatsapp-float svg { width:26px; height:26px; } }
        @media (prefers-reduced-motion: reduce) { .whatsapp-float { animation:none; transition:none; } .whatsapp-float-tooltip { transition:none; } }

        /* Penyegaran visual Beranda Portal Siswa */
        .portal-navbar { background: rgba(255,255,255,.82); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .brand-logo-wrap { border-radius: 18px; box-shadow: 0 8px 22px rgba(26,86,219,.10); }
        .nav-link { border-radius: 999px; }
        .hero-section { min-height: 590px; background-image: linear-gradient(112deg, rgba(7,28,72,.91) 0%, rgba(18,73,155,.78) 52%, rgba(9,37,89,.55) 100%), url("https://bogor24jam.com/uploads/posts/mig_697e50aa0c831_116970d3dae3da7..jpg"); background-position: center; }
        .hero-section::after { content:''; position:absolute; inset:0; pointer-events:none; background: radial-gradient(ellipse at 78% 25%, rgba(96,165,250,.23), transparent 38%); }
        .hero-badge, .hero-trust-pill { background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.24); backdrop-filter:blur(10px); border-radius:999px; padding:8px 13px; }
        .hero-title { max-width:720px; font-size:clamp(34px,4.2vw,54px); letter-spacing:-1.2px; }
        .btn-hero-primary { color:#fff; background:linear-gradient(135deg,#38bdf8,#2563eb 65%,#4f46e5); box-shadow:0 12px 30px rgba(37,99,235,.35),0 0 24px rgba(96,165,250,.18); }
        .btn-hero-primary:hover { color:#fff; background:linear-gradient(135deg,#0ea5e9,#1d4ed8 65%,#4338ca); }
        .btn-hero-primary, .btn-hero-secondary { transition:transform .2s ease, box-shadow .2s ease, background .2s ease; }
        .btn-hero-primary:hover, .btn-hero-secondary:hover { transform:translateY(-3px); }
        .hero-search-bar { background:rgba(255,255,255,.94); border-color:#fff; border-radius:22px; box-shadow:0 22px 48px -14px rgba(10,39,94,.32); }
        .main-content { padding-top:94px; }
        .daily-row { display:grid; grid-template-columns:1.1fr .9fr; gap:20px; margin-bottom:62px; }
        .daily-card { background:#fff; border:1px solid #e5edfb; border-radius:22px; padding:24px; box-shadow:var(--shadow-sm); }
        .daily-card h2 { font-size:19px; line-height:1.35; margin:0 0 7px; }
        .daily-card p { color:var(--text-muted); font-size:13.5px; margin:0; }
        .mood-options { display:flex; flex-wrap:wrap; gap:9px; margin:17px 0 12px; }
        .mood-option { border:1px solid #e2e8f0; background:#f8fafc; border-radius:14px; padding:9px 13px; cursor:pointer;  font-size:13px; font-weight:600; transition:.2s ease; }
        .mood-option:hover,.mood-option[aria-pressed="true"] { background:#eff6ff; border-color:#93c5fd; transform:translateY(-2px); box-shadow:0 6px 14px rgba(37,99,235,.1); }
        .mood-option span { display:block; font-size:22px; margin-bottom:2px; }
        .mood-response { min-height:22px; color:#1d4ed8!important; font-weight:700; }
        .daily-tip { background:linear-gradient(135deg,#fff7ed,#fffbeb 65%,#fef3c7); border-color:#fde7bd; position:relative; overflow:hidden; }
        .daily-tip::after { content:'✦'; position:absolute; right:22px; top:10px; color:#f59e0b; font-size:44px; opacity:.22; }
        .daily-tip .tip-label { display:inline-flex; color:#b45309; background:#fff; padding:5px 10px; border-radius:999px; font-size:11px; font-weight:800; margin-bottom:12px; }
        .daily-tip blockquote { margin:0 0 10px; max-width:430px; font-size:17px; font-weight:800; line-height:1.5; color:#713f12; }
        .layanan-card { border-top:3px solid #c7d2fe; }
        .layanan-card:nth-child(2) { border-top-color:#6ee7b7; }
        .layanan-card:nth-child(3) { border-top-color:#7dd3fc; }
        .layanan-card:nth-child(4) { border-top-color:#fdba74; }
        .layanan-card:hover { transform:translateY(-6px) scale(1.015); }
        .layanan-btn-cta:hover svg { transform:translateX(4px); }
        .layanan-btn-cta svg { transition:transform .2s ease; }
        .alur-steps-grid::before { content:''; position:absolute; left:11%; right:11%; top:43px; border-top:2px dashed #bfdbfe; }
        .step-card { z-index:1; }
        .step-number-pill { width:38px; height:38px; outline:5px solid #fff; }
        .portal-footer { background:linear-gradient(145deg,#0b1736,#101f43); border-top-width:3px; }
        .footer-bottom { color:#94a3b8; }
        @media (max-width:768px) {
            .hero-section { min-height:510px; }
            .hero-inner { padding:48px 18px 62px; }
            .daily-row { grid-template-columns:1fr; margin-bottom:46px; }
            .main-content { padding-top:132px; }
            .hero-search-boundary-container { padding:0 16px; }
            .alur-steps-grid::before { display:none; }
            .hero-trust-pills { gap:8px; }
        }
        @media (max-width:480px) {
            .btn-login-petugas { width:38px; height:38px; }
            .hero-title { font-size:30px; }
            .hero-btn-group { align-items:stretch; }
            .hero-btn-group .btn-hero-primary,.hero-btn-group .btn-hero-secondary { width:100%; justify-content:center; }
            .daily-card { padding:20px; }
        }

        /* =========================================================
           10. RESPONSIVE MEDIA QUERIES
           ========================================================= */
        @media (max-width: 1080px) {
            .empathy-section {
                grid-template-columns: 1fr;
                padding: 32px 28px;
            }

            .layanan-grid,
            .alur-steps-grid,
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

            .hero-section {
                min-height: 460px;
            }

            .hero-inner {
                padding: 56px 18px 64px;
            }

            .hero-title {
                font-size: 30px;
            }

            .hero-desc {
                font-size: 15px;
            }

            .empathy-points,
            .layanan-grid,
            .alur-steps-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 115px 16px 64px;
            }

            .hero-search-bar {
                padding: 14px 16px;
                border-radius: 16px;
            }

            .hero-search-form {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .hero-search-inputs-group {
                flex-direction: column;
                min-width: 100%;
                gap: 10px;
            }

            .hero-search-input-wrap {
                max-width: 100%;
                width: 100%;
            }

            .hero-search-btn {
                width: 100%;
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

            .hero-title {
                font-size: 25px;
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn-hero-primary,
            .btn-hero-outline {
                width: 100%;
                justify-content: center;
            }

            .empathy-section,
            .layanan-card,
            .alur-step-card {
                padding: 20px 16px;
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
                        <a href="{{ route('portal.siswa.index') }}" class="nav-link active">
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
                        <a href="{{ route('portal.siswa.tentang') }}" class="nav-link">
                            <i data-lucide="info" style="width: 15px; height: 15px;"></i>
                            Tentang
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn-login-petugas" title="Login Pengguna — Guru BK, Admin, dan Wali Kelas" aria-label="Login Pengguna">
                    <i data-lucide="circle-user-round" aria-hidden="true" style="width: 28px; height: 28px;"></i>
                </a>

                <button type="button" class="nav-toggle-btn" id="mobileNavToggle" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width: 20px; height: 20px;"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- -------------------------------------------------------------
         2. A. HERO SECTION (FULL-WIDTH SCHOOL HERO BANNER)
         ------------------------------------------------------------- --}}
    <section class="hero-section">
        <div class="hero-inner">
            <div class="hero-content">
                <div class="hero-badge">
                    <i data-lucide="heart-handshake" style="width: 16px; height: 16px;"></i>
                    <span>Layanan Bimbingan dan Konseling SMP Negeri 2 Dramaga</span>
                </div>

                <h1 class="hero-title">
                    Tidak Harus Menghadapi Semuanya Sendiri
                </h1>

                <p class="hero-desc">
                    Setiap siswa punya cerita dan tantangan masing-masing. Jika kamu sedang menghadapi masalah pribadi, pertemanan, atau kesulitan belajar, Guru BK siap mendengarkan dan membantumu menemukan solusi.
                </p>

                <div class="hero-btn-group">
                    <a href="{{ route('portal.siswa.create') }}" class="btn-hero-primary">
                        <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8z"/><path d="M12 16s-4-2.5-4-5a2.2 2.2 0 0 1 4-1.2A2.2 2.2 0 0 1 16 11c0 2.5-4 5-4 5z"/></svg>
                        <span>Mulai Bercerita</span>
                    </a>

                    <a href="{{ route('portal.siswa.status') }}" class="btn-hero-secondary">
                        <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="3" width="12" height="18" rx="2"/><path d="M16 3.5v2h-4v-2"/><path d="m11 14 2 2 4-4"/></svg>
                        <span>Cek Status</span>
                    </a>
                </div>

                <div class="hero-trust-pills">
                    <span class="hero-trust-pill">
                        <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6ee7b7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="m16 11 2 2 4-4"/></svg>
                        Tanpa Perlu Buat Akun
                    </span>
                    <span class="hero-trust-pill">
                        <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/><rect x="9" y="10" width="6" height="5" rx="1"/><path d="M10 10V8a2 2 0 1 1 4 0v2"/></svg>
                        Ceritamu Dijaga Rahasia
                    </span>
                    <span class="hero-trust-pill">
                        <i data-lucide="smile-plus" style="width: 15px; height: 15px; color: #fde68a;"></i>
                        Ruang Aman &amp; Ramah Siswa
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- -------------------------------------------------------------
         SEARCH BAR CEK SLOT KONSELING (TRANSPARAN DI PERBATASAN HERO)
         ------------------------------------------------------------- --}}
    <div class="hero-search-boundary-wrap">
        <div class="hero-search-boundary-container">
            <div class="hero-search-bar" id="search-slot">
                <form method="GET" action="{{ route('portal.siswa.index') }}#search-slot" class="hero-search-form">
                    <div class="hero-search-label">
                        <div class="hero-search-icon">
                            <i data-lucide="calendar-search" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div class="hero-search-text">
                            <span class="hero-search-title">Cek Slot Ketersediaan Konseling Guru BK</span>
                            <span class="hero-search-sub">Pilih tanggal untuk cek slot ketersediaan (dd/mm/yyyy)</span>
                        </div>
                    </div>
                    <div class="hero-search-inputs-group">
                        <div class="hero-search-input-wrap">
                            <input
                                type="date"
                                id="tanggalCekInput"
                                name="tanggal_cek"
                                class="hero-search-input"
                                min="{{ date('Y-m-d') }}"
                                value="{{ request()->filled('tanggal_cek') ? $selectedDate : '' }}"
                                required
                            >
                        </div>
                        <button type="submit" class="hero-search-btn">
                            <i data-lucide="search" style="width: 15px; height: 15px;"></i>
                            <span>Cek Slot Konseling</span>
                        </button>
                    </div>
                </form>

                {{-- Pesan Singkat Ketersediaan Slot (Hanya muncul jika siswa memilih tanggal dan menekan tombol Cek Slot Konseling) --}}
                @if (request()->filled('tanggal_cek'))
                    @php
                        $totalSlotCek = isset($slotDibuka) ? $slotDibuka->count() : 0;
                        $slotTersediaList = isset($slotDibuka) ? $slotDibuka->where('effective_status', 'Tersedia') : collect();
                        $slotTersediaCek = $slotTersediaList->count();
                        $slotDiajukanCek = isset($slotDibuka) ? $slotDibuka->whereIn('effective_status', ['Menunggu_Diproses', 'Dipesan'])->count() : 0;
                        $slotTidakTersediaCek = isset($slotDibuka) ? $slotDibuka->where('effective_status', 'Tidak_Tersedia')->count() : 0;
                        $formattedCekDate = \Carbon\Carbon::parse($selectedDate)->format('d/m/Y');
                    @endphp

                    <div class="hero-search-msg">
                        @if ($totalSlotCek === 0)
                            <p class="hero-search-msg-text text-warning">
                                Slot konseling belum tersedia pada tanggal {{ $formattedCekDate }}. Silakan pilih tanggal lain.
                            </p>
                        @elseif ($slotTersediaCek === 0 && $slotDiajukanCek > 0)
                            <p class="hero-search-msg-text text-orange">
                                Slot konseling pada tanggal {{ $formattedCekDate }} sudah diajukan oleh siswa lain. Silakan pilih tanggal lain.
                            </p>
                        @elseif ($slotTersediaCek === 0 && $slotTidakTersediaCek > 0)
                            <p class="hero-search-msg-text text-danger">
                                Slot konseling pada tanggal {{ $formattedCekDate }} sedang tidak tersedia (berbenturan dengan jadwal dinas/mengajar Guru BK). Silakan pilih tanggal lain.
                            </p>
                        @else
                            <p class="hero-search-msg-text text-success">
                                Tersedia {{ $slotTersediaCek }} slot konseling pada tanggal {{ $formattedCekDate }}:
                                @foreach ($slotTersediaList as $s)
                                    <strong>Pukul {{ substr($s->waktu_mulai, 0, 5) }} - {{ substr($s->waktu_selesai, 0, 5) }} WIB</strong> (Slot Kosong (Tersedia))@if(!$loop->last), @endif
                                @endforeach
                                &mdash; Silakan lanjutkan ke <a href="{{ route('portal.siswa.create', ['tanggal' => $selectedDate, 'id_slot' => $slotTersediaList->first()->id_slot ?? null]) }}" class="hero-search-msg-link">Izin Wali Kelas &rarr;</a>
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- -------------------------------------------------------------
         3. MAIN CONTENT
         ------------------------------------------------------------- --}}
    <main class="main-content">

        <section class="daily-row" aria-label="Check-in dan inspirasi harian">
            <div class="daily-card">
                <h2>🌤️ Pojok Mood Hari Ini</h2>
                <p>Pilih yang paling menggambarkan perasaanmu. Perasaanmu valid, apa pun itu.</p>
                <div class="mood-options" role="group" aria-label="Pilih suasana hati">
                    <button type="button" class="mood-option" data-message="Senang sekali! Semoga energi baikmu menular hari ini 😊" aria-pressed="false"><span>😄</span>Senang</button>
                    <button type="button" class="mood-option" data-message="Terima kasih sudah jujur pada perasaanmu. Nikmati satu hal kecil yang membuatmu nyaman 🌿" aria-pressed="false"><span>🙂</span>Biasa saja</button>
                    <button type="button" class="mood-option" data-message="Tidak apa-apa merasa sedih. Kamu boleh cerita pada orang dewasa yang kamu percaya 💙" aria-pressed="false"><span>😔</span>Sedih</button>
                    <button type="button" class="mood-option" data-message="Tarik napas pelan-pelan, ya. Kamu tidak harus menyelesaikan semuanya sekaligus 🌬️" aria-pressed="false"><span>😟</span>Cemas</button>
                </div>
                <p class="mood-response" id="moodResponse" aria-live="polite">Check-in ini hanya untuk dirimu sendiri.</p>
            </div>
            <article class="daily-card daily-tip">
                <span class="tip-label">TIPS KECIL HARI INI</span>
                <blockquote>“Langkah kecil yang kamu mulai hari ini tetap membawamu maju.”</blockquote>
                <p>Coba pecah tugas besar jadi bagian kecil, lalu beri jeda singkat setelah menyelesaikannya.</p>
            </article>
        </section>

        {{-- ---------------------------------------------------------
             B. BAGIAN AJAKAN UNTUK SISWA ("CERITA KAMU BERHARGA")
             --------------------------------------------------------- --}}
        <section class="empathy-section">
            {{-- Kolom Visual & Ilustrasi Hangat --}}
            <div class="empathy-visual-col">
                <div class="empathy-quote-tag">
                    <i data-lucide="sparkles" style="width: 13px; height: 13px;"></i>
                    <span>Ruang Aman untuk Siswa SMPN 2 Dramaga</span>
                </div>

                <div class="empathy-illustration-wrap">
                    {{-- Ilustrasi SVG Ramah & Hangat --}}
                    <svg width="210" height="150" viewBox="0 0 220 160" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="20" y="25" width="180" height="115" rx="22" fill="rgba(255,255,255,0.12)" stroke="rgba(255,255,255,0.35)" stroke-width="2"/>
                        <circle cx="78" cy="76" r="24" fill="#DBEAFE"/>
                        <path d="M70 73C70 73 73 78 78 78C83 78 86 73 86 73" stroke="#1E3A8A" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="71" cy="67" r="2.5" fill="#1E3A8A"/>
                        <circle cx="85" cy="67" r="2.5" fill="#1E3A8A"/>
                        <circle cx="144" cy="76" r="24" fill="#FEF3C7"/>
                        <path d="M136 73C136 73 139 78 144 78C149 78 152 73 152 73" stroke="#92400E" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="137" cy="67" r="2.5" fill="#92400E"/>
                        <circle cx="151" cy="67" r="2.5" fill="#92400E"/>
                        <path d="M111 44C106.5 39 99 39.5 96 45C93 39.5 85.5 39 81 44C76.5 49 79 57 96 67C113 57 115.5 49 111 44Z" fill="#F43F5E" transform="translate(15, -12) scale(0.95)"/>
                        <rect x="56" y="112" width="108" height="12" rx="6" fill="rgba(255,255,255,0.28)"/>
                    </svg>
                </div>

                <h3 class="empathy-visual-title">Cerita Kamu Berharga, Sekecil Apa Pun Itu</h3>
                <p class="empathy-visual-desc">
                    Ruang BK bukanlah tempat penghukuman. Guru BK hadir sebagai sahabat dan pendamping di sekolah agar kamu bisa belajar dengan hati yang tenang dan gembira.
                </p>
            </div>

            {{-- Kolom Pesan Sederhana untuk Siswa --}}
            <div class="empathy-text-col">
                <div>
                    <span class="section-tag" style="margin-bottom: 8px;">
                        <i data-lucide="smile" style="width: 13px; height: 13px;"></i>
                        Pesan untuk Kamu
                    </span>
                    <h2 class="empathy-heading">Tidak Apa-Apa Meminta Bantuan</h2>
                </div>

                <p class="empathy-lead">
                    Terkadang hari-hari di sekolah terasa membingungkan atau melelahkan. Kamu tidak perlu memendam semuanya sendirian. Berbicara dengan Guru BK adalah langkah berani untuk peduli pada dirimu sendiri.
                </p>

                <div class="empathy-points">
                    <div class="empathy-point-card">
                        <div class="empathy-point-icon">
                            <i data-lucide="hand-heart" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <h4>Boleh Meminta Bantuan</h4>
                            <p>Kamu selalu boleh meminta bantuan kapan saja ketika sedang menghadapi masalah atau kebingungan.</p>
                        </div>
                    </div>

                    <div class="empathy-point-card">
                        <div class="empathy-point-icon" style="background: #ecfdf5; color: #059669;">
                            <i data-lucide="messages-square" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <h4>Ceritakan Apa Saja</h4>
                            <p>Mulai dari kesulitan belajar, pertemanan, masalah pribadi, hingga rencana sekolah lanjutan di masa depan.</p>
                        </div>
                    </div>

                    <div class="empathy-point-card">
                        <div class="empathy-point-icon" style="background: #fff7ed; color: #d97706;">
                            <i data-lucide="sparkles" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <h4>Bukan Berarti Lemah</h4>
                            <p>Meminta bimbingan bukan berarti kamu lemah atau siswa bermasalah, melainkan tanda kamu ingin berkembang.</p>
                        </div>
                    </div>

                    <div class="empathy-point-card">
                        <div class="empathy-point-icon" style="background: #eef2ff; color: #4338ca;">
                            <i data-lucide="zap" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <h4>Tanpa Perlu Buat Akun</h4>
                            <p>Kamu dapat langsung mengajukan jadwal bimbingan melalui portal ini tanpa login dan tanpa menghafal NIS.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ---------------------------------------------------------
             C. BAGIAN LAYANAN BK (4 KARTU DALAM GRID)
             --------------------------------------------------------- --}}
        <section class="layanan-section" id="layanan">
            <div class="section-header">
                <span class="section-tag">
                    <i data-lucide="layers" style="width: 13px; height: 13px;"></i>
                    Bidang Layanan BK
                </span>
                <h2 class="section-title">Pilih Topik yang Ingin Kamu Ceritakan</h2>
                <p class="section-desc">
                    Empat bidang layanan Bimbingan dan Konseling yang siap mendampingi perjalananmu selama bersekolah di SMP Negeri 2 Dramaga.
                </p>
            </div>

            <div class="layanan-grid">
                {{-- 1. Bimbingan Pribadi --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: #eef2ff; color: #4338ca;">
                            <i data-lucide="smile" style="width: 27px; height: 27px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Pribadi</h3>
                        <p class="layanan-card-desc">
                            Membantumu mengenali diri sendiri, mengelola rasa cemas atau sedih, meningkatkan rasa percaya diri, dan membangun kebiasaan positif sehari-hari.
                        </p>
                    </div>
                    <a href="{{ route('portal.siswa.create', ['layanan' => 'Konseling Pribadi']) }}" class="layanan-btn-cta">
                        <span>Pilih Bimbingan Pribadi</span>
                        <i data-lucide="arrow-right" style="width: 15px; height: 15px;"></i>
                    </a>
                </div>

                {{-- 2. Bimbingan Sosial --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: #ecfdf5; color: #047857;">
                            <i data-lucide="users" style="width: 27px; height: 27px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Sosial</h3>
                        <p class="layanan-card-desc">
                            Membantumu menghadapi masalah pertemanan, beradaptasi di lingkungan kelas, serta berkomunikasi dengan lebih nyaman bersama teman, guru, dan keluarga.
                        </p>
                    </div>
                    <a href="{{ route('portal.siswa.create', ['layanan' => 'Konseling Sosial']) }}" class="layanan-btn-cta">
                        <span>Pilih Bimbingan Sosial</span>
                        <i data-lucide="arrow-right" style="width: 15px; height: 15px;"></i>
                    </a>
                </div>

                {{-- 3. Bimbingan Belajar --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: var(--primary-light); color: var(--primary);">
                            <i data-lucide="book-open" style="width: 27px; height: 27px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Belajar</h3>
                        <p class="layanan-card-desc">
                            Membantumu mengatasi kesulitan memahami pelajaran, mengatur waktu belajar, membangkitkan semangat belajar, dan menyiapkan diri menghadapi ujian.
                        </p>
                    </div>
                    <a href="{{ route('portal.siswa.create', ['layanan' => 'Konseling Belajar']) }}" class="layanan-btn-cta">
                        <span>Pilih Bimbingan Belajar</span>
                        <i data-lucide="arrow-right" style="width: 15px; height: 15px;"></i>
                    </a>
                </div>

                {{-- 4. Bimbingan Karier --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: #fff7ed; color: #c2410c;">
                            <i data-lucide="compass" style="width: 27px; height: 27px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Karier</h3>
                        <p class="layanan-card-desc">
                            Membantumu mengenali minat, bakat, dan cita-cita, serta merencanakan pilihan sekolah lanjutan setelah lulus SMP menuju SMA, SMK, atau MA.
                        </p>
                    </div>
                    <a href="{{ route('portal.siswa.create', ['layanan' => 'Bimbingan Karier']) }}" class="layanan-btn-cta">
                        <span>Pilih Bimbingan Karier</span>
                        <i data-lucide="arrow-right" style="width: 15px; height: 15px;"></i>
                    </a>
                </div>
            </div>
        </section>

        {{-- ---------------------------------------------------------
             D. PETUNJUK PENGGUNAAN PORTAL SISWA
             --------------------------------------------------------- --}}
        <section class="alur-section">
            <div class="section-header" style="margin-bottom: 12px;">
                <span class="section-tag">
                    <i data-lucide="route" style="width: 13px; height: 13px;"></i>
                    Petunjuk Penggunaan
                </span>
                <h2 class="section-title">Langkah Awal Menggunakan Layanan SIRASI-BK</h2>
                <p class="section-desc">
                    Ikuti langkah berikut untuk menggunakan layanan Portal Siswa dengan mudah.
                </p>
            </div>

            <div class="alur-steps-grid">
                <div class="step-card">
                    <div class="step-number-pill">1</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="book-open" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h4 class="step-title">Baca Informasi Layanan</h4>
                    <p class="step-desc">Baca informasi dan petunjuk penggunaan layanan sebelum mengajukan.</p>
                </div>
                <div class="step-card">
                    <div class="step-number-pill">2</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="user-check" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h4 class="step-title">Ajukan Izin Wali Kelas</h4>
                    <p class="step-desc">Buka menu <strong>Izin Wali Kelas</strong> jika perlu izin meninggalkan pelajaran.</p>
                </div>
                <div class="step-card">
                    <div class="step-number-pill">3</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="calendar-plus" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h4 class="step-title">Buka Jadwal Konseling</h4>
                    <p class="step-desc">Pilih menu <strong>Jadwal Konseling</strong> untuk mengajukan jadwal.</p>
                </div>
                <div class="step-card">
                    <div class="step-number-pill">4</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="users-round" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h4 class="step-title">Pilih Data Siswa</h4>
                    <p class="step-desc">Pilih kelas dan nama siswa sesuai data yang tersedia.</p>
                </div>
                <div class="step-card">
                    <div class="step-number-pill">5</div>
                    <div class="step-icon-wrap"><i data-lucide="calendar-check" style="width: 24px; height: 24px;"></i></div>
                    <h4 class="step-title">Pilih Keperluan dan Slot</h4>
                    <p class="step-desc">Pilih keperluan konseling dan slot jadwal yang telah dibuka Guru BK.</p>
                </div>
                <div class="step-card">
                    <div class="step-number-pill">6</div>
                    <div class="step-icon-wrap"><i data-lucide="send" style="width: 24px; height: 24px;"></i></div>
                    <h4 class="step-title">Lengkapi dan Kirim</h4>
                    <p class="step-desc">Isi keterangan tambahan jika diperlukan, kemudian kirim pengajuan.</p>
                </div>
                <div class="step-card">
                    <div class="step-number-pill">7</div>
                    <div class="step-icon-wrap"><i data-lucide="clipboard-check" style="width: 24px; height: 24px;"></i></div>
                    <h4 class="step-title">Cek Perkembangan</h4>
                    <p class="step-desc">Buka menu <strong>Cek Status</strong> untuk melihat perkembangan pengajuan.</p>
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
            <div class="footer-social-column text-left items-start justify-start">
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

        document.querySelectorAll('.mood-option').forEach(function (button) {
            button.addEventListener('click', function () {
                document.querySelectorAll('.mood-option').forEach(function (option) {
                    option.setAttribute('aria-pressed', option === button ? 'true' : 'false');
                });
                document.getElementById('moodResponse').textContent = button.dataset.message;
            });
        });

        // Helper sinkronisasi datepicker native dengan format dd/mm/yyyy pada search bar
    </script>
</body>

</html>
