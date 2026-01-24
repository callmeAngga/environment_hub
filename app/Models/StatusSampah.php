<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusSampah extends Model
{
    protected $table = 'status_sampah';
    
    protected $fillable = [
        'nama_status'
    ];
}