<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarEkspedisi extends Model
{
    protected $table = 'daftar_ekspedisi';
    
    protected $fillable = [
        'nama_ekspedisi',
        'alamat'
    ];
}