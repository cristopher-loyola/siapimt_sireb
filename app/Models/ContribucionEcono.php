<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContribucionEcono extends Model
{
    use HasFactory;
    protected $table = 'contribucion_econo';
    protected $fillable = [
        'tipoCat',
        'descContribucionE',
        'valorCat'
    ];
}
