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

<title>Firmar Protocolo / Propuesta Técnico-Económica</title>
<h3 class="fw-bold text-center py-5">
    Firmar Protocolo / Propuesta Técnico-Económica
</h3>
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
    <div class="mb-4 col" style="text-align: right">
        <button class="aceptar" id="opc" style="font-weight:500" onclick="showacces()">
            <img src="{!! asset('img/plus_bl.png')!!}" alt="" height="24em" width="24em">
            &nbsp;Firmar&nbsp;
        </button>
    </div>

    <div class="mb-2 col-1">
    </div>

    <div class="mb-4 col">
        <a href="{{ route('observaciones', $proyt->id)}}">
            <button type="submit" class="regresar" style="font-weight:500">
                <img src="{!! asset('img/back.png')!!}" alt="" height="24em" width="24em">
                &nbsp;Regresar&nbsp;&nbsp;
            </button>
        </a>
    </div>
</div>

{{-- Formulario de aceptados Inicio  --}}
<div class="mb-1 input-group" name="aceptados" id="aceptados" style="display: none">
    <form action="{{route('firmarprotocolo', [$proyt->id ,$obs->id])}}" method="POST">
    @csrf
    <div class="mb-4">
        <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
            Usuario
        </p>
        <input type="text" id="user" name="user" class="form-control">
        <span class="text-danger">@error('user') {{$message}} @enderror</span>
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
            <a href="{{ route('infoproys', $proyt->id)}}">
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
@stop
