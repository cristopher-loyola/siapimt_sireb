@extends('plantillas/plantillaFormalt')
@section('contenido') 
<title>Información de la solicitud</title>
<h3 class="fw-bold text-center py-5">Información de la solicitud</h3>
<div class="mb-1 input-group">
    <div class="mb-4 col" style="text-align: center">
        <label class="form-label" style="font-weight: bold; font-size: 1.2em">
            <?php
            if ($proyt->claven < 10)
                echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
            else
                echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
            ?>
        </label>
    </div>
</div>
{{--Inicio del Login o Acceso --}}
    @if ($obs->tipo == 1 || $obs->tipo == 2)
        <div class="mb-4">
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Fecha de solicitud: {{$obs->fechaobs}}</label>
        </div>
        <div class="mb-4">
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Justificación: </label>
            <textarea name="obssol" id="obssol" rows="3" class="form-control" placeholder="Objetivo" disabled>{{$obs->obs}}</textarea>
            <span class="text-danger">@error('obssol') {{$message}} @enderror</span>
        </div>
        <div class="mb-4">
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Justificacion del Rechazo: </label>
            <textarea name="obssol" id="obssol" rows="3" class="form-control" placeholder="Objetivo" disabled>{{$obs->obs_respuesta}}</textarea>
            <span class="text-danger">@error('obssol') {{$message}} @enderror</span>
        </div>
    @elseif ($obs->tipo == 5)
        <div class="mb-4">
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Fecha de solicitud: {{$obs->fechaobs}}</label>
        </div>
        <div class="mb-4">
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Motivo del Rechazo
            @if ($proyt->clavet == 'I')
                del Protocolo
            @else
                de la Propuesta Técnico-Económica:
            @endif
            </label>
            <textarea name="obssol" id="obssol" rows="3" class="form-control" placeholder="Objetivo" disabled>{{$obs->obs_respuesta}}</textarea>
            <span class="text-danger">@error('obssol') {{$message}} @enderror</span>
        </div>
    @elseif ($obs->tipo == 4)
        <div class="mb-4">
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Fecha de solicitud: {{$obs->fechaobs}}</label>
        </div>
        <div class="mb-4">
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Observaciones generales: </label>
            <textarea name="obssol" id="obssol" rows="3" class="form-control" placeholder="Objetivo" disabled>{{$obs->obs_respuesta}}</textarea>
            <span class="text-danger">@error('obssol') {{$message}} @enderror</span>
        </div>
    @endif
    <div>
    </div>
    <br>
    <div>
        <a href="{{ route('observaciones', $proyt->id)}}">
        <button type="submit" class="btn btn-dark btn-sm" id="redondb"
        style="font-weight:500">
            <img src="{!! asset('img/back.png') !!}" alt="" height="24em" width="24em">
                &nbsp;Regresar&nbsp;&nbsp;
            </button>
        </a>
    </div>
@stop
