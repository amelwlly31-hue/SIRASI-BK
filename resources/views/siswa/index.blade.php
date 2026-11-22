<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa - SIRASI-BK</title>

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
            --border: #e5e9f0;

            --green: #159447;
            --green-bg: #e9f8ef;

            --red: #d64545;
            --red-bg: #fff0f0;

            --shadow-sm: 0 4px 14px rgba(23, 60, 145, .05);
            --shadow-md: 0 12px 30px rgba(23, 60, 145, .08);
            --shadow-lg: 0 20px 45px rgba(23, 60, 145, .12);
        }

        body {

            background:
                radial-gradient(circle at 85% 0%, rgba(41, 67, 143, .08), transparent 28%),
                var(--bg);
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

        /* app */

        .app {
            display: flex;
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

            box-shadow: 12px 0 35px rgba(15, 45, 112, .10);
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

            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.15),
                0 8px 20px rgba(0,0,0,.10);

            font-size: 20px;
            font-weight: 800;
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
            min-height: 47px;

            display: flex;
            align-items: center;
            gap: 13px;

            padding: 0 14px;

            border-radius: 12px;

            color: #d2dcfa;

            font-size: 13.5px;
            font-weight: 500;

            border: 1px solid transparent;

            transition: .2s ease;
        }

        .menu-item:hover {
            color: white;
            background: rgba(255,255,255,.09);
            transform: translateX(2px);
        }

        .menu-item.active {
            color: white;

            background:
                linear-gradient(
                    90deg,
                    rgba(255,255,255,.17),
                    rgba(255,255,255,.08)
                );

            border-color: rgba(255,255,255,.10);

            box-shadow:
                inset 3px 0 0 #9db9ff,
                0 8px 20px rgba(0,0,0,.08);
        }

        .menu-icon {
            width: 25px;
            height: 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: rgba(255,255,255,.07);

            font-size: 14px;
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
            flex: 1;
            min-width: 0;
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

        .header-search {
            width: 430px;
            height: 42px;

            display: flex;
            align-items: center;

            padding: 0 14px;

            border: 1px solid var(--border);
            border-radius: 12px;

            background: #111c2e;

            transition: .2s ease;
        }

        .header-search:focus-within {
            border-color: #9bb0e8;
            background: #111c2e;
            box-shadow: 0 0 0 4px rgba(23,60,145,.06);
        }

        .header-search span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: #8b93a3;
            flex-shrink: 0;
        }

        .header-search span svg,
        .header-search span i {
            width: 15px !important;
            height: 15px !important;
            display: block;
        }

        .header-search input,
        .header-search input:hover,
        .header-search input:focus,
        .header-search input:focus-visible,
        .header-search input:active {
            width: 100% !important;
            height: 100% !important;
            border: none !important;
            border-width: 0 !important;
            outline: none !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            background: transparent !important;
            background-color: transparent !important;
            color: var(--text) !important;
            font-size: 13px !important;
            padding: 0 !important;
            margin: 0 !important;
            border-radius: 0 !important;
        }

        .header-search input::placeholder {
            color: #9aa1af !important;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification {
            width: 38px;
            height: 38px;

            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);
            border-radius: 11px;

            background: white;
            color: #5c6575;

            box-shadow: var(--shadow-sm);
        }

        .notification-dot {
            width: 7px;
            height: 7px;

            position: absolute;
            top: 7px;
            right: 7px;

            border: 2px solid white;
            border-radius: 50%;

            background: #e14c4c;
        }

        .notification-wrapper {
            position: relative;
        }

        .notification {
            cursor: pointer;
        }

        .notification-dropdown {
            position: absolute;
            top: 48px;
            right: 0;
            width: 340px;
            max-height: 420px;
            overflow-y: auto;

            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;

            box-shadow: 0 15px 35px rgba(23,60,145,.14);

            display: none;
            z-index: 1000;
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-header {
            padding: 15px 17px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
            color: var(--text);
        }

        .notification-item {
            display: flex;
            gap: 11px;

            padding: 13px 15px;

            border-bottom: 1px solid #edf0f4;

            color: var(--text);

            transition: .2s ease;
        }

        .notification-item:hover {
            background: #f7f9ff;
        }

        .notification-item-icon {
            width: 34px;
            height: 34px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--primary-light);
            color: var(--primary);
        }

        .notification-item-content {
            min-width: 0;
        }

        .notification-item-content strong {
            display: block;

            font-size: 11px;
            font-weight: 800;
        }

        .notification-item-content p {
            margin-top: 4px;

            color: var(--muted);

            font-size: 10px;
            line-height: 1.45;
        }

        .notification-item-content small {
            display: block;

            margin-top: 5px;

            color: #9aa1ae;

            font-size: 8px;
        }

        .notification-empty {
            padding: 30px 20px;

            text-align: center;

            color: var(--muted);
        }

        .notification-empty svg {
            width: 28px;
            height: 28px;

            margin-bottom: 8px;
        }

        .notification-empty p {
            font-size: 11px;
        }

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

            background:
                linear-gradient(
                    135deg,
                    #e8eeff,
                    #d5e0ff
                );

            color: var(--primary);

            font-size: 17px;
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
            max-width: 1700px;
            margin: auto;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 16px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .page-title {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary, #173b82);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }

        .page-title h1 {
            font-size: 24px;
            line-height: 1.25;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.025em;
            margin: 0;
        }

        .page-title p {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
            margin-top: 3px;
            line-height: 1.45;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            margin-left: auto;
        }

        /* --------------------------------------------------------------------------
           BUTTONS & MICRO-INTERACTIONS
           -------------------------------------------------------------------------- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 42px;
            padding: 0 18px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
            text-decoration: none;
            box-sizing: border-box;
            white-space: nowrap;
        }

        .btn svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #173b82 0%, #1e4ca6 100%);
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 4px 12px rgba(23, 59, 130, 0.22);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #132e65 0%, #173b82 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(23, 59, 130, 0.32);
            color: #ffffff !important;
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(23, 59, 130, 0.20);
        }

        .btn-secondary,
        .btn-outline {
            background: #ffffff;
            color: #334155 !important;
            border: 1px solid #cbd5e1;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .btn-secondary:hover,
        .btn-outline:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-secondary:active,
        .btn-outline:active {
            transform: translateY(0);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.10);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.20);
        }

        .btn-danger:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.28);
        }

        /* --------------------------------------------------------------------------
           METRIC / STAT CARDS (BENCHMARK DASHBOARD GURU BK)
           -------------------------------------------------------------------------- */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 22px;
            align-items: stretch;
        }

        .summary-card {
            position: relative;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 13px 18px 12px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 104px;
            box-sizing: border-box;
        }

        .summary-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--card-accent, #2563eb);
            opacity: 0.95;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            border-color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .summary-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .summary-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: var(--icon-bg, #eff6ff);
            color: var(--icon-color, #2563eb);
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .summary-card:hover .summary-icon {
            transform: scale(1.08);
        }

        .summary-icon svg {
            width: 20px;
            height: 20px;
            stroke-width: 2.1;
        }

        .summary-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 2.5px 8px;
            border-radius: 9999px;
            background: var(--pill-bg, #eff6ff);
            color: var(--pill-color, #1d4ed8);
            letter-spacing: 0.25px;
            line-height: 1.2;
            border: 1px solid var(--pill-border, rgba(37, 99, 235, 0.12));
        }

        .summary-card-body {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .summary-number {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.15;
            letter-spacing: -0.3px;
            font-variant-numeric: tabular-nums;
        }

        .summary-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #64748b;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Stat Card Color Themes */
        .stat-theme-siswa {
            --card-accent: #2563eb;
            --icon-bg: #eff6ff;
            --icon-color: #2563eb;
            --pill-bg: #eff6ff;
            --pill-color: #1d4ed8;
            --pill-border: rgba(37, 99, 235, 0.15);
        }

        .stat-theme-filter {
            --card-accent: #0284c7;
            --icon-bg: #f0f9ff;
            --icon-color: #0284c7;
            --pill-bg: #f0f9ff;
            --pill-color: #0369a1;
            --pill-border: rgba(2, 132, 199, 0.15);
        }

        .stat-theme-page {
            --card-accent: #6366f1;
            --icon-bg: #eef2ff;
            --icon-color: #6366f1;
            --pill-bg: #eef2ff;
            --pill-color: #4338ca;
            --pill-border: rgba(99, 102, 241, 0.15);
        }

        /* --------------------------------------------------------------------------
           FILTER CARD & INPUT CONTROLS
           -------------------------------------------------------------------------- */
        .filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px 22px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            margin-bottom: 22px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .filter-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
        }

        .filter-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .filter-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .filter-icon svg {
            width: 18px;
            height: 18px;
        }

        .filter-title-wrap {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .filter-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
        }

        .filter-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
            line-height: 1.35;
        }

        .filter-form {
            display: grid;
            grid-template-columns: minmax(240px, 1.8fr) minmax(150px, 1fr) minmax(160px, 1fr) auto;
            gap: 12px;
            align-items: center;
        }

        .filter-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .filter-input-icon {
            position: absolute;
            left: 13px;
            width: 16px;
            height: 16px;
            color: #94a3b8;
            pointer-events: none;
        }

        .search-wrap .search-input {
            padding-left: 38px !important;
        }

        .input {
            width: 100%;
            height: 42px;
            padding: 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            background: #ffffff;
            color: #0f172a;
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-sizing: border-box;

        }

        .input::placeholder {
            color: #94a3b8;
        }

        .input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.14);
            background: #ffffff;
        }

        select.input {
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
        }

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-filter-submit {
            height: 42px;
            padding: 0 20px;
        }

        .btn-filter-reset {
            height: 42px;
            padding: 0 14px;
        }

        /* --------------------------------------------------------------------------
           TABLE CARD & DATA TABLE
           -------------------------------------------------------------------------- */
        .table-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            overflow: hidden;
            margin-bottom: 24px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .table-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.07);
        }

        .table-top {
            padding: 16px 22px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .table-title-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-title-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .table-title-icon svg {
            width: 18px;
            height: 18px;
        }

        .table-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
        }

        .table-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
            line-height: 1.35;
        }

        .result-count {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 9999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11.5px;
            font-weight: 700;
            border: 1px solid rgba(37, 99, 235, 0.15);
        }

        .count-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2563eb;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table,
        table.modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
        }

        table thead th,
        table.modern-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 13px 18px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        table tbody tr,
        table.modern-table tbody tr {
            transition: background 0.16s ease;
        }

        table tbody tr:hover,
        table.modern-table tbody tr:hover {
            background: #f8faff;
        }

        table tbody td,
        table.modern-table tbody td {
            padding: 13px 18px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            color: #334155;
            vertical-align: middle;
        }

        table tbody tr:last-child td,
        table.modern-table tbody tr:last-child td {
            border-bottom: none;
        }

        .row-number {
            font-weight: 600;
            color: #94a3b8;
            font-size: 12px;
        }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
            border: 1px solid rgba(37, 99, 235, 0.15);
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }

        .student-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .student-name,
        .student-info strong {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
        }

        .student-id,
        .student-info span {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
        }

        .nis {
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            font-variant-numeric: tabular-nums;
        }

        .gender-badge,
        .gender-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .gender-male {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
        }

        .gender-female {
            background: #fdf2f8;
            color: #be185d;
            border: 1px solid #fce7f3;
        }

        .class-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .count,
        .count-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 26px;
            height: 26px;
            padding: 0 7px;
            border-radius: 8px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid rgba(37, 99, 235, 0.12);
        }

        .date {
            font-size: 12.5px;
            color: #475569;
            font-weight: 500;
            white-space: nowrap;
        }

        .date-empty {
            font-size: 12px;
            color: #94a3b8;
            font-style: italic;
            white-space: nowrap;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3.5px 10px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-active {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .status-inactive {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .actions form {
            display: inline-flex;
            margin: 0;
            padding: 0;
        }

        .action-btn,
        .action-link,
        .action-button {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            flex-shrink: 0;
            text-decoration: none;
            padding: 0;
            box-sizing: border-box;
        }

        .action-btn svg,
        .action-link svg,
        .action-button svg {
            width: 15px !important;
            height: 15px !important;
        }

        .action-btn:hover,
        .action-link:hover,
        .action-button:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
        }

        .action-btn-view:hover,
        .action-link:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .action-btn-edit:hover {
            background: #fefce8;
            border-color: #fde047;
            color: #a16207;
        }

        .action-btn-toggle-danger,
        .status-toggle {
            color: #d97706 !important;
            border-color: #fde68a !important;
            background: #fffbeb !important;
        }

        .action-btn-toggle-danger:hover,
        .status-toggle:hover {
            background: #d97706 !important;
            border-color: #d97706 !important;
            color: #ffffff !important;
        }

        .action-btn-toggle-success {
            color: #059669 !important;
            border-color: #a7f3d0 !important;
            background: #ecfdf5 !important;
        }

        .action-btn-toggle-success:hover {
            background: #059669 !important;
            border-color: #059669 !important;
            color: #ffffff !important;
        }

        .action-btn-delete,
        .delete-button,
        .action-button.delete {
            color: #dc2626 !important;
            border-color: #fecaca !important;
            background: #fef2f2 !important;
        }

        .action-btn-delete:hover,
        .delete-button:hover,
        .action-button.delete:hover {
            background: #dc2626 !important;
            border-color: #dc2626 !important;
            color: #ffffff !important;
        }

        /* --------------------------------------------------------------------------
           EMPTY STATE
           -------------------------------------------------------------------------- */
        .empty {
            padding: 50px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }

        .empty-icon svg {
            width: 24px;
            height: 24px;
        }

        .empty-title {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .empty-desc {
            font-size: 13px;
            color: #64748b;
            margin: 0;
            line-height: 1.4;
        }

        /* --------------------------------------------------------------------------
           TABLE FOOTER & PAGINATION
           -------------------------------------------------------------------------- */
        .table-footer {
            min-height: 54px;
            padding: 12px 22px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        .pagination-text {
            font-size: 12px;
            color: #64748b;
        }

        .pagination-text strong {
            color: #0f172a;
            font-weight: 700;
        }

        .pagination-wrapper nav {
            display: flex;
            align-items: center;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .pagination-wrapper nav > div:nth-child(2) > div:nth-child(2) {
            margin-top: 5px;
        }

        .pagination-wrapper nav > div:first-child {
            margin-right: 12px;
        }

        .pagination-wrapper svg {
            width: 14px !important;
            height: 14px !important;
        }

        .pagination-wrapper a,
        .pagination-wrapper span {
            min-width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 3px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: white;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.16s ease;
        }

        .pagination-wrapper a:hover {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .pagination-wrapper span[aria-current="page"] {
            background: #173b82;
            border-color: #173b82;
            color: white;
        }

        .pagination-wrapper .text-sm {
            font-size: 11px;
        }

        /* modal */

        .modal-overlay {
            position: fixed;
            inset: 0;

            display: none;
            align-items: center;
            justify-content: center;

            padding: 20px;

            background: rgba(12, 25, 60, .55);
            backdrop-filter: blur(5px);

            z-index: 1000;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            position: relative;
            width: 100%;
            max-width: 580px;
            max-height: calc(100vh - 48px);
            margin: auto;
            display: flex;
            flex-direction: column;
            overflow: hidden;

            border: 1px solid var(--border);
            border-radius: 18px;

            background: white;

            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.25);

            animation: modalIn .2s ease;
        }

        .modal form {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
            overflow: hidden;
            margin: 0;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            min-height: 72px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 24px;

            border-bottom: 1px solid var(--border);
        }

        .modal-heading {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .modal-heading-icon {
            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: var(--primary-light);
            color: var(--primary);
        }

        .modal-title {
            font-size: 17px;
            font-weight: 800;
        }

        .modal-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 10px;
        }

        .modal-close {
            width: 35px;
            height: 35px;

            border: 0;
            border-radius: 10px;

            background: #f5f6f9;
            color: #667085;

            font-size: 21px;

            cursor: pointer;
        }

        .modal-close:hover {
            background: #eceef3;
        }

        .modal-body {
            padding: 22px 24px;
            flex: 1 1 auto;
            max-height: calc(85vh - 140px);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 17px;
        }

        .field {
            display: flex;
            flex-direction: column;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        .field label {
            margin-bottom: 7px;

            color: #374151;

            font-size: 11px;
            font-weight: 700;
        }

        .required {
            color: var(--red);
        }

        .field-control {
            width: 100%;
            min-height: 42px;

            padding: 9px 12px;

            border: 1px solid var(--border);
            border-radius: 10px;

            outline: none;

            background: #fafbfe;
            color: var(--text);

            font-size: 12px;

            transition: .2s ease;
        }

        .field-control:focus {
            border-color: #9bb0e8;
            background: white;

            box-shadow:
                0 0 0 4px rgba(23,60,145,.05);
        }

        textarea.field-control {
            min-height: 95px;
            resize: vertical;
            line-height: 1.5;
        }

        .gender {
            min-height: 42px;

            display: flex;
            align-items: center;
            gap: 20px;
        }

        .gender label {
            display: flex;
            align-items: center;
            gap: 7px;

            margin: 0;

            font-size: 12px;
            font-weight: 500;

            cursor: pointer;
        }

        .gender input {
            appearance: none;
            -webkit-appearance: none;

            width: 14px;
            height: 14px;

            border: 2px solid #60789f;
            border-radius: 50%;

            background: #111c2e;

            cursor: pointer;
        }

        .gender input:checked {
            border-color: var(--primary);
            background:
                radial-gradient(
                    circle,
                    var(--primary) 0 4px,
                    transparent 4.5px
                );
        }

        body.dark-mode .gender input {
            border-color: #60789f;
            background: #111c2e;
        }

        body.dark-mode .gender input:checked {
            border-color: #6f9cff;
            background:
                radial-gradient(
                    circle,
                    #6f9cff 0 4px,
                    transparent 4.5px
                );
        }

        .field-error {
            margin-top: 6px;

            color: var(--red);

            font-size: 10px;
        }

        .error-summary {
            margin-bottom: 18px;
            padding: 13px 15px;

            border: 1px solid #f1cccc;
            border-radius: 11px;

            background: var(--red-bg);
            color: var(--red);

            font-size: 11px;
        }

        .error-summary strong {
            display: block;
            margin-bottom: 5px;
        }

        .error-summary ul {
            padding-left: 17px;
        }

        .import-guide {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid #dbe4ff;
            border-radius: 11px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 11px;
            line-height: 1.5;
        }

        .import-guide strong {
            display: block;
            margin-bottom: 5px;
            color: var(--primary-dark);
        }

        input[type="file"].field-control {
            padding: 7px 10px;
        }

        input[type="file"]::file-selector-button,
        input[type="file"]::-webkit-file-upload-button {
            background: #eef2f6;
            color: #334155;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 5px 12px;
            margin-right: 12px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            transition: .2s ease;
        }

        input[type="file"]::file-selector-button:hover,
        input[type="file"]::-webkit-file-upload-button:hover {
            background: #e2e8f0;
        }

        .modal-footer {
            flex-shrink: 0;
            min-height: 68px;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 12px;

            padding: 16px 24px;

            border-top: 1px solid var(--border);
            background: #f8fafc;
        }

        /* responsive */

        @media (max-width: 1200px) {

            .sidebar {
                width: 235px;
            }

            .main {
                margin-left: 235px;
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .summary-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {

            .sidebar {
                width: 78px;
                padding: 20px 10px;
            }

            .main {
                margin-left: 78px;
            }

            .brand {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            .brand-name,
            .brand-subtitle,
            .menu-title,
            .menu-item span:not(.menu-icon) {
                display: none;
            }

            .menu-item {
                justify-content: center;
                padding: 0;
            }

            .menu-item.active {
                box-shadow: none;
            }

            .header {
                padding: 0 20px;
            }

            .header-search {
                width: 300px;
            }

            .content {
                padding: 22px;
            }
        }

        @media (max-width: 700px) {

            .header {
                min-height: 72px;
                height: auto;

                padding: 14px;

                gap: 12px;
            }

            .header-search {
                width: 100%;
            }

            .profile-info {
                display: none;
            }

            .profile {
                padding-left: 0;
                border-left: 0;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .table-card {
                overflow-x: auto;
            }

            table,
            table.modern-table {
                min-width: 1050px;
            }

            .table-footer {
                flex-direction: column;
                align-items: flex-start;

                padding: 15px 20px;
            }

            .modal-grid {
                grid-template-columns: 1fr;
            }

            .field.full {
                grid-column: auto;
            }

            .modal-footer {
                flex-direction: column-reverse;

                height: auto;

                padding: 14px 24px;
            }

            .modal-footer .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {

            .sidebar {
                width: 66px;
            }

            .main {
                margin-left: 66px;
            }

            .content {
                padding: 16px;
            }

            .header {
                padding: 11px;
            }

            .header-search {
                height: 38px;
            }

            .notification {
                width: 36px;
                height: 36px;
            }

            .profile-photo {
                width: 36px;
                height: 36px;
            }

            .page-title h1 {
                font-size: 23px;
            }
        }

        .status-toggle {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: transparent;
            color: var(--primary);
            cursor: pointer;
            transition: .18s ease;
        }

        .status-toggle svg {
            width: 16px;
            height: 16px;
        }

        .status-toggle:hover {
            background: var(--primary);
            color: #ffffff;
        }

        .status-toggle-danger {
            color: #ef4444;
            border-color: #ef4444;
        }

        .status-toggle-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }

        .delete-button {
            width: 28px !important;
            height: 28px !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: 1px solid #ef4444 !important;
            border-radius: 9px !important;
            background: transparent !important;
            color: #ff6b81 !important;
            cursor: pointer;
            transition: .18s ease;
        }

        .delete-button svg {
            width: 16px !important;
            height: 16px !important;
            color: #ff6b81 !important;
            stroke: #ff6b81 !important;
        }

        .delete-button:hover {
            background: rgba(239, 68, 68, 0.12) !important;
            border-color: #ff6b81 !important;
            color: #ff6b81 !important;
        }

    </style>

<!-- SIRASI-BK MODERN UI OVERRIDES -->
<style>

/* sirasi-bk — modern ui system visual-only enhancement: keeps existing blade/route logic. */
:root{
  --ui-primary:#2855b7;
  --ui-primary-2:#3d6fd1;
  --ui-primary-dark:#17377f;
  --ui-ink:#17233b;
  --ui-muted:#73809a;
  --ui-bg:#f4f7fc;
  --ui-card:#ffffff;
  --ui-line:#e2e8f3;
  --ui-soft:#eef4ff;
  --ui-soft-2:#f7f9fe;
  --ui-shadow:0 8px 24px rgba(28,55,110,.07);
  --ui-shadow-hover:0 16px 36px rgba(28,55,110,.13);
}

html{scroll-behavior:smooth}
body{
  background:
    radial-gradient(circle at 90% 0%,rgba(70,112,207,.10),transparent 28%),
    linear-gradient(180deg,#f8faff 0%,var(--ui-bg) 48%,#f2f5fb 100%);
  color:var(--ui-ink);
}

/* sidebar / navigation */
.sidebar{
  background:
    linear-gradient(180deg,#21499e 0%,#1b408f 48%,#153575 100%) !important;
  box-shadow:12px 0 36px rgba(17,48,113,.14) !important;
}
.brand-logo{
  background:linear-gradient(145deg,rgba(255,255,255,.20),rgba(255,255,255,.08)) !important;
  border-color:rgba(255,255,255,.25) !important;
  box-shadow:inset 0 1px 0 rgba(255,255,255,.20),0 9px 22px rgba(0,0,0,.12) !important;
}
.brand-name,.brand-title{letter-spacing:.1px}
.menu{gap:6px !important}
.menu-item,.menu a{
  position:relative;
  min-height:46px !important;
  border:1px solid transparent !important;
  border-radius:13px !important;
  color:#dce5ff !important;
  font-weight:700 !important;
  transition:background .20s ease,color .20s ease,transform .20s ease,box-shadow .20s ease,border-color .20s ease !important;
}
.menu-item::after,.menu a::after{
  content:"";
  position:absolute;
  left:10px;right:10px;bottom:5px;height:2px;
  border-radius:999px;
  background:linear-gradient(90deg,transparent,rgba(160,195,255,.75),transparent);
  transform:scaleX(0);opacity:0;
  transition:.22s ease;
}
.menu-item:hover,.menu a:hover{
  color:#fff !important;
  background:linear-gradient(90deg,rgba(255,255,255,.13),rgba(255,255,255,.06)) !important;
  border-color:rgba(255,255,255,.08) !important;
  transform:translateX(2px) !important;
  box-shadow:0 7px 18px rgba(6,28,75,.10) !important;
}
.menu-item:hover::after,.menu a:hover::after{transform:scaleX(1);opacity:1}
.menu-item:active,.menu a:active{
  background:linear-gradient(90deg,rgba(151,190,255,.27),rgba(255,255,255,.10)) !important;
  transform:translateX(1px) scale(.995) !important;
}


.menu-icon{
  background:rgba(255,255,255,.085) !important;
  border:1px solid rgba(255,255,255,.035);
  transition:.2s ease;
}
.menu-item:hover .menu-icon,.menu a:hover .menu-icon{background:rgba(255,255,255,.15) !important}

.sidebar-logout button,.logout-button{
  min-height:46px !important;
  border-radius:13px !important;
  color:#dce5ff !important;
  font-weight:700 !important;
  transition:.2s ease !important;
}
.sidebar-logout button:hover,.logout-button:hover{
  color:#fff !important;
  background:rgba(255,255,255,.09) !important;
  transform:translateX(2px);
}
.sidebar-logout button:active,.logout-button:active{background:rgba(151,190,255,.20) !important}

/* topbar */
.header,.topbar{
  background:rgba(255,255,255,.90) !important;
  backdrop-filter:blur(16px) !important;
  -webkit-backdrop-filter:blur(16px);
  border-bottom:1px solid rgba(218,225,238,.85) !important;
  box-shadow:0 2px 18px rgba(25,48,95,.035);
}
.search-box,.search,.notification,.bell{
  border-color:#e0e6f1 !important;
  background:rgba(248,250,254,.92) !important;
  box-shadow:0 4px 14px rgba(30,58,110,.045) !important;
}
.search-box:focus-within,.search:focus-within{
  border-color:#9bb8ed !important;
  box-shadow:0 0 0 4px rgba(40,85,183,.08),0 8px 20px rgba(40,85,183,.06) !important;
}
.profile{border-left-color:#e0e6f0 !important}
.profile-name,.user-name{font-weight:800 !important;color:#18243a !important}
.profile-role,.user-role{color:#7a8599 !important}
.profile-photo,.user-avatar{
  background:linear-gradient(145deg,#edf3ff,#dbe6ff) !important;
  color:#2855b7 !important;
  box-shadow:inset 0 0 0 1px rgba(40,85,183,.10),0 6px 14px rgba(40,85,183,.07) !important;
}

/* page header */
.page-title,h1{color:#17233b}
.eyebrow{color:#2855b7 !important;letter-spacing:1.15px !important}
.page-subtitle,.page-description{color:#77839a !important}

/* universal cards */
.card,.panel,.table-card,.filter-card,.parameter-card,.result-card,.stat-card,.welcome-card,.option-card,.application-card{
  border-color:#e1e7f1 !important;
  box-shadow:var(--ui-shadow) !important;
  background:linear-gradient(145deg,#fff 0%,#fcfdff 100%) !important;
}
.card,.panel,.table-card,.filter-card,.parameter-card,.result-card,.option-card,.application-card{position:relative;overflow:hidden}
.card::before,.panel::before,.table-card::before,.filter-card::after,.parameter-card::before,.result-card::before,.option-card::before,.application-card::before{
  content:"";position:absolute;pointer-events:none;inset:0;
  background:linear-gradient(135deg,rgba(70,112,207,.045),transparent 28%,transparent 72%,rgba(70,112,207,.025));
  opacity:.9;
}
.card:hover,.panel:hover,.table-card:hover,.filter-card:hover,.parameter-card:hover,.result-card:hover,.option-card:hover,.application-card:hover{
  border-color:#cbd8ef !important;
  box-shadow:var(--ui-shadow-hover) !important;
}

/* welcome / hero */
.welcome-card{
  border-radius:22px !important;
  background:linear-gradient(135deg,#fff 0%,#f5f8ff 100%) !important;
  box-shadow:0 14px 34px rgba(30,59,118,.09) !important;
}
.welcome-card::before{background:radial-gradient(circle,rgba(54,97,190,.11),transparent 66%) !important}
.btn,.show-button,.btn-primary{
  transition:transform .20s ease,box-shadow .20s ease,background .20s ease,border-color .20s ease !important;
}
.btn:hover,.show-button:hover{transform:translateY(-2px) !important;box-shadow:0 12px 24px rgba(29,61,126,.13) !important}
.btn:active,.show-button:active{transform:translateY(0) scale(.985) !important}
.btn-primary,.show-button{
  background:linear-gradient(135deg,#315fc4,#234a9f) !important;
  border-color:#234a9f !important;
  box-shadow:0 9px 22px rgba(40,85,183,.22) !important;
}
.btn-primary:hover,.show-button:hover{background:linear-gradient(135deg,#3c6ed3,#234a9f) !important}

/* stat cards */
.stat-card{border-radius:19px !important}
.stat-card::after{background:radial-gradient(circle,rgba(62,101,191,.12),rgba(62,101,191,.02) 68%,transparent 70%) !important}
.stat-card:hover{transform:translateY(-5px) !important}
.stat-icon,.panel-heading-icon,.filter-heading-icon,.table-title-icon,.card-icon,.option-icon,.application-icon{
  background:linear-gradient(145deg,#edf3ff,#e1ebff) !important;
  color:#2855b7 !important;
  box-shadow:inset 0 0 0 1px rgba(40,85,183,.06) !important;
}

/* tables */
thead th,th{background:linear-gradient(180deg,#f8faff,#f3f6fb) !important;color:#68758c !important}
tbody tr{transition:background .16s ease,transform .16s ease !important}
tbody tr:hover{background:#f7faff !important}
.student-avatar{background:linear-gradient(145deg,#edf3ff,#dce7ff) !important;color:#2855b7 !important}

/* report type cards */
.report-types{gap:16px !important}
.report-type{
  position:relative !important;
  overflow:hidden !important;
  border:1px solid #e0e6f0 !important;
  border-radius:18px !important;
  background:linear-gradient(145deg,#fff 0%,#fbfcff 100%) !important;
  box-shadow:var(--ui-shadow) !important;
  transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease,background .22s ease !important;
}
.report-type::after{
  content:"";position:absolute;inset:0;pointer-events:none;
  background:linear-gradient(135deg,rgba(56,99,195,.06),transparent 42%,rgba(56,99,195,.025));
  opacity:0;transition:.22s ease;
}
.report-type::before{background:linear-gradient(180deg,#315fc4,#8fb0ee) !important}
.report-type:hover{
  transform:translateY(-5px) !important;
  border-color:#b9cbed !important;
  box-shadow:0 18px 36px rgba(34,67,135,.13) !important;
}
.report-type:hover::after{opacity:1}
.report-type:active{
  transform:translateY(-1px) scale(.995) !important;
  background:linear-gradient(145deg,#eef4ff,#fff) !important;
  box-shadow:0 10px 24px rgba(40,85,183,.16) !important;
}
.report-type.active{
  border-color:#8ea9df !important;
  background:linear-gradient(145deg,#f1f5ff,#fff) !important;
  box-shadow:0 14px 32px rgba(40,85,183,.12) !important;
}
.report-type.active::after{opacity:1}
.report-icon{transition:transform .22s ease,box-shadow .22s ease,background .22s ease !important}
.report-type:hover .report-icon{transform:translateY(-2px) scale(1.035)}
.report-type.active .report-icon{
  background:linear-gradient(145deg,#2f5fbe,#21499d) !important;
  box-shadow:0 9px 20px rgba(40,85,183,.20) !important;
}
.report-arrow{transition:transform .2s ease,color .2s ease !important}
.report-type:hover .report-arrow{transform:translateX(4px) !important;color:#2855b7 !important}

/* settings */
.option-card{
  border-radius:17px !important;
  transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease,background .22s ease !important;
}
.option-card:hover{transform:translateY(-4px) !important}
.option-card:active{transform:translateY(-1px) scale(.995) !important;background:#f1f5ff !important}
.option-icon{transition:transform .22s ease}
.option-card:hover .option-icon{transform:scale(1.05) rotate(-2deg)}
.application-card{border-radius:17px !important}

/* form controls */
input,select,textarea,.form-control,.filter-select,.filter-date{
  border-color:#dce4f0 !important;
  background:#fbfcfe !important;
  color:#26334b !important;
  transition:border-color .18s ease,box-shadow .18s ease,background .18s ease !important;
}
input:hover,select:hover,textarea:hover,.form-control:hover,.filter-select:hover,.filter-date:hover{border-color:#c7d5eb !important}
/* dark mode — modern ui compatibility */
body:not(.dark-mode) .header-search {
    background: #f8f9fc !important;
    border-color: #dce4f0 !important;
}

html.dark-mode body,
body.dark-mode {
    background:
        radial-gradient(circle at 90% 0%, rgba(67, 105, 190, .16), transparent 30%),
        #0f1728 !important;
    color: #edf3ff !important;
}

/* topbar */
body.dark-mode .header,
body.dark-mode .topbar {
    background: rgba(19, 30, 50, .96) !important;
    border-bottom-color: #2a3852 !important;
}

body.dark-mode .search-box,
body.dark-mode .search,
body.dark-mode .notification,
body.dark-mode .bell {
    background: #111c2e !important;
    border-color: #344560 !important;
    color: #edf3ff !important;
}

body.dark-mode .profile {
    border-left-color: #334463 !important;
}

body.dark-mode .profile-name,
body.dark-mode .user-name {
    color: #f1f5ff !important;
}

body.dark-mode .profile-role,
body.dark-mode .user-role {
    color: #9aa8c0 !important;
}

/* page header */
body.dark-mode .page-title,
body.dark-mode h1 {
    color: #edf3ff !important;
}

body.dark-mode .page-subtitle,
body.dark-mode .page-description {
    color: #9aa8c0 !important;
}

/* cards */
body.dark-mode .card,
body.dark-mode .panel,
body.dark-mode .table-card,
body.dark-mode .filter-card,
body.dark-mode .parameter-card,
body.dark-mode .result-card,
body.dark-mode .stat-card,
body.dark-mode .welcome-card,
body.dark-mode .option-card,
body.dark-mode .application-card {
    background: linear-gradient(145deg, #18253b 0%, #141f33 100%) !important;
    border-color: #2c3b57 !important;
    color: #edf3ff !important;
    box-shadow: 0 15px 35px rgba(0,0,0,.22) !important;
}

body.dark-mode .welcome-card {
    background: linear-gradient(135deg, #18253b 0%, #141f33 100%) !important;
}

/* table */
body.dark-mode thead,
body.dark-mode thead th,
body.dark-mode th {
    background: #141e32 !important;
    color: #9db2d6 !important;
    border-color: #293752 !important;
}

body.dark-mode tbody tr {
    background: transparent !important;
}

body.dark-mode tbody tr:hover {
    background: #1b2942 !important;
}

body.dark-mode td {
    color: #dbe4f4 !important;
    border-color: #24334d !important;
}

body.dark-mode .student-info strong {
    color: #edf3ff !important;
}

body.dark-mode .student-info span,
body.dark-mode .nis,
body.dark-mode .date {
    color: #9aa8c0 !important;
}

body.dark-mode .class-badge {
    background: #1d2c47 !important;
    color: #cbd7ed !important;
}

/* filter */
body.dark-mode .filter-title,
body.dark-mode .table-title {
    color: #edf3ff !important;
}

body.dark-mode .filter-icon {
    background: #1d3154 !important;
    border-color: #304b78 !important;
    color: #9fc0ff !important;
}

body.dark-mode .filter-subtitle,
body.dark-mode .table-subtitle {
    color: #9aa8c0 !important;
}

/* form */
body.dark-mode input,
body.dark-mode select,
body.dark-mode textarea,
body.dark-mode .form-control,
body.dark-mode .filter-select,
body.dark-mode .filter-date,
body.dark-mode .input,
body.dark-mode .field-control {
    background: #111c2e !important;
    border-color: #344560 !important;
    color: #edf3ff !important;
}

body.dark-mode input::placeholder,
body.dark-mode textarea::placeholder {
    color: #7f8da5 !important;
}

/* report type */
body.dark-mode .report-type {
    background: linear-gradient(145deg, #18253b 0%, #141f33 100%) !important;
    border-color: #2c3b57 !important;
    color: #edf3ff !important;
}

body.dark-mode .report-type.active {
    background: linear-gradient(145deg, #20365d 0%, #1a2c4c 100%) !important;
    border-color: #5d83d5 !important;
}

/* button */
body.dark-mode .btn,
body.dark-mode .action {
    background: #162238 !important;
    border-color: #334463 !important;
    color: #cbd7ed !important;
}

body.dark-mode .btn-primary,
body.dark-mode .show-button {
    background: linear-gradient(135deg, #2a55b8, #173c91) !important;
    border-color: #3967d1 !important;
    color: #ffffff !important;
}

/* pagination */
body.dark-mode .pagination-wrapper a,
body.dark-mode .pagination-wrapper span {
    background: #162238 !important;
    border-color: #334463 !important;
    color: #cbd7ed !important;
}

body.dark-mode .pagination-wrapper span[aria-current="page"] {
    background: #2a55b8 !important;
    border-color: #3967d1 !important;
    color: #ffffff !important;
}

/* empty state */
body.dark-mode .empty {
    color: #9aa8c0 !important;
}

/* modal */
body.dark-mode .modal {
    background: linear-gradient(145deg, #18253b 0%, #121d30 100%) !important;
    border-color: #334463 !important;
    color: #edf3ff !important;
}

body.dark-mode .modal-header,
body.dark-mode .modal-footer {
    border-color: #293752 !important;
}

body.dark-mode .modal-title,
body.dark-mode .modal-heading {
    color: #edf3ff !important;
}

body.dark-mode .modal-subtitle,
body.dark-mode .field label {
    color: #9aa8c0 !important;
}

body.dark-mode .modal-close {
    background: #1d2c47 !important;
    color: #cbd7ed !important;
}

body.dark-mode .modal-heading-icon {
    background: #1d2c47 !important;
    color: #a9c5ff !important;
}

body.dark-mode .gender-badge {
    background: #1d2c47 !important;
    color: #a9c5ff !important;
}

body.dark-mode .count {
    background: #1d2c47 !important;
    color: #a9c5ff !important;
}

body.dark-mode .result-count {
    background: #1d2c47 !important;
    color: #a9c5ff !important;
}

body.dark-mode .import-guide {
    background: #192742 !important;
    border-color: #2e436d !important;
    color: #c9d8fa !important;
}

body.dark-mode .import-guide strong {
    color: #ffffff !important;
}

body.dark-mode input[type="file"].field-control {
    background: #111c2e !important;
    border-color: #344560 !important;
    color: #edf3ff !important;
}

body.dark-mode input[type="file"]::file-selector-button,
body.dark-mode input[type="file"]::-webkit-file-upload-button {
    background: #1e2c45 !important;
    color: #dce5ff !important;
    border: 1px solid #344560 !important;
    border-radius: 6px !important;
    padding: 5px 12px !important;
    margin-right: 12px !important;
    cursor: pointer !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    transition: .2s ease !important;
}

body.dark-mode input[type="file"]::file-selector-button:hover,
body.dark-mode input[type="file"]::-webkit-file-upload-button:hover {
    background: #273957 !important;
    color: #ffffff !important;
    border-color: #4a638b !important;
}

body.dark-mode .status-active {
    background: #193a2a !important;
    color: #75d6a0 !important;
}

body.dark-mode .status-active::before {
    background: #55c98a !important;
}

body.dark-mode .actions .action-link,
body.dark-mode .actions .action-button,
body.dark-mode .actions .action-btn {
    background: #18253b !important;
    border-color: #3b5685 !important;
    color: #a9c5ff !important;
}

body.dark-mode .actions .action-link:hover,
body.dark-mode .actions .action-button:hover,
body.dark-mode .actions .action-btn:hover {
    background: #22365a !important;
    border-color: #5d83d5 !important;
    color: #ffffff !important;
}

body.dark-mode .actions .status-toggle,
body.dark-mode .actions .delete-button,
body.dark-mode .actions .action-button.delete,
body.dark-mode .actions .action-btn-delete,
body.dark-mode .actions .action-btn-toggle-danger {
    background: rgba(225, 76, 76, .12) !important;
    border-color: rgba(225, 76, 76, .35) !important;
    color: #ff8f9a !important;
}

body.dark-mode .actions .status-toggle:hover,
body.dark-mode .actions .delete-button:hover,
body.dark-mode .actions .action-button.delete:hover,
body.dark-mode .actions .action-btn-delete:hover,
body.dark-mode .actions .action-btn-toggle-danger:hover {
    background: #d64545 !important;
    border-color: #d64545 !important;
    color: #ffffff !important;
}

body.dark-mode .actions .action-btn-toggle-success {
    background: rgba(16, 185, 129, 0.15) !important;
    border-color: rgba(16, 185, 129, 0.35) !important;
    color: #6ee7b7 !important;
}

body.dark-mode .actions .action-btn-toggle-success:hover {
    background: #059669 !important;
    border-color: #059669 !important;
    color: #ffffff !important;
}

body.dark-mode .summary-card {
    background: #18253b !important;
    border-color: #2c3b57 !important;
}

body.dark-mode .summary-number {
    color: #f8fafc !important;
}

body.dark-mode .summary-label {
    color: #94a3b8 !important;
}

body.dark-mode .stat-theme-siswa {
    --card-accent: #3b82f6 !important;
    --icon-bg: rgba(59, 130, 246, 0.15) !important;
    --icon-color: #60a5fa !important;
    --pill-bg: rgba(59, 130, 246, 0.15) !important;
    --pill-color: #93c5fd !important;
    --pill-border: rgba(59, 130, 246, 0.3) !important;
}

body.dark-mode .stat-theme-filter {
    --card-accent: #38bdf8 !important;
    --icon-bg: rgba(56, 189, 248, 0.15) !important;
    --icon-color: #38bdf8 !important;
    --pill-bg: rgba(56, 189, 248, 0.15) !important;
    --pill-color: #7dd3fc !important;
    --pill-border: rgba(56, 189, 248, 0.3) !important;
}

body.dark-mode .stat-theme-page {
    --card-accent: #818cf8 !important;
    --icon-bg: rgba(129, 140, 248, 0.15) !important;
    --icon-color: #a5b4fc !important;
    --pill-bg: rgba(129, 140, 248, 0.15) !important;
    --pill-color: #c7d2fe !important;
    --pill-border: rgba(129, 140, 248, 0.3) !important;
}

body.dark-mode .gender-male {
    background: rgba(59, 130, 246, 0.15) !important;
    color: #93c5fd !important;
    border-color: rgba(59, 130, 246, 0.3) !important;
}

body.dark-mode .gender-female {
    background: rgba(244, 63, 94, 0.15) !important;
    color: #fda4af !important;
    border-color: rgba(244, 63, 94, 0.3) !important;
}

body.dark-mode .count-pill {
    background: rgba(59, 130, 246, 0.15) !important;
    color: #93c5fd !important;
    border-color: rgba(59, 130, 246, 0.3) !important;
}

body.dark-mode .btn-secondary {
    background: #18253b !important;
    border-color: #3b5685 !important;
    color: #cbd7ed !important;
}

body.dark-mode .btn-secondary:hover {
    background: #22365a !important;
    border-color: #5d83d5 !important;
    color: #ffffff !important;
}

body.dark-mode form .logout-button {
    background: transparent !important;
    border: 1px solid transparent !important;
    color: #dce5ff !important;
    box-shadow: none !important;
    outline: none !important;
}

body.dark-mode form .logout-button .menu-icon {
    background: rgba(255,255,255,.085) !important;
    color: #dce5ff !important;
}

body.dark-mode form .logout-button:hover {
    background: rgba(255,255,255,.09) !important;
    border-color: transparent !important;
    color: #ffffff !important;
}

body.dark-mode form .logout-button:hover .menu-icon {
    background: rgba(255,255,255,.15) !important;
    color: #ffffff !important;
}

/* focus / click feedback */
a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible,textarea:focus-visible{
  outline:3px solid rgba(91,132,211,.28) !important;
  outline-offset:2px;
}

/* responsive */
@media(max-width:900px){
  .report-types{grid-template-columns:1fr !important}
}
@media(max-width:650px){
  .menu-item,.menu a{font-size:13px !important}
  .profile-name,.user-name{font-size:12px !important}
}

/* Alert / Toast */
.alert-toast {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 18px;
    padding: 13px 16px;
    border: 1px solid #a7e2c0;
    border-radius: 12px;
    background: #f0fbf4;
    color: #17643a;
    font-size: 13px;
    font-weight: 650;
    line-height: 1.5;
}

.alert-toast svg {
    width: 18px;
    height: 18px;
    flex: 0 0 18px;
}

.alert-toast-danger {
    border-color: #f5c2c7;
    background: #fff0f0;
    color: #d64545;
}

/* Import Data Siswa modal */
.import-toast {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 18px;
    padding: 13px 16px;
    border: 1px solid #a7e2c0;
    border-radius: 12px;
    background: #f0fbf4;
    color: #17643a;
    font-size: 13px;
    font-weight: 650;
    line-height: 1.5;
}

.import-toast svg {
    width: 18px;
    height: 18px;
    flex: 0 0 18px;
}

#importModal {
    padding: clamp(12px, 3vw, 28px);
}

#importModal .modal {
    width: min(100%, 760px);
    max-width: 760px;
    max-height: min(88vh, 780px);
    max-height: min(88dvh, 780px);
    border-radius: 20px;
}

#importModal .modal-header {
    min-height: 92px;
    padding: 18px 26px;
    gap: 20px;
}

#importModal .modal-heading {
    min-width: 0;
    gap: 14px;
}

#importModal .modal-heading-icon {
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    border-radius: 14px;
}

#importModal .modal-heading-icon svg {
    width: 21px;
    height: 21px;
}

#importModal .modal-title {
    color: #172b4d;
    font-size: 18px;
    line-height: 1.3;
    letter-spacing: -.02em;
}

#importModal .modal-subtitle {
    margin-top: 5px;
    font-size: 12px;
    line-height: 1.5;
}

#importModal .modal-close {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e5eaf2;
    transition: background .18s ease, border-color .18s ease, color .18s ease;
}

#importModal .modal-close svg {
    width: 18px;
    height: 18px;
}

#importModal .modal-close:hover {
    border-color: #cbd5e1;
    color: #334155;
}

#importModal form {
    flex: 1 1 auto;
    min-height: 0;
}

#importModal .modal-body {
    flex: 1 1 auto;
    min-height: 0;
    max-height: none;
    padding: 24px 26px;
    overflow-x: hidden;
    overflow-y: auto;
    overscroll-behavior: contain;
    scrollbar-gutter: stable;
}

#importModal .import-guide-panel {
    margin: 0 0 22px;
    padding: 19px 20px;
    border: 1px solid #dce7f8;
    border-radius: 16px;
    background: linear-gradient(145deg, #f7faff 0%, #f1f6ff 100%);
    color: #334155;
}

#importModal .import-guide-header {
    display: flex;
    align-items: center;
    gap: 11px;
}

#importModal .import-guide-icon {
    width: 34px;
    height: 34px;
    flex: 0 0 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #e3edff;
    color: #2453a6;
}

#importModal .import-guide-icon svg {
    width: 17px;
    height: 17px;
}

#importModal .import-guide-title {
    color: #173b72;
    font-size: 14px;
    font-weight: 750;
    line-height: 1.35;
}

#importModal .import-guide-desc {
    margin: 13px 0 17px;
    color: #52627a;
    font-size: 12px;
    line-height: 1.65;
}

#importModal .import-guide-desc strong {
    color: #263c5c;
    font-weight: 700;
}

#importModal .import-col-label {
    margin-bottom: 9px;
    color: #42536d;
    font-size: 11px;
    font-weight: 750;
}

#importModal .import-col-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

#importModal .col-pill {
    min-height: 30px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 5px 10px;
    border: 1px solid #dce4ef;
    border-radius: 8px;
    background: #fff;
    color: #44536a;
    font-size: 11px;
    font-weight: 650;
    line-height: 1.3;
    white-space: nowrap;
}

#importModal .column-index {
    width: 20px;
    height: 20px;
    flex: 0 0 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: #edf2f9;
    color: #61728b;
    font-size: 9px;
    font-weight: 800;
    font-variant-numeric: tabular-nums;
}

#importModal .col-pill.required {
    border-color: #c9dafb;
    background: #edf4ff;
    color: #244f97;
}

#importModal .import-guide-note {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-top: 15px;
    padding-top: 13px;
    border-top: 1px solid #dce6f3;
    color: #5b6b81;
    font-size: 11px;
    line-height: 1.55;
}

#importModal .import-guide-note svg {
    width: 15px;
    height: 15px;
    flex: 0 0 15px;
    margin-top: 1px;
    color: #25845f;
}

#importModal .modal-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 19px 20px;
}

#importModal .field {
    min-width: 0;
}

#importModal .field label {
    margin-bottom: 8px;
    color: #34445d;
    font-size: 12px;
    line-height: 1.4;
}

#importModal .field-control {
    min-height: 46px;
    padding: 10px 13px;
    border-radius: 11px;
    background-color: #fbfcfe;
    font-size: 13px;
}

#importModal select.field-control {
    cursor: pointer;
}

#importModal select.field-control:disabled {
    cursor: not-allowed;
    color: #8995a7;
    background-color: #f1f4f8;
}

#importModal .field-hint {
    margin-top: 8px;
    color: #718096;
    font-size: 11px;
    line-height: 1.55;
}

#importModal .file-upload-wrapper {
    padding: 10px;
    border: 1px dashed #c9d5e6;
    border-radius: 12px;
    background: #f8faff;
}

#importModal input[type="file"].field-control {
    min-height: 44px;
    padding: 6px;
    border: 0;
    background: transparent;
    font-size: 12px;
}

#importModal input[type="file"]::file-selector-button,
#importModal input[type="file"]::-webkit-file-upload-button {
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 11px;
}

#importModal .modal-footer {
    position: sticky;
    bottom: 0;
    min-height: 76px;
    flex: 0 0 auto;
    flex-direction: row;
    gap: 10px;
    padding: 13px 26px;
    border-top: 1px solid #e5eaf1;
    background: #fff;
    box-shadow: 0 -5px 14px rgba(15, 23, 42, .035);
}

#importModal .modal-footer .btn {
    min-height: 42px;
    min-width: 112px;
    justify-content: center;
    border-radius: 10px;
    font-size: 12px;
}

body.dark-mode .alert-toast {
    border-color: #2b7250 !important;
    background: #173b2b !important;
    color: #a7edc2 !important;
}

body.dark-mode .alert-toast-danger {
    border-color: #74414c !important;
    background: #3c2028 !important;
    color: #ffd0d6 !important;
}

body.dark-mode .import-toast {
    border-color: #2b7250 !important;
    background: #173b2b !important;
    color: #a7edc2 !important;
}

body.dark-mode #importModal .import-error-summary {
    background: #3c2028 !important;
    border-color: #74414c !important;
    color: #ffd0d6 !important;
}

body.dark-mode #importModal .modal-title {
    color: #edf3ff !important;
}

body.dark-mode #importModal .import-guide-panel {
    border-color: #2e436d !important;
    background: linear-gradient(145deg, #192742 0%, #17243a 100%) !important;
    color: #c9d8fa !important;
}

body.dark-mode #importModal .import-guide-icon {
    background: #22375a !important;
    color: #a9c5ff !important;
}

body.dark-mode #importModal .import-guide-title,
body.dark-mode #importModal .import-guide-desc strong {
    color: #e4edff !important;
}

body.dark-mode #importModal .import-guide-desc,
body.dark-mode #importModal .import-col-label,
body.dark-mode #importModal .import-guide-note,
body.dark-mode #importModal .field-hint {
    color: #aab8d0 !important;
}

body.dark-mode #importModal .col-pill {
    border-color: #344560 !important;
    background: #1b2a43 !important;
    color: #d4def0 !important;
}

body.dark-mode #importModal .column-index {
    background: #253856 !important;
    color: #b9cae8 !important;
}

body.dark-mode #importModal .col-pill.required {
    border-color: #3c5e99 !important;
    background: #20365b !important;
    color: #c7d9ff !important;
}

