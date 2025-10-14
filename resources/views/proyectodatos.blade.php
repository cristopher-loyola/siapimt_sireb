<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datos proyecto</title>
    <link rel="icon" href="../img/Logo_IMT_mini.png" type="image/png" />
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <style>
        *{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        header{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        header table{
            font-weight: bold;
            font-size: 1.7em;
        }
        #formulario{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        input {
            border: 3px solid transparent; /* Sin borde visible por defecto */
            outline: none; /* Elimina el borde de enfoque por defecto */
            padding: 10px;
            font-size: 16px;
            transition: border-color 0.3s; /* Transición suave del borde */
            border-radius: 10px;
            text-align: center;
        }
        input:hover {
            border-color: #3498db; /* El color del borde al pasar el mouse */
        }
        input:focus {
            border-color: #3498db; /* El color del borde cuando el campo está en enfoque */
        }
        textarea {
            border: 3px solid transparent; /* Sin borde visible por defecto */
            outline: none; /* Elimina el borde de enfoque por defecto */
            /* padding: 10px; */
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
        select {
            border: 3px solid transparent; /* Sin borde visible por defecto */
            outline: none; /* Elimina el borde de enfoque por defecto */
            font-size: .9em;
            transition: border-color 0.3s; /* Transición suave del borde */
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
            resize: none;
            width: 400px;
            border-color: #aacfe7;
            /* padding-right: 30px; */
        }
        select:hover {
            border-color: #3498db; /* El color del borde al pasar el mouse */
        }
        select:focus {
            border-color: #3498db; /* El color del borde cuando el campo está en enfoque */
        }
        .contenedor {
            display: flex;
            gap: 20px;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
        }
        .columna {
            flex: 1;
            padding: 20px;
            border: 1px solid #cccccc00;
        }
        #actualizar{
            background: #1e8719;
            color: #fff;
            border-radius: 5px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #actualizar:hover{
            background: #219d1a;
            transform: scale(1.1); /* Aumenta el tamaño del botón */
        }
        #modificar{
            background: #eeb93d;
            color: #fff;
            border-radius: 5px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #modificar:hover {
            background-color: #d5a73b; /* Cambia el color de fondo */
            transform: scale(1.1); /* Aumenta el tamaño del botón */
        }
        #regresar{
            background: #ee3d3d;
            color: #fff;
            border-radius: 5px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #regresar:hover {
            background-color: #d53b3b; /* Cambia el color de fondo */
            transform: scale(1.1); /* Aumenta el tamaño del botón */
        }
        #cejas{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .boton-ceja-carpeta-actual{
            display: inline-block;
            padding: 15px 30px;
            /* Color de fondo que imita una carpeta amarilla */
            background-color: #007bff;
            border: none;
            border-top: 10px solid #0065d0; /* Color más oscuro para la ceja de la carpeta */
            border-radius: 5px 5px 0 0; /* Bordes redondeados en la parte superior */
            font-size: 16px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            position: relative;
            border-right: 1px solid #0065d0;
        }
        .boton-ceja-carpeta {
            display: inline-block;
            padding: 15px 30px;
            background-color: #3c4d8a;
            border: none;
            border-top: 10px solid #1A2C6E; /* Color más oscuro para la ceja de la carpeta */
            border-radius: 5px 5px 0 0; /* Bordes redondeados en la parte superior */
            font-size: 16px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil para darle un efecto de profundidad */
            border-right: 1px solid #007bff;
        }
        .boton-ceja-carpeta-success {
            display: inline-block;
            padding: 15px 30px;
            background-color: #1e7e19;
            border: none;
            border-top: 10px solid #3ba335; /* Color más oscuro para la ceja de la carpeta */
            border-radius: 5px 5px 0 0; /* Bordes redondeados en la parte superior */
            font-size: 16px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil para darle un efecto de profundidad */
            border-right: 1px solid #3ba335;
        }
        .boton-ceja-carpeta:before {
            content: '';
            position: absolute;
            top: -8px; /* Coloca la "ceja" justo encima del botón */
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 8px;
            background-color: #1A2C6E; /* Mismo color de la ceja */
            border-radius: 5px 5px 0 0; /* Bordes redondeados para la ceja */
        }
        .boton-ceja-carpeta:hover {
            background-color: #2742a5; /* Cambio de color al pasar el ratón */
        }
        .boton-ceja-carpeta-success:hover {
            background-color: #1e8719; /* Cambio de color al pasar el ratón */
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
        #fallo{
            width: 100%;
            background: #9d1a1a9f;
            color: #fff;
            font-size: 1.2em;
            border-radius: 5px;
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }
        #back{
            background: #1f1d1d;
            color: #fff;
            border-radius: 50px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #back:hover {
            background-color: #232121; /* Cambia el color de fondo */
            transform: scale(1.1); /* Aumenta el tamaño del botón */
        }

        #nameproy {
            width: 800px;
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
        }
        #clave{
            text-align: center;
            font-size: 1.4em;
            font-weight: bold;
        }
        #respon option{
            font-size: .9em;
            text-align: center;
        }
        .coloroption{
            text-align: justify;
        }
    </style>
    <script>
        function autoResize(textarea) {
            const actualizar = document.getElementById('actualizar');
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
            textarea.style.borderColor  = "#ed2f39";
            actualizar.id = 'modificar';
        }
        // Llama a la función al cargar la página para ajustar el tamaño inicial
        window.addEventListener('load', () => {
            const textarea = document.getElementById('nameproy');
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        });

        function cambio(){
            const selectElement = document.getElementById('respon');
            const actualizar = document.getElementById('actualizar');
            // Cambia el borde del select dependiendo de la opción seleccionada
            if (selectElement.value === "") {
                selectElement.style.border = "3px solid grey";
                selectElement.style.background = '#95959528';
            } else {
                selectElement.style.border = "3px solid #ed2f39";
                selectElement.style.background = '#fff';
            }
            actualizar.id = 'modificar';
        };

        function cambioa(){
            const selectElement = document.getElementById('aprobo');
            const actualizar = document.getElementById('actualizar');
            // Cambia el borde del select dependiendo de la opción seleccionada
            if (selectElement.value === "") {
                selectElement.style.border = "3px solid grey";
                selectElement.style.background = '#95959528';
            } else {
                selectElement.style.border = "3px solid #ed2f39";
                selectElement.style.background = '#fff';
            }
            actualizar.id = 'modificar';
        };

        $(document).ready(function() {
            setTimeout(function() {
                $("#exito").fadeOut(1500);
                $("#fallo").fadeOut(1500);
            },3000);
        });

        
    </script>

    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill-table-ui.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill-table-ui.min.js') }}"></script>
    <script src="{{ asset('js/quill-config.js') }}"></script>
