<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class solicitudes extends Model
{
    use HasFactory;

    public function usuariosQuePuedenVisualizar()
    {
        return $this->hasMany(solicitud_usuario::class, 'solicitud_id');
    }
    

}
