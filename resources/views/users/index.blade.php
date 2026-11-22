<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - SIRASI-BK</title>

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
        button, input, select {  }

        .app { display:flex; min-height:100vh; }

        .sidebar {
            width:235px; min-height:100vh; position:fixed; inset:0 auto 0 0;
            z-index:30; display:flex; flex-direction:column; justify-content:space-between;
            padding:24px 20px;
            background:linear-gradient(180deg, #102d70 0%, #173c91 100%);
            color:var(--white); box-shadow:4px 0 24px rgba(16,45,112,.12);
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
            flex:1; min-width:0; width:auto; max-width:none; margin-left:235px;
            padding:0 38px 30px; display:flex; flex-direction:column; gap:24px;
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

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .alert-success {
            background: var(--green-bg);
            color: var(--green);
            border: 1px solid #b8ebd0;
        }

        .alert-danger {
            background: var(--red-bg);
            color: var(--red);
            border: 1px solid #ffccd0;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            min-width: 235px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 13px;
            background: var(--white);
            color: var(--text);
            outline: none;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 60, 145, .1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            display: flex;
        }

        .filter-select {
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 13px;
            background: var(--white);
            color: var(--text);
            outline: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(23, 60, 145, .25);
        }

        /* Table Card */
        .content-card {
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
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

        .badge-role {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-admin { background: #f3ebff; color: #7c3aed; }
        .badge-bk { background: #eaf0ff; color: #173c91; }
        .badge-wali { background: #eaf8ef; color: #159447; }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--muted);
            cursor: pointer;
            transition: all .15s ease;
        }

        .btn-icon:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .btn-delete:hover {
            border-color: var(--red);
            color: var(--red);
            background: var(--red-bg);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(16, 45, 112, .45);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-dialog {
            background: var(--white);
            width: 100%;
            max-width: 500px;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: modalFadeIn .2s ease-out;
        }

        @keyframes modalFadeIn {
            from { transform: scale(.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafbfe;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            display: flex;
        }

        .modal-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .form-control {
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 13px;
            outline: none;
            background: var(--white);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 60, 145, .1);
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: #fafbfe;
        }

        .btn-secondary {
            background: #f0f2f5;
            color: var(--muted);
            border: 1px solid var(--border);
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #e4e7ed;
            color: var(--text);
        }

        .pagination-container {
            padding: 18px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-info { text-align: right; }
        .profile-name { font-size: 13.5px; font-weight: 700; color: var(--text); }
        .profile-role { font-size: 11.5px; color: var(--muted); }
        .profile-photo {
            width: 42px; height: 42px; border-radius: 50%;
            background: var(--primary-light); color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; border: 2px solid var(--primary-light); flex-shrink: 0;
        }
        .profile-photo img { width: 100%; height: 100%; object-fit: cover; }

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

    </style>
    @include('partials.theme')
    <style>
        html body.admin-users-page .main > .header { position:sticky !important; top:0 !important; z-index:45 !important; min-height:74px; margin:0 -38px; padding:0 38px !important; border:0 !important; border-bottom:1px solid rgba(148,163,184,.22) !important; border-radius:0 !important; background:rgba(255,255,255,.92) !important; box-shadow:0 2px 14px rgba(15,23,42,.035) !important; backdrop-filter:blur(16px); }
        html body.admin-users-page .main > .header .header-title { display:none !important; }
        html body.admin-users-page .sirasi-global-page-title { font-family:Inter,"Plus Jakarta Sans",sans-serif !important; }
        html body.admin-users-page .main > .toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:nowrap; gap:14px; padding:18px 20px; border:1px solid rgba(255,255,255,.86); border-radius:18px; background:rgba(255,255,255,.76); box-shadow:0 10px 28px rgba(28,54,108,.06),inset 0 1px rgba(255,255,255,.95); backdrop-filter:blur(18px); }
        html body.admin-users-page .toolbar form.toolbar-left { display:flex; flex:1 1 auto; min-width:0; align-items:center; gap:12px; }
        html body.admin-users-page .toolbar .search-box { flex:1 1 300px; width:auto; min-width:180px; }
        html body.admin-users-page .toolbar .search-box input, html body.admin-users-page .toolbar .filter-select { height:44px; }
        html body.admin-users-page .toolbar .btn-primary { min-height:44px; white-space:nowrap; }
        html body.admin-users-page .main .content-card { width:100%; min-width:0; border:1px solid rgba(255,255,255,.86); border-radius:18px; background:linear-gradient(135deg,rgba(247,250,255,.76),rgba(235,242,255,.62)); box-shadow:0 18px 48px rgba(28,54,108,.09),inset 0 1px rgba(255,255,255,.88); backdrop-filter:blur(20px); }
        html body.admin-users-page .table-responsive { width:100%; overflow-x:auto; }
        html body.admin-users-page .table-responsive table { width:100%; min-width:820px; table-layout:fixed; font-family:Inter,"Plus Jakarta Sans",sans-serif; }
        html body.admin-users-page .table-responsive th, html body.admin-users-page .table-responsive td { padding:14px 16px; vertical-align:middle; overflow-wrap:anywhere; }
        html body.admin-users-page .table-responsive th:nth-child(1) { width:56px; }
        html body.admin-users-page .table-responsive th:nth-child(2) { width:24%; }
        html body.admin-users-page .table-responsive th:nth-child(3) { width:17%; }
        html body.admin-users-page .table-responsive th:nth-child(4) { width:16%; }
        html body.admin-users-page .table-responsive th:nth-child(5) { width:20%; }
        html body.admin-users-page .table-responsive th:nth-child(6) { width:104px; }
        html body.admin-users-page .table-responsive tbody tr:nth-child(even) { background:rgba(255,255,255,.34); }
        html body.admin-users-page .btn-icon { width:32px; height:32px; flex:0 0 32px; }
        html body.admin-users-page .btn-icon svg { width:15px !important; height:15px !important; }
        html body.admin-users-page .pagination-container { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; padding:16px 20px; }
        html body.admin-users-page .pagination-container svg { width:16px !important; height:16px !important; }
        @media(max-width:1024px) {
            html body.admin-users-page .sidebar { width:76px; padding:20px 10px; align-items:center; }
            html body.admin-users-page .sidebar .sirasi-sidebar-user-name, html body.admin-users-page .sidebar .menu-title, html body.admin-users-page .sidebar .menu-label { display:none !important; }
            html body.admin-users-page .main { margin-left:76px; padding:0 20px 22px; }
            html body.admin-users-page .main > .header { margin:0 -20px; padding:0 20px !important; }
        }
        @media(max-width:768px) {
            html body.admin-users-page .main > .toolbar { align-items:stretch; flex-wrap:wrap; }
            html body.admin-users-page .toolbar form.toolbar-left { flex-basis:100%; flex-wrap:wrap; }
            html body.admin-users-page .toolbar .search-box { flex:1 1 100%; width:100%; }
            html body.admin-users-page .toolbar .filter-select { flex:1 1 150px; }
            html body.admin-users-page .toolbar > .btn-primary { align-self:flex-start; }
            html body.admin-users-page .pagination-container { align-items:flex-start; flex-direction:column; }
        }
        @media(max-width:640px) {
            html body.admin-users-page .sidebar { width:62px; padding:12px 5px; }
            html body.admin-users-page .main { margin-left:62px; padding:0 12px 18px; gap:18px; }
            html body.admin-users-page .main > .header { min-height:68px; margin:0 -12px; padding:0 14px !important; }
            html body.admin-users-page .main > .toolbar, html body.admin-users-page .main .content-card { border-radius:14px; }
        }
        html body.admin-users-page .toolbar .search-box {
            background: transparent !important;
            border: 0 !important;
            padding: 0 !important;
        }
        html body.admin-users-page .toolbar .search-box input,
        html body.admin-users-page .toolbar .search-box input:hover {
            box-sizing: border-box !important;
            height: 44px !important;
            padding: 10px 14px 10px 38px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            outline: none !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            color: #0f172a !important;
            box-shadow: none !important;
        }
        html body.admin-users-page .toolbar .search-box input::placeholder { color: #94a3b8 !important; opacity: 1; }
        html body.admin-users-page .toolbar .search-box input:focus,
        html body.admin-users-page .toolbar .search-box input:focus-visible {
            border-color: #2563eb !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }
        html body.admin-users-page .toolbar .search-icon { color: #64748b !important; }
        html.dark body.admin-users-page .toolbar .search-box input,
        html.dark-mode body.admin-users-page .toolbar .search-box input,
        body.dark.admin-users-page .toolbar .search-box input,
        body.dark-mode.admin-users-page .toolbar .search-box input,
        html.dark body.admin-users-page .toolbar .search-box input:hover,
        html.dark-mode body.admin-users-page .toolbar .search-box input:hover,
        body.dark.admin-users-page .toolbar .search-box input:hover,
        body.dark-mode.admin-users-page .toolbar .search-box input:hover {
            border: 1px solid rgba(148, 163, 184, 0.25) !important;
            background-color: rgba(15, 23, 42, 0.6) !important;
            background: rgba(15, 23, 42, 0.6) !important;
            color: #fff !important;
        }
        html.dark body.admin-users-page .toolbar .search-box input::placeholder,
        html.dark-mode body.admin-users-page .toolbar .search-box input::placeholder,
        body.dark.admin-users-page .toolbar .search-box input::placeholder,
        body.dark-mode.admin-users-page .toolbar .search-box input::placeholder { color: #94a3b8 !important; }
        html.dark body.admin-users-page .toolbar .search-box input:focus,
        html.dark-mode body.admin-users-page .toolbar .search-box input:focus,
        body.dark.admin-users-page .toolbar .search-box input:focus,
        body.dark-mode.admin-users-page .toolbar .search-box input:focus,
        html.dark body.admin-users-page .toolbar .search-box input:focus-visible,
        html.dark-mode body.admin-users-page .toolbar .search-box input:focus-visible,
        body.dark.admin-users-page .toolbar .search-box input:focus-visible,
        body.dark-mode.admin-users-page .toolbar .search-box input:focus-visible {
            border-color: #2563eb !important;
            background-color: rgba(15, 23, 42, 0.8) !important;
            background: rgba(15, 23, 42, 0.8) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }
        html.dark body.admin-users-page .toolbar .search-icon,
        html.dark-mode body.admin-users-page .toolbar .search-icon,
        body.dark.admin-users-page .toolbar .search-icon,
        body.dark-mode.admin-users-page .toolbar .search-icon { color: #94a3b8 !important; }
    </style></head>

<body class="admin-users-page">
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
        <header class="header">
            <div class="header-title">
                <h1>Kelola Pengguna Sistem</h1>
                <p>Manajemen Akun Administrator, Guru BK, dan Penugasan Wali Kelas</p>
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

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i data-lucide="check-circle-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i data-lucide="alert-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i data-lucide="alert-circle"></i>
                <div>
                    <strong>Perhatian:</strong>
                    <ul style="margin-left: 18px; margin-top: 4px;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Toolbar Filter & Search --}}
        <div class="toolbar">
            <form action="{{ route('users.index') }}" method="GET" class="toolbar-left">
                <div class="search-box">
                    <span class="search-icon"><i data-lucide="search" style="width: 16px; height: 16px;"></i></span>
                    <input type="text" name="search" placeholder="Cari nama, username, atau kelas..." value="{{ request('search') }}" autocomplete="off">
                </div>

                <select name="role" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru_bk" {{ request('role') === 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                    <option value="wali_kelas" {{ request('role') === 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                </select>

                @if (request()->hasAny(['search', 'role']))
                    <a href="{{ route('users.index') }}" class="btn-secondary" style="padding: 9px 14px; font-size: 13px;">Reset</a>
                @endif
            </form>

            <button type="button" class="btn-primary" onclick="openCreateModal()">
                <i data-lucide="user-plus"></i> Tambah Pengguna Baru
            </button>
        </div>

        {{-- Table User --}}
        <div class="content-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username / NIP</th>
                            <th>Role / Peran</th>
                            <th>Kelas Binaan</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $u)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $u->nama }}</strong>
                                    @if(auth()->id() == $u->id_user)
                                        <small style="color: var(--primary); font-weight: 600;">(Anda)</small>
                                    @endif
                                </td>
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
                                    @if ($u->isWaliKelas())
                                        @if ($u->kelas)
                                            <span style="font-weight: 600; color: var(--primary);">Kelas {{ $u->kelas->nama_kelas }}</span>
                                        @else
                                            <span style="color: var(--orange); font-size: 12px;">(Belum Ditugaskan)</span>
                                        @endif
                                    @else
                                        <span style="color: var(--muted);">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <button type="button" class="btn-icon" title="Edit Pengguna"
                                            onclick="openEditModal({{ $u->id_user }}, '{{ addslashes($u->nama) }}', '{{ addslashes($u->username) }}', '{{ $u->role }}', '{{ $u->id_kelas }}')">
                                            <i data-lucide="edit-3" style="width: 15px; height: 15px;"></i>
                                        </button>

                                        @if (auth()->id() != $u->id_user && $u->username !== 'adminbk')
                                            <form action="{{ route('users.destroy', $u->id_user) }}" method="POST" style="display: inline;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->nama }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon btn-delete" title="Hapus Pengguna">
                                                    <i data-lucide="trash-2" style="width: 15px; height: 15px;"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--muted); padding: 40px;">
                                    Tidak ada data pengguna ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="pagination-container">
                    <span style="font-size: 13px; color: var(--muted);">
                        Menampilkan {{ $users->firstItem() }} s/d {{ $users->lastItem() }} dari {{ $users->total() }} akun
                    </span>
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </main>
</div>

{{-- Modal Tambah Pengguna --}}
<div class="modal" id="createModal">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h3><i data-lucide="user-plus"></i> Tambah Pengguna Baru</h3>
                <button type="button" class="modal-close" onclick="closeCreateModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama & Gelar" required>
                </div>

                <div class="form-group">
                    <label>Username / NIP *</label>
                    <input type="text" name="username" class="form-control" placeholder="Contoh: 19850101... atau admin2" required>
                </div>

                <div class="form-group">
                    <label>Password Awal *</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="form-group">
                    <label>Role / Peran Pengguna *</label>
                    <select name="role" id="createRoleSelect" class="form-control" required onchange="toggleCreateKelas(this.value)">
                        <option value="admin">Administrator</option>
                        <option value="guru_bk">Guru BK</option>
                        <option value="wali_kelas">Wali Kelas</option>
                    </select>
                </div>

                <div class="form-group" id="createKelasGroup" style="display: none;">
                    <label>Pilih Kelas Binaan *</label>
                    <select name="id_kelas" id="createIdKelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($daftarKelas as $k)
                            <option value="{{ $k->id_kelas }}">Kelas {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeCreateModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Pengguna --}}
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3><i data-lucide="user-check"></i> Edit Data Pengguna</h3>
                <button type="button" class="modal-close" onclick="closeEditModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Username / NIP *</label>
                    <input type="text" name="username" id="editUsername" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Reset Password (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>

                <div class="form-group">
                    <label>Role / Peran Pengguna *</label>
                    <select name="role" id="editRoleSelect" class="form-control" required onchange="toggleEditKelas(this.value)">
                        <option value="admin">Administrator</option>
                        <option value="guru_bk">Guru BK</option>
                        <option value="wali_kelas">Wali Kelas</option>
                    </select>
                </div>

                <div class="form-group" id="editKelasGroup" style="display: none;">
                    <label>Pilih Kelas Binaan *</label>
                    <select name="id_kelas" id="editIdKelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($daftarKelas as $k)
                            <option value="{{ $k->id_kelas }}">Kelas {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-primary">Perbarui Akun</button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();

    function openCreateModal() {
        document.getElementById('createModal').classList.add('active');
        toggleCreateKelas(document.getElementById('createRoleSelect').value);
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.remove('active');
    }

    function toggleCreateKelas(role) {
        var group = document.getElementById('createKelasGroup');
        var select = document.getElementById('createIdKelas');
        if (role === 'wali_kelas') {
            group.style.display = 'flex';
            select.setAttribute('required', 'required');
        } else {
            group.style.display = 'none';
            select.removeAttribute('required');
        }
    }

    function openEditModal(id, nama, username, role, idKelas) {
        document.getElementById('editUserForm').action = '/users/' + id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editUsername').value = username;
        document.getElementById('editRoleSelect').value = role;
        document.getElementById('editIdKelas').value = idKelas || '';
        toggleEditKelas(role);
        document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    function toggleEditKelas(role) {
        var group = document.getElementById('editKelasGroup');
        var select = document.getElementById('editIdKelas');
        if (role === 'wali_kelas') {
            group.style.display = 'flex';
            select.setAttribute('required', 'required');
        } else {
            group.style.display = 'none';
            select.removeAttribute('required');
        }
    }

    window.onclick = function(event) {
        var createModal = document.getElementById('createModal');
        var editModal = document.getElementById('editModal');
        if (event.target == createModal) closeCreateModal();
        if (event.target == editModal) closeEditModal();

        var dropdown = document.getElementById('notificationDropdown');
        var btn = document.getElementById('notificationButton');
        if (dropdown && btn && !dropdown.contains(event.target) && !btn.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    }

    function toggleNotificationDropdown(event) {
        event.stopPropagation();
        var dropdown = document.getElementById('notificationDropdown');
        if (dropdown) {
            dropdown.classList.toggle('show');
            var dot = document.getElementById('notificationDot') || document.querySelector('.notification-dot');
            if (dot) {
                dot.style.display = 'none';
                fetch('{{ route("notifikasi.markAllRead") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).catch(function() {});
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
        }).then(function() {
            var dot = document.getElementById('notificationDot');
            if (dot) dot.style.display = 'none';
            document.querySelectorAll('.notification-item.unread').forEach(function(el) { el.classList.remove('unread'); });
        });
    }
</script>
</body>
</html>
