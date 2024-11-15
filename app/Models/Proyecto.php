<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyectos';
    protected $fillable = [
        'nomproy',
        'clavea',
        'clavet',
        'claven',
        'clavey',
        'fecha_inicio',
        'fecha_fin',
        'objetivo',
        'producto',
        'Tipo',
        'ncontratos',
        'Observaciones',
        'duracionm',
        'estado',
        'activo_act',
        'obser_cam',
        'cam_estado',
        'numtar',
        'orientacion',
        'nivel',
        'materia',
        'publicacion',
        'idpublicacion'
    ];
}
