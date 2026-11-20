<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MaintenanceController extends Controller
{
    /**
     * Menampilkan daftar maintenance.
     * Admin, pimpinan, dan karyawan dapat melihat.
     */
    public function index(Request $request)
    {
        $query = Maintenance::with('asset');

        // Pencarian kode dan nama aset
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('kode_aset', 'like', '%' . $search . '%')
                    ->orWhere('nama_aset', 'like', '%' . $search . '%');
            });
        }

        // Filter tanggal maintenance
        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_maintenance',
                $request->tanggal
            );
        }

        $maintenances = $query
            ->orderByDesc('tanggal_maintenance')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Form maintenance hanya dapat dibuka
     * setelah pengguna melakukan Scan QR Code.
     */
    public function create(Request $request)
    {
        $role = $request->session()->get('user_role');

        if (!in_array($role, ['admin', 'karyawan'], true)) {
            abort(403, 'Anda tidak memiliki akses input maintenance.');
        }

        $assetId = $request->query('asset_id');

        $scannedAssetId = $request->session()->get('scanned_asset_id');

        // Pastikan aset sudah dipindai melalui QR
        if (!$assetId || (int) $assetId !== (int) $scannedAssetId) {
            return redirect()
                ->route('asset-scans.index')
                ->with('error', 'Silakan scan QR Code aset terlebih dahulu.');
        }

        $asset = Asset::findOrFail($assetId);

        $assets = collect([$asset]);

        return view('maintenances.create', compact('assets', 'asset'));
    }

    /**
     * Menyimpan data maintenance.
     * Hanya admin dan karyawan.
     */
    public function store(Request $request)
    {
        $role = $request->session()->get('user_role');

        if (!in_array($role, ['admin', 'karyawan'], true)) {
            abort(403, 'Anda tidak memiliki akses input maintenance.');
        }

        $scannedAssetId = $request->session()->get('scanned_asset_id');

        // Validasi data
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'tanggal_maintenance' => ['required', 'date'],
            'jenis_maintenance' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:Terjadwal,Proses,Selesai'],
            'tanggal_maintenance_berikutnya' => [
                'nullable',
                'date'
            ],
            'dokumen' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,pdf',
                'max:5120'
            ],
        ], [
            'dokumen.mimes' => 'Dokumen harus berupa JPG, JPEG, PNG, WEBP, atau PDF.',
            'dokumen.max' => 'Ukuran dokumen maksimal 5 MB.',
        ]);

        // Pastikan aset yang dikirim sama dengan hasil scan
        if (
            !$scannedAssetId ||
            (int) $validated['asset_id'] !== (int) $scannedAssetId
        ) {
            return redirect()
                ->route('asset-scans.index')
                ->with('error', 'Aset tidak sesuai dengan QR Code yang dipindai.');
        }

        $path = null;

        try {
            // Upload dokumen
            if ($request->hasFile('dokumen')) {
                $path = $request->file('dokumen')
                    ->store('maintenance', 'public');

                $validated['dokumen'] = $path;
            }

            // Simpan data maintenance
            Maintenance::create($validated);

        } catch (Throwable $e) {

            // Hapus file jika penyimpanan gagal
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        // Hapus izin scan setelah maintenance berhasil disimpan
        $request->session()->forget('scanned_asset_id');

        return redirect()
            ->route('assets.show', $validated['asset_id'])
            ->with('success', 'Data maintenance berhasil disimpan.');
    }
}
