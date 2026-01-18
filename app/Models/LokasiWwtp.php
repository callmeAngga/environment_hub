<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiWwtp extends Model
{
    protected $table = 'lokasi_wwtp';
    
    protected $fillable = [
        'nama_wwtp',
        'alamat',
        'koordinat_lat',
        'koordinat_lng',
        'kapasitas_debit'
    ];

    protected $casts = [
        'koordinat_lat' => 'float',
        'koordinat_lng' => 'float',
        'kapasitas_debit' => 'float'
    ];
}