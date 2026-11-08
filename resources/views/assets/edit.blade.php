@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Edit Aset</h2>
        <p class="text-muted mb-0">
            Perbarui data aset
        </p>
    </div>

    <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>

<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">
        <strong>Form Edit Data Aset</strong>
    </div>

    <div class="card-body">

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

        <form action="{{ route('assets.update', $asset) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Kode Aset <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="kode_aset"
                        class="form-control"
                        value="{{ old('kode_aset', $asset->kode_aset) }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Nama Aset <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_aset"
                        class="form-control"
                        value="{{ old('nama_aset', $asset->nama_aset) }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Kategori <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="kategori"
                        class="form-control"
                        value="{{ old('kategori', $asset->kategori) }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Tanggal Pembelian
                    </label>

                    <input
                        type="date"
                        name="tanggal_pembelian"
                        class="form-control"
                        value="{{ old('tanggal_pembelian', optional($asset->tanggal_pembelian)->format('Y-m-d')) }}"
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Lokasi</label>

                    <input
                        type="text"
                        name="lokasi"
                        class="form-control"
                        value="{{ old('lokasi', $asset->lokasi) }}"
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Divisi</label>

                    <input
                        type="text"
                        name="divisi"
                        class="form-control"
                        value="{{ old('divisi', $asset->divisi) }}"
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Penanggung Jawab</label>

                    <input
                        type="text"
                        name="penanggung_jawab"
                        class="form-control"
                        value="{{ old('penanggung_jawab', $asset->penanggung_jawab) }}"
                    >
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">
                        Kondisi <span class="text-danger">*</span>
                    </label>

                    <select name="kondisi" class="form-select" required>

                        <option value="Baik"
                            {{ old('kondisi', $asset->kondisi) == 'Baik' ? 'selected' : '' }}>
                            Baik
                        </option>

                        <option value="Rusak Ringan"
                            {{ old('kondisi', $asset->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>
                            Rusak Ringan
                        </option>

                        <option value="Rusak Berat"
                            {{ old('kondisi', $asset->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>
                            Rusak Berat
                        </option>

                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">
                        Status <span class="text-danger">*</span>
                    </label>

                    <select name="status" class="form-select" required>

                        <option value="Aktif"
                            {{ old('status', $asset->status) == 'Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Tidak Aktif"
                            {{ old('status', $asset->status) == 'Tidak Aktif' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>

                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Keterangan</label>

                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="4"
                    >{{ old('keterangan', $asset->keterangan) }}</textarea>
                </div>

            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('assets.show', $asset) }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button type="submit" class="btn btn-dark">
                    💾 Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection