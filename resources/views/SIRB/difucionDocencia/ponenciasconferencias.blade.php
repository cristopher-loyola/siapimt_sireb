@extends('plantillas/plantillaresp')
@section('contenido')

<title>Ponencias y Conferencias</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Ponencias y Conferencias </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/ponenciasconferencias.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para una nueva Ponencias y Conferencias/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nueva ponencia / conferencia</h1>
        <br>
        <form action="{{route('nuevaponenciasconferencias')}}" method="POST">
          @csrf

          <div class="container">
            <div class="row" hidden>
                <div class="col-md-6 ">
                  <div class="mb-3">
                    <label class="form-label">Encargado</label>
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
                  <label class="form-label">Título</label>
                  <input id="titulopoco" type="text" class="form-control" name="titulopoco" placeholder="Título" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Entidad Organizadora</label>
                  <input id="entidad_O" type="text" class="form-control" name="entidad_O" placeholder="Entidad Organizadora" required>
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo</option>
                      <option value="Ponencia nacional">Ponencia nacional</option>
                      <option value="Conferencia nacional">Conferencia nacional</option>
                      <option value="Ponencia internacional">Ponencia internacional</option>
                      <option value="Conferencia internacional">Conferencia internacional</option>
                      <option value="Ponencia magistral">Ponencia magistral</option>
                      <option value="Conferencia magistral">Conferencia magistral</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de participación</label>
                    <select name="tipoparticipacion" id="tipoparticipacion" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo de participación</option>
                      <option value="Invitación">Invitación</option>
                      <option value="Iniciativa propia con arbitraje">Iniciativa propia con arbitraje</option>
                      <option value="Iniciativa propia sin arbitraje">Iniciativa propia sin arbitraje</option>
                    </select>
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


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fechaponente">Fecha de participación como ponente</label>
                  <input id="fechaponente" type="date" class="form-control" name="fechaponente" required disabled>
                </div>
              </div>

              <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Publicación de Ponencia o Conferencia</label>
                    <select name="publicacion" id="publicacion" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione la publicación</option>
                      <option value="Como artículo in extenso en versión impresa">Como artículo in extenso en versión impresa</option>
                      <option value="Como artículo in extenso en disco compacto">Como artículo in extenso en disco compacto</option>
                      <option value="Como artículo in extenso en internet">Como artículo in extenso en internet</option>
                      <option value="Sin formato de artículo in extenso en versión impresa">Sin formato de artículo in extenso en versión impresa</option>
                      <option value="Sin formato de artículo in extenso en disco compacto">Sin formato de artículo in extenso en disco compacto</option>
                      <option value="Sin formato de artículo in extenso en internet">Sin formato de artículo in extenso en internet</option>
                      <option value="No se publicaron memorias">No se publicaron memorias</option>
                    </select>
                  </div>
                </div>

                <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">

              </div>

              <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Nombre del evento</label>
                  <input id="nombreevento" type="text" class="form-control" name="nombreevento" placeholder="Nombre del evento" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Lugar del evento</label>
                  <input id="lugar" type="text" class="form-control" name="lugar" placeholder="Lugar del evento" required>
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










