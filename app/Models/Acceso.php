<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    use HasFactory;
    protected $table = 't_accessos';
    protected $fillable = [
        'nom_acceso',
        'id'
    ];
}
