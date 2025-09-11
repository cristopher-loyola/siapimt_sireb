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
            border: 3px solid transparent;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s;
            border-radius: 10px;
            text-align: justify;
            overflow: hidden;
            resize: none;
            border-color: #aacfe7;
        }
        textarea:hover {
            border-color: #3498db;
        }
        textarea:focus {
            border-color: #3498db;
        }
        textarea::placeholder {
            color: #84abf4;
            font-style: italic;
        }
        select {
            border: 3px solid transparent; /* Sin borde visible por defecto */
            outline: none; /* Elimina el borde de enfoque por defecto */
            font-size: 1em;
            transition: border-color 0.3s; /* Transición suave del borde */
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
            resize: none;
            width: 100%;
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
            /* Color de fondo que imita una carpeta amarilla */
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
            border-right: 1px solid #1A2C6E;
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
        label{
            text-align: justify;
            font-weight: 700;
            font-size: 1.2em;
        }
        /* #notas{
            background: #eeb93d;
            border-radius: 10px;
            border: 1px solid transparent;
            text-align: center;
            vertical-align: middle;
            padding: 5px 5px 5px 5px;
        }
        #notas:hover {
            background-color: #d5a73b;
            transform: scale(1.1);
        } */
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

        #antecedente{
            width: 800px;
        }
        #justifica{
            width: 800px;
        }

        .constpostick{
            display: flex;
            justify-content: flex-end;
        }
        .post-it {
            width: 600px;
            padding: 10px;
            background-color: #ffeb3b; /* Fondo amarillo para el post-it */
            border: 2px solid #fbc02d; /* Borde amarillo más oscuro */
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2); /* Sombra para el efecto 3D */
            font-size: 16px;
            color: #333;
            resize: none; /* Evita que el textarea cambie de tamaño */
            position: relative;
        }
        .post-it-title {
            font-weight: bold;
            font-size: 18px;
            color: #333;
            position: absolute;
            top: -10px;
            left: 10px;
            background-color: #ffeb3b;
            padding: 0 5px;
            border-radius: 5px;
        }
        .post-it:focus {
            outline: none;
            border: 2px solid #f57f17; /* Borde más oscuro al enfocar */
        }
        #notajust{
            width: 580px;
            height: 60px;
            background: transparent;
            text-align: justify;
            border: 1px transparent solid;
        }
        #notaant{
            width: 580px;
            height: 60px;
            background: transparent;
            text-align: justify;
            border: 1px transparent solid;
        }
        #clave{
            text-align: center;
            font-size: 1em;
            font-weight: bold;
            width: 800px;
        }

    </style>
    <script>
        function autoResize(textarea) {
            const actualizar = document.getElementById('actualizar');
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
            textarea.style.borderColor  = "#ed2f39";
            actualizar.id = 'modificar';
        };

        window.addEventListener('load', () => {
            const textarea = document.getElementById('justifica');
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
            const textarea1 = document.getElementById('antecedente');
            textarea1.style.height = 'auto';
            textarea1.style.height = (textarea1.scrollHeight) + 'px';
            const textarea2 = document.getElementById('notajust');
            textarea2.style.height = 'auto';
            textarea2.style.height = (textarea2.scrollHeight) + 'px';
            const textarea3 = document.getElementById('notaant');
            textarea3.style.height = 'auto';
            textarea3.style.height = (textarea3.scrollHeight) + 'px';
        });

        function cambio(){
            const selectElement = document.getElementById('materia');
            const actualizar = document.getElementById('actualizar');
            if (selectElement.value === "") {
                selectElement.style.border = "3px solid grey";
                selectElement.style.background = '#95959528';
            } else {
                selectElement.style.border = "3px solid #ed2f39";
                selectElement.style.background = '#fff';
            }
            actualizar.id = 'modificar';
        };

        function cambio1(){
            const selectElement = document.getElementById('orien');
            const actualizar = document.getElementById('actualizar');
            if (selectElement.value === "") {
                selectElement.style.border = "3px solid grey";
                selectElement.style.background = '#95959528';
            } else {
                selectElement.style.border = "3px solid #ed2f39";
                selectElement.style.background = '#fff';
            }
            actualizar.id = 'modificar';
        };

        function cambio2(){
            const selectElement = document.getElementById('nivel');
            const actualizar = document.getElementById('actualizar');
            if (selectElement.value === "") {
                selectElement.style.border = "3px solid grey";
                selectElement.style.background = '#95959528';
            } else {
                selectElement.style.border = "3px solid #ed2f39";
                selectElement.style.background = '#fff';
            }
            actualizar.id = 'modificar';
        };

        function toggleVisibility() {
            var element = document.getElementById("obj1");
            var checkbox = document.getElementById("mostrarOcultar");
            var textarea = document.getElementById('notajust');

            if (checkbox.checked) {
                element.style.display = "block";
                textarea.style.width = `580px`;
                textarea.style.height = `60px`;
            } else {
                element.style.display = "none";
            }
        }

        function toggleVisibility1() {
            var element = document.getElementById("obj2");
            var checkbox = document.getElementById("mostrarOcultar1");
            var textarea = document.getElementById('notaant');

            if (checkbox.checked) {
                element.style.display = "block";
                textarea.style.width = `580px`;
                textarea.style.height = `60px`;
            } else {
                element.style.display = "none";
            }
        }
