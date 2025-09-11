@extends('plantillas/plantillaalt')
@section('contenido')
<title>Participantes de {{$proyt->nomproy}}</title>
{{-- Navegadir nuevas vistta Inicio --}}
<style>
    .sidebar {
        width: 150px;
        height: 100vh;
        background-color: #001F5B;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between; /* Esto distribuye los elementos a lo largo del sidebar */
        padding-top: 20px;
    }

    .sidebar-header {
        margin-bottom: 20px;
    }

    .sidebar-icon {
        width: 80px;
        object-fit: cover;
    }

    /* Alineamos las pestañas al centro */
    .sidebar-menu {
        list-style-type: none;
        padding: 0;
        margin: 0;
        width: 100%;
        display: flex;
        flex-direction: column; /* Alinea las pestañas verticalmente */
        justify-content: center; /* Alinea verticalmente el contenido en el centro */
        align-items: center; /* Alinea los ítems de forma horizontal */
        flex-grow: 1; /* Asegura que las pestañas ocupen el espacio restante */
    }

    .sidebar-item {
        width: 100%;
        text-align: center;
        padding: 10px 0;
        position: relative;
    }

    .sidebar-item a {
        text-decoration: none;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        width: 100%;
    }

    .sidebar-image {
        width: 30px;
        height: 30px;
        object-fit: cover;
        margin-bottom: 5px;
    }


    .sidebar-item-cancel {
        width: 100%;
        text-align: center;
        padding: 10px 0;
        position: relative;
        background: #282828;
    }

    .sidebar-item-cancel a {
        text-decoration: none;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        width: 100%;
    }

    .sidebar-item-success {
        width: 100%;
        text-align: center;
        padding: 10px 0;
        position: relative;
        background: #1e7e19;
    }

    .sidebar-item-success a {
        text-decoration: none;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        width: 100%;
    }

    /* Efecto de iluminación y tooltip */
    .sidebar-item:hover {
        background-color: #143882;
        cursor: pointer;
    }

    .sidebar-item.active {
        background-color: #007bff;
    }

    .sidebar-item.active .tooltip {
        background-color: #007bff;
    }

    .sidebar-item-cancel:hover {
        background-color: #3c3c3c;
        cursor: pointer;
    }

    .sidebar-item-success:hover {
        background-color: #1e7e19;
        cursor: pointer;
    }

    .tooltip {
        position: absolute;
        top: 50%;
        left: 90%;
        height: 170%;
        height: 120%;
        transform: translateY(-50%);
        background-color: #143882;
        padding: 5px;
        border-radius: 3px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s;
        margin-left: 10px;
        z-index: 10;

        /* Centrar el texto dentro del tooltip */
        display: flex;
        align-items: center; /* Centra verticalmente */
        justify-content: center; /* Centra horizontalmente */
    }

    .sidebar-item:hover .tooltip {
        opacity: 1;
    }

    .sidebar-item-success:hover .tooltip {
        opacity: 1;
    }

    .sidebar-item-cancel:hover .tooltip {
        opacity: 1;
    }

    /* Tooltip específico para la pestaña activa */
    .sidebar-item.active:hover .tooltip {
        background-color: #007bff;
        color: white;
    }

    .sidebar-item-success:hover .tooltip {
        background-color: #1e7e19;
        color: white;
    }

    .sidebar-item-cancel:hover .tooltip {
        background-color: #3c3c3c;
        color: white;
    }

    /* Estilo para el botón de logout */
    .logout-btn {
        margin-top: auto;
        padding: 10px 20px;
        background-color: #ff4c4c;
        color: white;
        border: none;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
    }

    .logout-btn:hover {
        background-color: #ff2a2a;
    }

    /* Ajustar a la ventana */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .sidebar-menu {
            padding-left: 20px;
        }

        .sidebar-item a {
            flex-direction: row;
        }

        .sidebar-image {
            margin-bottom: 0;
            margin-right: 10px;
        }
    }


    .custom-checkbox{
        display: none;
    }

    .custom-checkbox-label{
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        font-size: 16px;
        color: #333;
        user-select: none;
    }

    .custom-checkbox-label::before{
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border: 2px solid #007bff;
        border-radius: 4px;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .custom-checkbox:checked + .custom-checkbox-label::before{
        background-color: #00C040;
        border-color: #00C040;
    }

    .custom-checkbox:checked + .custom-checkbox-label::after{
        content: '\2713';
        position: absolute;
        left: 4px;
        top: 2px;
        color: #fff;
        font-size: 12px;
    }

    .custom-checkbox-label:hover::before{
        border-color: #0056b3;
    }

    #no-participantes-texto {
        display: none;
        text-align: center;
        color: red;
        font-weight: bold;
        font-size: 18px;
        margin-top: 14px;
    }

    .btn-disabled {
        cursor: not-allowed;
        border-radius: 25px;
        height:45px;
        background-color: #28a745; 
        border-color: #28a745;
        opacity: 0.65;
    }

    .redondb{
        border-radius: 25px;
        height:45px;
        background-color: #28a745; 
        border-color: #28a745; 
    }
    .redondbr{
        border-radius: 25px;
        height:45px;
    }

