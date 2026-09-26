@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">Mutasi Aset</h2>

        <p class="text-muted mb-0">
            Kelola perpindahan aset antar lokasi, divisi, dan penanggung jawab
        </p>
    </div>

    <a href="{{ route('mutations.create') }}" class="btn btn-dark">
        + Tambah Mutasi
    </a>

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">
        <strong>Riwayat Mutasi Aset</strong>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0 align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>

                        <th>Kode Aset</th>

                        <th>Nama Aset</th>

                        <th>Lokasi Asal</th>

                        <th>Lokasi Tujuan</th>

                        <th>Divisi Asal</th>

                        <th>Divisi Tujuan</th>

                        <th>PJ Lama</th>

                        <th>PJ Baru</th>

                        <th>Tanggal Mutasi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($mutations as $mutation)

                        <tr>

                            <td>
                                {{ $mutations->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $mutation->asset->kode_aset ?? '-' }}
                                </strong>
                            </td>

                            <td>
                                {{ $mutation->asset->nama_aset ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->lokasi_asal ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->lokasi_tujuan ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->divisi_asal ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->divisi_tujuan ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->penanggung_jawab_lama ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->penanggung_jawab_baru ?? '-' }}
                            </td>

                            <td>
                                {{ $mutation->tanggal_mutasi
                                    ? $mutation->tanggal_mutasi->format('d-m-Y')
                                    : '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="10"
                                class="text-center text-muted py-5"
                            >

                                Belum ada data mutasi aset.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


@if($mutations->hasPages())

    <div class="mt-4">

        {{ $mutations->links() }}

    </div>

@endif

@endsection