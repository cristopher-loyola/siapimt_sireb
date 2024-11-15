<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- Información del servicio tecnológico -->
<p>{{ $details['mando'] }}</p>
<p>{{ $details['area'] }}</p>
<br>
<br>
<p>Buen día. Solicito por este medio la cancelación del Proyecto {{ $details['clave'] }}
, conforme al Plan de control de procesos RA-002 Investigación de iniciativa
interna, donde se indica que, en el caso de cancelación del proyecto, el Responsable del
proyecto y el Coordinador/Jefe de División, de común acuerdo, redactan las causas de la
cancelación. Por lo anterior, expongo la siguiente justificación:</p>
<p>{{ $details['just']}}</p>
<br>
<p>Esperando contar con la aceptación, quedo al pendiente de su respuesta.</p>
<br>
<p>Atentamente,</p>
<p>{{ $details['responsable']}}</p>
<p>Responsable del Proyecto.</p>
<br>
<p>Para aceptar o rechazar la solicitud, dar clic a la siguiente liga:</p>
<p>http://sireb.imt.mx/public/</p>
{{-- <p>http://sireb.imt.mx/revisionobs/{{$details['idproy']}}/{{$details['idobs']}}?/</p> --}}
{{-- <p>http://wwwroot.test/revisionobs/{{$details['idproy']}}/{{$details['idobs']}}?/</p> --}}



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