<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class miconfig extends Model
{
    use HasFactory;

    protected $primaryKey = 'anio';

    protected $fillable = [
        'anio',
        'PI1',
        'CPT1-2',
        'MIPC3',
        'IPC4',
        'PE5',
        'CPT2-6',
        'MIPEC7',
        'PIIE8',
        'EL9',
        'ELC10',
        'APRMN11',
        'IAPRMN12',
        'APRMI13',
        'IAPRMI14',
        'AB15',
        'IAB16',
        'CSC17',
        'ICSC18',
        'PT19',
        'IPT20',
        'ACA21',
        'IACA22',
        'IOGDML23',
        'IIOGDML24',
        'CI25',
        'ICI26',
        'CIR27',
        'ICIR28',
        'TITD29',
        'ITITD30'
    ];
}
