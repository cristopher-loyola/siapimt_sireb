@extends('plantillas/plantillaForm2')
@section('contenido') 
<title>Actualizar Cliente o Usuario Potencial</title>
        <h3 class="fw-bold text-center py-5">Actualizar Cliente o Usuario Potencial</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{ route('upclis', $cli->id) }}" method="POST">
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
                <label class="form-label"> Nivel 1 </label>
                <input id="nivel1" type="text" class="form-control" name="nivel1" placeholder="Valor 1" value="{{$cli->nivel1}}"" maxlength="7" style="text-transform:uppercase" onkeyup="javascript:this.value=this.value.toUpperCase();">
                <span class="text-danger">@error('nivel1') {{$message}} @enderror</span>
            </div> 
            <div class="mb-4">
                <label class="form-label"> Nivel 2  </label>
                <input id="nivel2" type="text" class="form-control" name="nivel2" placeholder="Valor 2" value="{{$cli->nivel2}}">
                <span class="text-danger">@error('nivel2') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Nivel 3 </label>
                <input id="nivel3" type="text" class="form-control" name="nivel3" placeholder="Valor 3" value="{{$cli->nivel3}}">
                <span class="text-danger">@error('nivel3') {{$message}} @enderror</span></div>
            <div>
                <a href="{{route('indexcliente')}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
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