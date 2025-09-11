@extends('plantillas/plantillaFormalt')
@section('contenido')
    <style>
      .modal {
        display: none; /* Por defecto, estará oculto */
        position: fixed; /* Posición fija */
        z-index: 1; /* Se situará por encima de otros elementos de la página*/
        padding-top: 400px; /* El contenido estará situado a 200px de la parte superior */
        padding-left: 500px;
        padding-right: 500px;
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
        width: 50%;
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

      .aceptar{
        color: #000;
        background-color: #ffc107;
        border-color: #ffc107;
        border-radius: 10px;
        padding: 10px;
        border: 1px solid transparent;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
      }

      .regresar{
        color: #000;
        background-color: #1c1c1c;
        border-color: #1c1c1c;
        color: #fff;
        border-radius: 10px;
        padding: 10px;
        border: 1px solid transparent;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
      }

      .rechazar{
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        border-radius: 10px;
        padding: 10px;
        border: 1px solid transparent;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
      }

    </style>

<title> Respuesta de Protocolo / Propuesta Técnico-Económica </title>
<h3 class="fw-bold text-center py-5"> Respuesta de Protocolo / Propuesta Técnico-Económica </h3>
{{-- <h2>Usuario: {{$daos->curp}}</h2> --}}
{{--Inicio del Login o Acceso --}}
<div class="mb-1 input-group">
    <div class="mb-4 col" style="text-align: center">
        <label class="form-label" style="font-weight: bold; font-size: 1.2em">
            <?php
            if ($proyt->claven < 10)
                echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
            else
                echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
            ?>
        </label>
    </div>
</div>
<div class="mb-1 input-group" id="content">
    <div class="mb-4 col" style="text-align: center">
        @if (Session::has('fail'))
            <div class="alert-danger">{{Session::get('fail')}}</div>
        @endif
    </div>
</div>
<div class="mb-1 input-group" id="principal" name="principal">
    @if ($LoggedUserInfo['director'] == 1)
    <div class="mb-4 col">
        <form action="{{route('firmardgprotocolo', [$proyt->id ,$obs->id])}}" method="post">
            @csrf
            <div class="mb-4">
                <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
                    Firma electrónica institucional
                </p>
                <input type="file" id="archivo" name="archivo" class="form-control">
                <textarea id="datofichero" name="datofichero" class="form-control" hidden></textarea>
                <span class="text-danger">@error('archivo') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
                    Contraseña
                </p>
                <input type="password" id="pass" name="pass" class="form-control">
                <span class="text-danger">@error('pass') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <div class="mb-4 col">
                    <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold; text; border-radius: 15px;">
                        <img src="{!! asset('img/plus.png')!!}" alt="" height="24em" width="24em">
                        Aceptar
                    </button>
                <div>
        </form>
            <br>
            <div class="mb-4 col">
                <a href="{{ route('observaciones', $proyt->id)}}">
                    <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold; border-radius: 15px;">
                        <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                        Cancelar
                    </button>
                </a>
            </div>
        </div>
    </div>
    @else
        <div class="mb-4 col" style="text-align: right">

            {{-- <button id="abrirModal" class="aceptar" style="font-weight:500">
                <img src="{!! asset('img/plus_bl.png')!!}" alt="" height="24em" width="24em">
                &nbsp;Aceptar&nbsp;
            </button> --}}

            
            @if ($obs->tipo == 1 || $obs->tipo == 2)
                <button class="aceptar" id="opc" style="font-weight:500" onclick="showacces()">
                    <img src="{!! asset('img/plus_bl.png')!!}" alt="" height="24em" width="24em">
                    &nbsp;Aceptar&nbsp;
                </button>        
            @elseif ($obs->tipo == 3 || $obs->tipo == 4)
                {{-- Mensaje de confirmacion para iniciar o reanudar proyecto --}}
                        <button id="abrirModal" class="aceptar" style="font-weight:500">
                            <img src="{!! asset('img/plus_bl.png')!!}" alt="" height="24em" width="24em">
                            &nbsp;Aprobar
                            @if ($proyt->clavet == 'I')
                                Protocolo
                            @else
                                PTE
                            @endif
                            &nbsp;
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

                            .botonera {
                            display: flex;
                            justify-content: center;  /* Centra horizontalmente */
                            gap: 10px;                /* Espacio entre los botones */
                            margin-top: 20px;         /* Margen superior opcional */
                            }
                        </style>
                        
                        <div id="ventanaModal" class="modal">
                            <div class="contenido-modal">
                                @if ($proyt->clavet == 'I')
                                    <h2 style="color: #007BFF; font-weight: bold; text-align: center;">¿Está seguro de aprobar el Protocolo?</h2>
                                    <br>
                                    <p style="font-size: 1.3em; font-weight: bold; text-align:justify; color:#FF0000">Se enviara la versión actual, para ser revisada por el mando inmediato, para la espera de la respuesta.</p>
                                @else
                                    <h2 style="color: #007BFF; font-weight: bold; text-align: center;">¿Está seguro de aprobar la Propuesta Técnico-Económica?</h2>
                                    <br>
                                    <p style="font-size: 1.3em; font-weight: bold; text-align:justify; color:#FF0000">Se enviara la versión actual, para ser revisada por el COSPIII, para la espera de la respuesta del comité.</p>
                                @endif
                                <div class="botonera">
                                    <span class="cerrar">
                                        <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;">
                                        <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                                        No, regresar
                                        </button>
                                    </span>
                                    &nbsp;&nbsp;
                                    <form action="{{route('previsadoaprobado', [$proyt->id ,$obs->id])}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold; text">
                                            <img src="{!! asset('img/plus.png')!!}" alt="" height="24em" width="24em">
                                            @if ($proyt->estado == 0 )
                                                Sí, iniciar
                                            @else
                                                Sí, reanudar
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                {{-- Mensaje de confirmacion para iniciar o reanudar proyecto --}}

                {{-- <form action="{{route('previsadoaprobado', [$proyt->id ,$obs->id])}}" method="POST">
                    @csrf
                    <button class="aceptar" id="opc" style="font-weight:500">
                        <img src="{!! asset('img/plus_bl.png')!!}" alt="" height="24em" width="24em">
                        &nbsp;Aprobar
                        @if ($proyt->clavet == 'I')
                            Protocolo
                        @else
                            PTE
                        @endif
                        &nbsp;
                    </button>
                </form> --}}
            @else
                @if ($obs->tipo != 6)
                    <button class="aceptar" id="opc" style="font-weight:500" onclick="showacces()">
                        <img src="{!! asset('img/plus_bl.png')!!}" alt="" height="24em" width="24em">
                        &nbsp;Aprobar&nbsp;
                    </button>    
                @endif
            @endif
        </div>

        <div class="mb-2 col-1">
        </div>

        @if ($obs->tipo == 1 || $obs->tipo == 2)
            <div class="mb-4 col">
                <button class="rechazar" id="opc" style="font-weight:500" onclick="showInp()">
                    <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                    &nbsp;Rechazar&nbsp;
                </button>
            </div>
        @elseif($obs->tipo == 3 || $obs->tipo == 4)
            <div class="mb-4 col">
                <div class="mb-4 col">
                    <button class="regresar" id="opc" style="font-weight:500" onclick="showInp()">
                        <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                        &nbsp;Regresar con observaciones&nbsp;
                    </button>
                </div>
            </div>
        @endif

        @if ($obs->tipo == 3 || $obs->tipo == 4)
            <div class="mb-4 col">
                <button class="rechazar" id="opc" style="font-weight:500" onclick="showrejprot()">
                    <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                    &nbsp;Rechazar
                    @if ($proyt->clavet == 'I')
                        Protocolo
                    @else
                        PTE
                    @endif
                    &nbsp;
                </button>
            </div>
        @endif
    @endif

</div>


{{-- Formulario de rechazo Inicio --}}
<div class="mb-1 input-group" name="rechazos" id="rechazos" style="display: none">
    @if ($obs->tipo == 1)
        <form action="{{route('rechazoreprogram',  [$proyt->id ,$obs->id])}}" method="POST">
    @elseif ($obs->tipo == 2)
        <form action="{{route('rechazocancel',  [$proyt->id ,$obs->id])}}" method="POST">
    @else
        <form action="{{route('notificarprotocolorevision', [$proyt->id, $obs->id])}}" method="POST">
    @endif
    
    @if (Session::has('success'))
        <div class="alert-success">{{Session::get('success')}}</div>
        <br>
    @endif
    @if (Session::has('fail'))
        <div class="alert-danger">{{Session::get('fail')}}</div>
        <br>
    @endif
    @csrf
    <div class="mb-4">
        @if ( $obs->tipo == 1 || $obs->tipo == 2)
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Motivo: </label>
        @elseif ( $obs->tipo == 3 || $obs->tipo == 4)
            <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Comentarios generales: </label>
        @endif
        @if ( $obs->obs_respuesta == '')
            <textarea name="obsresp" id="obsresp" rows="7" class="form-control" placeholder="Describe el motivo o las observaciones">{{old('obsresp')}}</textarea>
        @else
            @if ( $obs->tipo == 4)
                <textarea name="obsresp" id="obsresp" rows="7" class="form-control" placeholder="Describe el motivo o las observaciones">{{$obs->obs_respuesta}}</textarea>
            @endif
        @endif
        <span class="text-danger">@error('obsresp') {{$message}} @enderror</span>
    </div>
    <div>
        <button type="submit" class="btn btn-warning" id="redondb"
        style="background-color: rgb(255, 128, 17); font-weight:500">
            <img src="{!! asset('img/send_bl.png')!!}" alt="" height="24em" width="24em">
            &nbsp;Enviar&nbsp;
        </button>
    </div>
    </form>
    <br>
    <div>
        <a href="{{ route('observaciones', $proyt->id)}}">
        <button type="submit" class="btn btn-dark btn-sm" id="redondb"
        style="font-weight:500">
            <img src="{!! asset('img/back.png')!!}" alt="" height="24em" width="24em">
                &nbsp;Regresar&nbsp;&nbsp;
            </button>
        </a>
    </div>
</div>
{{-- Formulario de rechazo Fin  --}}

{{-- Formulario de rechazo de protocoloas Inicio --}}
<div class="mb-1 input-group" name="negarprotocolo" id="negarprotocolo" style="display: none">
    <form action="{{route('rechazarprotocolopte',  [$proyt->id ,$obs->id])}}" method="POST">
    @if (Session::has('success'))
        <div class="alert-success">{{Session::get('success')}}</div>
        <br>
    @endif
    @if (Session::has('fail'))
        <div class="alert-danger">{{Session::get('fail')}}</div>
        <br>
    @endif
    @csrf
    <div class="mb-4">
        <label class="form-label" style="font-weight: bold; font-size: 1.2em"> Motivo: </label>
        @if ( $obs->obs_respuesta == '')
            <textarea name="obsresp" id="obsresp" rows="7" class="form-control" placeholder="Describe el motivo del rechazo del protocolo o PTE">{{old('obsresp')}}</textarea>
        @else
            @if ( $obs->tipo == 5)
                <textarea name="obsresp" id="obsresp" rows="7" class="form-control" placeholder="Describe el motivo del rechazo del protocolo o PTE">{{$obs->obs_respuesta}}</textarea>
            @endif
        @endif
        <span class="text-danger">@error('obsresp') {{$message}} @enderror</span>
    </div>
    <div>
        <button type="submit" class="btn btn-warning" id="redondb"
        style="background-color: rgb(255, 128, 17); font-weight:500">
            <img src="{!! asset('img/send_bl.png')!!}" alt="" height="24em" width="24em">
            &nbsp;Enviar&nbsp;
        </button>
    </div>
    </form>
    <br>
    <div>
        <a href="{{ route('observaciones', $proyt->id)}}">
        <button type="submit" class="btn btn-dark btn-sm" id="redondb"
        style="font-weight:500">
            <img src="{!! asset('img/back.png')!!}" alt="" height="24em" width="24em">
                &nbsp;Regresar&nbsp;&nbsp;
            </button>
        </a>
    </div>
</div>
{{-- Formulario de rechazo de protocoloas Fin --}}

{{-- Formulario de aceptados Inicio  --}}
<div class="mb-1 input-group" name="aceptados" id="aceptados" @if ($obs->tipo == 6) style="display: block" @else style="display: none" @endif >
    @if ($obs->tipo == 1)
        <form action="{{route('aceptarreprogram', [$proyt->id ,$obs->id])}}" method="POST">
    @elseif ($obs->tipo == 2)
        <form action="{{route('aceptarcancel', [$proyt->id ,$obs->id])}}" method="POST">
    @else
        <form action="{{route('aceptarprotocolo', [$proyt->id ,$obs->id])}}" method="POST">
    @endif
    @csrf
    <div class="mb-4">
        <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
            Firma electrónica institucional
        </p>
        <input type="file" id="archivo" name="archivo" class="form-control">
        <textarea id="datofichero" name="datofichero" class="form-control" hidden></textarea>
        <span class="text-danger">@error('archivo') {{$message}} @enderror</span>
    </div>
    <div class="mb-4">
        <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
            Contraseña
        </p>
        <input type="password" id="pass" name="pass" class="form-control">
        <span class="text-danger">@error('pass') {{$message}} @enderror</span>
    </div>
    <div class="mb-4">
        <div class="mb-4 col">
            <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold; text; border-radius: 15px;">
                <img src="{!! asset('img/plus.png')!!}" alt="" height="24em" width="24em">
                Aceptar
            </button>
        <div>
        </form>
        <br>
        <div class="mb-4 col">
            <a href="{{ route('observaciones', $proyt->id)}}">
                <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold; border-radius: 15px;">
                    <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                    Cancelar
                </button>
            </a>
        </div>
    </div>
</div>
{{-- Formulario de aceptados Inicio  --}}


<script>
    document.getElementById('archivo').onchange = function () {
        document.getElementById('datofichero').innerHTML = document.getElementById('archivo').files[0].name;
    };

    function showacces(){
        document.getElementById("aceptados").style.display = "inline-block";
        document.getElementById("principal").style.display = "none";
    };

    function showInp(){
        document.getElementById("rechazos").style.display = "inline-block";
        document.getElementById("principal").style.display = "none";
    };

    function showrejprot(){
        document.getElementById("negarprotocolo").style.display = "inline-block";
        document.getElementById("principal").style.display = "none";
    };

    // Ventana modal
    var modal = document.getElementById("ventanaModal");
    // Botón que abre el modal
    var boton = document.getElementById("abrirModal");
    // Hace referencia al elemento <span> que tiene la X que cierra la ventana
    var span = document.getElementsByClassName("cerrar")[0];
    // Cuando el usuario hace clic en el botón, se abre la ventana
    boton.addEventListener("click",function() {
        modal.style.display = "block";
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

    $(document).ready(function() {
        setTimeout(function() {
            $("#content").fadeOut(2500);
        },3000);
    });
</script>

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

@stop
