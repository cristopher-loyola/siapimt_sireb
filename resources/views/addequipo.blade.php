@extends('plantillas/plantillaFormP')
@section('contenido') 
<title>Nuevo Miembro del Equipo</title>
        <h3 class="fw-bold text-center py-5">Nuevo Miembro del Equipo</h3>
        {{--Inicio--}}
            <form action="{{ route('addequipo', $proyt->id)}}" method="POST">
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
                <label class="form-label"> Miembro </label>
                <select name="equipo" id="equipo" class="form-control" value="{{old('equipo')}}">
                    <option value="">Selecciona un Miembro para el equipo</option>
                    @foreach ($user as $use)
                        <option value="{{ $use->id }}">{{$use->Apellido_Paterno.' '.$use->Apellido_Materno.' '.$use->Nombre}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('equipo') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{ route('Equipo', $proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </a>
                <button type="submit" class="btn btn-primary" tabindex="5" id="redondb">
                    <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
                    Agregar
                </button>
            </div>
            </form>
        {{--Fin--}}  
@endsection