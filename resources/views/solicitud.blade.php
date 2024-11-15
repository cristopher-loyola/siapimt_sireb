@extends('plantillas/plantillaFormalt')
@section('contenido') 
<title>Solicitud de reprogramación</title>
<h3 class="fw-bold text-center py-5">Solicitud de Reprogramación</h3>
{{--Inicio del Login o Acceso --}}
    <form action="{{route('sendsolicitud', $proyt->id)}}" method="POST">
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
        <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Justificación: </label>
        <textarea name="obssol" id="obssol" rows="7" class="form-control" placeholder="Objetivo">
{{old('obssol')}}
        </textarea>
        <span class="text-danger">@error('obssol') {{$message}} @enderror</span>
    </div>
    <div>
        <h6 class="fw-bold text-star py-2">
            Nota RA-002: En el caso de suspensión del proyecto el responsable
             del proyecto deberá informar al Coordinador las causas por escrito
             y esté a su juicio avalará o no la suspensión
        </h6>
    </div>
    <div>
        <button type="submit" class="btn btn-warning" tabindex="5" id="redondb"
        style="background-color: rgb(255, 128, 17); font-weight:500">
            <img src="../img/send_bl.png" alt="" height="24em" width="24em">
            &nbsp;Enviar&nbsp;
        </button>
    </div>
    </form>
    <br>
    <div>
        <a href="{{ route('infoproys', $proyt->id)}}">
        <button type="submit" class="btn btn-dark btn-sm" id="redondb"
        style="font-weight:500">
            <img src="../img/back.png" alt="" height="24em" width="24em">
                &nbsp;Regresar&nbsp;&nbsp;
            </button>
        </a>
    </div>
@stop
