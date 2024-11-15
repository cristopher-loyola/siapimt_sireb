@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nuevo Modo de Transporte</title>
        <h3 class="fw-bold text-center py-5">Nuevo Modo de Transporte</h3>
            <form action="addtranspo" method="POST">
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
                <input id="nombre" type="text" value="{{old('name')}}" class="form-control" name="name" placeholder="Nombre ">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div> 
            <div>
                <a href="modt" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </a>
                <button type="submit" class="btn btn-primary" tabindex="5" id="redondb">
                    <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
                    Agregar
                </button>
            </div>
            </form>
@endsection