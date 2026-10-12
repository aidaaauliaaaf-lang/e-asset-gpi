@extends('layouts.app')

@section('content')

@php
    $role = session('user_role');
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Dashboard</h2>
        <p class="text-muted mb-0">
            Sistem Informasi Manajemen E-Asset
        </p>
        <span class="badge bg-primary mt-2">
            Role: {{ ucfirst($role ?? 'Pengguna') }}
        </span>
    </div>
</div>

{{-- Menu sesuai role --}}
<div class="row g-3 mb-4">

    @if(in_array($role, ['admin', 'karyawan'], true))
        <div class="col-md-4">
            <a href="{{ route('assets.create') }}"
               class="card shadow-sm border-0 text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-dark">Input Aset</h5>
                    <p class="text-muted mb-0">
                        Tambahkan data aset baru.
                    </p>
                </div>
            </a>
        </div>
    @endif

    @if(in_array($role, ['admin', 'pimpinan'], true))
        <div class="col-md-4">
            <a href="{{ route('mutations.index') }}"
               class="card shadow-sm border-0 text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-dark">Laporan Mutasi</h5>
                    <p class="text-muted mb-0">
                        Lihat informasi mutasi aset.
                    </p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('maintenances.index') }}"
               class="card shadow-sm border-0 text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-dark">Laporan Maintenance</h5>
                    <p class="text-muted mb-0">
                        Lihat informasi pemeliharaan aset.
                    </p>
                </div>
            </a>
        </div>
    @endif

    @if($role === 'admin')
        <div class="col-md-4">
            <a href="{{ route('users.index') }}"
               class="card shadow-sm border-0 text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-dark">Manajemen Pengguna</h5>
                    <p class="text-muted mb-0">
                        Kelola akun dan hak akses pengguna.
                    </p>
                </div>
            </a>
        </div>
    @endif

</div>

{{-- Ringkasan aset --}}
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

{{-- Aset terbaru --}}
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