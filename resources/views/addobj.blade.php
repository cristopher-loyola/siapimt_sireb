@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nuevo Objetivo Sectorial</title>

        <h3 class="fw-bold text-center py-5">Nuevo Objetivo Sectorial</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="addobjs" method="POST">
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
                <label class="form-label"> Objetivo </label>
                <textarea name="name" id="name" rows="7" class="form-control" placeholder="Objetivo">
                    {{old('name')}}
                </textarea>
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="modo" class=" btn btn-danger" tabindex="4" id="redondb">
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