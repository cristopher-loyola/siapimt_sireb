@extends('plantillas/plantillaFormalt')
@section('contenido') 
<title>Form Add</title>
    <h3 class="fw-bold text-center py-5">Modificar Afectación... </h3>

    <form action="{{ route('upafectacion',[$proy_a->id ,$afectaciones->id])}}" method="POST">
            @csrf

            <div class="mb-4">
                <input id="idproy" type="number" class="form-control" name="idproy" value="{{$proy_a->id}}" hidden>
            </div> 

            <div class="mb-2">
                &nbsp;&nbsp;
            <div class="mb-4 col">
                <label class="form-label"> Fecha en que se genera </label>
                <input type="date" class="form-control" name="fecha" value="{{$afectaciones->fecha}}">
                <span class="text-danger">@error('fecha') {{$message}} @enderror</span>
            </div>
           
            </div>

            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Numero de Clc  </label>
                        <input type="number" class="form-control" name="clc" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="Otorgada por el " value="{{$afectaciones->clc}}">
                        <span class="text-danger">@error('clc') {{$message}} @enderror</span>
                        
                    </div>
            
                    <div class="mb-2">
                        &nbsp;&nbsp;
                    </div>
            
                    <div class="mb-4 col">
                        <div class="mb-1 input-group">
                            <div class="mb-4 col" >
                                <label class="form-label"> Concepto de Clc  </label>
                                <input type="text" class="form-control" name="conceptoc" placeholder="Digitado por el área de pagos" value="{{$afectaciones->conceptoc}}">
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
                    
                     <select class="form-control" name="partida" id="partidas">
                        <option selected value="{{ $afectaciones->id_partida.old('id_partida') }}">{{$partida->partida }}  | {{$partida->concepto }}</option>
                     
                       @foreach ($allPartidas as $par) 
                          
                          <option value="{{ $par->id }}">{{$par->partida }}  |   {{ $par->concepto }} </option>    
                       @endforeach
                       <span class="text-danger">@error('id_partida') {{$message}} @enderror</span>
                    </select>
                       
                </div>
                
                <div class="mb-2">
                    &nbsp;&nbsp;
                </div>

            </div>
            <div class="mb-1 col">
                <div class="mb-1 input-group">
                    <div class="mb-1 col" >
                        <label class="form-label">Fuente de Financiamiento</label>
                        <select name="tipo" class="form-control">
                          <option selected value="{{$afectaciones->tipo}}"> {{$afectaciones->tipo}} </option>  
                          <option value="1"> Recursos Fiscales </option>
                          <option value="5"> Recursos Fiscales Derivados de Ingresos Excedentes </option>  
                        </select>  
                    </div>
                </div>         
            </div>

                <div class="mb-1 col">
                    <div class="mb-1 input-group">
                        <div class="mb-1 col" >
                            <label class="form-label"> Monto por partida</label>
                            <input type="number" class="form-control" name="montoxpartida"  step="0.01" oninput="calcular()" placeholder="$" value="{{$afectaciones->montoxpartida}}">
                            <span class="text-danger">@error('montoxpartida') {{$message}} @enderror</span>
                        </div>
                    </div>         
                </div>
            
           

        </div>
                 
            <a href="{{route('afectaciones', $proy_a->id)}}" class="btn btn-danger"><i class="bx bxs-tag-x"></i>Cancelar</a>
           
                <button class="btn btn-outline-success" type="submit" ><i class="bx bx-plus-circle"> </i></button>           
            </div>
        </form>

@stop