@extends('plantillas/plantillaresp')
@section('contenido')

<title>Cursos Recibidos</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Cursos Recibidos </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/cursosRecibidos.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para una nuevo curso/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nuevo curso recibido</h1>
        <br>
        <form action="{{route('nuevocursoRecibido')}}" method="POST">
          @csrf

          <div class="container">


          <div class="row">

            <div class="col-md-6 ">
                <div class="mb-3">
                  <label class="form-label">Nombre del participante</label>
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
                    <label class="form-label">Nombre del curso</label>
                    <input id="nombrecurso" type="text" class="form-control" name="nombrecurso" placeholder="Nombre del curso" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Duración (horas)</label>
                    <input id="duracion" type="text" class="form-control" name="duracion" placeholder="Horas" required pattern="[0-9]+" title="Ingrese solo números">
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
                    <input id="fechafin" type="date" class="form-control" name="fechafin" required>
                    </div>
                </div>
                </div>

                <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Institución Organizadora</label>
                    <input id="D_perteneciente" class="form-control" name="D_perteneciente" placeholder="Título" style="height: 47px;" required>
                    {{-- <select name="D_perteneciente" id="D_perteneciente" class="form-control"  required>
                        @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}
                        </option>
                        @endforeach
                    </select> --}}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Lugar</label>
                    <input id="lugar" type="text" class="form-control" name="lugar" placeholder="Lugar" required>
                    </div>
                </div>

                </div>

            <div class="col-md-6">
                <div class="mb-3">
                <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
                </div>
            </div>

            </div>


            <div class="container-select">
            <div class="left">
                <div class="mb-3">
                    <label class="form-label">Otros participantes</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar participantes">
                    <div class="select-container">
                        <select name="participantes[]" id="oprt" class="form-control">
                            <option value="">Seleccione los participantes</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">
                                    {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }} {{ $usuario->Nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="selected-box">
                    <label class="form-label">Participantes</label>
                    <ul id="selected-options-solicitudes">
                    </ul>
                    <div class="button-container">
                    <button type="button" id="remove-selected" class="btn btn-danger">Borrar seleccionados</button>
                    <button type="button" id="remove-all" class="btn btn-danger">Borrar todos</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="usuarios_seleccionados" id="usuarios_seleccionados">

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
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar curso recibido</h1>
      <br>
      <form action="" id="editarForm">
            @csrf

            @method('PUT')
            <div class="container">


              <div class="row">

                <div class="col-md-6 ">
                    <div class="mb-3">
                      <label class="form-label">Nombre del participante</label>
                      <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Nombre del curso</label>
                      <input id="nombrecursoedit" type="text" class="form-control" name="nombrecurso" placeholder="Nombre del curso" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Duración (horas)</label>
                      <input id="duracionedit" type="text" class="form-control" name="duracion" placeholder="Horas" required pattern="[0-9]+" title="Ingrese solo números">
                    </div>
                  </div>

                </div>



                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label bold" for="fechainicioedit">Fecha de inicio</label>
                      <input id="fechainicioedit" type="date" class="form-control" name="fechainicio" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label bold" for="fechafinedit">Fecha de fin</label>
                      <input id="fechafinedit" type="date" class="form-control" name="fechafin" required>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Institución Organizadora</label>
                      <input id="D_pertenecienteedit" class="form-control" name="D_perteneciente" placeholder="Título" style="height: 47px;" required>
                      {{-- <select name="D_perteneciente" id="D_pertenecienteedit" class="form-control" required>
                        @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}
                        </option>
                        @endforeach --}}
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Lugar</label>
                      <input id="lugaredit" type="text" class="form-control" name="lugar" placeholder="Lugar" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                </div>
                <div class="row">
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <input id="nombre_personaedit" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
                </div>
              </div>


              <div class="container-select-edit">
            <div class="left">
                <div class="mb-3">
                    <label class="form-label">Otros participantes</label>
                    <input type="text" id="searchInputedit" class="form-control" placeholder="Buscar participantes">
                    <div class="select-container-edit">
                        <select name="participantes[]" id="oprtedit" class="form-control">
                            <option value="">Seleccione los participantes</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" data-nombre="{{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }} {{ $usuario->Nombre }}">
                                    {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }} {{ $usuario->Nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="selected-box-edit">
                    <label class="form-label">Participantes seleccionados</label>
                    <ul id="selected-options-editar">
                    </ul>
                    <div class="button-container">
                    <button type="button" id="remove-selected-edit" class="btn btn-danger">Borrar seleccionados</button>
                    <button type="button" id="remove-all-edit" class="btn btn-danger">Borrar todos</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="usuarios_seleccionados" id="usuarios_seleccionadosedit">
        <input type="hidden" name="usuarios_seleccionadosMail" id="usuarios_seleccionadoseditMail">


              <br>
              <br>
              <div>
                <button type="button" class="btn btn-danger" id="cancel-button-editar" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
                <button type="submit" class="btn btn-warning"  style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Actualizar</button>
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

      <form action="" id="elimFormR">
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


<div id="modal-container-eliminar-relacion">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Eliminar mi participación de este evento</h1>
      <br><br>
      <form action="" id="eliminarForm">
        @csrf

        @method('DELETE')

        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-eliminar-relacion" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>No, regresar</button>
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
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información del curso recibido</h5>
          </div>

        <div class="modal-body">

            <div class="row">
                <div class="col-md-12" hidden >
                    <div class="mb-3">
                        <label class="form-label">Nombre del participante</label>
                        <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nombre del curso</label>
                    <p type="text" class="form-control" id="nombrecursoviz" readonly></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Duración (horas)</label>
                    <p type="text" class="form-control" id="duracioncursoviz" readonly></p>
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
                <label class="form-label bold" for="fechafin">Fecha de fin</label>
                <p type="text" class="form-control" id="fechafinviz" readonly></p>
                </div>
            </div>
            </div>

            <div class="row">

            <div class="col-md-6">
                <div class="mb-3">
                <label class="form-label">Institución Organizadora</label>
                <p class="form-control" id="organizadoraviz" readonly></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                <label class="form-label">Lugar</label>
                <p class="form-control" id="lugarviz" readonly></p>
                </div>
            </div>
          </div>

            <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label">Participantes:</label>
                    <pre type="text" class="form-control" id="selected-options-paragraph-editar" readonly></pre>
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

<!--///////////////////////Boton para un nuevo curso/////////////////////// -->
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
<table class="table" id="cursosRTable">
  <thead class="thead-light">
    <tr>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Info</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha de término</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Nombre del curso</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Duración (horas)</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Institución organizadora</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Lugar</th>
        @php
        $thMostrado = false; // Inicializamos la variable de bandera como falsa
        @endphp
        @php
        $cursosRetiqueta = $cursosR->merge($cursosRelacionados);
        @endphp
        @foreach($cursosRetiqueta as $cursos)
        @php
              $fechacursos = $cursos->fecha_fin; // Obtener la fecha de la reunión en formato Y-m-d
              $mescursos = date("n", strtotime($fechacursos)); // Obtener el número de mes

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

              $bimestrecursos = $bimestres[$mescursos] ?? ''; // Obtener el bimestre correspondiente
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
            @if ($bimestrecursos == $currentBimester && !$thMostrado || $bimestrecursos == $previousBimester && !$thMostrado)
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
        @if ($bimestrecursos == $currentBimester && !$thMostrado)
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

  @foreach($cursosR as $cursos)
  @php
        $fechacursos = $cursos->fecha_fin; // Obtener la fecha de la reunión en formato Y-m-d
        $mescursos = date("n", strtotime($fechacursos)); // Obtener el número de mes

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

        $bimestrecursos = $bimestres[$mescursos] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
            data-id="{{ $cursos->id }}"
            data-nombrecurso ="{{ $cursos->nombre_curso }}"
            data-fechainicio ="{{ $cursos->fecha_inicio }}"
            data-fechafin ="{{ $cursos->fecha_fin }}"
            data-duracioncurso ="{{ $cursos->duracion_curso }}"
            data-organizadora ="{{ $cursos->I_organizadora }}"
            data-lugar ="{{ $cursos->lugar }}"
            data-nombrepersona ="{{ $cursos->nombre_persona }}"
            data-encargado="{{ $cursos->encargado }}"
            data-usuariosseleccionados="{{ $cursos->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursos->fecha_fin }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursos->nombre_curso }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursos->duracion_curso }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursos->I_organizadora }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursos->lugar }}</td>
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
        @if ($bimestrecursos == $currentBimester || $bimestrecursos == $previousBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $cursos->id }}"
              data-nombrecurso ="{{ $cursos->nombre_curso }}"
              data-fechainicio ="{{ $cursos->fecha_inicio }}"
              data-fechafin ="{{ $cursos->fecha_fin }}"
              data-duracioncurso ="{{ $cursos->duracion_curso }}"
              data-organizadora ="{{ $cursos->I_organizadora }}"
              data-lugar ="{{ $cursos->lugar }}"
              data-nombrepersona ="{{ $cursos->nombre_persona }}"
              data-usuariosseleccionados="{{ $cursos->participantes }}"
              data-action="{{ route('cursoRecibidoEditar', $cursos->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimR"
              data-idelim="{{ route('cursoRecibidoEliminar', $cursos->id) }}">
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
        @if ($bimestrecursos == $currentBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $cursos->id }}"
              data-nombrecurso ="{{ $cursos->nombre_curso }}"
              data-fechainicio ="{{ $cursos->fecha_inicio }}"
              data-fechafin ="{{ $cursos->fecha_fin }}"
              data-duracioncurso ="{{ $cursos->duracion_curso }}"
              data-organizadora ="{{ $cursos->I_organizadora }}"
              data-lugar ="{{ $cursos->lugar }}"
              data-nombrepersona ="{{ $cursos->nombre_persona }}"
              data-usuariosseleccionados="{{ $cursos->participantes }}"
              data-action="{{ route('cursoRecibidoEditar', $cursos->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimR"
              data-idelim="{{ route('cursoRecibidoEliminar', $cursos->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
    @endforeach

    @foreach($cursosRelacionados as $cursosRelacionado)
    @php
        $fechacursos = $cursosRelacionado->fecha_fin; // Obtener la fecha de la reunión en formato Y-m-d
        $mescursos = date("n", strtotime($fechacursos)); // Obtener el número de mes

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

        $bimestrecursos = $bimestres[$mescursos] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
    <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
              data-id="{{ $cursosRelacionado->id }}"
              data-nombrecurso ="{{ $cursosRelacionado->nombre_curso }}"
              data-fechainicio ="{{ $cursosRelacionado->fecha_inicio }}"
              data-fechafin ="{{ $cursosRelacionado->fecha_fin }}"
              data-duracioncurso ="{{ $cursosRelacionado->duracion_curso }}"
              data-organizadora ="{{ $cursosRelacionado->I_organizadora }}"
              data-lugar ="{{ $cursosRelacionado->lugar }}"
              data-nombrepersona ="{{ $cursosRelacionado->nombre_persona }}"
              data-encargado="{{ $cursosRelacionado->encargado }}"
              data-usuariosseleccionados="{{ $cursosRelacionado->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursosRelacionado->fecha_fin }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursosRelacionado->nombre_curso }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursosRelacionado->duracion_curso }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursosRelacionado->I_organizadora }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $cursosRelacionado->lugar }}</td>
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
        @if ($bimestrecursos == $currentBimester || $bimestrecursos == $previousBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('cursoRecibidoEliminarR', $cursosRelacionado->id) }}">
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
        @if ($bimestrecursos == $currentBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('cursoRecibidoEliminarR', $cursosRelacionado->id) }}">
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
<script>
    const nombreCompletoUsuario = @json($nombreCompleto); // Convierte el valor PHP en un valor JavaScript
