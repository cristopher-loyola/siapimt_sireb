@extends('plantillas/plantillaFormalt')
@section('contenido')
<title>Avance de Actividad o Tarea</title>
        <h3 class="fw-bold text-center py-5">Reporte de Avance de la Tarea</h3>
        {{--Inicio--}}
            <form action="{{ route('upavance',[$proyt->id ,$tarea->id])}}" method="POST">
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
            </div>
            <div class="mb-4">
                <label class="form-label"> Nombre de la Tarea </label>
                <input id="act" name="act"  type="text" class="form-control"
                placeholder="Nombre de la Tarea" value="{{$tarea->actividad}}" disabled>
                <span class="text-danger">@error('act') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Fecha de Inicio de la Tarea</label>
                <input id="inicio" name="inicio" type="date"
                class="form-control"
                value="{{$tarea->fecha_inicio}}" disabled>
                <span class="text-danger">@error('inicio') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <label class="form-label"> Fecha de Fin de la Tarea </label>
                <input id="fin" name="fin" type="date"
                class="form-control" value="{{$tarea->fecha_fin}}" disabled>
                <span class="text-danger">@error('fin') {{$message}} @enderror</span>
            </div>
            <div class="mb-4 input-group">
                <label class="form-label"> Duración de la Tarea &nbsp;</label>
                <input id="result" name="result" value="{{$tarea->duracion}}"
                type="number" class="form-control" disabled>
                <div class="input-group-append">
                    <span class="input-group-text"> &nbsp;&nbsp;&nbsp; Meses </span>
                </div>
                <span class="text-danger">@error('result') {{$message}} @enderror</span>
            </div>
            {{--<div class="mb-4 input-group">
                <label class="form-label">
                    Avance de la Tarea ( El numero de meses trabajados ) &nbsp;&nbsp;&nbsp;</label>
                <input id="avance1" name="avance1" type="number" min="0" max="{{$tarea->duracion}}"
                class="form-control" placeholder="Coloca un valor de 0 al {{$tarea->duracion}}"
                onclick="calcularm()">
                <label class="form-label"> &nbsp;&nbsp;&nbsp; Meses &nbsp;&nbsp;&nbsp;</label>
                <span class="text-danger">@error('avance') {{$message}} @enderror</span>
            </div>--}}
            {{-- estilo para la tabla y las celdas--}}
            <style>
            
                #crono{
                    padding: 10px;
                    overflow: scroll;
                    overflow-y: auto;
                    overflow-x: auto;
                    overscroll-behavior-x:initial;
                    overscroll-behavior-y:initial;
                }
                #crono::-webkit-scrollbar{
                    -webkit-appearance: none;
                }
                #crono::-webkit-scrollbar:vertical{
                    width: 10px;
                }
                #crono::-webkit-scrollbar-button:increment, #crono::-webkit-scrollbar-button{
                    display: none;
                }
                #crono::-webkit-scrollbar:horizontal{
                    height: 10px;
                }
                #crono::-webkit-scrollbar-thumb{
                    background: #909299;
                    border-radius: 20px;
                    border: 2px solid #f1f2f3;
                }

                #cuadro{
                    border-collapse: collapse;
                    border-spacing: 0;
                    border: 1px solid #000000;
                    padding: 10px 20px;
                    font-size: 12px;
                }
                #celdas, #celdas2, #celdast, #celdas2t{
                    border: 1px solid #000000;
                    padding: 5px 5px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    text-align:center;
                    width: 10px;
                }
                #celdas3{
                    border: 1px solid #000000;
                    padding: 5px 5px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    text-align:center;
                    background: #006098;
                    color: aliceblue;
                    width: 10px;
                }
                
            </style>

            <div id="crono" name="crono" class="mb-4 input-group">
                <script>
                    var lar = 2;
                    var anh = {{$tarea->duracion}};
                    var dur = {{$tarea->duracion}};
                    var colanh = {{$tarea->duracion}};
                    var nom = document.getElementById('act').value;
                    var fechafin = new Date(document.getElementById('fin').value);
                    var fechaini = new Date(document.getElementById('inicio').value);

                    /* Obtener la fecha del dia

                        var usaractual = Date.now();
                        var hoy = new Date(usaractual);
                        hoy.setDate(hoy.getDate() + 1);
                        var hoym = hoy.getMonth();
                        var hoyy = hoy.getFullYear();
                       
                    */

                    fechafin.setDate(fechafin.getDate() + 1);
                    fechaini.setDate(fechaini.getDate() + 1);

                    /* Para Pruebas de funciones de fecha
                        let inim1=fechaini.getMonth();
                        if (inim1 = 0) {
                            var inim2=fechaini.getMonth()+1;
                        } else {
                            var inim2=fechaini.getMonth();
                        }

                        var iniy = fechaini.getFullYear();
                        var inim = fechaini.getMonth()+1;
                        var inicio = inimn+'-'+iniy;
                        
                        var finm = fechafin.getMonth()+1;
                        var finy = fechafin.getFullYear();
                        var fin = finmn+'-'+finy;
                        
                        switch (inim2) {
                                    case 0:
                                        var finmn = 'ENE';
                                        break;
                                    case 1:
                                        var finmn = 'FEB';
                                        break;
                                    case 2:
                                        var finmn = 'MAR';
                                        break;
                                    case 3:
                                        var finmn = 'ABR';
                                        break;
                                    case 4:
                                        var finmn = 'MAY';
                                        break;
                                    case 5:
                                        var finmn = 'JUN';
                                        break;
                                    case 6:
                                        var finmn = 'JUL';
                                        break;
                                    case 7:
                                        var finmn = 'AGO';
                                        break;
                                    case 8:
                                        var finmn = 'SEP';
                                        break;
                                    case 9:
                                        var finmn = 'OCT';
                                        break;
                                    case 10:
                                        var finmn = 'NOV';
                                        break;
                                    case 11:
                                        var finmn = 'DEC';
                                        break;
                                    default:
                                        break;
                        }
                    */

                    let table = document.createElement('table');
                    table.setAttribute('id','cuadro');
                    table.setAttribute('class','table table-hover');
                    let thead = document.createElement('thead');
                    let tbody = document.createElement('tbody');
                    
                    table.appendChild(thead);
                    table.appendChild(tbody);
            
                    document.getElementById('crono').appendChild(table);
        
                    let row = document.createElement('tr');
                    row.setAttribute('id','celdast');
                    let headtext2 = document.createElement('th');
                    headtext2.setAttribute('id','celdas2t');
                    headtext2.setAttribute('colspan', colanh);
                    headtext2.innerHTML = " % PROGRAMADO ";
            
                    row.appendChild(headtext2);
                    thead.appendChild(row);
        
                    //calcula el valor de un parte del porcentaje de la tarea
                    var dt = new Number(document.getElementById('result').value);
                    var f = (100/dt);
                    var ff = f*1;
                    // fin del proceso

                    var c = 1; //contador de las tareas
                    var ca = 1; // contador que define el contador de Actividad
                    var can = 1; // contador que define el contador de No.

                    /*Generador de tabla*/
                    for( var i = 0; i < lar; i++){/*filas*/
                    let row1 = document.createElement('tr');
                    row1.setAttribute('id','celdas');
                    var i1 = i+1;//Contador para las filas
                    var fechaini1 = new Date(document.getElementById('inicio').value);
                    fechaini1.setDate(fechaini1.getDate() + 1);
                    var inim =fechaini1.getMonth();
                    var iniy =fechaini1.getFullYear();
                    for( var j = 0; j < anh; j++){/*columnas*/
                        /*
                            Esta codigo genera el la posicion de las celdas
                            let celda = document.createElement('th');
                            celda.setAttribute('id','celdas2');
                            celda.innerHTML = 'F'+i+'C'+j;
                            row1.appendChild(celda);
                        */
                        if(i == 0){
                            let celda = document.createElement('th');
                            switch (inim) {
                                case 0:
                                    var inimn = 'ENE';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 1:
                                    var inimn = 'FEB';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 2:
                                    var inimn = 'MAR';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 3:
                                    var inimn = 'ABR';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 4:
                                    var inimn = 'MAY';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 5:
                                    var inimn = 'JUN';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 6:
                                    var inimn = 'JUL';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 7:
                                    var inimn = 'AGO';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 8:
                                    var inimn = 'SEP';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 9:
                                    var inimn = 'OCT';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 10:
                                    var inimn = 'NOV';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    inim++;
                                    break;
                                case 11:
                                    var inimn = 'DEC';
                                    celda.innerHTML = inimn+'-'+iniy;
                                    iniy++;
                                    inim = 0;
                                    break;
                                default:
                                    celda.innerHTML = '-';
                                    break;
                            }
                            inim;
                            iniy;
                            celda.setAttribute('id','celdas');
                            row1.appendChild(celda);
                        } else {
                        //La celdas que no esten en la columna f0-1
                        const per = ff*c;
                        const per2 = per.toFixed(1);
                        const percent = Math.round(per);
                        let celda = document.createElement('th');
                        celda.setAttribute('id','celdas3');
                        celda.innerHTML = per2;
                        row1.appendChild(celda);
                        c++
                        }
                    }
                    tbody.appendChild(row1);
                    c;
                    }
        
                </script>
            </div>
        {{-- estilo para la tabla y las celdas
            <div class="mb-4 input-group">
                <label class="form-label"> % Programado &nbsp;&nbsp;&nbsp;</label>
                <select name="programado" id="programado" class="form-control" onchange="calcularm()">
                    {{$fechasfin = strtotime($tarea->fecha_fin)}}
                    {{$fechainicio = strtotime($tarea->fecha_inicio)}}
                    {{$first = date('m',$fechainicio) - $tarea->duracion}}
                    {{$first2 = date('m',$fechainicio)}}
                    {{$last = date('m',$fechasfin)}}
                    {{$yearfirst = date('Y',$fechainicio)}}
                    {{$yearlast = date('Y',$fechasfin)}}
                    {{$fechaomt = date('Y-m', $fechainicio)}}
                    {{$r = $tarea->duracion}}
                    @for($e = $yearlast; $e>= $yearfirst; $e--)
                        @for($i = $last; $i>= $first; $i--)
                            @if($i >= $first && $i > 0)
                                @if($e >= $yearfirst && $first2 != $i)
                                <option value="{{ $r-- }}">{{$i.'/'.$e}}</option>
                                @elseif($e == $yearfirst && $first2 == $i)
                                <option value="{{ $r-- }}">{{$i.'/'.$e}}</option>
                                @elseif($e != $yearfirst && $first2 == $i)
                                <option value="{{ $r-- }}">{{$i.'/'.$e}}</option>
                                @endif
                            @endif
                        @endfor
                    @endfor
                </select>
                <label class="form-label">&nbsp;&nbsp;&nbsp Avance estimado &nbsp;&nbsp;&nbsp</label>
                <input type="text" class="form-control" name="estimado" id="estimado" onclick="calcularm()">
                <span class="text-danger">@error('programado') {{$message}} @enderror</span>
            </div>
            --}}

            <div class="mb-4 input-group">
                <label class="form-label"> &nbsp; % Realizado: &nbsp;&nbsp; </label>
                <input type="number" class="form-control" name="avpor1" id="avpor1"
                value="{{$tarea->progreso}}" min="0" max="100" step=".1">
                <span class="text-danger">@error('avpor') {{$message}} @enderror</span>
                <div class="input-group-append">
                    <span class="input-group-text"> &nbsp;&nbsp;&nbsp; % </span>
                </div>
            </div>
            <div>
                <a href="{{ route('tareag', $proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redond">
                    <i class='bx bxs-tag-x'></i>
		     Cancelar
                </a>
                <button type="submit" class="btn btn-warning" tabindex="5" id="redond">
                    <i class='bx bxs-pencil bx-tada-hover bx-fw' ></i>
                    Registrar Avance
                </button>
            </div>
            </form>
        {{--Fin--}}
@stop
@push('scripts')
        <script>
            /*Realiza el calculo para el aprox. porcentaje de avance por meses*/

            // function calcularm(){
            // var id = document.getElementById('programado').value;
            // if (id <= 0){
            //     alert("La fecha seleccionada es inferior a la fecha de inicio, escoge una fecha adecuada")
            //     var color = document.getElementById('programado');
            //     color.setAttribute("style","background-color:red;");
            //     document.getElementById('programado').style.color="white";
            // }else{
            //     var id2 = id;
            //     var dt = new Number(document.getElementById('result').value);
            //     var f = (100/dt);
            //     var ff = f*id2;
            //     xf = Math.round(ff);
            //     document.getElementById('estimado').value=(xf);
            //     var color = document.getElementById('programado');
            //     color.setAttribute("style","background-color:default;");
            //     document.getElementById('programado').style.color="default";
            // }

            /*var dt = new Number(document.getElementById('result').value);
            document.getElementById('estimado').value=(xf);
            var r1 = (dt*aa);
            var r2 = r1/100;
            r3 = Math.round(r2);
            document.getElementById('avmes1').value=(r3);
            document.getElementById('avmes').value=(r3);*/
        </script>
@endpush