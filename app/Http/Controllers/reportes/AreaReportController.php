<?php

namespace App\Http\Controllers\reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Materia;
use App\Models\Nivel;
use App\Models\Impacto;
use App\Models\Orientacion;
use App\Models\ContribucionesProyecto;
use App\Classes\Reportes\GeneralReport;
use App\Http\Controllers\class\StatusController;
use App\Http\Controllers\class\ProgressPublicaciontController;
use App\Http\Controllers\class\PorcentTasksController;

use DB;

class AreaReportController extends Controller
{
    public function getReport(Request $request){

        $request->validate([
            'areas'=>'numeric',
        ]);
        $area = $request->get('areas');
        try {
            $report = new GeneralReport(
                $this->getDataForReport($area),'reporte_area',
                'Reporte General de Proyectos por Área','report_area'
            );
            return response()->json(['created' => true]);
        } catch (\Throwable $th) {
            return response()->json(['created' => false,'error' => $th->getMessage()]);
        }
        
    }

    public function getProjects($idArea){

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
        ->where([
            ['proyectos.oculto','=','1'],
            //['proyectos.clavea','=','M'],
            ['usuarios.idarea', '=',$idArea]
        ])
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

        return $projects;  
    }

    public function getProjectsMulti($idArea){

        $projectsM = Proyecto::
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
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.clavea','=','M'],
            ['usuarios.idarea', '=',$idArea]
        ])
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

        return $projectsM;  
    }
    

    protected function getContributions(){
        return ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
            ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
            ->get(['contribucion_a.nombre_contri','contribuciones.idproyecto']);
    }

// PARA OBTENER LOS IMPACTOS DE LOS PROYECTOS
    protected function getImpactos(){
        return Impacto::join('proyectos','proyectos.id', '=', 'impacto.idproyecto')
        ->get(['impacto.nivelImp', 'impacto.idproyecto']);
    }


    //combina las contribuciones con los proyectos, mapea los datos para enviar al reporte
    protected function getDataForReport($idArea){

        $statusController = new StatusController();
        $progressController = new ProgressPublicaciontController();
        $porcentProgramController = new PorcentTasksController();

// DESPUES DE OBTENER LOS PROYECTOS MULTI, LOS JUNTAMOS PARA TENERLOS EN CONJUNTO
        $projects = collect($this->getProjects($idArea));
        $projectsMulti = collect($this->getProjectsMulti($idArea));
        $projects = $projects->merge($projectsMulti);

        $orientaciones = Orientacion::all();
        $niveles = Nivel::all();
        $impactos = $this->getImpactos();
        $materias = Materia::all();
        $contribuciones = $this->getContributions();

        $projects->map(function($project) use ($statusController,$progressController,$porcentProgramController,
                        $orientaciones, $niveles, $materias,$contribuciones, $impactos) {

            $project['Orientación'] = $orientaciones->where('id', $project->orientacion)
                                                    ->pluck('descorientacion')
                                                    ->first();

            $impa = Impacto::where('idproyecto', $project->id)->get('nivelImp');

            if(empty($impa->nivelImp)){
                $project['Nivel de impacto'] = $niveles->where('id', $project->nivel)
                                                    ->pluck('nivel')
                                                    ->first();
            }else{
                $project['Nivel de impacto'] = $impactos->where('idproyecto', $project->id)
                                                    ->pluck('nivelImp')
                                                    ->toArray();
            }

            $project['Materia'] = $materias->where('id', $project->materia)
                                            ->pluck('descmateria')
                                            ->first();

            $project['Estado'] =  $statusController->getLabelStatus($project->estado); 
            
            $project['% Realizado'] = ($progressController->getProgressByPublication($project)).'%';
            
            $project['% Programado'] = ($porcentProgramController->getPorcentProgrammedForTasks($project->id)).'%';

                                            
            $project['Contribuciones'] = $contribuciones->where('idproyecto', $project->id)
                                            ->pluck('nombre_contri')
                                            ->toArray();                                          
            
            unset($project->id,$project->orientacion,$project->nivel, $project->materia,
            $project->progreso,$project->estado,$project->clavet,$project->publicacion);
    
            return $project;
        });

        return $projects;
    }
}
