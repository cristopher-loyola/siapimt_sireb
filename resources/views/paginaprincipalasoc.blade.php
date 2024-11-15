@extends('plantillas/plantillaasoc')
@section('contenido')
<title>Inicio</title>
    {{-- Principio de tabla de proyectos  --}}
    <div class="container bg-white shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center"> Proyectos </h2>
        <br><br>
        <div>
          <form action="newp" method="get">
              <button type="submit" class="btn btn-outline-success"><i class="bx bx-plus-circle bx-flashing-hover"></i> Nuevo </button>
          </form>
      </div>
      <br>
      <table class="table table-dark table-hover">
          <thead >
              <tr>
                  <th scope="col">#</th>
                  <th scope="col">Clave</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Fecha de inicio</th>
                  <th scope="col">Fecha de fin</th>
                  <th scope="col">Responsable</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($proy as $pr)
              <tr>
                  <th scope="row">{{$pr->id}}</th>

	     <?php if ($pr->claven < 10) { echo "<td><a href='{{ route('infoproys','". $pr->id.")}}'>".$pr->clavea.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey."</a></td>"; }
          else{ echo "<td><a href='{{ route('infoproys',". $pr->id.")}}'>".$pr->clavea.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey."</a></td>";   }
            ?>
                  <td>{{$pr->nomproy}}</td>
                  <td>{{$pr->fecha_inicio}}</td>
                  <td>{{$pr->fecha_fin}}</td>
                  <td><a href="infoproyect">N/A</a></td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
    {{-- Fin de la tabla de proyectos --}}
@stop
