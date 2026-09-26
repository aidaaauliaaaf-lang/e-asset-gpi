@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">Maintenance Aset</h2>
        <p class="text-muted mb-0">
            Kelola jadwal dan riwayat maintenance aset
        </p>
    </div>

    <a href="{{ route('maintenances.create') }}" class="btn btn-dark">
        + Tambah Maintenance
    </a>

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">
        <strong>Data Maintenance</strong>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0 align-middle">

                <thead class="table-light">

                    <tr>
                        <th width="60">No</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Tanggal</th>
                        <th>Jenis Maintenance</th>
                        <th>Penanggung Jawab</th>
                        <th>Status</th>
                        <th>Maintenance Berikutnya</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($maintenances as $maintenance)

                        <tr>

                            <td>
                                {{ $maintenances->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $maintenance->asset->kode_aset ?? '-' }}
                                </strong>
                            </td>

                            <td>
                                {{ $maintenance->asset->nama_aset ?? '-' }}
                            </td>

                            <td>
                                {{ $maintenance->tanggal_maintenance
                                    ? $maintenance->tanggal_maintenance->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $maintenance->jenis_maintenance }}
                            </td>

                            <td>
                                {{ $maintenance->penanggung_jawab ?? '-' }}
                            </td>

                            <td>

                                @if($maintenance->status === 'Selesai')

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                @elseif($maintenance->status === 'Proses')

                                    <span class="badge bg-warning text-dark">
                                        Proses
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Terjadwal
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $maintenance->tanggal_maintenance_berikutnya
                                    ? $maintenance->tanggal_maintenance_berikutnya->format('d-m-Y')
                                    : '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center text-muted py-5">

                                Belum ada data maintenance aset.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@if($maintenances->hasPages())

    <div class="mt-4">
        {{ $maintenances->links() }}
    </div>

@endif

@endsection