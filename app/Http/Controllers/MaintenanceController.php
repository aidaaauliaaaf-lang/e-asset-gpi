<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('asset')
            ->latest()
            ->paginate(10);

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
            'jenis_maintenance' => ['required'],
            'keterangan' => ['nullable'],
            'penanggung_jawab' => ['nullable'],
            'status' => ['required'],
            'tanggal_maintenance_berikutnya' => [
                'nullable',
                'date'
            ],
        ]);

        Maintenance::create($validated);

        return redirect()
            ->route('maintenances.index')
            ->with('success', 'Data maintenance berhasil ditambahkan.');
    }
}