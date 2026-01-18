<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'lab';
    
    protected $fillable = [
        'nama_lab',
        'lokasi'
    ];
}