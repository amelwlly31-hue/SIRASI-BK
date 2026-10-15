@if(auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="layout-dashboard"></i></span>
        Dashboard
    </a>
    <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="user-cog"></i></span>
        Kelola Pengguna
    </a>
    <a href="{{ route('siswa.index') }}" class="menu-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="users-round"></i></span>
        Data Siswa
    </a>
    <a href="{{ route('pengaturan.index') }}" class="menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="settings"></i></span>
        Pengaturan
    </a>
@elseif(auth()->check() && auth()->user()->isWaliKelas())
    @php
        $idKelasWali = auth()->user()->id_kelas;
        $pendingPengajuanCount = $idKelasWali
            ? \App\Models\Penjadwalan::where('status', 'Diajukan')
                ->whereHas('siswa', function($q) use ($idKelasWali) {
                    $q->where('id_kelas', $idKelasWali);
                })
                ->count()
            : 0;
    @endphp
    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="layout-dashboard"></i></span>
        Dashboard Kelas
    </a>
    <a href="{{ route('wali.pengajuan.index') }}" class="menu-item {{ request()->routeIs('wali.pengajuan.*') ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span class="menu-icon"><i data-lucide="clipboard-check"></i></span>
            <span>Persetujuan BK</span>
        </div>
        @if ($pendingPengajuanCount > 0)
            <span style="background: #eab308; color: #1e293b; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 9999px;">
                {{ $pendingPengajuanCount }}
            </span>
        @endif
    </a>
    <a href="{{ route('pengaturan.index') }}" class="menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="settings"></i></span>
        Pengaturan
    </a>
@else
    {{-- Guru BK --}}
    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="home"></i></span>
        Dashboard
    </a>
    <a href="{{ route('siswa.index') }}" class="menu-item {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="users-round"></i></span>
        Data Siswa
    </a>
    <a href="{{ route('penjadwalan.index') }}" class="menu-item {{ request()->routeIs('penjadwalan.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="calendar-clock"></i></span>
        <span>Penjadwalan</span>
    </a>
    <a href="{{ route('konseling.index') }}" class="menu-item {{ request()->routeIs('konseling.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
        <span>Data Konseling</span>
    </a>
    <a href="{{ route('siswa.riwayat') }}" class="menu-item {{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="history"></i></span>
        Riwayat Siswa
    </a>
    <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="file-chart-column"></i></span>
        Laporan
    </a>
    <a href="{{ route('pengaturan.index') }}" class="menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
        <span class="menu-icon"><i data-lucide="settings"></i></span>
        Pengaturan
    </a>
@endif
