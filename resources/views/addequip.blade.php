    @extends('plantillas/plantillaFormP')

    @section('contenido') 
    <title>Nuevo Participante del Equipo</title>
    <h3 class="fw-bold text-center py-5">Nuevo Participante del Equipo</h3>

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
        
        <label>Área</label>
        <div style="height: 5px"></div>
        <div class="mb-4">
            <select name="areas" id="areas" class="form-control">
                <option value="">Selecciona el Área</option>  
                @foreach ($areas as $area)
                    <option value="{{$area->id}}" data-area="{{$area->inicial_clave}}">
                        {{$area->nombre_area.' | '.$area->inicial_clave}}
                    </option>
                @endforeach
            </select>
            <span class="text-danger">@error('areas') {{$message}} @enderror</span>
        </div>

        <label>Participante</label>
        <div style="height: 10px"></div>
        <div class="mb-4">
            <select name="usuarios" id="usuarios" class="form-control">
                <option value="">Selecciona un participante</option> 
            </select>
            <span class="text-danger">@error('usuarios') {{$message}} @enderror</span>
        </div>

{{--DE ACUERDO AL ÁREA QUE SELECCIONO EN EL DE ARRIBA SE PASA AL DE USUARIOS PARA QUE SOLO MUESTRE LOS DEL ÁREA PARA PROYECTOS 'M'--}}
        <script>
            document.getElementById('areas').addEventListener('change', function() {
                let areaId = this.value;  
                let usuariosSeleccionado = document.getElementById('usuarios');
                
                usuariosSeleccionado.innerHTML = '<option value="">Selecciona nuevo miembro del Equipo</option>';
                
                @foreach ($users as $usu)
                    if (areaId == {{$usu->idarea}}) {
                        let option = document.createElement('option');
                        option.value = {{$usu->id}};
                        option.textContent = '{{$usu->Apellido_Paterno}} {{$usu->Apellido_Materno}} {{$usu->Nombre}}';
                        usuariosSeleccionado.appendChild(option);
                    }
                @endforeach
            });
        </script>
        <div style="height: 10px"></div>
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

