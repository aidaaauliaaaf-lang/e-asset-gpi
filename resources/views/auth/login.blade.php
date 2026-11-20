
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Asset GPI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #eef2f8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 18px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            width: 650px;
            height: 650px;
            border: 65px solid rgba(220, 38, 38, .08);
            border-radius: 50%;
            top: -390px;
            left: -180px;
        }

        body::after {
            content: "";
            position: fixed;
            width: 600px;
            height: 600px;
            border: 65px solid rgba(18, 49, 91, .07);
            border-radius: 50%;
            bottom: -420px;
            right: -170px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 470px;
            position: relative;
            z-index: 2;
        }

        .login-card {
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 22px 65px rgba(15, 23, 42, .16);
            border: 1px solid rgba(255,255,255,.9);
        }

        /* HEADER */
        .login-header {
            background: linear-gradient(135deg, #18375f, #0b1d37);
            color: white;
            text-align: center;
            padding: 30px 25px 27px;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            border-radius: 0 0 100% 0;
            background: #dc1f2b;
            top: -90px;
            left: -75px;
        }

        .login-header::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 100% 0 0 0;
            background: #dc1f2b;
            bottom: -105px;
            right: -75px;
        }

        .logo-container {
            width: 120px;
            height: 90px;
            background: white;
            border-radius: 13px;
            margin: 0 auto 15px;
            padding: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 5px 18px rgba(0,0,0,.12);
        }

        .logo-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .login-header h1 {
            font-size: 29px;
            font-weight: 800;
            letter-spacing: 1.5px;
            margin: 0 0 5px;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            font-size: 12px;
            letter-spacing: 1.6px;
            color: #dbeafe;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .brand-line {
            width: 100px;
            height: 5px;
            background: linear-gradient(to right, white 50%, #e31e2b 50%);
            border-radius: 10px;
            margin: 17px auto 0;
            position: relative;
            z-index: 1;
        }

        /* FORM BODY */
        .login-body {
            padding: 29px 36px 32px;
        }

        .login-title {
            text-align: center;
            margin-bottom: 27px;
        }

        .login-title h2 {
            color: #142e50;
            font-size: 27px;
            font-weight: 750;
            margin-bottom: 7px;
        }

        .login-title p {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 21px;
        }

        .form-label {
            color: #18375f;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .input-box {
            display: flex;
            align-items: center;
            width: 100%;
            height: 53px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            transition: .2s;
            overflow: hidden;
        }

        .input-box:focus-within {
            background: white;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220,38,38,.10);
        }

        .input-icon {
            width: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 18px;
        }

        .input-box input {
            flex: 1;
            min-width: 0;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: #1e293b;
            font-size: 14px;
            padding: 0 10px 0 0;
        }

        .input-box input::placeholder {
            color: #94a3b8;
        }

        .toggle-password {
            border: none;
            background: transparent;
            color: #64748b;
            padding: 0 15px;
            height: 100%;
            cursor: pointer;
            font-size: 18px;
        }

        .toggle-password:hover {
            color: #dc2626;
        }

        /* LOGIN BUTTON */
        .login-button {
            width: 100%;
            height: 53px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #ed1c2b, #bd1520);
            color: white;
            font-size: 16px;
            font-weight: 750;
            letter-spacing: .4px;
            margin-top: 5px;
            box-shadow: 0 7px 17px rgba(220,38,38,.20);
            transition: .2s;
        }

        .login-button:hover {
            background: linear-gradient(135deg, #cf1724, #991b1b);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(220,38,38,.25);
        }

        .login-button i {
            margin-right: 8px;
        }

        /* FOOTER */
        .login-footer {
            background: #f4f6fa;
            border-top: 1px solid #e8edf4;
            padding: 17px 15px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }

        .login-footer strong {
            color: #142e50;
            font-size: 14px;
        }

        .footer-line {
            width: 55px;
            height: 3px;
            background: #dc2626;
            display: inline-block;
            vertical-align: middle;
            margin: 0 12px;
            border-radius: 5px;
        }

        .alert {
            font-size: 13px;
            border-radius: 9px;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .login-body {
                padding: 25px 22px;
            }

            .login-header {
                padding: 26px 18px;
            }

            .login-title h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        {{-- LOGO DAN IDENTITAS PERUSAHAAN --}}
        <div class="login-header">

            <div class="logo-container">
                <img src="{{ asset('images/logo-gpi.png') }}"
                     alt="Logo GPI">
            </div>

            <h1>E-ASSET</h1>
            <p>PT GOLDEN PIPING INDONESIA</p>

            <div class="brand-line"></div>

        </div>

        {{-- FORM LOGIN --}}
        <div class="login-body">

            <div class="login-title">
                <h2>LOGIN</h2>
                <p>Silakan masuk untuk mengakses sistem E-Asset</p>
            </div>

            {{-- PESAN ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                {{-- USERNAME --}}
                <div class="form-group">

                    <label class="form-label">Username</label>

                    <div class="input-box">
                        <div class="input-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <input
                            type="text"
                            name="user"
                            placeholder="Masukkan username"
                            value="{{ old('user') }}"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                </div>

                {{-- PASSWORD --}}
                <div class="form-group">

                    <label class="form-label">Password</label>

                    <div class="input-box">
                        <div class="input-icon">
                            <i class="bi bi-lock-fill"></i>
                        </div>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword()"
                            aria-label="Tampilkan atau sembunyikan password"
                        >
                            <i class="bi bi-eye-fill" id="eyeIcon"></i>
                        </button>
                    </div>

                </div>

                {{-- TOMBOL LOGIN --}}
                <button type="submit" class="login-button">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </button>

            </form>

        </div>

        {{-- FOOTER --}}
        <div class="login-footer">
            <span class="footer-line"></span>
            <strong>E-Asset Management System</strong>
            <span class="footer-line"></span>
            <br>
            PT Golden Piping Indonesia &copy; {{ date('Y') }}
        </div>

    </div>

</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
        } else {
            password.type = 'password';
            eyeIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
        }
    }
</script>

</body>
</html>
