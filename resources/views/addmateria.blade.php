@extends('plantillas/plantillaFormP')
@section('contenido') 
<title>Nuev Materia</title>
        <h3 class="fw-bold text-center py-5">Nueva materia</h3>
        {{--Inicio--}}
            <form action="{{ route('addmateria', $proyt->id)}}" method="POST">
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
                <label class="form-label"> Materia </label>
                <select name="materia" id="materia" class="form-control" value="{{old('materia')}}">
                    <option value="">Selecciona una materia</option>
                    @foreach ($materia as $mat)
                        <option value="{{ $mat->id }}">{{$mat->descmateria}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('materia') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{ route('Materia', $proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb">
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