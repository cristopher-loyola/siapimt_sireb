<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscalaImpacto extends Model
{
    use HasFactory;
    protected $table = 'escala_impacto';
    protected $fillable = [
        'tipoCat',
        'descEscala',
        'valorCat',
    ];
}
