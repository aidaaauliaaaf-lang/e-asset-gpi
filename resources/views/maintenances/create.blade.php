
@extends('layouts.app')

@section('content')

@php
    $selectedAssetId = old(
        'asset_id',
        $asset->id ?? request()->query('asset_id')
    );

    $selectedAsset = $assets->firstWhere('id', $selectedAssetId);
@endphp

{{-- JUDUL HALAMAN --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Tambah Maintenance</h2>
        <p class="text-muted mb-0">Tambahkan data maintenance aset</p>
    </div>

    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>

{{-- NOTIFIKASI --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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

{{-- FORM MAINTENANCE --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white">
        <strong>Form Maintenance Aset</strong>
    </div>

    <div class="card-body">

        <form
            action="{{ route('maintenances.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="row">

                {{-- PILIH ASET --}}
                <div class="col-12 mb-3">
                    <label class="form-label">
                        Pilih Aset <span class="text-danger">*</span>
                    </label>

                    <select
                        name="asset_id"
                        id="asset_id"
                        class="form-select"
                        required
                    >
                        <option value="">-- Pilih Aset --</option>

                        @foreach($assets as $item)
                            <option
                                value="{{ $item->id }}"
                                data-lokasi="{{ $item->lokasi ?? '' }}"
                                data-divisi="{{ $item->divisi ?? '' }}"
                                data-pj="{{ $item->penanggung_jawab ?? '' }}"
                                data-kondisi="{{ $item->kondisi ?? '' }}"
                                data-keterangan="{{ $item->keterangan ?? '' }}"
                                {{ (string) $selectedAssetId === (string) $item->id ? 'selected' : '' }}
                            >
                                {{ $item->kode_aset }} - {{ $item->nama_aset }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- INFORMASI ASET --}}
                <div class="col-12 mb-4">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <strong>Informasi Aset</strong>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                {{-- LOKASI --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi Aset</label>

                                    <input
                                        type="text"
                                        id="lokasi_aset"
                                        class="form-control"
                                        value="{{ $selectedAsset->lokasi ?? '' }}"
                                        placeholder="Lokasi aset"
                                        readonly
                                    >
                                </div>

                                {{-- DIVISI --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Divisi Aset</label>

                                    <input
                                        type="text"
                                        id="divisi_aset"
                                        class="form-control"
                                        value="{{ $selectedAsset->divisi ?? '' }}"
                                        placeholder="Divisi aset"
                                        readonly
                                    >
                                </div>

                                {{-- PENANGGUNG JAWAB ASET --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Penanggung Jawab Aset
                                    </label>

                                    <input
                                        type="text"
                                        id="penanggung_jawab_aset"
                                        class="form-control"
                                        value="{{ old('penanggung_jawab_aset', $selectedAsset->penanggung_jawab ?? '') }}"
                                        placeholder="Mengikuti penanggung jawab Maintenance"
                                        readonly
                                    >

                                    <small class="text-muted">
                                        Akan diperbarui mengikuti nama pelaksana Maintenance.
                                    </small>
                                </div>

                                {{-- KONDISI ASET --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Kondisi Aset
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        name="kondisi_aset_baru"
                                        id="kondisi_aset_baru"
                                        class="form-select"
                                        required
                                    >
                                        <option value="">-- Pilih Kondisi --</option>

                                        <option
                                            value="Baik"
                                            {{ old('kondisi_aset_baru', $selectedAsset->kondisi ?? '') == 'Baik' ? 'selected' : '' }}
                                        >
                                            Baik
                                        </option>

                                        <option
                                            value="Rusak Ringan"
                                            {{ old('kondisi_aset_baru', $selectedAsset->kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}
                                        >
                                            Rusak Ringan
                                        </option>

                                        <option
                                            value="Rusak Berat"
                                            {{ old('kondisi_aset_baru', $selectedAsset->kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}
                                        >
                                            Rusak Berat
                                        </option>
                                    </select>
                                </div>

                                {{-- KETERANGAN ASET --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        Keterangan Aset
                                    </label>

                                    <textarea
                                        name="keterangan_aset_baru"
                                        id="keterangan_aset_baru"
                                        class="form-control"
                                        rows="3"
                                        placeholder="Keterangan kondisi aset terbaru"
                                    >{{ old('keterangan_aset_baru', $selectedAsset->keterangan ?? '') }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- TANGGAL MAINTENANCE --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Tanggal Maintenance
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_maintenance"
                        class="form-control"
                        value="{{ old('tanggal_maintenance', date('Y-m-d')) }}"
                        required
                    >
                </div>

                {{-- JENIS MAINTENANCE --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Jenis Maintenance
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="jenis_maintenance"
                        class="form-control"
                        value="{{ old('jenis_maintenance') }}"
                        placeholder="Contoh: Perbaikan Laptop"
                        required
                    >
                </div>

                {{-- PENANGGUNG JAWAB MAINTENANCE --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Penanggung Jawab Maintenance
                    </label>

                    <input
                        type="text"
                        name="penanggung_jawab"
                        id="penanggung_jawab"
                        class="form-control"
                        value="{{ old('penanggung_jawab') }}"
                        placeholder="Nama teknisi / pelaksana Maintenance"
                    >

                    <small class="text-muted">
                        Nama ini akan menjadi Penanggung Jawab terbaru pada Informasi Aset.
                    </small>
                </div>

                {{-- STATUS MAINTENANCE --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Status <span class="text-danger">*</span>
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required
                    >
                        <option value="">-- Pilih Status --</option>

                        <option
                            value="Terjadwal"
                            {{ old('status') == 'Terjadwal' ? 'selected' : '' }}
                        >
                            Terjadwal
                        </option>

                        <option
                            value="Proses"
                            {{ old('status') == 'Proses' ? 'selected' : '' }}
                        >
                            Proses
                        </option>

                        <option
                            value="Selesai"
                            {{ old('status') == 'Selesai' ? 'selected' : '' }}
                        >
                            Selesai
                        </option>
                    </select>
                </div>

                {{-- MAINTENANCE BERIKUTNYA --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Maintenance Berikutnya
                    </label>

                    <input
                        type="date"
                        name="tanggal_maintenance_berikutnya"
                        class="form-control"
                        value="{{ old('tanggal_maintenance_berikutnya') }}"
                    >
                </div>

                {{-- KETERANGAN PEKERJAAN MAINTENANCE --}}
                <div class="col-12 mb-3">
                    <label class="form-label">
                        Keterangan Pekerjaan Maintenance
                    </label>

                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="4"
                        placeholder="Contoh: Penggantian keyboard, pembersihan perangkat, dan pengecekan sistem..."
                    >{{ old('keterangan') }}</textarea>
                </div>

                {{-- DOKUMENTASI --}}
                <div class="col-12 mb-3">
                    <label for="dokumen" class="form-label">
                        Dokumentasi Maintenance
                    </label>

                    <input
                        type="file"
                        name="dokumen"
                        id="dokumen"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp,.pdf"
                    >

                    <small class="text-muted">
                        Format JPG, JPEG, PNG, WEBP, atau PDF.
                        Maksimal 5 MB.
                    </small>

                    {{-- PREVIEW DOKUMENTASI --}}
                    <div
                        id="preview-dokumen"
                        class="mt-3"
                        style="display:none;"
                    >
                        <div class="border rounded p-3">

                            <strong class="d-block mb-2">
                                Preview Dokumentasi:
                            </strong>

                            <img
                                id="preview-gambar"
                                src=""
                                alt="Preview Dokumentasi"
                                class="img-thumbnail"
                                style="max-width:250px; max-height:200px; display:none;"
                            >

                            <div id="preview-pdf" style="display:none;">
                                File PDF:
                                <span id="nama-pdf"></span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <hr>

            {{-- TOMBOL --}}
            <div class="d-flex justify-content-end gap-2">
                <a
                    href="{{ route('maintenances.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-dark"
                >
                    Simpan Maintenance
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // INFORMASI ASET OTOMATIS
    // ==========================================

    const assetSelect = document.getElementById('asset_id');

    const lokasiAset = document.getElementById('lokasi_aset');
    const divisiAset = document.getElementById('divisi_aset');

    const pjAset = document.getElementById('penanggung_jawab_aset');
    const pjMaintenance = document.getElementById('penanggung_jawab');

    const kondisiAset = document.getElementById('kondisi_aset_baru');
    const keteranganAset = document.getElementById('keterangan_aset_baru');

    // Ketika pengguna memilih aset lain,
    // tampilkan data awal dari aset yang dipilih.
    assetSelect.addEventListener('change', function () {

        const option = assetSelect.options[assetSelect.selectedIndex];

        if (!option || !option.value) {
            lokasiAset.value = '';
            divisiAset.value = '';
            pjAset.value = '';
            kondisiAset.value = '';
            keteranganAset.value = '';
            return;
        }

        lokasiAset.value = option.dataset.lokasi || '';
        divisiAset.value = option.dataset.divisi || '';
        pjAset.value = option.dataset.pj || '';
        kondisiAset.value = option.dataset.kondisi || '';
        keteranganAset.value = option.dataset.keterangan || '';
    });

    // Preview nama Penanggung Jawab Aset
    // mengikuti input Penanggung Jawab Maintenance.
    pjMaintenance.addEventListener('input', function () {
        pjAset.value = pjMaintenance.value;
    });

    // ==========================================
    // PREVIEW DOKUMENTASI
    // ==========================================

    const inputDokumen = document.getElementById('dokumen');
    const previewDokumen = document.getElementById('preview-dokumen');
    const previewGambar = document.getElementById('preview-gambar');
    const previewPdf = document.getElementById('preview-pdf');
    const namaPdf = document.getElementById('nama-pdf');

    inputDokumen.addEventListener('change', function () {

        const file = this.files[0];

        previewDokumen.style.display = 'none';
        previewGambar.style.display = 'none';
        previewGambar.src = '';
        previewPdf.style.display = 'none';
        namaPdf.textContent = '';

        if (!file) return;

        // Validasi ukuran maksimal 5 MB
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5 MB.');
            this.value = '';
            return;
        }

        // Validasi format
        const ekstensi = file.name.split('.').pop().toLowerCase();

        const formatDiizinkan = [
            'jpg',
            'jpeg',
            'png',
            'webp',
            'pdf'
        ];

        if (!formatDiizinkan.includes(ekstensi)) {
            alert('Format file harus JPG, JPEG, PNG, WEBP, atau PDF.');
            this.value = '';
            return;
        }

        previewDokumen.style.display = 'block';

        if (ekstensi === 'pdf') {

            previewPdf.style.display = 'block';
            namaPdf.textContent = file.name;

        } else {

            const reader = new FileReader();

            reader.onload = function (event) {
                previewGambar.src = event.target.result;
                previewGambar.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    });

});
</script>
@endpush
