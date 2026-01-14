<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatuanSampah extends Model
{
    protected $table = 'satuan_sampah';
    
    protected $fillable = [
        'nama_satuan'
    ];
}