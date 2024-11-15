@extends('plantillas/plantillaresp')
@section('contenido')

<title>Reuniones</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Reuniones </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/reuniones.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para una nueva reunion/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nueva reunión</h1>
        <br>
        <form action="{{route('nuevareunion')}}" method="POST">
          @csrf

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
                    <label class="form-label bold" for="fecha">Fecha</label>
                    <input id="fecha" type="date" class="form-control" name="fecha" required>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label" for="tipo_reunion">Tipo</label>
                    <select name="tipo_reunion" id="tipo_reunion" class="form-control" required>
                        <option value="">Seleccione el tipo de reunión</option>
                        <option value="Promoción de servicios de asesoría e investigación en transporte">Promoción de servicios de asesoría e investigación en transporte</option>
                        <option value="Reunión de trabajo con el cliente">Reunión de trabajo con el cliente</option>
                        <option value="Otro">Otro</option>
                    </select>
                    </div>
                </div>
                </div>

                <!-- Campo de captura adicional para "Otro" -->
                <div id="campo_otro" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="otro_tipo">Especifique otro tipo</label>
                        <input type="text" name="otro_tipo" id="otro_tipo" class="form-control">
                    </div>
                    </div>
                </div>
                </div>
                <!-- Campo de captura adicional para "Otro" -->

                <div class="row">
                <div class="col-md-12 ">
                    <div class="mb-3">
                    <label class="form-label">Actividades realizadas</label>
                    <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Actividades realizadas" oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Lugar</label>
                    <input id="lugar_reunion" type="text" class="form-control" name="lugar_reunion" placeholder="Lugar" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Dependencia de vinculación</label>
                    <select name="D_perteneciente" id="D_perteneciente" class="form-control" required>
                        @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12">
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
            <button type="button" class="btn btn-danger" id="cancel-button" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;">
              <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar
            </button>
            <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold;">
              <i class="bi bi-plus-circle"></i>Agregar
            </button>
          </div>

        </form>
      </div>
    </div>
</div>










