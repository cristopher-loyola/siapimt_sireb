<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;
    protected $table = 'obs_proy';
    protected $fillable = [
        'idproyecto',
        'obs',
        'obs_respuesta',
        'tipo',
        'fechaobs',
        'fecharepuesta',
        'bimestreobs',
        'yearobs',
        'revisado'
    ];
}
