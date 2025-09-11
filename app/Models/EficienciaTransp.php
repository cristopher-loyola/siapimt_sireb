<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EficienciaTransp extends Model
{
    use HasFactory;
    protected $table = 'eficiencia_transp';
    protected $fillable = [
        'tipoCat',
        'descEficiencia',
        'valorCat'
    ];
}
