<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
            'kode_aset' => 'required|string|max:255|unique:assets,kode_aset',
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tanggal_pembelian' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['qr_code'] = $validated['kode_aset'];

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('assets', 'public');
        }

        Asset::create($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Data aset berhasil ditambahkan.');
    }

    public function show(Asset $asset)
    {
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
                'string',
                'max:255',
                Rule::unique('assets', 'kode_aset')->ignore($asset->id),
            ],
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tanggal_pembelian' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['qr_code'] = $validated['kode_aset'];

        if ($request->hasFile('foto')) {
            if ($asset->foto) {
                Storage::disk('public')->delete($asset->foto);
            }

            $validated['foto'] = $request->file('foto')->store('assets', 'public');
        }

        $asset->update($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        if ($asset->foto) {
            Storage::disk('public')->delete($asset->foto);
        }

        $asset->delete();

        return redirect()->route('assets.index')
            ->with('success', 'Data aset berhasil dihapus.');
    }
}