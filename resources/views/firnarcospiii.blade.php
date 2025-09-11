@extends('plantillas/plantilla2')
@section('contenido')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #inputsContainer{
        background: #e7e7e7b2;
        width: 800px;
        padding: 25px;
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
<title> Proyecto</title>
<div>
    <h3 class="fw-bold text-center py-5" id="tituloform">Panel del COSPIII </h3>
<div>
    <div class="mb-4">
        @if (Session::has('success'))
            <div id="exito">{{Session::get('success')}}</div>
            <br>
        @endif
    </div>
<div>
    <a href="{{ route('cancelcrud')}}">
        <button type="submit" class="btn btn-dark btn-lg" id="redondb">
            <i class='bx bxs-chevron-left-circle bx-sm bx-flashing-hover'></i>
            <i class='bx  bxs-home bx-sm bx-flashing-hover'></i>
        </button>
    </a>
</div>
<br>
<div>
    <form id="formSeleccionados" method="POST" action="{{route('aprobarcospiii')}}">
        @csrf
        <table class="table table-hover table-sm table-responsive-sm">
            <thead class="thead-dark">
                <tr>
                    <th><input type="checkbox" id="checkAll" class="form-control"></th>
                    <th scope="col" style="width: 5rem;">Clave</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Área</th>
                    <th scope="col" style="width: 820px">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proyt as $pr)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $pr->id }}" class="form-control"></td>
                        <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                        else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                        ?>
                        <td><a href="{{ route('infoproys', $pr->idproyecto)}}">{{$pr->nomproy}}</a></td>
                        <td>{{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}</td>
                        <td>{{$pr->nombre_area}}</td>
                        <td><textarea name="obsfinal[{{ $pr->id }}]" rows="3" style="width: 100%"></textarea></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Mensaje de confirmacion para iniciar o reanudar proyecto --}}
            <button id="abrirModal" class="btn btn-primary" style="font-weight:500; border-radius:25px;" type="button">
                <img src="{!! asset('img/plus.png')!!}" alt="" height="24em" width="24em" style="margin-bottom: .1em">
                Aprobar Protocolos
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
                    <h2 style="color: #007BFF; font-weight: bold; text-align: center;">¿Está seguro de continuar?</h2>
                    <br>
                    <p style="font-size: 1.3em; font-weight: bold; text-align:justify; color:#FF0000">Si continuas, los proyectos marcados enviaran una notificación con las observaciones o el mensaje de aprobación </p>
                    <div class="botonera">
                        <span class="cerrar">
                            <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;">
                                <img src="{!! asset('img/reject.png')!!}" alt="" height="24em" width="24em">
                                No, Regresar
                            </button>
                        </span>
                        &nbsp;&nbsp;
                        <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold; text">
                            <img src="{!! asset('img/plus.png')!!}" alt="" height="24em" width="24em">
                            Sí, Continuar
                        </button>
                    </div>
                </div>
            </div>
        {{-- Mensaje de confirmacion para iniciar o reanudar proyecto --}}

        {{-- <div style="display: block; text-align: right;">
            <button class="btn btn-primary" id="showmost" type="submit">Aprobar Protocolos</button>
        </div> --}}
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#checkAll').click(function() {
        $('input[name="ids[]"]').prop('checked', this.checked);
    });
</script>
<script>
     document.getElementById('archivo').onchange = function () {
        document.getElementById('datofichero').innerHTML = document.getElementById('archivo').files[0].name;
    };

    function mostrarInputs() {
        const container = document.getElementById('inputsContainer');
        const most = document.getElementById('showmost');
        const space = document.getElementById('spacecontainer');
        container.style.display = 'block';
        space.style.display = 'block';
        most.style.display = 'none';
    };

    function mostrarInputs2() {
        const container = document.getElementById('inputsContainer');
        const most = document.getElementById('showmost2');
        const space = document.getElementById('spacecontainer');
        container.style.display = 'block';
        space.style.display = 'block';
        most.style.display = 'none';
    };
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
@push('scripts')
@endpush