<!--///////////////////////modal para editar la reunión/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar reunión</h1>
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
                    <label class="form-label bold" for="fecha">Fecha</label>
                    <input id="fechaedit" type="date" class="form-control" name="fecha">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label" for="tipo_reunion">Tipo</label>
                    <select name="tipo_reunion" id="tipo_reunionedit" class="form-control">
                        <option value="" disabled>Seleccione el tipo de reunión</option>
                        <option value="Promoción de servicios de asesoría e investigación en transporte">Promoción de servicios de asesoría e investigación en transporte</option>
                        <option value="Reunión de trabajo con el cliente">Reunión de trabajo con el cliente</option>
                        <option value="Otroedit">Otro</option>
                    </select>
                    </div>
                </div>
                </div>

                <!-- Campo de captura adicional para "Otro" -->
                <div id="campo_otroedit" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="otro_tipo">Especifique otro tipo</label>
                        <input type="text" name="otro_tipo" id="otro_tipoedit" class="form-control">
                    </div>
                    </div>
                </div>
                </div>
                <!-- Campo de captura adicional para "Otro" -->

                <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                    <label class="form-label">Actividades realizadas</label>
                    <textarea id="descripcionedit" class="form-control" name="descripcion" placeholder="Actividades realizadas" oninput="autoResizeTextarea(this)" style="overflow:hidden"></textarea>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Lugar</label>
                    <input id="lugar_reunionedit" type="text" class="form-control" name="lugar_reunion" placeholder="Lugar">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Dependencia de vinculación</label>
                    <select name="D_perteneciente" id="D_pertenecienteedit" class="form-control">
                        @foreach ($Cliente as $Clientes)
                        <option value="{{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}">
                            {{ $Clientes->nivel1 }} | {{ $Clientes->nivel2 }} | {{ $Clientes->nivel3 }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                </div>
                </div>

                <input id="nombre_personaedit" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">

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
                <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Actualizar</button>
            </div>
        </div>
        </form>
    </div>
  </div>
</div>











<!--///////////////////////modal para eliminar la reunion/////////////////////// -->
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
                <h5 class="modal-title fs-5" id="staticBackdropLabel" readonly>Información de la reunión</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
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
                            <label class="form-label" for="tipo_reunion">Tipo</label>
                            <p type="text" class="form-control" id="tipoviz" readonly></p>
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
                            <label class="form-label">Dependencia de vinculación</label>
                            <p class="form-control" id="dependenciaviz" readonly></p>
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
                            <label class="form-label">Actividades realizadas</label>
                            <p class="form-control" id="descripviz" readonly></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="cancel-button-vizualizar">
                        <i class='bx bxs-tag-x bx-fw bx-flashing-hover' readonly></i> Volver
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>





<input type="hidden" id="sesionEspecial" data-sesion-especial="{{ $sesionEspecial }}" value="{{ $sesionEspecial }}">

<!--///////////////////////Boton para una nueva reunion/////////////////////// -->
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
<table class="table" id="reunionesTable">
  <thead class="thead-light">
    <tr>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Info</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Tipo</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Dependencia de vinculación</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Lugar</th>
        @php
        $thMostrado = false; // Inicializamos la variable de bandera como falsa
        @endphp
        @php
        $reunionesetiqueta = $reuniones->merge($reunionesRelacionadas);
        @endphp
        @foreach($reunionesetiqueta as $reunion)
        @php
                $fechaReunion = $reunion->fecha_reunion; // Obtener la fecha de la reunión
                $mesReunion = date("n", strtotime($fechaReunion)); // Obtener el número de mes

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

                $bimestreReunion = $bimestres[$mesReunion] ?? ''; // Obtener el bimestre correspondiente
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
            @if ($bimestreReunion == $currentBimester && !$thMostrado || $bimestreReunion == $previousBimester && !$thMostrado)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">Acciones</th>
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
        @if ($bimestreReunion == $currentBimester && !$thMostrado)
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">Acciones</th>
        @php
            $thMostrado = true; // Actualizamos la variable de bandera como verdadera
        @endphp
        @endif
        @endif
    </tr>
    @endforeach
  </thead>
  <tbody>





  @foreach($reuniones as $reunion)
  @php
        $fechaReunion = $reunion->fecha_reunion; // Obtener la fecha de la reunión
        $mesReunion = date("n", strtotime($fechaReunion)); // Obtener el número de mes

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

        $bimestreReunion = $bimestres[$mesReunion] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn"
              data-id="{{ $reunion->id }}"
              data-fecha="{{ $reunion->fecha_reunion }}"
              data-tipo="{{ $reunion->tipo_reunion }}"
              data-nombre="{{ $reunion->nombre_persona }}"
              data-encargado="{{ $reunion->encargado }}"
              data-dependencia="{{ $reunion->D_vinculacion }}"
              data-descripcion="{{ $reunion->descripcion_R }}"
              data-usuariosseleccionados="{{ $reunion->participantes }}"
              data-lugar="{{ $reunion->lugar_reunion }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunion->fecha_reunion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunion->tipo_reunion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunion->D_vinculacion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunion->lugar_reunion }}</td>
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
        @if ($bimestreReunion == $currentBimester || $bimestreReunion == $previousBimester)
        <td style='text-align: center; vertical-align: middle;' class="acciones-col">
          <div id="five-editar" class="button-editar btn">
            <button type="button" id="btnedit" class="button-editar btn"
                data-fecha="{{ $reunion->fecha_reunion }}"
                data-tipo="{{ $reunion->tipo_reunion }}"
                data-nombre="{{ $reunion->nombre_persona }}"
                data-dependencia="{{ $reunion->D_vinculacion }}"
                data-descripcion="{{ $reunion->descripcion_R }}"
                data-lugar="{{ $reunion->lugar_reunion }}"
                data-usuariosseleccionados="{{ $reunion->participantes }}"
                data-action="{{ route('reunionesEditar', $reunion->id) }}">
                <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;' class="acciones-col">
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelimR" class="btn btn-danger"
              data-idelimr="{{ route('eliminarreunion', $reunion->id) }}">
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
        @if ($bimestreReunion == $currentBimester)
        <td style='text-align: center; vertical-align: middle;' class="acciones-col">
          <div id="five-editar" class="button-editar btn">
            <button type="button" id="btnedit" class="button-editar btn"
                data-fecha="{{ $reunion->fecha_reunion }}"
                data-tipo="{{ $reunion->tipo_reunion }}"
                data-nombre="{{ $reunion->nombre_persona }}"
                data-dependencia="{{ $reunion->D_vinculacion }}"
                data-descripcion="{{ $reunion->descripcion_R }}"
                data-lugar="{{ $reunion->lugar_reunion }}"
                data-usuariosseleccionados="{{ $reunion->participantes }}"
                data-action="{{ route('reunionesEditar', $reunion->id) }}">
                <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;' class="acciones-col">
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelimR" class="btn btn-danger"
              data-idelimr="{{ route('eliminarreunion', $reunion->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
  @endforeach



    @foreach($reunionesRelacionadas as $reunionRelacionada)
    @php
        $fechaReunion = $reunionRelacionada->fecha_reunion; // Obtener la fecha de la reunión en formato Y-m-d
        $mesReunion = date("n", strtotime($fechaReunion)); // Obtener el número de mes

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

        $bimestreReunion = $bimestres[$mesReunion] ?? ''; // Obtener el bimestre correspondiente





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
            <button type="button" id="btnviz" class="btn"
            data-id="{{ $reunionRelacionada->id }}"
            data-id="{{ $reunionRelacionada->id }}"
              data-fecha="{{ $reunionRelacionada->fecha_reunion }}"
              data-tipo="{{ $reunionRelacionada->tipo_reunion }}"
              data-nombre="{{ $reunionRelacionada->nombre_persona }}"
              data-encargado="{{ $reunionRelacionada->encargado }}"
              data-dependencia="{{ $reunionRelacionada->D_vinculacion }}"
              data-descripcion="{{ $reunionRelacionada->descripcion_R }}"
              data-usuariosseleccionados="{{ $reunionRelacionada->participantes }}"
              data-lugar="{{ $reunionRelacionada->lugar_reunion }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunionRelacionada->fecha_reunion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunionRelacionada->tipo_reunion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunionRelacionada->D_vinculacion }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $reunionRelacionada->lugar_reunion }}</td>
        @if ($sesionEspecial == 1)
        @if ($bimestreReunion == $currentBimester || $bimestreReunion == $previousBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">
          <div id="five-eliminar" class="button-eliminar btn ">
            <button type="button" id="btneliminar" class="btn btn-danger"
              data-ideliminar="{{ route('eliminarreunionR', $reunionRelacionada->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @else
        @if ($bimestreReunion == $currentBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">
          <div id="five-eliminar" class="button-eliminar btn ">
            <button type="button" id="btneliminar" class="btn btn-danger"
              data-ideliminar="{{ route('eliminarreunionR', $reunionRelacionada->id) }}">
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
<script src="{{ asset('js/reuniones.js') }}"></script>
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
