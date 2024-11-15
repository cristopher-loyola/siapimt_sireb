@extends('plantillas/plantillaresp')
@section('contenido')

<title>Reportes</title>
    {{-- Header de la vista  --}}
    <div class="text-center">
            <h2 id="title"> Reportes </h2>
            <br>
            <div>
    <p style="text-align: center; font-size: 1.2rem;"><strong>Periodo consultado:</strong> {{ $periodoConsultado }}</p>
</div>

@if ($sesionEspecial == 1)
<div>
    <p style="text-align: center; font-size: 1.2rem;"><strong>Sesión Especial Activa</strong></p>
</div>
@endif
        </div>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/menureportes.css') }}">
    <style>
        .mb-2 {
            font-size: 1.4rem;
        }
    </style>
</head>
<body>





<!-- Inicio de los modales, no sirven para nada xd -->


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

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Dependencia de vinculación</label>

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
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Actualizar comité</h1>
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

                    </div>
                </div>
                </div>

                <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Dependencia de vinculación</label>

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



<!-- Fin de los modales, no sirven para nada xd -->





  <!--///////////////////////modal para configurar el periodo a configurar/////////////////////// -->
  <div id="modal-container-configurar">
    <div class="modal-background">
        <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">¿Qué sexenio desea administrar?</h1>
        <br><br>
        <form action="" id="configForm">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <select class="select-list" name="sexenio" id="sexenio">
                            <option value="2010">2010 - 2015</option>
                            <option value="2011">2011 - 2016</option>
                            <option value="2012">2012 - 2017</option>
                            <option value="2013">2013 - 2018</option>
                            <option value="2014">2014 - 2019</option>
                            <option value="2015">2015 - 2020</option>
                            <option value="2016">2016 - 2021</option>
                            <option value="2017">2017 - 2022</option>
                            <option value="2018">2018 - 2023</option>
                            <option value="2019">2019 - 2024</option>
                            <option value="2020">2020 - 2025</option>
                            <option value="2021">2021 - 2026</option>
                            <option value="2022">2022 - 2027</option>
                            <option value="2023">2023 - 2028</option>
                            <option value="2024">2024 - 2029</option>
                            <option value="2025">2025 - 2030</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
            <button type="button" class="btn btn-danger" id="cancel-button-configurar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Regresar</button>
            <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold;"><i class="bi bi-check-lg"></i>Administrar</button>
            </div>
        </form>
        </div>
    </div>
  </div>


  <!--///////////////////////modal para configurar el periodo a configurar/////////////////////// -->
  <div id="modal-container-configurar2">
    <div class="modal-background">
        <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Elige el sexenio</h1>
        <br><br>
        <form action="" id="configForm2">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <select class="select-list" name="sexenio" id="sexenio">
                            <option value="2010">2010 - 2015</option>
                            <option value="2011">2011 - 2016</option>
                            <option value="2012">2012 - 2017</option>
                            <option value="2013">2013 - 2018</option>
                            <option value="2014">2014 - 2019</option>
                            <option value="2015">2015 - 2020</option>
                            <option value="2016">2016 - 2021</option>
                            <option value="2017">2017 - 2022</option>
                            <option value="2018">2018 - 2023</option>
                            <option value="2019">2019 - 2024</option>
                            <option value="2020">2020 - 2025</option>
                            <option value="2021">2021 - 2026</option>
                            <option value="2022">2022 - 2027</option>
                            <option value="2023">2023 - 2028</option>
                            <option value="2024">2024 - 2029</option>
                            <option value="2025">2025 - 2030</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
            <button type="button" class="btn btn-danger" id="cancel-button-configurar2" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Regresar</button>
            <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold;"><i class="bi bi-check-lg"></i>Reporte</button>
            </div>
        </form>
        </div>
    </div>
  </div>








  <div class="d-flex justify-content-center">
    <div class="text-center">
        @if ($LoggedUserInfo['acceso'] == 2)
        {{-- Sección Personal --}}
        <div class="mb-2">
            <a href="#" onclick="toggleVisibility('personal')" id="personal-link">Personal</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" onclick="toggleVisibility('coordinacion')" id="coordinacion-link">Área</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" onclick="toggleVisibility('indicadores')" id="indicadores-link">Indicadores</a>
            <br><br>
        </div>

        <div id="personal" class="section-content">
            <button type="button" class="btn btn-outline-primary" onclick="location.href='reporte'">
                <i class="bi bi-file-pdf"></i> Reporte Bimestral de Actividades
            </button>
        </div>

        <div id="coordinacion" class="section-content">
            <button type="button" class="btn btn-outline-primary" onclick="location.href='reporteACVN'">
                <i class="bi bi-file-pdf"></i> Acciones de Vinculación
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="location.href='reporteACDF'">
                <i class="bi bi-file-pdf"></i> Acciones de Difusión
            </button>

            <button type="button" class="btn btn-outline-primary" onclick="location.href='reporteACCM'">
                <i class="bi bi-file-pdf"></i> Comités
            </button>
        </div>


        <div id="indicadores" class="section-content">
            <button type="button" id="btnconfigir" class="btn btn-outline-primary" 
              data-idconfig="{{ route('indicadoresrendimiento') }}">
                <i class="bi bi-graph-up"></i> Indicadores de rendimiento
            </button>
            <button type="button" id="btnconfigci" class="btn btn-outline-primary"
              data-idconfig="{{ route('reporteConfigIndicadores') }}">
                <i class="bi bi-gear"></i> Definir indicadores
            </button>

        </div>

        @elseif ($LoggedUserInfo['acceso'] == 3)
        {{-- Sección Personal --}}
        <button type="button" class="btn btn-outline-primary" onclick="location.href='reporte'">
            <i class="bi bi-file-pdf"></i> Reporte Bimestral de Actividades
        </button>
        @endif
    </div>
</div>







    </body>
</html>



@stop
@push('scripts')

<script src="{{ asset('js/menureportes.js') }}"></script>
<script>
    function toggleVisibility(id) {
        var elements = document.querySelectorAll('.section-content');
        elements.forEach(function (element) {
            if (element.id !== id) {
                element.classList.remove('active');
            }
        });

        var links = document.querySelectorAll('[id$="-link"]');
        links.forEach(function (link) {
            if (link.id !== id + "-link") {
                link.classList.remove('active');
            }
        });

        var element = document.getElementById(id);
        if (!element.classList.contains('active')) {
            element.classList.add('active');
            document.getElementById(id + "-link").classList.add("active");
        } else {
            element.classList.remove('active');
            document.getElementById(id + "-link").classList.remove("active");
        }
    }
</script>

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
