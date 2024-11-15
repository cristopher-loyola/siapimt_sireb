@extends('plantillas/plantillaReporte')
@section('contenido') 
<title>Reportes</title>
            <h3 class="fw-bold text-center py-5">Reporte de Proyectos por Área de adscripción</h3>
            <select name="opc" id="opc" onchange="showInp()" value="{{old('opc')}}" class="form-control">
                <option value="">Selecciona una opción</option>
                <option value="1">Reporte de Proyectos por Área de adscripción</option>
                <option value="2">Formato F6 GS-001</option>
                <option value="3">Formato F2 GS-001</option>

            </select>
            <br>
            <form action="excelporresponsable" method="POST" id="form1" style="display: none">
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
                    <select name="areas" id="areas" class="form-control">
                        <option value="{{$areass->id}}">{{$areass->nombre_area}}</option>
                        @foreach ($areas as $area)
                        <option id="areas" value="{{$area->id}}" data-area="{{$area->inicial_clave}}">
                            {{$area->nombre_area.' | '.$area->inicial_clave}}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('areas') {{$message}} @enderror</span>
                </div>
                <div>
                    <button type="submit" class="btn btn-warning" tabindex="5" id="redondb">
                        <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
                        Reporte de Proyectos por Área de adscripción
                    </button>
                </div>
            </form>
            <form action="f6gs001" method="POST" id="form2" style="display: none">
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
                    <select name="areas" id="areas" class="form-control">
                        <option value="{{$areass->id}}">{{$areass->nombre_area}}</option>
                        @foreach ($areas as $area)
                        <option id="areas" value="{{$area->id}}" data-area="{{$area->inicial_clave}}">
                            {{$area->nombre_area.' | '.$area->inicial_clave}}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('areas') {{$message}} @enderror</span>
                </div>
                <div>
                    <button type="submit" class="btn btn-warning" tabindex="5" id="redondb">
                        <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
                        Formato F6 GS-001
                    </button>
                </div>
            </form>
            {{---agregamos la opcion para el otro formulario---}}
            <form action="{{route('reports.format.f2gs001')}}" method="POST" id="form3" style="display: none">
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
                    <select name="area" id="area" class="form-control">
                        <option value="{{$areass->id}}">{{$areass->nombre_area}}</option>
                        @foreach ($areas as $area)
                        <option id="areas" value="{{$area->id}}" data-area="{{$area->inicial_clave}}">
                            {{$area->nombre_area.' | '.$area->inicial_clave}}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('areas') {{$message}} @enderror</span>
                </div>
                <div>
                    <button type="submit" class="btn btn-warning" tabindex="5" id="redondb">
                        <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
                        Formato F2 GS-001
                    </button>
                </div>
            </form>

            <script>
                function showInp(){
                    getSelectValue = document.getElementById("opc").value;
                    if(getSelectValue=="1"){
                        document.getElementById("form1").style.display = "inline-block";
                        document.getElementById("form2").style.display = "none";
                        document.getElementById("form3").style.display = "none";                        
                    }
                    else if (getSelectValue=="2")
                    {
                        document.getElementById("form2").style.display = "inline-block";
                        document.getElementById("form1").style.display = "none";
                        document.getElementById("form3").style.display = "none";
                    }
                    else if ( getSelectValue == "3" ){
                        document.getElementById("form2").style.display = "none";
                        document.getElementById("form1").style.display = "none";
                        document.getElementById("form3").style.display = "inline-block";
                    }
                    else if ( getSelectValue == "" ){
                        document.getElementById("form2").style.display = "none";
                        document.getElementById("form1").style.display = "none";
                        document.getElementById("form3").style.display = "none";
                    }
                }
            </script>
            <br>
            <hr>
            <div class="mb-4">
            <h3 class="fw-bold text-center py-5">Reporte General de Proyectos</h3>
                <div>
                    <a href="{{ route('exceltodos')}}" class="btn btn-warning" tabindex="5" id="redondb">
                        <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
                        Reporte General de Proyectos
                    </a>
                </div>
            </div>
            <div>
                <a href="{{ route('cancelcrud')}}" class=" btn btn-danger" tabindex="4" id="redondb">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </a>
            </div>
@endsection