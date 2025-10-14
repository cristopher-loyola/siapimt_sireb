@extends('plantillas/plantillaresp')
@section('contenido')

<title>Otras Actividades</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Otras Actividades </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/otrasactividades.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para una nueva actividad/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nueva actividad</h1>
        <br>
        <form action="{{route('nuevaactividad')}}" method="POST">
          @csrf

          <div class="container">


            <div class="row">

                <div class="col-md-6 ">
                    <div class="mb-3">
                        <label class="form-label">Organizador</label>
                            <input id="encargadoservicio" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                    </div>
                </div>

                <div class="col-md-6 " hidden>
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <input id="areaActividad" class="form-control" name="areaActividad" value="{{$LoggedUserInfo['idarea']}}" required readonly>
                    </div>
                </div>

                <div class="col-md-6"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                    <div class="mb-3">
                    <label class="form-label">Actividad</label>
                    <input id="actividad" class="form-control" name="actividad" placeholder="Actividad" required>
                    </div>
                </div>
            </div>



            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Fecha</label>
                  <input id="fecha" type="date" class="form-control" name="fecha" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tipo</label>
                  <select name="tipoactividad" id="tipoactividad" class="form-control" style="height: 47px;" required>
                    <option value="" disabled selected>Seleccione el tipo de actividad</option>
                    <option value="Interna">Interna</option>
                    <option value="Externa">Externa</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                <div class="mb-3">
                  <label class="form-label">Descripción</label>
                  <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción de las actividades"  oninput="autoResizeTextarea(this)" style="overflow:hidden"  required></textarea>
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












<!--///////////////////////modal para editar/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar actividad</h1>
      <br>
      <form action="" id="editarForm">
            @csrf

            @method('PUT')
            <div class="container">


            <div class="row">
                <div class="col-md-6 ">
                    <div class="mb-3">
                      <label class="form-label">Organizador</label>
                      <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                    </div>
                </div>

                <div class="col-md-6"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                    <div class="mb-3">
                    <label class="form-label">Actividad</label>
                    <input id="actividadedit" class="form-control" name="actividad" placeholder="Actividad" required>
                    </div>
                </div>
                </div>



            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Fecha</label>
                  <input id="fechaedit" type="date" class="form-control" name="fecha" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tipo</label>
                  <select name="tipoactividad" id="tipoactividadedit" class="form-control" style="height: 47px;" required>
                    <option value="" disabled selected>Seleccione el tipo de actividad</option>
                    <option value="Interna">Interna</option>
                    <option value="Externa">Externa</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                <div class="mb-3">
                  <label class="form-label">Descripción</label>
                  <textarea id="descripcionedit" class="form-control" name="descripcion" placeholder="Descripción de las actividades"  oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
                </div>
              </div>
            </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <input id="nombre_personaedit" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
                </div>
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
                <button type="button" class="btn btn-danger" id="cancel-button-editar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
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










<!--///////////////////////modal para ver toda la informacion/////////////////////// -->
<div id="modal-container-vizualizar">
<div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF;">
        <div class="modal-header" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información de la actividad</h5>
          </div>

          <div class="modal-body">

            <div class="row">

                <div class="col-md-6 " hidden>
                    <div class="mb-3">
                        <label class="form-label">Organizador</label>
                        <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
                    </div>
                </div>

                <div class="col-md-6"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                    <div class="mb-3">
                    <label class="form-label">Actividad</label>
                    <p type="text" class="form-control" id="actividadviz" readonly></p>
                    </div>
                </div>
            </div>



            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Fecha</label>
                  <p type="text" class="form-control" id="fechaviz" readonly></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tipo</label>
                  <p type="text" class="form-control" id="tipoviz" readonly></p>
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


            <div class="row">
              <div class="col-md-12"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                <div class="mb-3">
                  <label class="form-label">Descripción</label>
                  <p type="text" class="form-control" id="descripcionviz" readonly></p>
                </div>
              </div>
            </div>

          <div class="col-md-6">
            <div class="mb-3">
              <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}" readonly>
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