<!--///////////////////////modal para editar la Ponencia/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar ponencia / conferencia</h1>
      <br>
      <form action="" id="editarForm">
          @csrf

          @method('PUT')

          <div class="container">

            <div class="row" hidden>
                <div class="col-md-6 ">
                  <div class="mb-3">
                    <label class="form-label">Encargado del servicio</label>
                    <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
                  </div>
                </div>
               </div>


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input id="titulopocoedit" type="text" class="form-control" name="titulopoco" placeholder="Título" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Entidad Organizadora</label>
                  <input id="entidad_Oedit" type="text" class="form-control" name="entidad_O" placeholder="Entidad Organizadora" required>
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" id="tipoedit" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo</option>
                      <option value="Ponencia nacional">Ponencia nacional</option>
                      <option value="Conferencia nacional">Conferencia nacional</option>
                      <option value="Ponencia internacional">Ponencia internacional</option>
                      <option value="Conferencia internacional">Conferencia internacional</option>
                      <option value="Ponencia magistral">Ponencia magistral</option>
                      <option value="Conferencia magistral">Conferencia magistral</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Tipo de participación</label>
                    <select name="tipoparticipacion" id="tipoparticipacionedit" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione el tipo de participación</option>
                      <option value="Invitación">Invitación</option>
                      <option value="Iniciativa propia con arbitraje">Iniciativa propia con arbitraje</option>
                      <option value="Iniciativa propia sin arbitraje">Iniciativa propia sin arbitraje</option>
                    </select>
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


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fechafin">Fecha de participación como ponente</label>
                  <input id="fechaponenteedit" type="date" class="form-control" name="fechaponente" required>
                </div>
              </div>

              <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Publicación de Ponencia o Conferencia</label>
                    <select name="publicacion" id="publicacionedit" class="form-control" style="height: 47px;" required>
                      <option value="" disabled selected>Seleccione la publicación</option>
                      <option value="Como artículo in extenso en versión impresa">Como artículo in extenso en versión impresa</option>
                      <option value="Como artículo in extenso en disco compacto">Como artículo in extenso en disco compacto</option>
                      <option value="Como artículo in extenso en internet">Como artículo in extenso en internet</option>
                      <option value="Sin formato de artículo in extenso en versión impresa">Sin formato de artículo in extenso en versión impresa</option>
                      <option value="Sin formato de artículo in extenso en disco compacto">Sin formato de artículo in extenso en disco compacto</option>
                      <option value="Sin formato de artículo in extenso en internet">Sin formato de artículo in extenso en internet</option>
                      <option value="No se publicaron memorias">No se publicaron memorias</option>
                    </select>
                  </div>
                </div>

                <input id="nombre_personaedit" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">

              </div>

              <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Nombre del evento</label>
                  <input id="nombreeventoedit" type="text" class="form-control" name="nombreevento" placeholder="Nombre del evento" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Lugar del evento</label>
                  <input id="lugaredit" type="text" class="form-control" name="lugar" placeholder="Lugar del evento" required>
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


            </div>



          <div>
            <button type="button" class="btn btn-danger" id="cancel-button-editar" style=" color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
            <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Actualizar</button>
          </div>

        </form>
    </div>
  </div>
</div>









<!--///////////////////////modal para eliminar la Memoria/////////////////////// -->
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






