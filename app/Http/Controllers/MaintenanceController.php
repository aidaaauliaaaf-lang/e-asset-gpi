<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MaintenanceController extends Controller
{
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

    public function create()
    {
        $assets = Asset::orderBy('nama_aset')->get();

        return view('maintenances.create', compact('assets'));
    }

    public function store(Request $request)
    {
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

        $path = null;

        try {
            // Upload dokumen ke storage
            if ($request->hasFile('dokumen')) {
                $path = $request->file('dokumen')
                    ->store('maintenance', 'public');

                $validated['dokumen'] = $path;
            }

            // Simpan data maintenance
            Maintenance::create($validated);

        } catch (Throwable $e) {
            // Hapus file jika penyimpanan data gagal
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        return redirect()
            ->route('maintenances.index')
            ->with('success', 'Data maintenance dan dokumentasi berhasil disimpan.');
    }
}
