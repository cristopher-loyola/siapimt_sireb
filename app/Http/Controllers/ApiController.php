<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Http\Controllers\class\StatusController;
use App\Http\Controllers\class\PorcentTasksController;
use Illuminate\Http\Request;
use DB;


class ApiController extends Controller
{
    /*
        En este controlador se ponen metodos de api o rutas que devuelven respuesta con datos en formato json
        (solo los ultimos metodos se deben agregar aqui debido a mostivos de estructuracion tardía) 
    */

    //busca por nombre del proyecto, clave o responsable
    public function getProjectsByNombreClaveResponsable(Request $request){
        $statusController = new StatusController();

        $projectsByName = $statusController->appendLabelAndColorStatus($this->getProjectsByName($request->value));
        $projectsByClave = $statusController->appendLabelAndColorStatus($this->getProjectsByClave($request->value));
        $projectsByResp = $statusController->appendLabelAndColorStatus($this->getProjectsByResponsable($request->value));

        return response()->json($projectsByName->concat($projectsByClave)->concat($projectsByResp));
    }

    function getProjectsByClave($value){
        $porcentProjectController = new PorcentTasksController();

        $projectsArea = Proyecto::select(
            'proyectos.*',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        )
        ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
        ->where(DB::raw("CONCAT(proyectos.clavea,proyectos.clavet,'-0',proyectos.claven,'/',proyectos.clavey)"),'like','%'.$value.'%')
        ->where('proyectos.oculto', '=', '1')
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get();

        if(count($projectsArea) < 1){
            $projectsArea = Proyecto::select(
                'proyectos.*',
                'usuarios.Nombre',
                'usuarios.Apellido_Paterno',
                'usuarios.Apellido_Materno',
            )
            ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
            ->where(DB::raw("CONCAT(proyectos.clavea,proyectos.clavet,'-',proyectos.claven,'/',proyectos.clavey)"),'like','%'.$value.'%')
            ->where('proyectos.oculto', '=', '1')
            ->orderBy('proyectos.clavea', 'ASC')
            ->orderBy('proyectos.clavet', 'ASC')
            ->orderBy('proyectos.claven', 'ASC')
            ->orderBy('proyectos.clavey', 'ASC')
            ->get();
        }
        $projectsArea = $porcentProjectController->appendProgressProgram($projectsArea);

        return $projectsArea;

    }

    function getProjectsByName($value){
        $porcentProjectController = new PorcentTasksController();

        $projectsArea = Proyecto::select(
            'proyectos.*',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        )
        ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
        ->where('proyectos.nomproy','like','%'.strtoupper($value).'%')
        ->where('proyectos.oculto', '=', '1')
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get();

        $projectsArea = $porcentProjectController->appendProgressProgram($projectsArea);

        return $projectsArea;
    }

    function getProjectsByResponsable($value){
        $porcentProjectController = new PorcentTasksController();

        $projectsArea = Proyecto::select(
            'proyectos.*',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
        )
        ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
        ->where('proyectos.oculto', '=', '1')
        ->where(function($query) use ($value){
            $query->where('usuarios.Nombre','like','%'.$value.'%')
            ->orWhere('usuarios.Apellido_Paterno','like','%'.$value.'%')
            ->orWhere('usuarios.Apellido_Materno','like','%'.$value.'%');
        })
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get();

        $projectsArea = $porcentProjectController->appendProgressProgram($projectsArea);

        return $projectsArea;
    }

}

