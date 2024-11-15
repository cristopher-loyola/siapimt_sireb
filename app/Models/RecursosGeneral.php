<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursosGeneral extends Model
{
    use HasFactory;
    protected $table = 'recursos_general';
    protected $fillable = [
        'cantidad'
    ];
}
