@ -0,0 +1,1236 @@
@extends('plantillas/plantillaresp')
@section('contenido')

<title>Servicios Tecnológicos</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Servicios Tecnológicos </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/serviciostecnologicos.css') }}">
    <style>
        .input-wrapper {
        position: relative;
        }

        .input-wrapper::after {
        content: "%";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        }

        .input-wrapperI {
        position: relative;
        }

        .input-wrapperI::after {
        content: "$";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        }

        .centrado {
        text-align: center;
        }

    </style>
</head>
    <body>




    <!--///////////////////////modal para un nuevo servicio/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nuevo servicio</h1>
        <br>
        <form action="{{route('nuevoserviciot')}}" method="POST">
          @csrf


          <div class="row">
            <div class="col-md-6 ">
              <div class="mb-3">
                <label class="form-label">Encargado del servicio</label>
                <input id="encargadoservicio" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
              </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tipo de servicio</label>
                    <select id="nombreservicio" class="form-control" name="nombreservicio" placeholder="Título del servicio" required>
                        <option value="" disabled selected>Seleccione el servicio</option>
                        @foreach ($ServiciostecnologicosAdmin as $Serviciostecnologicos)
                            <option value="{{ $Serviciostecnologicos->nombre }}">
                                {{ $Serviciostecnologicos->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
          </div>


           <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número del registro</label>
                  <input id="numeroregistro" type="text" class="form-control" name="numeroregistro" placeholder="Número del registro" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nombre del cliente</label>
                    <select name="nombrecliente" id="nombrecliente" class="form-control" required>
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
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Fecha de inicio</label>
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


            <div class="row" hidden>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número del convenio o contrato</label>
                  <input id="numerocontrato" type="text" class="form-control" name="numerocontrato" placeholder="Número del convenio o contrato" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Duración (Días)</label>
                  <input id="duracion" type="text" class="form-control" name="duracion" placeholder="Duración (días)" disabled pattern="[0-9]+" title="Ingrese solo números">
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Descripción del servicio</label>
                  <textarea id="servicio" type="text" class="form-control" name="servicio" placeholder="Descripción del servicio" required></textarea>
                </div>
              </div>

              <div class="col-md-6" hidden>
                <div class="mb-3">
                  <label class="form-label">Monto ($)</label>
                  <div class="input-wrapperI">
                    <input id="costo" type="text" class="form-control" name="costo" placeholder="0.00" disabled pattern="[0.00-9.00]+" title="Ingrese solo números">
                  </div>
                </div>
              </div>

            </div>

            <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
            <input id="area" type="hidden" class="form-control" name="area" value="{{$idarea}}">
            <input id="participacion" type="hidden" class="form-control" name="participacion" value="Lider">
            <input id="participacionusuario" type="hidden" class="form-control" name="participacionusuario" value="Integrante">

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















<!--///////////////////////modal para editar el servicio/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Editar servicio</h1>
      <br>
      <form action="" id="editarForm">
          @csrf

          @method('PUT')


          <div class="row">
            <div class="col-md-6 ">
              <div class="mb-3">
                <label class="form-label">Encargado del servicio</label>
                <input id="encargadoservicioedit" class="form-control" name="encargadoservicio" value="{{$LoggedUserInfo['Nombre']}} {{$LoggedUserInfo['Apellido_Paterno']}} {{$LoggedUserInfo['Apellido_Materno']}}" required readonly>
              </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tipo de servicio</label>
                  <select id="nombreservicioedit" class="form-control" name="nombreservicio" value="Titulo del servicio" placeholder="Título del servicio" required>
                    <option value="" disabled selected>Seleccione el servicio</option>
                        @foreach ($ServiciostecnologicosAdmin as $Serviciostecnologicos)
                            <option value="{{ $Serviciostecnologicos->nombre }}">
                                {{ $Serviciostecnologicos->nombre }}
                            </option>
                        @endforeach
                  </select>
                </div>
              </div>
           </div>

           <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número del registro</label>
                  <input id="numeroregistroedit" type="text" class="form-control" name="numeroregistro" placeholder="Número del registro" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nombre del cliente</label>
                  <select name="nombrecliente" id="nombreclienteedit" class="form-control" required>
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
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Fecha de inicio</label>
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


            <div class="row" hidden>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número del convenio o contrato</label>
                  <input id="numerocontratoedit" type="text" class="form-control" name="numerocontrato" placeholder="Número del convenio o contrato" disabled>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Duración del servicio (Días) </label>
                  <input id="duracionedit" type="text" class="form-control" name="duracion" placeholder="Duración del servicio"  disabled pattern="[0-9]+" title="Ingrese solo números">
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Descripción del servicio</label>
                  <textarea id="servicioedit" type="text" class="form-control" name="servicio" placeholder="Servicio" required></textarea>
                </div>
              </div>

              <div class="col-md-6" hidden>
                <div class="mb-3">
                  <label class="form-label">Costo ($)</label>
                  <div class="input-wrapperI">
                    <input id="costoedit" type="text" class="form-control" name="costo" placeholder="Costo" disabled pattern="[0.00-9.00]+" title="Ingrese solo números">
                  </div>
                </div>
              </div>
            </div>

            <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
            <input id="porcentajeedit" type="hidden" class="form-control" name="porcentaje">

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
        <div class="modal-header" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold; ">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Información del servicio</h5>
          </div>

          <div class="modal-body">

                <div class="row">
                <div class="col-md-6 " style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Encargado del servicio</label>
                        <p type="text" class="form-control" id="encargadoservicioviz" readonly></p>
                    </div>
                </div>

                <div class="col-md-6 ">
                    <div class="mb-3">
                        <label class="form-label">Título del servicio</label>
                        <p type="text" class="form-control" id="nombreservicioviz" readonly></p>
                    </div>
                </div>
                </div>


               <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Número del registro</label>
                    <p type="text" class="form-control" id="numeroregistroviz" readonly></p>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombre del cliente</label>
                        <p type="text" class="form-control" id="nombreregistroviz" readonly></p>
                    </div>
                </div>
              </div>


              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Fecha de inicio</label>
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
                <div class="col-md-6" hidden>
                  <div class="mb-3">
                    <label class="form-label">Número del convenio o contrato</label>
                    <p type="text" class="form-control" id="numerocontratoviz" readonly></p>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3" hidden>
                    <label class="form-label">Duración (Días)</label>
                    <p type="text" class="form-control" id="duracionviz" readonly></p>
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label">Descripción del servicio</label>
                    <p type="text" class="form-control" id="servicioviz" readonly></p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3" hidden>
                    <label class="form-label">Monto ($)</label>
                    <div class="input-wrapperI">
                    <p type="text" class="form-control" id="costoviz" readonly></p>
                    </div>
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



              <input id="nombre_persona" type="hidden" class="form-control" name="nombre_persona" value="{{ $LoggedUserInfo['usuario']}}">
              <input id="participacion" type="hidden" class="form-control" name="participacion" value="Lider">
              <input id="participacionusuario" type="hidden" class="form-control" name="participacionusuario" value="Integrante">



              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cancel-button-vizualizar"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i> Volver</button>
              </div>
          </div>
        </div>
      </div>
    </div>



















    <!--///////////////////////modal para el avance del servicio del lider/////////////////////// -->
<div id="modal-container-avance">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Avance del servicio</h1>
      <br><br>
      <form action="" id="avanceFormR">
        @csrf

          <div class="row">
            <div class="col-md-12 ">
              <div class="mb-3">
                <label class="form-label">Título del servicio</label>
                <input id="nombreservicioavance" class="form-control" name="nombreservicio" placeholder="Titulo del servicio" required disabled>
              </div>
            </div>
          </div>


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número del registro</label>
                  <input id="numeroregistroavance" type="text" class="form-control" name="numeroregistro" placeholder="Numero del registro" required disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Participación</label>
                  <input id="participacionavance" type="text" class="form-control" name="participacionavance" required disabled>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Porcentaje de avance</label>
                    <div>
                        <select id="porcentajeavance" class="form-control" name="porcentaje" required>
                            <option value="" hidden>0%</option>
                        </select>
                      </div>
                  </div>
                </div>
              </div>

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label">Actividades realizadas en el periodo</label>
                <textarea id="descripcionavance" class="form-control" name="descripcion" placeholder="Actividades realizadas en el periodo" oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
              </div>
            </div>
          </div>


          <input id="registro_idedit" type="hidden" class="form-control" name="registro_id" >


        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-avance" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
          <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i></i>Registrar avance</button>
        </div>
      </form>
    </div>
  </div>
</div>




















    <!--///////////////////////modal para el avance del servicio del integrante/////////////////////// -->
    <div id="modal-container-avance-integrante">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Avance del servicio</h1>
      <br><br>
      <form action="" id="avanceFormR2">
        @csrf

          <div class="row">
            <div class="col-md-12 ">
              <div class="mb-3">
                <label class="form-label">Título del servicio</label>
                <input id="nombreservicioavance2" class="form-control" name="nombreservicio" placeholder="Titulo del servicio" required disabled>
              </div>
            </div>
          </div>


            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Número del registro</label>
                  <input id="numeroregistroavance2" type="text" class="form-control" name="numeroregistro" placeholder="Numero del registro" required disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Participación</label>
                  <input id="participacionavance2" type="text" class="form-control" name="participacionavance" required disabled>
                </div>
              </div>
            </div>


          <div class="row">
            <div class="col-md-12 ">
              <div class="mb-3">
                <label class="form-label">Actividades realizadas en el periodo</label>
                <textarea id="descripcionavance2" type="text" class="form-control" name="descripcion" placeholder="Actividades realizadas en el periodo" oninput="autoResizeTextarea(this)" style="overflow:hidden" required></textarea>
              </div>
            </div>
          </div>


          <input id="registro_idedit2" type="hidden" class="form-control" name="registro_idusuarios">


        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-avance-integrante" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
          <button type="submit" class="btn btn-warning" style="color: #FFFFFF; font-weight: bold;"><i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>Registrar avance</button>
        </div>
      </form>
    </div>
  </div>
</div>



















<input type="hidden" id="sesionEspecial" data-sesion-especial="{{ $sesionEspecial }}" value="{{ $sesionEspecial }}">

<!--///////////////////////Boton para un nuevo servicio/////////////////////// -->
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
  <div class="buttons">
    <div id="five" class="button"><button> <i class="bi bi-plus-circle"></i> Nuevo </button></div>
  </div>
</div>
@endif
@else
@if ($fechabimestre->bimestre === $fechabimestre2->bimestre)
<div class="content">
  <div class="buttons">
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
<table class="table" id="serviciostTable">
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
        <th scope="col" style='text-align: center; vertical-align: middle;'>Número del registro</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Cliente</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Título</th>
        @if ($sesionEspecial == 1)
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)
        <th scope="col" style='text-align: center; vertical-align: middle;'>Avance</th>
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">Acciones</th>
        @endif
        @else
        @if ($fechabimestre->bimestre === $fechabimestre2->bimestre)
        <th scope="col" style='text-align: center; vertical-align: middle;'>Avance</th>
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">Acciones</th>
        @endif
        @endif
    </tr>
</thead>
  <tbody>




  @foreach($serviciotecnologico as $serviciotecnologicos)
  @php
    $fechainicio = $serviciotecnologicos->fechainicio;
    $fechafin = $serviciotecnologicos->fechafin;
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
        <button type="button" id="btnviz" class="btn"
          data-id="{{ $serviciotecnologicos->id }}"
          data-nombrepersona="{{ $serviciotecnologicos->nombre_persona }}"
          data-numeroregistro="{{ $serviciotecnologicos->numeroregistro }}"
          data-nombrecliente="{{ $serviciotecnologicos->nombrecliente }}"
          data-servicio="{{ $serviciotecnologicos->servicio }}"
          data-costo="{{ $serviciotecnologicos->costo }}"
          data-numerococ="{{ $serviciotecnologicos->numerococ }}"
          data-fechainicio="{{ $serviciotecnologicos->fechainicio }}"
          data-encargado="{{ $serviciotecnologicos->encargado }}"
          data-fechafin="{{ $serviciotecnologicos->fechafin }}"
          data-duracion="{{ $serviciotecnologicos->duracion }}"
          data-usuariosseleccionados="{{ $serviciotecnologicos->participantes }}"
          data-nombreservicio="{{ $serviciotecnologicos->nombreservicio }}">
          <i class="bi bi-info-circle"></i>
        </button>
    </td>
    <td style='text-align: center; vertical-align: middle;'>{{$serviciotecnologicos->numeroregistro}}</td>
    <td style='text-align: center; vertical-align: middle;'>{{$serviciotecnologicos->nombrecliente}}</td>
    <td style='text-align: center; vertical-align: middle;'>{{$serviciotecnologicos->nombreservicio}}</td>
    @if ($sesionEspecial == 1)
    @if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)
    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-avance" class="button-avance btn">
        <button type="button" id="btnavance" class="btn btn-info"
            data-id="{{ $serviciotecnologicos->id }}"
            data-numeroregistro="{{ $serviciotecnologicos->numeroregistro }}"
            data-participacion="{{ $serviciotecnologicos->participacion }}"
            data-nombreservicio="{{ $serviciotecnologicos->nombreservicio }}"
            data-descripcion="{{ $serviciotecnologicos->descripcion }}"
            data-porcentaje="{{ $serviciotecnologicos->porcentaje }}"
            data-idavance="{{ route('serviciotEditarDescripcion', $serviciotecnologicos->id) }}">
            <i class="bi bi-calendar2-range"></i>
        </button>
      </div>
    </td>
    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-editar" class="button-editar btn">
        <button type="button" id="btnedit" class="button-editar btn"
            data-id="{{ $serviciotecnologicos->id }}"
            data-nombrepersona="{{ $serviciotecnologicos->nombre_persona }}"
            data-numeroregistro="{{ $serviciotecnologicos->numeroregistro }}"
            data-nombrecliente="{{ $serviciotecnologicos->nombrecliente }}"
            data-servicio="{{ $serviciotecnologicos->servicio }}"
            data-costo="{{ $serviciotecnologicos->costo }}"
            data-numerococ="{{ $serviciotecnologicos->numerococ }}"
            data-fechainicio="{{ $serviciotecnologicos->fechainicio }}"
            data-fechafin="{{ $serviciotecnologicos->fechafin }}"
            data-duracion="{{ $serviciotecnologicos->duracion }}"
            data-nombreservicio="{{ $serviciotecnologicos->nombreservicio }}"
            data-porcentaje="{{ $serviciotecnologicos->porcentaje }}"
            data-usuariosseleccionados="{{ $serviciotecnologicos->participantes }}"
            data-action="{{ route('serviciotEditar', $serviciotecnologicos->id) }}">
            <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
        </button>
      </div>
    </td>
    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-eliminar" class="button-eliminar btn">
        <button type="button" id="btnelimR" class="btn btn-danger"
        data-idelim="{{ route('serviciotEliminar', $serviciotecnologicos->id) }}">
            <i class="bi bi-trash"></i>
        </button>
      </div>
    </td>
    @endif
    @else
    @if ($fechabimestre->bimestre === $fechabimestre2->bimestre)
    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-avance" class="button-avance btn">
        <button type="button" id="btnavance" class="btn btn-info"
            data-id="{{ $serviciotecnologicos->id }}"
            data-numeroregistro="{{ $serviciotecnologicos->numeroregistro }}"
            data-participacion="{{ $serviciotecnologicos->participacion }}"
            data-nombreservicio="{{ $serviciotecnologicos->nombreservicio }}"
            data-descripcion="{{ $serviciotecnologicos->descripcion }}"
            data-porcentaje="{{ $serviciotecnologicos->porcentaje }}"
            data-idavance="{{ route('serviciotEditarDescripcion', $serviciotecnologicos->id) }}">
            <i class="bi bi-calendar2-range"></i>
        </button>
      </div>
    </td>
    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-editar" class="button-editar btn">
        <button type="button" id="btnedit" class="button-editar btn"
            data-id="{{ $serviciotecnologicos->id }}"
            data-nombrepersona="{{ $serviciotecnologicos->nombre_persona }}"
            data-numeroregistro="{{ $serviciotecnologicos->numeroregistro }}"
            data-nombrecliente="{{ $serviciotecnologicos->nombrecliente }}"
            data-servicio="{{ $serviciotecnologicos->servicio }}"
            data-costo="{{ $serviciotecnologicos->costo }}"
            data-numerococ="{{ $serviciotecnologicos->numerococ }}"
            data-fechainicio="{{ $serviciotecnologicos->fechainicio }}"
            data-fechafin="{{ $serviciotecnologicos->fechafin }}"
            data-duracion="{{ $serviciotecnologicos->duracion }}"
            data-nombreservicio="{{ $serviciotecnologicos->nombreservicio }}"
            data-porcentaje="{{ $serviciotecnologicos->porcentaje }}"
            data-usuariosseleccionados="{{ $serviciotecnologicos->participantes }}"
            data-action="{{ route('serviciotEditar', $serviciotecnologicos->id) }}">
            <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
        </button>
      </div>
    </td>
    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-eliminar" class="button-eliminar btn">
        <button type="button" id="btnelimR" class="btn btn-danger"
        data-idelim="{{ route('serviciotEliminar', $serviciotecnologicos->id) }}">
            <i class="bi bi-trash"></i>
        </button>
      </div>
    </td>
    @endif
    @endif
  </tr>
  @endif
  @endforeach



  @foreach($serviciotecnologicoRelacionadas as $serviciotecnologicoRelacionada)
  @php
    $tdMostrado = false; // Inicializamos la variable de bandera como falsa
  @endphp
  @foreach($serviciotecnologicoDescripcion as $serviciotecnologicoDescripciones)
  @php
    $fechainicio = $serviciotecnologicoRelacionada->fechainicio;
    $fechafin = $serviciotecnologicoRelacionada->fechafin;
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
          data-id="{{ $serviciotecnologicoRelacionada->id }}"
          data-nombrepersona="{{ $serviciotecnologicoRelacionada->nombre_persona }}"
          data-numeroregistro="{{ $serviciotecnologicoRelacionada->numeroregistro }}"
          data-nombrecliente="{{ $serviciotecnologicoRelacionada->nombrecliente }}"
          data-servicio="{{ $serviciotecnologicoRelacionada->servicio }}"
          data-costo="{{ $serviciotecnologicoRelacionada->costo }}"
          data-numerococ="{{ $serviciotecnologicoRelacionada->numerococ }}"
          data-fechainicio="{{ $serviciotecnologicoRelacionada->fechainicio }}"
          data-encargado="{{ $serviciotecnologicoRelacionada->encargado }}"
          data-fechafin="{{ $serviciotecnologicoRelacionada->fechafin }}"
          data-duracion="{{ $serviciotecnologicoRelacionada->duracion }}"
          data-usuariosseleccionados="{{ $serviciotecnologicoRelacionada->participantes }}"
          data-nombreservicio="{{ $serviciotecnologicoRelacionada->nombreservicio }}">
          <i class="bi bi-info-circle"></i>
        </button>
    </td>
    <td style='text-align: center; vertical-align: middle;'>{{$serviciotecnologicoRelacionada->numeroregistro}}</td>
    <td style='text-align: center; vertical-align: middle;'>{{$serviciotecnologicoRelacionada->nombrecliente}}</td>
    <td style='text-align: center; vertical-align: middle;'>{{$serviciotecnologicoRelacionada->nombreservicio}}</td>
    @if ($sesionEspecial == 1)
    @if ($fechabimestre->bimestre === $fechabimestre2->bimestre || $fechabimestre->bimestre == $previousBimester)

    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-avance" class="button-avance btn">
        <button type="button" id="btnavance2" class="btn btn-info"
            data-id="{{ $serviciotecnologicoRelacionada->id }}"
            data-numeroregistro="{{ $serviciotecnologicoRelacionada->numeroregistro }}"
            data-participacion="{{ $serviciotecnologicoDescripciones->participacionusuario }}"
            data-nombreservicio="{{ $serviciotecnologicoRelacionada->nombreservicio }}"
            data-descripcion="{{ $serviciotecnologicoDescripciones->descripcionusuario }}"
            data-idavance2="{{ route('serviciotEditarDescripcionRelacion', $serviciotecnologicoRelacionada->id) }}">
            <i class="bi bi-calendar2-range"></i>
        </button>
      </div>
    </td>
    <td colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-eliminar" class="button-eliminar btn">
        <button type="button" id="btneliminar" class="btn btn-danger"
        data-ideliminar="{{ route('serviciotEliminarRelacion', $serviciotecnologicoRelacionada->id) }}">
            <i class="bi bi-trash"></i>
        </button>
      </div>
    </td>

    @endif
    @else
    @if ($fechabimestre->bimestre === $fechabimestre2->bimestre)

    <td style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-avance" class="button-avance btn">
        <button type="button" id="btnavance2" class="btn btn-info"
            data-id="{{ $serviciotecnologicoRelacionada->id }}"
            data-numeroregistro="{{ $serviciotecnologicoRelacionada->numeroregistro }}"
            data-participacion="{{ $serviciotecnologicoDescripciones->participacionusuario }}"
            data-nombreservicio="{{ $serviciotecnologicoRelacionada->nombreservicio }}"
            data-descripcion="{{ $serviciotecnologicoDescripciones->descripcionusuario }}"
            data-idavance2="{{ route('serviciotEditarDescripcionRelacion', $serviciotecnologicoRelacionada->id) }}">
            <i class="bi bi-calendar2-range"></i>
        </button>
      </div>
    </td>
    <td colspan='2' style='text-align: center; vertical-align: middle;' class="acciones-col">
      <div id="five-eliminar" class="button-eliminar btn">
        <button type="button" id="btneliminar" class="btn btn-danger"
        data-ideliminar="{{ route('serviciotEliminarRelacion', $serviciotecnologicoRelacionada->id) }}">
            <i class="bi bi-trash"></i>
        </button>
      </div>
    </td>

    @endif
    @endif
  </tr>
  @endif
  @php
  $tdMostrado = true; // Marca el registro como mostrado
  @endphp
  @endforeach
  @endforeach
    </tbody>
