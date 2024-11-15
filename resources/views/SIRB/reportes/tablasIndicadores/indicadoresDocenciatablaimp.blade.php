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
    @if (!empty($CursosPorBimestre[$i]))
        <center><h2>Bimestre {{ $i }}</h2></center>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Título</th>
                    <th>Lugar</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($CursosPorBimestre[$i] as $proyecto)
                    <tr> 
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $proyecto->titulo_curso}}</td>
                        <td>{{ $proyecto->lugar }}</td>
                        <td>
                        {{ $proyecto->encargado}}
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