</head>
@php
    // Modo solo lectura si NO viene ?crear=1
    $soloLectura = request('crear') != 1;
@endphp

@if($soloLectura)
<style>
  /* apariencia de solo lectura y ocultar botones de submit */
  .solo-lectura input:not([type="hidden"]),
  .solo-lectura select,
  .solo-lectura textarea {
    background:#f7f7f7;
    pointer-events:none; /* bloquea clicks/ediciones */
  }
  .solo-lectura button[type="submit"],
  .solo-lectura input[type="submit"] {
    display:none !important; /* no mostrar guardar/envíos */
  }
</style>
@endif

<body>
    <header>
        <img src="../img/Logo_IMT.png" alt="" height="100px" width="120px">
        <table>
            <caption></caption>
            <thead>
                <tr>
                    <th scope="col">Instituto Mexicano del Transporte</th>
                </tr>
                <tr>
                    <th scope="col">Información general</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </header>
    <br>
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
                <li class="sidebar-item active" id="item1">
                    <a href="{{route('proydatos', $proyt->id)}}" class="sidebar-link">
                        <img src="{{asset('/img/info-gnrl.png')}}" alt="Información general" class="sidebar-image">
                        <span class="tooltip active">Información general</span>
                    </a>
                </li>
                @if (($proyt->clavet == 'I' ||$proyt->clavet == 'E') && ($proyt->clavea == 'D' || $proyt->clavea == 'A' || $proyt->clavea == 'G'))
                    <li
                    @if ($vequipo != 0 || $proyt->colaboradores == 1)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item2">
                        <a @if ($proyt->completado == 1) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
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
                    id="item3">
                        <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
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
                    id="item4">
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
                    id="item5">
                        <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                            <span class="tooltip">Análisis de riesgos</span>
                        </a>
                    </li>
                    <li class="sidebar-item-cancel" id="item6">
                        <a href="{{route('infoproys',$proyt->id)}}">
                            <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                            <span class="tooltip">Información del Proyecto</span>
                        </a>
                    </li>
                {{--MENU PARA LOS PROYECTOS INTERNOS--}}
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
                        <a @if ($vimpacto != 0) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
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
                        <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
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
                    <li class="sidebar-item-cancel" id="item8">
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
                        <a @if ($proyt->completado == 1) href="{{ route('contribuciones', $proyt->id)}}" @endif class="sidebar-link">
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
                        <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
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
    <form action="{{ route('actulizarproyecto', $proyt->id) }}" method="POST">
    <div id="cejas">
        <button name="oculto" type="submit" value="1" class="boton-ceja-carpeta-actual">
            A
        </button>
        <button name="oculto" type="submit" value="2"
        @if($proyt->antecedente != '' && $proyt->orientacion != '' && $proyt->materia != '' && $proyt->justificacion != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            B
        </button>
        <button name="oculto" type="submit" value="3"
        @if($proyt->objetivo != '' && $proyt->alcance != '' && $proyt->metodologia != '' && $proyt->objespecifico != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            C
        </button>
        <button name="oculto" type="submit" value="4"
        @if($proyt->producto != '' && $proyt->comcliente != '' && $proyt->beneficios != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            D
        </button>
        <button name="oculto"  type="submit" value="5"
        @if($proyt->idlinea != '' && $proyt->idobjt != '' && $proyt->idalin != '' && $proyt->idmodot != '' && $proyt->referencias != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            E
        </button>
    </div>
    <div style="height: 30px"></div>
    <br>
@php
    // Definir el estado de solo lectura si el proyecto no está en ejecución
    $soloLectura = ($proyt->estado != 1);  // Estado 1 significa en ejecución
@endphp

<div id="formulario">
    <div>
        @if (Session::has('success'))
            <div id="exito">{{ Session::get('success') }}</div>
            <br>
        @endif
        @if (Session::has('fail'))
            <div id="fallo">{{ Session::get('fail') }}</div>
            <br>
        @endif
        @csrf

        <div id="clave">
            {{$proyt->clavea}}{{$proyt->clavet}}-@if($proyt->claven < 10)0{{$proyt->claven}}@else{{$proyt->claven}}@endif/{{$proyt->clavey}}
        </div>
        <div style="height: 50px"></div>

        <!-- Nombre del Proyecto (textarea) -->
        <div>
            <textarea name="nameproy" maxlength="200" 
          style="text-transform:uppercase" 
          id="nameproy" 
          oninput="autoResize(this)" 
          onkeyup="javascript:this.value=this.value.toUpperCase();"
          @if($soloLectura) readonly @endif>
        {{$proyt->nomproy}}
        </textarea>

        </div>
        <div style="height: 30px"></div>

        <div class="contenedor">

            <!-- Responsable (select) -->
            <div class="columna">
                Responsable
                <p></p>
                <select name="respon" id="respon" onchange="cambio(this)" @if($soloLectura) readonly @endif>
                    <option value="{{ $users->id }}">
                        {{ $users->Nombre.' '.$users->Apellido_Paterno.' '.$users->Apellido_Materno }}
                    </option>
                    @if(!$soloLectura)
                        <option value="">Selecciona al responsable</option>
                        @foreach ($user as $use)
                            <option value="{{ $use->id }}" class="coloroption">
                                {{ $use->Nombre.' '.$use->Apellido_Paterno.' '.$use->Apellido_Materno }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <span class="text-danger">@error('respon') {{$message}} @enderror</span>
            </div>
            <div class="columna">
                Aprobó
                <p></p>
<select name="aprobo" id="aprobo" onchange="cambio(this)" 
        @if($soloLectura) class="readonly" @endif>
                    <option value="{{$respon->id}}">
                        {{$respon->Nombre.' '.$respon->Apellido_Paterno.' '.$respon->Apellido_Materno}}
                    </option>
                </select>
                <span class="text-danger">@error('aprobo') {{$message}} @enderror</span>
            </div>

        </div>
    </div>
</div>


            <!-- </div>
                <div class="columna" style="text-align: center">
                    <button type="submit" id="actualizar">
                        <img src="../img/save.png" width="25px" height="25px" alt="">
                        &nbsp;
                        Guardar
                    </button>
                </div>
            </div>  -->
        </div>
    </div>
    </form>
</body>
</html>