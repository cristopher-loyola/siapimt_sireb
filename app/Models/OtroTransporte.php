<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtroTransporte extends Model
{
    use HasFactory;
    protected $table = 'otrotransporte';
    protected $fillable = [
        'otrotransporte'
    ];
}
