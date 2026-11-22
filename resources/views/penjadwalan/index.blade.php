<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penjadwalan BK - SIRASI-BK</title>

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

            --orange: #c98516;
            --orange-bg: #fff7e8;

            --shadow-sm: 0 4px 14px rgba(23, 60, 145, .05);
            --shadow-md: 0 12px 30px rgba(23, 60, 145, .08);
            --shadow-lg: 0 20px 45px rgba(23, 60, 145, .12);
        }

        body {

            background:
                radial-gradient(
                    circle at 85% 0%,
                    rgba(41, 67, 143, .08),
                    transparent 28%
                ),
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

            box-shadow:
                12px 0 35px rgba(15, 45, 112, .10);
        }

        .sidebar {
            background: linear-gradient(180deg, #21499e 0%, #1b408f 48%, #153575 100%);
            box-shadow: 12px 0 36px rgba(17, 48, 113, .14);
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
            letter-spacing: .2px;
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
            gap: 6px;
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
            padding-top: 18px;
        }

        .logout-button {
            width: 100%;

            border: 0;
            background: transparent;

            cursor: pointer;

            text-align: left;

            color: inherit;
            font: inherit;
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

        .header-space {
            flex: 1;
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

            cursor: pointer;
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

        .notification-dropdown { position: absolute; top: 48px; right: 0; width: 340px; max-height: 420px; overflow-y: auto; background: white; border: 1px solid var(--border); border-radius: 14px; box-shadow: 0 15px 35px rgba(23,60,145,.14); display: none; z-index: 1000; }
        .notification-dropdown.show { display: block; }
        .notification-header { padding: 15px 17px; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--text); display: flex; align-items: center; justify-content: space-between; }
        .notification-item { display: flex; gap: 11px; padding: 13px 15px; border-bottom: 1px solid #edf0f4; color: var(--text); text-decoration: none; transition: .2s ease; }
        .notification-item:hover { background: #f7f9ff; }
        .notification-item-icon { width: 34px; height: 34px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 9px; background: var(--primary-soft); color: var(--primary); }
        .notification-item-content { min-width: 0; }
        .notification-item-content strong { display: block; font-size: 11px; font-weight: 800; }
        .notification-item-content p { margin-top: 4px; color: var(--muted); font-size: 10px; line-height: 1.45; }
        .notification-item-content small { display: block; margin-top: 5px; color: #9aa1ae; font-size: 8px; }
        .notification-empty { padding: 30px 20px; text-align: center; color: var(--muted); font-size: 11px; }
        body.dark-mode .notification-dropdown { background: #162238 !important; border-color: #293752 !important; }
        body.dark-mode .notification-header, body.dark-mode .notification-item { border-color: #293752 !important; color: #edf3ff !important; }
        body.dark-mode .notification-item:hover { background: #1d2c47 !important; }
        .notification-wrapper {
            position: relative;
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

            display: block;
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

            gap: 20px;

            margin-bottom: 24px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            margin-left: auto;
        }

        .eyebrow {
            margin-bottom: 7px;

            color: var(--primary);

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .page-title h1 {
            font-size: 27px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .page-title p {
            margin-top: 7px;

            color: var(--muted);

            font-size: 13px;
        }

        /* button */

        .btn {
            height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 16px;

            border: 1px solid var(--border);
            border-radius: 11px;

            background: white;

            color: var(--text);

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;

            box-shadow: var(--shadow-sm);

            transition: .2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn svg {
            width: 16px;
            height: 16px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #315fc4, #234a9f);
            border-color: #234a9f;
            color: white;

            box-shadow: 0 9px 22px rgba(40, 85, 183, .22);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3c6ed3, #234a9f);
        }

        /* summary */

        .summary-grid {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 16px;

            margin-bottom: 20px;
        }

        .summary-card {
            position: relative;

            overflow: hidden;

            padding: 18px 20px;

            border: 1px solid var(--border);
            border-radius: 17px;

            background: white;

            box-shadow: var(--shadow-sm);
            transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        }

        .summary-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary);
            box-shadow: 0 0 18px rgba(23, 60, 145, .35);
            transition: box-shadow .25s ease;
            pointer-events: none;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            border-color: #c5d0e8;
            box-shadow: 0 13px 30px rgba(23, 60, 145, .10);
        }

        .summary-card:hover::before {
            box-shadow: 0 0 22px rgba(23, 60, 145, .48);
        }

        .summary-card::after {
            content: "";

            position: absolute;

            width: 110px;
            height: 110px;

            right: -50px;
            top: -55px;

            border-radius: 50%;

            background: rgba(23,60,145,.035);
        }

        .summary-label {
            position: relative;
            z-index: 1;

            color: var(--muted);

            font-size: 10px;
            font-weight: 700;
        }

        .summary-number {
            position: relative;
            z-index: 1;

            margin-top: 4px;

            color: var(--text);

            font-size: 24px;
            font-weight: 800;
        }

        /* filter */

        .filter-card {
            position: relative;

            overflow: hidden;

            margin-bottom: 20px;

            padding: 20px;

            border: 1px solid var(--border);
            border-radius: 18px;

            background: white;

            box-shadow: var(--shadow-sm);
        }

        .filter-card::before {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -120px;
            bottom: -120px;

            border-radius: 50%;

            background: rgba(23,60,145,.035);
        }

        .filter-header {
            display: flex;
            align-items: center;

            gap: 11px;

            margin-bottom: 15px;
        }

        .filter-icon {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: var(--primary-light);

            color: var(--primary);

            font-size: 14px;
        }

        .filter-icon svg {
            width: 18px;
            height: 18px;
        }

        .filter-title {
            font-size: 14px;
            font-weight: 800;
        }

        .filter-subtitle {
            margin-top: 3px;

            color: var(--muted);

            font-size: 10px;
        }

        .filter-form {
            position: relative;
            z-index: 1;

            display: grid;

            grid-template-columns:
                minmax(220px, 1fr)
                180px
                180px
                auto;

            gap: 10px;
        }

        .input {
            width: 100%;
            height: 42px;

            padding: 0 13px;

            border: 1px solid var(--border);
            border-radius: 11px;

            outline: none;

            background: #fafbfe;

            color: var(--text);

            font-size: 12px;

            transition: .2s ease;
        }

        .input:focus {
            border-color: #9bb0e8;

            background: white;

            box-shadow:
                0 0 0 4px rgba(23,60,145,.05);
        }

        select.input {
            cursor: pointer;
        }

        .filter-button {
            height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 17px;

            border: 0;
            border-radius: 11px;

            background: var(--primary);

            color: white;

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 8px 20px rgba(23,60,145,.20);

            transition: .2s ease;
        }

        .filter-button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .filter-button svg {
            width: 16px;
            height: 16px;
        }

        /* card list */

        .table-card {
            overflow: hidden;

            border: 1px solid var(--border);
            border-radius: 18px;

            background: white;

            box-shadow: var(--shadow-sm);
        }

        .table-top {
            min-height: 68px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 21px;

            border-bottom: 1px solid var(--border);
        }

        .table-title-area {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .table-title-icon {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: var(--primary-light);

            color: var(--primary);
        }

        .table-title-icon svg {
            width: 18px;
            height: 18px;
        }

        .table-title {
            font-size: 14px;
            font-weight: 800;
        }

        .table-subtitle {
            margin-top: 3px;

            color: var(--muted);

            font-size: 10px;
        }

        .result-count {
            padding: 6px 10px;

            border-radius: 8px;

            background: var(--primary-soft);

            color: var(--primary);

            font-size: 10px;
            font-weight: 700;
        }

        .schedule-list {
            padding: 20px;

            display: grid;

            grid-template-columns: repeat(
                auto-fit,
                minmax(320px, 1fr)
            );

            gap: 16px;
        }

        .schedule-card {
            position: relative;

            display: flex;
            flex-direction: column;

            min-width: 0;

            padding: 18px;

            border: 1px solid var(--border);
            border-radius: 17px;

            background: #ffffff;

            box-shadow: 0 4px 12px rgba(23,60,145,.045);

            transition: .2s ease;
        }

        .schedule-card:hover {
            transform: translateY(-3px);

            border-color: #d2dcf1;

            box-shadow: var(--shadow-md);
        }

        .schedule-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 12px;

            padding-bottom: 15px;

            border-bottom: 1px solid #edf0f5;
        }

        .schedule-number {
            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 9px;

            background: var(--primary-light);

            color: var(--primary);

            font-size: 11px;
            font-weight: 800;
        }

        .schedule-status {
            margin-left: auto;
        }

        /* student */

        .schedule-student {
            display: flex;
            align-items: center;

            gap: 11px;

            margin-top: 16px;
        }

        .student-avatar {
            width: 43px;
            height: 43px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #e8eeff,
                    #dce6ff
                );

            color: var(--primary);

            font-size: 13px;
            font-weight: 800;
        }

        .student-info {
            min-width: 0;
        }

        .student-info strong {
            display: block;

            color: var(--text);

            font-size: 13px;
            font-weight: 800;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .student-info span {
            display: block;

            margin-top: 3px;

            color: #9299a8;

            font-size: 10px;
        }

        /* schedule info */

        .schedule-info {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 10px;

            margin-top: 17px;
        }

        .info-box {
            min-width: 0;

            padding: 11px;

            border-radius: 11px;

            background: #f8faff;

            border: 1px solid #edf1f8;
        }

        .info-label {
            display: flex;
            align-items: center;

            gap: 5px;

            margin-bottom: 5px;

            color: #8a94a6;

            font-size: 9px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .info-label svg {
            width: 12px;
            height: 12px;
        }

        .info-value {
            color: var(--text);

            font-size: 11px;
            font-weight: 700;

            line-height: 1.4;
        }

        .schedule-type {
            margin-top: 11px;

            padding: 11px;

            border-radius: 11px;

            background: #f8faff;

            border: 1px solid #edf1f8;
        }

        .schedule-type .info-value {
            color: #4f596b;
        }

        /* catatan */

        .schedule-note {
            margin-top: 11px;

            padding: 11px;

            border-radius: 11px;

            background: #fffaf0;

            border: 1px solid #f3e8cf;
        }

        .schedule-note .info-label {
            color: #a27832;
        }

        .schedule-note .info-value {
            color: #665638;

            font-weight: 500;
        }

        /* status */

        .status-badge {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 6px 9px;

            border-radius: 8px;

            font-size: 10px;
            font-weight: 700;
        }

        .status-dot {
            width: 6px;
            height: 6px;

            border-radius: 50%;
        }

        .status-terjadwal {
            background: #eef4ff;
            color: #2855b7;
        }

        .status-terjadwal .status-dot {
            background: #5c82dc;
        }

        .status-selesai {
            background: var(--green-bg);
            color: var(--green);
        }

        .status-selesai .status-dot {
            background: #55c98a;
        }

        .status-diajukan {
            background: var(--orange-bg);
            color: var(--orange);
        }

        .status-diajukan .status-dot {
            background: #f39c12;
        }

        .status-disetujui_wali {
            background: #e6f9f0;
            color: #0e8a4a;
        }

        .status-disetujui_wali .status-dot {
            background: #2ecc71;
        }

        .status-ditolak_wali {
            background: var(--red-bg);
            color: var(--red);
        }

        .status-ditolak_wali .status-dot {
            background: #e46c6c;
        }

        .status-dibatalkan {
            background: #f1f3f7;
            color: #5c6475;
        }

        .status-dibatalkan .status-dot {
            background: #8c93a4;
        }

        /* actions */

        .schedule-actions {
            display: flex;
            align-items: center;

            gap: 7px;

            margin-top: 16px;
            padding-top: 15px;

            border-top: 1px solid #edf0f5;
        }

        .action-button {
            height: 34px;

            flex: 1;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 10px;

            border: 1px solid #dce3ef;
            border-radius: 9px;

            background: white;

            color: #60708a;

            cursor: pointer;

            font-size: 10px;
            font-weight: 700;

            transition: .2s ease;
        }

        .action-button:hover {
            background: #f2f5fb;

            border-color: #c5d1e5;

            color: var(--primary);
        }

        .action-button {
            flex: 0 0 38px;
        }

        .action-button.delete {
            flex: 0 0 38px;

            color: var(--red);
        }

        .action-button.delete:hover {
            background: var(--red-bg);

            border-color: #efcaca;

            color: #c93434;
        }

        .action-button svg {
            width: 14px;
            height: 14px;
        }

        /* empty state */

        .empty-state {
            padding: 60px 20px;

            text-align: center;
        }

        .empty-icon {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 13px;

            border-radius: 15px;

            background: var(--primary-light);

            color: var(--primary);
        }

        .empty-icon svg {
            width: 25px;
            height: 25px;
        }

        .empty-title {
            color: var(--text);

            font-size: 14px;
            font-weight: 800;
        }

        .empty-text {
            margin-top: 6px;

            color: var(--muted);

            font-size: 11px;
        }

        /* footer / pagination */

        .table-footer {
            min-height: 62px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 0 20px;

            border-top: 1px solid var(--border);

            background: #fcfdff;
        }

        .table-count {
            color: var(--muted);

            font-size: 10px;
        }

        .table-count strong {
            color: var(--text);
        }

        .pagination-wrapper {
            display: flex;
            align-items: center;
        }

        .pagination-wrapper nav {
            display: flex;
            align-items: center;
        }

        .pagination-wrapper svg {
            width: 14px;
            height: 14px;
        }

        .pagination-wrapper a,
        .pagination-wrapper span {
            font-size: 10px !important;
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

            .filter-button {
                width: 100%;
            }

            .summary-grid {
                grid-template-columns: 1fr 1fr;
            }

            .schedule-list {
                grid-template-columns: repeat(
                    auto-fit,
                    minmax(290px, 1fr)
                );
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

            .header {
                padding: 0 15px;
            }

            .profile-info {
                display: none;
            }

            .profile {
                padding-left: 12px;
            }

            .content {
                padding: 24px 15px 35px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .page-header > a {
                width: 100%;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .schedule-list {
                grid-template-columns: 1fr;

                padding: 15px;
            }

            .schedule-info {
                grid-template-columns: 1fr 1fr;
            }

            .table-footer {
                flex-direction: column;

                align-items: flex-start;

                padding: 15px 20px;
            }

        }

        @media (max-width: 430px) {

            .schedule-info {
                grid-template-columns: 1fr;
            }

            .schedule-actions {
                flex-wrap: wrap;
            }

            .action-button.delete {
                flex: 0 0 38px;
            }

        }

        /* dark mode */

        body.dark-mode {
            background:
                radial-gradient(
                    circle at 85% 0%,
                    rgba(54,91,177,.12),
                    transparent 28%
                ),
                #0f1728 !important;

            color: #edf3ff !important;
        }

        body.dark-mode .main {
            background: transparent !important;
        }

        body.dark-mode .header {
            background: rgba(15,23,40,.92) !important;
            border-bottom-color: #293752 !important;
        }

        body.dark-mode .notification {
            background: #172238 !important;
            border-color: #334463 !important;
            color: #cbd7ed !important;
            box-shadow: none !important;
        }

        body.dark-mode .notification-dot {
            border-color: #172238 !important;
        }

        body.dark-mode .profile {
            border-left-color: #334463 !important;
        }

        body.dark-mode .profile-name {
            color: #edf3ff !important;
        }

        body.dark-mode .profile-role {
            color: #9aa8c0 !important;
        }

        body.dark-mode .profile-photo {
            background: #1d2c47 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .page-title h1 {
            color: #edf3ff !important;
        }

        body.dark-mode .page-title p {
            color: #9aa8c0 !important;
        }

        body.dark-mode .eyebrow {
            color: #7fa7ff !important;
        }

        /* summary */

        body.dark-mode .summary-card {
            background:
                linear-gradient(
                    145deg,
                    #18253b 0%,
                    #141f33 100%
                ) !important;

            border-color: #2c3b57 !important;

            box-shadow:
                0 15px 35px rgba(0,0,0,.22) !important;
        }

        body.dark-mode .summary-label {
            color: #9aa8c0 !important;
        }

        body.dark-mode .summary-number {
            color: #f1f5ff !important;
        }

        /* filter */

        body.dark-mode .filter-card {
            background:
                linear-gradient(
                    145deg,
                    #18253b 0%,
                    #141f33 100%
                ) !important;

            border-color: #2c3b57 !important;

            box-shadow:
                0 15px 35px rgba(0,0,0,.22) !important;
        }

        body.dark-mode .filter-title {
            color: #f1f5ff !important;
        }

        body.dark-mode .filter-subtitle {
            color: #9aa8c0 !important;
        }

        body.dark-mode .filter-icon {
            background: #1d3154 !important;
            color: #9fc0ff !important;
            border-color: #304b78 !important;
        }

        body.dark-mode .input {
            background: #111c2e !important;
            border-color: #344560 !important;
            color: #edf3ff !important;
        }

        body.dark-mode .input::placeholder {
            color: #697a96 !important;
        }

        body.dark-mode .input:focus {
            background: #142137 !important;
            border-color: #6286d1 !important;

            box-shadow:
                0 0 0 3px rgba(98,134,209,.15) !important;
        }

        /* card container */

        body.dark-mode .table-card {
            background:
                linear-gradient(
                    145deg,
                    #18253b 0%,
                    #141f33 100%
                ) !important;

            border-color: #2c3b57 !important;

            box-shadow:
                0 15px 35px rgba(0,0,0,.22) !important;
        }

        body.dark-mode .table-top {
            border-bottom-color: #293752 !important;
        }

        body.dark-mode .table-title {
            color: #f1f5ff !important;
        }

        body.dark-mode .table-subtitle {
            color: #9aa8c0 !important;
        }

        body.dark-mode .table-title-icon {
            background: #1d3154 !important;
            color: #9fc0ff !important;
            border-color: #304b78 !important;
        }

        body.dark-mode .result-count {
            background: #1d2c47 !important;
            color: #a9c5ff !important;
        }

        /* schedule card */

        body.dark-mode .schedule-card {
            background:
                linear-gradient(
                    145deg,
                    #18253b 0%,
                    #141f33 100%
                ) !important;

            border-color: #2d3d5b !important;

            box-shadow:
                0 8px 20px rgba(0,0,0,.18) !important;
        }

        body.dark-mode .schedule-card:hover {
            border-color: #45618f !important;

            box-shadow:
                0 15px 30px rgba(0,0,0,.25) !important;
        }

        body.dark-mode .schedule-card-top {
            border-bottom-color: #293752 !important;
        }

        body.dark-mode .schedule-number {
            background: #1d3154 !important;
            color: #9fc0ff !important;
        }

        body.dark-mode .student-avatar {
            background: #1d2c47 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .student-info strong {
            color: #f1f5ff !important;
        }

        body.dark-mode .student-info span {
            color: #8797b2 !important;
        }

        body.dark-mode .info-box,
        body.dark-mode .schedule-type {
            background: #111c2e !important;

            border-color: #293a58 !important;
        }

        body.dark-mode .info-label {
            color: #8293ae !important;
        }

        body.dark-mode .info-value {
            color: #edf3ff !important;
        }

        body.dark-mode .schedule-type .info-value {
            color: #c0cadb !important;
        }

        body.dark-mode .schedule-note {
            background: #302a20 !important;

            border-color: #5a4b31 !important;
        }

        body.dark-mode .schedule-note .info-label {
            color: #c5a45d !important;
        }

        body.dark-mode .schedule-note .info-value {
            color: #d5c7a9 !important;
        }

        body.dark-mode .schedule-actions {
            border-top-color: #293752 !important;
        }

        /* status */

        body.dark-mode .status-terjadwal {
            background: #1d2c47 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .status-terjadwal .status-dot {
            background: #6f9cff !important;
        }

        body.dark-mode .status-selesai {
            background: #193a2a !important;
            color: #9be0b8 !important;
        }

        body.dark-mode .status-selesai .status-dot {
            background: #55c98a !important;
        }

        body.dark-mode .status-diajukan {
            background: #3d301b !important;
            color: #ffcf70 !important;
        }

        body.dark-mode .status-diajukan .status-dot {
            background: #f59e0b !important;
        }

        body.dark-mode .status-disetujui_wali {
            background: #193a2a !important;
            color: #9be0b8 !important;
        }

        body.dark-mode .status-disetujui_wali .status-dot {
            background: #55c98a !important;
        }

        body.dark-mode .status-ditolak_wali {
            background: #3a2028 !important;
            color: #ff9aa5 !important;
        }

        body.dark-mode .status-ditolak_wali .status-dot {
            background: #e46c6c !important;
        }

        body.dark-mode .status-dibatalkan {
            background: #252b36 !important;
            color: #9aa2b1 !important;
        }

        body.dark-mode .status-dibatalkan .status-dot {
            background: #6a7485 !important;
        }

        /* action */

        body.dark-mode .action-button {
            background: #18253b !important;

            border-color: #3b5685 !important;

            color: #a9c5ff !important;

            box-shadow: none !important;
        }

        body.dark-mode .action-button:hover {
            background: #22365a !important;

            border-color: #5d83d5 !important;

            color: #ffffff !important;
        }

        body.dark-mode .action-button.delete {
            color: #ff8f9a !important;
        }

        body.dark-mode .action-button.delete:hover {
            background: #3a2028 !important;
            border-color: #75404a !important;
        }

        /* empty */

        body.dark-mode .empty-icon {
            background: #1d3154 !important;
            color: #9fc0ff !important;
        }

        body.dark-mode .empty-title {
            color: #f1f5ff !important;
        }

        body.dark-mode .empty-text {
            color: #9aa8c0 !important;
        }

        /* footer */

        body.dark-mode .table-footer {
            background: #141f33 !important;
            border-top-color: #293752 !important;
        }

        body.dark-mode .table-count {
            color: #9aa8c0 !important;
        }

        body.dark-mode .table-count strong {
            color: #edf3ff !important;
        }

        body.dark-mode .pagination-wrapper a,
        body.dark-mode .pagination-wrapper span {
            background: #18253b !important;
            border-color: #334463 !important;
            color: #aebbd0 !important;
        }

        body.dark-mode .pagination-wrapper span[aria-current="page"] {
            background: #2855b7 !important;
            border-color: #3967d1 !important;
            color: #ffffff !important;
        }

        /* sidebar dark */

        body.dark-mode .sidebar {
            background:
                linear-gradient(
                    180deg,
                    #193f96 0%,
                    #173887 52%,
                    #112e70 100%
                ) !important;
        }

        body.dark-mode .brand-subtitle {
            color: #b9c9ef !important;
        }

        body.dark-mode .menu-title {
            color: #91a9dc !important;
        }

        /* penjadwalan modal card */

        .penjadwalan-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 12000;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .penjadwalan-modal.active {
            display: flex;
        }

        .penjadwalan-modal-overlay {
            position: absolute;
            inset: 0;
            z-index: 0;
            background: rgba(10, 25, 55, 0.62);
            backdrop-filter: blur(5px);
        }

        .penjadwalan-modal-card {
            position: relative;
            z-index: 1;
            width: min(720px, 100%);
            max-height: 90vh;
            overflow-y: auto;
            background: var(--card-bg, #ffffff);
            border-radius: 20px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
            animation: penjadwalanModalIn .2s ease;
        }

        @keyframes penjadwalanModalIn {
            from {
                opacity: 0;
                transform: translateY(15px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .penjadwalan-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 24px;
            border-bottom: 1px solid var(--border-color, #e5e7eb);
        }

        .penjadwalan-modal-title {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .penjadwalan-modal-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf0ff;
            color: #1749ad;
        }

        .penjadwalan-modal-title h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .penjadwalan-modal-title p {
            margin: 3px 0 0;
            font-size: 12px;
            color: #718096;
        }

        .penjadwalan-modal-close {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 10px;
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
        }

        .penjadwalan-modal-close:hover {
            background: #f1f5f9;
            color: #dc2626;
        }

        .penjadwalan-modal-body {
            padding: 24px;
        }

        .penjadwalan-form-group {
            margin-bottom: 18px;
        }

        .penjadwalan-form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 600;
        }

        .penjadwalan-form-group label span {
            color: #dc2626;
        }

        .penjadwalan-form-input {
            width: 100%;
            box-sizing: border-box;
            padding: 11px 13px;
            border: 1px solid #d9e0ea;
            border-radius: 10px;
            background: #fff;
            color: #172033;
            font-size: 13px;
            outline: none;
        }

        .penjadwalan-form-input:focus {
            border-color: #315ccf;
            box-shadow: 0 0 0 3px rgba(49, 92, 207, .1);
        }

        .penjadwalan-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .penjadwalan-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 18px 24px;
            border-top: 1px solid #e5e7eb;
        }

        .penjadwalan-btn-secondary,
        .penjadwalan-btn-primary {
            border: none;
            border-radius: 10px;
            padding: 10px 17px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .penjadwalan-btn-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .penjadwalan-btn-primary {
            background: #1749ad;
            color: white;
        }

        .penjadwalan-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .penjadwalan-detail-item {
            padding: 15px;
            border: 1px solid #e5eaf1;
            border-radius: 12px;
        }

        .penjadwalan-detail-label {
            font-size: 11px;
            color: #7b8798;
            margin-bottom: 5px;
        }

        .penjadwalan-detail-value {
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 650px) {
            .penjadwalan-modal {
                padding: 12px;
            }

            .penjadwalan-form-grid,
            .penjadwalan-detail-grid {
                grid-template-columns: 1fr;
            }

            .penjadwalan-modal-body {
                padding: 18px;
            }
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

            <div class="header-space"></div>

            <div class="profile-area">

                <div class="notification-wrapper">
                    <button
                        type="button"
                        class="notification"
                        id="notificationButton" title="Notifikasi"
                    >
                        <i data-lucide="bell"></i>
                        @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)<span class="notification-dot" id="notificationDot"></span>@endif
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
                <div style="display:none">
                    <button type="button">
                    </button>
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

            {{-- page header --}}

            <div class="page-header" style="flex-wrap: wrap; justify-content: flex-end;">

                <div class="page-title">

                    <div class="eyebrow">
                        Manajemen Bimbingan Konseling
                    </div>

                    <h1>
                        Penjadwalan BK
                    </h1>

                    <p>
                        Kelola jadwal mengajar Guru BK, slot ketersediaan konseling (08.00–15.00 WIB), dan jadwal bimbingan siswa SMP Negeri 2 Dramaga.
                    </p>

                </div>
                <div class="header-actions" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-left: auto; justify-content: flex-end;">
                    <button
                        type="button"
                        class="btn"
                        onclick="openPenjadwalanModal('mengajarModal')"
                        style="border-color: #c5d3f5; color: var(--primary); background: var(--primary-soft);"
                    >
                        <i data-lucide="book-open"></i>
                        Jadwal Mengajar BK
                    </button>
                    <button
                        type="button"
                        class="btn"
                        onclick="openPenjadwalanModal('slotModal')"
                        style="border-color: #b7e4c7; color: #159447; background: #eaf8ef;"
                    >
                        <i data-lucide="clock-plus"></i>
                        Buka Slot Konseling
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="openPenjadwalanModal('createModal')"
                    >
                        <i data-lucide="calendar-plus"></i>
                        Tambah Jadwal
                    </button>
                </div>
            </div>

            {{-- Alert Notifikasi Session / Validasi --}}
            @if (session('success'))
                <div style="background: #eaf8ef; border: 1px solid #c3ebd2; color: #159447; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 600;">
                    <i data-lucide="check-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div style="background: #fff0f0; border: 1px solid #ffd1d1; color: #d64545; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 600;">
                    <i data-lucide="alert-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @php
                $displayErrors = collect($errors->all())
                    ->unique()
                    ->reject(fn ($message) => session('error') === $message)
                    ->values();
            @endphp
            @if ($displayErrors->isNotEmpty())
                <div style="background: #fff0f0; border: 1px solid #ffd1d1; color: #d64545; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px;">
                    <div style="font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="alert-triangle" style="width: 18px; height: 18px;"></i>
                        Perhatian: Terdapat kesalahan input jadwal
                    </div>
                    <ul style="margin-left: 24px; margin-top: 4px;">
                        @foreach ($displayErrors as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- summary --}}

            <div class="summary-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">

                <div class="summary-card">
                    <div class="summary-label">TOTAL JADWAL BIMBINGAN</div>
                    <div class="summary-number">{{ $penjadwalan->total() }}</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">SLOT TERSEDIA</div>
                    <div class="summary-number" style="color: #159447;">{{ $slotStats['tersedia'] ?? 0 }}</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">MENUNGGU DIPROSES</div>
                    <div class="summary-number" style="color: #c98516;">{{ $slotStats['menunggu'] ?? 0 }}</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">SLOT DIPESAN</div>
                    <div class="summary-number" style="color: var(--primary);">{{ $slotStats['dipesan'] ?? 0 }}</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">SLOT TIDAK TERSEDIA</div>
                    <div class="summary-number" style="color: #d64545;">{{ $slotStats['tidak_tersedia'] ?? 0 }}</div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">JADWAL MENGAJAR BK</div>
                    <div class="summary-number">{{ isset($jadwalMengajar) ? $jadwalMengajar->count() : 0 }}</div>
                </div>

            </div>

            {{-- =========================================================================
                 BAGIAN 1 & 2: JADWAL MENGAJAR GURU BK & SLOT KETERSEDIAAN KONSELING
                 ========================================================================= --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 420px), 1fr)); gap: 20px; margin-bottom: 22px;">

                {{-- PANEL 1: JADWAL MENGAJAR GURU BK --}}
                <div class="table-card">
                    <div class="table-top" style="padding: 16px 20px; border-bottom: 1px solid var(--border); justify-content: space-between;">
                        <div class="table-title-area">
                            <div class="table-title-icon">
                                <i data-lucide="book-open-check"></i>
                            </div>
                            <div>
                                <div class="table-title">Jadwal Mengajar Guru BK</div>
                                <div class="table-subtitle">Waktu mengajar kelas yang otomatis dikecualikan dari slot konseling</div>
                            </div>
                        </div>
                        <button type="button" class="btn" onclick="openPenjadwalanModal('mengajarModal')" style="height: 36px; padding: 0 12px; font-size: 11px;">
                            <i data-lucide="plus"></i>
                            Tambah Mengajar
                        </button>
                    </div>

                    <div style="padding: 16px 20px;">
                        @if (isset($jadwalMengajar) && $jadwalMengajar->count() > 0)
                            <div style="display: flex; flex-direction: column; gap: 10px; max-height: 320px; overflow-y: auto;">
                                @foreach ($jadwalMengajar as $jm)
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 14px; border: 1px solid var(--border); border-radius: 12px; background: #fafbfe;">
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <span style="font-size: 11px; font-weight: 800; color: var(--primary); background: var(--primary-light); padding: 3px 9px; border-radius: 6px;">
                                                    {{ $jm->hari }}{{ $jm->tanggal ? ' (' . \Carbon\Carbon::parse($jm->tanggal)->format('d/m/Y') . ')' : ' (Rutin)' }}
                                                </span>
                                                <strong style="font-size: 12.5px; color: var(--text);">
                                                    {{ substr($jm->waktu_mulai, 0, 5) }} - {{ substr($jm->waktu_selesai, 0, 5) }} WIB
                                                </strong>
                                                @if ($jm->kelas)
                                                    <span style="font-size: 11px; font-weight: 700; color: #475569;">• Kelas {{ $jm->kelas->nama_kelas }}</span>
                                                @endif
                                            </div>
                                            <div style="font-size: 11.5px; color: var(--muted); margin-top: 4px;">
                                                {{ $jm->mata_pelajaran }}
                                                @if ($jm->catatan)
                                                    — <em>{{ $jm->catatan }}</em>
                                                @endif
                                            </div>
                                        </div>

                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <button type="button" class="action-button" title="Edit Jadwal Mengajar" onclick="openPenjadwalanModal('editMengajarModal{{ $jm->id_jadwal_mengajar }}')" style="width: 34px; height: 34px;">
                                                <i data-lucide="pencil" style="width: 14px; height: 14px;"></i>
                                            </button>
                                            <form action="{{ route('penjadwalan.mengajar.destroy', $jm->id_jadwal_mengajar) }}" method="POST" onsubmit="return confirm('Hapus jadwal mengajar ini?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-button delete" title="Hapus Jadwal Mengajar" style="width: 34px; height: 34px;">
                                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Modal Edit Jadwal Mengajar --}}
                                    <div id="editMengajarModal{{ $jm->id_jadwal_mengajar }}" class="penjadwalan-modal">
                                        <div class="penjadwalan-modal-overlay" onclick="closePenjadwalanModal('editMengajarModal{{ $jm->id_jadwal_mengajar }}')"></div>
                                        <div class="penjadwalan-modal-card">
                                            <div class="penjadwalan-modal-header">
                                                <div class="penjadwalan-modal-title">
                                                    <div class="penjadwalan-modal-icon"><i data-lucide="book-open"></i></div>
                                                    <div>
                                                        <h3>Edit Jadwal Mengajar BK</h3>
                                                        <p>Perbarui jam mengajar Guru BK di kelas.</p>
                                                    </div>
                                                </div>
                                                <button type="button" class="penjadwalan-modal-close" onclick="closePenjadwalanModal('editMengajarModal{{ $jm->id_jadwal_mengajar }}')"><i data-lucide="x"></i></button>
                                            </div>
                                            <form action="{{ route('penjadwalan.mengajar.update', $jm->id_jadwal_mengajar) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="penjadwalan-modal-body">
                                                    <div class="penjadwalan-form-grid">
                                                        <div class="penjadwalan-form-group">
                                                            <label>Hari Mengajar <span>*</span></label>
                                                            <select name="hari" class="penjadwalan-form-input" required>
                                                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hariOpt)
                                                                    <option value="{{ $hariOpt }}" {{ $jm->hari === $hariOpt ? 'selected' : '' }}>{{ $hariOpt }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="penjadwalan-form-group">
                                                            <label>Tanggal Spesifik (Opsional)</label>
                                                            <input type="date" name="tanggal" class="penjadwalan-form-input" value="{{ $jm->tanggal }}">
                                                        </div>
                                                    </div>
                                                    <div class="penjadwalan-form-grid">
                                                        <div class="penjadwalan-form-group">
                                                            <label>Waktu Mulai <span>*</span></label>
                                                            <input type="time" name="waktu_mulai" class="penjadwalan-form-input" value="{{ substr($jm->waktu_mulai, 0, 5) }}" required>
                                                        </div>
                                                        <div class="penjadwalan-form-group">
                                                            <label>Waktu Selesai <span>*</span></label>
                                                            <input type="time" name="waktu_selesai" class="penjadwalan-form-input" value="{{ substr($jm->waktu_selesai, 0, 5) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="penjadwalan-form-grid">
                                                        <div class="penjadwalan-form-group">
                                                            <label>Kelas</label>
                                                            <select name="id_kelas" class="penjadwalan-form-input">
                                                                <option value="">-- Semua / Umum --</option>
                                                                @if (isset($kelasList))
                                                                    @foreach ($kelasList as $kls)
                                                                        <option value="{{ $kls->id_kelas }}" {{ (int) $jm->id_kelas === (int) $kls->id_kelas ? 'selected' : '' }}>Kelas {{ $kls->nama_kelas }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="penjadwalan-form-group">
                                                            <label>Kegiatan / Mata Pelajaran</label>
                                                            <input type="text" name="mata_pelajaran" class="penjadwalan-form-input" value="{{ $jm->mata_pelajaran }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="penjadwalan-form-group">
                                                        <label>Catatan</label>
                                                        <input type="text" name="catatan" class="penjadwalan-form-input" value="{{ $jm->catatan }}">
                                                    </div>
                                                </div>
                                                <div class="penjadwalan-modal-footer">
                                                    <button type="button" class="penjadwalan-btn-secondary" onclick="closePenjadwalanModal('editMengajarModal{{ $jm->id_jadwal_mengajar }}')">Batal</button>
                                                    <button type="submit" class="penjadwalan-btn-primary"><i data-lucide="save"></i> Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 24px 12px; color: var(--muted); font-size: 12px;">
                                Belum ada jadwal mengajar Guru BK yang dimasukkan. Klik <strong>Tambah Mengajar</strong> untuk memasukkan jadwal mengajar.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- PANEL 2: SLOT KETERSEDIAAN KONSELING (08:00 - 15:00 WIB) --}}
                <div class="table-card">
                    <div class="table-top" style="padding: 16px 20px; border-bottom: 1px solid var(--border); justify-content: space-between;">
                        <div class="table-title-area">
                            <div class="table-title-icon" style="background: #eaf8ef; color: #159447;">
                                <i data-lucide="clock"></i>
                            </div>
                            <div>
                                <div class="table-title">Slot Ketersediaan Konseling (08.00–15.00 WIB)</div>
                                <div class="table-subtitle">Hanya slot yang dibuka Guru BK yang dapat dipilih oleh siswa</div>
                            </div>
                        </div>
                        <button type="button" class="btn" onclick="openPenjadwalanModal('slotModal')" style="height: 36px; padding: 0 12px; font-size: 11px; border-color: #b7e4c7; color: #159447; background: #eaf8ef;">
                            <i data-lucide="plus"></i>
                            Buka Slot
                        </button>
                    </div>

                    <div style="padding: 16px 20px;">
                        @if (isset($slotKonseling) && $slotKonseling->count() > 0)
                            <div style="display: flex; flex-direction: column; gap: 10px; max-height: 320px; overflow-y: auto;">
                                @foreach ($slotKonseling as $slot)
                                    @php
                                        $effStatus = $slot->effective_status;
                                        $badgeBg = '#eaf8ef';
                                        $badgeColor = '#159447';
                                        $badgeLabel = 'Tersedia';
                                        if ($effStatus === 'Menunggu_Diproses') {
                                            $badgeBg = '#fff7e8';
                                            $badgeColor = '#c98516';
                                            $badgeLabel = 'Menunggu Diproses';
                                        } elseif ($effStatus === 'Dipesan') {
                                            $badgeBg = '#eaf0ff';
                                            $badgeColor = '#173c91';
                                            $badgeLabel = 'Dipesan';
                                        } elseif ($effStatus === 'Tidak_Tersedia') {
                                            $badgeBg = '#fff0f0';
                                            $badgeColor = '#d64545';
                                            $badgeLabel = 'Tidak Tersedia';
                                        }
                                    @endphp
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 14px; border: 1px solid var(--border); border-radius: 12px; background: #fafbfe;">
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <span style="font-size: 11px; font-weight: 800; color: {{ $badgeColor }}; background: {{ $badgeBg }}; padding: 3px 9px; border-radius: 6px;">
                                                    {{ $badgeLabel }}
                                                </span>
                                                <strong style="font-size: 12.5px; color: var(--text);">
                                                    {{ \Carbon\Carbon::parse($slot->tanggal)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($slot->tanggal)->translatedFormat('l') }})
                                                </strong>
                                                <span style="font-size: 12px; font-weight: 700; color: var(--primary);">
                                                    • {{ substr($slot->waktu_mulai, 0, 5) }} - {{ substr($slot->waktu_selesai, 0, 5) }} WIB
                                                </span>
                                                <span style="font-size: 10.5px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 2px 7px; border-radius: 5px;">
                                                    {{ $slot->formatted_duration }}
                                                </span>
                                            </div>
                                            @if ($slot->catatan)
                                                <div style="font-size: 11.5px; color: var(--muted); margin-top: 4px;">
                                                    {{ $slot->catatan }}
                                                </div>
                                            @endif
                                        </div>

                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <button type="button" class="action-button" title="Edit Slot Konseling" onclick="openPenjadwalanModal('editSlotModal{{ $slot->id_slot }}')" style="width: 34px; height: 34px;">
                                                <i data-lucide="pencil" style="width: 14px; height: 14px;"></i>
                                            </button>
                                            <form action="{{ route('penjadwalan.slot.destroy', $slot->id_slot) }}" method="POST" onsubmit="return confirm('Hapus slot konseling ini?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-button delete" title="Hapus Slot Konseling" style="width: 34px; height: 34px;">
                                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Modal Edit Slot Konseling --}}
                                    <div id="editSlotModal{{ $slot->id_slot }}" class="penjadwalan-modal">
                                        <div class="penjadwalan-modal-overlay" onclick="closePenjadwalanModal('editSlotModal{{ $slot->id_slot }}')"></div>
                                        <div class="penjadwalan-modal-card">
                                            <div class="penjadwalan-modal-header">
                                                <div class="penjadwalan-modal-title">
                                                    <div class="penjadwalan-modal-icon"><i data-lucide="clock"></i></div>
                                                    <div>
                                                        <h3>Edit Slot Ketersediaan Konseling</h3>
                                                        <p>Jam operasional konseling 08:00 – 15:00 WIB.</p>
                                                    </div>
                                                </div>
                                                <button type="button" class="penjadwalan-modal-close" onclick="closePenjadwalanModal('editSlotModal{{ $slot->id_slot }}')"><i data-lucide="x"></i></button>
                                            </div>
                                            <form action="{{ route('penjadwalan.slot.update', $slot->id_slot) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="penjadwalan-modal-body">
                                                    <div class="penjadwalan-form-grid">
                                                        <div class="penjadwalan-form-group">
                                                            <label>Tanggal Slot <span>*</span></label>
                                                            <input type="date" name="tanggal" class="penjadwalan-form-input" value="{{ $slot->tanggal }}" required>
                                                        </div>
                                                        <div class="penjadwalan-form-group">
                                                            <label>Status Ketersediaan Slot <span>*</span></label>
                                                            <select name="status_slot" class="penjadwalan-form-input" required>
                                                                <option value="Tersedia" {{ $slot->status_slot === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                                <option value="Menunggu_Diproses" {{ $slot->status_slot === 'Menunggu_Diproses' ? 'selected' : '' }}>Menunggu Diproses</option>
                                                                <option value="Dipesan" {{ $slot->status_slot === 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                                                                <option value="Tidak_Tersedia" {{ $slot->status_slot === 'Tidak_Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="penjadwalan-form-grid">
                                                        <div class="penjadwalan-form-group">
                                                            <label>Waktu Mulai (08:00 - 15:00) <span>*</span></label>
                                                            <input type="time" name="waktu_mulai" min="08:00" max="15:00" class="penjadwalan-form-input" value="{{ substr($slot->waktu_mulai, 0, 5) }}" required>
                                                        </div>
                                                        <div class="penjadwalan-form-group">
                                                            <label>Waktu Selesai (08:00 - 15:00) <span>*</span></label>
                                                            <input type="time" name="waktu_selesai" min="08:00" max="15:00" class="penjadwalan-form-input" value="{{ substr($slot->waktu_selesai, 0, 5) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="penjadwalan-form-group">
                                                        <label>Catatan Slot</label>
                                                        <input type="text" name="catatan" class="penjadwalan-form-input" value="{{ $slot->catatan }}" placeholder="Contoh: Ruang Konseling BK 1">
                                                    </div>
                                                </div>
                                                <div class="penjadwalan-modal-footer">
                                                    <button type="button" class="penjadwalan-btn-secondary" onclick="closePenjadwalanModal('editSlotModal{{ $slot->id_slot }}')">Batal</button>
                                                    <button type="submit" class="penjadwalan-btn-primary">Simpan Slot</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 24px 12px; color: var(--muted); font-size: 12px;">
                                Belum ada slot ketersediaan konseling yang dibuka. Klik <strong>Buka Slot</strong> untuk membuka slot waktu (08.00–15.00 WIB) agar dapat dipilih siswa.
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- filter --}}

            <div class="filter-card">

                <div class="filter-header">

                    <div class="filter-icon">
                        <i data-lucide="list-filter"></i>
                    </div>

                    <div>

                        <div class="filter-title">
                            Filter & Pencarian
                        </div>

                        <div class="filter-subtitle">
                            Gunakan filter untuk menemukan jadwal dengan cepat.
                        </div>

                    </div>

                </div>

                <form
                    action="{{ route('penjadwalan.index') }}"
                    method="GET"
                    class="filter-form"
                >

                    <input
                        type="text"
                        name="search"
                        class="input"
                        placeholder="Cari nama siswa, jenis bimbingan, atau catatan..."
                        value="{{ request('search') }}"
                    >

                    <input
                        type="date"
                        name="tanggal"
                        class="input"
                        value="{{ request('tanggal') }}"
                    >

                    <select
                        name="status"
                        class="input"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="Diajukan"
                            {{ request('status') == 'Diajukan' ? 'selected' : '' }}
                        >
                            Menunggu Izin Wali Kelas
                        </option>

                        <option
                            value="Disetujui_Wali"
                            {{ request('status') == 'Disetujui_Wali' ? 'selected' : '' }}
                        >
                            Izin Disetujui Wali Kelas
                        </option>

                        <option
                            value="Ditolak_Wali"
                            {{ request('status') == 'Ditolak_Wali' ? 'selected' : '' }}
                        >
                            Belum Diizinkan Wali Kelas
                        </option>

                        <option
                            value="Terjadwal"
                            {{ request('status') == 'Terjadwal' ? 'selected' : '' }}
                        >
                            Terjadwal
                        </option>

                        <option
                            value="Selesai"
                            {{ request('status') == 'Selesai' ? 'selected' : '' }}
                        >
                            Selesai
                        </option>

                        <option
                            value="Dibatalkan"
                            {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}
                        >
                            Dibatalkan
                        </option>

                    </select>

                    <button
                        type="submit"
                        class="filter-button"
                    >

                        <i data-lucide="search"></i>

                        Terapkan

                    </button>

                </form>

            </div>

            {{-- card container --}}

            <div class="table-card">

                {{-- card header --}}

                <div class="table-top">

                    <div class="table-title-area">

                        <div class="table-title-icon">
                            <i data-lucide="calendar-days"></i>
                        </div>

                        <div>

                            <div class="table-title">
                                Daftar Jadwal Bimbingan
                            </div>

                            <div class="table-subtitle">
                                Data jadwal bimbingan konseling siswa
                            </div>

                        </div>

                    </div>

                    <div class="result-count">
                        {{ $penjadwalan->total() }} Jadwal
                    </div>

                </div>

                {{-- card list --}}

                @if ($penjadwalan->count() > 0)

                    <div class="schedule-list">

                        @foreach ($penjadwalan as $item)

                            <div class="schedule-card">

                                {{-- top card --}}

                                <div class="schedule-card-top">

                                    <div class="schedule-number">
                                        {{ $penjadwalan->firstItem() + $loop->index }}
                                    </div>

                                    <div class="schedule-status">

                                        @if ($item->status === 'Terjadwal')

                                            <span class="status-badge status-terjadwal">

                                                <span class="status-dot"></span>

                                                Jadwal Terjadwal

                                            </span>

                                        @elseif ($item->status === 'Selesai')

                                            <span class="status-badge status-selesai">

                                                <span class="status-dot"></span>

                                                Selesai

                                            </span>

                                        @elseif ($item->status === 'Diajukan')

                                            <span class="status-badge status-diajukan">

                                                <span class="status-dot"></span>

                                                Menunggu Izin Wali

                                            </span>

                                        @elseif ($item->status === 'Disetujui_Wali')

                                            <span class="status-badge status-disetujui_wali">

                                                <span class="status-dot"></span>

                                                Izin Disetujui Wali Kelas

                                            </span>

                                        @elseif ($item->status === 'Ditolak_Wali')

                                            <span class="status-badge status-ditolak_wali">

                                                <span class="status-dot"></span>

                                                Belum Diizinkan Wali

                                            </span>

                                        @else

                                            <span class="status-badge status-dibatalkan">

                                                <span class="status-dot"></span>

                                                Dibatalkan

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                {{-- siswa --}}

                                <div class="schedule-student">

                                    <div class="student-avatar">

                                        {{
                                            strtoupper(
                                                substr(
                                                    $item->siswa->nama_siswa ?? 'S',
                                                    0,
                                                    1
                                                )
                                            )
                                        }}

                                    </div>

                                    <div class="student-info">

                                        <strong>
                                            {{ $item->siswa->nama_siswa ?? '-' }}
                                        </strong>

                                        <span>
                                            NIS:
                                            {{ $item->siswa->nis ?? '-' }}
                                            &nbsp; • &nbsp;
                                            Kelas:
                                            {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                                        </span>

                                    </div>

                                </div>

                                {{-- date + time --}}

                                <div class="schedule-info">

                                    <div class="info-box">

                                        <div class="info-label">

                                            <i data-lucide="calendar-days"></i>

                                            Tanggal

                                        </div>

                                        <div class="info-value">

                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}

                                            <br>

                                            <small style="font-size:9px;color:#9299a8;">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}
                                            </small>

                                        </div>

                                    </div>

                                    <div class="info-box">

                                        <div class="info-label">

                                            <i data-lucide="clock-3"></i>

                                            Waktu

                                        </div>

                                        <div class="info-value">

                                            {{
                                                \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i')
                                            }}

                                            -

                                            {{
                                                \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i')
                                            }}

                                        </div>

                                    </div>

                                </div>

                                {{-- jenis bimbingan --}}

                                <div class="schedule-type">

                                    <div class="info-label">

                                        <i data-lucide="users"></i>

                                        Jenis Bimbingan

                                    </div>

                                    <div class="info-value">

                                        {{ $item->jenis_bimbingan }}

                                    </div>

                                </div>

                                {{-- catatan --}}

                                @if (!empty($item->catatan))

                                    <div class="schedule-note">

                                        <div class="info-label">

                                            <i data-lucide="notebook-pen"></i>

                                            Catatan

                                        </div>

                                        <div class="info-value">

                                            {{ $item->catatan }}

                                        </div>

                                    </div>

                                @endif

                                {{-- catatan wali kelas jika ada --}}
                                @if (!empty($item->id_wali) || !empty($item->catatan_wali))
                                    <div class="schedule-note" style="border-left: 3px solid #173c91; background: rgba(23, 60, 145, 0.04); padding: 8px 12px; border-radius: 8px; margin-top: 8px;">
                                        <div class="info-label" style="font-weight: 700; color: #173c91;">
                                            <i data-lucide="user-check"></i>
                                            Wali Kelas: {{ $item->waliKelas->nama ?? 'Wali Kelas' }}
                                            @if ($item->waktu_persetujuan_wali)
                                                <span style="font-size: 10px; color: #737b8c; font-weight: normal;">({{ \Carbon\Carbon::parse($item->waktu_persetujuan_wali)->format('d/m/Y H:i') }})</span>
                                            @endif
                                        </div>
                                        @if (!empty($item->catatan_wali))
                                            <div class="info-value" style="font-style: italic; color: #475569; margin-top: 3px;">
                                                "{{ $item->catatan_wali }}"
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                        {{-- action --}}
                                        @if ($item->status === 'Disetujui_Wali')
                                            <div class="schedule-note" style="border-left: 3px solid #0e8a4a; background: #f2fbf6; padding: 8px 12px; border-radius: 8px; margin-top: 8px;">
                                                <div class="info-label" style="font-weight: 700; color: #0e8a4a; margin-bottom: 3px;">
                                                    <i data-lucide="clock"></i>
                                                    Jadwal Belum Final
                                                </div>
                                                <div class="info-value" style="font-size: 10.5px; color: #2f523f;">
                                                    @if ($item->hasSubmittedSchedule())
                                                        Slot konseling telah dipilih siswa. Konfirmasi jadwal untuk mengubah status menjadi <strong>Jadwal Terjadwal</strong>.
                                                    @else
                                                        Izin Wali Kelas sudah disetujui, namun siswa belum memilih slot konseling (atau atur jam melalui Edit Jadwal).
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                <div class="schedule-actions">

                                    {{-- edit --}}
                                    @if ($item->status === 'Disetujui_Wali')
                                        @if (
                                            $item->hasSubmittedSchedule()
                                            && \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') !== '00:00'
                                            && \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') !== '00:00'
                                        )
                                            <form
                                                action="{{ route('penjadwalan.update', $item->id_penjadwalan) }}"
                                                method="POST"
                                                style="display:inline;flex:1;"
                                            >
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_siswa" value="{{ $item->id_siswa }}">
                                                <input type="hidden" name="tanggal" value="{{ $item->tanggal }}">
                                                <input type="hidden" name="waktu_mulai" value="{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}">
                                                <input type="hidden" name="waktu_selesai" value="{{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}">
                                                <input type="hidden" name="jenis_bimbingan" value="{{ $item->jenis_bimbingan }}">
                                                <input type="hidden" name="catatan" value="{{ $item->catatan }}">
                                                <input type="hidden" name="status" value="Terjadwal">
                                                <input type="hidden" name="redirect_to" value="index">
                                                <button
                                                    type="submit"
                                                    class="action-button"
                                                    title="Konfirmasi Jadwal Terjadwal"
                                                    style="width:100%;flex:1;background:#eef4ff;border-color:#c6d7f9;color:#173c91;"
                                                >
                                                    <i data-lucide="check-circle-2"></i>
                                                    Konfirmasi Terjadwal
                                                </button>
                                            </form>
                                        @else
                                            <button
                                                type="button"
                                                class="action-button"
                                                title="Atur Jam &amp; Konfirmasi Jadwal"
                                                onclick="openPenjadwalanModal('editModal{{ $item->id_penjadwalan }}')"
                                                style="flex:1;background:#eef4ff;border-color:#c6d7f9;color:#173c91;"
                                            >
                                                <i data-lucide="calendar-check"></i>
                                                Atur &amp; Konfirmasi
                                            </button>
                                        @endif
                                    @endif

                                    <button
                                        type="button"
                                        class="action-button"
                                        title="Edit Jadwal"
                                        onclick="openPenjadwalanModal('editModal{{ $item->id_penjadwalan }}')"
                                    >
                                        <i data-lucide="pencil"></i>
                                    </button>

                                    {{-- delete --}}

                                    <form
                                        action="{{ route('penjadwalan.destroy', $item->id_penjadwalan) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');"
                                        style="display:inline;flex:0 0 38px;"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button delete"
                                            title="Hapus Jadwal"
                                        >

                                            <i data-lucide="trash-2"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>

                            {{-- modal edit jadwal --}}

                            <div
                                id="editModal{{ $item->id_penjadwalan }}"
                                class="penjadwalan-modal"
                            >
                                <div
                                    class="penjadwalan-modal-overlay"
                                    onclick="closePenjadwalanModal('editModal{{ $item->id_penjadwalan }}')"
                                ></div>

                                <div class="penjadwalan-modal-card">

                                    <div class="penjadwalan-modal-header">

                                        <div class="penjadwalan-modal-title">

                                            <div class="penjadwalan-modal-icon">
                                                <i data-lucide="calendar-pen"></i>
                                            </div>

                                            <div>
                                                <h3>Edit Jadwal BK</h3>
                                                <p>Perbarui informasi jadwal bimbingan siswa.</p>
                                            </div>

                                        </div>

                                        <button
                                            type="button"
                                            class="penjadwalan-modal-close"
                                            onclick="closePenjadwalanModal('editModal{{ $item->id_penjadwalan }}')"
                                        >
                                            <i data-lucide="x"></i>
                                        </button>

                                    </div>

                                    <form
                                        action="{{ route('penjadwalan.update', $item->id_penjadwalan) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <div class="penjadwalan-modal-body">

                                            {{-- siswa --}}

                                            <div class="penjadwalan-form-group">

                                                <label>
                                                    Siswa <span>*</span>
                                                </label>

                                                <select
                                                    name="id_siswa"
                                                    class="penjadwalan-form-input"
                                                    required
                                                >

                                                    @foreach ($siswa as $student)

                                                        <option
                                                            value="{{ $student->id_siswa }}"
                                                            {{ $item->id_siswa == $student->id_siswa ? 'selected' : '' }}
                                                        >
                                                            {{ $student->nama_siswa }}
                                                            — {{ $student->kelas->nama_kelas ?? '-' }}
                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                            {{-- tanggal + jenis --}}

                                            <div class="penjadwalan-form-grid">

                                                <div class="penjadwalan-form-group">

                                                    <label>
                                                        Tanggal <span>*</span>
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="tanggal"
                                                        class="penjadwalan-form-input"
                                                        value="{{ $item->tanggal }}"
                                                        required
                                                    >

                                                </div>

                                                <div class="penjadwalan-form-group">

                                                    <label>
                                                        Jenis Bimbingan <span>*</span>
                                                    </label>

                                                    <select
                                                        name="jenis_bimbingan"
                                                        class="penjadwalan-form-input"
                                                        required
                                                    >

                                                        <option
                                                            value="Individu"
                                                            {{ $item->jenis_bimbingan == 'Individu' ? 'selected' : '' }}>Individu</option>
                                                        @php
                                                            $extraJenisOptions = ['Konseling Pribadi', 'Konseling Sosial', 'Konseling Belajar', 'Bimbingan Karier', 'Konseling Individu'];
                                                            if (!empty($item->jenis_bimbingan) && !in_array($item->jenis_bimbingan, array_merge(['Individu', 'Kelompok'], $extraJenisOptions), true)) {
                                                                array_unshift($extraJenisOptions, $item->jenis_bimbingan);
                                                            }
                                                        @endphp
                                                        @foreach ($extraJenisOptions as $jenisOption)
                                                            <option value="{{ $jenisOption }}" {{ $item->jenis_bimbingan == $jenisOption ? 'selected' : '' }}>{{ $jenisOption }}</option>
                                                        @endforeach
                                                        <option value="Individu" hidden disabled
                                                        >
                                                            Individu
                                                        </option>

                                                        <option
                                                            value="Kelompok"
                                                            {{ $item->jenis_bimbingan == 'Kelompok' ? 'selected' : '' }}
                                                        >
                                                            Kelompok
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>

                                            {{-- waktu --}}

                                            <div class="penjadwalan-form-grid">

                                                <div class="penjadwalan-form-group">

                                                    <label>
                                                        Waktu Mulai <span>*</span>
                                                    </label>

                                                    <input
                                                        type="time"
                                                        name="waktu_mulai"
                                                        class="penjadwalan-form-input"
                                                        value="{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}"
                                                        required
                                                    >

                                                </div>

                                                <div class="penjadwalan-form-group">

                                                    <label>
                                                        Waktu Selesai <span>*</span>
                                                    </label>

                                                    <input
                                                        type="time"
                                                        name="waktu_selesai"
                                                        class="penjadwalan-form-input"
                                                        value="{{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}"
                                                        required
                                                    >

                                                </div>

                                            </div>

                                            {{-- status --}}

                                            <div class="penjadwalan-form-group">

                                                <label>
                                                    Status <span>*</span>
                                                </label>

                                                <select
                                                    name="status"
                                                    class="penjadwalan-form-input"
                                                    required
                                                >

                                                    <option
                                                        value="Diajukan"
                                                        {{ $item->status == 'Diajukan' ? 'selected' : '' }}
                                                    >
                                                        Diajukan (Menunggu Izin Wali Kelas)
                                                    </option>

                                                    <option
                                                        value="Disetujui_Wali"
                                                        {{ $item->status == 'Disetujui_Wali' ? 'selected' : '' }}
                                                    >
                                                        Izin Disetujui Wali Kelas (Jadwal Belum Final)
                                                    </option>

                                                    <option
                                                        value="Ditolak_Wali"
                                                        {{ $item->status == 'Ditolak_Wali' ? 'selected' : '' }}
                                                    >
                                                        Belum Diizinkan Wali Kelas
                                                    </option>

                                                    <option
                                                        value="Terjadwal"
                                                        {{ $item->status == 'Terjadwal' ? 'selected' : '' }}
                                                    >
                                                        Jadwal Terjadwal (Sudah Dikonfirmasi)
                                                    </option>

                                                    <option
                                                        value="Selesai"
                                                        {{ $item->status == 'Selesai' ? 'selected' : '' }}
                                                    >
                                                        Selesai
                                                    </option>

                                                    <option
                                                        value="Dibatalkan"
                                                        {{ $item->status == 'Dibatalkan' ? 'selected' : '' }}
                                                    >
                                                        Dibatalkan
                                                    </option>

                                                </select>

                                            </div>

                                            {{-- catatan --}}

                                            <div class="penjadwalan-form-group">

                                                <label>
                                                    Catatan
                                                </label>

                                                <textarea
                                                    name="catatan"
                                                    class="penjadwalan-form-input"
                                                    rows="4"
                                                    placeholder="Tambahkan catatan jika diperlukan..."
                                                >{{ $item->catatan }}</textarea>

                                            </div>

                                        </div>

                                        {{-- footer --}}

                                        <div class="penjadwalan-modal-footer">

                                            <button
                                                type="button"
                                                class="penjadwalan-btn-secondary"
                                                onclick="closePenjadwalanModal('editModal{{ $item->id_penjadwalan }}')"
                                            >
                                                Batal
                                            </button>

                                            <button
                                                type="submit"
                                                class="penjadwalan-btn-primary"
                                            >
                                                <i data-lucide="save"></i>
                                                Simpan Perubahan
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>
                        @endforeach

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">

                            <i data-lucide="calendar-x-2"></i>

                        </div>

                        <div class="empty-title">
                            Belum Ada Jadwal
                        </div>

                        <div class="empty-text">
                            Belum terdapat data jadwal bimbingan konseling.
                        </div>

                    </div>

                @endif

                {{-- footer --}}

                @if ($penjadwalan->total() > 0)

                    <div class="table-footer">

                        <div class="table-count">

                            Menampilkan

                            <strong>
                                {{ $penjadwalan->firstItem() }}
                            </strong>

                            sampai

                            <strong>
                                {{ $penjadwalan->lastItem() }}
                            </strong>

                            dari

                            <strong>
                                {{ $penjadwalan->total() }}
                            </strong>

                            jadwal

                        </div>

                        <div class="pagination-wrapper">

                            {{ $penjadwalan->onEachSide(1)->links('pagination::simple-tailwind') }}

                        </div>

                    </div>

                @endif

            </div>

        </section>

    </main>

</div>

<script>

    function openPenjadwalanModal(modalId) {
        const modal = document.getElementById(modalId);

        if (modal) {
            // Jadwal edit modal awalnya ada di dalam kartu yang beranimasi dengan
            // transform. Pindahkan ke body agar tidak terjebak stacking context.
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            lucide.createIcons();
        }
    }

    function closePenjadwalanModal(modalId) {
        const modal = document.getElementById(modalId);

        if (modal) {
            modal.classList.remove('active');
        }

        if (!document.querySelector('.penjadwalan-modal.active')) {
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            document.querySelectorAll('.penjadwalan-modal.active')
                .forEach(function (modal) {
                    modal.classList.remove('active');
                });

            document.body.style.overflow = '';
        }

    });

    function applySlotDuration() {
        const startInput = document.getElementById('slotWaktuMulai');
        const durationSelect = document.getElementById('slotDurasiMenit');
        const endInput = document.getElementById('slotWaktuSelesai');

        if (!startInput || !durationSelect || !endInput) return;

        const durationVal = parseInt(durationSelect.value || '0', 10);
        if (!durationVal || !startInput.value) return;

        const parts = startInput.value.split(':');
        if (parts.length < 2) return;

        const startMins = parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
        let endMins = startMins + durationVal;
        if (endMins > 15 * 60) {
            endMins = 15 * 60;
        }

        const endHours = String(Math.floor(endMins / 60)).padStart(2, '0');
        const endRem = String(endMins % 60).padStart(2, '0');
        endInput.value = endHours + ':' + endRem;
    }

    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
        applySlotDuration();
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
    });

</script>

{{-- modal tambah jadwal mengajar guru bk --}}
<div id="mengajarModal" class="penjadwalan-modal">
    <div class="penjadwalan-modal-overlay" onclick="closePenjadwalanModal('mengajarModal')"></div>
    <div class="penjadwalan-modal-card">
        <div class="penjadwalan-modal-header">
            <div class="penjadwalan-modal-title">
                <div class="penjadwalan-modal-icon">
                    <i data-lucide="book-open"></i>
                </div>
                <div>
                    <h3>Tambah Jadwal Mengajar Guru BK</h3>
                    <p>Masukkan jadwal mengajar kelas agar tidak berbenturan dengan slot konseling.</p>
                </div>
            </div>
            <button type="button" class="penjadwalan-modal-close" onclick="closePenjadwalanModal('mengajarModal')">
                <i data-lucide="x"></i>
            </button>
        </div>

        <form action="{{ route('penjadwalan.mengajar.store') }}" method="POST">
            @csrf
            <div class="penjadwalan-modal-body">
                <div class="penjadwalan-form-grid">
                    <div class="penjadwalan-form-group">
                        <label>Hari Mengajar <span>*</span></label>
                        <select name="hari" class="penjadwalan-form-input" required>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hariOpt)
                                <option value="{{ $hariOpt }}">{{ $hariOpt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="penjadwalan-form-group">
                        <label>Tanggal Spesifik (Opsional)</label>
                        <input type="date" name="tanggal" class="penjadwalan-form-input">
                    </div>
                </div>

                <div class="penjadwalan-form-grid">
                    <div class="penjadwalan-form-group">
                        <label>Waktu Mulai Mengajar <span>*</span></label>
                        <input type="time" name="waktu_mulai" class="penjadwalan-form-input" value="08:00" required>
                    </div>
                    <div class="penjadwalan-form-group">
                        <label>Waktu Selesai Mengajar <span>*</span></label>
                        <input type="time" name="waktu_selesai" class="penjadwalan-form-input" value="09:30" required>
                    </div>
                </div>

                <div class="penjadwalan-form-grid">
                    <div class="penjadwalan-form-group">
                        <label>Kelas</label>
                        <select name="id_kelas" class="penjadwalan-form-input">
                            <option value="">-- Pilih Kelas (Opsional) --</option>
                            @if (isset($kelasList))
                                @foreach ($kelasList as $kls)
                                    <option value="{{ $kls->id_kelas }}">Kelas {{ $kls->nama_kelas }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="penjadwalan-form-group">
                        <label>Kegiatan / Mata Pelajaran <span>*</span></label>
                        <input type="text" name="mata_pelajaran" class="penjadwalan-form-input" value="Bimbingan Klasikal BK" required>
                    </div>
                </div>

                <div class="penjadwalan-form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" class="penjadwalan-form-input" rows="2" placeholder="Catatan tambahan jadwal mengajar..."></textarea>
                </div>
            </div>

            <div class="penjadwalan-modal-footer">
                <button type="button" class="penjadwalan-btn-secondary" onclick="closePenjadwalanModal('mengajarModal')">Batal</button>
                <button type="submit" class="penjadwalan-btn-primary">Simpan Jadwal Mengajar</button>
            </div>
        </form>
    </div>
</div>

{{-- modal buka slot ketersediaan konseling --}}
<div id="slotModal" class="penjadwalan-modal">
    <div class="penjadwalan-modal-overlay" onclick="closePenjadwalanModal('slotModal')"></div>
    <div class="penjadwalan-modal-card">
        <div class="penjadwalan-modal-header">
            <div class="penjadwalan-modal-title">
                <div class="penjadwalan-modal-icon">
                    <i data-lucide="clock-plus"></i>
                </div>
                <div>
                    <h3>Buka Slot Ketersediaan Konseling</h3>
                    <p>Jam operasional 08.00–15.00 WIB (tidak berbenturan dengan jadwal mengajar).</p>
                </div>
            </div>
            <button type="button" class="penjadwalan-modal-close" onclick="closePenjadwalanModal('slotModal')">
                <i data-lucide="x"></i>
            </button>
        </div>

        <form action="{{ route('penjadwalan.slot.store') }}" method="POST">
            @csrf
            <div class="penjadwalan-modal-body">
                <div class="penjadwalan-form-grid">
                    <div class="penjadwalan-form-group">
                        <label>Tanggal Konseling <span>*</span></label>
                        <input type="date" name="tanggal" class="penjadwalan-form-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="penjadwalan-form-group">
                        <label>Durasi Slot Konseling <span>*</span></label>
                        <select name="durasi_menit" id="slotDurasiMenit" class="penjadwalan-form-input" onchange="applySlotDuration()">
                            <option value="60" selected>1 Jam (60 Menit)</option>
                            <option value="120">2 Jam (120 Menit)</option>
                            <option value="45">45 Menit</option>
                            <option value="90">1,5 Jam (90 Menit)</option>
                            <option value="0">Kustom (Atur Waktu Selesai Manual)</option>
                        </select>
                    </div>
                </div>

                <div class="penjadwalan-form-grid">
                    <div class="penjadwalan-form-group">
                        <label>Waktu Mulai (08:00 – 15:00) <span>*</span></label>
                        <input type="time" id="slotWaktuMulai" name="waktu_mulai" min="08:00" max="15:00" class="penjadwalan-form-input" value="08:00" onchange="applySlotDuration()" required>
                    </div>
                    <div class="penjadwalan-form-group">
                        <label>Waktu Selesai (Maks. 15:00) <span>*</span></label>
                        <input type="time" id="slotWaktuSelesai" name="waktu_selesai" min="08:00" max="15:00" class="penjadwalan-form-input" value="09:00" required>
                    </div>
                </div>

                <div class="penjadwalan-form-group">
                    <label>Status Awal Slot <span>*</span></label>
                    <select name="status_slot" class="penjadwalan-form-input" required>
                        <option value="Tersedia" selected>Tersedia (Dapat Dipilih Siswa yang Sudah Disetujui Wali Kelas)</option>
                        <option value="Tidak_Tersedia">Tidak Tersedia (Ditutup Sementara)</option>
                    </select>
                </div>

                <div class="penjadwalan-form-group">
                    <label>Catatan Slot (Opsional)</label>
                    <input type="text" name="catatan" class="penjadwalan-form-input" placeholder="Contoh: Sesi Konseling Individu / Ruang BK">
                </div>
            </div>

            <div class="penjadwalan-modal-footer">
                <button type="button" class="penjadwalan-btn-secondary" onclick="closePenjadwalanModal('slotModal')">Batal</button>
                <button type="submit" class="penjadwalan-btn-primary">Buka Slot Konseling</button>
            </div>
        </form>
    </div>
</div>

{{-- modal tambah jadwal --}}
<div
    id="createModal"
    class="penjadwalan-modal"
>
    <div
        class="penjadwalan-modal-overlay"
        onclick="closePenjadwalanModal('createModal')"
    ></div>

    <div class="penjadwalan-modal-card">

        <div class="penjadwalan-modal-header">

            <div class="penjadwalan-modal-title">

                <div class="penjadwalan-modal-icon">
                    <i data-lucide="calendar-plus"></i>
                </div>

                <div>
                    <h3>Tambah Jadwal BK</h3>
                    <p>Buat jadwal bimbingan konseling siswa.</p>
                </div>

            </div>

            <button
                type="button"
                class="penjadwalan-modal-close"
                onclick="closePenjadwalanModal('createModal')"
            >
                <i data-lucide="x"></i>
            </button>

        </div>

        <form
            action="{{ route('penjadwalan.store') }}"
            method="POST"
        >

            @csrf

            <div class="penjadwalan-modal-body">

                <div class="penjadwalan-form-group">

                    <label>
                        Siswa <span>*</span>
                    </label>

                    <select
                        name="id_siswa"
                        class="penjadwalan-form-input"
                        required
                    >

                        <option value="">
                            -- Pilih Siswa --
                        </option>

                        @foreach ($siswa as $student)

                            <option value="{{ $student->id_siswa }}">
                                {{ $student->nama_siswa }}
                                — {{ $student->kelas->nama_kelas ?? '-' }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="penjadwalan-form-grid">

                    <div class="penjadwalan-form-group">

                        <label>
                            Tanggal <span>*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="penjadwalan-form-input"
                            required
                        >

                    </div>

                    <div class="penjadwalan-form-group">

                        <label>
                            Jenis Bimbingan <span>*</span>
                        </label>

                        <select
                            name="jenis_bimbingan"
                            class="penjadwalan-form-input"
                            required
                        >

                            <option value="">
                                -- Pilih --
                            </option>

                            <option value="Individu">
                                Individu
                            </option>

                            <option value="Kelompok">
                                Kelompok
                            </option>

                        </select>

                    </div>

                </div>

                <div class="penjadwalan-form-grid">

                    <div class="penjadwalan-form-group">

                        <label>
                            Waktu Mulai <span>*</span>
                        </label>

                        <input
                            type="time"
                            name="waktu_mulai"
                            class="penjadwalan-form-input"
                            required
                        >

                    </div>

                    <div class="penjadwalan-form-group">

                        <label>
                            Waktu Selesai <span>*</span>
                        </label>

                        <input
                            type="time"
                            name="waktu_selesai"
                            class="penjadwalan-form-input"
                            required
                        >

                    </div>

                </div>

                <div class="penjadwalan-form-group">

                    <label>Catatan</label>

                    <textarea
                        name="catatan"
                        class="penjadwalan-form-input"
                        rows="4"
                        placeholder="Tambahkan catatan jika diperlukan..."
                    ></textarea>

                </div>

            </div>

            <div class="penjadwalan-modal-footer">

                <button
                    type="button"
                    class="penjadwalan-btn-secondary"
                    onclick="closePenjadwalanModal('createModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="penjadwalan-btn-primary"
                >
                    Simpan Jadwal
                </button>

            </div>

        </form>

    </div>
</div>

</body>

</html>