</table>



    </body>
</html>



@stop
@push('scripts')
<script>
    const nombreCompletoUsuario = @json($nombreCompleto); // Convierte el valor PHP en un valor JavaScript
    
    // Crear mapa de usuarios para la visualización de participantes
    @php
    $usersMap = [];
    foreach ($usuarios as $u) {
        $usersMap[$u->id] = trim($u->Apellido_Paterno.' '.$u->Apellido_Materno.' '.$u->Nombre);
    }
    @endphp
    const usersById = @json($usersMap);
    
    // Función mejorada para mostrar participantes en el modal de visualización
    function mostrarParticipantesEnVisualizacion(btn, encargado) {
        const participantesEl = document.getElementById('selected-options-paragraph-editar');
        if (!participantesEl) return;

        // Obtener datos de participantes del botón
        let raw = (btn.getAttribute('data-usuariosseleccionados') || '').trim();

        // Procesar los IDs de participantes
        let items = [];
        try {
            const maybe = JSON.parse(raw);
            if (Array.isArray(maybe)) items = maybe;
        } catch (_) {
            items = raw
                .replace(/\r/g, '')
                .split(/\n|,|;/g)
                .map(s => s.trim())
                .filter(Boolean);
        }

        // Convertir IDs a nombres
        const nombres = items.map(t => {
            const token = String(t).replace(/^\[?"+?|\]?"+?$/g, '').trim();
            if (/^\d+$/.test(token) && usersById[token]) return usersById[token];
            return token;
        }).filter(Boolean);

        // Crear lista final sin duplicados, con encargado al inicio
        const final = [];
        const seen = new Set();
        
        // Función para normalizar nombres para comparación
        const normaliza = (s) => s.toLowerCase().replace(/\s+/g, ' ').trim();
        
        // Función para escapar HTML
        const escapeHtml = (text) => {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, (m) => map[m]);
        };
        
        if (encargado) {
            final.push(encargado);
            seen.add(normaliza(encargado));
        }
        
        for (const n of nombres) {
            const k = normaliza(n);
            if (!seen.has(k)) {
                seen.add(k);
                final.push(n);
            }
        }

        // Mostrar participantes: encargado en negrita, resto en líneas nuevas
        if (final.length > 0) {
            participantesEl.innerHTML = final
                .map((p, i) => i === 0 ? '<strong>' + escapeHtml(p) + '</strong>' : escapeHtml(p))
                .join('\n');
        } else {
            participantesEl.textContent = "No hay ningún participante seleccionado";
        }
    }
</script>
<script src="{{ asset('js/serviciostecnologicos.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush