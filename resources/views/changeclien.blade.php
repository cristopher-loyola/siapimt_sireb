@extends('plantillas/plantillaForm4')
@section('contenido')
<style>
    .center{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    #regresar{
        background: #ee3d3d;
        color: #fff;
        border-radius: 25mm;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border: 1px solid transparent;
        padding: .4em;
    }
    #regresar:hover {
        background-color: #d53b3b; /* Cambia el color de fondo */
        transform: scale(1.1); /* Aumenta el tamaño del botón */
    }
</style>
<title>Actualizar Proyecto</title>
    <div class="row align-items-stretch">
    {{-- <div class="col bg rounded d-none d-lg-block col-md-5 col-lg-5 col-xl-6" id="bgimg">
    </div> --}}
        <h3 class="fw-bold text-center py-5" id="tituloform">Actualizar el cliente</h3>
        {{--Inicio de Nuevo Proyecto --}}
        <form action="{{ route('changeclien', $proyt->id) }}" method="POST">
                @if(Session::has('success'))
                    <div class="alert-success">{{Session::get('success')}}</div>
                    <br>
                @endif
                @if (Session::has('fail'))
                    <div class="alert-danger">{{Session::get('fail')}}</div>
                    <br>
                @endif
            @csrf
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <x-select-client label="Cliente o Usuario potencial" nameField='userpot' :categories="$categoriesN1" :cliente="$clis" :categoriesN2="$categoriesN2" :categoriesN3="$categoriesN3"/>
                    <span class="text-danger">@error('userpot') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <button type="button" id="regresar">
                        &nbsp;
                        <a href="{{ route('proydatos4', $proyt->id)}}" style="text-decoration: none; color:#ffffff">
                            <img src="../img/return.png" width="22px" height="22px" alt="">
                            &nbsp;
                            Cancelar
                        </a>
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-warning" id="redond">
                        <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
                        Actualizar
                    </button>
                </div>
            </div>
        </form>
    </div>
    {{-- Fin de Nuevo Proyecto --}}
        <br>
    </div>
</div>
@stop
@push('scripts')
@endpush