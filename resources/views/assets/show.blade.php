@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Detail Aset</h2>
        <p class="text-muted mb-0">
            Informasi lengkap aset
        </p>
    </div>

    <div>
        <a href="{{ route('assets.edit', $asset) }}" class="btn btn-warning">
            Edit
        </a>

        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4">

    {{-- INFORMASI ASET --}}
    <div class="col-lg-8">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white">
                <strong>Informasi Aset</strong>
            </div>

            <div class="card-body">

                <table class="table table-bordered align-middle mb-0">

                    <tr>
                        <th width="35%">Kode Aset</th>
                        <td>{{ $asset->kode_aset }}</td>
                    </tr>

                    <tr>
                        <th>Nama Aset</th>
                        <td>{{ $asset->nama_aset }}</td>
                    </tr>

                    <tr>
                        <th>Kategori</th>
                        <td>{{ $asset->kategori }}</td>
                    </tr>

                    <tr>
                        <th>Tanggal Pembelian</th>
                        <td>
                            {{ $asset->tanggal_pembelian
                                ? $asset->tanggal_pembelian->format('d-m-Y')
                                : '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $asset->lokasi ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Divisi</th>
                        <td>{{ $asset->divisi ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Penanggung Jawab</th>
                        <td>{{ $asset->penanggung_jawab ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Kondisi</th>
                        <td>{{ $asset->kondisi }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>{{ $asset->status }}</td>
                    </tr>

                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $asset->keterangan ?? '-' }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    {{-- QR CODE --}}
    <div class="col-lg-4">

        <div class="card shadow-sm border-0 text-center">

            <div class="card-header bg-dark text-white">
                <strong>QR Code Aset</strong>
            </div>

            <div class="card-body">

                <div id="qrcode" class="d-flex justify-content-center mb-3"></div>

                <h5 class="fw-bold">
                    {{ $asset->kode_aset }}
                </h5>

                <p class="text-muted mb-0">
                    Scan QR Code untuk identifikasi aset
                </p>

            </div>

        </div>

    </div>

</div>

{{-- RIWAYAT MUTASI --}}
<div class="card shadow-sm border-0 mt-4">

    <div class="card-header bg-dark text-white">
        <strong>Riwayat Mutasi Aset</strong>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Lokasi Asal</th>
                        <th>Lokasi Tujuan</th>
                        <th>Divisi Asal</th>
                        <th>Divisi Tujuan</th>
                        <th>Penanggung Jawab Baru</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($asset->mutations as $mutation)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $mutation->tanggal_mutasi
                                    ? $mutation->tanggal_mutasi->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>{{ $mutation->lokasi_asal ?? '-' }}</td>

                            <td>{{ $mutation->lokasi_tujuan ?? '-' }}</td>

                            <td>{{ $mutation->divisi_asal ?? '-' }}</td>

                            <td>{{ $mutation->divisi_tujuan ?? '-' }}</td>

                            <td>{{ $mutation->penanggung_jawab_baru ?? '-' }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada riwayat mutasi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- RIWAYAT MAINTENANCE --}}
<div class="card shadow-sm border-0 mt-4 mb-4">

    <div class="card-header bg-dark text-white">
        <strong>Riwayat Maintenance</strong>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Maintenance</th>
                        <th>Penanggung Jawab</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($asset->maintenances as $maintenance)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $maintenance->tanggal_maintenance
                                    ? $maintenance->tanggal_maintenance->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>{{ $maintenance->jenis_maintenance }}</td>

                            <td>{{ $maintenance->penanggung_jawab ?? '-' }}</td>

                            <td>{{ $maintenance->status }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada riwayat maintenance.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- QR CODE --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    new QRCode(document.getElementById("qrcode"), {
        text: "{{ $asset->kode_aset }}",
        width: 200,
        height: 200
    });
</script>

@endsection