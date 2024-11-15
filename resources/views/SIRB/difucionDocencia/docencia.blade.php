@extends('plantillas/plantillaresp')
@section('contenido')

<title>Docencia</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Cursos Impartidos </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/docencia.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para una nueva Docencia/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold; width:1250px; height: 620px">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nuevo curso impartido</h1>
        <br>
        <form action="{{route('nuevadocencia')}}" method="POST">
          @csrf

          <div class="container">

            <div class="row" hidden>
                <div class="col-md-6 ">
                  <div class="mb-3">
                    <label class="form-label">Nombre del docente</label>
                        <input id="encargadoservicio" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                  </div>
                </div>
            </div>

            <div class="col-md-6 " hidden>
                <div class="mb-3">
                    <label class="form-label">Area</label>
                    <input id="areaActividad" class="form-control" name="areaActividad" value="{{$LoggedUserInfo['idarea']}}" required readonly>
                </div>
            </div>

            <div class="row">
            <div class="col-md-6"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input id="titulodocencia" class="form-control" name="titulodocencia" placeholder="Título" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Institución donde se impartió</label>
                  <input id="D_perteneciente" class="form-control" name="D_perteneciente" placeholder="Título" required>
                  {{-- <select name="D_perteneciente" id="D_perteneciente" class="form-control" style="height: 47px;" required>
                    @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel3 }}
                        </option>
                    @endforeach --}}
                  </select>
                </div>
              </div>
            </div>



            <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Lugar</label>
                  <input id="lugar" type="text" class="form-control" name="lugar" placeholder="Lugar" required>
                </div>
              </div>

                <div class="col-md-6">
                  <div class="mb-3">
                      <label class="form-label bold" for="fechaponente">Duración neta (horas) </label>
                      <input id="duracion" type="text" class="form-control" name="duracion" placeholder="Duración" required pattern="[0-9]+" title="Ingrese solo números">
                    </div>
                  </div>
                </div>


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fechainicio">Fecha de inicio</label>
                  <input id="fechainicio" type="date" class="form-control" name="fechainicio" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fechafin">Fecha de fin</label>
                  <input id="fechafin" type="date" class="form-control" name="fechafin" required disabled>
                </div>
              </div>
            </div>

                <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">

              </div>

          <br>
          <br>
          <div>
            <button type="button" class="btn btn-danger" id="cancel-button" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
            <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold;"><i class="bi bi-plus-circle"></i>Agregar</button>
          </div>

        </form>
      </div>
    </div>
</div>










<!--///////////////////////modal para editar la Docencia/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold; width:1250px; height: 620px"">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar curso impartido</h1>
      <br>
      <form action="" id="editarForm">
          @csrf

          @method('PUT')

          <div class="container">

            <div class="row" hidden>
                <div class="col-md-6 ">
                  <div class="mb-3">
                    <label class="form-label">Nombre del docente</label>
                    <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                  </div>
                </div>
               </div>

            <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input id="titulodocenciaedit" class="form-control" name="titulodocencia" placeholder="Título" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Institución donde se impartio</label>
                  <input id="D_pertenecienteedit" class="form-control" name="D_perteneciente" placeholder="Título" required>
                  {{-- <select name="D_perteneciente" id="D_pertenecienteedit" class="form-control" style="height: 47px;" required>
                    @foreach ($Cliente as $Clientes)
                    <option value="{{ $Clientes->nivel3 }}">
                       {{ $Clientes->nivel3 }}
                    </option>
                    @endforeach --}}
                  </select>
                </div>
              </div>
            </div>



            <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Lugar</label>
                  <input id="lugaredit" type="text" class="form-control" name="lugar" placeholder="Lugar" required>
                </div>
              </div>

                <div class="col-md-6">
                  <div class="mb-3">
                      <label class="form-label bold" for="fechaponente">Duración neta (horas)</label>
                      <input id="duracionedit" type="text" class="form-control" name="duracion" placeholder="Duración" required pattern="[0-9]+" title="Ingrese solo números">
                    </div>
                  </div>
                </div>


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fechainicio">Fecha de inicio</label>
                  <input id="fechainicioedit" type="date" class="form-control" name="fechainicio" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fechafin">Fecha de fin</label>
                  <input id="fechafinedit" type="date" class="form-control" name="fechafin" required>
                </div>
              </div>
            </div>

                <input id="nombre_personaedit" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">

              </div>

          <div>
            <button type="button" class="btn btn-danger" id="cancel-button-editar" style=" color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
            <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Actualizar</button>
          </div>

        </form>
    </div>
  </div>
</div>









<!--///////////////////////modal para eliminar la Docencia/////////////////////// -->
<div id="modal-container-eliminar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">¿Desea eliminar este evento?</h1>
      <br><br>
      <form action="" id="elimFormR">
        @csrf

        @method('DELETE')

        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color:#007BFF; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>No, regresar</button>
          <button type="submit" class="btn btn-primary" style="background-color: #FF0000; font-weight: bold;"><i class="bi bi-check-lg"></i>Si, eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>










<!--///////////////////////modal para ver toda la informacion de la Docencia/////////////////////// -->
<div id="modal-container-vizualizar">
<div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF;">
        <div class="modal-header" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información del curso impartido</h5>
          </div>

          <div class="modal-body">
            <div class="row" hidden>
                <div class="col-md-6 ">
                    <div class="mb-3">
                        <label class="form-label">Nombre del docente</label>
                        <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                    <div class="mb-3">
                      <label class="form-label">Título</label>
                      <p type="text" class="form-control" id="titulocursoviz" readonly></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Institución donde se impartió</label>
                      <p type="text" class="form-control" id="organizadoraviz" readonly></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Lugar</label>
                      <p type="text" class="form-control" id="lugarviz" readonly></p>
                    </div>
                  </div>

                    <div class="col-md-6">
                      <div class="mb-3">
                          <label class="form-label bold" for="fechaponente">Duración neta (horas) </label>
                          <p type="text" class="form-control" id="duracioncursoviz" readonly></p>
                        </div>
                      </div>
                    </div>


                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label bold" for="fechainicio">Fecha de inicio</label>
                      <p class="form-control" id="fechainicioviz" readonly></p>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label bold" for="fechafin">Fecha de fin</label>
                      <p class="form-control" id="fechafinviz" readonly></p>
                    </div>
                  </div>
                </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cancel-button-vizualizar"><i class='bx bxs-tag-x bx-fw bx-flashing-hover' readonly></i> Volver</button>
              </div>
          </div>
  </div>
</div>
</div>






<input type="hidden" id="sesionEspecial" data-sesion-especial="{{ $sesionEspecial }}" value="{{ $sesionEspecial }}">

<!--///////////////////////Boton para una nueva docencia/////////////////////// -->
@php
      $currentBimester = $fechabimestre2->bimestre;
      $previousBimester = "";

      switch ($currentBimester) {
        case "Enero-Febrero":
            $previousBimester = "Noviembre-Diciembre";
          break;
        case "Marzo-Abril":
            $previousBimester = "Enero-Febrero";
          break;
        case "Mayo-Junio":
            $previousBimester = "Marzo-Abril";
          break;
        case "Julio-Agosto":
            $previousBimester = "Mayo-Junio";
          break;
        case "Septiembre-Octubre":
            $previousBimester = "Julio-Agosto";
          break;
        case "Noviembre-Diciembre":
            $previousBimester = "Septiembre-Octubre";
          break;
          }


@endphp
@if ($sesionEspecial == 1)
@if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)
<div class="content">
  <div class="">
    <div id="five" class="button"><button> <i class="bi bi-plus-circle"></i> Nuevo </button></div>
  </div>
</div>
@endif
@else
@if ($fechabimestre->bimestre === $fechabimestre2->bimestre)
<div class="content">
  <div class="">
    <div id="five" class="button"><button> <i class="bi bi-plus-circle"></i> Nuevo </button></div>
  </div>
</div>
@endif
@endif

<div>
    <p style="text-align: center; font-size: 1.2rem;"><strong>Periodo consultado:</strong> {{ $periodoConsultado }}</p>
