<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas</title>
    <link rel="stylesheet" href="{{ asset('css/indicadoresrendimientotablas.css') }}">
</head>
<body>




@for ($i = 1; $i <= 6; $i++)
    @if (!empty($serviciosTesisCursosGET[$i]))
        <center><h2>Bimestre {{ $i }}</h2></center>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Participantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviciosTesisCursosGET[$i] as $servicio)
                    <tr>
                        @if ($servicio instanceof \App\Models\tesi)
                            @if ($servicio->fase_tesis == 'Terminada')
                                <td>{{ $loop->iteration }}</td>
                            @endif
                        @elseif ($servicio instanceof \App\Models\docencia)
                            <td>{{ $loop->iteration }}</td>
                        @endif

                        @if ($servicio instanceof \App\Models\tesi)
                            @if ($servicio->fase_tesis == 'Terminada')
                                <td>{{ $servicio->titulo_tesis}}</td>
                            @endif
                        @elseif ($servicio instanceof \App\Models\docencia)
                            <td>{{ $servicio->titulo_curso }}</td>
                        @endif

                        @if ($servicio instanceof \App\Models\tesi)
                            @if ($servicio->fase_tesis == 'Terminada')
                                <td>Tesis</td>
                            @endif
                        @elseif ($servicio instanceof \App\Models\docencia)
                            <td>Curso Impartidos</td>
                        @endif
                        
                        @if ($servicio instanceof \App\Models\tesi)
                            @if ($servicio->fase_tesis == 'Terminada')
                                <td>
                                    {{ $servicio->encargado }}<br>
                                    @foreach($nombresParticipantesPorCursos[$servicio->id] ?? [] as $participanteCurso)
                                        {{ $participanteCurso->Nombre }} {{ $participanteCurso->Apellido_Paterno }} {{ $participanteCurso->Apellido_Materno }}<br>
                                    @endforeach
                                </td>
                            @endif
                        @elseif ($servicio instanceof \App\Models\docencia)
                            <td>
                                {{ $servicio->encargado }}<br>
                                @foreach($nombresParticipantesPorCursos[$servicio->id] ?? [] as $participanteCurso)
                                    {{ $participanteCurso->Nombre }} {{ $participanteCurso->Apellido_Paterno }} {{ $participanteCurso->Apellido_Materno }}<br>
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <br>
    @endif
@endfor




    <br>
    <br>
    <br>
</body>
</html>