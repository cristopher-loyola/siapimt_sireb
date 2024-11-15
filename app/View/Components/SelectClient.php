<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectClient extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    /*component attributes */

    //label: string
    public $label;

    //nameField: string
    public $nameField;

    //categories: Array
    public $categories;

    /*
        Estos atributos solo se utilizaran en caso de que el componente se utilice para actualizar
    */

    //cliente: Array por si hay un cliente por defecto
    public $cliente;

    //categoriesN2: Array
    public $categoriesN2;

    //categoriesN3: Array
    public $categoriesN3;

    public function __construct($label,$nameField='cliente_usuario',$categories,$cliente = [], $categoriesN2 = [], $categoriesN3 = [])
    {
        $this->label = $label;
        $this->nameField = $nameField;
        $this->categories = $categories;
        $this->categoriesN2 = $categoriesN2;
        $this->categoriesN3 = $categoriesN3;
        $this->cliente = $cliente;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-client');
    }
}
