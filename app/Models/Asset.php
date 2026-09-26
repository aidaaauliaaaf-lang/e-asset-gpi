<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $table = 'assets';

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'kategori',
        'tanggal_pembelian',
        'lokasi',
        'divisi',
        'penanggung_jawab',
        'kondisi',
        'status',
        'qr_code',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
    ];

    public function mutations(): HasMany
    {
        return $this->hasMany(AssetMutation::class, 'asset_id');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'asset_id');
    }
}