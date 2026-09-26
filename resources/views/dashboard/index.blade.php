@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Dashboard</h2>
        <p class="text-muted mb-0">
            Sistem Informasi Manajemen E-Asset
        </p>
    </div>
</div>

<div class="row g-4">

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Aset</h6>
                <h2 class="fw-bold">{{ $totalAssets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Aset Aktif</h6>
                <h2 class="fw-bold">{{ $activeAssets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Aset Kondisi Baik</h6>
                <h2 class="fw-bold">{{ $goodAssets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Aset Rusak</h6>
                <h2 class="fw-bold">{{ $damagedAssets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Mutasi</h6>
                <h2 class="fw-bold">{{ $totalMutations }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Maintenance</h6>
                <h2 class="fw-bold">{{ $totalMaintenances }}</h2>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm border-0 mt-4">

    <div class="card-header bg-dark text-white">
        <strong>Aset Terbaru</strong>
    </div>

    <div class="card-body">

        @if($recentAssets->count() > 0)

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($recentAssets as $asset)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $asset->kode_aset }}</td>
                            <td>{{ $asset->nama_aset }}</td>
                            <td>{{ $asset->kategori }}</td>
                            <td>{{ $asset->lokasi }}</td>
                            <td>{{ $asset->kondisi }}</td>
                            <td>{{ $asset->status }}</td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center text-muted py-4">
                Belum ada data aset.
            </div>

        @endif

    </div>

</div>

@endsection