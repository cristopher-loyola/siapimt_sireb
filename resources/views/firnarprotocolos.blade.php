@extends('plantillas/plantilla2')
@section('contenido')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #inputsContainer{
        background: #e7e7e7b2;
        width: 800px;
        padding: 25px;
    }
</style>
<title> Proyecto</title>
<div>
    <h3 class="fw-bold text-center py-5" id="tituloform">Protocolo / Propuesta Técnico-Económica por Autorizar</h3>
<div>
<div>
    <a href="{{ route('cancelcrud')}}">
        <button type="submit" class="btn btn-dark btn-lg" id="redondb">
            <i class='bx bxs-chevron-left-circle bx-sm bx-flashing-hover'></i>
            <i class='bx  bxs-home bx-sm bx-flashing-hover'></i>
        </button>
    </a>
</div>
<br>

<div style="margin-bottom: 15px; display: block; text-align: right;">
    <button onclick="mostrarInputs2()" class="btn btn-primary" id="mostrarInputs2" type="button">Firmar</button>
</div>
<div>
    <form id="formSeleccionados" method="POST" action="{{route('firmartodosdg')}}">
        @csrf
        <table class="table table-hover table-sm table-responsive-sm">
            <thead class="thead-dark">
                <tr>
                    <th><input type="checkbox" id="checkAll" class="form-control"></th>
                    <th scope="col" style="width: 5rem;">Clave</th>
                    {{-- <th scope="col">Id del Protocolo</th> --}}
                    <th scope="col">Nombre</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Área</th>
                    {{-- <th scope="col">Responsable</th>
                    <th scope="col">Protocolo</th>
                    <th scope="col">Firma de Responsable</th>
                    <th scope="col">Firma de Coordinador/Jefe</th>
                    <th scope="col">Firma Director General</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($proyt as $pr)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $pr->id }}" class="form-control"></td>
                        <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
                        else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
                        ?>
                        <td><a href="{{ route('infoproys', $pr->idproyecto)}}">{{$pr->nomproy}}</a></td>
                        <td>
                            {{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}
                        </td>
                        <td>
                            {{$pr->nombre_area}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="display: block; text-align: right;">
            <button onclick="mostrarInputs()" class="btn btn-primary" id="showmost" type="button">Firmar</button>
        </div>
        <div style="display: grid; place-items: center;">
            <div style="height: 50px; display: none;" id="spacecontainer">
            </div>
            <div style="display: none" id="inputsContainer">
                <div class="mb-4">
                    <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
                        Firma electrónica institucional
                    </p>
                    <input type="file" id="archivo" name="archivo" class="form-control">
                    <textarea id="datofichero" name="datofichero" class="form-control" hidden></textarea>
                    <span class="text-danger">@error('archivo') {{$message}} @enderror</span>
                </div>
                <div class="mb-4">
                    <p style="font-size: 1.3em; font-weight: 500; text-align:justify;">
                        Contraseña
                    </p>
                    <input type="password" id="pass" name="pass" class="form-control">
                    <span class="text-danger">@error('pass') {{$message}} @enderror</span>
                </div>
                <button type="submit" class="btn btn-success" id="firmarsubmit">Firmar</button>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#checkAll').click(function() {
        $('input[name="ids[]"]').prop('checked', this.checked);
    });
</script>
<script>
     document.getElementById('archivo').onchange = function () {
        document.getElementById('datofichero').innerHTML = document.getElementById('archivo').files[0].name;
    };

    function mostrarInputs() {
        const container = document.getElementById('inputsContainer');
        const most = document.getElementById('showmost');
        const space = document.getElementById('spacecontainer');
        container.style.display = 'block';
        space.style.display = 'block';
        most.style.display = 'none';
    };

    function mostrarInputs2() {
        const container = document.getElementById('inputsContainer');
        const most = document.getElementById('showmost2');
        const space = document.getElementById('spacecontainer');
        container.style.display = 'block';
        space.style.display = 'block';
        most.style.display = 'none';
    };
</script>
@stop
@push('scripts')
@endpush