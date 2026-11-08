<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Response;

class AssetQrController extends Controller
{
    /**
     * Menampilkan QR Code untuk aset tertentu.
     */
    public function show(Asset $asset): Response
    {
        // URL halaman detail aset
        $url = route('assets.show', $asset->id);

        // Membuat QR Code
        $qrCode = new QrCode(
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        // Menghasilkan gambar PNG
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Mengirim gambar QR Code ke browser
        return response($result->getString(), 200)
            ->header('Content-Type', 'image/png')
            ->header(
                'Content-Disposition',
                'inline; filename="qr-aset-' . $asset->kode_aset . '.png"'
            );
    }
}
