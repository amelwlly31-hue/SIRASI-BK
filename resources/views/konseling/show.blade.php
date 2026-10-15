<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konseling - SIRASI-BK</title>
    @include('partials.theme')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #21499f;
            --primary-dark: #173d8b;
            --primary-soft: #eaf0ff;
            --text: #14223d;
            --muted: #78869d;
            --line: #e0e7f1;
            --surface: #ffffff;
            --page: #f4f7fc;
            --success: #16834a;
            --success-bg: #eaf8f0;
            --danger: #d64545;
            --danger-bg: #fff1f1;
        }

        body {
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--page);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        textarea {
            font: inherit;
        }

        /* layout */
        .app {
            min-height: 100vh;
            display: flex;
        }

        /* sidebar */
        .sidebar {
            width: 270px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
            overflow-y: auto;
            padding: 24px 16px;
            background: linear-gradient(180deg, #193f96 0%, #173887 52%, #112e70 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
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
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: linear-gradient(145deg, rgba(255,255,255,.20), rgba(255,255,255,.08));
            border: 1px solid rgba(255,255,255,.25);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.20), 0 9px 22px rgba(0,0,0,.12);
            overflow: hidden;
        }

        .brand-logo img {
            width: 200px;
            height: 150px;
            object-fit: contain;
            transform: translateY(20px);
        }

        .brand-name {
            font-size: 16px;
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
            gap: 6px;
        }

        .menu-item {
            position: relative;
            width: 100%;
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 0 14px;
            border: 1px solid transparent;
            border-radius: 13px;
            background: transparent;
            color: #dce5ff;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
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

        .menu-icon {
            width: 25px;
            height: 25px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(255,255,255,.085);
            border: 1px solid rgba(255,255,255,.035);
            transition: .2s ease;
        }

        .menu-item:hover .menu-icon {
            background: rgba(255,255,255,.15);
        }

        .menu-item.active .menu-icon {
            background: rgba(255,255,255,.14);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.06);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
        }

        .logout-button {
            appearance: none;
            text-align: left;
            min-height: 46px;
            border-radius: 13px;
            color: #dce5ff;
            font-weight: 700;
            transition: .2s ease;
            width: 100%;
            border: 0;
            background: transparent;
            cursor: pointer;
        }

        .logout-button:hover {
            color: #fff;
            background: rgba(255,255,255,.09);
            transform: translateX(2px);
        }

        .logout-button:active {
            background: rgba(151,190,255,.20);
        }

        /* main content */
        .main {
            flex: 1;
            min-width: 0;
            margin-left: 270px;
            background:
                radial-gradient(circle at 90% 0%, rgba(54,91,177,.07), transparent 26%),
                var(--page);
        }

        /* header */
        .header {
            height: 76px;
            padding: 0 32px;
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid #e4e9f2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .search {
            width: 100%;
            max-width: 430px;
            height: 42px;
            padding: 0 13px;
            border: 1px solid #dbe3ef;
            border-radius: 12px;
            background: #f9fbfe;
            display: flex;
            align-items: center;
            gap: 9px;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .search:focus-within {
            background: #fff;
            border-color: #b8c8e9;
            box-shadow: 0 0 0 4px rgba(42,79,160,.07);
        }

        .search-icon {
            color: #8b99af;
            display: flex;
            align-items: center;
        }

        .search-icon svg {
            width: 16px;
            height: 16px;
        }

        .search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--text);
            font-size: 13px;
        }

        .search input::placeholder {
            color: #9aa7bb;
        }

        .profile-area {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .notification {
            position: relative;
            width: 40px;
            height: 40px;
            border: 1px solid #dfe6f1;
            border-radius: 11px;
            background: #fff;
            color: #3f5170;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 16px rgba(29,56,105,.06);
            cursor: pointer;
        }

        .notification svg {
            width: 25px;
            height: 25px;
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #d65a65;
            border: 1px solid #fff;
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
            border: 1px solid #dfe6f1;
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
            border-bottom: 1px solid #dfe6f1;
            font-size: 13px;
            color: #172542;
        }

        .notification-item {
            display: flex;
            gap: 11px;
            padding: 13px 15px;
            border-bottom: 1px solid #edf0f4;
            color: #172542;
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
            background: #e8eeff;
            color: #254695;
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
            color: #8490a5;
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
            color: #8490a5;
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
            padding-left: 17px;
            border-left: 1px solid #e1e6ef;
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .profile-info {
            text-align: right;
        }

        .profile-name {
            color: #172542;
            font-size: 13px;
            font-weight: 800;
        }

        .profile-role {
            margin-top: 3px;
            color: #8490a5;
            font-size: 11px;
        }

        .profile-photo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #e8eeff;
            color: #254695;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            display: block;
        }

        .profile-photo svg {
            width: 18px;
            height: 18px;
        }

        /* content area */
        .content {
            padding: 32px;
        }

        .page-header {
            margin-bottom: 25px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .eyebrow {
            margin-bottom: 9px;
            color: #2850a7;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .back-link {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border: 1px solid #dce4ef;
            border-radius: 11px;
            background: #fff;
            color: #23499f;
            box-shadow: 0 4px 14px rgba(28,55,103,.05);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .back-link svg,
        .back-link i {
            width: 18px;
            height: 18px;
        }

        .back-link:hover {
            transform: translateX(-2px);
            box-shadow: 0 8px 18px rgba(28,55,103,.10);
        }

        .page-title {
            color: #0f1f3c;
            font-size: 29px;
            line-height: 1.15;
            letter-spacing: -.7px;
            font-weight: 800;
        }

        .page-description {
            margin: 8px 0 0 0;
            color: #74829a;
            font-size: 13px;
            line-height: 1.6;
        }

        .page-actions {
            display: flex;
            gap: 9px;
            flex-shrink: 0;
        }

        .btn {
            min-height: 40px;
            padding: 0 16px;
            border: 1px solid #d8e0ec;
            border-radius: 11px;
            background: #fff;
            color: #243552;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .btn svg {
            width: 15px;
            height: 15px;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 16px rgba(30,55,100,.08);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2149a2, #173c91);
            border-color: #173c91;
            color: #fff;
            box-shadow: 0 4px 14px rgba(23,60,145,.18);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #173c91, #102e70);
            box-shadow: 0 6px 18px rgba(23,60,145,.25);
            color: #fff;
        }

        .btn-primary-outline {
            background: #eaf0ff;
            border-color: #c9d8ff;
            color: #21499f;
        }

        .btn-primary-outline:hover {
            background: #dde7ff;
            border-color: #b5caff;
            color: #153880;
        }

        .btn-danger-outline {
            background: #fff0f0;
            border-color: #ffd2d2;
            color: #d64545;
            padding: 4px 9px;
            min-height: 30px;
            font-size: 11px;
            border-radius: 8px;
        }

        .btn-danger-outline:hover {
            background: #ffe3e3;
            color: #bd2d2d;
        }

        /* alert */
        .alert-success {
            margin-bottom: 20px;
            padding: 12px 18px;
            border-radius: 12px;
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid #c8ebd5;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-success svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* detail layout */
        .detail-layout {
            display: grid;
            grid-template-columns: 335px minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .student-card {
            position: sticky;
            top: 98px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #dfe6f1;
            border-radius: 20px;
            box-shadow: 0 18px 45px rgba(28,55,103,.08);
        }

        .student-cover {
            height: 105px;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 88% 0%, rgba(255,255,255,.72) 0 64px, transparent 65px),
                radial-gradient(circle at 76% 14%, rgba(255,255,255,.38) 0 108px, transparent 109px),
                linear-gradient(135deg, #e7edff 0%, #dbe5ff 100%);
        }

        .student-cover::before {
            content: "";
            position: absolute;
            width: 145px;
            height: 145px;
            right: -58px;
            top: -103px;
            border: 18px solid rgba(255,255,255,.30);
            border-radius: 50%;
        }

        .student-body {
            padding: 0 22px 22px;
        }

        .student-avatar {
            width: 68px;
            height: 68px;
            margin: -34px auto 12px;
            position: relative;
            border: 5px solid #fff;
            border-radius: 18px;
            background: #e8eeff;
            color: #23499b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(31,62,121,.14);
        }

        .student-name {
            text-align: center;
            color: #162540;
            font-size: 18px;
            font-weight: 800;
        }

        .class-badge {
            width: fit-content;
            margin: 8px auto 18px;
            padding: 5px 10px;
            border: 1px solid #d7e2ff;
            border-radius: 999px;
            background: #edf3ff;
            color: #3156a6;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 10px;
            font-weight: 800;
        }

        .class-badge svg {
            width: 12px;
            height: 12px;
        }

        .student-divider {
            height: 1px;
            margin: 0 0 10px;
            border: 0;
            background: #e5eaf2;
        }

        .student-info {
            padding: 0;
        }

        .info-row {
            min-height: 43px;
            padding: 9px 0;
            border-bottom: 1px solid #edf1f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .info-row:last-child {
            border-bottom: 0;
        }

        .info-label {
            color: #8995a8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .info-value {
            max-width: 190px;
            color: #263653;
            font-size: 11px;
            font-weight: 800;
            text-align: right;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
        }

        .status.selesai {
            background: #eaf8f0;
            color: #16834a;
        }

        .status.proses {
            background: #fff5df;
            color: #a96b00;
        }

        .status.default {
            background: #edf2f8;
            color: #66758d;
        }

        .status-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .student-history {
            min-height: 40px;
            margin-top: 14px;
            padding: 0 12px;
            border: 1px solid #cfdbf5;
            border-radius: 10px;
            background: #f6f8ff;
            color: #2850a7;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 10px;
            font-weight: 800;
            transition: background .2s ease, border-color .2s ease, transform .2s ease;
        }

        .student-history svg {
            width: 13px;
            height: 13px;
        }

        .student-history:hover {
            transform: translateY(-1px);
            background: #edf2ff;
            border-color: #b9c9ed;
        }

        .right-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .detail-card {
            overflow: hidden;
            background: #fff;
            border: 1px solid #dfe6f1;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(28,55,103,.06);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .detail-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 34px rgba(28,55,103,.08);
        }

        .detail-card-header {
            min-height: 58px;
            padding: 0 20px;
            border-bottom: 1px solid #e2e8f2;
            background: linear-gradient(135deg, #f7f9ff 0%, #edf2ff 100%);
            color: #172846;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .04em;
        }

        .result-card .detail-card-header {
            background: linear-gradient(135deg, #f4f8ff 0%, #eef3ff 100%);
        }

        .section-icon {
            width: 31px;
            height: 31px;
            border-radius: 10px;
            background: #e7eeff;
            color: #2850a7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-icon svg {
            width: 16px;
            height: 16px;
        }

        .detail-card-body {
            min-height: 82px;
            padding: 22px 23px;
        }

        .detail-card-body p {
            color: #34435e;
            font-size: 13px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .empty-text {
            color: #99a5b8 !important;
            font-size: 12px !important;
            line-height: 1.6 !important;
        }

        .follow-up-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid #edf1f6;
        }

        .follow-up-item:first-child {
            padding-top: 0;
        }

        .follow-up-item:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .follow-up-main {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            flex: 1;
        }

        .follow-up-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #eaf0ff;
            color: #2850a7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .follow-up-icon svg {
            width: 16px;
            height: 16px;
        }

        .follow-up-content {
            flex: 1;
        }

        .follow-up-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #172542;
        }

        .follow-up-desc {
            margin-top: 4px;
            color: #55647e;
            font-size: 12.5px;
            line-height: 1.6;
            white-space: pre-line;
        }

        .follow-up-date {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 6px;
            color: #8e9bb0;
            font-size: 11px;
            font-weight: 600;
        }

        .follow-up-date svg {
            width: 12px;
            height: 12px;
        }

        .note {
            padding: 5px 0 5px 15px;
            border-left: 3px solid #6f8ed5;
            background: linear-gradient(90deg, #f7f9ff, transparent);
        }

        .note p {
            color: #66758e !important;
            font-size: 12px !important;
        }

        /* modal */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-dialog {
            background: #fff;
            width: 100%;
            max-width: 520px;
            border-radius: 18px;
            border: 1px solid #dfe6f1;
            box-shadow: 0 20px 50px rgba(15, 35, 80, .20);
            overflow: hidden;
            animation: modalPop .2s ease-out;
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            padding: 18px 22px;
            border-bottom: 1px solid #e5ebf5;
            background: linear-gradient(135deg, #f8faff, #edf2ff);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 15px;
            font-weight: 800;
            color: #172542;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .modal-close {
            background: transparent;
            border: 0;
            color: #8a96a8;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s ease;
        }

        .modal-close:hover {
            background: rgba(0,0,0,.06);
            color: #172542;
        }

        .modal-body {
            padding: 22px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 11px;
            font-weight: 800;
            color: #435169;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d9e1ee;
            border-radius: 10px;
            background: #fbfcfe;
            color: #172033;
            font-size: 13px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-input:focus {
            border-color: #7b9ce0;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(33, 73, 159, .10);
        }

        .modal-footer {
            padding: 16px 22px;
            border-top: 1px solid #edf1f7;
            background: #fafbfe;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        @media (max-width: 1050px) {
            .detail-layout {
                grid-template-columns: 1fr;
            }

            .student-card {
                position: static;
            }

            .page-header {
                align-items: flex-start;
            }
        }

        @media (max-width: 750px) {
            .sidebar {
                width: 80px;
                padding: 20px 10px;
            }

            .main {
                margin-left: 80px;
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

            .search {
                max-width: 240px;
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
                gap: 16px;
            }

            .page-title {
                font-size: 25px;
            }

            .page-actions {
                width: 100%;
            }

            .page-actions .btn {
                flex: 1;
            }
        }

        /* dark mode */
        body.dark-mode {
            background: #0f1728 !important;
            color: #edf3ff !important;
        }

        body.dark-mode .main {
            background:
                radial-gradient(circle at 90% 0%, rgba(54,91,177,.12), transparent 28%),
                #0f1728 !important;
        }

        body.dark-mode .header {
            background: rgba(15,23,40,.92) !important;
            border-bottom-color: #293752 !important;
        }

        body.dark-mode .search {
            background: #141f33 !important;
            border-color: #293752 !important;
        }

        body.dark-mode .search input {
            color: #edf3ff !important;
        }

        body.dark-mode .notification {
            background: #162238 !important;
            border-color: #334463 !important;
            color: #8baae4 !important;
        }

        body.dark-mode .notification-dropdown {
            background: #172238 !important;
            border-color: #293752 !important;
        }

        body.dark-mode .notification-header,
        body.dark-mode .notification-item {
            border-color: #293752 !important;
            color: #edf3ff !important;
        }

        body.dark-mode .notification-item:hover {
            background: #1d2c47 !important;
        }

        body.dark-mode .notification-item-content strong {
            color: #edf3ff !important;
        }

        body.dark-mode .profile {
            border-left-color: #293752 !important;
        }

        body.dark-mode .profile-name {
            color: #edf3ff !important;
        }

        body.dark-mode .profile-role {
            color: #9aa8c0 !important;
        }

        body.dark-mode .content {
            color: #edf3ff !important;
        }

        body.dark-mode .eyebrow {
            color: #a9c5ff !important;
        }

        body.dark-mode .page-title {
            color: #edf3ff !important;
        }

        body.dark-mode .page-description {
            color: #9aa8c0 !important;
        }

        body.dark-mode .back-link {
            background: #162238 !important;
            border-color: #334463 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .student-card,
        body.dark-mode .detail-card {
            background: #172238 !important;
            border-color: #293752 !important;
            box-shadow: 0 18px 45px rgba(0,0,0,.18) !important;
        }

        body.dark-mode .student-cover {
            background:
                radial-gradient(circle at 88% 0%, rgba(80,121,210,.35) 0 64px, transparent 65px),
                linear-gradient(135deg,#203d7c,#19346d) !important;
        }

        body.dark-mode .student-avatar {
            border-color: #172238 !important;
            background: #1d2c47 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .student-name {
            color: #edf3ff !important;
        }

        body.dark-mode .class-badge {
            background: #1d2c47 !important;
            border-color: #334463 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .student-divider,
        body.dark-mode .info-row,
        body.dark-mode .follow-up-item {
            border-color: #293752 !important;
        }

        body.dark-mode .info-label {
            color: #8998b0 !important;
        }

        body.dark-mode .info-value {
            color: #cbd7ed !important;
        }

        body.dark-mode .status.proses {
            background: #1d2c47 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .status.selesai {
            background: #193a2a !important;
            color: #75d6a0 !important;
        }

        body.dark-mode .student-history {
            background: #1d2c47 !important;
            border-color: #334463 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .detail-card-header {
            background: linear-gradient(135deg,#1a2940,#162238) !important;
            border-bottom-color: #293752 !important;
            color: #edf3ff !important;
        }

        body.dark-mode .section-icon,
        body.dark-mode .follow-up-icon {
            background: #1d2c47 !important;
            color: #a9c5ff !important;
        }

        body.dark-mode .detail-card-body p,
        body.dark-mode .follow-up-desc {
            color: #cbd7ed !important;
        }

        body.dark-mode .follow-up-title {
            color: #edf3ff !important;
        }

        body.dark-mode .follow-up-date {
            color: #8998b0 !important;
        }

        body.dark-mode .note {
            background: linear-gradient(90deg,#141f33,transparent) !important;
        }

        body.dark-mode .note p {
            color: #8998b0 !important;
        }

        body.dark-mode .modal-dialog {
            background: #172238 !important;
            border-color: #293752 !important;
        }

        body.dark-mode .modal-header {
            background: linear-gradient(135deg,#1a2940,#162238) !important;
            border-color: #293752 !important;
        }

        body.dark-mode .modal-title {
            color: #edf3ff !important;
        }

        body.dark-mode .modal-footer {
            background: #141f33 !important;
            border-color: #293752 !important;
        }

        body.dark-mode .form-label {
            color: #cbd7ed !important;
        }

        body.dark-mode .form-input {
            background: #111d31 !important;
            border-color: #293752 !important;
            color: #edf3ff !important;
        }

        body.dark-mode .btn-primary-outline {
            background: #1d2c47 !important;
            border-color: #334463 !important;
            color: #a9c5ff !important;
        }
    </style>
</head>

<body>

<div class="app">

    {{-- sidebar --}}
    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo-smpn2-dramaga.png') }}" alt="Logo SMP Negeri 2 Dramaga">
                </div>
                <div>
                    <div class="brand-name">SIRASI-BK</div>
                    <div class="brand-subtitle">Bimbingan & Konseling</div>
                </div>
            </div>

            <div class="menu-title">Menu Utama</div>

            <nav class="menu">
                <a href="{{ route('dashboard') }}" class="menu-item">
                    <span class="menu-icon"><i data-lucide="home"></i></span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('siswa.index') }}" class="menu-item">
                    <span class="menu-icon"><i data-lucide="users-round"></i></span>
                    <span>Data Siswa</span>
                </a>

                <a href="{{ route('penjadwalan.index') }}" class="menu-item">
                    <span class="menu-icon"><i data-lucide="calendar-clock"></i></span>
                    <span>Penjadwalan</span>
                </a>

                <a href="{{ route('konseling.index') }}" class="menu-item active">
                    <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
                    <span>Data Konseling</span>
                </a>

                <a href="{{ route('siswa.riwayat') }}" class="menu-item">
                    <span class="menu-icon"><i data-lucide="history"></i></span>
                    <span>Riwayat Siswa</span>
                </a>

                <a href="{{ route('laporan.index') }}" class="menu-item">
                    <span class="menu-icon"><i data-lucide="file-chart-column"></i></span>
                    <span>Laporan</span>
                </a>

                <a href="{{ route('pengaturan.index') }}" class="menu-item">
                    <span class="menu-icon"><i data-lucide="settings"></i></span>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Anda yakin ingin keluar?');">
                @csrf
                <button type="submit" class="menu-item logout-button">
                    <span class="menu-icon"><i data-lucide="log-out"></i></span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- main --}}
    <main class="main">

        {{-- header --}}
        <header class="header">
            <div class="search">
                <span class="search-icon"><i data-lucide="search"></i></span>
                <input type="text" placeholder="Cari data konseling...">
            </div>

            <div class="profile-area">
                <div class="notification-wrapper">
                    <button type="button" class="notification" id="notificationButton">
                        <i data-lucide="bell"></i>
                        @if (isset($notifikasis) && $notifikasis->where('dibaca', false)->count() > 0)
                            <span class="notification-dot"></span>
                        @endif
                    </button>

                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <strong>Notifikasi</strong>
                        </div>

                        @forelse ($notifikasis ?? [] as $notifikasi)
                            <a href="{{ route('notifikasi.baca', $notifikasi->id) }}" class="notification-item">
                                <div class="notification-item-icon">
                                    @if ($notifikasi->tipe === 'jadwal' || $notifikasi->tipe === 'penjadwalan')
                                        <i data-lucide="calendar-clock"></i>
                                    @elseif ($notifikasi->tipe === 'siswa')
                                        <i data-lucide="users-round"></i>
                                    @else
                                        <i data-lucide="clipboard-list"></i>
                                    @endif
                                </div>
                                <div class="notification-item-content">
                                    <strong>{{ $notifikasi->judul }}</strong>
                                    <p>{{ preg_replace('/\s*\[JADWAL:\d+\]/', '', $notifikasi->pesan) }}</p>
                                    <small>{{ $notifikasi->created_at->diffForHumans() }}</small>
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
                            {{ auth()->user()?->nama ?? 'Guru BK' }}
                        </div>
                        <div class="profile-role">
                            {{ auth()->user()?->role ?? 'Administrator' }}
                        </div>
                    </div>

                    <div class="profile-photo">
                        @if (auth()->user()?->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil">
                        @else
                            <i data-lucide="user-round"></i>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        {{-- content --}}
        <section class="content">

            {{-- page header --}}
            <a href="{{ route('konseling.index') }}" class="back-link" title="Kembali ke Data Konseling">
                <i data-lucide="arrow-left"></i>
            </a>

            @if (session('success'))
                <div class="alert-success">
                    <i data-lucide="check-circle-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="page-header">
                <div>
                    <div class="eyebrow">Data Konseling</div>
                    <h1 class="page-title">Detail Catatan Konseling</h1>
                    <p class="page-description">
                        Informasi lengkap mengenai sesi bimbingan dan konseling siswa.
                    </p>
                </div>
                <div class="page-actions">
                    <a href="{{ route('konseling.edit', $konseling->id_konseling) }}" class="btn btn-primary">
                        <i data-lucide="pencil"></i>
                        <span>Edit Konseling</span>
                    </a>
                </div>
            </div>

            {{-- detail layout --}}
            <div class="detail-layout">

                {{-- student card --}}
                <div class="student-card">
                    <div class="student-cover"></div>

                    <div class="student-body">
                        <div class="student-avatar">
                            {{ strtoupper(substr($konseling->siswa->nama_siswa ?? 'S', 0, 2)) }}
                        </div>

                        <div class="student-name">
                            {{ $konseling->siswa->nama_siswa ?? '-' }}
                        </div>

                        <div class="class-badge">
                            <i data-lucide="graduation-cap"></i>
                            Kelas {{ $konseling->siswa->kelas->nama_kelas ?? '-' }}
                        </div>

                        <hr class="student-divider">

                        <div class="student-info">
                            <div class="info-row">
                                <span class="info-label">NIS</span>
                                <span class="info-value">{{ $konseling->siswa->nis ?? '-' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Tanggal</span>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($konseling->tanggal)->format('d M Y') }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Jenis Masalah</span>
                                <span class="info-value">
                                    {{ $konseling->jenisMasalah->nama_jenis ?? '-' }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Status</span>
                                @php
                                    $status = strtolower($konseling->status ?? '');
                                @endphp

                                @if ($status === 'selesai')
                                    <span class="status selesai">
                                        <span class="status-dot"></span>
                                        Selesai
                                    </span>
                                @elseif ($status === 'proses')
                                    <span class="status proses">
                                        <span class="status-dot"></span>
                                        Proses
                                    </span>
                                @else
                                    <span class="status default">
                                        <span class="status-dot"></span>
                                        {{ $konseling->status ?? '-' }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if ($konseling->siswa)
                            <a href="{{ route('siswa.show', [$konseling->siswa->id_siswa, 'from' => 'riwayat']) }}" class="student-history">
                                <i data-lucide="eye"></i>
                                <span>Lihat Riwayat Siswa</span>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- right content --}}
                <div class="right-content">

                    {{-- masalah --}}
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <span class="section-icon">
                                <i data-lucide="info"></i>
                            </span>
                            <span>MASALAH YANG DIHADAPI</span>
                        </div>

                        <div class="detail-card-body">
                            @if ($konseling->masalah)
                                <p>{{ $konseling->masalah }}</p>
                            @else
                                <div class="empty-text">Belum ada keterangan masalah.</div>
                            @endif
                        </div>
                    </div>

                    {{-- hasil konseling --}}
                    @if ($konseling->hasil_konseling)
                        <div class="detail-card result-card">
                            <div class="detail-card-header">
                                <span class="section-icon">
                                    <i data-lucide="circle-check"></i>
                                </span>
                                <span>HASIL KONSELING</span>
                            </div>

                            <div class="detail-card-body">
                                <p>{{ $konseling->hasil_konseling }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- tindak lanjut --}}
                    <div class="detail-card">
                        <div class="detail-card-header" style="justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span class="section-icon">
                                    <i data-lucide="check"></i>
                                </span>
                                <span>TINDAK LANJUT</span>
                            </div>

                            <button type="button" class="btn btn-primary-outline" id="btnBukaModalTindakLanjut" style="padding: 5px 12px; font-size: 11px; min-height: 32px; border-radius: 9px;">
                                <i data-lucide="plus" style="width: 14px; height: 14px;"></i>
                                <span>Tambah Tindak Lanjut</span>
                            </button>
                        </div>

                        <div class="detail-card-body">
                            @forelse ($konseling->tindakLanjut as $tindakLanjut)
                                <div class="follow-up-item">
                                    <div class="follow-up-main">
                                        <div class="follow-up-icon">
                                            <i data-lucide="check"></i>
                                        </div>

                                        <div class="follow-up-content">
                                            <div class="follow-up-title">{{ $tindakLanjut->tindakan }}</div>
                                            @if ($tindakLanjut->keterangan)
                                                <div class="follow-up-desc">{{ $tindakLanjut->keterangan }}</div>
                                            @endif
                                            <span class="follow-up-date">
                                                <i data-lucide="calendar"></i>
                                                {{ \Carbon\Carbon::parse($tindakLanjut->tanggal)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <form action="{{ route('tindak_lanjut.destroy', $tindakLanjut->id_tindak_lanjut) }}" method="POST" onsubmit="return confirm('Hapus tindak lanjut ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-outline" title="Hapus Tindak Lanjut">
                                            <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="empty-text" style="display: flex; flex-direction: column; align-items: flex-start; gap: 10px;">
                                    <span>Belum ada tindak lanjut.</span>
                                    <button type="button" class="btn btn-primary-outline" id="btnEmptyTambahTindakLanjut" style="padding: 6px 12px; font-size: 11px; min-height: 32px;">
                                        <i data-lucide="plus" style="width: 13px; height: 13px;"></i>
                                        <span>Tambah Tindak Lanjut</span>
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- catatan tambahan --}}
                    @if ($konseling->catatan)
                        <div class="detail-card">
                            <div class="detail-card-header">
                                <span class="section-icon">
                                    <i data-lucide="notebook-pen"></i>
                                </span>
                                <span>CATATAN TAMBAHAN</span>
                            </div>

                            <div class="detail-card-body">
                                <div class="note">
                                    <p>"{{ $konseling->catatan }}"</p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </section>

    </main>

</div>

{{-- modal tambah tindak lanjut --}}
<div class="modal-backdrop" id="modalTindakLanjut">
    <div class="modal-dialog">
        <form action="{{ route('tindak_lanjut.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_konseling" value="{{ $konseling->id_konseling }}">

            <div class="modal-header">
                <div class="modal-title">
                    <i data-lucide="plus-circle" style="width: 18px; height: 18px; color: var(--primary);"></i>
                    <span>Tambah Tindak Lanjut</span>
                </div>
                <button type="button" class="modal-close" id="btnTutupModal">
                    <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="tanggal_tindak_lanjut">Tanggal Tindak Lanjut</label>
                    <input type="date" name="tanggal" id="tanggal_tindak_lanjut" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="tindakan">Tindakan</label>
                    <input type="text" name="tindakan" id="tindakan" class="form-input" placeholder="Contoh: Pemanggilan orang tua / Bimbingan lanjutan..." required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-input" rows="3" placeholder="Keterangan atau perkembangan dari tindakan yang dilakukan..." required></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn" id="btnBatalModal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                    <span>Simpan Tindak Lanjut</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }

        // notification dropdown
        const notificationButton = document.getElementById('notificationButton');
        const notificationDropdown = document.getElementById('notificationDropdown');

        if (notificationButton && notificationDropdown) {
            notificationButton.addEventListener('click', function (event) {
                event.stopPropagation();
                notificationDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function (event) {
                if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }

        // modal tindak lanjut
        const modal = document.getElementById('modalTindakLanjut');
        const btnBuka = document.getElementById('btnBukaModalTindakLanjut');
        const btnEmpty = document.getElementById('btnEmptyTambahTindakLanjut');
        const btnTutup = document.getElementById('btnTutupModal');
        const btnBatal = document.getElementById('btnBatalModal');

        function bukaModal() {
            if (modal) {
                modal.classList.add('show');
                if (window.lucide) {
                    lucide.createIcons();
                }
            }
        }

        function tutupModal() {
            if (modal) {
                modal.classList.remove('show');
            }
        }

        if (btnBuka) btnBuka.addEventListener('click', bukaModal);
        if (btnEmpty) btnEmpty.addEventListener('click', bukaModal);
        if (btnTutup) btnTutup.addEventListener('click', tutupModal);
        if (btnBatal) btnBatal.addEventListener('click', tutupModal);

        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    tutupModal();
                }
            });
        }
    });
</script>

</body>
</html>
