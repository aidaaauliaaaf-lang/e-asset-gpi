@extends('layouts.app')

@section('content')

@php
    $displayColumns = array_values(array_filter(
        $columns,
        fn($column) => !in_array($column, [
            'id',
            'created_at',
            'updated_at',
            'deleted_at'
        ], true)
    ));

    $columnLabels = [
        'kode_aset' => 'Kode Aset',
        'nama_aset' => 'Nama Aset',
        'tanggal_pembelian' => 'Tanggal Perolehan',
        'kategori' => 'Kategori',
        'lokasi' => 'Lokasi',
        'divisi' => 'Divisi',
        'kondisi' => 'Kondisi',
        'status' => 'Status',
        'foto' => 'Foto',

        'asset_id' => 'ID Aset',
        'lokasi_asal' => 'Lokasi Asal',
        'lokasi_tujuan' => 'Lokasi Tujuan',
        'divisi_asal' => 'Divisi Asal',
        'divisi_tujuan' => 'Divisi Tujuan',
        'penanggung_jawab_lama' => 'Penanggung Jawab Lama',
        'penanggung_jawab_baru' => 'Penanggung Jawab Baru',
        'tanggal_mutasi' => 'Tanggal Mutasi',

        'tanggal_maintenance' => 'Tanggal Maintenance',
        'tanggal_pemeliharaan' => 'Tanggal Maintenance',
        'jenis_maintenance' => 'Jenis Maintenance',
        'jenis_pemeliharaan' => 'Jenis Maintenance',
        'keterangan' => 'Keterangan',
        'dokumen' => 'Dokumentasi',
        'penanggung_jawab' => 'Penanggung Jawab',
        'tanggal_maintenance_berikutnya' => 'Tanggal Maintenance Berikutnya',
    ];

    $statisticLabels = [
        'aset' => 'Total Seluruh Aset',
        'mutasi' => 'Total Seluruh Mutasi',
        'pemeliharaan' => 'Total Seluruh Maintenance',
    ];

    $statisticTotal = $statistics[$jenis] ?? 0;
    $statisticLabel = $statisticLabels[$jenis] ?? 'Total Data';

    $pageTitle = $report['title'] ?? 'Laporan E-Asset';
@endphp

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">{{ $pageTitle }}</h2>
        <p class="text-muted mb-0">
            Sistem Informasi E-Asset PT Golden Piping Indonesia
        </p>
    </div>

    @if(!$warning)
        <a href="{{ route('reports.pdf', [
            'jenis' => $jenis,
            'dari' => $dari,
            'sampai' => $sampai
        ]) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i>
            Download PDF
        </a>
    @endif
</div>

