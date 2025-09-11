<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemSocial extends Model
{
    use HasFactory;
    protected $table = 'problem_social';
    protected $fillable = [
        'tipoCat',
        'descProb',
        'valorCat',

    ];
}
