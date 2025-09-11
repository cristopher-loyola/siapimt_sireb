<?php

namespace App\Http\Controllers\reportes;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\Materia;
use App\Models\Nivel;
use App\Models\Orientacion;
use App\Models\ContribucionesProyecto;
use App\Classes\Reportes\GeneralReport;
use App\Http\Controllers\class\StatusController;
use App\Http\Controllers\class\ProgressPublicaciontController;
use App\Http\Controllers\class\PorcentTasksController;

use DB;


class GeneralReportController extends Controller
{

    public function getReport(){
        try {
            $report = new GeneralReport(
                $this->getDataForReport(),'general_report','Reporte General'
            );
            return response()->json(['created' => true]);
        } catch (\Throwable $th) {
            return response()->json(['created' => false,'error' => $th->getMessage()]);
        }
        
    }

    public function getProjects(){

        $projects = Proyecto::
            select([
                'proyectos.id',
                'area_adscripcion.nombre_area as Área de adscripción',
                'proyectos.tipo as Interno/Externo',
                DB::raw("CASE 
                    WHEN proyectos.claven < 10 THEN CONCAT(proyectos.clavea, proyectos.clavet,'-0', proyectos.claven,'/',proyectos.clavey)
                    WHEN proyectos.claven >= 10 THEN
                    CONCAT(proyectos.clavea, proyectos.clavet,'-', proyectos.claven,'/',proyectos.clavey)
                    END
                    as Clave
                "),
                'proyectos.nomproy as Nombre del proyecto',
                'cliente.nivel1 as Cliente Nivel 1',
                'cliente.nivel2 as Cliente Nivel 2',
                'cliente.nivel3 as Cliente Nivel 3',
                'modo_transporte.nombre_transporte as Modo de Transporte',
                'linea_investigación.nombre_linea as Linea de investigacion',
                'objetivo_sectorial.nombre_objetivosec as Objetivo Sectorial',
                'proyectos.duracionm as Duración(Meses)',
                'proyectos.fecha_inicio as Inicio',
                'proyectos.fecha_fin as Fin',
                DB::raw("CONCAT('$',proyectos.costo) as Costo"),
                DB::raw("CONCAT(usuarios.Nombre, ' ', usuarios.Apellido_Paterno, ' ', usuarios.Apellido_Materno) as Responsable"),
                
                'proyectos.Observaciones as Observaciones',
                
                'proyectos.estado',   
                'proyectos.clavet',             
                'proyectos.progreso',
                'proyectos.orientacion',
                'proyectos.nivel',
                'proyectos.materia',
                'proyectos.publicacion',

            ])
        ->join('usuarios','usuarios.id','=','proyectos.idusuarior')
        ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
        ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
        ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
        ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
        ->join('cliente','cliente.id','=','proyectos.Cliente')
        ->where('proyectos.oculto','=','1')
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

        return $projects;  
    }

    protected function getContributions(){
        return ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
            ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
            ->get(['contribucion_a.nombre_contri','contribuciones.idproyecto']);
    }


    //combina las contribuciones con los proyectos, mapea los datos para enviar al reporte
    protected function getDataForReport(){

        $statusController = new StatusController();
        $progressController = new ProgressPublicaciontController();
        $porcentProgramController = new PorcentTasksController();


        $projects = collect($this->getProjects());

        $orientaciones = Orientacion::all();
        $niveles = Nivel::all();
        $materias = Materia::all();
        $contribuciones = $this->getContributions();

        $projects->map(function($project) use ($statusController,$progressController,$porcentProgramController,
                        $orientaciones, $niveles, $materias,$contribuciones){

            $project['Orientación'] = $orientaciones->where('id', $project->orientacion)
                                                    ->pluck('descorientacion')
                                                    ->first();

            $project['Nivel de impacto'] = $niveles->where('id', $project->nivel)
                                                    ->pluck('nivel')
                                                    ->first();

            $project['Materia'] = $materias->where('id', $project->materia)
                                            ->pluck('descmateria')
                                            ->first();

            $project['Estado'] =  $statusController->getLabelStatus($project->estado); 
            
            $project['% Realizado'] = ($progressController->getProgressByPublication($project)).'%';
            
            $project['% Programado'] = ($porcentProgramController->getPorcentProgrammedForTasks($project->id)).'%';

                                            
            $project['Contribuciones'] = $contribuciones->where('idproyecto', $project->id)
                                            ->pluck('nombre_contri')
                                            ->toArray();                                          
            
            //eliminamos las llaves que no utilizamos
            unset($project->id,$project->orientacion,$project->nivel, $project->materia,
            $project->progreso,$project->estado,$project->clavet,$project->publicacion);
    
            return $project;
        });

        return $projects;
    }
}
