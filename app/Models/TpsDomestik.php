<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpsDomestik extends Model
{
    protected $table = 'tps_domestik';

    protected $fillable = [
        'tps_id',
        'no_sampah_keluar',
        'tanggal_pengangkutan',
        'ekspedisi_id',
        'no_kendaraan',
        'berat_bersih_kg',
        'jenis_sampah_id',
        'penerima_id'
    ];

    protected $casts = [
        'tanggal_pengangkutan' => 'date',
        'berat_bersih_kg' => 'float'
    ];

    public function tps()
    {
        return $this->belongsTo(Tps::class, 'tps_id');
    }

    public function ekspedisi()
    {
        return $this->belongsTo(DaftarEkspedisi::class, 'ekspedisi_id');
    }

    public function penerima()
    {
        return $this->belongsTo(DaftarPenerima::class, 'penerima_id');
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }
}
