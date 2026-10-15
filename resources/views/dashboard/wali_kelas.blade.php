<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas - SIRASI-BK</title>

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
            font-family: Inter, "Segoe UI", Arial, Helvetica, sans-serif;
            background: radial-gradient(circle at 85% 0%, rgba(41, 67, 143, .08), transparent 28%), #f5f7fb;
            color: var(--text);
            min-height: 100vh;
        }

        a { text-decoration: none; }
        button, input { font-family: inherit; }

        .app {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
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
            background: #eaf8ef;
            color: #159447;
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 2px;
        }

        .profile-photo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #eaf8ef;
            color: #159447;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #c8edd5;
            overflow: hidden;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #102d70 0%, #173c91 60%, #1d7e52 100%);
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

        .hero-content h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .hero-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, .88);
            max-width: 600px;
            line-height: 1.5;
        }

        .class-badge {
            background: rgba(255, 255, 255, .2);
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, .3);
        }

        .alert-warning {
            background: #fff4e3;
            border: 1px solid #ffd8a8;
            color: #d98218;
            padding: 16px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
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
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

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

        /* Two columns */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 24px;
        }

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
            font-size: 15px;
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
            padding: 12px 18px;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #f8faff;
        }

        .badge {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success { background: #eaf8ef; color: #159447; }
        .badge-warning { background: #fff4e3; color: #d98218; }
        .badge-secondary { background: #f0f2f5; color: #64748b; }

        @media (max-width: 1100px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .dashboard-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .app { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .stat-grid { grid-template-columns: 1fr; }
            .main { padding: 18px; }
        }
    </style>
    @include('partials.theme')
</head>

<body>
<div class="app">
    {{-- Sidebar --}}
    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo-smpn2-dramaga.png') }}?v=2" alt="Logo SMP Negeri 2 Dramaga">
                </div>
                <div>
                    <div class="brand-name">SIRASI-BK</div>
                    <div class="brand-subtitle">Portal Wali Kelas</div>
                </div>
            </div>

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
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Area --}}
    <main class="main">
        {{-- Header --}}
        <header class="header">
            <div class="header-title">
                <h1>Dashboard Wali Kelas</h1>
                <p>Pemantauan Siswa & Jadwal Bimbingan Kelas {{ $kelas ? $kelas->nama_kelas : '(Belum Ditugaskan)' }}</p>
            </div>

            <div class="profile-area">
                <div class="profile">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->nama }}</div>
                        <div class="profile-role">Wali Kelas {{ $kelas ? $kelas->nama_kelas : '' }}</div>
                    </div>
                    <div class="profile-photo">
                        @if (auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil">
                        @else
                            <i data-lucide="user-check"></i>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        {{-- Hero / Alert --}}
        @if ($kelas)
            <div class="hero-banner">
                <div class="hero-content">
                    <h2>Kelas Binaan: {{ $kelas->nama_kelas }}</h2>
                    <p>Selamat datang, Bapak/Ibu <strong>{{ auth()->user()->nama }}</strong>. Anda dapat memantau daftar siswa kelas binaan dan jadwal bimbingan konseling di sini.</p>
                </div>
                <div class="class-badge">
                    <i data-lucide="school"></i> Tingkat {{ $kelas->tingkat }}
                </div>
            </div>
        @else
            <div class="alert-warning">
                <i data-lucide="alert-triangle"></i>
                <div>
                    <strong>Pemberitahuan Penugasan Kelas:</strong>
                    Akun Anda belum ditautkan ke kelas binaan tertentu. Silakan hubungi Administrator sistem untuk mengatur kelas perwalian Anda.
                </div>
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Siswa Kelas</div>
                    <div class="stat-icon icon-blue">
                        <i data-lucide="users"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $totalSiswaKelas }}</div>
                <div class="stat-footer">
                    <span>Siswa terdaftar di Kelas {{ $kelas ? $kelas->nama_kelas : '-' }}</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Siswa Laki-laki</div>
                    <div class="stat-icon icon-purple">
                        <i data-lucide="user"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $siswaLaki }}</div>
                <div class="stat-footer">
                    <span>Peserta Didik Putra</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Siswa Perempuan</div>
                    <div class="stat-icon icon-orange">
                        <i data-lucide="user"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $siswaPerempuan }}</div>
                <div class="stat-footer">
                    <span>Peserta Didik Putri</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Jadwal Bimbingan</div>
                    <div class="stat-icon icon-green">
                        <i data-lucide="calendar-clock"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $jadwalSiswa->count() }}</div>
                <div class="stat-footer">
                    <span>Aktivitas Penjadwalan Siswa</span>
                </div>
            </div>
        </div>

        {{-- Two Columns Section --}}
        <div class="dashboard-grid">
            {{-- Daftar Siswa Kelas --}}
            <div class="content-card">
                <div class="card-header">
                    <h3><i data-lucide="users-round"></i> Daftar Siswa Kelas Binaan</h3>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>JK</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($daftarSiswa as $idx => $s)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td><code>{{ $s->nis ?: '-' }}</code></td>
                                    <td><strong>{{ $s->nama_siswa }}</strong></td>
                                    <td>{{ $s->jenis_kelamin }}</td>
                                    <td>
                                        <span class="badge {{ $s->status === 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $s->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--muted); padding: 30px;">
                                        Belum ada data siswa untuk kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Ringkasan Jadwal Bimbingan --}}
            <div class="content-card">
                <div class="card-header">
                    <h3><i data-lucide="calendar"></i> Jadwal Bimbingan Siswa</h3>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Tanggal & Waktu</th>
                                <th>Layanan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwalSiswa as $j)
                                <tr>
                                    <td><strong>{{ $j->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($j->tanggal)->isoFormat('D MMM Y') }}</div>
                                        <small style="color: var(--muted);">
                                            {{ substr($j->waktu_mulai, 0, 5) }} - {{ substr($j->waktu_selesai, 0, 5) }}
                                        </small>
                                    </td>
                                    <td>{{ $j->jenis_bimbingan }}</td>
                                    <td>
                                        <span class="badge {{ $j->status === 'Terjadwal' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $j->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; color: var(--muted); padding: 30px;">
                                        Belum ada jadwal bimbingan untuk siswa kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
