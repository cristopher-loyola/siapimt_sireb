@extends('plantillas/plantillaForm2')
@section('contenido') 
<title>Actualizar Objetivo Sectorial</title>
        <h3 class="fw-bold text-center py-5">Actualizar Objetivo Sectorial</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{ route('upobjs', $obj->id) }}" method="POST">
            @if (Session::has('success'))
                <div class="alert-success">{{Session::get('success')}}</div>
                <br>
            @endif
            @if (Session::has('fail'))
                <div class="alert-danger">{{Session::get('fail')}}</div>
                <br>
            @endif
            @csrf
            <div class="mb-4">
                <label class="form-label"> Nombre </label>
                <textarea name="name" id="name"  class="form-control"rows="7">
                {{$obj->nombre_objetivosec}}
                </textarea>
                {{-- <input id="nombre" type="text" class="form-control" name="name" value="{{$obj->nombre_objetivosec}}"> --}}
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div> 
            <div>
                <a href="{{route('indexObjetivo')}}" class=" btn btn-danger" tabindex="4" id="redondb">
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