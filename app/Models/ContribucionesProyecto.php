<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContribucionesProyecto extends Model
{
    use HasFactory;
    protected $table = 'contribuciones';
    protected $primaryKey = 'id';
}
