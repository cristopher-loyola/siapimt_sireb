@extends('plantillas/plantillaresp')
@section('contenido')

<title>Revistas</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Revistas </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/revistas.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">


<!--///////////////////////modal para una nueva revista/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nueva revista</h1>
        <br>
        <form action="{{route('nuevarevista')}}" method="POST">
          @csrf

          <div class="container">

            <div class="row" hidden>
                <div class="col-md-6 ">
                  <div class="mb-3">
                    <label class="form-label">Autor</label>
                    <input id="encargadoservicio" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                  </div>
                </div>
            </div>

            <div class="col-md-6 " hidden>
                <div class="mb-3">
                    <label class="form-label">Área</label>
                    <input id="areaActividad" class="form-control" name="areaActividad" value="{{$LoggedUserInfo['idarea']}}" required readonly>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Título del artículo</label>
                  <input id="tituloarticulo" type="text" class="form-control" name="tituloarticulo" placeholder="Título del artículo" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Editorial</label>
                  <input id="editorial" type="text" class="form-control" name="editorial" placeholder="Editorial" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de revista</label>
                    <select name="tiporevista" id="tiporevista" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo de revista</option>
                      <option value="Internacional con arbitraje">Internacional con arbitraje</option>
                      <option value="Nacional con arbitraje">Nacional con arbitraje</option>
                      <option value="Internacional sin arbitraje">Internacional sin arbitraje</option>
                      <option value="Nacional sin arbitraje">Nacional sin arbitraje</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de artículo</label>
                    <select name="tipoarticulo" id="tipoarticulo" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo de artículo</option>
                      <option value="No Indizado">No Indizado</option>
                      <option value="Indizado">Indizado</option>
                    </select>
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Nombre de la revista</label>
                  <input id="nombrerevista" type="text" class="form-control" name="nombrerevista" placeholder="Nombre de la revista" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número de la revista</label>
                  <input id="numerorevista" type="text" class="form-control" name="numerorevista" placeholder="Número de la revista" required pattern="[0-9]+" title="Ingrese solo números">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Ciudad y/o país</label>
                  <input id="ciudadpais" type="text" class="form-control" name="ciudadpais" placeholder="Ciudad y/o país" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Fecha</label>
                  <input id="fecha" type="date" class="form-control" name="fecha" placeholder="Fecha" required>
                </div>
              </div>

                <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">

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











<!--///////////////////////modal para editar la revista/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar revista</h1>
      <br>
      <form action="" id="editarForm">
          @csrf

          @method('PUT')

          <div class="container">
            <div class="row" hidden>
                <div class="col-md-6 ">
                  <div class="mb-3">
                    <label class="form-label">Encargado</label>
                    <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                  </div>
                </div>
               </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Título del artículo</label>
                  <input id="tituloarticuloedit" type="text" class="form-control" name="tituloarticulo" placeholder="Título del artículo" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Editorial</label>
                  <input id="editorialedit" type="text" class="form-control" name="editorial" placeholder="Editorial" required>
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de revista</label>
                    <select name="tiporevista" id="tiporevistaedit" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo de revista</option>
                      <option value="Internacional con arbitraje">Internacional con arbitraje</option>
                      <option value="Nacional con arbitraje">Nacional con arbitraje</option>
                      <option value="Internacional sin arbitraje">Internacional sin arbitraje</option>
                      <option value="Nacional sin arbitraje">Nacional sin arbitraje</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de artículo</label>
                    <select name="tipoarticulo" id="tipoarticuloedit" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo de artículo</option>
                      <option value="No Indizado">No Indizado</option>
                      <option value="Indizado">Indizado</option>
                    </select>
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Nombre de la revista</label>
                  <input id="nombrerevistaedit" type="text" class="form-control" name="nombrerevista" placeholder="Nombre de la revista" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número de la revista</label>
                  <input id="numerorevistaedit" type="text" class="form-control" name="numerorevista" placeholder="Número de la revista" required pattern="[0-9]+" title="Ingrese solo números">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Ciudad y/o país</label>
                  <input id="ciudadpaisedit" type="text" class="form-control" name="ciudadpais" placeholder="Ciudad y/o país" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Fecha</label>
                  <input id="fechaedit" type="date" class="form-control" name="fecha" placeholder="Fecha" required>
                </div>
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
            <button type="button" class="btn btn-danger" id="cancel-button-editar" style=" color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
            <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Actualizar</button>
          </div>

        </form>
    </div>
  </div>
