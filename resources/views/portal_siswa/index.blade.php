<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pengajuan Konseling Siswa - SIRASI-BK SMPN 2 Dramaga</title>

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
            --white: #ffffff;
            --text: #172033;
            --muted: #64748b;
            --border: #e2e8f0;
            --green: #15803d;
            --green-bg: #dcfce7;
            --orange: #b45309;
            --orange-bg: #fef3c7;
            --red: #b91c1c;
            --red-bg: #fee2e2;
            --shadow-sm: 0 4px 12px rgba(23, 60, 145, .06);
            --shadow-md: 0 10px 25px rgba(23, 60, 145, .08);
        }

        body {
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: radial-gradient(circle at 85% 0%, rgba(41, 67, 143, .07), transparent 30%), var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* Top Navbar */
        .portal-nav {
            background: linear-gradient(135deg, #102d70 0%, #173c91 100%);
            color: white;
            padding: 16px 28px;
            box-shadow: 0 4px 20px rgba(16, 45, 112, 0.15);
        }

        .portal-nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-title {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .3px;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #cbd8ff;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-btn {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .15s ease;
            cursor: pointer;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.22);
            color: white;
        }

        /* Container */
        .portal-container {
            max-width: 1100px;
            margin: 28px auto 0;
            padding: 0 20px;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13.5px;
        }

        .alert-success { background: var(--green-bg); border: 1px solid #bbf7d0; color: var(--green); }
        .alert-danger { background: var(--red-bg); border: 1px solid #fecaca; color: var(--red); }
        .alert-info { background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; }

        /* NIS Login Card */
        .login-card {
            background: var(--white);
            border-radius: 18px;
            padding: 36px 32px;
            max-width: 520px;
            margin: 40px auto;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            text-align: center;
        }

        .login-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .login-card h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .login-card p {
            font-size: 13.5px;
            color: var(--muted);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text);
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 14px;
            font-family: inherit;
            transition: all .2s;
            background: #fff;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 60, 145, 0.12);
        }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 13px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: background .15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
        }

        /* Student Dashboard Elements */
        .student-header-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px 28px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .student-profile {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .student-avatar {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
        }

        .student-meta h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .student-meta p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 3px;
        }

        .wali-badge {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Grid */
        .portal-grid {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 24px;
        }

        .card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .card-header h3 {
            font-size: 15px;
            font-weight: 800;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .status-Diajukan { background: var(--orange-bg); color: var(--orange); }
        .status-Disetujui_Wali { background: #ecfdf5; color: #047857; }
        .status-Terjadwal { background: var(--primary-light); color: var(--primary); }
        .status-Selesai { background: var(--green-bg); color: var(--green); }
        .status-Ditolak_Wali { background: var(--red-bg); color: var(--red); }
        .status-Dibatalkan { background: #f1f5f9; color: #64748b; }

        .request-item {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 14px;
            transition: all .15s ease;
            background: #ffffff;
        }

        .request-item:hover {
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
            border-color: #cbd5e1;
        }

        .request-item-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .request-date {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .request-time {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .request-service {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .request-note {
            font-size: 12.5px;
            color: #475569;
            background: #f8fafc;
            padding: 8px 12px;
            border-radius: 8px;
            margin-top: 8px;
        }

        .wali-response-box {
            margin-top: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            border-left: 3px solid var(--primary);
            background: #f0fdf4;
            color: #166534;
        }

        .wali-response-box.rejected {
            border-left-color: #dc2626;
            background: #fef2f2;
            color: #991b1b;
        }

        /* Slot Info */
        .busy-slot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: #fef3c7;
            border: 1px solid #fde68a;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 6px;
            color: #92400e;
        }

        @media (max-width: 860px) {
            .portal-grid {
                grid-template-columns: 1fr;
            }
            .student-header-card {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    {{-- Top Navbar --}}
    <nav class="portal-nav">
        <div class="portal-nav-inner">
            <a href="{{ route('portal.siswa.index') }}" class="brand-area">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo-smpn2-dramaga.png') }}?v=2" alt="Logo SMP Negeri 2 Dramaga">
                </div>
                <div>
                    <div class="brand-title">SIRASI-BK</div>
                    <div class="brand-subtitle">Portal Bimbingan Konseling Siswa</div>
                </div>
            </a>

            <div class="nav-actions">
                @if ($siswa)
                    <form action="{{ route('portal.siswa.logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-btn">
                            <i data-lucide="log-out" style="width: 14px; height: 14px;"></i>
                            Ganti Siswa / Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-btn">
                        <i data-lucide="lock" style="width: 14px; height: 14px;"></i>
                        Login Petugas
                    </a>
                @endif
            </div>
        </div>
    </nav>

    {{-- Content Container --}}
    <main class="portal-container">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i data-lucide="check-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                <i data-lucide="info" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                <div>{{ session('info') }}</div>
            </div>
        @endif

        @if (!$siswa)
            {{-- Guest Mode: Form Verifikasi NIS --}}
            <div class="login-card">
                <div class="login-icon">
                    <i data-lucide="user-check" style="width: 32px; height: 32px;"></i>
                </div>
                <h2>Masuk Portal Pengajuan Siswa</h2>
                <p>Masukkan Nomor Induk Siswa (NIS) Anda yang terdaftar di SMP Negeri 2 Dramaga untuk mengajukan jadwal atau melihat status bimbingan.</p>

                <form action="{{ route('portal.siswa.login') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="nis">Nomor Induk Siswa (NIS)</label>
                        <input
                            type="text"
                            id="nis"
                            name="nis"
                            class="form-control"
                            placeholder="Contoh: 70701"
                            value="{{ old('nis') }}"
                            required
                            autofocus
                        >
                        @error('nis')
                            <div style="color: var(--red); font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                        Lanjutkan ke Portal
                    </button>
                </form>

                <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border); font-size: 12.5px; color: var(--muted); text-align: left;">
                    <strong>Alur Pengajuan Konseling Mandiri:</strong>
                    <ol style="margin-left: 18px; margin-top: 8px; line-height: 1.6;">
                        <li>Masukkan NIS Anda.</li>
                        <li>Pilih tanggal dan jam bimbingan yang diinginkan.</li>
                        <li>Wali Kelas memeriksa jadwal dan memberikan koordinasi izin jam pelajaran.</li>
                        <li>Guru BK menetapkan jadwal resmi dan notifikasi terbit di sistem.</li>
                    </ol>
                </div>
            </div>
        @else
            {{-- Authenticated Student Mode --}}
            <div class="student-header-card">
                <div class="student-profile">
                    <div class="student-avatar">
                        {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                    </div>
                    <div class="student-meta">
                        <h2>{{ $siswa->nama_siswa }}</h2>
                        <p>NIS: <strong>{{ $siswa->nis }}</strong> &nbsp;•&nbsp; Kelas: <strong>{{ $siswa->kelas->nama_kelas ?? '-' }}</strong> &nbsp;•&nbsp; Status: <span style="color: var(--green); font-weight: 700;">{{ $siswa->status }}</span></p>
                    </div>
                </div>

                <div class="wali-badge">
                    <i data-lucide="user-check" style="width: 16px; height: 16px;"></i>
                    <span>Wali Kelas: <strong>{{ $siswa->kelas->waliKelas->nama ?? '(Belum Ditugaskan)' }}</strong></span>
                </div>
            </div>

            <div class="portal-grid">
                {{-- Left Column: Form Pengajuan Baru --}}
                <div class="card">
                    <div class="card-header">
                        <h3><i data-lucide="calendar-plus"></i> Ajukan Jadwal Bimbingan Konseling</h3>
                    </div>

                    {{-- Cek Ketersediaan Slot Guru BK --}}
                    <div style="margin-bottom: 20px; padding: 12px 14px; background: #f8fafc; border: 1px solid var(--border); border-radius: 10px;">
                        <form method="GET" action="{{ route('portal.siswa.index') }}" style="display: flex; gap: 8px; align-items: flex-end;">
                            <div style="flex: 1;">
                                <label style="font-size: 11px; font-weight: 700; color: var(--muted); display: block; margin-bottom: 4px;">Lihat Slot Terisi pada Tanggal:</label>
                                <input type="date" name="tanggal" value="{{ $selectedDate }}" class="form-control" style="padding: 7px 10px; font-size: 13px;">
                            </div>
                            <button type="submit" class="nav-btn" style="background: var(--primary); padding: 8px 12px;">Cek</button>
                        </form>

                        @if ($jadwalTerisi->count() > 0)
                            <div style="margin-top: 10px;">
                                <span style="font-size: 11.5px; font-weight: 700; color: #92400e; display: block; margin-bottom: 4px;">Slot yang sudah terisi Guru BK:</span>
                                @foreach ($jadwalTerisi as $slot)
                                    <div class="busy-slot">
                                        <span><strong>{{ substr($slot->waktu_mulai, 0, 5) }} - {{ substr($slot->waktu_selesai, 0, 5) }}</strong> ({{ $slot->jenis_bimbingan }})</span>
                                        <span style="font-size: 10.5px; font-weight: 700; text-transform: uppercase;">{{ str_replace('_', ' ', $slot->status) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="margin-top: 8px; font-size: 12px; color: var(--green); display: flex; align-items: center; gap: 4px;">
                                <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                                Belum ada jadwal terisi pada tanggal ini. Slot tersedia!
                            </div>
                        @endif
                    </div>

                    {{-- Form Ajukan --}}
                    <form action="{{ route('portal.siswa.ajukan') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <label for="tanggal">Tanggal Bimbingan <span>*</span></label>
                            <input
                                type="date"
                                id="tanggal"
                                name="tanggal"
                                class="form-control"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('tanggal', $selectedDate) }}"
                                required
                            >
                            @error('tanggal')
                                <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-grid-2">
                            <div class="input-group">
                                <label for="waktu_mulai">Jam Mulai <span>*</span></label>
                                <input
                                    type="time"
                                    id="waktu_mulai"
                                    name="waktu_mulai"
                                    class="form-control"
                                    value="{{ old('waktu_mulai', '08:30') }}"
                                    required
                                >
                                @error('waktu_mulai')
                                    <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group">
                                <label for="waktu_selesai">Jam Selesai <span>*</span></label>
                                <input
                                    type="time"
                                    id="waktu_selesai"
                                    name="waktu_selesai"
                                    class="form-control"
                                    value="{{ old('waktu_selesai', '09:15') }}"
                                    required
                                >
                                @error('waktu_selesai')
                                    <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="jenis_bimbingan">Jenis Layanan Bimbingan <span>*</span></label>
                            <select id="jenis_bimbingan" name="jenis_bimbingan" class="form-control" required>
                                <option value="">-- Pilih Jenis Bimbingan --</option>
                                <option value="Konseling Pribadi" {{ old('jenis_bimbingan') == 'Konseling Pribadi' ? 'selected' : '' }}>Konseling Pribadi</option>
                                <option value="Konseling Belajar" {{ old('jenis_bimbingan') == 'Konseling Belajar' ? 'selected' : '' }}>Konseling Belajar</option>
                                <option value="Konseling Sosial" {{ old('jenis_bimbingan') == 'Konseling Sosial' ? 'selected' : '' }}>Konseling Sosial</option>
                                <option value="Bimbingan Karier" {{ old('jenis_bimbingan') == 'Bimbingan Karier' ? 'selected' : '' }}>Bimbingan Karier</option>
                                <option value="Konseling Individu" {{ old('jenis_bimbingan') == 'Konseling Individu' ? 'selected' : '' }}>Konseling Individu</option>
                            </select>
                            @error('jenis_bimbingan')
                                <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="catatan">Alasan / Catatan Pengajuan (Opsional)</label>
                            <textarea
                                id="catatan"
                                name="catatan"
                                class="form-control"
                                rows="3"
                                placeholder="Jelaskan secara singkat topik yang ingin Anda bicarakan dengan Guru BK..."
                            >{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div style="color: var(--red); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            <i data-lucide="send" style="width: 16px; height: 16px;"></i>
                            Kirim Pengajuan Bimbingan
                        </button>
                    </form>
                </div>

                {{-- Right Column: Riwayat & Status Pengajuan --}}
                <div class="card">
                    <div class="card-header">
                        <h3><i data-lucide="history"></i> Status Pengajuan Konseling Saya</h3>
                        <span style="font-size: 12px; color: var(--muted);">Total: {{ $pengajuan->count() }}</span>
                    </div>

                    @forelse ($pengajuan as $item)
                        <div class="request-item">
                            <div class="request-item-top">
                                <div class="request-date">
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

                            <div class="request-time">
                                <i data-lucide="clock" style="width: 13px; height: 13px; display: inline-block; vertical-align: middle;"></i>
                                Pukul {{ substr($item->waktu_mulai, 0, 5) }} - {{ substr($item->waktu_selesai, 0, 5) }} WIB
                            </div>

                            <div class="request-service" style="margin-top: 8px;">
                                Layanan: <strong>{{ $item->jenis_bimbingan }}</strong>
                            </div>

                            @if (!empty($item->catatan))
                                <div class="request-note">
                                    <em>"{{ $item->catatan }}"</em>
                                </div>
                            @endif

                            {{-- Catatan respon Wali Kelas --}}
                            @if (!empty($item->id_wali) || !empty($item->catatan_wali))
                                <div class="wali-response-box {{ $item->status === 'Ditolak_Wali' ? 'rejected' : '' }}">
                                    <strong>Respon Wali Kelas ({{ $item->waliKelas->nama ?? 'Wali Kelas' }}):</strong>
                                    <p style="margin-top: 3px;">
                                        @if ($item->status === 'Ditolak_Wali')
                                            Alasan Penolakan: <em>"{{ $item->catatan_wali }}"</em>
                                        @else
                                            Catatan: <em>"{{ $item->catatan_wali ?: 'Disetujui untuk mengikuti bimbingan konseling.' }}"</em>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--muted); padding: 40px 20px;">
                            <i data-lucide="calendar-x" style="width: 38px; height: 38px; margin: 0 auto 10px; display: block; opacity: .5;"></i>
                            <p style="font-size: 13.5px;">Belum ada riwayat pengajuan bimbingan konseling.</p>
                            <small>Silakan gunakan formulir di samping untuk mengajukan jadwal konsultasi pertama Anda.</small>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
