<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Izin Konseling Siswa - SIRASI-BK</title>

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
        button, input, select, textarea {  }

        .app {
            display: grid;
            grid-template-columns: 235px minmax(0, 1fr);
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar */
        .sidebar {
            grid-column: 1;
            min-width: 0;
            width: 235px;
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
            grid-column: 2;
            min-width: 0;
            width: 100%;
            max-width: 100%;
            padding: 28px 36px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .approval-content {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            gap: 24px;
            width: 100%;
            min-width: 0;
        }

        .approval-content > * {
            width: 100%;
            min-width: 0;
        }

        .approval-content .table-responsive {
            max-width: 100%;
            overflow-x: auto;
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
            width: 42px;
            height: 42px;
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

        @media (max-width: 1024px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 900px) {
            .app { grid-template-columns: 78px minmax(0, 1fr); }
            .sidebar { width: 78px; }
            .main { grid-column: 2; }
            .sidebar { width: 78px; padding: 18px 10px; align-items: center; }
            .brand { justify-content: center; margin-bottom: 18px; padding-bottom: 14px; }
            .brand-name, .brand-subtitle, .menu-title, .menu-label, .menu-badge { display: none !important; }
            .menu-item, .logout-button { justify-content: center; padding: 12px 0; font-size: 0; }
        }

        @media (max-width: 768px) {
            .main { padding: 18px 14px; }
            .header { flex-direction: column; align-items: flex-start; gap: 12px; padding: 16px; }
            .profile-area { width: 100%; justify-content: flex-end; }
            .stat-grid { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; align-items: stretch; }
        }

        /* Notification */
        .notification-wrapper {
            position: relative;
        }

        .notification-btn {
            position: relative;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
        }

        .notification-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .notification-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 9px;
            height: 9px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, .25);
        }

        .notification-dropdown {
            position: absolute;
            top: 48px;
            right: 0;
            width: 340px;
            max-height: 420px;
            overflow-y: auto;
            background: var(--white);
            border-radius: 14px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            display: none;
            z-index: 1000;
        }

        .notification-dropdown.show {
            display: block;
            animation: modalFadeIn .15s ease-out;
        }

        .notification-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 700;
            background: #fafbfe;
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            gap: 12px;
            align-items: flex-start;
            text-decoration: none;
            color: var(--text);
            transition: background .15s ease;
        }

        .notification-item:hover {
            background: #f8faff;
        }

        .notification-item.unread {
            background: #f0f5ff;
        }

        .notification-item-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #eaf0ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-item-content {
            flex: 1;
            font-size: 12.5px;
        }

        .notification-item-content strong {
            display: block;
            color: var(--primary-dark);
            margin-bottom: 2px;
            font-size: 13px;
        }

        .notification-item-content p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .notification-item-content small {
            color: #94a3b8;
            font-size: 11px;
        }

        .notification-empty {
            padding: 30px 20px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }

        /* Penyelarasan visual halaman approval izin siswa */
        .stat-card { position:relative; overflow:hidden; padding:22px; border-radius:20px; border-color:#e4eaf3; box-shadow:0 8px 22px rgba(24,48,94,.055); transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease; }
        .stat-card:hover { transform:translateY(-3px); border-color:#cbdaf2; box-shadow:0 14px 28px rgba(24,48,94,.10); }
        .stat-icon { width:42px; height:42px; border-radius:16px; box-shadow:inset 0 1px rgba(255,255,255,.8),0 5px 12px rgba(30,50,88,.07); }
        .stat-icon svg { width:20px; height:20px; stroke-width:2.1; }
        .stat-icon.icon-orange { background:linear-gradient(145deg,#fff8eb,#ffedc7); color:#c67a11; }
        .stat-icon.icon-blue { background:linear-gradient(145deg,#eff5ff,#dce8ff); color:#315fc4; }
        .stat-icon.icon-red { background:linear-gradient(145deg,#fff2f1,#ffe0df); color:#d64545; }
        .stat-icon.icon-green { background:linear-gradient(145deg,#effcf4,#d8f5e3); color:#17834a; }
        .stat-value { color:#17233b; font-size:25px; letter-spacing:-.4px; }
        .filter-panel { padding:20px; border:1px solid #e3e9f2; border-radius:20px; background:linear-gradient(145deg,#fff,#fbfcff); box-shadow:0 8px 24px rgba(24,48,94,.055); }
        .filter-panel-heading { display:flex; align-items:center; gap:11px; margin-bottom:16px; }
        .filter-panel-icon { display:grid; place-items:center; width:36px; height:36px; flex:0 0 36px; border:1px solid #dbe6fa; border-radius:12px; background:linear-gradient(145deg,#eff5ff,#e1ebff); color:#315fc4; }
        .filter-panel-icon svg { width:18px; height:18px; }
        .filter-panel-heading strong { display:block; color:#20304d; font-size:13px; font-weight:800; }
        .filter-panel-heading small { display:block; margin-top:3px; color:#7a879a; font-size:11px; }
        .toolbar { justify-content:flex-start; }
        .toolbar form { display:flex !important; align-items:center; gap:10px !important; flex:1; flex-wrap:wrap; }
        .search-box { flex:1 1 280px; min-width:min(280px,100%); }
        .search-box input,.filter-select { min-height:42px; border-color:#dce4ef; border-radius:12px; background:#f9fbfe; transition:border-color .18s ease,box-shadow .18s ease,background .18s ease; }
        .search-box input:focus,.filter-select:focus { border-color:#7da2e6; background:#fff; box-shadow:0 0 0 3px rgba(59,130,246,.12); }
        .search-icon { color:#5276bd; }
        .filter-select { min-width:250px; }
        .content-card { border-color:#e2e8f0; border-radius:20px; box-shadow:0 9px 26px rgba(24,48,94,.06); }
        thead { background:#f5f8fc; color:#53627a; }
        th { padding-top:15px; padding-bottom:15px; color:#53627a; font-size:11px; font-weight:750; letter-spacing:.025em; }
        th,td { border-color:#e9eef5; }
        td { padding-top:16px; padding-bottom:16px; }
        tbody tr:hover { background:#f8faff; }
        .badge { padding:5px 10px; border-radius:999px; font-size:10.5px; line-height:1.35; box-shadow:inset 0 1px rgba(255,255,255,.75); }
        .badge-diajukan { background:linear-gradient(135deg,#fff8eb,#fff1d6); color:#a45c07; border-color:#f4d59a; }
        .badge-disetujui { background:linear-gradient(135deg,#eff5ff,#e3edff); color:#214eaa; border-color:#bfd2f5; }
        .badge-ditolak { background:linear-gradient(135deg,#fff3f3,#ffe7e7); color:#a52e38; border-color:#f3c4c7; }
        .badge-terjadwal,.badge-selesai { background:linear-gradient(135deg,#effcf5,#def6e8); color:#176a42; border-color:#b8e6ca; }
        .badge-dibatalkan { background:linear-gradient(135deg,#f7f9fc,#edf1f6); color:#536174; border-color:#d8e0ea; }
        .btn-action:not(.btn-approve):not(.btn-reject) { min-height:36px; padding:0 13px; border:1px solid #d8e3f4 !important; border-radius:11px; background:linear-gradient(135deg,#fff,#f4f7fc) !important; color:#3155a1 !important; box-shadow:0 3px 9px rgba(31,61,116,.07); transition:all .18s ease; }
        .btn-action:not(.btn-approve):not(.btn-reject):hover { transform:translateY(-1px); border-color:#aac1eb !important; background:#edf4ff !important; box-shadow:0 7px 15px rgba(31,61,116,.12); }
        .main { padding-top:0; }
        .approval-top-navbar { position:relative; z-index:20; width:calc(100% + 72px); min-height:64px; margin:0 -36px; padding:12px 24px 12px 16px; border:0; border-bottom:1px solid rgba(226,232,240,.85); border-radius:0; background:rgba(255,255,255,.86); box-shadow:none; backdrop-filter:blur(14px); }
        @media (max-width:768px) { .main { padding-top:0; } .approval-top-navbar { width:calc(100% + 28px); margin:0 -14px; padding:12px 14px; border-radius:0; box-shadow:none; } }
        @media (max-width:768px) { .filter-panel { padding:16px; border-radius:17px; } .toolbar form { align-items:stretch; flex-direction:column; } .search-box,.filter-select { width:100%; min-width:0; } }
    </style>
    @include('partials.theme')
    <style>
        html body .toolbar .search-box {
            background: transparent !important;
            border: 0 !important;
            padding: 0 !important;
        }
        html body .toolbar .search-box input,
        html body .toolbar .search-box input:hover {
            box-sizing: border-box !important;
            height: 42px !important;
            min-height: 42px !important;
            padding: 10px 14px 10px 38px !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            outline: none !important;
            color: #0f172a !important;
            box-shadow: none !important;
        }
        html body .toolbar .filter-select {
            box-sizing: border-box !important;
            height: 42px !important;
            min-height: 42px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            background-color: #ffffff !important;
        }
        html body .toolbar .search-box input::placeholder {
            color: #94a3b8 !important;
            opacity: 1;
        }
        html body .toolbar .search-box input:focus,
        html body .toolbar .search-box input:focus-visible,
        html body .toolbar .filter-select:focus,
        html body .toolbar .filter-select:focus-visible {
            border-color: #2563eb !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }
        html body .toolbar .search-icon {
            color: #64748b !important;
            pointer-events: none;
        }
        html.dark body .toolbar .search-box input,
        html.dark-mode body .toolbar .search-box input,
        body.dark .toolbar .search-box input,
        body.dark-mode .toolbar .search-box input,
        html.dark body .toolbar .search-box input:hover,
        html.dark-mode body .toolbar .search-box input:hover,
        body.dark .toolbar .search-box input:hover,
        body.dark-mode .toolbar .search-box input:hover {
            background-color: rgba(15, 23, 42, 0.6) !important;
            background: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(148, 163, 184, 0.25) !important;
            color: #f8fafc !important;
        }
        html.dark body .toolbar .filter-select,
        html.dark-mode body .toolbar .filter-select,
        body.dark .toolbar .filter-select,
        body.dark-mode .toolbar .filter-select {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(148, 163, 184, 0.25) !important;
            color: #f8fafc !important;
        }
        html.dark body .toolbar .search-box input::placeholder,
        html.dark-mode body .toolbar .search-box input::placeholder,
        body.dark .toolbar .search-box input::placeholder,
        body.dark-mode .toolbar .search-box input::placeholder {
            color: #94a3b8 !important;
        }
        html.dark body .toolbar .search-box input:focus,
        html.dark-mode body .toolbar .search-box input:focus,
        body.dark .toolbar .search-box input:focus,
        body.dark-mode .toolbar .search-box input:focus,
        html.dark body .toolbar .search-box input:focus-visible,
        html.dark-mode body .toolbar .search-box input:focus-visible,
        body.dark .toolbar .search-box input:focus-visible,
        body.dark-mode .toolbar .search-box input:focus-visible,
        html.dark body .toolbar .filter-select:focus,
        html.dark-mode body .toolbar .filter-select:focus,
        body.dark .toolbar .filter-select:focus,
        body.dark-mode .toolbar .filter-select:focus {
            border-color: #2563eb !important;
            background-color: rgba(15, 23, 42, 0.8) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }
        html.dark body .toolbar .search-icon,
        html.dark-mode body .toolbar .search-icon,
        body.dark .toolbar .search-icon,
        body.dark-mode .toolbar .search-icon {
            color: #94a3b8 !important;
        }
    </style>
</head>

<body>
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
        <header class="header approval-top-navbar">
            <div class="header-title">
                <h1>Approval Izin Mengikuti Bimbingan Konseling</h1>
                <p>Pemberian Izin Siswa Kelas {{ $kelas ? $kelas->nama_kelas : '(Belum Ditugaskan)' }} untuk Mengikuti Sesi Bimbingan Konseling (Penetapan Jadwal Dikelola oleh Guru BK)</p>
            </div>

            <div class="profile-area" style="display: flex; align-items: center; gap: 16px;">
                {{-- Notifikasi --}}
                <div class="notification-wrapper">
                    <button type="button" class="notification-btn" id="notificationButton" onclick="toggleNotificationDropdown(event)" title="Notifikasi Pengajuan Izin">
                        <i data-lucide="bell" style="width: 18px; height: 18px;"></i>
                        @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                            <span class="notification-dot" id="notificationDot"></span>
                        @endif
                    </button>

                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <span>Notifikasi Pengajuan Baru</span>
                            @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                                <button type="button" onclick="markAllNotificationsRead(event)" style="background: none; border: none; color: var(--primary); font-size: 11.5px; font-weight: 600; cursor: pointer;">Tandai Dibaca</button>
                            @endif
                        </div>

                        @forelse ($notifikasis ?? [] as $notif)
                            <a href="{{ route('notifikasi.baca', $notif->id) }}" class="notification-item {{ !$notif->dibaca ? 'unread' : '' }}">
                                <div class="notification-item-icon">
                                    <i data-lucide="clipboard-check" style="width: 16px; height: 16px;"></i>
                                </div>
                                <div class="notification-item-content">
                                    <strong>{{ $notif->judul }}</strong>
                                    <p>{{ $notif->pesan }}</p>
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

                <div class="profile" style="display: flex; align-items: center; gap: 12px;">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->nama }}</div>
                        <div class="profile-role">Wali Kelas {{ $kelas ? $kelas->nama_kelas : '' }}</div>
                    </div>
                    <div class="profile-photo">
                        @if (auth()->user()->foto_profil)
                            <img src="{{ route('profile.photo', basename(auth()->user()->foto_profil)) }}" alt="Foto Profil">
                        @else
                            <i data-lucide="user-check"></i>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <div class="approval-content">
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
                    <span class="stat-label">Menunggu Persetujuan Wali Kelas</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-blue"><i data-lucide="clipboard-check"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $totalDisetujui }}</span>
                    <span class="stat-label">Izin Siswa Disetujui</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-red"><i data-lucide="clock-alert"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $totalDitolak }}</span>
                    <span class="stat-label">Belum Diizinkan (Kendala Jam)</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-green"><i data-lucide="calendar-check"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $totalTerjadwal }}</span>
                    <span class="stat-label">Dijadwalkan / Selesai di BK</span>
                </div>
            </div>
        </div>

        {{-- Filter & Search --}}
        <div class="filter-panel">
            <div class="filter-panel-heading">
                <span class="filter-panel-icon"><i data-lucide="list-filter"></i></span>
                <div><strong>Filter &amp; Pencarian</strong><small>Temukan pengajuan izin berdasarkan nama, NIS, atau status.</small></div>
            </div>
            <div class="toolbar">
            <form action="{{ route('wali.pengajuan.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <div class="search-box">
                    <span class="search-icon"><i data-lucide="search" style="width: 16px; height: 16px;"></i></span>
                    <input type="text" name="search" placeholder="Cari nama atau NIS siswa..." value="{{ request('search') }}">
                </div>

                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status Izin &amp; Jadwal</option>
                    <option value="Diajukan" {{ request('status') === 'Diajukan' ? 'selected' : '' }}>Menunggu Persetujuan Wali Kelas</option>
                    <option value="Disetujui_Wali" {{ request('status') === 'Disetujui_Wali' ? 'selected' : '' }}>Izin Disetujui Wali Kelas</option>
                    <option value="Ditolak_Wali" {{ request('status') === 'Ditolak_Wali' ? 'selected' : '' }}>Belum Diizinkan pada Jam Tersebut</option>
                    <option value="Terjadwal" {{ request('status') === 'Terjadwal' ? 'selected' : '' }}>Terjadwal Resmi oleh Guru BK</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai Konseling</option>
                    <option value="Dibatalkan" {{ request('status') === 'Dibatalkan' ? 'selected' : '' }}>Jadwal Dibatalkan</option>
                </select>

                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('wali.pengajuan.index') }}" class="btn-secondary" style="padding: 9px 14px; font-size: 13px;">Reset Filter</a>
                @endif
            </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="content-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Izin</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Data Siswa</th>
                            <th>Bidang Layanan</th>
                            <th>Tanggal &amp; Jam Diminta</th>
                            <th>Status Izin &amp; Jadwal BK</th>
                            <th>Catatan Izin Wali Kelas</th>
                            <th style="text-align: center;">Approval Izin Siswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $index => $p)
                            @php
                                $tglPengajuan = \Carbon\Carbon::parse($p->created_at ?? $p->tanggal);
                                $tglDiminta = $p->tanggal ? \Carbon\Carbon::parse($p->tanggal) : null;
                                $isUrgent = $p->status === 'Diajukan' && ($tglPengajuan->isToday() || $tglPengajuan->isTomorrow());
                                $waktuInfo = ($p->waktu_mulai && $p->waktu_mulai !== '00:00:00')
                                    ? (substr($p->waktu_mulai, 0, 5) . ' - ' . substr($p->waktu_selesai, 0, 5) . ' WIB')
                                    : 'Sesuai Jam Pelajaran';
                                $namaSiswa = $p->siswa->nama_siswa ?? 'Siswa';
                                $namaKelas = $p->siswa->kelas->nama_kelas ?? '-';
                                $detailData = [
                                    'id_penjadwalan' => $p->id_penjadwalan,
                                    'kode_pengajuan' => $p->kode_pengajuan,
                                    'nama_siswa' => $namaSiswa,
                                    'nis' => $p->siswa->nis ?: '-',
                                    'kelas' => $namaKelas,
                                    'jenis_bimbingan' => $p->jenis_bimbingan,
                                    'tanggal_diminta' => $tglDiminta ? $tglDiminta->isoFormat('dddd, D MMMM Y') : '-',
                                    'jam_diminta' => $waktuInfo,
                                    'tanggal_pengajuan' => $tglPengajuan->isoFormat('dddd, D MMMM Y, HH:mm') . ' WIB',
                                    'status' => $p->status,
                                    'status_label' => match($p->status) {
                                        'Diajukan' => 'Menunggu Persetujuan Wali Kelas',
                                        'Disetujui_Wali' => $p->hasSubmittedSchedule() ? 'Izin Disetujui (Menunggu Jadwal BK)' : 'Izin Disetujui (Siswa Dapat Ajukan Jadwal)',
                                        'Ditolak_Wali' => 'Izin Ditolak Wali Kelas',
                                        'Terjadwal' => 'Terjadwal Resmi oleh Guru BK',
                                        'Selesai' => 'Selesai Konseling',
                                        'Dibatalkan' => 'Jadwal Dibatalkan',
                                        default => str_replace('_', ' ', $p->status),
                                    },
                                    'badge_class' => match($p->status) {
                                        'Diajukan' => 'badge-diajukan',
                                        'Disetujui_Wali' => 'badge-disetujui',
                                        'Ditolak_Wali' => 'badge-ditolak',
                                        'Terjadwal' => 'badge-terjadwal',
                                        'Selesai' => 'badge-selesai',
                                        default => 'badge-dibatalkan',
                                    },
                                    'catatan_wali' => $p->catatan_wali,
                                    'waktu_persetujuan_wali' => $p->waktu_persetujuan_wali ? \Carbon\Carbon::parse($p->waktu_persetujuan_wali)->isoFormat('D MMMM Y, HH:mm') . ' WIB' : null,
                                ];
                            @endphp
                            <tr class="clickable-row" onclick="openDetailModal({{ json_encode($detailData) }})" style="cursor: pointer;" title="Klik untuk melihat rincian permohonan izin">
                                <td>{{ $pengajuan->firstItem() + $index }}</td>
                                <td>
                                    @if ($p->kode_pengajuan)
                                        <code style="background: #eff6ff; color: var(--primary-dark); padding: 3px 8px; border-radius: 6px; font-weight: 800; font-size: 12px; border: 1px solid #bfdbfe;">{{ $p->kode_pengajuan }}</code>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $tglPengajuan->isoFormat('D MMMM Y') }}</strong>
                                    <div><small style="color: var(--muted);">Pukul {{ $tglPengajuan->format('H:i') }} WIB</small></div>
                                    @if ($isUrgent)
                                        <div><span class="urgent-tag">Perlu Konfirmasi Izin</span></div>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color: var(--primary-dark); font-size: 13.5px;">{{ $namaSiswa }}</strong>
                                    <div><small style="color: var(--muted);">NIS: {{ $p->siswa->nis ?: '-' }}</small></div>
                                    <div><small style="color: var(--muted); font-weight: 600;">Kelas {{ $namaKelas }}</small></div>
                                </td>
                                <td>{{ $p->jenis_bimbingan }}</td>
                                <td>
                                    @if ($tglDiminta)
                                        <strong>{{ $tglDiminta->isoFormat('D MMMM Y') }}</strong>
                                        <div><small style="color: var(--primary); font-weight: 700;">{{ $waktuInfo }}</small></div>
                                    @else
                                        <span style="color: var(--muted);">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->status === 'Diajukan')
                                        <span class="badge badge-diajukan">Menunggu Persetujuan Wali Kelas</span>
                                    @elseif ($p->status === 'Disetujui_Wali')
                                        @if ($p->hasSubmittedSchedule())
                                            <span class="badge badge-disetujui">Izin Disetujui (Menunggu Jadwal BK)</span>
                                        @else
                                            <span class="badge badge-disetujui">Izin Disetujui (Siswa Dapat Ajukan Jadwal)</span>
                                        @endif
                                    @elseif ($p->status === 'Ditolak_Wali')
                                        <span class="badge badge-ditolak">Izin Ditolak Wali Kelas</span>
                                    @elseif ($p->status === 'Terjadwal')
                                        <span class="badge badge-terjadwal">Terjadwal oleh Guru BK</span>
                                    @elseif ($p->status === 'Selesai')
                                        <span class="badge badge-selesai">Selesai Konseling</span>
                                    @elseif ($p->status === 'Dibatalkan')
                                        <span class="badge badge-dibatalkan">Jadwal Dibatalkan</span>
                                    @else
                                        <span class="badge badge-dibatalkan">{{ str_replace('_', ' ', $p->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->catatan_wali)
                                        <div style="font-size: 12px; font-weight: 500; color: {{ $p->status === 'Ditolak_Wali' ? 'var(--red)' : 'var(--text)' }};">"{{ $p->catatan_wali }}"</div>
                                        @if ($p->waktu_persetujuan_wali)
                                            <small style="color: var(--muted);">{{ $p->waktu_persetujuan_wali->format('d/m/Y H:i') }} WIB</small>
                                        @endif
                                    @else
                                        <span style="color: var(--muted);">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;" onclick="event.stopPropagation();">
                                    @if ($p->status === 'Diajukan')
                                        <div style="display: inline-flex; gap: 8px;">
                                            <button type="button" class="btn-action btn-approve" title="Setujui / Terima Izin"
                                                onclick="openApproveModal({{ $p->id_penjadwalan }}, '{{ addslashes($namaSiswa) }}', '{{ $tglPengajuan->isoFormat('D MMMM Y') }}', '{{ addslashes($waktuInfo) }}')">
                                                <i data-lucide="check" style="width: 14px; height: 14px;"></i> Terima <span style="display:none;">Setujui</span>
                                            </button>
                                            <button type="button" class="btn-action btn-reject"
                                                onclick="openRejectModal({{ $p->id_penjadwalan }}, '{{ addslashes($namaSiswa) }}', '{{ $tglPengajuan->isoFormat('D MMMM Y') }}')">
                                                <i data-lucide="x" style="width: 14px; height: 14px;"></i> Tolak
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn-action" style="background: #f1f5f9; color: var(--text); border: 1px solid #cbd5e1;"
                                            onclick="openDetailModal({{ json_encode($detailData) }})">
                                            <i data-lucide="eye" style="width: 13px; height: 13px;"></i> Detail
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; color: var(--muted); padding: 40px;">
                                    Belum ada permohonan izin mengikuti bimbingan konseling dari siswa kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pengajuan instanceof \Illuminate\Pagination\LengthAwarePaginator && $pengajuan->hasPages())
                <div class="pagination-container">
                    <span style="font-size: 13px; color: var(--muted);">
                        Menampilkan {{ $pengajuan->firstItem() }} s/d {{ $pengajuan->lastItem() }} dari {{ $pengajuan->total() }} data izin
                    </span>
                    {{ $pengajuan->links() }}
                </div>
            @endif
        </div>
        </div>
    </main>
</div>

{{-- Modal Detail Lengkap Pengajuan Izin Siswa (Klik Baris) --}}
<div class="modal" id="detailModal">
    <div class="modal-dialog" style="max-width: 560px;">
        <div class="modal-header">
            <h3>
                <i data-lucide="clipboard-list" style="color: var(--primary);"></i>
                <span>Detail Permohonan Izin Siswa</span>
            </h3>
            <button type="button" class="modal-close" onclick="closeDetailModal()"><i data-lucide="x"></i></button>
        </div>
        <div class="modal-body" style="gap: 16px;">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; gap: 10px; flex-wrap: wrap;">
                <div>
                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--muted); display: block;">Kode Izin Unik</span>
                    <code id="detailKodeIzin" style="font-size: 16px; font-weight: 800; color: var(--primary); background: #eff6ff; padding: 3px 10px; border-radius: 6px; border: 1px solid #bfdbfe;">-</code>
                </div>
                <div id="detailStatusBadgeContainer">
                    <span id="detailStatusBadge" class="badge">-</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                    <div style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase;">Nama Siswa</div>
                    <div id="detailNamaSiswa" style="font-size: 14px; font-weight: 800; color: var(--text); margin-top: 2px;">-</div>
                    <div id="detailNis" style="font-size: 12px; color: var(--muted);">NIS: -</div>
                </div>

                <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                    <div style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase;">Kelas Binaan</div>
                    <div id="detailKelas" style="font-size: 14px; font-weight: 800; color: var(--text); margin-top: 2px;">-</div>
                    <div style="font-size: 12px; color: var(--green); font-weight: 600;">Wali Kelas Terverifikasi</div>
                </div>

                <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                    <div style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase;">Bidang Layanan</div>
                    <div id="detailJenisBimbingan" style="font-size: 13.5px; font-weight: 700; color: var(--primary-dark); margin-top: 2px;">-</div>
                </div>

                <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                    <div style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase;">Tanggal Pengajuan</div>
                    <div id="detailTanggalPengajuan" style="font-size: 13px; font-weight: 600; color: var(--text); margin-top: 2px;">-</div>
                </div>
            </div>

            <div style="background: #eef4ff; border: 1px solid #c7d9fe; border-radius: 12px; padding: 14px;">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary-dark); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Waktu &amp; Jam Pelajaran yang Diminta Ditinggalkan:</div>
                <div id="detailTanggalDiminta" style="font-size: 14px; font-weight: 800; color: var(--text);">-</div>
                <div id="detailJamDiminta" style="font-size: 13.5px; font-weight: 700; color: var(--primary); margin-top: 2px;">-</div>
                <div id="detailPeriodeJam" style="font-size: 12px; color: var(--muted); margin-top: 4px;"></div>
            </div>

            {{-- Kotak Keputusan Jika Sudah Ada Keputusan --}}
            <div id="detailKeputusanBox" style="display: none; background: #fafbfe; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px;">
                <div style="font-size: 11px; font-weight: 800; color: var(--muted); text-transform: uppercase; margin-bottom: 4px;">Catatan Keputusan Wali Kelas:</div>
                <div id="detailCatatanWali" style="font-size: 13.5px; font-style: italic; color: var(--text); font-weight: 600;">-</div>
                <div id="detailWaktuKeputusan" style="font-size: 12px; color: var(--muted); margin-top: 4px;">-</div>
            </div>
        </div>
        <div class="modal-footer" id="detailModalFooter">
            <button type="button" class="btn-secondary" onclick="closeDetailModal()">Tutup</button>
            <div id="detailActionButtons" style="display: inline-flex; gap: 8px;">
                <button type="button" class="btn-action btn-reject" id="btnDetailReject" style="padding: 10px 18px; font-size: 13px;">
                    <i data-lucide="x"></i> Tolak Izin
                </button>
                <button type="button" class="btn-action btn-approve" id="btnDetailApprove" style="padding: 10px 18px; font-size: 13px;">
                    <i data-lucide="check"></i> Terima Izin
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Beri Izin Siswa --}}
<div class="modal" id="approveModal">
    <div class="modal-dialog">
        <form id="approveForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-header">
                <h3 style="color: var(--green);"><i data-lucide="check-circle-2"></i> Terima Izin Siswa Mengikuti Konseling</h3>
                <button type="button" class="modal-close" onclick="closeApproveModal()"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div class="modal-info-box">
                    <div><strong>Siswa:</strong> <span id="approveSiswaName"></span></div>
                    <div><strong>Waktu Rencana:</strong> <span id="approveScheduleTime"></span></div>
                </div>

                <div class="form-group">
                    <label>Catatan Izin / Koordinasi Jam Pelajaran (Opsional):</label>
                    <textarea name="catatan_wali" class="form-control" rows="3" placeholder="Contoh: Diizinkan mengikuti sesi konseling, sudah dikoordinasikan dengan guru mapel yang bersangkutan."></textarea>
                    <small style="color: var(--muted);">Pemberian izin ini tersimpan di database dan siswa dapat melanjutkan ke pengajuan jadwal konseling Guru BK.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeApproveModal()">Batal</button>
                <button type="submit" class="btn-action btn-approve" style="padding: 10px 18px; font-size: 13px;">
                    <i data-lucide="check"></i> Terima Izin
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tolak Izin --}}
<div class="modal" id="rejectModal">
    <div class="modal-dialog">
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-header">
                <h3 style="color: var(--red);"><i data-lucide="alert-triangle"></i> Tolak Permohonan Izin Siswa</h3>
                <button type="button" class="modal-close" onclick="closeRejectModal()"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div class="modal-info-box" style="border-color: #fecaca; background: #fff5f5;">
                    <div><strong>Siswa:</strong> <span id="rejectSiswaName"></span></div>
                    <div><strong>Tanggal Rencana:</strong> <span id="rejectScheduleDate"></span></div>
                </div>

                <div class="form-group">
                    <label>Alasan Penolakan Izin * (Wajib Diisi):</label>
                    <textarea name="catatan_wali" class="form-control" rows="3" placeholder="Contoh: Pada jam tersebut ada ujian penilaian harian di kelas, silakan ajukan ulang izin pada jam atau hari lain." required minlength="5"></textarea>
                    <small style="color: var(--muted);">Alasan ini akan tersimpan ke database dan ditampilkan pada portal siswa agar siswa dapat mengajukan ulang.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn-action btn-reject" style="padding: 10px 18px; font-size: 13px;">
                    <i data-lucide="x"></i> Tolak Izin
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();

    let currentDetailItem = null;

    function openDetailModal(data) {
        currentDetailItem = data;
        document.getElementById('detailKodeIzin').innerText = data.kode_pengajuan || '-';
        document.getElementById('detailNamaSiswa').innerText = data.nama_siswa;
        document.getElementById('detailNis').innerText = 'NIS: ' + (data.nis || '-');
        document.getElementById('detailKelas').innerText = 'Kelas ' + data.kelas;
        document.getElementById('detailJenisBimbingan').innerText = data.jenis_bimbingan;
        document.getElementById('detailTanggalPengajuan').innerText = data.tanggal_pengajuan;
        document.getElementById('detailTanggalDiminta').innerText = data.tanggal_diminta;
        document.getElementById('detailJamDiminta').innerText = 'Pukul ' + data.jam_diminta;
        document.getElementById('detailPeriodeJam').innerText = data.periode_jam ? ('Keterangan: ' + data.periode_jam) : '';

        const badge = document.getElementById('detailStatusBadge');
        badge.className = 'badge ' + data.badge_class;
        badge.innerText = data.status_label;

        const actionButtons = document.getElementById('detailActionButtons');
        const keputusanBox = document.getElementById('detailKeputusanBox');

        if (data.status === 'Diajukan') {
            actionButtons.style.display = 'inline-flex';
            keputusanBox.style.display = 'none';

            document.getElementById('btnDetailApprove').onclick = function () {
                closeDetailModal();
                openApproveModal(data.id_penjadwalan, data.nama_siswa, data.tanggal_diminta, data.jam_diminta);
            };

            document.getElementById('btnDetailReject').onclick = function () {
                closeDetailModal();
                openRejectModal(data.id_penjadwalan, data.nama_siswa, data.tanggal_diminta);
            };
        } else {
            actionButtons.style.display = 'none';
            if (data.catatan_wali || data.waktu_persetujuan_wali) {
                keputusanBox.style.display = 'block';
                document.getElementById('detailCatatanWali').innerText = data.catatan_wali ? ('"' + data.catatan_wali + '"') : '(Tanpa catatan tambahan)';
                document.getElementById('detailWaktuKeputusan').innerText = 'Diputuskan pada: ' + (data.waktu_persetujuan_wali || '-');
            } else {
                keputusanBox.style.display = 'none';
            }
        }

        document.getElementById('detailModal').classList.add('active');
        lucide.createIcons();
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    function openApproveModal(id, siswaName, date, time) {
        document.getElementById('approveForm').action = '/wali-kelas/pengajuan/' + id + '/approve';
        document.getElementById('approveSiswaName').innerText = siswaName;
        document.getElementById('approveScheduleTime').innerText = date + ' (' + time + ')';
        document.getElementById('approveModal').classList.add('active');
        lucide.createIcons();
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.remove('active');
    }

    function openRejectModal(id, siswaName, date) {
        document.getElementById('rejectForm').action = '/wali-kelas/pengajuan/' + id + '/reject';
        document.getElementById('rejectSiswaName').innerText = siswaName;
        document.getElementById('rejectScheduleDate').innerText = date;
        document.getElementById('rejectModal').classList.add('active');
        lucide.createIcons();
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
    }

    function toggleNotificationDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) {
            dropdown.classList.toggle('show');
            const dot = document.getElementById('notificationDot');
            if (dot) {
                dot.style.display = 'none';
                fetch('{{ route('notifikasi.markAllRead') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).catch(() => {});
            }
        }
    }

    function markAllNotificationsRead(event) {
        event.stopPropagation();
        const dot = document.getElementById('notificationDot');
        if (dot) dot.style.display = 'none';
        document.querySelectorAll('.notification-item.unread').forEach(el => el.classList.remove('unread'));
        fetch('{{ route('notifikasi.markAllRead') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).catch(() => {});
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('notificationDropdown');
        const button = document.getElementById('notificationButton');
        if (dropdown && !dropdown.contains(e.target) && button && !button.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });

    window.onclick = function(e) {
        if (e.target == document.getElementById('detailModal')) closeDetailModal();
        if (e.target == document.getElementById('approveModal')) closeApproveModal();
        if (e.target == document.getElementById('rejectModal')) closeRejectModal();
    }
</script>
</body>
</html>
