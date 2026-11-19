
@extends('layouts.app')

@section('title', 'Mutasi Aset')

@section('content')

{{-- HEADER HALAMAN --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1">Mutasi Aset</h2>
        <p class="text-muted mb-0">
            Kelola perpindahan aset antar lokasi, divisi, dan penanggung jawab
        </p>
    </div>

    {{-- TOMBOL TAMBAH MUTASI HANYA ADMIN --}}
    @if(strtolower(session('user_role', '')) === 'admin')
        <a href="{{ route('mutations.create') }}" class="btn btn-dark">
            + Tambah Mutasi
        </a>
    @endif

</div>

{{-- NOTIFIKASI SUKSES --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- PENCARIAN DAN FILTER TANGGAL --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        <form action="{{ route('mutations.index') }}" method="GET">

            <div class="row g-2 align-items-end">

                {{-- PENCARIAN --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Cari Aset
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari kode aset atau nama aset..."
                    >
                </div>

                {{-- FILTER TANGGAL --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Tanggal Mutasi
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}"
                    >
                </div>

                {{-- TOMBOL CARI --}}
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>

                {{-- RESET FILTER --}}
                <div class="col-12 d-flex justify-content-end">
                    <a href="{{ route('mutations.index') }}"
                       class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filter
                    </a>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- TABEL RIWAYAT MUTASI --}}
<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">
        <strong>Riwayat Mutasi Aset</strong>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0 align-middle">

                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Lokasi Asal</th>
                        <th>Lokasi Tujuan</th>
                        <th>Divisi Asal</th>
                        <th>Divisi Tujuan</th>
                        <th>PJ Lama</th>
                        <th>PJ Baru</th>
                        <th>Tanggal Mutasi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($mutations as $mutation)

                        <tr>

                            <td>
                                {{ $mutations->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $mutation->asset->kode_aset ?? '-' }}
                                </strong>
                            </td>

                            <td>
                                {{ $mutation->asset->nama_aset ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->lokasi_asal ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->lokasi_tujuan ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->divisi_asal ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->divisi_tujuan ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->penanggung_jawab_lama ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->penanggung_jawab_baru ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->tanggal_mutasi
                                    ? $mutation->tanggal_mutasi->format('d-m-Y')
                                    : '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10"
                                class="text-center text-muted py-5">

                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                Tidak ada data mutasi yang ditemukan.

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- INFORMASI JUMLAH DATA --}}
<div class="d-flex justify-content-between align-items-center mt-3">

    <small class="text-muted">
        Menampilkan {{ $mutations->firstItem() ?? 0 }}
        sampai {{ $mutations->lastItem() ?? 0 }}
        dari {{ $mutations->total() }} data mutasi
    </small>

</div>

{{-- PAGINATION --}}
@if($mutations->hasPages())
    <div class="mt-3">
        {{ $mutations->links() }}
    </div>
@endif

@endsection
