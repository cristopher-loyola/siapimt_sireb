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
    @if (!empty($proyectosPorBimestreI[$i]))
        <center><h2>Bimestre {{ $i }}</h2></center>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Clave de registro</th>
                    <th>Nombre del proyecto</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyectosPorBimestreI[$i] as $proyecto)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $proyecto->clavea}}{{ $proyecto->clavet}}{{ $proyecto->claven}}{{ $proyecto->clavey}}</td>
                        <td>{{ $proyecto->nomproy }}</td>
                        <td>{{ $proyecto->Nombre}} {{ $proyecto->Apellido_Paterno}} {{ $proyecto->Apellido_Materno}}</td>
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