</style>
<div class="sidebar">
<div class="sidebar-header">
    <img src="{{asset('/img/Logo_blanco.png')}}" alt="Icono" class="sidebar-icon">
</div>
<ul class="sidebar-menu">
    <li
    @if ($proyt->completado != 0)
        class="sidebar-item-success"
    @else
        class="sidebar-item"
    @endif
    id="item1">
        <a href="{{route('proydatos', $proyt->id)}}" class="sidebar-link">
            <img src="{{asset('/img/info-gnrl.png')}}" alt="Información general" class="sidebar-image">
            <span class="tooltip">Información general</span>
        </a>
    </li>
        @if (($proyt->clavet == 'I' ||$proyt->clavet == 'E') && ($proyt->clavea == 'D' || $proyt->clavea == 'A' || $proyt->clavea == 'G'))            
            <li class="sidebar-item active" id="item3">
                <a  href="{{ route('Equipo', $proyt->id) }}"  class="sidebar-link">
                  <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                  <span class="tooltip">Participantes</span>
              </a>
            </li>
            <li
            @if ($vtarea != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item3">
                <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                    <span class="tooltip">Programa de actividades</span>
                </a>
            </li>
            <li
            @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item5">
                <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                    <span class="tooltip">Propuesta económica</span>
                </a>
            </li>
            <li
            @if ($vriesgo != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item6">
                <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                    <span class="tooltip">Análisis de riesgos</span>
                </a>
            </li>
            <li class="sidebar-item-cancel" id="item7">
                <a href="{{route('infoproys',$proyt->id)}}">
                    <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                    <span class="tooltip">Información del Proyecto</span>
                </a>
            </li>
        @elseif ($proyt->clavet == 'I')
            {{-- Cambiar en las formas de mostrar el impacto --}}
            @if ($proyt->actimpacto == 1)
                <li
                        @if ($vimpacto!= 0)
                            class="sidebar-item-success"
                        @else
                            class="sidebar-item"
                        @endif
                        id="item2">
                            <a href="{{ route('impactoproy', $proyt->id) }}" class="sidebar-link">
                                <img src="{{asset('/img/impactosoceco.png')}}" alt="Plan de actividades" class="sidebar-image">
                                <span class="tooltip">Impacto Socioeconómico</span>
                            </a>
                </li>
            @endif
            <li
            @if ($vcontri != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item3">
                <a @if ($proyt->completado != 0) href="{{ route('contribuciones', $proyt->id)}}" @endif class="sidebar-link">
                    <img src="{{asset('/img/contribuciones.png')}}" alt="Contribuciones a…" class="sidebar-image">
                    <span class="tooltip">Contribuciones a…</span>
                </a>
            </li>
            
            <li class="sidebar-item active" id="item4">
                <a href="{{ route('Equipo', $proyt->id) }}" class="sidebar-link">
                    <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                    <span class="tooltip">Participantes</span>
                </a>
            </li>
            <li
            @if ($vtarea != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item5">
                <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                    <span class="tooltip">Programa de actividades</span>
                </a>
            </li>
            <li
            @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item6">
                <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                    <span class="tooltip">Propuesta económica</span>
                </a>
            </li>
            <li
            @if ($vriesgo != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item7">
                <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                    <span class="tooltip">Análisis de riesgos</span>
                </a>
            </li>
            <li class="sidebar-item-cancel" id="item7">
                <a href="{{route('infoproys',$proyt->id)}}">
                    <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                    <span class="tooltip">Información del Proyecto</span>
                </a>
            </li>
        @else
            <li
            @if ($vcontri != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item2">
                <a href="{{ route('contribuciones', $proyt->id)}}" class="sidebar-link">
                    <img src="{{asset('/img/contribuciones.png')}}" alt="Contribuciones a…" class="sidebar-image">
                    <span class="tooltip">Contribuciones a…</span>
                </a>
            </li>
            
            <li class="sidebar-item active" id="item3">
                <a href="{{ route('Equipo', $proyt->id) }}" class="sidebar-link">
                    <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                    <span class="tooltip">Participantes</span>
                </a>
            </li>
            <li
            @if ($vtarea != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item4">
                <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                    <span class="tooltip">Programa de actividades</span>
                </a>
            </li>
            <li
            @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item5">
                <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                    <span class="tooltip">Propuesta económica</span>
                </a>
            </li>
            <li
            @if ($vriesgo != 0)
                class="sidebar-item-success"
            @else
                class="sidebar-item"
            @endif
            id="item6">
                <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                    <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                    <span class="tooltip">Análisis de riesgos</span>
                </a>
            </li>
            <li class="sidebar-item-cancel" id="item7">
                <a href="{{route('infoproys',$proyt->id)}}">
                    <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                    <span class="tooltip">Información del Proyecto</span>
                </a>
            </li>
        @endif
    </ul>
</div>
{{-- Navegadir nuevas vistta Fin --}}

   <div><h4 class="fw-bold text-center py-5" id="tituloform"> Participantes
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
        <div class="row align-items-center">
            <div class="col-md-3">
                <div>
                    @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                    <a href="{{ route('addequipos', $proyt->id)}}">
                        <button type="submit" class="btn btn-success redondb" id="botonsito">
                            <img src="{{asset('/img/plus.png')}}" width="25px" height="25px" alt="">
                            Nuevo Participante
                        </button>
                    </a>
                    @endif
                </div>
            </div>
            @if ($equipos->count() == 0)
            <div class="">
                <input type="checkbox" class="custom-checkbox" id="sinColaboradores" data-id="{{$proyt->id}}"
                    {{$proyt->colaboradores == 1 ? 'checked' : ''}}>
                <label for="sinColaboradores" class="custom-checkbox-label">
                    Sin participantes
                    <span title="Seleccionar en caso de no contar con participantes">
                        <img src="{{asset('/img/info-circle.png')}}" alt="info">
                    </span>
                </label>
            </div>
            @endif
        </div>
    </div>

    <div> 
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="">No</th>
                    <th scope="col" class="">Apellido Paterno</th>
                    <th scope="col" class="">Apellido Materno</th>
                    <th scope="col" class="">Nombre</th>
                    @if ($proyt->estado == 1 || $proyt->estado == 4 || $proyt->estado == 0)
                        <th scope="col" class="">Eliminar</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($equipos as $e)
                <tr>
                    <td scope="row"></td>
                    <td>{{ $e->Apellido_Paterno }}</td>
                    <td>{{ $e->Apellido_Materno }}</td>
                    <td>{{ $e->Nombre }}</td>
                    @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                    <td>
                        <form action="{{ route('destroyequipo',[$proyt->id, $e->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger redondbr">
                                <img src="{{asset('/img/trash_alt.png')}}" width="22px" height="22px" alt="">
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        <div id="no-participantes-texto">
            No hay participantes
        </div>
    </div>


            <style>
                #actualizar{
                    background: #1e8719;
                    color: #fff;
                    border-radius: 5px;
                    display: inline-flex;
                    justify-content: center;
                    align-items: center;
                    border: 1px solid transparent;
                    padding: .4em;
                }
                #actualizar:hover{
                    background: #219d1a;
                    transform: scale(1.1); /* Aumenta el tamaño del botón */
                }
            </style>
            
            {{-- <div>
                <a href="{{ route('infoproys', $proyt->id)}}">
                    <button type="submit" id="actualizar">
                        <img src="{{asset('/img/back.png')}}" width="25px" height="25px" alt="">
                        &nbsp;Finalizar&nbsp;
                    </button>
                </a>
            </div> --}}
        </div>
        <br>

        <br>
</div>
@stop
@push('scripts')
<script>
    $(document).ready(function() {
        var isChecked = {{ $proyt->colaboradores == 1 ? 'true' : 'false' }};
        var particip = $('#participantes-lista tr')

        if (isChecked) {
            $('#sinColaboradores').prop('checked', true);
            $('#no-participantes-texto').show();
            $('#botonsito').addClass('btn-disabled').removeClass('redondb');
            $('#botonsito').attr('disabled', true);
        } else {
            $('#sinColaboradores').prop('checked', false);
            $('#no-participantes-texto').hide();
            $('#botonsito').removeClass('btn-disabled').addClass('redondb');
            $('#botonsito').attr('disabled', false);
        }

        $('#sinColaboradores').on('change', function() {
            var colaboradores = $(this).prop('checked') == true ? 1 : 0;
            var proyId = $(this).data('id');

            if ($(this).prop('checked')) {
                $('#no-participantes-texto').show();
                $('#botonsito').addClass('btn-disabled').removeClass('redondb');
                $('#botonsito').attr('disabled', true);
            } else {
                $('#no-participantes-texto').hide();
                $('#botonsito').removeClass('btn-disabled').addClass('redondb');
                $('#botonsito').attr('disabled', false);
            }

            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '{{ route('sinColab') }}', 
                data: {
                    'colaboradores': colaboradores,
                    'proyId': proyId
                },
                success: function(data) {
                    if(data.reload) {
                        location.reload();
                    }
                }
            });
        });
    });


</script>
@endpush