@extends('plantillas/plantillaReporte')
@section('contenido') 
<title>Por contrato</title>

        <h3 class="fw-bold text-center py-5">Reporte por contrato</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{route('exportExcel2')}}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label"> Contrato</label>
                <select class="form-control" name="ncontratos" value="{{old('ncontratos')}}">
                    <option value="" disabled> Seleccione el contrato</option>
                    @foreach ($contratos as $con)
                  <option name="ncontratos" value="{{ $con->ncontratos }}"> {{$con->ncontratos }}</option>
                @endforeach    
                </select>    
            </div> 
            
                <button type="submit" class="btn btn-outline-warning" tabindex="5" id="redondb">
                    <i class="bx bxs-file-export"></i>
                    Reporte por Contrato
                </button>

                <a href="{{ route('cancelcrudafect')}}" class="btn btn-danger" id="redondb"><i class="bx bxs-tag-x bx-fw bx-sm bx-flashing-hover"></i>Cancelar</a>
                            
            </div>
            </form>
        {{--Inicio del Login o Acceso --}}  

@endsection