@extends('plantillas/plantillaalt')
@section('contenido')
<title>Programa de actividades de {{$proyt->nomproy}}</title>

{{-- Navegadir nuevas vistta Inicio --}}
<style>
  .sidebar {
      width: 150px;
      height: 100vh;
      background-color: #001F5B;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between; /* Esto distribuye los elementos a lo largo del sidebar */
      padding-top: 20px;
  }

  .sidebar-header {
      margin-bottom: 20px;
  }

  .sidebar-icon {
      width: 80px;
      object-fit: cover;
  }

  /* Alineamos las pestañas al centro */
  .sidebar-menu {
      list-style-type: none;
      padding: 0;
      margin: 0;
      width: 100%;
      display: flex;
      flex-direction: column; /* Alinea las pestañas verticalmente */
      justify-content: center; /* Alinea verticalmente el contenido en el centro */
      align-items: center; /* Alinea los ítems de forma horizontal */
      flex-grow: 1; /* Asegura que las pestañas ocupen el espacio restante */
  }

  .sidebar-item {
      width: 100%;
      text-align: center;
      padding: 10px 0;
      position: relative;
  }

  .sidebar-item a {
      text-decoration: none;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      width: 100%;
  }

  .sidebar-image {
      width: 30px;
      height: 30px;
      object-fit: cover;
      margin-bottom: 5px;
  }


  .sidebar-item-cancel {
      width: 100%;
      text-align: center;
      padding: 10px 0;
      position: relative;
      background: #282828;
  }

  .sidebar-item-cancel a {
      text-decoration: none;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      width: 100%;
  }

  .sidebar-item-success {
      width: 100%;
      text-align: center;
      padding: 10px 0;
      position: relative;
      background: #1e7e19;
  }

  .sidebar-item-success a {
      text-decoration: none;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      width: 100%;
  }

  /* Efecto de iluminación y tooltip */
  .sidebar-item:hover {
      background-color: #143882;
      cursor: pointer;
  }

  .sidebar-item.active {
      background-color: #007bff;
  }

  .sidebar-item.active .tooltip {
      background-color: #007bff;
  }

  .sidebar-item-cancel:hover {
      background-color: #3c3c3c;
      cursor: pointer;
  }

  .sidebar-item-success:hover {
      background-color: #1e7e19;
      cursor: pointer;
  }

  .tooltip {
      position: absolute;
      top: 50%;
      left: 90%;
      height: 170%;
      height: 120%;
      transform: translateY(-50%);
      background-color: #143882;
      padding: 5px;
      border-radius: 3px;
      white-space: nowrap;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s;
      margin-left: 10px;
      z-index: 10;

      /* Centrar el texto dentro del tooltip */
      display: flex;
      align-items: center; /* Centra verticalmente */
      justify-content: center; /* Centra horizontalmente */
  }

  .sidebar-item:hover .tooltip {
      opacity: 1;
  }

  .sidebar-item-success:hover .tooltip {
      opacity: 1;
  }

  .sidebar-item-cancel:hover .tooltip {
      opacity: 1;
  }

  /* Tooltip específico para la pestaña activa */
  .sidebar-item.active:hover .tooltip {
      background-color: #007bff;
      color: white;
  }

  .sidebar-item-success:hover .tooltip {
      background-color: #1e7e19;
      color: white;
  }

  .sidebar-item-cancel:hover .tooltip {
      background-color: #3c3c3c;
      color: white;
  }

  /* Estilo para el botón de logout */
  .logout-btn {
      margin-top: auto;
      padding: 10px 20px;
      background-color: #ff4c4c;
      color: white;
      border: none;
      border-radius: 5px;
      width: 100%;
      cursor: pointer;
  }

  .logout-btn:hover {
      background-color: #ff2a2a;
  }

  /* Ajustar a la ventana */
  @media (max-width: 768px) {
      .sidebar {
          width: 200px;
      }

      .sidebar-menu {
          padding-left: 20px;
      }

      .sidebar-item a {
          flex-direction: row;
      }

      .sidebar-image {
          margin-bottom: 0;
          margin-right: 10px;
      }
  }