<!--///////////////////////modal para ver toda la informacion de la Memoria/////////////////////// -->
<div id="modal-container-vizualizar">
<div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF;">
        <div class="modal-header" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información de ponencia / conferencia</h5>
          </div>

          <div class="modal-body">

            <div class="row" hidden>
                <div class="col-md-6 ">
                    <div class="mb-3">
                        <label class="form-label">Encargado del servicio</label>
                        <p type="text" class="form-control" id="encargadoservicioviz"></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Título</label>
                    <p type="text" class="form-control" id="tituloviz" readonly></p>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Entidad Organizadora</label>
                    <p type="text" class="form-control" id="entidadviz" readonly></p>
                </div>
                </div>
              </div>



              <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Tipo</label>
                      <p type="text" class="form-control" id="tipoponenciaviz" readonly></p>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Tipo de participación</label>
                      <p class="form-control" id="tipoparticipacionviz" readonly></p>
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


              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label bold" for="fechaponente">Fecha de participación</label>
                    <p class="form-control" id="fechaparticipacionviz" readonly></p>
                </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Publicación de Ponencia o Conferencia</label>
                      <p class="form-control" id="publicacionpocoviz" readonly></p>
                    </div>
                  </div>

                  <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">

                </div>

                <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label bold" for="fecha">Nombre del evento</label>
                    <p class="form-control" id="nombreeventoviz" readonly></p>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Lugar del evento</label>
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
              <th scope="col" style='text-align: center; vertical-align: middle;'>Tipo</th>
              <th scope="col" style='text-align: center; vertical-align: middle;'>Fecha</th>
              <th scope="col" style='text-align: center; vertical-align: middle;'>Título</th>
              <th scope="col" style='text-align: center; vertical-align: middle;'>Lugar</th>
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

  @foreach($ponenciasconferencias as $ponenciasconferencia)
  @php
        $fechaponenciasconferencia = $ponenciasconferencia->fecha_fin; // Obtener la fecha de la reunión en formato Y-m-d
        $mesponenciasconferencia = date("n", strtotime($fechaponenciasconferencia)); // Obtener el número de mes

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

        $bimestreponenciasconferencia = $bimestres[$mesponenciasconferencia] ?? ''; // Obtener el bimestre correspondiente
    @endphp
    <tr>
        <td style='text-align: center; vertical-align: middle;'>
            <button type="button" id="btnviz" class="btn btn-light"
            data-id="{{ $ponenciasconferencia->id }}"
            data-tipopc="{{ $ponenciasconferencia->tipo_PC }}"
            data-entidad="{{ $ponenciasconferencia->entidad_O }}"
            data-titulo="{{ $ponenciasconferencia->titulo }}"
            data-fechainicio="{{ $ponenciasconferencia->fecha_inicio }}"
            data-fechafin="{{ $ponenciasconferencia->fecha_fin }}"
            data-tipoparticipacion="{{ $ponenciasconferencia->tipo_participacion }}"
            data-publicacionpc="{{ $ponenciasconferencia->publicacion_PC }}"
            data-fechaponente="{{ $ponenciasconferencia->fecha_part_ponente }}"
            data-nombreevento="{{ $ponenciasconferencia->nombre_evento }}"
            data-lugarevento="{{ $ponenciasconferencia->lugar_evento }}"
            data-encargado="{{ $ponenciasconferencia->encargado }}"
            data-usuariosseleccionados="{{ $ponenciasconferencia->participantes }}">
              <i class="bi bi-info-circle"></i>
            </button>
        </td>
        <td style='text-align: center; vertical-align: middle;'>{{$ponenciasconferencia->tipo_participacion}}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $ponenciasconferencia->fecha_part_ponente }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $ponenciasconferencia->titulo }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $ponenciasconferencia->lugar_evento }}</td>
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
        @if ($bimestreponenciasconferencia == $currentBimester || $bimestreponenciasconferencia == $previousBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $ponenciasconferencia->id }}"
              data-tipopc="{{ $ponenciasconferencia->tipo_PC }}"
              data-entidad="{{ $ponenciasconferencia->entidad_O }}"
              data-titulo="{{ $ponenciasconferencia->titulo }}"
              data-fechainicio="{{ $ponenciasconferencia->fecha_inicio }}"
              data-fechafin="{{ $ponenciasconferencia->fecha_fin }}"
              data-tipoparticipacion="{{ $ponenciasconferencia->tipo_participacion }}"
              data-publicacionpc="{{ $ponenciasconferencia->publicacion_PC }}"
              data-fechaponente="{{ $ponenciasconferencia->fecha_part_ponente }}"
              data-nombreevento="{{ $ponenciasconferencia->nombre_evento }}"
              data-lugarevento="{{ $ponenciasconferencia->lugar_evento }}"
              data-usuariosseleccionados="{{ $ponenciasconferencia->participantes }}"
              data-action="{{ route('ponenciasconferenciasEditar', $ponenciasconferencia->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimRe"
              data-idelimre="{{ route('ponenciasconferenciasEliminar', $ponenciasconferencia->id) }}">
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
        @if ($bimestreponenciasconferencia == $currentBimester)
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btnedit" class="button-editar btn btn-warning"
              data-id="{{ $ponenciasconferencia->id }}"
              data-tipopc="{{ $ponenciasconferencia->tipo_PC }}"
              data-entidad="{{ $ponenciasconferencia->entidad_O }}"
              data-titulo="{{ $ponenciasconferencia->titulo }}"
              data-fechainicio="{{ $ponenciasconferencia->fecha_inicio }}"
              data-fechafin="{{ $ponenciasconferencia->fecha_fin }}"
              data-tipoparticipacion="{{ $ponenciasconferencia->tipo_participacion }}"
              data-publicacionpc="{{ $ponenciasconferencia->publicacion_PC }}"
              data-fechaponente="{{ $ponenciasconferencia->fecha_part_ponente }}"
              data-nombreevento="{{ $ponenciasconferencia->nombre_evento }}"
              data-lugarevento="{{ $ponenciasconferencia->lugar_evento }}"
              data-usuariosseleccionados="{{ $ponenciasconferencia->participantes }}"
              data-action="{{ route('ponenciasconferenciasEditar', $ponenciasconferencia->id) }}">
              <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="btn">
            <button type="button" id="btnelimRe"
              data-idelimre="{{ route('ponenciasconferenciasEliminar', $ponenciasconferencia->id) }}">
                <i class="bi bi-trash">

                </i>
            </button>
          </div>
        </td>
        @endif
        @endif
    </tr>
  @endforeach





