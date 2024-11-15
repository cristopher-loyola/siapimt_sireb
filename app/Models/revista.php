<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class revista extends Model
{
    use HasFactory;


    public function usuariosQuePuedenVisualizar()
    {
        return $this->hasMany(revista_usuario::class, 'revista_id');
    }


}
