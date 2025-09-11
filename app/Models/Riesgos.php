<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riesgos extends Model
{
    use HasFactory;
    protected $table = 'riesgos';
    protected $fillable = [
        'tiporiesgo',
        'tvarrisk',
        'resprisk'
    ];
}