<!--///////////////////////Boton para una nueva actividad/////////////////////// -->
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
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Actividad</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Tipo</th>
        @php
        $thMostrado = false; // Inicializamos la variable de bandera como falsa
        @endphp
        @php
        $otraactividaetiqueta = $otraactivida->merge($otraactividaRelacionados);
        @endphp
        @foreach($otraactividaetiqueta as $otraactividad)
        @php
              $fechaotraactividad = $otraactividad->fecha; // Obtener la fecha de la reunión en formato Y-m-d
              $mesotraactividad = date("n", strtotime($fechaotraactividad)); // Obtener el número de mes

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

              $bimestreotraactividad = $bimestres[$mesotraactividad] ?? ''; // Obtener el bimestre correspondiente
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
            @if ($bimestreotraactividad == $currentBimester && !$thMostrado || $bimestreotraactividad == $previousBimester && !$thMostrado)
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
        @if ($bimestreotraactividad == $currentBimester && !$thMostrado)
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

  @foreach($otraactivida as $otraactividad)
  @php
        $fechaotraactividad = $otraactividad->fecha; // Obtener la fecha de la reunión en formato Y-m-d
        $mesotraactividad = date("n", strtotime($fechaotraactividad)); // Obtener el número de mes

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

        $bimestreotraactividad = $bimestres[$mesotraactividad] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
            data-id="{{ $otraactividad->id }}"
            data-nombreactividad ="{{ $otraactividad->nombre_actividad }}"
            data-fecha ="{{ $otraactividad->fecha }}"
            data-tipoactividad ="{{ $otraactividad->tipo_actividad }}"
            data-descripcion ="{{ $otraactividad->descripcion }}"
            data-nombrepersona ="{{ $otraactividad->nombre_persona }}"
            data-encargado="{{ $otraactividad->encargado }}"
            data-usuariosseleccionados="{{ $otraactividad->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $otraactividad->fecha }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $otraactividad->nombre_actividad }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $otraactividad->tipo_actividad }}</td>
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
        @if ($bimestreotraactividad == $currentBimester || $bimestreotraactividad == $previousBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $otraactividad->id }}"
              data-nombreactividad ="{{ $otraactividad->nombre_actividad }}"
              data-fecha ="{{ $otraactividad->fecha }}"
              data-tipoactividad ="{{ $otraactividad->tipo_actividad }}"
              data-descripcion ="{{ $otraactividad->descripcion }}"
              data-nombrepersona ="{{ $otraactividad->nombre_persona }}"
              data-usuariosseleccionados="{{ $otraactividad->participantes }}"
              data-action="{{ route('actividadEditar', $otraactividad->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimR"
              data-idelim="{{ route('actividadEliminar', $otraactividad->id) }}">
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
        @if ($bimestreotraactividad == $currentBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $otraactividad->id }}"
              data-nombreactividad ="{{ $otraactividad->nombre_actividad }}"
              data-fecha ="{{ $otraactividad->fecha }}"
              data-tipoactividad ="{{ $otraactividad->tipo_actividad }}"
              data-descripcion ="{{ $otraactividad->descripcion }}"
              data-nombrepersona ="{{ $otraactividad->nombre_persona }}"
              data-usuariosseleccionados="{{ $otraactividad->participantes }}"
              data-action="{{ route('actividadEditar', $otraactividad->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimR"
              data-idelim="{{ route('actividadEliminar', $otraactividad->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
    @endforeach

    @foreach($otraactividaRelacionados as $otraactividaRelacionado)
    @php
        $fechaotraactividad = $otraactividaRelacionado->fecha; // Obtener la fecha de la reunión en formato Y-m-d
        $mesotraactividad = date("n", strtotime($fechaotraactividad)); // Obtener el número de mes

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

        $bimestreotraactividad = $bimestres[$mesotraactividad] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
    <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
              data-id="{{ $otraactividaRelacionado->id }}"
              data-nombreactividad ="{{ $otraactividaRelacionado->nombre_actividad }}"
              data-fecha ="{{ $otraactividaRelacionado->fecha }}"
              data-tipoactividad ="{{ $otraactividaRelacionado->tipo_actividad }}"
              data-descripcion ="{{ $otraactividaRelacionado->descripcion }}"
              data-nombrepersona ="{{ $otraactividaRelacionado->nombre_persona }}"
              data-encargado="{{ $otraactividaRelacionado->encargado }}"
              data-usuariosseleccionados="{{ $otraactividaRelacionado->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $otraactividaRelacionado->fecha }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $otraactividaRelacionado->nombre_actividad }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $otraactividaRelacionado->tipo_actividad }}</td>
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
        @if ($bimestreotraactividad == $currentBimester || $bimestreotraactividad == $previousBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('actividadEliminarR', $otraactividaRelacionado->id) }}">
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
        @if ($bimestreotraactividad == $currentBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('actividadEliminarR', $otraactividaRelacionado->id) }}">
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
{{-- ESTOS DOS PRIMEROS SE QUEDAN IGUAL --}}
<script>
    const nombreCompletoUsuario = @json($nombreCompleto);
</script>
<script src="{{ asset('js/otrasactividades.js') }}"></script>

{{-- EL BLOQUE PHP TAMBIÉN SE QUEDA IGUAL --}}
@php
  $usersMap = [];
  foreach ($usuarios as $u) {
      $usersMap[$u->id] = trim($u->Apellido_Paterno.' '.$u->Apellido_Materno.' '.$u->Nombre);
  }
@endphp
<script>
    // Hacemos que el mapa de usuarios de PHP esté disponible en JavaScript
    const usersMap = @json($usersMap);

    document.addEventListener('click', function (ev) {
        const btn = ev.target.closest('#btnviz');
        if (!btn) return;

        const participantesEl = document.getElementById('selected-options-paragraph-editar');
        if (!participantesEl) return;

        const encargado = (btn.getAttribute('data-encargado') || '').trim();
        let raw = (btn.getAttribute('data-usuariosseleccionados') || '').trim();
        let items = []; // Aquí guardaremos los IDs de los participantes

        try {
            const maybe = JSON.parse(raw);
            if (Array.isArray(maybe)) items = maybe.map(String);
        } catch (_) {
            items = raw
                .replace(/\r/g, '')
                .split(/\n|,|;|•/g)
                .map(s => s.trim())
                .filter(Boolean);
        }

        const final = [];
        const seen = new Set();

        if (encargado && !seen.has(normaliza(encargado))) {
            final.push(encargado);
            seen.add(normaliza(encargado));
        }

        // Bucle para "traducir" cada ID a su nombre completo usando el mapa
        for (const id of items) {
            const participantName = usersMap[id.trim()] || `Usuario (ID: ${id})`; // Busca el nombre
            const normalizedName = normaliza(participantName);
            if (!seen.has(normalizedName)) {
                seen.add(normalizedName);
                final.push(participantName); // Agrega el NOMBRE a la lista final
            }
        }

        // Renderizamos la lista final con los NOMBRES
        participantesEl.innerHTML = final
            .map((p, i) => i === 0 ? '<strong>' + escapeHtml(p) + '</strong>' : escapeHtml(p))
            .join('\n');
    });

    function normaliza(s) {
        return String(s).normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    }

    function escapeHtml(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
</script>
@endpush

