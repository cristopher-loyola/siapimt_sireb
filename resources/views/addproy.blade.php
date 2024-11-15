@extends('plantillas/plantillaForm3')
@section('contenido')
<title>Nuevo Proyecto</title>
<div class="row align-items-stretch">
    {{-- <div class="col bg rounded d-none d-lg-block col-md-5 col-lg-5 col-xl-6" id="bgimg">
    </div> --}}
        <h3 class="fw-bold text-center py-5" id="tituloform">Nuevo Proyecto</h3>
        {{--Inicio de Nuevo Proyecto --}}
        <form action="addnewp" method="POST">
            @if (Session::has('success'))
                    <div class="alert-success">{{Session::get('success')}}</div>
                    <br>
                @endif
                @if (Session::has('fail'))
                    <div class="alert-danger">{{Session::get('fail')}}</div>
                    <br>
                @endif
            @csrf
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Responsable </label>
                    <select name="respon" id="respon" class="form-control">
                        <option value="{{$search->id}}">
                            {{$search->Apellido_Paterno.' '.$search->Apellido_Materno.' '.$search->Nombre}}
                        </option>
                        @foreach ($user as $use)
                            <option value="{{ $use->id }}">
                                {{$use->Apellido_Paterno.' '.$use->Apellido_Materno.' '.$use->Nombre}}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('respon') {{$message}} @enderror</span>
                </div>
                <div class="mb-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="mb-4 col">
                    <label class="form-label">Área de adscripción &nbsp;&nbsp;</label>
                    <select name="areas" id="areas" class="form-control" onchange='mostrarValorA(this.value)'>
                        <option value="{{$areauser->id}}">
                            {{$areauser->nombre_area.' | '.$areauser->inicial_clave}}
                        </option>
                        @foreach ($areas as $area)
                        <option value="{{$area->id}}" data-area="{{$area->inicial_clave}}">
                            {{$area->nombre_area.' | '.$area->inicial_clave}}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('areas') {{$message}} @enderror</span>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Tipo de Proyecto (I)nterno / (E)xterno</label>
                        <select name="tipo" id="tipo" class="form-control"
                        value="{{old('tipo')}}" onchange='showInpt(),mostrarValor(this.value)'>
                            <option value=""> Seleccione un tipo</option>
                            <option value="I"> I</option>
                            <option value="E"> E</option>
                        </select>
                        <span class="text-danger">@error('tipo') {{$message}} @enderror</span>
                        <br>
                        <input id="atipo" name="atipo" type="text" style="display: none"
                        placeholder="No. Contraro" class="form-control"/>
                    </div>
                    <div class="mb-2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="mb-4 col">
                        <label class="form-label">Aprobó</label>
                        <select name="aprobo" id="aprobo" class="form-control">
                            <option value="{{$resp->id}}">
                                {{$resp->Apellido_Paterno.' '.$resp->Apellido_Materno.' '.$resp->Nombre}}
                            </option>
                        </select>
                        <span class="text-danger">@error('aprobo') {{$message}} @enderror</span>
                    </div>
                </div>
            {{---se muestran los anios disponibles para agregar un nuevo proyecto---}}
            <div class="container-year-to-realize mb-5" >
                <div class="input-group">
                    <div class="col-4 ">
                        <label for="select-year-realize">Año de realización</label>
                        <select class="form-select form-control" id="select-year-realize" aria-label="Año de realización"
                        name="year_to_realize_project">
                        <option value="">Seleccionar...</option>
                        
                            @foreach($yearOptions as $option)
                            <option value="{{$option['year']}}">{{$option['year']}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">@error('year_to_realize_project') {{$message}} @enderror</span>
                    </div>

                    <div class="mb-2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    </div>

                    <div class="col-4 mb-1">
                        <label>Multicoordinación</label>
                        <select class="form-select form-control" id="select-is-multicoord" aria-label="¿Es Proyecto Multicoordinación?"
                        name="is_project_multicoord" required>
                        <option value="">Seleccionar...</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                        </select>
                        <span class="text-danger">@error('is_project_multicoord') {{$message}} @enderror</span>
                    </div>
                </div>
            </div>
            <div class="mb-1">
                <div class="mb-2">
                    <label class="form-label"> Objetivo del proyecto </label>
                    <textarea  type="text" class="form-control" id="objetivo"
                    name="objetivo" rows="5">
                    {{{old('objetivo')}}}
                    </textarea>
                    <span class="text-danger">@error('objetivo') {{$message}} @enderror</span>
                </div>
            </div>
            <br>
            <div class="mb-1">
                <div class="mb-2">
                    <label class="form-label"> Producto por obtener</label>
                    <textarea  type="text" class="form-control" id="prodobt"
                    name="prodobt" rows="5" maxlength="500">
                    {{{old('prodobt')}}}
                    </textarea>
                    <span class="text-danger">@error('prodobt') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Línea de investigación  </label>
                    {{-- <input type="text" class="form-control" name="lininve"> --}}
                    <select name="lins" id="lins" class="form-control">
                        <option value="{{old('lins')}}">Seleccione una Línea de investigación</option>
                        @foreach ($invs as $inv)
                            <option value="{{ $inv->id }}">{{$inv->nombre_linea}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('lins') {{$message}} @enderror</span>
                </div>
            </div>
            <div class="mb-1 input-group">
                {{---componente para seleccionar un cliente por medio de la categoria----}}
                <div class="mb-4 col">
                    <x-select-client label="Cliente o Usuario potencial" nameField='userpot' :categories="$categoriesN1"/>
                </div>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Objetivo sectorial</label>
                        <select name="objs" id="objs" class="form-control">
                            <option value="{{old('objs')}}">Seleccione un Objetivo sectorial</option>
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
                        <select name="alin" id="alin" class="form-control">
                            <option value="{{old('alin')}}">Seleccione un Programa sectorial</option>
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
                                <option value="{{old('materia')}}">Seleccione una Materia </option>
                                @foreach ($materia as $mat)
                                    <option value="{{ $mat->id }}">
                                        {{$mat->descmateria}}
                                    </option>
                                @endforeach
                            </select>
                        <span class="text-danger">@error('materia') {{$message}} @enderror</span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Orientación </label>
                            <select name="orien" id="orien" class="form-control">
                                <option value="{{old('orien')}}">Seleccione una orientación </option>
                                @foreach ($orientacion as $ore)
                                    <option value="{{ $ore->id }}">
                                        {{$ore->descorientacion}}
                                    </option>
                                @endforeach
                            </select>
                        <span class="text-danger">@error('orien') {{$message}} @enderror</span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Nivel de impacto social o Económico </label>
                            <select name="nivel" id="nivel" class="form-control">
                                <option value="{{old('nivel')}}">Seleccione una nivel </option>
                                @foreach ($nivel as $lvl)
                                    <option value="{{ $lvl->id }}">
                                        {{$lvl->nivel}}
                                    </option>
                                @endforeach
                            </select>
                        <span class="text-danger">@error('nivel') {{$message}} @enderror</span>
                    </div>
                </div>
            {{-- Nuevo codigo --}}
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Modo de transporte </label>
                    <select name="tran" id="tran" class="form-control" onchange='showInp()'>
                        <option value="{{old('tran')}}">Seleccione un modo de transporte</option>
                        @foreach ($trans as $tra)
                            <option id="formao" value="{{ $tra->id }}">{{$tra->nombre_transporte}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('tran') {{$message}} @enderror</span>
                    <br>
                    <input id="otran" name="otran" type="text" style="display: none"
                    placeholder="Otro transporte" class="form-control" value="{{old('otran')}}"/>
                    <span class="text-danger">@error('otran') {{$message}} @enderror</span>
                </div>
                <div class="mb-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <!-- <div class="mb-4 col">
                    <label class="form-label"> Clave </label>
                    <div class="mb-4 col input-group">
                        <div class="col-1">
                            <label class="form-label"> Área </label>
                            <input id="aread" name="aread" type="text"
                            value="{{$areauser->inicial_clave}}" class="form-control" disabled/>
                            <input id="areads" name="areads" type="text"
                            class="form-control" value="{{$areauser->inicial_clave}}" hidden>
                        </div>
                        <div class="col-1">
                            <label class="form-label"> Tipo </label>
                            <input id="otipo" name="otipo" type="text"
                            style="display: none" class="form-control" disabled/>
                        </div>
                        <div class="mb-2">
                            <span>&nbsp;</span>
                            <h1>&nbsp;-&nbsp;</h1>
                        </div>
                        <div class="col-1">
                            <label class="form-label"> No. </label>
                            <input type="text" class="form-control col-1" value="{{old('nop')}}"
                            name="nop" placeholder="00" maxlength="2" pattern="{0-9}">
                        </div>
                        <div class="mb-2">
                            <span>&nbsp;</span>
                            <h1>&nbsp;/&nbsp;</h1>
                        </div>
                        <div class="col-1">
                            <label class="form-label"> Año </label>
                            <input type="text" class="form-control col-1" value="{{old('yearcre')}}"
                            name="yearcre" placeholder="00" maxlength="2">
                        </div>
                    </div>
                    <span class="text-danger">@error('nop') {{$message}} @enderror</span>
                    <span class="text-danger">@error('yearcre') {{$message}} @enderror</span>
                </div> -->
            </div>
            <div class="mb-4">
                <label class="form-label"> Nombre del proyecto (200 caracteres máximo)</label>
                {{----
                <input type="text" class="form-control" name="nameproy"
                value="{{old('nameproy')}}" maxlength="200" style="text-transform:uppercase"
                onclick="calcularm()"
                >
                --}}
                <input type="text" class="form-control" name="nameproy"
                    value="{{old('nameproy')}}" maxlength="200" onclick="calcularm()"
                    style="text-transform:uppercase"
                    id="project-name"
                >

                <span class="text-danger">@error('nameproy') {{$message}} @enderror</span>
            </div>
            <div class="mb-4">
                <input id="meses" name="meses" type="text" class="form-control" hidden>
            </div>
            <div class="mb-1 input-group">
                <div class="mb-4 col">
                    <label class="form-label"> Fecha de elaboración </label>
                    <label id="dia"><script type="text/javascript">
                        var d = new Date();
                        var mm=new Date();
                        var m2 = mm.getMonth() + 1;
                        var mesok = (m2 < 10) ? '0' + m2 : m2;
                        var mesok=new Array(12);
                        mesok[0]="Enero";
                        mesok[1]="Febrero";
                        mesok[2]="Marzo";
                        mesok[3]="Abril";
                        mesok[4]="Mayo";
                        mesok[5]="Junio";
                        mesok[6]="Julio";
                        mesok[7]="Agosto";
                        mesok[8]="Septiembre";
                        mesok[9]="Octubre";
                        mesok[10]="Noviembre";
                        mesok[11]="Diciembre";
                        document.write(d.getDate(),' '+mesok[mm.getMonth()],' '+d.getFullYear());
                        </script></label>
                </div>
                <div class="mb-4 col">
                </div>
            <div>
                <button type="submit" class="btn btn-primary" id="redond"><i class='bx bxs-save'></i> Guardar </button>
            </div>
            <div class="mb-2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="my-3">
                <span class="text-primary"></span>
            </div>
        </form>
        <div>
            <form action="cancelcrud" method="get">
                <button type="submit" class="btn btn-danger" id="redond">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </button>
            </form>
        </div>
    </div>
    {{-- Fin de Nuevo Proyecto --}}
        <br>
    </div>
</div>
@stop
@push('scripts')
<script>
    const inputProjectName = document.getElementById('project-name');

    inputProjectName.addEventListener('keyup',function(e){
        inputProjectName.value = inputProjectName.value.toUpperCase();
    });
</script>

<script>
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
    function showInpt(){
    getSelectValue = document.getElementById("tipo").value;
    if(getSelectValue=="E"){
        document.getElementById("atipo").style.display = "inline-block";
        document.getElementById("atipo").placeholder= "No. Contrato";
    } else {
        document.getElementById("atipo").style.display = "none";
        document.getElementById("atipo").style.display = "disabled";
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
<script>
    $('#areas').change(function () {
        valorActuala = $(this).find(':selected').data('area');
        document.getElementById('aread').style.display = "inline-block";
	    document.getElementById('aread').value=(valorActuala=='') ? x : valorActuala;
        document.getElementById('areads').style.display = "inline-block";
        document.getElementById('areads').value=(valorActuala=='') ? x : valorActuala;
    });
</script>
@endpush