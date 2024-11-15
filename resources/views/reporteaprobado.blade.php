<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Autorización Reprogramacion {{$nombreproyecto}}</title>
    <style>
        /* Estilos CSS para el PDF, puedes personalizarlos según tus necesidades */

        header {
            text-align: center;
        }

        header img {
            display: block; /* Hace que la imagen se muestre como bloque */
            float: left;
            width: 9.5rem; /* Ajusta el ancho de la imagen según tus necesidades */
            height: 7rem;
            margin-top: -1rem; /* Ajusta la posición vertical de la imagen */
        }

        header h1 {
            margin: 0;
            padding: 0;
            font-size: 1.4rem; /* Tamaño de fuente del título */
        }

        header p {
            margin: 0;
            padding: 5px 0;
            font-size: .9rem; /* Tamaño de fuente para los párrafos */
        }

        /* Regla para justificar el texto de los elementos <li> y <h3> */
        ol, li, h3 {
            text-align: justify;
        }

        /* Estilos para la numeración de página y la fecha */
        .page-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        label {
            font-size: 1.1em;
            text-align: justify;
        }
        /* .current-page:after {
            content: counter(page);
        } */

        /*Firmas*/
        .container {
            position: relative;
        }

        .signature1 {
            text-align: center;
            position: absolute;
            left: 3%; /* Alinea a la izquierda */
            top: 50%; /* Alinea verticalmente en el centro */
            transform: translateY(-50%); /* Alinea verticalmente en el centro */
            height: 800px;
        }

        .signature2 {
            text-align: center;
            position: absolute;
            right: 3%; /* Alinea a la derecha */
            top: 50%; /* Alinea verticalmente en el centro */
            transform: translateY(-50%); /* Alinea verticalmente en el centro */
            height: 800px;
        }

        .signature1 p, .signature2 p {
            margin: 0;
        }

        /* Línea subrayada */
        .signature2 hr {
            border: 0;
            border-top: 1px solid #000; /* Grosor de la línea y color */
            max-width: 100%; /* Ancho máximo */
            width: auto; /* Ancho automático para adaptarse al contenido */
        }

        
        .signature3 {
            text-align: center;
            position: absolute;
            left: 3%; /* Alinea a la izquierda */
            top: 50%; /* Alinea verticalmente en el centro */
            transform: translateY(-50%); /* Alinea verticalmente en el centro */
            height: 800px;
        }

        .signature4 {
            text-align: center;
            position: absolute;
            right: 3%; /* Alinea a la derecha */
            top: 50%; /* Alinea verticalmente en el centro */
            transform: translateY(-50%), translateX(-70%); /* Alinea verticalmente en el centro */
            height: 800px;
        }

        .signature3 p, .signature4 p {
            margin: 0;
        }

        /* Línea subrayada */
        .signature3 hr {
            border: 0;
            border-top: 1px solid #000; /* Grosor de la línea y color */
            max-width: 100%; /* Ancho máximo */
            width: auto; /* Ancho automático para adaptarse al contenido */
        }

        .obsjust{
            text-align: center !important;
        }

    </style>
</head>

    <!-- SEGMENTO DEL ENCABEZADO  -->
    <header>
        <img src="{{ public_path('img/Logo_IMT.png') }}" alt="Logo IMT">
        <p>&nbsp;</p>
        <h1>INSTITUTO MEXICANO DEL TRANSPORTE</h1>
        <p><strong>AUTORIZACIÓN REPROGRAMACIÓN DE PROYECTO</strong></p>

    </header>
    <!--FIN DEL SEGMENTO DEL ENCABEZADO  -->

    <!-- Contenido del reporte -->
    <body>
        <div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
        <div>
            <label for="">{{$responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno}}</label>
            <br>
            <label for="">Responsable del Proyecto.</label>
            <br>
            <label for="">{{$nombreproyecto}}</label>
            <p>&nbsp;</p>
            <label for="">Analizando lo planteado en la justificación</label>
            <br>
            <label for="" id="obsjust">{{$obs->obs}}</label>
            <p>&nbsp;</p>
            <label for="">
                Se determina viable la Reprogramación del Proyecto
                {{$nombreproyecto}},
                por lo que puede proceder con los cambios que considere pertinentes en el Sistema de Administración de Proyectos (SIAPIMT), considerando que se deben especificar las pausas en el mismo; es decir, que la duración neta no debe variar, aunque se modifique la fecha de fin, para evitar cambios en los porcentajes ya reportados.
            </label>
            <p>&nbsp;</p>
            <label for="">Sin más por el momento,</label>
            <p>&nbsp;</p>
            <label for="">Firma electrónica:</label>
            <br>
            <label for="">{{$obs->fobsmando}}</label>
            <br>
            <label for="">{{$area->nombre_area}}</label>
            <p>&nbsp;</p>
        </div>
    </body>

</html>
