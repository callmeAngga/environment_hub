<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tps extends Model
{
    protected $table = 'tps';
    
    protected $fillable = [
        'nama_tps',
        'alamat',
        'koordinat_lat',
        'koordinat_lng',
        'kapasitas_max'
    ];

    protected $casts = [
        'koordinat_lat' => 'float',
        'koordinat_lng' => 'float',
        'kapasitas_max' => 'float'
    ];
}