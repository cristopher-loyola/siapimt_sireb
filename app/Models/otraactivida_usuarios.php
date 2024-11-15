<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otraactivida_usuarios extends Model
{
    use HasFactory;

    protected $fillable = ['otraactividad_id', 'usuario_id'];

}
