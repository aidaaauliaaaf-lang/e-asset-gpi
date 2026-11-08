@extends('layouts.app')

@section('title', 'Tambah Mutasi Aset')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Tambah Mutasi Aset</h3>
            <p class="text-muted mb-0">
                Catat perpindahan aset dari data lama ke data baru.
            </p>
        </div>

        <a href="{{ route('mutations.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum dapat disimpan.</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">
                Form Mutasi Aset
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('mutations.store') }}" method="POST">

                @csrf

                {{-- PILIH ASET --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Pilih Aset <span class="text-danger">*</span>
                    </label>

                    <select
                        name="asset_id"
                        id="asset_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            -- Pilih Aset --
                        </option>

                        @foreach ($assets as $asset)

                            <option
                                value="{{ $asset->id }}"
                                data-lokasi="{{ $asset->lokasi }}"
                                data-divisi="{{ $asset->divisi }}"
                                data-pj="{{ $asset->penanggung_jawab }}"
                            >
                                {{ $asset->kode_aset }} -
                                {{ $asset->nama_aset }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- DATA LAMA --}}
                <div class="card bg-light border mb-4">

                    <div class="card-header bg-light">
                        <strong>Data Lama / Asal</strong>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            {{-- KANTOR / LOKASI ASAL --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Kantor / Lokasi Asal
                                </label>

                                <input
                                    type="text"
                                    name="lokasi_asal"
                                    id="lokasi_asal"
                                    class="form-control"
                                    readonly
                                    placeholder="Otomatis dari data aset"
                                >

                            </div>


                            {{-- DIVISI ASAL --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Divisi Asal
                                </label>

                                <input
                                    type="text"
                                    name="divisi_asal"
                                    id="divisi_asal"
                                    class="form-control"
                                    readonly
                                    placeholder="Otomatis dari data aset"
                                >

                            </div>


                            {{-- PJ LAMA --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Penanggung Jawab Lama
                                </label>

                                <input
                                    type="text"
                                    name="penanggung_jawab_lama"
                                    id="penanggung_jawab_lama"
                                    class="form-control"
                                    readonly
                                    placeholder="Otomatis dari data aset"
                                >

                            </div>

                        </div>

                    </div>

                </div>


                {{-- DATA BARU --}}
                <div class="card border mb-4">

                    <div class="card-header bg-white">
                        <strong>Data Baru / Tujuan</strong>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            {{-- KANTOR TUJUAN --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Kantor / Lokasi Tujuan
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="lokasi_tujuan"
                                    class="form-control"
                                    placeholder="Masukkan kantor tujuan"
                                    value="{{ old('lokasi_tujuan') }}"
                                    required
                                >

                            </div>


                            {{-- DIVISI TUJUAN --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Divisi Tujuan
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="divisi_tujuan"
                                    class="form-control"
                                    placeholder="Masukkan divisi tujuan"
                                    value="{{ old('divisi_tujuan') }}"
                                    required
                                >

                            </div>


                            {{-- PJ BARU --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Penanggung Jawab Baru
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="penanggung_jawab_baru"
                                    class="form-control"
                                    placeholder="Masukkan penanggung jawab baru"
                                    value="{{ old('penanggung_jawab_baru') }}"
                                    required
                                >

                            </div>

                        </div>

                    </div>

                </div>


                {{-- TANGGAL & KETERANGAN --}}
                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Tanggal Mutasi
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_mutasi"
                            class="form-control"
                            value="{{ old('tanggal_mutasi', date('Y-m-d')) }}"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Keterangan mutasi..."
                        >{{ old('keterangan') }}</textarea>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('mutations.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Simpan Mutasi
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const assetSelect = document.getElementById('asset_id');

    const lokasiAsal = document.getElementById('lokasi_asal');

    const divisiAsal = document.getElementById('divisi_asal');

    const pjLama = document.getElementById('penanggung_jawab_lama');


    assetSelect.addEventListener('change', function () {

        const selectedOption =
            assetSelect.options[assetSelect.selectedIndex];


        if (selectedOption.value === '') {

            lokasiAsal.value = '';
            divisiAsal.value = '';
            pjLama.value = '';

            return;
        }


        lokasiAsal.value =
            selectedOption.getAttribute('data-lokasi') || '';

        divisiAsal.value =
            selectedOption.getAttribute('data-divisi') || '';

        pjLama.value =
            selectedOption.getAttribute('data-pj') || '';

    });

});

</script>

@endpush