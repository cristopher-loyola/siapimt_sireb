<?php

/* header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=InformacionProyectosGeneral.xls'); */

$fecha=date('d_m_Y');
header('Content-type: application/vnd.ms-excel;charset=utf8');// 
header("Content-Disposition: attachment; filename=Afectaciones_$fecha.xls");
?>
<style>
    #aling{
        text-align: center;
    }

    #aling-l{
        text-align: right;
    }
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<div> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<img src="\\10.34.1.205\Logo\logoIMT con letras.jpg" width="150" height="100">
</div>

<table>
    <thead>
        <tr>
            <th scope="col">Número de contrato</th>
            <th scope="col">Clave del Proyecto</th>
            <th scope="col">Nombre del Proyecto</th>            
            <th scope="col">Número de Clc</th>
            <th scope="col">Concepto de Clc</th>
            <th scope="col">Fecha</th>
            <th scope="col">Partidas Presupuestarias</th>
            <th scope="col">Concepto de la Partida</th>
            <th scope="col">Fuente de Financiamiento</th>
            <th scope="col">Monto por Partida </th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($afectaciones as $af)
        <tr>
            <th scope="row">{{ $af->ncontratos }}</th>

		 @if ($af->claven < 10) <td id="aling">{{$af->clavea.$af->clavet.'-0'.$af->claven.'/'.$af->clavey}}</td>
          	 @else <td id="aling">{{$af->clavea.$af->clavet.'-'.$af->claven.'/'.$af->clavey}}</td> 
		 @endif

            <td id="aling">{{$af->nomproy}}</td>   
            <td id="aling">{{ $af->clc }}</td>
            <td id="aling">{{ $af->conceptoc }}</td>
            <td id="aling">{{ $af->fecha }}</td>
            <td id="aling">{{ $af->partida }}</td>
            <td id="aling">{{ $af->concepto}}</td>
            <td id="aling">{{ $af->tipo}}</td>
            <td id="aling">$ {{ $af->montoxpartida }}</td>
            </tr>
            
            @endforeach 

            <tr>             
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td id="aling-l"><strong>Monto Asignado:</strong></td>
                <td id="aling"><strong> $ {{$af->costo}}</strong></td>
            
            </tr>

            <tr> 
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td id="aling-l"><strong> Monto de las Afectaciones: </strong></td>
                <td id="aling"><strong>${{$total}}</strong></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td id="aling-l"><strong> Restante:</strong></td>
                <td id="aling"><strong> $ {{$af->costo - $total}}</strong></td>
            </tr>
        </tbody>    
    </table>

             
                        