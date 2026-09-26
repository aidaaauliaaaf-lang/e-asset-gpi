<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetMutation extends Model
{
    protected $table = 'asset_mutations';

    protected $fillable = [
        'asset_id',
        'lokasi_asal',
        'lokasi_tujuan',
        'divisi_asal',
        'divisi_tujuan',
        'penanggung_jawab_lama',
        'penanggung_jawab_baru',
        'tanggal_mutasi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}