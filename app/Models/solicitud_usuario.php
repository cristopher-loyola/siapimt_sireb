<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud_usuario extends Model
{
    use HasFactory;

    protected $fillable = ['solicitud_id', 'usuario_id'];
}
