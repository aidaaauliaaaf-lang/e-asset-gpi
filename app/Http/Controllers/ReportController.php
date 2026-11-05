<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Daftar jenis laporan.
     */
    private function reportTypes()
    {
        return [
            'aset' => [
                'title' => 'Laporan Data Aset',
                'table' => 'assets',
                'filename' => 'laporan-data-aset.pdf',
            ],

            'mutasi' => [
                'title' => 'Laporan Mutasi Aset',
                'table' => 'asset_mutations',
                'filename' => 'laporan-mutasi-aset.pdf',
            ],

            'pemeliharaan' => [
                'title' => 'Laporan Maintenance Aset',
                'table' => 'maintenances',
                'filename' => 'laporan-maintenance-aset.pdf',
            ],
        ];
    }

    /**
     * Menampilkan halaman laporan.
     */
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

        $reports = $this->reportTypes();
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

        // Statistik seluruh laporan.
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

    /**
     * Download PDF sesuai jenis laporan.
     */
    public function downloadPdf(Request $request, string $jenis)
    {
        $validated = $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => [
                'nullable',
                'date',
                'after_or_equal:dari',
            ],
        ]);

        $reports = $this->reportTypes();

        if (!isset($reports[$jenis])) {
            abort(404, 'Jenis laporan tidak ditemukan.');
        }

        $report = $reports[$jenis];
        $table = $report['table'];

        if (!Schema::hasTable($table)) {
            abort(404, "Tabel {$table} tidak ditemukan.");
        }

        $dari = $validated['dari'] ?? null;
        $sampai = $validated['sampai'] ?? null;

        $columns = Schema::getColumnListing($table);
        $query = DB::table($table);

        if (in_array('created_at', $columns, true)) {
            if ($dari) {
                $query->whereDate('created_at', '>=', $dari);
            }

            if ($sampai) {
                $query->whereDate('created_at', '<=', $sampai);
            }

            $query->orderByDesc('created_at');
        }

        $total = (clone $query)->count();
        $rows = $query->limit(500)->get();

        $pdf = Pdf::loadView('reports.pdf', [
            'jenis' => $jenis,
            'report' => $report,
            'rows' => $rows,
            'columns' => $columns,
            'dari' => $dari,
            'sampai' => $sampai,
            'total' => $total,
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($report['filename']);
    }

    /**
     * Kompatibilitas dengan route PDF aset lama.
     */
    public function asetPdf(Request $request)
    {
        return $this->downloadPdf($request, 'aset');
    }
}
