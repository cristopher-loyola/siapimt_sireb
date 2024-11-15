<?php

namespace App\Http\Controllers\class;

use App\Enum\StatusPublication as EnumStatusPublication;
use App\Http\Controllers\Controller;
use App\Enum\StatusPublication;
use App\Enum\TypeProject;

class ProgressPublicaciontController extends Controller
{
    public function getProgressByPublication($project){

        //en caso de que el proyecto sea interno y este 100%
        if($this->isInternalProject($project->clavet) && $project->progreso >= 100){
            //por si no tiene publcacion, se calcula el progreso
            if($project->publicacion == StatusPublication::NoPublication->value){
                return $this->calculateProgress($project->progreso);
            }
            //acciones para el caso especifico 2 (con publicacion)
            if($project->publicacion == StatusPublication::Publication->value){
                return $project->progreso;
            }
            //acciones para el caso especifico 3 (es documento)
            if($project->publicacion == StatusPublication::Document->value){
                return $project->progreso;
            }
        }

        //retorno por defecto
        return $project->progreso;
    }

    public function calculateProgress($progress){
        return (($progress * 98) / 100);
    }

    public function isInternalProject($typeProject){
        return $typeProject == TypeProject::Internal->value;
    }

}
