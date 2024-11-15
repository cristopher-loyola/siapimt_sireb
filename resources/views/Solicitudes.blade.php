@extends('plantillas/plantillaalt')
@section('contenido')
<title>Solicitudes de {{$proyt->nomproy}}</title>
        <div><h4 class="fw-bold text-center py-5" id="tituloform"> Solicitudes
	<td style='text-align:center;'>
	<?php
		if ($proyt->claven < 10)
 		echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
        else
        echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
	?>
	</td>
            <br>
        </div>
        <div class="mb-4">
            <div class="mb-1 input-group">
                <div>
                    <a href="{{ route('infoproys', $proyt->id)}}">
                        <button type="submit" class="btn btn-dark btn-sm" id="redondb">
                        <img src="{{URL::asset('img/back.png')}}" width="23em" height="23em"
                            alt="" style="margin-bottom: .1em">
                        Info. proyecto
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col" class="">No</th>
                    {{-- <th scope="col" class="">Observacion</th> --}}
                    <th scope="col" class="">Tipo de solicitud</th>
                    <th scope="col" class="">Fecha</th>
                    <th scope="col" class="">Proceso</th>
                    <th scope="col" class="">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($obs as $e)
                <tr>
                    <td scope="row"></td>
                    {{-- <td>{{ $e->obs }}</td> --}}
                    <td>
                        @if ($e->tipo == 1)
                            Reprogramación
                        @else
                            Cancelación
                        @endif
                    </td>
                    <td>{{$e->fechaobs}}</td>
                    <td>
                        @if ($e->revisado == 0)
                            En espera
                        @elseif ($e->revisado == 2)
                            Rechazado
                        @else
                            Aprobado
                        @endif
                    </td>
                    <td> 
                        
                        @if ($e->revisado == 0)
                            @if ($LoggedUserInfo['acceso'] == 2)
                                <form action="{{ route('revisionobs', [$proyt->id ,$e->id]) }}" method="get">
                                    <button type="submit" class="btn btn-warning" id="redondb">
                                        <img src="{{URL::asset('img/edit.png')}}" width="23em" height="23em"
                                        alt="" style="margin-bottom: .1em">
                                    </button>
                                </form>
                            @endif
                        @elseif ($e->revisado == 1)
                            <form action="{{ route('reporteaceptado',[$proyt->id ,$e->id]) }}" method="get">
                                <button type="submit" class="btn btn-primary" id="redondb">
                                    <img src="{{URL::asset('img/pdf.png')}}" width="23em" height="23em"
                                    alt="" style="margin-bottom: .1em">
                                </button>
                            </form>
                        @elseif ($e->revisado == 2)
                            <form action="{{ route('vistainfoobs',[$proyt->id ,$e->id]) }}" method="get">
                                <button type="submit" class="btn btn-primary" id="redondb" style="background-color:cadetblue">
                                    <img src="{{URL::asset('img/info_bl.png')}}" width="25em" height="25em"
                                    alt="" style="margin-bottom: .1em">
                                </button>
                            </form>
                        @endif
                    </td>
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