<?php
          /* header('Content-type:application/xls');
          header('Content-Disposition: attachment; filename=InformacionProyectosGeneral.xls'); */
          $fecha=date('d_m_Y');
          header('Pragma: no-cache');
          header('Expires: 0');
          header('Content-Transfer-Encoding: none');
          header('Content-type: application/vnd.ms-excel;charset=utf-8');// 
          header("Content-Disposition: attachment; filename=ReporteGeneralProyectos_$fecha.xls");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
  <div> 
  <p>Reporte General de Proyectos</p>

  </div>
  <br>
  <br>
  <br>
  <table class="table table-hover" id="mytab1">
    <thead class="thead-dark">
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
          <th scope="col">Duración (Meses)</th>
          <th scope="col">Inicio</th>
          <th scope="col">Fin</th>
          <th scope="col">Costo</th>
          <th scope="col">Avance</th>
          <th scope="col">Responsable</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($proyt as $pr) 
        <tr>
          <th scope="row">{{$pr->nombre_area}}</th>
          <td>{{$pr->clavet}}</td>
          <td>{{$pr->clavea.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey}}</td>
          <td>{{$pr->nomproy}}</td>
          <td>{{$pr->nivel1}}</td>
          <td>{{$pr->nivel2}}</td>
          <td>{{$pr->nivel3}}</td>
          <td>{{$pr->nombre_transporte}}</td>
          <td>{{$pr->nombre_linea}}</td>
          <td>{{$pr->nombre_objetivosec}}</td>
          <td>{{$pr->duracionm}} Meses</td>
          <td>{{$pr->fecha_inicio}}</td>
          <td>{{$pr->fecha_fin}}</td>
          <td>{{$pr->costo}} $</td>
          <td>{{$pr->progreso}}%</td>
          <td>{{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}</td>
        </tr>
      @endforeach
      @foreach ($proy as $pr) 
        <tr>
          <th scope="row">{{$pr->nombre_area}}</th>
          <td>{{$pr->clavet}}</td>
          <td>{{$pr->clavea.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey}}</td>
          <td>{{$pr->nomproy}}</td>
          <td>{{$pr->nivel1}}</td>
          <td>{{$pr->nivel2}}</td>
          <td>{{$pr->nivel3}}</td>
          <td>{{$pr->nombre_transporte}}</td>
          <td>{{$pr->nombre_linea}}</td>
          <td>{{$pr->nombre_objetivosec}}</td>
          <td>{{$pr->duracionm}} Meses</td>
          <td>{{$pr->fecha_inicio}}</td>
          <td>{{$pr->fecha_fin}}</td>
          <td>{{$pr->costo}} $</td>
          <td>{{$pr->progreso}}%</td>
          <td>{{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}</td>
        </tr>
      @endforeach
    </tbody>
</table>


