<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class libro extends Model
{
    use HasFactory;

    public function usuariosQuePuedenVisualizar()
    {
        return $this->hasMany(libros_usuario::class, 'libros_id');
    }


}
