@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nuevo Puesto</title>
        <h3 class="fw-bold text-center py-5">Nuevo Puesto</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="addpuesto" method="POST">
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
                <label class="form-label"> Puesto </label>
                <input id="puesto" type="text" value="{{old('puesto')}}" class="form-control" name="puesto" placeholder="Puesto">
                <span class="text-danger">@error('puesto') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Costo x Hora </label>
                <input id="cxh" type="text" value="{{old('cxh')}}" class="form-control" name="cxh" placeholder="Costo x Hora">
                <span class="text-danger">@error('cxh') {{$message}} @enderror</span>
            </div> 
            <div>
                <a href="{{route('puesto')}}" class=" btn btn-danger" tabindex="4" id="redondb">
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