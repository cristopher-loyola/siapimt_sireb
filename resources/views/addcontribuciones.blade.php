@extends('plantillas/plantillaFormP')
@section('contenido') 
<title>Agregar las contribuciones del proyecto</title>
        <h3 class="fw-bold text-center py-5">Contribuciones del proyecto</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{route('addcontribucione',$proyt->id)}}" method="POST">
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
                <input id="idproy" type="number" class="form-control" name="idproy" value="{{$proyt->id}}" hidden>
                <span class="text-danger">@error('idproy') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Contribución </label>
                <select name="contri" id="contri" class="form-control">
                    <option value="{{old('contri')}}">Selecciona una Contribución</option>
                    @foreach ($contri as $use)
                        <option value="{{ $use->id }}">{{$use->id .' | '.$use->nombre_contri}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('contri') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{ route('contribuciones', $proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb">
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