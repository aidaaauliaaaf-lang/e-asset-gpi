<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                    ->orWhere('nama_aset', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('divisi', 'like', "%{$search}%");
            });
        }

        $assets = $query->latest()->paginate(10)->withQueryString();

        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aset' => ['required', 'unique:assets,kode_aset'],
            'nama_aset' => ['required'],
            'kategori' => ['required'],
            'tanggal_pembelian' => ['nullable', 'date'],
            'lokasi' => ['nullable'],
            'divisi' => ['nullable'],
            'penanggung_jawab' => ['nullable'],
            'kondisi' => ['required'],
            'status' => ['required'],
            'keterangan' => ['nullable'],
        ]);

        $validated['qr_code'] = $validated['kode_aset'];

        Asset::create($validated);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Data aset berhasil ditambahkan.');
    }

    public function show(Asset $asset)
    {
        $asset->load([
            'mutations',
            'maintenances'
        ]);

        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'kode_aset' => [
                'required',
                'unique:assets,kode_aset,' . $asset->id
            ],
            'nama_aset' => ['required'],
            'kategori' => ['required'],
            'tanggal_pembelian' => ['nullable', 'date'],
            'lokasi' => ['nullable'],
            'divisi' => ['nullable'],
            'penanggung_jawab' => ['nullable'],
            'kondisi' => ['required'],
            'status' => ['required'],
            'keterangan' => ['nullable'],
        ]);

        $validated['qr_code'] = $validated['kode_aset'];

        $asset->update($validated);

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()
            ->route('assets.index')
            ->with('success', 'Data aset berhasil dihapus.');
    }
}