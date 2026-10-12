<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pimpinan - E-Asset GPI</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        header {
            background: #12315b;
            color: white;
            padding: 22px 30px;
        }
        header h1 { margin: 0 0 6px; font-size: 24px; }
        header p { margin: 0; color: #dbeafe; }
        main { max-width: 1200px; margin: auto; padding: 25px; }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 18px;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 2px 8px #0f172a0d;
        }
        .card p { color: #64748b; margin: 0 0 12px; }
        .number { font-size: 30px; font-weight: bold; }
        section { margin-top: 28px; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        th { background: #e2e8f0; }
        .table-wrap { overflow-x: auto; }
        .logout {
            display: inline-block;
            margin-top: 22px;
            padding: 10px 16px;
            background: #dc2626;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }
        @media (max-width: 600px) {
            main { padding: 15px; }
            header { padding: 20px 15px; }
        }
    </style>
</head>
<body>
<header>
    <h1>Dashboard Pimpinan</h1>
    <p>E-Asset Golden Piping Indonesia — Ringkasan dan Monitoring Aset</p>
</header>

<main>
    <p>Selamat datang, {{ session('user_name', 'Pimpinan') }}.</p>

    <div class="cards">
        <div class="card">
            <p>Total Aset</p>
            <div class="number">{{ $totalAssets }}</div>
        </div>
        <div class="card">
            <p>Aset Aktif</p>
            <div class="number">{{ $activeAssets }}</div>
        </div>
        <div class="card">
            <p>Aset Kondisi Baik</p>
            <div class="number">{{ $goodAssets }}</div>
        </div>
        <div class="card">
            <p>Aset Rusak</p>
            <div class="number">{{ $damagedAssets }}</div>
        </div>
        <div class="card">
            <p>Total Mutasi</p>
            <div class="number">{{ $totalMutations }}</div>
        </div>
        <div class="card">
            <p>Total Pemeliharaan</p>
            <div class="number">{{ $totalMaintenances }}</div>
        </div>
    </div>

    <section>
        <h2>5 Aset Terbaru</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Aset</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentAssets as $asset)
                        <tr>
                            <td>{{ $asset->kode_aset }}</td>
                            <td>{{ $asset->nama_aset }}</td>
                            <td>{{ $asset->lokasi }}</td>
                            <td>{{ $asset->kondisi }}</td>
                            <td>{{ $asset->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data aset.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <h2>5 Mutasi Terbaru</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Lokasi Tujuan</th>
                        <th>Divisi Tujuan</th>
                        <th>Tanggal Mutasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentMutations as $mutation)
                        <tr>
                            <td>{{ $mutation->asset->nama_aset ?? '-' }}</td>
                            <td>{{ $mutation->lokasi_tujuan }}</td>
                            <td>{{ $mutation->divisi_tujuan }}</td>
                            <td>{{ $mutation->tanggal_mutasi }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Belum ada data mutasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <h2>5 Pemeliharaan Terbaru</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Jenis Pemeliharaan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentMaintenances as $maintenance)
                        <tr>
                            <td>{{ $maintenance->asset->nama_aset ?? '-' }}</td>
                            <td>{{ $maintenance->jenis_maintenance }}</td>
                            <td>{{ $maintenance->tanggal_maintenance }}</td>
                            <td>{{ $maintenance->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Belum ada data pemeliharaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout" type="submit">Logout</button>
    </form>
</main>
</body>
</html>