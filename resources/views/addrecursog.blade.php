@extends('plantillas/plantillaFormP')
@section('contenido') 
<title>Agregar Recurso para el proyecto</title>
        <h3 class="fw-bold text-center py-5">Agregar Recurso para el proyecto</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{ route('addrecursoproy', $proyt->id)}}" method="POST">
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
                <label class="form-label"> Recurso </label>
                    <select name="resc" id="resc" class="form-control" value="{{old('resc')}}">
                        <option value="Inicio">Seleccione un recurso</option>
                        @foreach ($resc as $res)
                            <option value="{{ $res->id }}">{{$res->partida.' | '.$res->concepto.' | '.$res->clave}}</option>
                        @endforeach
                    </select>
                <span class="text-danger">@error('resc') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
            <label class="form-label"> Cantidad ($)</label>
                <input id="cant" type="number" step="any" class="form-control" name="cant" value="{{old('cant')}}" placeholder="">
                <span class="text-danger">@error('cant') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{route('recursosproy',$proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb">
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