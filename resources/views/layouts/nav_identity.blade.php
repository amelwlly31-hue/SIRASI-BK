        {{-- Profil pengguna dipindahkan ke bagian atas sidebar. --}}
        @php
            $sidebarUser = auth()->user();
        @endphp
        <div class="sirasi-sidebar-user">
            <div class="sirasi-sidebar-avatar">
                @if ($sidebarUser && $sidebarUser->foto_profil)
                    <img src="{{ asset('storage/' . $sidebarUser->foto_profil) }}" alt="Foto profil {{ $sidebarUser->nama ?? $sidebarUser->name }}">
                @else
                    <span>{{ strtoupper(substr($sidebarUser->nama ?? $sidebarUser->name ?? 'U', 0, 1)) }}</span>
                @endif
            </div>
            <div class="sirasi-sidebar-user-name">{{ $sidebarUser->nama ?? $sidebarUser->name ?? 'Pengguna' }}</div>
        </div>


@once
    <style>
        .sidebar { --active-tab-bg:#eaf0fa; height:100vh !important; min-height:100vh !important; display:flex !important; flex-direction:column !important; justify-content:space-between !important; overflow:visible !important; padding-right:var(--sirasi-active-tab-bleed, 16px) !important; background:#eee5e1 !important; box-shadow:none !important; border-right:0 !important; }
        .sidebar > div:first-child { display:flex !important; min-height:0 !important; flex:1 1 auto !important; flex-direction:column !important; overflow:visible !important; }
        .sidebar .sirasi-sidebar-user { display:flex; align-items:center; flex:0 0 auto; flex-direction:column; gap:0; padding:8px 14px 12px; margin:0 0 5px; border-bottom:1px solid rgba(125,101,112,.18); text-align:center; }
        .sidebar .sirasi-sidebar-avatar { display:grid; width:68px; height:68px; flex:0 0 68px; place-items:center; overflow:hidden; border:2px solid rgba(255,255,255,.8); border-radius:50%; background:#e0d5d1; color:#695564; box-shadow:0 3px 9px rgba(64,46,54,.10); font-size:18px; font-weight:700; }
        .sidebar .sirasi-sidebar-avatar img { width:100%; height:100%; border-radius:50%; object-fit:cover; }
        .sidebar .sirasi-sidebar-user-name { min-width:0; max-width:100%; flex:0 1 auto; margin:8px 0 0; overflow:hidden; color:#574452; font-size:14px; font-weight:600; text-overflow:ellipsis; text-align:center; white-space:nowrap; }
        .sidebar nav.menu { display:flex !important; width:calc(100% + var(--sirasi-active-tab-bleed, 16px)) !important; min-height:0; flex:1 1 auto; flex-direction:column !important; gap:4px !important; margin-right:calc(-1 * var(--sirasi-active-tab-bleed, 16px)) !important; overflow:visible !important; scrollbar-width:thin; scrollbar-color:rgba(107,83,98,.22) transparent; }
        .sidebar nav.menu::-webkit-scrollbar { width:5px; }
        .sidebar nav.menu::-webkit-scrollbar-thumb { border-radius:99px; background:rgba(107,83,98,.22); }
        .sidebar nav.menu > .menu-item,
        .sidebar nav.menu > a { min-height:42px !important; padding-top:0 !important; padding-bottom:0 !important; }
        .sidebar nav.menu .menu-icon,
        .sidebar .sidebar-bottom .logout-button .menu-icon { width:32px !important; height:32px !important; flex:0 0 32px !important; padding:0 !important; }
        .sidebar nav.menu .menu-icon > svg,
        .sidebar nav.menu .menu-icon > i { width:26px !important; height:26px !important; }
        .sidebar .sidebar-bottom { position:relative !important; z-index:5; flex:0 0 auto !important; width:100%; padding:8px 0 !important; margin-top:auto !important; border-top:0 !important; background:transparent !important; }
        .sidebar .sidebar-bottom form { width:100%; }
        .sidebar .sidebar-bottom .logout-button { display:flex !important; align-items:center !important; justify-content:flex-start !important; width:100% !important; min-height:42px !important; gap:13px !important; padding:0 14px !important; border:1px solid transparent !important; border-radius:10px !important; background:transparent !important; color:#756671 !important; box-shadow:none !important; font-size:13.5px !important; font-weight:600 !important; text-align:left !important; transform:none; }
        .sidebar .sidebar-bottom .logout-button:hover { border-color:transparent !important; background:linear-gradient(100deg,rgba(255,255,255,.5),rgba(255,255,255,.18)) !important; color:#574452 !important; box-shadow:inset 0 1px rgba(255,255,255,.7) !important; transform:translateY(-1px); }
        .sidebar .sidebar-bottom .logout-button::after { content:none !important; display:none !important; }
        .sidebar .sidebar-bottom .logout-button .menu-icon { display:flex !important; width:30px !important; height:30px !important; flex:0 0 30px !important; align-items:center !important; justify-content:center !important; padding:0 !important; border:0 !important; border-radius:0 !important; background:transparent !important; color:#806e79 !important; }
        .sidebar .sidebar-bottom .logout-button .menu-icon svg,
        .sidebar .sidebar-bottom .logout-button .menu-icon i { width:26px !important; height:26px !important; }
        .sidebar .sidebar-bottom .logout-button:hover .menu-icon { border-color:transparent !important; background:transparent !important; color:#5a4052 !important; }
        body .sidebar nav.menu > .menu-item, body .sidebar nav.menu > a { display:flex !important; width:calc(100% - var(--sirasi-active-tab-bleed, 16px)) !important; align-items:center !important; min-height:40px !important; padding:0 12px !important; gap:10px !important; border:1px solid transparent !important; border-radius:10px !important; color:#756671 !important; font-size:13px !important; font-weight:600 !important; text-decoration:none !important; transition:all .2s ease !important; }
        body .sidebar nav.menu > .menu-item:hover, body .sidebar nav.menu > a:hover { border-color:transparent !important; background:linear-gradient(100deg,rgba(255,255,255,.5),rgba(255,255,255,.18)) !important; color:#574452 !important; box-shadow:inset 0 1px rgba(255,255,255,.7) !important; transform:translateY(-1px); }
        body .sidebar nav.menu > .menu-item, body .sidebar nav.menu > a { position:relative !important; overflow:hidden; }
        body .sidebar nav.menu > .menu-item::after, body .sidebar nav.menu > a::after { content:none !important; display:none !important; }
        body .sidebar nav.menu .menu-icon { border:0 !important; border-radius:0 !important; background:transparent !important; color:#806e79 !important; }
        body .sidebar nav.menu .menu-icon > svg { width:26px !important; height:26px !important; color:inherit !important; }
        body .sidebar nav.menu > .menu-item.active, body .sidebar nav.menu > a.active { z-index:2 !important; width:100% !important; margin-right:0 !important; overflow:visible !important; border-radius:12px 0 0 12px !important; background:#f8f3f0 !important; border-color:transparent !important; color:#4f3d4b !important; box-shadow:0 3px 9px rgba(71,51,61,.08),inset 0 1px rgba(255,255,255,.88) !important; font-weight:700 !important; }
        body .sidebar nav.menu > .menu-item.active .menu-icon, body .sidebar nav.menu > a.active .menu-icon { border:0 !important; outline:0 !important; background:transparent !important; box-shadow:none !important; color:#173b82 !important; }
        body .sidebar nav.menu > .menu-item.active .menu-icon::before, body .sidebar nav.menu > .menu-item.active .menu-icon::after, body .sidebar nav.menu > a.active .menu-icon::before, body .sidebar nav.menu > a.active .menu-icon::after { content:none !important; display:none !important; box-shadow:none !important; }
        body .sidebar .sidebar-bottom { padding:8px 0 !important; border-top:0 !important; }
        body .sidebar .sidebar-bottom .logout-button { min-height:40px !important; padding:0 12px !important; gap:10px !important; border-radius:10px !important; background:transparent !important; color:#756671 !important; }
        body .sidebar .sidebar-bottom .logout-button:hover { border-color:transparent !important; background:linear-gradient(100deg,rgba(255,255,255,.5),rgba(255,255,255,.18)) !important; color:#574452 !important; }
        body .sidebar .sidebar-bottom .logout-button .menu-icon { border:0 !important; border-radius:0 !important; background:transparent !important; color:#806e79 !important; }
        /* Shared sidebar palette and active-tab treatment for every authenticated role. */
        html body .sidebar {
            --active-tab-bg:#eaf0fa;
            --sirasi-active-tab-bleed:16px;
            padding-right:var(--sirasi-active-tab-bleed, 16px) !important;
            overflow:visible !important;
            background:linear-gradient(160deg,#133985 0%,#17429e 50%,#1d52bd 100%) !important;
            -webkit-backdrop-filter:blur(16px);
            backdrop-filter:blur(16px);
            border-right:0 !important;
            box-shadow:none !important;
        }
        html body.dark-mode .sidebar {
            --active-tab-bg:#121d31;
            border-right:0 !important;
            box-shadow:none !important;
        }
        html body:not(.sirasi-portal),
        html body:not(.sirasi-portal) .app,
        html body:not(.sirasi-portal) .main,
        html body:not(.sirasi-portal) .main-content,
        html body:not(.sirasi-portal) .settings-main {
            background:#eaf0fa !important;
        }
        html body.dark-mode:not(.sirasi-portal),
        html body.dark-mode:not(.sirasi-portal) .app,
        html body.dark-mode:not(.sirasi-portal) .main,
        html body.dark-mode:not(.sirasi-portal) .main-content,
        html body.dark-mode:not(.sirasi-portal) .settings-main {
            background:#121d31 !important;
        }
        body .sidebar .sirasi-sidebar-user { border-bottom-color:rgba(255,255,255,.2) !important; }
        body .sidebar .sirasi-sidebar-avatar { color:#fff !important; }
        body .sidebar .sirasi-sidebar-user-name,
        body .sidebar .menu-title { color:rgba(255,255,255,.9) !important; }
        body .sidebar .menu-label { white-space:nowrap !important; }
        html body .sidebar nav.menu { display:flex !important; width:calc(100% + var(--sirasi-active-tab-bleed, 16px)) !important; min-height:0; flex:1 1 auto; flex-direction:column !important; gap:4px !important; margin-right:calc(-1 * var(--sirasi-active-tab-bleed, 16px)) !important; scrollbar-color:rgba(255,255,255,.38) transparent !important; overflow:visible !important; }
        body .sidebar nav.menu::-webkit-scrollbar-thumb { background:rgba(255,255,255,.3) !important; }
        html body .sidebar nav.menu > .menu-item,
        html body .sidebar nav.menu > a,
        html body .sidebar .sidebar-bottom .logout-button {
            color:rgba(255,255,255,.8) !important;
        }
        html body .sidebar nav.menu .menu-icon,
        html body .sidebar .sidebar-bottom .logout-button .menu-icon { color:rgba(255,255,255,.82) !important; }
        html body .sidebar nav.menu > .menu-item:not(.active):hover,
        html body .sidebar nav.menu > a:not(.active):hover,
        html body .sidebar .sidebar-bottom .logout-button:hover {
            background:rgba(255,255,255,.08) !important;
            color:#fff !important;
            box-shadow:inset 0 1px rgba(255,255,255,.12) !important;
        }
        html body .sidebar nav.menu > .menu-item:not(.active):hover .menu-icon,
        html body .sidebar nav.menu > a:not(.active):hover .menu-icon,
        html body .sidebar .sidebar-bottom .logout-button:hover .menu-icon { color:#fff !important; }
        html body .sidebar nav.menu > .menu-item.active,
        html body .sidebar nav.menu > a.active,
        html body .sidebar nav.menu > .menu-item.active:hover,
        html body .sidebar nav.menu > a.active:hover {
            position:relative !important;
            z-index:2 !important;
            width:calc(100% + 1px) !important;
            margin-left:0 !important;
            margin-right:-1px !important;
            overflow:visible !important;
            border:0 !important;
            border-top-left-radius:9999px !important;
            border-bottom-left-radius:9999px !important;
            border-top-right-radius:0 !important;
            border-bottom-right-radius:0 !important;
            background:var(--active-tab-bg, #eaf0fa) !important;
            color:#1d4ed8 !important;
            font-weight:600 !important;
            box-shadow:none !important;
            transform:none !important;
        }
        html body .sidebar nav.menu > .menu-item.active .menu-icon,
        html body .sidebar nav.menu > a.active .menu-icon,
        html body .sidebar nav.menu > .menu-item.active:hover .menu-icon,
        html body .sidebar nav.menu > a.active:hover .menu-icon,
        html body .sidebar nav.menu > .menu-item.active .menu-icon > svg,
        html body .sidebar nav.menu > a.active .menu-icon > svg { background:transparent !important; color:#1d4ed8 !important; border:0 !important; box-shadow:none !important; transform:none !important; }
        html body.dark-mode .sidebar nav.menu > .menu-item.active,
        html body.dark-mode .sidebar nav.menu > a.active,
        html body.dark-mode .sidebar nav.menu > .menu-item.active:hover,
        html body.dark-mode .sidebar nav.menu > a.active:hover {
            background:var(--active-tab-bg, #121d31) !important;
            color:#60a5fa !important;
        }
        html body.dark-mode .sidebar nav.menu > .menu-item.active .menu-icon,
        html body.dark-mode .sidebar nav.menu > a.active .menu-icon,
        html body.dark-mode .sidebar nav.menu > .menu-item.active:hover .menu-icon,
        html body.dark-mode .sidebar nav.menu > a.active:hover .menu-icon,
        html body.dark-mode .sidebar nav.menu > .menu-item.active .menu-icon > svg,
        html body.dark-mode .sidebar nav.menu > a.active .menu-icon > svg { background:transparent !important; color:#60a5fa !important; border:0 !important; box-shadow:none !important; transform:none !important; }
        html body .sidebar nav.menu > .menu-item.active::before,
        html body .sidebar nav.menu > a.active::before,
        html body .sidebar nav.menu > .menu-item.active:hover::before,
        html body .sidebar nav.menu > a.active:hover::before {
            content:"" !important;
            display:block !important;
            position:absolute !important;
            right:0 !important;
            top:-24px !important;
            bottom:auto !important;
            left:auto !important;
            width:24px !important;
            height:24px !important;
            background:transparent !important;
            border-radius:0 0 24px 0 !important;
            border-bottom-right-radius:24px !important;
            box-shadow:10px 10px 0 10px var(--active-tab-bg, #eaf0fa) !important;
            clip-path:inset(0) !important;
            pointer-events:none !important;
            z-index:3 !important;
            transform:none !important;
            opacity:1 !important;
        }
        html body .sidebar nav.menu > .menu-item.active::after,
        html body .sidebar nav.menu > a.active::after,
        html body .sidebar nav.menu > .menu-item.active:hover::after,
        html body .sidebar nav.menu > a.active:hover::after {
            content:"" !important;
            display:block !important;
            position:absolute !important;
            right:0 !important;
            bottom:-24px !important;
            top:auto !important;
            left:auto !important;
            width:24px !important;
            height:24px !important;
            background:transparent !important;
            border-radius:0 24px 0 0 !important;
            border-top-right-radius:24px !important;
            box-shadow:10px -10px 0 10px var(--active-tab-bg, #eaf0fa) !important;
            clip-path:inset(0) !important;
            pointer-events:none !important;
            z-index:3 !important;
            transform:none !important;
            opacity:1 !important;
        }
        .sirasi-global-header { display:flex !important; flex-direction:row !important; align-items:center !important; justify-content:space-between !important; gap:20px !important; }
        .sirasi-global-header .header-title { display:none !important; }
        .sirasi-global-page-title { margin-left:0; }
        .sirasi-global-back { display:grid; width:36px; height:36px; flex:0 0 36px; place-items:center; border:1px solid #dce5f2; border-radius:10px; color:#315b9e; background:#fff; }
        .sirasi-global-back svg { width:18px; height:18px; }
        .sirasi-global-actions { display:flex !important; align-items:center; justify-content:flex-end; gap:12px; margin-left:auto; }
        .sirasi-global-header .sirasi-global-search,
        .sirasi-global-header .header-search,
        .sirasi-global-header .search-box,
        .sirasi-global-header .search { display: none !important; }
        .sirasi-theme-toggle { display:grid; width:40px; height:40px; flex:0 0 40px; place-items:center; padding:0; border:1px solid #e0e6ef; border-radius:10px; background:#fff; color:#52627a; box-shadow:0 2px 6px rgba(25,45,80,.035); cursor:pointer; transition:all .18s ease; }
        .sirasi-theme-toggle:hover { border-color:#c8d6ed; background:#f5f8fe; color:#285dbb; transform:translateY(-1px); }
        .sirasi-theme-toggle:focus-visible { outline:3px solid rgba(59,109,207,.2); outline-offset:2px; }
        .sirasi-theme-toggle svg { width:18px; height:18px; }
        .sirasi-theme-toggle .theme-icon-sun { display:none; }
        .sirasi-theme-toggle[aria-pressed="true"] .theme-icon-sun { display:block; }
        .sirasi-theme-toggle[aria-pressed="true"] .theme-icon-moon { display:none; }
        .sirasi-global-header .notification-wrapper { position:relative; flex:0 0 auto; }
        .sirasi-global-header button.notification, .sirasi-global-header button.notification-btn, .sirasi-global-header button.bell { position:relative; display:grid; width:40px !important; height:40px !important; flex:0 0 40px !important; place-items:center; padding:0; border:1px solid #e0e6ef; border-radius:10px; background:#fff; color:#52627a; box-shadow:0 2px 6px rgba(25,45,80,.035); cursor:pointer; transition:all .18s ease; }
        .sirasi-global-header button.notification:hover, .sirasi-global-header button.notification-btn:hover, .sirasi-global-header button.bell:hover { border-color:#c8d6ed; background:#f5f8fe; color:#285dbb; transform:translateY(-1px); }
        .sirasi-global-header button.notification svg, .sirasi-global-header button.notification-btn svg, .sirasi-global-header button.bell svg { width:18px !important; height:18px !important; }
        .notification-item-icon { width:34px !important; height:34px !important; flex:0 0 34px !important; }
        .notification-item-icon svg, .notification-item-icon i { width:16px !important; height:16px !important; }
        .stat-icon, .stat-icon-wrapper, .summary-icon { width:42px !important; height:42px !important; flex:0 0 42px !important; }
        .stat-icon svg, .stat-icon-wrapper svg, .summary-icon svg { width:20px !important; height:20px !important; }
        .filter-icon, .filter-heading-icon, .table-title-icon, .card-icon, .report-icon, .panel-icon-badge { width:36px !important; height:36px !important; flex:0 0 36px !important; }
        .filter-icon svg, .filter-heading-icon svg, .table-title-icon svg, .card-icon svg, .report-icon svg, .panel-icon-badge svg { width:18px !important; height:18px !important; }
        .sirasi-global-header .notification-dot { position:absolute; top:6px !important; right:6px !important; width:9px; height:9px; border:2px solid #fff; border-radius:50%; background:#ef4444; }
        .sirasi-global-header .profile { display:none !important; }
        body.dark-mode .sirasi-theme-toggle { border-color:#334463; background:#18253c; color:#bfd0ef; }
        body.dark-mode .sirasi-theme-toggle:hover { border-color:#5878b4; background:#203250; color:#fff; }
        body.dark-mode .sirasi-global-header button.notification, body.dark-mode .sirasi-global-header button.notification-btn, body.dark-mode .sirasi-global-header button.bell { border-color:#334463; background:#18253c; color:#bfd0ef; }
        body.dark-mode .sirasi-global-header button.notification:hover, body.dark-mode .sirasi-global-header button.notification-btn:hover, body.dark-mode .sirasi-global-header button.bell:hover { border-color:#5878b4; background:#203250; color:#fff; }
        @media(max-width:900px) { .sidebar .sirasi-sidebar-user { justify-content:center; padding:8px 0 10px; margin-bottom:4px; } .sidebar .sirasi-sidebar-avatar { width:68px; height:68px; flex-basis:68px; font-size:18px; } }
        @media(max-width:600px) { .sirasi-global-header { gap:8px !important; padding-right:14px !important; padding-left:14px !important; } .sirasi-global-page-title { font-size:14px; } .sirasi-global-actions { gap:7px; } .sirasi-theme-toggle { width:36px; height:36px; flex-basis:36px; } }
    </style>
    @include('layouts.page_title_system')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Guard kondisi single-active menu sidebar pada detail siswa (/siswa/{id})
            if (/\/siswa\/\d+/i.test(window.location.pathname)) {
                var isFromSiswa = new URLSearchParams(window.location.search).get('from') === 'siswa';
                document.querySelectorAll('.sidebar nav.menu > .menu-item, .sidebar nav.menu > a').forEach(function (item) {
                    var label = (item.querySelector('.menu-label') ? item.querySelector('.menu-label').textContent : item.textContent).trim();
                    if (label.includes('Data Siswa')) {
                        item.classList.toggle('active', isFromSiswa);
                    } else if (label.includes('Riwayat Siswa')) {
                        item.classList.toggle('active', !isFromSiswa);
                    }
                });
            }

            document.querySelectorAll('.main > .header, .main > .topbar, main > .header, main > .topbar').forEach(function (header) {
                if (header.dataset.sirasiHeaderReady === 'true') return;
                header.dataset.sirasiHeaderReady = 'true';
                header.classList.add('sirasi-global-header');

                var explicitTitle = header.getAttribute('data-page-title');
                var titleSource = explicitTitle ? null : document.querySelector('.content .page-title h1, .content h1.page-title, .main-content .page-title h1, .main-content h1.page-title, .page-top h1, .content h1, .page-heading h1');
                if (!explicitTitle && !titleSource) titleSource = header.querySelector('.header-title h1') || document.querySelector('main h1');
                var title = explicitTitle || (titleSource ? titleSource.textContent.trim() : document.title.split(' - ')[0]);
                var titleNode = document.createElement('div');
                titleNode.className = 'sirasi-global-page-title';
                titleNode.textContent = title || 'SIRASI-BK';
                header.insertBefore(titleNode, header.firstChild);

                var backLinks = Array.from(document.querySelectorAll('a, button')).filter(function (node) {
                    if (header.contains(node) || node.closest('.sidebar, nav, .notification-dropdown')) return false;
                    return /^kembali(?:\s|$)/i.test((node.textContent || '').trim());
                });
                var backLink = backLinks[0];
                if (backLink && !header.querySelector('.sirasi-global-back')) {
                    var back = document.createElement('a');
                    back.className = 'sirasi-global-back';
                    back.href = backLink.href || '#';
                    back.setAttribute('aria-label', 'Kembali');
                    back.title = 'Kembali';
                    back.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/><path d="M20 12H9"/></svg>';
                    titleNode.before(back);
                    backLink.remove();
                    backLinks.slice(1).forEach(function (duplicate) { duplicate.remove(); });
                }

                if (titleSource && !header.contains(titleSource)) {
                    var titleArea = titleSource.closest('.header-title, .page-title, .page-heading, .page-top, .page-header');
                    if (titleArea === titleSource && titleSource.tagName === 'H1') {
                        titleArea = titleSource.parentElement.closest('.page-heading, .page-top, .page-header') || titleArea;
                    }
                    if (titleArea && titleArea.classList.contains('header-title')) {
                        titleArea.classList.add('sirasi-page-title-source');
                    } else if (titleArea) {
                        var actionArea = titleArea.querySelector('.header-actions, .page-actions, .topbar-right');
                        if (!actionArea) {
                            actionArea = Array.from(titleArea.querySelectorAll('a, button')).find(function (node) {
                                return !node.contains(titleSource) && !titleSource.contains(node);
                            });
                        }
                        if (actionArea) {
                            var titleColumn = titleSource;
                            while (titleColumn.parentElement && titleColumn.parentElement !== titleArea && !titleColumn.parentElement.contains(actionArea)) {
                                titleColumn = titleColumn.parentElement;
                            }
                            if (titleColumn !== titleArea && !titleColumn.contains(actionArea)) {
                                titleColumn.classList.add('sirasi-page-title-source');
                                titleArea.querySelectorAll('.eyebrow, .page-description, .page-subtitle, p.subtitle, :scope > p').forEach(function (node) {
                                    if (!actionArea.contains(node)) node.classList.add('sirasi-page-title-source');
                                });
                            } else {
                                titleSource.classList.add('sirasi-page-title-source');
                                titleArea.querySelectorAll('.eyebrow, .page-description, .page-subtitle, p.subtitle, :scope > p').forEach(function (node) {
                                    node.classList.add('sirasi-page-title-source');
                                });
                            }
                        } else {
                            titleArea.classList.add('sirasi-page-title-source');
                        }
                    } else {
                        titleSource.classList.add('sirasi-page-title-source');
                    }
                }

                var actions = header.querySelector('.topbar-right, .profile-area, .header-right, .topbar-actions');
                if (!actions) {
                    actions = document.createElement('div');
                    actions.className = 'sirasi-global-actions';
                    header.appendChild(actions);
                } else {
                    actions.classList.add('sirasi-global-actions');
                }

                var searchForms = Array.from(header.querySelectorAll('.sirasi-global-search, .header-search, .search-box, .search, form[role="search"], input[name="search"]'));
                searchForms.forEach(function (search) {
                    var container = search.closest('form, .search-box, .search, .header-search, .sirasi-global-search') || search;
                    container.remove();
                });

                var notification = header.querySelector('.notification-wrapper');
                if (notification && notification.parentElement !== actions) actions.appendChild(notification);

                var notificationButton = actions.querySelector('#notificationButton');
                if (!actions.querySelector('.sirasi-theme-toggle')) {
                    var themeButton = document.createElement('button');
                    themeButton.type = 'button';
                    themeButton.className = 'sirasi-theme-toggle';
                    themeButton.setAttribute('aria-label', 'Beralih ke tampilan gelap');
                    themeButton.setAttribute('title', 'Ganti tema');
                    themeButton.innerHTML = '<svg class="theme-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.9 13A8.5 8.5 0 0 1 11 3.1 8.5 8.5 0 1 0 20.9 13Z"/></svg><svg class="theme-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></svg>';
                    var notificationAnchor = notificationButton && (notificationButton.closest('.notification-wrapper') || notificationButton);
                    if (notificationAnchor) notificationAnchor.before(themeButton);
                    else actions.appendChild(themeButton);
                    var themeKey = 'sirasi-theme';

                    function syncThemeButton() {
                        var isDark = document.documentElement.classList.contains('dark-mode');
                        themeButton.setAttribute('aria-pressed', String(isDark));
                        themeButton.setAttribute('aria-label', isDark ? 'Beralih ke tampilan terang' : 'Beralih ke tampilan gelap');
                    }

                    themeButton.addEventListener('click', function () {
                        var isDark = !(document.documentElement.classList.contains('dark-mode') || document.body.classList.contains('dark-mode'));
                        if (window.sirasiSetTheme) {
                            window.sirasiSetTheme(isDark ? 'dark' : 'light');
                        } else {
                            document.documentElement.classList.toggle('dark-mode', isDark);
                            document.body.classList.toggle('dark-mode', isDark);
                            localStorage.setItem(themeKey, isDark ? 'dark' : 'light');
                            window.dispatchEvent(new CustomEvent('sirasi-theme-change', { detail: isDark ? 'dark' : 'light' }));
                        }
                        syncThemeButton();
                    });
                    window.addEventListener('sirasi-theme-change', syncThemeButton);
                    syncThemeButton();
                }
            });
        });
    </script>
@endonce
