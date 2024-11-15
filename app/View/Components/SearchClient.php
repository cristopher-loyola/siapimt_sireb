<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchClient extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     //label: String
    public $label;
    
    //fielName: String
    public $fieldName;

    //eventName: String
    public $eventName;

    public function __construct($label = 'Buscar cliente',$fieldName,$eventName)
    {
        $this->label = $label;
        $this->fieldName = $fieldName;
        $this->eventName = $eventName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search-client');
    }
}
