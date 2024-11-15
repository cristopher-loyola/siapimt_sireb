<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cursorecibido_usuarios extends Model
{
    use HasFactory;

    protected $fillable = ['cursorecibido_id', 'usuario_id'];
}
