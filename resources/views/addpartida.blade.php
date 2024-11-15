@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nueva Partida</title>

        <h3 class="fw-bold text-center py-5">Nueva Partida</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="addpartidas" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label"> Partida </label>
                <input id="partida" type="number" class="form-control" name="partida" placeholder="Partida ">
            </div> 

            <div class="mb-4">
                <label class="form-label"> Concepto </label>
                <input id="concepto" type="text" class="form-control" name="concepto" placeholder="Concepto ">
            </div> 

            <div>
                <a href="partidas" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </a>
                <button type="submit" class="btn btn-primary" tabindex="5" id="redondb">
                    <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
                    Agregar
                </button>
            </div>
            </form>
        {{--Inicio del Login o Acceso --}}  

@endsection