{{-- STATISTIK --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-2">{{ $statisticLabel }}</p>
                <h3 class="fw-bold mb-0">
                    {{ number_format($statisticTotal, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-2">Data Ditampilkan</p>
                <h3 class="fw-bold mb-0">
                    {{ number_format($rows->count(), 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-2">Total Hasil Filter</p>
                <h3 class="fw-bold mb-0">
                    {{ number_format($total, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- PILIH JENIS LAPORAN --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white">
        <strong>Pilih Jenis Laporan</strong>
    </div>

    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('reports.index', ['jenis' => 'aset']) }}"
               class="btn {{ $jenis === 'aset' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-box-seam"></i>
                Laporan Aset
            </a>

            <a href="{{ route('reports.index', ['jenis' => 'mutasi']) }}"
               class="btn {{ $jenis === 'mutasi' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-arrow-left-right"></i>
                Laporan Mutasi
            </a>

            <a href="{{ route('reports.index', ['jenis' => 'pemeliharaan']) }}"
               class="btn {{ $jenis === 'pemeliharaan' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-tools"></i>
                Laporan Maintenance
            </a>

        </div>
    </div>
</div>

{{-- FILTER LAPORAN --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white">
        <strong>Filter {{ $pageTitle }}</strong>
    </div>

    <div class="card-body">
        <form action="{{ route('reports.index') }}" method="GET">
            <input type="hidden" name="jenis" value="{{ $jenis }}">

            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input
                        type="date"
                        name="dari"
                        class="form-control"
                        value="{{ $dari }}"
                    >
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input
                        type="date"
                        name="sampai"
                        class="form-control"
                        value="{{ $sampai }}"
                    >
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>
                </div>
            </div>

            <div class="mt-3">
                <a
                    href="{{ route('reports.index', ['jenis' => $jenis]) }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset Filter
                </a>
            </div>
        </form>
    </div>
</div>

{{-- PERINGATAN --}}
@if($warning)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        {{ $warning }}
    </div>
@endif

{{-- TABEL LAPORAN --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <strong>{{ $pageTitle }}</strong>

        <span class="badge bg-light text-dark">
            {{ number_format($total, 0, ',', '.') }} Data
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>

                        @foreach($displayColumns as $column)
                            <th>
                                {{ $columnLabels[$column] ?? ucwords(str_replace('_', ' ', $column)) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @forelse($rows as $index => $row)

                        <tr>
                            <td class="text-center">
                                {{ $index + 1 }}
                            </td>

                            @foreach($displayColumns as $column)

                                @php
                                    $value = $row->{$column} ?? null;
                                @endphp

                                <td>

                                    {{-- FOTO ASET --}}
                                    @if($jenis === 'aset' && $column === 'foto')

                                        @if($value)
                                            @php
                                                $fotoUrl = asset(
                                                    'storage/' . ltrim($value, '/')
                                                );
                                            @endphp

                                            <a href="{{ $fotoUrl }}" target="_blank">
                                                <img
                                                    src="{{ $fotoUrl }}"
                                                    alt="Foto Aset"
                                                    style="
                                                        width: 100px;
                                                        height: 75px;
                                                        object-fit: cover;
                                                        border-radius: 6px;
                                                        border: 1px solid #ddd;
                                                    "
                                                >
                                            </a>
                                        @else
                                            <span class="text-muted">
                                                Tidak ada foto
                                            </span>
                                        @endif

                                    {{-- FOTO DOKUMENTASI MAINTENANCE --}}
                                    @elseif($jenis === 'pemeliharaan' && $column === 'dokumen')

                                        @if($value)
                                            @php
                                                $extension = strtolower(
                                                    pathinfo($value, PATHINFO_EXTENSION)
                                                );

                                                $documentUrl = asset(
                                                    'storage/' . ltrim($value, '/')
                                                );
                                            @endphp

                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                <a href="{{ $documentUrl }}" target="_blank">
                                                    <img
                                                        src="{{ $documentUrl }}"
                                                        alt="Dokumentasi Maintenance"
                                                        style="
                                                            width: 100px;
                                                            height: 75px;
                                                            object-fit: cover;
                                                            border-radius: 6px;
                                                            border: 1px solid #ddd;
                                                        "
                                                    >
                                                </a>

                                            @elseif($extension === 'pdf')
                                                <a
                                                    href="{{ $documentUrl }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                    Lihat PDF
                                                </a>
                                            @else
                                                -
                                            @endif
                                        @else
                                            <span class="text-muted">
                                                Tidak ada dokumen
                                            </span>
                                        @endif

                                    {{-- KONDISI --}}
                                    @elseif($column === 'kondisi')

                                        @if($value === 'Baik')
                                            <span class="badge bg-success">Baik</span>

                                        @elseif($value === 'Rusak Ringan')
                                            <span class="badge bg-warning text-dark">
                                                Rusak Ringan
                                            </span>

                                        @elseif($value === 'Rusak Berat')
                                            <span class="badge bg-danger">
                                                Rusak Berat
                                            </span>

                                        @else
                                            <span class="badge bg-secondary">
                                                {{ $value ?? '-' }}
                                            </span>
                                        @endif

                                    {{-- STATUS --}}
                                    @elseif($column === 'status')

                                        @if($value === 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($value === 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($value === 'Proses')
                                            <span class="badge bg-warning text-dark">Proses</span>
                                        @elseif($value === 'Terjadwal')
                                            <span class="badge bg-info text-dark">Terjadwal</span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ $value ?? '-' }}
                                            </span>
                                        @endif

                                    {{-- TANGGAL --}}
                                    @elseif($value && (
                                        str_contains($column, 'tanggal') ||
                                        str_ends_with($column, '_at')
                                    ))

                                        {{ \Carbon\Carbon::parse($value)->format('d-m-Y') }}

                                    {{-- DATA KOSONG --}}
                                    @elseif($value === null || $value === '')

                                        -

                                    {{-- DATA BIASA --}}
                                    @else

                                        {{ is_scalar($value) ? $value : json_encode($value) }}

                                    @endif

                                </td>

                            @endforeach
                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="{{ count($displayColumns) + 1 }}"
                                class="text-center text-muted py-5"
                            >
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                Belum ada data
                                {{ strtolower($pageTitle) }}
                                untuk ditampilkan.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

    <div class="card-footer bg-white">
        <small class="text-muted">
            {{ $pageTitle }} PT Golden Piping Indonesia.
            Maksimal 500 data ditampilkan.
        </small>
    </div>
</div>

@endsection