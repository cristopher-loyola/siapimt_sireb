@extends('plantillas/plantillaFormP')
@section('contenido')
<title>Agregar Recurso para el proyecto</title>
        <h3 class="fw-bold text-center py-5">Agregar Recurso para el proyecto</h3>
        {{--Inicio del Login o Acceso --}}
            <form action="{{ route('addrecursoproy', $proyt->id)}}" method="POST">
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
            <div class="mb-4">
                <label class="form-label"> Recurso </label>
                    <select name="resc" id="resc" class="form-control" value="{{old('resc')}}" onchange="calcularCosto()">
                        <option value="Inicio">Seleccione un recurso</option>
                        @foreach ($resc as $res)
                            <option value="{{ $res->id }}" data-costo="{{ $res->costo }}">{{$res->partida.' | '.$res->concepto.' | '.$res->clave}}</option>
                        @endforeach
                    </select>
                <span class="text-danger">@error('resc') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <div id="campoOculto" style="display: none">
                    <label class="form-label"> Costo/Hr </label>
                    <input id="costo" type="number" class="form-control" name="costo" value="{{old('costo')}}" placeholder="" oninput="multiplicar()" readonly>
                    <span class="text-danger">@error('costo') {{$message}} @enderror</span>
                    <br>
                    <label class="form-label"> Horas trabajadas</label>
                    <input id="horas" type="number" step="1" class="form-control" name="horas" value="0" placeholder="" oninput="multiplicar()">
                    <span class="text-danger">@error('horas') {{$message}} @enderror</span>
                    <br>
                </div>
                <label class="form-label"> Cantidad ($) </label>
                <input id="cant" type="number" step="any" class="form-control" name="cant" value="{{old('cant')}}" placeholder="">
                <span class="text-danger">@error('cant') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{route('recursosproy',$proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb">
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

    <script>
        function multiplicar() {
            // Obtener los valores de los campos
            let num1 = parseFloat(document.getElementById("costo").value);
            let num2 = parseFloat(document.getElementById("horas").value);

            const vesp = document.getElementById('cant');

            if (!isNaN(num1) && !isNaN(num2)) {
                let resultado = num1 * num2;
                resultado = resultado.toFixed(2);
                document.getElementById("cant").value = resultado;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.getElementById('resc');
            var miDiv = document.getElementById('campoOculto');
            var miDiv2 = document.getElementById('campoOriginal');

            const inputCosto = document.getElementById('costo');
                
            selectElement.addEventListener('change', function() {
                var selectValue = this.value;
                // Asegúrate de que el valor que estás comprobando sea el correcto
                if (selectValue == '77' || selectValue == '78' || selectValue == '79') {  // Cambia '2' por el valor que necesites
                    const costo = selectElement.options[selectElement.selectedIndex].getAttribute('data-costo');
                    inputCosto.value = costo;
                    miDiv.style.display = 'block';
                    miDiv2.style.display = 'none';
                } else {
                    miDiv.style.display = 'none';
                    miDiv2.style.display = 'block';
                }
            });
        });
    </script>
@endsection