<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class comite extends Model
{
    use HasFactory;

    public function usuariosQuePuedenVisualizar()
    {
        return $this->hasMany(comite_usuario::class, 'comite_id');
    }
}
