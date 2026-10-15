<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Siswa - SIRASI-BK SMP Negeri 2 Dramaga</title>

    @include('partials.theme')
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        :root {
            --primary: #173c91;
            --primary-dark: #102d70;
            --primary-light: #eaf0ff;
            --primary-soft: #f4f7ff;
            --primary-glow: rgba(23, 60, 145, 0.12);

            --bg: #f8fafc;
            --white: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;

            --green: #15803d;
            --green-bg: #dcfce7;
            --orange: #b45309;
            --orange-bg: #fef3c7;
            --red: #b91c1c;
            --red-bg: #fee2e2;

            --shadow-sm: 0 4px 12px rgba(16, 45, 112, 0.04);
            --shadow-md: 0 10px 25px rgba(16, 45, 112, 0.08);
            --shadow-lg: 0 18px 40px rgba(16, 45, 112, 0.12);
        }

        body {
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }

        /* -------------------------------------------------------------
           1. TOP HORIZONTAL NAVBAR (PORTAL SISWA - TANPA SIDEBAR)
           ------------------------------------------------------------- */
        .portal-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(16, 45, 112, 0.05);
            transition: all 0.3s ease;
        }

        .nav-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
            height: 74px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-main);
            flex-shrink: 0;
        }

        .brand-logo-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
            border: 1px solid rgba(23, 60, 145, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            box-shadow: var(--shadow-sm);
        }

        .brand-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-text-name {
            font-size: 19px;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .brand-text-badge {
            font-size: 11px;
            font-weight: 600;
            color: var(--primary);
            background: var(--primary-light);
            padding: 2px 8px;
            border-radius: 999px;
        }

        .brand-text-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Nav Menu Horizontal Links */
        .nav-menu-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-main);
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
            font-weight: 700;
        }

        /* Nav Actions (Right) */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .student-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-soft);
            border: 1px solid rgba(23, 60, 145, 0.2);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            color: var(--primary-dark);
            font-weight: 700;
        }

        .btn-nav-logout {
            background: transparent;
            border: 1px solid #cbd5e1;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-nav-logout:hover {
            border-color: var(--red);
            color: var(--red);
            background: var(--red-bg);
        }

        .btn-login-petugas {
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 4px 12px rgba(23, 60, 145, 0.2);
            transition: all 0.2s ease;
        }

        .btn-login-petugas:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(23, 60, 145, 0.3);
            color: #ffffff;
        }

        /* Mobile Hamburger Toggle */
        .nav-toggle-btn {
            display: none;
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 8px;
            color: var(--text-main);
            cursor: pointer;
        }

        /* -------------------------------------------------------------
           2. MAIN CONTENT WRAPPER
           ------------------------------------------------------------- */
        .main-content {
            flex: 1;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 24px 60px;
        }

        /* Flash Alerts */
        .alert-box {
            padding: 14px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .alert-success { background: var(--green-bg); border: 1px solid #bbf7d0; color: var(--green); }
        .alert-danger { background: var(--red-bg); border: 1px solid #fecaca; color: var(--red); }
        .alert-info { background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; }

        /* -------------------------------------------------------------
           3. HERO SECTION (PROFESIONAL LANDING PAGE DENGAN FOTO ASLI SEKOLAH)
           ------------------------------------------------------------- */
        .hero-section {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 48px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 48px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary) 0%, #38bdf8 100%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 40px;
            align-items: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-light);
            border: 1px solid rgba(23, 60, 145, 0.15);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.22;
            letter-spacing: -0.6px;
            color: var(--primary-dark);
            margin-bottom: 18px;
        }

        .hero-desc {
            font-size: 15.5px;
            line-height: 1.7;
            color: var(--text-muted);
            margin-bottom: 30px;
        }

        .hero-btn-group {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            padding: 13px 26px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            box-shadow: 0 6px 18px rgba(23, 60, 145, 0.25);
            transition: all 0.2s ease;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(23, 60, 145, 0.35);
            color: #ffffff;
        }

        .btn-hero-secondary {
            background: #ffffff;
            color: var(--primary-dark);
            border: 1.5px solid var(--border-color);
            font-size: 14.5px;
            font-weight: 700;
            padding: 13px 24px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            transition: all 0.2s ease;
        }

        .btn-hero-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-soft);
            transform: translateY(-2px);
        }

        /* Hero Highlights / Value Props */
        .hero-highlights {
            display: flex;
            gap: 20px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .highlight-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .highlight-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .highlight-text strong {
            display: block;
            font-size: 12.5px;
            color: var(--text-main);
        }

        .highlight-text span {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Hero Media / Authentic Photo */
        .hero-media-wrapper {
            position: relative;
        }

        .hero-photo-frame {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 3px solid #ffffff;
            aspect-ratio: 4/3;
            background: #e2e8f0;
        }

        .hero-photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .hero-photo-frame:hover img {
            transform: scale(1.03);
        }

        .photo-floating-badge {
            position: absolute;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(23, 60, 145, 0.12);
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-md);
            z-index: 2;
        }

        .photo-floating-badge.badge-top {
            top: 16px;
            left: 16px;
        }

        .photo-floating-badge.badge-bottom {
            bottom: 16px;
            right: 16px;
        }

        .badge-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .badge-icon.green {
            background: var(--green-bg);
            color: var(--green);
        }

        .badge-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .badge-sub {
            font-size: 10.5px;
            color: var(--text-muted);
        }

        /* -------------------------------------------------------------
           4. SECTION HEADERS
           ------------------------------------------------------------- */
        .section-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .section-tag {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1.2px;
            color: var(--primary);
            background: var(--primary-light);
            padding: 4px 14px;
            border-radius: 999px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.4px;
            margin-bottom: 10px;
        }

        .section-desc {
            font-size: 15px;
            color: var(--text-muted);
            max-width: 680px;
            margin: 0 auto;
        }

        /* -------------------------------------------------------------
           5. SECTION LAYANAN BK (GRID 4 KARTU)
           ------------------------------------------------------------- */
        .layanan-section {
            margin-bottom: 56px;
        }

        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .layanan-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 28px 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .layanan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: transparent;
            transition: background 0.2s ease;
        }

        .layanan-card:hover {
            transform: translateY(-5px);
            border-color: rgba(23, 60, 145, 0.3);
            box-shadow: var(--shadow-md);
        }

        .layanan-card:hover::before {
            background: var(--primary);
        }

        .layanan-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .layanan-card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .layanan-card-desc {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 22px;
            flex-grow: 1;
        }

        .layanan-btn-cta {
            background: var(--primary-soft);
            color: var(--primary);
            border: 1px solid rgba(23, 60, 145, 0.15);
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .layanan-btn-cta:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        /* -------------------------------------------------------------
           6. SECTION ALUR PENGAJUAN (5 LANGKAH VISUAL MUDAH DIPAHAMI)
           ------------------------------------------------------------- */
        .alur-section {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 22px;
            padding: 44px 36px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 56px;
        }

        .alur-steps-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 18px;
            margin-top: 32px;
            position: relative;
        }

        .step-card {
            background: var(--primary-soft);
            border: 1px solid rgba(23, 60, 145, 0.08);
            border-radius: 16px;
            padding: 24px 18px;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.2s ease;
        }

        .step-card:hover {
            transform: translateY(-3px);
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .step-number-pill {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary);
            color: #ffffff;
            font-size: 15px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 4px 10px rgba(23, 60, 145, 0.25);
        }

        .step-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #ffffff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .step-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 6px;
            line-height: 1.35;
        }

        .step-desc {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* -------------------------------------------------------------
           7. AJAKAN / CALL TO ACTION BANNER
           ------------------------------------------------------------- */
        .ajakan-banner {
            background: linear-gradient(135deg, #102d70 0%, #173c91 60%, #2563eb 100%);
            border-radius: 22px;
            padding: 44px 38px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            box-shadow: var(--shadow-md);
            margin-bottom: 56px;
            flex-wrap: wrap;
        }

        .ajakan-text h3 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.3px;
            margin-bottom: 8px;
        }

        .ajakan-text p {
            font-size: 14.5px;
            color: #dbeafe;
            max-width: 620px;
            line-height: 1.6;
        }

        .btn-ajakan-action {
            background: #ffffff;
            color: var(--primary-dark);
            font-size: 14.5px;
            font-weight: 700;
            padding: 13px 26px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.16);
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-ajakan-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
            color: var(--primary);
        }

        /* -------------------------------------------------------------
           8. SECTION FORMULIR / STATUS / VERIFIKASI NIS
           ------------------------------------------------------------- */
        .verification-anchor-card {
            background: var(--white);
            border-radius: 22px;
            border: 2px solid rgba(23, 60, 145, 0.15);
            box-shadow: var(--shadow-md);
            padding: 44px 36px;
            max-width: 600px;
            margin: 0 auto 56px;
            text-align: center;
            position: relative;
        }

        .verification-icon-wrap {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 6px 16px rgba(23, 60, 145, 0.1);
        }

        .verification-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .verification-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .form-group-nis {
            text-align: left;
            margin-bottom: 22px;
        }

        .form-group-nis label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .nis-input-field {
            width: 100%;
            padding: 14px 18px;
            font-size: 15px;
            font-family: inherit;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .nis-input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(23, 60, 145, 0.12);
        }

        .btn-submit-nis {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            border: none;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 16px rgba(23, 60, 145, 0.22);
            transition: all 0.2s ease;
        }

        .btn-submit-nis:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(23, 60, 145, 0.3);
        }

        .nis-helper-info {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.5;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Mode Siswa Terverifikasi */
        .student-profile-bar {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px 30px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .student-profile-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .student-avatar-badge {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(23, 60, 145, 0.2);
        }

        .student-details h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.3px;
            margin-bottom: 4px;
        }

        .student-meta-pills {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            color: var(--text-muted);
            flex-wrap: wrap;
        }

        .student-meta-pills strong {
            color: var(--text-main);
        }

        .wali-kelas-badge {
            background: var(--primary-light);
            border: 1px solid rgba(23, 60, 145, 0.15);
            padding: 10px 18px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--primary-dark);
        }

        .portal-workspace-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            margin-bottom: 56px;
        }

        .workspace-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 28px;
            box-shadow: var(--shadow-sm);
        }

        .workspace-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 18px;
            margin-bottom: 22px;
            border-bottom: 1px solid var(--border-color);
        }

        .workspace-card-header h3 {
            font-size: 17px;
            font-weight: 800;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .slot-checker-box {
            background: var(--primary-soft);
            border: 1px solid rgba(23, 60, 145, 0.12);
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 22px;
        }

        .slot-checker-form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .busy-slot-item {
            background: #ffffff;
            border: 1px solid #fed7aa;
            border-left: 4px solid var(--orange);
            padding: 8px 12px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .input-group-item {
            margin-bottom: 18px;
        }

        .input-group-item label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .input-group-item label span {
            color: var(--red);
        }

        .form-field {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .form-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 60, 145, 0.1);
        }

        .btn-submit-ajukan {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            border: none;
            padding: 13px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(23, 60, 145, 0.2);
            transition: all 0.2s ease;
        }

        .btn-submit-ajukan:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(23, 60, 145, 0.28);
        }

        /* Status Timeline Cards */
        .status-timeline-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
        }

        .status-timeline-card:hover {
            border-color: rgba(23, 60, 145, 0.25);
            box-shadow: var(--shadow-sm);
        }

        .status-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .status-date {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge {
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
            text-transform: capitalize;
        }

        .status-Diajukan { background: var(--orange-bg); color: var(--orange); border: 1px solid #fde68a; }
        .status-Disetujui_Wali { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }
        .status-Terjadwal { background: var(--green-bg); color: var(--green); border: 1px solid #bbf7d0; }
        .status-Selesai { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .status-Ditolak_Wali, .status-Dibatalkan { background: var(--red-bg); color: var(--red); border: 1px solid #fecaca; }

        .status-time {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-service {
            font-size: 13.5px;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .status-note-bubble {
            background: #f8fafc;
            border-left: 3px solid var(--primary);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12.5px;
            color: var(--text-muted);
            margin-bottom: 10px;
            font-style: italic;
        }

        .wali-feedback-bubble {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #14532d;
            margin-top: 8px;
        }

        .wali-feedback-bubble.rejected {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        /* -------------------------------------------------------------
           9. SECTION TENTANG
           ------------------------------------------------------------- */
        .tentang-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 22px;
            padding: 40px 36px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 40px;
        }

        .tentang-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 24px;
        }

        .tentang-item {
            background: var(--primary-soft);
            border: 1px solid rgba(23, 60, 145, 0.08);
            border-radius: 16px;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .tentang-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #ffffff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }

        .tentang-item h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .tentang-item p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* -------------------------------------------------------------
           10. FOOTER
           ------------------------------------------------------------- */
        .portal-footer {
            background: #0d1e4a;
            color: #ffffff;
            padding: 48px 24px 28px;
            margin-top: auto;
        }

        .footer-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            padding-bottom: 24px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-brand h4 {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.2px;
        }

        .footer-brand p {
            font-size: 12px;
            color: #94a3b8;
        }

        .footer-links {
            display: flex;
            align-items: center;
            gap: 18px;
            list-style: none;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            max-width: 1240px;
            margin: 20px auto 0;
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }

        /* -------------------------------------------------------------
           RESPONSIVE STYLES
           ------------------------------------------------------------- */
        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; gap: 32px; }
            .layanan-grid { grid-template-columns: repeat(2, 1fr); }
            .alur-steps-grid { grid-template-columns: repeat(3, 1fr); }
            .tentang-grid { grid-template-columns: 1fr; }
            .portal-workspace-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .nav-menu-links {
                display: none;
                position: absolute;
                top: 74px;
                left: 0;
                right: 0;
                background: #ffffff;
                border-bottom: 1px solid var(--border-color);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
                flex-direction: column;
                padding: 16px 24px;
                gap: 8px;
            }

            .nav-menu-links.show {
                display: flex;
            }

            .nav-toggle-btn {
                display: block;
            }

            .hero-section {
                padding: 32px 20px;
            }

            .hero-title {
                font-size: 28px;
            }

            .layanan-grid {
                grid-template-columns: 1fr;
            }

            .alur-steps-grid {
                grid-template-columns: 1fr;
            }

            .student-profile-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .ajakan-banner {
                flex-direction: column;
                align-items: flex-start;
                padding: 32px 24px;
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    {{-- -------------------------------------------------------------
         1. TOP HORIZONTAL NAVBAR (KHUSUS PORTAL SISWA - TANPA SIDEBAR)
         ------------------------------------------------------------- --}}
    <header class="portal-navbar">
        <div class="nav-container">
            {{-- Brand Logo & Name --}}
            <a href="{{ route('portal.siswa.index') }}" class="nav-brand">
                <div class="brand-logo-wrap">
                    <img src="{{ asset('images/logo-smpn2-dramaga.png') }}?v=2" alt="Logo SMP Negeri 2 Dramaga">
                </div>
                <div>
                    <div class="brand-text-name">
                        SIRASI-BK
                        <span class="brand-text-badge">Siswa</span>
                    </div>
                    <div class="brand-text-sub">SMP Negeri 2 Dramaga</div>
                </div>
            </a>

            {{-- Horizontal Navigation Links --}}
            <nav>
                <ul class="nav-menu-links" id="portalNavMenu">
                    <li>
                        <a href="#beranda" class="nav-link active">
                            <i data-lucide="home" style="width: 15px; height: 15px;"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="#ajukan-bimbingan" class="nav-link" onclick="handleLayananClick('ajukan')">
                            <i data-lucide="calendar-plus" style="width: 15px; height: 15px;"></i>
                            Ajukan Bimbingan
                        </a>
                    </li>
                    <li>
                        <a href="#status-pengajuan" class="nav-link" onclick="handleLayananClick('status')">
                            <i data-lucide="clipboard-list" style="width: 15px; height: 15px;"></i>
                            Cek Status Pengajuan
                        </a>
                    </li>
                    <li>
                        <a href="#tentang" class="nav-link">
                            <i data-lucide="info" style="width: 15px; height: 15px;"></i>
                            Tentang
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Right Actions --}}
            <div class="nav-actions">
                @if ($siswa)
                    {{-- Sesi Siswa Aktif Terverifikasi --}}
                    <span class="student-chip" title="Siswa Terverifikasi: {{ $siswa->nama_siswa }}">
                        <i data-lucide="user-check" style="width: 15px; height: 15px; color: var(--primary);"></i>
                        <span>{{ Str::limit($siswa->nama_siswa, 15) }} ({{ $siswa->nis }})</span>
                    </span>

                    <form action="{{ route('portal.siswa.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-nav-logout" title="Keluar dari sesi portal siswa">
                            <i data-lucide="log-out" style="width: 14px; height: 14px;"></i>
                            Keluar
                        </button>
                    </form>
                @endif

                {{-- Tautan Login Petugas (Admin, Guru BK, Wali Kelas) --}}
                <a href="{{ route('login') }}" class="btn-login-petugas" title="Halaman Masuk Khusus Petugas / Guru / Staf">
                    <i data-lucide="shield" style="width: 15px; height: 15px;"></i>
                    Login Petugas
                </a>

                {{-- Mobile Hamburger Button --}}
                <button type="button" class="nav-toggle-btn" id="mobileNavToggle" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width: 20px; height: 20px;"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- -------------------------------------------------------------
         2. MAIN CONTENT
         ------------------------------------------------------------- --}}
    <main class="main-content">

        {{-- Flash Notification Alerts --}}
        @if (session('success'))
            <div class="alert-box alert-success">
                <i data-lucide="check-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-box alert-danger">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (session('info'))
            <div class="alert-box alert-info">
                <i data-lucide="info" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('info') }}</div>
            </div>
        @endif

        {{-- ---------------------------------------------------------
             SECTION A: HERO SECTION (INSPIRASI LANDING PAGE PROFESIONAL)
             --------------------------------------------------------- --}}
        <section class="hero-section" id="beranda">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-badge">
                        <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                        <span>Layanan Bimbingan & Konseling Terpadu SMP Negeri 2 Dramaga</span>
                    </div>

                    <h1 class="hero-title">
                        Temukan Solusi dan Kembangkan Potensi Dirimu
                    </h1>

                    <p class="hero-desc">
                        Layanan Bimbingan dan Konseling di SMP Negeri 2 Dramaga hadir sebagai ruang aman, nyaman, dan terpercaya bagi setiap siswa untuk berkonsultasi, menemukan solusi atas tantangan belajar maupun pribadi, serta merencanakan masa depan dengan percaya diri bersama Guru BK.
                    </p>

                    <div class="hero-btn-group">
                        <a href="#ajukan-bimbingan" class="btn-hero-primary" onclick="handleLayananClick('ajukan')">
                            <i data-lucide="calendar-plus" style="width: 18px; height: 18px;"></i>
                            <span>Ajukan Bimbingan</span>
                        </a>

                        <a href="#status-pengajuan" class="btn-hero-secondary" onclick="handleLayananClick('status')">
                            <i data-lucide="clipboard-list" style="width: 18px; height: 18px;"></i>
                            <span>Cek Status Pengajuan</span>
                        </a>
                    </div>

                    <div class="hero-highlights">
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i data-lucide="shield-check" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div class="highlight-text">
                                <strong>100% Rahasia</strong>
                                <span>Privasi Dijamin Kode Etik</span>
                            </div>
                        </div>

                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i data-lucide="user-check" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div class="highlight-text">
                                <strong>Izin Wali Kelas</strong>
                                <span>Koordinasi Jam Belajar</span>
                            </div>
                        </div>

                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i data-lucide="clock" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div class="highlight-text">
                                <strong>Jadwal Fleksibel</strong>
                                <span>Bebas Antre & Pasti</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hero Media: Foto Asli Gedung SMP Negeri 2 Dramaga --}}
                <div class="hero-media-wrapper">
                    <div class="hero-photo-frame">
                        <img
                            src="{{ asset('images/gedung-smpn2-dramaga-3.jpg') }}"
                            alt="Gedung Utama SMP Negeri 2 Dramaga"
                            loading="lazy"
                        >

                        <div class="photo-floating-badge badge-top">
                            <div class="badge-icon">
                                <i data-lucide="school" style="width: 16px; height: 16px;"></i>
                            </div>
                            <div>
                                <div class="badge-label">SMP Negeri 2 Dramaga</div>
                                <div class="badge-sub">Kampus Babakan Dramaga</div>
                            </div>
                        </div>

                        <div class="photo-floating-badge badge-bottom">
                            <div class="badge-icon green">
                                <i data-lucide="heart-handshake" style="width: 16px; height: 16px;"></i>
                            </div>
                            <div>
                                <div class="badge-label">Ruang Bimbingan Konseling</div>
                                <div class="badge-sub">Layanan Ramah Siswa</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ---------------------------------------------------------
             SECTION B: BAGIAN LAYANAN BK (SUSUNAN KARTU GRID)
             --------------------------------------------------------- --}}
        <section class="layanan-section" id="layanan">
            <div class="section-header">
                <span class="section-tag">Bidang Layanan</span>
                <h2 class="section-title">Layanan Bimbingan Konseling yang Tersedia</h2>
                <p class="section-desc">
                    Pilihlah bidang layanan konseling yang sesuai dengan kebutuhan, tantangan, atau perencanaan yang ingin kamu konsultasikan bersama Guru BK.
                </p>
            </div>

            <div class="layanan-grid">
                {{-- 1. Bimbingan Pribadi --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: #eef2ff; color: #4338ca;">
                            <i data-lucide="smile" style="width: 26px; height: 26px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Pribadi</h3>
                        <p class="layanan-card-desc">
                            Membantu mengelola emosi, kecemasan, rasa percaya diri, pembentukan kebiasaan positif, dan pemahaman potensi diri agar kamu tumbuh menjadi pribadi yang tangguh.
                        </p>
                    </div>
                    <button type="button" class="layanan-btn-cta" onclick="handleLayananClick('ajukan', 'Konseling Pribadi')">
                        <span>Pilih Layanan Ini</span>
                        <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>

                {{-- 2. Bimbingan Sosial --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: #ecfdf5; color: #047857;">
                            <i data-lucide="users" style="width: 26px; height: 26px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Sosial</h3>
                        <p class="layanan-card-desc">
                            Membantu mengatasi permasalahan pertemanan di sekolah, adaptasi di kelas baru, komunikasi dengan guru maupun keluarga, serta penyelesaian kesalahpahaman.
                        </p>
                    </div>
                    <button type="button" class="layanan-btn-cta" onclick="handleLayananClick('ajukan', 'Konseling Sosial')">
                        <span>Pilih Layanan Ini</span>
                        <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>

                {{-- 3. Bimbingan Belajar --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: var(--primary-light); color: var(--primary);">
                            <i data-lucide="book-open" style="width: 26px; height: 26px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Belajar</h3>
                        <p class="layanan-card-desc">
                            Membantu mengatasi kesulitan belajar, kejenuhan, manajemen waktu antara belajar dan kegiatan sekolah, serta strategi belajar efektif menjelang ujian.
                        </p>
                    </div>
                    <button type="button" class="layanan-btn-cta" onclick="handleLayananClick('ajukan', 'Konseling Belajar')">
                        <span>Pilih Layanan Ini</span>
                        <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>

                {{-- 4. Bimbingan Karier --}}
                <div class="layanan-card">
                    <div>
                        <div class="layanan-icon-wrap" style="background: #fff7ed; color: #c2410c;">
                            <i data-lucide="compass" style="width: 26px; height: 26px;"></i>
                        </div>
                        <h3 class="layanan-card-title">Bimbingan Karier</h3>
                        <p class="layanan-card-desc">
                            Membimbing eksplorasi bakat, minat, dan cita-cita, serta memberikan wawasan dalam merencanakan pilihan sekolah lanjutan ke jenjang SMA, SMK, atau MA.
                        </p>
                    </div>
                    <button type="button" class="layanan-btn-cta" onclick="handleLayananClick('ajukan', 'Bimbingan Karier')">
                        <span>Pilih Layanan Ini</span>
                        <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>
            </div>
        </section>

        {{-- ---------------------------------------------------------
             SECTION C: BAGIAN ALUR PENGAJUAN (5 LANGKAH MUDAH DIPAHAMI)
             --------------------------------------------------------- --}}
        <section class="alur-section">
            <div class="section-header" style="margin-bottom: 20px;">
                <span class="section-tag">Alur Pengajuan</span>
                <h2 class="section-title">5 Langkah Alur Pengajuan Konseling Siswa</h2>
                <p class="section-desc">
                    Proses pengajuan terstruktur dan terintegrasi dengan koordinasi Wali Kelas serta penetapan jadwal resmi oleh Guru BK.
                </p>
            </div>

            <div class="alur-steps-grid">
                {{-- Langkah 1 --}}
                <div class="step-card">
                    <div class="step-number-pill">1</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="user-check" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4 class="step-title">Verifikasi Identitas</h4>
                    <p class="step-desc">Siswa memasukkan NIS untuk verifikasi identitas dan data kelas binaan.</p>
                </div>

                {{-- Langkah 2 --}}
                <div class="step-card">
                    <div class="step-number-pill">2</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="calendar-plus" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4 class="step-title">Ajukan Bimbingan</h4>
                    <p class="step-desc">Siswa mengajukan bimbingan konseling dan memilih waktu serta topik bimbingan.</p>
                </div>

                {{-- Langkah 3 --}}
                <div class="step-card">
                    <div class="step-number-pill">3</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="check-square" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4 class="step-title">Pemeriksaan Wali Kelas</h4>
                    <p class="step-desc">Wali Kelas memeriksa dan menyetujui atau menolak pengajuan bimbingan.</p>
                </div>

                {{-- Langkah 4 --}}
                <div class="step-card">
                    <div class="step-number-pill">4</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="calendar-clock" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4 class="step-title">Penyesuaian Jadwal BK</h4>
                    <p class="step-desc">Guru BK menyesuaikan jadwal berdasarkan ketersediaan dan jadwal siswa.</p>
                </div>

                {{-- Langkah 5 --}}
                <div class="step-card">
                    <div class="step-number-pill">5</div>
                    <div class="step-icon-wrap">
                        <i data-lucide="bell" style="width: 22px; height: 22px;"></i>
                    </div>
                    <h4 class="step-title">Lihat Status & Jadwal</h4>
                    <p class="step-desc">Siswa melihat status dan jadwal bimbingan resmi secara transparan di portal.</p>
                </div>
            </div>
        </section>

        {{-- ---------------------------------------------------------
             SECTION D: BAGIAN AJAKAN (CALL TO ACTION BANNER)
             --------------------------------------------------------- --}}
        <section class="ajakan-banner">
            <div class="ajakan-text">
                <h3>Jangan Ragu untuk Memulai Langkah Pertamamu!</h3>
                <p>
                    Setiap tantangan dan kesulitan yang kamu hadapi memiliki jalan keluar. Guru BK SMP Negeri 2 Dramaga selalu siap mendengarkan, mendampingi, dan membantumu tumbuh menjadi pribadi yang lebih baik.
                </p>
            </div>
            <a href="#ajukan-bimbingan" class="btn-ajakan-action" onclick="handleLayananClick('ajukan')">
                <i data-lucide="send" style="width: 17px; height: 17px;"></i>
                <span>Ajukan Konseling Sekarang</span>
            </a>
        </section>

        {{-- ---------------------------------------------------------
             SECTION E: AREA LAYANAN (FORM PENGAJUAN / STATUS / NIS)
             --------------------------------------------------------- --}}
        @if (!$siswa)
            {{-- MODE BELUM VERIFIKASI: SISWA DIMINTA MEMASUKKAN NIS KETIKA MEMILIH LAYANAN --}}
            <section id="ajukan-bimbingan">
                <div class="verification-anchor-card" id="verifikasi-identitas">
                    <div class="verification-icon-wrap">
                        <i data-lucide="user-check" style="width: 34px; height: 34px;"></i>
                    </div>

                    <h2 class="verification-title">Masuk Portal Pengajuan Siswa</h2>

                    <p class="verification-subtitle" id="verificationInstructionText">
                        Untuk mengajukan jadwal bimbingan konseling mandiri atau memeriksa perkembangan status pengajuan bimbingan Anda,
                        silakan verifikasi identitas terlebih dahulu menggunakan Nomor Induk Siswa (NIS) Anda.
                    </p>

                    <form action="{{ route('portal.siswa.login') }}" method="POST">
                        @csrf
                        <div class="form-group-nis">
                            <label for="nisInput">Nomor Induk Siswa (NIS)</label>
                            <input
                                type="text"
                                id="nisInput"
                                name="nis"
                                class="nis-input-field"
                                placeholder="Contoh: 70701"
                                value="{{ old('nis') }}"
                                required
                            >
                            @error('nis')
                                <div style="color: var(--red); font-size: 12.5px; margin-top: 6px; font-weight: 600;">
                                    <i data-lucide="alert-circle" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit-nis">
                            <i data-lucide="arrow-right" style="width: 17px; height: 17px;"></i>
                            Lanjutkan ke Portal
                        </button>
                    </form>

                    <div class="nis-helper-info">
                        <i data-lucide="help-circle" style="width: 15px; height: 15px; color: var(--primary);"></i>
                        <span>Belum tahu NIS Anda? Silakan hubungi Wali Kelas atau petugas TU SMP Negeri 2 Dramaga.</span>
                    </div>
                </div>
            </section>
            {{-- Dummy anchor agar tautan status tetap mengarah ke sini jika belum login --}}
            <div id="status-pengajuan" style="position: relative; top: -60px;"></div>

        @else
            {{-- MODE TERVERIFIKASI: TAMPILKAN PROFIL SISWA, FORM AJUKAN, & STATUS PENGAJUAN --}}
            <div class="student-profile-bar">
                <div class="student-profile-left">
                    <div class="student-avatar-badge">
                        {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                    </div>
                    <div class="student-details">
                        <h2>{{ $siswa->nama_siswa }}</h2>
                        <div class="student-meta-pills">
                            <span>NIS: <strong>{{ $siswa->nis }}</strong></span>
                            <span>•</span>
                            <span>Kelas: <strong>{{ $siswa->kelas->nama_kelas ?? '-' }}</strong></span>
                            <span>•</span>
                            <span>Status: <strong style="color: var(--green);">{{ $siswa->status }}</strong></span>
                        </div>
                    </div>
                </div>

                <div class="wali-kelas-badge">
                    <i data-lucide="user-check" style="width: 18px; height: 18px; color: var(--primary);"></i>
                    <div>
                        <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--text-muted);">Wali Kelas Binaan</div>
                        <strong style="color: var(--primary-dark);">{{ $siswa->kelas->waliKelas->nama ?? '(Belum Ditugaskan)' }}</strong>
                    </div>
                </div>
            </div>

            {{-- Workspace Grid: Kiri (Ajukan), Kanan (Status) --}}
            <div class="portal-workspace-grid">

                {{-- KOLOM KIRI: AJUKAN JADWAL BIMBINGAN --}}
                <div class="workspace-card" id="ajukan-bimbingan">
                    <div class="workspace-card-header">
                        <h3>
                            <i data-lucide="calendar-plus" style="width: 20px; height: 20px; color: var(--primary);"></i>
                            Ajukan Jadwal Bimbingan Konseling
                        </h3>
                    </div>

                    {{-- Cek Ketersediaan Slot Guru BK --}}
                    <div class="slot-checker-box">
                        <div style="font-size: 12px; font-weight: 700; color: var(--primary-dark); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                            <i data-lucide="search" style="width: 14px; height: 14px;"></i>
                            Cek Ketersediaan Slot Waktu Guru BK:
                        </div>

                        <form method="GET" action="{{ route('portal.siswa.index') }}#ajukan-bimbingan" class="slot-checker-form">
                            <div style="flex: 1;">
                                <input
                                    type="date"
                                    name="tanggal"
                                    value="{{ $selectedDate }}"
                                    class="form-field"
                                    style="padding: 8px 12px; font-size: 13px;"
                                >
                            </div>
                            <button type="submit" class="btn-submit-ajukan" style="width: auto; padding: 8px 16px; font-size: 13px;">
                                Cek Tanggal
                            </button>
                        </form>

                        @if ($jadwalTerisi->count() > 0)
                            <div style="margin-top: 12px;">
                                <div style="font-size: 11.5px; font-weight: 700; color: var(--orange); margin-bottom: 6px;">
                                    ⚠️ Slot waktu yang sudah terisi Guru BK pada tanggal ini:
                                </div>
                                @foreach ($jadwalTerisi as $slot)
                                    <div class="busy-slot-item">
                                        <span><strong>{{ substr($slot->waktu_mulai, 0, 5) }} - {{ substr($slot->waktu_selesai, 0, 5) }} WIB</strong> ({{ $slot->jenis_bimbingan }})</span>
                                        <span style="font-size: 11px; font-weight: 700; color: var(--orange);">{{ str_replace('_', ' ', $slot->status) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="margin-top: 10px; font-size: 12.5px; color: var(--green); display: flex; align-items: center; gap: 6px; font-weight: 600;">
                                <i data-lucide="check-circle" style="width: 15px; height: 15px;"></i>
                                Belum ada jadwal terisi pada tanggal ini. Seluruh slot jam masih bebas!
                            </div>
                        @endif
                    </div>

                    {{-- Form Ajukan Konseling --}}
                    <form action="{{ route('portal.siswa.ajukan') }}" method="POST">
                        @csrf
                        <div class="input-group-item">
                            <label for="tanggalInput">Tanggal Bimbingan <span>*</span></label>
                            <input
                                type="date"
                                id="tanggalInput"
                                name="tanggal"
                                class="form-field"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('tanggal', $selectedDate) }}"
                                required
                            >
                            @error('tanggal')
                                <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row-2">
                            <div class="input-group-item">
                                <label for="waktuMulaiInput">Jam Mulai <span>*</span></label>
                                <input
                                    type="time"
                                    id="waktuMulaiInput"
                                    name="waktu_mulai"
                                    class="form-field"
                                    value="{{ old('waktu_mulai', '08:30') }}"
                                    required
                                >
                                @error('waktu_mulai')
                                    <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group-item">
                                <label for="waktuSelesaiInput">Jam Selesai <span>*</span></label>
                                <input
                                    type="time"
                                    id="waktuSelesaiInput"
                                    name="waktu_selesai"
                                    class="form-field"
                                    value="{{ old('waktu_selesai', '09:15') }}"
                                    required
                                >
                                @error('waktu_selesai')
                                    <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="input-group-item">
                            <label for="jenisBimbinganSelect">Jenis Layanan Bimbingan <span>*</span></label>
                            <select id="jenisBimbinganSelect" name="jenis_bimbingan" class="form-field" required>
                                <option value="">-- Pilih Jenis Bimbingan --</option>
                                <option value="Konseling Belajar" {{ old('jenis_bimbingan') == 'Konseling Belajar' ? 'selected' : '' }}>Konseling Belajar</option>
                                <option value="Konseling Pribadi" {{ old('jenis_bimbingan') == 'Konseling Pribadi' ? 'selected' : '' }}>Konseling Pribadi</option>
                                <option value="Konseling Sosial" {{ old('jenis_bimbingan') == 'Konseling Sosial' ? 'selected' : '' }}>Konseling Sosial</option>
                                <option value="Bimbingan Karier" {{ old('jenis_bimbingan') == 'Bimbingan Karier' ? 'selected' : '' }}>Bimbingan Karier</option>
                                <option value="Konseling Individu" {{ old('jenis_bimbingan') == 'Konseling Individu' ? 'selected' : '' }}>Konseling Individu</option>
                            </select>
                            @error('jenis_bimbingan')
                                <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group-item">
                            <label for="catatanInput">Alasan / Catatan Pengajuan (Opsional)</label>
                            <textarea
                                id="catatanInput"
                                name="catatan"
                                class="form-field"
                                rows="3"
                                placeholder="Tuliskan secara singkat topik yang ingin Anda bicarakan dengan Guru BK..."
                            >{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit-ajukan">
                            <i data-lucide="send" style="width: 16px; height: 16px;"></i>
                            Kirim Pengajuan Bimbingan
                        </button>
                    </form>
                </div>

                {{-- KOLOM KANAN: STATUS PENGAJUAN SAYA --}}
                <div class="workspace-card" id="status-pengajuan">
                    <div class="workspace-card-header">
                        <h3>
                            <i data-lucide="history" style="width: 20px; height: 20px; color: var(--primary);"></i>
                            Status Pengajuan Konseling Saya
                        </h3>
                        <span style="font-size: 12.5px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 3px 10px; border-radius: 999px;">
                            Total: {{ $pengajuan->count() }}
                        </span>
                    </div>

                    @forelse ($pengajuan as $item)
                        <div class="status-timeline-card">
                            <div class="status-top-bar">
                                <div class="status-date">
                                    <i data-lucide="calendar" style="width: 15px; height: 15px; color: var(--primary);"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                </div>
                                <span class="status-badge status-{{ $item->status }}">
                                    @if ($item->status === 'Diajukan')
                                        Menunggu Wali Kelas
                                    @elseif ($item->status === 'Disetujui_Wali')
                                        Disetujui Wali Kelas
                                    @elseif ($item->status === 'Ditolak_Wali')
                                        Ditolak Wali Kelas
                                    @else
                                        {{ $item->status }}
                                    @endif
                                </span>
                            </div>

                            <div class="status-time">
                                <i data-lucide="clock" style="width: 14px; height: 14px;"></i>
                                Pukul {{ substr($item->waktu_mulai, 0, 5) }} - {{ substr($item->waktu_selesai, 0, 5) }} WIB
                            </div>

                            <div class="status-service">
                                Layanan: <strong>{{ $item->jenis_bimbingan }}</strong>
                            </div>

                            @if (!empty($item->catatan))
                                <div class="status-note-bubble">
                                    "{{ $item->catatan }}"
                                </div>
                            @endif

                            {{-- Catatan respon Wali Kelas --}}
                            @if (!empty($item->id_wali) || !empty($item->catatan_wali))
                                <div class="wali-feedback-bubble {{ $item->status === 'Ditolak_Wali' ? 'rejected' : '' }}">
                                    <strong>Respon Wali Kelas ({{ $item->waliKelas->nama ?? 'Wali Kelas' }}):</strong>
                                    <div style="margin-top: 3px;">
                                        @if ($item->status === 'Ditolak_Wali')
                                            Alasan Penolakan: <em>"{{ $item->catatan_wali }}"</em>
                                        @else
                                            Catatan: <em>"{{ $item->catatan_wali ?: 'Disetujui untuk mengikuti sesi bimbingan konseling.' }}"</em>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--text-muted); padding: 48px 20px;">
                            <i data-lucide="calendar-x" style="width: 44px; height: 44px; margin: 0 auto 12px; display: block; opacity: 0.4;"></i>
                            <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">Belum Ada Riwayat Pengajuan</h4>
                            <p style="font-size: 13px;">Gunakan formulir di sebelah kiri untuk mengajukan jadwal konsultasi pertama Anda dengan Guru BK.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        @endif

        {{-- ---------------------------------------------------------
             SECTION F: TENTANG LAYANAN BK SMPN 2 DRAMAGA
             --------------------------------------------------------- --}}
        <section class="tentang-card" id="tentang">
            <div class="section-header" style="margin-bottom: 24px;">
                <span class="section-tag">Tentang Layanan</span>
                <h2 class="section-title">Bimbingan Konseling SMP Negeri 2 Dramaga</h2>
                <p class="section-desc">
                    Komitmen kami adalah menciptakan iklim sekolah yang kondusif, inklusif, dan ramah anak demi perkembangan akademik dan pembentukan karakter mulia siswa.
                </p>
            </div>

            <div class="tentang-grid">
                <div class="tentang-item">
                    <div class="tentang-icon">
                        <i data-lucide="shield-check" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h4>Asas Kerahasiaan (Confidentiality)</h4>
                    <p>
                        Setiap cerita, konsultasi, dan catatan kasus konseling dijaga kerahasiaannya oleh Guru BK sesuai kode etik profesi Bimbingan dan Konseling.
                    </p>
                </div>

                <div class="tentang-item">
                    <div class="tentang-icon" style="color: var(--green);">
                        <i data-lucide="clock" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h4>Jam Operasional Layanan</h4>
                    <p>
                        Layanan tatap muka di Ruang BK buka setiap hari kerja sekolah: <strong>Senin s.d. Jumat</strong> pukul <strong>07.30 - 15.00 WIB</strong>.
                    </p>
                </div>

                <div class="tentang-item">
                    <div class="tentang-icon" style="color: var(--orange);">
                        <i data-lucide="map-pin" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h4>Lokasi Ruang BK</h4>
                    <p>
                        Gedung Utama Lantai 1, SMP Negeri 2 Dramaga, Jalan Raya Dramaga KM. 07, Desa Dramaga, Kabupaten Bogor. Ruang konsultasi yang tenang, sejuk, dan ramah siswa.
                    </p>
                </div>
            </div>
        </section>

    </main>

    {{-- -------------------------------------------------------------
         11. FOOTER
         ------------------------------------------------------------- --}}
    <footer class="portal-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="brand-logo-wrap" style="background: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);">
                    <img src="{{ asset('images/logo-smpn2-dramaga.png') }}?v=2" alt="Logo SMP Negeri 2 Dramaga">
                </div>
                <div>
                    <h4>SIRASI-BK SMP Negeri 2 Dramaga</h4>
                    <p>Sistem Informasi Riwayat Administrasi dan Penjadwalan Bimbingan Konseling</p>
                </div>
            </div>

            <ul class="footer-links">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#layanan">Layanan BK</a></li>
                <li><a href="#ajukan-bimbingan" onclick="handleLayananClick('ajukan')">Ajukan Bimbingan</a></li>
                <li><a href="#status-pengajuan" onclick="handleLayananClick('status')">Cek Status</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="{{ route('login') }}" style="color: #93c5fd; font-weight: 700;">Login Petugas</a></li>
            </ul>
        </div>

        <div class="footer-bottom">
            &copy; {{ date('Y') }} SMP Negeri 2 Dramaga, Kabupaten Bogor. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </footer>

    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();

        // Mobile Nav Toggle
        const mobileToggle = document.getElementById('mobileNavToggle');
        const navMenu = document.getElementById('portalNavMenu');
        if (mobileToggle && navMenu) {
            mobileToggle.addEventListener('click', function () {
                navMenu.classList.toggle('show');
            });
        }

        // Active link tracking on scroll
        const sections = document.querySelectorAll('section[id], div[id="ajukan-bimbingan"]');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', function () {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 120;
                if (pageYOffset >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Handler saat siswa memilih layanan (Ajukan atau Status)
        function handleLayananClick(type, serviceName) {
            const nisInput = document.getElementById('nisInput');
            const targetSection = document.getElementById('verifikasi-identitas');
            const jenisSelect = document.getElementById('jenisBimbinganSelect');

            if (nisInput && targetSection) {
                // Siswa belum verifikasi NIS -> Arahkan ke form verifikasi dengan fokus
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    nisInput.focus();
                    if (serviceName) {
                        const instruction = document.getElementById('verificationInstructionText');
                        if (instruction) {
                            instruction.innerHTML = `Anda memilih <strong>${serviceName}</strong>. Silakan masukkan <strong>Nomor Induk Siswa (NIS)</strong> Anda terlebih dahulu untuk melanjutkan pengajuan.`;
                        }
                    }
                }, 400);
            } else if (jenisSelect && serviceName) {
                // Siswa sudah login -> Isi otomatis jenis bimbingan yang dipilih
                jenisSelect.value = serviceName;
                const formSection = document.getElementById('ajukan-bimbingan');
                if (formSection) {
                    formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }
    </script>
</body>

</html>
