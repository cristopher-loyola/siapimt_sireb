@extends('plantillas/plantillaFormalt')
@section('contenido') 
<title>Información del movimiento</title>
    <h3 class="fw-bold text-center py-5"> </h3>

    <form action="{{ route('infoafectacion',[$proy_a->id ,$afectaciones->id])}}" method="POST">
            @csrf
            <div class="mb-2">
                &nbsp;&nbsp;
            <div class="mb-4 col">
                <label class="form-label"> Fecha en que se generó </label>
                <label class="form-control" name="fecha"> {{$afectaciones->fecha}}</label>
                </div>
            </div>

            <div class="mb-4">
                <div class="mb-1 input-group">
                    <div class="mb-4 col" >
                        <label class="form-label"> Numero de Clc  </label>
                        <label class="form-control" name="clc"> {{$afectaciones->clc}} </label> 
                    </div>
            
                    <div class="mb-2">
                        &nbsp;&nbsp;
                    </div>
            
                    <div class="mb-4 col">
                        <div class="mb-1 input-group">
                            <div class="mb-4 col" >
                                <label class="form-label"> Concepto de Clc  </label>
                                <label class="form-control" name="conceptoc"> {{ $afectaciones->conceptoc}} </label>
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
                    <label class="form-control" name="partida"> {{ $partida->partida }} | {{$partida->concepto }} </label>   
                </div>
                
                <div class="mb-2">
                    &nbsp;&nbsp;
                </div>
                
            </div>
            <div class="mb-1 col">
                <div class="mb-1 input-group">
                    <div class="mb-1 col" >
                        <label class="form-label">Tipo de partida</label>
                        <label name="tipo" class="form-control"> {{$afectaciones->tipo}}</label>
                    </div>
                </div>         
            </div>

                <div class="mb-1 col">
                    <div class="mb-1 input-group">
                        <div class="mb-1 col" >
                            <label class="form-label"> Monto por partida</label>
                            <label class="form-control" name="montoxpartida"> ${{ $afectaciones->montoxpartida }} </label>
                        </div>
                    </div>         
                </div>
            </div>

            <div class="form-group col-8">
               <a href="{{route('afectaciones', $proy_a->id)}}" class="btn btn-danger"><i class="bx bxs-tag-x"></i></a> 
            </div>                
         
    </div>        
</form>

@stop