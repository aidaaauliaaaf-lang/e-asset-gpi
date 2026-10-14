<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetScan;
use Illuminate\Http\Request;

class AssetScanController extends Controller
{
    public function index(Request $request)
    {
        $scans = AssetScan::with('asset')
            ->where('user_id', $request->session()->get('user_id'))
            ->latest()
            ->paginate(10);

        return view('asset-scans.index', compact('scans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => ['required', 'string', 'max:255'],
        ]);

        $qrCode = trim($validated['qr_code']);

        $asset = Asset::where('qr_code', $qrCode)
            ->orWhere('kode_aset', $qrCode)
            ->first();

        if (!$asset) {
            return redirect()->route('asset-scans.index')
                ->with('error', 'QR Code tidak valid atau aset tidak ditemukan.');
        }

        AssetScan::create([
            'asset_id' => $asset->id,
            'user_id' => $request->session()->get('user_id'),
            'qr_code' => $qrCode,
            'hasil' => 'valid',
            'keterangan' => 'Scan QR Code berhasil.',
        ]);

        return redirect()->route('asset-scans.index')
            ->with('success', 'QR Code valid. Aset: ' . $asset->nama_aset);
    }
}