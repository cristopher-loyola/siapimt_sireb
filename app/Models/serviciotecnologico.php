<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serviciotecnologico extends Model
{
    use HasFactory;

    public function usuariosQuePuedenVisualizar()
    {
        return $this->hasMany(serviciotecnologico_usuario::class, 'serviciostec_id');
    }
}