body.dark-mode #importModal .import-guide-note {
    border-color: #2e4360 !important;
}

body.dark-mode #importModal .file-upload-wrapper {
    border-color: #3c5274 !important;
    background: #142139 !important;
}

body.dark-mode #importModal .modal-footer {
    border-color: #293752 !important;
    background: #121d30 !important;
}

@media (max-width: 700px) {
    #importModal .modal {
        max-height: min(92vh, 780px);
        max-height: min(92dvh, 780px);
    }

    #importModal .modal-header {
        min-height: 80px;
        padding: 15px 18px;
    }

    #importModal .modal-body {
        padding: 18px;
    }

    #importModal .import-guide-panel {
        margin-bottom: 18px;
        padding: 16px;
    }

    #importModal .modal-grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 16px;
    }

    #importModal .field.full {
        grid-column: auto;
    }

    #importModal .modal-footer {
        flex-direction: row;
        padding: 12px 18px calc(12px + env(safe-area-inset-bottom));
    }

    #importModal .modal-footer .btn {
        width: auto;
        min-width: 0;
        flex: 1 1 0;
    }
}

@media (max-width: 420px) {
    #importModal .modal-heading {
        gap: 10px;
    }

    #importModal .modal-heading-icon {
        width: 40px;
        height: 40px;
        flex-basis: 40px;
    }

    #importModal .modal-title {
        font-size: 16px;
    }

    #importModal .modal-subtitle {
        font-size: 11px;
    }

    #importModal .modal-close {
        width: 34px;
        height: 34px;
        flex-basis: 34px;
    }

    #importModal .col-pill {
        padding: 5px 8px;
        font-size: 10px;
    }
}

