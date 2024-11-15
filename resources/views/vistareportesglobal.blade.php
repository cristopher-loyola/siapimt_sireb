@extends('plantillas/plantillaReporte')
@section('contenido') 
<title>Reporte</title>
        <h3 class="fw-bold text-center py-5">Reporte de Proyectos por Fechas</h3>
             <form action="excelporfecha" method="POST">
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
                <label class="form-label"> Fecha de fin entre</label>
                <input id="inicio" name="inicio" type="date" class="form-control" 
                value="{{old('inicio')}}">
                <span class="text-danger">@error('inicio') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> y </label>
                <input id="fin" name="fin" type="date" class="form-control" 
                value="{{old('fin')}}">
                <span class="text-danger">@error('fin') {{$message}} @enderror</span>
            </div>
            <div>
                <button type="submit" class="btn btn-warning" tabindex="5" id="redondb">
                    <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
                    Reportes de Proyectos por Fechas
                </button>
            </div>
            </form> 
            <hr>
            <div class="mb-4">
            <h3 class="fw-bold text-center py-5">Reporte General de Proyectos</h3>
                <div>
                    <a href="{{ route('exceltodosglobal')}}" class="btn btn-warning" tabindex="5" id="redondb">
                        <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
                        Reporte General de Proyectos
                    </a>
                </div>
            </div>
            <div>
                <a href="{{ route('adpindex')}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </a>
            </div>
@endsection