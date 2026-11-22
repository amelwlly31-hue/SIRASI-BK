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

            background: radial-gradient(circle at 85% 0%, rgba(41, 67, 143, .08), transparent 28%), #f5f7fb;
            color: var(--text);
            min-height: 100vh;
        }

        a { text-decoration: none; }
        button, input {  }

        .app {
            display: grid;
            grid-template-columns: 235px 1fr;
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
            width: 42px;
            height: 42px;
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

        .badge-primary { background: #eaf0ff; color: #173c91; }
        .badge-success { background: #eaf8ef; color: #159447; }
        .badge-warning { background: #fff4e3; color: #d98218; }
        .badge-danger { background: #fff0f0; color: #d64545; }
        .badge-secondary { background: #f0f2f5; color: #64748b; }

        @media (max-width: 1100px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .dashboard-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .app { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .stat-grid { grid-template-columns: 1fr; }
        }

        /* Action Buttons */
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
            text-decoration: none;
        }

        .btn-approve { background: #159447; color: var(--white); }
        .btn-approve:hover { background: #117839; }

        .btn-reject { background: #d64545; color: var(--white); }
        .btn-reject:hover { background: #b03636; }

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

        @media (max-width: 1100px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-banner { flex-direction: column; align-items: flex-start; gap: 18px; }
        }

        @media (max-width: 900px) {
            .app { display: block; }
            .sidebar { position: fixed; left: 0; top: 0; bottom: 0; width: 74px; padding: 18px 8px; align-items: center; z-index: 60; }
            .main { margin-left: 74px; width: calc(100% - 74px); max-width: calc(100vw - 74px); padding: 20px 18px; }
            .brand { justify-content: center; margin-bottom: 18px; padding-bottom: 14px; }
            .brand-name, .brand-subtitle, .menu-title, .menu-label, .menu-badge { display: none !important; }
            .menu-item, .logout-button { justify-content: center; padding: 12px 0; font-size: 0; }
        }

        @media (max-width: 640px) {
            .sidebar { width: 62px; padding: 14px 6px; }
            .main { margin-left: 62px; width: calc(100% - 62px); max-width: calc(100vw - 62px); padding: 16px 14px; gap: 18px; }
            .stat-grid { grid-template-columns: 1fr; }
            .header { flex-direction: row; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; padding: 14px 16px; }
            .header-title h1 { font-size: 18px; }
            .profile-info { display: none; }
            .hero-banner { padding: 20px 18px; }
            .hero-text h2 { font-size: 19px; }
        }

        /* Penyegaran visual khusus Dashboard Wali Kelas */
        .sidebar { background: linear-gradient(165deg, #102b68 0%, #173c91 58%, #2256ad 100%); }
        .menu-item { color: rgba(255,255,255,.9); border: 1px solid transparent; }
        .menu-icon { width: 34px; height: 34px; border-radius: 11px; background: rgba(255,255,255,.10); color: #fff; transition: background .2s ease, transform .2s ease; }
        .menu-item:hover { background: rgba(255,255,255,.09); color: #fff; }
        .menu-item:hover .menu-icon { background: rgba(255,255,255,.18); transform: translateY(-1px); }
        .menu-item.active { position: relative; background: rgba(255,255,255,.16); color:#fff; border-color:rgba(255,255,255,.14); box-shadow:0 8px 18px rgba(5,20,58,.18); }
        .menu-item.active::before { content:''; position:absolute; left:-1px; top:9px; bottom:9px; width:3px; border-radius:0 4px 4px 0; background:#93c5fd; }
        .menu-item.active .menu-icon { background:rgba(255,255,255,.22); }
        .main { min-width:0; padding:30px 38px; gap:24px; }
        .header { min-height:82px; padding:17px 22px; border-radius:18px; box-shadow:0 8px 24px rgba(23,60,145,.055); }
        .header-title h1 { font-size:21px; letter-spacing:-.45px; }
        .header-title p { margin-top:5px; line-height:1.45; }
        .profile-area { gap:14px; }
        .notification-btn { width:42px; height:42px; border-radius:13px; background:#f8faff; border-color:#e5eaf5; color:#334b7d; }
        .notification-btn:hover { background:#edf3ff; }
        .profile { gap:10px; padding-left:13px; border-left:1px solid var(--border); }
        .profile-name { font-size:13.5px; }
        .profile-role { border-radius:999px; padding:4px 9px; background:#edf4ff; color:#2453a6; }
        .profile-photo { width:44px; height:44px; background:#eaf0ff; color:#2453a6; border:2px solid #d9e5ff; }
        .hero-banner { min-height:186px; padding:30px 34px; border-radius:22px; border:1px solid rgba(255,255,255,.22); background:radial-gradient(circle at 86% 18%,rgba(147,197,253,.25),transparent 26%),linear-gradient(118deg,#123477 0%,#1c4c9e 57%,#3178c4 100%); box-shadow:0 18px 38px rgba(23,60,145,.16); }
        .hero-banner::after { content:''; position:absolute; width:260px; height:260px; border:1px solid rgba(255,255,255,.12); border-radius:50%; right:-72px; bottom:-168px; box-shadow:0 0 0 24px rgba(255,255,255,.035),0 0 0 50px rgba(255,255,255,.025); pointer-events:none; }
        .hero-content,.class-badge { position:relative; z-index:1; }
        .hero-eyebrow { display:inline-flex; margin-bottom:8px; color:rgba(219,234,254,.88); font-size:10px; font-weight:800; letter-spacing:.13em; text-transform:uppercase; }
        .hero-content h2 { font-size:25px; letter-spacing:-.55px; margin-bottom:9px; }
        .hero-content p { color:rgba(239,246,255,.9); font-size:14px; max-width:650px; }
        .class-badge { padding:9px 15px; border-radius:999px; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); color:#fff; backdrop-filter:blur(12px); font-size:12px; box-shadow:inset 0 1px 0 rgba(255,255,255,.12); }
        .class-badge-copy { display:flex; flex-direction:column; line-height:1.15; gap:3px; }
        .class-badge-copy small { color:rgba(219,234,254,.82); font-size:9px; font-weight:700; letter-spacing:.07em; text-transform:uppercase; }
        .class-badge-copy strong { color:#fff; font-size:13px; }
        .stat-grid { gap:16px; }
        .stat-card { min-height:158px; padding:18px 19px 15px; border-radius:18px; gap:9px; transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease; }
        .stat-card:hover { transform:translateY(-3px); box-shadow:var(--shadow-md); border-color:#d5e2fb; }
        .stat-icon { width:42px; height:42px; border-radius:13px; }
        .stat-icon svg { width:20px; height:20px; }
        .stat-title { max-width:calc(100% - 52px); font-size:12.5px; line-height:1.4; }
        .stat-heading-group .stat-title { max-width:none; }
        .stat-value { font-size:28px; line-height:1.1; letter-spacing:-.65px; }
        .stat-footer { min-height:31px; padding-top:8px; font-size:11.5px; line-height:1.4; }
        .stat-footer > span { min-width:0; }
        .stat-footer a { flex-shrink:0; white-space:nowrap; }
        .dashboard-grid { display:grid; grid-template-columns:minmax(0,1fr); gap:20px; }
        .content-card { border-radius:19px; box-shadow:0 8px 24px rgba(23,60,145,.05); }
        .card-header { min-height:62px; padding:15px 20px; gap:14px; background:linear-gradient(180deg,#fff,#fbfcff); }
        .card-header h3 { font-size:14px; line-height:1.4; gap:9px; }
        .card-header h3 i { color:#3567b8; }
        .card-header > a { flex-shrink:0; }
        .table-responsive { overscroll-behavior-x:contain; scrollbar-color:#cbd5e1 transparent; scrollbar-width:thin; }
        table { min-width:740px; font-size:12.5px; }
        thead { background:#f6f8fc; color:#64748b; font-size:11px; letter-spacing:.035em; text-transform:uppercase; }
        th,td { padding:13px 15px; }
        tbody tr:last-child { border-bottom:0; }
        .badge { border-radius:999px; padding:5px 9px; line-height:1.35; white-space:nowrap; }
        .badge-primary { background:#edf3ff; color:#2453a6; }
        .badge-success { background:#eaf8f0; color:#16834a; }
        .badge-warning { background:#fff5df; color:#a45c05; }
        .badge-danger { background:#fff0f0; color:#b8323c; }
        .date-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 8px; border-radius:9px; background:#f1f5ff; color:#214e9a; font-size:11.5px; font-weight:750; white-space:nowrap; }
        .date-meta { display:block; margin-top:5px; color:#8791a3; font-size:10.5px; }
        .request-code { display:inline-flex; margin-top:5px; padding:3px 7px; border:1px solid #dbe7ff; border-radius:7px; background:#f3f7ff; color:#345ca0; font:700 10.5px/1.3 ui-monospace,SFMono-Regular,Menlo,monospace; }
        .service-badge { display:inline-flex; padding:5px 9px; border:1px solid #e5eaf3; border-radius:999px; background:#f8fafc; color:#475569; font-size:11px; font-weight:650; white-space:nowrap; }
        .btn-action { min-height:30px; padding:6px 10px; border-radius:9px; }
        .btn-approve { background:#18884d; }
        .btn-reject { background:#c94049; }
        .student-number { color:#94a3b8; font-weight:700; }
        .student-nis { padding:3px 6px; border-radius:6px; background:#f6f8fb; color:#5b6474; font:600 11px ui-monospace,SFMono-Regular,Menlo,monospace; }
        .student-name { color:#1e3158; font-size:13px; }
        .empty-state { padding:36px 20px!important; color:#7b8799!important; }
        .empty-state i { display:block; margin:0 auto 9px; color:#9aaed1; }
        .alert-warning { border-radius:16px; }
        @media (max-width:1100px) {
            .main { padding:24px 24px; }
            .stat-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
        }
        @media (max-width:900px) {
            .sidebar { display:flex; }
            .hero-banner { min-height:170px; }
        }
        @media (max-width:640px) {
            .main { padding:14px 12px; gap:15px; }
            .header { padding:12px 13px; border-radius:15px; }
            .header-title { min-width:0; flex:1; }
            .header-title h1 { font-size:16px; }
            .header-title p { font-size:11px; }
            .profile-area { gap:8px; }
            .profile { padding-left:8px; gap:0; }
            .profile-photo { width:38px; height:38px; }
            .notification-btn { width:38px; height:38px; }
            .hero-banner { min-height:0; padding:22px 18px; gap:18px; border-radius:19px; }
            .hero-content h2 { font-size:21px; }
            .hero-content p { font-size:12.5px; }
            .class-badge { padding:8px 12px; font-size:12px; }
            .stat-grid { grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
            .stat-card { min-height:145px; padding:14px 13px 12px; border-radius:15px; }
            .stat-title { font-size:11px; }
            .stat-icon { width:36px; height:36px; border-radius:11px; }
            .stat-value { font-size:24px; }
            .stat-footer { font-size:10.5px; }
            .card-header { align-items:flex-start; padding:14px; }
            .card-header h3 { font-size:12.5px; }
            .card-header > a { font-size:10.5px!important; white-space:nowrap; }
            .notification-dropdown { width:min(340px,calc(100vw - 86px)); }
        }
        @media (max-width:390px) {
            .stat-grid { grid-template-columns:1fr; }
            .stat-card { min-height:130px; }
            .card-header { flex-direction:column; }
            .card-header > a { align-self:flex-start; }
        }

        /* Sidebar dipadankan dengan standar master sidebar Guru BK */
        .app { display:flex !important; min-height:100vh; }
        body .sidebar {
            width:235px !important; min-height:100vh; position:fixed !important; left:0; top:0; bottom:0; z-index:60;
            display:flex !important; flex-direction:column; justify-content:space-between; padding:24px 16px !important;
            background:linear-gradient(180deg,#163675 0%,#122c60 52%,#0d2149 100%) !important;
            color:#fff; border-right:1px solid rgba(255,255,255,.08); box-shadow:6px 0 28px rgba(13,33,73,.16);
        }
        body .sidebar .brand { display:flex; align-items:center; gap:13px; padding:6px 10px 24px; border-bottom:1px solid rgba(255,255,255,.10); margin:0 0 20px; }
        body .sidebar .brand-logo { width:48px; height:48px; flex-shrink:0; display:flex; align-items:center; justify-content:center; border-radius:12px; background:linear-gradient(135deg,rgba(255,255,255,.22),rgba(255,255,255,.08)); border:1px solid rgba(255,255,255,.25); box-shadow:0 4px 14px rgba(0,0,0,.12),inset 0 1px 0 rgba(255,255,255,.3); overflow:hidden; padding:4px; }
        body .sidebar .brand-logo img { width:100%; height:100%; object-fit:contain; filter:drop-shadow(0 2px 4px rgba(0,0,0,.15)); }
        body .sidebar .brand-info { display:flex; flex-direction:column; min-width:0; }
        body .sidebar .brand-name { color:#fff; font-size:18px; font-weight:800; letter-spacing:.5px; line-height:1.2; }
        body .sidebar .brand-subtitle { margin-top:3px; color:#b5ccff; font-size:11px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        body .sidebar .brand-badge { display:inline-block; align-self:flex-start; margin-top:3px; padding:2px 6px; border-radius:4px; background:rgba(255,255,255,.15); color:#e0edff; font-size:9.5px; font-weight:700; letter-spacing:.3px; }
        body .sidebar .menu-title { padding:0 12px 10px; color:#9cbaff; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; }
        body .sidebar .menu { display:flex; flex-direction:column; gap:6px; }
        body .sidebar .menu-item, body .sidebar .menu a {
            position:relative; min-height:46px; display:flex; align-items:center; gap:13px; padding:0 14px;
            border:1px solid transparent; border-radius:10px; color:#d1e0ff; font-size:13.5px; font-weight:600;
            transition:all .22s cubic-bezier(.16,1,.3,1); overflow:hidden;
        }
        body .sidebar .menu-item::after, body .sidebar .menu a::after {
            content:""; position:absolute; left:10px; right:10px; bottom:5px; height:2px; border-radius:999px;
            background:linear-gradient(90deg,transparent,rgba(160,195,255,.85),transparent); transform:scaleX(0); opacity:0;
            transition:transform .24s cubic-bezier(.16,1,.3,1),opacity .22s ease; pointer-events:none; z-index:2;
        }
        body .sidebar .menu-item:hover, body .sidebar .menu a:hover {
            color:#fff; background:linear-gradient(90deg,rgba(255,255,255,.13),rgba(255,255,255,.06));
            border-color:rgba(255,255,255,.08); transform:translateX(3px); box-shadow:0 4px 12px rgba(6,22,54,.12);
        }
        body .sidebar .menu-item:hover::after, body .sidebar .menu a:hover::after { transform:scaleX(1); opacity:1; }
        
        
        
        
        body .sidebar .menu-icon { width:28px; height:28px; display:flex; align-items:center; justify-content:center; flex-shrink:0; border-radius:8px; background:rgba(255,255,255,.10); color:#fff; border:1px solid rgba(255,255,255,.08); transition:all .2s cubic-bezier(.16,1,.3,1); }
        body .sidebar .menu-icon > svg { width:17px; height:17px; stroke-width:2; }
        body .sidebar .menu-item:hover .menu-icon, body .sidebar .menu a:hover .menu-icon { background:rgba(255,255,255,.20); color:#fff; border-color:rgba(255,255,255,.18); transform:scale(1.05); }
        
        body .sidebar .menu-label { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        body .sidebar {  }
        body .sidebar .sidebar-bottom { padding-top:16px; border-top:1px solid rgba(255,255,255,.10); margin-top:auto; }
        body .sidebar .sidebar-bottom form { width:100%; }
        body .sidebar .logout-button { width:100%; border:1px solid transparent; background:rgba(239,68,68,.10); color:#fca5a5!important; cursor:pointer; text-align:left; transition:all .2s ease; position:relative; }
        body .sidebar .logout-button::after { content:""; position:absolute; left:10px; right:10px; bottom:5px; height:2px; border-radius:999px; background:linear-gradient(90deg,transparent,rgba(252,165,165,.8),transparent); transform:scaleX(0); opacity:0; transition:transform .24s cubic-bezier(.16,1,.3,1),opacity .22s ease; pointer-events:none; }
        body .sidebar .logout-button .menu-icon { background:rgba(239,68,68,.18); color:#fca5a5; }
        body .sidebar .logout-button:hover { color:#fff!important; background:rgba(239,68,68,.25); border-color:rgba(239,68,68,.35); transform:translateX(3px); }
        body .sidebar .logout-button:hover::after { transform:scaleX(1); opacity:1; }
        body .sidebar .logout-button:hover .menu-icon { background:#ef4444; color:#fff; }
        .main { flex:1; min-width:0; width:auto; max-width:none; margin-left:235px; }
        @media (max-width:1024px) {
            body .sidebar { width:76px!important; padding:20px 10px!important; }
            body .sidebar .brand-info, body .sidebar .menu-title, body .sidebar .menu-label, body .sidebar .brand-badge { display:none!important; }
            body .sidebar .brand { justify-content:center; padding:0 0 18px; }
            body .sidebar .brand-logo { width:44px; height:44px; }
            body .sidebar .menu-item, body .sidebar .menu a { justify-content:center; min-height:44px; padding:0; }
            .main { margin-left:76px; width:auto; max-width:none; }
        }
        /* Header penuh selebar konten, mengikuti arsitektur Dashboard Guru BK */
        .main { padding:0 38px 30px; gap:24px; }
        .header {
            height:74px; min-height:74px; margin:0 -38px; padding:0 36px;
            display:flex; flex-wrap:nowrap; align-items:center; justify-content:flex-end; gap:0;
            position:sticky; top:0; z-index:25; border:0; border-bottom:1px solid #e2e8f0;
            border-radius:0; background:rgba(255,255,255,.88); backdrop-filter:blur(16px);
            -webkit-backdrop-filter:blur(16px); box-shadow:0 2px 14px rgba(15,23,42,.03);
        }
        .header .profile-area { display:flex; align-items:center; gap:16px; }
        .header .notification-btn {
            width:42px; height:42px; display:flex; align-items:center; justify-content:center;
            border:1px solid #e2e8f0; border-radius:12px; background:#fff; color:#334155;
            box-shadow:0 1px 2px rgba(15,23,42,.04); transition:all .2s ease;
        }
        .header .notification-btn:hover { background:#f8fafc; border-color:#cbd5e1; color:#173b82; transform:translateY(-1px); }
        .header .notification-btn > svg { width:19px; height:19px; }
        .header .notification-dot { top:9px; right:9px; width:9px; height:9px; border:2px solid #fff; }
        .header .profile { display:flex; align-items:center; gap:12px; padding-left:14px; border-left:1px solid #e2e8f0; }
        .header .profile-info { text-align:right; }
        .header .profile-name { color:#0f172a; font-size:13.5px; font-weight:700; line-height:1.3; }
        .header .profile-role-badge {
            display:inline-flex; align-items:center; gap:4px; margin-top:2px; padding:1px 8px;
            border:1px solid rgba(37,99,235,.15); border-radius:9999px; background:#eff4fe;
            color:#173b82; font-size:11px; font-weight:700;
        }
        .header .profile-photo {
            width:42px; height:42px; flex-shrink:0; display:flex; align-items:center; justify-content:center;
            overflow:hidden; border:2px solid #fff; border-radius:12px;
            background:linear-gradient(135deg,#e0e7ff,#c7d2fe); color:#173b82;
            box-shadow:0 2px 8px rgba(15,23,42,.08); font-size:15px; font-weight:800;
        }
        .header .profile-photo img { width:100%; height:100%; object-fit:cover; }
        .page-heading h1 { color:#0f172a; font-size:22px; font-weight:800; letter-spacing:-.45px; line-height:1.25; }
        .page-heading p { margin-top:5px; color:#64748b; font-size:13px; line-height:1.45; }
        @media (max-width:1100px) {
            .main { padding-left:24px; padding-right:24px; }
            .header { margin-left:-24px; margin-right:-24px; padding-left:24px; padding-right:24px; }
        }
        @media (max-width:640px) {
            .main { padding:0 12px 18px; gap:18px; }
            .header { height:68px; min-height:68px; margin-left:-12px; margin-right:-12px; padding:0 14px; }
            .header .profile-area { gap:10px; }
            .header .profile { gap:8px; padding-left:10px; }
            .header .profile-name { font-size:12px; }
            .header .profile-role-badge { font-size:9.5px; padding:1px 6px; }
            .header .notification-btn { width:38px; height:38px; }
            .header .profile-photo { width:38px; height:38px; }
            .page-heading h1 { font-size:19px; }
            .page-heading p { font-size:11.5px; }
        }
        @media (max-width:390px) {
            .header .profile-name { max-width:112px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
            .header .profile-role-badge { max-width:125px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        }
    </style>
    @include('partials.theme')
</head>

<body>
<div class="app">
    {{-- Sidebar master yang sama dengan Dashboard Guru BK --}}
    @include('layouts.sidebar')

    {{-- Main Area --}}
    <main class="main">
        {{-- Header --}}
        <header class="header">
            <div class="profile-area">
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

                <div class="profile">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->nama }}</div>
                        <div class="profile-role-badge">
                            <i data-lucide="shield-check" style="width: 12px; height: 12px;"></i>
                            Wali Kelas {{ $kelas ? $kelas->nama_kelas : '' }}
                        </div>
                    </div>
                    <div class="profile-photo">
                        @if (auth()->user()->foto_profil)
                            <img src="{{ route('profile.photo', basename(auth()->user()->foto_profil)) }}" alt="Foto Profil">
                        @else
                            {{ strtoupper(substr(auth()->user()->nama ?? 'W', 0, 1)) }}
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <div class="page-heading">
            <h1>Dashboard Wali Kelas</h1>
            <p>Pemantauan Siswa &amp; Jadwal Bimbingan Kelas {{ $kelas ? $kelas->nama_kelas : '(Belum Ditugaskan)' }}</p>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success" style="background: #eaf8ef; color: #159447; border: 1px solid #b8ebd0; padding: 14px 18px; border-radius: 10px; font-size: 14px; display: flex; align-items: center; gap: 12px; font-weight: 500;">
                <i data-lucide="check-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" style="background: #fff0f0; color: #d64545; border: 1px solid #ffccd0; padding: 14px 18px; border-radius: 10px; font-size: 14px; display: flex; align-items: center; gap: 12px; font-weight: 500;">
                <i data-lucide="alert-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        {{-- Hero / Alert --}}
        @if ($kelas)
            <div class="hero-banner">
                <div class="hero-content">
                    <span class="hero-eyebrow">Ringkasan Kelas Binaan</span>
                    <h2>Selamat datang, {{ auth()->user()->nama }}</h2>
                    <p>Pantau siswa dan jadwal bimbingan kelas <strong>{{ $kelas->nama_kelas }}</strong> dalam satu tempat.</p>
                </div>
                <div class="class-badge">
                    <i data-lucide="school" style="width:17px;height:17px;"></i>
                    <span class="class-badge-copy"><small>Tingkat</small><strong>{{ [7 => 'VII', 8 => 'VIII', 9 => 'IX'][$kelas->tingkat] ?? $kelas->tingkat }}</strong></span>
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

        {{-- Banner Notifikasi Permohonan Izin Siswa --}}
        @if ($pengajuanPending > 0)
            <div style="background: #fff9e6; border: 1px solid #ffd480; border-left: 5px solid #d98218; padding: 18px 24px; border-radius: 14px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: var(--shadow-sm); flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #fff4e3; color: #d98218; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                        <i data-lucide="bell-ring"></i>
                    </div>
                    <div>
                        <strong style="color: #8c5208; font-size: 15px; display: block;">Ada {{ $pengajuanPending }} Siswa Menunggu Approval Izin Mengikuti Bimbingan Konseling</strong>
                        <p style="color: #6d4107; font-size: 13px; margin-top: 3px;">Siswa di kelas binaan Anda membutuhkan izin Wali Kelas untuk mengikuti sesi bimbingan bersama Guru BK.</p>
                    </div>
                </div>
                <a href="{{ route('wali.pengajuan.index') }}" style="background: #d98218; color: white; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13.5px; text-decoration: none; white-space: nowrap; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(217, 130, 24, .25);">
                    <i data-lucide="clipboard-check" style="width: 17px; height: 17px;"></i>
                    Berikan Approval Izin
                </a>
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-blue">
                            <i data-lucide="users"></i>
                        </div>
                        <div class="stat-title">Total Siswa Kelas</div>
                    </div>
                </div>
                <div class="stat-value">{{ $totalSiswaKelas }}</div>
                <div class="stat-footer">
                    <span>Siswa di Kelas {{ $kelas ? $kelas->nama_kelas : '-' }}</span>
                </div>
            </div>

            <div class="stat-card" style="{{ $pengajuanPending > 0 ? 'border: 1.5px solid #ffd480; background: #fffdf8;' : '' }}">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-orange">
                            <i data-lucide="clipboard-check"></i>
                        </div>
                        <div class="stat-title">Menunggu Persetujuan Wali Kelas</div>
                    </div>
                </div>
                <div class="stat-value" style="{{ $pengajuanPending > 0 ? 'color: #d98218;' : '' }}">{{ $pengajuanPending }}</div>
                <div class="stat-footer" style="justify-content: space-between;">
                    <span>Perlu Izin Wali Kelas</span>
                    <a href="{{ route('wali.pengajuan.index') }}" style="color: var(--primary); font-weight: 700; font-size: 11.5px;">Kelola Izin &rarr;</a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-green">
                            <i data-lucide="calendar-clock"></i>
                        </div>
                        <div class="stat-title">Jadwal Bimbingan</div>
                    </div>
                </div>
                <div class="stat-value">{{ $totalJadwalKelas ?? $jadwalSiswa->count() }}</div>
                <div class="stat-footer">
                    <span>Aktivitas Konseling Siswa</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-heading-group flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                        <div class="stat-icon icon-purple">
                            <i data-lucide="user-check"></i>
                        </div>
                        <div class="stat-title">Komposisi Siswa</div>
                    </div>
                </div>
                <div class="stat-value" style="font-size: 20px;">
                    {{ $siswaLaki }} <small style="font-size: 13px; font-weight: 600; color: var(--muted);">L</small> /
                    {{ $siswaPerempuan }} <small style="font-size: 13px; font-weight: 600; color: var(--muted);">P</small>
                </div>
                <div class="stat-footer">
                    <span>{{ $siswaLaki }} Laki-laki, {{ $siswaPerempuan }} Perempuan</span>
                </div>
            </div>
        </div>

        {{-- Two Columns Section --}}
        <div class="dashboard-grid">
            {{-- Pengajuan Izin Siswa & Jadwal Bimbingan --}}
            <div class="content-card" style="grid-column: 1 / -1;">
                <div class="card-header">
                    <h3><i data-lucide="clipboard-check"></i> Pengajuan Izin Siswa &amp; Jadwal Bimbingan</h3>
                    <a href="{{ route('wali.pengajuan.index') }}" style="font-size: 12px; color: var(--primary); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        Kelola Semua Pengajuan <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Bidang Layanan</th>
                                <th>Status</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwalSiswa as $j)
                                @php
                                    $tglPengajuan = \Carbon\Carbon::parse($j->created_at ?? $j->tanggal);
                                    $namaSiswa = $j->siswa->nama_siswa ?? 'Siswa';
                                    $namaKelas = $j->siswa->kelas->nama_kelas ?? ($kelas->nama_kelas ?? '-');
                                    $waktuText = ($j->waktu_mulai && $j->waktu_mulai !== '00:00:00')
                                        ? substr($j->waktu_mulai, 0, 5) . ' - ' . substr($j->waktu_selesai, 0, 5) . ' WIB'
                                        : 'Sesuai Jam Pelajaran';
                                    $tglText = \Carbon\Carbon::parse($j->tanggal)->isoFormat('D MMM Y');
                                    $labelStatus = match($j->status) {
                                        'Diajukan' => 'Menunggu Persetujuan Wali Kelas',
                                        'Disetujui_Wali' => $j->hasSubmittedSchedule() ? 'Izin Disetujui (Menunggu Jadwal BK)' : 'Izin Disetujui Wali Kelas',
                                        'Ditolak_Wali' => 'Izin Ditolak Wali Kelas',
                                        'Terjadwal' => 'Terjadwal oleh Guru BK',
                                        'Selesai' => 'Selesai Konseling',
                                        'Dibatalkan' => 'Jadwal Dibatalkan',
                                        default => str_replace('_', ' ', $j->status),
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <span class="date-badge"><i data-lucide="calendar-days" style="width:13px;height:13px;"></i>{{ $tglText }}</span>
                                        <small class="date-meta">Diajukan: {{ $tglPengajuan->isoFormat('D MMM Y') }}</small>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600; color: var(--primary);">{{ $waktuText }}</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--primary-dark); font-size: 13.5px;">{{ $namaSiswa }}</strong>
                                        @if ($j->kode_pengajuan)
                                            <div><code class="request-code">{{ $j->kode_pengajuan }}</code></div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">Kelas {{ $namaKelas }}</span>
                                    </td>
                                    <td><span class="service-badge">{{ $j->jenis_bimbingan }}</span></td>
                                    <td>
                                        <span class="badge {{ $j->status === 'Terjadwal' ? 'badge-primary' : ($j->status === 'Disetujui_Wali' || $j->status === 'Selesai' ? 'badge-success' : ($j->status === 'Diajukan' ? 'badge-warning' : 'badge-danger')) }}">
                                            {{ $labelStatus }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($j->status === 'Diajukan')
                                            <div style="display: inline-flex; gap: 8px;">
                                                <button type="button" class="btn-action btn-approve"
                                                    onclick="openApproveModal({{ $j->id_penjadwalan }}, '{{ addslashes($namaSiswa) }}', '{{ $tglText }}', '{{ addslashes($waktuText) }}')">
                                                    <i data-lucide="check" style="width: 14px; height: 14px;"></i> Terima
                                                </button>
                                                <button type="button" class="btn-action btn-reject"
                                                    onclick="openRejectModal({{ $j->id_penjadwalan }}, '{{ addslashes($namaSiswa) }}', '{{ $tglText }}')">
                                                    <i data-lucide="x" style="width: 14px; height: 14px;"></i> Tolak
                                                </button>
                                            </div>
                                        @else
                                            <a href="{{ route('wali.pengajuan.index', ['search' => $j->kode_pengajuan ?: ($j->siswa->nama_siswa ?? '')]) }}" class="btn-action" style="background: #f1f5f9; color: var(--text); border: 1px solid #cbd5e1;">
                                                <i data-lucide="eye" style="width: 12px; height: 12px;"></i> Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state" style="text-align: center;">
                                        <i data-lucide="inbox" style="width:24px;height:24px;"></i>
                                        Belum ada permohonan izin atau jadwal bimbingan untuk siswa kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Daftar Siswa Kelas Binaan --}}
            <div class="content-card" style="grid-column: 1 / -1;">
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
                                    <td><span class="student-number">{{ $idx + 1 }}</span></td>
                                    <td><code class="student-nis">{{ $s->nis ?: '-' }}</code></td>
                                    <td><strong class="student-name">{{ $s->nama_siswa }}</strong></td>
                                    <td>{{ $s->jenis_kelamin }}</td>
                                    <td>
                                        <span class="badge {{ $s->status === 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $s->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state" style="text-align: center;">
                                        <i data-lucide="users-round" style="width:24px;height:24px;"></i>
                                        Belum ada data siswa untuk kelas ini.
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
        if (e.target == document.getElementById('approveModal')) closeApproveModal();
        if (e.target == document.getElementById('rejectModal')) closeRejectModal();
    }
</script>
</body>
</html>
