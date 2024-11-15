@extends('plantillas/plantillaresp')
@section('contenido')

<title>Documentos Técnico</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Documentos Técnicos </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/documentosT.css') }}">
</head>
    <body>

<div>
    <p style="text-align: center; font-size: 1.2rem;"><strong>Periodo consultado:</strong> {{ $periodoConsultado }}</p>
</div>

@if ($sesionEspecial == 1)
<div>
    <p style="text-align: center; font-size: 1.2rem;"><strong>Sesión Especial Activa</strong></p>
</div>
@endif




<!--///////////////////////Tabla con el contenido/////////////////////// -->
<table class="table" id="boletinesTable">
    <thead class="thead-light">
        <tr>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Tipo de producto</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha de publicación</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Número</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Título de producto</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Participación</th>
        </tr>
    </thead>
    <tbody>
    <!-- Filtra los boletines para eliminar duplicados -->
    @php
    $documentosUnicos = array_unique($documentos, SORT_REGULAR);
    @endphp
    <!-- Muestra los resultados en la tabla -->
    @foreach ($documentosUnicos as $documento)
        @php
            $documento->Anio = date('m-Y', strtotime($documento->Anio));

            if($documento->Jerarquia == 0){
                $documento->Jerarquia = "Autor";
            }else if($documento->Jerarquia != 0){
                $documento->Jerarquia = "Coautor";
            }
        @endphp
        <tr>
            <td style='text-align: center; vertical-align: middle;'>{{ $documento->Nombre }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $documento->Anio }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $documento->NoPublicacion }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $documento->Titulo }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $documento->Jerarquia }}</td>
        </tr>
    @endforeach
    </tbody>
</table>



    </body>
</html>
@stop
@push('scripts')
<script src="{{ asset('js/documentosT.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
