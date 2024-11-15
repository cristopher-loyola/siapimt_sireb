<?php
        $fecha=date('d_m_Y');
        header('Pragma: no-cache');
        header('Expires: 0');
        header('Content-Transfer-Encoding: none');
        header('Content-type: application/vnd.ms-excel;charset=utf-8');// 
        header("Content-Disposition: attachment; filename=F1_R1-002_02_$fecha.xls");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    table{
                counter-reset: rowNumber;
            }
            table tr > td:first-child{
                counter-increment: rowNumber;
            }
            table tr td:first-child::before{
                content: counter(rowNumber);
                min-width: 1em;
                margin-right: 0.5em;
            }
</style>
<body> 
    <table>
        <thead> 
            <tr>
                <th colspan="2" rowspan="3" >
                    <img src="\\10.34.1.205\Logo\logoIMT con letras.jpg" width="100" height="80">
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="9">
                    <strong> Sistema de Gestión de Calidad </strong>
                </th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th colspan="5">Coordinación de </th>
                <th colspan="7" style="border: 1px solid black;">{{$areas->nombre_area}}</th>
            </tr>
            <tr>
                <th width="80">Instituto Mexicano del Transporte</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="7">
                    <strong> PROGRAMA DE ACTIVIDADES </strong>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><strong>PROYECTO:</strong></th>
                <th colspan="8">{{$proyt->clavea.' '.$proyt->clavet.'-'.$proyt->claven.'/'.$proyt->clavey.' '}}{{$proyt->nomproy}}</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  <br>
    <table border="1">
        <thead> 
        </thead>
        <tbody>
            <tr>
                <th colspan="2"> Actividad </th>
                <th rowspan="2" colspan="2" > % de 
                    PARTICIPACIÓN
                </th>
                <tH colspan="12"> DURACIÓN (MESES O SEMANAS)</tH>
            </tr>
            <tr>
                <th>NO.</th>
                <th>DESCRIPCIÓN</th>
                <th width="30">1</th>
                <th width="30">2</th>
                <th width="30">3</th>
                <th width="30">4</th>
                <th width="30">5</th>
                <th width="30">6</th>
                <th width="30">7</th>
                <th width="30">8</th>
                <th width="30">9</th>
                <th width="30">10</th>
                <th width="30"> ... </th>
                <th width="30"> N </th>
            </tr>
            @foreach ($tarea as $t)
            <tr>
                <td scope="row" rowspan="2"></td>
                <th rowspan="2">{{ $t->actividad }}</th>
                <th>
                    P{{-- {{ $t->fecha_inicio }} --}}
                </th>
                <td>
                    {{-- {{ $t->fecha_fin }} --}}
                    <strong>100%</strong>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>R</th>
                <td><strong>{{$t->progreso}}%</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <th colspan="2" rowspan="2" > Total </th>
                <th>P</th>
                <td><strong>100%</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>R</th>
                <td><strong>{{$proyt->progreso}}%</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th colspan="2" rowspan="2" > Observaciones </th>
                <th colspan="14" rowspan="2" ></th>
            </tr>
            <tr>         
            </tr>
        </tbody>
    </table>
{{--   <table class="table table-hover">
    <thead>
    <tr>
      <th scope="col" class="">No</th>
      <th scope="col" class="">Tarea o Actividad</th>
      <th scope="col" class="">Fecha inicio</th>
      <th scope="col" class="">Fecha Fin</th>
      <th scope="col" class="">Duración</th>
      <th scope="col" class="">Avance</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tarea as $t)
    <tr>
      <td scope="row"></td>
      <td>{{ $t->actividad }}</td>
      <td>
        {{ $t->fecha_inicio }}
      </td>
      <td>
        {{ $t->fecha_fin }}
      </td>
      <td>
        {{ $t->duracion }} dias 
      </td>
      <td>
        <strong>{{$t->progreso}}%</strong>
      </td>
    </tr>
    @endforeach
    </tbody>
</table> --}}


</body>
</html>
