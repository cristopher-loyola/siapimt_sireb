@extends('plantillas/plantillaresp')
@section('contenido')

<title>Tesis</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Tesis </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/tesis.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para una nueva tesis/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nueva tesis</h1>
        <br>
        <form action="{{route('nuevotesis')}}" method="POST">
          @csrf

          <div class="container">
            <div class="row">

                <div class="col-md-6 ">
                    <div class="mb-3">
                      <label class="form-label">Director de tesis</label>
                      <input id="encargadoservicio" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                    </div>
                  </div>

                  <div class="col-md-6 " hidden>
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <input id="areaActividad" class="form-control" name="areaActividad" value="{{$LoggedUserInfo['idarea']}}" required readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Título de la tesis</label>
                    <input id="nombretesis" type="text" class="form-control" name="nombretesis" placeholder="Título de la tesis" required>
                    </div>
                </div>

                <div class="col-md-6" hidden>
                    <div class="mb-3">
                    <label class="form-label">Nombre del estudiante</label>
                    <input id="nombre_estudiante" type="text" class="form-control" name="nombre_estudiante" value="{{ $LoggedUserInfo['usuario']}}" required readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nombre del estudiante</label>
                    <input id="estudiante" type="text" class="form-control" name="estudiante" placeholder="Nombre del estudiante" required>
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
                    <label class="form-label bold" for="fechafin">Fecha tentativa de titulación</label>
                    <input id="fechatitulacion" type="date" class="form-control" name="fechatitulacion" required disabled>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Institución</label>
                    <select name="D_perteneciente" id="D_perteneciente" class="form-control" style="height: 47px;" required>
                        <option value="" hidden>Seleccione una dependencia o institución</option>
                        @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel3 }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Facultad</label>
                    <input id="facultad" type="text" class="form-control" name="facultad" placeholder="Nombre de la Facultad" required>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nombre completo de la especialidad</label>
                    <input id="nombreespecialidad" type="text" class="form-control" name="nombreespecialidad" placeholder="Nombre completo de la especialidad" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Participación</label>
                    <select name="participacion" id="participacion" class="form-control" style="height: 47px;" required>
                        <option value="" disabled selected>Seleccione el tipo de participación</option>
                        <option value="Director(a) de tesis">Director(a) de tesis</option>
                        <option value="Sinodal">Sinodal</option>
                        <option value="Codirector(a)">Codirector(a)</option>
                    </select>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Grado</label>
                    <select name="grado" id="grado" class="form-control" style="height: 47px;" required>
                        <option value="" disabled selected>Seleccione el grado</option>
                        <option value="Doctorado">Doctorado</option>
                        <option value="Maestria">Maestria</option>
                        <option value="Licenciatura">Licenciatura</option>
                    </select>
                    </div>
                </div>

                {{-- <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-control" style="height: 47px;" required>
                            <option value="En desarrollo">En desarrollo</option>
                            <option value="Terminada">Terminada</option>
                            <option value="Suspendida">Suspendida</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                </div> --}}
                <div class="col-md-6"> <div class=“mb-3”> <label class="form-label">Estado</label> <select name="estado" id="estado" class="form-control" style="height: 47px;" required> <option value="En desarrollo" selected>En desarrollo</option> </select> </div> </div>
                </div>
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












