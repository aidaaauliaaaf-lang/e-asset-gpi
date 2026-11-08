```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - E-Asset GPI</title>

    <style>
        :root {
            --red: #D71920;
            --red-dark: #B51219;
            --dark: #20252B;
            --bg: #F2F4F7;
            --white: #FFFFFF;
            --text: #29313A;
            --muted: #6B7280;
            --border: #E3E7EC;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .sidebar {
            width: 255px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--dark);
            color: var(--white);
            padding: 25px 17px;
            overflow-y: auto;
        }

        .brand {
            padding: 0 12px 24px;
            border-bottom: 1px solid #41464D;
            margin-bottom: 24px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .brand-name span { color: var(--red); }

        .brand-subtitle {
            margin-top: 7px;
            font-size: 11px;
            line-height: 1.5;
            color: #C5CAD0;
            letter-spacing: .5px;
        }

        .nav-title {
            padding: 0 12px;
            margin: 22px 0 10px;
            font-size: 10px;
            color: #9CA3AF;
            font-weight: bold;
            letter-spacing: 1.5px;
        }

        .nav-link {
            display: block;
            padding: 12px;
            margin: 5px 0;
            color: #D1D5DB;
            text-decoration: none;
            border-radius: 7px;
            font-size: 14px;
            transition: .2s;
        }

        .nav-link:hover {
            background: #343A42;
            color: white;
        }

        .nav-link.active {
            background: var(--red);
            color: white;
            font-weight: bold;
        }

        .role-box {
            margin: 22px 7px 0;
            padding: 13px;
            background: #30363E;
            border-radius: 8px;
            font-size: 12px;
            color: #D1D5DB;
        }

        .role-box strong {
            display: block;
            margin-top: 5px;
            color: white;
            font-size: 14px;
        }

        .main {
            margin-left: 255px;
            min-height: 100vh;
        }

        .topbar {
            height: 72px;
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .topbar-title {
            font-size: 14px;
            font-weight: bold;
        }

        .topbar-user {
            font-size: 13px;
            color: var(--muted);
        }

        .content {
            padding: 30px;
            max-width: 1500px;
            margin: auto;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .eyebrow {
            color: var(--red);
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.5px;
            margin-bottom: 9px;
        }

        h1 {
            margin: 0;
            color: var(--dark);
            font-size: 27px;
        }

        .subtitle {
            margin-top: 9px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 17px;
            background: var(--red);
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        .btn:hover {
            background: var(--red-dark);
        }

        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px #20252B08;
        }

        .card-header {
            padding: 20px 23px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-title {
            font-size: 16px;
            font-weight: bold;
            color: var(--dark);
        }

        .card-description {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        .count {
            display: inline-block;
            background: #FCE8E8;
            color: var(--red-dark);
            border-radius: 20px;
            padding: 6px 11px;
            font-size: 12px;
            font-weight: bold;
        }

        .alert {
            padding: 14px 16px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert-success {
            background: #E8F7EE;
            color: #17663A;
            border: 1px solid #C7EBD4;
        }

        .alert-error {
            background: #FDECEC;
            color: #991B1B;
            border: 1px solid #F5CACA;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            padding: 15px 18px;
            background: #F7F8FA;
            color: #555E68;
            text-align: left;
            font-size: 11px;
            letter-spacing: .5px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        td {
            padding: 16px 18px;
            border-bottom: 1px solid #EDF0F3;
            vertical-align: middle;
        }

        tbody tr:hover { background: #FAFBFC; }
        tbody tr:last-child td { border-bottom: none; }

        .number { color: var(--muted); }

        .user-name {
            font-weight: bold;
            color: var(--dark);
        }

        .email { color: #59636F; }

        .role {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #ECEFF3;
            color: #454D57;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
        }

        .role-admin {
            background: #FCE8E8;
            color: #B51219;
        }

        .role-pimpinan {
            background: #E8EEF9;
            color: #294E8A;
        }

        .role-karyawan {
            background: #E7F5EB;
            color: #21683A;
        }

        .action-link {
            display: inline-block;
            padding: 8px 11px;
            background: #FCE8E8;
            color: var(--red-dark);
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
        }

        .action-link:hover {
            background: var(--red);
            color: white;
        }

        .empty {
            text-align: center;
            padding: 35px 15px;
            color: var(--muted);
        }

        .pagination {
            padding: 18px 22px;
            border-top: 1px solid var(--border);
        }

        .pagination nav p {
            font-size: 12px;
            color: var(--muted);
        }

        .pagination nav div div {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span[aria-current="page"] span {
            display: inline-block;
            padding: 7px 11px;
            border: 1px solid var(--border);
            border-radius: 5px;
            text-decoration: none;
            color: var(--text);
            font-size: 12px;
        }

        .pagination span[aria-current="page"] span {
            background: var(--red);
            color: white;
            border-color: var(--red);
        }

        .logout {
            width: 100%;
            margin-top: 20px;
            padding: 11px 12px;
            color: #FCA5A5;
            background: transparent;
            border: 1px solid #555B63;
            border-radius: 7px;
            text-align: left;
            font-size: 13px;
            cursor: pointer;
        }

        .logout:hover {
            background: #343A42;
        }

        @media (max-width: 850px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main { margin-left: 0; }

            .topbar { padding: 0 20px; }

            .content { padding: 20px; }
        }

        @media (max-width: 480px) {
            .topbar {
                height: auto;
                min-height: 65px;
                flex-wrap: wrap;
                padding: 15px 20px;
            }

            h1 { font-size: 23px; }
        }
    </style>
</head>

<body>
@php
    $role = session('user_role');
    $currentRoute = request()->route()->getName();
@endphp

<aside class="sidebar">
    <div class="brand">
        <div class="brand-name">E-<span>ASSET</span></div>
        <div class="brand-subtitle">
            GOLDEN PIPING INDONESIA<br>
            ASSET MANAGEMENT SYSTEM
        </div>
    </div>

    <div class="nav-title">MENU UTAMA</div>

    <a class="nav-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}"
       href="{{ route('dashboard') }}">Dashboard</a>

    @if (in_array($role, ['admin', 'karyawan'], true))
        <a class="nav-link {{ str_starts_with($currentRoute, 'assets.') ? 'active' : '' }}"
           href="{{ route('assets.index') }}">Data Aset</a>
    @endif

    @if (in_array($role, ['admin', 'pimpinan'], true))
        <div class="nav-title">LAPORAN</div>

        <a class="nav-link {{ str_starts_with($currentRoute, 'mutations.') ? 'active' : '' }}"
           href="{{ route('mutations.index') }}">Mutasi Aset</a>

        <a class="nav-link {{ str_starts_with($currentRoute, 'maintenances.') ? 'active' : '' }}"
           href="{{ route('maintenances.index') }}">Pemeliharaan</a>
    @endif

    @if ($role === 'admin')
        <div class="nav-title">ADMINISTRASI</div>

        <a class="nav-link {{ str_starts_with($currentRoute, 'users.') ? 'active' : '' }}"
           href="{{ route('users.index') }}">Manajemen Pengguna</a>
    @endif

    <div class="role-box">
        LOGIN SEBAGAI
        <strong>{{ ucfirst($role ?? 'Pengguna') }}</strong>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout">Keluar dari Sistem</button>
    </form>
</aside>

<main class="main">
    <header class="topbar">
        <div class="topbar-title">E-Asset / Manajemen Pengguna</div>
        <div class="topbar-user">
            Halo, <strong>{{ session('user_name', 'Pengguna') }}</strong>
        </div>
    </header>

    <section class="content">
        <div class="page-heading">
            <div>
                <div class="eyebrow">ADMINISTRASI SISTEM</div>
                <h1>Manajemen Pengguna</h1>
                <div class="subtitle">
                    Kelola akun dan hak akses pengguna sistem E-Asset Golden Piping Indonesia.
                </div>
            </div>

            <a class="btn" href="{{ route('users.create') }}">
                + Tambah Pengguna
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Daftar Pengguna</div>
                    <div class="card-description">
                        Informasi akun yang terdaftar dalam sistem.
                    </div>
                </div>

                <span class="count">
                    {{ $users->total() }} Pengguna
                </span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="number">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <div class="user-name">{{ $user->name }}</div>
                                </td>

                                <td class="email">{{ $user->email }}</td>

                                <td>
                                    <span class="role role-{{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $user->created_at?->format('d-m-Y') ?? '-' }}
                                </td>

                                <td>
                                    <a class="action-link"
                                       href="{{ route('users.edit', $user) }}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty">
                                    Belum ada pengguna yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="pagination">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </section>
</main>
</body>
</html>
```