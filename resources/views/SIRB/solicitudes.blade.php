@extends('plantillas/plantillaresp')
@section('contenido')

<title>Solicitudes</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Solicitudes de asesoría y consulta técnica </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/solicitudes.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para una nueva solicitud/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nueva solicitud</h1>
        <br>
        <form action="{{route('nuevasolicitud')}}" method="POST">
          @csrf

          <div class="container">
                <div class="row">
                    <div class="col-md-6 ">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la persona atendida</label>
                        <input id="encargadoservicio" class="form-control" name="encargadoservicio" placeholder="Ingresa el nombre del solicitante" required>
                    </div>
                    </div>
                    <div class="col-md-6 " >
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input id="titulosol" class="form-control" name="titulosol" placeholder="Ingresa el título de la solicitud" required>
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
                    <label class="form-label" for="tipo_solicitud">Tipo</label>
                    <select name="tipo_solicitud" id="tipo_solicitud" class="form-control" style="height: 47px;" required>
                        <option value="" disabled selected>Seleccione el tipo de solicitud</option>
                        <option value="Asesoría técnica">Asesoría técnica</option>
                        <option value="Consulta técnica">Consulta técnica</option>
                    </select>
                    </div>
                </div>
                </div>

                <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Dependencia o Institución</label>
                    <select name="D_perteneciente" id="D_perteneciente" class="form-control" style="height: 47px;" required>
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
                    <input id="cargo_actual" type="text" class="form-control" name="cargo_actual" placeholder="Cargo" required>
                    </div>
                </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Producto final</label>
                        <select name="producto_final" id="producto_final" class="form-control" style="height: 47px;" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Respuesta por correo electrónico">Respuesta por correo electrónico</option>
                            <option value="Respuesta por teléfono">Respuesta por teléfono</option>
                            <option value="Apoyo en forma presencial">Apoyo en forma presencial</option>
                            <option value="Elaboración de informe">Elaboración de informe</option>
                            <option value="Apoyo en forma virtual">Apoyo en forma virtual</option>
                        </select>
                        </div>
                    </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Tiempo dedicado (horas)</label>
                    <input id="tiempo_dedicado" type="text" class="form-control" name="tiempo_dedicado" placeholder="Horas" required pattern="[0-9]+" title="Ingrese solo números">
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                    <div class="mb-3">
                    <label class="form-label">Descripción de las Actividades desarrolladas</label>
                    <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Actividades desarrolladas" oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
                    </div>
                </div>
                </div>

                <div class="row">

                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
                <input id="actividad" type="hidden" class="form-control" name="actividad" value="3">
                </div>
            </div>

            <input id="areaActividad" type="hidden" class="form-control" name="areaActividad" value="{{$LoggedUserInfo['idarea']}}" required readonly>

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








