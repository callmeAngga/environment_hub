<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TpsProduksiMasuk extends Model
{
    protected $table = 'tps_produksi_masuk';
    
    protected $fillable = [
        'tps_id',
        'tanggal',
        'jumlah_sampah',
        'satuan_sampah_id',
        'jenis_sampah_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_sampah' => 'integer'
    ];

    public function tps(): BelongsTo
    {
        return $this->belongsTo(Tps::class, 'tps_id');
    }

    public function satuanSampah(): BelongsTo
    {
        return $this->belongsTo(SatuanSampah::class, 'satuan_sampah_id');
    }

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }
}