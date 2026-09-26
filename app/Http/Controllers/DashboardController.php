<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\Maintenance;

class DashboardController extends Controller
{
    public function index()
    {
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

        return view('dashboard.index', compact(
            'totalAssets',
            'activeAssets',
            'goodAssets',
            'damagedAssets',
            'totalMutations',
            'totalMaintenances',
            'recentAssets'
        ));
    }
}