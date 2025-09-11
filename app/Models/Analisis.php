<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    use HasFactory;
    protected $table = 'analisis';
    protected $fillable = [
        'riesgo',
        'id',
        'probabilidad',
        'impacto',
        'vesperado',
        'calificacion',
        'respriesgo',
        'acciones',
        'fechaproable',
        'probocurrencia'
    ];
}
