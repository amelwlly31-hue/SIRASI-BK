<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Jadwal BK - SIRASI-BK</title>

    @include('partials.theme')

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
            --bg: #f5f7fb;
            --white: #fff;
            --text: #172033;
            --muted: #737b8c;
            --border: #e3e7ef;
            --success: #16894a;
            --success-bg: #eaf8f0;
            --danger: #d64545;
            --danger-bg: #fff0f0;
            --shadow-sm: 0 4px 14px rgba(23, 60, 145, .05);
            --shadow-md: 0 12px 30px rgba(23, 60, 145, .08);
        }

        body {

            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
        }

        button {

        }

        .app {
            min-height: 100vh;
        }

        /* sidebar */

        .sidebar {
            width: 235px;
            min-height: 100vh;

            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;

            display: flex;
            flex-direction: column;

            padding: 24px 16px;

            background:
                linear-gradient(
                    180deg,
                    #193f96 0%,
                    #173887 52%,
                    #112e70 100%
                );

            color: white;

            box-shadow:
                12px 0 35px rgba(15, 45, 112, .10);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 4px 10px 28px;
        }

        .brand-logo {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.20);
        }

        .brand-logo img {
            width: 200px;
            height: 150px;
            object-fit: contain;
            transform: translateY(20px);
        }

        .brand-name {
            font-size: 19px;
            font-weight: 800;
        }

        .brand-subtitle {
            margin-top: 4px;
            color: #cbd8ff;
            font-size: 11px;
        }

        .menu-title {
            padding: 4px 12px 10px;
            color: #9eb2e9;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu-item {
            position: relative;
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 0 14px;
            border: 1px solid transparent;
            border-radius: 13px;
            color: #dce5ff;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            transition: background .20s ease, color .20s ease, transform .20s ease, box-shadow .20s ease, border-color .20s ease;
        }

        .menu-item::after {
            content: "";
            position: absolute;
            left: 10px;
            right: 10px;
            bottom: 5px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, rgba(160,195,255,.75), transparent);
            transform: scaleX(0);
            opacity: 0;
            transition: .22s ease;
        }

        .menu-item:hover {
            color: #fff;
            background: linear-gradient(90deg, rgba(255,255,255,.13), rgba(255,255,255,.06));
            border-color: rgba(255,255,255,.08);
            transform: translateX(2px);
            box-shadow: 0 7px 18px rgba(6,28,75,.10);
        }

        .menu-item:hover::after {
            transform: scaleX(1);
            opacity: 1;
        }

        .menu-item.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(255,255,255,.17), rgba(255,255,255,.07));
            border-color: rgba(255,255,255,.12);
            box-shadow: inset 3px 0 0 #a7c3ff, 0 9px 22px rgba(5,28,74,.13);
        }

        .menu-item.active::after {
            transform: scaleX(1);
            opacity: .9;
        }

        .menu-item:hover .menu-icon {
            background: rgba(255,255,255,.15);
        }

        .menu-item.active .menu-icon {
            background: rgba(255,255,255,.14);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.06);
            color: #ffffff;
        }

        .menu-icon {
            width: 25px;
            height: 25px;
            min-width: 25px;
            border-radius: 8px;
            background: rgba(255,255,255,.085);
            border: 1px solid rgba(255,255,255,.035);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #dce5ff;
            flex-shrink: 0;
            transition: .2s ease;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
        }

        .logout-button {
            width: 100%;
            border: 0;
            background: transparent;
            cursor: pointer;
            text-align: left;
        }

        /* main */

        .main {
            min-height: 100vh;
            margin-left: 235px;
        }

        /* header */

        .header {
            height: 76px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 32px;

            background: rgba(255,255,255,.88);
            backdrop-filter: blur(14px);

            border-bottom: 1px solid rgba(226,230,238,.8);

            position: sticky;
            top: 0;
            z-index: 40;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);
            border-radius: 11px;

            background: white;
            color: #5c6575;

            cursor: pointer;
        }

        .notification { position: relative; }
        .notification-dot { width: 7px; height: 7px; position: absolute; top: 7px; right: 7px; border: 2px solid white; border-radius: 50%; background: #e14c4c; }
        .notification-wrapper { position: relative; }
        .notification-dropdown { position: absolute; top: 48px; right: 0; width: 340px; max-height: 420px; overflow-y: auto; background: white; border: 1px solid var(--border); border-radius: 14px; box-shadow: 0 15px 35px rgba(23,60,145,.14); display: none; z-index: 1000; }
        .notification-dropdown.show { display: block; }
        .notification-header { padding: 15px 17px; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--text); }
        .notification-item { display: flex; gap: 11px; padding: 13px 15px; border-bottom: 1px solid #edf0f4; color: var(--text); text-decoration: none; transition: .2s ease; }
        .notification-item:hover { background: #f7f9ff; }
        .notification-item-icon { width: 34px; height: 34px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 9px; background: var(--primary-soft); color: var(--primary); }
        .notification-item-content { min-width: 0; }
        .notification-item-content strong { display: block; font-size: 11px; font-weight: 800; }
        .notification-item-content p { margin-top: 4px; color: var(--muted); font-size: 10px; line-height: 1.45; }
        .notification-item-content small { display: block; margin-top: 5px; color: #9aa1ae; font-size: 8px; }
        .notification-empty { padding: 30px 20px; text-align: center; color: var(--muted); font-size: 11px; }
        html.dark-mode .notification-dropdown { background: #162238 !important; border-color: #2a3953 !important; }
        html.dark-mode .notification-header, html.dark-mode .notification-item { border-color: #2a3953 !important; color: #eef3ff !important; }
        html.dark-mode .notification-item:hover { background: #1d2c47 !important; }
        .profile {
            display: flex;
            align-items: center;
            gap: 11px;

            padding-left: 18px;

            border-left: 1px solid var(--border);
        }

        .profile-info {
            text-align: right;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 700;
        }

        .profile-role {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .profile-photo {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #e8eeff;
            color: var(--primary);
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        /* content */

        .content {
            padding: 32px;
            max-width: 1200px;
            margin: auto;
        }

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;

            margin-bottom: 22px;
        }

        .eyebrow {
            margin-bottom: 7px;

            color: var(--primary);

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
        }

        .page-description {
            margin-top: 7px;

            color: var(--muted);

            font-size: 13px;
            line-height: 1.6;
        }

        /* button */

        .btn {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 0 15px;

            border: 1px solid var(--border);
            border-radius: 10px;

            background: white;
            color: #596375;

            font-size: 11px;
            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary {
            border-color: var(--primary);

            background:
                linear-gradient(
                    135deg,
                    #2149a2,
                    #173c91
                );

            color: white;
        }

        .btn-danger {
            border-color: #efcccc;
            background: var(--danger-bg);
            color: var(--danger);
        }

        /* detail card */

        .detail-card {
            position: relative;
            overflow: hidden;

            border: 1px solid var(--border);
            border-radius: 20px;

            background: white;

            box-shadow: var(--shadow-md);
        }

        .detail-card::before {
            content: "";

            position: absolute;

            left: 0;
            top: 0;

            width: 4px;
            height: 100%;

            background:
                linear-gradient(
                    180deg,
                    #173c91,
                    #6f8fd9
                );
        }

        .detail-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 22px 25px;

            border-bottom: 1px solid var(--border);
        }

        .detail-title-wrap {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .detail-icon {
            width: 46px;
            height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background: var(--primary-light);
            color: var(--primary);
        }

        .detail-title {
            font-size: 15px;
            font-weight: 800;
        }

        .detail-subtitle {
            margin-top: 4px;

            color: var(--muted);

            font-size: 10px;
        }

        /* status */

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 7px 11px;

            border-radius: 9px;

            font-size: 9px;
            font-weight: 800;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-badge.terjadwal {
            background: var(--primary-light);
            color: var(--primary);
        }

        .status-badge.terjadwal .status-dot {
            background: var(--primary);
        }

        .status-badge.selesai {
            background: var(--success-bg);
            color: var(--success);
        }

        .status-badge.selesai .status-dot {
            background: var(--success);
        }

        .status-badge.diajukan {
            background: #fff7e8;
            color: #c98516;
        }

        .status-badge.diajukan .status-dot {
            background: #f39c12;
        }

        .status-badge.disetujui_wali {
            background: #eaf8f0;
            color: #16894a;
        }

        .status-badge.disetujui_wali .status-dot {
            background: #2ecc71;
        }

        .status-badge.ditolak_wali {
            background: #fff0f0;
            color: #d64545;
        }

        .status-badge.ditolak_wali .status-dot {
            background: #e74c3c;
        }

        .status-badge.dibatalkan {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .status-badge.dibatalkan .status-dot {
            background: var(--danger);
        }

        /* body */

        .detail-body {
            padding: 25px;
        }

        .student-section {
            display: flex;
            align-items: center;
            gap: 15px;

            margin-bottom: 25px;

            padding: 17px;

            border: 1px solid #dce4f5;
            border-radius: 14px;

            background: #f8faff;
        }

        .student-avatar {
            width: 52px;
            height: 52px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #dfe8ff,
                    #cbd9ff
                );

            color: var(--primary);

            font-size: 17px;
            font-weight: 800;
        }

        .student-name {
            font-size: 15px;
            font-weight: 800;
        }

        .student-info {
            margin-top: 4px;

            color: var(--muted);

            font-size: 10px;
        }

        /* information grid */

        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 15px;

            color: var(--text);

            font-size: 12px;
            font-weight: 800;
        }

        .section-title i {
            color: var(--primary);
        }

        .info-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 13px;
        }

        .info-item {
            padding: 15px;

            border: 1px solid var(--border);
            border-radius: 12px;

            background: #fcfcfd;
        }

        .info-label {
            margin-bottom: 6px;

            color: #8a92a2;

            font-size: 9px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .info-value {
            color: var(--text);

            font-size: 11px;
            font-weight: 700;
        }

        .info-value.primary {
            color: var(--primary);
        }

        .note-section {
            margin-top: 20px;
        }

        .note-box {
            min-height: 100px;

            padding: 15px;

            border: 1px solid var(--border);
            border-radius: 12px;

            background: #fcfcfd;

            color: #606a7a;

            font-size: 11px;
            line-height: 1.7;

            white-space: pre-line;
        }

        .empty-note {
            color: #9aa1ae;
            font-style: italic;
        }

        /* footer */

        .detail-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            padding: 18px 25px;

            border-top: 1px solid var(--border);

            background: #fcfcfd;
        }

        .footer-left,
        .footer-right {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        /* alert */

        .alert-success {
            margin-bottom: 18px;

            padding: 13px 15px;

            border: 1px solid #ccebd9;
            border-radius: 10px;

            background: var(--success-bg);

            color: var(--success);

            font-size: 11px;
        }

        .alert-danger {
            margin-bottom: 18px;

            padding: 13px 15px;

            border: 1px solid #efcccc;
            border-radius: 10px;

            background: var(--danger-bg, #fff0f0);

            color: var(--danger, #d64545);

            font-size: 11px;
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

        /* responsive */

        @media (max-width: 900px) {
            .sidebar {
                width: 74px;
            }

            .main {
                margin-left: 74px;
            }

            .header {
                padding: 0 20px;
            }

            .content {
                padding: 22px;
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 62px;
            }

            .main {
                margin-left: 62px;
            }

            .page-heading,
            .detail-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .detail-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .footer-left,
            .footer-right {
                width: 100%;
            }

            .footer-left .btn,
            .footer-right .btn {
                flex: 1;
            }
        }

        /* dark mode */

        html.dark-mode body {
            background: #0f1728 !important;
            color: #e7ecf7 !important;
        }

        html.dark-mode .header {
            background: rgba(15,23,40,.94) !important;
            border-color: #24324a !important;
        }

        html.dark-mode .detail-card {
            background: #162238 !important;
            border-color: #2a3953 !important;
        }

        html.dark-mode .detail-header,
        html.dark-mode .detail-footer {
            border-color: #2a3953 !important;
            background: #18263c !important;
        }

        html.dark-mode .detail-title,
        html.dark-mode .section-title,
        html.dark-mode .student-name,
        html.dark-mode .info-value {
            color: #eef3ff !important;
        }

        html.dark-mode .detail-subtitle,
        html.dark-mode .student-info {
            color: #8f9db2 !important;
        }

        html.dark-mode .student-section,
        html.dark-mode .info-item,
        html.dark-mode .note-box {
            background: #1b2a42 !important;
            border-color: #33445f !important;
        }

        html.dark-mode .note-box {
            color: #b8c4d8 !important;
        }

        html.dark-mode .profile {
            border-color: #33445f !important;
        }

        html.dark-mode .profile-name {
            color: #eef3ff !important;
        }

        html.dark-mode .profile-role {
            color: #8996aa !important;
        }

        html.dark-mode .notification,
        html.dark-mode .btn {
            background: #1b2a42 !important;
            border-color: #33445f !important;
            color: #e7ecf7 !important;
        }

        html.dark-mode .btn-primary {
            background: var(--primary) !important;
            color: white !important;
        }

        html.dark-mode .btn-danger {
            background: #351e27 !important;
            color: #ff9a9a !important;
            border-color: #58313c !important;
        }
    </style>
</head>

<body>

<div class="app">

    {{-- sidebar --}}
    @include('layouts.sidebar')

    {{-- main --}}
    <main class="main">

        {{-- header --}}
        <header class="header">

            <div></div>

            <div class="profile-area">

                <div class="notification-wrapper">
                    <button class="notification" type="button" id="notificationButton" title="Notifikasi">
                        <i data-lucide="bell"></i>
                        @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                            <span class="notification-dot" id="notificationDot"></span>
                        @endif
                    </button>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header"><strong>Notifikasi</strong></div>
                        @forelse ($notifikasis ?? [] as $notifikasi)
                            <a href="{{ route('notifikasi.baca', $notifikasi->id) }}" class="notification-item {{ !$notifikasi->dibaca ? 'unread' : '' }}">
                                <div class="notification-item-icon"><i data-lucide="clipboard-list"></i></div>
                                <div class="notification-item-content">
                                    <strong>{{ $notifikasi->judul }}</strong>
                                    <p>{{ preg_replace('/\s*\[JADWAL:\d+\]/', '', $notifikasi->pesan) }}</p>
                                    <small>{{ $notifikasi->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        @empty
                            <div class="notification-empty"><i data-lucide="bell-off"></i><p>Belum ada notifikasi</p></div>
                        @endforelse
                    </div>
                </div>
                <button style="display:none" type="button">
                    <i data-lucide="bell"></i>
                </button>

                <div class="profile">

                    <div class="profile-info">

                        <div class="profile-name">
                            {{ auth()->user()->nama ?? auth()->user()->name ?? 'Admin BK' }}
                        </div>

                        <div class="profile-role">
                            Guru BK
                        </div>

                    </div>

                    <div class="profile-photo">

                        @if(auth()->user()->foto_profil)

                            <img
                                src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                alt="Foto Profil"
                            >

                        @else

                            <i data-lucide="user"></i>

                        @endif

                    </div>

                </div>

            </div>

        </header>

        {{-- content --}}
        <section class="content">

            @if(session('success'))

                <div class="alert-success" role="status">
                    {{ session('success') }}
                </div>

            @endif

            @if(session('error'))

                <div class="alert-danger" role="alert">
                    {{ session('error') }}
                </div>

            @endif

            <div class="page-heading">

                <div>

                    <div class="eyebrow">
                        Manajemen Bimbingan Konseling
                    </div>

                    <h1 class="page-title">
                        Detail Jadwal BK
                    </h1>

                    <p class="page-description">
                        Informasi lengkap mengenai jadwal bimbingan konseling siswa.
                    </p>

                </div>

                <a
                    href="{{ route('penjadwalan.index') }}"
                    class="btn"
                >
                    <i data-lucide="arrow-left"></i>
                    Kembali
                </a>

            </div>

            {{-- detail card --}}
            <div class="detail-card">

                <div class="detail-header">

                    <div class="detail-title-wrap">

                        <div class="detail-icon">
                            <i data-lucide="calendar-clock"></i>
                        </div>

                        <div>

                            <div class="detail-title">
                                Jadwal Bimbingan Konseling
                            </div>

                            <div class="detail-subtitle">
                                ID Jadwal #{{ $penjadwalan->id_penjadwalan }}
                                @if ($penjadwalan->kode_pengajuan)
                                    &nbsp; • &nbsp; Kode Izin: <strong>{{ $penjadwalan->kode_pengajuan }}</strong>
                                @endif
                            </div>

                        </div>

                    </div>

                    @php
                        $sudahAjukanSlot = $penjadwalan->hasSubmittedSchedule();
                        $statusDetailLabel = match ($penjadwalan->status) {
                            'Diajukan' => 'Menunggu Persetujuan Wali Kelas',
                            'Disetujui_Wali' => $sudahAjukanSlot
                                ? 'Izin Disetujui Wali Kelas (Menunggu Konfirmasi Guru BK)'
                                : 'Izin Disetujui Wali Kelas (Menunggu Siswa Pilih Slot)',
                            'Ditolak_Wali' => 'Ditolak Wali Kelas',
                            'Terjadwal' => 'Jadwal Terjadwal',
                            'Selesai' => 'Selesai',
                            'Dibatalkan' => 'Dibatalkan',
                            default => str_replace('_', ' ', $penjadwalan->status),
                        };
                    @endphp

                    <span class="status-badge {{ strtolower($penjadwalan->status) }}">

                        <span class="status-dot"></span>

                        {{ $statusDetailLabel }}

                    </span>

                </div>

                <div class="detail-body">

                    {{-- siswa --}}
                    <div class="student-section">

                        <div class="student-avatar">
                            {{ strtoupper(substr($penjadwalan->siswa->nama_siswa ?? '?', 0, 1)) }}
                        </div>

                        <div>

                            <div class="student-name">
                                {{ $penjadwalan->siswa->nama_siswa ?? '-' }}
                            </div>

                            <div class="student-info">
                                NIS: {{ $penjadwalan->siswa->nis ?? '-' }}
                                &nbsp; • &nbsp;
                                Kelas: {{ $penjadwalan->siswa->kelas->nama_kelas ?? '-' }}
                            </div>

                        </div>

                    </div>

                    {{-- informasi jadwal --}}
                    <div class="section-title">

                        <i data-lucide="calendar"></i>

                        Informasi Jadwal

                    </div>

                    <div class="info-grid">

                        <div class="info-item">

                            <div class="info-label">
                                Tanggal
                            </div>

                            <div class="info-value">

                                {{ \Carbon\Carbon::parse($penjadwalan->tanggal)->translatedFormat('l, d F Y') }}

                            </div>

                        </div>

                        <div class="info-item">

                            <div class="info-label">
                                Waktu
                            </div>

                            <div class="info-value">
                                @if (
                                    \Carbon\Carbon::parse($penjadwalan->waktu_mulai)->format('H:i') === '00:00'
                                    && \Carbon\Carbon::parse($penjadwalan->waktu_selesai)->format('H:i') === '00:00'
                                )
                                    Belum ditentukan (Menunggu pemilihan slot)
                                @else
                                    {{ \Carbon\Carbon::parse($penjadwalan->waktu_mulai)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($penjadwalan->waktu_selesai)->format('H:i') }}
                                    WIB
                                @endif
                            </div>

                        </div>

                        <div class="info-item">

                            <div class="info-label">
                                Jenis Bimbingan
                            </div>

                            <div class="info-value primary">
                                {{ $penjadwalan->jenis_bimbingan }}
                            </div>

                        </div>

                        <div class="info-item">

                            <div class="info-label">
                                Status
                            </div>

                            <div class="info-value">
                                {{ $statusDetailLabel }}
                            </div>

                        </div>

                    </div>

                    {{-- catatan --}}
                    <div class="note-section">

                        <div class="section-title">

                            <i data-lucide="file-text"></i>

                            Catatan

                        </div>

                        <div class="note-box">

                            @if($penjadwalan->catatan)

                                {{ $penjadwalan->catatan }}

                            @else

                                <span class="empty-note">
                                    Tidak ada catatan untuk jadwal ini.
                                </span>

                            @endif

                        </div>

                    </div>

                    {{-- izin wali kelas --}}
                    @php
                        $namaWaliKelas = $penjadwalan->waliKelas->nama
                            ?? $penjadwalan->siswa?->kelas?->waliKelas?->nama
                            ?? null;
                    @endphp
                    @if ($namaWaliKelas || $penjadwalan->catatan_wali || $penjadwalan->waktu_persetujuan_wali || in_array($penjadwalan->status, ['Diajukan', 'Disetujui_Wali', 'Ditolak_Wali'], true))
                    <div class="note-section" style="margin-top: 18px;">
                        <div class="section-title">
                            <i data-lucide="user-check"></i>
                            Approval Izin Siswa (Wali Kelas)
                        </div>
                        <div class="note-box" style="border-left: 3px solid var(--primary); background: #f8faff;">
                            <p style="margin-bottom: 6px;"><strong>Wali Kelas:</strong> {{ $namaWaliKelas ?? '-' }}</p>
                            @if ($penjadwalan->waktu_persetujuan_wali)
                                <p style="font-size: 12px; color: var(--muted); margin-bottom: 6px;">
                                    <strong>Waktu Konfirmasi Izin:</strong> {{ \Carbon\Carbon::parse($penjadwalan->waktu_persetujuan_wali)->format('d F Y, H:i') }} WIB
                                </p>
                            @elseif ($penjadwalan->status === 'Diajukan')
                                <p style="font-size: 12px; color: var(--muted); margin-bottom: 6px;">
                                    <strong>Status Izin:</strong> Menunggu persetujuan Wali Kelas
                                </p>
                            @endif
                            @if ($penjadwalan->catatan_wali)
                                <p style="margin-top: 6px; padding-top: 6px; border-top: 1px dashed #dce2ee;">
                                    <strong>Catatan Wali Kelas:</strong> <em>"{{ $penjadwalan->catatan_wali }}"</em>
                                </p>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>

                {{-- footer --}}
                <div class="detail-footer">

                    <div class="footer-left">

                    </div>

                    <div class="footer-right">
                        @if (
                            $penjadwalan->status === 'Disetujui_Wali'
                            && \Carbon\Carbon::parse($penjadwalan->waktu_mulai)->format('H:i') !== '00:00'
                            && \Carbon\Carbon::parse($penjadwalan->waktu_selesai)->format('H:i') !== '00:00'
                        )
                            <form action="{{ route('penjadwalan.update', $penjadwalan->id_penjadwalan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id_siswa" value="{{ $penjadwalan->id_siswa }}">
                                <input type="hidden" name="tanggal" value="{{ $penjadwalan->tanggal }}">
                                <input type="hidden" name="waktu_mulai" value="{{ \Carbon\Carbon::parse($penjadwalan->waktu_mulai)->format('H:i') }}">
                                <input type="hidden" name="waktu_selesai" value="{{ \Carbon\Carbon::parse($penjadwalan->waktu_selesai)->format('H:i') }}">
                                <input type="hidden" name="jenis_bimbingan" value="{{ $penjadwalan->jenis_bimbingan }}">
                                <input type="hidden" name="catatan" value="{{ $penjadwalan->catatan }}">
                                <input type="hidden" name="status" value="Terjadwal">
                                <button type="submit" class="btn btn-primary" style="background:#16894a;border-color:#16894a;">
                                    <i data-lucide="check-circle-2"></i>
                                    Konfirmasi Terjadwal
                                </button>
                            </form>
                        @endif

                        <a
                            href="{{ route('penjadwalan.edit', $penjadwalan->id_penjadwalan) }}"
                            class="btn btn-primary"
                        >
                            <i data-lucide="pencil"></i>
                            Edit Jadwal
                        </a>

                        <form
                            action="{{ route('penjadwalan.destroy', $penjadwalan->id_penjadwalan) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >
                                <i data-lucide="trash-2"></i>
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>

<script>
    lucide.createIcons();
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
            if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.remove('show');
            }
        });
    }
</script>

</body>

</html>
