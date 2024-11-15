@extends('plantillas/plantillaFormalt')
@section('contenido') 
<title>Actualizar Actividad o Tarea</title>
        <h3 class="fw-bold text-center py-5">Actualizar Tarea</h3>
        {{--Inicio--}}
            <form action="{{ route('uptarea',[$proyt->id ,$tarea->id])}}" method="POST">
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
            </div> 
            <div class="mb-4">
                <label class="form-label"> Nombre de la Tarea (80 caracteres máximo)</label>
                <input id="act" name="act"  type="text" class="form-control" placeholder="Actividad" value="{{$tarea->actividad}}" maxlength="80">
                <span class="text-danger">@error('act') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Fecha de Inicio de la Tarea </label>
                <input id="inicio" name="inicio" onclick="calcular()" 
                type="date" class="form-control" 
                value="{{$tarea->fecha_inicio}}" >
                <span class="text-danger">@error('inicio') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Fecha de Fin de la Tarea </label>
                <input id="fin" name="fin" onclick="calcular()" 
                type="date" class="form-control" value="{{$tarea->fecha_fin}}"> 
                <span class="text-danger">@error('fin') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{ route('tareag', $proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redond">
                    <i class='bx bxs-tag-x'></i>
		     Cancelar
                </a>
                <button type="submit" class="btn btn-warning" tabindex="5" id="redond">
                    <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
                    Actualizar
                </button>
            </div>
            </form>
        {{--Fin--}}  
        <script>
            var fechaini = new Date(document.getElementById('inicio').value);
            var fechafin = new Date(document.getElementById('fin').value);
            var diasdif= fechafin.getTime()-fechaini.getTime();
            var contdias = Math.round(diasdif/(1000*60*60*24));
            var contdiasmas = contdias+1;
            if(contdias == 0){
                document.getElementById('result').value=1;
            }
            document.getElementById('result').value=(contdiasmas=='') ? x : contdiasmas;
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
            }
        </script> 
@endsection