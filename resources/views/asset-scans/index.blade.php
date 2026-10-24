
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold">Scan QR Code Aset</h2>
        <p class="text-muted">
            PT Golden Piping Indonesia — Pemindaian aset oleh karyawan
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <strong>Pemindaian QR Code</strong>
        </div>

        <div class="card-body">
            <div id="reader" style="max-width: 500px; margin: auto;"></div>

            <form action="{{ route('asset-scans.store') }}"
                  method="POST" class="mt-4">
                @csrf

                <label for="qr_code" class="form-label fw-semibold">
                    Kode QR / Kode Aset
                </label>

                <div class="input-group">
                    <input
                        type="text"
                        id="qr_code"
                        name="qr_code"
                        class="form-control"
                        placeholder="Scan QR atau masukkan kode aset"
                        value="{{ old('qr_code') }}"
                        required
                    >
                    <button type="submit" class="btn btn-primary">
                        Validasi & Simpan
                    </button>
                </div>

                <small class="text-muted">
                    Jika kamera tidak tersedia, masukkan kode aset secara manual.
                </small>
            </form>

            <div class="mt-3">
                <button type="button" id="startScan" class="btn btn-success">
                    Mulai Kamera
                </button>
                <button type="button" id="stopScan" class="btn btn-outline-secondary">
                    Hentikan Kamera
                </button>
            </div>

            <p id="scanStatus" class="mt-3 mb-0 text-muted">
                Kamera belum dijalankan.
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Riwayat Scan Saya</strong>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Kode QR</th>
                        <th>Aset</th>
                        <th>Hasil</th>
                        <th>Keterangan</th>
                        <th>Waktu Scan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($scans as $scan)
                        <tr>
                            <td>{{ $scans->firstItem() + $loop->index }}</td>
                            <td>{{ $scan->qr_code }}</td>
                            <td>
                                {{ $scan->asset->nama_aset ?? 'Aset tidak tersedia' }}
                            </td>
                            <td>
                                @if($scan->hasil === 'valid')
                                    <span class="badge bg-success">Valid</span>
                                @else
                                    <span class="badge bg-danger">
                                        {{ $scan->hasil ?? 'Tidak valid' }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $scan->keterangan ?? '-' }}</td>
                            <td>{{ $scan->created_at?->format('d-m-Y H:i:s') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada riwayat scan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($scans->hasPages())
        <div class="mt-3">
            {{ $scans->links() }}
        </div>
    @endif

</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const reader = document.getElementById('reader');
    const input = document.getElementById('qr_code');
    const status = document.getElementById('scanStatus');
    const startButton = document.getElementById('startScan');
    const stopButton = document.getElementById('stopScan');

    let scanner = null;
    let running = false;

    startButton.addEventListener('click', async function () {
        if (running) return;

        try {
            scanner = new Html5Qrcode('reader');

            await scanner.start(
                { facingMode: 'environment' },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                async function (decodedText) {
                    input.value = decodedText;
                    status.textContent =
                        'QR terbaca: ' + decodedText +
                        '. Silakan klik Validasi & Simpan.';

                    if (running) {
                        await scanner.stop();
                        running = false;
                    }
                },
                function () {}
            );

            running = true;
            status.textContent = 'Kamera aktif. Arahkan ke QR Code aset.';
        } catch (error) {
            status.textContent =
                'Kamera gagal dibuka. Periksa izin kamera browser atau masukkan kode manual.';
        }
    });

    stopButton.addEventListener('click', async function () {
        if (scanner && running) {
            await scanner.stop();
            running = false;
            status.textContent = 'Kamera dihentikan.';
        }
    });
});
</script>
@endsection
