
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Tambah Maintenance</h2>
        <p class="text-muted mb-0">
            Tambahkan data maintenance aset
        </p>
    </div>

    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white">
        <strong>Form Maintenance Aset</strong>
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

                        @foreach($assets as $asset)
                            <option
                                value="{{ $asset->id }}"
                                data-lokasi="{{ $asset->lokasi }}"
                                data-divisi="{{ $asset->divisi }}"
                                data-pj="{{ $asset->penanggung_jawab }}"
                                {{ old('asset_id') == $asset->id ? 'selected' : '' }}
                            >
                                {{ $asset->kode_aset }} - {{ $asset->nama_aset }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- INFORMASI ASET --}}
                <div class="col-12 mb-4">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <strong>Data Aset Saat Ini</strong>
                        </div>

                        <div class="card-body bg-light">
                            <div class="row">

                                <div class="col-md-4 mb-2">
                                    <label class="form-label">
                                        Kantor / Lokasi Aset
                                    </label>

                                    <input
                                        type="text"
                                        id="lokasi_aset"
                                        class="form-control"
                                        placeholder="Otomatis dari data aset"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label class="form-label">
                                        Divisi Aset
                                    </label>

                                    <input
                                        type="text"
                                        id="divisi_aset"
                                        class="form-control"
                                        placeholder="Otomatis dari data aset"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label class="form-label">
                                        Penanggung Jawab Aset
                                    </label>

                                    <input
                                        type="text"
                                        id="pj_aset"
                                        class="form-control"
                                        placeholder="Otomatis dari data aset"
                                        readonly
                                    >
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

                {{-- PENANGGUNG JAWAB --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Penanggung Jawab Maintenance
                    </label>

                    <input
                        type="text"
                        name="penanggung_jawab"
                        class="form-control"
                        value="{{ old('penanggung_jawab') }}"
                        placeholder="Nama teknisi / penanggung jawab"
                    >
                </div>

                {{-- STATUS --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Status <span class="text-danger">*</span>
                    </label>

                    <select name="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>

                        <option value="Terjadwal"
                            {{ old('status') == 'Terjadwal' ? 'selected' : '' }}>
                            Terjadwal
                        </option>

                        <option value="Proses"
                            {{ old('status') == 'Proses' ? 'selected' : '' }}>
                            Proses
                        </option>

                        <option value="Selesai"
                            {{ old('status') == 'Selesai' ? 'selected' : '' }}>
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

                {{-- KETERANGAN --}}
                <div class="col-12 mb-3">
                    <label class="form-label">Keterangan</label>

                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="4"
                        placeholder="Keterangan maintenance..."
                    >{{ old('keterangan') }}</textarea>
                </div>

                {{-- DOKUMENTASI MAINTENANCE --}}
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
                        Format JPG, JPEG, PNG, WEBP, atau PDF; maksimal 5 MB.
                    </small>

                    {{-- PREVIEW FOTO --}}
                    <div id="preview-dokumen" class="mt-3" style="display: none;">
                        <div class="border rounded p-3">
                            <strong class="d-block mb-2">
                                Preview Dokumentasi:
                            </strong>

                            <img
                                id="preview-gambar"
                                src=""
                                alt="Preview Dokumentasi"
                                class="img-thumbnail"
                                style="max-width: 250px; max-height: 200px; display: none;"
                            >

                            <div id="preview-pdf" style="display: none;">
                                📄 <span id="nama-pdf"></span>
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

                <button type="submit" class="btn btn-dark">
                    💾 Simpan Maintenance
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // OTOMATIS MENGISI INFORMASI ASET
    const assetSelect = document.getElementById('asset_id');

    const lokasiAset = document.getElementById('lokasi_aset');
    const divisiAset = document.getElementById('divisi_aset');
    const pjAset = document.getElementById('pj_aset');

    function isiDataAset() {

        const selectedOption =
            assetSelect.options[assetSelect.selectedIndex];

        if (!selectedOption || selectedOption.value === '') {
            lokasiAset.value = '';
            divisiAset.value = '';
            pjAset.value = '';
            return;
        }

        lokasiAset.value = selectedOption.dataset.lokasi || '';
        divisiAset.value = selectedOption.dataset.divisi || '';
        pjAset.value = selectedOption.dataset.pj || '';
    }

    assetSelect.addEventListener('change', isiDataAset);
    isiDataAset();


    // PREVIEW DOKUMENTASI
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

        // Validasi format file
        const ekstensi = file.name.split('.').pop().toLowerCase();

        const formatDiizinkan = [
            'jpg', 'jpeg', 'png', 'webp', 'pdf'
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

@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Tambah Maintenance</h2>
        <p class="text-muted mb-0">
            Tambahkan data maintenance aset
        </p>
    </div>

    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white">
        <strong>Form Maintenance Aset</strong>
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

                        @foreach($assets as $asset)
                            <option
                                value="{{ $asset->id }}"
                                data-lokasi="{{ $asset->lokasi }}"
                                data-divisi="{{ $asset->divisi }}"
                                data-pj="{{ $asset->penanggung_jawab }}"
                                {{ old('asset_id') == $asset->id ? 'selected' : '' }}
                            >
                                {{ $asset->kode_aset }} - {{ $asset->nama_aset }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- INFORMASI ASET --}}
                <div class="col-12 mb-4">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <strong>Data Aset Saat Ini</strong>
                        </div>

                        <div class="card-body bg-light">
                            <div class="row">

                                <div class="col-md-4 mb-2">
                                    <label class="form-label">
                                        Kantor / Lokasi Aset
                                    </label>

                                    <input
                                        type="text"
                                        id="lokasi_aset"
                                        class="form-control"
                                        placeholder="Otomatis dari data aset"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label class="form-label">
                                        Divisi Aset
                                    </label>

                                    <input
                                        type="text"
                                        id="divisi_aset"
                                        class="form-control"
                                        placeholder="Otomatis dari data aset"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label class="form-label">
                                        Penanggung Jawab Aset
                                    </label>

                                    <input
                                        type="text"
                                        id="pj_aset"
                                        class="form-control"
                                        placeholder="Otomatis dari data aset"
                                        readonly
                                    >
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

                {{-- PENANGGUNG JAWAB --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Penanggung Jawab Maintenance
                    </label>

                    <input
                        type="text"
                        name="penanggung_jawab"
                        class="form-control"
                        value="{{ old('penanggung_jawab') }}"
                        placeholder="Nama teknisi / penanggung jawab"
                    >
                </div>

                {{-- STATUS --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Status <span class="text-danger">*</span>
                    </label>

                    <select name="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>

                        <option value="Terjadwal"
                            {{ old('status') == 'Terjadwal' ? 'selected' : '' }}>
                            Terjadwal
                        </option>

                        <option value="Proses"
                            {{ old('status') == 'Proses' ? 'selected' : '' }}>
                            Proses
                        </option>

                        <option value="Selesai"
                            {{ old('status') == 'Selesai' ? 'selected' : '' }}>
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

                {{-- KETERANGAN --}}
                <div class="col-12 mb-3">
                    <label class="form-label">Keterangan</label>

                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="4"
                        placeholder="Keterangan maintenance..."
                    >{{ old('keterangan') }}</textarea>
                </div>

                {{-- DOKUMENTASI MAINTENANCE --}}
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
                        Format JPG, JPEG, PNG, WEBP, atau PDF; maksimal 5 MB.
                    </small>

                    {{-- PREVIEW FOTO --}}
                    <div id="preview-dokumen" class="mt-3" style="display: none;">
                        <div class="border rounded p-3">
                            <strong class="d-block mb-2">
                                Preview Dokumentasi:
                            </strong>

                            <img
                                id="preview-gambar"
                                src=""
                                alt="Preview Dokumentasi"
                                class="img-thumbnail"
                                style="max-width: 250px; max-height: 200px; display: none;"
                            >

                            <div id="preview-pdf" style="display: none;">
                                📄 <span id="nama-pdf"></span>
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

                <button type="submit" class="btn btn-dark">
                    💾 Simpan Maintenance
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // OTOMATIS MENGISI INFORMASI ASET
    const assetSelect = document.getElementById('asset_id');

    const lokasiAset = document.getElementById('lokasi_aset');
    const divisiAset = document.getElementById('divisi_aset');
    const pjAset = document.getElementById('pj_aset');

    function isiDataAset() {

        const selectedOption =
            assetSelect.options[assetSelect.selectedIndex];

        if (!selectedOption || selectedOption.value === '') {
            lokasiAset.value = '';
            divisiAset.value = '';
            pjAset.value = '';
            return;
        }

        lokasiAset.value = selectedOption.dataset.lokasi || '';
        divisiAset.value = selectedOption.dataset.divisi || '';
        pjAset.value = selectedOption.dataset.pj || '';
    }

    assetSelect.addEventListener('change', isiDataAset);
    isiDataAset();


    // PREVIEW DOKUMENTASI
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

        // Validasi format file
        const ekstensi = file.name.split('.').pop().toLowerCase();

        const formatDiizinkan = [
            'jpg', 'jpeg', 'png', 'webp', 'pdf'
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
