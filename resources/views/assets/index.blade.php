
@extends('layouts.app')

@section('content')

{{-- HEADER HALAMAN --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Data Aset</h2>
        <p class="text-muted mb-0">
            Kelola seluruh data aset PT Golden Piping Indonesia
        </p>
    </div>

    {{-- TOMBOL TAMBAH HANYA UNTUK ADMIN --}}
    @if(strtolower(session('user_role', '')) === 'admin')
        <a href="{{ route('assets.create') }}" class="btn btn-dark">
            + Tambah Aset
        </a>
    @endif
</div>

{{-- PESAN SUKSES --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

{{-- PESAN ERROR --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

{{-- PENCARIAN --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('assets.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari kode aset, nama aset, kategori, lokasi, atau divisi..."
                    >
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        🔍 Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL ASET --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white">
        <strong>Daftar Aset</strong>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Tanggal Perolehan</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Divisi</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($assets as $asset)
                        <tr>
                            {{-- NOMOR --}}
                            <td>
                                {{ $assets->firstItem() + $loop->index }}
                            </td>

                            {{-- FOTO --}}
                            <td>
                                @if($asset->foto)
                                    <img
                                        src="{{ asset('storage/' . $asset->foto) }}"
                                        alt="Foto aset"
                                        width="70"
                                        height="60"
                                        style="object-fit: cover; border-radius: 6px;"
                                    >
                                @else
                                    <span class="text-muted">
                                        Belum ada foto
                                    </span>
                                @endif
                            </td>

                            {{-- KODE ASET --}}
                            <td>
                                <strong>{{ $asset->kode_aset }}</strong>
                            </td>

                            {{-- NAMA ASET --}}
                            <td>{{ $asset->nama_aset }}</td>

                            {{-- TANGGAL PEROLEHAN --}}
                            <td>
                                {{ $asset->tanggal_pembelian
                                    ? \Carbon\Carbon::parse($asset->tanggal_pembelian)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            {{-- KATEGORI --}}
                            <td>{{ $asset->kategori }}</td>

                            {{-- LOKASI --}}
                            <td>{{ $asset->lokasi ?? '-' }}</td>

                            {{-- DIVISI --}}
                            <td>{{ $asset->divisi ?? '-' }}</td>

                            {{-- KONDISI --}}
                            <td>
                                @if($asset->kondisi === 'Baik')
                                    <span class="badge bg-success">
                                        Baik
                                    </span>
                                @elseif($asset->kondisi === 'Rusak Ringan')
                                    <span class="badge bg-warning text-dark">
                                        Rusak Ringan
                                    </span>
                                @elseif($asset->kondisi === 'Rusak Berat')
                                    <span class="badge bg-danger">
                                        Rusak Berat
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ $asset->kondisi }}
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($asset->status === 'Aktif')
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ $asset->status }}
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td>
                                <div class="d-flex flex-wrap gap-1">

                                    {{-- DETAIL UNTUK SEMUA ROLE --}}
                                    <a
                                        href="{{ route('assets.show', $asset) }}"
                                        class="btn btn-sm btn-info text-white"
                                    >
                                        Detail
                                    </a>

                                    {{-- EDIT DAN HAPUS HANYA ADMIN --}}
                                    @if(strtolower(session('user_role', '')) === 'admin')

                                        <a
                                            href="{{ route('assets.edit', $asset) }}"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('assets.destroy', $asset) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus aset ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    @endif

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                Belum ada data aset.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

{{-- PAGINATION --}}
@if($assets->hasPages())
    <div class="mt-4">
        {{ $assets->links() }}
    </div>
@endif

@endsection
