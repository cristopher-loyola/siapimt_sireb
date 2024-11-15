@extends('plantillas/plantillaresp')
@section('contenido')

<title>Boletines IMT</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Boletines IMT </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/boletines.css') }}">
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
            <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Número de boletín</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Número de artículo</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Título del artículo</th>
            <th scope="col" style='text-align: center; vertical-align: middle;'>Participación</th>
        </tr>
    </thead>
    <tbody>
    <!-- Filtra los boletines para eliminar duplicados -->
    @php
    $boletinesUnicos = array_unique($boletines, SORT_REGULAR);
    @endphp
    <!-- Muestra los resultados en la tabla -->
    @foreach ($boletinesUnicos as $boletin)
        @php
            $boletin->Anio = date('m-Y', strtotime($boletin->Anio));

            if($boletin->Jerarquia == 0){
                $boletin->Jerarquia = "Autor";
            }else if($boletin->Jerarquia != 0){
                $boletin->Jerarquia = "Coautor";
            }
        @endphp
        <tr>
            <td style='text-align: center; vertical-align: middle;'>{{ $boletin->Anio }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $boletin->NoBoletin }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $boletin->NoArticulo }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $boletin->ArticuloTitulo }}</td>
            <td style='text-align: center; vertical-align: middle;'>{{ $boletin->Jerarquia }}</td>
        </tr>
    @endforeach
    </tbody>
</table>



    </body>
</html>
@stop
@push('scripts')
<script src="{{ asset('js/boletines.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
