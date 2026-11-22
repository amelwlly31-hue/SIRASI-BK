<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SIRASI-BK</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue-deep: #102d70;
            --blue-dark: #173c91;
            --blue: #173c91;
            --blue-hover: #102d70;
            --blue-soft: #6f90e5;

            --text: #172033;
            --muted: #4b576d;
            --line: rgba(23, 60, 145, 0.12);

            --white: #ffffff;
        }

        body {
            width: 100%;
            height: 100vh;
            min-height: 100vh;



            background: #f4f6fa;
            color: var(--text);

            overflow: hidden;
            overflow: auto;
        }

        /* page */
        .login-page {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 100vh;

            display: grid;
            grid-template-columns: 1.08fr .92fr;

            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    rgba(10, 39, 94, .88) 0%,
                    rgba(24, 66, 143, .78) 48%,
                    rgba(7, 29, 73, .92) 100%
                ),
                url("https://bogor24jam.com/uploads/posts/mig_697e50aa0c831_116970d3dae3da7..jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* left panel */
        .login-left {
            position: relative;

            height: 100vh;
            min-height: 0;

            display: flex;
            flex-direction: column;

            padding: 40px 7.5% 34px;

            overflow: hidden;

            color: white;

            background: transparent;
        }

        .login-left::before {       /* decorative circle */
            content: "";

            position: absolute;

            width: 560px;
            height: 560px;

            top: -300px;
            right: -250px;

            border-radius: 50%;

            border:
                1px solid
                rgba(255,255,255,.075);

            box-shadow:
                0 0 0 45px
                rgba(255,255,255,.02),
                0 0 0 90px
                rgba(255,255,255,.015);

            pointer-events: none;
        }

        .login-left::after {
            content: "";

            position: absolute;

            width: 420px;
            height: 420px;

            left: -245px;
            bottom: -260px;

            border-radius: 50%;

            border:
                1px solid
                rgba(255,255,255,.05);

            pointer-events: none;
        }

        /* brand */
        .brand {
            position: relative;
            z-index: 10;

            display: flex;
            align-items: center;

            gap: 12px;

            width: fit-content;
        }

        .brand-icon {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 14px;

            background:
                rgba(255,255,255,.12);

            border:
                1px solid
                rgba(255,255,255,.22);

            box-shadow:
                inset 0 1px 0
                rgba(255,255,255,.12),
                0 10px 24px
                rgba(0,0,0,.12);

            backdrop-filter: blur(10px);

            overflow: hidden;
            padding: 0;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transform: scale(1.25);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            color: white;

            font-size: 20px;
            line-height: 1;

            font-weight: 800;

            letter-spacing: .2px;
        }

        .brand-subtitle {
            margin-top: 5px;

            color: #cbd7f7;

            font-size: 10px;
            line-height: 1.2;

            letter-spacing: .4px;
        }

        /* main content */
        .left-content {
            position: relative;
            z-index: 5;

            width: min(650px, 100%);

            margin-top: auto;
            margin-bottom: auto;

            padding:
                90px 0
                75px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;

            gap: 9px;

            margin-bottom: 18px;

            color: #d6e1ff;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1.6px;

            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";

            width: 25px;
            height: 2px;

            border-radius: 999px;

            background: #aec3ff;
        }

        .left-content h1 {
            position: relative;
            z-index: 6;

            max-width: 630px;

            color: white;

            font-size:
                clamp(35px, 4vw, 60px);

            line-height: 1.01;

            font-weight: 800;

            letter-spacing: -2.3px;
        }

        .left-content h1 span {
            color: #c3d3ff;
        }

        .description {
            position: relative;
            z-index: 6;

            max-width: 535px;

            margin-top: 28px;

            padding-left: 18px;

            border-left:
                3px solid
                rgba(188,208,255,.76);

            color: #d0dcfb;

            font-size: 14px;

            line-height: 1.8;
        }

        .description strong {
            color: white;

            font-weight: 700;
        }

        /* large logo silhouette */
        .school-logo-bg {
            position: absolute;

            z-index: 1;

            left: -210px;
            bottom: -300px;

            width: 1050px;
            height: 1050px;

            display: flex;
            align-items: center;
            justify-content: center;

            pointer-events: none;

            opacity: .12;

            transform: rotate(-8deg);
        }

        .school-logo-bg img {
            position: relative;
            z-index: 2;

            width: 100%;
            height: 100%;

            object-fit: contain;

            filter:
                brightness(0)
                contrast(1.3);

            opacity: 1;

            transform: scale(1.45);
        }

        /* footer left */
        .left-footer {
            position: relative;
            z-index: 10;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .slider-indicator {
            display: flex;
            align-items: center;

            gap: 8px;
        }

        .slider-indicator span {
            display: block;

            width: 31px;
            height: 4px;

            border-radius: 999px;

            background:
                rgba(255,255,255,.34);
        }

        .slider-indicator span:first-child {
            width: 44px;

            background:
                #d5e0ff;
        }

        .slider-indicator span:last-child {
            width: 9px;

            opacity: .55;
        }

        .school-label {
            color: #bfcef0;

            font-size: 10px;

            font-weight: 600;

            letter-spacing: .8px;

            text-transform: uppercase;
        }

        /* right panel */
        .login-right {
            position: relative;

            height: 100vh;
            min-height: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 45px;

            background: transparent;
        }

        .login-right::before {
            content: "";

            position: absolute;

            width: 430px;
            height: 430px;

            top: -260px;
            right: -220px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(61,95,174,.10),
                    transparent 68%
                );

            pointer-events: none;
        }

        .login-right::after {
            content: "";

            position: absolute;

            width: 280px;
            height: 280px;

            bottom: -190px;
            left: -170px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(56,86,157,.06),
                    transparent 70%
                );

            pointer-events: none;
        }

        /* login card */
        .login-card {
            position: relative;
            z-index: 4;

            width: 100%;
            max-width: 435px;

            padding: 25px 40px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255, 255, 255, 0.44) 0%,
                    rgba(255, 255, 255, 0.22) 100%
                );

            border:
                1px solid
                rgba(255, 255, 255, 0.52);

            border-radius: 24px;

            box-shadow:
                0 24px 60px rgba(5, 22, 60, 0.30),
                0 8px 20px rgba(5, 22, 60, 0.15),
                inset 0 1px 1px rgba(255, 255, 255, 0.65);

            backdrop-filter:
                blur(20px) saturate(140%);
            -webkit-backdrop-filter:
                blur(20px) saturate(140%);
        }

        /* login heading */
        .login-heading {
            margin-bottom: 31px;
        }

        .login-heading .eyebrow {
            margin-bottom: 12px;

            color: #173c91;

            font-size: 9.5px;

            font-weight: 800;

            letter-spacing: 1.7px;
        }

        .login-heading .eyebrow::before {
            width: 21px;

            background:
                #2855b7;
        }

        .login-card h2 {
            color: #0f1f42;

            font-size: 31px;

            line-height: 1.1;

            font-weight: 800;

            letter-spacing: -.9px;
        }

        .login-subtitle {
            margin-top: 10px;

            color: #475569;

            font-size: 12.5px;

            line-height: 1.65;
        }

        /* error */
        .error-message {
            margin-bottom: 20px;

            padding: 12px 14px;

            color: #991b1b;

            font-size: 12px;

            line-height: 1.5;

            background:
                rgba(254, 226, 226, 0.80);

            border:
                1px solid
                rgba(248, 113, 113, 0.50);

            border-radius: 12px;

            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            margin-bottom: 8px;

            color: #1e293b;

            font-size: 11.5px;

            font-weight: 700;

            letter-spacing: .15px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            width: 100%;
            height: 50px;

            padding:
                0 46px
                0 44px;

            color: #172033;



            font-size: 13px;

            font-weight: 500;

            background:
                rgba(255, 255, 255, 0.32);

            border:
                1px solid
                rgba(255, 255, 255, 0.60);

            border-radius: 13px;

            outline: none;

            box-shadow:
                inset 0 1px 2px rgba(23, 60, 145, 0.04);

            transition:
                background .2s ease,
                border-color .2s ease,
                box-shadow .2s ease;
        }

        #username { padding-left: 2.75rem !important; }
        #password { padding-left: 2.75rem !important; padding-right: 2.75rem !important; }

        .input-wrapper input::placeholder {
            color: #64748b;
            font-weight: 400;
        }

        .input-wrapper input:hover {
            background:
                rgba(255, 255, 255, 0.42);

            border-color:
                rgba(23, 60, 145, 0.28);
        }

        .input-wrapper input:focus {
            background:
                rgba(255, 255, 255, 0.52);

            border-color:
                #173c91;

            box-shadow:
                0 0 0 4px
                rgba(23, 60, 145, 0.12),
                inset 0 1px 2px rgba(23, 60, 145, 0.04);
        }

        .input-wrapper input:-webkit-autofill,
        .input-wrapper input:-webkit-autofill:hover,
        .input-wrapper input:-webkit-autofill:focus,
        .input-wrapper input:-webkit-autofill:active {
            -webkit-text-fill-color: #172033 !important;
            transition: background-color 5000s ease-in-out 0s;
            box-shadow: inset 0 0 0 30px rgba(255, 255, 255, 0.45) !important;
        }

        .input-icon {           /* icon username/password */
            position: absolute;

            left: 14px;
            top: 50%;

            transform:
                translateY(-50%);

            display: flex;
            align-items: center;
            justify-content: center;

            color: #94a3b8;

            pointer-events: none;
        }

        .input-icon svg {
            width: 17px;
            height: 17px;

            stroke-width: 2;
        }

        /* password toggle */
        .password-toggle {
            position: absolute;

            top: 50%;
            right: 10px;

            width: 31px;
            height: 31px;

            display: flex;
            align-items: center;
            justify-content: center;

            transform:
                translateY(-50%);

            border: 0;

            border-radius: 9px;

            background:
                transparent;

            color: #4b576d;

            cursor: pointer;

            transition:
                background .2s ease,
                color .2s ease;
        }

        .password-toggle svg {
            width: 16px;
            height: 16px;

            stroke-width: 2;
        }

        .password-toggle:hover {
            background:
                rgba(23, 60, 145, 0.10);

            color:
                #173c91;
        }

        /* remember */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin:
                8px 0 25px;
        }

        .remember {
            display: flex;
            align-items: center;

            gap: 8px;

            color: #394359;

            font-size: 11.5px;

            font-weight: 600;

            cursor: pointer;

            user-select: none;
        }

        .remember input {
            width: 16px;
            height: 16px;

            accent-color:
                #173c91;

            cursor: pointer;
        }

        .forgot {
            color: #173c91;
            cursor: pointer;

            padding: 0;
            border: 0;
            background: transparent;
            font: inherit;

            font-size: 11.5px;

            font-weight: 700;

            text-decoration: none;

            transition:
                color .2s ease,
                text-decoration .2s ease;
        }

        .forgot:hover {
            color: #102d70;

            text-decoration:
                underline;
        }

        .reset-dialog-overlay { position: fixed; inset: 0; z-index: 50; width: 100vw; height: 100vh; max-width: none; max-height: none; margin: 0; padding: 16px; border: 0; background: transparent; overflow-y: auto; }
        .reset-dialog-overlay:not([open]) { display: none !important; }
        .reset-dialog-overlay[open] { display: flex; align-items: center; justify-content: center; }
        .reset-dialog-overlay::backdrop { background: rgba(5, 16, 40, .62); backdrop-filter: blur(4px); }
        .reset-dialog {
            margin: auto;
            width: min(92vw, 440px);
            padding: 0;
            color: #0f172a;
            border: 1px solid rgba(255,255,255,.75);
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 24px 70px rgba(2, 12, 35, .38);
        }
        .reset-dialog::backdrop { background: rgba(5, 16, 40, .62); backdrop-filter: blur(4px); }
        .reset-dialog form { padding: 26px; }
        .reset-dialog h3 { margin: 0 0 8px; color: #102d70; font-size: 20px; }
        .reset-dialog p { margin: 0 0 18px; color: #475569; font-size: 13px; line-height: 1.55; }
        .reset-dialog label { display:block; margin: 12px 0 6px; color:#334155; font-size:12px; font-weight:700; }
        .reset-dialog input, .reset-dialog select { width:100%; min-height:44px; padding:10px 12px; border:1px solid #cbd5e1; border-radius:10px; color:#0f172a; background:#fff; }
        .reset-dialog-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:20px; }
        .reset-dialog-actions button { padding:10px 14px; border:0; border-radius:10px; font-weight:700; cursor:pointer; }
        .reset-dialog-cancel { color:#334155; background:#e2e8f0; }
        .reset-dialog-submit { color:#fff; background:#173c91; }
        .login-status { margin:0 0 16px; padding:11px 13px; border-radius:10px; font-size:12px; line-height:1.5; }
        .login-status.success { color:#14532d; background:#dcfce7; }
        .login-status.failure { color:#7f1d1d; background:#fee2e2; }

        /* login button */
        .login-button > span:empty { display: none; }
        .login-button {
            width: 100%;
            height: 51px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 9px;

            border: 0;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #1e47a5 0%,
                    #173c91 60%,
                    #102d70 100%
                );

            color: #ffffff;



            font-size: 13px;

            font-weight: 700;

            letter-spacing: .3px;

            cursor: pointer;

            box-shadow:
                0 10px 22px rgba(23, 60, 145, 0.32),
                inset 0 1px 0 rgba(255, 255, 255, 0.20);

            transition:
                background .25s ease,
                transform .2s ease,
                box-shadow .25s ease;
        }

        .login-button:hover {
            background:
                linear-gradient(
                    135deg,
                    #183c8f 0%,
                    #13337a 60%,
                    #0c2358 100%
                );

            transform:
                translateY(-2px);

            box-shadow:
                0 14px 28px rgba(16, 45, 112, 0.40),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);
        }

        .login-button:active {
            transform:
                translateY(0);

            box-shadow:
                0 6px 14px rgba(16, 45, 112, 0.30);
        }

        /* divider help */
        .divider {
            width: 100%;
            height: 1px;

            margin:
                26px 0 20px;

            background:
                rgba(23, 60, 145, 0.12);
        }

        .help-text {
            text-align: center;

            color: #4b576d;

            font-size: 11px;

            line-height: 1.6;
        }

        .help-text a {
            color: #173c91;

            font-weight: 700;

            text-decoration: none;

            transition:
                color .2s ease,
                text-decoration .2s ease;
        }

        .help-text a:hover {
            color: #102d70;

            text-decoration:
                underline;
        }

        /* responsive */
        @media (max-width: 1100px) {

        .login-page {
            grid-template-columns: 0.9fr 1.1fr;
            min-height: 100vh;
            height: auto;
        }

        .login-left {
            height: 100vh;
            min-height: 100vh;

            padding:
                28px 5% 24px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
        }

        .brand-name {
            font-size: 18px;
        }

        .brand-subtitle {
            font-size: 9px;
        }

        .left-content {
            width: 100%;
            padding:
                45px 0
                35px;
        }

        .left-content h1 {
            max-width: 100%;
            font-size: clamp(28px, 4vw, 42px);
            letter-spacing: -1.5px;
        }

        .description {
            max-width: 100%;
            margin-top: 18px;
            padding-left: 12px;
            font-size: 12px;
            line-height: 1.6;
        }

        .school-logo-bg {
            width: 600px;
            height: 600px;

            left: -180px;
            bottom: -180px;
        }

        .login-right {
            height: 100vh;
            min-height: 100vh;

            padding:
                25px 18px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;

            padding:
                30px 25px;

            border-radius: 20px;
        }

        .login-heading {
            margin-bottom: 24px;
        }

        .login-card h2 {
            font-size: 27px;
        }

        .login-subtitle {
            font-size: 11.5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .input-wrapper input {
            height: 46px;
            font-size: 12px;
        }

        .remember-row {
            margin:
                5px 0 18px;
        }

        .login-button {
            height: 47px;
        }

        .divider {
            margin:
                20px 0 15px;
        }
    }

        @media (max-width: 650px) {

            .login-left {
                min-height: 510px;

                padding:
                    30px 24px 28px;
            }

            .brand-icon {
                width: 42px;
                height: 42px;
            }

            .brand-icon img {
                width: 100%;
                height: 100%;
            }

            .brand-name {
                font-size: 18px;
            }

            .brand-subtitle {
                font-size: 9px;
            }

            .left-content {
                padding:
                    55px 0
                    40px;
            }

            .left-content h1 {
                font-size:
                    38px;

                letter-spacing:
                    -1.4px;
            }

            .description {
                font-size:
                    12px;
            }

            .school-logo-bg {
                width:
                    420px;

                height:
                    420px;

                left:
                    -40px;

                bottom:
                    -80px;

                opacity:
                    .085;
            }

            .school-label {
                display:
                    none;
            }

            .login-right {
                padding:
                    25px 16px
                    35px;
            }

            .login-card {
                padding:
                    31px 23px;

                border-radius:
                    20px;
            }

            .login-card h2 {
                font-size:
                    27px;
            }

        }

    </style>

    @include('partials.theme')
</head>

<body>

<div class="login-page">

    <!--quick theme toggle-->
    <button
        type="button"
        id="themeToggleBtn"
        class="theme-toggle-btn"
        onclick="toggleLoginTheme()"
        aria-label="Ganti tema"
        title="Ganti tema"
    >
        <i data-lucide="moon" id="themeToggleIcon"></i>
    </button>

    <!--left panel-->
    <section class="login-left">

        <!--Brand-->
        <div class="brand">

            <div class="brand-icon p-0 overflow-hidden flex items-center justify-center">

                <img
                    src="{{ asset('images/logo-smpn2-dramaga.png') }}"
                    alt="Logo SMP Negeri 2 Dramaga"
                    style="width: 100%; height: 100%; object-fit: contain; transform: scale(3) translateY(12%); transform-origin: center;"
                >

            </div>

            <div class="brand-text">

                <div class="brand-name">
                    SIRASI-BK
                </div>

                <div class="brand-subtitle">
                    Bimbingan & Konseling
                </div>

            </div>

        </div>

        <!--Main content-->
        <div class="left-content">

            <div class="eyebrow">
                Sistem Informasi Sekolah
            </div>

            <h1>
                Sistem Informasi Riwayat dan
                Administrasi
                <span>Bimbingan Konseling</span>
            </h1>

            <div class="description">
                Platform manajemen data konseling yang aman,
                terorganisir, dan profesional untuk mendukung
                perkembangan siswa di
                <strong>SMP Negeri 2 Dramaga</strong>
            </div>

        </div>

        <!--Footer-->
        <div class="left-footer">

            <div class="slider-indicator">
                <span></span>
                <span></span>
            </div>

            <div class="school-label">
                SMP Negeri 2 Dramaga
            </div>

        </div>

        <!--logo siluet-->
        <div class="school-logo-bg">

            <img
                src="{{ asset('images/logo-smpn2-dramaga.png') }}"
                alt=""
            >

        </div>

    </section>

    <!--right panel-->
    <section class="login-right">

        <div class="login-card">

            <!--heading-->
            <div class="login-heading">

                <div class="eyebrow">
                    SIRASI-BK
                </div>

                <h2>
                    Selamat Datang
                </h2>

                <p class="login-subtitle">
                    Silakan masuk menggunakan akun Guru BK.
                </p>

            </div>

            @if (session('reset_success'))
                <div class="login-status success" role="status">{{ session('reset_success') }}</div>
            @endif
            @if (session('reset_failure'))
                <div class="login-status failure" role="alert">{{ session('reset_failure') }}</div>
            @endif

            <!-- ERROR -->
            @if ($errors->any())

                <div class="error-message">
                    {{ $errors->first() }}
                </div>

            @endif

            <!--Form-->
            <form
                action="{{ route('login.process') }}"
                method="POST"
                autocomplete="off"
            >

                @csrf

                <!--username-->
                <div class="form-group">

                    <label for="username">
                        Username / Email
                    </label>

                    <div class="input-wrapper relative flex items-center">

                        <span class="input-icon pointer-events-none text-slate-400" aria-hidden="true">
                            <i data-lucide="user-round"></i>
                        </span>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukkan Username atau Email"
                            value="{{ old('username', '') }}"
                            autocomplete="off"
                            required
                        >

                    </div>

                </div>

                <!--password-->
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-wrapper relative flex items-center">

                        <span class="input-icon pointer-events-none text-slate-400" aria-hidden="true">
                            <i data-lucide="lock-keyhole"></i>
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword()"
                            aria-label="Tampilkan password"
                        >
                            <i data-lucide="eye"></i>
                        </button>

                    </div>

                </div>

                <!--remember-->
                <div class="remember-row">

                    <label class="remember">

                        <input
                            type="checkbox"
                            name="remember"
                        >

                        <span>
                            Ingat saya
                        </span>

                    </label>

                    <button
                        type="button"
                        id="openResetDialog"
                        class="forgot"
                    >
                        Lupa Password?
                    </button>

                </div>

                <!--login button-->
                <button
                    type="submit"
                    class="login-button"
                >
                    <span>
                        Masuk
                    </span>
                </button>

            </form>

            <!--divider-->
            <div class="divider"></div>

            <!--help-->
            <p class="help-text">

                Butuh bantuan akses?

                <a href="https://wa.me/6281284053871?text=Halo%20Administrator%20SIRASI-BK%20SMP%20Negeri%202%20Dramaga,%20saya%20membutuhkan%20bantuan%20akses%20pembuatan%20akun%20login." target="_blank" rel="noopener noreferrer" class="hover:underline font-medium">
                    Hubungi Administrator
                </a>

            </p>

            <dialog class="reset-dialog-overlay fixed inset-0 z-50 flex items-center justify-center p-4" id="resetPasswordDialog" aria-labelledby="resetDialogTitle">
                <div class="reset-dialog">
                <form action="{{ route('login.password-help') }}" method="POST">
                    @csrf
                    <h3 id="resetDialogTitle">Permintaan Reset Password</h3>
                    <p>Masukkan username atau email dan peran akun. Permintaan akan dikirim ke Administrator SMP Negeri 2 Dramaga untuk ditindaklanjuti.</p>

                    @if ($errors->has('reset_username') || $errors->has('reset_role'))
                        <div class="login-status failure" role="alert">{{ $errors->first('reset_username') ?: $errors->first('reset_role') }}</div>
                    @endif

                    <label for="reset_username">Username / Email</label>
                    <input id="reset_username" name="reset_username" placeholder="Masukkan Username atau Email" value="{{ old('reset_username') }}" autocomplete="username" required>

                    <label for="reset_role">Role akun</label>
                    <select id="reset_role" name="reset_role" required>
                        <option value="">Pilih role</option>
                        <option value="guru_bk" {{ old('reset_role') === 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                        <option value="wali_kelas" {{ old('reset_role') === 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    </select>

                    <div class="reset-dialog-actions">
                        <button type="button" class="reset-dialog-cancel" id="closeResetDialog">Batal</button>
                        <button type="submit" class="reset-dialog-submit">Kirim Permintaan</button>
                    </div>
                </form>
                </div>
            </dialog>

        </div>

    </section>

</div>

<!--lucide-->
<script src="https://unpkg.com/lucide@latest"></script>

<script>
    if (window.lucide) lucide.createIcons();

    const resetDialog = document.getElementById('resetPasswordDialog');
    document.getElementById('openResetDialog')?.addEventListener('click', () => resetDialog?.showModal());
    document.getElementById('closeResetDialog')?.addEventListener('click', () => resetDialog?.close());
    @if ($errors->has('reset_username') || $errors->has('reset_role'))
        resetDialog?.showModal();
    @endif

    function resetLoginFormIfEmpty() {
        @if (!old('username'))
        const u = document.getElementById('username');
        const p = document.getElementById('password');
        if (u) u.value = '';
        if (p) p.value = '';
        @endif
    }

    document.addEventListener('DOMContentLoaded', function () {
        resetLoginFormIfEmpty();
        setTimeout(resetLoginFormIfEmpty, 50);
        setTimeout(resetLoginFormIfEmpty, 200);
    });

    window.addEventListener('pageshow', function () {
        resetLoginFormIfEmpty();
    });

    function togglePassword() {

        const password =
            document.getElementById('password');

        const button =
            document.querySelector('.password-toggle');

        if (password.type === 'password') {

            password.type = 'text';

            button.innerHTML =
                '<i data-lucide="eye-off"></i>';

            button.setAttribute(
                'aria-label',
                'Sembunyikan password'
            );

        } else {

            password.type = 'password';

            button.innerHTML =
                '<i data-lucide="eye"></i>';

            button.setAttribute(
                'aria-label',
                'Tampilkan password'
            );

        }

        lucide.createIcons();
    }

    function updateLoginThemeIcon(theme) {
        var btn = document.getElementById('themeToggleBtn');
        if (!btn) return;
        if (theme === 'dark') {
            btn.innerHTML = '<i data-lucide="sun"></i>';
            btn.setAttribute('title', 'Beralih ke Tampilan Terang');
        } else {
            btn.innerHTML = '<i data-lucide="moon"></i>';
            btn.setAttribute('title', 'Beralih ke Tampilan Gelap');
        }
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function toggleLoginTheme() {
        var currentTheme = document.documentElement.classList.contains('dark-mode') ? 'dark' : 'light';
        var nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
        if (window.sirasiSetTheme) {
            window.sirasiSetTheme(nextTheme);
        } else {
            localStorage.setItem('sirasi-theme', nextTheme);
            localStorage.setItem('sirasi-theme-portal', nextTheme);
            document.documentElement.classList.toggle('dark-mode', nextTheme === 'dark');
            document.documentElement.classList.toggle('dark', nextTheme === 'dark');
            document.body.classList.toggle('dark-mode', nextTheme === 'dark');
            document.body.classList.toggle('dark', nextTheme === 'dark');
        }
        updateLoginThemeIcon(nextTheme);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var initialTheme = document.documentElement.classList.contains('dark-mode') ? 'dark' : 'light';
        updateLoginThemeIcon(initialTheme);
    });
</script>

</body>
</html>
