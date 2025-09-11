    @extends('plantillas/plantillaFormP')

    @section('contenido') 
    <title>Nuevo Participante del Equipo</title>
    <h3 class="fw-bold text-center py-5">Nuevo participante del Equipo</h3>

    <form action="{{ route('addequipo', $proyt->id)}}" method="POST">
        @if (Session::has('success'))
            <div class="alert-success">{{Session::get('success')}}</div>
            <br>
        @endif
        @if (Session::has('fail'))
            <div class="alert-danger">{{Session::get('fail')}}</div>
            <br>
        @endif
        @csrf
        <div class="mb-4">
            <input id="idproy" type="number" class="form-control" name="idproy" value="{{$proyt->id}}" hidden>
            <span class="text-danger">@error('idproy') {{$message}} @enderror</span>
        </div>

        <label>Participante</label>
        <div style="height: 10px"></div>
        <div class="mb-4">
            <select name="usuarios" id="usuarios" class="form-control">
                <option value="">Selecciona un participante</option>
                @foreach ($users as $usu)
                    @if ($usu->idarea == $proyt->idarea)
                        <option value="{{$usu->id}}" data-area="{{$usu->idarea}}">
                            {{$usu->Apellido_Paterno.' '.$usu->Apellido_Materno.' '.$usu->Nombre}}
                        </option> 
                    @endif
                @endforeach
            </select>
            <span class="text-danger">@error('usuarios') {{$message}} @enderror</span>
        </div>
        
        <div>
            <a href="{{ route('Equipo', $proyt->id)}}" class="btn btn-danger" tabindex="4" id="redondb">
                <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
                Cancelar
            </a>
            &nbsp; &nbsp; &nbsp;
            <button type="submit" class="btn btn-primary" tabindex="5" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
                Agregar
            </button>
        </div>
    </form>

    @endsection

