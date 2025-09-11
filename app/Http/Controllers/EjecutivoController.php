<?php

namespace App\Http\Controllers;
use App\Models\Proyecto;



class EjecutivoController extends Controller
{
    /*
        -Recuperar los poyectos que pertenecen al area donde esta el ejecutivo
        -Recuperar proyectos a los que pertenece como capitan
        -Recuperar proyectos a los que pertenece como integrante
        -Recuperar proyectos multicoordinacion
    
    */

    //recuperamos todos los proyectos de los cuales es responsable le usuario autenticado
    function getProjectsMulticoordinacionIamResponsableInMyArea($area)
    {

        if (session()->has('LoginId')) {
            //recuperamos el id y el area de la sesion del usuario
            $userId = session('LoginId');
            $userProjects = Proyecto::select(
                'proyectos.id',
                'proyectos.nomproy',
                'proyectos.clavea',
                'proyectos.clavet',
                'proyectos.claven',
                'proyectos.clavey',
                'proyectos.fecha_inicio',
                'proyectos.fecha_fin',
                'proyectos.idusuarior',
                'proyectos.aprobo',
                'proyectos.oculto',
                'proyectos.progreso',
                'proyectos.duracionm',
                'proyectos.costo',
                'proyectos.estado',
                'proyectos.publicacion',
                'proyectos.idpublicacion',
                'usuarios.Nombre',
                'usuarios.Apellido_Paterno',
                'usuarios.Apellido_Materno',
                'area_adscripcion.nombre_area',
                'proyectos.completado'
            )
            ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
            ->join('area_adscripcion','usuarios.idarea','=','area_adscripcion.id')

                ->where([
                    ['proyectos.oculto','=','1'],
                    ['proyectos.idusuarior', '=', $userId],
                    ['proyectos.clavea','=','M'],
                    ['area_adscripcion.nombre_area', '=', $area],
                ])
                ->orderBy('proyectos.clavea', 'ASC')
                ->orderBy('proyectos.clavet', 'ASC')
                ->orderBy('proyectos.claven', 'ASC')
                ->orderBy('proyectos.clavey', 'ASC')
                ->get();

            return $userProjects;
        }
        return ['error' => 'Error de autenticacion'];
    }

    //recuperamos todos los proyectos de los cuales es responsable le usuario autenticado
    function getProjectsIamResponsableInMyArea($area)
    {

        if (session()->has('LoginId')) {
            //recuperamos el id y el area de la sesion del usuario
            $userId = session('LoginId');
            $userProjects = Proyecto::select(
                'proyectos.id',
                'proyectos.nomproy',
                'proyectos.clavea',
                'proyectos.clavet',
                'proyectos.claven',
                'proyectos.clavey',
                'proyectos.fecha_inicio',
                'proyectos.fecha_fin',
                'proyectos.idusuarior',
                'proyectos.aprobo',
                'proyectos.oculto',
                'proyectos.progreso',
                'proyectos.duracionm',
                'proyectos.costo',
                'proyectos.estado',
                'proyectos.publicacion',
                'proyectos.idpublicacion',
                'usuarios.Nombre',
                'usuarios.Apellido_Paterno',
                'usuarios.Apellido_Materno',
                'area_adscripcion.nombre_area',
                'proyectos.completado'
            )
                ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
                ->join('area_adscripcion','usuarios.idarea','=','area_adscripcion.id')
                ->where([
                    ['proyectos.oculto','=','1'],
                    ['proyectos.idusuarior', '=', $userId],
                    ['area_adscripcion.nombre_area', '=', $area],
                ])
                ->orderBy('proyectos.clavea', 'ASC')
                ->orderBy('proyectos.clavet', 'ASC')
                ->orderBy('proyectos.claven', 'ASC')
                ->orderBy('proyectos.clavey', 'ASC')
                ->get();

            return $userProjects;
        }
        return ['error' => 'Error de autenticacion'];
    }

        //recuperamos todos los proyectos de los cuales es participante, pero mo responsable del usuario autenticado
        function getProjectsMulticoordinacionIamMiembro()
        {
    
            if (session()->has('LoginId')) {
                //recuperamos el id y el area de la sesion del usuario
                $userId = session('LoginId');
    
                $userProjects = Proyecto::select(
                    'proyectos.id',
                    'proyectos.nomproy',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.idusuarior',
                    'proyectos.aprobo',
                    'proyectos.oculto',
                    'proyectos.progreso',
                    'proyectos.duracionm',
                    'proyectos.costo',
                    'proyectos.estado',
                    'proyectos.publicacion',
                    'proyectos.idpublicacion',
                    'usuarios.Nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    'area_adscripcion.nombre_area',
                    'proyectos.completado'
                )
                    ->join('equipo', 'equipo.idproyecto', '=', 'proyectos.id')
                    ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
                    ->join('area_adscripcion','usuarios.idarea','=','area_adscripcion.id')
                    ->where([
                        ['proyectos.oculto','=','1'],
                        ['proyectos.idusuarior', '!=', $userId],
                        ['equipo.idusuario', '=', $userId],
                        ['proyectos.clavea','=','M'],
                    ])
                    ->orderBy('proyectos.clavea', 'ASC')
                    ->orderBy('proyectos.clavet', 'ASC')
                    ->orderBy('proyectos.claven', 'ASC')
                    ->orderBy('proyectos.clavey', 'ASC')
                    ->get();
    
                return $userProjects;
            }
            return ['error' => 'Error de autenticacion'];
        }
    //recuperamos todos los proyectos de los cuales es participante, pero mo responsable del usuario autenticado
    function getProjectsIamMiembroInMyArea($area)
    {

        if (session()->has('LoginId')) {
            //recuperamos el id y el area de la sesion del usuario
            $userId = session('LoginId');

            $userProjects = Proyecto::select(
                'proyectos.id',
                'proyectos.nomproy',
                'proyectos.clavea',
                'proyectos.clavet',
                'proyectos.claven',
                'proyectos.clavey',
                'proyectos.fecha_inicio',
                'proyectos.fecha_fin',
                'proyectos.idusuarior',
                'proyectos.aprobo',
                'proyectos.oculto',
                'proyectos.progreso',
                'proyectos.duracionm',
                'proyectos.costo',
                'proyectos.estado',
                'proyectos.publicacion',
                'proyectos.idpublicacion',
                'usuarios.Nombre',
                'usuarios.Apellido_Paterno',
                'usuarios.Apellido_Materno',
                'area_adscripcion.nombre_area',
                'proyectos.completado'
            )
                ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
                ->join('equipo', 'equipo.idproyecto', '=', 'proyectos.id')
                ->join('area_adscripcion', 'proyectos.idarea', '=', 'area_adscripcion.id')
                ->where([
                    ['proyectos.oculto','=','1'],
                    ['proyectos.idusuarior', '!=', $userId],
                    ['equipo.idusuario', '=', $userId],
                    ['area_adscripcion.nombre_area', '=', $area],
                ])
                ->orderBy('proyectos.clavea', 'ASC')
                ->orderBy('proyectos.clavet', 'ASC')
                ->orderBy('proyectos.claven', 'ASC')
                ->orderBy('proyectos.clavey', 'ASC')
                ->get();

            return $userProjects;
        }
        return ['error' => 'Error de autenticacion'];
    }


}
