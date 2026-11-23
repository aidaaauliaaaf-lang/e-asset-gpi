<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MaintenanceController extends Controller
{
    /**
     * Menampilkan daftar Maintenance.
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

        // Filter tanggal Maintenance
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
     * Form Maintenance.
     * Bisa dibuka manual maupun melalui Scan QR.
     */
    public function create(Request $request)
    {
        $role = $request->session()->get('user_role');

        if (!in_array($role, ['admin', 'karyawan'], true)) {
            abort(403, 'Anda tidak memiliki akses input Maintenance.');
        }

        $assets = Asset::orderBy('nama_aset')->get();

        // Jika berasal dari Scan QR, pilih aset otomatis
        $assetId = $request->query('asset_id');

        $asset = $assetId
            ? Asset::findOrFail($assetId)
            : null;

        return view(
            'maintenances.create',
            compact('assets', 'asset')
        );
    }

    /**
     * Menyimpan Maintenance dan memperbarui informasi aset.
     */
    public function store(Request $request)
    {
        $role = $request->session()->get('user_role');

        if (!in_array($role, ['admin', 'karyawan'], true)) {
            abort(403, 'Anda tidak memiliki akses input Maintenance.');
        }

        // =========================================
        // VALIDASI DATA
        // =========================================

        $validated = $request->validate([

            'asset_id' => [
                'required',
                'exists:assets,id'
            ],

            'tanggal_maintenance' => [
                'required',
                'date'
            ],

            'jenis_maintenance' => [
                'required',
                'string',
                'max:255'
            ],

            // Keterangan pekerjaan Maintenance
            'keterangan' => [
                'nullable',
                'string'
            ],

            // Teknisi atau pelaksana Maintenance
            'penanggung_jawab' => [
                'nullable',
                'string',
                'max:255'
            ],

            'status' => [
                'required',
                'in:Terjadwal,Proses,Selesai'
            ],

            'tanggal_maintenance_berikutnya' => [
                'nullable',
                'date'
            ],

            // Kondisi aset terbaru
            'kondisi_aset_baru' => [
                'required',
                'in:Baik,Rusak Ringan,Rusak Berat'
            ],

            // Dokumentasi
            'dokumen' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,pdf',
                'max:5120'
            ],

        ], [
            'asset_id.required' =>
                'Silakan pilih aset terlebih dahulu.',

            'kondisi_aset_baru.required' =>
                'Kondisi aset wajib dipilih.',

            'dokumen.mimes' =>
                'Dokumen harus berupa JPG, JPEG, PNG, WEBP, atau PDF.',

            'dokumen.max' =>
                'Ukuran dokumen maksimal 5 MB.',
        ]);

        $path = null;

        try {

            // =========================================
            // UPLOAD DOKUMENTASI
            // =========================================

            if ($request->hasFile('dokumen')) {
                $path = $request->file('dokumen')
                    ->store('maintenance', 'public');
            }

            // =========================================
            // SIMPAN MAINTENANCE DAN UPDATE ASET
            // =========================================

            DB::transaction(function () use ($validated, $path) {

                // Ambil aset berdasarkan ID
                $asset = Asset::where(
                    'id',
                    $validated['asset_id']
                )
                    ->lockForUpdate()
                    ->firstOrFail();

                // =====================================
                // SIMPAN RIWAYAT MAINTENANCE
                // =====================================

                $maintenance = new Maintenance();

                $maintenance->asset_id =
                    $asset->id;

                $maintenance->tanggal_maintenance =
                    $validated['tanggal_maintenance'];

                $maintenance->jenis_maintenance =
                    $validated['jenis_maintenance'];

                // Simpan keterangan pekerjaan
                $maintenance->keterangan =
                    $validated['keterangan'] ?? null;

                // Simpan nama pelaksana Maintenance
                $maintenance->penanggung_jawab =
                    $validated['penanggung_jawab'] ?? null;

                $maintenance->status =
                    $validated['status'];

                $maintenance->tanggal_maintenance_berikutnya =
                    $validated['tanggal_maintenance_berikutnya'] ?? null;

                $maintenance->dokumen = $path;

                $maintenance->save();

                // =====================================
                // UPDATE INFORMASI ASET
                // =====================================

                // Penanggung Jawab Aset mengikuti
                // pelaksana Maintenance terbaru.
                $penanggungJawabAset =
                    !empty($validated['penanggung_jawab'])
                        ? $validated['penanggung_jawab']
                        : $asset->penanggung_jawab;

                // Keterangan Aset mengikuti
                // keterangan pekerjaan Maintenance.
                $keteranganAset =
                    $validated['keterangan'] ?? null;

                DB::table('assets')
                    ->where('id', $asset->id)
                    ->update([

                        'penanggung_jawab' =>
                            $penanggungJawabAset,

                        'kondisi' =>
                            $validated['kondisi_aset_baru'],

                        'keterangan' =>
                            $keteranganAset,

                        'updated_at' => now(),

                    ]);

                // =====================================
                // VERIFIKASI HASIL UPDATE
                // =====================================

                $dataAsetTerbaru = DB::table('assets')
                    ->where('id', $asset->id)
                    ->first();

                if (!$dataAsetTerbaru) {
                    throw new \RuntimeException(
                        'Data aset tidak ditemukan.'
                    );
                }

                if (
                    $dataAsetTerbaru->penanggung_jawab
                        !== $penanggungJawabAset ||

                    $dataAsetTerbaru->kondisi
                        !== $validated['kondisi_aset_baru'] ||

                    $dataAsetTerbaru->keterangan
                        !== $keteranganAset
                ) {
                    throw new \RuntimeException(
                        'Informasi aset gagal diperbarui.'
                    );
                }
            });

        } catch (Throwable $e) {

            // Hapus dokumentasi jika transaksi gagal
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        // Hapus sesi Scan QR jika ada
        $request->session()->forget('scanned_asset_id');

        // Kembali ke Detail Aset
        return redirect()
            ->route('assets.show', $validated['asset_id'])
            ->with(
                'success',
                'Maintenance berhasil disimpan dan informasi aset berhasil diperbarui.'
            );
    }
}
