<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= APP_LONG_NAME ?>">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">

    <!-- Title -->
    <title>Login | <?= APP_LONG_NAME ?></title>

    <?php view("templates/style") ?>

    <style>
        /* =====================================================
           MODERN LOGIN PAGE
           ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f7fb;
            color: #263238;
        }

        /* -----------------------------------------------------
           MAIN WRAPPER
           ----------------------------------------------------- */

        .modern-login-page {
            min-height: 100vh;
            width: 100%;
            display: flex;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(
                    circle at 10% 15%,
                    rgba(255, 255, 255, 0.12) 0,
                    rgba(255, 255, 255, 0.02) 24%,
                    transparent 25%
                ),
                linear-gradient(
                    135deg,
                    #0d47a1 0%,
                    #1565c0 45%,
                    #1976d2 100%
                );
        }

        /* Decorative circles */

        .modern-login-page::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            left: -170px;
            bottom: -170px;
        }

        .modern-login-page::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            top: -130px;
            right: 35%;
        }

        /* -----------------------------------------------------
           LEFT SIDE
           ----------------------------------------------------- */

        .login-brand-section {
            width: 55%;
            min-height: 100vh;
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 60px 70px;
            color: #ffffff;
        }

        .brand-content {
            width: 100%;
            max-width: 650px;
        }

        /* Logo */

        .brand-logo-box {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .brand-logo {
            width: 90px;
            height: 90px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #ffffff;
            border-radius: 20px;
            padding: 10px;

            box-shadow:
                0 15px 40px rgba(0, 0, 0, 0.18);
        }

        .brand-logo img {
            display: block;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .brand-logo-text {
            margin-left: 22px;
        }

        .brand-logo-text .small-title {
            display: block;
            margin-bottom: 3px;

            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1.8px;
            text-transform: uppercase;

            color: rgba(255, 255, 255, 0.76);
        }

        .brand-logo-text .system-name {
            margin: 0;

            font-size: 25px;
            line-height: 1.3;
            font-weight: 700;

            color: #ffffff;
        }

        /* Main title */

        .brand-heading {
            margin: 0 0 20px;

            max-width: 620px;

            font-size: 48px;
            line-height: 1.15;
            font-weight: 700;

            color: #ffffff;
        }

        .brand-heading span {
            color: #bbdefb;
        }

        .brand-description {
            max-width: 580px;

            margin: 0 0 35px;

            font-size: 16px;
            line-height: 1.8;

            color: rgba(255, 255, 255, 0.82);
        }

        /* Features */

        .brand-features {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .feature-item {
            display: inline-flex;
            align-items: center;

            padding: 10px 16px;

            border: 1px solid rgba(255, 255, 255, 0.17);
            border-radius: 50px;

            background: rgba(255, 255, 255, 0.08);

            font-size: 13px;
            color: rgba(255, 255, 255, 0.92);
        }

        .feature-check {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 19px;
            height: 19px;

            margin-right: 8px;

            border-radius: 50%;
            background: #ffffff;
            color: #1565c0;

            font-size: 11px;
            font-weight: bold;
        }

        /* -----------------------------------------------------
           RIGHT SIDE
           ----------------------------------------------------- */

        .login-form-section {
            width: 45%;
            min-height: 100vh;

            position: relative;
            z-index: 5;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px;

            background: #f7f9fc;

            border-radius: 45px 0 0 45px;

            box-shadow:
                -20px 0 50px rgba(0, 0, 0, 0.08);
        }

        .login-container {
            width: 100%;
            max-width: 430px;
        }

        /* Mobile logo */

        .mobile-logo {
            display: none;
            text-align: center;
            margin-bottom: 25px;
        }

        .mobile-logo img {
            width: 80px;
            max-height: 90px;
            object-fit: contain;
        }

        /* Login heading */

        .login-heading {
            margin-bottom: 35px;
        }

        .login-heading .welcome-label {
            display: inline-block;

            margin-bottom: 10px;

            padding: 6px 13px;

            background: #e3f2fd;
            border-radius: 50px;

            color: #1565c0;

            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .login-heading h2 {
            margin: 0 0 9px;

            font-size: 31px;
            font-weight: 700;

            color: #172b4d;
        }

        .login-heading p {
            margin: 0;

            font-size: 14px;
            line-height: 1.6;

            color: #7b8794;
        }

        /* -----------------------------------------------------
           FORM
           ----------------------------------------------------- */

        .login-form .form-group {
            margin-bottom: 21px;
        }

        .login-form label {
            display: block;

            margin-bottom: 8px;

            font-size: 13px;
            font-weight: 600;

            color: #344563;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 17px;
            top: 50%;

            transform: translateY(-50%);

            width: 21px;
            height: 21px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #8b98a8;

            z-index: 2;
        }

        .input-icon svg {
            width: 19px;
            height: 19px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .modern-input {
            width: 100%;
            height: 53px;

            padding: 0 48px 0 50px;

            border: 1px solid #dce3ec;
            border-radius: 12px;

            outline: none;

            background: #ffffff;

            font-size: 14px;
            color: #263238;

            box-shadow: none;

            transition: all 0.25s ease;
        }

        .modern-input::placeholder {
            color: #aab3bf;
        }

        .modern-input:hover {
            border-color: #b7c5d5;
        }

        .modern-input:focus {
            border-color: #1976d2;

            box-shadow:
                0 0 0 4px rgba(25, 118, 210, 0.10);

            background: #ffffff;
        }

        .modern-input:focus + .password-toggle {
            color: #1976d2;
        }

        /* Password toggle */

        .password-toggle {
            position: absolute;

            right: 16px;
            top: 50%;

            transform: translateY(-50%);

            width: 26px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0;

            border: none;
            outline: none;

            background: transparent;

            color: #8b98a8;

            cursor: pointer;
        }

        .password-toggle:hover {
            color: #1976d2;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;

            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* -----------------------------------------------------
           LOGIN BUTTON
           ----------------------------------------------------- */

        .btn-modern-login {
            width: 100%;
            height: 54px;

            margin-top: 6px;

            border: 0;
            border-radius: 12px;

            outline: none;

            background:
                linear-gradient(
                    135deg,
                    #1565c0 0%,
                    #1976d2 100%
                );

            color: #ffffff;

            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.3px;

            cursor: pointer;

            box-shadow:
                0 10px 25px rgba(25, 118, 210, 0.25);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;
        }

        .btn-modern-login:hover {
            transform: translateY(-1px);

            box-shadow:
                0 13px 30px rgba(25, 118, 210, 0.32);
        }

        .btn-modern-login:active {
            transform: translateY(0);
        }

        .btn-modern-login:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* -----------------------------------------------------
           INFORMATION BOX
           ----------------------------------------------------- */

        .login-information {
            display: flex;

            margin-top: 27px;

            padding: 14px 16px;

            background: #eef6ff;

            border: 1px solid #d8eaff;
            border-radius: 11px;
        }

        .info-icon {
            flex: 0 0 31px;

            width: 31px;
            height: 31px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-right: 11px;

            border-radius: 50%;

            background: #1976d2;
            color: #ffffff;

            font-size: 15px;
            font-weight: 700;
        }

        .info-text {
            padding-top: 1px;

            font-size: 12px;
            line-height: 1.6;

            color: #5f6c7b;
        }

        .info-text strong {
            display: block;
            margin-bottom: 1px;
            color: #344563;
        }

        /* -----------------------------------------------------
           FOOTER
           ----------------------------------------------------- */

        .login-footer {
            margin-top: 35px;

            text-align: center;

            font-size: 11px;
            line-height: 1.6;

            color: #9aa5b1;
        }

        /* -----------------------------------------------------
           LOADER
           ----------------------------------------------------- */

        .loader-wrapper {
            position: fixed;

            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            z-index: 99999;

            display: none;

            align-items: center;
            justify-content: center;

            background: rgba(15, 30, 50, 0.58);

            backdrop-filter: blur(3px);
        }

        .loader-wrapper.active {
            display: flex;
        }

        .load-content {
            width: 290px;

            padding: 28px 25px;

            background: #ffffff;

            border-radius: 16px;

            text-align: center;

            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.22);
        }

        .loader-spinner {
            width: 39px;
            height: 39px;

            margin: 0 auto 16px;

            border: 4px solid #e4ebf3;
            border-top-color: #1976d2;
            border-radius: 50%;

            animation: modern-spin 0.8s linear infinite;
        }

        .loader-title {
            margin-bottom: 4px;

            font-size: 14px;
            font-weight: 700;

            color: #344563;
        }

        .loader-description {
            font-size: 12px;
            color: #8b98a8;
        }

        @keyframes modern-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* -----------------------------------------------------
           RESPONSIVE
           ----------------------------------------------------- */

        @media (max-width: 1100px) {

            .login-brand-section {
                width: 50%;
                padding: 45px;
            }

            .login-form-section {
                width: 50%;
            }

            .brand-heading {
                font-size: 40px;
            }
        }

        @media (max-width: 850px) {

            .modern-login-page {
                display: block;

                min-height: 100vh;

                background:
                    linear-gradient(
                        135deg,
                        #0d47a1 0%,
                        #1976d2 100%
                    );

                padding: 30px 18px;
            }

            .login-brand-section {
                display: none;
            }

            .login-form-section {
                width: 100%;
                min-height: calc(100vh - 60px);

                padding: 35px 25px;

                border-radius: 24px;

                background: #f8fafc;
            }

            .login-container {
                max-width: 430px;
            }

            .mobile-logo {
                display: block;
            }

            .login-heading {
                text-align: center;
            }
        }

        @media (max-width: 480px) {

            .modern-login-page {
                padding: 15px;
            }

            .login-form-section {
                min-height: calc(100vh - 30px);

                padding: 30px 20px;

                border-radius: 20px;
            }

            .login-heading h2 {
                font-size: 26px;
            }

            .modern-input {
                height: 51px;
            }

            .btn-modern-login {
                height: 52px;
            }
        }

    </style>

</head>


<body>

<div class="modern-login-page">

    <!-- =====================================================
         LEFT / BRANDING SECTION
         ===================================================== -->
    <section class="login-brand-section">

        <div class="brand-content">

            <!-- Logo -->
            <div class="brand-logo-box">

                <div class="brand-logo">

                    <img
                        src="<?= base_url('assets/images/logo_sdit.png') ?>"
                        alt="Logo"
                        onerror="this.style.display='none';"
                    >

                </div>


                <div class="brand-logo-text">

                    <span class="small-title">
                        Sistem Informasi
                    </span>

                    <h2 class="system-name">
                        <?= APP_LONG_NAME ?>
                    </h2>

                </div>

            </div>


            <!-- Main heading -->
            <h1 class="brand-heading">
                Kelola Arus Kas
                <span>Lebih Mudah.</span>
            </h1>


            <p class="brand-description">
                Sistem pencatatan dan pengelolaan arus kas
                yang membantu proses pencatatan transaksi,
                pemantauan saldo, serta penyusunan laporan
                keuangan secara lebih terstruktur.
            </p>


            <!-- Feature badges -->
            <div class="brand-features">

                <div class="feature-item">

                    <span class="feature-check">
                        ✓
                    </span>

                    Pencatatan Transaksi

                </div>


                <div class="feature-item">

                    <span class="feature-check">
                        ✓
                    </span>

                    Monitoring Saldo

                </div>


                <div class="feature-item">

                    <span class="feature-check">
                        ✓
                    </span>

                    Laporan Arus Kas

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         RIGHT / LOGIN SECTION
         ===================================================== -->
    <section class="login-form-section">

        <div class="login-container">

            <!-- Mobile Logo -->
            <div class="mobile-logo">

                <img
                    src="<?= base_url('assets/images/logo.png') ?>"
                    alt="Logo"
                    onerror="this.style.display='none';"
                >

            </div>


            <!-- Heading -->
            <div class="login-heading">

                <span class="welcome-label">
                    Selamat Datang
                </span>

                <h2>
                    Masuk ke Sistem
                </h2>

                <p>
                    Silakan masukkan username dan password
                    untuk mengakses aplikasi.
                </p>

            </div>


            <!-- =================================================
                 LOGIN FORM
                 ================================================= -->
            <form
                class="login-form"
                id="form-login"
                onsubmit="do_login(); return false;"
            >

                <!-- USERNAME -->
                <div class="form-group">

                    <label for="username">
                        Username
                    </label>


                    <div class="input-wrapper">

                        <span class="input-icon">

                            <svg viewBox="0 0 24 24">

                                <path
                                    d="M20 21a8 8 0 0 0-16 0"
                                ></path>

                                <circle
                                    cx="12"
                                    cy="7"
                                    r="4"
                                ></circle>

                            </svg>

                        </span>


                        <input
                            class="modern-input"
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>


                    <div class="input-wrapper">

                        <span class="input-icon">

                            <svg viewBox="0 0 24 24">

                                <rect
                                    x="4"
                                    y="10"
                                    width="16"
                                    height="10"
                                    rx="2"
                                ></rect>

                                <path
                                    d="M8 10V7a4 4 0 0 1 8 0v3"
                                ></path>

                            </svg>

                        </span>


                        <input
                            class="modern-input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >


                        <!-- Show / Hide password -->
                        <button
                            type="button"
                            class="password-toggle"
                            id="password-toggle"
                            onclick="toggle_password()"
                            title="Tampilkan password"
                            aria-label="Tampilkan password"
                        >

                            <svg
                                id="eye-icon"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"
                                ></path>

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                ></circle>

                            </svg>

                        </button>

                    </div>

                </div>


                <!-- LOGIN BUTTON -->
                <button
                    class="btn-modern-login"
                    type="submit"
                    id="btn-login"
                >
                    Masuk ke Sistem
                </button>

            </form>


            <!-- Information -->
            <div class="login-information">

                <div class="info-icon">
                    i
                </div>


                <div class="info-text">

                    <strong>
                        Informasi Login
                    </strong>

                    Gunakan username dan password
                    yang telah terdaftar untuk mengakses sistem.

                </div>

            </div>


            <!-- Footer -->
            <div class="login-footer">

                &copy; <?= date('Y') ?>
                <?= APP_LONG_NAME ?>

                <br>

                Sistem Pencatatan dan Pengelolaan Alur Kas

            </div>

        </div>

    </section>

</div>


<!-- =========================================================
     LOADER
     ========================================================= -->
<div
    class="loader-wrapper"
    id="loader"
>

    <div class="load-content">

        <div class="loader-spinner"></div>

        <div class="loader-title">
            Mohon tunggu...
        </div>

        <div class="loader-description">
            Sedang memproses login
        </div>

    </div>

</div>


<!-- =========================================================
     TEMPLATE SCRIPT
     ========================================================= -->
<?php view("templates/script") ?>


<script>

    /*
    |--------------------------------------------------------------------------
    | SHOW / HIDE PASSWORD
    |--------------------------------------------------------------------------
    */

    function toggle_password() {

        var password =
            document.getElementById("password");

        var button =
            document.getElementById("password-toggle");


        if (password.type === "password") {

            password.type = "text";

            button.title =
                "Sembunyikan password";

            button.setAttribute(
                "aria-label",
                "Sembunyikan password"
            );

        } else {

            password.type = "password";

            button.title =
                "Tampilkan password";

            button.setAttribute(
                "aria-label",
                "Tampilkan password"
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOADER
    |--------------------------------------------------------------------------
    */

    function show_login_loader() {

        var loader =
            document.getElementById("loader");

        var button =
            document.getElementById("btn-login");


        if (loader) {
            loader.classList.add("active");
        }


        if (button) {

            button.disabled = true;

            button.innerHTML =
                "Memproses...";
        }
    }


    function hide_login_loader() {

        var loader =
            document.getElementById("loader");

        var button =
            document.getElementById("btn-login");


        if (loader) {
            loader.classList.remove("active");
        }


        if (button) {

            button.disabled = false;

            button.innerHTML =
                "Masuk ke Sistem";
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    function do_login() {

        var username =
            document.getElementById("username").value.trim();

        var password =
            document.getElementById("password").value;


        /*
         * Validasi sederhana sebelum request
         */
        if (username === "") {

            show_toast(
                "Peringatan",
                "Username harus diisi.",
                "warning"
            );

            document
                .getElementById("username")
                .focus();

            return false;
        }


        if (password === "") {

            show_toast(
                "Peringatan",
                "Password harus diisi.",
                "warning"
            );

            document
                .getElementById("password")
                .focus();

            return false;
        }


        show_login_loader();


        /*
         * Tetap menggunakan mekanisme AJAX
         * aplikasi lama.
         */
        var form_data =
            $("#form-login").serializeArray();


        ajax_post(

            '<?= base_url() ?>login/do_login',

            form_data,

            function(resp) {

                console.log(resp);

                try {

                    var json =
                        JSON.parse(resp);

                    var is_success =
                        json.is_success;

                    var message =
                        json.message;


                    /*
                     * LOGIN BERHASIL
                     */
                    if (is_success == 1) {

                        show_toast(
                            "Success",
                            "Login berhasil. Mengarahkan ke halaman utama...",
                            "success"
                        );


                        window.location.href =
                            "<?= base_url('') ?>";

                    }

                    /*
                     * LOGIN GAGAL
                     */
                    else {

                        hide_login_loader();


                        show_toast(
                            "Login Gagal",
                            message
                                ? message
                                : "Username atau password tidak sesuai.",
                            "error"
                        );

                    }

                }

                catch (error) {

                    hide_login_loader();


                    console.error(
                        "Login response error:",
                        error
                    );


                    show_toast(
                        "Error",
                        "Application Response Error",
                        "error"
                    );
                }

            }

        );


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | AUTO FOCUS USERNAME
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        "DOMContentLoaded",
        function() {

            var username =
                document.getElementById("username");

            if (username) {
                username.focus();
            }

        }
    );

</script>

</body>
</html>