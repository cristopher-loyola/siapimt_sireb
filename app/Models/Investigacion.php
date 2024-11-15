<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investigacion extends Model
{
    use HasFactory;
    protected $table = 'linea_investigación';
    protected $fillable = [
        'nombre_linea',
        'rubro'
    ];
}