</style>
    @include('partials.theme')
</head>

<body>

<div class="app">

    @php
        $siswaIndexRoute = request()->routeIs('admin.siswa.index') ? 'admin.siswa.index' : 'siswa.index';
    @endphp

    {{-- sidebar --}}

    @include('layouts.sidebar')

    {{-- main --}}

    <main class="main">

        {{-- header --}}

        <header class="header">

            <div class="profile-area">

                <div class="notification-wrapper">

                    <button
                        type="button"
                        class="notification"
                        id="notificationButton"
                    >
                        <i data-lucide="bell"></i>

                        @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                            <span class="notification-dot" id="notificationDot"></span>
                        @endif
                    </button>

                    <div
                        class="notification-dropdown"
                        id="notificationDropdown"
                    >
                        <div class="notification-header">
                            <strong>Notifikasi</strong>
                        </div>

                        @forelse ($notifikasis ?? [] as $notifikasi)

                            <a
                                href="{{ route('notifikasi.baca', $notifikasi->id) }}"
                                class="notification-item {{ !$notifikasi->dibaca ? 'unread' : '' }}"
                            >
                                <div class="notification-item-icon">
                                    <i data-lucide="clipboard-list"></i>
                                </div>

                                <div class="notification-item-content">
                                    <strong>{{ $notifikasi->judul }}</strong>

                                    <p>{{ preg_replace('/\s*\[JADWAL:\d+\]/', '', $notifikasi->pesan) }}</p>

                                    <small>
                                        {{ $notifikasi->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </a>

                        @empty

                            <div class="notification-empty">
                                <i data-lucide="bell-off"></i>
                                <p>Belum ada notifikasi</p>
                            </div>

                        @endforelse
                    </div>

                </div>

                <div class="profile">

                    <div class="profile-info">

                        <div class="profile-name">
                            {{ auth()->user()->nama }}
                        </div>

                        <div class="profile-role">
                            {{ auth()->user()->role }}
                        </div>

                    </div>

                    <div class="profile-photo">
                        @if (auth()->user()->foto_profil)
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

            @if (session('success'))
                <div class="alert-toast" role="status">
                    <i data-lucide="circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-toast alert-toast-danger" role="alert">
                    <i data-lucide="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('import_success'))
                <div class="import-toast" role="status">
                    <i data-lucide="circle-check"></i>
                    <span>{{ session('import_success') }}</span>
                </div>
            @endif

            {{-- page header --}}

            <div class="page-header" style="justify-content: flex-end;">

                <div class="page-title">

                    <div class="eyebrow">
                        <i data-lucide="folder-kanban" style="width: 13px; height: 13px;"></i>
                        <span>Manajemen Data</span>
                    </div>

                    <h1>
                        Data Siswa
                    </h1>

                    <p>
                        Kelola data profil, tingkat, kelas, serta pantau riwayat konseling siswa SMP Negeri 2 Dramaga.
                    </p>

                </div>

                <div class="header-actions" style="margin-left: auto; justify-content: flex-end;">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="openImportModal()"
                    >
                        <i data-lucide="file-up"></i>
                        <span>Import Excel</span>
                    </button>

                    <a
                        href="{{ route('siswa.create') }}"
                        class="btn btn-primary"
                    >
                        <i data-lucide="user-plus"></i>
                        <span>Tambah Siswa</span>
                    </a>

                </div>

            </div>

            {{-- summary / metric cards --}}

            <div class="summary-grid">

                <div class="summary-card stat-theme-siswa">
                    <div class="summary-card-header">
                        <div class="summary-icon">
                            <i data-lucide="users"></i>
                        </div>
                        <span class="summary-badge">Aktif Terdata</span>
                    </div>
                    <div class="summary-card-body">
                        <div class="summary-number">{{ number_format($siswa->total(), 0, ',', '.') }}</div>
                        <div class="summary-label">Total Siswa</div>
                    </div>
                </div>

                <div class="summary-card stat-theme-filter">
                    <div class="summary-card-header">
                        <div class="summary-icon">
                            <i data-lucide="list-filter"></i>
                        </div>
                        <span class="summary-badge">Hasil Filter</span>
                    </div>
                    <div class="summary-card-body">
                        <div class="summary-number">{{ number_format($siswa->count(), 0, ',', '.') }}</div>
                        <div class="summary-label">Data Ditampilkan</div>
                    </div>
                </div>

                <div class="summary-card stat-theme-page">
                    <div class="summary-card-header">
                        <div class="summary-icon">
                            <i data-lucide="book-open"></i>
                        </div>
                        <span class="summary-badge">Dari {{ $siswa->lastPage() }} Hal</span>
                    </div>
                    <div class="summary-card-body">
                        <div class="summary-number">{{ $siswa->currentPage() }}</div>
                        <div class="summary-label">Halaman Aktif</div>
                    </div>
                </div>

            </div>

            {{-- filter --}}

            <div class="filter-card">

                <div class="filter-header">

                    <div class="filter-icon">
                        <i data-lucide="sliders-horizontal"></i>
                    </div>

                    <div class="filter-title-wrap">

                        <div class="filter-title">
                            Filter & Pencarian Siswa
                        </div>

                        <div class="filter-subtitle">
                            Gunakan filter untuk menemukan siswa berdasarkan kata kunci, jenjang, atau kelas.
                        </div>

                    </div>

                </div>

                <form
                    action="{{ route($siswaIndexRoute) }}"
                    method="GET"
                    class="filter-form"
                >

                    <div class="filter-input-wrap search-wrap">
                        <i data-lucide="search" class="filter-input-icon"></i>
                        <input
                            type="text"
                            name="search"
                            class="input search-input"
                            placeholder="Cari nama atau kelas siswa..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="filter-input-wrap">
                        <select
                            name="tingkat"
                            class="input select-input"
                        >

                            <option value="">
                                Semua Tingkat
                            </option>

                            @foreach ([7, 8, 9] as $tingkat)

                                <option
                                    value="{{ $tingkat }}"
                                    {{ request('tingkat') == $tingkat ? 'selected' : '' }}
                                >
                                    Kelas {{ [7 => 'VII', 8 => 'VIII', 9 => 'IX'][$tingkat] }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="filter-input-wrap">
                        <select
                            name="kelas"
                            class="input select-input"
                        >

                            <option value="">
                                Semua Kelas
                            </option>

                            @foreach (\App\Models\Kelas::all() as $kelas)

                                <option
                                    value="{{ $kelas->id_kelas }}"
                                    {{ request('kelas') == $kelas->id_kelas ? 'selected' : '' }}
                                >
                                    {{ $kelas->nama_kelas }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="filter-actions">
                        <button
                            type="submit"
                            class="btn btn-primary btn-filter-submit"
                        >
                            <i data-lucide="search"></i>
                            Cari
                        </button>

                        @if (request()->hasAny(['search', 'tingkat', 'kelas']) && (request('search') || request('tingkat') || request('kelas')))
                            <a
                                href="{{ route($siswaIndexRoute) }}"
                                class="btn btn-secondary btn-filter-reset"
                                title="Reset Filter"
                            >
                                <i data-lucide="rotate-ccw"></i>
                                Reset
                            </a>
                        @endif
                    </div>

                </form>

            </div>

            {{-- table card --}}

            <div class="table-card">

                <div class="table-top">

                    <div class="table-title-area">

                        <div class="table-title-icon">
                            <i data-lucide="users-round"></i>
                        </div>

                        <div>

                            <div class="table-title">
                                Daftar Siswa
                            </div>

                            <div class="table-subtitle">
                                Data siswa terdaftar dan riwayat bimbingan konseling.
                            </div>

                        </div>

                    </div>

                    <div class="result-count">
                        <span class="count-dot"></span>
                        {{ number_format($siswa->total(), 0, ',', '.') }} Siswa
                    </div>

                </div>

                <div class="table-wrap">

                    <table class="modern-table">

                        <thead>

                            <tr>

                                <th style="width: 55px; text-align: center;">
                                    No
                                </th>

                                <th>
                                    Siswa
                                </th>

                                <th>
                                    NIS
                                </th>

                                <th>
                                    Jenis Kelamin
                                </th>

                                <th>
                                    Kelas
                                </th>

                                <th style="text-align: center;">
                                    Konseling
                                </th>

                                <th>
                                    Konseling Terakhir
                                </th>

                                <th>
                                    Status
                                </th>

                                <th style="text-align: center; width: 140px;">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($siswa as $index => $item)

                                <tr>

                                    <td style="text-align: center;" class="row-number">
                                        {{ $siswa->firstItem() + $index }}
                                    </td>

                                    <td>

                                        <div class="student-cell">

                                            <div class="student-avatar">

                                                {{
                                                    strtoupper(
                                                        substr(
                                                            $item->nama_siswa ?? 'S',
                                                            0,
                                                            1
                                                        )
                                                    )
                                                }}

                                            </div>

                                            <div class="student-info">

                                                <strong class="student-name">
                                                    {{ $item->nama_siswa }}
                                                </strong>

                                                <span class="student-id">
                                                    ID #{{ $item->id_siswa }}
                                                </span>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <span class="nis">
                                            {{ $item->nis ?: '-' }}
                                        </span>

                                    </td>

                                    <td>

                                        @php
                                            $isMale = in_array(strtoupper(trim($item->jenis_kelamin ?? '')), ['L', 'LAKI-LAKI', 'LAKI - LAKI']);
                                        @endphp
                                        <span class="gender-pill {{ $isMale ? 'gender-male' : 'gender-female' }}">
                                            {{ $item->jenis_kelamin }}
                                        </span>

                                    </td>

                                    <td>

                                        <span class="class-badge">
                                            {{ $item->kelas->nama_kelas ?? '-' }}
                                        </span>

                                    </td>

                                    <td style="text-align: center;">

                                        <span class="count-pill">
                                            {{ $item->konseling_count }}
                                        </span>

                                    </td>

                                    <td>

                                        @if ($item->konseling_terakhir)

                                            <span class="date">

                                                {{
                                                    \Carbon\Carbon::parse(
                                                        $item->konseling_terakhir
                                                    )->format('d M Y')
                                                }}

                                            </span>

                                        @else

                                            <span class="date-empty">
                                                Belum ada
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if (($item->status ?? 'Aktif') === 'Aktif')

                                            <span class="status status-active">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="status status-inactive">
                                                {{ $item->status }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="actions">
                                            @if (auth()->user() && (auth()->user()->isGuruBk() || auth()->user()->isAdmin()))
                                            <a
                                                href="{{ route('siswa.show', [$item->id_siswa, 'from' => 'siswa']) }}"
                                                class="action-btn action-btn-view"
                                                title="Lihat Detail Riwayat Konseling"
                                            >
                                                <i data-lucide="eye"></i>
                                            </a>
                                            @endif

                                            <a
                                                href="{{ route('siswa.edit', $item->id_siswa) }}"
                                                class="action-btn action-btn-edit"
                                                title="Edit Siswa"
                                            >
                                                <i data-lucide="pencil"></i>
                                            </a>

                                            <form
                                                action="{{ route('siswa.toggleStatus', $item->id_siswa) }}"
                                                method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Yakin ingin mengubah status siswa ini?');"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="action-btn action-btn-toggle {{ ($item->status ?? 'Aktif') === 'Aktif' ? 'action-btn-toggle-danger' : 'action-btn-toggle-success' }}"
                                                    title="{{ ($item->status ?? 'Aktif') === 'Aktif' ? 'Nonaktifkan Siswa' : 'Aktifkan Siswa' }}"
                                                >
                                                    <i data-lucide="power"></i>
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('siswa.destroy', $item->id_siswa) }}"
                                                method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirmDelete()"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="action-btn action-btn-delete delete-button"
                                                    title="Hapus Siswa"
                                                >
                                                    <i data-lucide="trash-2"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="9"
                                        class="empty"
                                    >

                                        <div class="empty-icon">
                                            <i data-lucide="users-round"></i>
                                        </div>

                                        <strong class="empty-title">
                                            Belum Ada Data Siswa
                                        </strong>

                                        <p class="empty-desc">
                                            Tidak ada data siswa yang cocok dengan filter atau belum ada siswa yang ditambahkan.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if ($siswa->total() > 0)

                    <div class="table-footer">

                        <div class="pagination-text">

                            Menampilkan

                            <strong>
                                {{ $siswa->firstItem() }}
                            </strong>

                            sampai

                            <strong>
                                {{ $siswa->lastItem() }}
                            </strong>

                            dari

                            <strong>
                                {{ $siswa->total() }}
                            </strong>

                            siswa

                        </div>

                        <div class="pagination-wrapper">

                            {{ $siswa->links() }}

                        </div>

                    </div>

                @endif

            </div>

        </section>

    </main>

</div>

{{-- modal tambah siswa --}}

<div
    id="createModal"
    class="modal-overlay"
    onclick="closeOutside(event, 'createModal')"
>

    <div
        class="modal"
        onclick="event.stopPropagation()"
    >

        <div class="modal-header">

            <div class="modal-heading">

                <div class="modal-heading-icon">
                    <i data-lucide="user-plus"></i>
                </div>

                <div>

                    <div class="modal-title">
                        Tambah Data Siswa
                    </div>

                    <div class="modal-subtitle">
                        Masukkan informasi siswa baru.
                    </div>

                </div>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeCreateModal()"
            >
                <i data-lucide="x"></i>
            </button>

        </div>

        <form
            action="{{ route('siswa.store') }}"
            method="POST"
        >

            @csrf

            <div class="modal-body">

                @if ($errors->any() && old('form_type') !== 'import')

                    <div class="error-summary">

                        <strong>
                            Data belum dapat disimpan.
                        </strong>

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <div class="modal-grid">

                    <div class="field">

                        <label>
                            Nama Lengkap Siswa
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_siswa"
                            class="field-control"
                            placeholder="Contoh: Budi Santoso"
                            value="{{ old('nama_siswa') }}"
                            required
                        >

                        @error('nama_siswa')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="field">

                        <label>
                            NIS / Nomor Induk
                        </label>

                        <input
                            type="text"
                            name="nis"
                            class="field-control"
                            placeholder="Masukkan NIS"
                            value="{{ old('nis') }}"
                        >

                        @error('nis')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="field">

                        <label>
                            Kelas
                            <span class="required">*</span>
                        </label>

                        <select
                            name="id_kelas"
                            class="field-control"
                            required
                        >

                            <option value="">
                                Pilih Kelas
                            </option>

                            @foreach (\App\Models\Kelas::all() as $kelas)

                                <option
                                    value="{{ $kelas->id_kelas }}"
                                    {{ old('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}
                                >
                                    {{ $kelas->nama_kelas }}
                                </option>

                            @endforeach

                        </select>

                        @error('id_kelas')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="field">

                        <label>
                            Jenis Kelamin
                            <span class="required">*</span>
                        </label>

                        <div class="gender">

                            <label>

                                <input
                                    type="radio"
                                    name="jenis_kelamin"
                                    value="L"
                                    {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}
                                    required
                                >

                                Laki-laki

                            </label>

                            <label>

                                <input
                                    type="radio"
                                    name="jenis_kelamin"
                                    value="P"
                                    {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}
                                >

                                Perempuan

                            </label>

                        </div>

                        @error('jenis_kelamin')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="field">

                        <label>
                            Nomor Telepon
                        </label>

                        <input
                            type="text"
                            name="no_telp"
                            class="field-control"
                            placeholder="Contoh: 081234567890"
                            value="{{ old('no_telp') }}"
                        >

                        @error('no_telp')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="field">

                        <label>
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            class="field-control"
                            placeholder="Masukkan alamat siswa..."
                        >{{ old('alamat') }}</textarea>

                        @error('alamat')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn"
                    onclick="closeCreateModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>

{{-- modal import excel --}}

<div
    id="importModal"
    class="modal-overlay"
    onclick="closeOutside(event, 'importModal')"
>

    <div
        class="modal"
        onclick="event.stopPropagation()"
    >

        <div class="modal-header">

            <div class="modal-heading">

                <div class="modal-heading-icon">
                    <i data-lucide="file-up"></i>
                </div>

                <div>

                    <div class="modal-title">
                        Import Data Siswa
                    </div>

                    <div class="modal-subtitle">
                        Tambahkan banyak data siswa sekaligus menggunakan format Excel.
                    </div>

                </div>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeImportModal()"
                title="Tutup dialog"
            >
                <i data-lucide="x"></i>
            </button>

        </div>

        <form
            action="{{ route('siswa.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <input
                type="hidden"
                name="form_type"
                value="import"
            >

            <div class="modal-body">

                @if ($errors->any() && old('form_type') === 'import')
                    <div class="error-summary import-error-summary" role="alert">
                        <strong>Import belum berhasil.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Panel Informasi Format Import --}}
                <div class="import-guide-panel">

                    <div class="import-guide-header">
                        <div class="import-guide-icon">
                            <i data-lucide="info"></i>
                        </div>
                        <div class="import-guide-title">
                            Panduan Format File Excel
                        </div>
                    </div>

                    <p class="import-guide-desc">
                        Gunakan file Excel dengan lima kolom berikut secara berurutan. Setelah memilih file, tentukan <strong>Jenjang Tingkat</strong> dan <strong>Target Kelas</strong> yang sesuai.
                    </p>

                    <div class="import-col-label">
                        Susunan Kolom Excel yang Didukung:
                    </div>

                    <div class="import-col-tags">
                        <span class="col-pill"><span class="column-index">01</span>NO</span>
                        <span class="col-pill"><span class="column-index">02</span>NISN</span>
                        <span class="col-pill"><span class="column-index">03</span>NAMA</span>
                        <span class="col-pill"><span class="column-index">04</span>JENIS KELAMIN</span>
                        <span class="col-pill"><span class="column-index">05</span>KELAS</span>
                    </div>

                    <div class="import-guide-note">
                        <i data-lucide="check-circle-2"></i>
                        <span>Pastikan nama dan urutan kolom pada baris header sesuai dengan format di atas.</span>
                    </div>

                </div>

                {{-- Grid Input Pemilihan Jenjang, Kelas & File --}}
                <div class="modal-grid">

                    {{-- Jenjang --}}
                    <div class="field">

                        <label for="importTingkat">
                            Jenjang Tingkat
                            <span class="required">*</span>
                        </label>

                        <select
                            name="tingkat"
                            id="importTingkat"
                            class="field-control"
                            required
                        >
                            <option value="">
                                -- Pilih Jenjang --
                            </option>
                            <option value="7">
                                Kelas VII
                            </option>
                            <option value="8">
                                Kelas VIII
                            </option>
                            <option value="9">
                                Kelas IX
                            </option>
                        </select>

                    </div>

                    {{-- Kelas --}}
                    <div class="field">

                        <label for="importKelas">
                            Target Kelas
                            <span class="required">*</span>
                        </label>

                        <select
                            name="kelas"
                            id="importKelas"
                            class="field-control"
                            required
                            disabled
                        >
                            <option value="">
                                Pilih jenjang terlebih dahulu
                            </option>
                            @foreach (\App\Models\Kelas::all() as $dataKelas)
                                <option
                                    value="{{ $dataKelas->id_kelas }}"
                                    data-tingkat="{{ $dataKelas->tingkat }}"
                                >
                                    {{ $dataKelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>

                        <div class="field-hint">
                            Pilih <em>Semua Kelas</em> jika file Excel mencakup lebih dari satu kelas.
                        </div>

                    </div>

                    {{-- File Excel --}}
                    <div class="field full">

                        <label for="importFile">
                            Pilih File Excel
                            <span class="required">*</span>
                        </label>

                        <div class="file-upload-wrapper">
                            <input
                                type="file"
                                name="file"
                                id="importFile"
                                class="field-control file-input-custom"
                                accept=".xlsx,.xls,.csv"
                                required
                            >
                        </div>

                        <div class="field-hint">
                            Format berkas yang diterima: <strong>.xlsx</strong>, <strong>.xls</strong>, atau <strong>.csv</strong> (Maksimal ukuran file: <strong>5 MB</strong>).
                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    onclick="closeImportModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i data-lucide="file-up"></i>
                    Import Data
                </button>

            </div>

        </form>

    </div>

</div>

<script>

    /* create modal */

    function openCreateModal() {

        document
            .getElementById('createModal')
            .classList
            .add('show');

        document.body.style.overflow = 'hidden';

    }

    function closeCreateModal() {

        document
            .getElementById('createModal')
            .classList
            .remove('show');

        document.body.style.overflow = '';

    }

    /* import excel modal */

    const kelasData = @json($daftarKelas);

    function openImportModal() {

        document
            .getElementById('importModal')
            .classList
            .add('show');

        document.body.style.overflow = 'hidden';

    }

    function closeImportModal() {

        document
            .getElementById('importModal')
            .classList
            .remove('show');

        document.body.style.overflow = '';

    }

    document.addEventListener('DOMContentLoaded', function () {

        const tingkatSelect =
            document.getElementById('importTingkat');

        const kelasSelect =
            document.getElementById('importKelas');

        if (!tingkatSelect || !kelasSelect) {
            return;
        }

        tingkatSelect.addEventListener('change', function () {

            const tingkat = this.value;

            kelasSelect.innerHTML = '';

            if (!tingkat) {

                kelasSelect.disabled = true;

                kelasSelect.innerHTML = `
                    <option value="">
                        Pilih jenjang terlebih dahulu
                    </option>
                `;

                return;
            }

            kelasSelect.disabled = false;

            kelasSelect.innerHTML = `
                <option value="all">
                    Semua Kelas
                </option>
            `;

            kelasData
                .filter(function (kelas) {
                    return String(kelas.tingkat) === String(tingkat);
                })
                .forEach(function (kelas) {

                    const option =
                        document.createElement('option');

                    option.value = kelas.id_kelas;
                    option.textContent = kelas.nama_kelas;

                    kelasSelect.appendChild(option);

                });

        });

    });

    /* click outside */

    function closeOutside(event, modalId) {

        if (event.target.id === modalId) {

            document
                .getElementById(modalId)
                .classList
                .remove('show');

            document.body.style.overflow = '';

        }

    }

    /* delete confirmation */

    function confirmDelete() {

        return confirm(
            'Yakin ingin menghapus data siswa ini?\n\n' +
            'Jika siswa memiliki riwayat konseling, ' +
            'data tidak dapat dihapus.'
        );

    }

    /* esc key */

    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key === 'Escape') {
                closeCreateModal();
                closeImportModal();
            }

        }
    );

    /* validation error open create modal */

    @if ($errors->any())

        document.addEventListener(
            'DOMContentLoaded',
            function() {

                @if (old('form_type') === 'import')

                    openImportModal();

                    const tingkat =
                        document.getElementById('importTingkat');

                    if (tingkat) {

                        tingkat.value =
                            "{{ old('tingkat') }}";

                        tingkat.dispatchEvent(
                            new Event('change')
                        );

                        document.getElementById('importKelas').value =
                            "{{ old('kelas') }}";

                    }

                @else

                    openCreateModal();

                @endif

            }
        );

    @endif

</script>

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
            if (
                !notificationButton.contains(event.target) &&
                !notificationDropdown.contains(event.target)
            ) {
                notificationDropdown.classList.remove('show');
            }
        });
    }
</script>

</body>
</html>
