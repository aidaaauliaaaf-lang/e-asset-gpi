<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetScan;
use Illuminate\Http\Request;

class AssetScanController extends Controller
{
    /**
     * Menampilkan halaman Scan QR Code
     * beserta riwayat scan pengguna.
     */
    public function index(Request $request)
    {
        $scans = AssetScan::with('asset')
            ->where('user_id', $request->session()->get('user_id'))
            ->latest()
            ->paginate(10);

        return view('asset-scans.index', compact('scans'));
    }

    /**
     * Memproses hasil Scan QR Code.
     */
    public function store(Request $request)
    {
        // Hapus izin scan sebelumnya
        $request->session()->forget('scanned_asset_id');

        // Validasi QR Code
        $validated = $request->validate([
            'qr_code' => ['required', 'string', 'max:255'],
        ]);

        $qrCode = trim($validated['qr_code']);

        // Cari aset berdasarkan QR Code atau kode aset
        $asset = Asset::where('qr_code', $qrCode)
            ->orWhere('kode_aset', $qrCode)
            ->first();

        // Jika aset tidak ditemukan
        if (!$asset) {
            return redirect()
                ->route('asset-scans.index')
                ->with('error', 'QR Code tidak valid atau aset tidak ditemukan.');
        }

        // Simpan riwayat scan
        AssetScan::create([
            'asset_id' => $asset->id,
            'user_id' => $request->session()->get('user_id'),
            'qr_code' => $qrCode,
            'hasil' => 'valid',
            'keterangan' => 'Scan QR Code berhasil.',
        ]);

        // Simpan ID aset hasil scan ke session
        $request->session()->put('scanned_asset_id', $asset->id);

        // Arahkan pengguna ke detail aset
        return redirect()
            ->route('assets.show', $asset->id)
            ->with('success', 'QR Code valid. Menampilkan detail aset.');
    }
}
