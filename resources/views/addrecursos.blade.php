@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nuevo Recurso</title>
        <h3 class="fw-bold text-center py-5">Nuevo Recurso</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="addrecu" method="POST">
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
                <label class="form-label"> Partida </label>
                <input id="partida" type="number" value="{{old('partida')}}" class="form-control" name="partida" placeholder="Partida">
                <span class="text-danger">@error('partida') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Concepto </label>
                <input id="concepto" type="text" value="{{old('concepto')}}" class="form-control" name="concepto" placeholder="Concepto">
                <span class="text-danger">@error('concepto') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Clave </label>
                    <select name="clave" id="clave" class="form-control" value="{{old('clave')}}">
                        <option value=""> Selecciona una clave para el recurso</option>
                        <option value="F"> F - Financiero</option>
                        <option value="M"> M - Materiales </option>
                        <option value="H"> H - Humano</option>
                        <option value="O"> O - Otros</option>
                        <option value="T"> T - Tecnologicos</option>
                    </select>
                <span class="text-danger">@error('clave') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{route('Recursos')}}" class=" btn btn-danger" tabindex="4" id="redondb">
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