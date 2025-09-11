@extends('plantillas/plantillaFormRiesgo')
@section('contenido')
<title>
    Nuevo Riesgo
    @if ($tipor == 1)
        Interno
    @else
        Externo
    @endif
</title>

<script>
    // Función para realizar la multiplicación
    function multiplicar() {
        // Obtener los valores de los campos
        let num1 = parseFloat(document.getElementById("probly").value);
        let num2 = parseFloat(document.getElementById("impact").value);

        const vesp = document.getElementById('vesp');
        const calf = document.getElementById('calf');
        const rriesgo = document.getElementById('rriesgo');
        const acciones = document.getElementById('acciones');
        const accion = document.getElementById('accion');

        const vesplab = document.getElementById('vesplab');
        const calflab = document.getElementById('calflab');
        const rriesgolab = document.getElementById('rriesgolab');

        if (!isNaN(num1) && !isNaN(num2)) {
            let resultado = num1 * num2;
            // resultado = Math.round(resultado * 100) / 100;
            resultado = resultado.toFixed(4);
            document.getElementById("vesp").value = resultado;
            document.getElementById("vesplab").value = resultado;

            if (0 <= resultado && resultado < 0.07) {
                calf.value = 'Prioridad baja';
                calflab.value = 'Prioridad baja';
                rriesgo.value = 'Aceptación pasiva';
                rriesgolab.value = 'Aceptación pasiva';
                if (acciones.style.display === 'block'){
                    acciones.style.display = 'none';
                    accion.value = '';
                }
            } else if (0.08 <= resultado && resultado <= 0.18) {
                calf.value = 'Prioridad media';
                calflab.value = 'Prioridad media';
                rriesgo.value = 'Aceptación pasiva';
                rriesgolab.value = 'Aceptación pasiva';
                if (acciones.style.display === 'block'){
                    acciones.style.display = 'none';
                    accion.value = '';
                }
            } else if (0.19 <= resultado && resultado < 1.00){
                calf.value = 'Prioridad alta';
                calflab.value = 'Prioridad alta';
                rriesgo.value = 'Aceptación activa';
                rriesgolab.value = 'Aceptación activa';
                if (acciones.style.display === 'none' || acciones.style.display === '') {
                    acciones.style.display = 'block';
                }
            }
        } else {
            document.getElementById("vesp").value = "";
            calf.value = 'Por favor, ingresa un número válido.';
        }
    }


    function mostrar() {
        const mostrar = document.getElementById('mostrar');
        const ocultar = document.getElementById('ocultar');
        const tabla = document.getElementById('tabla');
        mostrar.style.backgroundColor = "gray";
        mostrar.disabled = false;
        tabla.style.display = 'block';
        ocultar.style.backgroundColor = "#d31515"
    }

    function ocultar() {
        const ocultar = document.getElementById('ocultar');
        const mostrar = document.getElementById('mostrar');
        const tabla = document.getElementById('tabla');
        ocultar.style.backgroundColor = "gray";
        ocultar.disabled = false;
        tabla.style.display = 'none';
        mostrar.style.backgroundColor = "#129312"
    }

    document.addEventListener('DOMContentLoaded', function() {
        var selectElement = document.getElementById('risk');
        var miDiv = document.getElementById('campoOculto');
                
        selectElement.addEventListener('change', function() {
            var selectValue = this.value;
            if (selectValue == '3') {  // Cambia '2' por el valor que necesites
                miDiv.style.display = 'block';
            } else {
                miDiv.style.display = 'none';
            }
        });
    });
    
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var selectElement = document.getElementById('risk');
    const inputCosto = document.getElementById('accion');
        selectElement.addEventListener('change', function() {
            var selectValue = this.value;
            const costo = selectElement.options[selectElement.selectedIndex].getAttribute('data-extra');
            inputCosto.value = costo;
        });
    });
