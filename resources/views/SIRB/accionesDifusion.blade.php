<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Acciones de difusión</title>
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
            <h2><strong>Reporte de actividades de difusión del quehacer de la {{ $userData->Area }}</strong></h2>
            <h4><strong>{{ $periodoConsultado }}</strong></h4>
        </header>

        {{-- <table>
            <th>Conferencias en seminarios y congresos</th>
            <tr>
                <th>Nombre del investigador</th>
                <th>Arbitraje</th>
                <th>Conteo</th>
            </tr>
            @foreach($ponenciasconferencias as $conferencia)
                <tr>
                    <td>{{ $conferencia->encargado }}</td>
                    @foreach($countPC as $count)
                        <td>{{ $count->tipo_participacion }}</td>
                        <td>{{ $count->count }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        <br>

        <table>
            <th>Articulos publicados en revistas</th>
            <tr>
                <th>Nombre del investigador</th>
                <th>Arbitraje</th>
                <th>Conteo</th>
            </tr>
            @foreach($revistas as $revista)
                <tr>
                    <td>{{ $revista->encargado }}</td>
                    @foreach($countRV as $count)
                        <td>{{ $count->tipo_revista }}</td>
                        <td>{{ $count->count }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        <br>

        <table>
            <tr><th>Ponencias y conferencias</th></tr>
            <tr>
                <th>Nombre del Investigador</th>
                <th>Tipo de Participación</th>
            </tr>
            @foreach($ponenciasconferencias as $conferencia)
            <tr>
                <td>{{ $conferencia->encargado }}</td>
                <td>{{ $conferencia->tipo_participacion }}</td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr><th>Revistas</th></tr>
            <tr>
                <th>Nombre del Investigador</th>
                <th>Tipo de Participación</th>
            </tr>
            @foreach($revistas as $revista)
            <tr>
                <td>{{ $revista->encargado }}</td>
                <td>{{ $revista->tipo_revista }}</td>
            </tr>
            @endforeach
        </table>

        <table>

            <tr><th>Memorias</th></tr>
            <tr>
                <th>Nombre del Investigador</th>
                <th>Tipo de Participación</th>
            </tr>
            @foreach($memorias as $memorias)
            <tr>
                <td>{{ $memorias->encargado }}</td>
                <td>{{ $memorias->tipo_memoria }}</td>
            </tr>
            @endforeach
        </table> --}}


        <table>
            <tr>
                <th colspan="2">Articulos publicados en revistas</th>
            </tr>
            @foreach($revistas as $revista)
            <tr>
                <td>
                @php
                    $participantes = explode(',', $revista->participantes);
                @endphp
                <strong> {{ $revista->encargado }} </strong>
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
                @endif</td>
                <td>Artículo publicado en revista {{ $revista->tipo_revista }}: {{$revista->titulo}}. NO.{{$revista->numero_revista}}. {{$revista->ciudad_pais}}. {{$revista->fecha}}.</td>
            </tr>
            @endforeach
        </table>
        <br>

        <table>
            <tr>
                <th colspan="2">Articulos publicados en memorias</th>
            </tr>
            @foreach($memorias as $memoria)
            <tr>
                <td>
                @php
                    $participantes = explode(',', $memoria->participantes);
                @endphp
                <strong>{{ $memoria->encargado }}</strong>
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
                @endif</td>
                <td>Artículo publicado en memoria {{ $memoria->tipo_memoria }}: {{ $memoria->titulo }}. {{ $memoria->tipo_memoria }}. {{ $memoria->nombre_seminario }}. {{ $memoria->ciudad_pais }}. {{ $memoria->fecha }}.</td>
            </tr>
            @endforeach
        </table>
        <br>

        <table>
            <tr>
                <th colspan="2">Conferencias en seminarios y congresos</th>
            </tr>
            @foreach($ponenciasconferencias as $conferencia)
            <tr>
                <td><strong>{{ $conferencia->encargado }}</strong></td>
                <td>{{ $conferencia->tipo_PC }} por {{ $conferencia->tipo_participacion }}: {{$conferencia->nombre_evento}}. {{$conferencia->lugar_evento}}. {{$conferencia->fecha_fin}}.</td>
            </tr>
            @endforeach
        </table>
        <br>

    <!-- Separación de páginas -->
    <div style="page-break-before: always;"></div>

        <table>
            <tr>
                <th>Tipo de Participación</th>
                <th>Conteo</th>
            </tr>
            @foreach($countPC as $count)
            <tr>
                <td>{{ $count->tipo_participacion }}</td>
                <td>{{ $count->count }}</td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr>
                <th>Tipo de Revista</th>
                <th>Conteo</th>
            </tr>
            @foreach($countRV as $count)
            <tr>
                <td>{{ $count->tipo_revista }}</td>
                <td>{{ $count->count }}</td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr>
                <th>Tipo de Memoria</th>
                <th>Conteo</th>
            </tr>
            @foreach($countMM as $count)
            <tr>
                <td>{{ $count->tipo_memoria }}</td>
                <td>{{ $count->count }}</td>
            </tr>
            @endforeach
        </table>

        <br><br>

        <div style="text-align: center;">
            <p>Aprobó</p><br><br><br>
            @if ($fcoordinador)
                <p>_____________________________</p>
                <p>{{ $fcoordinador->NombreCoordinador }} {{ $fcoordinador->ApellidoPaternoCoordinador }} {{ $fcoordinador->ApellidoMaternoCoordinador }} coordinador de</p>
                <p> {{ $fcoordinador->Area }}</p>
            @else
                <p>Coordinador no encontrado</p>
            @endif
        </div>


        {{-- <!-- Separación de páginas -->
        <div style="page-break-before: always;"></div>

        <table>
            @foreach($ponenciasconferencias as $conferencia)
            <tr>
                <th>{{ $conferencia->encargado }}</th>
                <th>{{ $conferencia->tipo_PC }} por {{ $conferencia->tipo_participacion }} : {{$conferencia->nombre_evento}} , {{$conferencia->lugar_evento}} , {{$conferencia->fecha_fin}}.</th>
            </tr>
            @endforeach
        </table> --}}



	</body>
</html>
