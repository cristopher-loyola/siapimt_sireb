<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- Información del servicio tecnológico -->
<p>Buen día {{ $details['participante']->Nombre }}, se le notifica que {{ $details['servicio']->encargado }} lo ha agregado en el Sistema de Reportes Bimestrales, como participante de:</p>
<br>
<p>Evento: {{ $details['evento']}}</p>
<p>Fecha: {{ $details['servicio']->fecha_reunion }}</p>
<p>Titulo: {{ $details['servicio']->tipo_reunion }}</p>
<br>
<br>
<p>Usted puede consultar el evento o eliminar su participación desde el sistema.</p>
<p>Para cualquier aclaración, comunicarse con la persona que lo agregó.</p>
<p>Por favor, no responda a este mensaje, ya que ha sido enviado de forma automática.</p>
    
</body>
</html>