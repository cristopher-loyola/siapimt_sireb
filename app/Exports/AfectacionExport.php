<?php
namespace App\Exports;

use App\Invoice;
use App\Models\Afectacion;
use App\Models\Financiero;
use App\Models\Proyecto;
use App\Models\RecursosGeneral;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class AfectacionExport implements FromView
{

    public function view(): View
    {

        return view('afectaciones', [
        'proy_a' => Proyecto::where('id','id')->first(),
        
        'totalproyt' => RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto','id')
                ->sum('recursos_general.cantidad'),
        'afectacion' => Afectacion::Where('id_proyecto','id')->orderBy('clc', 'desc')->get(),
        
        'total' => Afectacion::Where('id_proyecto','id')->sum('montoxpartida'),
        'partidas' => Afectacion::Where('id_partida','id')->get(),
        'allPartidas' => Financiero::where('status',1)->get(),
        'partida' => Afectacion::join('tb_partidas','tb_partidas.id','=','tb_afectaciones.id_partida')
            ->join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            ->Where('id_proyecto','id')
            ->get(['tb_afectaciones.id','tb_partidas.partida','tb_partidas.concepto',
            'tb_afectaciones.fecha','tb_afectaciones.clc','tb_afectaciones.montoxpartida','tb_afectaciones.tipo'])
            
            
        ]);
    }
}
