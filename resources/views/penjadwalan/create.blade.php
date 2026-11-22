<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Jadwal BK - SIRASI-BK</title>

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

        button,
        input,
        select,
        textarea {

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

        /* form card */

        .form-card {
            position: relative;
            overflow: hidden;

            border: 1px solid var(--border);
            border-radius: 20px;

            background: white;

            box-shadow: var(--shadow-md);
        }

        .form-card::before {
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

        .form-header {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 22px 25px;

            border-bottom: 1px solid var(--border);
        }

        .form-header-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: var(--primary-light);
            color: var(--primary);
        }

        .form-header-title {
            font-size: 14px;
            font-weight: 800;
        }

        .form-header-description {
            margin-top: 3px;

            color: var(--muted);

            font-size: 10px;
        }

        .form-body {
            padding: 25px;
        }

        .form-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            color: #4e596b;

            font-size: 11px;
            font-weight: 800;
        }

        .required {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            height: 43px;

            padding: 0 12px;

            border: 1px solid var(--border);
            border-radius: 10px;

            outline: none;

            background: #fafbfc;

            color: var(--text);

            font-size: 11px;

            transition: .2s ease;
        }

        textarea.form-control {
            height: 110px;
            padding: 12px;
            resize: vertical;
        }

        .form-control:focus {
            background: white;
            border-color: #91a8df;

            box-shadow:
                0 0 0 4px rgba(23,60,145,.05);
        }

        .form-error {
            color: var(--danger);
            font-size: 9px;
        }

        .form-help {
            color: #9299a7;
            font-size: 9px;
        }

        /* buttons */

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 10px;

            padding: 18px 25px;

            border-top: 1px solid var(--border);

            background: #fcfcfd;
        }

        .btn {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 0 16px;

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

            box-shadow:
                0 8px 20px rgba(23,60,145,.18);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        /* alert */

        .alert {
            margin-bottom: 18px;

            padding: 13px 15px;

            border: 1px solid #f0caca;
            border-radius: 10px;

            background: var(--danger-bg);

            color: var(--danger);

            font-size: 11px;
        }

        .alert ul {
            margin: 7px 0 0 17px;
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

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-footer {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .form-footer .btn {
                width: 100%;
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

        html.dark-mode .form-card {
            background: #162238 !important;
            border-color: #2a3953 !important;
        }

        html.dark-mode .form-header,
        html.dark-mode .form-footer {
            border-color: #2a3953 !important;
            background: #18263c !important;
        }

        html.dark-mode .form-label,
        html.dark-mode .form-header-title {
            color: #eef3ff !important;
        }

        html.dark-mode .form-header-description,
        html.dark-mode .page-description {
            color: #8f9db2 !important;
        }

        html.dark-mode .form-control,
        html.dark-mode .btn,
        html.dark-mode .notification {
            background: #1b2a42 !important;
            border-color: #33445f !important;
            color: #e7ecf7 !important;
        }

        html.dark-mode .form-control:focus {
            background: #1b2a42 !important;
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
                            {{ auth()->user()->role ?? 'Guru BK' }}
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

            <div class="page-heading">

                <div class="eyebrow">
                    Manajemen Bimbingan Konseling
                </div>

                <h1 class="page-title">
                    Tambah Jadwal BK
                </h1>

                <p class="page-description">
                    Tambahkan jadwal bimbingan konseling untuk siswa.
                </p>

            </div>

            {{-- validation error --}}
            @if ($errors->any())

                <div class="alert">

                    <strong>
                        Terdapat kesalahan pada data yang dimasukkan.
                    </strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- form --}}
            <form
                action="{{ route('penjadwalan.store') }}"
                method="POST"
                class="form-card"
            >

                @csrf

                <div class="form-header">

                    <div class="form-header-icon">
                        <i data-lucide="calendar-plus"></i>
                    </div>

                    <div>

                        <div class="form-header-title">
                            Informasi Jadwal
                        </div>

                        <div class="form-header-description">
                            Isi data jadwal bimbingan dengan lengkap.
                        </div>

                    </div>

                </div>

                <div class="form-body">

                    <div class="form-grid">

                        {{-- siswa --}}
                        <div class="form-group full">

                            <label class="form-label">
                                Siswa <span class="required">*</span>
                            </label>

                            <select
                                name="id_siswa"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    -- Pilih Siswa --
                                </option>

                                @foreach ($siswa as $item)

                                    <option
                                        value="{{ $item->id_siswa }}"
                                        {{ old('id_siswa') == $item->id_siswa ? 'selected' : '' }}
                                    >
                                        {{ $item->nama_siswa }}
                                        -
                                        {{ $item->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                                        (NIS: {{ $item->nis }})
                                    </option>

                                @endforeach

                            </select>

                            <div class="form-help">
                                Hanya siswa dengan status aktif yang ditampilkan.
                            </div>

                            @error('id_siswa')
                                <div class="form-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- tanggal --}}
                        <div class="form-group">

                            <label class="form-label">
                                Tanggal <span class="required">*</span>
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                value="{{ old('tanggal') }}"
                                class="form-control"
                                required
                            >

                            @error('tanggal')
                                <div class="form-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- jenis bimbingan --}}
                        <div class="form-group">

                            <label class="form-label">
                                Jenis Bimbingan <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="jenis_bimbingan"
                                value="{{ old('jenis_bimbingan') }}"
                                class="form-control"
                                placeholder="Contoh: Konseling Individu"
                                required
                            >

                            @error('jenis_bimbingan')
                                <div class="form-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- waktu mulai --}}
                        <div class="form-group">

                            <label class="form-label">
                                Waktu Mulai <span class="required">*</span>
                            </label>

                            <input
                                type="time"
                                name="waktu_mulai"
                                value="{{ old('waktu_mulai') }}"
                                class="form-control"
                                required
                            >

                            @error('waktu_mulai')
                                <div class="form-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- waktu selesai --}}
                        <div class="form-group">

                            <label class="form-label">
                                Waktu Selesai <span class="required">*</span>
                            </label>

                            <input
                                type="time"
                                name="waktu_selesai"
                                value="{{ old('waktu_selesai') }}"
                                class="form-control"
                                required
                            >

                            @error('waktu_selesai')
                                <div class="form-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- catatan --}}
                        <div class="form-group full">

                            <label class="form-label">
                                Catatan
                            </label>

                            <textarea
                                name="catatan"
                                class="form-control"
                                placeholder="Tambahkan catatan jika diperlukan..."
                            >{{ old('catatan') }}</textarea>

                            @error('catatan')
                                <div class="form-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

                <div class="form-footer">

                    <a
                        href="{{ route('penjadwalan.index') }}"
                        class="btn"
                    >
                        <i data-lucide="arrow-left"></i>
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i data-lucide="save"></i>
                        Simpan Jadwal
                    </button>

                </div>

            </form>

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
