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
    @if (!empty($BoletinesPorBimestre[$i]))
        <center><h2>Bimestre {{ $i }}</h2></center>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Articulo</th>
                    <th>Boletín</th>
                    <th>Título del artículo</th>
                    <th>Participantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($BoletinesPorBimestre[$i] as $proyecto)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $proyecto->ID_BOL_Articulo }}</td>
                        <td>{{ $proyecto->ID_BOL_Boletin }}</td>
                        <td>{{ $proyecto->titulo }}</td>
                        <td>
                            @if (!empty($participantesPorArticulo[$proyecto->ID_BOL_Articulo]))
                                @foreach($participantesPorArticulo[$proyecto->ID_BOL_Articulo] as $participante)
                                    {{ $participante->Nombre }} {{ $participante->Apellidos }}<br>
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