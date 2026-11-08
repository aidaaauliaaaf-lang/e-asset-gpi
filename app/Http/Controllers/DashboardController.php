<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\Maintenance;

class DashboardController extends Controller
{
    public function index()
    {
        $role = session('user_role');

        // Ringkasan aset perusahaan
        $totalAssets = Asset::count();

        $activeAssets = Asset::where('status', 'Aktif')->count();

        $goodAssets = Asset::where('kondisi', 'Baik')->count();

        $damagedAssets = Asset::whereIn('kondisi', [
            'Rusak Ringan',
            'Rusak Berat'
        ])->count();

        $totalMutations = AssetMutation::count();

        $totalMaintenances = Maintenance::count();

        $recentAssets = Asset::latest()->take(5)->get();

        // Data tambahan khusus Pimpinan
        $divisionAssets = collect();
        $conditionSummary = collect();
        $recentActivities = collect();
        $notifications = collect();

        if ($role === 'pimpinan') {

            // Jumlah aset berdasarkan divisi
            $divisionAssets = Asset::select('divisi')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('divisi')
                ->orderBy('divisi')
                ->get();

            // Ringkasan kondisi aset
            $conditionSummary = Asset::select('kondisi')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('kondisi')
                ->get();

            // Aktivitas mutasi terbaru
            $mutations = AssetMutation::with('asset')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->tanggal_mutasi,
                        'jenis' => 'Mutasi',
                        'kode_aset' => $item->asset->kode_aset ?? '-',
                        'keterangan' => $item->keterangan ?? '-',
                        'urutan' => $item->created_at?->timestamp ?? 0,
                    ];
                });

            // Aktivitas maintenance terbaru
            $maintenances = Maintenance::with('asset')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->tanggal_maintenance,
                        'jenis' => 'Maintenance',
                        'kode_aset' => $item->asset->kode_aset ?? '-',
                        'keterangan' => $item->keterangan ?? '-',
                        'urutan' => $item->created_at?->timestamp ?? 0,
                    ];
                });

            // Gabungkan aktivitas
            $recentActivities = $mutations
                ->concat($maintenances)
                ->sortByDesc('urutan')
                ->take(5)
                ->values();

            // Notifikasi informasi aset rusak
            $damagedNotifications = Asset::whereIn('kondisi', [
                'Rusak Ringan',
                'Rusak Berat'
            ])->latest()->take(5)->get()
                ->map(function ($item) {
                    return [
                        'judul' => 'Aset Rusak',
                        'pesan' => $item->kode_aset . ' - ' . $item->nama_aset,
                        'tanggal' => $item->updated_at,
                        'jenis' => 'rusak',
                    ];
                });

            // Notifikasi mutasi terbaru
            $mutationNotifications = AssetMutation::with('asset')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'judul' => 'Aktivitas Mutasi',
                        'pesan' => 'Mutasi aset ' .
                            ($item->asset->kode_aset ?? '-'),
                        'tanggal' => $item->created_at,
                        'jenis' => 'mutasi',
                    ];
                });

            // Notifikasi maintenance terbaru
            $maintenanceNotifications = Maintenance::with('asset')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'judul' => 'Informasi Maintenance',
                        'pesan' => 'Maintenance aset ' .
                            ($item->asset->kode_aset ?? '-'),
                        'tanggal' => $item->created_at,
                        'jenis' => 'maintenance',
                    ];
                });

            $notifications = $damagedNotifications
                ->concat($mutationNotifications)
                ->concat($maintenanceNotifications)
                ->sortByDesc(function ($item) {
                    return $item['tanggal']?->timestamp ?? 0;
                })
                ->take(10)
                ->values();
        }

        return view('dashboard.index', compact(
            'role',
            'totalAssets',
            'activeAssets',
            'goodAssets',
            'damagedAssets',
            'totalMutations',
            'totalMaintenances',
            'recentAssets',
            'divisionAssets',
            'conditionSummary',
            'recentActivities',
            'notifications'
        ));
    }
}
