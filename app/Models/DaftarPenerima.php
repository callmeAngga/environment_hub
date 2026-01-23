<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPenerima extends Model
{
    protected $table = 'daftar_penerima';
    
    protected $fillable = [
        'nama_penerima',
        'alamat',
        'tipe'
    ];
}