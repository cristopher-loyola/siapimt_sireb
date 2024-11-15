@extends('plantillas/plantilla2')
@section('contenido')
<title>Informacion</title>
        <div id="caja">
            <div class="container jumbotron shadow-lg rounded font-weight-light bg-white">
                <div>
                    <h2 class="text-center">Informacion sobre el proyecto</h2>
                </div>
                <br>
                <form action="paginaBienvenida" method="GET"">
                    <div class="mb-4">
                        <label class="form-label"> Nombre del proyecto </label>
                        <input type="text" class="form-control" name="nameproy">
                    </div> 
                    <div class="mb-4 input-group">
                        <label class="form-label"> Coordinación de &nbsp;&nbsp;</label>
                        <input type="text" class="form-control" name="nameproy">
                    </div>
                    
                    <div class="mb-4">
                        <div class="mb-1 input-group">
                            <div class="mb-4 col" >
                                <label class="form-label"> Objetivo del proyecto </label>
                                <input type="text" class="form-control" name="Objetivo">
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
                            <div class="mb-4 col">
                                <label class="form-label"> Responsable </label>
                                <input type="text" class="form-control" name="respon">
                            </div>
                            <div class="mb-2">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="mb-4 col">
                                <label class="form-label"> Fecha de Fin</label>
                                <input type="date" class="form-control" name="fin">
                            </div>
                        </div>
        
                        <div class="mb-1 input-group">
                            <div class="mb-4 col">
                                <label class="form-label"> Equipo </label>
                                <input type="text" class="form-control" name="respon">
                            </div>
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
                                <input type="text" class="form-control" name="lininve">
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
                            <input type="text" class="form-control" name="aliprosect">
                            </div>
                            <div class="mb-4 col">
                                <span></span>
                            </div>
                            <div class="mb-1 col">
                                <label class="form-label"> Tipo </label>
                                    <br>
                                    <input type="radio" id="html" name="fav_language" value="I(interno)">
                                <label for="html">I(interno)</label><br>
                                    <p>
                                    <input type="radio" id="css" name="fav_language" value="E(Externo)">
                                <label for="css">E(Externo)</label><br>
                            </div>
                        </div>
                        <div class="mb-1 input-group">
                            <div class="mb-4 col">
                            <label class="form-label"> Objetivo sectorial</label>
                            <input type="text" class="form-control" name="objsect">
                            </div>
                            <div class="mb-4 col">
                                <span></span>
                            </div>
                        </div>
                        <div class="mb-1 input-group">
                            <div class="mb-4 col">
                            <label class="form-label"> Contribucion a </label>
                            <input type="text" class="form-control" name="contri">
                            </div>
                            <div class="mb-4 col">
                                <span></span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="mb-4 col input-group">
                            <label class="form-label"> Clave </label>
                                <div class="col-1">
                                    <input type="text" class="form-control" name="nombre" placeholder="">
                                </div>
                                <div class="col-1">
                                    <input type="text" class="form-control" name="nombre" placeholder="">
                                </div>
                                <div class="col-1">
                                    <h4>-</h4>
                                </div>
                                <div class="col-1">
                                    <input type="text" class="form-control" name="nombre" placeholder="">
                                </div>
                                <div class="col-1">
                                    <h4>/</h4>
                                </div>
                                <div class="col-1">
                                    <input type="text" class="form-control" name="nombre" placeholder="">
                                </div>
                            </div>
                            <div class="mb-4 col">
                                <span></span>
                            </div>
                        </div>
                            <div class="mb-4 col">
                                <span></span>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-success"><i class='bx bx-edit'></i></button>
                        </div>  
                    </div>
                    <div class="my-3">
                        <span class="text-primary"></span>
                    </div>
                
            </form>
            </div>
        </div> 
@stop
