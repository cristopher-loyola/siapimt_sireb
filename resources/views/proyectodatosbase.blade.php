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
        }
        textarea:hover {
            border-color: #3498db; /* El color del borde al pasar el mouse */
        }

        textarea:focus {
            border-color: #3498db; /* El color del borde cuando el campo está en enfoque */
        }
        select {
            border: 3px solid transparent; /* Sin borde visible por defecto */
            outline: none; /* Elimina el borde de enfoque por defecto */
            font-size: .9em;
            font-weight: bold;
            transition: border-color 0.3s; /* Transición suave del borde */
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
            resize: none;
            width: 100%;
            /* padding-right: 30px; */
            appearance: none; /* Elimina el estilo predeterminado de la flecha */
            -webkit-appearance: none; /* Para Safari */
            -moz-appearance: none; /* Para Firefox */
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
            background-color: #ffffff;
            border: none;
            border-top: 10px solid #1A2C6E; /* Color más oscuro para la ceja de la carpeta */
            border-radius: 5px 5px 0 0; /* Bordes redondeados en la parte superior */
            font-size: 16px;
            color: #1A2C6E;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            position: relative;
            border-right: 1px solid #1A2C6E;
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
        label{
            text-align: justify;
            font-weight: 700;
            font-size: 1.4em;
        }
        #exito{
            width: 100%;
            background: #1a831ade;
            color: #fff;
            font-weight: bold;
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
            font-weight: bold;
            font-size: 1.2em;
            border-radius: 5px;
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }

    </style>
    <script>
        // function autoResize(textarea) {
        //     const actualizar = document.getElementById('actualizar');
        //     textarea.style.height = 'auto';
        //     textarea.style.height = (textarea.scrollHeight) + 'px';
        //     textarea.style.borderColor  = "#ed2f39";
        //     actualizar.id = 'modificar';
        // }
        // window.addEventListener('load', () => {
        //     const textarea = document.getElementById('nameproy');
        //     textarea.style.height = 'auto';
        //     textarea.style.height = (textarea.scrollHeight) + 'px';
        // });

        // function cambio(){
        //     const selectElement = document.getElementById('respon');
        //     const actualizar = document.getElementById('actualizar');
        //     if (selectElement.value === "") {
        //         selectElement.style.border = "3px solid grey";
        //         selectElement.style.background = '#95959528';
        //     } else {
        //         selectElement.style.border = "3px solid #ed2f39";
        //         selectElement.style.background = '#fff';
        //     }
        //     actualizar.id = 'modificar';
        // };

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
                    <th scope="col">Información del proyecto</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </header>
    <br>
    <div id="cejas">
        <a href="{{route ('proydatos', $proyt->id)}}">
            <button class="boton-ceja-carpeta-actual">
                Información del proyecto
            </button>
        </a>
        <a href="{{route ('proydatos1', $proyt->id)}}">
            <button class="boton-ceja-carpeta-actual">
                Justificaciones
            </button>
        </a>
        <a href="{{route ('proydatos2', $proyt->id)}}">
            <button class="boton-ceja-carpeta">
                Objetivos
            </button>
        </a>
        <a href="{{route ('proydatos3', $proyt->id)}}">
            <button class="boton-ceja-carpeta">
                Resultados
            </button>
        </a>
        <a href="{{route ('proydatos4', $proyt->id)}}">
            <button class="boton-ceja-carpeta">
            Datos generales
            </button>
        </a>
    </div>
    <div style="height: 100px"></div>
    <br>
    <div id="formulario">
        <form action="{{ route('', $proyt->id) }}" method="POST">
            @if (Session::has('success'))
                <div id="exito">{{Session::get('success')}}</div>
                <br>
            @endif
            @if (Session::has('fail'))
                <div id="fallo">{{Session::get('fail')}}</div>
                <br>
            @endif
            @csrf
            <div style="height: 30px"></div>
            <div style="text-align: center">
                <button type="submit" id="actualizar">
                    <img src="../img/save.png" width="25px" height="25px" alt="">
                    &nbsp;
                    Guardar
                </button>
            </div>
        </form>
    </div>
</body>
</html>