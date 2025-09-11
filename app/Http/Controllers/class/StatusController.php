<?php

namespace App\Http\Controllers\class;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /*
    Los valores de estados en proyectos deberian estar en una tabla en base de datos, no en datos estaticos en codigo.
    Pero yo solo soy el de las implementaciones, asi que me reservo el derecho realizar cualquier modificacion 
    que me pueda retrasar y no terminar lo que me corresponde :)
    */
    protected $statusValues = [
        0 => [
            'label' => 'No iniciado',
            'color' => '#c433ff'
        ],
        1 => [
            'label' => 'En ejecución',
            'color' => '#1373c1'
        ],
        2 => [
            'label'=>'Concluido',
            'color' => '#1fc113'
            ],
        3 => [
            'label'=>'En pausa',
            'color' => '#ffaa00'
            ]
        ,
        4 => [
            'label'=>'En reprogramación',
            'color' => '#000000'
        ],
        5 => [
            'label'=>'Cancelado',
            'color' => '#c1131f'
        ],
        6 => [
            'label'=>'No aceptado',
            'color' => '#FF1C0E'
        ]
    ];

    protected $labelsValues = [
        'I' => 'en espera COSPIII',
        'E' => 'en negociación',
    ];

    //manejara los status del proyecto, devolvera las etiquetas de acuerdo a lo requerido
    public function getLabelStatus($status){
        return $this->statusValues[$status]['label'] ?? 'Desconocido';
    }

    //manejara los status del proyecto, devolvera el color para la etiqueta del estado
    public function getColorLabelStatus($status){
        return $this->statusValues[$status]['color'] ?? '#575656';
    }

    //retornara la etiqueta del estado en negociacion en caso de no estar iniciado el proyecto
    public function getLabelStatusNegotiation($status,$typeProject){
        if($status == 0){
            return $this->labelsValues[$typeProject] ?? 'Desconocido';
        }
        return '';
    }

    //dada una consulta directa de base de datos, retorna la consulta pero con los colores y etiquetas de estado
    public function appendLabelAndColorStatus($response){
        //agregamos el campo con la etiqueta de acuerdo con su estado
        $response->map(function($project){
            $project->label_status = $this->getLabelStatus($project->estado);
            $project->label_color = $this->getColorLabelStatus($project->estado);
            //embdede la etiqueta del estado del proyectyo en caso de que no se haya iniciado
            //$project->label_negotiation = $this->getLabelStatusNegotiation($project->estado,$project->clavet);
            return $project;  
        });
        return $response;
    }

}
