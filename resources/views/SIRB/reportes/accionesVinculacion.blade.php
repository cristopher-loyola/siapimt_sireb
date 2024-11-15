<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Acciones de vinculación</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            header {
                display: flex; /* Utiliza flexbox */
                justify-content: start; /* Alinea los elementos a la izquierda */
                align-items: center; /* Centra los elementos verticalmente */
                margin-bottom: 1.2rem;
            }
            header img {
                display: block; /* Hace que la imagen se muestre como bloque */
                float: left;
                width: 12.5rem; /* Ajusta el ancho de la imagen según tus necesidades */
                height: 10rem;
                margin-top: -1rem; /* Ajusta la posición vertical de la imagen */
                margin-right: 1rem;
            }
            header h1 {
                font-size: 1.5rem;
            }
            header h2, header h3, header h4 {
                font-size: 1rem;
            }
            table {
                width: 80%;
                margin: auto;
                font-size: .7rem;
            }
            table th {
                background-color: #f0f0f0;
            }
            table th, table td {
                padding: .5rem;
                text-align: left;
            }
        </style>
	</head>
    <body>
        <header>
            <img src="{{ public_path('img/Logo_IMT.png') }}" alt="Logo IMT">
            <h1>Instituto Mexicano del Transporte</h1>
            <h2><strong>{{ $userData->Area }}</strong></h2>
            <h2><strong>Acciones de Vinculación</strong></h3>
            <h4><strong>{{ $periodoConsultado }}</strong></h4>
        </header>

        <!-- Reuniones -->
        <table>
            @foreach($reuniones as $reunion)
            <tr>
                <th>Tipo de Reunión</th>
                <th>Dependencia de Vinculación</th>
                <th>Descripción de la Reunión</th>
                <th>Lugar de la Reunión</th>
            </tr>

            <tr>
                <td>{{ $reunion->tipo_reunion }}</td>
                <td>{{ $reunion->D_vinculacion }}</td>
                <td>{{ $reunion->descripcion_R }} <strong>({{$reunion->fecha_reunion}})</strong></td>
                <td>{{ $reunion->lugar_reunion }}</td>
                <br>
            </tr>
            <br><br><br>
            @endforeach
        </table>


        {{-- <!-- Proyectos -->
        <table>
            @foreach($proyectos as $proyecto)
            @php
                    $bimestres = [
                        1 => "Enero-Febrero",
                        1 => "Enero-Febrero",
                        2 => "Marzo-Abril",
                        2 => "Marzo-Abril",
                        3 => "Mayo-Junio",
                        3 => "Mayo-Junio",
                        4 => "Julio-Agosto",
                        4 => "Julio-Agosto",
                        5 => "Septiembre-Octubre",
                        5 => "Septiembre-Octubre",
                        6 => "Noviembre-Diciembre",
                        6 => "Noviembre-Diciembre",
                    ];

                        $bimestreNumerico = array_search($fechabimestre->bimestre, $bimestres);
                    @endphp
            @if(isset($proyecto->aniosBimestres[$fechabimestre->año][$bimestreNumerico]))
            <tr>
                <th>Nombre del Proyecto</th>
                <th>Objetivo</th>
                <th>Fecha de Finalización</th>
                <th>Progreso</th>
            </tr>
            <tr>
                <td><strong>{{ $proyecto->clavea}}{{ $proyecto->clavet}}-{{ $proyecto->claven}}/{{ $proyecto->clavey}}</strong> {{ $proyecto->nomproy }}
                <br>
                <br>
                Responsable: {{ $proyecto->Nombre.' '.$proyecto->Apellido_Materno.' '.$proyecto->Apellido_Paterno}}</td>
                <td>{{ $proyecto->objetivo }}</td>
                <td>{{ $proyecto->fecha_fin }}</td>
                <td>{{ $proyecto->progreso }}%</td>
            </tr>
            <br><br><br>
            @endif
            @endforeach
        </table>

        <table>
            @foreach($prmI as $proyectoA)
            @php
                    $bimestres = [
                        1 => "Enero-Febrero",
                        1 => "Enero-Febrero",
                        2 => "Marzo-Abril",
                        2 => "Marzo-Abril",
                        3 => "Mayo-Junio",
                        3 => "Mayo-Junio",
                        4 => "Julio-Agosto",
                        4 => "Julio-Agosto",
                        5 => "Septiembre-Octubre",
                        5 => "Septiembre-Octubre",
                        6 => "Noviembre-Diciembre",
                        6 => "Noviembre-Diciembre",
                    ];



                        $bimestreNumerico = array_search($fechabimestre->bimestre, $bimestres);
                    @endphp
            @if(isset($proyectoA->aniosBimestres[$fechabimestre->año][$bimestreNumerico]))
            <tr>
                <th>Nombre del Proyecto</th>
                <th>Objetivo</th>
                <th>Fecha de Finalización</th>
                <th>Progreso</th>
            </tr>
            <tr>
                <td><strong>{{ $proyectoA->clavea}}{{ $proyectoA->clavet}} {{ $proyectoA->claven}}/{{ $proyectoA->clavey}}</strong> {{ $proyectoA->nomproy }}
                <br>
                <br>
                Responsable: {{ $proyectoA->Nombre.' '.$proyectoA->Apellido_Materno.' '.$proyectoA->Apellido_Paterno}}</td>
                <td>{{ $proyectoA->objetivo }}</td>
                <td>{{ $proyectoA->fecha_fin }}</td>
                <td>{{ $proyectoA->progreso }}%</td>
            </tr>
            <br><br><br>
            @endif
            @endforeach
        </table> --}}

    </body>
</html>
