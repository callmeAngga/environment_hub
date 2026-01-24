<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TpsProduksiKeluar extends Model
{
    protected $table = 'tps_produksi_keluar';
    
    protected $fillable = [
        'tps_id',
        'no_sampah_keluar',
        'tanggal_pengangkutan',
        'ekspedisi_id',
        'no_kendaraan',
        'berat_kosong_kg',
        'berat_isi_kg',
        'jenis_sampah_id',
        'penerima_id',
        'total_unit',
        'status_sampah_id',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pengangkutan' => 'date',
        'berat_kosong_kg' => 'float',
        'berat_isi_kg' => 'float',
        'berat_bersih_kg' => 'float',
        'total_unit' => 'integer',
    ];

    public function tps(): BelongsTo
    {
        return $this->belongsTo(Tps::class, 'tps_id');
    }

    public function ekspedisi(): BelongsTo
    {
        return $this->belongsTo(DaftarEkspedisi::class, 'ekspedisi_id');
    }

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(DaftarPenerima::class, 'penerima_id');
    }

    public function statusSampah(): BelongsTo
    {
        return $this->belongsTo(StatusSampah::class, 'status_sampah_id');
    }
}