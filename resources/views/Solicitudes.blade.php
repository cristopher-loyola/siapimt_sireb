@extends('plantillas/plantillaalt')
@section('contenido')
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<style>
    #exito{
        width: 100%;
        background: #1a831ade;
        color: #fff;
        font-size: 1.2em;
        border-radius: 5px;
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }
</style>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#exito").fadeOut(1500);
            $("#fallo").fadeOut(1500);
        },3000);
    });
</script>
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
            @if (Session::has('success'))
                <div id="exito">{{Session::get('success')}}</div>
                <br>
            @endif
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
                @if ($proyt->idusuarior  == $LoggedUserInfo['id'])
                    @if ($proyt->gprotocolo == 0)
                        <div>
                            &nbsp;&nbsp;&nbsp;
                        </div>
                        <div>
                            <form action="{{route('notificarreporte', $proyt->id)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" id="redondb">
                                    <img src="../img/mail.png" width="32em" height="32em"
                                    alt="" style="margin-bottom: .1em">
                                    @if ($proyt->clavet == 'I')
                                        Revisión protocolo
                                    @else
                                        Revisión PTE
                                    @endif
                                </button>
                            </form>
                        </div>
                    @endif
                @endif
                @if ($responsable == 1 || $LoggedUserInfo['acceso'] == 2)
                    @if ($proyt->cam_estado == 0)
                        @if ($proyt->estado == 1 || $proyt->estado == 3)
                            @if ($proyt->estado == 3)
                                @if($reanudar == 1)
                                    <div>
                                        &nbsp;&nbsp;&nbsp;
                                    </div>
                                    <div>
                                        <a href="{{ url('change-status-proy/'.$proyt->id)}}" class="btn btn-primary" id="redondb"
                                            style="background: #1373c1; color:#ffffff">
                                            <img src="../img/play.png" width="32em" height="32em"
                                            alt="" style="margin-bottom: .1em">
                                            &nbsp;Reanudar&nbsp;
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div>
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div>
                                    <form action="{{route('solicitud', $proyt->id)}}" method="get">
                                        @csrf
                                        <button type="submit" class="btn" id="redondb"
                                        style="background: #1373c1; color:#ffffff">
                                            <img src="../img/reprogramar.png" alt="" height="24em" width="24em">
                                            &nbsp;Reprogramar&nbsp;
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif
                        @if ($proyt->estado == 1 || $proyt->estado == 3 || $proyt->estado == 4)
                            <div>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                            <div>
                                <form action="{{route('soldcan', $proyt->id)}}" method="get">
                                    @csrf
                                    <button type="submit" class="btn" tabindex="5" id="redondb" style="background: #de2626; color:#ffffff">
                                        <img src="../img/cancelar.png" alt="" height="26em" width="26em">
                                        &nbsp;Cancelar&nbsp;
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col" class="">No</th>
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
                    <td>
                        @if ($e->tipo == 1)
                            Reprogramación
                        @elseif ($e->tipo == 2)
                            Cancelación
                        @else
                            Protocolo
                        @endif
                    </td>
                    <td>{{$e->fechaobs}}</td>
                    <td>
                        @if ($e->revisado == 0)
                            @if($e->tipo == 1)
                                En espera de respuesta
                            @elseif ($e->tipo == 2)
                                En espera de respuesta
                            @elseif ($e->tipo == 3)
                                En revisión
                            @elseif($e->tipo == 4)
                                Regresado con observaciones
                            @elseif($e->tipo == 5)
                                @if ($proyt->clavet == 'I')
                                    Protocolo Rechazado
                                @else
                                    PTE Rechazado
                                @endif
                            @elseif ($e->tipo == 6)
                                Aprobado para firmar
                            @elseif ($e->tipo == 7)
                                Esperando respuesta del COSPIII
                            @endif
                        @elseif ($e->revisado == 2)
                            Rechazado
                        @else
                            @if ($e->tipo == 4 || $e->tipo == 3 || $e->tipo == 6)
                                @if ($proyt->clavet == 'I')
                                    Protocolo Aprobado
                                @else
                                    PTE Aprobado
                                @endif
                            @else
                                Aprobado
                            @endif
                            
                        @endif
                    </td>
                    <td>
                        @if ( $proyt->idusuarior == $LoggedUserInfo['id'])
                            @if ($e->tipo == 6)
                                @if ($e->fobsresponsble == null)
                                    <form action="{{route('firmaresponsable', [$proyt->id ,$e->id])}}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-warning" id="redondb">
                                            <img src="{{URL::asset('img/edit.png')}}" width="25em" height="25em"
                                            alt="" style="margin-bottom: .1em">
                                        </button>
                                    </form>
                                {{-- @elseif ($e->fobsmando == null && $e->fobsresponsble != null)
                                    <form action="{{route('firmaresponsable', [$proyt->id ,$e->id])}}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-warning" id="redondb">
                                            <img src="{{URL::asset('img/edit.png')}}" width="25em" height="25em"
                                            alt="" style="margin-bottom: .1em">
                                        </button>
                                    </form> --}}
                                @else
                                    @if ($e->fobsmando == null)
                                        <img src="{{URL::asset('/img/espera.png')}}" width="25em" height="25em"
                                        alt="En espera" title="En espera de firma del mando inmediato">
                                    @else
                                        <img src="{{URL::asset('/img/aprub.png')}}" width="32em" height="32em"
                                        alt="Aprobado">
                                    @endif
                                @endif
                            @elseif ($e->tipo == 3)
                                @if ($e->fobsmando == null)
                                    <img src="{{URL::asset('/img/espera.png')}}" width="25em" height="25em"
                                    alt="En espera" title="En espera de aprobación">
                                @else
                                    <img src="{{URL::asset('/img/aprub.png')}}" width="32em" height="32em"
                                    alt="Aprobado">
                                @endif
                            @elseif ($e->tipo == 4)
                                @if ($e->fobsmando != '' && $e->fobsresponsble == '')
                                    <form action="{{route('firmaresponsable', [$proyt->id ,$e->id])}}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-warning" id="redondb">
                                            <img src="{{URL::asset('img/edit.png')}}" width="25em" height="25em"
                                            alt="" style="margin-bottom: .1em">
                                        </button>
                                    </form>
                                @else
                                    @if ($e->fobsmando == null)
                                        <img src="{{URL::asset('/img/espera.png')}}" width="25em" height="25em"
                                        alt="En espera" title="Revisar las observaciones señaladas">
                                    @else
                                        <img src="{{URL::asset('/img/aprub.png')}}" width="32em" height="32em"
                                        alt="Aprobado">
                                    @endif
                                @endif
                            @elseif ($e->tipo == 5)
                                <form action="{{ route('vistainfoobs',[$proyt->id ,$e->id]) }}" method="get">
                                    <button type="submit" class="btn btn-primary" id="redondb" style="background-color:cadetblue">
                                        <img src="{{URL::asset('img/info_bl.png')}}" width="25em" height="25em"
                                        alt="" style="margin-bottom: .1em">
                                    </button>
                                </form>
                            @elseif ($e->tipo == 7)
                                <img src="{{URL::asset('/img/espera.png')}}" width="25em" height="25em"
                                alt="En espera" title="En espera de respuesta del COSPIII">
                            @endif
                        @elseif ($LoggedUserInfo['director'] == 1)
                            @if ($e->revisado == 1)
                                @if ($e->fobsdirectorg == '' )
                                    <form action="{{ route('revisionobs', [$proyt->id ,$e->id]) }}" method="get">
                                        <button type="submit" class="btn btn-warning" id="redondb">
                                            <img src="{{URL::asset('img/edit.png')}}" width="23em" height="23em"
                                            alt="" style="margin-bottom: .1em">
                                        </button>
                                    </form>
                                @else
                                    <img src="{{URL::asset('img/aprub.png')}}" width="32em" height="32em"
                                    alt="">
                                @endif
                            @endif
                        @endif

                        @if ($e->revisado == 0)
                            @if ($LoggedUserInfo['acceso'] == 2)
                                @if ($e->tipo == 5)
                                    <form action="{{ route('vistainfoobs',[$proyt->id ,$e->id]) }}" method="get">
                                        <button type="submit" class="btn btn-primary" id="redondb" style="background-color:cadetblue">
                                            <img src="{{URL::asset('img/info_bl.png')}}" width="25em" height="25em"
                                            alt="" style="margin-bottom: .1em">
                                        </button>
                                    </form>
                                @elseif ($e->tipo == 6)
                                    @if ($e->fobsresponsble != null)
                                        <form action="{{ route('revisionobs', [$proyt->id ,$e->id]) }}" method="get">
                                            <button type="submit" class="btn btn-warning" id="redondb">
                                                <img src="{{URL::asset('img/edit.png')}}" width="23em" height="23em"
                                                alt="" style="margin-bottom: .1em">
                                            </button>
                                        </form>
                                    @else
                                        <img src="{{URL::asset('/img/espera.png')}}" width="25em" height="25em"
                                        alt="En espera" title="Esperando firma del responsable">
                                    @endif
                                @elseif ($e->tipo == 7)
                                    <img src="{{URL::asset('/img/espera.png')}}" width="25em" height="25em"
                                    alt="En espera" title="En espera de respuesta del COSPIII">
                                @else
                                    <form action="{{ route('revisionobs', [$proyt->id ,$e->id]) }}" method="get">
                                        <button type="submit" class="btn btn-warning" id="redondb">
                                            <img src="{{URL::asset('img/edit.png')}}" width="23em" height="23em"
                                            alt="" style="margin-bottom: .1em">
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @elseif ($e->revisado == 1)
                            @if ($e->tipo <= 2)
                                <form action="{{ route('reporteaceptado',[$proyt->id ,$e->id]) }}" method="get">
                                    <button type="submit" class="btn btn-primary" id="redondb">
                                        <img src="{{URL::asset('img/pdf.png')}}" width="23em" height="23em"
                                        alt="" style="margin-bottom: .1em">
                                    </button>
                                </form>
                            @else
                                @if ( $proyt->aprobo == $LoggedUserInfo['id'])
                                    @if ($e->fobsresponsble == null)
                                        <img src="{{URL::asset('img/espera.png')}}" width="32em" height="32em"
                                        alt="">
                                    @elseif ($e->fobsmando == null && $e->fobsresponsble != null)
                                        <form action="{{ route('revisionobs', [$proyt->id ,$e->id]) }}" method="get">
                                            <button type="submit" class="btn btn-warning" id="redondb">
                                                <img src="{{URL::asset('img/edit.png')}}" width="23em" height="23em"
                                                alt="" style="margin-bottom: .1em">
                                            </button>
                                        </form>
                                    @else
                                        <img src="{{URL::asset('img/aprub.png')}}" width="32em" height="32em"
                                        alt="">
                                    @endif
                                @endif
                            @endif
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