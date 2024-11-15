<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProjectsByArea extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */


    //texto que se va a mostrar en el campo 
    public $label;

    //recibe las areas de adscripcion para mostrar el el select []
    public $areasAdscripcion;

    public function __construct($label='Área de adscripción:',$areasAdscripcion = [])
    {
        $this->label = $label;
        $this->areasAdscripcion = $areasAdscripcion;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.projects-by-area');
    }
}