</script>
        <h3 class="fw-bold text-center py-5">
            Nuevo Riesgo
            @if ($tipor == 1)
                Interno
            @else
                Externo
            @endif
        </h3>
        {{--Inicio--}}
            <form action="{{ route('addriesgosave', $proyt->id)}}" method="POST">
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
                <label class="form-label"> Tipo de riesgo </label>
                <input type="text" name="trisk" id="trisk" class="form-control" value="{{$tipor}}" hidden>
                <select name="trisksh" id="trisksh" class="form-control" value="{{old('trisksh')}}" disabled>
                    @if ($tipor == 1)
                        <option value="1">Interno</option>
                    @else
                        <option value="2">Externo</option>
                    @endif
                </select>
                <span class="text-danger">@error('trisk') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Riesgo </label>
                <select name="risk" id="risk" class="form-control">
                    <option value="">Selecciona un riesgo</option>
                    @foreach ($listriesk as $list)
                        <option value="{{$list->id}}" title= "{{$list->tiporiesgo}}" data-extra="{{$list->resprisk}}">
                            {{ \Illuminate\Support\Str::limit($list->tiporiesgo, 150, '...') }}
                        </option>
                    @endforeach
                </select>
                <br>
                <input id="campoOculto" type="text" class="form-control" name="riskotro" value="{{old('riskotro')}}"
                placeholder="" style="display: none">
            </div>
            <style>
                #tabla {
                    text-align: center;
                }
                #ocultar{
                    background: gray;
                    color: rgb(255, 255, 255);
                    font-weight: 500;
                }
                #mostrar{
                    background: #129312;
                    color: rgb(255, 255, 255);
                    font-weight: 500;
                }
            </style>
            <div class="mb-4">
                <label class="form-label"> Probabilidad </label>
                {{-- <input id="probly" type="number" class="form-control" name="probly" value="{{old('probly')}}" min="0" max="1"
                placeholder="El rango de los valores es de 0 al 1 (Ejemplo: 0.5)" min="0" max="1" step="0.05" oninput="multiplicar()"> --}}
                <select id="probly" class="form-control" name="probly" oninput="multiplicar()">
                    <option value="selecciona">Selecciona una probabilidad</option>
                    <option value="0.1">0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.2">0.3</option>
                    <option value="0.4">0.4</option>
                    <option value="0.5">0.5</option>
                    <option value="0.6">0.6</option>
                    <option value="0.7">0.7</option>
                    <option value="0.8">0.8</option>
                    <option value="0.9">0.9</option>
                    <option value="1">1</option>
                </select>
                <span class="text-danger">@error('probly') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label">Indicador numérico del impacto</label>
            </div>
            <div style="text-align: center">
                <a class="btn" onclick="mostrar()" id="mostrar">Mostrar</a>
                <a class="btn" onclick="ocultar()" id="ocultar">Ocultar</a>
            </div>
            <br>
            <div id="tabla" style="display: none">
                <img src={{asset('/img/tabla_riesgos.png')}} alt="tabla de riesgos" width="80%">
            </div>
            <div class="mb-4">
                <label class="form-label"> Impacto </label>
                {{-- <input id="impact" type="number" class="form-control" name="impact" value="{{old('impact')}}"
                placeholder="El rango de los valores es de 0 a1 1" min="0" max="1" step="0.05" oninput="multiplicar()"> --}}
                <select id="impact" class="form-control" name="impact" oninput="multiplicar()">
                    <option value="selecciona">Selecciona un valor de impacto</option>
                    <option value="0.05">0.05</option>
                    <option value="0.1">0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.4">0.4</option>
                    <option value="0.8">0.8</option>
                </select>
                <span class="text-danger">@error('impact') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Valor Esperado (VE) </label>
                <input id="vesplab" type="text" class="form-control" name="vesplab" value="" disabled>
                <input id="vesp" type="text" class="form-control" name="vesp" value="" style="display: none">
                <span class="text-danger">@error('vesp') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Calificación </label>
                <input id="calflab" type="text" class="form-control" name="calflab" value="" disabled>
                <input id="calf" type="text" class="form-control" name="calf" value="" style="display: none"
                placeholder="">
                <span class="text-danger">@error('calf') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Respuesta al riesgo </label>
                <input id="rriesgolab" type="text" class="form-control" name="rriesgolab" value="" disabled>
                <input id="rriesgo" type="text" class="form-control" name="rriesgo" value="" style="display: none"
                placeholder="">
                <span class="text-danger">@error('rriesgo') {{$message}} @enderror</span>
            </div>
            <div class="mb-4" style="display: none" id="acciones">
                <label class="form-label"> Acciones </label>
                <textarea name="accion" id="accion" rows="5" class="form-control"></textarea>
                <span class="text-danger">@error('accion') {{$message}} @enderror</span>
            </div>
            {{-- <div class="mb-4">
                <label class="form-label"> Fecha probable de ocurrencia </label>
                <input id="ocurd" type="date" class="form-control" name="ocurd" value="{{old('ocurd')}}"
                placeholder="">
                <span class="text-danger">@error('ocurd') {{$message}} @enderror</span>
            </div> --}}
            <div class="mb-4">
                <label class="form-label"> Etapa probable de ocurrencia </label>
                <select name="probcurrent" id="probcurrent" class="form-control">
                    <option value="">Selecciona una opción</option>
                    @foreach ($ocurrent as $ocurr)
                        <option value="{{$ocurr->id}}">{{$ocurr->nombre_ocurrencia}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('probcurrent') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{ route('ariesgo', $proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		            Cancelar
                </a>
                <button type="submit" class="btn btn-primary" tabindex="5" id="redondb">
                    <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
                    Agregar
                </button>
            </div>
            </form>

        {{--Fin--}}
@endsection
@push('scripts')
@endpush