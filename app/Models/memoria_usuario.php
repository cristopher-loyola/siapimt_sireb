<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class memoria_usuario extends Model
{
    use HasFactory;

    protected $fillable = ['memoria_id', 'usuario_id'];

}
