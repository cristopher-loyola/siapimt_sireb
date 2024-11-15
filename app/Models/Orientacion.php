<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orientacion extends Model
{
    use HasFactory;
    protected $table = 'orientacion';
    protected $fillable = [
        'descorientacion'
    ];
}
