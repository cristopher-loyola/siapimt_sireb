@extends('plantillas/plantillaForm2')
@section('contenido') 
<title>Actualizar Usuario</title>
 
        <h3 class="fw-bold text-center py-5">Actualizar Usuario</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{ route('upuser', $user->id)}}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label"> Nombre</label>
                <input id="nombre" type="text" class="form-control" name="name" value="{{$user->Nombre}}">
            </div> 
            <div class="mb-4">
                <label class="form-label"> Apellido Paterno </label>
                <input id="nombre" type="text" class="form-control" name="appat" value="{{$user->Apellido_Paterno}}">
            </div> 
            <div class="mb-4">
                <label class="form-label"> Apellido Materno </label>
                <input id="nombre" type="text" class="form-control" name="apmat" value="{{$user->Apellido_Materno}}">
            </div>
            <div class="mb-4">
                <label class="form-label"> Curp </label>
                <input id="curp" type="text" class="form-control" name="curp" value="{{$user->curp}}">
            </div>
            <div class="mb-4">
                <label class="form-label"> Correo </label>
                <input id="correo" type="text" class="form-control" name="correo" value="{{$user->correo}}">
            </div>
            <div class="mb-4">
                <label class="form-label">Area de adscripción &nbsp;&nbsp;</label>
                <select name="areas" id="areas" class="form-control">
                    <option value="{{$user->idarea}}">{{$areass->nombre_area}}</option>
                    @foreach ($areas as $area)
                        <option id="formao" value="{{ $area->id }}">{{$area->nombre_area}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('areas') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Puesto </label>
                <select name="puesto" id="puesto" class="form-control">
                    <option value="{{$user->idpuesto}}">{{$puestos->puesto}}</option>
                    @foreach ($puesto as $pues)
                        <option value="{{ $pues->id }}">{{$pues->puesto}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('puesto') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Usuario </label>
                <input id="nombre" type="text" class="form-control" name="usuario" value="{{$user->usuario}}">
            </div> 
            <div class="mb-4">
                <label class="form-label"> Contraseña </label>
                <input id="nombre" type="text" class="form-control" name="pass" value="{{$pass}}">
            </div> 
            <div class="mb-4">
                <label class="form-label"> Tipo de Usuario (Acceso) </label>
                <select name="tacces" id="tacces" class="form-control">
                    <option value="{{$user->acceso}}">{{$acces->nom_acceso}}</option>
                    @foreach ($access as $acce)
                        <option value="{{ $acce->id }}">{{$acce->nom_acceso}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('tacces') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> ¿Es el director general? </label>
                <select name="esdg" id="esdg" class="form-control">
                    @if ($user->director == 1)
                        <option value="1">Si</option>
                    @else
                        <option value="0">No</option>
                    @endif
                    <option value=""> Selecciona una respuesta </option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
                <span class="text-danger">@error('esdg') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> ¿Es el Presidente COSPIII? </label>
                <select name="espd" id="espd" class="form-control">
                    @if ($user->pcospii == 1)
                        <option value="1">Si</option>
                    @else
                        <option value="0">No</option>
                    @endif
                    <option value=""> Selecciona una respuesta </option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
                <span class="text-danger">@error('espd') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{route('userAdmin')}}" class=" btn btn-danger" tabindex="4" id="redond"> 
                    <i class='bx bxs-tag-x'></i>
		     Cancelar
                </a> 
                <button type="submit" class="btn btn-warning" tabindex="5" id="redond">
                    <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
                    Actualizar
                </button>
            </div>
            </form>
        {{--Inicio del Login o Acceso --}}

@endsection
