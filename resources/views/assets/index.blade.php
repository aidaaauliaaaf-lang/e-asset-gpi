@extends('layouts.app')

@section('content')

{{-- Header halaman --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Data Aset</h2>
        <p class="text-muted mb-0">
            Kelola seluruh data aset PT Golden Piping Indonesia
        </p>
    </div>

    {{-- Tombol tambah hanya untuk Admin dan Karyawan --}}
    @if(in_array(session('user_role'), ['admin', 'karyawan']))
        <a href="{{ route('assets.create') }}" class="btn btn-dark">
            + Tambah Aset
        </a>
    @endif
</div>

{{-- Pesan sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

{{-- Pesan error --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

{{-- Pencarian --}}
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

{{-- Tabel aset --}}
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
                            {{-- Nomor --}}
                            <td>
                                {{ $assets->firstItem() + $loop->index }}
                            </td>

                            {{-- Foto --}}
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

                            {{-- Kode aset --}}
                            <td>
                                <strong>{{ $asset->kode_aset }}</strong>
                            </td>

                            {{-- Nama aset --}}
                            <td>{{ $asset->nama_aset }}</td>

                            {{-- Tanggal perolehan --}}
                            <td>
                                {{ $asset->tanggal_pembelian
                                    ? \Carbon\Carbon::parse($asset->tanggal_pembelian)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            {{-- Kategori --}}
                            <td>{{ $asset->kategori }}</td>

                            {{-- Lokasi --}}
                            <td>{{ $asset->lokasi ?? '-' }}</td>

                            {{-- Divisi --}}
                            <td>{{ $asset->divisi ?? '-' }}</td>

                            {{-- Kondisi --}}
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

                            {{-- Status --}}
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

                            {{-- Aksi --}}
                            <td>
                                <div class="d-flex flex-wrap gap-1">

                                    {{-- Detail dapat diakses semua role --}}
                                    <a
                                        href="{{ route('assets.show', $asset) }}"
                                        class="btn btn-sm btn-info text-white"
                                    >
                                        Detail
                                    </a>

                                    {{-- Edit dan Hapus hanya Admin --}}
                                    @if(session('user_role') === 'admin')

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

{{-- Pagination --}}
@if($assets->hasPages())
    <div class="mt-4">
        {{ $assets->links() }}
    </div>
@endif

@endsection
