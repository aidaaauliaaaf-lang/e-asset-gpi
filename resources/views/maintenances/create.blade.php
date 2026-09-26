@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">Tambah Maintenance</h2>

        <p class="text-muted mb-0">
            Tambahkan data maintenance aset
        </p>
    </div>

    <a href="{{ route('maintenances.index') }}"
       class="btn btn-secondary">
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


        <form action="{{ route('maintenances.store') }}"
              method="POST">

            @csrf

            <div class="row">

                {{-- ASET --}}
                <div class="col-12 mb-3">

                    <label class="form-label">
                        Pilih Aset <span class="text-danger">*</span>
                    </label>

                    <select
                        name="asset_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            -- Pilih Aset --
                        </option>

                        @foreach($assets as $asset)

                            <option
                                value="{{ $asset->id }}"
                                {{ old('asset_id') == $asset->id ? 'selected' : '' }}
                            >

                                {{ $asset->kode_aset }}
                                -
                                {{ $asset->nama_aset }}

                            </option>

                        @endforeach

                    </select>

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


                {{-- JENIS --}}
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
                        Penanggung Jawab
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
                        Status
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required
                    >

                        <option value="">
                            -- Pilih Status --
                        </option>

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

                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="4"
                        placeholder="Keterangan maintenance..."
                    >{{ old('keterangan') }}</textarea>

                </div>

            </div>


            <hr>


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
                    💾 Simpan Maintenance
                </button>

            </div>

        </form>

    </div>

</div>

@endsection