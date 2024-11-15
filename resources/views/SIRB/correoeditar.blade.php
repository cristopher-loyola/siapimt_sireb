<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- Información del servicio tecnológico -->
<h2>Hola {{ $details2['participante']->Nombre }}, fuiste agregado al servicio tecnológico</h2>
<p>Nombre del servicio: {{ $details2['servicio']->nombreservicio }}</p>
<p>Encargado: {{ $details2['servicio']->encargado }}</p>
    
</body>
</html>