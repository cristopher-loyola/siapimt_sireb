@extends('plantillas/plantilla')
@section('contenido')   
<title>Inicio</title>
    {{-- Principio de tabla de proyectos  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Módulo Financiero / Proyectos </h2>
        <br><br>
        <div class="container text-right">
            <a href="{{route ('porcontrato')}}" class="btn btn-outline-warning">
            <i class="bx bxs-file-export"></i>
            Reporte por Contrato
            </a>
        </div>
        <br>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Número de Contrato</th>
                    <th scope="col">Clave del Proyecto</th>
                    <th scope="col">Nombre del Proyecto</th>
                    <th scope="col">Fecha de inicio</th>
                    <th scope="col">Fecha de fin</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($proy as $pr)
                <tr>
                    <td> {{$pr->ncontratos}}</td>
                    <td>{{$pr->clavea.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey}}</td>
                    <td><a href="{{route('afectaciones', $pr->id)}}"> {{$pr->nomproy}}</a></td>
                    <td>{{$pr->fecha_inicio}}</td>
                    <td>{{$pr->fecha_fin}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      <br>
    </div>
    {{-- Fin de la tabla de proyectos --}}
@stop