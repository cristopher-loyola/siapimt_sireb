@extends('plantillas/plantillaFormRiesgo')
@section('contenido') 
<title>Actualizar Riesgo</title>
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

    // document.addEventListener('DOMContentLoaded', function() {
    //     var selectElement = document.getElementById('risk');
    //     var miDiv = document.getElementById('campoOculto');
                
    //     selectElement.addEventListener('change', function() {
    //         var selectValue = this.value;
    //         if (selectValue == '3') {  // Cambia '2' por el valor que necesites
    //             miDiv.style.display = 'block';
    //         } else {
    //             miDiv.style.display = 'none';
    //         }
    //     });
    // });
</script>
        <h3 class="fw-bold text-center py-5">Actualizar Riesgo</h3>
        {{--Inicio--}}
            <form action="{{ route('upriesgosave', $riesgos->id)}}" method="POST">
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
                <input id="idproy" type="number" class="form-control" name="idproy" value="{{$riesgos->idproyecto}}" hidden>
                <span class="text-danger">@error('idproy') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <input id="idregis" type="number" class="form-control" name="idregis" value="{{$riesgos->id}}" hidden>
                <span class="text-danger">@error('idregis') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Tipo de riesgo </label>
                <input type="text" name="trisk" id="trisk" class="form-control" value="{{$riesgos->tiporiesgo}}" hidden>
                <select name="trisksh" id="trisksh" class="form-control" value="{{old('trisksh')}}" disabled>
                    <option value="{{$riesgos->tiporiesgo}}">
                        @if ($riesgos->tiporiesgo = 1)
                            Interno
                        @else
                            Externo
                        @endif
                    </option>
                </select>
                <span class="text-danger">@error('trisk') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Riesgo </label>
                <select name="risk" id="risk" class="form-control">
                    <option value="{{$riskesp->id}}">{{$riskesp->tiporiesgo}}</option>
                    <option value="">Selecciona un riesgo</option>
                    @foreach ($listriesk as $list)
                        <option value="{{$list->id}}">{{$list->tiporiesgo}}</option>
                    @endforeach
                </select>
                <br>
                <input id="campoOculto" type="text" class="form-control" name="riskotro" value="{{$riesgos->otroriesgo}}"
                placeholder=""
                @if ( $riesgos->otroriesgo ==  "")
                    style="display: none"
                @else
                    style="display: block"
                @endif
                >
                <span class="text-danger">@error('riskotro') {{$message}} @enderror</span>
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
                {{-- <input id="probly" type="number" class="form-control" name="probly" value="{{$riesgos->probabilidad}}" min="0" max="1"
                placeholder="El rango de los valores es de 0 al 1 (Ejemplo: 0.5)" min="0" max="1" step="0.05" oninput="multiplicar()"> --}}
                <select id="probly" class="form-control" name="probly" oninput="multiplicar()">
                    <option value="{{$riesgos->probabilidad}}">{{$riesgos->probabilidad}}</option>
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
                {{-- <input id="impact" type="number" class="form-control" name="impact" value="{{$riesgos->impacto}}"
                placeholder="El rango de los valores es de 0 a1 1" min="0" max="1" step="0.05" oninput="multiplicar()"> --}}
                <select id="impact" class="form-control" name="impact" oninput="multiplicar()">
                    <option value="{{$riesgos->impacto}}">{{$riesgos->impacto}}</option>
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
                <input id="vesplab" type="text" class="form-control" name="vesplab" value="{{$riesgos->vesperado}}" disabled>
                <input id="vesp" type="text" class="form-control" name="vesp" value="{{$riesgos->vesperado}}" style="display: none">
                <span class="text-danger">@error('vesp') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Calificación </label>
                <input id="calflab" type="text" class="form-control" name="calflab" value="{{$riesgos->calificacion}}" disabled>
                <input id="calf" type="text" class="form-control" name="calf" value="{{$riesgos->calificacion}}" style="display: none"
                placeholder="">
                <span class="text-danger">@error('calf') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Respuesta al riesgo </label>
                <input id="rriesgolab" type="text" class="form-control" name="rriesgolab" value="{{$riesgos->respriesgo}}" disabled>
                <input id="rriesgo" type="text" class="form-control" name="rriesgo" value="{{$riesgos->respriesgo}}" style="display: none"
                placeholder="">
                <span class="text-danger">@error('rriesgo') {{$message}} @enderror</span>
            </div>
            <div class="mb-4"
            @if ($riesgos->acciones == "")
                style="display: none"
            @else
                style="display: block"
            @endif
            id="acciones">
                <label class="form-label"> Acciones </label>
                <textarea name="accion" id="accion" rows="5" class="form-control">{{$riesgos->acciones}}</textarea>
                <span class="text-danger">@error('accion') {{$message}} @enderror</span>
            </div>
            {{-- <div class="mb-4">
                <label class="form-label"> Fecha probable de ocurrencia </label>
                <input id="ocurd" type="date" class="form-control" name="ocurd" value="{{$riesgos->fechaproable}}"
                placeholder="">
                <span class="text-danger">@error('ocurd') {{$message}} @enderror</span>
            </div> --}}
            <div class="mb-4">
                <label class="form-label"> Etapa probable de ocurrencia </label>
                <select name="probcurrent" id="probcurrent" class="form-control">
                    @foreach ($ocurrent as $ocur)
                        @if ($ocur->id == $riesgos->probocurrencia)
                        <option value="{{$ocur->id}}">{{$ocur->nombre_ocurrencia}}</option>
                        @endif
                    @endforeach
                    <option value="">Selecciona una opción</option>
                    @foreach ($ocurrent as $ocurr)
                        <option value="{{$ocurr->id}}">{{$ocurr->nombre_ocurrencia}}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('probcurrent') {{$message}} @enderror</span>
            </div>
            <div>
                <a href="{{ route('ariesgo', $riesgos->idproyecto)}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		            Cancelar
                </a>
                <button type="submit" class="btn btn-warning" tabindex="5" id="redondb">
                    <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
                    Actualizar
                </button>
            </div>
            </form>

        {{--Fin--}}
@endsection
@push('scripts')
@endpush