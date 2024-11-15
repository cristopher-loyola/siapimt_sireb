@extends('plantillas/plantillaFormP')
@section('contenido') 
<input class="form-label" id="contador" value="{{$contador}}" hidden>   

<title>Ejercicio | {{$proy_a->clavea.$proy_a->clavet.'-'.$proy_a->claven.'/'.$proy_a->clavey}}</title>

    <h2 class="text-center" id="tituloform">Ejercicio del Gasto de los Recursos</h2>
    <div class="container" id="fondo_cajita">
        
    <br>
    
    

<span class="text-danger">@error('fecha') {{$message}} @enderror</span>
<span class="text-danger">@error('clc') {{$message}} @enderror</span>
<span class="text-danger">@error('concepto') {{$message}} @enderror</span>
<span class="text-danger">@error('montoxpartida') {{$message}} @enderror</span>

    <div class="form-row">
        <div class="col">
            <label > Número de Contrato: </label>
            <label class="form-control " > {{$proy_a->ncontratos }} </label>
            
            {{--<input disabled="disabled" placeholder="{{$proy->ncontratos }}"> </input>--}}
        </div>
        <div class="col">
            <label> Clave del Proyecto: </label>
            <label class="form-control " > {{ $proy_a->clavea.$proy_a->clavet.'-'.$proy_a->claven.'/'.$proy_a->clavey}} </label>
            
            {{--<input disabled="disabled" placeholder="{{ $proy->clavea.$proy->clavet.'-'.$proy->claven.'/'.$proy->clavey}}" > 
        --}}</div>
    </div>
    
    <div class="mb-4">
        <div class="mb-1 input-group">
            <div class="mb-4 col" >
                <label class="form-label"> Concepto del Proyecto:  </label>
                <label class="form-control">  {{ $proy_a->nomproy}}  </label>    
            </div>
    
            <div class="mb-2">
                &nbsp;&nbsp;
            </div>
    
            <div class="mb-2">
                &nbsp;&nbsp;
            </div>

            <div class="mb-4 col">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Monto asignado del Proyecto:  </label>
                        <label class="form-control"><strong> ${{  $proy_a->costo }} </strong> </label>    
                    </div>
            
                <div class="mb-2">
                    &nbsp;&nbsp;
                </div>
            </div>
        </div> 
    </div>

    <br>

                <table class="table table-hover">
                        <thead class="">
                            <tr>
                                {{--<th scope="col">Afectación</th>--}}
                                <th scope="col">Número de clc</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Partidas Presupuestarias</th>
                                <th scope="col">Fuente de Financiamiento
                                    <i class='bx bxs-info-circle bx-tada-hover' 
                                    title="*Fuente de Financiamiento(FF): 
                                    1 = RECURSOS FISCALES
                                    5 = RECURSOS FISCALES DERIVADOS DE INGRESOS EXCEDENTES" 
                                    id="info"></i>
                                </th>
                                <th scope="col">Monto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                {{--<th scope="col"> &nbsp;&nbsp; +</th>--}}
                                <th scope="col">Modificar</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($partida as $af)
                             <tr>
                               {{--<th> {{$af->id}}</th>--}}
                               <th scope="row">{{ $af->clc }}</td>
                               <td>{{ $af->fecha }}</td>
                               <td><a href="{{ route('infoafectacion', [ $proy_a->id ,$af->id])}}">{{ $af->concepto }}</a></td>
                               <td> &nbsp;&nbsp;&nbsp;{{ $af->tipo}}</td>
                               <td> $ {{ $af->montoxpartida }}</td>
                              {{-- <td> 
                                   
                                 <form action="{{ route('infoafectacion', [ $proy_a->id ,$af->id])}}" method="GET">
                                    <button type="submit" class="btn btn-info" id="redondb">
                                    <i class='bx bx-info-circle bx-fw bx-sm bx-flashing-hover'></i>
                                    </button>
                                 </form>
                               </td> --}}
                               <td>    
                                 <form action="{{ route('upafectaciones', [$proy_a->id , $af->id]) }}" method="GET">
                                    <button type="sumbit" class="btn btn-warning" id="redondb">
                                     <i class='bx bxs-up-arrow-circle bx-fw bx-sm bx-flashing-hover'></i>
                                   </button>
                                 </form> 
                               </td>
                               <td>
                                 <form action="{{ route('destroyAfectacion', [$proy_a->id, $af->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" id="redondb">
                                      <i class='bx bxs-trash-alt bx-fw bx-sm bx-flashing-hover'></i>
                                    </button>
                                 </form> 
                               </td>
                             </tr>
                             @endforeach 

                             <tr> 
                                <td></td>
                                <td></td>
                                <td> </td>
                                <td>Monto Asignado:</td>
                                <td> <strong> ${{$proy_a->costo}}</strong></td>
                               </tr>
   
                               
                               <tr> 
                                   <td></td>
                                   <td></td>
                                   <td> </td>
                                   <td>Monto de las Afectaciones:</td>
                                   <td> <strong>${{$total}}</strong></td>
                                  </tr>
   
                                  
                               <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Monto Restante:</td>
                                <td> <strong> ${{$proy_a->costo - $total}}</strong></td>
                               </tr>
   

                         </tbody>
                        
                    </table>
                    <br>

                    {{-- NOTA 
                    <p> *Fuente de Financiamiento(FF): <br> 1 = RECURSOS FISCALES
                        <br> 5 = RECURSOS FISCALES DERIVADOS DE INGRESOS EXCEDENTES
                    </p>--}}

                    <div class="form-group ">
                        <div class="form-group col-4">
                            <button type="button" data-toggle="modal" data-target="#newpartida" class="btn btn-success" id="redondb"><i class="bx bx-plus-circle bx-sm bx-fw bx-flashing-hover"> </i> Nuevo Registro</button>
                            <a href="{{ route('cancelcrudafect')}}" class="btn btn-danger" id="redondb"><i class="bx bxs-tag-x bx-fw bx-sm bx-flashing-hover"></i>Cancelar</a>
                        <br>
                        <br>
                            <a id="btnimp" href="{{ route('exportExcel1', [$proy_a->id]) }}"
                                class="btn btn-outline-warning">
                                <i class="bx bxs-file-export"> Reporte por Proyecto
                                </i>    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                            
        <?php $fcha = date("Y-m-d");?>
        {{-- MODAL PARA AGREGAR --}}
        <form action="{{ route('addAfectacion', $proy_a->id)}}" method="POST">
            @csrf            
            
            <div class="mb-4">
                {{--Enviar valor PROYECTO AFECTACION HIIDEN--}}
                <input id="idproy" type="number" class="form-control" name="idproy" value="{{$proy_a->id}}" hidden >
                
            </div> 
            

            <div class="modal fade" id="newpartida" tabindex="-1" role="dialog" aria-labelledby="titPar" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="titPar" text-center>Agregar movimiento</h2>
                        <button class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <form action="" id="frmpartidas">

                                <div class="mb-2">
                                    &nbsp;&nbsp;
                                <div class="mb-4 col">
                                    <label class="form-label"> Fecha en que se genera </label>
                                    <input type="date" class="form-control" name="fecha" 
                                        value="<?php echo date("Y-m-d");?>">
                                    <span class="text-danger">@error('fecha') {{$message}} @enderror</span>
                                </div>
                               
                                </div>

                                <div class="mb-4">
                                    <div class="mb-1 input-group">
                                        <div class="mb-4 col" >
                                            <label class="form-label"> Numero de Clc  </label>
                                            <input type="number" value="{{old('clc')}}" class="form-control" name="clc" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="Otorgada por el ">
                                            <span class="text-danger">@error('clc') {{$message}} @enderror</span>
                                        </div>
                                
                                        <div class="mb-2">
                                            &nbsp;&nbsp;
                                        </div>
                                
                                        <div class="mb-2">
                                            &nbsp;&nbsp;
                                        </div>

                                        <div class="mb-4 col">
                                            <div class="mb-1 input-group">
                                                <div class="mb-4 col" >
                                                    <label class="form-label"> Concepto de Clc  </label>
                                                    <input  value="{{old('conceptoc')}}" type="text" class="form-control" name="conceptoc" placeholder="Digitado por el área de pagos">
                                                    <span class="text-danger">@error('conceptoc') {{$message}} @enderror</span>
                                                </div>
                                        
                                            <div class="mb-2">
                                                &nbsp;&nbsp;
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="mb-1 input-group">
                                    <div class="mb-1 col" >
                                        <label class="form-label"> Partida Presupuestaria</label>
                                        
                                         <select class="form-control" name="partidas" id="partidas" value="{{old('id_partida')}}">
                                          
                                          
                                           @foreach ($allPartidas as $par) 
                                                <option value="{{ $par->id }}"> {{$par->partida }}  |  {{ $par->concepto }}</option>    
                                           @endforeach 

                                        </select>
                                        <span class="text-danger">@error('id_partida') {{$message}} @enderror</span>
                                    </div>

                                    <div class="mb-2">
                                        &nbsp;&nbsp;
                                    </div>
                                    <div class="mb-2">
                                        &nbsp;&nbsp;
                                    </div>


        
                                    <div class="mb-1 col">
                                        <div class="mb-1 input-group">
                                            <div class="mb-1 col" >
                                                <label class="form-label">
                                                    Fuente de Financiamiento
                                                </label>
                                                <select name="tipo" class="form-control"> 
                                                 
                                                 <option value="1">Recursos Fiscales </option>                                                
                                                 <option value="5">Recursos Fiscales Derivados de Ingresos Excedentes</option>  
                                                </select>  
                                            </div>
                                        </div>         
                                    </div>
                                </div>

                                    <div class="mb-1 col">
                                        <div class="mb-1 input-group">
                                            <div class="mb-1 col" >
                                                <label class="form-label"> Monto por partida</label>
                                                <input value="{{old('montoxpartida')}}" type="number" class="form-control" name="montoxpartida" step="0.01" onkeypress="return validateFloatKeyPress(this,event);" placeholder="$">
                                                <span class="text-danger">@error('montoxpartida') {{$message}} @enderror</span>
                                            </div>
                                        </div>         
                                    </div>
                            
                            </form>
                        </div>
                    </div>


                    <div class="modal-foot bm-3 text-cen">

                <button type="submit" class="btn btn-danger" id="redond">
                    <i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>
		     Cancelar
                </button>
                        <button class="btn btn-outline-success" type="submit" ><i class="bx bx-plus-circle"> </i>
		     Agregar
		</button>           
                    </div>
                </div>
            </div>
        </div>  
    </div>  
</form> 

<script>
function validateFloatKeyPress(el, evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }

    if (charCode == 46 && el.value.indexOf(".") !== -1) {
        return false;
    }

    if (el.value.indexOf(".") !== -1)
    {
        var range = document.selection.createRange();

        if (range.text != ""){
        }
        else
        {
            var number = el.value.split('.');
            if (number.length == 2 && number[1].length > 1)
                return false;
        }
    }

    return true;
}

contador=document.getElementById("contador").value;
        
        if(contador==0){
            document.getElementById("btnimp").style.display = "none";
        }
</script>

@stop