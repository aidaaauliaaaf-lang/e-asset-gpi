
@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Maintenance Aset</h2>
        <p class="text-muted mb-0">
            Kelola jadwal dan riwayat maintenance aset
        </p>
    </div>

    {{-- Tambah Maintenance khusus Admin --}}
    @if(strtolower(session('user_role', '')) === 'admin')
        <a href="{{ route('maintenances.create') }}" class="btn btn-dark">
            + Tambah Maintenance
        </a>
    @endif
</div>

{{-- NOTIFIKASI SUKSES --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
@endif

{{-- NOTIFIKASI ERROR --}}
@if($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa data berikut:</strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- PENCARIAN DAN FILTER TANGGAL --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        <form action="{{ route('maintenances.index') }}" method="GET">

            <div class="row g-3 align-items-end">

                <div class="col-md-5">
                    <label class="form-label fw-semibold">
                        Cari Aset
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Masukkan kode atau nama aset..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Tanggal Maintenance
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}"
                    >
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a
                        href="{{ route('maintenances.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- TABEL RIWAYAT MAINTENANCE --}}
<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">
        <strong>Riwayat Maintenance Aset</strong>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0 align-middle">

                {{-- HEADER TABEL --}}
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Tanggal</th>
                        <th>Jenis Maintenance</th>
                        <th>Penanggung Jawab</th>
                        <th>Status</th>
                        <th>Maintenance Berikutnya</th>
                        <th class="text-center" width="140">
                            Dokumentasi
                        </th>
                    </tr>
                </thead>

                {{-- ISI TABEL --}}
                <tbody>

                    @forelse($maintenances as $maintenance)

                        <tr>

                            {{-- NOMOR --}}
                            <td>
                                {{ $maintenances->firstItem() + $loop->index }}
                            </td>

                            {{-- KODE ASET --}}
                            <td>
                                <strong>
                                    {{ $maintenance->asset->kode_aset ?? '-' }}
                                </strong>
                            </td>

                            {{-- NAMA ASET --}}
                            <td>
                                {{ $maintenance->asset->nama_aset ?? '-' }}
                            </td>

                            {{-- TANGGAL --}}
                            <td>
                                {{ $maintenance->tanggal_maintenance
                                    ? $maintenance->tanggal_maintenance->format('d-m-Y')
                                    : '-' }}
                            </td>

                            {{-- JENIS MAINTENANCE --}}
                            <td>
                                {{ $maintenance->jenis_maintenance }}
                            </td>

                            {{-- PENANGGUNG JAWAB --}}
                            <td>
                                {{ $maintenance->penanggung_jawab ?? '-' }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($maintenance->status === 'Selesai')

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                @elseif($maintenance->status === 'Proses')

                                    <span class="badge bg-warning text-dark">
                                        Proses
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Terjadwal
                                    </span>

                                @endif
                            </td>

                            {{-- MAINTENANCE BERIKUTNYA --}}
                            <td>
                                {{ $maintenance->tanggal_maintenance_berikutnya
                                    ? $maintenance->tanggal_maintenance_berikutnya->format('d-m-Y')
                                    : '-' }}
                            </td>

                            {{-- DOKUMENTASI MAINTENANCE --}}
                            <td class="text-center">

                                @if($maintenance->dokumen)

                                    @php
                                        $ekstensi = strtolower(
                                            pathinfo(
                                                $maintenance->dokumen,
                                                PATHINFO_EXTENSION
                                            )
                                        );

                                        $urlDokumen = asset(
                                            'storage/' . $maintenance->dokumen
                                        );
                                    @endphp

                                    {{-- FOTO JPG, JPEG, PNG, WEBP --}}
                                    @if(in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp']))

                                        <a
                                            href="{{ $urlDokumen }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="Klik untuk melihat foto"
                                        >
                                            <img
                                                src="{{ $urlDokumen }}"
                                                alt="Dokumentasi Maintenance"
                                                class="img-thumbnail"
                                                loading="lazy"
                                                style="
                                                    width: 80px;
                                                    height: 65px;
                                                    object-fit: cover;
                                                    cursor: pointer;
                                                "
                                            >
                                        </a>

                                    {{-- FILE PDF --}}
                                    @elseif($ekstensi === 'pdf')

                                        <a
                                            href="{{ $urlDokumen }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="btn btn-sm btn-outline-danger"
                                        >
                                            <i class="bi bi-file-earmark-pdf"></i>
                                            Lihat PDF
                                        </a>

                                    {{-- FORMAT TIDAK DIKENALI --}}
                                    @else

                                        <span class="text-muted">
                                            Format tidak dikenali
                                        </span>

                                    @endif

                                @else

                                    <span class="text-muted">
                                        Tidak ada dokumen
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="9"
                                class="text-center text-muted py-5"
                            >
                                Data maintenance tidak ditemukan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- PAGINATION --}}
@if($maintenances->hasPages())

    <div class="mt-4">
        {{ $maintenances->links() }}
    </div>

@endif

@endsection
