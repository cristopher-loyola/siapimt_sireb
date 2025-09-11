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
            border: 3px solid transparent;
            outline: none; 
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
        #submitImpacto{
            background: #129990;
            color: #fff;
            border-radius: 5px;
            font-size: 18px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #submitImpacto:hover{
            background: #129990;
            transform: scale(1.1); 
        }
        #modificar{
            background: #129990;
            color: #fff;
            border-radius: 5px;
            font-size: 18px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #modificar:hover {
            background-color: #129990; 
            transform: scale(1.1); 
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
            background-color: #d53b3b; 
            transform: scale(1.1); 
        }
        #cejas{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .boton-ceja-carpeta-actual{
            display: inline-block;
            padding: 15px 30px;
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
            top: -8px; 
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 8px;
            background-color: #1A2C6E;
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
            background: #941717;
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
            background-color: #232121; /
            transform: scale(1.1); 
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
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }
/*CHECKBOX*/
        .custom-checkbox-container {
            position: relative;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .custom-checkbox {
            display: none;
        }
        .custom-checkbox-label {
            position: relative;
            padding-left: 35px; 
            cursor: pointer;
            font-size: 16px;
            color: #333;
        }
        .custom-checkbox-label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 15px;
            height: 15px;
            border: 2px solid #007bff;
            border-radius: 15%;
            background-color: #fff;
            transition: all 0.3s ease;
        }
/*COLORES PARA CUANDO SE MARQUE*/
        .custom-checkbox:checked + .custom-checkbox-label::before {
            background-color: #00c04099;
            border-color: #00C04099;
        }
/*PALOMITA DENTRO DEL CHECKBOX*/
        .custom-checkbox:checked + .custom-checkbox-label::after {
            content: '\2713';
            position: absolute;
            left: 4px;
            top: 2px;
            color: #fff;
            font-size: 12px;
        }
        .custom-checkbox-label:hover::before {
            border-color: #0056b3;
        }
