@extends('plantillas/plantillaForm')
@section('contenido') 
<title>Nuevo Usuario</title>

        <h3 class="fw-bold text-center py-5">Nuevo Usuario</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="adduser" method="POST">
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
                <label class="form-label"> Nombre</label>
                <input id="nombre" type="text" class="form-control" name="name" placeholder="Nombre" value="{{old('name')}}">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Apellido Paterno </label>
                        <input id="nombre" type="text" class="form-control" name="appat" placeholder="Apellido Paterno" value="{{old('appat')}}">
                        <span class="text-danger">@error('appat') {{$message}} @enderror</span>
                    </div>
                    <div class="mb-2">
                        &nbsp;&nbsp;
                    </div>
                    <div class="mb-4 col" >
                        <label class="form-label"> Apellido Materno </label>
                        <input id="nombre" type="text" class="form-control" name="apmat" placeholder="Apellido Materno" value="{{old('apmat')}}">
                        <span class="text-danger">@error('apmat') {{$message}} @enderror</span>
                    </div>
                </div>
            </div>
            <div class="mb-4 col">
                <label class="form-label">Correo del usuario</label>
                <input id="correo" type="text" class="form-control" name="correo" placeholder="Correo" value="{{old('apmat')}}">
                <span class="text-danger">@error('areas') {{$message}} @enderror</span>
            </div>
            <div class="mb-4 col">
                <label class="form-label">Curp del usuario</label>
                <input id="curp" type="text" class="form-control" name="curp" placeholder="Curp" value="{{old('apmat')}}">
                <span class="text-danger">@error('areas') {{$message}} @enderror</span>
            </div>
            <div class="mb-4 col">
                <label class="form-label">Area de adscripción</label>
                <select name="areas" id="areas" class="form-control" value="{{old('areas')}}">
                    <option value="Inicio">Seleccione un Area</option>
                    @foreach ($areas as $area)
                        <option id="formao" value="{{ $area->id }}">{{$area->nombre_area}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('areas') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Acceso </label>
                <select name="tacces" id="tacces" class="form-control">
                    <option value="dato">Presiona para cambiar el acceso</option>
                    @foreach ($access as $acce)
                        <option value="{{ $acce->id }}">{{$acce->nom_acceso}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('tacces') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> Puesto </label>
                <select name="puesto" id="puesto" class="form-control">
                    <option value="dato">Presiona para cambiar el Puesto</option>
                    @foreach ($puesto as $pues)
                        <option value="{{ $pues->id }}">{{$pues->puesto}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('puesto') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> Usuario </label>
                <input id="nombre" type="text" class="form-control" name="usuario" placeholder="Usuario" value="{{old('usuario')}}">
                <span class="text-danger">@error('usuario') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> Contraseña </label>
                <input id="nombre" type="text" class="form-control" name="pass" placeholder="Contraseña" value="{{old('pass')}}">
                <span class="text-danger">@error('pass') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{route('userAdmin')}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		            Cancelar
                </a>
                <button type="submit" class="btn btn-primary" tabindex="5" id="redondb">
                    <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
                    Agregar
                </button>
            </div>
            </form>
        {{--Inicio del Login o Acceso --}}  

@endsection