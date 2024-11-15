@extends('plantillas/plantillaForm3')
@section('contenido')
<title>Nuevo Proyecto</title>
<div class="row align-items-stretch">
    {{-- <div class="col bg rounded d-none d-lg-block col-md-5 col-lg-5 col-xl-6" id="bgimg">
    </div> --}}
        <h3 class="fw-bold text-center py-5" id="tituloform">Nuevo Proyecto</h3>
        {{--Inicio de Nuevo Proyecto --}}  
        <form action="addnewp" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label"> Nombre del proyecto </label>
                <input type="text" class="form-control" name="nameproy">
            </div> 
            <div class="mb-4 input-group">
                <label class="form-label"> Coordinación de &nbsp;&nbsp;</label>
                {{-- <input type="text" class="form-control" name="nameproy"> --}}
                <select name="areas" id="areas" class="form-control">
                    <option value="0">Seleccione un Area</option>
                    @foreach ($areas as $area)
                        <option id="formao" value="{{ $area->id }}">{{$area->nombre}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Objetivo del proyecto </label>
                        <input type="text" class="form-control" name="objetivo">
                    </div>
                    <div class="mb-2">
                        &nbsp;&nbsp;
                    </div>
                    <div class="mb-4 col">
                        <label class="form-label"> Fecha de inicio</label>
                        <input type="date" class="form-control" name="inicio">
                    </div>
                </div>
                
                <div class="mb-1 input-group">
{{--                     <div class="mb-4 col">
                        <label class="form-label"> Responsable </label>
                        <input type="text" class="form-control" name="respon">
                    </div> --}}
                    <div class="mb-2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="mb-4 col">
                        <label class="form-label"> Fecha de Fin</label>
                        <input type="date" class="form-control" name="fin">
                    </div>
                </div>

                <div class="mb-1 input-group">
   {{--                  <div class="mb-4 col">
                        <label class="form-label"> Equipo </label>
                        <input type="text" class="form-control" name="respon">
                    </div> --}}
                    <div class="mb-2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="mb-4 col">
                        <label class="form-label"> Cliente o Usuario Potencial</label>
                        <input type="text" class="form-control" name="userpot">
                    </div>
                </div>

                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> Linea de investigacion  </label>
                        {{-- <input type="text" class="form-control" name="lininve"> --}}
                        <select name="lins" id="lins" class="form-control">
                            <option value="0">Seleccione una Linea de investigacion</option>
                            @foreach ($invs as $inv)
                                <option value="{{ $inv->id }}">{{$inv->id.' | '.$inv->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="mb-4 col">
                        <label class="form-label"> Producto por obtener</label>
                        <input type="text" class="form-control" name="prodobt">
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                    <label class="form-label"> Alineación del programa sectorial</label>
                    {{-- <input type="text" class="form-control" name="aliprosect"> --}}
                    <select name="alin" id="alin" class="form-control">
                        <option value="0">Seleccione una Programa sectorial</option>
                        @foreach ($alins as $ali)
                            <option value="{{ $ali->id }}">{{$ali->id.' | '.$ali->nombre}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                    <div class="mb-1 col">
                        <label class="form-label"> Tipo de Proyecto (Interno / Externo)</label>
                        <select name="tipo" id="tipo" class="form-control">
                            <option value="0"> Selecciona una tipo</option>
                            <option value="I"> I</option>
                            <option value="E"> E</option>
                        </select>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                    <label class="form-label"> Objetivo sectorial</label>
                    {{-- <input type="text" class="form-control" name="objsect"> --}}
                    <select name="objs" id="objs" class="form-control">
                        <option value="0">Seleccione una Objetivo sectorial</option>
                        @foreach ($objs as $obj)
                            <option id="formao" value="{{ $obj->id }}">{{$obj->nombre}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                    <label class="form-label"> Contribucion a : </label>
                    {{-- <input type="text" class="form-control" name="contri"> --}}
                   {{--  <select name="cons" id="cons" class="form-control">
                        <option value="0">Seleccione una Contribucion</option> --}}
                        @foreach ($contri as $con)
                            {{-- <option id="formao" value="{{ $con->id }}"> --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $con->id }}" id="flexCheckDefault" name="cont">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{$con->nombre_contri}}
                                    </label>
                                  </div>
                            </option>
                        @endforeach
{{--                     </select> --}}
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                    <label class="form-label"> Modo de transporte </label>
                    <select name="tran" id="tran" class="form-control">
                        <option value="0">Selecciona un modo de transporte</option>
                        @foreach ($trans as $tra)
                            <option id="formao" value="{{ $tra->id }}">{{$tra->nombre}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div>
                <div class="mb-1 input-group">
                    <div class="mb-4 col">
                        <label class="form-label"> clave </label>
                        <input type="text" class="form-control" name="clave">
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div>
                
                {{-- <div class="mb-1">
                    <label class="form-label"> Clave </label>
                    <div class="mb-4 col input-group">
                        <div class="col-1">
                            <input type="text" class="form-control" name="nombre" placeholder="" tabindex="1">
                           {{--  <select name="areas" id="areas" class="form-select">
                                <option value="0">Letra</option>
                                @foreach ($areas as $area)
                                    <option id="formao" value="{{ $area->id }}">{{$area->inicial_clave}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control" name="nombre" placeholder="" >
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <div class="col-0">
                            <h4>-</h4>
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <div class="col-1">
                            <input type="text" class="form-control" name="nombre" placeholder="">
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <div class="col-0">
                            <h4>/</h4>
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <div class="col-1">
                            <input type="text" class="form-control" name="nombre" placeholder="">
                        </div>
                    </div>
                    <div class="mb-4 col">
                        <span></span>
                    </div>
                </div> --}}

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
                        <span></span>
                    </div>
                </div>

            </div>
 
            <div class="d-grid">
                <button type="submit" class="btn btn-primary" id="redond"><i class='bx bxs-save bx-flashing'></i> Guardar </button>
            </div>
            <div class="my-3">
                <span class="text-primary"></span>
              </div>
        </form>
    </div>{{-- Fin de Nuevo Proyecto --}}
        <br>
    </div>
</div>
@stop