0
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
    
</head>
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

            #justifica-container{
                min-height: 100px;
            }
            .ql-toolbar.ql-snow,
            .editor-quill {
                width: 800px;
                margin: 0 auto;
                border-width: 3px !important;
                border-style: solid !important;
                border-color: #aacfe7 !important; 
                box-sizing: border-box;
                margin-bottom: 6px !important;
            }

            .ql-toolbar.ql-snow {
                background: #fff;
                border-radius: 10px 10px 0 0;
                border: 3px solid #aacfe7;
                border-bottom: none;
                padding: 10px;
            }

            .editor-quill {
                min-height: 150px;
                max-height: 300px;
                height: 200px;
                overflow-y: auto;
                background: #fff;
                border-radius: 0 0 10px 10px;
                border: 3px solid #aacfe7;
                border-top: none;
                padding: 10px;
            }
            .editor-quill.borde-azul, .ql-toolbar.ql-snow.borde-azul {
                border-color: #6bb3e3 !important;
            }
            .editor-quill.borde-rojo, .ql-toolbar.ql-snow.borde-rojo {
                border-color: #e74c3c !important;
            }
            .ql-toolbar .ql-formats button[title] {
                position: relative;
            }
            .ql-table::before {
                content: '▦'; 
                font-size: 16px;
                color: #444;
                display: inline-block;
                line-height: 1;
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

                @elseif($proyt->clavet == 'I')
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
                        <a @if ($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
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
                        <a @if($vtarea != 0) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
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
                        <a @if ($vrecurso != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
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
                        <a @if ($vriesgo != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
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
                {{-- MENU LATERAL PARA EXTERNOS--}}
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
                        <a @if ($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
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
                        <a @if($vtarea != 0) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
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
                        <a @if ($vrecurso != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
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
                        <a @if ($vriesgo != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
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
    <form action="{{ route('actulizarproyecto1', $proyt->id) }}" method="POST">
        <input type="hidden" id="idproy-quill" name="idproy" value="{{$proyt->id}}">
    <div id="cejas">
        <button name="oculto" type="submit" value="1"
        @if($proyt->nomproy != '' && $proyt->idusuarior != '' && $proyt->aprobo != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            A
        </button>
        <button name="oculto" type="submit" value="2" class="boton-ceja-carpeta-actual">
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
    <br>
    <div id="formulario">
        <div>
            @if (Session::has('success'))
                <div id="exito">{{Session::get('success')}}</div>
                <br>
            @endif
            @if (Session::has('fail'))
                <div id="fallo">{{Session::get('fail')}}</div>
                <br>
            @endif
            @csrf
            <div id="clave">
                {{$proyt->clavea}}{{$proyt->clavet}}-@if($proyt->claven < 10)0{{$proyt->claven}}@else{{$proyt->claven}}@endif/{{$proyt->clavey}} -
                {{$proyt->nomproy}}
            </div>
            <br>
            <label>Justificación</label>
            <div style="height: 10px;"></div>

            <div class="form-group">
                @php
                    $justificacion = old('justificacion', $proyt->justificacion ?? '');
                    if($proyt->clavet == 'I'){
                        $placeholder = 'Justificar su realización, indicando la necesidad o problemática que se busca atender en referencia a su alineación al Plan Nacional de Desarrollo, a las estrategias, las líneas de acción y objetivo del Programa Sectorial de la SICT vigentes, así como a su contribución al Decreto de creación vigente.';
                    }else{
                        $placeholder = 'Justificar la realización de la investigación, refiriéndose a la solicitud de una Unidad Administrativa de la SICT o de un cliente externo.';
                    }
                @endphp

                <div class="editor-quill" data-input="justificacion"
                    @if(empty(strip_tags($justificacion)))
                        placeholder="{{$placeholder}}"
                    @endif>
                    @if(!empty(strip_tags($justificacion))){!!$justificacion !!}@endif</div>

                <input type="hidden" name="justificacion" value="{{$justificacion}}">
                <span class="text-danger">@error('justificacion') {{$message}} @enderror</span>
            </div>

            {{--<div>
                @if ($proyt->justificacion == '')
                    @if ($proyt->clavet == 'I')
                        <div="justifica-container" class="quill-editor" classtype="text" id="justifica" name="justifica" rows="5" oninput="autoResize(this)"
                        placeholder="Justificar su realización, indicando la necesidad o problemática que se busca atender en referencia a su alineación al Plan Nacional de Desarrollo, a las estrategias, las líneas de acción y objetivo del Programa Sectorial de la SICT vigentes, así como a su contribución al Decreto de creación vigente."
                        >{{old('justifica')}}</textarea>
                    @else
                        <textarea type="text" id="justifica" name="justifica" rows="5" oninput="autoResize(this)"
                        placeholder="Justificar la realización de la investigación, refiriéndose a la solicitud de una Unidad Administrativa de la SICT o de un cliente externo."
                        >{{old('justifica')}}</textarea>
                    @endif
                @else
                    <textarea type="text" id="justifica" name="justifica" rows="5" oninput="autoResize(this)">{{$proyt->justificacion}}</textarea>
                @endif
                <span class="text-danger">@error('justifica') {{$message}} @enderror</span>
                <br>
            </div>--}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Obtén el nombre del usuario (esto lo pasa Laravel con Blade)
                    const userName = @json($LoggedUserInfo['Nombre']);

                    // Selecciona el textarea
                    const contentField = document.getElementById('notajust');

                    // Función para auto-ajustar la altura del textarea
                    function autoResizeuniq() {
                        // Restablecer la altura para que el contenido no se corte al redimensionar
                        contentField.style.height = 'auto';
                        contentField.style.height = (contentField.scrollHeight) + 'px';
                    }

                    // Variable para verificar si es el primer comentario
                    let firstComment = true;

                    // Escucha el evento keydown para detectar cuando se presiona "Enter"
                    contentField.addEventListener('keydown', function(event) {
                        // Verifica si la tecla presionada es "Enter" (código de tecla 13)
                        if (event.key === "Enter") {
                            // Prevenir el comportamiento por defecto del Enter (que agregue un salto de línea extra)
                            event.preventDefault();
                            
                            // Obtén el texto actual del textarea
                            const currentText = contentField.value.trim();

                            // Si el texto no está vacío, agrega el nombre de usuario seguido de un salto de línea
                            if (currentText.length > 0) {
                                // Añadir el nombre del usuario y luego un salto de línea
                                contentField.value = currentText + "\n" + userName + ": ";
                                
                                // Llamamos a la función para redimensionar el textarea después de agregar el nombre
                                autoResizeuniq();
                            }
                        }
                    });

                    // Escucha el evento input para agregar el nombre en el primer comentario
                    contentField.addEventListener('input', function() {
                        // Verifica si es el primer comentario
                        if (firstComment && contentField.value.trim().length > 0) {
                            contentField.value = userName + ": " + contentField.value.replace(/^.*?:\s*/, "");
                            firstComment = false;  // Después de esto, ya no será el primer comentario
                            autoResizeuniq();  // Asegura que se ajuste el tamaño después de agregar el nombre
                        }
                    });

                    // Inicializa la función de auto-resize al cargar la página
                    autoResizeuniq();
                });
            </script>
            <!--<script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Inicializa Quill en el contenedor con el ID correspondiente
                    var quill = new Quill('#justifica-container', {
                        theme: 'snow',  // O 'bubble' si prefieres otro estilo
                        modules: {
                            toolbar: [
                                [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'align': [] }],
                                ['bold', 'italic', 'underline'],
                                ['link'],
                                ['image'],
                                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                                [{ 'font': [] }],
                                [{ 'align': [] }],
                            ]
                        }
                    });
                });

                document.addEventListener("DOMContentLoaded", function () {
                    editor.on('justifica', function () {
                        quillEditor.value = editor.root.innerHTML = "";
                    })
                });

                editor.on('text-change', function () {
                    
                })

            </script>-->
            @if ($proyt->aprobo == $LoggedUserInfo['id'])
                @if ($proyt->obsnotasjust == '')
                    <div>
                        <label for="mostrarOcultar">Agregar comentario:</label>
                        <input type="checkbox" id="mostrarOcultar" onclick="toggleVisibility()">
                    </div>
                    <br>
                    <div class="constpostick">
                        <div class="post-it" id="obj1" style="display: none">
                            <div class="post-it-title">Comentario: Justificación</div>
                            <textarea type="text" id="notajust" name="notajust" rows="3" oninput="autoResize(this)">{{old('notajust')}}</textarea>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="constpostick">
                        <div class="post-it">
                            <div class="post-it-title">Comentario: Justificación</div>
                            <textarea type="text" id="notajust" name="notajust" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasjust}}</textarea>
                        </div>
                    </div>
                @endif
            @else
                @if ($proyt->obsnotasjust != '')
                    @if ($proyt->gprotocolo != 2)
                        <br>
                        <div class="constpostick">
                            <div class="post-it">
                                <div class="post-it-title">Comentario: Justificación</div>
                                <textarea type="text" id="notajust" name="notajust" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasjust}}</textarea>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
            <br>
            <label class="form-label"> Materia </label>
            <div class="mb-4 col">
                <select name="materia" id="materia" onchange="cambio(this)">
                    @if ($proyt->materia != '')
                        @foreach ($materia as $mat)
                            @if ($proyt->materia == $mat->id)
                            <option value="{{$proyt->materia}}">{{$mat->descmateria}}</option>
                            @endif
                        @endforeach
                    @endif
                    <option value="{{old('materia')}}">Selecciona...</option>
                    @foreach ($materia as $mat)
                        <option value="{{ $mat->id }}">
                            {{$mat->descmateria}}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger">@error('materia') {{$message}} @enderror</span>
            </div>
            <br>
            <label class="form-label"> Orientación </label>
            <div class="mb-4 col">
                <select name="orien" id="orien" onchange="cambio1(this)">
                    @if ($proyt->orientacion != '')
                        @foreach ($orientacion as $ore)
                            @if ($proyt->orientacion == $ore->id)
                            <option value="{{$proyt->orientacion}}">{{$ore->descorientacion}}</option>
                            @endif
                        @endforeach
                    @endif
                    <option value="{{old('orien')}}">Selecciona...</option>
                    @foreach ($orientacion as $ore)
                        <option value="{{ $ore->id }}">
                            {{$ore->descorientacion}}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger">@error('orien') {{$message}} @enderror</span>
            </div>
            <br>
            {{--<label> Nivel de impacto social o Económico </label>
            <div>
                <select name="nivel" id="nivel" onchange="cambio2(this)">
                    @if ($proyt->nivel != '')
                        @foreach ($nivel as $lvl)
                            @if ($proyt->nivel == $lvl->id)
                            <option value="{{$proyt->nivel}}">{{$lvl->nivel}}</option>
                            @endif
                        @endforeach
                    @endif
                    <option value="{{old('nivel')}}">Selecciona...</option>
                    @foreach ($nivel as $lvl)
                        <option value="{{ $lvl->id }}">
                            {{$lvl->nivel}}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger">@error('nivel') {{$message}} @enderror</span>
            </div>--}}
            <br>
            <label> Antecedentes </label>
            <div style="height: 10px;"></div>
            @php
                $antecedente = old('antecedente', $proyt->antecedente ?? '');
                $placeholderAnt = 'Describir en un máximo de dos cuartillas el conocimiento existente sobre el tema de investigación, su evolución histórica y su relación con las aportaciones esperadas de la investigación.';
            @endphp
            <div class="form-group">
                <div class="editor-quill" data-input="antecedente"
                    @if(empty(strip_tags($antecedente)))
                        placeholder="{{$placeholderAnt}}"
                    @endif>
                    @if(!empty(strip_tags($antecedente))){!!$antecedente!!}@endif</div>
                <input type="hidden" name="antecedente" value="{{$antecedente}}">
                <span class="text-danger">@error('antecedente') {{$message}} @enderror</span>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Obtén el nombre del usuario (esto lo pasa Laravel con Blade)
                    const userName = @json($LoggedUserInfo['Nombre']); 

                    // Selecciona el textarea
                    const contentField = document.getElementById('notaant');

                    // Función para auto-ajustar la altura del textarea
                    function autoResizeuniq() {
                        // Restablecer la altura para que el contenido no se corte al redimensionar
                        contentField.style.height = 'auto';
                        contentField.style.height = (contentField.scrollHeight) + 'px';
                    }

                    // Variable para verificar si es el primer comentario
                    let firstComment = true;

                    // Escucha el evento keydown para detectar cuando se presiona "Enter"
                    contentField.addEventListener('keydown', function(event) {
                        // Verifica si la tecla presionada es "Enter" (código de tecla 13)
                        if (event.key === "Enter") {
                            // Prevenir el comportamiento por defecto del Enter (que agregue un salto de línea extra)
                            event.preventDefault();
                            
                            // Obtén el texto actual del textarea
                            const currentText = contentField.value.trim();

                            // Si el texto no está vacío, agrega el nombre de usuario seguido de un salto de línea
                            if (currentText.length > 0) {
                                // Añadir el nombre del usuario y luego un salto de línea
                                contentField.value = currentText + "\n" + userName + ": ";
                                
                                // Llamamos a la función para redimensionar el textarea después de agregar el nombre
                                autoResizeuniq();
                            }
                        }
                    });

                    // Escucha el evento input para agregar el nombre en el primer comentario
                    contentField.addEventListener('input', function() {
                        // Verifica si es el primer comentario
                        if (firstComment && contentField.value.trim().length > 0) {
                            contentField.value = userName + ": " + contentField.value.replace(/^.*?:\s*/, "");
                            firstComment = false;  // Después de esto, ya no será el primer comentario
                            autoResizeuniq();  // Asegura que se ajuste el tamaño después de agregar el nombre
                        }
                    });

                    // Inicializa la función de auto-resize al cargar la página
                    autoResizeuniq();
                });
            </script>
            @if ($proyt->aprobo == $LoggedUserInfo['id'])
                @if ($proyt->obsnotasantc == '')
                    <div>
                        <label for="mostrarOcultar1">Agregar comentario:</label>
                        <input type="checkbox" id="mostrarOcultar1" onclick="toggleVisibility1()">
                    </div>
                    <br>
                    <div class="constpostick">
                        <div class="post-it" id="obj2" style="display: none">
                            <div class="post-it-title">Comentario: Antecedentes</div>
                            <textarea type="text" id="notaant" name="notaant" rows="3" oninput="autoResize(this)">{{old('notaant')}}</textarea>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="constpostick">
                        <div class="post-it">
                            <div class="post-it-title">Comentario: Antecedentes</div>
                            <textarea type="text" id="notaant" name="notaant" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasantc}}</textarea>
                        </div>
                    </div>
                @endif
            @else
                @if ($proyt->obsnotasantc != '')
                    @if ($proyt->gprotocolo != 2)
                        <br>
                        <div class="constpostick">
                            <div class="post-it">
                                <div class="post-it-title">Comentario: Antecedentes</div>
                                <textarea type="text" id="notaant" name="notaant" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasantc}}</textarea>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
            <br>
            {{-- <div style="text-align: center">
                <button type="submit" id="actualizar">
                    <img src="../img/save.png" width="25px" height="25px" alt="">
                    &nbsp;
                    Guardar
                </button>
            </div> --}}
        </div>
    </div>
    </form>
    <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>

    <script src="{{ asset('vendor/quill/quill-table-ui.min.js') }}"></script>
    
    <script src="{{ asset('js/quill-config.js') }}"></script>
</body>
</html>