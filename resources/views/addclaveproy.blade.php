@extends('plantillas/plantillaForm3')
@section('contenido')
<title>Nuevo Proyecto</title>
<div class="row align-items-stretch">
    {{-- <div class="col bg rounded d-none d-lg-block col-md-5 col-lg-5 col-xl-6" id="bgimg">
    </div> --}}
        <h3 class="fw-bold text-center py-5" id="tituloform">Nuevo Proyecto</h3>
        {{--Inicio de Nuevo Proyecto --}}
        <form action="addclave" method="POST">
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
                <label class="form-label"> Nombre del proyecto (200 caracteres máximo)</label>
                <input type="text" class="form-control" name="nameproy" value="{{old('nameproy')}}" maxlength="200" onclick="calcularm()"
                style="text-transform:uppercase" id="project-name">
                <span class="text-danger">@error('nameproy') {{$message}} @enderror</span>
            </div>
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
                        @if($area->id != 12 && $area->inicial_clave != 'M')
                            <option value="{{$area->id}}" data-area="{{$area->inicial_clave}}">
                                {{$area->nombre_area.' | '.$area->inicial_clave}}
                            </option>
                        @endif
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
            {{-- <div class="mb-4 col">
                <x-select-client label="Cliente o Usuario potencial" nameField='userpot' :categories="$categoriesN1"/>
            </div> --}}
            {{-- Nuevo codigo --}}
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
<script>
    const input = document.getElementById('expandingInput');
    function ajustarAncho() {
        input.style.width = (input.value.length + 1) * 8 + 'px';
    }
    input.addEventListener('input', ajustarAncho);
</script>
@endpush