</script>
<script src="{{ asset('js/cursosRecibidos.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
<script>
  // Corre al final de TODO (después de cursosRecibidos.js y lo que empuje el layout)
  window.addEventListener('load', function () {
    const BIMESTRE_END = @json($bimestreEndDate) || '2099-12-31';

    const unlockDate = (start, end) => {
      if (!start || !end) return;

      // Quita cualquier candado previo
      ['min','max','readonly','disabled'].forEach(a => {
        start.removeAttribute(a);
        end.removeAttribute(a);
      });

      // Política: inicio puede ser bien atrás; fin topa en fin de bimestre
      start.setAttribute('min', '1900-01-01');
      start.setAttribute('max', BIMESTRE_END);
      end.setAttribute('max', BIMESTRE_END);

      // fin >= inicio
      start.addEventListener('change', (e) => {
        end.min = e.target.value || '1900-01-01';
        if (end.value && end.value < e.target.value) end.value = e.target.value;
      });

      // Si algún script intenta reimponer min/disabled, lo reventamos
      const obs = new MutationObserver(() => {
        if (start.getAttribute('min') !== '1900-01-01') start.setAttribute('min','1900-01-01');
        if (start.hasAttribute('disabled')) start.removeAttribute('disabled');
      });
      obs.observe(start, { attributes: true, attributeFilter: ['min','disabled']});
    };

    // Crear
    unlockDate(document.getElementById('fechainicio'), document.getElementById('fechafin'));
    // Editar
    unlockDate(document.getElementById('fechainicioedit'), document.getElementById('fechafinedit'));

    // Reaplica el unlock cuando abres el modal de "Nuevo"
    document.querySelector('#five button')?.addEventListener('click', () => {
      // espera a que el DOM del modal esté visible
      setTimeout(() => unlockDate(
        document.getElementById('fechainicio'),
        document.getElementById('fechafin')
      ), 0);
    });

    // Debug rápido
    const si = document.getElementById('fechainicio');
    console.debug('fechainicio => min:', si?.getAttribute('min'), 'max:', si?.getAttribute('max'));
  });
</script>


@endpush