/*TABLA QUE ALMACENA LOS CHECKBOX DE CADA CRITERIO*/
        .table-checkbox {
            width: 930px;
            border-collapse: collapse;
        }
        .table-checkbox td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .table-row:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .custom-checkbox-container {
            display: flex;
            align-items: center;
        }
        .custom-checkbox {
            margin-right: 10px;
        }
        .custom-checkbox-label {
            cursor: pointer;
        }
        .center-container {
            width: 80%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;  
        }
        #justificaImp{
            width: 930px;
        }
        .proyecto{
            width: 900px;
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

        document.querySelectorAll('.custom-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                this.nextElementSibling.classList.toggle('checked', this.checked);
            });
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
                display: flex;
                align-items: center; 
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
    <form action="{{ route('upimpactoproy1', $proyt->id) }}" method="POST">
    <div id="cejas">
        <button name="oculto" type="submit" value="1"
        @if($proytImp->crit1 != '' && $proytImp->vcrit1 != '' && $proytImp->crit2 != '' && 
            $proytImp->vcrit2 != '' && $proytImp->crit3 != '' && $proytImp->vcrit3 != '' &&
            $proytImp->descImpSoc != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>   
            Social
        </button>
        <button name="oculto" type="submit" value="2" class="boton-ceja-carpeta-actual"
        @if($proytImp->crit4 != '' && $proytImp->vcrit4 != '' && $proytImp->crit5 != ''
            && $proytImp->vcrit5 != '' && $proytImp->crit6 != '' && $proytImp->vcrit6 != ''
            && $proytImp->descImpEco != '')
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
                <div id="exito">{{ Session::get('success') }}</div>
                <br>
            @endif
            @if (Session::has('fail'))
                <div id="fallo">{{ Session::get('fail') }}</div>
                <br>
            @endif
            @csrf
            <div class="proyecto">
                <div id="clave">
                    {{$proyt->clavea}}{{$proyt->clavet}}-@if($proyt->claven < 10)0{{$proyt->claven}}@else{{$proyt->claven}}@endif/{{$proyt->clavey}}
                    {{$proyt->nomproy}}
                </div>
            </div>  
            <div style="height: 35px"></div>
            <label class="form-label">¿Qué propone el proyecto para aumentar la eficiencia del transporte? <span title= "Seleccione una o varias opciones."><img src="{{asset('/img/noteimp.png')}}"></span></label>
            <div style="height: 20px"></div>
            <div class="mb-4 col">
                @if ($eficiTransp != '')
                    <table class="table-checkbox">
                        @foreach ($eficiTransp as $efici)
                            <tr class="table-row">
                                <td>
                                    <div class="custom-checkbox-container">
                                        <input type="checkbox" class="custom-checkbox" id="eficienciaTransp_{{ $efici->id }}" value="{{ $efici->id }}" name="eficienciaTransp[]"
                                            @if(in_array($efici->id, old('eficienciaTransp', explode(',', $proytImp->crit4 ?? '')))) checked @endif>
                                        <label for="eficienciaTransp_{{ $efici->id }}" class="custom-checkbox-label">
                                            <span>{{ $efici->descEficiencia }}</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                <span class="text-danger">@error('eficienciaTransp') {{$message}} @enderror</span>
            </div>

            <div style="height: 35px"></div>

            <label class="form-label">¿Qué propone el proyecto para aumentar la productividad del transporte? <span title= "Seleccione una o varias opciones."><img src="{{asset('/img/noteimp.png')}}"></span></label>
            <div style="height: 20px"></div>
            <div class="mb-4 col">
                @if ($produTransp != '')
                    <table class="table-checkbox">
                        @foreach ($produTransp as $produ)
                            <tr class="table-row">
                                <td>
                                    <div class="custom-checkbox-container">
                                        <input type="checkbox" class="custom-checkbox" id="productividadTransp_{{ $produ->id }}" value="{{ $produ->id }}" name="productividadTransp[]"
                                            @if(in_array($produ->id, old('productividadTransp', explode(',', $proytImp->crit5 ?? '')))) checked @endif>
                                        <label for="productividadTransp_{{ $produ->id }}" class="custom-checkbox-label">
                                            <span>{{ $produ->descProductividad }}</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                <span class="text-danger">@error('productividadTransp') {{$message}} @enderror</span>
            </div>

            <div style="height: 35px"></div>

            <label class="form-label">¿Cuál es la contribución económica esperada del proyecto en el sector del transporte? <span title= "Seleccione una o varias opciones."><img src="{{asset('/img/noteimp.png')}}"></span></label>
            <div style="height: 20px"></div>
            <div class="mb-4 col">
                @if ($contriEco != '')
                    <table class="table-checkbox">
                        @foreach ($contriEco as $contriE)
                            <tr class="table-row">
                                <td>
                                    <div class="custom-checkbox-container">
                                        <input type="checkbox" class="custom-checkbox" id="contribucionEcono_{{ $contriE->id }}" value="{{ $contriE->id }}" name="contribucionEcono[]"
                                            @if(in_array($contriE->id, old('contribucionEcono', explode(',', $proytImp->crit6 ?? '')))) checked @endif>
                                        <label for="contribucionEcono_{{ $contriE->id }}" class="custom-checkbox-label">
                                            <span>{{ $contriE->descContribucionE }}</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                <span class="text-danger">@error('contribucionEcono') {{$message}} @enderror</span>
            </div>

            <div style="height: 35px"></div>

            <label class="form-label">Justifica brevemente el impacto económico de tu proyecto.</label>
            <div style="height: 20px"></div>
            <div>
                <textarea type="text" id="justificaImp" name="justificaImp" rows="5" oninput="autoResize(this)"
                    placeholder="Explica brevemente">{{ old('justificaImpEco', $proytImp->descImpEco) }}</textarea>
                <span class="text-danger">@error('justificaImp') {{$message}} @enderror</span>
                <br>
            </div>

            <div style="height: 20px"></div>
            <div style="text-align: center">
                <button type="submit" id="submitImpacto" value="3" name="oculto">
                    <img src="../img/resultados.png" width="25px" height="25px" alt="">
                    &nbsp; Obtener el ISE
                </button>
            </div>
        </div>
        <div style="height: 40px"></div>
        </div>
        <div style="height: 30px"></div>
    </div>
    </form>
</body>
</html>