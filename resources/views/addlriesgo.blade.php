@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nuevo Riesgo</title>
        <h3 class="fw-bold text-center py-5">Nuevo Riesgo</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="addlriesgos" method="POST">
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
                <label class="form-label"> Nombre del riesgo </label>
                <input id="nombre" type="text" value="{{old('name')}}" class="form-control" name="name" placeholder="Nombre">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Tipo de riesgo </label>
                <select name="tipo" id="tipo" class="form-control" value="{{old('tipo')}}">
                    <option value="">Selecciona un tipo de riesgo</option>
                    <option value="1">Interno</option>
                    <option value="2">Externo</option>
                    <option value="3">Ambos</option>
                </select>
                <span class="text-danger">@error('tipo') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Acciones del riesgo </label>
                <textarea name="actrisk" id="actrisk" rows="5" class="form-control" placeholder="">{{old('actrisk')}}</textarea>
                <span class="text-danger">@error('actrisk') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="riesgos" class=" btn btn-danger" tabindex="4" id="redondb">
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