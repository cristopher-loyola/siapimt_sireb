@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nueva Área de Adscripción</title>

        <h3 class="fw-bold text-center py-5">Nueva Área de Adscripción</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="addar" method="POST">
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
                <input id="nombre" type="text" value="{{old('name')}}" class="form-control" name="name" placeholder="Nombre">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> Siglas </label>
                <input id="siglas" type="text" value="{{old('siglas')}}" class="form-control" name="siglas" placeholder="siglas" maxlength="5" style="text-transform:uppercase" onkeyup="javascript:this.value=this.value.toUpperCase();">
                <span class="text-danger">@error('siglas') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Letra Clave </label>
                <input id="letra" type="text" value="{{old('letra')}}" class="form-control" name="letra" placeholder="letra" maxlength="1" style="text-transform:uppercase" onkeyup="javascript:this.value=this.value.toUpperCase();">
                <span class="text-danger">@error('letra') {{$message}} @enderror</span>
            </div>  
            <div>
                <a href="moda" class=" btn btn-danger" tabindex="4" id="redondb">
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