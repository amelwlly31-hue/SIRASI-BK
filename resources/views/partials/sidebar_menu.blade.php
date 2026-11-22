@if(auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('dashboard') }}" class="menu-item {{ (request()->routeIs('dashboard*') || request()->is('dashboard*')) ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="home"></i></span>
        <span class="menu-label">Dashboard</span>
    </a>
    <a href="{{ route('users.index') }}" class="menu-item {{ (request()->routeIs('users.*') || request()->is('users*')) ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="user-cog"></i></span>
        <span class="menu-label">Kelola Pengguna</span>
    </a>
    <a href="{{ route('admin.siswa.index') }}" class="menu-item {{ (request()->routeIs('admin.siswa.*') || request()->is('admin/siswa*')) ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="users-round"></i></span>
        <span class="menu-label">Data Siswa</span>
    </a>
    <a href="{{ route('pengaturan.index') }}" class="menu-item {{ (request()->routeIs('pengaturan.*') || request()->is('pengaturan*')) ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="settings"></i></span>
        <span class="menu-label">Pengaturan</span>
    </a>
@elseif(auth()->check() && auth()->user()->isWaliKelas())
    @php
        $idKelasWali = auth()->user()->id_kelas;
        if (!$idKelasWali) {
            $idKelasWali = \App\Models\Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', auth()->id()))->value('id_kelas');
        }
        $pendingPengajuanCount = $idKelasWali
            ? \App\Models\Penjadwalan::where('status', 'Diajukan')
                ->whereHas('siswa', fn($sub) => $sub->where('id_kelas', $idKelasWali))
                ->count()
            : 0;
    @endphp
    <a href="{{ route('dashboard') }}" class="menu-item {{ (request()->routeIs('dashboard*') || request()->is('dashboard*')) ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="home"></i></span>
        <span class="menu-label">Dashboard Kelas</span>
    </a>
    <a href="{{ route('wali.pengajuan.index') }}" class="menu-item {{ (request()->routeIs('wali.pengajuan.*') || request()->is('wali-kelas/pengajuan*')) ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="clipboard-check"></i></span>
        <span class="menu-label">Approval Izin Siswa</span>
        @if ($pendingPengajuanCount > 0)
            <span class="menu-badge" style="margin-left: auto; background: #eab308; color: #1e293b; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 9999px; line-height: 1.3;">
                {{ $pendingPengajuanCount }}
            </span>
        @endif
    </a>
    <a href="{{ route('pengaturan.index') }}" class="menu-item {{ (request()->routeIs('pengaturan.*') || request()->is('pengaturan*')) ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="settings"></i></span>
        <span class="menu-label">Pengaturan</span>
    </a>
@else
    {{-- Guru BK --}}
    @php
        $isDashboardActive = request()->routeIs('dashboard*') || request()->is('dashboard*');
        $isSiswaShow = request()->routeIs('siswa.show') || (request()->is('siswa/*') && !request()->routeIs('siswa.create', 'siswa.edit', 'siswa.riwayat') && !request()->is('siswa/create', 'siswa/*/edit'));
        if ($isSiswaShow) {
            if (request('from') === 'siswa') {
                $isSiswaMenuActive = true;
                $isRiwayatMenuActive = false;
            } else {
                $isSiswaMenuActive = false;
                $isRiwayatMenuActive = true;
            }
        } else {
            $isSiswaMenuActive = (request()->routeIs('siswa.index', 'siswa.create', 'siswa.edit')
                || (request()->is('siswa*') && !request()->routeIs('siswa.riwayat') && !request()->is('riwayat-siswa*')));
            $isRiwayatMenuActive = request()->routeIs('siswa.riwayat') || request()->is('riwayat-siswa*');
        }
        $isPenjadwalanActive = request()->routeIs('penjadwalan.*') || request()->is('penjadwalan*');
        $isKonselingActive = request()->routeIs('konseling.*', 'tindak_lanjut.*') || request()->is('konseling*', 'tindak_lanjut*');
        $isLaporanActive = request()->routeIs('laporan.*') || request()->is('laporan*');
        $isPengaturanActive = request()->routeIs('pengaturan.*') || request()->is('pengaturan*');
    @endphp
    <a href="{{ route('dashboard') }}" class="menu-item {{ $isDashboardActive ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="home"></i></span>
        <span class="menu-label">Dashboard</span>
    </a>
    <a href="{{ route('siswa.index') }}" class="menu-item {{ $isSiswaMenuActive ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="users-round"></i></span>
        <span class="menu-label">Data Siswa</span>
    </a>
    <a href="{{ route('penjadwalan.index') }}" class="menu-item {{ $isPenjadwalanActive ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="calendar-clock"></i></span>
        <span class="menu-label">Penjadwalan</span>
    </a>
    <a href="{{ route('konseling.index') }}" class="menu-item {{ $isKonselingActive ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
        <span class="menu-label">Data Konseling</span>
    </a>
    <a href="{{ route('siswa.riwayat') }}" class="menu-item {{ $isRiwayatMenuActive ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="history"></i></span>
        <span class="menu-label">Riwayat Siswa</span>
    </a>
    <a href="{{ route('laporan.index') }}" class="menu-item {{ $isLaporanActive ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="file-chart-column"></i></span>
        <span class="menu-label">Laporan</span>
    </a>
    <a href="{{ route('pengaturan.index') }}" class="menu-item {{ $isPengaturanActive ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="settings"></i></span>
        <span class="menu-label">Pengaturan</span>
    </a>
@endif
