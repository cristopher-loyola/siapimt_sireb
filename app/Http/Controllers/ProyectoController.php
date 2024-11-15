<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;


class ProyectoController extends Controller
{
    //retorna los anios disponibles para realizar un proyecto, anio actual y un rango de anios especificado
    public function getYearOptionsForRealizeProject($yearRange=2){
        $currentYear = date('Y');
        $yearOptions = [];

            for ($i = 0; $i < $yearRange; $i++) { 
                $yearOptions[$i] = ['year'=>$currentYear+$i];
            }
        return $yearOptions;
    }

    public function getValueYear($year){
        //en caso de ser una cadena, se toman los ultimos 2 digitos y se retorna en formato int
        if(is_string($year)){
            return intval(substr($year,1,3));
        }
        //en caso de ser un int, se convierte a cadena y se toman los ultimos 2 digitos y se retorna en formato int
        if(is_int($year)){
            return intval(substr(strval($year),1,3));
        }
    }

    //funcion que retorna el proximo numero de proyecto
    public function getNumberProject($idArea,$year){

        $lastProjectNumber = Proyecto::select('id','nomproy','claven','clavey','idarea')
        ->where('clavey','=',$this->getValueYear($year))
        ->where('idarea','=',$idArea)
        ->get()
        ->max('claven');

        return $lastProjectNumber + 1;
    }
}
