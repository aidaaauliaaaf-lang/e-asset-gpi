<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMutation;
use Illuminate\Http\Request;

class AssetMutationController extends Controller
{
<<<<<<< HEAD
    public function index(Request $request)
    {
        $query = AssetMutation::with('asset');

        // Pencarian kode dan nama aset
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('kode_aset', 'like', '%' . $search . '%')
                  ->orWhere('nama_aset', 'like', '%' . $search . '%');
            });
        }

        // Filter tanggal mutasi
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_mutasi', $request->tanggal);
        }

        $mutations = $query
            ->orderByDesc('tanggal_mutasi')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
=======
    /**
     * Menampilkan daftar mutasi aset
     */
    public function index()
    {
        $mutations = AssetMutation::with('asset')
            ->latest()
            ->paginate(10);
>>>>>>> origin/main

        return view('mutations.index', compact('mutations'));
    }

<<<<<<< HEAD
=======
    /**
     * Menampilkan form tambah mutasi
     */
>>>>>>> origin/main
    public function create()
    {
        $assets = Asset::orderBy('nama_aset')->get();

        return view('mutations.create', compact('assets'));
    }

<<<<<<< HEAD
=======
    /**
     * Menyimpan data mutasi
     */
>>>>>>> origin/main
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
<<<<<<< HEAD
            'lokasi_asal' => ['nullable', 'string', 'max:255'],
            'lokasi_tujuan' => ['required', 'string', 'max:255'],
            'divisi_asal' => ['nullable', 'string', 'max:255'],
            'divisi_tujuan' => ['required', 'string', 'max:255'],
            'penanggung_jawab_lama' => ['nullable', 'string', 'max:255'],
            'penanggung_jawab_baru' => ['required', 'string', 'max:255'],
            'tanggal_mutasi' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        // Simpan riwayat mutasi baru
        AssetMutation::create($validated);

        // Perbarui posisi terbaru aset
=======

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
>>>>>>> origin/main
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
<<<<<<< HEAD
}
=======
}
>>>>>>> origin/main
