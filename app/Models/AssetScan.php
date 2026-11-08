<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetScan extends Model
{
    protected $table = 'asset_scans';

    protected $fillable = [
        'asset_id',
        'user_id',
        'qr_code',
        'hasil',
        'keterangan',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}