@extends('plantillas/plantillaForm4')
@section('contenido')
<style>
    .center{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>
<title>Actualizar Proyecto</title>
    <div class="row align-items-stretch">
    {{-- <div class="col bg rounded d-none d-lg-block col-md-5 col-lg-5 col-xl-6" id="bgimg">
    </div> --}}
        <h3 class="fw-bold text-center py-5" id="tituloform">Actualizar información del Proyecto</h3>
        {{--Inicio de Nuevo Proyecto --}}  
        <form action="{{ route('upproy', $proyt->id) }}" method="POST">
                @if(Session::has('success'))
                    <div class="alert-success">{{Session::get('success')}}</div>
                    <br>
                @endif
                @if (Session::has('fail'))
                    <div class="alert-danger">{{Session::get('fail')}}</div>
                    <br>
                @endif
            @csrf
            <div class="show-key-project pb-5 input-group center">
                <span class="fs-5">
                    <strong>Clave:</strong> {{$proyt->clavea}}{{$proyt->clavet}}-@if($proyt->claven < 10)0{{$proyt->claven}}@else{{$proyt->claven}}@endif/{{$proyt->clavey}}
                </span>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Responsable </label>
                    <select name="respon" id="respon" class="form-control" onclick="calcularm()"  >
                        <option value="{{ $users->id }}">{{$users->Apellido_Paterno.' '.$users->Apellido_Materno.' '.$users->Nombre}}</option>
                        @foreach ($user as $use)
                            <option value="{{ $use->id }}">{{$use->Apellido_Paterno.' '.$use->Apellido_Materno.' '.$use->Nombre}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('respon') {{$message}} @enderror</span>
                </div>
                <div class="mb-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="mb-4 col">
                    <label class="form-label">Área de adscripción &nbsp;&nbsp;</label>
                    <select name="areas" id="areas" class="form-control" onclick="calcularm()" >
                        <option value="{{$areass->id}}">{{$areass->nombre_area}}</option>
                        @foreach ($areas as $area)
                        <option id="areas" value="{{$area->id}}" data-area="{{$area->inicial_clave}}">
                            {{$area->nombre_area.' | '.$area->inicial_clave}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Tipo de Proyecto (I)nterno / (E)xterno</label>
                            <select name="tipo" id="tipo" class="form-control" onclick="calcularm()" 
                            value="{{old('tipo')}}" onchange='showInpt(),mostrarValor(this.value)'>
                                <option value="{{$proyt->Tipo}}"> {{$proyt->Tipo}}</option>
                                <option value="I"> I</option>
                                <option value="E"> E</option>
                            </select>
                        <span class="text-danger">@error('tipo') {{$message}} @enderror</span>
                        <br>
                        <input id="atipo" name="atipo" type="text" value="{{$proyt->ncontratos}}"
                        style="display: none" placeholder="No. Contraro" class="form-control" maxlength="30" 
                        style="text-transform:uppercase" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                    </div>
                    <div class="mb-2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="mb-4 col">
                        <label class="form-label">Aprobó</label>
                        <select name="aprobo" id="aprobo" class="form-control">
                            <option value="{{$resp->id}}">{{$resp->Apellido_Paterno.' '.$resp->Apellido_Materno.' '.$resp->Nombre}}</option>
                        </select>
                        <span class="text-danger">@error('aprobo') {{$message}} @enderror</span>
                    </div>
                </div>
            </div>
            <!-- <div class="mb-1">
                <div class="mb-2">
                    <label class="form-label"> Costo</label>
                    <input  type="text" class="form-control" id="costo"
                    name="costo" value="{{$proyt->costo}}">

                    <span class="text-danger">@error('costo') {{$message}} @enderror</span>
                </div>
            </div>
            <br> -->
            <div class="mb-1">
                <div class="mb-2">
                    <label class="form-label"> Objetivo del proyecto </label>
                    <textarea  type="text" class="form-control" id="objetivo" onclick="calcularm()" 
                    name="objetivo" rows="5">
                    {{{$proyt->objetivo}}}
                    </textarea>
                    <span class="text-danger">@error('objetivo') {{$message}} @enderror</span>
                </div>
            </div>
            <br>
            <div class="mb-1">
                <div class="mb-2">
                    <label class="form-label"> Producto por obtener</label>
                    <textarea  type="text" class="form-control" id="prodobt" onclick="calcularm()" 
                    name="prodobt" rows="5" maxlength="500">
                    {{{$proyt->producto}}}
                    </textarea>
                    <span class="text-danger">@error('prodobt') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> LÍnea de investigación  </label>
                    <select name="lins" id="lins" class="form-control" onclick="calcularm()" >
                        <option value="{{$lineas->id}}">{{$lineas->nombre_linea}}</option>
                        @foreach ($invs as $inv)
                            <option value="{{ $inv->id }}">{{$inv->nombre_linea}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('lins') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <x-select-client label="Cliente o Usuario potencial" nameField='userpot' :categories="$categoriesN1" :cliente="$clis" :categoriesN2="$categoriesN2" :categoriesN3="$categoriesN3"/>
                    <span class="text-danger">@error('userpot') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Objetivo sectorial</label>
                    <select name="objs" id="objs" class="form-control" onclick="calcularm()" >
                        <option value="{{$objss->id}}">{{
                            \Illuminate\Support\Str::limit($objss->nombre_objetivosec, 500, '...')}}
                            </option>
                        @foreach ($objs as $obj)
                            <option value="{{ $obj->id }}">
                                {{ \Illuminate\Support\Str::limit($obj->nombre_objetivosec, 500, '...') }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('objs') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Alineación al programa sectorial</label>
                        <select name="alin" id="alin" class="form-control" onclick="calcularm()" >
                            <option value="{{$alinss->id}}">{{$alinss->nombre}}</option>
                            @foreach ($alins as $ali)
                                <option value="{{ $ali->id }}">{{$ali->nombre}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">@error('alin') {{$message}} @enderror</span>
                    </div>
                    <div class="mb-4 col">
                    </div>
                </div>
            </div>
            {{-- Nuevo codigo --}}
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Materia </label>
                            <select name="materia" id="materia" class="form-control">
                                @if ($proyt->materia == "")
                                    <option value="{{old('materia')}}">Seleccione una Materia </option>
                                    @foreach ($materia as $mat)
                                        <option value="{{ $mat->id }}">
                                            {{$mat->descmateria}}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{$mate->id}}">{{$mate->descmateria}}</option>
                                    @foreach ($materia as $mat)
                                        <option value="{{ $mat->id }}">
                                            {{$mat->descmateria}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        <span class="text-danger">@error('materia') {{$message}} @enderror</span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Orientación </label>
                            <select name="orien" id="orien" class="form-control">
                                @if ($proyt->orientacion == "")
                                    <option value="{{old('orien')}}">Seleccione una orientación </option>
                                    @foreach ($orientacion as $ore)
                                    <option value="{{ $ore->id }}">
                                            {{$ore->descorientacion}}
                                    </option>
                                @endforeach
                                @else
                                    <option value="{{$orent->id}}">{{$orent->descorientacion}}</option>
                                    @foreach ($orientacion as $ore)
                                        <option value="{{ $ore->id }}">
                                                {{$ore->descorientacion}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        <span class="text-danger">@error('orien') {{$message}} @enderror</span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Nivel de impacto social o Económico </label>
                            <select name="nivel" id="nivel" class="form-control">
                                @if ($proyt->orientacion == "")
                                    <option value="{{old('nivel')}}">Seleccione una nivel </option>
                                    @foreach ($nivel as $lvl)
                                        <option value="{{ $lvl->id }}">
                                            {{$lvl->nivel}}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{$nivelp->id}}">{{$nivelp->nivel}}</option>
                                    @foreach ($nivel as $lvl)
                                        <option value="{{ $lvl->id }}">
                                            {{$lvl->nivel}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        <span class="text-danger">@error('nivel') {{$message}} @enderror</span>
                    </div>
                </div>
            {{-- Nuevo codigo --}}
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Objetivo sectorial</label>
                    <select name="objs" id="objs" class="form-control" onclick="calcularm()" >
                        <option value="{{$objss->id}}">{{
                            \Illuminate\Support\Str::limit($objss->nombre_objetivosec, 500, '...')}}
                            </option>
                        @foreach ($objs as $obj)
                            <option value="{{ $obj->id }}">
                                {{ \Illuminate\Support\Str::limit($obj->nombre_objetivosec, 500, '...') }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('objs') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Modo de transporte </label>
                    <select name="tran" id="tran" class="form-control" onchange='showInp()' onclick="calcularm()">
                        <option value="{{$transs->id}}">{{$transs->nombre_transporte}}</option>
                        @foreach ($trans as $tra)
                            <option id="formao" value="{{ $tra->id }}">{{$tra->nombre_transporte}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('tran') {{$message}} @enderror</span>
                    <br>
                    <input type='text' name="otrotra" id="otrotra" class="form-control" value="{{$transs->id}}" hidden>
                    <input id="otran" name="otran" type="text" onclick="calcularm()" placeholder="Otro transporte" class="form-control" value="{{$proyt->otrotrans}}"/>
                    <span class="text-danger">@error('otran') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1  input-group">
                <div class="mb-4 col">
                <label class="form-label"> Nombre del proyecto (200 caracteres máximo)</label>
                <input type="text" class="form-control" name="nameproy" 
                value="{{$proyt->nomproy}}" maxlength="200" style="text-transform:uppercase" 
                onclick="calcularm()"
                onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                <input id="areads" name="areads" type="text" value="{{$proyt->clavea}}" class="form-control" hidden>
                </div>
                <div class="mb-4 col">
                    <span></span>
                </div>
            </div> 
            <div class="mb-4">
                <input id="meses" name="meses" type="text" class="form-control" hidden>
            </div>      
            <div>
                <a href="{{route('infoproys',$proyt->id)}}" class=" btn btn-danger" tabindex="4" id="redondb"  onclick="calcularm()">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </a>
                <button type="submit" class="btn btn-warning" tabindex="5" id="redond">
                    <i class='bx bxs-up-arrow-circle bx-fw bx-flashing-hover'></i>
                    Actualizar
                </button>
            </div>
        </form>
    </div>
    <script>
        otrotra = document.getElementById("otrotra").value;
        if(otrotra != 7){
            document.getElementById("otran").style.display = "none";
        }
    </script>
{{-- Fin de Nuevo Proyecto --}}
        <br>
    </div>
</div>
@stop
@push('scripts')
    <script>
        var fechaini = new Date(document.getElementById('inicio').value);
        var fechafin = new Date(document.getElementById('fin').value);
        var year1=fechaini.getFullYear();
        var year2=fechafin.getFullYear();
        var month1=fechaini.getMonth();
        var month2=fechafin.getMonth();
            if(month1===0){
                month1++;
                month2++;
            }
        var numberOfMonths = (year2 - year1) * 12 + (month2 - month1) + 1;
        document.getElementById('meses').value=(numberOfMonths=='') ? x : numberOfMonths;
        function calcularm(){
        var fechaini = new Date(document.getElementById('inicio').value);
        var fechafin = new Date(document.getElementById('fin').value);
        var year1=fechaini.getFullYear();
        var year2=fechafin.getFullYear();
        var month1=fechaini.getMonth();
        var month2=fechafin.getMonth();
            if(month1===0){
                month1++;
                month2++;
            }
        var numberOfMonths = (year2 - year1) * 12 + (month2 - month1) + 1;
        document.getElementById('meses').value=(numberOfMonths=='') ? x : numberOfMonths;
        }
    </script> 
    <script>
        function showInp(){
        getSelectValue = document.getElementById("tran").value;
        if(getSelectValue=="7"){
            document.getElementById("otran").style.display = "inline-block";
        } else {
            document.getElementById("otran").style.display = "none";
            document.getElementById("otran").style.display = "disabled";
            document.getElementById("otran").value= "N/A";
        }
    }
    </script>
    <script>
        tipo = document.getElementById("tipo").value;
        if(tipo=="E"){
            document.getElementById("atipo").style.display = "inline-block";
        }
        function showInpt(){
        getSelectValue = document.getElementById("tipo").value;
        if(getSelectValue=="E"){
            document.getElementById("atipo").style.display = "inline-block";
            document.getElementById("atipo").placeholder= "No. Contrato";
        } else {
            document.getElementById("atipo").style.display = "none";
            document.getElementById("atipo").style.display = "disabled";
            document.getElementById("atipo").value = null;
        }
    }
    </script>
    <script>
        function mostrarValor(x){
        var valorActual = document.getElementById('tipo').value;
        document.getElementById('otipo').style.display = "inline-block";
        document.getElementById('otipo').value=(valorActual=='') ? x : valorActual;
        }
    </script>
    {{-- <script>
        function mostrarValorA(x){
        valorActual = document.getDate('areas').value;
        document.getElementById('oaread').style.display = "inline-block";
        document.getElementById('oaread').value=(valorActual=='') ? x : valorActual;
        }
    </script> --}}
    <script>
        $('#areas').change(function () {
            valorActuala = $(this).find(':selected').data('area');
            document.getElementById('aread').style.display = "inline-block";
            document.getElementById('aread').value=(valorActuala=='') ? x : valorActuala;
            document.getElementById('areads').style.display = "inline-block";
            document.getElementById('areads').value=(valorActuala=='') ? x : valorActuala;
            document.getElementById('areasd').style.display = "inline-block";
            document.getElementById('areasd').value=(valorActuala=='') ? x : valorActuala;
        });
    </script>
@endpush