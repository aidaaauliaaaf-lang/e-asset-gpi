
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Asset | Golden Piping Indonesia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --gpi-red: #D71920;
            --gpi-red-dark: #B51219;
            --gpi-dark: #20252B;
            --gpi-dark-light: #30363D;
            --gpi-bg: #F2F4F7;
            --gpi-white: #FFFFFF;
            --gpi-text: #20252B;
            --gpi-muted: #667085;
            --gpi-border: #E1E5EA;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--gpi-bg);
            color: var(--gpi-text);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 255px;
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            background: linear-gradient(180deg, #20252B, #15191E);
            color: white;
            z-index: 1000;
            box-shadow: 5px 0 25px rgba(32, 37, 43, .08);
        }

        .brand {
            padding: 25px 22px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .brand-title {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: .3px;
        }

        .brand-icon {
            color: var(--gpi-red);
        }

        .brand-subtitle {
            margin-top: 4px;
            color: #D1D5DB;
            font-size: 12px;
        }

        .role-label {
            display: inline-block;
            margin-top: 13px;
            padding: 5px 10px;
            border-radius: 20px;
            background: rgba(215,25,32,.17);
            color: #FFD9DA;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .nav-area {
            padding: 18px 12px;
        }

        .nav-heading {
            padding: 8px 12px;
            color: #A7ADB5;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .sidebar a.menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 0;
            padding: 12px 14px;
            border-radius: 9px;
            color: #E1E4E8;
            text-decoration: none;
            font-size: 14px;
            transition: .2s ease;
        }

        .sidebar a.menu-link i {
            width: 20px;
            font-size: 17px;
            text-align: center;
        }

        .sidebar a.menu-link:hover,
        .sidebar a.menu-link.active {
            color: white;
            background: var(--gpi-red);
            box-shadow: 0 5px 14px rgba(215,25,32,.22);
        }

        .sidebar-divider {
            margin: 18px 10px;
            border-color: rgba(255,255,255,.15);
        }

        .logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            padding: 11px;
            border: 1px solid var(--gpi-red);
            border-radius: 9px;
            background: var(--gpi-red);
            color: white;
            font-weight: 600;
            transition: .2s;
        }

        .logout-button:hover {
            background: var(--gpi-red-dark);
            border-color: var(--gpi-red-dark);
        }

        /* AREA KONTEN */
        .main-area {
            min-height: 100vh;
            margin-left: 255px;
        }

        .topbar {
            min-height: 66px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 14px 30px;
            background: white;
            border-bottom: 1px solid var(--gpi-border);
        }

        .topbar-title {
            font-size: 13px;
            color: var(--gpi-muted);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #FCE7E7;
            color: var(--gpi-red);
            font-size: 17px;
        }

        .content {
            padding: 30px;
        }

        /* KARTU DAN TABEL */
        .content > .container,
        .content > .container-fluid {
            max-width: 100%;
        }

        .content .card {
            border: 1px solid var(--gpi-border);
            border-radius: 13px;
            box-shadow: 0 5px 20px rgba(32,37,43,.045);
        }

        .content .btn-primary {
            border-color: var(--gpi-red);
            background: var(--gpi-red);
        }

        .content .btn-primary:hover {
            border-color: var(--gpi-red-dark);
            background: var(--gpi-red-dark);
        }

        .content .table {
            vertical-align: middle;
        }

        .content .table thead th {
            padding: 14px 12px;
            border-bottom: 1px solid var(--gpi-border);
            background: #F2F4F7;
            color: #344054;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .content .table tbody td {
            padding: 13px 12px;
            border-color: #EAECF0;
            font-size: 13px;
        }

        .content .form-control:focus,
        .content .form-select:focus {
            border-color: var(--gpi-red);
            box-shadow: 0 0 0 .2rem rgba(215,25,32,.12);
        }

        .content .btn-outline-primary {
            color: var(--gpi-red);
            border-color: var(--gpi-red);
        }

        .content .btn-outline-primary:hover {
            color: white;
            background: var(--gpi-red);
            border-color: var(--gpi-red);
        }

        .content .alert-success {
            border-color: #B7E4C7;
            background: #E9F7EF;
            color: #187443;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 76px;
            }

            .brand {
                padding: 18px 8px;
                text-align: center;
            }

            .brand-title {
                font-size: 16px;
            }

            .brand-subtitle,
            .role-label,
            .nav-heading,
            .menu-text {
                display: none;
            }

            .nav-area {
                padding: 14px 8px;
            }

            .sidebar a.menu-link {
                justify-content: center;
                padding: 13px 5px;
            }

            .sidebar a.menu-link i {
                font-size: 20px;
            }

            .sidebar form {
                padding: 0 !important;
            }

            .logout-button {
                font-size: 0;
            }

            .logout-button i {
                font-size: 18px;
            }

            .main-area {
                margin-left: 76px;
            }

            .topbar {
                padding: 12px 15px;
            }

            .content {
                padding: 15px;
            }
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
            <i class="bi bi-box-seam-fill brand-icon me-1"></i>
            E-Asset
        </div>

        <div class="brand-subtitle">
            GOLDEN PIPING INDONESIA
        </div>

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

        <hr class="sidebar-divider">

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
        <div class="topbar-title">
            <i class="bi bi-building me-1"></i>
            Sistem Informasi Manajemen Aset Perusahaan
        </div>

        <div class="topbar-user">
            <div class="user-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <span>{{ session('user_name', 'Pengguna') }}</span>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
