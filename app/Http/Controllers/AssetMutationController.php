<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMutation;
use Illuminate\Http\Request;

class AssetMutationController extends Controller
{
    /**
     * Menampilkan daftar mutasi aset
     */
    public function index()
    {
        $mutations = AssetMutation::with('asset')
            ->latest()
            ->paginate(10);

        return view('mutations.index', compact('mutations'));
    }

    /**
     * Menampilkan form tambah mutasi
     */
    public function create()
    {
        $assets = Asset::orderBy('nama_aset')->get();

        return view('mutations.create', compact('assets'));
    }

    /**
     * Menyimpan data mutasi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],

            'lokasi_asal' => ['nullable', 'string', 'max:255'],
            'lokasi_tujuan' => ['required', 'string', 'max:255'],

            'divisi_asal' => ['nullable', 'string', 'max:255'],
            'divisi_tujuan' => ['required', 'string', 'max:255'],

            'penanggung_jawab_lama' => ['nullable', 'string', 'max:255'],
            'penanggung_jawab_baru' => ['required', 'string', 'max:255'],

            'tanggal_mutasi' => ['required', 'date'],

            'keterangan' => ['nullable', 'string'],
        ]);

        // Simpan riwayat mutasi
        AssetMutation::create($validated);

        // Update posisi terbaru aset
        $asset = Asset::findOrFail($validated['asset_id']);

        $asset->update([
            'lokasi' => $validated['lokasi_tujuan'],
            'divisi' => $validated['divisi_tujuan'],
            'penanggung_jawab' => $validated['penanggung_jawab_baru'],
        ]);

        return redirect()
            ->route('mutations.index')
            ->with('success', 'Mutasi aset berhasil dicatat.');
    }
}