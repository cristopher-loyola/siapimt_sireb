@extends('plantillas/plantillaForm2')
@section('contenido') 
<title>Actualizar Área de Adscripción</title>

        <h3 class="fw-bold text-center py-5">Actualizar Área de Adscripción</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{ route('upareas', $key->id) }}" method="POST">
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
                <input id="nombre" type="text" class="form-control" name="name" placeholder="Nombre" value="{{$key->nombre_area}}">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> Siglas </label>
                <input id="siglas" type="text" class="form-control" name="siglas" placeholder="siglas" maxlength="5" style="text-transform:uppercase" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$key->siglas}}">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Letra Clave </label>
                <input id="letra" type="text" class="form-control" name="letra" placeholder="letra" maxlength="1" style="text-transform:uppercase" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$key->inicial_clave}}">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div>  
            <div>
                <a href="{{route('indexarea')}}" class=" btn btn-danger" tabindex="4" id="redondb">
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