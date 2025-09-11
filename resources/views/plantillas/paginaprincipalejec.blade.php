@extends('plantillas/plantillaProyUsuario')
@section('contenido')
<style>
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
  footer {
    color: #5C5C69;
    font-size: .8em;
    text-align: center;
    padding: 10px 0;
    background-color: #FFFFFF;
    border-top: 1px solid #ddd;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    z-index: 1;
    margin-top: 24px;
}
</style>
<title>Inicio</title>
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
        <div style="display: flex;">
          <form action="claveproy" method="get">
              <button type="submit" class="btn btn-success" id="redondb">
                <i class="bx bx-plus-circle bx-fw bx-flashing-hover"></i>
                Nuevo
              </button>
          </form>
          @if ($LoggedUserInfo['director'] == 1)
            <form action="{{route('firnaralldg')}}" method="GET">
              <button type="submit" class="btn" id="redondb" style="background: #1373c1; color: white;">
                <img src="{{asset('/img/signature.png')}}" alt="" width="20px" height="20px" style="margin-bottom: 5px;">
                Firmar Protocolos
              </button>
            </form>
          @endif
        </div>
        
      <div class="text-right">
        <a href="{{ route('vistareportes')}}" class="btn btn-warning" tabindex="5" id="redondb">
          <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
          Reportes
        </a>
      </div>
      <br>
      <table class="table table-hover table-sm table-responsive-sm">
        <thead class="thead-dark">
              <tr>
                  <th scope="col" style="width: 5rem;">Clave</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Fecha de inicio</th>
                  <th scope="col">Fecha de fin</th>
                  <th scope="col">Responsable</th>
                  <th scope="col">Duración</th>
                  <th scope="col" style="width: 7rem;">Costo</th>
                  <th scope="col" style="width: 7rem;">Progreso</th>
                  @if ($LoggedUserInfo['director'] == 1)
                    <th scope="col">Protocolo</th>
                  @endif
                  <th scope="col">Estado</th>
              </tr>
          </thead>
          @if ($LoggedUserInfo['director'] == 0)
            <tbody>
              {{---proyectos donde se es responsable---}}
              @foreach ($allProjectsWhereImResponsable as $pr)
                <tr class="table align-middle" >

                    <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                      else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                    ?>
                    @if ($pr->completado == 1)
                      <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                    @else
                      @if($pr->estado != 4 && $pr->estado != 5)
                        <td><a href="{{ route('proydatos', $pr->id)}}">{{$pr->nomproy}}</a></td>
                      @else
                        <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                      @endif
                    @endif
                    <td>{{$pr->fecha_inicio}}</td>
                    <td>{{$pr->fecha_fin}}</td>
                    <td>
                      <a href="{{ route('infoproys', $pr->id)}}" id="lider">
                          <img src="{{ asset('Icons/person-fill.svg') }}" alt="Person Icon" style="width: 1.5rem; height: 1.5rem;">
                          <input type="button" id="resp" name="resp" value="{{$pr->idusuarior}}" hidden>
                        <input type="button" id="ref" name="ref" value="{{ $LoggedUserInfo['id']}}" hidden>
                      </a>
                    </td>
                    <td>{{$pr->duracionm}} Meses</td>
                    <td>$ {{round($pr->costo,1)}}</td>
                    <td>
                      <div class="container-progress-bar space-between-vertical">

                        <a class="popup-link" href="{{ route('resumenMensual', [$pr->id]) }}" method="get">

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
                                              class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                              class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                                  class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                                  class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                          class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
              {{---proyectos donde se es miembro---}}
              @foreach ($allProjectsWhereImMember as $pr)
                <tr class="table align-middle" >
                    <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                      else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                    ?>
                    @if ($pr->completado == 1)
                      <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                    @else
                      @if($pr->estado != 4 && $pr->estado != 5)
                        <td><a href="{{ route('proydatos', $pr->id)}}">{{$pr->nomproy}}</a></td>
                      @else
                        <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                      @endif
                    @endif
                    <td>{{$pr->fecha_inicio}}</td>
                    <td>{{$pr->fecha_fin}}</td>
                    <td>
                      <a href="{{ route('infoproys', $pr->id)}}" id="miembro">
                          <img src="{{ asset('Icons/people-fill.svg') }}" alt="Person Icon" style="width: 1.5rem; height: 1.5rem;">
                          <input type="button" id="team" name="team" value="{{$pr->idusuario}}" hidden>
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
                                              class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                              class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                                  class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                                  class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                          class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
              {{---resto de proyectos multicoordinacion y del area---}}
              @foreach ($restProjects as $pr)
                <tr class="table align-middle">

                    <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                    else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                    ?>
                    @if ($pr->completado == 1)
                      <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                    @else
                      @if($pr->estado != 4 && $pr->estado != 5)
                        <td><a href="{{ route('proydatos', $pr->id)}}">{{$pr->nomproy}}</a></td>
                      @else
                        <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                      @endif
                    @endif
                    <td>{{$pr->fecha_inicio}}</td>
                    <td>{{$pr->fecha_fin}}</td>
                    <td>{{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}</td>
                    <td>{{$pr->duracionm}} Meses </td>
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
                                              class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                              class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                          @endif
                                          role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                          aria-valuemin="0" aria-valuemax="100" id="barra">
                                          <strong>{{$pr->progreso}}%</strong>
                                          <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                          </div>
                                      </div>
                                  @else
                                      @if ($pr->progreso == 98)
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
                                                  class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                                  class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
                                          class="progress-bar progress-bar-striped progress-bar-animated bg-success"
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
          @else
            @foreach ($todosproj as $pr)
              <tbody id="tabladg">
                <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                ?>
                <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                <td>{{$pr->fecha_inicio}}</td>
                <td>{{$pr->fecha_fin}}</td>
                <td>{{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}</td>
                <td>{{$pr->duracionm}} Meses</td>
                <td>$ {{round($pr->costo,1)}}</td>
                <td>
                  <div class="container-progress-bar space-between-vertical">
                    <div class="container-porcent-expected ">
                      <div class="contain-letter pr-1" style="float: left">
                        <strong>P</strong>
                      </div>
                      @if ($pr->clavet == 'I')
                        @if ($pr->publicacion == 1 || $pr->publicacion == 2)
                          <div class="contains-progress-bar">
                            <div class="progress" style="height: 30px; background:#575656; text-color">
                              <div
                                class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">
                                  {{$pr->progreso}}%
                              </div>
                            </div>
                          </div>
                        @elseif ($pr->progreso == 100)
                          <div class="contains-progress-bar">
                            <div class="progress" style="height: 30px; background:#575656; text-color">
                              <div
                                class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                role="progressbar" style="width: 98%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">
                                98%
                              </div>
                            </div>
                          </div>
                        @else
                          <div class="contains-progress-bar">
                            <div class="progress" style="height: 30px; background:#575656; text-color">
                              <div
                                class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">
                                  {{$pr->progreso}}%
                              </div>
                            </div>
                          </div>
                        @endif
                      @else
                        <div class="contains-progress-bar">
                          <div class="progress" style="height: 30px; background:#575656; text-color">
                            <div
                              class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                              role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                                {{$pr->progreso}}%
                            </div>
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                </td>
                <td>
                  @if ($pr->fimradg == 1)
                    <label for="" style="color: #1373c1">
                      Firmado
                    </label>
                  @else
                    <label for="" style="color: #c1131f">
                      Sin firmar
                    </label>
                  @endif
                </td>
                <td>
                  @switch($pr->estado)
                      @case(0)
                        <label for="" style="color: #c433ff">
                          @if($pr->clavet == 'I')
                            en espera COSPIII
                          @else
                            en negociación
                          @endif
                        </label>
                          @break
                      @case(1)
                        <label for="" style="color: #1373c1">En ejecución</label>
                          @break
                      @case(2)
                        <label for="" style="color: #1fc113">Concluido</label>
                          @break
                      @case(3)
                        <label for="" style="color: #ffaa00">En pausa</label>
                          @break
                      @case(4)
                        <label for="" style="color: #000000">En reprogramación</label>
                          @break
                      @case(5)
                        <label for="" style="color: #c1131f">Cancelado</label>
                          @break
                      @case(6)
                        <label for="" style="color: #c433ff">No aceptado</label>
                          @break
                      @default
                        <label for="" style="color: #FF1C0E">Desconocido</label>
                  @endswitch
                </td>
              </tbody>
            @endforeach
          @endif
      </table>
      <br>
      <div>
        <form action="newp" method="get">
            <button type="submit" class="btn btn-success" id="redondb">
              <i class="bx bx-plus-circle bx-fw bx-flashing-hover"></i>
              Nuevo
            </button>
        </form>
      </div>

      <script>

      </script>
    {{-- Fin de la tabla de proyectos --}}
    <footer>
            2025 © Desarrollado por la División de Telemática
      </footer>
@stop

@push('scripts')
<script>
  document.querySelectorAll(".popup-link").forEach(function(el) {
    el.addEventListener("click", function(e) {
      e.preventDefault();
      const url = el.getAttribute("href");
      window.open(url, "_popupResumen", "width=1040,height=350,scrollbars=yes, resizable=yes");  
    });
  });
</script>
@endpush
