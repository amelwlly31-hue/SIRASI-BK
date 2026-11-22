<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIRASI-BK</title>

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #173c91;
            --primary-dark: #102d70;
            --primary-light: #eaf0ff;
            --primary-soft: #f3f6ff;
            --bg: #f5f7fb;
            --white: #ffffff;
            --text: #172033;
            --muted: #737b8c;
            --border: #e7eaf0;
            --green: #159447;
            --green-bg: #e9f8ef;
            --orange: #d98218;
            --orange-bg: #fff4e3;
            --red: #d64545;
            --red-bg: #fff0f0;
            --shadow-sm: 0 4px 14px rgba(23, 60, 145, .05);
            --shadow-md: 0 12px 30px rgba(23, 60, 145, .08);
            --shadow-lg: 0 20px 45px rgba(23, 60, 145, .12);
        }

        body {
            margin: 0;

            background: radial-gradient(circle at 85% 0%, rgba(41, 67, 143, .08), transparent 28%), #f5f7fb;
            color: var(--text);
            min-height: 100vh;
        }

        a { text-decoration: none; }
        button, input {  }

        .app {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 235px;
            min-width: 235px;
            flex: 0 0 235px;
            --sirasi-active-tab-bleed: 20px;
            background: linear-gradient(180deg, #102d70 0%, #173c91 100%);
            color: var(--white);
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: sticky;
            top: 0;
            height: 100vh;
            box-shadow: 4px 0 24px rgba(16, 45, 112, .12);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            margin-bottom: 24px;
        }

        .brand-logo img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .brand-subtitle {
            font-size: 11px;
            color: rgba(255, 255, 255, .75);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 12px;
            padding-left: 12px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: rgba(255, 255, 255, .82);
            font-size: 14px;
            font-weight: 500;
            transition: all .2s ease;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255, 255, 255, .15);
            color: var(--white);
        }

        .menu-item.active {
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        }

        .menu-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }

        .sidebar-bottom {
            border-top: 1px solid rgba(255, 255, 255, .12);
            padding-top: 16px;
        }

        .logout-button {
            color: #ff9b9b !important;
        }

        .logout-button:hover {
            background: rgba(214, 69, 69, .2) !important;
            color: #ffffff !important;
        }

        /* Main Content */
        .main {
            flex: 1 1 auto;
            min-width: 0;
            width: auto;
            max-width: none;
            margin-left: 235px;
            padding: 28px 36px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            padding: 18px 24px;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .header-title h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .header-title p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-info {
            text-align: right;
        }

        .profile-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .profile-role {
            font-size: 11px;
            font-weight: 600;
            background: var(--primary-light);
            color: var(--primary);
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 2px;
            text-transform: capitalize;
        }

        .profile-photo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--primary-light);
            overflow: hidden;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #102d70 0%, #173c91 60%, #2053c5 100%);
            color: var(--white);
            padding: 28px 32px;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            right: -40px;
            top: -40px;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
        }

        .hero-content h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .hero-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, .85);
            max-width: 580px;
            line-height: 1.5;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            z-index: 1;
        }

        .btn-light {
            background: var(--white);
            color: var(--primary-dark);
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
        }

        .btn-light:hover {
            background: #f0f4ff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        .btn-outline-light {
            background: rgba(255, 255, 255, .15);
            color: var(--white);
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, .3);
            transition: all .2s ease;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, .25);
        }

        /* Stat Grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-card {
            background: var(--white);
            padding: 22px;
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-icon svg { width: 20px; height: 20px; }

        .icon-blue { background: #eaf0ff; color: #173c91; }
        .icon-green { background: #eaf8ef; color: #159447; }
        .icon-orange { background: #fff4e3; color: #d98218; }
        .icon-purple { background: #f3ebff; color: #7c3aed; }

        .stat-title {
            font-size: 13px;
            color: var(--muted);
            font-weight: 600;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
        }

        .stat-footer {
            font-size: 12px;
            color: var(--muted);
            border-top: 1px solid var(--border);
            padding-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge-role {
            font-size: 11px;
            padding: 2px 7px;
            border-radius: 6px;
            font-weight: 600;
        }

        .badge-admin { background: #f3ebff; color: #7c3aed; }
        .badge-bk { background: #eaf0ff; color: #173c91; }
        .badge-wali { background: #eaf8ef; color: #159447; }

        /* Content Section */
        .content-card {
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        thead {
            background: #fafbfe;
            color: var(--muted);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }

        th, td {
            padding: 14px 20px;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #f8faff;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary);
            transition: all .2s ease;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: var(--white);
        }

        .notification-wrapper { position: relative; }
        .notification-btn {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--primary-soft); border: 1px solid var(--border);
            color: var(--primary); display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative; transition: all .2s ease;
        }
        .notification-btn:hover { background: var(--primary-light); }
        .notification-dot {
            position: absolute; top: 8px; right: 8px; width: 8px; height: 8px;
            border-radius: 50%; background: var(--red); border: 2px solid var(--white);
        }
        .notification-dropdown {
            position: absolute; top: 50px; right: 0; width: 320px; max-height: 380px;
            overflow-y: auto; background: var(--white); border: 1px solid var(--border);
            border-radius: 14px; box-shadow: var(--shadow-lg); display: none; z-index: 1000;
        }
        .notification-dropdown.show { display: block; }
        .notification-header {
            padding: 12px 16px; border-bottom: 1px solid var(--border);
            font-size: 13px; font-weight: 700; display: flex; justify-content: space-between; align-items: center;
        }
        .notification-item {
            display: flex; gap: 10px; padding: 12px 16px;
            border-bottom: 1px solid var(--border); transition: background .15s ease; text-decoration: none;
        }
        .notification-item:hover { background: #f8faff; }
        .notification-item.unread { background: #f0f7ff; }
        .notification-item-icon {
            width: 34px; height: 34px; border-radius: 8px;
            background: var(--primary-light); color: var(--primary);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .notification-item-content strong { display: block; font-size: 12.5px; color: var(--text); margin-bottom: 2px; }
        .notification-item-content p { font-size: 12px; color: var(--muted); line-height: 1.4; }
        .notification-item-content small { display: block; font-size: 10.5px; color: #94a3b8; margin-top: 4px; }
        .notification-empty { padding: 24px 16px; text-align: center; color: var(--muted); font-size: 12.5px; }

        @media (max-width: 1100px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-banner { flex-direction: column; align-items: flex-start; gap: 18px; }
        }

        @media (max-width: 900px) {
            .sidebar { width: 78px; min-width: 78px; flex-basis: 78px; padding: 18px 10px; align-items: center; }
            .main { margin-left: 78px; }
            .brand { justify-content: center; margin-bottom: 18px; padding-bottom: 14px; }
            .brand-name, .brand-subtitle, .menu-title, .menu-label, .menu-badge { display: none !important; }
            .menu-item, .logout-button { justify-content: center; padding: 12px 0; font-size: 0; }
        }

        @media (max-width: 768px) {
            .stat-grid { grid-template-columns: 1fr; }
            .main { padding: 18px 14px; }
            .header { flex-direction: column; align-items: flex-start; gap: 12px; padding: 16px; }
            .profile-area { width: 100%; justify-content: flex-end; }
        }
    </style>
    @include('partials.theme')
    <style>
        body.dashboard-admin,
        body.dashboard-admin * {
            font-family: Inter, "Plus Jakarta Sans", sans-serif !important;
        }

        html body.dashboard-admin .main {
            padding: 0 36px 28px;
            gap: 28px;
        }

        html body.dashboard-admin .main > .header {
            position: sticky !important;
            top: 0 !important;
            z-index: 45 !important;
            min-height: 78px;
            margin: 0 -36px;
            padding: 0 36px;
            border: 0 !important;
            border-bottom: 1px solid rgba(148, 163, 184, .22) !important;
            border-radius: 0 !important;
            background: rgba(255, 255, 255, .88) !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .035) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        body.dashboard-admin .sirasi-global-page-title {
            font-family: Inter, "Plus Jakarta Sans", sans-serif !important;
        }

        body.dashboard-admin .sirasi-global-page-title::after {
            display: none !important;
        }

        body.dashboard-admin .hero-banner {
            width: 100%;
            min-width: 0;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            gap: 20px;
            margin-bottom: 0;
        }

        body.dashboard-admin .hero-topbar,
        body.dashboard-admin .hero-school-badge,
        body.dashboard-admin .hero-date-badge,
        body.dashboard-admin .hero-main-row,
        body.dashboard-admin .hero-actions {
            display: flex;
            align-items: center;
        }

        body.dashboard-admin .hero-topbar {
            position: relative;
            z-index: 1;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        body.dashboard-admin .hero-school-badge,
        body.dashboard-admin .hero-date-badge {
            min-height: 32px;
            gap: 8px;
            padding: 6px 12px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 999px;
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .94);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        body.dashboard-admin .hero-date-badge {
            font-size: 11px;
            letter-spacing: 0;
            text-transform: none;
        }

        body.dashboard-admin .hero-school-badge svg,
        body.dashboard-admin .hero-date-badge svg {
            width: 15px;
            height: 15px;
            flex: 0 0 15px;
            color: #dbeafe;
        }

        body.dashboard-admin .hero-main-row {
            position: relative;
            z-index: 1;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        body.dashboard-admin .hero-content {
            min-width: 0;
            flex: 1 1 420px;
        }

        body.dashboard-admin .hero-content h2 {
            margin-bottom: 6px;
            color: #fff;
            font-size: clamp(24px, 2.2vw, 30px);
            font-weight: 700;
            line-height: 1.2;
        }

        body.dashboard-admin .hero-content p {
            max-width: 620px;
        }

        body.dashboard-admin .hero-actions {
            position: relative;
            z-index: 1;
            justify-content: flex-end;
            gap: 12px;
            flex: 0 0 auto;
            flex-wrap: wrap;
        }

        body.dashboard-admin .hero-divider {
            position: relative;
            z-index: 1;
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, .18);
        }

        @media (max-width: 900px) {
            html body.dashboard-admin .main { padding: 0 24px 24px; }
            html body.dashboard-admin .main > .header { margin-right: -24px; margin-left: -24px; padding-right: 24px; padding-left: 24px; }
        }

        @media (max-width: 768px) {
            html body.dashboard-admin .main { padding: 0 14px 18px; }
            html body.dashboard-admin .main > .header { margin-right: -14px; margin-left: -14px; padding-right: 14px; padding-left: 14px; }
            body.dashboard-admin .hero-main-row { align-items: flex-start; flex-direction: column; }
            body.dashboard-admin .hero-actions { width: 100%; justify-content: flex-start; }
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
</head>

<body class="dashboard-admin">
<div class="app">
    {{-- Sidebar --}}
    <aside class="sidebar">
        <div>
            @include('layouts.nav_identity')

            <div class="menu-title">Menu Utama</div>

            <nav class="menu">
                @include('partials.sidebar_menu')
            </nav>
        </div>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Anda yakin ingin keluar?');">
                @csrf
                <button type="submit" class="menu-item logout-button">
                    <span class="menu-icon"><i data-lucide="log-out"></i></span>
                    <span class="menu-label">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Area --}}
    <main class="main">
        {{-- Header --}}
        <header class="header" data-page-title="Dashboard">
            <div class="header-title">
                <h1>Dashboard Administrator</h1>
                <p>Pusat Manajemen Pengguna, Master Siswa, & Pengaturan Sistem</p>
            </div>

            <div class="profile-area" style="display: flex; align-items: center; gap: 14px;">
                <div class="notification-wrapper">
                    <button type="button" class="notification-btn" id="notificationButton" onclick="toggleNotificationDropdown(event)" title="Notifikasi Sistem">
                        <i data-lucide="bell" style="width: 18px; height: 18px;"></i>
                        @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                            <span class="notification-dot" id="notificationDot"></span>
                        @endif
                    </button>

                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <span>Notifikasi Sistem</span>
                            @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                                <button type="button" onclick="markAllNotificationsRead(event)" style="background: none; border: none; color: var(--primary); font-size: 11.5px; font-weight: 600; cursor: pointer;">Tandai Dibaca</button>
                            @endif
                        </div>

                        @forelse ($notifikasis ?? [] as $notif)
                            <a href="{{ route('notifikasi.baca', $notif->id) }}" class="notification-item {{ !$notif->dibaca ? 'unread' : '' }}">
                                <div class="notification-item-icon">
                                    <i data-lucide="bell-ring" style="width: 16px; height: 16px;"></i>
                                </div>
                                <div class="notification-item-content">
                                    <strong>{{ $notif->judul }}</strong>
                                    <p>{{ trim(preg_replace('/\s*\[JADWAL:\d+\]/', '', (string) $notif->pesan)) }}</p>
                                    <small>{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        @empty
                            <div class="notification-empty">
                                <i data-lucide="bell-off" style="width: 24px; height: 24px; margin-bottom: 6px; display: inline-block;"></i>
                                <p>Belum ada notifikasi baru</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="profile">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->nama }}</div>
                        <div class="profile-role">Admin Sistem</div>
                    </div>
                    <div class="profile-photo">
                        @if (auth()->user()->foto_profil)
                            <img src="{{ route('profile.photo', basename(auth()->user()->foto_profil)) }}" alt="Foto Profil">
                        @else
                            <i data-lucide="shield"></i>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success" role="status" style="margin-top: 14px;">
                <i data-lucide="check-circle-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 14px;">
                <i data-lucide="alert-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Hero Banner --}}
        <div class="hero-banner">
            <div class="hero-topbar">
                <div class="hero-school-badge">
                    <i data-lucide="graduation-cap" aria-hidden="true"></i>
                    SMP NEGERI 2 DRAMAGA &bull; SISTEM ADMINISTRATOR
                </div>
                <div class="hero-date-badge">
                    <i data-lucide="calendar-days" aria-hidden="true"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </div>
            </div>
            <div class="hero-main-row">
                <div class="hero-content">
                    <h2>Selamat Datang, Administrator <span aria-hidden="true">👋</span></h2>
                    <p>Anda memiliki hak akses Administrator untuk mengelola akun pengguna (Admin, Guru BK, Wali Kelas) serta mengelola data induk siswa SMP Negeri 2 Dramaga.</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('users.index') }}" class="btn-light">
                        <i data-lucide="user-plus"></i> Kelola Pengguna
                    </a>
                    <a href="{{ route('siswa.index') }}" class="btn-outline-light">
                        <i data-lucide="file-spreadsheet"></i> Master Siswa
                    </a>
                </div>
            </div>
            <div class="hero-divider" aria-hidden="true"></div>
        </div>

        {{-- Stat Cards --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-purple">
                            <i data-lucide="users"></i>
                        </div>
                        <div class="stat-title">Total Akun Pengguna</div>
                    </div>
                </div>
                <div class="stat-value">{{ $totalUser }}</div>
                <div class="stat-footer">
                    <span class="badge-role badge-admin">{{ $totalAdmin }} Admin</span>
                    <span class="badge-role badge-bk">{{ $totalGuruBK }} BK</span>
                    <span class="badge-role badge-wali">{{ $totalWaliKelas }} Wali</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-blue">
                            <i data-lucide="graduation-cap"></i>
                        </div>
                        <div class="stat-title">Total Siswa Terdaftar</div>
                    </div>
                </div>
                <div class="stat-value">{{ $totalSiswa }}</div>
                <div class="stat-footer">
                    <span style="color: var(--green); font-weight: 600;">● {{ $siswaAktif }} Aktif</span>
                    <span style="color: var(--muted); margin-left: 6px;">● {{ $siswaTidakAktif }} Non-Aktif</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-orange">
                            <i data-lucide="school"></i>
                        </div>
                        <div class="stat-title">Total Kelas Sekolah</div>
                    </div>
                </div>
                <div class="stat-value">{{ $totalKelas }}</div>
                <div class="stat-footer">
                    <i data-lucide="check-circle" style="width: 14px; height: 14px; color: var(--green);"></i>
                    <span>Tingkat VII, VIII, dan IX (35 Rombel)</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-green">
                            <i data-lucide="shield-check"></i>
                        </div>
                        <div class="stat-title">Hak Akses Sistem</div>
                    </div>
                </div>
                <div class="stat-value" style="font-size: 20px; color: var(--green);">Least Privilege</div>
                <div class="stat-footer">
                    <i data-lucide="lock" style="width: 14px; height: 14px;"></i>
                    <span>Catatan BK bersifat privat</span>
                </div>
            </div>
        </div>

        {{-- Table User Terbaru --}}
        <div class="content-card">
            <div class="card-header">
                <h3><i data-lucide="user-check"></i> Akun Pengguna Sistem Terbaru</h3>
                <a href="{{ route('users.index') }}" class="btn-sm">
                    Lihat Semua Pengguna <i data-lucide="chevron-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username / NIP</th>
                            <th>Role / Peran</th>
                            <th>Kelas Binaan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usersTerbaru as $index => $u)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $u->nama }}</strong></td>
                                <td><code>{{ $u->username }}</code></td>
                                <td>
                                    @if ($u->isAdmin())
                                        <span class="badge-role badge-admin">Admin</span>
                                    @elseif ($u->isGuruBK())
                                        <span class="badge-role badge-bk">Guru BK</span>
                                    @elseif ($u->isWaliKelas())
                                        <span class="badge-role badge-wali">Wali Kelas</span>
                                    @else
                                        <span class="badge-role">{{ $u->role }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $u->kelas ? 'Kelas ' . $u->kelas->nama_kelas : '-' }}
                                </td>
                                <td>
                                    <span style="color: var(--green); font-weight: 600;">● Aktif</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--muted); padding: 30px;">
                                    Belum ada akun pengguna terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
    lucide.createIcons();

    function toggleNotificationDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) {
            dropdown.classList.toggle('show');
            const dot = document.getElementById('notificationDot') || document.querySelector('.notification-dot');
            if (dot) {
                dot.style.display = 'none';
                fetch('{{ route("notifikasi.markAllRead") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).catch(() => {});
            }
        }
    }

    function markAllNotificationsRead(event) {
        event.stopPropagation();
        fetch('{{ route("notifikasi.markAllRead") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(() => {
            const dot = document.getElementById('notificationDot');
            if (dot) dot.style.display = 'none';
            document.querySelectorAll('.notification-item.unread').forEach(el => el.classList.remove('unread'));
        });
    }

    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('notificationDropdown');
        const btn = document.getElementById('notificationButton');
        if (dropdown && btn && !dropdown.contains(event.target) && !btn.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });
</script>
</body>
</html>
