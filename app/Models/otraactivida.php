<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class otraactivida extends Model
{
    use HasFactory;

    public function usuariosQuePuedenVisualizar()
    {
        return $this->hasMany(otraactivida_usuarios::class, 'otraactividad_id');
    }

}
