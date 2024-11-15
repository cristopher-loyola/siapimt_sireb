<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    use HasFactory;
    protected $table = 'objetivo_sectorial';
    protected $fillable = [
        'nombre_objetivosec'
    ];
}