<!--///////////////////////modal para editar la solicitud/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar solicitud</h1>
      <br>
      <form action="" id="editarForm">
          @csrf

          @method('PUT')

          <div class="container">
          <div class="row">
                    <div class="col-md-6 ">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la persona atendida</label>
                        <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" placeholder="Ingresa el nombre del solicitante" required>
                    </div>
                    </div>
                    <div class="col-md-6 " >
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input id="titulosoledit" class="form-control" name="titulosol" placeholder="Ingresa el título de la solicitud" required>
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
                  <label class="form-label" for="tipo_solicitud">Tipo</label>
                  <select name="tipo_solicitud" id="tipo_solicitudedits" class="form-control" style="height: 47px;" required>
                    <option value="" disabled selected>Seleccione el tipo de solicitud</option>
                    <option value="Asesoría técnica">Asesoría técnica</option>
                    <option value="Consulta técnica">Consulta técnica</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Dependencia o Institución</label>
                  <select name="D_perteneciente" id="D_pertenecienteedit" class="form-control" style="height: 47px;" required>
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
                  <input id="cargo_actualedit" type="text" class="form-control" name="cargo_actual" placeholder="Cargo" required>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Producto final</label>
                  <select name="producto_final" id="producto_finaledit" class="form-control" style="height: 47px;" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="Respuesta por correo electrónico">Respuesta por correo electrónico</option>
                    <option value="Respuesta por teléfono">Respuesta por teléfono</option>
                    <option value="Apoyo en forma presencial">Apoyo en forma presencial</option>
                    <option value="Elaboración de informe">Elaboración de informe</option>
                    <option value="Apoyo en forma virtual">Apoyo en forma virtual</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tiempo dedicado (horas)</label>
                  <input id="tiempo_dedicadoedit" type="text" class="form-control" name="tiempo_dedicado" placeholder="Horas" required pattern="[0-9]+" title="Ingrese solo números">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12"> <!-- Cambiamos a 12 columnas para que "Descripción" ocupe toda la fila -->
                <div class="mb-3">
                  <label class="form-label">Descripción de las Actividades desarrolladas</label>
                  <textarea id="descripcionedit" class="form-control" name="descripcion" placeholder="Actividades desarrolladas" oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
                </div>
              </div>
            </div>

            <div class="row">

            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
              <input id="actividad" type="hidden" class="form-control" name="actividad" value="3">
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
            <button type="button" class="btn btn-danger" id="cancel-button-editar" style=" color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
            <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Actualizar</button>
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
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información de la solicitud</h5>
          </div>

            <div class="modal-body">

            <div class="row">
                    <div class="col-md-6 ">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la persona atendida</label>
                        <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
                    </div>
                    </div>
                    <div class="col-md-6 " >
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <p type="text" class="form-control" id="titulosolviz" readonly></p>
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
                        <label class="form-label" for="tipo_solicitud">Tipo</label>
                            <p type="text" class="form-control" id="tipoviz" readonly></p>
                        </div>
                    </div>
                    </div>

                    <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Dependencia o Institución</label>
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

                        <div class="col-md-6">
                            <div class="mb-3">
                            <label class="form-label">Producto final</label>
                                <p class="form-control" id="productoviz" readonly></p>
                            </div>
                        </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Tiempo dedicado (horas)</label>
                            <p class="form-control" id="tiempoviz" readonly></p>
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
                        <label class="form-label">Descripción de las Actividades desarrolladas</label>
                            <p class="form-control" id="descripviz" readonly></p>
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

<!--///////////////////////Boton para una nueva solicitud/////////////////////// -->
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
        <th scope="col" style='text-align: center; vertical-align: middle;'>Tipo</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Título</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Dependencia o Institución</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Tiempo dedicado (horas)</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Producto final</th>
        @php
        $thMostrado = false; // Inicializamos la variable de bandera como falsa
        $solicitudesetiqueta = $solicitudes->merge($solicitudesRelacionadas);
        @endphp
        @foreach($solicitudesetiqueta as $solicitud)
        @php
            $fechasolicitud = $solicitud->fecha; // Obtener la fecha de la reunión en formato Y-m-d
            $messolicitud = date("n", strtotime($fechasolicitud)); // Obtener el número de mes

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

            $bimestresolicitud = $bimestres[$messolicitud] ?? ''; // Obtener el bimestre correspondiente
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
            @if ($bimestresolicitud == $currentBimester && !$thMostrado || $bimestresolicitud == $previousBimester && !$thMostrado)
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
        @if ($bimestresolicitud == $currentBimester && !$thMostrado)
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
  @foreach($solicitudes as $solicitud)
    @php
        $fechasolicitud = $solicitud->fecha; // Obtener la fecha de la reunión en formato Y-m-d
        $messolicitud = date("n", strtotime($fechasolicitud)); // Obtener el número de mes

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

        $bimestresolicitud = $bimestres[$messolicitud] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
                data-id="{{ $solicitud->id }}"
                data-fecha="{{ $solicitud->fecha }}"
                data-titulo="{{ $solicitud->titulo }}"
                data-tipo="{{ $solicitud->tipo_solicitud }}"
                data-nombre="{{ $solicitud->nombre_persona }}"
                data-encargado="{{ $solicitud->encargado }}"
                data-cargo="{{ $solicitud->cargo_actual }}"
                data-dependencia="{{ $solicitud->D_perteneciente }}"
                data-descripcion="{{ $solicitud->descripcion }}"
                data-tiempo="{{ $solicitud->tiempo_dedicado }}"
                data-producto="{{ $solicitud->producto_final }}"
                data-usuariosseleccionados="{{ $solicitud->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitud->fecha }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitud->tipo_solicitud }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitud->titulo }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitud->D_perteneciente }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitud->tiempo_dedicado }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitud->producto_final }}</td>
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
        @if ($bimestresolicitud == $currentBimester || $bimestresolicitud == $previousBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
                    data-id="{{ $solicitud->id }}"
                    data-fecha="{{ $solicitud->fecha }}"
                    data-titulo="{{ $solicitud->titulo }}"
                    data-encargado="{{ $solicitud->encargado }}"
                    data-tipo="{{ $solicitud->tipo_solicitud }}"
                    data-nombre="{{ $solicitud->nombre_persona }}"
                    data-cargo="{{ $solicitud->cargo_actual }}"
                    data-dependencia="{{ $solicitud->D_perteneciente }}"
                    data-descripcion="{{ $solicitud->descripcion }}"
                    data-tiempo="{{ $solicitud->tiempo_dedicado }}"
                    data-producto="{{ $solicitud->producto_final }}"
                    data-usuariosseleccionados="{{ $solicitud->participantes }}"
                    data-action="{{ route('editarsolicitud', $solicitud->id) }}">
                <i class="bi bi-pencil"></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelim"
              data-idelim="{{ route('eliminarsolicitud', $solicitud->id) }}">
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
        @if ($bimestresolicitud == $currentBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
                    data-id="{{ $solicitud->id }}"
                    data-fecha="{{ $solicitud->fecha }}"
                    data-tipo="{{ $solicitud->tipo_solicitud }}"
                    data-titulo="{{ $solicitud->titulo }}"
                    data-encargado="{{ $solicitud->encargado }}"
                    data-nombre="{{ $solicitud->nombre_persona }}"
                    data-cargo="{{ $solicitud->cargo_actual }}"
                    data-dependencia="{{ $solicitud->D_perteneciente }}"
                    data-descripcion="{{ $solicitud->descripcion }}"
                    data-tiempo="{{ $solicitud->tiempo_dedicado }}"
                    data-producto="{{ $solicitud->producto_final }}"
                    data-usuariosseleccionados="{{ $solicitud->participantes }}"
                    data-action="{{ route('editarsolicitud', $solicitud->id) }}">
                <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelim"
              data-idelim="{{ route('eliminarsolicitud', $solicitud->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
    @endforeach


    @foreach($solicitudesRelacionadas as $solicitudRelacionada)
    @php
        $fechasolicitud = $solicitudRelacionada->fecha; // Obtener la fecha de la reunión en formato Y-m-d
        $messolicitud = date("n", strtotime($fechasolicitud)); // Obtener el número de mes

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

        $bimestresolicitud = $bimestres[$messolicitud] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
    <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
                data-id="{{ $solicitudRelacionada->id }}"
                data-fecha="{{ $solicitudRelacionada->fecha }}"
                data-tipo="{{ $solicitudRelacionada->tipo_solicitud }}"
                data-nombre="{{ $solicitudRelacionada->nombre_persona }}"
                data-encargado="{{ $solicitudRelacionada->encargado }}"
                data-cargo="{{ $solicitudRelacionada->cargo_actual }}"
                data-dependencia="{{ $solicitudRelacionada->D_perteneciente }}"
                data-descripcion="{{ $solicitudRelacionada->descripcion }}"
                data-tiempo="{{ $solicitudRelacionada->tiempo_dedicado }}"
                data-producto="{{ $solicitudRelacionada->producto_final }}"
                data-usuariosseleccionados="{{ $solicitudRelacionada->participantes }}">

              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitudRelacionada->fecha }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitudRelacionada->tipo_solicitud }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitudRelacionada->titulo }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitudRelacionada->D_perteneciente }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitudRelacionada->tiempo_dedicado }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $solicitudRelacionada->producto_final }}</td>
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
        @if ($bimestresolicitud == $currentBimester || $bimestresolicitud == $previousBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('eliminarsolicitudR', $solicitudRelacionada->id) }}">
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
        @if ($bimestresolicitud == $currentBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('eliminarsolicitudR', $solicitudRelacionada->id) }}">
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
<script src="{{ asset('js/solicitudes.js') }}"></script>
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
