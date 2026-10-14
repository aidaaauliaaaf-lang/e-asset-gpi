
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Data Aset</h2>
        <p class="text-muted mb-0">
            Kelola seluruh data aset PT Golden Piping Indonesia
        </p>
    </div>

    <a href="{{ route('assets.create') }}" class="btn btn-dark">
        + Tambah Aset
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

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
                        placeholder="Cari kode, nama, kategori, lokasi, atau divisi..."
                    >
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

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
                            <td>{{ $assets->firstItem() + $loop->index }}</td>

                            <td class="text-center">
                                @if($asset->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($asset->foto))
                                    <a href="{{ asset('storage/' . $asset->foto) }}" target="_blank">
                                        <img
                                            src="{{ asset('storage/' . $asset->foto) }}"
                                            alt="Foto {{ $asset->nama_aset }}"
                                            style="width:70px;height:60px;object-fit:cover;border-radius:6px;"
                                        >
                                    </a>
                                @else
                                    <div class="text-muted small"
                                         style="width:70px;height:60px;display:flex;align-items:center;justify-content:center;background:#f1f3f5;border-radius:6px;">
                                        Belum ada foto
                                    </div>
                                @endif
                            </td>

                            <td><strong>{{ $asset->kode_aset }}</strong></td>
                            <td>{{ $asset->nama_aset }}</td>
                            <td>{{ $asset->kategori }}</td>
                            <td>{{ $asset->lokasi ?? '-' }}</td>
                            <td>{{ $asset->divisi ?? '-' }}</td>

                            <td>
                                @if($asset->kondisi === 'Baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif($asset->kondisi === 'Rusak Ringan')
                                    <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                @elseif($asset->kondisi === 'Rusak Berat')
                                    <span class="badge bg-danger">Rusak Berat</span>
                                @else
                                    <span class="badge bg-secondary">{{ $asset->kondisi }}</span>
                                @endif
                            </td>

                            <td>
                                @if($asset->status === 'Aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">{{ $asset->status }}</span>
                                @endif
                            </td>

                            <td class="text-nowrap">
                                <a href="{{ route('assets.show', $asset) }}"
                                   class="btn btn-sm btn-info text-white">
                                    Detail
                                </a>

                                @if(session('user_role') === 'admin')
                                    <a href="{{ route('assets.edit', $asset) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('assets.destroy', $asset) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                Belum ada data aset.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($assets->hasPages())
    <div class="mt-4">
        {{ $assets->links() }}
    </div>
@endif
@endsection
