<?php
          /* header('Content-type:application/xls');
          header('Content-Disposition: attachment; filename=InformacionProyectosGeneral.xls'); */
          $fecha=date('d_m_Y');
          header('Pragma: no-cache');
          header('Expires: 0');
          header('Content-Transfer-Encoding: none');
          header('Content-type: application/vnd.ms-excel;charset=utf-8');// 
          header("Content-Disposition: attachment; filename=ReporteDeProyectosPorResponsable_$fecha.xls");
?>
<style>
  #aling{
      text-align: center;
  }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
<div>
<p> Reporte General de Proyectoss</p>

</div>
<br>
<br>
<br>
<table>
  <thead>
      <tr>
          <th scope="col">Area de Adscripción</th>
          <th scope="col">Interno/Externo</th>
          <th scope="col">Clave</th>
          <th scope="col">Nombre del Proyecto</th>
          <th scope="col">Cliente Nivel 1</th>
          <th scope="col">Cliente Nivel 2</th>
          <th scope="col">Cliente Nivel 3</th>
          <th scope="col">Modo de Transporte</th>
          <th scope="col">Linea de investigación</th>
          <th scope="col">Objetivo Sectorial </th>
          <th scope="col">Orientación</th>
          <th scope="col">Impacto social o Económico</th>
          <th scope="col">Materia</th>
          <th scope="col">Duración (Meses)</th>
          <th scope="col">Inicio</th>
          <th scope="col">Fin</th>
          <th scope="col">Costo</th>
          <th scope="col">Avance</th>
          <th scope="col">Responsable</th>
          <th scope="col">Contribuciones</th>
      </tr>
  </thead>
  <tbody>
    @foreach ($proy as $pr)
      <tr>
          <th scope="row">{{$pr->nombre_area}}</th>
          <td id="aling">{{$pr->clavet}}</td>

		 @if ($pr->claven < 10) <td id="aling">{{$pr->clavea.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey}}</td>
          	 @else <td id="aling">{{$pr->clavea.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey}}</td>
		 @endif

          <td id="aling">{{ strip_tags(html_entity_decode($pr->nomproy)) }}</td>
          <td id="aling">{{$pr->nivel1}}</td>
          <td id="aling">{{$pr->nivel2}}</td>
          <td id="aling">{{$pr->nivel3}}</td>
          <td id="aling">{{$pr->nombre_transporte}}</td>
          <td id="aling">{{$pr->nombre_linea}}</td>
          <td id="aling">{{$pr->nombre_objetivosec}}</td>
          <td id="aling">
            @foreach ($orientacion as $ori)
              @if ($pr->orientacion == $ori->id)
                {{$ori->descorientacion}}
              @endif
            @endforeach
          </td>
          <td id="aling">
            @foreach ($nivel as $lvl)
              @if ($pr->nivel == $lvl->id)
              {{$lvl->nivel}}
              @endif
            @endforeach
          </td>
          <td id="aling">
            @foreach ($materia as $mat)
              @if ($pr->materia == $mat->id)
                {{$mat->descmateria}}
              @endif
            @endforeach
          </td>
          <td id="aling">{{$pr->duracionm}} Meses</td>
          <td id="aling">{{$pr->fecha_inicio}}</td>
          <td id="aling">{{$pr->fecha_fin}}</td>
          <td id="aling">{{$pr->costo}} $</td>

          @if ($pr->clavet == 'I')
            @if ($pr->publicacion == 1)
              <td id="aling">{{$pr->progreso}}%</td>
            @elseif ($pr->publicacion == 2)
              <td id="aling">{{$pr->progreso}}%</td>
            @else
              @if ($pr->progreso == 100)
                <td id="aling">98%</td>
              @else
                  <?php
                  $pgreal = $pr->progreso;
                  $comp = 98;
                  $mult = ($comp*$pgreal);
                  $div = ($mult/100);
                  $psinp = round($div,0);
                  ?>
                <td id="aling">{{$psinp}}%</td>
              @endif
            @endif
          @else
            <td id="aling">{{$pr->progreso}}%</td>
          @endif

          <td id="aling">{{ strip_tags(html_entity_decode($pr->responsable)) }}</td>
          <td id="aling">
            @foreach ($contri as $con)
              @if ($pr->id == $con->idproyecto)
                {{$con->nombre_contri.' | '}}
              @endif
            @endforeach
        </td>
      </tr>
    @endforeach
  </tbody>
</table>