@foreach($ponenciasconferenciasRelacionadas as $ponenciasconferenciasRelacionada)
  @php
    $tdMostrado = false; // Inicializamos la variable de bandera como falsa
  @endphp

  @php
    $fechainicio = $ponenciasconferenciasRelacionada->fecha_inicio;
    $fechafin = $ponenciasconferenciasRelacionada->fecha_fin;
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

  @if (in_array($currentBimestre, $bimestresCubiertos) && !$tdMostrado)
  <tr>
    <td style='text-align: center; vertical-align: middle;'>
        <button type="button" id="btnviz" class="btn"
        data-id="{{ $ponenciasconferenciasRelacionada->id }}"
        data-tipopc="{{ $ponenciasconferenciasRelacionada->tipo_PC }}"
        data-entidad="{{ $ponenciasconferenciasRelacionada->entidad_O }}"
        data-titulo="{{ $ponenciasconferenciasRelacionada->titulo }}"
        data-fechainicio="{{ $ponenciasconferenciasRelacionada->fecha_inicio }}"
        data-fechafin="{{ $ponenciasconferenciasRelacionada->fecha_fin }}"
        data-tipoparticipacion="{{ $ponenciasconferenciasRelacionada->tipo_participacion }}"
        data-publicacionpc="{{ $ponenciasconferenciasRelacionada->publicacion_PC }}"
        data-fechaponente="{{ $ponenciasconferenciasRelacionada->fecha_part_ponente }}"
        data-nombreevento="{{ $ponenciasconferenciasRelacionada->nombre_evento }}"
        data-lugarevento="{{ $ponenciasconferenciasRelacionada->lugar_evento }}"
        data-encargado="{{ $ponenciasconferenciasRelacionada->encargado }}"
        data-usuariosseleccionados="{{ $ponenciasconferenciasRelacionada->participantes }}">
          <i class="bi bi-info-circle"></i>
        </button>
    </td>
    <td style='text-align: center; vertical-align: middle;'>{{$ponenciasconferenciasRelacionada->tipo_participacion}} </td>
    <td style='text-align: center; vertical-align: middle;'>{{ $ponenciasconferenciasRelacionada->fecha_part_ponente }}</td>
    <td style='text-align: center; vertical-align: middle;'>{{ $ponenciasconferenciasRelacionada->titulo }}</td>
    <td style='text-align: center; vertical-align: middle;'>{{ $ponenciasconferenciasRelacionada->lugar_evento }}</td>

    @if ($sesionEspecial == 1)
    @if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)


    <td colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-eliminar" class="button-eliminar btn">
        <button type="button" id="btneliminar" class="btn btn-danger"
        data-ideliminar="{{ route('ponenciasconferenciaEliminarRelacion', $ponenciasconferenciasRelacionada->id) }}">
            <i class="bi bi-trash"></i>
        </button>
      </div>
    </td>

    @endif
    @else
    @if ($fechabimestre->bimestre === $fechabimestre2->bimestre)

    <td colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">
        <div id="five-eliminar" class="button-eliminar btn">
          <button type="button" id="btneliminar" class="btn btn-danger"
          data-ideliminar="{{ route('ponenciasconferenciaEliminarRelacion', $ponenciasconferenciasRelacionada->id) }}">
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


@stop
@push('scripts')
<script>
    const nombreCompletoUsuario = @json($nombreCompleto); // Convierte el valor PHP en un valor JavaScript
</script>
<script src="{{ asset('js/ponenciasconferencias.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
