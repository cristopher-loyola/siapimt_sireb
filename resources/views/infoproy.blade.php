@extends('plantillas/plantilla2')
@section('contenido')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
<meta name="csrf-token" content="{{ csrf_token() }}">
<title> Proyecto</title>
<style>

    .btn-impact{
  background: linear-gradient(135deg,#0fb37a,#0a8d62);
  color:#fff !important;
  border: 0;
  box-shadow: 0 6px 16px rgba(15,179,122,.25);
}
.btn-impact:hover{ filter: brightness(1.06); color:#fff !important; }

    .modal {
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1; /* Se situará por encima de otros elementos de la página*/
      position: fixed; /* Posición fija */
      left: 0;
      top: 0;
      width: 100vw; /* Ancho completo */
      height: 100vh; /* Algura completa */
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

    .centrar{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
    }

    #exito{
        width: 100%;
        background: #1a831ade;
        color: #fff;
        font-size: 1.2em;
        border-radius: 5px;
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }
</style>
<div>
    <h3 class="fw-bold text-center py-5" id="tituloform">Información del Proyecto </h3>
<div>
    <div class="mb-4">
        
        @if (Session::has('success'))
            <div id="exito">{{Session::get('success')}}</div>
            <br>
        @endif
        {{-- <div class="mb-1 input-group"> --}}
            {{-- <div class="mb-2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div>
                <form action="{{ route('tareag', $proyt->id) }}" method="get">
                    <button type="submit" class="btn btn-info" id="redondb">
                        <i class='bx bxs-briefcase bx-sm bx-fw bx-flashing-hover'></i>
                        &nbsp;Tareas
                    </button>
                </form>
            </div>
            
            <div class="mb-2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div>
                <form action="{{ route('recursosproy', $proyt->id) }}" method="get">
                    <button type="submit" class="btn btn-info" id="redondb">
                        <i class='bx bx-select-multiple bx-sm bx-fw bx-flashing-hover'></i>
                        Recursos
                    </button>
                </form>
            </div>
            <div class="mb-2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div>
                <a href="{{ route('contribuciones', $proyt->id)}}">
                    <button type="submit" class="btn btn-info" id="redondb">
                       <i class='bx bx-sitemap bx-sm bx-fw bx-flashing-hover'></i>
                       Contribuciones a...
                    </button>
                </a>
            </div>
            <div class="mb-2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div>
                <form action="{{ route('Equipo', $proyt->id) }}" method="get">
                    <button type="submit" class="btn btn-info" id="redondb">
                        <i class='bx bx-body bx-sm bx-fw bx-flashing-hover'></i>
                        Participantes
                    </button>
                </form>
            </div> --}}
            {{-- <div class="mb-2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div>
                <form action="{{ route('Materia', $proyt->id) }}" method="get">
                    <button type="submit" class="btn btn-info" id="redondb">
                        <img src="{{URL::asset('img/materia.png')}}" width="25em" height="25em"
                        alt="" style="margin-bottom: .1em">
                        Materia
                    </button>
                </form>
            </div> --}}
        {{-- </div> --}}
    </div>

    <div class="mb-1 input-group">
        @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4 )
        <div>
            @if ($LoggedUserInfo['pcospii'] == 1 && $LoggedUserInfo['id'] != $proyt->idusuarior )
                <a href="{{ route('firmarcospiii')}}">
                    <button type="submit" class="btn btn-dark" id="redondb" >
                        <img src="../img/back.png" width="25em" height="25em" alt="" style="margin-bottom: .1em">
                        <img src="../img/homeb.png" width="25em" height="25em" alt="" style="margin-bottom: .1em">
                    </button>
                </a>
            @else
                <a href="{{ route('cancelcrud')}}">
                    <button type="submit" class="btn btn-dark" id="redondb">
                        <img src="../img/back.png" width="25em" height="25em" alt="" style="margin-bottom: .1em">
                        <img src="../img/homeb.png" width="25em" height="25em" alt="" style="margin-bottom: .1em">
                    </button>
                </a>
            @endif
        </div>
        <div class="mb-2">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div>
        {{-- <form action="{{route('proydatos', $proyt->id)}}" method="get"> --}}
        <form action="" method="GET">
            <button type="submit" class="btn btn-success" id="redondb" value="1" name="crear">
                <i class='bx bxs-edit-alt bx-sm bx-fw bx-flashing-hover'></i>
                Editar
            </button>
        </form>
        </div>
            @if($proyt->completado == 1)
                {{-- @if ($proyt->gprotocolo == 2) --}}
                    <div class="mb-2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div>
                        <form action="{{route('gprotocolo2', $proyt->id)}}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-warning" id="redondb">
                                <img src="../img/export.png" width="32em" height="32em"
                                alt="" style="margin-bottom: .1em">
                                Protocolo
                            </button>
                        </form>
                    </div>
                {{-- @endif --}}
            @endif
        {{-- <div >
            <form action="{{route('excelinfoproyecto', $proyt->id)}}" method="get">
                <button type="submit" class="btn btn-warning" tabindex="5" id="redondb">
                        <i class="bx bxs-file-export bx-sm bx-fw bx-flashing-hover"></i>
                        Exportar Cronograma
                </button>
            </form>
        </div> --}}
        @elseif ($proyt->estado == 2 || $proyt->estado == 5 || $proyt->estado == 6)
            <div>
                <a href="{{ route('cancelcrud')}}">
                    <button type="submit" class="btn btn-dark btn-lg" id="redondb">
                        <img src="../img/back.png" width="25em" height="25em" alt="" style="margin-bottom: .1em">
                        <img src="../img/homeb.png" width="25em" height="25em" alt="" style="margin-bottom: .1em">
                    </button>
                </a>
            </div>


        


            @if ($proyt->actimpacto == 1)
                <div class="mb-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <form action="{{route('generalimpacto', $proyt->id)}}" method="get">
                    @csrf
                    <button type="submit" class="btn btn-success" id="redondb">
                        <i class='bx bxs-edit-alt bx-sm bx-fw bx-flashing-hover'></i>
                        Editar
                    </button>
                </form>
            @endif
        @endif
<div class="mb-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<a href="{{ route('impactoproy', $proyt->id) }}"
   class="btn btn-impact d-inline-flex align-items-center gap-2"
   id="redondb"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="Editar Impacto Socioeconómico"
   aria-label="Editar Impacto Socioeconómico">
    <i class='bx bx-line-chart bx-sm'></i>
    <span class="text-start">
        <small class="d-block lh-1">Impacto socioeconómico</small>
    </span>
</a>
        @if ($LoggedUserInfo['acceso'] == 1)
        <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        @endif

        @if ($LoggedUserInfo['acceso'] == 1)
            <form action="{{route('excelinfoproyecto', $proyt->id)}}" method="get">
                <button type="submit" class="btn" tabindex="5" id="redondb" style="background: #fd8700">
                    <img src="{{URL::asset('/img/cronograma.png')}}" width="25em" height="25em"
                    alt="" style="margin-bottom: .1em">
                    {{-- Exportar --}}
                    Cronograma
                </button>
            </form>
        @endif
        {{-- @if ($LoggedUserInfo['acceso'] == 1)
        <div class="mb-2">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
            <form action="{{route('protocolocrono', $proyt->id)}}" method="get">
                <button type="submit" class="btn" tabindex="5" id="redondb" style="background: red">
                    <img src="{{URL::asset('/img/cronograma.png')}}" width="25em" height="25em"
                    alt="" style="margin-bottom: .1em">
                    Exportar
                    PruebaCronos
                </button>
            </form>
        @endif --}}
        @if ($LoggedUserInfo['acceso'] != 1)
        <div class="mb-2">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div >
            <form action="{{route('excelinfoproyecto', $proyt->id)}}" method="get">
                <button type="submit" class="btn" tabindex="5" id="redondb" style="background: #fd8700">
                    <img src="{{URL::asset('/img/cronograma.png')}}" width="25em" height="25em"
                    alt="" style="margin-bottom: .1em">
                    {{-- Exportar --}}
                    Cronograma
                </button>
            </form>
        </div>
        @endif

        @if ($LoggedUserInfo['acceso'] == 2 || $LoggedUserInfo['acceso'] == 1 || $LoggedUserInfo['acceso'] == 3)
        <div class="mb-2">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div >
            <form action="{{ route('observaciones', $proyt->id) }}" method="get">
                <button type="submit" class="btn btn-info" id="redondb" style="background-color:#1373c1">
                    <img src="{{URL::asset('img/list.png')}}" width="25em" height="25em"
                    alt="" style="margin-bottom: .1em">
                    Solicitudes
                </button>
            </form>
        </div>
        @endif
        @if ($LoggedUserInfo['acceso'] == 1)
            @if ($proyt->publicacion == 0)
                <div class="mb-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div >
                    <form action="{{ route('infotec', $proyt->id) }}" method="get">
                        <button type="submit" class="btn btn-info" id="redondb" style="background-color:#4794d2">
                            <img src="{{URL::asset('img/infot.png')}}" width="25em" height="25em"
                            alt="" style="margin-bottom: .1em">
                            Informe técnico
                        </button>
                    </form>
                </div>
            @endif
        @endif
        <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        {{---mostramos el boton solo en caso de que no este iniciado y el usuario se el responsable----}}
        @if($proyt->estado == 0 && $proyt->idusuarior == $LoggedUserInfo->id)
            <div class="container-btn-no-approbe" id="abrirModal">
                    <button type="button" class="redondb btn btn-danger "
                    style="border-radius:25px;height:40px" data-id="{{$proyt->id}}" data-status="6">
                    <i class='bx bx-minus-circle bx-sm bx-fw bx-flashing-hover'></i>
                    No aceptado
                </button>
            </div>
        @endif
    </div>
    {{---- Modal para confirmar no aceptacion del proyecto -----}}
    <div id="ventanaModal" class="modal">
        <div class="contenido-modal">

            <h2 style="color: #007BFF; font-weight: bold; text-align: center;">Aviso</h2>

            <div style="text-align: center" id="action-buttons">
                <div>
                    <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
                        Si selecciona la opción "No aceptado", ya no se podrá realizar ninguna edición al proyecto, 
                        sólo quedará para consulta.
                    </p>
                    <p style="font-size: 1.3em; font-weight: 500;" class="text-center">¿Desea continuar?</p>
                </div>
              <span class="cerrar">
                <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;">
                  <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                  No, regresar
                </button>
              </span>

            <button type="button" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold; text"
                id="btn-no-approve" data-id="{{$proyt->id}}" data-status="6">
                <img src="{!! asset('img/plus.png')!!}" height="24em" width="24em" >
                Sí, continuar
            </button>

            </div>
        </div>
      </div>
    {{---- Modal para confirmar no aceptacion del proyecto -----}}
    <br>
{{--Inicio de Nuevo Proyecto --}}
        <form action="{{ route('infoproy', $proyt->id) }}" method="POST">
	<td style='text-align:center;'>
	<?php
		if ($proyt->claven < 10)
 			echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
          	else 	echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
	?>
	</td>
    <br>
    <div class="container-status-project">
                <div class="row">

                    <div class="col-10">
                        <label class="form-label"><strong>Avance Total del Proyecto</strong></label>
                    </div>
                    <div class="col ">
                        <label
                        @if(isset($proyt->porcent_program))
                            class="form-label centrar"
                        @else
                            class="form-label"
                        @endif>
                        <strong>Estado</strong></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-10">
                        {{------ se muestra barra de progreso programado o esperado-------}}
                        {{-- @if($LoggedUserInfo['acceso'] == 1) --}}
                            <div class="row pb-1">
                                <div class="col">
                                    <div class="row centrar">
                                        <div class="container-label-porcent">
                                            <label>P</label>
                                        </div>
                                        <div class="container-progress-program col">
                                            <div class="progress" style="height: 35px; background:#575656;">
                                                <div
                                                    class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                                    role="progressbar" style="width: {{$aprox}}%" aria-valuenow="25"
                                                    aria-valuemin="0" aria-valuemax="100" id="barra">
                                                    <strong>{{round($aprox, 0)}}%</strong>
                                                    <input type="text" value="{{$aprox}}" id="progreso" name="progreso" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- @endif --}}

                        {{------ se muestra barra de progreso real o actual -------}}
                        <div class="row ">
                            <div class="col ">
                                <div class="row centrar">
                                    @if(isset($proyt->porcent_program))
                                        <div class="container-label-porcent">
                                            <label>R</label>
                                        </div>
                                    @endif
                                    <div class="container-progress-real col">
                                        @if ($proyt->clavet == 'I')
                                            @if ($proyt->publicacion == 1)
                                                <div class="progress" style="height: 35px; background:#575656;">
                                                    <div
                                                    @if ($proyt->estado == 5)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                                    @elseif ($proyt->estado == 3)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                    @elseif ($proyt->estado == 2)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    @elseif ($proyt->estado == 1)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    @else
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    @endif
                                                    role="progressbar" style="width: {{$proyt->progreso}}%" aria-valuenow="25"
                                                    aria-valuemin="0" aria-valuemax="100" id="barra">
                                                    <strong>{{$proyt->progreso}}%</strong>
                                                    <input type="text" value="{{$proyt->progreso}}" id="progreso" name="progreso" hidden>
                                                    </div>
                                                </div>
                                            @elseif ($proyt->publicacion == 2)
                                                <div class="progress" style="height: 35px; background:#575656;">
                                                    <div
                                                    @if ($proyt->estado == 5)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                                    @elseif ($proyt->estado == 3)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                    @elseif ($proyt->estado == 2)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    @elseif ($proyt->estado == 1)
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    @else
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    @endif
                                                    role="progressbar" style="width: {{$proyt->progreso}}%" aria-valuenow="25"
                                                    aria-valuemin="0" aria-valuemax="100" id="barra">
                                                    <strong>{{$proyt->progreso}}%</strong>
                                                    <input type="text" value="{{$proyt->progreso}}" id="progreso" name="progreso" hidden>
                                                    </div>
                                                </div>
                                            @else
                                                @if ($proyt->progreso == 100)
                                                    <div class="progress" style="height: 35px; background:#575656;">
                                                        <div
                                                        @if ($proyt->estado == 5)
                                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                                        @elseif ($proyt->estado == 3)
                                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                        @elseif ($proyt->estado == 2)
                                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                        @elseif ($proyt->estado == 1)
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
                                                        $pgreal = $proyt->progreso;
                                                        $comp = 100;
                                                        $mult = ($comp*$pgreal);
                                                        $div = ($mult/100);
                                                        $psinp = round($div,0);
                                                    ?>
                                                    <div class="progress" style="height: 35px; background:#575656;">
                                                        <div
                                                        @if ($proyt->estado == 5)
                                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                                        @elseif ($proyt->estado == 3)
                                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                        @elseif ($proyt->estado == 2)
                                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                        @elseif ($proyt->estado == 1)
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
                                                @if ($proyt->estado == 5)
                                                    class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                                @elseif ($proyt->estado == 3)
                                                    class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                @elseif ($proyt->estado == 2)
                                                    class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                @elseif ($proyt->estado == 1)
                                                    class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                @else
                                                    class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                @endif
                                                role="progressbar" style="width: {{$proyt->progreso}}%" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100" id="barra">
                                                <strong>{{$proyt->progreso}}%</strong>
                                                <input type="text" value="{{$proyt->progreso}}" id="progreso" name="progreso" hidden>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div 
                    @if(isset($proyt->porcent_program))
                        class="col centrar p-0 m-0"
                    @else
                        class="col p-0 m-0"
                    @endif
                    >
                        <!-- se muestra la etiqueta del estado del proyecto, color y estado de negociacion -->
                        <div class="container-project-estado " >
                            <!-- se muestra la etiqueta del estado del proyecto, color y estado de negociacion -->
                            <label class="form-label" style="font-weight:bold;">
                                <strong style="color: {{$proyt->label_color}};">{{$proyt->label_status}}</strong>
                                <!---se muestra estado de negociacion del proyecto--->
                                @if(!empty($proyt->label_negotiation)) 
                                    <br>
                                    <label style="color:#575656">
                                        ({{$proyt->label_negotiation}})
                                    </label>
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @csrf
            <br>
            @if ($proyt->clavet == 'I')
                @if ($proyt->publicacion == 1)
                    <div class="mb-1 input-group" id="publicacionaprub">
                        @if (isset($publicacion->ID_PUB_TipoPublicacion))
                            @if ($publicacion->ID_PUB_TipoPublicacion == 1)
                            <div class="mb-4 col-2">
                                <label class="form-label"> Publicación </label>
                                <input name="respon" id="respon" class="form-control" 
                                value="PT {{$publicacion->NoPublicacion }}" disabled>
                            </div>
                            @elseif($publicacion->ID_PUB_TipoPublicacion == 2)
                                <div class="mb-4 col-2">
                                    <label class="form-label"> Publicación </label>
                                    <input name="respon" id="respon" class="form-control"
                                    value="MN {{$publicacion->NoPublicacion }}" disabled>
                                </div>
                            @elseif($publicacion->ID_PUB_TipoPublicacion == 3)
                                <div class="mb-4 col-2">
                                    <label class="form-label"> Publicación </label>
                                    <input name="respon" id="respon" class="form-control"
                                    value="DT {{$publicacion->NoPublicacion }}" disabled>
                                </div>
                            @endif
                        @endif
                        <div class="col-3" id="">
                        </div>
                    </div>
                @elseif ($proyt->publicacion == 2)
                    <div class="mb-1 input-group" id="publicacionaprubinfo">
                        <div class="mb-4 col-2">
                            <label class="form-label"> Publicación </label>
                            <input name="respon" id="respon" class="form-control"
                            value="Informe técnico" disabled>
                        </div>
                    </div>
                @else
                    <div class="mb-1 input-group" id="publicacion">
                        <div class="mb-4 col-2">
                            <label class="form-label"> Publicación </label>
                            <input name="respon" id="respon" class="form-control"
                            value=" - " disabled>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Codigo para validar el ptogereso real Inicio --}}
            {{-- @if( !empty($proyt->fecha_inicio) && $LoggedUserInfo['acceso'] == 1)
            <div class="mb-1 input-group">
                <table class="table table-hover table-sm table-responsive-sm">
                    <caption></caption>
                    <thead class="thead-dark">
                        <tr>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Duración</th>
                            <th>Duración Cumplida</th>
                        </tr>
                    </thead>
                    <?php
                        $aprox = 0;
                    ?>
                    <tbody>
                        
                        @foreach ($tareasproy as $tar)
                        <tr>
                            
                            <td>{{$in = $tar->fecha_inicio}}</td>
                            <td>{{$fin = $tar->fecha_fin}}</td>
                            <td>{{$dur = $tar->duracion}}</td>
                            <?php
                                $tar = 100 / $tareasum;
                                
                                $inicio = explode('-', $in);
                                $fin = explode('-', $fin);
                                $fhoyog = explode('-', date("Y-m-d"));

                                $fecha1 = new DateTime($inicio[0].'-'.$inicio[1].'-'.$inicio[2]);
                                $fecha2 = new DateTime($fin[0].'-'.$fin[1].'-'.$fin[2]);
                                $fhoy = new DateTime($fhoyog[0].'-'.$fhoyog[1].'-'.$fhoyog[2]);

                                // Calcular la diferencia entre las dos fechas
                                // $diferencia = $fecha1->diff($fecha2);
                                $diferencia = $fecha1->diff($fhoy);

                                // Obtener el número total de meses
                                $meses = (($diferencia->y * 12) + $diferencia->m)+1;

                                // diferencia cuantos meses de avance tiene, si ya se completa el valor
                                // se reempleza por la duracion de la tarea

                                if ($fecha1 < $fhoy) {
                                    if ($meses >= $dur) {
                                        $previsto = $tar*$dur;
                                    } else {
                                        $previsto = $tar*$meses;
                                    };
                                } else {
                                    $previsto = $tar*0;
                                };
                                $aprox = $aprox+$previsto;
                            ?>
                            @if ($fecha1 < $fhoy)
                                @if ($meses >= $dur)
                                    <td>{{$dur.' | '.number_format($previsto, 2)}}</td>
                                @else
                                    <td>{{$meses.' | '.number_format($previsto, 2)}}</td>
                                @endif
                            @else
                                <td>{{'0 | '.number_format($previsto, 2)}}</td>
                            @endif
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>{{number_format($tar,2)}} | {{($tar*$tareasum)}}</td>
                            <td>{{$tareasum}}</td>
                            <td>{{number_format($aprox,2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif --}}
            {{-- Codigo para validar el ptogereso real Fin --}}

            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label">Responsable</label>
                    <input name="respon" id="respon" class="form-control" value="{{$user->Nombre.' '.$user->Apellido_Paterno.' '.$user->Apellido_Materno}}" disabled>
                </div>
                <div class="mb-4 col">
                    <label class="form-label">Fecha de inicio</label>
                    <input type="date" class="form-control" name="inicio" value="{{$proyt->fecha_inicio}}" disabled>
                </div>
                <div class="mb-4 col">
                    <label class="form-label">Fecha de Fin</label>
                    <input type="date" class="form-control" name="fin" value="{{$proyt->fecha_fin}}" disabled>
                </div>
            </div>

            <div class="mb-1">
                <div class="mb-4">
                    <label class="form-label">Objetivo del proyecto</label>
                    <textarea class="form-control" name="objetivo" id="objetivo" rows="3" disabled>{{strip_tags($proyt->objetivo)}}</textarea>
                    {{-- <p>{!!$proyt->objetivo!!}</p> --}}
                </div>
            </div>

            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label">Materia</label>
                    @if ($proyt->materia == '')
                        <input type="text" class="form-control" name="mate" id="mate" value="" disabled>
                    @else
                        <input type="text" class="form-control" name="mate" id="mate" value="{{$materia->descmateria}}" disabled>
                    @endif
                </div>
                <div class="mb-4 col">
                    <label class="form-label">Orientación</label>
                    @if ($proyt->orientacion == '')
                        <input type="text" class="form-control" name="orien" id="orien" value="" disabled>
                    @else
                        <input type="text" class="form-control" name="orien" id="orien" value="{{$orien->descorientacion}}" disabled>
                    @endif
                </div>
                <div class="mb-4 col">
                    <label class="form-label">Nivel de impacto social o Económico</label>
                    @if ($proyt->nivel == '')
                        <input type="text" class="form-control" name="nivel" id="nivel" value="" disabled>
                    @else
                        <input type="text" class="form-control" name="nivel" id="nivel" value="{{$nivel->nivel}}" disabled>
                    @endif
                </div>
            </div>

            <div class="mb-1 input-group">
                <div class="mb-4 col-12"> 
                    <label class="form-label">Investigadores participantes:</label>
                    <textarea class="form-control" name="cont" id="cont" rows="5" disabled>
                        @foreach ($team as $t)
                            {{$t->Apellido_Paterno.' '.$t->Apellido_Materno.' '.$t->nombre}}
                        @endforeach
                    </textarea> 
                </div>
            </div>

                {{--<div class="mb-4 col">
                    <label class="form-label"> Área de adscripción &nbsp;&nbsp;</label>
                    <input type="text" class="form-control" name="areas" id="areas"
                    value="{{$areas->nombre_area}}" disabled>
                </div>
                <div class="mb-2">
                </div>
                <div class="mb-4 col">
                    <label class="form-label"> Aprobó </label>
                    <input type="text" class="form-control" name="areas" id="areas"
                    value="{{$resp->Apellido_Paterno.' '.$resp->Apellido_Materno.' '.$resp->Nombre}}" disabled>
                </div>
            </div>
            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Tipo de Proyecto (Interno / Externo)</label>
                        <input name="tipo" id="tipo" class="form-control" value="{{$proyt->Tipo}}" disabled>
                        <br>
                        <input id="atipo" name="atipo" class="form-control" value="{{$proyt->ncontratos}}" disabled>
                    </div>--}}
                {{--<div class="mb-1">
                    <div class="mb-2">
                        <label class="form-label"> Producto por obtener</label>
                        <textarea class="form-control" name="prodobt"
                        id="prodobt" rows="3" disabled>{{$proyt->producto}}</textarea>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Línea de investigación  </label>
                        @if ($proyt->idlinea == '')
                            <textarea class="form-control" name="lins" id="lins"
                            rows="3" disabled></textarea>
                        @else
                            <textarea class="form-control" name="lins" id="lins"
                            rows="3" disabled>{{$linea->nombre_linea}}</textarea>
                        @endif
                        
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Cliente o Usuario Potencial</label>
                        <input name="userpot" id="userpot" class="form-control"
                        value="{{$cli->nivel1.' | '.$cli->nivel2.' | '.$cli->nivel3}}" disabled>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Objetivo sectorial</label>
                        @if ($proyt->idobjt == '')
                            <textarea class="form-control" name="objs" id="objs" rows="3" disabled></textarea>
                        @else
                            <textarea class="form-control" name="objs" id="objs" rows="3" disabled>{{$obj->nombre_objetivosec}}</textarea>
                        @endif
                    </div>
                </div>
                <div class="mb-4">
                    <div class="mb-1 input-group">
                        <div class="mb-4 col">
                            <label class="form-label"> Alineación al programa sectorial</label>
                            @if ($proyt->idalin == '')
                                <input type="text" class="form-control" name="alin" id="alin" value="" disabled>
                            @else
                                <input type="text" class="form-control" name="alin" id="alin" value="{{$alin->nombre}}" disabled>
                            @endif
                        </div>
                        <div class="mb-1 col">
                        </div>
                    </div>
                </div>--}}
                {{-- <div class="mb-1 input-group">
                    <div class="mb-4 col">
                    <label class="form-label"> Materia: </label>
                    <textarea class="form-control" name="mate" id="mate" rows="3" disabled>
                        @foreach ($materia as $t)
                        {{$t->descmateria}}
                        @endforeach
                    </textarea>
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div> --}}
                
                {{--<div class="mb-1 input-group">
                    <div class="mb-4 col">
                    <label class="form-label"> Contribución a : </label>
                    <textarea class="form-control" name="cont" id="cont" rows="5" disabled>
                        @foreach ($contri as $c)
                        {{$c->nombre_contri }}
                        @endforeach
                    </textarea> 
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Modo de transporte </label>
                        @if ($proyt->idmodot  == '')
                            <input type='text' name="tran" id="tran" class="form-control" value="" disabled>
                            <input type='text' name="otrotra" id="otrotra" class="form-control" value="" hidden>
                            <br>
                            <input id="altran" name="altran" class="form-control" value="" disabled>
                        @else
                            <input type='text' name="tran" id="tran" class="form-control" value="{{$tran->nombre_transporte}}" disabled>
                            <input type='text' name="otrotra" id="otrotra" class="form-control" value="{{$tran->id}}" hidden>
                            <br>
                            <input id="altran" name="altran" class="form-control" value="{{$proyt->otrotrans}}" disabled>
                        @endif
                        
                    </div>--}}
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        tipo = document.getElementById("tipo").value;
        if(tipo=="I"){
            document.getElementById("atipo").style.display = "none";
        }
    </script>
    <script>
        otrotra = document.getElementById("otrotra").value;
        if(otrotra != 7){
            document.getElementById("altran").style.display = "none";
        }
    </script>
    <script>
        window.onload = function(){
            if(document.getElementById('abrirModal') != null){
                document.getElementById('btn-no-approve').addEventListener('click',requestChangeStatus);

                async function requestChangeStatus(){

                    const idProject = this.dataset.id;
                    const newStatus = this.dataset.status;
                    const route = '{{route("projects.change.estado")}}';
                    const data = {
                        'id':idProject,
                        'estado':newStatus
                    };
                    const options = {
                        method:'POST',
                        headers:{
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify(data)
                    };

                    try {
                        const response = await fetch(route,options);
                        const data = await response.json();
                        if(data.success){
                            document.getElementById('action-buttons').innerHTML = '<p style="font-size: 1.3em; font-weight: 500;" class="text-center">El estado del proyecto ha cambiado</p>';
                            setTimeout(() => {
                                window.location.reload();                            
                            }, 1500);
                        }
                    } catch (error) {
                        console.error(error);
                    }
                }
            }
        }
    </script>

    <script>
        // Ventana modal
        const modal = document.getElementById("ventanaModal");
        // Botón que abre el modal
        const boton = document.getElementById("abrirModal");
        // Hace referencia al elemento <span> que tiene la X que cierra la ventana
        const span = document.getElementsByClassName("cerrar")[0];
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
{{--Fin de Nuevo Proyecto    --}}
</div>
@stop
@push('scripts')
@endpush