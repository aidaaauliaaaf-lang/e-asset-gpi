@extends('layouts.app')

@section('content')

@php
    $role = session('user_role');
@endphp

@if($role === 'pimpinan')

{{-- DASHBOARD PIMPINAN --}}
<style>
    .pimpinan-dashboard .summary-card {
        border: 1px solid #e9edf3;
        border-radius: 12px;
        transition: .2s;
    }

    .pimpinan-dashboard .summary-card:hover {
        transform: translateY(-2px);
    }

    .pimpinan-dashboard .summary-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 21px;
    }

    .pimpinan-dashboard .section-card {
        border: 1px solid #e9edf3;
        border-radius: 12px;
        overflow: hidden;
    }

    .pimpinan-dashboard .section-title {
        font-weight: 700;
        color: #172554;
    }

    .pimpinan-dashboard .notification-menu {
        position: relative;
    }

    .pimpinan-dashboard .notification-menu summary {
        cursor: pointer;
        list-style: none;
    }

    .pimpinan-dashboard .notification-menu summary::-webkit-details-marker {
        display: none;
    }

    .pimpinan-dashboard .notification-content {
        position: absolute;
        right: 0;
        top: 45px;
        width: 320px;
        max-width: 85vw;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,.12);
        z-index: 1000;
    }

    .pimpinan-dashboard .notification-item {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .pimpinan-dashboard .notification-item:last-child {
        border-bottom: 0;
    }
</style>

<div class="pimpinan-dashboard">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1">Dashboard Pimpinan</h3>
            <p class="text-muted mb-0">
                Sistem Informasi Manajemen E-Asset
            </p>
            <span class="badge bg-primary mt-2">Pimpinan</span>
        </div>

        {{-- NOTIFIKASI --}}
        <details class="notification-menu">
            <summary class="btn btn-light border position-relative">
                <span style="font-size:20px;">🔔</span>
                @if($notifications->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifications->count() }}
                    </span>
                @endif
            </summary>

            <div class="notification-content">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <strong>Notifikasi</strong>
                    <span class="badge bg-primary">
                        {{ $notifications->count() }}
                    </span>
                </div>

                @forelse($notifications as $notification)
                    <div class="notification-item">
                        <div class="fw-semibold">
                            @if($notification['jenis'] === 'rusak')
                                <span class="text-danger">●</span>
                            @elseif($notification['jenis'] === 'mutasi')
                                <span class="text-primary">●</span>
                            @else
                                <span class="text-warning">●</span>
                            @endif

                            {{ $notification['judul'] }}
                        </div>

                        <div class="small text-muted">
                            {{ $notification['pesan'] }}
                        </div>

                        <div class="small text-secondary mt-1">
                            {{ optional($notification['tanggal'])->format('d-m-Y') ?? '-' }}
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted p-4">
                        Belum ada notifikasi.
                    </div>
                @endforelse
            </div>
        </details>
    </div>

    {{-- KARTU RINGKASAN --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="card summary-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon bg-primary-subtle text-primary">
                        📦
                    </div>
                    <div>
                        <div class="text-muted small">Total Aset</div>
                        <h3 class="fw-bold mb-0">{{ $totalAssets }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card summary-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon bg-success-subtle text-success">
                        ✓
                    </div>
                    <div>
                        <div class="text-muted small">Aset Aktif</div>
                        <h3 class="fw-bold mb-0">{{ $activeAssets }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card summary-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon bg-info-subtle text-info">
                        ✔
                    </div>
                    <div>
                        <div class="text-muted small">Kondisi Baik</div>
                        <h3 class="fw-bold mb-0">{{ $goodAssets }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card summary-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon bg-danger-subtle text-danger">
                        !
                    </div>
                    <div>
                        <div class="text-muted small">Aset Rusak</div>
                        <h3 class="fw-bold mb-0">{{ $damagedAssets }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- INFORMASI MUTASI DAN MAINTENANCE --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card section-card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Mutasi Aset</div>
                        <h4 class="fw-bold mb-0">{{ $totalMutations }}</h4>
                    </div>
                    <a href="{{ route('mutations.index') }}"
                       class="btn btn-outline-primary btn-sm">
                        Lihat Mutasi
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card section-card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Maintenance</div>
                        <h4 class="fw-bold mb-0">{{ $totalMaintenances }}</h4>
                    </div>
                    <a href="{{ route('maintenances.index') }}"
                       class="btn btn-outline-primary btn-sm">
                        Lihat Maintenance
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- REKAP ASET PER DIVISI --}}
    <div class="card section-card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="section-title mb-0">Rekap Data Aset Per Divisi</h6>
            <small class="text-muted">Seluruh divisi perusahaan</small>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70">No</th>
                            <th>Divisi</th>
                            <th width="180">Jumlah Aset</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisionAssets as $division)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $division->divisi ?: 'Belum ditentukan' }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $division->total }} Aset
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    Belum ada data divisi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- REKAP KONDISI ASET --}}
    <div class="card section-card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="section-title mb-0">Rekap Kondisi Aset</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70">No</th>
                            <th>Kondisi Aset</th>
                            <th width="180">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conditionSummary as $condition)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $condition->kondisi ?: 'Belum ditentukan' }}</td>
                                <td>{{ $condition->total }} Aset</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    Belum ada data kondisi aset.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- AKTIVITAS TERBARU --}}
    <div class="card section-card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="section-title mb-0">Aktivitas Terbaru</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Aktivitas</th>
                            <th>Kode Aset</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities as $activity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($activity['tanggal'])->format('d-m-Y') ?? '-' }}
                                </td>
                                <td>
                                    @if($activity['jenis'] === 'Mutasi')
                                        <span class="badge bg-primary">Mutasi</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Maintenance</span>
                                    @endif
                                </td>
                                <td>{{ $activity['kode_aset'] }}</td>
                                <td>{{ $activity['keterangan'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Belum ada aktivitas terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ASET TERBARU --}}
    <div class="card section-card shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="section-title mb-0">Data Aset Terbaru</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Divisi</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAssets as $asset)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $asset->kode_aset }}</td>
                                <td>{{ $asset->nama_aset }}</td>
                                <td>{{ $asset->divisi }}</td>
                                <td>{{ $asset->lokasi }}</td>
                                <td>{{ $asset->kondisi }}</td>
                                <td>{{ $asset->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Belum ada data aset.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@else

{{-- DASHBOARD ADMIN DAN KARYAWAN: TETAP SEPERTI SEMULA --}}

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

<div class="row g-3 mb-4">

    @if(in_array($role, ['admin', 'karyawan'], true))
        <div class="col-md-4">
            <a href="{{ route('assets.create') }}"
               class="card shadow-sm border-0 text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-dark">Input Aset</h5>
                    <p class="text-muted mb-0">Tambahkan data aset baru.</p>
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
                    <p class="text-muted mb-0">Lihat informasi mutasi aset.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('maintenances.index') }}"
               class="card shadow-sm border-0 text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-dark">Laporan Maintenance</h5>
                    <p class="text-muted mb-0">Lihat informasi pemeliharaan aset.</p>
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
                    <p class="text-muted mb-0">Kelola akun dan hak akses pengguna.</p>
                </div>
            </a>
        </div>
    @endif

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

@endif

@endsection
