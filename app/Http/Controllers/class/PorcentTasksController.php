<?php

namespace App\Http\Controllers\class;
use App\Http\Controllers\Controller;
use App\Models\Tarea;
use App\Models\Proyecto;


class PorcentTasksController extends Controller
{

    /*
        Metodos para obtener el porcentaje programado con base en la duracion de las tareas
    
    */
    /*
        retorna la duracion total en meses de las tareas o actividades de un proyecto
        toamando el campo de duracion de cada actividad
    */
        //obtiene la fecha de inicio del proyecto, la fecha de inicio de la primer tarea
    public function getDateStartProject($idProject){

        $dateStart = Tarea::where('idproyecto', $idProject)->min('fecha_inicio');

        if(!isset($dateStart)){
            return [];
        }

        return [
            'day' => date('d', strtotime($dateStart)),
            'month' => date('m', strtotime($dateStart)),
            'year' => date('Y', strtotime($dateStart)),
        ];
    } 

    //obtiene la fecha de inicio del proyecto, la fecha de fin de la ultima tarea
    public function getDateEndProject($idProject){
        
        $dateEnd = Tarea::where('idproyecto', $idProject)->max('fecha_fin');

        if(!isset($dateEnd)){
            return [];
        }

        return [
            'day' => date('d', strtotime($dateEnd)),
            'month' => date('m', strtotime($dateEnd)),
            'year' => date('Y', strtotime($dateEnd)),
        ];

    } 

    //retorna la fecha actual
    public function getDateCurrent(){
        return [
            'day' => date('d'),
            'month' => date('m'),
            'year' => date('Y'),
        ];
    }
    
    //embede el campo de porcentaje programado  una coleccion de proyectos
    public function appendProgressProgram($projects){
        //evaluamos todos los proyectos entrantes
        $projects->map(function($project){
            //si el proyecto tiene fecha de inicio y fecha de fin, independientemente del estado que tenga
            if(!empty($this->getDateStartProject($project->id)) && 
                !empty($this->getDateEndProject($project->id))){
                $project->porcent_program = $this->getPorcentProgrammedForTasks($project->id);
            }else{
                //en caso de que no tenga fecha de inicio y fin,dejamos en 0 el porcentaje programado
                $project->porcent_program = 0;
            }
            return $project;
        });
        //retornamos todos los proyectos
        return $projects;
    }

    public function getTotalTasksMonthsDuration($idProject){
        $totalMonthsDuration = Tarea::select('id','actividad','duracion','fecha_inicio','fecha_fin')
        ->where('idproyecto','=',$idProject)
        ->get()
        ->sum('duracion');
        return $totalMonthsDuration;
    }

    //retorna la duracion de una tarea
    public function getTasksMonthDuration($idTask){
        return Tarea::select('duracion')
        ->where('id','=',$idTask)
        ->first()
        ->duracion;
    }

    //retorna el promedio de porcentaje por mes de acuerdo con la sumatoria total de tareas
    public function getAveragePorcentForMonthByTasks($idProject){
        return round(100 / $this->getTotalTasksMonthsDuration($idProject) , 2);
    }

    //retorna fechas de inicio y fin de las tareas
    public function getTasksDatesForProject($idProject){
        $tasksProject = Tarea::select('id','fecha_inicio','fecha_fin')
        ->where('idproyecto','=',$idProject)
        ->orderBy('fecha_inicio','ASC')
        ->orderBy('fecha_fin','ASC')
        ->get()
        ->map(function($item){
            $item->fecha_inicio_2 = [
                'day' => date('d', strtotime($item->fecha_inicio)),
                'month' => date('m', strtotime($item->fecha_inicio)),
                'year' => date('Y', strtotime($item->fecha_inicio)),
            ];
            $item->fecha_fin_2 = [
                'day' => date('d', strtotime($item->fecha_fin)),
                'month' => date('m', strtotime($item->fecha_fin)),
                'year' => date('Y', strtotime($item->fecha_fin)),
            ];
            return $item;
        });

        return $tasksProject;
    }

