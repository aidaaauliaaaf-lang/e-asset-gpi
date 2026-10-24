<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'jenis' => [
                'nullable',
                Rule::in(['aset', 'mutasi', 'pemeliharaan']),
            ],
            'dari' => ['nullable', 'date'],
            'sampai' => [
                'nullable',
                'date',
                'after_or_equal:dari',
            ],
        ]);

        $jenis = $validated['jenis'] ?? 'aset';
        $dari = $validated['dari'] ?? null;
        $sampai = $validated['sampai'] ?? null;

        $reports = [
            'aset' => [
                'title' => 'Laporan Data Aset',
                'table' => 'assets',
            ],
            'mutasi' => [
                'title' => 'Laporan Mutasi Aset',
                'table' => 'asset_mutations',
            ],
            'pemeliharaan' => [
                'title' => 'Laporan Pemeliharaan',
                'table' => 'maintenances',
            ],
        ];

        $report = $reports[$jenis];
        $table = $report['table'];

        $rows = collect();
        $columns = [];
        $total = 0;
        $warning = null;

        if (!Schema::hasTable($table)) {
            $warning = "Tabel {$table} belum ditemukan di database.";
        } else {
            $columns = Schema::getColumnListing($table);
            $query = DB::table($table);

            if (in_array('created_at', $columns, true)) {
                if ($dari) {
                    $query->whereDate('created_at', '>=', $dari);
                }

                if ($sampai) {
                    $query->whereDate('created_at', '<=', $sampai);
                }
            } elseif ($dari || $sampai) {
                $warning = 'Filter tanggal tidak tersedia karena tabel ini tidak memiliki kolom created_at.';
            }

            $total = (clone $query)->count();

            if (in_array('created_at', $columns, true)) {
                $query->orderByDesc('created_at');
            }

            $rows = $query->limit(500)->get();
        }

        $statistics = [
            'aset' => Schema::hasTable('assets')
                ? DB::table('assets')->count()
                : 0,

            'mutasi' => Schema::hasTable('asset_mutations')
                ? DB::table('asset_mutations')->count()
                : 0,

            'pemeliharaan' => Schema::hasTable('maintenances')
                ? DB::table('maintenances')->count()
                : 0,
        ];

        return view('reports.index', compact(
            'jenis',
            'dari',
            'sampai',
            'report',
            'rows',
            'columns',
            'total',
            'warning',
            'statistics'
        ));
    }
}
