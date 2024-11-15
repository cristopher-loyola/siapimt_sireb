@extends('plantillas/plantillaProyUsuario')
@section('contenido')
<head>
    <style>
        #solicitudesTable {
        width: 80%; /* Ancho de la tabla */
        margin: 0 auto; /* Centrar la tabla en la página */
        }

        #solicitudesTable th,
        #solicitudesTable td {
        padding: 5px 10px; /* Espaciado interno de celdas */
        }

        /* Reducir el tamaño de fuente de las celdas */
        #solicitudesTable th,
        #solicitudesTable td {
        font-size: 12px;
        }

        /* Reducir el espaciado entre las filas */
        #solicitudesTable tbody tr {
        margin-bottom: 5px;
        }

        .button-container {
            display: flex;
            justify-content: space-around;

        }

        #selected-options-solicitudes {
            font-weight: normal; /* Esto quitará la negrita */
        }

        .space-between-vertical{
          display: flex;
          gap: .2rem;
          flex-direction: column;
        }
        .center{
          display: flex;
          justify-content: center;
          align-content: center;
        }
    </style>
</head>
<title>Proyectos</title>
    {{-- Principio de tabla de proyectos  --}}
    @if (Session::has('registered') && Session::has('key_project'))
    <script type="module">
      document.getElementById('btn-toogle-dialog-modal').click();
    </script>
      <div class="container-dialog-message">       
      <div class="modal" tabindex="-1" id="modal-dialog-message" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{Session::get('registered')}}</h5>
              </div>
              <div class="modal-body">
                <p style="font-size: 2.5rem"><h6>La clave del proyecto registrado es: <strong class="text-primary">{{Session::get('key_project')}}</strong></h6></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog-message"
        id="btn-toogle-dialog-modal" style="display:none"></button> 
      </div>
    @endif
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Proyectos </h2>
        <br><br>
        <div>
            <form action="newp" method="get">
                <button type="submit" class="btn btn-success" id="redondb">
                  <i class="bx bx-plus-circle bx-fw bx-flashing-hover"></i>
                  Nuevo
                </button>
            </form>
        </div>
        <div class="text-right">
          <a href="{{ route('vistareportes')}}" class="btn btn-warning" tabindex="5" id="redondb">
            <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
            Reportes
          </a>
        </div>
      <br>
      <table class="table table-hover table-sm table-responsive-sm" id="mytab1">
           <thead class="thead-dark">
              <tr>
                  <th scope="col" style="width: 5rem;">Clave</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Fecha de inicio</th>
                  <th scope="col">Fecha de fin</th>
                  <th scope="col">Rol <i class='bx bxs-info-circle bx-tada-hover'
                    title="*Responsable o Miembro del equipo"
                    id="info"></i>
                  </th>
                  <th scope="col">Duración
                  </th>
                  <th scope="col" style="width: 7rem;">Costo</th>
                  <th scope="col" style="width: 7rem;">Progreso</th>
                  <th scope="col" style="width: 10rem;" class="text-center"> Estado</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($proyt as $pr)
              <tr class="table align-middle" >

                  <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                    else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                  ?>
                  <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                  <td>{{$pr->fecha_inicio}}</td>
                  <td>{{$pr->fecha_fin}}</td>
                  <td>
                    <a href="{{ route('infoproys', $pr->id)}}" id="lider">
                        <img src="{{ asset('Icons/person-fill.svg') }}" alt="Person Icon" style="width: 1.5rem; height: 1.5rem;">
                        <input type="button" id="resp" name="resp" value="{{$pr->idusuarior}}" hidden>
                      <input type="button" id="ref" name="ref" value="{{ $LoggedUserInfo['id']}}" hidden>
                    </a>
                  </td>
                  <td>
                      @if(isset($pr->duracionm))
                        {{$pr->duracionm}} Meses
                      @else
                        Por definir
                      @endif
                  </td>
                  <td>$ {{round($pr->costo,1)}}</td>
                  <td>
                    <div class="container-progress-bar space-between-vertical">

                        @if (isset($pr->porcent_program))
                        <div class="container-porcent-expected ">
                          <div class="contain-letter pr-1" style="float: left">
                            <strong>P</strong> 
                          </div>
                          <div class="contains-progress-bar">                          
                            <div class="progress" style="height: 30px; background:#575656; text-color">
                              <div
                                  class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                              role="progressbar" style="width: {{$pr->porcent_program}}%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                                {{$pr->porcent_program}}%
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif

                        <div class="container-porcent-progress" >
                          @if (isset($pr->porcent_program))
                            <div class="contain-letter pr-1" style="float: left">
                            <strong>R</strong>
                            </div>
                          @endif
                          <div class="contains-progress-bar">
                            @if ($pr->clavet == 'I')
                              @if ($pr->publicacion == 1)
                                    <div class="progress" style="height: 35px; background:#575656;">
                                        <div
                                        @if ($pr->estado == 5)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                        @elseif ($pr->estado == 3)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                        @elseif ($pr->estado == 2)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @elseif ($pr->estado == 1)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @else
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        @endif
                                        role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100" id="barra">
                                        <strong>{{$pr->progreso}}%</strong>
                                        <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                        </div>
                                    </div>
                                @elseif ($pr->publicacion == 2)
                                    <div class="progress" style="height: 35px; background:#575656;">
                                        <div
                                        @if ($pr->estado == 5)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                        @elseif ($pr->estado == 3)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                        @elseif ($pr->estado == 2)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @elseif ($pr->estado == 1)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @else
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        @endif
                                        role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100" id="barra">
                                        <strong>{{$pr->progreso}}%</strong>
                                        <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                        </div>
                                    </div>
                                @else
                                    @if ($pr->progreso == 100)
                                        <div class="progress" style="height: 35px; background:#575656;">
                                            <div
                                            @if ($pr->estado == 5)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            @elseif ($pr->estado == 3)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            @elseif ($pr->estado == 2)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @elseif ($pr->estado == 1)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @else
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                            @endif
                                            role="progressbar" style="width:98%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100" id="barra">
                                            <strong>98%</strong>
                                            <input type="text" value="98" id="progreso" name="progreso" hidden>
                                            </div>
                                        </div>
                                    @else
                                        <?php
                                            $pgreal = $pr->progreso;
                                            $comp = 98;
                                            $mult = ($comp*$pgreal);
                                            $div = ($mult/100);
                                            $psinp = round($div,0);
                                        ?>
                                        <div class="progress" style="height: 35px; background:#575656;">
                                            <div
                                            @if ($pr->estado == 5)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            @elseif ($pr->estado == 3)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            @elseif ($pr->estado == 2)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @elseif ($pr->estado == 1)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @else
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                            @endif
                                            role="progressbar" style="width: {{$psinp}}%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100" id="barra">
                                            <strong>{{$psinp}}%</strong>
                                            <input type="text" value="{{$psinp}}" id="progreso" name="progreso" hidden>
                                            </div>
                                        </div>
                                    @endif
                              @endif
                            @else
                                <div class="progress" style="height: 35px; background:#575656;">
                                    <div
                                    @if ($pr->estado == 5)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                    @elseif ($pr->estado == 3)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                    @elseif ($pr->estado == 2)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    @elseif ($pr->estado == 1)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    @else
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                    @endif
                                    role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" id="barra">
                                    <strong>{{$pr->progreso}}%</strong>
                                    <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                    </div>
                                </div>
                            @endif
                          </div>

                        </div>

                      </div>
                  </td>
                  <td>
                    <!-- se muestra la etiqueta del estado del proyecto, color y estado de negociacion -->
                    <label class="form-label" style="color: {{$pr->label_color}};">
                      <label >{{$pr->label_status}}</label>
                      <!---se muestra estado de negociacion del proyecto--->
                      @if(!empty($pr->label_negotiation)) 
                        <label style="color: {{$pr->label_color}};">
                            ({{$pr->label_negotiation}})
                        </label>
                      @endif
                    </label>
                  </td>
              </tr>
            @endforeach
            @foreach ($proy as $pr)
              <tr class="table align-middle" >
                  <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                    else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                  ?>
                  <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                  <td>{{$pr->fecha_inicio}}</td>
                  <td>{{$pr->fecha_fin}}</td>
                  <td>
                    <a href="{{ route('infoproys', $pr->id)}}" id="miembro">
                        <img src="{{ asset('Icons/people-fill.svg') }}" alt="Person Icon" style="width: 1.5rem; height: 1.5rem;">
                        <input type="button" id="team" name="team" value="{{$pr->idusuario}}" hidden>
                      <input type="button" id="ref" name="ref" value="{{ $LoggedUserInfo['id']}}" hidden>
                    </a>
                  </td>
                  <td>{{$pr->duracionm}} Meses</td>
                  <td>$ {{round($pr->costo,1)}}</td>
                  <td>
                    <div class="container-progress-bar space-between-vertical">

                        @if (isset($pr->porcent_program))
                        <div class="container-porcent-expected ">
                          <div class="contain-letter pr-1" style="float: left">
                            <strong>P</strong> 
                          </div>
                          <div class="contains-progress-bar">                          
                            <div class="progress" style="height: 30px; background:#575656; text-color">
                              <div
                                  class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                              role="progressbar" style="width: {{$pr->porcent_program}}%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                                {{$pr->porcent_program}}%
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif

                        <div class="container-porcent-progress" >
                          @if (isset($pr->porcent_program))
                            <div class="contain-letter pr-1" style="float: left">
                            <strong>R</strong>
                            </div>
                          @endif
                          <div class="contains-progress-bar">
                            @if ($pr->clavet == 'I')
                              @if ($pr->publicacion == 1)
                                    <div class="progress" style="height: 35px; background:#575656;">
                                        <div
                                        @if ($pr->estado == 5)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                        @elseif ($pr->estado == 3)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                        @elseif ($pr->estado == 2)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @elseif ($pr->estado == 1)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @else
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        @endif
                                        role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100" id="barra">
                                        <strong>{{$pr->progreso}}%</strong>
                                        <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                        </div>
                                    </div>
                                @elseif ($pr->publicacion == 2)
                                    <div class="progress" style="height: 35px; background:#575656;">
                                        <div
                                        @if ($pr->estado == 5)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                        @elseif ($pr->estado == 3)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                        @elseif ($pr->estado == 2)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @elseif ($pr->estado == 1)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @else
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        @endif
                                        role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100" id="barra">
                                        <strong>{{$pr->progreso}}%</strong>
                                        <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                        </div>
                                    </div>
                                @else
                                    @if ($pr->progreso == 100)
                                        <div class="progress" style="height: 35px; background:#575656;">
                                            <div
                                            @if ($pr->estado == 5)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            @elseif ($pr->estado == 3)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            @elseif ($pr->estado == 2)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @elseif ($pr->estado == 1)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @else
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                            @endif
                                            role="progressbar" style="width:98%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100" id="barra">
                                            <strong>98%</strong>
                                            <input type="text" value="98" id="progreso" name="progreso" hidden>
                                            </div>
                                        </div>
                                    @else
                                        <?php
                                            $pgreal = $pr->progreso;
                                            $comp = 98;
                                            $mult = ($comp*$pgreal);
                                            $div = ($mult/100);
                                            $psinp = round($div,0);
                                        ?>
                                        <div class="progress" style="height: 35px; background:#575656;">
                                            <div
                                            @if ($pr->estado == 5)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            @elseif ($pr->estado == 3)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            @elseif ($pr->estado == 2)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @elseif ($pr->estado == 1)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @else
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                            @endif
                                            role="progressbar" style="width: {{$psinp}}%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100" id="barra">
                                            <strong>{{$psinp}}%</strong>
                                            <input type="text" value="{{$psinp}}" id="progreso" name="progreso" hidden>
                                            </div>
                                        </div>
                                    @endif
                              @endif
                            @else
                                <div class="progress" style="height: 35px; background:#575656;">
                                    <div
                                    @if ($pr->estado == 5)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                    @elseif ($pr->estado == 3)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                    @elseif ($pr->estado == 2)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    @elseif ($pr->estado == 1)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    @else
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                    @endif
                                    role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" id="barra">
                                    <strong>{{$pr->progreso}}%</strong>
                                    <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                    </div>
                                </div>
                            @endif
                          </div>

                        </div>

                      </div>
                  </td>
                  <td>
                    <!-- se muestra la etiqueta del estado del proyecto, color y estado de negociacion -->
                    <label class="form-label" style="color: {{$pr->label_color}};">
                      <label >{{$pr->label_status}}</label>
                      <!---se muestra estado de negociacion del proyecto--->
                      @if(!empty($pr->label_negotiation)) 
                        <label style="color: {{$pr->label_color}};">
                            ({{$pr->label_negotiation}})
                        </label>
                      @endif
                    </label>
                  </td>
              </tr>
            @endforeach
          </tbody>
      </table>
      <div>
        <form action="newp" method="get">
            <button type="submit" class="btn btn-success" id="redondb">
              <i class="bx bx-plus-circle bx-fw bx-flashing-hover"></i>
              Nuevo
            </button>
        </form>
      </div>

@stop
@push('scripts')
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
