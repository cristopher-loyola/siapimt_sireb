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
                text-align: center;
                margin-bottom: 1.2rem;
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
                font-size: .9rem;
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
            <h1>Instituto Mexicano del Transporte</h1>
            <h2><strong>{{ $userData->Area }}</strong></h2>
            <h3><strong>Acciones de Vinculación</strong></h3>
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

        <!-- Proyectos -->
        <table>
            @foreach($proyectos as $proyecto)
            <tr>
                <th>Nombre del Proyecto</th>
                <th>Objetivo</th>
                <th>Fecha de Finalización</th>
                <th>Progreso</th>
            </tr>

            <tr>
                <td><strong>{{ $proyecto->clavea}}{{ $proyecto->clavet}} {{ $proyecto->claven}}/{{ $proyecto->clavey}}</strong> {{ $proyecto->nomproy }} </td>
                <td>{{ $proyecto->objetivo }}</td>
                <td>{{ $proyecto->fecha_fin }}</td>
                <td>{{ $proyecto->progreso }}%</td>
            </tr>
            <br><br><br>
            @endforeach
        </table>

    </body>
</html>
