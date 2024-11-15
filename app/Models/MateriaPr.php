<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaPr extends Model
{
    use HasFactory;
    protected $table = 'materias_proy';
    protected $fillable = [
        'idproy',
        'idmateria'
    ];
}
