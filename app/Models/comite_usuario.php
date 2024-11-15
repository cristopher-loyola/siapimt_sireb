<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comite_usuario extends Model
{
    use HasFactory;

    protected $fillable = ['comite_id', 'usuario_id'];
}
