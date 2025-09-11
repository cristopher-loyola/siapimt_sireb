<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impacto extends Model
{
    use HasFactory;
    protected $table = 'impacto';
    protected $fillable = [
        'nivelImp',
        'escalaImp',
        'crit1',
        'vcrit1',
        'crit2',
        'vcrit2',
        'crit3',
        'vcrit3',
        'crit4',
        'vcrit4',
        'crit5',
        'vcrit5',
        'crit6',
        'vcrit6',
        'descImpSoc',
        'descImpEco',
        'idproyecto',
        'completado'
    ];
}
