<?php

namespace App\Exports;

use App\Models\Proyecto;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use function PHPSTORM_META\map;

class DetallesProyecto implements FromQuery , WithHeadings, ShouldAutoSize, WithStyles, WithHeadingRow
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

                'Areá de Adscripción',
                'Nombre del Proyecto',
                'A',
                'T',
                'No. Proyecto',
                'Año',
                'Fecha Inicio',
                'Fecha Fin',
                'Cliente Nivel 1',
                'Cliente Nivel 2',
                'Cliente Nivel 3',
                'Modo de Transporte',
                'Linea de Investigación',
                'Objetivo Sectorial',
                //'Duracion',
                'Inicio',
                'Fin',
                //'Costo',
                'Avance',
                'Responsable'

                ]
        ];
        
    }

    
    public function __construct(int $id)
    {
        $this->id = $id;
    }
    

    use Exportable;
    
    public function query()
    {
        //return Proyecto::query()
        
        return Proyecto::query()
        ->where('proyectos.id', $this->id)
        ->select(                    
                    'proyectos.Tipo', 
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.nomproy');
        /* ->orderBy('area_adscripcion.nombre_area', 'ASC')
    
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
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.progreso',
                    'usuarios.nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    */
                   
                //);
     ;  
    }

}