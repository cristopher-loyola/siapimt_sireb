<?php

namespace App\Exports;

use App\Models\Proyecto;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpParser\Node\Expr\Cast\Double;

use function PHPSTORM_META\map;

class ProyectosExport implements FromQuery , WithHeadings, ShouldAutoSize, WithStyles, WithHeadingRow
{


    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    
    public function headings(): array
    {
        return [ 
            [

                'Área de Adscripción',
                'Interno/Externo',
                'A',
                'T',
                'No. Proyecto',
                'Año',
                'Nombre del Proyecto',
                'Cliente Nivel 1',
                'Cliente Nivel 2',
                'Cliente Nivel 3',
                'Modo de Transporte',
                'Linea de Investigación',
                'Objetivo Sectorial',
                'Duracion (Meses)',
                'Inicio',
                'Fin',
                'Costo',
                'Avance',
                'Responsable'

                ]
        ];
        
    }

    use Exportable;
    
    public function query()
    {
        return Proyecto::query()
        
        ->orderBy('area_adscripcion.nombre_area', 'ASC')
    
        ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
        ->join('cliente','cliente.id','=','proyectos.Cliente')
        ->join('modo_transporte','modo_transporte.id', '=', 'proyectos.idmodot')
        ->join('linea_investigación','linea_investigación.id', '=', 'proyectos.idlinea')
    	->join('objetivo_sectorial','objetivo_sectorial.id', '=', 'proyectos.idobjt')
        ->join('usuarios','usuarios.id', '=', 'proyectos.idusuarior')
        
                ->select('area_adscripcion.nombre_area',                    
                    'proyectos.Tipo',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.nomproy',
                    'cliente.nivel1',
                    'cliente.nivel2',
                    'cliente.nivel3',
                    'modo_transporte.nombre_transporte',
                    'linea_investigación.nombre_linea',
                    'objetivo_sectorial.nombre_objetivosec',
                    'proyectos.duracionm',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.costo',
                    'proyectos.progreso',
                    'usuarios.nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                );
        
    }

}
