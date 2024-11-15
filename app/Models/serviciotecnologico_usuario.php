<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serviciotecnologico_usuario extends Model
{
    use HasFactory;

    protected $fillable = ['serviciostec_id', 'usuario_id', 'participacionusuario'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['participacionusuario'] = 'Integrante';
    }
}
