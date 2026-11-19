
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold">Scan QR Code Aset</h2>
        <p class="text-muted">
            PT Golden Piping Indonesia — Pemindaian aset oleh karyawan
        </p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Pemindaian QR Code</strong>
        </div>

        <div class="card-body text-center p-4">

            <div id="reader" style="max-width:500px; margin:auto;"></div>

            <p id="scanStatus" class="mt-3 text-muted">
                Mengaktifkan kamera...
            </p>

            <form id="scanForm"
                  action="{{ route('asset-scans.store') }}"
                  method="POST">
                @csrf
                <input type="hidden" id="qr_code" name="qr_code">
            </form>

        </div>
    </div>

</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
document.addEventListener('DOMContentLoaded', async function () {

    const status = document.getElementById('scanStatus');
    const form = document.getElementById('scanForm');
    const input = document.getElementById('qr_code');

    let scanner = null;
    let processing = false;

    async function startCamera() {
        try {

            if (typeof Html5Qrcode === 'undefined') {
                throw new Error('Library QR Code tidak tersedia.');
            }

            scanner = new Html5Qrcode('reader');

            await scanner.start(
                { facingMode: 'environment' },
                {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },

                async function (decodedText) {

                    if (processing) return;

                    processing = true;

                    status.textContent =
                        'QR berhasil dibaca. Memvalidasi aset...';

                    input.value = decodedText;

                    try {
                        await scanner.stop();
                    } catch (error) {
                        console.warn(error);
                    }

                    form.submit();
                },

                function () {}
            );

            status.textContent =
                'Kamera aktif. Arahkan kamera ke QR Code aset.';

        } catch (error) {

            console.error(error);

            status.textContent =
                'Kamera gagal dibuka. Izinkan akses kamera browser dan gunakan HTTPS atau localhost.';
        }
    }

    startCamera();

});
</script>
@endsection
