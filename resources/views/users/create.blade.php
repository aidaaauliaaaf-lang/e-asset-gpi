
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna | E-Asset Golden Piping Indonesia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --red: #D71920;
            --red-dark: #B51219;
            --dark: #20252B;
            --bg: #F2F4F7;
            --muted: #667085;
            --border: #E1E5EA;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--dark);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .sidebar {
            width: 255px;
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            background: linear-gradient(180deg, #20252B, #15191E);
            color: white;
            z-index: 10;
        }

        .brand {
            padding: 25px 22px;
            border-bottom: 1px solid #41464D;
        }

        .brand-title {
            font-size: 25px;
            font-weight: 800;
        }

        .brand-title i { color: var(--red); }

        .brand-subtitle {
            color: #D1D5DB;
            font-size: 11px;
            margin-top: 5px;
        }

        .role-label {
            display: inline-block;
            margin-top: 13px;
            padding: 5px 10px;
            background: rgba(215,25,32,.18);
            color: #FFD9DA;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .nav-area { padding: 18px 12px; }

        .nav-heading {
            padding: 8px 12px;
            color: #A7ADB5;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin: 4px 0;
            border-radius: 8px;
            color: #E1E4E8;
            text-decoration: none;
            font-size: 14px;
        }

        .menu-link i {
            width: 20px;
            font-size: 17px;
            text-align: center;
        }

        .menu-link:hover,
        .menu-link.active {
            background: var(--red);
            color: white;
        }

        .logout-button {
            width: 100%;
            padding: 11px;
            background: var(--red);
            color: white;
            border: 0;
            border-radius: 8px;
            font-weight: 600;
        }

        .logout-button:hover { background: var(--red-dark); }

        .main-area { margin-left: 255px; min-height: 100vh; }

        .topbar {
            min-height: 68px;
            padding: 14px 30px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .topbar-label { color: var(--muted); font-size: 13px; }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #FCE7E7;
            color: var(--red);
            display: grid;
            place-items: center;
            font-size: 18px;
        }

        .content { padding: 30px; }

        .page-banner {
            position: relative;
            overflow: hidden;
            background: linear-gradient(115deg, #20252B, #414750);
            border-left: 6px solid var(--red);
            border-radius: 13px;
            color: white;
            padding: 28px 30px;
            margin-bottom: 24px;
        }

        .page-banner::after {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            right: -40px;
            top: -65px;
            border: 20px solid rgba(255,255,255,.06);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-banner h1 {
            font-size: 27px;
            font-weight: 750;
            margin: 0 0 8px;
        }

        .page-banner p {
            color: #E1E4E8;
            margin: 0;
            font-size: 14px;
        }

        .form-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 7px 24px rgba(32,37,43,.05);
            overflow: hidden;
        }

        .form-card-header {
            padding: 22px 26px;
            border-bottom: 1px solid #EAECF0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .header-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: #FCE7E7;
            color: var(--red);
            font-size: 22px;
        }

        .form-card-header h2 {
            margin: 0;
            font-size: 19px;
            font-weight: 750;
        }

        .form-card-header p {
            color: var(--muted);
            margin: 4px 0 0;
            font-size: 13px;
        }

        .form-body { padding: 26px; }

        .section-label {
            color: var(--red);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 17px;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #344054;
        }

        .form-control,
        .form-select {
            min-height: 45px;
            border: 1px solid #D0D5DD;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(215,25,32,.11);
        }

        .field-hint {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        .input-group .form-control { min-width: 0; }

        .password-toggle {
            border: 1px solid #D0D5DD;
            background: white;
            color: #475467;
        }

        .password-toggle:hover {
            background: #F2F4F7;
        }

        .role-info {
            padding: 15px;
            border: 1px solid #F3C7C9;
            background: #FFF7F7;
            border-radius: 9px;
            color: #7F1D1D;
            font-size: 13px;
            line-height: 1.6;
        }

        .form-footer {
            padding: 19px 26px;
            border-top: 1px solid #EAECF0;
            background: #FAFAFA;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-gpi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 17px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 650;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-save {
            border: 1px solid var(--red);
            background: var(--red);
            color: white;
        }

        .btn-save:hover {
            background: var(--red-dark);
            border-color: var(--red-dark);
            color: white;
        }

        .btn-back {
            border: 1px solid #D0D5DD;
            background: white;
            color: #344054;
        }

        .btn-back:hover {
            background: #F2F4F7;
            color: #20252B;
        }

        .validation-errors {
            padding: 14px 18px;
            background: #FFF1F1;
            border: 1px solid #F3C7C9;
            border-radius: 9px;
            color: #B51219;
            margin-bottom: 22px;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .sidebar { width: 76px; }
            .brand { padding: 18px 5px; text-align: center; }
            .brand-title { font-size: 15px; }
            .brand-subtitle, .role-label, .nav-heading, .menu-text {
                display: none;
            }
            .nav-area { padding: 12px 7px; }
            .menu-link { justify-content: center; padding: 13px 5px; }
            .menu-link i { font-size: 20px; }
            .main-area { margin-left: 76px; }
            .topbar { padding: 12px 15px; }
            .content { padding: 15px; }
            .page-banner { padding: 23px 19px; }
            .page-banner h1 { font-size: 22px; }
            .form-card-header, .form-body { padding: 19px; }
            .form-footer { padding: 17px 19px; }
        }
    </style>
</head>

<body>
@php
    $role = session('user_role');
    $currentRoute = request()->route()
        ? request()->route()->getName()
        : '';
@endphp

<aside class="sidebar">
    <div class="brand">
        <div class="brand-title">
            <i class="bi bi-box-seam-fill"></i> E-Asset
        </div>
        <div class="brand-subtitle">GOLDEN PIPING INDONESIA</div>
        <span class="role-label">
            <i class="bi bi-shield-check me-1"></i>
            {{ ucfirst($role ?? 'Tidak diketahui') }}
        </span>
    </div>

    <nav class="nav-area">
        <div class="nav-heading">MENU UTAMA</div>

        <a class="menu-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}"
           href="{{ route('dashboard') }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        @if(in_array($role, ['admin', 'karyawan'], true))
            <a class="menu-link {{ str_starts_with($currentRoute, 'assets.') ? 'active' : '' }}"
               href="{{ route('assets.index') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span class="menu-text">Data Aset</span>
            </a>
        @endif

        @if(in_array($role, ['admin', 'pimpinan'], true))
            <a class="menu-link {{ str_starts_with($currentRoute, 'mutations.') ? 'active' : '' }}"
               href="{{ route('mutations.index') }}">
                <i class="bi bi-arrow-left-right"></i>
                <span class="menu-text">Mutasi Aset</span>
            </a>

            <a class="menu-link {{ str_starts_with($currentRoute, 'maintenances.') ? 'active' : '' }}"
               href="{{ route('maintenances.index') }}">
                <i class="bi bi-tools"></i>
                <span class="menu-text">Maintenance</span>
            </a>
        @endif

        @if($role === 'admin')
            <a class="menu-link {{ str_starts_with($currentRoute, 'users.') ? 'active' : '' }}"
               href="{{ route('users.index') }}">
                <i class="bi bi-people-fill"></i>
                <span class="menu-text">Manajemen Pengguna</span>
            </a>
        @endif

        <hr style="border-color:#555B63; margin:18px 10px;">

        <form action="{{ route('logout') }}" method="POST" class="px-2">
            @csrf
            <button type="submit" class="logout-button">
                <i class="bi bi-box-arrow-right"></i>
                <span class="menu-text">Logout</span>
            </button>
        </form>
    </nav>
</aside>

<div class="main-area">
    <header class="topbar">
        <div class="topbar-label">
            <i class="bi bi-building me-1"></i>
            Sistem Informasi Manajemen Aset Perusahaan
        </div>

        <div class="topbar-user">
            <div class="avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <span>{{ session('user_name', 'Pengguna') }}</span>
        </div>
    </header>

    <main class="content">
        <section class="page-banner">
            <h1>
                <i class="bi bi-person-plus-fill me-2"></i>
                Tambah Pengguna
            </h1>
            <p>Buat akun dan tentukan hak akses pengguna E-Asset Golden Piping Indonesia.</p>
        </section>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="validation-errors">
                <strong><i class="bi bi-exclamation-circle-fill me-1"></i>
                    Periksa kembali data berikut:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <section class="form-card">
                <div class="form-card-header">
                    <div class="header-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>
                    <div>
                        <h2>Informasi Akun</h2>
                        <p>Lengkapi identitas, role, dan kata sandi pengguna.</p>
                    </div>
                </div>

                <div class="form-body">
                    <div class="section-label">
                        <i class="bi bi-person-lines-fill me-1"></i>
                        Identitas Pengguna
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama lengkap"
                               maxlength="255" autocomplete="name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input id="email" type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="nama@goldenpiping.co.id"
                               maxlength="255" autocomplete="email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label">Role Pengguna</label>
                        <select id="role" name="role"
                                class="form-select @error('role') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih hak akses --</option>
                            <option value="admin" @selected(old('role') === 'admin')>
                                Admin — pengelolaan sistem
                            </option>
                            <option value="pimpinan" @selected(old('role') === 'pimpinan')>
                                Pimpinan — melihat laporan
                            </option>
                            <option value="karyawan" @selected(old('role') === 'karyawan')>
                                Karyawan — input dan melihat aset
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="field-hint">
                            Hak akses menentukan menu dan fitur yang dapat dibuka pengguna.
                        </div>
                    </div>

                    <div class="role-info mb-4">
                        <i class="bi bi-shield-lock-fill me-1"></i>
                        <strong>Perhatian:</strong>
                        Pilih role sesuai tanggung jawab pengguna. Admin memiliki akses pengelolaan,
                        sedangkan Pimpinan dan Karyawan memiliki batasan akses masing-masing.
                    </div>

                    <hr style="border-color:#EAECF0; margin:25px 0;">

                    <div class="section-label">
                        <i class="bi bi-lock-fill me-1"></i>
                        Keamanan Akun
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Buat password"
                                   minlength="8" autocomplete="new-password" required>
                            <button class="btn password-toggle" type="button"
                                    onclick="togglePassword('password', this)"
                                    aria-label="Tampilkan atau sembunyikan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="field-hint">Gunakan minimal 8 karakter.</div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Password
                        </label>
                        <div class="input-group">
                            <input id="password_confirmation" type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password"
                                   minlength="8" autocomplete="new-password" required>
                            <button class="btn password-toggle" type="button"
                                    onclick="togglePassword('password_confirmation', this)"
                                    aria-label="Tampilkan atau sembunyikan konfirmasi password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('users.index') }}" class="btn-gpi btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit" class="btn-gpi btn-save">
                        <i class="bi bi-person-check-fill"></i>
                        Simpan Pengguna
                    </button>
                </div>
            </section>
        </form>
    </main>
</div>

<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
</body>
</html>
