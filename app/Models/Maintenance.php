<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $table = 'maintenances';

    protected $fillable = [
<<<<<<< HEAD
    'asset_id',
    'tanggal_maintenance',
    'jenis_maintenance',
    'keterangan',
    'dokumen',
    'penanggung_jawab',
    'status',
    'tanggal_maintenance_berikutnya',
];
=======
        'asset_id',
        'tanggal_maintenance',
        'jenis_maintenance',
        'keterangan',
        'penanggung_jawab',
        'status',
        'tanggal_maintenance_berikutnya',
    ];
>>>>>>> origin/main

    protected $casts = [
        'tanggal_maintenance' => 'date',
        'tanggal_maintenance_berikutnya' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}