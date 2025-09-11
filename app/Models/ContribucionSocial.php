<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContribucionSocial extends Model
{
    use HasFactory;
    protected $table = 'contribucion_social';
    protected $fillable = [
        'tipoCat',
        'descContribucionS',
        'valorCat',
    ];
}
