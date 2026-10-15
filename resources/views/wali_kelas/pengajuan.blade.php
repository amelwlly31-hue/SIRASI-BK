<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Pengajuan Konseling - SIRASI-BK</title>

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
        button, input, select, textarea { font-family: inherit; }

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
            gap: 24px;
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

        .alert-success { background: var(--green-bg); color: var(--green); border: 1px solid #b8ebd0; }
        .alert-danger { background: var(--red-bg); color: var(--red); border: 1px solid #ffccd0; }
        .alert-warning { background: var(--orange-bg); color: var(--orange); border: 1px solid #ffe1b5; }

        /* Stat Grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .stat-card {
            background: var(--white);
            padding: 20px;
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-orange { background: #fff4e3; color: #d98218; }
        .icon-blue { background: #eaf0ff; color: #173c91; }
        .icon-red { background: #fff0f0; color: #d64545; }
        .icon-green { background: #eaf8ef; color: #159447; }

        .stat-content {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            min-width: 280px;
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
            padding: 14px 18px;
            vertical-align: middle;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #f8faff;
        }

        /* Badges */
        .badge {
            font-size: 11px;
            padding: 4px 9px;
            border-radius: 6px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-diajukan { background: #fff4e3; color: #b45309; border: 1px solid #fde68a; }
        .badge-disetujui { background: #eaf0ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .badge-ditolak { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-terjadwal { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-selesai { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .badge-dibatalkan { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

        .urgent-tag {
            background: #fee2e2;
            color: #dc2626;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 4px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .6; }
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            border: none;
            transition: all .2s ease;
        }

        .btn-approve { background: #159447; color: var(--white); }
        .btn-approve:hover { background: #117839; }

        .btn-reject { background: #d64545; color: var(--white); }
        .btn-reject:hover { background: #b03636; }

        /* Modal */
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

        .modal.active { display: flex; }

        .modal-dialog {
            background: var(--white);
            width: 100%;
            max-width: 480px;
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
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafbfe;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close { background: none; border: none; color: var(--muted); cursor: pointer; display: flex; }

        .modal-body {
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .modal-info-box {
            background: #f8faff;
            border: 1px solid #e0e7ff;
            border-radius: 10px;
            padding: 14px;
            font-size: 13px;
            display: flex;
            flex-direction: column;
            gap: 4px;
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
            width: 100%;
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

        .pagination-container {
            padding: 18px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 1024px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .app { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .main { padding: 18px; }
            .stat-grid { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; align-items: stretch; }
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
                <h1>Persetujuan Pengajuan Konseling</h1>
                <p>Verifikasi & Izin Meninggalkan Jam Pelajaran untuk Siswa Kelas {{ $kelas ? $kelas->nama_kelas : '(Belum Ditugaskan)' }}</p>
            </div>

            <div class="profile-area">
                <div style="font-size: 13px; font-weight: 600; color: var(--primary);">
                    <i data-lucide="user-check" style="width: 16px; height: 16px; vertical-align: middle;"></i>
                    {{ auth()->user()->nama }}
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

        @if (!$kelas)
            <div class="alert alert-warning">
                <i data-lucide="alert-triangle"></i>
                <div>
                    <strong>Perhatian:</strong> Akun Anda belum memiliki penugasan kelas binaan. Hubungi Administrator untuk mengatur kelas perwalian Anda.
                </div>
            </div>
        @endif

        {{-- Stat Summary Cards --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon icon-orange"><i data-lucide="clock"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $totalMenunggu }}</span>
                    <span class="stat-label">Menunggu Persetujuan</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-blue"><i data-lucide="clipboard-check"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $totalDisetujui }}</span>
                    <span class="stat-label">Disetujui Wali Kelas</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-red"><i data-lucide="x-circle"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $totalDitolak }}</span>
                    <span class="stat-label">Ditolak Wali Kelas</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-green"><i data-lucide="calendar-check"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $totalTerjadwal }}</span>
                    <span class="stat-label">Terjadwal / Selesai</span>
                </div>
            </div>
        </div>

        {{-- Toolbar Filter & Search --}}
        <div class="toolbar">
            <form action="{{ route('wali.pengajuan.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <div class="search-box">
                    <span class="search-icon"><i data-lucide="search" style="width: 16px; height: 16px;"></i></span>
                    <input type="text" name="search" placeholder="Cari nama atau NIS siswa..." value="{{ request('search') }}">
                </div>

                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Diajukan" {{ request('status') === 'Diajukan' ? 'selected' : '' }}>Menunggu Persetujuan (Diajukan)</option>
                    <option value="Disetujui_Wali" {{ request('status') === 'Disetujui_Wali' ? 'selected' : '' }}>Disetujui Wali Kelas</option>
                    <option value="Ditolak_Wali" {{ request('status') === 'Ditolak_Wali' ? 'selected' : '' }}>Ditolak Wali Kelas</option>
                    <option value="Terjadwal" {{ request('status') === 'Terjadwal' ? 'selected' : '' }}>Terjadwal oleh BK</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ request('status') === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>

                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('wali.pengajuan.index') }}" class="btn-secondary" style="padding: 9px 14px; font-size: 13px;">Reset Filter</a>
                @endif
            </form>
        </div>

        {{-- Table Card --}}
        <div class="content-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rencana Jadwal</th>
                            <th>Data Siswa</th>
                            <th>Layanan Bimbingan</th>
                            <th>Catatan Siswa</th>
                            <th>Status Persetujuan</th>
                            <th>Respon Wali Kelas</th>
                            <th style="text-align: center;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $index => $p)
                            @php
                                $tgl = \Carbon\Carbon::parse($p->tanggal);
                                $isUrgent = $p->status === 'Diajukan' && ($tgl->isToday() || $tgl->isTomorrow());
                            @endphp
                            <tr>
                                <td>{{ $pengajuan->firstItem() + $index }}</td>
                                <td>
                                    <div><strong>{{ $tgl->isoFormat('D MMMM Y') }}</strong></div>
                                    <small style="color: var(--muted);">
                                        {{ substr($p->waktu_mulai, 0, 5) }} - {{ substr($p->waktu_selesai, 0, 5) }} WIB
                                    </small>
                                    @if ($isUrgent)
                                        <div><span class="urgent-tag">Perlu Segera Direspon</span></div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $p->siswa->nama_siswa ?? 'Siswa' }}</strong>
                                    <div><small style="color: var(--muted);">NIS: {{ $p->siswa->nis ?: '-' }}</small></div>
                                </td>
                                <td>{{ $p->jenis_bimbingan }}</td>
                                <td>
                                    <span style="color: var(--muted); font-size: 12px;">
                                        {{ $p->catatan ? \Illuminate\Support\Str::limit($p->catatan, 60) : '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($p->status === 'Diajukan')
                                        <span class="badge badge-diajukan">Menunggu Persetujuan</span>
                                    @elseif ($p->status === 'Disetujui_Wali')
                                        <span class="badge badge-disetujui">Disetujui Wali Kelas</span>
                                    @elseif ($p->status === 'Ditolak_Wali')
                                        <span class="badge badge-ditolak">Ditolak Wali Kelas</span>
                                    @elseif ($p->status === 'Terjadwal')
                                        <span class="badge badge-terjadwal">Dikonfirmasi Guru BK</span>
                                    @elseif ($p->status === 'Selesai')
                                        <span class="badge badge-selesai">Selesai</span>
                                    @else
                                        <span class="badge badge-dibatalkan">{{ $p->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->catatan_wali)
                                        <div style="font-size: 12px; font-weight: 500;">"{{ $p->catatan_wali }}"</div>
                                        @if ($p->waktu_persetujuan_wali)
                                            <small style="color: var(--muted);">{{ $p->waktu_persetujuan_wali->format('d/m/Y H:i') }}</small>
                                        @endif
                                    @else
                                        <span style="color: var(--muted);">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if ($p->status === 'Diajukan')
                                        <div style="display: inline-flex; gap: 8px;">
                                            <button type="button" class="btn-action btn-approve"
                                                onclick="openApproveModal({{ $p->id_penjadwalan }}, '{{ addslashes($p->siswa->nama_siswa ?? 'Siswa') }}', '{{ $tgl->isoFormat('D MMMM Y') }}', '{{ substr($p->waktu_mulai, 0, 5) }} - {{ substr($p->waktu_selesai, 0, 5) }}')">
                                                <i data-lucide="check" style="width: 14px; height: 14px;"></i> Setujui
                                            </button>
                                            <button type="button" class="btn-action btn-reject"
                                                onclick="openRejectModal({{ $p->id_penjadwalan }}, '{{ addslashes($p->siswa->nama_siswa ?? 'Siswa') }}', '{{ $tgl->isoFormat('D MMMM Y') }}')">
                                                <i data-lucide="x" style="width: 14px; height: 14px;"></i> Tolak
                                            </button>
                                        </div>
                                    @else
                                        <span style="color: var(--muted); font-size: 12px;">Selesai Diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; color: var(--muted); padding: 40px;">
                                    Belum ada pengajuan bimbingan konseling dari siswa kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pengajuan instanceof \Illuminate\Pagination\LengthAwarePaginator && $pengajuan->hasPages())
                <div class="pagination-container">
                    <span style="font-size: 13px; color: var(--muted);">
                        Menampilkan {{ $pengajuan->firstItem() }} s/d {{ $pengajuan->lastItem() }} dari {{ $pengajuan->total() }} pengajuan
                    </span>
                    {{ $pengajuan->links() }}
                </div>
            @endif
        </div>
    </main>
</div>

{{-- Modal Setujui --}}
<div class="modal" id="approveModal">
    <div class="modal-dialog">
        <form id="approveForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-header">
                <h3 style="color: var(--green);"><i data-lucide="check-circle-2"></i> Persetujuan Izin Konseling</h3>
                <button type="button" class="modal-close" onclick="closeApproveModal()"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div class="modal-info-box">
                    <div><strong>Siswa:</strong> <span id="approveSiswaName"></span></div>
                    <div><strong>Waktu Rencana:</strong> <span id="approveScheduleTime"></span></div>
                </div>

                <div class="form-group">
                    <label>Catatan Izin / Koordinasi (Opsional):</label>
                    <textarea name="catatan_wali" class="form-control" rows="3" placeholder="Contoh: Disetujui, sudah dikoordinasikan dengan Guru Matematika pada jam ke-3."></textarea>
                    <small style="color: var(--muted);">Catatan ini akan diteruskan ke Guru BK untuk penetapan jadwal.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeApproveModal()">Batal</button>
                <button type="submit" class="btn-action btn-approve" style="padding: 10px 18px; font-size: 13px;">
                    <i data-lucide="check"></i> Konfirmasi Setuju
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tolak --}}
<div class="modal" id="rejectModal">
    <div class="modal-dialog">
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-header">
                <h3 style="color: var(--red);"><i data-lucide="alert-triangle"></i> Penolakan Pengajuan Konseling</h3>
                <button type="button" class="modal-close" onclick="closeRejectModal()"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div class="modal-info-box" style="border-color: #fecaca; background: #fff5f5;">
                    <div><strong>Siswa:</strong> <span id="rejectSiswaName"></span></div>
                    <div><strong>Tanggal Rencana:</strong> <span id="rejectScheduleDate"></span></div>
                </div>

                <div class="form-group">
                    <label>Alasan Penolakan * (Wajib Diisi):</label>
                    <textarea name="catatan_wali" class="form-control" rows="3" placeholder="Contoh: Jam pelajaran tersebut ada ujian harian, mohon ajukan di jam istirahat atau sepulang sekolah." required minlength="5"></textarea>
                    <small style="color: var(--muted);">Jelaskan alasan penolakan agar siswa dan Guru BK dapat menyesuaikan.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn-action btn-reject" style="padding: 10px 18px; font-size: 13px;">
                    <i data-lucide="x"></i> Tolak Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();

    function openApproveModal(id, siswaName, date, time) {
        document.getElementById('approveForm').action = '/wali-kelas/pengajuan/' + id + '/approve';
        document.getElementById('approveSiswaName').innerText = siswaName;
        document.getElementById('approveScheduleTime').innerText = date + ' (' + time + ' WIB)';
        document.getElementById('approveModal').classList.add('active');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.remove('active');
    }

    function openRejectModal(id, siswaName, date) {
        document.getElementById('rejectForm').action = '/wali-kelas/pengajuan/' + id + '/reject';
        document.getElementById('rejectSiswaName').innerText = siswaName;
        document.getElementById('rejectScheduleDate').innerText = date;
        document.getElementById('rejectModal').classList.add('active');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
    }

    window.onclick = function(e) {
        if (e.target == document.getElementById('approveModal')) closeApproveModal();
        if (e.target == document.getElementById('rejectModal')) closeRejectModal();
    }
</script>
</body>
</html>
