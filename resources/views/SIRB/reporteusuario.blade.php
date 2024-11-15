<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte bimestral</title>
    <style>
        /* Estilos CSS para el PDF, puedes personalizarlos según tus necesidades */

        header {
            text-align: center;
        }

        header img {
            display: block; /* Hace que la imagen se muestre como bloque */
            float: left;
            width: 12.5rem; /* Ajusta el ancho de la imagen según tus necesidades */
            height: 10rem;
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

        .current-page:after {
            content: counter(page);
        }

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


    </style>
</head>
    <!-- SEGMENTO DEL ENCABEZADO  -->
    <header>
        <img src="{{ public_path('img/Logo_IMT.png') }}" alt="Logo IMT">
        <h1>INSTITUTO MEXICANO DEL TRANSPORTE</h1>
        <p><strong> {{ $userData->Area }}</strong></p>
        <p><strong>INFORME DE ACTIVIDADES CORRESPONDIENTE AL PERIODO</strong></p>
        <p><strong>{{ $periodoConsultado }}</strong></p>
        <p><strong>NOMBRE: </strong> {{ $userData->Nombre }} {{ $userData->Apellido_Paterno }} {{ $userData->Apellido_Materno }}</p>
        <p><strong>PLAZA: </strong>{{ $userData->Plaza }}</p>

    </header>
    <!--FIN DEL SEGMENTO DEL ENCABEZADO  -->

    <!-- Contenido del reporte -->
    <body>
    <div>
        <ol>
<!-- Antes -->
            <li>
                <h3>PROYECTOS INICIADOS O EN PROCESO EN EL PERIODO</h3>
                <ol>
                    @if($proyectos->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($proyectos as $proyecto)
                            <li>
                                <p>
                                    <strong>Nombre del proyecto:</strong> {{ $proyecto->nomproy }}
                                    <br>
                                    <strong>Porcentaje:</strong> {{ $proyecto->progreso }}
                                    <br>
                                    <strong>Fecha teminación:</strong> {{ $proyecto->fecha_fin }}
                                    <br>
                                </p>
                            </li>
                            <br>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>SERVICIOS INICIADOS O EN PROCESO EN EL PERIODO</h3>
                <ol>
                    @if ($serviciotecnologico->isEmpty() && $serviciotecnologicoRelacionadas->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($serviciotecnologico as $servicio)
                        @php
                        $fechainicio = $servicio->fechainicio;
                        $fechafin = $servicio->fechafin;
                        $mesInicio = date("n", strtotime($fechainicio));
                        $mesFin = date("n", strtotime($fechafin));

                        $bimestres = [
                        1 => "Enero-Febrero",
                        2 => "Enero-Febrero",
                        3 => "Marzo-Abril",
                        4 => "Marzo-Abril",
                        5 => "Mayo-Junio",
                        6 => "Mayo-Junio",
                        7 => "Julio-Agosto",
                        8 => "Julio-Agosto",
                        9 => "Septiembre-Octubre",
                        10 => "Septiembre-Octubre",
                        11 => "Noviembre-Diciembre",
                        12 => "Noviembre-Diciembre",
                        ];

                        $bimestreInicio = $bimestres[$mesInicio] ?? '';
                        $bimestreFin = $bimestres[$mesFin] ?? '';

                        $bimestresCubiertos = [];

                        $fechaInicio = strtotime($fechainicio);
                        $fechaFin = strtotime($fechafin);

                        while ($fechaInicio <= $fechaFin) {
                            $mesActual = date("n", $fechaInicio);
                            $bimestreActual = $bimestres[$mesActual] ?? '';

                            if (!in_array($bimestreActual, $bimestresCubiertos)) {
                                $bimestresCubiertos[] = $bimestreActual;
                            }

                            $fechaInicio = strtotime("+1 month", $fechaInicio);
                        }



                        $currentBimester = $fechabimestre2->bimestre;
                        $previousBimester = "";

                        switch ($currentBimester) {
                        case "Enero-Febrero":
                            $previousBimester = "Noviembre-Diciembre";
                            break;
                        case "Marzo-Abril":
                            $previousBimester = "Enero-Febrero";
                            break;
                        case "Mayo-Junio":
                            $previousBimester = "Marzo-Abril";
                            break;
                        case "Julio-Agosto":
                            $previousBimester = "Mayo-Junio";
                            break;
                        case "Septiembre-Octubre":
                            $previousBimester = "Julio-Agosto";
                            break;
                        case "Noviembre-Diciembre":
                            $previousBimester = "Septiembre-Octubre";
                            break;
                            }


                    @endphp

                        @if (in_array($currentBimester, $bimestresCubiertos))
                            <li>
                                <p>
                                    <strong>Nombre del servicio:</strong> {{ $servicio->nombreservicio }}
                                    <br>
                                    <strong>No. del registro:</strong> {{ $servicio->numeroregistro }}
                                    <br>
                                    <strong>Participación en el servicio como:</strong> {{ $servicio->participacion }}
                                    <br>
                                    <strong>Descripción de lo realizado:</strong> {{ $servicio->descripcion }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $servicio->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $servicio->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif

                                    <br>
                                    <strong>Porcentaje:</strong>
                                    @if (!empty($servicio->porcentaje))
                                        {{ $servicio->porcentaje }}%
                                    @endif
                                </p>
                            </li>
                        @endif
                        @endforeach

                        @foreach ($serviciotecnologicoRelacionadas as $servicio)
                        @php
                        $fechainicio = $servicio->fechainicio;
                        $fechafin = $servicio->fechafin;
                        $mesInicio = date("n", strtotime($fechainicio));
                        $mesFin = date("n", strtotime($fechafin));

                        $bimestres = [
                        1 => "Enero-Febrero",
                        2 => "Enero-Febrero",
                        3 => "Marzo-Abril",
                        4 => "Marzo-Abril",
                        5 => "Mayo-Junio",
                        6 => "Mayo-Junio",
                        7 => "Julio-Agosto",
                        8 => "Julio-Agosto",
                        9 => "Septiembre-Octubre",
                        10 => "Septiembre-Octubre",
                        11 => "Noviembre-Diciembre",
                        12 => "Noviembre-Diciembre",
                        ];

                        $bimestreInicio = $bimestres[$mesInicio] ?? '';
                        $bimestreFin = $bimestres[$mesFin] ?? '';

                        $bimestresCubiertos = [];

                        $fechaInicio = strtotime($fechainicio);
                        $fechaFin = strtotime($fechafin);

                        while ($fechaInicio <= $fechaFin) {
                            $mesActual = date("n", $fechaInicio);
                            $bimestreActual = $bimestres[$mesActual] ?? '';

                            if (!in_array($bimestreActual, $bimestresCubiertos)) {
                                $bimestresCubiertos[] = $bimestreActual;
                            }

                            $fechaInicio = strtotime("+1 month", $fechaInicio);
                        }



                        $currentBimester = $fechabimestre2->bimestre;
                        $previousBimester = "";

                        switch ($currentBimester) {
                        case "Enero-Febrero":
                            $previousBimester = "Noviembre-Diciembre";
                            break;
                        case "Marzo-Abril":
                            $previousBimester = "Enero-Febrero";
                            break;
                        case "Mayo-Junio":
                            $previousBimester = "Marzo-Abril";
                            break;
                        case "Julio-Agosto":
                            $previousBimester = "Mayo-Junio";
                            break;
                        case "Septiembre-Octubre":
                            $previousBimester = "Julio-Agosto";
                            break;
                        case "Noviembre-Diciembre":
                            $previousBimester = "Septiembre-Octubre";
                            break;
                            }


                    @endphp

                    @if (in_array($currentBimester, $bimestresCubiertos))
                            <li>
                                <strong>Nombre del servicio:</strong> {{ $servicio->servicio }}
                                <br>
                                <strong>No. del registro:</strong> {{ $servicio->numeroregistro }}
                                <br>
                                <strong>Participación en el servicio como:</strong> Integrante
                                <br>
                                <strong>Descripción de lo realizado:</strong> {{ $servicio->descripcion }}
                                <br>
                                @php
                                    $participantes = explode(',', $servicio->participantes);
                                @endphp
                                <strong>Participantes:</strong> {{ $servicio->encargado }}
                                @if (!empty($participantes[0]))
                                    ,
                                    @foreach ($participantes as $participanteId)
                                        @php
                                            $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                        @endphp
                                        @if ($usuario)
                                            {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                            @if (!$loop->last), @endif
                                        @endif
                                    @endforeach
                                @endif

                                <br>
                                <strong>Porcentaje:</strong>
                                @if (!empty($servicio->porcentaje))
                                    {{ $servicio->porcentaje }}%
                                @endif
                            </li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </li>
            <li>
                <h3>PARTICIPACIONES EN REUNIONES DE TRABAJO CON ENTIDADES EXTERNAS AL IMT</h3>
                <ol>
                    @if ($reuniones->isEmpty() && $reunionesRelacionadas->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($reuniones as $reunion)
                            <li>
                                <p>
                                    <strong>Tipo de reunión:</strong> {{ $reunion->tipo_reunion }}
                                    <br>
                                    <strong>Dependencia de vinculación:</strong> {{ $reunion->D_vinculacion }}
                                    <br>
                                    <strong>Descripción de la reunión:</strong> {{ $reunion->descripcion_R }}
                                    <br>
                                    <strong>Lugar de la reunión:</strong> {{ $reunion->lugar_reunion }}
                                    <br>
                                    <strong>Fecha de la reunión:</strong> {{ $reunion->fecha_reunion }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $reunion->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $reunion->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach

                        @foreach ($reunionesRelacionadas as $reunion)
                            <li>
                                <p>
                                    <strong>Tipo de reunión:</strong> {{ $reunion->tipo_reunion }}
                                    <br>
                                    <strong>Dependencia de vinculación:</strong> {{ $reunion->D_vinculacion }}
                                    <br>
                                    <strong>Descripción de la reunión:</strong> {{ $reunion->descripcion_R }}
                                    <br>
                                    <strong>Lugar de la reunión:</strong> {{ $reunion->lugar_reunion }}
                                    <br>
                                    <strong>Fecha de la reunión:</strong> {{ $reunion->fecha_reunion }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $reunion->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $reunion->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>COMITÉS</h3>
                <ol>
                    @if ($comites->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($comites as $comite)
                        <li>
                            <p>
                                <strong>Nombre del comité:</strong> {{ $comite->nombre_comite }}
                                <br>
                                <strong>Cargo en el comité:</strong> {{ $comite->cargo_comite }}
                                <br>
                                <strong>Actividades realizadas:</strong> {{ $comite->A_desarrolladas }}
                                <br>
                                <strong>Fecha:</strong> {{ $comite->fechas }}
                                <br>
                                    @php
                                        $participantes = explode(',', $comite->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $comite->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                            </p>
                        </li>
                        @endforeach

                        @foreach ($comitesRelacionadas as $comite)
                        <li>
                            <p>
                                <strong>Nombre del comité:</strong> {{ $comite->nombre_comite }}
                                <br>
                                <strong>Actividades realizadas:</strong> {{ $comite->A_desarrolladas }}
                                <br>
                                <strong>Fecha:</strong> {{ $comite->fechas }}
                                <br>
                                    @php
                                        $participantes = explode(',', $comite->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $comite->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif

                                </p>
                        </li>
                        @endforeach
                    @endif
                </ol>
            </li>
            <li>
                <h3>SOLICITUDES DE APOYO O DE INFORMACIÓN ATENDIDAS</h3>
                <ol>
                    @if ($solicitudes->isEmpty() && $solicitudesRelacionadas->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($solicitudes as $solicitud)
                            <li>
                                <p>
                                    <strong>Tipo de solicitud:</strong> {{ $solicitud->tipo_solicitud }}
                                    <br>
                                    <strong>Nombre de la persona atendida:</strong> {{ $solicitud->nombre_persona }}
                                    <br>
                                    <strong>Cargo actual:</strong> {{ $solicitud->cargo_actual }}
                                    <br>
                                    <strong>Dependencia a la que pertenece:</strong> {{ $solicitud->D_perteneciente }}
                                    <br>
                                    <strong>Descripción de la solicitud atendida:</strong> {{ $solicitud->descripcion }}
                                    <br>
                                    <strong>Tiempo dedicado:</strong> {{ $solicitud->tiempo_dedicado }}
                                    <br>
                                    <strong>Producto final:</strong> {{ $solicitud->producto_final }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $solicitud->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $reunion->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach

                        @foreach ($solicitudesRelacionadas as $solicitud)
                            <li>
                                <p>
                                    <strong>Tipo de solicitud:</strong> {{ $solicitud->tipo_solicitud }}
                                    <br>
                                    <strong>Nombre de la persona atendida:</strong> {{ $solicitud->nombre_persona }}
                                    <br>
                                    <strong>Cargo actual:</strong> {{ $solicitud->cargo_actual }}
                                    <br>
                                    <strong>Dependencia a la que pertenece:</strong> {{ $solicitud->D_perteneciente }}
                                    <br>
                                    <strong>Descripción de la solicitud atendida:</strong> {{ $solicitud->descripcion }}
                                    <br>
                                    <strong>Tiempo dedicado:</strong> {{ $solicitud->tiempo_dedicado }}
                                    <br>
                                    <strong>Producto final:</strong> {{ $solicitud->producto_final }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $solicitud->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $solicitud->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>REVISTAS PUBLICADAS</h3>
                <ol>
                    @if ($revistas->isEmpty() && $revistaRelacionados->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($revistas as $revista)
                        <li>
                            <p>
                                <strong>Titulo de la revista:</strong> {{ $revista->titulo }}
                                <br>
                                <strong>Tipo de articulo:</strong> {{ $revista->tipo_articulo }}
                                <br>
                                <strong>Nombre de la revista:</strong> {{ $revista->nombre_revista }}
                                <br>
                                <strong>Número de la revista:</strong> {{ $revista->numero_revista }}
                                <br>
                                <strong>Editorial:</strong> {{ $revista->editorial }}
                                <br>
                                <strong>Fecha de publicación:</strong> {{ $revista->fecha }}
                                <br>
                                @php
                                        $participantes = explode(',', $revista->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $revista->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                            </p>
                        </li>
                        @endforeach

                        @foreach ($revistaRelacionados as $revista)
                            <li>
                                <p>
                                    <strong>Titulo de la revista:</strong> {{ $revista->titulo }}
                                    <br>
                                    <strong>Tipo de articulo:</strong> {{ $revista->tipo_articulo }}
                                    <br>
                                    <strong>Nombre de la revista:</strong> {{ $revista->nombre_revista }}
                                    <br>
                                    <strong>Número de la revista:</strong> {{ $revista->numero_revista }}
                                    <br>
                                    <strong>Editorial:</strong> {{ $revista->editorial }}
                                    <br>
                                    <strong>Fecha de publicación:</strong> {{ $revista->fecha }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $revista->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $revista->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>MEMORIAS PUBLICADAS</h3>
                <ol>
                    @if ($memorias->isEmpty() && $memoriaRelacionados->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($memorias as $memoria)
                            <li>
                                <p>
                                    <strong>Titulo:</strong> {{ $memoria->titulo }}
                                    <br>
                                    <strong>Semniario:</strong> {{ $memoria->nombre_seminario }}
                                    <br>
                                    <strong>Actividad:</strong> {{ $memoria->tipo_memoria }}
                                    <br>
                                    <strong>Organizador:</strong> {{ $memoria->organizador }}
                                    <br>
                                    <strong>Nombre de la persona:</strong> {{ $memoria->nombre_persona }}
                                    <br>
                                    <strong>Fecha de publicación:</strong> {{ $memoria->fecha }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $memoria->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $memoria->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach

                        @foreach ($memoriaRelacionados as $memoria)
                            <li>
                                <p>
                                    <strong>Titulo:</strong> {{ $memoria->titulo }}
                                    <br>
                                    <strong>Semniario:</strong> {{ $memoria->nombre_seminario }}
                                    <br>
                                    <strong>Actividad:</strong> {{ $memoria->tipo_memoria }}
                                    <br>
                                    <strong>Organizador:</strong> {{ $memoria->organizador }}
                                    <br>
                                    <strong>Nombre de la persona:</strong> {{ $memoria->nombre_persona }}
                                    <br>
                                    <strong>Fecha de publicación:</strong> {{ $memoria->fecha }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $memoria->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $memoria->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>PONENCIAS EN CONFERENCIAS REALIZADAS</h3>
                <ol>
                    @if ($ponenciasconferencias->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($ponenciasconferencias as $ponenconf)
                            <li>
                                <p>
                                    <strong>Nombre del evento:</strong> {{ $ponenconf->nombre_evento }}
                                    <br>
                                    <strong>Nombre del participante:</strong> {{ $ponenconf->nombre_persona }}
                                    <br>
                                    <strong>Tipo de evento:</strong> {{ $ponenconf->tipo_PC }}
                                    <br>
                                    <strong>Fecha de participación:</strong> {{ $ponenconf->fecha_part_ponente }}
                                    <br>
                                    <strong>Entidad organizadora:</strong> {{ $ponenconf->entidad_O }}
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>DOCENCIAS REALIZADAS</h3>
                <ol>
                    @if ($docencias->isEmpty())
                        <li>No aplica en este periodo</li>
                    @else
                        @foreach ($docencias as $docencia)
                            <li>
                                <p>
                                    <strong>Curso impartido:</strong> {{ $docencia->titulo_curso }}
                                    <br>
                                    <strong>Institución donde se impartio:</strong> {{ $docencia->institucion_impartio }}
                                    <br>
                                    <strong>Nombre del docente:</strong> {{ $docencia->nombre_persona }}
                                    <br>
                                    <strong>Duración del curso:</strong> {{ $docencia->duracion_curso }}
                                    <br>
                                    <strong>Fecha de finalización:</strong> {{ $docencia->fecha_fin }}
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>LIBROS PUBLICADOS</h3>
                <ol>
                    @if ($libros->isEmpty() && $librosRelacionados->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($libros as $libro)
                        <li>
                            <p>
                                <strong>Año de publicación:</strong> {{ $libro->año }}
                                <br>
                                <strong>Titulo:</strong> {{ $libro->titulo }}
                                <br>
                                <strong>Editorial:</strong> {{ $libro->editorial }}
                                <br>
                                <strong>Autor:</strong> {{ $libro->nombre_persona }}
                                <br>
                                <strong>ISBN:</strong> {{ $libro->isbn }}
                                <br>
                                @php
                                        $participantes = explode(',', $libro->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $libro->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                            </p>
                        </li>
                        @endforeach

                        @foreach ($librosRelacionados as $libro)
                            <li>
                                <p>
                                    <strong>Año de publicación:</strong> {{ $libro->año }}
                                    <br>
                                    <strong>Titulo:</strong> {{ $libro->titulo }}
                                    <br>
                                    <strong>Editorial:</strong> {{ $libro->editorial }}
                                    <br>
                                    <strong>Autor:</strong> {{ $libro->nombre_persona }}
                                    <br>
                                    <strong>ISBN:</strong> {{ $libro->isbn }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $libro->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $libro->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>CURSOS DE CAPACITACIÓN APOYADOS POR EL IMT</h3>
                <ol>
                    @if ($cursosR->isEmpty() && $cursosRelacionados->isEmpty())
                    <p>No aplica en este periodo</p>
                    @else
                        @foreach ($cursosR as $curso)
                            <li>
                                <p>
                                    <strong>Nombre del curso:</strong> {{ $curso->nombre_curso }}
                                    <br>
                                    <strong>Fecha de inicio:</strong> {{ $curso->fecha_inicio }}
                                    <br>
                                    <strong>Fecha de terminación:</strong> {{ $curso->fecha_fin }}
                                    <br>
                                    <strong>Duración:</strong> {{ $curso->duracion_curso }}
                                    <br>
                                    <strong>Institución organizadora:</strong> {{ $curso->I_organizadora }}
                                    <br>
                                    <strong>Lugar:</strong> {{ $curso->lugar }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $libro->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $libro->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach

                        @foreach ($cursosRelacionados as $curso)
                            <li>
                                <p>
                                    <strong>Nombre del curso:</strong> {{ $curso->nombre_curso }}
                                    <br>
                                    <strong>Fecha de inicio:</strong> {{ $curso->fecha_inicio }}
                                    <br>
                                    <strong>Fecha de terminación:</strong> {{ $curso->fecha_fin }}
                                    <br>
                                    <strong>Duración:</strong> {{ $curso->duracion_curso }}
                                    <br>
                                    <strong>Institución organizadora:</strong> {{ $curso->I_organizadora }}
                                    <br>
                                    <strong>Lugar: </strong>{{ $curso->lugar }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $libro->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $libro->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </li>

            <li>
                <h3>OBTENCIÓN DE POSTGRADOS</h3>
                <ol>
                    @if ($postgrados->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($postgrados as $postgrado)
                        @php
                        $fechainicio = $postgrado->fecha_inicio;
                        $fechafin = $postgrado->fechaT_titulacion;
                        $mesInicio = date("n", strtotime($fechainicio));
                        $mesFin = date("n", strtotime($fechafin));

                        $bimestres = [
                        1 => "Enero-Febrero",
                        2 => "Enero-Febrero",
                        3 => "Marzo-Abril",
                        4 => "Marzo-Abril",
                        5 => "Mayo-Junio",
                        6 => "Mayo-Junio",
                        7 => "Julio-Agosto",
                        8 => "Julio-Agosto",
                        9 => "Septiembre-Octubre",
                        10 => "Septiembre-Octubre",
                        11 => "Noviembre-Diciembre",
                        12 => "Noviembre-Diciembre",
                        ];

                        $bimestreInicio = $bimestres[$mesInicio] ?? '';
                        $bimestreFin = $bimestres[$mesFin] ?? '';

                        $bimestresCubiertos = [];

                        $fechaInicio = strtotime($fechainicio);
                        $fechaFin = strtotime($fechafin);

                        while ($fechaInicio <= $fechaFin) {
                            $mesActual = date("n", $fechaInicio);
                            $bimestreActual = $bimestres[$mesActual] ?? '';

                            if (!in_array($bimestreActual, $bimestresCubiertos)) {
                                $bimestresCubiertos[] = $bimestreActual;
                            }

                            $fechaInicio = strtotime("+1 month", $fechaInicio);
                        }



                        $currentBimester = $fechabimestre2->bimestre;
                        $previousBimester = "";

                        switch ($currentBimester) {
                        case "Enero-Febrero":
                            $previousBimester = "Noviembre-Diciembre";
                            break;
                        case "Marzo-Abril":
                            $previousBimester = "Enero-Febrero";
                            break;
                        case "Mayo-Junio":
                            $previousBimester = "Marzo-Abril";
                            break;
                        case "Julio-Agosto":
                            $previousBimester = "Mayo-Junio";
                            break;
                        case "Septiembre-Octubre":
                            $previousBimester = "Julio-Agosto";
                            break;
                        case "Noviembre-Diciembre":
                            $previousBimester = "Septiembre-Octubre";
                            break;
                            }


                    @endphp

                    @if (in_array($currentBimester, $bimestresCubiertos))
                            <li>
                                <p>
                                    <strong>Realización de estudios de:</strong> {{ $postgrado->grado }}
                                    <br>
                                    <strong>Fase:</strong> {{ $postgrado->estado }}
                                    <br>
                                    <strong>Institución:</strong> {{ $postgrado->institucion }}
                                    <br>
                                    <strong>Actividades desarrolladas:</strong> {{ $postgrado->A_desarrolladas }}
                                    <br>
                                    <strong>Título de la tesis:</strong> {{ $postgrado->titulo_tesis }}
                                    <br>
                                    <strong>Fecha de inicio:</strong> {{ $postgrado->fecha_inicio }}
                                    <br>
                                    <strong>Fecha de titulación:</strong> {{ $postgrado->fechaT_titulacion }}
                                </p>
                            </li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </li>
            <li>
                <h3>TESIS EN LAS QUE EL USUARIO HA PARTICIPADO</h3>
                <ol>
                    @if ($tesis->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($tesis as $tesi)
                        @php
                        $fechainicio = $tesi->fecha_inicio;
                        $fechafin = $tesi->fechaT_titulacion;
                        $mesInicio = date("n", strtotime($fechainicio));
                        $mesFin = date("n", strtotime($fechafin));

                        $bimestres = [
                        1 => "Enero-Febrero",
                        2 => "Enero-Febrero",
                        3 => "Marzo-Abril",
                        4 => "Marzo-Abril",
                        5 => "Mayo-Junio",
                        6 => "Mayo-Junio",
                        7 => "Julio-Agosto",
                        8 => "Julio-Agosto",
                        9 => "Septiembre-Octubre",
                        10 => "Septiembre-Octubre",
                        11 => "Noviembre-Diciembre",
                        12 => "Noviembre-Diciembre",
                        ];

                        $bimestreInicio = $bimestres[$mesInicio] ?? '';
                        $bimestreFin = $bimestres[$mesFin] ?? '';

                        $bimestresCubiertos = [];

                        $fechaInicio = strtotime($fechainicio);
                        $fechaFin = strtotime($fechafin);

                        while ($fechaInicio <= $fechaFin) {
                            $mesActual = date("n", $fechaInicio);
                            $bimestreActual = $bimestres[$mesActual] ?? '';

                            if (!in_array($bimestreActual, $bimestresCubiertos)) {
                                $bimestresCubiertos[] = $bimestreActual;
                            }

                            $fechaInicio = strtotime("+1 month", $fechaInicio);
                        }



                        $currentBimester = $fechabimestre2->bimestre;
                        $previousBimester = "";

                        switch ($currentBimester) {
                        case "Enero-Febrero":
                            $previousBimester = "Noviembre-Diciembre";
                            break;
                        case "Marzo-Abril":
                            $previousBimester = "Enero-Febrero";
                            break;
                        case "Mayo-Junio":
                            $previousBimester = "Marzo-Abril";
                            break;
                        case "Julio-Agosto":
                            $previousBimester = "Mayo-Junio";
                            break;
                        case "Septiembre-Octubre":
                            $previousBimester = "Julio-Agosto";
                            break;
                        case "Noviembre-Diciembre":
                            $previousBimester = "Septiembre-Octubre";
                            break;
                            }
                    @endphp

                    @if (in_array($currentBimester, $bimestresCubiertos))
                            <li>
                                <p>
                                    <strong>Se participa como:</strong> {{ $tesi->participacion }}
                                    <br>
                                    <strong>Título de la tesis dirigida o asesorada:</strong> {{ $tesi->titulo_tesis }}
                                    <br>
                                    <strong>Nombre del alumno que se dirige o asesora:</strong> {{ $tesi->estudiante }}
                                    <br>
                                    <strong> Nombre completo de la especialidad:</strong> {{ $tesi->nombre_especialidad }}
                                    <br>
                                    <strong>Facultad a la que pertenece:</strong> {{ $tesi->facultad }}
                                    <br>
                                    <strong>Nombre de la universidad o instituto de educación superior:</strong> {{ $tesi->institucion }}
                                    <br>
                                    <strong> Fase de la tesis:</strong> {{ $tesi->fase_tesis }}
                                    <br>
                                    <strong>Fecha de inicio de la tesis:</strong> {{ $tesi->fecha_inicio }}
                                    <br>
                                    <strong>Fase de titulación:</strong> {{ $tesi->fechaT_titulacion }}
                                </p>
                            </li>
                        @endif
                        @endforeach
                    @endif
                </ol>
            </li>
            <div style="page-break-before: always;"></div>
            <li>
                <h3>OTRAS ACTIVIDADES</h3>
                <ol>
                    @if ($otraactivida->isEmpty())
                        <p>No aplica en este periodo</p>
                    @else
                        @foreach ($otraactivida as $actividad)
                            <li>
                                <p>
                                    <strong>Nombre de la actividad:</strong> {{ $actividad->nombre_actividad }}
                                    <br>
                                    <strong>Descripción de lo realizado:</strong> {{ $actividad->descripcion }}
                                    <br>
                                    <strong>Fecha:</strong> {{ $actividad->fecha }}
                                    <br>
                                    @php
                                        $participantes = explode(',', $actividad->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $actividad->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </li>
                        @endforeach

                        @foreach ($otraactividaRelacionados as $actividad)
                        <li>
                            <p>
                                <strong>Nombre de la actividad:</strong> {{ $actividad->nombre_actividad }}
                                <br>
                                <strong>Descripción de lo realizado:</strong> {{ $actividad->descripcion }}
                                <br>
                                <strong>Fecha:</strong> {{ $actividad->fecha }}
                                <br>
                                @php
                                        $participantes = explode(',', $actividad->participantes);
                                    @endphp
                                    <strong>Participantes:</strong> {{ $actividad->encargado }}
                                    @if (!empty($participantes[0]))
                                        ,
                                        @foreach ($participantes as $participanteId)
                                            @php
                                                $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                            @endphp
                                            @if ($usuario)
                                                {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                                @if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endif
                            </p>
                        </li>
                        @endforeach
                    @endif
                </ol>
            </li>
        </ol>

        <div class="container">
            <br><br><br><br><br><br><br><br><br>
            <div class="signature1"> <!-- signature1 a la izquierda -->
                <br><br><br><br>
                <p>________________________</p>
                <p>{{ $userData->Nombre }} {{ $userData->Apellido_Paterno }} {{ $userData->Apellido_Materno }}</p>
                <p>{{ $userData->Plaza }}</p>
            </div>
            <div class="signature2"> <!-- signature2 a la derecha -->
                <p>Aprobó</p><br><br><br>
                @if ($fcoordinador)
                    <p>_____________________________</p>
                    <p>{{ $fcoordinador->NombreCoordinador }} {{ $fcoordinador->ApellidoPaternoCoordinador }} {{ $fcoordinador->ApellidoMaternoCoordinador }} coordinador de</p>
                    <p> {{ $fcoordinador->Area }}</p>
                @else
                    <p>Coordinador no encontrado</p>
                @endif
            </div>
        </div>
    </div>



        <!-- Inserta la fecha en el pie de página -->
        <div class="page-number">
            <span style="float: right;">Fecha: <?php echo date('Y-m-d'); ?></span>
        </div>

    </body>

</html>
