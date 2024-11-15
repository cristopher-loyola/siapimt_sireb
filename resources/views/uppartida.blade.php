@extends('plantillas/plantillaForm2')
@section('contenido') 
<title>Modificar Partida</title>

        <h3 class="fw-bold text-center py-5">Modificar Partida</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{ route('uppartidas', $partida->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label"> Partida </label>
                    <input id="partida" type="number" class="form-control" name="partida" value="{{$partida->partida}}">
                </div> 
    
                <div class="mb-4">
                    <label class="form-label"> Concepto </label>
                    <input id="concepto" type="text" class="form-control" name="concepto" value="{{$partida->concepto}}">
                </div> 
            <div>
                <a href="{{route('indexpartida')}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </a> 
                <button type="submit" class="btn btn-warning" tabindex="5" id="redond">
                    <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
                    Actualizar
                </button>
            </div>
            </form>
        {{--Inicio del Login o Acceso --}}  
@endsection