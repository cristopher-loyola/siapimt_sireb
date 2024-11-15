<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- Información del servicio tecnológico -->
<p>{{ $details['responsable']}}</p>
<p>Responsable del Proyecto.</p>
<br>
<br>
<p>Buen día, en respuesta a su solicitud, se rechaza la Reprogramación del proyecto  {{ $details['clave'] }} ], por el motivo siguiente:</p>
<p>{{ $details['justrechazo'] }}</p>
<br>
<p>Por lo anterior, deberá continuar con los tiempos definidos en el programa actual del Sistema de Administración de Proyectos (SIAPIMT).</p>
<br>
<br>
<p>Atentamente,
<p>{{ $details['mando'] }}</p>
<p>{{ $details['area'] }}</p>
<br>

<p style="color: #4c642c; font-size: 13px;">
    Antes de imprimir este mensaje, asegúrese de que es necesario.
    <br>
    Proteger el medio ambiente está en nuestras manos.
</p>

<br>

<h1 style="font-family: 'Times New Roman', Times, serif; color: gray; font-weight: bold; font-size: 12px;">ADVERTENCIA LEGAL</h1>

<p style="font-family: 'Times New Roman', Times, serif; color: gray; font-size: 11px;">
"La información contenida o anexa a este mensaje es considerada pública y excepcionalmente, en términos de las disposiciones aplicables, podría clasificarse como información reservada o confidencial.
Los datos personales y sensibles que contenga serán tratados conforme a la Ley General de Protección de Datos Personales en Posesión de Sujetos Obligados y demás normatividad aplicable. Si usted recibió esta información por error o no es el destinatario, deberá borrarla por completo de su sistema e informar a la brevedad al remitente.
Fundamento: Artículos 6° de la Constitución Política de los Estados Unidos Mexicanos, 4°, 113, 116 de la Ley General de Transparencia y Acceso a la Información Pública; 3°, 110 y 113 de la Ley Federal de Transparencia y Acceso a la Información Pública."
</p>

</body>
</html>