</style>
<div class="sidebar">
<div class="sidebar-header">
    <img src="{{asset('/img/Logo_blanco.png')}}" alt="Icono" class="sidebar-icon">
</div>
<ul class="sidebar-menu">
    <li
    @if ($proyt->completado != 0)
        class="sidebar-item-success"
    @else
        class="sidebar-item"
    @endif
    id="item1">
        <a href="{{route('proydatos', $proyt->id)}}" class="sidebar-link">
            <img src="{{asset('/img/info-gnrl.png')}}" alt="Información general" class="sidebar-image">
            <span class="tooltip">Información general</span>
        </a>
    </li>
    @if (($proyt->clavet == 'I' ||$proyt->clavet == 'E') && ($proyt->clavea == 'D' || $proyt->clavea == 'A' || $proyt->clavea == 'G'))
      <li
            @if ($vequipo != 0 || $proyt->colaboradores == 1)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item3">
                <a href="{{ route('Equipo', $proyt->id) }}" class="sidebar-link">
                    <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                    <span class="tooltip">Participantes</span>
                </a>
            </li>
            <li class="sidebar-item active"id="item4">
                <a href="{{ route('tareag', $proyt->id) }}" class="sidebar-link">
                    <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                    <span class="tooltip">Programa de actividades</span>
                </a>
            </li>
          <li
          @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item5">
              <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                  <span class="tooltip">Propuesta económica</span>
              </a>
          </li>
          <li
          @if ($vriesgo != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item6">
              <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                  <span class="tooltip">Análisis de riesgos</span>
              </a>
          </li>
          <li class="sidebar-item-cancel" id="item7">
              <a href="{{route('infoproys',$proyt->id)}}">
                  <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                  <span class="tooltip">Información del Proyecto</span>
              </a>
          </li>
    @elseif ($proyt->clavet == 'I')
          {{-- Cambiar en las formas de mostrar el impacto --}}
          @if ($proyt->actimpacto == 1)
              <li
              @if ($vimpacto!= 0)
                  class="sidebar-item-success"
              @else
                  class="sidebar-item"
              @endif
              id="item2">
                  <a href="{{ route('impactoproy', $proyt->id) }}" class="sidebar-link">
                      <img src="{{asset('/img/impactosoceco.png')}}" alt="Plan de actividades" class="sidebar-image">
                      <span class="tooltip">Impacto Socioeconómico</span>
                  </a>
              </li>
            @endif
          <li
          @if ($vcontri != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item3">
              <a @if ($proyt->completado != 0) href="{{ route('contribuciones', $proyt->id)}}" @endif class="sidebar-link">
                  <img src="{{asset('/img/contribuciones.png')}}" alt="Contribuciones a…" class="sidebar-image">
                  <span class="tooltip">Contribuciones a…</span>
              </a>
          </li>

          <li
          @if ($vequipo != 0 || $proyt->colaboradores == 1)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item4">
              <a href="{{ route('Equipo', $proyt->id) }}" class="sidebar-link">
                  <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                  <span class="tooltip">Participantes</span>
              </a>
          </li>
          <li class="sidebar-item active"id="item5">
              <a href="{{ route('tareag', $proyt->id) }}" class="sidebar-link">
                  <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                  <span class="tooltip">Programa de actividades</span>
              </a>
          </li>
          <li
          @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item6">
              <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                  <span class="tooltip">Propuesta económica</span>
              </a>
          </li>
          <li
          @if ($vriesgo != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item7">
              <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                  <span class="tooltip">Análisis de riesgos</span>
              </a>
          </li>
          <li class="sidebar-item-cancel" id="item7">
              <a href="{{route('infoproys',$proyt->id)}}">
                  <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                  <span class="tooltip">Información del Proyecto</span>
              </a>
          </li>
    @else
          <li
          @if ($vcontri != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item2">
              <a @if ($vcontri != 0) href="{{ route('contribuciones', $proyt->id)}}" @endif class="sidebar-link">
                  <img src="{{asset('/img/contribuciones.png')}}" alt="Contribuciones a…" class="sidebar-image">
                  <span class="tooltip">Contribuciones a…</span>
              </a>
          </li>
           <li
            @if ($vequipo != 0 || $proyt->colaboradores == 1)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item3">
                <a href="{{ route('Equipo', $proyt->id) }}" class="sidebar-link">
                    <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                    <span class="tooltip">Participantes</span>
                </a>
            </li>
            <li class="sidebar-item active"id="item4">
                <a href="{{ route('tareag', $proyt->id) }}" class="sidebar-link">
                    <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                    <span class="tooltip">Programa de actividades</span>
                </a>
            </li>
          <li
          @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item5">
              <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                  <span class="tooltip">Propuesta económica</span>
              </a>
          </li>
          <li
          @if ($vriesgo != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item6">
              <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                  <span class="tooltip">Análisis de riesgos</span>
              </a>
          </li>
          <li class="sidebar-item-cancel" id="item7">
              <a href="{{route('infoproys',$proyt->id)}}">
                  <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                  <span class="tooltip">Información del Proyecto</span>
              </a>
          </li>
        @endif
    </ul>
</div>
{{-- Navegadir nuevas vistta Fin --}}

        <div><h4 class="fw-bold text-center py-5" id="tituloform">Programa de actividades</h4>
	<td style='text-align:center;'>
	<?php
		if ($proyt->claven < 10) {
 			echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
    	}	else {	echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
      }
	?>
	</td>
      <br>
      <div>
        <div class="mb-4">
            <div class="mb-1 input-group">
                {{-- <div>
                    <a href="{{ route('infoproys', $proyt->id)}}">
                    <button type="submit" class="btn btn-dark btn-sm" id="redondb">
                        <i class='bx bxs-chevron-left-circle bx-sm bx-flashing-hover'></i>
                        Info. proyecto
                        </button>
                    </a>
                </div>
                <div class="mb-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div> --}}
                <div>
                  @if ($proyt->estado == 0 || $proyt->estado == 4)
                    <a href="{{ route('tareas', $proyt->id)}}">
                    <button type="submit" class="btn btn-success" id="redondb">
                        <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                        Nuevo
                    </button>
                    </a>
                  @endif
                </div>
                @if ($existen != 0)
                <div class="mb-2">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div>
                {{-- Mensaje de confirmacion para iniciar o reanudar proyecto --}}
                  @if ($proyt->estado == 0 || $proyt->estado == 4 || $proyt->estado == 3)
                    {{-- @if ($proyt->gprotocolo == 2) --}}
                      <button id="abrirModal" class="btn btn-primary" style="border-radius: 50em;">
                        <img src="{{URL::asset('img/start.png')}}" width="25em" height="25em"
                        alt="" style="margin-bottom: .1em">
                        @if ($proyt->estado == 0 )
                          Iniciar
                        @elseif ($proyt->estado == 0 || $proyt->estado == 3)
                          Reanudar
                        @endif
                      </button>

                      <style>
                        .modal {
                          display: none; /* Por defecto, estará oculto */
                          justify-content: center; /*para centrar vertical y horizontalmente el modal */
                          align-items: center;
                          position: fixed; /* Posición fija */
                          z-index: 1; /* Se situará por encima de otros elementos de la página*/
                          left: 0;
                          top: 0;
                          width: 100%; /* Ancho completo */
                          height: 100%; /* Algura completa */
                          overflow: auto; /* Se activará el scroll si es necesario */
                          background-color: rgba(0,0,0,0.5); /* Color negro con opacidad del 50% */
                        }

                        .contenido-modal {
                          position: relative; /* Relativo con respecto al contenedor -modal- */
                          background-color: white;
                          margin: auto; /* Centrada */
                          padding: 50px;
                          width: 50vw;
                          -webkit-animation-name: animarsuperior;
                          -webkit-animation-duration: 0.5s;
                          animation-name: animarsuperior;
                          animation-duration: 0.5s;
                          border-radius: 25px;
                        }

                        /* Add Animation */
                        @-webkit-keyframes animatetop {
                          from {top:-300px; opacity:0} 
                          to {top:0; opacity:1}
                        }
                        @keyframes animarsuperior {
                          from {top:-300px; opacity:0}
                          to {top:0; opacity:1}
                        }

                        .close {
                          color: black;
                          float: right;
                          font-size: 30px;
                          font-weight: bold;
                        }

                        .close:hover,
                        .close:focus {
                          color: #000;
                          text-decoration: none;
                          cursor: pointer;
                        }

                      </style>
                      
                      <div id="ventanaModal" class="modal">
                        <div class="contenido-modal">
                            @if ($proyt->estado == 4 || $proyt->estado == 3)
                              <h2 style="color: #007BFF; font-weight: bold; text-align: center;">¿Está seguro de reanudar el proyecto?</h2>
                              <br>
                              <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">Al reanudar el proyecto no se podrán agregar, modificar o eliminar tareas, sólo reportar el avance.</p>
                              <br>
                            @else
                              <h2 style="color: #007BFF; font-weight: bold; text-align: center;">¿Está seguro de iniciar el proyecto?</h2>
                              <br>
                              <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">Al iniciar el proyecto no se podrán agregar, modificar o eliminar tareas, sólo reportar el avance.</p>
                              <br>
                              <p style="font-size: 1.3em; font-weight: bold; text-align:justify; color:#FF0000">Para realizar cambios, se tendrá que solicitar la autorización de reprogramación.</p>
                              <br>
                            @endif
                            <div style="text-align: center">
                              <span class="cerrar">
                                <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;">
                                  <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                                  No, regresar
                                </button>
                              </span>
                              &nbsp;&nbsp;
                              <a href="{{ route('iniciarproy', $proyt->id)}}">
                                <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold; text">
                                  <img src="{!! asset('img/plus.png')!!}" alt="" height="24em" width="24em">
                                  @if ($proyt->estado == 0 )
                                    Sí, iniciar
                                  @else
                                    Sí, reanudar
                                  @endif
                                </button>
                              </a>
                            </div>
                        </div>
                      </div>
                    {{-- @endif --}}

                  @endif
                {{-- Mensaje de confirmacion para iniciar o reanudar proyecto --}}
                </div>
                @endif
            </div>
        </div>
        
        <div>
            <table class="table table-hover">
              <caption></caption>
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Nombre de la tarea</th>
                  <th scope="col" class="">Fecha inicio</th>
                  <th scope="col" class="">Fecha fin</th>
                  {{-- @if ($proyt->gprotocolo == 2) --}}
                  @if ($proyt->estado != 0)
                    <th scope="col" class="">Avance</th>
                  @endif
                  @if ($proyt->estado == 0 || $proyt->estado == 4)
                    <th scope="col" class="">Actualizar</th>
                    <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                <label hidden>{{$r=0}}</label>
                @foreach ($tarea as $t)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $t->actividad }}</td>
                  <td>
                    {{ $t->fecha_inicio }}
                  </td>
                  <td>
                    {{ $t->fecha_fin }}
                  </td>
                  @if ($proyt->estado != 0)
                    <td>
                      <a
                      @if ($proyt->estado == 1)
                        href="{{ route('avance', [$proyt->id ,$t->id]) }}" method="get"
                      @endif
                      >
                        <div class="progress" style="height: 30px; background:#575656;">
                          <div 
                          @if ($proyt->estado == 5)
                              class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                          @elseif ($proyt->estado == 3)
                              class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                          @elseif ($proyt->estado == 2)
                              class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                          @else
                              class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                          @endif
                          role="progressbar" style="width: {{$t->progreso}}%" aria-valuenow="25"
                          aria-valuemin="0" aria-valuemax="100">
                          <strong>{{$t->progreso}}%</strong>
                          </div>
                        </div>
                      </a>
                    </td>
                  @endif
                  @if ($proyt->estado == 0 || $proyt->estado == 4)
                    <td>
                      <form action="{{ route('uptareas', [$proyt->id ,$t->id]) }}" method="get">
                        <button type="submit" class="btn btn-warning" id="redondb">
                          <i class='bx bxs-up-arrow-circle bx-fw bx-sm bx-flashing-hover'></i>
                        </button>
                      </form>
                    </td>
                    <td>
                      <form action="{{ route('destroytarea', [$proyt->id,$t ->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="redondb">
                          <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                        </button>
                      </form>
                    </td>
                  @endif
                </tr>
                <label hidden>{{$r++}}</label>
                @endforeach
                </tbody>
            </table>
            <label hidden> {{$r}}</label>
        <br>
      </div>
    {{--
      <style>
        #crono{
          overflow: scroll;
          overflow-y: auto;
          overflow-x: auto;
          overscroll-behavior-x:initial;
          overscroll-behavior-y:initial;
        }
        #cuadro{
          border-collapse: collapse;
          border-spacing: 0;
          border: 1px solid #000000;
          padding: 10px 20px;
        }
        #celdas, #celdas2, #celdast, #celdas2t{
          border: 1px solid #000000;
          padding: 10px 20px;
          text-overflow: ellipsis;
          white-space: nowrap;

        }
      </style>
      <div id="crono" name="crono" class="overflow-auto">
        <script>
          var lar = {{$r}}+1;
          var anh = {{$proyt->duracionm}}+2
          let table = document.createElement('table');
          table.setAttribute('id','cuadro');
          let thead = document.createElement('thead');
          let tbody = document.createElement('tbody');
          
          table.appendChild(thead);
          table.appendChild(tbody);
    
          document.getElementById('crono').appendChild(table);

          let row = document.createElement('tr');
          row.setAttribute('id','celdast');
          let headtext = document.createElement('th');
          headtext.setAttribute('id','celdast');
          headtext.innerHTML = "No.";
          let headtext1 = document.createElement('th');
          headtext1.setAttribute('id','celdas2t');
          headtext1.innerHTML = "Actividad";
          /*let headtext2 = document.createElement('th');
          headtext2.setAttribute('id','celdas2t');
          headtext2.innerHTML = "Fechas";*/
    
          row.appendChild(headtext);
          row.appendChild(headtext1);
          thead.appendChild(row);


          var c = 1;
          var ca = 1; // variable que define el contador de Actividad
          var can = 1; // variable que define el contador de No.
          /*Generador de tabla*/
          for( var i = 0; i < lar; i++){/*filas*/
            let row1 = document.createElement('tr');
            row1.setAttribute('id','celdas');
            var i1 = i+1;//Contador para las filas

            for( var j = 0; j < anh; j++){/*columnas*/
              /*
                Esta codigo genera el la posicion de las celdas
                let celda = document.createElement('th');
                celda.setAttribute('id','celdas2');
                celda.innerHTML = 'F'+i+'C'+j;
                row1.appendChild(celda);
              */
              if (j == 0 && i == 0 || j == 1 && i == 0) {
                //Define las posciones 0-0 y 0-1 como vacias
                let celda = document.createElement('th');
                celda.innerHTML = ' ';
                row1.appendChild(celda);
              }
              else if( j == 1 && i != 0){
                //La celdas que generan la columna de actividad
                let celda = document.createElement('th');
                celda.setAttribute('id','celdas2');
                celda.innerHTML = 'Actividad '+ca;
                row1.appendChild(celda);
                ca++;
              }
              else if (i <= i1 && j <= 1) {
                //La celdas que generan la columna de id
                let celda = document.createElement('th');
                celda.setAttribute('id','celdas2');
                celda.innerHTML = can;
                row1.appendChild(celda);
                can++;
              }
              else {
                //La celdas que no esten en la columna f0-1
                let celda = document.createElement('th');
                celda.setAttribute('id','celdas2');
                celda.innerHTML = c;
                row1.appendChild(celda);
                c++;
              }
            }
            tbody.appendChild(row1);
            c=1;
          }

        </script>
      </div>
    --}}
@stop
@push('scripts')
<script>
    // Ventana modal
  var modal = document.getElementById("ventanaModal");
  // Botón que abre el modal
  var boton = document.getElementById("abrirModal");
  // Hace referencia al elemento <span> que tiene la X que cierra la ventana
  var span = document.getElementsByClassName("cerrar")[0];
  // Cuando el usuario hace clic en el botón, se abre la ventana
  boton.addEventListener("click",function() {
    modal.style.display = "flex";
  });
  // Si el usuario hace clic en la x, la ventana se cierra
  span.addEventListener("click",function() {
    modal.style.display = "none";
  });
  // Si el usuario hace clic fuera de la ventana, se cierra.
  window.addEventListener("click",function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });
</script>
@endpush