<!--///////////////////////modal para editar el curso/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar tesis</h1>
      <br>
      <form action="" id="editarForm">
            @csrf

            @method('PUT')

            <div class="container">
            <div class="row">

                <div class="col-md-6 ">
                    <div class="mb-3">
                      <label class="form-label">Director de tesis</label>
                      <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                    </div>
                  </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Título de la tesis</label>
                    <input id="nombretesisedit" type="text" class="form-control" name="nombretesis" placeholder="Título de la tesis" required>
                    </div>
                </div>

                <div class="col-md-6" hidden>
                    <div class="mb-3">
                    <label class="form-label">Nombre del estudiante</label>
                    <input id="nombre_estudianteedit" type="text" class="form-control" name="nombre_estudiante" value="{{ $LoggedUserInfo['usuario']}}" required readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nombre del estudiante</label>
                    <input id="estudianteedit" type="text" class="form-control" name="estudiante" placeholder="Nombre del estudiante" required>
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
                    <label class="form-label bold" for="fechatitulacion">Fecha tentativa de titulación</label>
                    <input id="fechatitulacionedit" type="date" class="form-control" name="fechatitulacion" required>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Institución</label>
                    <select name="D_perteneciente" id="D_pertenecienteedit" class="form-control" style="height: 47px;" required>
                        <option value="" hidden>Seleccione una dependencia o institución</option>
                        @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel3 }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Facultad</label>
                    <input id="facultadedit" type="text" class="form-control" name="facultad" value="Facultad" placeholder="Nombre de la Facultad" required>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nombre completo de la especialidad</label>
                    <input id="nombreespecialidadedit" type="text" class="form-control" name="nombreespecialidad" placeholder="Nombre completo de la especialidad" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Participación</label>
                    <select name="participacion" id="participacionedit" class="form-control" style="height: 47px;" required>
                        <option value="" disabled selected>Seleccione el grado</option>
                        <option value="Director(a) de tesis">Director(a) de tesis</option>
                        <option value="Sinodal">Sinodal</option>
                        <option value="Codirector(a)">Codirector(a)</option>
                    </select>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Grado</label>
                    <select name="grado" id="gradoedit" class="form-control" style="height: 47px;" required>
                        <option value="" disabled selected>Seleccione el grado</option>
                        <option value="Doctorado">Doctorado</option>
                        <option value="Maestria">Maestria</option>
                        <option value="Licenciatura">Licenciatura</option>
                    </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" id="estadoedit" class="form-control" style="height: 47px;" required>
                            <option value="" disabled selected>Seleccione el estado</option>
                            <option value="En desarrollo">En desarrollo</option>
                            <option value="Terminada">Terminada</option>
                            <option value="Suspendida">Suspendida</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                </div>
                </div>
            </div>


              <br>
              <br>
              <div>
                <button type="button" class="btn btn-danger" id="cancel-button-editar" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
                <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Actualizar</button>
              </div>

              </form>

    </div>
  </div>
</div>











<!--///////////////////////modal para eliminar el curso/////////////////////// -->
<div id="modal-container-eliminar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">¿Desea eliminar este evento?</h1>
      <br>
      <br>

      <form action="" id="elimFormP">
        @csrf

        @method('DELETE')

        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>No, regresar</button>
          <button type="submit" class="btn btn-primary" style="background-color: #FF0000; font-weight: bold;"><i class="bi bi-check-lg"></i>Sí, eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>














<!--///////////////////////modal para ver toda la informacion de la solicitud/////////////////////// -->
<div id="modal-container-vizualizar">
<div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF;">
        <div class="modal-header" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información de la tesis</h5>
          </div>

          <div class="modal-body">


            <div class="row">

                <div class="col-md-6 ">
                    <div class="mb-3">
                      <label class="form-label">Director de tesis</label>
                      <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
                    </div>
                  </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Título de la tesis</label>
                    <p type="text" class="form-control" id="nombretesisviz" readonly></p>
                </div>
                </div>

                <div class="col-md-6" hidden>
                    <div class="mb-3">
                    <label class="form-label">Nombre del estudiante</label>
                    <p class="form-control" id="nombre_estudianteviz" readonly></p>
                </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                    <label class="form-label">Nombre del estudiante</label>
                    <p type="text" class="form-control" id="estudianteviz" readonly></p>
                    </div>
                </div>
                </div>


                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label bold" for="fechainicio">Fecha de inicio</label>
                    <p type="text" class="form-control" id="fechainicioviz" readonly></p>
                </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label bold" for="fechafin">Fecha tentativa de titulación</label>
                    <p type="text" class="form-control" id="fechatitulacionviz" readonly></p>
                </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Institución</label>
                    <p class="form-control" id="institucionviz" readonly></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Facultad</label>
                    <p class="form-control" id="facultadviz" readonly></p>
                </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nombre completo de la especialidad</label>
                    <p class="form-control" id="nombreespecialidadviz" readonly></p>
                </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Participación</label>
                    <p type="text" class="form-control" id="participacionviz" readonly></p>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Grado</label>
                    <p class="form-control" id="gradoviz" readonly></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <p class="form-control" id="fasetesisviz" readonly></p>
                    </div>
                </div>
                </div>
            </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cancel-button-vizualizar"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i> Volver</button>
              </div>
          </div>
  </div>
</div>
</div>





<input type="hidden" id="sesionEspecial" data-sesion-especial="{{ $sesionEspecial }}" value="{{ $sesionEspecial }}">

<!--///////////////////////Boton para una nueva tesis/////////////////////// -->
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
<table class="table" id="postgradosTable">
<thead class="thead-light">
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
    <tr>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Info</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha de inicio</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Participación</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Grado</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Institución</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Facultad</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Título de la tesis</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Estatus</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha tentativa de Titulación</th>
        @if ($sesionEspecial == 1)
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;'>Acciones</th>
        @endif
        @else
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;'>Acciones</th>
        @endif
        @endif
    </tr>
</thead>
  <tbody>




  @foreach($tesis as $tesi)
  @php
    $fechainicio = $tesi->fecha_inicio;
    $fechafin = $tesi->fechaT_titulacion;
    $mesInicio = date("n", strtotime($fechainicio));
    $mesFin = date("n", strtotime($fechafin));

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

    $bimestreInicio = $bimestres[$mesInicio] ?? '';
    $bimestreFin = $bimestres[$mesFin] ?? '';

    $currentBimestre = $fechabimestre->bimestre;

    $bimestresCubiertos = [];

    $fechaInicio = strtotime($fechainicio);
    $fechaFin = strtotime($fechafin);

    while ($fechaInicio <= $fechaFin) {
        $mesActual = date("n", $fechaInicio);
        $bimestreActual = $bimestres[$mesActual] ?? '';

        if (!in_array($bimestreActual, $bimestresCubiertos)) {
            $bimestresCubiertos[] = $bimestreActual;
        }

        $fechaInicio = strtotime("+1 month", $fechaInicio);
    }


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

  @if (in_array($currentBimestre, $bimestresCubiertos))
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
            data-id="{{ $tesi->id }}"
            data-titulotesis="{{ $tesi->titulo_tesis }}"
            data-participacion="{{ $tesi->participacion }}"
            data-nombrealumno="{{ $tesi->nombre_alumno }}"
            data-encargado="{{ $tesi->encargado }}"
            data-nombreespecialidad="{{ $tesi->nombre_especialidad }}"
            data-facultad="{{ $tesi->facultad }}"
            data-gradot="{{ $tesi->grado }}"
            data-institucion="{{ $tesi->institucion }}"
            data-fechainicio="{{ $tesi->fecha_inicio }}"
            data-fechatitulacion="{{ $tesi->fechaT_titulacion }}"
            data-fasetesis="{{ $tesi->fase_tesis }}"
            data-estudiante="{{ $tesi->estudiante }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->fecha_inicio }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->participacion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->grado }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->institucion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->facultad }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->titulo_tesis }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->fase_tesis }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $tesi->fechaT_titulacion }}</td>

        @if ($sesionEspecial == 1)
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)

        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
            data-id="{{ $tesi->id }}"
            data-titulotesis="{{ $tesi->titulo_tesis }}"
            data-participacion="{{ $tesi->participacion }}"
            data-nombrealumno="{{ $tesi->nombre_alumno }}"
            data-encargado="{{ $tesi->encargado }}"
            data-nombreespecialidad="{{ $tesi->nombre_especialidad }}"
            data-facultad="{{ $tesi->facultad }}"
            data-grado="{{ $tesi->grado }}"
            data-institucion="{{ $tesi->institucion }}"
            data-fechainicio="{{ $tesi->fecha_inicio }}"
            data-fechatitulacion="{{ $tesi->fechaT_titulacion }}"
            data-fasetesis="{{ $tesi->fase_tesis }}"
            data-estudiante="{{ $tesi->estudiante }}"
                data-action="{{ route('tesisEditar', $tesi->id) }}">
                <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelimpost"
              data-idelim="{{ route('tesisEliminar', $tesi->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>

        @endif
        @else
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre)

        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
                data-id="{{ $tesi->id }}"
                data-titulotesis="{{ $tesi->titulo_tesis }}"
                data-participacion="{{ $tesi->participacion }}"
                data-nombrealumno="{{ $tesi->nombre_alumno }}"
                data-nombreespecialidad="{{ $tesi->nombre_especialidad }}"
                data-facultad="{{ $tesi->facultad }}"
                data-grado="{{ $tesi->grado }}"
                data-institucion="{{ $tesi->institucion }}"
                data-fechainicio="{{ $tesi->fecha_inicio }}"
                data-fechatitulacion="{{ $tesi->fechaT_titulacion }}"
                data-fasetesis="{{ $tesi->fase_tesis }}"
                data-estudiante="{{ $tesi->estudiante }}"
                data-action="{{ route('tesisEditar', $tesi->id) }}">
                <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelimpost"
              data-idelim="{{ route('tesisEliminar', $tesi->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
    @endif
  </tr>
  @endif
  @endforeach

  </tbody>
</table>


    </body>
</html>



@stop
@push('scripts')
<script src="{{ asset('js/tesis.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
