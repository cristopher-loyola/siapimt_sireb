<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProjectsInputFilter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    //nombre textual que tendra el usuario :string 
    public $label;

    //nombre que tendra el campo de busqueda :string
    public $nameField;

    //nombre del evento cuando se obtenga respuesta de la peticion
    public $nameEvent;

    public function __construct($label = 'Clave, Nombre o Responsable',$nameField = 'project-query',$nameEvent)
    {
        $this->label = $label;
        $this->nameField = $nameField;
        $this->nameEvent = $nameEvent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.projects-input-filter');
    }
}
