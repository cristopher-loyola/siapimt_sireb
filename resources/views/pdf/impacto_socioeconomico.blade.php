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

h1,h2{ margin:0 0 6px 0; }
h1{ font-size:18px; }
h2{ font-size:14px; margin-top:14px; border-bottom:1px solid #ccc; padding-bottom:4px; }
.muted{ color:#666; }
.mb8{ margin-bottom:8px; }
.mb12{ margin-bottom:12px; }
.box{ border:1px solid #ddd; padding:10px; border-radius:4px; margin-bottom:10px; }
ul{ margin:6px 0 0 18px; }
table{ width:100%; border-collapse: collapse; margin-top:6px; }
th,td{ border:1px solid #ddd; padding:6px; font-size:12px; text-align:left; }
.badge{ display:inline-block; background:#0F52BA; color:#fff; padding:3px 8px; border-radius:4px; font-size:11px; }

</style>
</head>
<body>

<h1>Impacto Socioeconómico del Proyecto</h1>
<p class="muted mb12">
    {{ $proyt->clavea }}-@if($proyt->claven < 10)0{{ $proyt->claven }}@else{{ $proyt->claven }}@endif/{{ $proyt->clavey }}
    — <strong>{{ $proyt->nomproy }}</strong>
</p>

{{-- Sección Social --}}
<h2>1) Impacto Social</h2>
<div>
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
<div>
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
<div>
    <table>
        <tr>
            <th>Escala Total</th>
            <th>Nivel</th>
        </tr>
        <tr>
            <td><span class="badge">{{ $escalaTot }}</span></td>
            <td><strong>{{ $nivelImp ?? '—' }}</strong></td>
        </tr>
    </table>
</div>

<footer>
    Página <span class="page"></span> 
</footer>

</body>
</html>
