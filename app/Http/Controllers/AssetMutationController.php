<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMutation;
use Illuminate\Http\Request;

class AssetMutationController extends Controller
{
    public function index()
    {
        $mutations = AssetMutation::with('asset')
            ->latest()
            ->paginate(10);

        return view('mutations.index', compact('mutations'));
    }

    public function create()
    {
        $assets = Asset::orderBy('nama_aset')->get();

        return view('mutations.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'lokasi_asal' => ['nullable'],
            'lokasi_tujuan' => ['nullable'],
            'divisi_asal' => ['nullable'],
            'divisi_tujuan' => ['nullable'],
            'penanggung_jawab_lama' => ['nullable'],
            'penanggung_jawab_baru' => ['nullable'],
            'tanggal_mutasi' => ['required', 'date'],
            'keterangan' => ['nullable'],
        ]);

        $mutation = AssetMutation::create($validated);

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