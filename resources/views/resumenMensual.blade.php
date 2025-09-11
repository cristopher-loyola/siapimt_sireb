<!DOCTYPE html>
<html>
<head>
    <title>Resumen Mensual</title>
    <meta charset="UTF-8">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
     <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        body{
            zoom: 90%;
            background: #fff;
            background-size: 400% 400%;
            width: 100%;
            min-height: 100vh; 
            height: auto; 
            padding: 25px; 
        }
        h1,h3{
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .label{
            font-weight: bold;
            font-size: 18px;
            color: #333;
            margin-bottom: 5px; 
        }
        
    </style>
</head>

<body>
    <h1>Progreso por Meses</h1>

    <div class="mx-auto mb-4" style="width: fit-content;">
        <table class="table mb-4">
            <tbody>
                <tr>
                    <th>Clave:</th>
                    <?php if($proyecto->claven<10){
                        echo "<td>$proyecto->clavea$proyecto->clavet-0$proyecto->claven/$proyecto->clavey</td>";
                    } else {
                        echo "<td>$proyecto->clavea$proyecto->clavet-$proyecto->claven/$proyecto->clavey</td>";
                    } ?>
                </tr>
                <tr>
                    <th>Nombre:</th>
                    <td>{{$proyecto->nomproy}}</td>
                </tr>
                <tr>
                    <th>Duración:</th>
                    <td>{{$proyecto->duracionm}} meses</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered text-center mb-4" style="font-size: 0.9rem; table-layout: inherit;">
    <thead style="background-color: #707070; color: white;">
        <tr>
            <th style="width: 120px;">&nbsp;</th>
            @foreach($datosPorMes as $mes => $dato)
                <th>
                    {{ ucfirst(\Carbon\Carbon::parse($mes)->locale('es')->translatedFormat('F')) }} - {{ \Carbon\Carbon::parse($mes)->translatedFormat('Y') }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Programado</th>
            @foreach($datosPorMes as $dato)
                <td class="bg-primary text-white font-weight-bold">
                    {{ round(min($dato['acum_programado'], 100)) }}%
                </td>
            @endforeach
        </tr>
        <tr>
            <th>Realizado</th>
            @foreach($datosPorMes as $dato)
                <td class="bg-success text-white font-weight-bold">
                    {{ round(min($dato['acum_realizado'], 100)) }}%
                </td>
            @endforeach
        </tr>

        <!--<tr>
            <th>Programado</th>
            @foreach($datosPorMes as $dato)
                <td class="bg-primary text-white font-weight-bold">
                    {{ min($dato['programado'], 100) }}%
                </td>
            @endforeach
        </tr>
        <tr>
            <th>Realizado</th>
            @foreach($datosPorMes as $dato)
                <td class="bg-success text-white font-weight-bold">
                    {{ min($dato['realizado'], 100) }}%
                </td>
            @endforeach
        </tr>-->
    </tbody>
</table>



    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>



    {{--<p><strong>Nombre:</strong> {{ $proyecto->nomproy }}</p>
    <p><strong>Progreso:</strong> {{ $proyecto->progreso }}%</p>
    <p><strong>Estado:</strong> {{ $proyecto->estado }}</p>--}}
