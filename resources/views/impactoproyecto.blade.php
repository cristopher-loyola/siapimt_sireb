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
            box-sizing: border-box;
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
        #formulario {
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
            border-color: #3498db; 
        }
        input:focus {
            border-color: #3498db;
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
            font-size: 18px;
            transition: border-color 0.3s; /* Transición suave del borde */
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
            resize: none;
            width: 100%;
            border-color: #aacfe7;
            max-width: 800px; 
            margin: 10px 0;
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
            background-color: #232121; /* Cambia el color de fondo */
            transform: scale(1.1); /* Aumenta el tamaño del botón */
        }
        #nameproy {
            width: 100%;
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
        .form-label2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
            text-align: center;
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
            background-color: #00C04099;
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
            width: 100%;
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
            width: 85%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;  
        }
        #justificaImp{
            width: 725px;
        }
        .proyecto{
            width: 900px;
        }

        /* Botón pequeño en esquina */
.info-btn-corner {
    position: fixed; /* Fijo en pantalla */
    top: 20px; /* Espacio desde arriba */
    right: 20px; /* Espacio desde la derecha */
    background-color: #007bff;
    color: #fff;
    font-size: 13px; /* Más discreto */
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    z-index: 1000; /* Siempre encima del contenido */
    transition: background-color 0.3s, transform 0.2s;
}

.info-btn-corner img {
    width: 16px;
    height: 16px;
    margin-right: 5px;
}

.info-btn-corner:hover {
    background-color: #0056b3;
    transform: scale(1.05); /* Pequeño efecto hover */
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
    </div>
<a href="{{ route('infoproys', $proyt->id) }}" class="info-btn-corner">
    <img src="{{asset('/img/info-chat.png')}}" alt="Información del Proyecto"> Info Proyecto
</a>
    <form action="{{ route('upimpactoproy', $proyt->id) }}" method="POST">
    <div id="cejas">
        <button name="oculto" type="submit" value="1"  class="boton-ceja-carpeta-actual"
        @if($proytImp->crit1 != '' && $proytImp->vcrit1 != '' && $proytImp->crit2 != '' && 
            $proytImp->vcrit2 != '' && $proytImp->crit3 != '' && $proytImp->vcrit3 != '' &&
            $proytImp->descImpSoc != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>   
            Social
        </button>
        <button name="oculto" type="submit" value="2"
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
            <div style="height: 15px"></div>
            <div class="center-container">
                <label class="form-label2">¿El proyecto aborda un problema social descrito en...?</label>
                <div>
                    <select name="problemasoc" id="problemasoc" onchange="cambio(this)">
                        <option value="Selecciona..." disabled selected>Selecciona una opción...</option>
                        @foreach ($problemSoc as $prob)
                            <option value="{{ $prob->id }}"
                                @if(old('problemasoc', $proytImp->crit1) == $prob->id) selected @endif>
                                {{$prob->descProb}}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('problemasoc') {{$message}} @enderror</span>
                </div>
                <br>

                <label class="form-label2">¿Cuál es el nivel de impacto en base a una escala geográfica?</label>
                <div>
                    <select name="escalaImpacto" id="escalaImpacto" onchange="cambio(this)">
                        <option value="Selecciona..." disabled selected>Selecciona una opción...</option>
                        @foreach ($escalaImp as $escala)
                            <option value="{{ $escala->id }}"
                                @if(old('escalaImpacto', $proytImp->crit2) == $escala->id) selected @endif>
                                {{$escala->descEscala}}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('escalaImpacto') {{$message}} @enderror</span>
                </div>

                <div style="height: 15px"></div>

                <label class="form-label">¿Cuál es la contribución social esperada del proyecto en el sector del transporte? 
                    <span title= "Seleccione una o varias opciones"><img src="{{asset('/img/noteimp.png')}}"></span></label>
                <div style="height: 20px"></div>
                <div class="mb-4 col">
                    @if ($contriSoc != '')
                        <table class="table-checkbox">
                            @foreach ($contriSoc as $contrib)
                                <tr class="table-row">
                                    <td>
                                        <div class="custom-checkbox-container">
                                            <input type="checkbox" class="custom-checkbox" id="contribucionSoc_{{$contrib->id}}" 
                                            value="{{$contrib->id}}" name="contribucionSoc[]"
                                                @if(in_array($contrib->id, old('contribucionSoc',explode(',', $proytImp->crit3 ?? '')))) 
                                                checked @endif>
                                            <label for="contribucionSoc_{{$contrib->id}}" class="custom-checkbox-label">
                                                <span>{{ $contrib->descContribucionS }}</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                    <span class="text-danger">@error('contribucionSoc') {{$message}} @enderror</span>
                </div>

                <div style="height: 35px"></div>
                <label class="form-label">Justifica brevemente el impacto social de tu proyecto:</label>
                <div style="height: 20px"></div>
                <div>
                    <textarea type="text" id="justificaImp" name="justificaImp" rows="5" oninput="autoResize(this)"
                        placeholder="Explica brevemente">{{ old('justificaImp', $proytImp->descImpSoc) }}</textarea>
                    <span class="text-danger">@error('justificaImp') {{$message}} @enderror</span>
                    <br>
                </div>
                <div style="height: 10px"></div>
            </div>
        </div>
    </form>
</body>
</html>