<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Impacto Socioeconómico - {{ $proyt->nomproy }}</title>
<style>
@page {
    margin: 50px 25px 60px 25px; /* margen inferior para el footer */
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #222;
    padding-bottom: 60px; /* espacio para el footer */
    line-height: 1.4;
    background-color: #fff;
}

footer {
    position: fixed; 
    bottom: 0; 
    left: 0; 
    right: 0; 
    height: 40px;
    text-align: center;
    font-size: 10px;
    color: #666;
    border-top: 1px solid #ccc;
    padding-top: 5px;
}

footer .page:after { content: counter(page); }
footer .topage:after { content: counter(pages); }

h1,h2{ margin:0 0 10px 0; }
h1{ 
    font-size:22px; 
    color: #0F52BA; 
    text-align: center; 
    margin-bottom: 20px;
    padding: 15px 0;
    border-bottom: 3px solid #0F52BA;
}
h2{ 
    font-size:16px; 
    margin-top:25px; 
    margin-bottom:15px;
    border-bottom:2px solid #0F52BA; 
    padding-bottom:8px; 
    color: #0F52BA;
    font-weight: bold;
}
.muted{ color:#666; font-style: italic; }
.mb8{ margin-bottom:8px; }
.mb12{ margin-bottom:12px; }
.box{ 
    border:1px solid #ddd; 
    padding:15px; 
    border-radius:8px; 
    margin-bottom:15px; 
    background-color: #f8f9fa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Estilos para las secciones de contenido */
.seccion-contenido {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.proyecto-info {
    background-color: #e3f2fd;
    border: 1px solid #bbdefb;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 25px;
    text-align: center;
}
ul{ margin:6px 0 0 18px; }
table{ width:100%; border-collapse: collapse; margin-top:6px; }
th,td{ border:1px solid #ddd; padding:6px; font-size:12px; text-align:left; }
.badge{ display:inline-block; background:#0F52BA; color:#fff; padding:3px 8px; border-radius:4px; font-size:11px; }

/* Estilos para la card visual de resultados - Optimizados para PDF */
.resultado-container {
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    margin: 20px auto;
    width: 400px;
    text-align: center;
    background-color: #f9f9f9;
    page-break-inside: avoid;
}

.resultado-titulo {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #222;
    text-transform: uppercase;
}

.escala-card {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin: 15px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #333;
}

.escala-numero {
    font-size: 36px;
    font-weight: bold;
    color: white;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.nivel-titulo {
    font-size: 14px;
    font-weight: bold;
    margin: 15px 0 10px 0;
    color: #222;
    text-transform: uppercase;
}

.nivel-texto {
    font-size: 20px;
    font-weight: bold;
    margin: 10px 0;
}

/* Colores para los diferentes niveles - Optimizados para PDF */
.nivel-muy-bajo .escala-card {
    background-color: #ff0000;
    border-color: #cc0000;
}
.nivel-muy-bajo .nivel-texto {
    color: #ff0000;
}

.nivel-bajo .escala-card {
    background-color: #ff5252;
    border-color: #ff1744;
}
.nivel-bajo .nivel-texto {
    color: #ff5252;
}

.nivel-medio .escala-card {
    background-color: #FFBF00;
    border-color: #FF8F00;
}
.nivel-medio .nivel-texto {
    color: #FFBF00;
}

.nivel-alto .escala-card {
    background-color: #50C878;
    border-color: #2E7D32;
}
.nivel-alto .nivel-texto {
    color: #50C878;
}

.nivel-muy-alto .escala-card {
    background-color: #00A36C;
    border-color: #00695C;
}
.nivel-muy-alto .nivel-texto {
    color: #00A36C;
}

/* Tabla de interpretación mejorada */
.tabla-interpretacion {
    margin: 20px auto;
    width: 100%;
    max-width: 400px;
    border-collapse: collapse;
}

.tabla-interpretacion th {
    background-color: #f0f0f0;
    font-weight: bold;
    padding: 8px;
    border: 1px solid #ddd;
}

.tabla-interpretacion td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: center;
}

</style>
</head>
<body>

<h1>Impacto Socioeconómico del Proyecto</h1>
<div class="proyecto-info">
    <p style="margin: 0; font-size: 14px;">
        <strong>Clave:</strong> {{ $proyt->clavea }}-@if($proyt->claven < 10)0{{ $proyt->claven }}@else{{ $proyt->claven }}@endif/{{ $proyt->clavey }}
    </p>
    <p style="margin: 10px 0 0 0; font-size: 16px; font-weight: bold; color: #0F52BA;">
        {{ $proyt->nomproy }}
    </p>
</div>

{{-- Sección Social --}}
<h2>1) Impacto Social</h2>
<div class="seccion-contenido">
    <p><strong>Problema social:</strong> {{ $problemaSocialTxt }}</p>
    <p><strong>Escala geográfica:</strong> {{ $escalaGeograficaTxt }}</p>

    <p class="mb8"><strong>Contribuciones sociales seleccionadas:</strong></p>
    @if(count($selContriSocTxt))
        <ul>
            @foreach($selContriSocTxt as $txt)
                @if($txt !== '') <li>{{ $txt }}</li> @endif
            @endforeach
        </ul>
    @else
        <p class="muted">Sin selecciones.</p>
    @endif

    <p class="mb8"><strong>Justificación social:</strong></p>
    <div>
        {!! nl2br(e($proytImp->descImpSoc ?? '')) ?: '<span class="muted">Sin justificación.</span>' !!}
    </div>
</div>

{{-- Sección Económica --}}
<h2>2) Impacto Económico</h2>
<div class="seccion-contenido">
    <p class="mb8"><strong>Eficiencia del transporte:</strong></p>
    @if(count($selEfiTxt))
        <ul>
            @foreach($selEfiTxt as $txt)
                @if($txt !== '') <li>{{ $txt }}</li> @endif
            @endforeach
        </ul>
    @else
        <p class="muted">Sin selecciones.</p>
    @endif

    <p class="mb8"><strong>Productividad del transporte:</strong></p>
    @if(count($selProdTxt))
        <ul>
            @foreach($selProdTxt as $txt)
                @if($txt !== '') <li>{{ $txt }}</li> @endif
            @endforeach
        </ul>
    @else
        <p class="muted">Sin selecciones.</p>
    @endif

    <p class="mb8"><strong>Contribución económica:</strong></p>
    @if(count($selEcoTxt))
        <ul>
            @foreach($selEcoTxt as $txt)
                @if($txt !== '') <li>{{ $txt }}</li> @endif
            @endforeach
        </ul>
    @else
        <p class="muted">Sin selecciones.</p>
    @endif
    <br></br>

    <p class="mb8"><strong>Justificación económica:</strong></p>
    <div>
        {!! nl2br(e($proytImp->descImpEco ?? '')) ?: '<span class="muted">Sin justificación.</span>' !!}
    </div>
</div>

{{-- Resultado --}}
<h2>3) Resultado (ISE)</h2>

@php
    // Determinar la clase CSS basada en el nivel
    $nivelClass = '';
    $nivelTexto = $nivelImp ?? '—';
    
    if (stripos($nivelTexto, 'muy bajo') !== false) {
        $nivelClass = 'nivel-muy-bajo';
    } elseif (stripos($nivelTexto, 'bajo') !== false) {
        $nivelClass = 'nivel-bajo';
    } elseif (stripos($nivelTexto, 'medio') !== false) {
        $nivelClass = 'nivel-medio';
    } elseif (stripos($nivelTexto, 'alto') !== false && stripos($nivelTexto, 'muy alto') === false) {
        $nivelClass = 'nivel-alto';
    } elseif (stripos($nivelTexto, 'muy alto') !== false) {
        $nivelClass = 'nivel-muy-alto';
    }
@endphp

<div class="resultado-container {{ $nivelClass }}">
    <div class="resultado-titulo">Índice de Impacto Socioeconómico</div>
    
    <div class="escala-card">
        <div class="escala-numero">{{ $escalaTot }}</div>
    </div>
    
    <div class="nivel-titulo">Nivel de Impacto</div>
    <div class="nivel-texto">{{ $nivelTexto }}</div>
</div>

{{-- Tabla de interpretación adicional --}}
<div style="margin-top: 20px;">
    <table class="tabla-interpretacion">
        <tr>
            <th>Escala Total</th>
            <th>Nivel de Impacto</th>
        </tr>
        <tr>
            <td><strong>{{ $escalaTot }}</strong></td>
            <td><strong>{{ $nivelTexto }}</strong></td>
        </tr>
    </table>
</div>

<footer>
    Página <span class="page"></span> 
</footer>

</body>
</html>
