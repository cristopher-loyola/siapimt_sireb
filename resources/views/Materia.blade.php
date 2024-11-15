@extends('plantillas/plantillaalt')
@section('contenido')
<title>Materia de {{$proyt->nomproy}}</title>
        <div><h4 class="fw-bold text-center py-5" id="tituloform"> Materia
	<td style='text-align:center;'>
	<?php
		if ($proyt->claven < 10) 
 			echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
          	else 	echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
	?>
	</td>
            <br>
        </div>
        <div class="mb-4">
            <div class="mb-1 input-group">
                <div>
                    <a href="{{ route('infoproys', $proyt->id)}}">
                        <button type="submit" class="btn btn-dark btn-sm" id="redondb">
                        <i class='bx bxs-chevron-left-circle bx-sm bx-flashing-hover'></i>
                        Info. proyecto
                        </button>
                    </a>
                </div>
                <div class="mb-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div>
                    @if ($proyt->estado == 1 || $proyt->estado == 0)
                    <a href="{{ route('addmaterias', $proyt->id)}}">
                    <button type="submit" class="btn btn-success" id="redondb">
                        <i class='bx bxs-plus-circle bx-flashing-hover'>  </i>
                        Nueva Materia
                    </button>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col" class="">No</th>
                    <th scope="col" class="">Materia</th>
                    @if ($proyt->estado == 1 || $proyt->estado == 4 || $proyt->estado == 0)
                    <th scope="col" class="">Eliminar</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($materia as $e)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $e->descmateria }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0)
                  <td>
                    <form action="{{ route('destroymateria',[$proyt->id, $e->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="redondb">
                          <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                        </button>
                      </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br>

        <br>
</div>
@stop
@push('scripts')
@endpush