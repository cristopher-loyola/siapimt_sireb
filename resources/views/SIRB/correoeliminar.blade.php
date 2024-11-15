<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- Información del servicio tecnológico -->
<h2>Hola {{ $details3['participante']->Nombre }}, Fuiste eliminado del servicio tecnológico</h2>
<p>Nombre del servicio: {{ $details3['servicio']->nombreservicio }}</p>
<p>Encargado: {{ $details3['servicio']->encargado }}</p>
    
</body>
</html>