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
    @if (!empty($DocumentosPorBimestre[$i]))
        <center><h2>Bimestre {{ $i }}</h2></center>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Número de documento</th>
                    <th>Título</th>
                    <th>Participantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($DocumentosPorBimestre[$i] as $servicio)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $servicio->NoPublicacion }}</td>
                        <td>{{ $servicio->Titulo }}</td>
                        <td>
                            @if (isset($publicaciones[$servicio->NoPublicacion]['nombresAutores']))
                                @foreach ($publicaciones[$servicio->NoPublicacion]['nombresAutores'] as $autor)
                                    {{ $autor->Nombre }} {{ $autor->Apellidos }}<br>
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