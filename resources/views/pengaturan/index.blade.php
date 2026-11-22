<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengaturan - SIRASI-BK</title>

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {

            --primary: #173c91;
            --primary-dark: #102e70;
            --primary-soft: #edf2ff;

            --bg: #f5f7fb;
            --white: #ffffff;

            --text: #172033;
            --muted: #747d8e;

            --border: #e1e6ef;

            --shadow-sm:
                0 5px 18px rgba(23, 60, 145, .055);

            --shadow-md:
                0 15px 35px rgba(23, 60, 145, .09);

        }

        body {

            min-height: 100vh;



            color: var(--text);

            background:
                radial-gradient(
                    circle at 90% 0%,
                    rgba(40, 74, 160, .09),
                    transparent 30%
                ),
                var(--bg);

        }

        /* penting mencegah link berubah warna ungu setelah diklik. */

        a,
        a:visited,
        a:hover,
        a:active {

            text-decoration: none;

        }

        .report-type,
        .report-type:visited,
        .report-type:hover,
        .report-type:active {

            color: var(--text);

            text-decoration: none;

        }

        .report-type-title {

            color: #172033;

        }

        .report-type-description {

            color: #747d8e;

        }

        .report-type:hover .report-type-title,
        .report-type:active .report-type-title,
        .report-type:visited .report-type-title {

            color: #172033;

        }

        button,
        input,
        select {



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

            color: white;

            background:
                linear-gradient(
                    180deg,
                    #193f96 0%,
                    #173887 52%,
                    #112e70 100%
                );

            box-shadow:
                12px 0 35px
                rgba(15, 45, 112, .10);

        }

        .brand {

            display: flex;

            align-items: center;

            gap: 13px;

            padding:
                4px 10px 28px;

        }

        .brand-logo {

            width: 55px;
            height: 55px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background:
                rgba(255, 255, 255, .14);

            border:
                1px solid
                rgba(255, 255, 255, .20);

            font-size: 20px;

            font-weight: 800;

        }

        .brand-logo img {
            width: 200px;
            height: 150px;
            object-fit: contain;
            transform: translateY(20px);
        }

        .brand-title {

            font-size: 19px;

            font-weight: 800;

        }

        .brand-subtitle {

            margin-top: 4px;

            color: #cbd8ff;

            font-size: 11px;

        }

        .menu-title {

            padding:
                4px 12px 10px;

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

        .menu a {

            min-height: 47px;

            display: flex;

            align-items: center;

            gap: 13px;

            padding:
                0 14px;

            border-radius: 12px;

            color: #d2dcfa;

            font-size: 13.5px;

            font-weight: 500;

            border:
                1px solid transparent;

            transition: .2s ease;

        }

        .menu a:visited {

            color: #d2dcfa;

        }

        .menu a:hover {

            color: white;

            background:
                rgba(255, 255, 255, .09);

            transform:
                translateX(2px);

        }

        .menu a.active {

            color: white;

            background:
                linear-gradient(
                    90deg,
                    rgba(255,255,255,.17),
                    rgba(255,255,255,.08)
                );

            border-color:
                rgba(255,255,255,.10);

            box-shadow:
                inset 3px 0 0 #9db9ff;

        }

        .menu a.active:visited {

            color: white;

        }

        .menu-icon {

            width: 25px;
            height: 25px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background:
                rgba(255, 255, 255, .07);

            font-size: 14px;

        }

        /* sidebar logout */

        .sidebar-logout {
            margin-top: auto;
            padding-top: 20px;
        }

        /* button logout */

        .sidebar-logout button {
            width: 100%;
            min-height: 47px;

            display: flex;
            align-items: center;
            gap: 13px;

            border: 1px solid transparent;
            border-radius: 12px;

            background: transparent;

            color: #d2dcfa;

            cursor: pointer;
            text-align: left;

            padding: 0 14px;


            font-size: 13.5px;
            font-weight: 700;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease,
                border-color .2s ease;
        }

        /* icon logout */

        .sidebar-logout button .menu-icon {
            width: 25px;
            height: 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 8px;

            background: rgba(255,255,255,.07);

            font-size: 14px;

            transition:
                background .2s ease,
                box-shadow .2s ease;
        }

        /* hover logout */

        .sidebar-logout button:hover {
            background: rgba(255,255,255,.09);

            border-color:
                rgba(255,255,255,.08);

            color: white;

            transform: translateX(2px);
        }

        .sidebar-logout button:hover .menu-icon {
            background:
                rgba(255,255,255,.15);

            box-shadow:
                inset 0 0 0 1px
                rgba(255,255,255,.05);
        }

        /* click */

        .sidebar-logout button:active {
            background:
                rgba(151,190,255,.20);

            transform:
                translateX(1px) scale(.995);
        }

        /* focus */

        .sidebar-logout button:focus-visible {
            outline:
                3px solid
                rgba(157,185,255,.28);

            outline-offset: 2px;
        }

        /* responsive */

        /* theme preference */
        .theme-choice { position: relative; cursor: pointer; transition: .2s ease; }
        .theme-choice:hover { transform: translateY(-1px); border-color: #a9bee7; box-shadow: 0 8px 18px rgba(40,85,183,.07); }
        .theme-choice.active { border-color: #4d73c8; background: linear-gradient(135deg, #f5f8ff 0%, #edf3ff 100%); box-shadow: 0 0 0 3px rgba(49,95,196,.08); }
        .theme-choice.active::after { content: '✓'; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; position: absolute; top: 13px; right: 13px; border-radius: 50%; background: #315fc4; color: #fff; font-size: 12px; font-weight: 800; }
        .theme-current { margin: 14px 0 0; padding: 10px 12px; border: 1px dashed #d5dfef; border-radius: 11px; background: #f8faff; color: #667693; font-size: 10.5px; line-height: 1.5; }
        .theme-current strong { color: #294d9d; }

        /* dark theme */
        body.dark-mode { --bg:#0f1728; --white:#172238; --text:#edf3ff; --muted:#9aa8c0; --border:#293752; background:radial-gradient(circle at 90% 0%,rgba(67,105,190,.16),transparent 30%),#0f1728; color:#edf3ff; }
        body.dark-mode .main { background:#0f1728; }
        body.dark-mode .topbar { background:rgba(19,30,50,.96) !important; border-bottom-color:#2a3852 !important; }
        body.dark-mode .bell { background:#18253c !important; border-color:#334463 !important; color:#9fc0ff !important; }
        body.dark-mode .profile-name, body.dark-mode .page-title, body.dark-mode .option-title, body.dark-mode .application-name, body.dark-mode .modal-title, body.dark-mode .settings-info-item-title, body.dark-mode .app-about-title { color:#f1f5ff !important; }
        body.dark-mode .profile-role, body.dark-mode .page-subtitle, body.dark-mode .profile-username, body.dark-mode .profile-label, body.dark-mode .option-description, body.dark-mode .application-version, body.dark-mode .settings-info-item-text, body.dark-mode .settings-modal-intro, body.dark-mode .app-about-description, body.dark-mode .theme-current { color:#9eacc4 !important; }
        body.dark-mode .profile-card, body.dark-mode .option-card, body.dark-mode .application-card { background:linear-gradient(145deg,#18253b 0%,#141f33 100%) !important; border-color:#2c3b57 !important; box-shadow:0 15px 35px rgba(0,0,0,.18) !important; }
        body.dark-mode .profile-card:hover, body.dark-mode .option-card:hover { border-color:#5478c8 !important; box-shadow:0 16px 32px rgba(0,0,0,.24) !important; }
        body.dark-mode .profile-avatar { background:#1b2942 !important; border-color:#18253b !important; color:#a9c5ff !important; }
        body.dark-mode .profile-row { border-top-color:#30405b !important; }
        body.dark-mode .role { color: #a9c5ff !important; background: #1d2c47 !important; border-color: #334463 !important; }
        body.dark-mode .arrow,
        body.dark-mode .settings-layout .arrow {
            background: #1d2c47 !important;
            border: 1px solid #334463 !important;
            color: #9fc0ff !important;
        }
        body.dark-mode .option-card:hover .arrow,
        body.dark-mode .settings-layout .option-card:hover .arrow {
            background: #25395e !important;
            border-color: #5d83d5 !important;
            color: #ffffff !important;
        }
        body.dark-mode .logout-btn { background:#211d28 !important; border-color:#d96876 !important; color:#ff9ba5 !important; }
        body.dark-mode .logout-btn:hover { background:#30202a !important; }
        body.dark-mode .theme-choice { background:linear-gradient(145deg,#1a2940 0%,#162238 100%) !important; border-color:#30405b !important; }
        body.dark-mode .theme-choice.active { background:linear-gradient(135deg,#20365d 0%,#1a2c4c 100%) !important; border-color:#5d83d5 !important; box-shadow:0 0 0 3px rgba(93,131,213,.12); }
        body.dark-mode .theme-current { background:#162238 !important; border-color:#354560 !important; }
        body.dark-mode .theme-current strong { color:#b4ccff !important; }
        body.dark-mode .modal-card { background:linear-gradient(145deg,#18253b 0%,#121d30 100%) !important; border-color:#34445f !important; box-shadow:0 30px 80px rgba(0,0,0,.48) !important; }
        body.dark-mode .modal-header { background:linear-gradient(180deg,#1c2a42,#17243a) !important; border-bottom-color:#30405a !important; }
        body.dark-mode .modal-close { color:#9ba9bf !important; }
        body.dark-mode .modal-close:hover { background:#253550 !important; border-color:#3b4d6b !important; color:#fff !important; }
        body.dark-mode .modal-footer { background:rgba(20,31,49,.9) !important; border-top-color:#30405a !important; }
        body.dark-mode .form-group label { color:#b8c4d8 !important; }
        body.dark-mode .form-group input { background:#111c2e !important; border-color:#344560 !important; color:#edf3ff !important; }
        body.dark-mode .form-group input:hover, body.dark-mode .form-group input:focus { background:#142137 !important; border-color:#6286d1 !important; }
        body.dark-mode .modal-btn { background:#1b2940 !important; border-color:#394a65 !important; color:#c4cee0 !important; }
        body.dark-mode .modal-btn:hover { background:#243550 !important; border-color:#4b5e7c !important; }
        body.dark-mode .settings-info-item { background:linear-gradient(135deg,#1a2940 0%,#162238 100%) !important; border-color:#30405b !important; }
        body.dark-mode .settings-info-item-icon, body.dark-mode .app-about-icon { background:#20385f !important; border-color:#3a5684 !important; color:#a9c8ff !important; }
        body.dark-mode .app-about-version { background:#1b3155 !important; border-color:#385583 !important; color:#abc5ff !important; }
        body.responsive-disabled .settings-main,
        body.responsive-disabled .main-content {
            min-width: 1100px;
        }

        body.responsive-disabled .settings-layout {
            min-width: 1000px;
        }

        .responsive-choice {
            position: relative;
            cursor: pointer;
            padding-right: 58px !important;
        }

        .responsive-choice .responsive-toggle {
            position: absolute;
            top: 50%;
            right: 18px;
            width: 38px;
            height: 22px;
            border-radius: 999px;
            background: #cbd5e5;
            transform: translateY(-50%);
            transition: .2s ease;
        }

        .responsive-choice .responsive-toggle::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 5px rgba(20,45,90,.18);
            transition: .2s ease;
        }

        .responsive-choice.active .responsive-toggle {
            background: #315fc4;
        }

        .responsive-choice.active .responsive-toggle::after {
            transform: translateX(16px);
        }

        body.dark-mode .responsive-choice .responsive-toggle {
            background: #43536e;
        }

        body.dark-mode .responsive-choice.active .responsive-toggle {
            background: #5d83d5;
        }

        @media (max-width: 760px) {

            .sidebar-logout button {
                justify-content: center;
                padding: 0;
            }

        }

        /* main */

        .main {

            min-height: 100vh;

            margin-left: 235px;

        }

        /* topbar */

        .topbar {

            height: 76px;

            display: flex;

            align-items: center;

            justify-content: flex-end;

            padding:
                0 32px;

            background:
                rgba(255,255,255,.88);

            backdrop-filter:
                blur(14px);

            border-bottom:
                1px solid
                rgba(226,230,238,.8);

            position: sticky;

            top: 0;

            z-index: 40;

        }

        .topbar-right {

            display: flex;

            align-items: center;

            gap: 15px;

        }

        .bell {

            width: 38px;
            height: 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            border:
                1px solid
                var(--border);

            border-radius: 11px;

            background: white;

            color:
                var(--primary);

            box-shadow:
                var(--shadow-sm);

            position: relative;

        }

        .bell-dot {

            width: 7px;
            height: 7px;

            position: absolute;

            top: 6px;
            right: 6px;

            border:
                2px solid white;

            border-radius: 50%;

            background:
                #e14c4c;

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

        .notification-wrapper {
            position: relative;
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

        .top-divider {

            width: 1px;

            height: 30px;

            background:
                var(--border);

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
            color: #172033;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.1;
        }

        .profile-role {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.1;
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

            color:
                var(--primary);

            font-size: 13px;

            font-weight: 800;

        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        /* content */

        .content {

            width: 100%;

            max-width: 1450px;

            margin: auto;

            padding:
                32px;

        }

        /* page header */

        .page-top {

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;

        }

        .eyebrow {

            margin-bottom: 7px;

            color:
                var(--primary);

            font-size: 10px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1px;

        }

        .page-title {

            font-size: 29px;

            font-weight: 800;

            letter-spacing: -.5px;

        }

        .page-subtitle {

            margin-top: 7px;

            color:
                var(--muted);

            font-size: 12px;

        }

        /* report cards */

        .report-types {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 15px;

            margin-bottom: 22px;

        }

        .report-type {

            position: relative;

            overflow: hidden;

            min-height: 125px;

            display: flex;

            align-items: flex-start;

            gap: 14px;

            padding: 18px;

            border:
                1px solid
                var(--border);

            border-radius: 16px;

            background:
                white;

            box-shadow:
                var(--shadow-sm);

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                border-color .22s ease;

        }

        .report-type::before {

            content: "";

            position: absolute;

            left: 0;

            top: 0;

            bottom: 0;

            width: 0;

            background:
                var(--primary);

            box-shadow:
                0 0 18px
                rgba(23,60,145,.35);

            transition:
                width .25s ease;

        }

        .report-type:hover {

            transform:
                translateY(-3px);

            border-color:
                #c5d0e8;

            box-shadow:
                0 13px 30px
                rgba(23,60,145,.10);

        }

        .report-type.active {

            border-color:
                #8ea6df;

            background:
                linear-gradient(
                    145deg,
                    #f4f7ff,
                    #ffffff
                );

            box-shadow:
                0 13px 30px
                rgba(23,60,145,.11);

        }

        .report-type.active::before {

            width: 4px;

        }

        .report-icon {

            width: 44px;
            height: 44px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                var(--primary-soft);

            color:
                var(--primary);

            font-size: 17px;

            transition: .22s ease;

        }

        .report-type.active .report-icon {

            background:
                var(--primary);

            color:
                white;

            box-shadow:
                0 7px 16px
                rgba(23,60,145,.20);

        }

        .report-content {

            flex: 1;

        }

        .report-type-title {

            margin-bottom: 6px;

            font-size: 13px;

            font-weight: 800;

            color:
                #172033;

        }

        .report-type-description {

            color:
                #747d8e;

            font-size: 10px;

            line-height: 1.6;

        }

        .report-arrow {

            margin-top: 3px;

            color:
                #a3aab7;

            font-size: 20px;

            transition: .2s ease;

        }

        .report-type:hover .report-arrow {

            color:
                var(--primary);

            transform:
                translateX(3px);

        }

        /* parameter card */

        .parameter-card {

            overflow: hidden;

            border:
                1px solid
                var(--border);

            border-radius: 18px;

            background:
                white;

            box-shadow:
                var(--shadow-sm);

            margin-bottom: 22px;

        }

        .parameter-header {

            padding:
                20px 22px;

            border-bottom:
                1px solid
                var(--border);

        }

        .parameter-title {

            font-size: 15px;

            font-weight: 800;

        }

        .parameter-description {

            margin-top: 5px;

            color:
                var(--muted);

            font-size: 10px;

        }

        .parameter-body {

            padding:
                22px;

        }

        .filter-grid {

            display: grid;

            grid-template-columns:
                1fr 1fr 1fr 1fr;

            gap: 14px;

        }

        .field label {

            display: block;

            margin-bottom: 7px;

            color:
                #586173;

            font-size: 9.5px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .3px;

        }

        .field input,
        .field select {

            width: 100%;

            height: 43px;

            padding:
                0 12px;

            border:
                1px solid
                #dce2ec;

            border-radius: 10px;

            background:
                #fafbfc;

            color:
                var(--text);

            font-size: 10.5px;

            outline: none;

            transition: .2s ease;

        }

        .field input:focus,
        .field select:focus {

            background:
                white;

            border-color:
                #8ea6df;

            box-shadow:
                0 0 0 4px
                rgba(23,60,145,.06);

        }

        .button-row {

            display: flex;

            justify-content: flex-end;

            margin-top: 20px;

        }

        .show-button {

            min-width: 147px;

            height: 43px;

            padding:
                0 18px;

            border:
                1px solid
                var(--primary);

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #2149a2,
                    #173c91
                );

            color:
                white;

            cursor: pointer;

            font-size: 10.5px;

            font-weight: 800;

            box-shadow:
                0 7px 16px
                rgba(23,60,145,.15);

            transition: .2s ease;

        }

        .show-button:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 10px 20px
                rgba(23,60,145,.21);

        }

        /* result card */

        .result-card {

            overflow: hidden;

            border:
                1px solid
                var(--border);

            border-radius: 18px;

            background:
                white;

            box-shadow:
                var(--shadow-sm);

        }

        .result-header {

            padding:
                20px 22px;

            border-bottom:
                1px solid
                var(--border);

        }

        .result-title {

            font-size: 14px;

            font-weight: 800;

        }

        .result-description {

            margin-top: 5px;

            color:
                var(--muted);

            font-size: 10px;

        }

        .table-wrapper {

            overflow-x: auto;

        }

        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 800px;

        }

        thead th {

            padding:
                13px 16px;

            background:
                #f8f9fc;

            border-bottom:
                1px solid
                var(--border);

            color:
                #70798a;

            font-size: 9px;

            font-weight: 800;

            text-align: left;

            text-transform: uppercase;

            letter-spacing: .35px;

        }

        tbody td {

            padding:
                15px 16px;

            border-bottom:
                1px solid
                #edf0f4;

            color:
                #4f5869;

            font-size: 10px;

        }

        tbody tr:last-child td {

            border-bottom: 0;

        }

        tbody tr:hover {

            background:
                #fafbff;

        }

        .student-name {

            color:
                var(--primary);

            font-weight: 800;

        }

        .problem-name {

            color:
                #172033;

            font-weight: 700;

        }

        .date {

            font-weight: 700;

        }

        .status {

            display: inline-flex;

            padding:
                5px 9px;

            border-radius: 7px;

            font-size: 8.5px;

            font-weight: 800;

        }

        .status-selesai {

            color:
                #16834a;

            background:
                #eaf8f0;

        }

        .status-proses {

            color:
                #b77908;

            background:
                #fff7df;

        }

        /* empty */

        .empty {

            padding:
                50px 20px;

            text-align: center;

            color:
                var(--muted);

        }

        .empty-icon {

            width: 55px;
            height: 55px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin:
                0 auto 12px;

            border-radius: 16px;

            background:
                #eef2f8;

            color:
                #8992a2;

            font-size: 21px;

        }

        .empty-title {

            margin-bottom: 5px;

            color:
                var(--text);

            font-size: 13px;

            font-weight: 800;

        }

        .empty-text {

            font-size: 10px;

        }

        /* settings layout */

        .settings-layout {
            display: grid;

            grid-template-columns: 335px 1fr;

            gap: 24px;

            align-items: start;
        }

        /* profile card */

        .profile-card {
            background: white;

            border: 1px solid #cfd2dc;

            border-radius: 8px;

            overflow: hidden;
        }

        .profile-cover {
            height: 65px;

            background: linear-gradient(
                90deg,
                #29438f,
                #5369b4
            );
        }

        .profile-body {
            padding: 0 24px 22px;

            text-align: center;
        }

        .profile-avatar {
            width: 95px;
            height: 95px;

            margin: -24px auto 15px;

            background: #f5f5f5;

            border: 5px solid white;

            border-radius: 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #29438f;

            font-size: 28px;
            font-weight: 700;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .profile-username {
            color: #666;
            font-size: 13px;

            margin-bottom: 20px;
        }

        .profile-row {
            border-top: 1px solid #ddd;

            padding: 13px 0;

            display: flex;
            justify-content: space-between;
            align-items: center;

            font-size: 13px;
        }

        .profile-label {
            color: #666;
        }

        .profile-value {
            font-weight: 600;
        }

        .role {
            color: #173c91;
        }

        /* option cards */

        .options {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 16px;
        }

        .option-card {
            background: white;

            border: 1px solid #cfd2dc;

            border-radius: 8px;

            padding: 17px;

            min-height: 118px;

            display: flex;

            align-items: flex-start;

            gap: 15px;

            cursor: pointer;

            transition: .15s;
        }

        .option-card:hover {
            border-color: #29438f;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, .05);
        }

        .option-icon {
            width: 43px;
            height: 43px;

            flex-shrink: 0;

            background: #eef1ff;

            color: #173c91;

            border-radius: 5px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;
        }

        .option-content {
            flex: 1;
        }

        .option-title {
            font-size: 14px;
            font-weight: 600;

            margin-bottom: 7px;
        }

        .option-description {
            color: #555;

            font-size: 13px;

            line-height: 1.45;
        }

        .arrow {
            color: #aaa;

            font-size: 22px;

            margin-top: 5px;
        }

        /* application card */

        .application-card {
            grid-column: 1 / -1;

            background: white;

            border: 1px solid #cfd2dc;

            border-radius: 8px;

            padding: 16px;

            display: flex;

            align-items: center;

            gap: 14px;
        }

        .application-icon {
            width: 43px;
            height: 43px;

            background: #eef1ff;

            color: #173c91;

            border-radius: 5px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .application-info {
            flex: 1;
        }

        .application-name {
            font-size: 14px;
            font-weight: 600;
        }

        .application-version {
            font-size: 12px;

            color: #555;

            margin-top: 3px;
        }

        .logout-btn {
            border: 1px solid #dc3545;

            background: white;

            color: #dc3545;

            border-radius: 5px;

            padding: 10px 20px;

            cursor: pointer;

            font-size: 13px;
        }

        .logout-btn:hover {
            background: #fff4f4;
        }

        /* modal */

        .modal {
            display: none;

            position: fixed;

            inset: 0;

            background: rgba(12, 24, 52, .45);

            align-items: center;
            justify-content: center;

            z-index: 1000;
        }

        .modal.show {
            display: flex;
        }

        .modal-card {
            width: 480px;

            max-width: calc(100% - 30px);

            background: white;

            border-radius: 8px;

            box-shadow:
                0 15px 45px rgba(0, 0, 0, .2);
        }

        .modal-header {
            padding: 18px 22px;

            border-bottom: 1px solid #ddd;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .modal-title {
            font-size: 17px;
            font-weight: 600;
        }

        .modal-close {
            border: 0;

            background: none;

            font-size: 23px;

            cursor: pointer;

            color: #666;
        }

        .modal-body {
            padding: 22px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;

            margin-bottom: 7px;

            font-size: 13px;

            font-weight: 600;
        }

        .form-group input {
            width: 100%;

            height: 40px;

            border: 1px solid #c9ccd5;

            border-radius: 5px;

            padding: 8px 11px;


        }

        .form-group input:focus {
            outline: none;

            border-color: #29438f;
        }

        .modal-footer {
            border-top: 1px solid #ddd;

            padding: 14px 22px;

            display: flex;

            justify-content: flex-end;

            gap: 10px;
        }

        .modal-btn {
            padding: 9px 17px;

            border-radius: 5px;

            border: 1px solid #ccd0da;

            background: white;

            cursor: pointer;
        }

        .modal-btn-primary {
            background: #173c91;

            border-color: #173c91;

            color: white;
        }

        .error {
            color: #d71920;

            font-size: 12px;

            margin-top: 5px;
        }

        /* responsive */

        @media (max-width: 1100px) {

            .filter-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .report-types {

                grid-template-columns:
                    1fr;

            }

        }

        @media (max-width: 800px) {

            .sidebar {

                width: 78px;

                padding:
                    20px 10px;
            }

            .main {

                margin-left: 78px;
            }

            .brand {

                justify-content:
                    center;

                padding-left: 0;
                padding-right: 0;
            }

            .brand-title,
            .brand-subtitle,
            .menu-title {

                display: none;
            }

            .menu a {

                justify-content:
                    center;

                padding: 0;
                font-size: 0;
            }

            .menu-icon {

                font-size: 14px;
            }

            .sidebar-logout button {

                text-align: center;

                padding: 0;

            }

            .content {

                padding:
                    24px 16px;

            }

            .page-top {

                flex-direction:
                    column;

            }

        }

        @media (max-width: 560px) {

            .filter-grid {

                grid-template-columns:
                    1fr;

            }

            .topbar {

                padding:
                    0 15px;

            }

            .user-info,
            .top-divider {

                display: none;

            }

        }

        @media (max-width: 430px) {

            .sidebar {

                display: none;

            }

            .main {

                margin-left: 0;

            }

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
input:focus,select:focus,textarea:focus,.form-control:focus,.filter-select:focus,.filter-date:focus{
  border-color:#8eabe0 !important;
  background:#fff !important;
  box-shadow:0 0 0 4px rgba(40,85,183,.075) !important;
  outline:none !important;
}

/* focus / click feedback */
a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible,textarea:focus-visible{
  outline:3px solid rgba(91,132,211,.28) !important;
  outline-offset:2px;
}

/* responsive */
@media(max-width:800px){.sidebar{width:78px !important;padding:20px 10px !important}.main{margin-left:78px !important}.brand{justify-content:center !important;padding-left:0 !important;padding-right:0 !important}.brand-title,.brand-subtitle,.menu-title{display:none !important}.menu a{justify-content:center !important;padding:0 !important;font-size:0 !important}.menu-icon{font-size:14px !important}.sidebar-logout button,.logout-button{justify-content:center !important;padding:0 !important;font-size:0 !important}}
@media(max-width:650px){
  .menu-item,.menu a{font-size:13px !important}
  .profile-name,.user-name{font-size:12px !important}
}

</style>

    <!-- SIRASI-BK SETTINGS VISUAL ENHANCEMENT -->
    <style>
        /* pengaturan — modern visual only hanya mengubah tampilan halaman pengaturan dan modal. tidak mengubah route, form, data, atau fungsi javascript. */

        .settings-layout {
            grid-template-columns: 335px minmax(0, 1fr);
            gap: 24px;
        }

        /* profile card */
        .settings-layout .profile-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(210, 220, 238, .95);
            border-radius: 22px;
            background: linear-gradient(145deg, #ffffff 0%, #f8faff 100%);
            box-shadow:
                0 18px 42px rgba(28, 55, 110, .10),
                0 4px 12px rgba(28, 55, 110, .05);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .settings-layout .profile-card:hover {
            transform: translateY(-3px);
            border-color: #c8d6ef;
            box-shadow:
                0 24px 50px rgba(28, 55, 110, .13),
                0 7px 18px rgba(28, 55, 110, .06);
        }

        .settings-layout .profile-cover {
            position: relative;
            height: 96px;
            overflow: hidden;
            background:
                radial-gradient(circle at 82% 18%, rgba(255,255,255,.24), transparent 24%),
                radial-gradient(circle at 12% 110%, rgba(132,174,255,.22), transparent 34%),
                linear-gradient(135deg, #234a9f 0%, #315fc4 52%, #597bd0 100%);
        }

        .settings-layout .profile-cover::before {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            right: -55px;
            top: -100px;
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 50%;
            box-shadow: 0 0 0 22px rgba(255,255,255,.035), 0 0 0 44px rgba(255,255,255,.025);
        }

        .settings-layout .profile-cover::after {
            content: "";
            position: absolute;
            width: 110px;
            height: 110px;
            left: -58px;
            bottom: -78px;
            border: 1px solid rgba(255,255,255,.14);
            border-radius: 50%;
        }

        .settings-layout .profile-body {
            position: relative;
            padding: 0 25px 23px;
        }

        .settings-layout .profile-avatar {
            position: relative;
            z-index: 2;
            width: 94px;
            height: 94px;
            margin: -31px auto 16px;
            border: 5px solid rgba(255,255,255,.96);
            border-radius: 22px;
            background: linear-gradient(145deg, #f8faff 0%, #e8eefb 100%);
            color: #2855b7;
            box-shadow:
                0 12px 28px rgba(29, 61, 126, .16),
                inset 0 0 0 1px rgba(40,85,183,.06);
            font-size: 27px;
            font-weight: 800;
        }

        .settings-layout .profile-name {
            color: #17233b;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -.25px;
            margin-bottom: 5px;
        }

        .settings-layout .profile-username {
            color: #77839a;
            font-size: 12px;
            margin-bottom: 21px;
        }

        .settings-layout .profile-row {
            padding: 14px 2px 2px;
            border-top: 1px solid #e4e9f2;
            font-size: 12px;
        }

        .settings-layout .profile-label {
            color: #7b879b;
            font-weight: 600;
        }

        .settings-layout .profile-value {
            font-weight: 800;
        }

        .settings-layout .role {
            color: #2855b7;
            padding: 5px 10px;
            border-radius: 999px;
            background: #edf3ff;
            border: 1px solid #dce7fb;
        }

        /* option cards */
        .settings-layout .options {
            gap: 17px;
        }

        .settings-layout .option-card {
            position: relative;
            overflow: hidden;
            min-height: 136px;
            padding: 21px;
            border: 1px solid #e0e7f2;
            border-radius: 20px;
            background: linear-gradient(145deg, #ffffff 0%, #fbfcff 100%);
            box-shadow: 0 9px 25px rgba(28, 55, 110, .065);
            transition:
                transform .24s ease,
                box-shadow .24s ease,
                border-color .24s ease,
                background .24s ease;
        }

        .settings-layout .option-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(135deg, rgba(58,101,198,.07), transparent 42%, rgba(58,101,198,.025));
            opacity: .7;
        }

        .settings-layout .option-card:hover {
            transform: translateY(-5px);
            border-color: #bfd0ee;
            background: linear-gradient(145deg, #ffffff 0%, #f6f9ff 100%);
            box-shadow: 0 18px 38px rgba(28, 55, 110, .12);
        }

        .settings-layout .option-icon {
            position: relative;
            z-index: 1;
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: linear-gradient(145deg, #edf3ff 0%, #dfeaff 100%);
            color: #2855b7;
            box-shadow:
                inset 0 0 0 1px rgba(40,85,183,.06),
                0 7px 16px rgba(40,85,183,.07);
            font-size: 20px;
            transition: transform .24s ease, box-shadow .24s ease, background .24s ease;
        }

        .settings-layout .option-card:hover .option-icon {
            transform: translateY(-2px) scale(1.05);
            background: linear-gradient(145deg, #e6efff 0%, #d5e4ff 100%);
            box-shadow:
                inset 0 0 0 1px rgba(40,85,183,.08),
                0 10px 20px rgba(40,85,183,.11);
        }

        .settings-layout .option-content {
            position: relative;
            z-index: 1;
            padding-top: 1px;
        }

        .settings-layout .option-title {
            color: #17233b;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .settings-layout .option-description {
            color: #758198;
            font-size: 11.5px;
            line-height: 1.55;
        }

        .settings-layout .arrow {
            position: relative;
            z-index: 1;
            width: 34px;
            height: 34px;
            margin-top: 1px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9aa5b5;
            font-size: 18px;
            transition: transform .22s ease, color .22s ease, background .22s ease;
        }

        .settings-layout .option-card:hover .arrow {
            transform: translateX(4px);
            color: #2855b7;
            background: #edf3ff;
        }

        /* application card */
        .settings-layout .application-card {
            min-height: 76px;
            padding: 17px;
            border: 1px solid #dce5f2;
            border-radius: 20px;
            background: linear-gradient(145deg, #ffffff 0%, #f7faff 100%);
            box-shadow: 0 10px 26px rgba(28,55,110,.07);
        }

        .settings-layout .application-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(145deg, #edf3ff 0%, #dfeaff 100%);
            color: #2855b7;
            box-shadow: inset 0 0 0 1px rgba(40,85,183,.06);
        }

        .settings-layout .application-name {
            color: #17233b;
            font-size: 13px;
            font-weight: 800;
        }

        .settings-layout .application-version {
            color: #7b879b;
            font-size: 11px;
            margin-top: 4px;
        }

        .settings-layout .logout-btn {
            min-width: 84px;
            height: 40px;
            padding: 0 17px;
            border: 1px solid #ef9aa4;
            border-radius: 11px;
            background: #fff;
            color: #d54857;
            font-size: 11px;
            font-weight: 700;
            box-shadow: 0 5px 13px rgba(213,72,87,.06);
            transition: transform .2s ease, background .2s ease, border-color .2s ease, box-shadow .2s ease;
        }

        .settings-layout .logout-btn:hover {
            transform: translateY(-2px);
            background: #fff7f8;
            border-color: #e97986;
            box-shadow: 0 9px 18px rgba(213,72,87,.10);
        }

        /* modal */
        .modal {
            background: rgba(10, 25, 58, .54);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 20px;
        }

        .modal.show .modal-card {
            animation: settingsModalIn .24s ease-out;
        }

        .modal-card {
            width: 500px;
            max-width: min(500px, calc(100% - 10px));
            overflow: hidden;
            border: 1px solid rgba(220,228,242,.95);
            border-radius: 22px;
            background: linear-gradient(145deg, #ffffff 0%, #f9fbff 100%);
            box-shadow:
                0 30px 80px rgba(8, 27, 69, .24),
                0 8px 25px rgba(8, 27, 69, .12),
                inset 0 1px 0 rgba(255,255,255,.9);
        }

        .modal-header {
            min-height: 68px;
            padding: 18px 22px;
            border-bottom: 1px solid #e5eaf2;
            background: linear-gradient(180deg, rgba(255,255,255,.96), rgba(248,250,255,.88));
        }

        .modal-title {
            color: #17233b;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -.15px;
        }

        .modal-close {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            border-radius: 10px;
            background: transparent;
            color: #7a8494;
            font-size: 20px;
            transition: .2s ease;
        }

        .modal-close:hover {
            border-color: #e1e6ef;
            background: #f1f4fa;
            color: #26344d;
            transform: rotate(3deg);
        }

        .modal-body {
            padding: 24px 22px 21px;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            margin-bottom: 8px;
            color: #344159;
            font-size: 11.5px;
            font-weight: 800;
        }

        .form-group input {
            width: 100%;
            height: 44px;
            padding: 0 13px;
            border: 1px solid #d9e1ed;
            border-radius: 11px;
            background: #f9fbfe;
            color: #26334b;
            font-size: 12px;
            box-shadow: inset 0 1px 2px rgba(20,45,90,.025);
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease, transform .2s ease;
        }

        .form-group input:hover {
            border-color: #c8d5e9;
            background: #fff;
        }

        .form-group input:focus {
            border-color: #86a7e1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(40,85,183,.075), 0 6px 16px rgba(40,85,183,.05);
            transform: translateY(-1px);
        }

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 7px;
            display: grid;
            width: 34px;
            height: 34px;
            padding: 0;
            place-items: center;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #748098;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .password-toggle:hover,
        .password-toggle:focus-visible {
            background: #edf2fa;
            color: #173c91;
            outline: none;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .password-toggle .eye-off-icon,
        .password-toggle.is-visible .eye-icon {
            display: none;
        }

        .password-toggle.is-visible .eye-off-icon {
            display: block;
        }

        body.dark-mode .password-toggle:hover,
        body.dark-mode .password-toggle:focus-visible {
            background: #263751;
            color: #d9e5ff;
        }

        .modal-footer {
            min-height: 70px;
            padding: 14px 22px;
            border-top: 1px solid #e5eaf2;
            background: rgba(248,250,255,.72);
        }

        .modal-btn {
            min-height: 39px;
            padding: 0 17px;
            border: 1px solid #d4dce9;
            border-radius: 10px;
            background: #fff;
            color: #4c586c;
            font-size: 11px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
        }

        .modal-btn:hover {
            transform: translateY(-1px);
            border-color: #c4d0e3;
            background: #f8faff;
            box-shadow: 0 6px 14px rgba(30,58,110,.07);
        }

        .modal-btn-primary {
            min-width: 82px;
            border-color: #234a9f;
            background: linear-gradient(135deg, #315fc4 0%, #234a9f 100%);
            color: #fff;
            box-shadow: 0 8px 18px rgba(40,85,183,.20);
        }

        .modal-btn-primary:hover {
            border-color: #21499d;
            background: linear-gradient(135deg, #3a6dd0 0%, #234a9f 100%);
            color: #fff;
            box-shadow: 0 11px 22px rgba(40,85,183,.25);
        }

        .error {
            color: #cf3e4c;
            font-size: 11px;
            margin-top: 6px;
            font-weight: 600;
        }

        /* preference & information modal */
        .settings-info-list {
            display: grid;
            gap: 11px;
        }

        .settings-info-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            border: 1px solid #e3e9f3;
            border-radius: 13px;
            background: linear-gradient(135deg, #fbfdff 0%, #f5f8fd 100%);
        }

        .settings-info-item-icon {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d7e3fa;
            border-radius: 11px;
            background: #edf3ff;
            color: #2859b8;
        }

        .settings-info-item-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        .settings-info-item-content {
            flex: 1;
            min-width: 0;
        }

        .settings-info-item-title {
            color: #1b2a44;
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .settings-info-item-text {
            color: #71809a;
            font-size: 11px;
            line-height: 1.5;
        }

        .settings-modal-intro {
            margin: 0 0 16px;
            color: #71809a;
            font-size: 11.5px;
            line-height: 1.6;
        }

        .app-about {
            text-align: center;
            padding: 4px 4px 2px;
        }

        .app-about-icon {
            width: 62px;
            height: 62px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d5e2fb;
            border-radius: 18px;
            background: linear-gradient(145deg, #edf4ff, #dfeaff);
            color: #2859b8;
            box-shadow: 0 12px 24px rgba(40,85,183,.10);
        }

        .app-about-icon svg {
            width: 28px;
            height: 28px;
            stroke-width: 1.8;
        }

        .app-about-title {
            color: #17233b;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -.2px;
        }

        .app-about-version {
            display: inline-flex;
            align-items: center;
            margin-top: 7px;
            padding: 5px 10px;
            border: 1px solid #dce6f7;
            border-radius: 999px;
            background: #f3f7ff;
            color: #3562b3;
            font-size: 10.5px;
            font-weight: 700;
        }

        .app-about-description {
            max-width: 390px;
            margin: 15px auto 0;
            color: #6d7c95;
            font-size: 11.5px;
            line-height: 1.65;
        }

        @keyframes settingsModalIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 760px) {
            .settings-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 560px) {
            .settings-layout .options {
                grid-template-columns: 1fr;
            }

            .modal-card {
                border-radius: 18px;
            }

            .modal-body {
                padding: 20px 18px 18px;
            }

            .modal-footer {
                padding: 13px 18px;
            }
        }

        /* Account settings hub — scoped to the main settings content only */
        .settings-layout.settings-hub { display:flex; flex-direction:column; gap:22px; }
        .settings-hub .profile-card {
            display:block; width:100%; min-height:210px; border:1px solid rgba(32,66,132,.22);
            border-radius:24px; background:linear-gradient(112deg,#102a5e 0%,#173d83 52%,#315da7 100%);
            box-shadow:0 20px 46px rgba(20,47,100,.17); cursor:default;
        }
        .settings-hub .profile-cover { position:absolute; inset:0; height:auto; background:radial-gradient(circle at 80% 20%,rgba(168,197,255,.25),transparent 28%),linear-gradient(112deg,#102a5e 0%,#173d83 52%,#315da7 100%); }
        .settings-hub .profile-cover::before { content:""; position:absolute; width:270px; height:270px; right:-68px; top:-176px; border:1px solid rgba(255,255,255,.16); border-radius:50%; box-shadow:0 0 0 24px rgba(255,255,255,.035),0 0 0 50px rgba(255,255,255,.025); }
        .settings-hub .profile-cover::after { content:""; position:absolute; width:150px; height:150px; left:38%; bottom:-126px; border:1px solid rgba(255,255,255,.12); border-radius:50%; }
        .settings-hub .profile-body { position:relative; z-index:1; min-height:210px; display:flex; align-items:center; gap:22px; padding:30px 34px; color:#fff; text-align:left; }
        .settings-hub .profile-avatar { flex:0 0 104px; width:104px; height:104px; margin:0; border:4px solid rgba(255,255,255,.9); border-radius:25px; background:linear-gradient(145deg,#edf3ff,#d7e4ff); color:#214b9a; box-shadow:0 14px 30px rgba(5,20,54,.24); font-size:30px; }
        .settings-hub .profile-avatar img { border-radius:20px; }
        .settings-hub .profile-identity { min-width:0; flex:1; }
        .settings-hub .profile-name { margin:0; color:#fff !important; font-size:25px; font-weight:800; letter-spacing:-.45px; line-height:1.2; }
        .settings-hub .profile-username { margin:7px 0 15px; color:rgba(226,236,255,.78); font-size:13px; }
        .settings-hub .profile-badges { display:flex; align-items:center; gap:9px; flex-wrap:wrap; }
        .settings-hub .role, .settings-hub .account-status { display:inline-flex; align-items:center; gap:6px; min-height:29px; padding:5px 11px; border:1px solid rgba(255,255,255,.24); border-radius:999px; background:rgba(255,255,255,.12); color:#fff; font-size:11px; font-weight:700; backdrop-filter:blur(8px); }
        .settings-hub .account-status { border-color:rgba(167,243,208,.3); color:#d1fae5; background:rgba(16,185,129,.14); }
        .settings-hub .profile-aside { flex:0 0 auto; display:flex; align-items:center; gap:10px; padding:11px 15px; border:1px solid rgba(255,255,255,.18); border-radius:15px; background:rgba(255,255,255,.10); color:#e4edff; font-size:11px; font-weight:700; backdrop-filter:blur(10px); }
        .settings-hub .profile-aside svg { width:17px; height:17px; }
        .settings-hub .settings-panels { width:100%; display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:20px; align-items:stretch; }
        .settings-hub .settings-panel { min-width:0; padding:21px; border:1px solid #e2e8f2; border-radius:21px; background:linear-gradient(145deg,#fff 0%,#fbfcff 100%); box-shadow:0 10px 28px rgba(28,55,110,.06); }
        .settings-hub .settings-panel-heading { display:flex; align-items:center; gap:12px; margin-bottom:17px; }
        .settings-hub .settings-panel-icon { width:42px; height:42px; flex:0 0 42px; display:flex; align-items:center; justify-content:center; border:1px solid #dce7fb; border-radius:13px; background:linear-gradient(145deg,#eff4ff,#e2ebff); color:#315fc4; }
        .settings-hub .settings-panel-icon svg { width:19px; height:19px; }
        .settings-hub .settings-panel-heading h2 { color:#17233b; font-size:15px; font-weight:800; letter-spacing:-.15px; }
        .settings-hub .settings-panel-heading p { margin-top:3px; color:#7a8599; font-size:11px; line-height:1.4; }
        .settings-hub .options { display:flex; flex-direction:column; grid-template-columns:1fr; gap:10px; }
        .settings-hub .option-card { min-height:88px; align-items:center; gap:14px; padding:15px; border:1px solid #e5eaf2; border-radius:16px; background:#fff; box-shadow:0 4px 13px rgba(24,48,94,.035); }
        .settings-hub .option-card::before { opacity:.4; }
        .settings-hub .option-card:hover { transform:translateY(-2px); border-color:#c8d8f3; box-shadow:0 12px 24px rgba(28,55,110,.09); }
        .settings-hub .option-icon { width:44px; height:44px; flex:0 0 44px; border-radius:13px; }
        .settings-hub .option-content { min-width:0; }
        .settings-hub .option-title { margin-bottom:4px; font-size:13px; }
        .settings-hub .option-description { font-size:11px; line-height:1.45; }
        .settings-hub .option-meta { display:inline-flex; align-items:center; gap:5px; margin-top:7px; color:#6d7c95; font-size:10px; font-weight:700; }
        .settings-hub .option-meta svg { width:12px; height:12px; color:#4b73bd; }
        .settings-hub .arrow { width:32px; height:32px; flex:0 0 32px; margin:0; border:1px solid #e5ebf4; border-radius:10px; background:#f8faff; color:#8290a8; font-size:16px; }
        .settings-hub .application-card { grid-column:auto; min-width:0; min-height:82px; margin-top:14px; padding:14px; gap:11px; border:1px solid #e0e7f2; border-radius:16px; background:linear-gradient(135deg,#f8faff,#fff); box-shadow:none; }
        .settings-hub .application-icon { width:42px; height:42px; flex:0 0 42px; border-radius:12px; }
        .settings-hub .application-name { font-size:12px; }
        .settings-hub .application-version { font-size:10.5px; }
        .settings-hub .logout-btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-width:102px; height:38px; padding:0 13px; border:1px solid #efb5bc; border-radius:11px; background:#fff; color:#c33e4c; font-size:11px; font-weight:750; transition:all .2s ease; }
        .settings-hub .logout-btn:hover { transform:translateY(-2px); border-color:#e78c97; background:#fff6f7; box-shadow:0 8px 16px rgba(195,62,76,.09); }
        .settings-hub .logout-btn svg { width:15px; height:15px; }
        body.dark-mode .settings-hub .settings-panel { border-color:#2c3b57; background:linear-gradient(145deg,#18253b,#141f33); box-shadow:0 15px 35px rgba(0,0,0,.18); }
        body.dark-mode .settings-hub .settings-panel-heading h2 { color:#f1f5ff; }
        body.dark-mode .settings-hub .settings-panel-heading p, body.dark-mode .settings-hub .option-meta { color:#9eacc4; }
        body.dark-mode .settings-hub .settings-panel-icon { border-color:#3a5684; background:#20385f; color:#a9c8ff; }
        body.dark-mode .settings-hub .option-meta svg { color:#a9c8ff; }
        @media (max-width:900px) {
            .settings-hub .settings-panels { grid-template-columns:1fr; }
            .settings-hub .profile-aside { display:none; }
        }
        @media (max-width:600px) {
            .settings-hub .profile-card, .settings-hub .profile-body { min-height:0; }
            .settings-hub .profile-body { align-items:flex-start; gap:15px; padding:24px 20px; }
            .settings-hub .profile-avatar { flex-basis:76px; width:76px; height:76px; border-radius:19px; font-size:24px; }
            .settings-hub .profile-avatar img { border-radius:15px; }
            .settings-hub .profile-name { font-size:19px; overflow-wrap:anywhere; }
            .settings-hub .profile-username { margin:5px 0 11px; font-size:11px; }
            .settings-hub .role, .settings-hub .account-status { min-height:26px; padding:4px 8px; font-size:9.5px; }
            .settings-hub .settings-panel { padding:15px; border-radius:17px; }
            .settings-hub .option-card { min-height:80px; padding:12px; gap:10px; }
            .settings-hub .option-icon { width:39px; height:39px; flex-basis:39px; }
            .settings-hub .application-card { flex-wrap:wrap; }
            .settings-hub .application-info { min-width:calc(100% - 60px); }
            .settings-hub .application-card form { width:100%; }
            .settings-hub .logout-btn { width:100%; }
        }

        /* Horizontal account settings tabs (main content only) */
        .settings-page { padding-top:28px; }
        .settings-heading { display:flex; justify-content:space-between; align-items:flex-end; gap:18px; margin-bottom:22px; }
        .settings-eyebrow,.settings-card-kicker { display:block; color:#71809a; font-size:10px; font-weight:800; letter-spacing:1.1px; text-transform:uppercase; }
        .settings-page .page-title { margin:0; font-size:26px; letter-spacing:-.55px; }
        .settings-page .page-subtitle { margin-top:7px; }
        .settings-active-badge { display:inline-flex; align-items:center; gap:7px; padding:9px 13px; border:1px solid #bce8d1; border-radius:999px; background:#ecfbf2; color:#197447; font-size:11px; font-weight:750; white-space:nowrap; }
        .settings-active-badge svg { width:15px; height:15px; }
        .settings-tabs { display:flex; gap:5px; padding:5px; margin:22px 0 18px; overflow-x:auto; border:1px solid #e2e8f1; border-radius:15px; background:#fff; box-shadow:0 5px 18px rgba(23,60,145,.04); scrollbar-width:thin; }
        .settings-tab { position:relative; display:inline-flex; align-items:center; justify-content:center; gap:9px; min-height:46px; padding:0 17px; border:0; border-radius:11px; background:transparent; color:#69758b;  font-size:12px; font-weight:600; white-space:nowrap; cursor:pointer; transition:all .2s ease; }
        .settings-tab svg { width:17px; height:17px; }
        .settings-tab:hover { background:#f4f7fc; color:#244c9f; }
        .settings-tab.active { background:#edf3ff; color:#204ca8; box-shadow:inset 0 0 0 1px #d7e4ff; }
        .settings-tab-panels { min-width:0; }
        .settings-tab-panel { animation:settingsPanelIn .22s ease both; }
        .settings-tab-panel[hidden] { display:none; }
        @keyframes settingsPanelIn { from { opacity:0; transform:translateY(5px); } to { opacity:1; transform:translateY(0); } }
        .settings-form-card,.security-tip-card,.about-settings-card { min-width:0; padding:25px; border:1px solid #e2e8f1; border-radius:20px; background:#fff; box-shadow:0 9px 28px rgba(23,60,145,.055); }
        .tab-card-heading { display:flex; justify-content:space-between; align-items:center; gap:15px; padding-bottom:20px; margin-bottom:20px; border-bottom:1px solid #edf0f5; }
        .tab-card-heading h2 { margin:5px 0 4px; color:#1b2942; font-size:18px; font-weight:800; letter-spacing:-.25px; }
        .tab-card-heading p { color:#7b879a; font-size:12px; }
        .heading-icon { display:grid; place-items:center; width:45px; height:45px; flex:0 0 45px; border:1px solid #dbe7ff; border-radius:14px; background:#eff4ff; color:#315fc4; }
        .heading-icon svg { width:21px; height:21px; }
        .heading-icon-violet { color:#6954bd; background:#f2efff; border-color:#e3dcff; }
        .heading-icon-amber { color:#a56b19; background:#fff7e9; border-color:#f6e5c6; }
        .profile-upload-row { position:relative; display:flex; align-items:center; gap:16px; padding:16px; margin-bottom:21px; border:1px dashed #d8e1ee; border-radius:15px; background:#f9fbfe; }
        .upload-avatar { display:grid; place-items:center; width:76px; height:76px; flex:0 0 76px; overflow:hidden; border:3px solid #fff; border-radius:50%; background:#e8efff; color:#315fc4; box-shadow:0 0 0 1px #dbe5f6,0 5px 14px rgba(30,60,120,.12); font-size:22px; font-weight:800; }
        .upload-avatar img { width:100%; height:100%; object-fit:cover; }
        .upload-copy { display:flex; align-items:flex-start; flex-direction:column; gap:5px; }
        .upload-copy strong { color:#25334c; font-size:13px; }
        .upload-copy p,.upload-hint { color:#7b879a; font-size:11px; }
        .upload-button { display:inline-flex; align-items:center; gap:6px; padding:7px 10px; margin-top:3px; border:1px solid #d7e2f5; border-radius:9px; background:#fff; color:#3155a1; font-size:11px; font-weight:700; cursor:pointer; transition:.18s ease; }
        .upload-button:hover { border-color:#a9c0ea; background:#f1f6ff; }
        .upload-button svg { width:14px; height:14px; }
        .visually-hidden-file { position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; clip-path:inset(50%); }
        .settings-form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
        .settings-page .form-group { display:flex; min-width:0; flex-direction:column; gap:8px; margin-bottom:16px; }
        .settings-page .form-group label { color:#38465d; font-size:12px; font-weight:700; }
        .settings-page .form-group input { width:100%; min-height:44px; padding:10px 13px; border:1px solid #d5dce7; border-radius:11px; outline:none; background:#fff; color:#1e293b;  font-size:13px; font-weight:400; transition:border-color .18s ease,box-shadow .18s ease; }
        .settings-page .form-group input:focus { border-color:#4c78d0; box-shadow:0 0 0 3px rgba(76,120,208,.13); }
        .settings-page .readonly-field { display:flex; align-items:center; gap:8px; min-height:44px; padding:10px 13px; border:1px solid #e2e8f0; border-radius:11px; background:#f7f9fc; color:#66748b; font-size:12px; }
        .readonly-field svg { width:15px; height:15px; color:#5675b7; }
        .settings-form-actions { display:flex; justify-content:flex-end; gap:10px; padding-top:17px; margin-top:3px; border-top:1px solid #edf0f5; }
        .settings-button { display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:42px; padding:0 17px; border:1px solid transparent; border-radius:11px; font-size:12px; font-weight:700; cursor:pointer; transition:all .2s ease; }
        .settings-button svg { width:16px; height:16px; }
        .settings-button-light { border-color:#dce3ee; background:#fff; color:#56647a; }
        .settings-button-light:hover { background:#f7f9fc; border-color:#cbd5e1; }
        .settings-button-primary { background:#2563eb; color:#fff; box-shadow:0 5px 12px rgba(37,99,235,.16); }
        .settings-button-primary:hover { transform:translateY(-1px); background:#1d4ed8; box-shadow:0 8px 16px rgba(37,99,235,.22); }
        .settings-button-logout { margin-top:22px; border-color:#efb2bb; background:#fff; color:#bf3f4e; }
        .settings-button-logout:hover { background:#fff5f6; border-color:#e58b96; }
        .security-grid { display:grid; grid-template-columns:minmax(0,1.55fr) minmax(230px,.8fr); align-items:stretch; gap:18px; }
        .security-tip-card { display:flex; align-items:flex-start; flex-direction:column; justify-content:center; background:linear-gradient(145deg,#f4f7ff,#fff); }
        .security-tip-icon { display:grid; place-items:center; width:45px; height:45px; margin-bottom:18px; border-radius:14px; background:#e7efff; color:#315fc4; }
        .security-tip-icon svg { width:22px; height:22px; }
        .security-tip-card h3 { margin:8px 0; color:#20304d; font-size:17px; }
        .security-tip-card p { color:#6f7d94; font-size:12px; line-height:1.7; }
        .security-tip-note { display:flex; align-items:flex-start; gap:8px; padding-top:16px; margin-top:18px; border-top:1px solid #e1e8f4; color:#60718d; font-size:10.5px; line-height:1.5; }
        .security-tip-note svg { width:15px; height:15px; flex:0 0 15px; color:#5275bd; }
        .preference-section-label { margin:0 0 11px; color:#47556c; font-size:12px; font-weight:750; }
        .preference-choice-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px; }
        .settings-page .theme-choice { display:flex; align-items:center; gap:13px; min-height:91px; padding:15px; border:1px solid #e2e8f0; border-radius:14px; background:#fff; text-align:left; cursor:pointer; }
        .settings-page .settings-info-item-icon { display:grid; place-items:center; width:40px; height:40px; flex:0 0 40px; border:1px solid #dce7fb; border-radius:12px; background:#eff4ff; color:#315fc4; }
        .settings-page .settings-info-item-icon svg { width:19px; height:19px; }
        .settings-page .settings-info-item-content { display:flex; flex-direction:column; gap:5px; }
        .settings-page .settings-info-item-title { color:#27364f; font-size:12px; font-weight:750; }
        .settings-page .settings-info-item-text { color:#7a879a; font-size:11px; line-height:1.45; }
        .settings-page .theme-choice.active { border-color:#6e91d8; background:#f1f5ff; }
        .preference-status { padding:11px 13px; margin-top:12px; border:1px dashed #d8e2f1; border-radius:11px; background:#f8faff; color:#75829a; font-size:11px; }
        .preference-status strong { color:#3155a1; }
        .settings-responsive-choice { display:flex; align-items:center; gap:12px; min-height:76px; padding:14px 66px 14px 14px !important; margin-top:20px; border:1px solid #e2e8f0; border-radius:14px; background:#fff; }
        .responsive-choice-icon { display:grid; place-items:center; width:40px; height:40px; flex:0 0 40px; border-radius:12px; background:#edf7f5; color:#258472; }
        .responsive-choice-icon svg { width:19px; height:19px; }
        .about-settings-card { display:flex; align-items:center; flex-direction:column; max-width:760px; margin:0 auto; padding:36px; text-align:center; }
        .about-brand-icon { display:grid; place-items:center; width:66px; height:66px; margin-bottom:15px; border:1px solid #dbe6fb; border-radius:20px; background:linear-gradient(145deg,#eef4ff,#e2ebff); color:#315fc4; }
        .about-brand-icon svg { width:31px; height:31px; }
        .about-settings-card h2 { margin:8px 0 10px; color:#1c2b48; font-size:24px; letter-spacing:.2px; }
        .about-settings-card .app-about-version { padding:6px 11px; border:1px solid #d7e4fb; border-radius:999px; background:#eef4ff; color:#3155a1; font-size:11px; font-weight:750; }
        .about-settings-card .app-about-description { max-width:560px; margin:17px 0; color:#708097; font-size:12px; line-height:1.7; }
        .about-details { display:flex; justify-content:center; flex-wrap:wrap; gap:9px; }
        .about-details span { display:inline-flex; align-items:center; gap:6px; padding:8px 10px; border:1px solid #e5eaf2; border-radius:9px; background:#fafbfd; color:#62718a; font-size:10.5px; }
        .about-details svg { width:14px; height:14px; color:#5575b8; }
        body.dark-mode .settings-form-card, body.dark-mode .security-tip-card, body.dark-mode .about-settings-card, body.dark-mode .settings-tabs { border-color:#2c3b57; background:#172238; box-shadow:0 12px 30px rgba(0,0,0,.16); }
        body.dark-mode .tab-card-heading { border-bottom-color:#30405b; }
        body.dark-mode .tab-card-heading h2, body.dark-mode .security-tip-card h3, body.dark-mode .about-settings-card h2 { color:#f1f5ff; }
        body.dark-mode .tab-card-heading p, body.dark-mode .upload-copy p, body.dark-mode .upload-hint, body.dark-mode .security-tip-card p, body.dark-mode .about-settings-card .app-about-description { color:#9eacc4; }
        body.dark-mode .settings-page .form-group label, body.dark-mode .preference-section-label { color:#c4cee0; }
        body.dark-mode .settings-page .form-group input { border-color:#344560; background:#111c2e; color:#edf3ff; }
        body.dark-mode .settings-page .readonly-field, body.dark-mode .profile-upload-row, body.dark-mode .settings-page .theme-choice, body.dark-mode .settings-responsive-choice { border-color:#30405b; background:#142137; color:#c4cee0; }
        body.dark-mode .settings-page .settings-info-item-title { color:#e4ebf8; }
        body.dark-mode .settings-page .settings-info-item-text { color:#9eacc4; }
        body.dark-mode .preference-status { border-color:#354560; background:#162238; color:#9eacc4; }
        body.dark-mode .preference-status strong { color:#b4ccff; }
        body.dark-mode .about-details span { border-color:#30405b; background:#142137; color:#b8c4d8; }
        body.dark-mode .settings-button-light { border-color:#394a65; background:#1b2940; color:#d0d8e8; }
        body.dark-mode .settings-button-logout { border-color:#d96876; background:#211d28; color:#ff9ba5; }
        @media (max-width:900px) { .settings-tabs { justify-content:flex-start; } .security-grid { grid-template-columns:1fr; } .security-tip-card { min-height:210px; } }
        @media (max-width:650px) { .settings-page { padding:20px 15px; } .settings-heading { align-items:flex-start; flex-direction:column; } .settings-page .page-title { font-size:22px; } .settings-active-badge { align-self:flex-start; } .settings-tabs { margin-top:18px; } .settings-tab { min-height:42px; padding:0 12px; font-size:11px; } .settings-form-card,.security-tip-card { padding:17px; border-radius:16px; } .settings-form-grid,.preference-choice-grid { grid-template-columns:1fr; gap:0; } .profile-upload-row { align-items:flex-start; padding:13px; } .upload-avatar { width:60px; height:60px; flex-basis:60px; font-size:18px; } .settings-form-actions { flex-direction:column-reverse; } .settings-form-actions .settings-button { width:100%; } .about-settings-card { padding:25px 18px; } .about-details { flex-direction:column; width:100%; } .about-details span { justify-content:center; } }

        /* Premium visual treatment for settings content only */
        .settings-page { position:relative; isolation:isolate; background:radial-gradient(ellipse at 88% 2%,rgba(99,143,225,.10),transparent 30%),linear-gradient(180deg,rgba(242,246,252,.72),rgba(247,249,252,.92)); border-radius:28px 28px 0 0; }
        .settings-page::before { content:""; position:absolute; z-index:-1; inset:0; pointer-events:none; border-radius:inherit; background:radial-gradient(circle at 8% 34%,rgba(194,213,247,.12),transparent 25%); }
        .settings-heading { align-items:center; }
        .settings-eyebrow { margin-bottom:7px; color:#7890b6; }
        .settings-active-badge { position:relative; gap:9px; padding:10px 15px; border-color:rgba(127,205,165,.35); background:rgba(235,250,242,.78); box-shadow:0 5px 18px rgba(31,140,88,.06),inset 0 1px rgba(255,255,255,.8); backdrop-filter:blur(10px); }
        .settings-active-badge svg { color:#24935d; }
        .settings-active-badge::before { content:""; width:7px; height:7px; border-radius:50%; background:#22a565; box-shadow:0 0 0 3px rgba(34,165,101,.12); animation:statusPulse 2.2s ease-in-out infinite; }
        @keyframes statusPulse { 0%,100% { box-shadow:0 0 0 3px rgba(34,165,101,.12); } 50% { box-shadow:0 0 0 6px rgba(34,165,101,.04); } }
        .settings-tabs { width:max-content; max-width:100%; gap:3px; padding:6px; border:1px solid rgba(220,227,237,.8); border-radius:17px; background:rgba(236,240,246,.88); box-shadow:inset 0 1px 2px rgba(30,48,78,.035); backdrop-filter:blur(12px); }
        .settings-tab { min-height:43px; padding:0 16px; border-radius:12px; color:#68758a; font-weight:600; }
        .settings-tab:hover { background:rgba(255,255,255,.58); color:#243754; }
        .settings-tab.active { color:#285dbb; background:#fff; box-shadow:0 3px 10px rgba(30,55,100,.09),inset 0 0 0 1px rgba(228,234,244,.7); }
        .settings-tab.active svg { color:#3569c4; }
        .settings-form-card,.security-tip-card,.about-settings-card { overflow:hidden; border-color:rgba(218,226,238,.9); border-radius:22px; box-shadow:0 14px 40px rgba(34,55,94,.075),0 2px 8px rgba(34,55,94,.035); }
        .tab-card-heading { margin:-25px -25px 0; padding:23px 25px 17px; border-bottom:0; background:linear-gradient(180deg,#fff,#fbfcfe); }
        .tab-card-heading h2 { font-size:19px; }
        .tab-card-heading p { font-size:12px; }
        .heading-icon { border-radius:15px; box-shadow:0 5px 14px rgba(49,95,196,.08); }
        .profile-cover-banner { position:relative; min-height:172px; overflow:visible; margin:0 -25px; background:linear-gradient(112deg,#10244d 0%,#17396f 52%,#315d9c 100%); }
        .profile-cover-banner::before,.profile-cover-banner::after { position:absolute; content:""; border:1px solid rgba(219,233,255,.16); border-radius:50%; pointer-events:none; }
        .profile-cover-banner::before { width:310px; height:310px; right:-76px; top:-188px; box-shadow:0 0 0 24px rgba(255,255,255,.035),0 0 0 52px rgba(255,255,255,.025); }
        .profile-cover-banner::after { width:210px; height:210px; left:42%; bottom:-167px; }
        .profile-cover-art { position:absolute; inset:0; background:radial-gradient(ellipse at 90% 8%,rgba(138,180,255,.24),transparent 32%),linear-gradient(115deg,transparent 35%,rgba(134,171,238,.08)); }
        .cover-profile-row { position:relative; z-index:1; display:flex; align-items:center; gap:19px; min-height:172px; padding:21px 29px 33px; }
        .upload-avatar { position:relative; width:94px; height:94px; flex:0 0 94px; overflow:visible; border:4px solid #fff; background:linear-gradient(145deg,#edf3ff,#dbe7ff); color:#2855a7; box-shadow:0 9px 25px rgba(3,16,44,.25),0 0 0 1px rgba(255,255,255,.3); font-size:26px; transform:translateY(19px); }
        .upload-avatar img { display:block; width:100%; height:100%; border-radius:50%; object-fit:cover; }
        .upload-avatar > span { display:grid; width:100%; height:100%; place-items:center; }
        .avatar-camera { position:absolute; right:-3px; bottom:-2px; display:grid; width:31px; height:31px; place-items:center; border:3px solid #183d75; border-radius:50%; background:#fff; color:#315fc4; cursor:pointer; box-shadow:0 3px 9px rgba(2,15,39,.18); transition:.2s ease; }
        .avatar-camera:hover { transform:scale(1.08); background:#edf4ff; }
        .avatar-camera svg { width:14px; height:14px; }
        .cover-identity { display:flex; min-width:0; flex-direction:column; gap:7px; color:#fff; }
        .cover-eyebrow { color:rgba(216,231,255,.7); font-size:9px; font-weight:800; letter-spacing:1.3px; }
        .cover-identity > strong { overflow-wrap:anywhere; font-size:20px; font-weight:800; letter-spacing:-.25px; }
        .cover-badges { display:flex; flex-wrap:wrap; gap:7px; }
        .cover-badges span { display:inline-flex; align-items:center; gap:5px; padding:5px 9px; border:1px solid rgba(255,255,255,.2); border-radius:999px; background:rgba(255,255,255,.11); color:#eef4ff; font-size:10px; font-weight:650; backdrop-filter:blur(9px); }
        .cover-badges svg { width:12px; height:12px; }
        .profile-upload-tools { display:flex; align-items:center; justify-content:flex-end; gap:12px; min-height:74px; padding:13px 4px 15px; border-bottom:1px solid #edf1f6; }
        .upload-copy { align-items:flex-end; flex-direction:row; flex-wrap:wrap; justify-content:flex-end; gap:6px 10px; text-align:right; }
        .upload-copy strong { color:#273650; font-size:11px; }
        .upload-copy p { width:100%; }
        .upload-button { padding:7px 10px; margin:0; border-color:#dbe5f3; background:#f9fbff; }
        .delete-photo-button { margin-left:8px; cursor:pointer; color:#b42318; }
        .upload-hint { font-size:10px; }
        .settings-form-section { padding-top:20px; }
        .form-section-heading { display:flex; align-items:center; gap:11px; margin-bottom:15px; }
        .form-section-heading > div { display:flex; flex-direction:column; gap:3px; }
        .form-section-heading strong { color:#283750; font-size:12px; font-weight:800; }
        .form-section-heading span:not(.section-heading-icon) { color:#8995a7; font-size:10.5px; }
        .section-heading-icon { display:grid; width:32px; height:32px; flex:0 0 32px; place-items:center; border:1px solid #dfe8f9; border-radius:10px; background:#f0f5ff; color:#4269b2; }
        .section-heading-icon svg { width:16px; height:16px; }
        .section-heading-icon-teal { border-color:#d8efe9; background:#effaf7; color:#298574; }
        .settings-form-section .settings-form-grid { gap:15px; }
        .institutional-section { padding:16px 15px 1px; margin-top:3px; border:1px solid #e8edf4; border-radius:15px; background:linear-gradient(145deg,#fafbfd,#f7f9fc); }
        .settings-page .form-group { gap:7px; margin-bottom:14px; }
        .settings-page .form-group input { background:#f8fafc; border-color:#e0e6ef; border-radius:12px; }
        .settings-page .form-group input:hover { border-color:#cbd7e8; }
        .settings-page .form-group input:focus { background:#fff; border-color:#4b77cf; box-shadow:0 0 0 3px rgba(59,109,207,.13); }
        .settings-page .form-group input[type="file"] { display:none; }
        .readonly-field { position:relative; padding-right:108px !important; border-color:#e5eaf1 !important; background:#f1f4f8 !important; }
        .verified-tag { position:absolute; right:8px; display:inline-flex; align-items:center; padding:4px 7px; border:1px solid #dce7f3; border-radius:999px; background:#fff; color:#74839a; font-size:9px; font-weight:750; white-space:nowrap; }
        .settings-form-actions { position:sticky; z-index:2; bottom:-25px; margin:17px -25px -25px; padding:14px 25px 18px; border-top:1px solid rgba(224,231,240,.86); background:rgba(255,255,255,.94); box-shadow:0 -8px 20px rgba(30,50,88,.035); backdrop-filter:blur(12px); }
        .settings-button { min-height:43px; border-radius:12px; }
        .settings-button-primary { padding:0 21px; background:linear-gradient(105deg,#2563eb,#4f46e5); box-shadow:0 8px 18px rgba(59,96,220,.21); }
        .settings-button-primary:hover { background:linear-gradient(105deg,#1d4ed8,#4338ca); box-shadow:0 10px 22px rgba(59,96,220,.27); }
        .settings-button-primary:active { transform:scale(.97); }
        .security-tip-card { position:relative; overflow:hidden; background:radial-gradient(circle at 100% 0%,rgba(110,151,226,.15),transparent 36%),linear-gradient(145deg,#f6f8ff,#fff); }
        .security-tip-card::after { position:absolute; right:-50px; bottom:-80px; width:190px; height:190px; border:1px solid rgba(75,115,190,.12); border-radius:50%; content:""; box-shadow:0 0 0 22px rgba(75,115,190,.035); pointer-events:none; }
        .security-tip-note { padding:12px; border:1px solid #e1e9f6; border-radius:12px; background:rgba(255,255,255,.72); }
        .settings-page .theme-choice { background:linear-gradient(145deg,#fff,#f8faff); box-shadow:0 5px 14px rgba(30,55,100,.04); }
        .settings-page .theme-choice:hover { transform:translateY(-2px); }
        .settings-page .theme-choice.active { border-color:#8da9df; background:linear-gradient(135deg,#f2f6ff,#fff); box-shadow:0 8px 20px rgba(47,91,170,.1),0 0 0 3px rgba(77,115,200,.07); }
        .settings-responsive-choice { box-shadow:0 5px 14px rgba(30,55,100,.04); }
        .about-settings-card { position:relative; overflow:hidden; background:radial-gradient(circle at 50% -5%,rgba(90,135,216,.14),transparent 35%),linear-gradient(145deg,rgba(255,255,255,.98),rgba(247,250,255,.94)); }
        .about-settings-card::before { position:absolute; top:0; right:0; left:0; height:5px; background:linear-gradient(90deg,#1e3a8a,#3b82f6,#818cf8); content:""; }
        .about-brand-icon { border-radius:19px; background:rgba(235,242,255,.76); box-shadow:inset 0 1px rgba(255,255,255,.95),0 10px 24px rgba(50,90,160,.1); backdrop-filter:blur(8px); }
        body.dark-mode .settings-page { background:radial-gradient(ellipse at 88% 2%,rgba(60,96,166,.15),transparent 30%),#111c2e; }
        body.dark-mode .tab-card-heading { background:linear-gradient(180deg,#172238,#172238); }
        body.dark-mode .settings-active-badge { border-color:#24573f; background:rgba(22,73,50,.55); color:#a8edc5; }
        body.dark-mode .profile-upload-tools { border-bottom-color:#30405b; }
        body.dark-mode .upload-copy strong, body.dark-mode .form-section-heading strong { color:#e3eaf6; }
        body.dark-mode .form-section-heading span:not(.section-heading-icon) { color:#9eacc4; }
        body.dark-mode .institutional-section { border-color:#30405b; background:linear-gradient(145deg,#142137,#172238); }
        body.dark-mode .readonly-field { border-color:#30405b !important; background:#1c2a40 !important; color:#b8c4d8; }
        body.dark-mode .verified-tag { border-color:#384b67; background:#24334b; color:#b2bfd4; }
        body.dark-mode .settings-form-actions { border-top-color:#30405b; background:rgba(23,34,56,.95); }
        body.dark-mode .security-tip-card { background:radial-gradient(circle at 100% 0%,rgba(75,111,177,.18),transparent 36%),linear-gradient(145deg,#18253b,#141f33); }
        body.dark-mode .security-tip-note { border-color:#30405b; background:rgba(20,33,55,.8); }
        @media (max-width:650px) {
            .settings-page { border-radius:20px 20px 0 0; }
            .settings-tabs { width:100%; gap:2px; }
            .settings-tab { flex:0 0 auto; padding:0 12px; }
            .tab-card-heading { margin:-17px -17px 0; padding:18px 17px 14px; }
            .profile-cover-banner { margin:0 -17px; }
            .cover-profile-row { gap:13px; padding:20px 17px 29px; }
            .upload-avatar { width:76px; height:76px; flex-basis:76px; font-size:21px; }
            .cover-identity > strong { font-size:17px; }
            .profile-upload-tools { min-height:80px; }
            .upload-copy { align-items:flex-start; justify-content:flex-start; text-align:left; }
            .upload-copy p { width:auto; }
            .settings-form-section .settings-form-grid { gap:0; }
            .institutional-section { padding:13px 11px 1px; }
            .settings-form-actions { bottom:-17px; margin:15px -17px -17px; padding:12px 17px 15px; }
            .settings-form-actions .settings-button { flex:1; padding:0 10px; }
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .alert-success {
            background: #eaf8f0;
            color: #16894a;
            border: 1px solid #b8ebd0;
        }

        .alert-danger {
            background: #fff0f0;
            color: #d64545;
            border: 1px solid #ffccd0;
        }

        body.dark-mode .alert-success {
            background: #173b2b !important;
            color: #a7edc2 !important;
            border-color: #2b7250 !important;
        }

        body.dark-mode .alert-danger {
            background: #3c2028 !important;
            color: #ffd0d6 !important;
            border-color: #74414c !important;
        }
    </style>

    @include('partials.theme')
</head>

<body>

<div class="layout">

    {{-- sidebar --}}

    @include('layouts.sidebar')

    {{-- main --}}

    <main class="main">

        {{-- topbar --}}

        <header class="topbar">

            <div class="topbar-right">

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
                            {{ auth()->user()->nama ?? 'Guru BK' }}
                        </div>

                        <div class="profile-role">
                            {{ auth()->user()->role ?? 'User' }}
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

        <section class="content settings-page">
            <div class="settings-heading">
                <div>
                    <p class="settings-eyebrow">Pusat Pengaturan</p>
                    <h1 class="page-title">Pengaturan Akun &amp; Sistem</h1>
                    <p class="page-subtitle">Kelola identitas, keamanan, dan tampilan akun SIRASI-BK Anda.</p>
                </div>
                <span class="settings-active-badge"><i data-lucide="circle-check"></i>Status Akun: Aktif</span>
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="status">
                    <i data-lucide="check-circle-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <i data-lucide="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="settings-tabs" role="tablist" aria-label="Pengaturan akun dan sistem">
                <button class="settings-tab active" id="profileTab" type="button" role="tab" aria-selected="true" aria-controls="profilePanel" data-tab="profilePanel"><i data-lucide="user-round"></i><span>Profil &amp; Biodata</span></button>
                <button class="settings-tab" id="securityTab" type="button" role="tab" aria-selected="false" aria-controls="securityPanel" data-tab="securityPanel"><i data-lucide="lock-keyhole"></i><span>Keamanan &amp; Kata Sandi</span></button>
                <button class="settings-tab" id="preferencesTab" type="button" role="tab" aria-selected="false" aria-controls="preferencesPanel" data-tab="preferencesPanel"><i data-lucide="sliders-horizontal"></i><span>Preferensi Tampilan</span></button>
                <button class="settings-tab" id="aboutTab" type="button" role="tab" aria-selected="false" aria-controls="aboutPanel" data-tab="aboutPanel"><i data-lucide="info"></i><span>Tentang Aplikasi</span></button>
            </div>

            <div class="settings-tab-panels">
                <section class="settings-tab-panel active" id="profilePanel" role="tabpanel" aria-labelledby="profileTab">
                    <form id="deleteProfilePhotoForm" action="{{ route('pengaturan.profil.photo.delete') }}" method="POST" onsubmit="return confirm('Hapus foto profil Anda?')">
                        @csrf
                        @method('DELETE')
                    </form>
                    <form class="settings-form-card" action="{{ route('pengaturan.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="tab-card-heading"><div><span class="settings-card-kicker">IDENTITAS AKUN</span><h2>Profil &amp; Biodata</h2><p>Pastikan informasi akun Anda selalu terbaru.</p></div><span class="heading-icon"><i data-lucide="contact-round"></i></span></div>

                        <div class="profile-cover-banner">
                            <div class="profile-cover-art" aria-hidden="true"></div>
                            <div class="cover-profile-row">
                                <div class="upload-avatar" id="profilePreview">
                                    @if ($user->foto_profil)
                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil {{ $user->nama }}">
                                    @else
                                        <span>{{ strtoupper(substr($user->nama, 0, 2)) }}</span>
                                    @endif
                                    <label for="settingsPhoto" class="avatar-camera" aria-label="Unggah foto profil"><i data-lucide="camera"></i></label>
                                </div>
                                <div class="cover-identity">
                                    <span class="cover-eyebrow">AKUN SIRASI-BK</span>
                                    <strong>{{ $user->nama }}</strong>
                                    <div class="cover-badges"><span><i data-lucide="shield-check"></i>{{ $user->role }}</span><span><i data-lucide="circle-check"></i>Akun aktif</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-upload-tools">
                            <div class="upload-copy"><strong>Foto Profil</strong><p>Gunakan foto yang jelas agar mudah dikenali.</p><label for="settingsPhoto" class="upload-button"><i data-lucide="upload"></i>Unggah Foto Baru</label>@if ($user->foto_profil) <button type="submit" form="deleteProfilePhotoForm" class="upload-button delete-photo-button"><i data-lucide="trash-2"></i>Hapus Foto</button> @endif<span class="upload-hint">JPG, PNG, atau WebP · Maks. 2 MB</span></div>
                            <input class="visually-hidden-file" id="settingsPhoto" type="file" name="foto_profil" accept=".jpg,.jpeg,.png,.webp">
                            @error('foto_profil')<div class="error">{{ $message }}</div>@enderror
                        </div>

                        <div class="settings-form-section">
                            <div class="form-section-heading"><span class="section-heading-icon"><i data-lucide="user-round"></i></span><div><strong>Informasi Pribadi</strong><span>Data identitas yang digunakan pada akun Anda.</span></div></div>
                            <div class="settings-form-grid">
                                <div class="form-group"><label for="settingsNama">Nama Lengkap</label><input id="settingsNama" type="text" name="nama" value="{{ old('nama', $user->nama) }}" autocomplete="name" required>@error('nama')<div class="error">{{ $message }}</div>@enderror</div>
                                <div class="form-group"><label for="settingsUsername">Username</label><input id="settingsUsername" type="text" name="username" value="{{ old('username', $user->username) }}" autocomplete="username" required>@error('username')<div class="error">{{ $message }}</div>@enderror</div>
                            </div>
                        </div>
                        <div class="settings-form-section institutional-section">
                            <div class="form-section-heading"><span class="section-heading-icon section-heading-icon-teal"><i data-lucide="school"></i></span><div><strong>Data Institusi</strong><span>Informasi institusi dan hak akses akun.</span></div></div>
                            <div class="settings-form-grid">
                                <div class="form-group"><label>Peran / Hak Akses</label><div class="readonly-field"><i data-lucide="shield-check"></i>{{ $user->role }}<span class="verified-tag">Terverifikasi</span></div></div>
                                <div class="form-group"><label>Satuan Pendidikan</label><div class="readonly-field"><i data-lucide="school"></i>SMP Negeri 2 Dramaga<span class="verified-tag">Terkunci</span></div></div>
                            </div>
                        </div>
                        <div class="settings-form-actions"><button type="reset" class="settings-button settings-button-light">Batal / Reset</button><button type="submit" class="settings-button settings-button-primary">Simpan Perubahan</button></div>
                    </form>
                </section>

                <section class="settings-tab-panel" id="securityPanel" role="tabpanel" aria-labelledby="securityTab" hidden>
                    <div class="security-grid">
                        <form class="settings-form-card" action="{{ route('pengaturan.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="tab-card-heading"><div><span class="settings-card-kicker">PERLINDUNGAN AKUN</span><h2>Ubah Kata Sandi</h2><p>Pilih kata sandi kuat yang tidak digunakan di tempat lain.</p></div><span class="heading-icon heading-icon-violet"><i data-lucide="key-round"></i></span></div>
                            <div class="form-group"><label for="password_lama">Password Saat Ini</label><div class="password-field"><input id="password_lama" type="password" name="password_lama" autocomplete="current-password" required><button type="button" class="password-toggle" aria-label="Tampilkan Password Lama" aria-pressed="false" onclick="togglePasswordVisibility('password_lama', this)"><svg class="eye-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg><svg class="eye-off-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.2A10.7 10.7 0 0 1 12 5c6.4 0 10 7 10 7s-3.6 7-10 7a10 10 0 0 1-4-.8"/></svg></button></div>@error('password_lama')<div class="error">{{ $message }}</div>@enderror</div>
                            <div class="form-group"><label for="password_baru">Password Baru</label><div class="password-field"><input id="password_baru" type="password" name="password_baru" autocomplete="new-password" required><button type="button" class="password-toggle" aria-label="Tampilkan Password Baru" aria-pressed="false" onclick="togglePasswordVisibility('password_baru', this)"><svg class="eye-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg><svg class="eye-off-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.2A10.7 10.7 0 0 1 12 5c6.4 0 10 7 10 7s-3.6 7-10 7a10 10 0 0 1-4-.8"/></svg></button></div>@error('password_baru')<div class="error">{{ $message }}</div>@enderror</div>
                            <div class="form-group"><label for="password_baru_confirmation">Konfirmasi Password Baru</label><div class="password-field"><input id="password_baru_confirmation" type="password" name="password_baru_confirmation" autocomplete="new-password" required><button type="button" class="password-toggle" aria-label="Tampilkan Konfirmasi Password Baru" aria-pressed="false" onclick="togglePasswordVisibility('password_baru_confirmation', this)"><svg class="eye-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg><svg class="eye-off-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.2A10.7 10.7 0 0 1 12 5c6.4 0 10 7 10 7s-3.6 7-10 7a10 10 0 0 1-4-.8"/></svg></button></div>@error('password_baru_confirmation')<div class="error">{{ $message }}</div>@enderror</div>
                            <div class="settings-form-actions"><button type="reset" class="settings-button settings-button-light">Batal / Reset</button><button type="submit" class="settings-button settings-button-primary"><i data-lucide="key-round"></i>Perbarui Password</button></div>
                        </form>
                        <aside class="security-tip-card"><span class="security-tip-icon"><i data-lucide="shield-check"></i></span><span class="settings-card-kicker">TIPS KEAMANAN</span><h3>Jaga akun tetap aman</h3><p>Gunakan kombinasi huruf, angka, dan simbol. Hindari nama atau tanggal yang mudah ditebak, dan jangan bagikan kata sandi Anda kepada orang lain.</p><div class="security-tip-note"><i data-lucide="lock-keyhole"></i><span>Kata sandi baru akan digunakan setelah perubahan berhasil disimpan.</span></div></aside>
                    </div>
                </section>

                <section class="settings-tab-panel" id="preferencesPanel" role="tabpanel" aria-labelledby="preferencesTab" hidden>
                    <div class="settings-form-card"><div class="tab-card-heading"><div><span class="settings-card-kicker">PENGALAMAN PENGGUNA</span><h2>Preferensi Tampilan</h2><p>Pilihan ini tersimpan pada browser yang sedang Anda gunakan.</p></div><span class="heading-icon heading-icon-amber"><i data-lucide="sliders-horizontal"></i></span></div>
                        <div class="preference-section-label">Tema antarmuka</div>
                        <div class="preference-choice-grid"><button type="button" class="settings-info-item theme-choice" data-theme-choice="light" onclick="setTheme('light')"><span class="settings-info-item-icon"><i data-lucide="sun"></i></span><span class="settings-info-item-content"><strong class="settings-info-item-title">Tampilan Terang</strong><span class="settings-info-item-text">Antarmuka cerah untuk penggunaan sehari-hari.</span></span></button><button type="button" class="settings-info-item theme-choice" data-theme-choice="dark" onclick="setTheme('dark')"><span class="settings-info-item-icon"><i data-lucide="moon"></i></span><span class="settings-info-item-content"><strong class="settings-info-item-title">Tampilan Gelap</strong><span class="settings-info-item-text">Warna redup untuk penggunaan di lingkungan minim cahaya.</span></span></button></div>
                        <div class="preference-status">Tema aktif: <strong id="currentThemeLabel">Tampilan Terang</strong></div>
                        <div class="responsive-choice settings-responsive-choice" id="responsiveChoice" onclick="toggleResponsive()" role="button" tabindex="0" aria-label="Aktifkan atau nonaktifkan tampilan responsif"><span class="responsive-choice-icon"><i data-lucide="monitor-smartphone"></i></span><span class="settings-info-item-content"><strong class="settings-info-item-title">Tampilan Responsif</strong><span class="settings-info-item-text" id="responsiveDescription">Tampilan menyesuaikan ukuran layar agar tetap nyaman digunakan pada perangkat yang berbeda.</span></span><span class="responsive-toggle" aria-hidden="true"></span></div>
                        <div class="preference-status">Tampilan responsif: <strong id="responsiveStatusLabel">Aktif</strong></div>
                    </div>
                </section>

                <section class="settings-tab-panel" id="aboutPanel" role="tabpanel" aria-labelledby="aboutTab" hidden>
                    <div class="about-settings-card"><div class="about-brand-icon"><i data-lucide="graduation-cap"></i></div><span class="settings-card-kicker">SISTEM INFORMASI SEKOLAH</span><h2>SIRASI-BK</h2><span class="app-about-version">Version 1.0.0</span><p class="app-about-description">Sistem Informasi Riwayat Siswa untuk membantu pengelolaan data Bimbingan dan Konseling secara lebih terstruktur, rapi, dan mudah digunakan.</p><div class="about-details"><span><i data-lucide="school"></i> SMP Negeri 2 Dramaga</span><span><i data-lucide="shield-check"></i> Layanan Bimbingan &amp; Konseling</span></div><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="settings-button settings-button-logout"><i data-lucide="log-out"></i>Keluar</button></form></div>
                </section>
            </div>
        </section>

    </main>

</div>

<script>

    function openModal(id)
    {
        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id)
    {
        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    function applyTheme(theme)
    {
        document.documentElement.classList.toggle('dark-mode', theme === 'dark');
        document.body.classList.toggle('dark-mode', theme === 'dark');

        const label = document.getElementById('currentThemeLabel');

        if (label) {
            label.textContent = theme === 'dark' ? 'Tampilan Gelap' : 'Tampilan Terang';
        }

        document.querySelectorAll('[data-theme-choice]').forEach(function(choice) {
            choice.classList.toggle('active', choice.dataset.themeChoice === theme);
        });
    }

    function setTheme(theme)
    {
        if (theme !== 'light' && theme !== 'dark') {
            return;
        }

        localStorage.setItem('sirasi-theme', theme);
        applyTheme(theme);
    }

    function applyResponsive(enabled)
    {
        document.documentElement.classList.toggle('responsive-disabled', !enabled);
        document.body.classList.toggle('responsive-disabled', !enabled);

        const choice = document.getElementById('responsiveChoice');
        const label = document.getElementById('responsiveStatusLabel');
        const description = document.getElementById('responsiveDescription');

        if (choice) {
            choice.classList.toggle('active', enabled);
        }

        if (label) {
            label.textContent = enabled ? 'Aktif' : 'Nonaktif';
        }

        if (description) {
            description.textContent = enabled
                ? 'Tampilan otomatis menyesuaikan ukuran layar perangkat.'
                : 'Tampilan menggunakan ukuran desktop dan tidak menyesuaikan layar kecil.';
        }
    }

    function toggleResponsive()
    {
        const current = localStorage.getItem('sirasi-responsive');
        const enabled = current !== 'false';
        const next = !enabled;

        localStorage.setItem('sirasi-responsive', next ? 'true' : 'false');
        applyResponsive(next);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const settingsTabs = Array.from(document.querySelectorAll('.settings-tab[data-tab]'));
        settingsTabs.forEach(function(tab, index) {
            tab.addEventListener('click', function() {
                settingsTabs.forEach(function(item) {
                    const active = item === tab;
                    item.classList.toggle('active', active);
                    item.setAttribute('aria-selected', String(active));
                    const panel = document.getElementById(item.dataset.tab);
                    if (panel) {
                        panel.hidden = !active;
                        panel.classList.toggle('active', active);
                    }
                });
            });
            tab.addEventListener('keydown', function(event) {
                if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
                    event.preventDefault();
                    const offset = event.key === 'ArrowRight' ? 1 : -1;
                    const next = settingsTabs[(index + offset + settingsTabs.length) % settingsTabs.length];
                    next.focus();
                    next.click();
                }
            });
        });

        const photoInput = document.getElementById('settingsPhoto');
        if (photoInput) {
            photoInput.addEventListener('change', function() {
                const file = photoInput.files && photoInput.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('profilePreview');
                    if (preview) preview.innerHTML = '<img src="' + event.target.result + '" alt="Pratinjau foto profil">';
                };
                reader.readAsDataURL(file);
            });
        }

        const preferenceCard = document.getElementById('preferenceCard');
        const infoCard = document.getElementById('infoCard');
        const savedTheme = localStorage.getItem('sirasi-theme') || 'light';
        const savedResponsive = localStorage.getItem('sirasi-responsive') !== 'false';

        applyTheme(savedTheme);
        applyResponsive(savedResponsive);

        if (preferenceCard) {
            preferenceCard.addEventListener('click', function() {
                openModal('preferenceModal');
            });
        }

        if (infoCard) {
            infoCard.addEventListener('click', function() {
                openModal('infoModal');
            });
        }

        const responsiveChoice = document.getElementById('responsiveChoice');

        if (responsiveChoice) {
            responsiveChoice.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    toggleResponsive();
                }
            });
        }

    });

    document
        .querySelectorAll('.modal')
        .forEach(function(modal) {

            modal.addEventListener(
                'click',
                function(event) {

                    if (event.target === modal) {

                        modal.classList.remove('show');

                    }

                }
            );

        });

</script>

<script>
    lucide.createIcons();

    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const isVisible = input.type === 'password';
        input.type = isVisible ? 'text' : 'password';
        button.classList.toggle('is-visible', isVisible);
        button.setAttribute('aria-pressed', String(isVisible));
        button.setAttribute(
            'aria-label',
            `${isVisible ? 'Sembunyikan' : 'Tampilkan'} ${button.getAttribute('aria-label').replace(/^(Tampilkan|Sembunyikan) /, '')}`
        );
    }

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
