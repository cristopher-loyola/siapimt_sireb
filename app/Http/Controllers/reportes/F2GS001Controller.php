<?php

namespace App\Http\Controllers\reportes;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;

class F2GS001Controller extends Controller
{
    /*recibe un request con el nombre del departamento que se esta solicitando */
    public function getF2GS001Report(Request $request){
        $area = $request->input('area');

        //recuperamos todos los proyectos que estan en espera de COSPIII
        $waitProjects = $this->getWaitingProjects($area)->concat($this
        ->getWaitingMulticoordProjects($area));
        
        //recuperamos todos los proyectos qu estan en negociacion
        $negotiationProjects = $this->getNegotiationProjects($area)
        ->concat($this->getNegotiationMulticoordProjects($area));

        //recuperamos todos los proyectos externos, incluyendo multicoordinacion
        $extProjects =  collect($this->getExtProjects($area)->concat($this->getExtMulticoordProjects($area)))
        ->diff(collect($negotiationProjects));
        
        //recuperamos todos los proyectos internos, incluyendo multicoordinacion
        $intProjects = $this->getInternalProjects($area);
        $intMulticoordinacionProjects = $this->getInternalMulticoordProjects($area);

        $internalProjects = collect($intProjects->concat($intMulticoordinacionProjects))->diff(collect($waitProjects))->all();

        //contamos los proyectos
        $totalProjects = count($extProjects->concat($internalProjects)->concat($waitProjects)->concat($negotiationProjects));

        //obtenemos el jefe de la division
        $jefeArea = $this->getResponsableByArea($area);

        //retornamos a la vista del reporte 
        return view('SIRB/reportes/f2_gs_001/f2_gs_001',compact('area','extProjects',
        'internalProjects','waitProjects','negotiationProjects','totalProjects','jefeArea'));
    }

    /*obtenemos todos los proyectos de investigacion interna del area */
    protected function getExtProjects($area){
        //campos que se van a seleccionar
        $projectsExt = Proyecto::select([
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.nomproy',
            'proyectos.idusuarior',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.costo',
            //beneficios
            //financiamientos
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        //traemos el nombre del usuario responsable del proyecto
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.idarea','=',$area],
            ['proyectos.clavet','=','E'],
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });


        return $projectsExt;
    } 

    /*obtenemos los proyectos externos de multicoordinacion*/
    protected function getExtMulticoordProjects($area){

        //proyectos multicoordinacion
        $extMulticoordinacionProjects = Proyecto::select([
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.nomproy',
            'proyectos.idusuarior',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.costo',
            //beneficios
            //financiamientos
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        ->join('area_adscripcion', 'area_adscripcion.id', '=', 'proyectos.idarea')
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.clavea','=','M'],
            ['proyectos.clavet','=','E'],
            ['usuarios.idarea', '=',$area]
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });

        return $extMulticoordinacionProjects;
    } 

    /*obtenemos todos los proyectos de investigacion interna del area */
    protected function getInternalProjects($area){
       //campos que se van a seleccionar
       $projectsInt = Proyecto::select([
        'proyectos.clavea',
        'proyectos.clavet',
        'proyectos.claven',
        'proyectos.clavey',
        'proyectos.nomproy',
        'proyectos.idusuarior',
        'proyectos.fecha_inicio',
        'proyectos.fecha_fin',
        'proyectos.costo',
        //beneficios
        //financiamientos
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno',
    ])
        //traemos el nombre del usuario responsable del proyecto
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.idarea','=',$area],
            ['proyectos.clavet','=','I'],
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });

        return $projectsInt;
    }

    /*obtenemos los proyecots internos de multicoordinacion*/
    protected function getInternalMulticoordProjects($area){

        //proyectos multicoordinacion
        $intMulticoordinacionProjects = Proyecto::select([
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.nomproy',
            'proyectos.idusuarior',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.costo',
            //beneficios
            //financiamientos
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        ->join('area_adscripcion', 'area_adscripcion.id', '=', 'proyectos.idarea')
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.clavea','=','M'],
            ['proyectos.clavet','=','I'],
            ['usuarios.idarea', '=',$area]
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });

        return $intMulticoordinacionProjects;
    }

    /*obtenemos los proyectos que estan en espera COSPIII (internos) */
    protected function getWaitingProjects($area){
        //campos que se van a seleccionar
        $projectsWait = Proyecto::select([
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.nomproy',
            'proyectos.idusuarior',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.costo',
            //beneficios
            //financiamientos
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        //traemos el nombre del usuario responsable del proyecto
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.idarea','=',$area],
            ['proyectos.clavet','=','I'],
            ['proyectos.estado','=','0'],
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });

        return $projectsWait;
    }

    /*obtenemos los proyectos de multicoordinacion que estan en espera COSPIII (internos) */
    protected function getWaitingMulticoordProjects($area){
        //campos que se van a seleccionar
        $projectsWait = Proyecto::select([
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.nomproy',
            'proyectos.idusuarior',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.costo',
            //beneficios
            //financiamientos
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        //traemos el nombre del usuario responsable del proyecto
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.idarea','=',$area],
            ['proyectos.clavet','=','I'],
            ['proyectos.clavea','=','M'],
            ['proyectos.estado','=','0'],
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });

        return $projectsWait;
    }

    /*obtenemos los pproyectos de multicoordinacion que estan en negociacion */
    protected function getNegotiationMulticoordProjects($area){
        //campos que se van a seleccionar
        $projectsNegotiation = Proyecto::select([
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.nomproy',
            'proyectos.idusuarior',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.costo',
            //beneficios
            //financiamientos
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        //traemos el nombre del usuario responsable del proyecto
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.idarea','=',$area],
            ['proyectos.clavet','=','E'],
            ['proyectos.clavea','=','M'],
            ['proyectos.estado','=','0'],
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });

        return $projectsNegotiation;
    }

    /*obtenemos los pproyectos que estan en negociacion */
    function getNegotiationProjects($area){
        //campos que se van a seleccionar
        $projectsNegotiation = Proyecto::select([
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.nomproy',
            'proyectos.idusuarior',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.costo',
            //beneficios
            //financiamientos
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        //traemos el nombre del usuario responsable del proyecto
        ->join('usuarios','usuarios.id','proyectos.idusuarior')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.idarea','=',$area],
            ['proyectos.clavet','=','E'],
            ['proyectos.estado','=','0'],
        ])
        //ordenamos por orden alfabetico y numero menor
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get()
        ->map(function($project){
            $project->clave_project = $this->getProjectId($project->clavea,$project->clavet,$project->claven,$project->clavey);
            return $project;
        });

        return $projectsNegotiation;
    }

    //construye y retorna el id o clave del proyecto
    function getProjectId($clave_area,$clave_tipo,$clave_numero,$clave_anio){
        if($clave_numero < 10){
            return $clave_area . $clave_tipo . '-0'. $clave_numero.'/'. $clave_anio;
        }
        return $clave_area . $clave_tipo . '-'. $clave_numero.'/'. $clave_anio;
    }

    public function getResponsableByArea($idarea){
        //recuperamos el nombre completo del jefe de division
        $jefeDivision = User::select([
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        ])
        ->where([
            ['usuarios.idarea','=',$idarea],
            ['usuarios.responsable','=', 1] //1 representa el responsable de su area
        ])
        ->first();

        if(collect($jefeDivision)->isNotEmpty()){
            return $jefeDivision->Nombre.' '.$jefeDivision->Apellido_Paterno.' '.$jefeDivision->Apellido_Materno;
        }
        return 'No se encontro resposnable del area';
    }
}
