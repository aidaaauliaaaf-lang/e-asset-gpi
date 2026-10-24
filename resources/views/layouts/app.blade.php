
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Asset | Golden Piping Indonesia')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --gpi-red: #D71920;
            --gpi-red-dark: #B51219;
            --gpi-dark: #20252B;
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
            overflow-y: auto;
            background: linear-gradient(180deg, #20252B, #15191E);
            color: white;
            z-index: 1040;
            box-shadow: 5px 0 25px rgba(32, 37, 43, .08);
        }

        .brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .brand-title {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: .3px;
            color: white;
        }

        .brand-icon {
            color: var(--gpi-red);
        }

        .brand-subtitle {
            margin-top: 4px;
            color: #D1D5DB;
            font-size: 11px;
        }

        .role-label {
            display: inline-block;
            margin-top: 12px;
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

        .sidebar .menu-link,
        .sidebar .submenu-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            margin: 4px 0;
            padding: 12px 14px;
            border: 0;
            border-radius: 9px;
            color: #E1E4E8;
            background: transparent;
            text-decoration: none;
            font-family: inherit;
            font-size: 14px;
            text-align: left;
            transition: .2s ease;
        }

        .sidebar .menu-link i,
        .sidebar .submenu-toggle > i:first-child {
            width: 20px;
            font-size: 17px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar .menu-link:hover,
        .sidebar .menu-link.active,
        .sidebar .submenu-toggle:hover,
        .sidebar .submenu-toggle.active {
            color: white;
            background: var(--gpi-red);
            box-shadow: 0 5px 14px rgba(215,25,32,.22);
        }

        .submenu-toggle {
            cursor: pointer;
        }

        .submenu-arrow {
            margin-left: auto;
            font-size: 12px !important;
            transition: transform .2s ease;
        }

        .submenu-toggle[aria-expanded="true"] .submenu-arrow {
            transform: rotate(180deg);
        }

        .submenu {
            padding: 2px 0 6px 23px;
        }

        .sidebar .submenu-link {
            display: block;
            margin: 3px 0;
            padding: 10px 12px;
            border-radius: 7px;
            color: #D1D5DB;
            text-decoration: none;
            font-size: 12px;
            line-height: 1.45;
            transition: .2s ease;
        }

        .sidebar .submenu-link:hover,
        .sidebar .submenu-link.active {
            background: rgba(215,25,32,.2);
            color: white;
        }

        .sidebar-divider {
            margin: 18px 10px;
            border-color: rgba(255,255,255,.15);
        }

        .logout-button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--gpi-red);
            border-radius: 9px;
            background: var(--gpi-red);
            color: white;
            font-weight: 600;
            font-size: 14px;
            transition: .2s;
        }

        .logout-button:hover {
            background: var(--gpi-red-dark);
            border-color: var(--gpi-red-dark);
        }

        /* KONTEN UTAMA */
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
            overflow: hidden;
            flex-shrink: 0;
        }

        .content {
            padding: 30px;
        }

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

        /* RESPONSIVE */
        .mobile-menu-button {
            display: none;
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 255px;
                transform: translateX(-100%);
                transition: transform .2s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.45);
                z-index: 1030;
            }

            .main-area {
                margin-left: 0;
            }

            .mobile-menu-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                padding: 12px 15px;
            }

            .topbar-title {
                display: none;
            }

            .content {
                padding: 15px;
            }
        }

        @media print {
            .sidebar,
            .topbar,
            .sidebar-overlay,
            .no-print,
            .btn,
            form {
                display: none !important;
            }

            .main-area {
                margin-left: 0 !important;
            }

            .content {
                padding: 0 !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
</head>

<body>

@php
    $role = strtolower(session('user_role', ''));

    $currentRoute = request()->route()
        ? (request()->route()->getName() ?? '')
        : '';

    $isAdmin = $role === 'admin';
    $isKaryawan = $role === 'karyawan';
    $isPimpinan = $role === 'pimpinan';

    $canManageAssets = $isAdmin || $isKaryawan;
    $canViewReports = $isAdmin || $isPimpinan;

    $isReportRoute = request()->is('laporan*')
        || str_starts_with($currentRoute, 'reports.');

    $isProfileRoute = str_starts_with($currentRoute, 'profile.');
    $isAssetRoute = str_starts_with($currentRoute, 'assets.');
    $isScanRoute = str_starts_with($currentRoute, 'asset-scans.');
    $isMutationRoute = str_starts_with($currentRoute, 'mutations.');
    $isMaintenanceRoute = str_starts_with($currentRoute, 'maintenances.');
    $isUserRoute = str_starts_with($currentRoute, 'users.');

    $reportType = request()->query('jenis', 'aset');
@endphp

<div class="sidebar-overlay" id="sidebarOverlay"
     onclick="toggleSidebar()"></div>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">

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
            {{ ucfirst($role ?: 'Pengguna') }}
        </span>
    </div>

    <nav class="nav-area">
        <div class="nav-heading">MENU UTAMA</div>

        {{-- DASHBOARD --}}
        <a class="menu-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}"
           href="{{ route('dashboard') }}">
            <i class="bi bi-house-door-fill"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        {{-- SIDEBAR KHUSUS PIMPINAN --}}
        @if($isPimpinan)

            <a class="menu-link {{ $isAssetRoute ? 'active' : '' }}"
               href="{{ route('assets.index') }}">
                <i class="bi bi-calendar2-week-fill"></i>
                <span class="menu-text">Data Aset</span>
            </a>

            {{-- MENU LAPORAN DENGAN SUBMENU --}}
            <button type="button"
                    class="submenu-toggle {{ $isReportRoute ? 'active' : '' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#pimpinanReports"
                    aria-expanded="{{ $isReportRoute ? 'true' : 'false' }}"
                    aria-controls="pimpinanReports">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span class="menu-text flex-grow-1">Laporan</span>
                <i class="bi bi-chevron-down submenu-arrow"></i>
            </button>

            <div class="collapse {{ $isReportRoute ? 'show' : '' }}"
                 id="pimpinanReports">
                <div class="submenu">

                    <a class="submenu-link {{ $isReportRoute && $reportType === 'aset' ? 'active' : '' }}"
                       href="{{ route('reports.index', ['jenis' => 'aset']) }}">
                        Laporan Aset
                    </a>

                    <a class="submenu-link {{ $isReportRoute && $reportType === 'mutasi' ? 'active' : '' }}"
                       href="{{ route('reports.index', ['jenis' => 'mutasi']) }}">
                        Laporan Mutasi
                    </a>

                    <a class="submenu-link {{ $isReportRoute && $reportType === 'pemeliharaan' ? 'active' : '' }}"
                       href="{{ route('reports.index', ['jenis' => 'pemeliharaan']) }}">
                        Laporan Pemeliharaan
                    </a>

                </div>
            </div>

            {{-- PROFIL PIMPINAN --}}
            <a class="menu-link mt-2 {{ $isProfileRoute ? 'active' : '' }}"
               href="{{ route('profile.show') }}">
                <i class="bi bi-person-fill"></i>
                <span class="menu-text">Profil</span>
            </a>

        @else

            {{-- MENU ADMIN DAN KARYAWAN --}}
            @if($canManageAssets)

                <a class="menu-link {{ $isAssetRoute && !in_array($currentRoute, ['assets.create', 'assets.store'], true) ? 'active' : '' }}"
                   href="{{ route('assets.index') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span class="menu-text">Data Aset</span>
                </a>

                @if(\Illuminate\Support\Facades\Route::has('assets.create'))
                    <a class="menu-link {{ in_array($currentRoute, ['assets.create', 'assets.store'], true) ? 'active' : '' }}"
                       href="{{ route('assets.create') }}">
                        <i class="bi bi-clipboard-plus-fill"></i>
                        <span class="menu-text">Input Aset</span>
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('asset-scans.index'))
                    <a class="menu-link {{ $isScanRoute ? 'active' : '' }}"
                       href="{{ route('asset-scans.index') }}">
                        <i class="bi bi-qr-code-scan"></i>
                        <span class="menu-text">Scan QR Code</span>
                    </a>
                @endif

            @endif

            <a class="menu-link {{ $isProfileRoute ? 'active' : '' }}"
               href="{{ route('profile.show') }}">
                <i class="bi bi-person-circle"></i>
                <span class="menu-text">Profil Karyawan</span>
            </a>

            {{-- MENU TAMBAHAN KHUSUS ADMIN --}}
            @if($isAdmin)

                @if(\Illuminate\Support\Facades\Route::has('mutations.index'))
                    <a class="menu-link {{ $isMutationRoute ? 'active' : '' }}"
                       href="{{ route('mutations.index') }}">
                        <i class="bi bi-arrow-left-right"></i>
                        <span class="menu-text">Mutasi Aset</span>
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('maintenances.index'))
                    <a class="menu-link {{ $isMaintenanceRoute ? 'active' : '' }}"
                       href="{{ route('maintenances.index') }}">
                        <i class="bi bi-tools"></i>
                        <span class="menu-text">Pemeliharaan</span>
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('reports.index'))
                    <a class="menu-link {{ $isReportRoute ? 'active' : '' }}"
                       href="{{ route('reports.index') }}">
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span class="menu-text">Laporan</span>
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('users.index'))
                    <a class="menu-link {{ $isUserRoute ? 'active' : '' }}"
                       href="{{ route('users.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span class="menu-text">Manajemen Pengguna</span>
                    </a>
                @endif

            @endif

        @endif

        <hr class="sidebar-divider">

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST" class="px-2">
            @csrf

            <button type="submit" class="logout-button">
                <i class="bi bi-box-arrow-right"></i>
                <span class="menu-text">Logout</span>
            </button>
        </form>
    </nav>
</aside>

{{-- KONTEN UTAMA --}}
<div class="main-area">

    <header class="topbar">
        <div class="d-flex align-items-center gap-3">

            <button type="button"
                    class="btn btn-outline-secondary mobile-menu-button"
                    onclick="toggleSidebar()"
                    aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="topbar-title">
                <i class="bi bi-building me-1"></i>
                Sistem Informasi Manajemen Aset Perusahaan
            </div>
        </div>

        <div class="topbar-user">
            <div class="user-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <span>{{ session('user_name', 'Pengguna') }}</span>
        </div>
    </header>

    <main class="content">

        {{-- NOTIFIKASI SUKSES --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"
                 role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Tutup"></button>
            </div>
        @endif

        {{-- NOTIFIKASI ERROR --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show"
                 role="alert">
                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Tutup"></button>
            </div>
        @endif

        {{-- VALIDASI --}}
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ISI HALAMAN --}}
        @yield('content')

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
</script>

</body>
</html>
