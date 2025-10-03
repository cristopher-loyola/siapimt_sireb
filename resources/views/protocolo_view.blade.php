@extends('plantillas/plantilla2')

@section('contenido')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <h3 class="fw-bold text-center py-5">Información del Proyecto - Protocolo</h3>

    <div>
        <p><strong>Clave Proyecto:</strong> {{$proyt->clavea}}{{$proyt->clavet}}/{{$proyt->clavey}} | {{$proyt->nomproy}}</p>
        <p><strong>Responsable del Proyecto:</strong> {{$user->Nombre}} {{$user->Apellido_Paterno}} {{$user->Apellido_Materno}}</p>
        <p><strong>Director:</strong> {{$director->Nombre}} {{$director->Apellido_Paterno}} {{$director->Apellido_Materno}}</p>
        
        <div class="mt-4">
            <h4><strong>Justificación del Proyecto</strong></h4>
            <div class="ql-editor">{!! $proyt->justificacion !!}</div>

            <h4><strong>Antecedentes</strong></h4>
            <div class="ql-editor">{!! $proyt->antecedente !!}</div>

            <h4><strong>Objetivos</strong></h4>
            <div class="ql-editor">{!! $proyt->objetivo !!}</div>

            <h4><strong>Alcances</strong></h4>
            <div class="ql-editor">{!! $proyt->alcance !!}</div>

            <h4><strong>Metodología</strong></h4>
            <div class="ql-editor">{!! $proyt->metodologia !!}</div>

            <h4><strong>Productos por Obtener</strong></h4>
            <div class="ql-editor">{!! $proyt->producto !!}</div>

            <h4><strong>Compromisos del Cliente</strong></h4>
            <div class="ql-editor">{!! $proyt->comcliente !!}</div>

            <h4><strong>Beneficios Esperados</strong></h4>
            <div class="ql-editor">{!! $proyt->beneficios !!}</div>
        </div>

        <!-- Botón para generar el PDF -->
        <div class="mt-5">
            <form action="{{ route('gprotocolo2', $proyt->id) }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-impact d-inline-flex align-items-center gap-2" id="redondb">
                    Generar Protocolo (PDF)
                </button>
            </form>
        </div>
    </div>
@stop

