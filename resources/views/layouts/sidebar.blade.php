{{-- =========================================================================
     STANDARDIZED SIDEBAR NAVIGATION SIRASI-BK
     SMP Negeri 2 Dramaga - Sistem Bimbingan dan Konseling
     ========================================================================= --}}
<aside class="sidebar">

    <div>
        @include('layouts.nav_identity')

        <div class="menu-title">Menu Utama</div>

        <nav class="menu">
            @include('partials.sidebar_menu')
        </nav>
    </div>

    {{-- Sidebar Bottom: Keluar --}}
    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Anda yakin ingin keluar dari sistem SIRASI-BK?');">
            @csrf
            <button type="submit" class="menu-item logout-button">
                <span class="menu-icon"><i data-lucide="log-out"></i></span>
                <span class="menu-label">Keluar</span>
            </button>
        </form>
    </div>

</aside>
