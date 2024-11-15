<?php

namespace App\Exports;

use App\Models\Afectacion;
use App\Models\Proyecto;
use App\Models\Financiero;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use \PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpParser\Node\Expr\Cast\Double;

class Afectacion_Export implements FromQuery , WithHeadings/*, WithDrawings*/, ShouldAutoSize, WithStyles, WithHeadingRow
{

    /*public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('img/logo_IMT.png'));
        $drawing->setHeight(45);
        $drawing->setCoordinates('G1');

        return $drawing;
    }*/

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['italic' => true], 'font' => ['size'=> 14]],

        ];
    }
    
    public function headings(): array
    {
        return [
        [
            'Monto asignado:',
            $this->total,
        ],
        [   'Contrato',
            'Nombre del proyecto',
            'Número de Clc',
            'Concepto de Clc',
            'Fecha',
            'Partida',
            'Concepto de Partida',
            'Fuente de Financiamiento',
            'Monto por partida'
        ]
        ];
    }

    public function __construct(String $ncontratos, $total)
    {
        $this->ncontratos = $ncontratos;
        $this->total = $total;
        
    }

    use Exportable;
    
    public function query()
    {
        return Afectacion::query()
            -> join('tb_partidas','tb_partidas.id','=','tb_afectaciones.id_partida')
            -> join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            -> where('ncontratos', $this->ncontratos) 
            -> select ('proyectos.ncontratos','proyectos.nomproy',
            'tb_afectaciones.clc','tb_afectaciones.conceptoc','tb_afectaciones.fecha',
            'tb_partidas.partida','tb_partidas.concepto','tb_afectaciones.tipo','tb_afectaciones.montoxpartida')
            -> orderBy('proyectos.nomproy','asc');
        }

}
