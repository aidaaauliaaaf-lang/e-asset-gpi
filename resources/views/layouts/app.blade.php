<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-Asset Golden Piping</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            min-height: 100vh;
            background: #212529;
        }

        .sidebar .brand {
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 20px;
            border-bottom: 1px solid #444;
        }

        .sidebar a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 12px 20px;
        }

        .sidebar a:hover {
            background: #343a40;
            color: white;
        }

        .content {
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 p-0 sidebar">

            <div class="brand">
                E-Asset
                <div style="font-size: 12px; font-weight: normal;">
                    Golden Piping Indonesia
                </div>
            </div>

            <nav class="mt-2">

                <a href="{{ route('dashboard') }}">
                    📊 Dashboard
                </a>

                <a href="{{ route('assets.index') }}">
                    📦 Data Aset
                </a>

                <a href="{{ route('mutations.index') }}">
                    🔄 Mutasi Aset
                </a>

                <a href="{{ route('maintenances.index') }}">
                    🔧 Maintenance
                </a>

                <hr class="text-secondary mx-3">

                <form action="{{ route('logout') }}" method="POST" class="px-3">
                    @csrf

                    <button type="submit"
                            class="btn btn-danger w-100">
                        Logout
                    </button>
                </form>

            </nav>

        </div>

        <!-- CONTENT -->
        <div class="col-md-9 col-lg-10 content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </div>

    </div>
</div>

</body>
</html>