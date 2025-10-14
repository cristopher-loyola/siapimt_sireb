<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Contenedor principal que simula la hoja de Word tamaño carta */
        .hojap {
            width: 8.5in; /* Ancho de tamaño carta */
            height: 11in; /* Alto de tamaño carta */
            margin: 20px auto;
            padding: .5in;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        .hoja {
            width: 8.5in; /* Ancho de tamaño carta */
            height: 11in; /* Alto de tamaño carta */
            margin: 20px auto;
            padding: 1in;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        /* Estilos para el área de texto */
        .contenido {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }

        label{
            font-size: 16pt;
            font-weight: bold;
        }

        .rnadl{
            font-size: 14pt;
            font-weight: bold;
        }

        .cont {
            display: flex;
            justify-content: space-between;
        }

        .div1, .div2 {
            display: inline-block;
            width: 45%; /* Ajusta el ancho según necesites */
            padding: 10px;
            margin: 10px;
        }

        /* Estilo para la simulación de márgenes */
        .contenido p {
            margin-bottom: 15px;
        }

        #regresar{
                position: fixed;
                top: 50px;
                left: 20px;
                background: #151515;
                color: #ffffff;
                border-radius: 5px;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                border: 1px solid transparent;
                padding: .4em;
            }
        #regresar:hover{
            background: #272727;
            transform: scale(1.1); /* Aumenta el tamaño del botón */
        }

        #protocolo{
                position: fixed;
                top: 100px;
                left: 20px;
                background: #e9bf16;
                color: #000;
                border-radius: 5px;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                border: 1px solid transparent;
                padding: .4em;
            }
        #protocolo:hover{
            background: #f8cb17;
            transform: scale(1.1); /* Aumenta el tamaño del botón */
        }
        /* === Respeta la alineación de Quill (pantalla y PDF) === */
        .ql-align-left    { text-align: left    !important; }
        .ql-align-center  { text-align: center  !important; }
        .ql-align-right   { text-align: right   !important; }
        .ql-align-justify { text-align: justify !important; }

        /* Indentaciones (opcional) */
        .ql-indent-1 { padding-left: 3em !important; }
        .ql-indent-2 { padding-left: 6em !important; }
        .ql-indent-3 { padding-left: 9em !important; }

        /* RTL (opcional) */
        .ql-direction-rtl { direction: rtl !important; }

        /* Impresión */
        @media print {
            #protocolo {
                display: none;
            }

            #regresar{
                display: none;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .hojap {
                width: 8.5in;
                height: 11in;
                margin: 0;
                padding: 0in;
                box-shadow: none;
                border: 1px solid transparent;
            }

            .hoja {
                width: 8.5in;
                height: 11in;
                margin: 0;
                padding: 1in;
                box-shadow: none;
                border: 1px solid black;
            }

            .contenido {
                font-size: 12pt;
                line-height: 1.5;
                color: #000;
            }

            /* Desactivar el fondo en impresión para evitar consumir tinta */
            body {
                background-color: white;
            }

            /*  Estilo tabla INICIO */
            table {
                width: 100%;
                max-width: 100%;
                overflow-x: auto;
                border-collapse: collapse;
                margin: 20px 0;
                page-break-inside: avoid;
            }
            thead {
                background-color: #003366;
                color: white;
            }
            body {
                margin: 0;
                padding: 0;
            }
            th, td {
            border: 1px solid #000;
            padding: 8px 12px;
            word-wrap: break-word;
            white-space: normal;
            vertical-align: top;
            /* sin text-align global, o si quieres default: */
            text-align: left; /* ✅ opcional */
            }
            th {
                font-weight: bold;
            }
            /* Estilo tabla FIN */
           /* === Respeta la alineación de Quill === */
            .ql-align-left    { text-align: left    !important; }
            .ql-align-center  { text-align: center  !important; }
            .ql-align-right   { text-align: right   !important; }
            .ql-align-justify { text-align: justify !important; }

            /* Indentaciones de Quill (opcional) */
            .ql-indent-1 { padding-left: 3em !important; }
            .ql-indent-2 { padding-left: 6em !important; }
            .ql-indent-3 { padding-left: 9em !important; }

            /* Texto derecha-a-izquierda (opcional) */
            .ql-direction-rtl { direction: rtl !important; }


        }
    </style>
</head>
<body>
    <div>
        <div>
            <a href="{{ route('infoproys', $proyt->id)}}">
                <button type="submit" id="regresar">
                    <img src="{{asset('/img/back.png')}}" width="25px" height="25px" alt="">
                    <img src="{{asset('/img/homeb.png')}}" width="25px" height="25px" alt="">
                </button>
            </a>
        </div>
        <div>
            <form action="{{route('gprotocolo2', $proyt->id)}}" method="GET">
                @csrf
                <button type="submit" id="protocolo">
                    <img src="../img/export.png" width="32em" height="32em"
                    alt="" style="margin-bottom: .1em">
                    Generar datos del Protocolo
                </button>
            </form>
        </div>
    </div>
    <div class="hojap">
        <div class="contenido">
            <img src="/img/header_imt.png" alt="Logo IMT"  width="600" height="65">
            <div style="padding-top: 2in">
            </div>

            <label>{{$areas->nombre_area}}</label>

            <div style="padding-top: 1in">
            </div>

            @if ($proyt->clavet == 'I')
                <label>Protocolo de investigación</label>
            @else
                <label>Propuesta técnico-económica</label>
            @endif

            <div style="padding-top: 1in">
            </div>

            <div class="cont">
                <div class="div1"><p class="rnadl">{{$clave}}</p></div>
                <div class="div2"><p class="rnadl">{{$proyt->nomproy}}</p></div>
            </div>

            <div style="padding-top: 2.8in">
            </div>

            <p style="text-align: right">
                <?php
                    setlocale(LC_TIME, 'es_MX.UTF-8'); // Establecer el idioma a español
                    echo strftime("%d de %m de %Y"); // Muestra la fecha en el formato deseado
                ?>
            </p>        </div>
    </div>
    <div class="hojap">
        <div class="contenido">
            <img src="/img/header_imt.png" alt="Logo IMT"  width="600" height="65">

            <div style="padding-top: 2in">
            </div>

            <label>INSTITUTO MEXICANO DEL TRANSPORTE</label>
            <p>
                Km 12+000, carretera estatal 431 “El Colorado - Galindo <br>
                Parque Tecnológico San Fandila <br>
                Mpio. Pedro Escobedo, Querétaro, México <br>
                CP 76703 <br>
                Teléfonos: +52(442) 2 16 97 77
            </p>

            <div style="padding-top: 2in">
            </div>

            <div class="cont">
                <div class="div1">
                    <p class="rnadl">Aprobó</p>
                    <p>{{$obs->fobsresponsble}}</p>
                    <hr>
                    <p>
                    {{$users->Apellido_Paterno.' '.$users->Apellido_Materno.' '.$users->Nombre}}
                    </p>
                </div>
                <div class="div2">
                    <p class="rnadl">Autorizó</p>
                    <p>{{$obs->fobsmando}}</p>
                    <hr>
                    <p> Coordinador/Jefe de {{$areas->nombre_area}} <br>
                        {{$respon->Apellido_Paterno.' '.$respon->Apellido_Materno.' '.$respon->Nombre}}
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
