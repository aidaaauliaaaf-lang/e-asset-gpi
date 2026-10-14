
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Tambah Aset</h2>
        <p class="text-muted mb-0">Tambahkan data aset baru</p>
    </div>
    <a href="{{ route('assets.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa kembali data berikut:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('assets.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kode Aset *</label>
                    <input type="text" name="kode_aset" class="form-control"
                           value="{{ old('kode_aset') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Aset *</label>
                    <input type="text" name="nama_aset" class="form-control"
                           value="{{ old('nama_aset') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kategori *</label>
                    <input type="text" name="kategori" class="form-control"
                           value="{{ old('kategori') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian"
                           class="form-control"
                           value="{{ old('tanggal_pembelian') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control"
                           value="{{ old('lokasi') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Divisi</label>
                    <input type="text" name="divisi" class="form-control"
                           value="{{ old('divisi') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab"
                           class="form-control"
                           value="{{ old('penanggung_jawab') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kondisi *</label>
                    <select name="kondisi" class="form-select" required>
                        <option value="Baik" @selected(old('kondisi', 'Baik') === 'Baik')>Baik</option>
                        <option value="Rusak Ringan" @selected(old('kondisi') === 'Rusak Ringan')>Rusak Ringan</option>
                        <option value="Rusak Berat" @selected(old('kondisi') === 'Rusak Berat')>Rusak Berat</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="Aktif" @selected(old('status', 'Aktif') === 'Aktif')>Aktif</option>
                        <option value="Tidak Aktif" @selected(old('status') === 'Tidak Aktif')>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Foto Aset</label>
                    <input type="file" name="foto" class="form-control"
                           accept="image/jpeg,image/png,image/webp">
                    <small class="text-muted">
                        Format JPG, PNG, atau WEBP; maksimal 2 MB.
                    </small>
                </div>

                <div class="col-12">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control"
                              rows="3">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-dark">
                    Simpan Aset
                </button>
                <a href="{{ route('assets.index') }}"
                   class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