    //retorna el progreso total de meses sumando los e todas las tareas
    public function getTotalMonthsProgressForTasks($idProject){
        //obtener todas las tareas del proyecto

        //evaluar que la tarea ya haya empezado, restar la fecha actual con la fecha de inicio de cada tarea
        $totalMonthsProgress = 0;
        $tasksProject = $this->getTasksDatesForProject($idProject);

        foreach ($tasksProject as $task ) {
            $totalMonthsProgress = $totalMonthsProgress + ($this->getTasksProgress($task));
        }

        return $totalMonthsProgress;
    }

    //retorna los meses de progreso de cada tarea con respecto a la fecha actual
    public function getTasksProgress($task){
        //constantes
        $MONTHS_FOR_YEAR = 12;
        $dateCurrent = $this->getDateCurrent();

        /*
            En caso de que la fecha actual pase la fecha de termino se retorna 
            la duracion total esperada de meses de la tarea
        */
        if( intval($dateCurrent['year']) >= intval($task['fecha_fin_2']['year']) && 
            intval($dateCurrent['month']) >= intval($task['fecha_fin_2']['month'])){
           return $this->getTasksMonthDuration($task->id);
        }

        //calculamos el total de meses transcurridos desde su inicio hasta la fecha actual
        $progressMonths = (($dateCurrent['year'] - $task['fecha_inicio_2']['year']) * $MONTHS_FOR_YEAR)
            + (($dateCurrent['month'] - $task['fecha_inicio_2']['month']) + 1);

        //en caso de que la fecha del proyecto aun no haya iniciado o la fecha de inicio no haya llegado
        if($progressMonths < 0){
            return 0;
        } 
        
        return $progressMonths;
    }

    //retorna el porcentaje programado para el proyecto
    public function getPorcentProgrammedForTasks($idProject){

        /*si la duracion total es 0 quiere decir que no se han establecido tareas para el proyecto,
         por lo que no se puede calcular el progreso
        */

        if($this->getTotalTasksMonthsDuration($idProject) < 1){
            return 0;
        }

        //mivariante modificada
        $tareasproy = Tarea::where('idproyecto',$idProject)->get();
        $tareasum = Tarea::where('idproyecto',$idProject)->get()->sum('duracion');
        $aprox = 0;

        foreach ($tareasproy as $tar) {
            $in = $tar->fecha_inicio;
            $fin = $tar->fecha_fin;
            $dur = $tar->duracion;
            $tar = 100 / $tareasum;
                                    
            $inicio = explode('-', $in);
            $fin = explode('-', $fin);
            $fhoyog = explode('-', date("Y-m-d"));

            $fecha1 = new \DateTime($inicio[0].'-'.$inicio[1].'-'.$inicio[2]);
            $fecha2 = new \DateTime($fin[0].'-'.$fin[1].'-'.$fin[2]);
            $fhoy = new \DateTime($fhoyog[0].'-'.$fhoyog[1].'-'.$fhoyog[2]);

            // Calcular la diferencia entre las dos fechas
            // $diferencia = $fecha1->diff($fecha2);
            $diferencia = $fecha1->diff($fhoy);

            // Obtener el número total de meses
            $meses = (($diferencia->y * 12) + $diferencia->m)+1;

            // diferencia cuantos meses de avance tiene, si ya se completa el valor
            // se reempleza por la duracion de la tarea

            if ($fecha1 < $fhoy) {
                if ($meses >= $dur) {
                    $previsto = $tar*$dur;
                } else {
                    $previsto = $tar*$meses;
                };
            } else {
                $previsto = $tar*0;
            };
            $aprox = $aprox+$previsto;
        };

        $porcentProgrammed = round($aprox,0);

        // $porcentProgrammed = $this->getTotalMonthsProgressForTasks($idProject) *
        // $this->getAveragePorcentForMonthByTasks($idProject);

        //en caso de que se pase una decimas del 100 o que falten algunas decimas para completar el 100, regresamos el 100
        if(($porcentProgrammed > 99 && $porcentProgrammed < 100) || ($porcentProgrammed > 100)){
            return 100;
        }
        return round($porcentProgrammed,0);
    }

}
