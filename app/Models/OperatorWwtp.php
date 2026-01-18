<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorWwtp extends Model
{
    protected $table = 'operator_wwtp';
    
    protected $fillable = [
        'nama_operator'
    ];
}