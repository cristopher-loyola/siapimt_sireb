<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alineacion extends Model
{
    use HasFactory;
    protected $table = 'alineacion_programa_s';
    protected $fillable = [
        'nombre'
    ];
}
