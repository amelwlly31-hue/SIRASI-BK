<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Guru BK - SIRASI-BK</title>


    <script src="https://unpkg.com/lucide@latest"></script>

    @include('partials.theme')

    <style>
        /* ==========================================================================
           SIRASI-BK - DASHBOARD GURU BK MODERN & PROFESIONAL
           Sistem Informasi Bimbingan dan Konseling SMP Negeri 2 Dramaga
           ========================================================================== */

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Palette: Institutional Formal Educational (Navy, Sapphire, Slate, Warm Accents) */
            --brand-primary: #173b82;
            --brand-primary-dark: #0f2656;
            --brand-primary-light: #2563eb;
            --brand-primary-soft: #eff4fe;
            --brand-accent: #0284c7;

            --surface-bg: #f5f8fc;
            --surface-card: #ffffff;
            --surface-muted: #f8fafc;
            --surface-border: #e2e8f0;
            --surface-border-subtle: #edf2f7;

            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --text-light: #94a3b8;

            --status-success: #059669;
            --status-success-bg: #ecfdf5;
            --status-success-border: #a7f3d0;

            --status-info: #0284c7;
            --status-info-bg: #f0f9ff;
            --status-info-border: #bae6fd;

            --status-warning: #d97706;
            --status-warning-bg: #fffbeb;
            --status-warning-border: #fde68a;

            --status-danger: #e11d48;
            --status-danger-bg: #fff1f2;
            --status-danger-border: #fecdd3;

            /* Shadows & Elevation */
            --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-sm: 0 4px 12px rgba(17, 38, 86, 0.05);
            --shadow-md: 0 10px 25px rgba(17, 38, 86, 0.07);
            --shadow-lg: 0 18px 38px rgba(17, 38, 86, 0.10);
            --shadow-card-hover: 0 16px 32px rgba(23, 59, 130, 0.10);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-2xl: 24px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {

            background:
                radial-gradient(circle at 85% 0%, rgba(37, 99, 235, 0.06), transparent 32%),
                radial-gradient(circle at 10% 20%, rgba(14, 165, 233, 0.04), transparent 25%),
                var(--surface-bg);
            color: var(--text-body);
            line-height: 1.5;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, input, select {

        }

        /* --------------------------------------------------------------------------
           LAYOUT CORE
           -------------------------------------------------------------------------- */
        .app {
            display: flex;
            min-height: 100vh;
        }

        /* --------------------------------------------------------------------------
           SIDEBAR NAVIGATION & HOVER INDICATOR
           -------------------------------------------------------------------------- */
        .sidebar {
            width: 235px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 30;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 16px;
            background: linear-gradient(180deg, #163675 0%, #122c60 52%, #0d2149 100%);
            color: #ffffff;
            box-shadow: 6px 0 28px rgba(13, 33, 73, 0.16);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 6px 10px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.10);
            margin-bottom: 20px;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0.08));
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            overflow: hidden;
            padding: 4px;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
        }

        .brand-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff;
            line-height: 1.2;
        }

        .brand-subtitle {
            margin-top: 3px;
            color: #b5ccff;
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .brand-badge {
            display: inline-block;
            font-size: 9.5px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.15);
            color: #e0edff;
            padding: 2px 6px;
            border-radius: 4px;
            margin-top: 3px;
            align-self: flex-start;
            letter-spacing: 0.3px;
        }

        .menu-title {
            padding: 0 12px 10px;
            color: #9cbaff;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-item,
        .menu a {
            position: relative;
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 0 14px;
            border-radius: var(--radius-md);
            color: #d1e0ff;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.22s ease;
            border: 1px solid transparent;
            overflow: hidden;
        }

        /* Garis indikator tipis di bagian bawah nama menu saat hover */
        .menu-item::after,
        .menu a::after {
            content: "";
            position: absolute;
            left: 10px;
            right: 10px;
            bottom: 5px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, rgba(160, 195, 255, 0.85), transparent);
            transform: scaleX(0);
            opacity: 0;
            transition: transform 0.24s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.22s ease;
            pointer-events: none;
            z-index: 2;
        }

        .menu-item:hover,
        .menu a:hover {
            color: #ffffff;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.13), rgba(255, 255, 255, 0.06));
            border-color: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
            box-shadow: 0 4px 12px rgba(6, 22, 54, 0.12);
        }

        .menu-item:hover::after,
        .menu a:hover::after {
            transform: scaleX(1);
            opacity: 1;
        }

        /* Menu aktif (termasuk Dashboard saat aktif) */
        .menu-item.active,
        .menu a.active {
            color: #ffffff;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.20), rgba(255, 255, 255, 0.08));
            border-color: rgba(255, 255, 255, 0.18);
            box-shadow: inset 3.5px 0 0 #60a5fa, 0 6px 18px rgba(6, 22, 54, 0.15);
        }

        .menu-item.active::after,
        .menu a.active::after {
            transform: scaleX(1);
            opacity: 1;
            background: linear-gradient(90deg, transparent, rgba(160, 195, 255, 0.95), transparent);
        }

        .menu-item.active:hover,
        .menu a.active:hover {
            color: #ffffff;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.24), rgba(255, 255, 255, 0.10));
            box-shadow: inset 3.5px 0 0 #93c5fd, 0 8px 22px rgba(6, 22, 54, 0.18);
            transform: translateX(3px);
        }

        .menu-item.active:hover::after,
        .menu a.active:hover::after {
            transform: scaleX(1);
            opacity: 1;
        }

        .menu-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            background: rgba(255, 255, 255, 0.10);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .menu-icon > svg {
            width: 17px;
            height: 17px;
            stroke-width: 2;
        }

        .menu-item:hover .menu-icon {
            background: rgba(255, 255, 255, 0.20);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.18);
            transform: scale(1.05);
        }

        .menu-item.active .menu-icon {
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.24);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        .menu-label {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-bottom {
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.10);
            margin-top: auto;
        }

        .logout-button {
            width: 100%;
            border: 1px solid transparent;
            background: rgba(239, 68, 68, 0.10);
            color: #fca5a5;
            cursor: pointer;
            text-align: left;
            transition: all 0.2s ease;
            position: relative;
        }

        .logout-button::after {
            content: "";
            position: absolute;
            left: 10px;
            right: 10px;
            bottom: 5px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, rgba(252, 165, 165, 0.8), transparent);
            transform: scaleX(0);
            opacity: 0;
            transition: transform 0.24s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.22s ease;
            pointer-events: none;
        }

        .logout-button .menu-icon {
            background: rgba(239, 68, 68, 0.18);
            color: #fca5a5;
        }

        .logout-button:hover {
            color: #ffffff;
            background: rgba(239, 68, 68, 0.25);
            border-color: rgba(239, 68, 68, 0.35);
            transform: translateX(3px);
        }

        .logout-button:hover::after {
            transform: scaleX(1);
            opacity: 1;
        }

        .logout-button:hover .menu-icon {
            background: #ef4444;
            color: #ffffff;
        }

        /* --------------------------------------------------------------------------
           MAIN CONTENT AREA
           -------------------------------------------------------------------------- */
        .main {
            flex: 1;
            min-width: 0;
            width: auto;
            max-width: none;
            margin-left: 235px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --------------------------------------------------------------------------
           TOPBAR / NAVBAR
           -------------------------------------------------------------------------- */
        .header {
            height: 74px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--surface-border);
            position: sticky;
            top: 0;
            z-index: 25;
            box-shadow: 0 2px 14px rgba(15, 23, 42, 0.03);
        }

        .search-box {
            width: 440px;
            max-width: 100%;
            height: 42px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-md);
            background: #f8fafc;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-xs);
        }

        .search-box:focus-within {
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12), var(--shadow-sm);
        }

        .search-icon {
            margin-right: 12px;
            color: var(--text-light);
            display: flex;
            align-items: center;
        }

        .search-icon > svg {
            width: 18px;
            height: 18px;
        }

        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 13.5px;
            color: var(--text-heading);
            font-weight: 500;
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Notification Bell */
        .notification-wrapper {
            position: relative;
        }

        .notification {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            border: 1px solid var(--surface-border);
            background: #ffffff;
            color: var(--text-body);
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-xs);
        }

        .notification:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: var(--brand-primary);
            transform: translateY(-1px);
        }

        .notification > svg {
            width: 19px;
            height: 19px;
        }

        .notification-dot {
            position: absolute;
            top: 9px;
            right: 9px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #ef4444;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.3);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.6); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .notification-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            width: 360px;
            max-height: 440px;
            overflow-y: auto;
            background: #ffffff;
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            display: none;
            z-index: 1000;
            animation: dropdown-fade 0.2s ease-out;
        }

        @keyframes dropdown-fade {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
            border-bottom: 1px solid var(--surface-border-subtle);
            background: #fafcff;
        }

        .notification-header strong {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-heading);
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--surface-border-subtle);
            color: var(--text-body);
            transition: background 0.18s ease;
        }

        .notification-item:hover {
            background: #f1f6ff;
        }

        .notification-item-icon {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            background: var(--brand-primary-soft);
            color: var(--brand-primary);
        }

        .notification-item-icon > svg {
            width: 17px;
            height: 17px;
        }

        .notification-item-content {
            min-width: 0;
            flex: 1;
        }

        .notification-item-content strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-heading);
            line-height: 1.35;
        }

        .notification-item-content p {
            margin-top: 3px;
            color: var(--text-muted);
            font-size: 12px;
            line-height: 1.45;
        }

        .notification-item-content small {
            display: inline-block;
            margin-top: 6px;
            color: var(--text-light);
            font-size: 11px;
            font-weight: 500;
        }

        .notification-empty {
            padding: 36px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .notification-empty svg {
            width: 32px;
            height: 32px;
            color: var(--text-light);
            margin-bottom: 8px;
        }

        .notification-empty p {
            font-size: 13px;
            font-weight: 500;
        }

        /* Profile Block */
        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 14px;
            border-left: 1px solid var(--surface-border);
        }

        .profile-info {
            text-align: right;
        }

        .profile-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-heading);
            line-height: 1.3;
        }

        .profile-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
            padding: 1px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            background: var(--brand-primary-soft);
            color: var(--brand-primary);
            border: 1px solid rgba(37, 99, 235, 0.15);
        }

        .profile-photo {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            flex-shrink: 0;
            font-weight: 800;
            font-size: 15px;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo svg {
            width: 20px;
            height: 20px;
        }

        /* --------------------------------------------------------------------------
           MAIN CONTENT BODY
           -------------------------------------------------------------------------- */
        .content {
            padding: 28px 36px 44px;
            min-width: 0;
            max-width: 1600px;
            width: 100%;
            margin: 0 auto;
        }

        /* --------------------------------------------------------------------------
           HERO / WELCOME CARD (FOKUS UTAMA - RINGKAS, ELEGAN & SEIMBANG)
           Sapaan personal hangat, tanggal, ringkasan pengingat harian, tanpa teks panjang
           -------------------------------------------------------------------------- */
        .hero-welcome-card {
            position: relative;
            width: 100%;
            min-width: 0;
            overflow: hidden;
            border-radius: var(--radius-2xl);
            background: linear-gradient(135deg, #132e65 0%, #173b82 45%, #1e4ca6 100%);
            color: #ffffff;
            box-shadow: 0 16px 40px rgba(17, 43, 98, 0.16), 0 4px 12px rgba(17, 43, 98, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            margin-bottom: 26px;
            padding: 26px 32px;
            transition: box-shadow 0.3s ease;
        }

        .hero-welcome-card:hover {
            box-shadow: 0 20px 48px rgba(17, 43, 98, 0.22);
        }

        /* Decorative Abstract Geometric Accents */
        .hero-geometric-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .hero-circle-1 {
            position: absolute;
            width: 360px;
            height: 360px;
            right: -80px;
            top: -140px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.20) 0%, rgba(37, 99, 235, 0.04) 70%, transparent 80%);
        }

        .hero-circle-2 {
            position: absolute;
            width: 220px;
            height: 220px;
            right: 180px;
            bottom: -90px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.16) 0%, rgba(37, 99, 235, 0.02) 70%, transparent 80%);
        }

        .hero-pattern-dots {
            position: absolute;
            right: 25px;
            top: 25px;
            width: 140px;
            height: 140px;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1.5px, transparent 1.5px);
            background-size: 14px 14px;
            opacity: 0.75;
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .hero-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-school-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #dbeafe;
        }

        .hero-school-tag svg {
            width: 14px;
            height: 14px;
            color: #93c5fd;
        }

        .hero-date-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 4px 13px;
            border-radius: 9999px;
            background: rgba(15, 38, 86, 0.45);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            font-size: 12px;
            font-weight: 600;
            color: #e0edff;
        }

        .hero-date-badge svg {
            width: 14px;
            height: 14px;
            color: #60a5fa;
        }

        .hero-main-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-greeting {
            flex: 0 0 auto;
            min-width: 0;
        }

        .hero-greeting h1 {
            font-size: 26px;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.4px;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .hero-greeting h1 .wave-hand {
            display: inline-block;
            animation: wave-anim 2.5s infinite;
            transform-origin: 70% 70%;
        }

        @keyframes wave-anim {
            0% { transform: rotate( 0.0deg) }
            10% { transform: rotate(14.0deg) }
            20% { transform: rotate(-8.0deg) }
            30% { transform: rotate(14.0deg) }
            40% { transform: rotate(-4.0deg) }
            50% { transform: rotate(10.0deg) }
            60% { transform: rotate( 0.0deg) }
            100% { transform: rotate( 0.0deg) }
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            background: #ffffff;
            color: #173b82;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            transition: all 0.22s ease;
            cursor: pointer;
        }

        .btn-hero-primary svg {
            width: 16px;
            height: 16px;
            color: #173b82;
            stroke-width: 2.2;
        }

        .btn-hero-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.16);
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.24);
            transition: all 0.22s ease;
            cursor: pointer;
        }

        .btn-hero-secondary svg {
            width: 16px;
            height: 16px;
            color: #dbeafe;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.24);
            border-color: rgba(255, 255, 255, 0.40);
            transform: translateY(-2px);
        }

        /* Hero Daily Digest (Pill summary of activities) */
        .hero-digest-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
        }

        .hero-digest-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 13px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.10);
            transition: all 0.2s ease;
        }

        .hero-digest-item:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.20);
        }

        .hero-digest-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
            flex-shrink: 0;
        }

        .hero-digest-icon svg {
            width: 16px;
            height: 16px;
        }

        .hero-digest-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .hero-digest-val {
            font-size: 14.5px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .hero-digest-lbl {
            font-size: 11px;
            color: #bfdbfe;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* --------------------------------------------------------------------------
           STATISTICS CARDS (4 UNIFORM METRIC CARDS - RINGKAS & PROPORSIONAL)
           -------------------------------------------------------------------------- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 22px;
            align-items: stretch;
        }

        .stat-card-v2 {
            position: relative;
            background: var(--surface-card);
            border: 1px solid var(--surface-border);
            border-radius: 14px;
            padding: 13px 16px 12px;
            box-shadow: var(--shadow-xs);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 120px;
        }

        .stat-card-v2::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--card-accent, #2563eb);
            opacity: 0.95;
        }

        .stat-card-v2:hover {
            transform: translateY(-3px);
            border-color: #cbd5e1;
            box-shadow: var(--shadow-sm);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .stat-icon-wrapper {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: var(--icon-bg, #eff6ff);
            color: var(--icon-color, #2563eb);
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .stat-card-v2:hover .stat-icon-wrapper {
            transform: scale(1.06);
        }

        .stat-icon-wrapper svg {
            width: 20px;
            height: 20px;
            stroke-width: 2.1;
        }

        .stat-pill {
            font-size: 9.5px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 9999px;
            background: var(--pill-bg, #f1f5f9);
            color: var(--pill-color, #475569);
            letter-spacing: 0.25px;
            line-height: 1.2;
        }

        .stat-body {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .stat-metric-value {
            font-size: 23px;
            font-weight: 800;
            color: var(--text-heading);
            line-height: 1.15;
            letter-spacing: -0.3px;
            font-variant-numeric: tabular-nums;
        }

        .stat-metric-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-muted);
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat-footer {
            margin-top: 8px;
            padding-top: 7px;
            border-top: 1px solid var(--surface-border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 10.5px;
            color: var(--text-light);
            line-height: 1.2;
        }

        .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-weight: 600;
            color: var(--trend-color, #059669);
        }

        .stat-trend svg {
            width: 12px;
            height: 12px;
        }

        /* Card 1: Siswa Theme (Royal Blue) */
        .stat-theme-siswa {
            --card-accent: #2563eb;
            --icon-bg: #eff6ff;
            --icon-color: #2563eb;
            --pill-bg: #eff6ff;
            --pill-color: #1d4ed8;
            --trend-color: #2563eb;
        }

        /* Card 2: Total Konseling Theme (Indigo) */
        .stat-theme-konseling {
            --card-accent: #6366f1;
            --icon-bg: #eef2ff;
            --icon-color: #6366f1;
            --pill-bg: #eef2ff;
            --pill-color: #4338ca;
            --trend-color: #6366f1;
        }

        /* Card 3: Bulan Ini Theme (Emerald) */
        .stat-theme-bulan {
            --card-accent: #059669;
            --icon-bg: #ecfdf5;
            --icon-color: #059669;
            --pill-bg: #ecfdf5;
            --pill-color: #047857;
            --trend-color: #059669;
        }

        /* Card 4: Tindak Lanjut Theme (Amber) */
        .stat-theme-tindak {
            --card-accent: #d97706;
            --icon-bg: #fffbeb;
            --icon-color: #d97706;
            --pill-bg: #fffbeb;
            --pill-color: #b45309;
            --trend-color: #d97706;
        }

        /* --------------------------------------------------------------------------
           MAIN DASHBOARD CONTENT LAYOUT (RAPUH & SEIMBANG TANPA RUANG KOSONG)
           Baris 1: Riwayat Konseling (Kiri) & Konseling per Bulan (Kanan)
           Baris 2: Agenda & Penjadwalan BK (Full width atau split rapi jika ada atensi)
           -------------------------------------------------------------------------- */
        .dashboard-content-layout {
            display: flex;
            flex-direction: column;
            gap: 26px;
        }

        /* Baris 1: Riwayat Konseling & Grafik Bulanan berdampingan dengan seimbang */
        .dashboard-row-primary {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr);
            gap: 26px;
            align-items: stretch;
        }

        .dashboard-row-primary .card-panel {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .dashboard-row-primary .table-responsive-wrapper,
        .dashboard-row-primary .chart-container-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Baris 2: Penjadwalan BK & Siswa Perhatian */
        .dashboard-row-secondary.full-width {
            display: block;
            width: 100%;
        }

        .dashboard-row-secondary.has-attention {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr);
            gap: 26px;
            align-items: stretch;
        }

        /* --------------------------------------------------------------------------
           UNIVERSAL PANEL / CARD CONTAINERS
           -------------------------------------------------------------------------- */
        .card-panel {
            background: var(--surface-card);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: border-color 0.22s ease, box-shadow 0.22s ease;
        }

        .card-panel:hover {
            border-color: #cbd5e1;
            box-shadow: var(--shadow-md);
        }

        .card-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--surface-border-subtle);
            background: #ffffff;
            gap: 16px;
            flex-wrap: wrap;
        }

        .panel-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .panel-icon-badge {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            background: var(--brand-primary-soft);
            color: var(--brand-primary);
            flex-shrink: 0;
        }

        .panel-icon-badge svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.1;
        }

        .panel-titles {
            display: flex;
            flex-direction: column;
        }

        .panel-main-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: -0.2px;
        }

        .panel-subtitle-text {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .panel-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: var(--radius-md);
            background: #f1f5f9;
            color: var(--brand-primary);
            font-size: 12px;
            font-weight: 700;
            border: 1px solid var(--surface-border);
            transition: all 0.2s ease;
        }

        .panel-action-btn svg {
            width: 14px;
            height: 14px;
            transition: transform 0.2s ease;
        }

        .panel-action-btn:hover {
            background: var(--brand-primary);
            color: #ffffff;
            border-color: var(--brand-primary);
            box-shadow: 0 4px 12px rgba(23, 59, 130, 0.18);
        }

        .panel-action-btn:hover svg {
            transform: translateX(3px);
        }

        /* --------------------------------------------------------------------------
           DATA TABLES (RIWAYAT KONSELING & PENJADWALAN BK)
           -------------------------------------------------------------------------- */
        .table-responsive-wrapper {
            overflow-x: auto;
            width: 100%;
        }

        .dashboard-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
        }

        .dashboard-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 12px 18px;
            border-bottom: 1px solid var(--surface-border);
            white-space: nowrap;
        }

        .dashboard-table tbody tr {
            transition: background 0.16s ease;
        }

        .dashboard-table tbody tr:hover {
            background: #f8faff;
        }

        .dashboard-table tbody td {
            padding: 13px 18px;
            border-bottom: 1px solid var(--surface-border-subtle);
            font-size: 13px;
            color: var(--text-body);
            vertical-align: middle;
        }

        .dashboard-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Table Date Pill */
        .table-date {
            font-weight: 600;
            color: var(--text-heading);
            font-size: 12.5px;
            white-space: nowrap;
        }

        /* Table Student Cell */
        .student-cell {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .student-avatar-sm {
            width: 35px;
            height: 35px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
            border: 1px solid rgba(37, 99, 235, 0.15);
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
        }

        .student-meta {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .student-name-text {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-heading);
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }

        .student-sub-badge {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .class-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #334155;
            font-size: 11.5px;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .category-text {
            color: #334155;
            font-weight: 600;
            font-size: 12.5px;
        }

        .time-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-body);
            background: #f8fafc;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .time-pill svg {
            width: 12px;
            height: 12px;
            color: var(--text-muted);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.3;
            white-space: nowrap;
        }

        .status-badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-badge-success {
            background: var(--status-success-bg);
            color: var(--status-success);
            border: 1px solid var(--status-success-border);
        }

        .status-badge-process {
            background: var(--status-info-bg);
            color: var(--status-info);
            border: 1px solid var(--status-info-border);
        }

        .status-badge-warning {
            background: var(--status-warning-bg);
            color: var(--status-warning);
            border: 1px solid var(--status-warning-border);
        }

        .status-badge-danger {
            background: var(--status-danger-bg);
            color: var(--status-danger);
            border: 1px solid var(--status-danger-border);
        }

        /* Empty State */
        .table-empty-state {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-icon-box {
            width: 50px;
            height: 50px;
            margin: 0 auto 12px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-icon-box svg {
            width: 22px;
            height: 22px;
        }

        .empty-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 4px;
        }

        .empty-desc {
            font-size: 12px;
            color: var(--text-muted);
            max-width: 320px;
            margin: 0 auto;
        }

        /* --------------------------------------------------------------------------
           CHART / VISUALISASI DATA (KONSELING PER BULAN)
           -------------------------------------------------------------------------- */
        .chart-container-box {
            padding: 20px 22px 24px;
        }

        .chart-meta-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .chart-year-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            background: var(--brand-primary-soft);
            color: var(--brand-primary);
        }

        .chart-stat-summary {
            text-align: right;
        }

        .chart-stat-summary-val {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-heading);
            line-height: 1.2;
        }

        .chart-stat-summary-lbl {
            font-size: 11px;
            color: var(--text-muted);
        }

        .bar-chart-visual {
            height: 205px;
            display: flex;
            align-items: flex-end;
            gap: 9px;
            padding-bottom: 28px;
            border-bottom: 1px solid var(--surface-border-subtle);
            position: relative;
        }

        /* Horizontal reference lines */
        .chart-grid-line {
            position: absolute;
            left: 0;
            right: 0;
            border-top: 1px dashed #e2e8f0;
            pointer-events: none;
            z-index: 1;
        }

        .chart-grid-line.line-mid { bottom: 110px; }
        .chart-grid-line.line-top { bottom: 180px; }

        .chart-column {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .chart-bar-track {
            width: 100%;
            max-width: 24px;
            height: 100%;
            max-height: 160px;
            background: #f1f5f9;
            border-radius: 8px 8px 4px 4px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            position: relative;
            overflow: visible;
        }

        .chart-bar-fill {
            width: 100%;
            min-height: 4px;
            border-radius: 7px 7px 3px 3px;
            background: #cbd5e1;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .chart-bar-fill.active {
            background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .chart-bar-fill.is-current-month {
            background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%);
            border: 1.5px solid #ffffff;
            box-shadow: 0 0 0 2px #2563eb, 0 6px 14px rgba(37, 99, 235, 0.35);
        }

        .chart-bar-track:hover .chart-bar-fill {
            filter: brightness(1.1);
            transform: translateY(-2px);
        }

        .chart-tooltip-val {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 6px;
            font-size: 10.5px;
            font-weight: 800;
            color: #1e3a8a;
            background: #eff6ff;
            padding: 2px 5px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0.9;
            transition: opacity 0.2s ease;
        }

        .chart-month-name {
            position: absolute;
            bottom: -24px;
            font-size: 10px;
            font-weight: 600;
            color: var(--text-light);
            text-align: center;
            white-space: nowrap;
        }

        .chart-month-name.has-data {
            color: var(--text-body);
            font-weight: 700;
        }

        .chart-month-name.is-now {
            color: #2563eb;
            font-weight: 800;
        }

        /* --------------------------------------------------------------------------
           SISWA PERHATIAN KHUSUS PANEL
           -------------------------------------------------------------------------- */
        .attention-list {
            padding: 10px 18px 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .attention-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            border-radius: var(--radius-md);
            background: #fafcff;
            border: 1px solid var(--surface-border-subtle);
            transition: all 0.2s ease;
        }

        .attention-item:hover {
            background: #f1f6ff;
            border-color: #bfdbfe;
            transform: translateX(2px);
        }

        .attention-student {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .attention-avatar {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            background: #fee2e2;
            color: #b91c1c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12.5px;
            font-weight: 800;
            flex-shrink: 0;
            border: 1px solid #fca5a5;
        }

        .attention-info {
            display: flex;
            flex-direction: column;
        }

        .attention-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-heading);
            line-height: 1.3;
        }

        .attention-class {
            font-size: 11px;
            color: var(--text-muted);
        }

        .attention-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 9px;
            border-radius: 9999px;
            background: #fef2f2;
            color: #dc2626;
            font-size: 11px;
            font-weight: 700;
            border: 1px solid #fecaca;
        }

        .attention-count-badge svg {
            width: 12px;
            height: 12px;
        }

        /* --------------------------------------------------------------------------
           DARK MODE ADAPTATIONS
           -------------------------------------------------------------------------- */
        html.dark-mode body.dark-mode {
            --surface-bg: #0b1120;
            --surface-card: #131c31;
            --surface-muted: #1a253c;
            --surface-border: #23314f;
            --surface-border-subtle: #1c273e;

            --text-heading: #f1f5f9;
            --text-body: #cbd5e1;
            --text-muted: #94a3b8;
            --text-light: #64748b;

            background: #0b1120 !important;
            color: #cbd5e1 !important;
        }

        html.dark-mode body.dark-mode .sidebar {
            background: linear-gradient(180deg, #0e172a 0%, #0b1222 100%) !important;
            border-right-color: #1e293b !important;
        }

        html.dark-mode body.dark-mode .header {
            background: rgba(19, 28, 49, 0.90) !important;
            border-bottom-color: #23314f !important;
        }

        html.dark-mode body.dark-mode .search-box,
        html.dark-mode body.dark-mode .notification {
            background: #18233c !important;
            border-color: #2a3b5c !important;
            color: #e2e8f0 !important;
        }

        html.dark-mode body.dark-mode .search-box input {
            color: #f1f5f9 !important;
        }

        html.dark-mode body.dark-mode .notification-dropdown {
            background: #131c31 !important;
            border-color: #23314f !important;
        }

        html.dark-mode body.dark-mode .notification-header {
            background: #18233c !important;
            border-bottom-color: #23314f !important;
        }

        html.dark-mode body.dark-mode .notification-item:hover {
            background: #1a2742 !important;
        }

        html.dark-mode body.dark-mode .card-panel,
        html.dark-mode body.dark-mode .stat-card-v2 {
            background: #131c31 !important;
            border-color: #23314f !important;
        }

        html.dark-mode body.dark-mode .stat-card-v2:hover {
            border-color: #3b82f6 !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35) !important;
        }

        html.dark-mode body.dark-mode .stat-theme-siswa {
            --icon-bg: rgba(37, 99, 235, 0.18);
            --icon-color: #93c5fd;
            --pill-bg: rgba(37, 99, 235, 0.22);
            --pill-color: #93c5fd;
        }

        html.dark-mode body.dark-mode .stat-theme-konseling {
            --icon-bg: rgba(99, 102, 241, 0.18);
            --icon-color: #a5b4fc;
            --pill-bg: rgba(99, 102, 241, 0.22);
            --pill-color: #a5b4fc;
        }

        html.dark-mode body.dark-mode .stat-theme-bulan {
            --icon-bg: rgba(5, 150, 105, 0.18);
            --icon-color: #6ee7b7;
            --pill-bg: rgba(5, 150, 105, 0.22);
            --pill-color: #6ee7b7;
        }

        html.dark-mode body.dark-mode .stat-theme-tindak {
            --icon-bg: rgba(217, 119, 6, 0.18);
            --icon-color: #fcd34d;
            --pill-bg: rgba(217, 119, 6, 0.22);
            --pill-color: #fcd34d;
        }

        html.dark-mode body.dark-mode .card-panel-header {
            background: #131c31 !important;
            border-bottom-color: #23314f !important;
        }

        html.dark-mode body.dark-mode .panel-action-btn {
            background: #1a253c !important;
            border-color: #2a3b5c !important;
            color: #93c5fd !important;
        }

        html.dark-mode body.dark-mode .dashboard-table thead th {
            background: #18233c !important;
            color: #94a3b8 !important;
            border-bottom-color: #23314f !important;
        }

        html.dark-mode body.dark-mode .dashboard-table tbody tr:hover {
            background: #18253e !important;
        }

        html.dark-mode body.dark-mode .dashboard-table tbody td {
            border-bottom-color: #1e2c47 !important;
        }

        html.dark-mode body.dark-mode .class-pill,
        html.dark-mode body.dark-mode .time-pill {
            background: #1a253c !important;
            border-color: #2a3b5c !important;
            color: #cbd5e1 !important;
        }

        html.dark-mode body.dark-mode .attention-item {
            background: #18233c !important;
            border-color: #23314f !important;
        }

        html.dark-mode body.dark-mode .chart-bar-track {
            background: #1a253c !important;
        }

        html.dark-mode body.dark-mode .chart-grid-line {
            border-top-color: #23314f !important;
        }

        /* --------------------------------------------------------------------------
           RESPONSIVE BREAKPOINTS
           -------------------------------------------------------------------------- */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-row-primary,
            .dashboard-row-secondary.has-attention {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 76px;
                padding: 20px 10px;
            }

            .sidebar .brand-info,
            .sidebar .menu-title,
            .sidebar .menu-label,
            .sidebar .brand-badge {
                display: none !important;
            }

            .brand {
                justify-content: center;
                padding: 0 0 18px 0;
            }

            .brand-logo {
                width: 44px;
                height: 44px;
            }

            .menu-item {
                justify-content: center;
                padding: 0;
                min-height: 44px;
            }

            .main {
                margin-left: 76px;
            }

            .header {
                padding: 0 24px;
            }

            .content {
                padding: 22px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 16px;
                height: 68px;
            }

            .search-box {
                width: 220px;
            }

            .profile-info {
                display: none;
            }

            .content {
                padding: 16px;
            }

            .hero-welcome-card {
                padding: 22px 18px;
            }

            .hero-greeting h1 {
                font-size: 22px;
            }

            .hero-digest-bar {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
        }

        @media (max-width: 540px) {
            .search-box {
                display: none;
            }

            .hero-actions {
                width: 100%;
            }

            .btn-hero-primary,
            .btn-hero-secondary {
                width: 100%;
                justify-content: center;
            }
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .alert-success {
            background: #eaf8f0;
            color: #16894a;
            border: 1px solid #b8ebd0;
        }

        .alert-danger {
            background: #fff0f0;
            color: #d64545;
            border: 1px solid #ffccd0;
        }

        body.dark-mode .alert-success {
            background: #173b2b !important;
            color: #a7edc2 !important;
            border-color: #2b7250 !important;
        }

        body.dark-mode .alert-danger {
            background: #3c2028 !important;
            color: #ffd0d6 !important;
            border-color: #74414c !important;
        }
    </style>
    @if(auth()->check() && (auth()->user()->isGuruBK() || auth()->user()->peran === 'guru_bk'))
        <link rel="stylesheet" href="{{ asset('css/sirasi-guru-bk.css') }}?v=glass-cards-gurubk-20261031-1">
    @endif
</head>

<body>

<div class="app">

    {{-- =========================================================================
         SIDEBAR NAVIGATION
         ========================================================================= --}}
    @include('layouts.sidebar')

    {{-- =========================================================================
         MAIN APPLICATION AREA
         ========================================================================= --}}
    <main class="main">

        {{-- Topbar / Header --}}
        <header class="header" data-page-title="Dashboard">

            <div class="profile-area">

                {{-- Notifikasi --}}
                <div class="notification-wrapper">
                    <button
                        type="button"
                        class="notification"
                        id="notificationButton"
                        aria-label="Notifikasi"
                    >
                        <i data-lucide="bell"></i>
                        @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                            <span class="notification-dot" id="notificationDot"></span>
                        @endif
                    </button>

                    <div
                        class="notification-dropdown"
                        id="notificationDropdown"
                    >
                        <div class="notification-header">
                            <strong>Notifikasi & Pengingat</strong>
                            @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                                <span class="profile-role-badge">
                                    {{ $notifikasis->where('dibaca', false)->count() }} Baru
                                </span>
                            @endif
                        </div>

                        @forelse ($notifikasis ?? [] as $notifikasi)
                            <a
                                href="{{ route('notifikasi.baca', $notifikasi->id) }}"
                                class="notification-item {{ !$notifikasi->dibaca ? 'unread' : '' }}"
                            >
                                <div class="notification-item-icon">
                                    <i data-lucide="bell-ring"></i>
                                </div>
                                <div class="notification-item-content">
                                    <strong>{{ $notifikasi->judul }}</strong>
                                    <p>{{ preg_replace('/\s*\[JADWAL:\d+\]/', '', $notifikasi->pesan) }}</p>
                                    <small>{{ $notifikasi->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        @empty
                            <div class="notification-empty">
                                <i data-lucide="bell-off"></i>
                                <p>Belum ada notifikasi saat ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- User Profile Chip --}}
                <div class="profile">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->nama }}</div>
                        <div class="profile-role-badge">
                            <i data-lucide="shield-check" style="width: 12px; height: 12px;"></i>
                            Guru Bimbingan Konseling
                        </div>
                    </div>

                    <div class="profile-photo">
                        @if (auth()->user()->foto_profil)
                            <img
                                src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                alt="Foto Profil {{ auth()->user()->nama }}"
                            >
                        @else
                            {{ strtoupper(substr(auth()->user()->nama ?? 'G', 0, 1)) }}
                        @endif
                    </div>
                </div>

            </div>

        </header>

        {{-- Content Container --}}
        <section class="content">

            @if (session('success'))
                <div class="alert alert-success" role="status">
                    <i data-lucide="check-circle-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <i data-lucide="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- =================================================================
                 1. HERO / WELCOME CARD (FOKUS UTAMA)
                 ================================================================= --}}
            <div class="hero-welcome-card">
                {{-- Aksen Visual Geometris Dekoratif --}}
                <div class="hero-geometric-bg">
                    <div class="hero-circle-1"></div>
                    <div class="hero-circle-2"></div>
                    <div class="hero-pattern-dots"></div>
                </div>

                <div class="hero-inner">
                    {{-- Top Bar: Identitas Sekolah & Tanggal Hari Ini --}}
                    <div class="hero-top-bar">
                        <div class="hero-school-tag">
                            <i data-lucide="graduation-cap"></i>
                            SMP Negeri 2 Dramaga &bull; Layanan Konseling
                        </div>

                        <div class="hero-date-badge">
                            <i data-lucide="calendar"></i>
                            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </div>
                    </div>

                    {{-- Main Row: Sapaan Personal & Tombol Aksi Cepat --}}
                    <div class="hero-main-row">
                        <div class="hero-greeting">
                            <h1>
                                Selamat Datang, {{ auth()->user()->nama }}
                                <span class="wave-hand">👋</span>
                            </h1>
                        </div>

                        <div class="hero-actions">
                            <a href="{{ route('konseling.create') }}" class="btn-hero-primary">
                                <i data-lucide="clipboard-plus"></i>
                                Catat Konseling Baru
                            </a>
                            <a href="{{ route('siswa.create') }}" class="btn-hero-secondary">
                                <i data-lucide="user-plus"></i>
                                Tambah Data Siswa
                            </a>
                        </div>
                    </div>

                    {{-- Ringkasan Pengingat / Aktivitas Harian --}}
                    <div class="hero-digest-bar">
                        <div class="hero-digest-item">
                            <div class="hero-digest-icon">
                                <i data-lucide="calendar-clock"></i>
                            </div>
                            <div class="hero-digest-info">
                                <div class="hero-digest-val">{{ $jadwalBimbingan->count() }} Agenda</div>
                                <div class="hero-digest-lbl">Jadwal Bimbingan Terdekat</div>
                            </div>
                        </div>

                        <div class="hero-digest-item">
                            <div class="hero-digest-icon">
                                <i data-lucide="clipboard-check"></i>
                            </div>
                            <div class="hero-digest-info">
                                <div class="hero-digest-val">{{ $konselingBulanIni }} Sesi</div>
                                <div class="hero-digest-lbl">Konseling Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})</div>
                            </div>
                        </div>

                        <div class="hero-digest-item">
                            <div class="hero-digest-icon">
                                <i data-lucide="alert-circle"></i>
                            </div>
                            <div class="hero-digest-info">
                                <div class="hero-digest-val">{{ $siswaPerhatian->count() }} Siswa</div>
                                <div class="hero-digest-lbl">Perlu Pemantauan Khusus (≥ 3 Sesi)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =================================================================
                 2. STATISTIK CARDS (4 METRIK SERAGAM)
                 ================================================================= --}}
            <div class="stats-grid">

                {{-- Stat 1: Total Siswa --}}
                <div class="stat-card-v2 stat-theme-siswa">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <i data-lucide="users-round"></i>
                        </div>
                        <span class="stat-pill">DATA POKOK</span>
                    </div>
                    <div class="stat-body">
                        <div class="stat-metric-value">{{ number_format($totalSiswa, 0, ',', '.') }}</div>
                        <div class="stat-metric-label">Total Siswa Terdaftar</div>
                    </div>
                    <div class="stat-footer">
                        <span class="stat-trend">
                            <i data-lucide="check-circle-2"></i>
                            Aktif Terdata
                        </span>
                        <span>SMPN 2 Dramaga</span>
                    </div>
                </div>

                {{-- Stat 2: Total Konseling --}}
                <div class="stat-card-v2 stat-theme-konseling">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <i data-lucide="clipboard-list"></i>
                        </div>
                        <span class="stat-pill">AKUMULASI</span>
                    </div>
                    <div class="stat-body">
                        <div class="stat-metric-value">{{ number_format($totalKonseling, 0, ',', '.') }}</div>
                        <div class="stat-metric-label">Total Sesi Konseling</div>
                    </div>
                    <div class="stat-footer">
                        <span class="stat-trend">
                            <i data-lucide="history"></i>
                            Riwayat Lengkap
                        </span>
                        <span>Seluruh Periode</span>
                    </div>
                </div>

                {{-- Stat 3: Konseling Bulan Ini --}}
                <div class="stat-card-v2 stat-theme-bulan">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <i data-lucide="calendar-days"></i>
                        </div>
                        <span class="stat-pill">AKTIVITAS TERKINI</span>
                    </div>
                    <div class="stat-body">
                        <div class="stat-metric-value">{{ number_format($konselingBulanIni, 0, ',', '.') }}</div>
                        <div class="stat-metric-label">Konseling Bulan Ini</div>
                    </div>
                    <div class="stat-footer">
                        <span class="stat-trend">
                            <i data-lucide="trending-up"></i>
                            Periode Berjalan
                        </span>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                    </div>
                </div>

                {{-- Stat 4: Tindak Lanjut --}}
                <div class="stat-card-v2 stat-theme-tindak">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <i data-lucide="list-checks"></i>
                        </div>
                        <span class="stat-pill">MONITORING</span>
                    </div>
                    <div class="stat-body">
                        <div class="stat-metric-value">{{ number_format($totalTindakLanjut, 0, ',', '.') }}</div>
                        <div class="stat-metric-label">Total Tindak Lanjut</div>
                    </div>
                    <div class="stat-footer">
                        <span class="stat-trend">
                            <i data-lucide="shield-alert"></i>
                            Rencana Kasus
                        </span>
                        <span>Evaluasi Siswa</span>
                    </div>
                </div>

            </div>

            {{-- =================================================================
                 3. MAIN DASHBOARD CONTENT (BALANCED ROWS WITHOUT EMPTY SPACE)
                 ================================================================= --}}
            <div class="dashboard-content-layout">

                {{-- BARIS 1: Riwayat Konseling Terbaru (Kiri) & Konseling per Bulan (Kanan) --}}
                <div class="dashboard-row-primary">

                    {{-- Panel: Riwayat Konseling Terbaru --}}
                    <div class="card-panel">
                        <div class="card-panel-header">
                            <div class="panel-title-group">
                                <div class="panel-icon-badge">
                                    <i data-lucide="clipboard-list"></i>
                                </div>
                                <div class="panel-titles">
                                    <div class="panel-main-title">Riwayat Konseling Terbaru</div>
                                    <div class="panel-subtitle-text">5 aktivitas pencatatan konseling siswa terkini</div>
                                </div>
                            </div>

                            <a href="{{ route('konseling.index') }}" class="panel-action-btn">
                                Lihat Semua Konseling
                                <i data-lucide="arrow-right"></i>
                            </a>
                        </div>

                        <div class="table-responsive-wrapper">
                            <table class="dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Masalah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayatKonseling as $konseling)
                                        <tr>
                                            <td>
                                                <span class="table-date">
                                                    {{ \Carbon\Carbon::parse($konseling->tanggal)->translatedFormat('d M Y') }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="student-cell">
                                                    <div class="student-avatar-sm">
                                                        {{ strtoupper(substr($konseling->siswa->nama_siswa ?? 'S', 0, 1)) }}
                                                    </div>
                                                    <div class="student-meta">
                                                        <span class="student-name-text">
                                                            {{ $konseling->siswa->nama_siswa ?? '-' }}
                                                        </span>
                                                        <span class="student-sub-badge">
                                                            NISN: {{ $konseling->siswa->nisn ?? '-' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="class-pill">
                                                    {{ $konseling->siswa->kelas->nama_kelas ?? '-' }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="category-text">
                                                    {{ $konseling->jenisMasalah->nama_jenis ?? '-' }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($konseling->status === 'Selesai')
                                                    <span class="status-badge status-badge-success">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="status-badge status-badge-process">
                                                        {{ $konseling->status }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="table-empty-state">
                                                    <div class="empty-icon-box">
                                                        <i data-lucide="clipboard-x"></i>
                                                    </div>
                                                    <div class="empty-title">Belum Ada Riwayat Konseling</div>
                                                    <div class="empty-desc">
                                                        Data konseling siswa yang telah dicatat akan tampil di sini. Mulai tambahkan catatan konseling baru.
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Panel: Tren Konseling Bulanan (Visual Chart) --}}
                    <div class="card-panel">
                        <div class="card-panel-header">
                            <div class="panel-title-group">
                                <div class="panel-icon-badge">
                                    <i data-lucide="bar-chart-3"></i>
                                </div>
                                <div class="panel-titles">
                                    <div class="panel-main-title">Konseling per Bulan</div>
                                    <div class="panel-subtitle-text">Distribusi sesi tahun {{ \Carbon\Carbon::now()->year }}</div>
                                </div>
                            </div>

                            <span class="chart-year-badge">
                                <i data-lucide="calendar"></i>
                                Tahun {{ \Carbon\Carbon::now()->year }}
                            </span>
                        </div>

                        <div class="chart-container-box">
                            <div class="chart-meta-bar">
                                <div>
                                    <div class="chart-stat-summary-val">{{ $totalKonseling }}</div>
                                    <div class="chart-stat-summary-lbl">Total Konseling Terdata</div>
                                </div>
                                <div class="chart-stat-summary">
                                    <div class="chart-stat-summary-val">{{ $konselingBulanIni }}</div>
                                    <div class="chart-stat-summary-lbl">Sesi Bulan Berjalan</div>
                                </div>
                            </div>

                            @php
                                $namaBulan = [
                                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                    5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                    9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
                                ];
                                $dataPerBulan = $konselingPerBulan->keyBy('bulan');
                                $maksimal = max($dataPerBulan->max('jumlah') ?? 0, 1);
                                $currentMonthNum = \Carbon\Carbon::now()->month;
                            @endphp

                            <div class="bar-chart-visual">
                                {{-- Reference Grid Lines --}}
                                <div class="chart-grid-line line-mid"></div>
                                <div class="chart-grid-line line-top"></div>

                                @foreach ($namaBulan as $nomorBulan => $nama)
                                    @php
                                        $jumlah = $dataPerBulan->get($nomorBulan)->jumlah ?? 0;
                                        $tinggiPersen = $jumlah > 0 ? max(round(($jumlah / $maksimal) * 100), 10) : 4;
                                        $isCurrentMonth = ($nomorBulan === $currentMonthNum);
                                    @endphp

                                    <div class="chart-column">
                                        <div class="chart-bar-track" title="{{ $nama }}: {{ $jumlah }} Sesi">
                                            @if ($jumlah > 0)
                                                <span class="chart-tooltip-val">{{ $jumlah }}</span>
                                            @endif
                                            <div
                                                class="chart-bar-fill {{ $jumlah > 0 ? 'active' : '' }} {{ $isCurrentMonth ? 'is-current-month' : '' }}"
                                                style="height: {{ $tinggiPersen }}%;"
                                            ></div>
                                        </div>

                                        <span class="chart-month-name {{ $jumlah > 0 ? 'has-data' : '' }} {{ $isCurrentMonth ? 'is-now' : '' }}">
                                            {{ $nama }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                {{-- BARIS 2: Agenda & Penjadwalan BK (Full-width rapi atau split bersama atensi jika ada) --}}
                @if (isset($siswaPerhatian) && $siswaPerhatian->count() > 0)
                    <div class="dashboard-row-secondary has-attention">
                        {{-- Panel: Penjadwalan BK Terdekat --}}
                        <div class="card-panel">
                            <div class="card-panel-header">
                                <div class="panel-title-group">
                                    <div class="panel-icon-badge">
                                        <i data-lucide="calendar-clock"></i>
                                    </div>
                                    <div class="panel-titles">
                                        <div class="panel-main-title">Agenda & Penjadwalan BK</div>
                                        <div class="panel-subtitle-text">Jadwal bimbingan siswa terdekat yang perlu dikonfirmasi / dihadiri</div>
                                    </div>
                                </div>

                                <a href="{{ route('penjadwalan.index') }}" class="panel-action-btn">
                                    Kelola Jadwal
                                    <i data-lucide="arrow-right"></i>
                                </a>
                            </div>

                            <div class="table-responsive-wrapper">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Waktu</th>
                                            <th>Jenis Bimbingan</th>
                                            <th>Status Jadwal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jadwalBimbingan as $jadwal)
                                            <tr>
                                                <td>
                                                    <span class="table-date">
                                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="student-cell">
                                                        <div class="student-avatar-sm">
                                                            {{ strtoupper(substr($jadwal->siswa->nama_siswa ?? 'S', 0, 1)) }}
                                                        </div>
                                                        <div class="student-meta">
                                                            <span class="student-name-text">
                                                                {{ $jadwal->siswa->nama_siswa ?? '-' }}
                                                            </span>
                                                            <span class="student-sub-badge">
                                                                {{ $jadwal->kode_pengajuan ?? 'Bimbingan' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="class-pill">
                                                        {{ $jadwal->siswa->kelas->nama_kelas ?? '-' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="time-pill">
                                                        <i data-lucide="clock"></i>
                                                        {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="category-text">
                                                        {{ $jadwal->jenis_bimbingan }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($jadwal->status === 'Selesai')
                                                        <span class="status-badge status-badge-success">
                                                            Selesai
                                                        </span>
                                                    @elseif ($jadwal->status === 'Ditolak_Wali')
                                                        <span class="status-badge status-badge-danger">
                                                            Ditolak Wali Kelas
                                                        </span>
                                                    @elseif ($jadwal->status === 'Dibatalkan')
                                                        <span class="status-badge status-badge-danger">
                                                            Dibatalkan
                                                        </span>
                                                    @else
                                                        @php
                                                            $statusLabel = 'Terjadwal';
                                                            $badgeClass = 'status-badge-process';

                                                            if ($jadwal->status === 'Diajukan') {
                                                                $statusLabel = 'Menunggu Izin Wali Kelas';
                                                                $badgeClass = 'status-badge-warning';
                                                            } elseif ($jadwal->status === 'Disetujui_Wali') {
                                                                if (method_exists($jadwal, 'hasSubmittedSchedule') && $jadwal->hasSubmittedSchedule()) {
                                                                    $statusLabel = 'Izin Disetujui Wali (Menunggu Konfirmasi BK)';
                                                                    $badgeClass = 'status-badge-process';
                                                                } else {
                                                                    $statusLabel = 'Izin Disetujui Wali Kelas';
                                                                    $badgeClass = 'status-badge-process';
                                                                }
                                                            }
                                                        @endphp
                                                        <span class="status-badge {{ $badgeClass }}">
                                                            {{ $statusLabel }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <div class="table-empty-state">
                                                        <div class="empty-icon-box">
                                                            <i data-lucide="calendar-x"></i>
                                                        </div>
                                                        <div class="empty-title">Belum Ada Jadwal Bimbingan</div>
                                                        <div class="empty-desc">
                                                            Pengajuan jadwal dari siswa atau agenda bimbingan terdekat akan muncul di sini.
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Panel: Siswa Perlu Perhatian Khusus --}}
                        <div class="card-panel">
                            <div class="card-panel-header">
                                <div class="panel-title-group">
                                    <div class="panel-icon-badge" style="background: #fef2f2; color: #dc2626;">
                                        <i data-lucide="alert-triangle"></i>
                                    </div>
                                    <div class="panel-titles">
                                        <div class="panel-main-title">Perlu Perhatian Khusus</div>
                                        <div class="panel-subtitle-text">Siswa dengan frekuensi konseling tinggi (≥ 3 sesi)</div>
                                    </div>
                                </div>
                            </div>

                            <div class="attention-list">
                                @foreach ($siswaPerhatian as $perhatian)
                                    <div class="attention-item">
                                        <div class="attention-student">
                                            <div class="attention-avatar">
                                                {{ strtoupper(substr($perhatian->nama_siswa ?? 'S', 0, 1)) }}
                                            </div>
                                            <div class="attention-info">
                                                <a href="{{ route('siswa.show', $perhatian->id_siswa) }}" class="attention-name">
                                                    {{ $perhatian->nama_siswa }}
                                                </a>
                                                <span class="attention-class">
                                                    Kelas {{ $perhatian->kelas->nama_kelas ?? '-' }}
                                                </span>
                                            </div>
                                        </div>

                                        <span class="attention-count-badge">
                                            <i data-lucide="flame"></i>
                                            {{ $perhatian->konseling_count }} Sesi
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dashboard-row-secondary full-width">
                        {{-- Panel: Penjadwalan BK Terdekat (Full Width Membentang Rapi) --}}
                        <div class="card-panel">
                            <div class="card-panel-header">
                                <div class="panel-title-group">
                                    <div class="panel-icon-badge">
                                        <i data-lucide="calendar-clock"></i>
                                    </div>
                                    <div class="panel-titles">
                                        <div class="panel-main-title">Agenda & Penjadwalan BK</div>
                                        <div class="panel-subtitle-text">Jadwal bimbingan siswa terdekat yang perlu dikonfirmasi / dihadiri</div>
                                    </div>
                                </div>

                                <a href="{{ route('penjadwalan.index') }}" class="panel-action-btn">
                                    Kelola Jadwal
                                    <i data-lucide="arrow-right"></i>
                                </a>
                            </div>

                            <div class="table-responsive-wrapper">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Waktu</th>
                                            <th>Jenis Bimbingan</th>
                                            <th>Status Jadwal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jadwalBimbingan as $jadwal)
                                            <tr>
                                                <td>
                                                    <span class="table-date">
                                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="student-cell">
                                                        <div class="student-avatar-sm">
                                                            {{ strtoupper(substr($jadwal->siswa->nama_siswa ?? 'S', 0, 1)) }}
                                                        </div>
                                                        <div class="student-meta">
                                                            <span class="student-name-text">
                                                                {{ $jadwal->siswa->nama_siswa ?? '-' }}
                                                            </span>
                                                            <span class="student-sub-badge">
                                                                {{ $jadwal->kode_pengajuan ?? 'Bimbingan' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="class-pill">
                                                        {{ $jadwal->siswa->kelas->nama_kelas ?? '-' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="time-pill">
                                                        <i data-lucide="clock"></i>
                                                        {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="category-text">
                                                        {{ $jadwal->jenis_bimbingan }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($jadwal->status === 'Selesai')
                                                        <span class="status-badge status-badge-success">
                                                            Selesai
                                                        </span>
                                                    @elseif ($jadwal->status === 'Ditolak_Wali')
                                                        <span class="status-badge status-badge-danger">
                                                            Ditolak Wali Kelas
                                                        </span>
                                                    @elseif ($jadwal->status === 'Dibatalkan')
                                                        <span class="status-badge status-badge-danger">
                                                            Dibatalkan
                                                        </span>
                                                    @else
                                                        @php
                                                            $statusLabel = 'Terjadwal';
                                                            $badgeClass = 'status-badge-process';

                                                            if ($jadwal->status === 'Diajukan') {
                                                                $statusLabel = 'Menunggu Izin Wali Kelas';
                                                                $badgeClass = 'status-badge-warning';
                                                            } elseif ($jadwal->status === 'Disetujui_Wali') {
                                                                if (method_exists($jadwal, 'hasSubmittedSchedule') && $jadwal->hasSubmittedSchedule()) {
                                                                    $statusLabel = 'Izin Disetujui Wali (Menunggu Konfirmasi BK)';
                                                                    $badgeClass = 'status-badge-process';
                                                                } else {
                                                                    $statusLabel = 'Izin Disetujui Wali Kelas';
                                                                    $badgeClass = 'status-badge-process';
                                                                }
                                                            }
                                                        @endphp
                                                        <span class="status-badge {{ $badgeClass }}">
                                                            {{ $statusLabel }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <div class="table-empty-state">
                                                        <div class="empty-icon-box">
                                                            <i data-lucide="calendar-x"></i>
                                                        </div>
                                                        <div class="empty-title">Belum Ada Jadwal Bimbingan</div>
                                                        <div class="empty-desc">
                                                            Pengajuan jadwal dari siswa atau agenda bimbingan terdekat akan muncul di sini.
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </section>

    </main>

</div>

{{-- Lucide Icon Initializer & Dropdown Event Handler --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        const notificationButton = document.getElementById('notificationButton');
        const notificationDropdown = document.getElementById('notificationDropdown');

        if (notificationButton && notificationDropdown) {
            notificationButton.addEventListener('click', function (event) {
                event.stopPropagation();
                notificationDropdown.classList.toggle('show');
            const dot = document.getElementById('notificationDot') || document.querySelector('.notification-dot');
            if (dot) {
                dot.style.display = 'none';
                fetch('{{ route("notifikasi.markAllRead") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).catch(function () {});
            }
            });

            document.addEventListener('click', function (event) {
                if (
                    !notificationButton.contains(event.target) &&
                    !notificationDropdown.contains(event.target)
                ) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }
    });
</script>

</body>

</html>
