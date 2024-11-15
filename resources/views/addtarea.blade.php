@extends('plantillas/plantillaFormP')
@section('contenido') 
<title>Nueva Tarea o Actividad</title>
        <h3 class="fw-bold text-center py-5">Nueva Tarea</h3>
        {{--Inicio--}}
            <form action="{{ route('tarea', $proyt->id)}}" method="POST">
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
                <input id="idproy" type="number" class="form-control" name="idproy" value="{{$proyt->id}}" hidden >
                <span class="text-danger">@error('idproy') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> Nombre de la Tarea (80 caracteres máximo)</label>
                <input id="act" name="act"  type="text" value="{{old('act')}}" maxlength="80" class="form-control" placeholder="">
                <span class="text-danger">@error('act') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Fecha de Inicio de la Tarea</label>
                <input id="inicio" name="inicio"  type="date" value="{{old('inicio')}}"
                 class="form-control" onclick="calcular()" <input type="date" id="fecha" name="fecha">
                <span class="text-danger">@error('inicio') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Fecha de Fin de la Tarea</label>
                <input id="fin" name="fin"  type="date" 
                value="{{old('fin')}}" class="form-control" onclick="calcular()">
                <span class="text-danger">@error('fin') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{ route('tareag', $proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb">
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
        <script>
            function calcular(){
            var fechaini = new Date(document.getElementById('inicio').value);
            var fechafin = new Date(document.getElementById('fin').value);
            var diasdif= fechafin.getTime()-fechaini.getTime();
            var contdias = Math.round(diasdif/(1000*60*60*24));
            var contdiasmas = contdias+1;
            if(contdias == 0){
                document.getElementById('result').value=1;
            }
            document.getElementById('result').value=(contdiasmas=='') ? x : contdiasmas;
            /* alert(contdias); */
            }
        </script>
@endsection