<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ponenciaconferencia_usuario extends Model
{
    use HasFactory;

    protected $fillable = ['ponenciaconferencia_id', 'usuario_id'];
}
