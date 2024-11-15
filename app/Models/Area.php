<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area_adscripcion';
    protected $fillable = [
        'nombre_area',
        'siglas',
        'inicial_clave'
    ];
}
