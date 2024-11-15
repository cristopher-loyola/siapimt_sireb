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
    @if (!empty($serviciosPorBimestre[$i]))
        <center><h2>Bimestre {{ $i }}</h2></center>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Número de registro</th>
                    <th>Nombre del servicio</th>
                    <th>Participantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviciosPorBimestre[$i] as $servicio)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $servicio->numeroregistro }}</td>
                        <td>{{ $servicio->nombreservicio }}</td>
                        <td>
                            {{ $servicio->encargado }}<br>
                            @foreach($nombresParticipantesPorServicio[$servicio->id] ?? [] as $participante)
                                {{ $participante->Nombre }} {{ $participante->Apellido_Paterno }} {{ $participante->Apellido_Materno }}<br>
                            @endforeach
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