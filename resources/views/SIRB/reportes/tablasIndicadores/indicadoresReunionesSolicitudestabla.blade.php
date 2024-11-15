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
    @if (!empty($serviciosReunionSolicitudGET[$i]))
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
                @foreach($serviciosReunionSolicitudGET[$i] as $servicio)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($servicio instanceof \App\Models\Reunion)
                                {{ $servicio->tipo_reunion }}
                            @elseif ($servicio instanceof \App\Models\solicitudes)
                                {{ $servicio->titulo }}
                            @endif                        
                        </td>
                        <td>
                            @if ($servicio instanceof \App\Models\Reunion)
                                Reunion
                            @elseif ($servicio instanceof \App\Models\solicitudes)
                                Solicitud
                            @endif
                        </td>
                        <td>
                            {{ $servicio->encargado }}<br>
                            @foreach($nombresParticipantesPorReunion[$servicio->id] ?? [] as $participanteReunion)
                                {{ $participanteReunion->Nombre }} {{ $participanteReunion->Apellido_Paterno }} {{ $participanteReunion->Apellido_Materno }}<br>
                            @endforeach
                            {{-- Agregar participantes de solicitudes --}}
                            @if ($servicio instanceof \App\Models\Solicitud)
                                @foreach($nombresParticipantesPorSolicitud[$servicio->id] ?? [] as $participanteSolicitud)
                                    {{ $participanteSolicitud->Nombre }} {{ $participanteSolicitud->Apellido_Paterno }} {{ $participanteSolicitud->Apellido_Materno }}<br>
                                @endforeach
                            @endif
                        </td>
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