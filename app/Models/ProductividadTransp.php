<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductividadTransp extends Model
{
    use HasFactory;
    protected $table = 'productividad_transp';
    protected $fillable = [
        'tipoCat',
        'descProductividad',
        'valorCat'
    ];
}
