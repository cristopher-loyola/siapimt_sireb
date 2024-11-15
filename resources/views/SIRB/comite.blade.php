@extends('plantillas/plantillaresp')
@section('contenido')

<title>Comites</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Comités </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/comites.css') }}">
</head>
    <body>



<!--///////////////////////modal para un nuevo comite/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nuevo comité</h1>
        <br>
        <form action="{{ route('nuevocomite') }}" method="POST">
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
                  <label class="form-label" for="tipo_solicitud">Comité</label>
                  <select name="nombre_comite" id="nombre_comite" class="form-control" style="height: 47px;" required>
                    <option value="" disabled selected>Seleccione el comité</option>
                    @foreach ($comitesAdmin as $comitesAdmins)
                      <option value="{{ $comitesAdmins->nombre }}">
                        {{ $comitesAdmins->nombre }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Dependencia de vinculación</label>
                  <select name="dependencia_V" id="dependencia_V" class="form-control" style="height: 47px;" required>
                    @foreach ($Cliente as $Clientes)
                    <option value="{{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}">
                        {{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Cargo</label>
                  <input id="cargo_comite" type="text" class="form-control" name="cargo_comite" placeholder="Cargo" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Actividades desarrolladas</label>
                  <textarea id="A_desarrolladas" class="form-control" name="A_desarrolladas" placeholder="Actividades desarrolladas" oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario'] }}">
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
            <div>
              <button type="button" class="btn btn-danger" id="cancel-button" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
              <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold;"><i class="bi bi-plus-circle"></i>Agregar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>







<!--///////////////////////modal para editar el comite/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar comité</h1>
      <br>
      <form action="" id="editarForm">
          @csrf

          @method('PUT')

            <div class="row">
                <div class="col-md-6 ">
                <div class="mb-3">
                    <label class="form-label">Nombre del participante</label>
                    <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label bold" for="fecha">Fecha</label>
                    <input id="fechaedit" type="date" class="form-control" name="fecha" required>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label" for="tipo_solicitud">Comite</label>
                    <select name="nombre_comite" id="nombrecomiteedit" class="form-control" style="height: 47px;" required>
                        @foreach ($comitesAdmin as $comitesAdmins)
                        <option value="{{ $comitesAdmins->nombre }}">
                            {{ $comitesAdmins->nombre }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                </div>
                </div>

                <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Dependencia de vinculación</label>
                    <select name="dependencia_V" id="dependenciaedit" class="form-control" style="height: 47px;" required>
                        <option value="" hidden>Seleccione una dependencia de vinculación</option>
                        @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Cargo</label>
                    <input id="cargoedit" type="text" class="form-control" name="cargo_comite" placeholder="Cargo" required>
                    </div>
                </div>
                </div>


                <div class="row">
                    <div class="col-md-12"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                        <div class="mb-3">
                            <label class="form-label">Actividades desarrolladas</label>
                            <textarea id="adesarrolladasedit" class="form-control" name="A_desarrolladas" placeholder="Actividades desarrolladas" oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <input id="nombreedit" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
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

            <div>
                <button type="button" class="btn btn-danger" id="cancel-button-editar" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
                <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i> Actualizar</button>
            </div>

        </form>
    </div>
  </div>
</div>








<!--///////////////////////modal para eliminar la solicitud/////////////////////// -->
<div id="modal-container-eliminar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">¿Desea eliminar este evento?</h1>
      <br><br>
      <form action="" id="elimForm">
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
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información del comité</h5>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="mb-3">
                        <label class="form-label">Nombre del participante</label>
                            <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
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
                    <label class="form-label" for="tipo_solicitud">Comite</label>
                        <p type="text" class="form-control" id="nombrecomiteviz" readonly></p>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Dependencia de vinculación</label>
                            <p class="form-control" id="dependenciaviz" readonly></p>
                </div>
              </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Cargo</label>
                            <p type="text" class="form-control" id="cargoviz" readonly></p>
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
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Actividades desarrolladas</label>
                            <p class="form-control" id="adesarrolladasviz" readonly></p>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario'] }}">
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

<!--///////////////////////Boton para un nuevo comite/////////////////////// -->
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
<table class="table" id="comitesTable">
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
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Comité</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Cargo</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Dependencia de vinculación</th>
        @if ($sesionEspecial == 1)
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;'>Acciones</th>
        @endif
        @else
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">Acciones</th>
        @endif
        @endif
  </thead>
  <tbody>


  @foreach($comites as $comite)
  @php
      $fechaComite = $comite->fechas; // Obtener el valor del campo 'fechas'
      $mesComite = date("n", strtotime($fechaComite)); // Obtener el número de mes

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

      $bimestreComite = $bimestres[$mesComite] ?? ''; // Obtener el bimestre correspondiente


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
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
              data-id="{{ $comite->id }}"
              data-fecha="{{ $comite->fechas }}"
              data-nombrecomite="{{ $comite->nombre_comite }}"
              data-nombre="{{ $comite->nombre_persona }}"
              data-encargado="{{ $comite->encargado }}"
              data-cargo="{{ $comite->cargo_comite }}"
              data-dependencia="{{ $comite->dependencia_V }}"
              data-adesarrolladas="{{ $comite->A_desarrolladas }}"
              data-usuariosseleccionados="{{ $comite->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comite->fechas }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comite->nombre_comite }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comite->cargo_comite }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comite->dependencia_V }}</td>
        @if ($sesionEspecial == 1)
        @if ($bimestreComite == $currentBimester || $bimestreComite == $previousBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btneditC" class="button-editar btn"
              data-id="{{ $comite->id }}"
              data-fecha="{{ $comite->fechas }}"
              data-nombrecomite="{{ $comite->nombre_comite }}"
              data-nombre="{{ $comite->nombre_persona }}"
              data-cargo="{{ $comite->cargo_comite }}"
              data-dependencia="{{ $comite->dependencia_V }}"
              data-adesarrolladas="{{ $comite->A_desarrolladas }}"
              data-usuariosseleccionados="{{ $comite->participantes }}"
              data-action="{{ route('comitesEditar', $comite->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelim"
              data-idelim="{{ route('eliminarcomites', $comite->id) }}">
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
        @if ($bimestreComite == $currentBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btneditC" class="button-editar btn"
              data-id="{{ $comite->id }}"
              data-fecha="{{ $comite->fechas }}"
              data-nombrecomite="{{ $comite->nombre_comite }}"
              data-nombre="{{ $comite->nombre_persona }}"
              data-cargo="{{ $comite->cargo_comite }}"
              data-dependencia="{{ $comite->dependencia_V }}"
              data-adesarrolladas="{{ $comite->A_desarrolladas }}"
              data-usuariosseleccionados="{{ $comite->participantes }}"
              data-action="{{ route('comitesEditar', $comite->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelim"
              data-idelim="{{ route('eliminarcomites', $comite->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
    @endforeach


    @foreach($comitesRelacionadas as $comitesRelacionada)
  @php
      $fechaComite = $comitesRelacionada->fechas; // Obtener el valor del campo 'fechas'
      $mesComite = date("n", strtotime($fechaComite)); // Obtener el número de mes

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

      $bimestreComite = $bimestres[$mesComite] ?? ''; // Obtener el bimestre correspondiente

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
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
              data-id="{{ $comitesRelacionada->id }}"
              data-fecha="{{ $comitesRelacionada->fechas }}"
              data-nombrecomite="{{ $comitesRelacionada->nombre_comite }}"
              data-nombre="{{ $comitesRelacionada->nombre_persona }}"
              data-encargado="{{ $comitesRelacionada->encargado }}"
              data-cargo="{{ $comitesRelacionada->cargo_comite }}"
              data-dependencia="{{ $comitesRelacionada->dependencia_V }}"
              data-adesarrolladas="{{ $comitesRelacionada->A_desarrolladas }}"
              data-usuariosseleccionados="{{ $comitesRelacionada->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comitesRelacionada->fechas }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comitesRelacionada->nombre_comite }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comitesRelacionada->cargo_comite }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comitesRelacionada->dependencia_V }}</td>
        @if ($sesionEspecial == 1)
        @if ($bimestreComite == $currentBimester || $bimestreComite == $previousBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('eliminarcomitesR', $comitesRelacionada->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @else
        @if ($bimestreComite == $currentBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('eliminarcomitesR', $comitesRelacionada->id) }}">
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
<script src="{{ asset('js/comites.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;

  function autoResizeTextarea(element) {
    element.style.height = "auto";
    element.style.height = (element.scrollHeight) + "px";
}

</script>
@endpush