</div>

@if ($sesionEspecial == 1)
<div>
    <p style="text-align: center; font-size: 1.2rem;"><strong>Sesión Especial Activa</strong></p>
</div>
@endif







<!--///////////////////////Tabla con el contenido/////////////////////// -->
<table class="table" id="solicitudesTable">
  <thead class="thead-light">
    <tr>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Info</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Título del curso</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Lugar</th>
        @php
        $thMostrado = false; // Inicializamos la variable de bandera como falsa
        @endphp
        @foreach($docencias as $docencia)
        @php
              $fechadocencia = $docencia->fecha_fin; // Obtener la fecha de la reunión en formato Y-m-d
              $mesdocencia = date("n", strtotime($fechadocencia)); // Obtener el número de mes

              // Determinar el bimestre correspondiente
              $bimestres = [
                  1 => "Enero-Febrero",
                  2 => "Enero-Febrero",
                  3 => "Marzo-Abril",
                  4 => "Marzo-Abril",
                  5 => "Mayo-Junio",
                  6 => "Mayo-Junio",
                  7 => "Julio-Agosto",
                  8 => "Julio-Agosto",
                  9 => "Septiembre-Octubre",
                  10 => "Septiembre-Octubre",
                  11 => "Noviembre-Diciembre",
                  12 => "Noviembre-Diciembre",
              ];

              $bimestredocencia = $bimestres[$mesdocencia] ?? ''; // Obtener el bimestre correspondiente
          @endphp
          @if ($sesionEspecial == 1)
            @php
                $currentBimester = $fechabimestre2->bimestre;
                $previousBimester = "";

                switch ($currentBimester) {
                    case "Enero-Febrero":
                        $previousBimester = "Noviembre-Diciembre";
                        break;
                    case "Marzo-Abril":
                        $previousBimester = "Enero-Febrero";
                        break;
                    case "Mayo-Junio":
                        $previousBimester = "Marzo-Abril";
                        break;
                    case "Julio-Agosto":
                        $previousBimester = "Mayo-Junio";
                        break;
                    case "Septiembre-Octubre":
                        $previousBimester = "Julio-Agosto";
                        break;
                    case "Noviembre-Diciembre":
                        $previousBimester = "Septiembre-Octubre";
                        break;
                }
            @endphp
            @if ($bimestredocencia == $currentBimester && !$thMostrado || $bimestredocencia == $previousBimester && !$thMostrado)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;'>Acciones</th>
        @php
            $thMostrado = true; // Actualizamos la variable de bandera como verdadera
        @endphp
        @endif
        @else
        @php
            $currentBimester = $fechabimestre2->bimestre;
            $previousBimester = "";

            switch ($currentBimester) {
                case "Enero-Febrero":
                    $previousBimester = "Noviembre-Diciembre";
                    break;
                case "Marzo-Abril":
                    $previousBimester = "Enero-Febrero";
                    break;
                case "Mayo-Junio":
                    $previousBimester = "Marzo-Abril";
                    break;
                case "Julio-Agosto":
                    $previousBimester = "Mayo-Junio";
                    break;
                case "Septiembre-Octubre":
                    $previousBimester = "Julio-Agosto";
                    break;
                case "Noviembre-Diciembre":
                    $previousBimester = "Septiembre-Octubre";
                    break;
            }
        @endphp
        @if ($bimestredocencia == $currentBimester && !$thMostrado)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;'>Acciones</th>
        @php
            $thMostrado = true; // Actualizamos la variable de bandera como verdadera
        @endphp
        @endif
        @endif
        @endforeach
    </tr>
  </thead>
  <tbody>

  @foreach($docencias as $docencia)
  @php
        $fechadocencia = $docencia->fecha_fin; // Obtener la fecha de la reunión en formato Y-m-d
        $mesdocencia = date("n", strtotime($fechadocencia)); // Obtener el número de mes

        // Determinar el bimestre correspondiente
        $bimestres = [
            1 => "Enero-Febrero",
            2 => "Enero-Febrero",
            3 => "Marzo-Abril",
            4 => "Marzo-Abril",
            5 => "Mayo-Junio",
            6 => "Mayo-Junio",
            7 => "Julio-Agosto",
            8 => "Julio-Agosto",
            9 => "Septiembre-Octubre",
            10 => "Septiembre-Octubre",
            11 => "Noviembre-Diciembre",
            12 => "Noviembre-Diciembre",
        ];

        $bimestredocencia = $bimestres[$mesdocencia] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
            data-id="{{ $docencia->id }}"
            data-titulocurso="{{ $docencia->titulo_curso }}"
            data-fechainicio="{{ $docencia->fecha_inicio }}"
            data-fechafin="{{ $docencia->fecha_fin }}"
            data-duracioncurso="{{ $docencia->duracion_curso }}"
            data-institucion="{{ $docencia->institucion_impartio }}"
            data-lugar="{{ $docencia->lugar }}"
            data-encargado="{{ $docencia->encargado }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $docencia->fecha_fin }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $docencia->titulo_curso     }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $docencia->lugar }}</td>
        @if ($sesionEspecial == 1)
        @php
            $currentBimester = $fechabimestre2->bimestre;
            $previousBimester = "";

            switch ($currentBimester) {
                case "Enero-Febrero":
                    $previousBimester = "Noviembre-Diciembre";
                    break;
                case "Marzo-Abril":
                    $previousBimester = "Enero-Febrero";
                    break;
                case "Mayo-Junio":
                    $previousBimester = "Marzo-Abril";
                    break;
                case "Julio-Agosto":
                    $previousBimester = "Mayo-Junio";
                    break;
                case "Septiembre-Octubre":
                    $previousBimester = "Julio-Agosto";
                    break;
                case "Noviembre-Diciembre":
                    $previousBimester = "Septiembre-Octubre";
                    break;
            }
        @endphp
        @if ($bimestredocencia == $currentBimester || $bimestredocencia == $previousBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
                data-id="{{ $docencia->id }}"
                data-titulocurso="{{ $docencia->titulo_curso }}"
                data-fechainicio="{{ $docencia->fecha_inicio }}"
                data-fechafin="{{ $docencia->fecha_fin }}"
                data-duracioncurso="{{ $docencia->duracion_curso }}"
                data-institucion="{{ $docencia->institucion_impartio }}"
                data-lugar="{{ $docencia->lugar }}"
                data-action="{{ route('docenciaEditar', $docencia->id) }}">
                <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimRe"
              data-idelimre="{{ route('docenciaEliminar', $docencia->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @else
        @php
            $currentBimester = $fechabimestre2->bimestre;
            $previousBimester = "";

            switch ($currentBimester) {
                case "Enero-Febrero":
                    $previousBimester = "Noviembre-Diciembre";
                    break;
                case "Marzo-Abril":
                    $previousBimester = "Enero-Febrero";
                    break;
                case "Mayo-Junio":
                    $previousBimester = "Marzo-Abril";
                    break;
                case "Julio-Agosto":
                    $previousBimester = "Mayo-Junio";
                    break;
                case "Septiembre-Octubre":
                    $previousBimester = "Julio-Agosto";
                    break;
                case "Noviembre-Diciembre":
                    $previousBimester = "Septiembre-Octubre";
                    break;
            }
        @endphp
        @if ($bimestredocencia == $currentBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
                data-id="{{ $docencia->id }}"
                data-titulocurso="{{ $docencia->titulo_curso }}"
                data-fechainicio="{{ $docencia->fecha_inicio }}"
                data-fechafin="{{ $docencia->fecha_fin }}"
                data-duracioncurso="{{ $docencia->duracion_curso }}"
                data-institucion="{{ $docencia->institucion_impartio }}"
                data-lugar="{{ $docencia->lugar }}"
                data-action="{{ route('docenciaEditar', $docencia->id) }}">
                <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimRe"
              data-idelimre="{{ route('docenciaEliminar', $docencia->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
    @endforeach

  </tbody>
</table>

    </body>
</html>


@stop
@push('scripts')
<script src="{{ asset('js/docencia.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
