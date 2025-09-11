<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Impacto Socioeconómico del Proyecto</title>
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
            background: #0F52BA;
            color: #fff;
            border-radius: 5px;
            font-size: 18px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #actualizar:hover{
            background: #0F52BA;
            transform: scale(1.1);
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
        .form-label {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 12px;
            text-align: center;
        }
/*NUEVA LETRA PARA LA CARD Y EL TEXTO ENTRE LAS COMILLAS*/
        body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
            Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }
/*ESTA ES LA CARD PEQUEÑA QUE TIENE EL PUNTAJE*/
        .card {
            width: 300px;
            height: auto;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgb(199, 199, 199);
        }
        h2 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            line-height: 28px;
            letter-spacing: 3px;
        }
        .card_text {
            padding: 0 30px 30px 30px;
        }
        p {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            line-height: 28px;
            letter-spacing: 2px;
        }
/*LOS COLORES QUE TOMARA LA CARD PEQUEÑA PARA CADA UNO DE LOS NIVELES DEL IISE*/
        .card-muy-bajo {
            background: linear-gradient(30deg, #ff0000 0%, #ff0000 50%, #ff0000 90%);
            box-shadow: 0 0 15px #ff0000;
        }
        .card-bajo {
            background: linear-gradient(30deg, #ff5252 0%, #ff5252 50%, #ff5252 90%);
            box-shadow: 0 0 15px #ff5252;
        }
        .card-medio {
            background: linear-gradient(30deg, #FFBF00 0%, #FFBF00 50%, #FFBF00 90%);
            box-shadow: 0 0 15px #FFBF00;
        }
        .card-alto {
            background: linear-gradient(30deg, #50C878 0%, #50C878 50%, #50C878 90%);
            box-shadow: 0 0 15px #50C878;
        }
        .card-muy-alto {
            background: linear-gradient(30deg, #00A36C 0%, #00A36C 50%, #00A36C 90%);
            box-shadow: 0 0 15px #00A36C;
        }
/*LOS COLORES DEL TETO QUE INDICA EL NIVEL DEL IMPACTO*/
        .results-muy-bajo {
            color: #ff0000;
            font-size: 28px;
            font-weight: 700;
        }
        .results-bajo {
            color: #ff5252;
            font-size: 28px;
            font-weight: 700;
        }
        .results-medio {
            color: #FFBF00;
            font-size: 28px;
            font-weight: 700;
        }
        .results-alto {
            color: #50C878;
            font-size: 28px;
            font-weight: 700;
        }
        .results-muy-alto {
            color: #00A36C;
            font-size: 28px;
            font-weight: 700;
        }
/*ESTA ES LA CARD GRANDE QUE GUARDA LA CARD PEQUEÑA CON EL NIVEL Y LOS RESULTADOS*/
        .card-contenedora {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2); 
            padding: 30px;
            margin: 20px auto;
            width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .proyecto{
            width: 900px;
        }
        .table-checkbox {
            width: 100%;
            border-collapse: collapse;
            margin: 70px 0;
        }
        .table-checkbox td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .table-checkbox th {
            padding: 10px;
            background-color: #f2f2f2;
            text-align: center;
            border: 1px solid #f2f2f2;
        } 

        .columnas{
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 50px;
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
                    <th scope="col">Nivel de Impacto Socioeconómico</th>
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
                justify-content: center; 
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
                @if($proyt->actimpacto == 0) <a href="{{route('proydatos', $proyt->id)}}" class="sidebar-link"> @endif
                    <img src="{{asset('/img/info-gnrl.png')}}" alt="Información general" class="sidebar-image">
                    <span class="tooltip">Información general</span>
                </a>
            </li>
            <li class="sidebar-item active" id="item2">
                <a href="{{ route('impactoproy', $proyt->id) }}" class="sidebar-link">
                    <img src="{{asset('/img/impactosoceco.png')}}" alt="Plan de actividades" class="sidebar-image">
                    <span class="tooltip">Impacto Socioeconómico</span>
                </a>
            </li>
            <li
                @if ($vcontri != 0)
                    class="sidebar-item-success"
                @else
                    class="sidebar-item"
                @endif
                id="item3">
                    @if($proyt->actimpacto == 0) <a @if ($vimpacto != 0) href="{{ route('contribuciones', $proyt->id)}}" @endif class="sidebar-link"> @endif
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
                    @if($proyt->actimpacto == 0) <a @if ($vcontri != 0) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link"> @endif
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
                    @if($proyt->actimpacto == 0) <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link"> @endif
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
                    @if($proyt->actimpacto == 0) <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link"> @endif
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
                    @if($proyt->actimpacto == 0) <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link"> @endif
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
            </ul>
        </div>
    <form action="{{ route('upimpactoproy2', $proyt->id) }}" method="POST">
    <div id="cejas">
        <button name="oculto" type="submit" value="1"
        @if($proytImp->crit1 != null && $proytImp->vcrit1 != 0 && $proytImp->crit2 != 0 &&
            $proytImp->vcrit2 != 0 && $proytImp->crit3 != null && $proytImp->vcrit3 != 0
            && $proytImp->descImpSoc != null)
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>   
            Social
        </button>
        <button name="oculto" type="submit" value="2"
            @if($proytImp->crit4 != null && $proytImp->vcrit4 != 0 && $proytImp->crit5 != null
            && $proytImp->vcrit5 != 0 && $proytImp->crit6 != null && $proytImp->vcrit6 != 0
            && $proytImp->descImpEco != null)
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            Económico
        </button>
        <button name="oculto" type="submit" value="3"
        @if($proytImp->crit1 != 0 && $proytImp->vcrit1 != 0 && $proytImp->crit2 != 0 &&
            $proytImp->vcrit2 != 0 && $proytImp->crit3 != null && $proytImp->vcrit3 != 0 &&
            $proytImp->descImpEco != null && $proytImp->crit4 != null && $proytImp->vcrit4 != 0 && 
            $proytImp->crit5 != null && $proytImp->vcrit5 != 0 && $proytImp->crit6 != null && 
            $proytImp->vcrit6 != 0 && $proytImp->descImpEco != null && $proytImp->nivelImp != null && 
            $proytImp->escalaImp != 0)
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            Resultado
        </button>
    </div>
    <div style="height: 30px"></div>
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
            <div class = "proyecto"> 
            <div id="clave">
                {{$proyt->clavea}}{{$proyt->clavet}}-@if($proyt->claven < 10)0{{$proyt->claven}}@else{{$proyt->claven}}@endif/{{$proyt->clavey}}
                {{$proyt->nomproy}}
            </div> 
            </div>
            <div style="height: 15px"></div>
            <div style="width: 600px; margin: 0 auto;">
            <p style="text-align: center; color: black;">
                El nivel de Impacto Socioeconómico se determina según la siguiente escala de interpretación:
            </p>
            </div>
            <div style="height: 5px"></div>
            <div class="columnas">
                <div class="col-md-6">
                    <table class="table-checkbox">
                        <thead>
                            <tr>
                                <th>Escala</th>
                                <th>Nivel de ISE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>6-10</td>
                                <td>Muy Bajo</td>
                            </tr>
                            <tr>
                                <td>11-15</td>
                                <td>Bajo</td>
                            </tr>
                            <tr>
                                <td>16-20</td>
                                <td>Medio</td>
                            </tr>
                            <tr>
                                <td>21-25</td>
                                <td>Alto</td>
                            </tr>
                            <tr>
                                <td>26-30</td>
                                <td>Muy Alto</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card-contenedora">
                        <div style="height: 10px"></div>
                        <label class="form-label">RESULTADO</label>
                        <div style="height: 20px"></div>
                        <div class="mb-4 col">
                            <div class="wrapper">
                                <div class="card" id="resultadosCardPeque">
                                    <div class="card_heading">
                                        <h2>{{$escalaTot}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div style="height: 30px"></div>
                            <label class="form-label">NIVEL DE ISE</label>
                            <div style="height: 20px"></div>
                            <div class="results" id="resultadosTexto">
                                <label>{{$proytImp->nivelImp}}</label>
                            </div>
                            <div style="height: 20px"></div>
                        </div>
                    </div>
                </div>
            </div>
                
{{--ES EL SCRIPT PARA MANEJAR LOS COLORES DE ACUERDO AL PUNTAJE, SE ESTABLECE EL RANGO DE ACUERDO AL DOC PROPORCIONADO--}}
            <script>
                let escalaTot = {{$escalaTot}};

                let resultadosCardPeque = document.getElementById('resultadosCardPeque');
                let resultadosTexto= document.getElementById('resultadosTexto');
                resultadosCardPeque.classList.remove('card-muy-bajo', 'card-bajo', 'card-medio', 'card-alto', 'card-muy-alto');
                resultadosTexto.classList.remove('results-muy-bajo', 'results-bajo', 'results-medio', 'results-alto', 'results-muy-alto');

                if (escalaTot >= 6 && escalaTot <= 10) {
                    resultadosCardPeque.classList.add('card-muy-bajo');
                    resultadosTexto.classList.add('results-muy-bajo');
                } else if (escalaTot >= 11 && escalaTot <= 15) {
                    resultadosCardPeque.classList.add('card-bajo');
                    resultadosTexto.classList.add('results-bajo');
                } else if (escalaTot >= 16 && escalaTot <= 20) {
                    resultadosCardPeque.classList.add('card-medio');
                    resultadosTexto.classList.add('results-medio');
                } else if (escalaTot >= 21 && escalaTot <= 25) {
                    resultadosCardPeque.classList.add('card-alto');
                    resultadosTexto.classList.add('results-alto');
                } else if (escalaTot >= 26 && escalaTot <= 30) {
                    resultadosCardPeque.classList.add('card-muy-alto');
                    resultadosTexto.classList.add('results-muy-alto');
                }
            </script>
            <div style="height: 30px"></div>
                <div style="text-align: center">
                <button type="submit" id="actualizar" value="4" name="oculto">
                    <img src="../img/siguienteflecha.png" width="25px" height="25px" alt="">
                    &nbsp;
                    Continuar
                </button>
                </div>
            <div style="height: 20px"></div>
        </div>
    </form>
</body>
</html>