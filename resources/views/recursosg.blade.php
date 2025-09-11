@extends('plantillas/plantillaalt')
@section('contenido')
<title>Propuesta económica de {{$proyt->nomproy}}</title>
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
              <a  href="{{ route('Equipo', $proyt->id) }}"  class="sidebar-link">
                  <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                  <span class="tooltip">Participantes</span>
              </a>
          </li>
          <li
          @if ($vtarea != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item4">
              <a href="{{ route('tareag', $proyt->id) }}" class="sidebar-link">
                  <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                  <span class="tooltip">Programa de actividades</span>
              </a>
          </li>
          <li class="sidebar-item active" id="item5">
              <a href="{{ route('recursosproy', $proyt->id) }}" class="sidebar-link">
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
              <a @if ($vrecurso != 0 || $proyt->notapresupuesto != null) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
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
              <a @if ($vcontri != 0) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                  <span class="tooltip">Participantes</span>
              </a>
          </li>
          <li
          @if ($vtarea != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item5">
              <a href="{{ route('tareag', $proyt->id) }}" class="sidebar-link">
                  <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                  <span class="tooltip">Programa de actividades</span>
              </a>
          </li>
          <li class="sidebar-item active" id="item6">
              <a href="{{ route('recursosproy', $proyt->id) }}" class="sidebar-link">
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
              <a @if ($vrecurso != 0 || $proyt->notapresupuesto != null) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
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
              <a @if ($vcontri != 0) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
                  <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                  <span class="tooltip">Participantes</span>
              </a>
          </li>
          <li
          @if ($vtarea != 0)
              class="sidebar-item-success"
          @else
              class="sidebar-item"
          @endif
          id="item4">
              <a href="{{ route('tareag', $proyt->id) }}" class="sidebar-link">
                  <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                  <span class="tooltip">Programa de actividades</span>
              </a>
          </li>
          <li class="sidebar-item active" id="item5">
              <a href="{{ route('recursosproy', $proyt->id) }}" class="sidebar-link">
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
              <a @if ($vrecurso != 0 || $proyt->notapresupuesto != null) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
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

  <div><h4 class="fw-bold text-center py-5" id="tituloform"> Propuesta económica
  <td style='text-align:center;'>
	<?php
		if ($proyt->claven < 10) 
 			echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
          	else 	echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
	?>
	</td>
            <br>
        <div>
          <input type="text" name="tipo" id="tipo" value="{{ $proyt->clavet }}" hidden>
        <div>
          {{-- <a href="{{ route('infoproys', $proyt->id)}}">
                        <button type="submit" class="btn btn-dark btn-sm" id="redondb">
                        <i class='bx bxs-chevron-left-circle bx-sm bx-flashing-hover'></i>
                        Info. proyecto
            </button> --}}
          </a>
        </div>
        <h3 class="fw-bold text-center py-5"> Recursos Financieros </h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyf', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Financiero
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($rescf as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalf}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="fw-bold text-center py-5"> Recursos Materiales</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproym', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Material
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($rescm as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalm}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="fw-bold text-center py-5"> Recursos Tecnológicos</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyt', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Tecnológico
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($resct as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalt}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="fw-bold text-center py-5"> Recursos Humanos</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyh', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Humano
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($resch as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalh}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <h3 class="fw-bold text-center py-5"> Otros Recursos</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyo', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso de Otros
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($resco as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalo}}</td>
                </tr>
                </tbody>
            </table>
        </div>
      <h3 class="fw-bold text-center py-5"> Presupuesto Global </h3>
      <div> 
          <table class="table table-hover">
              <thead>
              <tr>
                <th scope="col" class="">Recursos</th>
                <th scope="col" class="">Cantidad</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>Recurso Financiero</td>
                <td>{{'$'.$subtotalf}}</td>
              </tr>
              <tr>
                <td>Recurso Materiales</td>
                <td>{{'$'.$subtotalm}}</td>
              </tr>
              <tr>
                <td>Recurso Tecnológico</td>
                <td>{{'$'.$subtotalt}}</td>
              </tr>
              <tr>
                <td>Recurso Humanos</td>
                <td>{{'$'.$subtotalh}}</td>
              </tr>
              <tr>
                <td>Otros Recursos</td>
                <td>{{'$'.$subtotalo}}</td>
              </tr>
              <tr id="etotal">
                <th style="text-align: end">Total<i class='bx bxs-info-circle bx-tada-hover' 
                  title="*Nota: En la propuesta económicas de proyectos internos no se incluye I.V.A"
                  id="info"></i></th>
                <td >$ <input type="text" id="monto" name="monto" 
                  placeholder="Monto" style="border: hidden" value="{{round($total,2)}}" disabled></td></td>
              </tr>
              <tr id="itotal">
                <th style="text-align: end">Subtotal<i class='bx bxs-info-circle bx-tada-hover' 
                  title="*Nota: En la propuesta económicas de proyectos externos se incluye I.V.A"
                  id="info"></i>
                </th>
                <td>$ <input type="text" id="monto" name="monto" 
                  placeholder="Monto" style="border: hidden" value="{{round($total,2)}}" disabled></td>
              </tr>
              <tr id="miva">
                <th style="text-align: end">IVA %</th>
                <td>$ <input type="text" id="iva" name="iva" style="border: hidden"
                  placeholder="IVA" disabled></td>
              </tr>
              <tr id="final">
                <th style="text-align: end">Total</th>
                <td>$ <input type="text" id="total" name="total" style="border: hidden"
                placeholder="Total" disabled></td>
              </tr>
          </table>
      </div>
      <br>
      <div>
        <style>
          textarea {
            border: 3px solid transparent; /* Sin borde visible por defecto */
            outline: none; /* Elimina el borde de enfoque por defecto */
            /* padding: 10px; */
            width: 100%;
            font-size: 16px;
            transition: border-color 0.3s; /* Transición suave del borde */
            border-radius: 10px;
            text-align: justify;
            overflow: hidden;
            resize: none;
            border-color: #aacfe7;
          }
          textarea:hover {
            border-color: #3498db; /* El color del borde al pasar el mouse */
          }
          textarea:focus {
            border-color: #3498db; /* El color del borde cuando el campo está en enfoque */
          }
          textarea::placeholder {
            color: #84abf4; /* Aquí puedes poner el color que desees */
            font-style: italic;
          }
        </style>
        <form action="{{route('addnotapresupuesto')}}" method="POST">
          @csrf
          <input type="number" name="id" id="id" value="{{$proyt->id}}" hidden>
          <label for="notapresupuesto" class="form-label">Nota de recursos</label>
          <textarea name="notapresupuesto" id="notapresupuesto" rows="5">@if ($proyt->notapresupuesto != null) {{$proyt->notapresupuesto}} @endif</textarea>
          <button type="submit"
          @if ($proyt->notapresupuesto != null)
            class="btn btn-warning"     
          @else
            class="btn btn-success"
          @endif
          id="redondb">
            @if ($proyt->notapresupuesto != null)
              <img src="{{asset('/img/plus_bl.png')}}" alt="Add" width="25px" height="25px">
            @else
              <img src="{{asset('/img/plus.png')}}" alt="Add" width="25px" height="25px">
            @endif
            Actualizar Nota
          </button>
        </form>
      </div>
    <div>
@stop
@push('scripts')
<script>
  getSelectValue = document.getElementById("tipo").value;
  if(getSelectValue=="E"){
    var tasa = 16;
    var monto = document.getElementById("monto").value;
    var iva = (monto*tasa)/100;
    var ivatotal = parseFloat(monto) + parseFloat(iva);
    ivatotal = Math.round(ivatotal);
    document.getElementById('iva').value=(iva=='') ? x : iva;
    document.getElementById('total').value=(ivatotal=='') ? x : ivatotal;
    document.getElementById("etotal").style="visibility:hidden;";
    document.getElementById("etotal2").style="visibility:hidden;";
  }else{
    document.getElementById("itotal").style="visibility:hidden;";
    document.getElementById("miva").style="visibility:hidden;";
    document.getElementById("final").style="visibility:hidden;";
  }
</script>    
@endpush