</div>









<!--///////////////////////modal para eliminar la revista/////////////////////// -->
<div id="modal-container-eliminar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">¿Desea eliminar este evento?</h1>
      <br><br>
      <form action="" id="elimFormR">
        @csrf

        @method('DELETE')

        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>No, regresar</button>
          <button type="submit" class="btn btn-primary" style="background-color: #FF0000; font-weight: bold;"><i class="bi bi-check-lg"></i>Si, eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div id="modal-container-eliminar-relacion">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">¿Eliminar mi participación de este evento?</h1>
      <br><br>
      <form action="" id="eliminarForm">
        @csrf

        @method('DELETE')

        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-eliminar-relacion" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>No, regresar</button>
          <button type="submit" class="btn btn-primary" style="background-color: #FF0000; font-weight: bold;"><i class="bi bi-check-lg"></i>Si, eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>








<!--///////////////////////modal para ver toda la informacion de la solicitud/////////////////////// -->
<div id="modal-container-vizualizar">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF;">
        <div class="modal-header" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold; ">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información de la revista</h5>
          </div>

          <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label">Autor</label>
                    <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Título del artículo</label>
                  <p class="form-control" id="tituloarticuloviz" readonly></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Editorial</label>
                  <p class="form-control" id="editorialviz" readonly></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de revista</label>
                      <p type="text" class="form-control" id="tiporevistaviz" readonly></p>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de artículo</label>
                    <p type="text" class="form-control" id="tipoarticuloviz" readonly></p>
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Nombre de la revista</label>
                  <p type="text" class="form-control" id="nombrerevistaviz" readonly></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número de la revista</label>
                  <p class="form-control" id="numerorevistaviz" readonly></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Ciudad y/o país</label>
                  <p class="form-control" id="ciudadpaisviz" readonly></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Fecha</label>
                  <p class="form-control" id="fechaviz" readonly></p>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label">Participantes</label>
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
        <th scope="col" style='text-align: center; vertical-align: middle;'>Tipo</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Título del artículo</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Lugar</th>
        @php
        $thMostrado = false; // Inicializamos la variable de bandera como falsa
        @endphp
        @php
        $revistasetiqueta = $revistas->merge($revistaRelacionados);
        @endphp
        @foreach($revistasetiqueta as $revista)
        @php
              $fecharevista = $revista->fecha; // Obtener la fecha de la reunión en formato Y-m-d
              $mesrevista = date("n", strtotime($fecharevista)); // Obtener el número de mes

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

              $bimestrerevista = $bimestres[$mesrevista] ?? ''; // Obtener el bimestre correspondiente
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
            @if ($bimestrerevista == $currentBimester && !$thMostrado || $bimestrerevista == $previousBimester && !$thMostrado)
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
        @if ($bimestrerevista == $currentBimester && !$thMostrado)
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
  @foreach($revistas as $revista)
  @php
        $fecharevista = $revista->fecha; // Obtener la fecha de la reunión en formato Y-m-d
        $mesrevista = date("n", strtotime($fecharevista)); // Obtener el número de mes

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

        $bimestrerevista = $bimestres[$mesrevista] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
            data-id="{{ $revista->id }}"
            data-tiporevista="{{ $revista->tipo_revista }}"
            data-titulo="{{ $revista->titulo }}"
            data-tipoarticulo="{{ $revista->tipo_articulo }}"
            data-nombrerevista="{{ $revista->nombre_revista }}"
            data-numerorevista="{{ $revista->numero_revista }}"
            data-editorial="{{ $revista->editorial }}"
            data-ciudadpais="{{ $revista->ciudad_pais }}"
            data-fecha="{{ $revista->fecha }}"
            data-nombrepersona="{{ $revista->nombre_persona }}"
            data-encargado="{{ $revista->encargado }}"
            data-usuariosseleccionados="{{ $revista->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revista->tipo_revista }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revista->fecha }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revista->titulo }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revista->ciudad_pais }}</td>
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
        @if ($bimestrerevista == $currentBimester || $bimestrerevista == $previousBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $revista->id }}"
              data-tiporevista="{{ $revista->tipo_revista }}"
              data-titulo="{{ $revista->titulo }}"
              data-tipoarticulo="{{ $revista->tipo_articulo }}"
              data-nombrerevista="{{ $revista->nombre_revista }}"
              data-numerorevista="{{ $revista->numero_revista }}"
              data-editorial="{{ $revista->editorial }}"
              data-ciudadpais="{{ $revista->ciudad_pais }}"
              data-fecha="{{ $revista->fecha }}"
              data-nombrepersona="{{ $revista->nombre_persona }}"
              data-usuariosseleccionados="{{ $revista->participantes }}"
              data-action="{{ route('revistaEditar', $revista->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimRe"
              data-idelimre="{{ route('revistaEliminar', $revista->id) }}">
                <i class="bi bi-trash">

                </i>
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
        @if ($bimestrerevista == $currentBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $revista->id }}"
              data-tiporevista="{{ $revista->tipo_revista }}"
              data-titulo="{{ $revista->titulo }}"
              data-tipoarticulo="{{ $revista->tipo_articulo }}"
              data-nombrerevista="{{ $revista->nombre_revista }}"
              data-numerorevista="{{ $revista->numero_revista }}"
              data-editorial="{{ $revista->editorial }}"
              data-ciudadpais="{{ $revista->ciudad_pais }}"
              data-fecha="{{ $revista->fecha }}"
              data-nombrepersona="{{ $revista->nombre_persona }}"
              data-usuariosseleccionados="{{ $revista->participantes }}"
              data-action="{{ route('revistaEditar', $revista->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimRe"
              data-idelimre="{{ route('revistaEliminar', $revista->id) }}">
                <i class="bi bi-trash">

                </i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
  @endforeach

    @foreach($revistaRelacionados as $revistaRelacionado)
    @php
        $fecharevista = $revistaRelacionado->fecha; // Obtener la fecha de la reunión en formato Y-m-d
        $mesrevista = date("n", strtotime($fecharevista)); // Obtener el número de mes

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

        $bimestrerevista = $bimestres[$mesrevista] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
    <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
              data-id="{{ $revistaRelacionado->id }}"
              data-tiporevista="{{ $revistaRelacionado->tipo_revista }}"
              data-titulo="{{ $revistaRelacionado->titulo }}"
              data-tipoarticulo="{{ $revistaRelacionado->tipo_articulo }}"
              data-nombrerevista="{{ $revistaRelacionado->nombre_revista }}"
              data-numerorevista="{{ $revistaRelacionado->numero_revista }}"
              data-editorial="{{ $revistaRelacionado->editorial }}"
              data-ciudadpais="{{ $revistaRelacionado->ciudad_pais }}"
              data-fecha="{{ $revistaRelacionado->fecha }}"
              data-nombrepersona="{{ $revistaRelacionado->nombre_persona }}"
              data-encargado="{{ $revistaRelacionado->encargado }}"
              data-usuariosseleccionados="{{ $revistaRelacionado->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revistaRelacionado->tipo_revista }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revistaRelacionado->fecha }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revistaRelacionado->titulo }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $revistaRelacionado->ciudad_pais }}</td>
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
        @if ($bimestrerevista == $currentBimester || $bimestrerevista == $previousBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('revistaEliminarR', $revistaRelacionado->id) }}">
                <i class="bi bi-trash">

                </i>
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
        @if ($bimestrerevista == $currentBimester)
        <td colspan='2' style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btneliminar"
              data-ideliminar="{{ route('revistaEliminarR', $revistaRelacionado->id) }}">
                <i class="bi bi-trash">
                </i>
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
<script src="{{ asset('js/revistas.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
