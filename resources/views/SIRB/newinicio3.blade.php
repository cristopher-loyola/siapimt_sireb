@extends('plantillas/incioresaltado')
@section('contenido')

<title>Inicio</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
        <h2 class="text-center" id="title">¡Buen día, {{ $FullName }}!</h2>


        <br><br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/inicioreporte.css') }}">

</head>
<body>

<div>
    <p style="text-align: center; font-size: 1.2rem;"><strong>Periodo consultado:</strong> {{ $periodoConsultado }}</p>
</div>
<br>

<button onclick="mostrarContenido()" class="btn btn-primary" style="font-size: 1.5rem; text-align: center; margin: 0 auto; display: block;">Cambiar periodo</button>
<br>
<div id="contenido" style="display: none;">
    <div class="container-xl">
        <form action="{{ route('editarfecha', $userID) }}" method="POST" id="bimestrefechoso">
            @csrf
            @method('PUT')

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4">
                        <div class="card-body">
                            <h2 class="text-center mb-4">Periodo Consultado</h2>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-6 input-wrapperI">
                                    <label for="slct1" style="color: #007BFF; font-weight: bold;">Año:</label>
                                    <select class="form-control" name="slct1" id="slct1">
                                        <option value="2023">2023</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6 input-wrapperI">
                                    <label for="slct2" style="color: #007BFF; font-weight: bold;">Bimestre:</label>
                                    <select class="form-control" name="slct2" id="slct2">
                                        <option value= "{{ $fechabimestre->bimestre }}"> {{ $fechabimestre->bimestre }}</option>
                                        <option value="Enero-Febrero">Enero-Febrero</option>
                                        <option value="Marzo-Abril">Marzo-Abril</option>
                                        <option value="Mayo-Junio">Mayo-Junio</option>
                                        <option value="Julio-Agosto">Julio-Agosto</option>
                                        <option value="Septiembre-Octubre">Septiembre-Octubre</option>
                                        <option value="Noviembre-Diciembre">Noviembre-Diciembre</option>
                                    </select>
                                </div>


                            </div>


                            <div class="form-row">
                            <div class="form-group col-md-6">
                            <input type="hidden" name="slct3" id="slct3">
                            </div>
                                <div class="form-group col-md-6">
                                    <select name="slct4" id="slct4" hidden>
                                        <option value="Enero-Febrero">Enero-Febrero</option>
                                        <option value="Marzo-Abril">Marzo-Abril</option>
                                        <option value="Mayo-Junio">Mayo-Junio</option>
                                        <option value="Julio-Agosto">Julio-Agosto</option>
                                        <option value="Septiembre-Octubre">Septiembre-Octubre</option>
                                        <option value="Noviembre-Diciembre">Noviembre-Diciembre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mt-4 text-right"> <!-- Cambiamos la alineación a la derecha -->
                                <button type="submit" class="btn btn-primary btn-md">Cambiar</button> <!-- Usamos btn-md para tamaño medio -->
                                <!-- <button type="submit" class="btn btn-primary btn-md">Cambiar al actual</button> Usamos btn-md para tamaño medio -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

    </body>
</html>



@stop
@push('scripts')
<script src="{{ asset('js/inicioreporte.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
