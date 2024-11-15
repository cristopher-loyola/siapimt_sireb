@extends('plantillas/plantilla')
@section('contenido')  
<title>Elementos</title>

            <div class="container jumbotron shadow-lg rounded font-weight-light">
                <div>
                    <h2 class="text-center">Elementos del Sistema</h2>
                </div>
                <br>
                <form action="contri" method="get">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>contribucion a </button>
                    </div>
                </form>
                <form action="moda" method="get">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>area de adscripcion</button>
                    </div>
                </form>
                <form action="modo" method="get">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>Objetivos Sectoriales</button>
                    </div>
                </form>
                <form action="modinv" method="get">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>Linea de investigacion</button>
                    </div>
                </form>
                <form action="modt" method="get">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>Modo de transporte</button>
                    </div>
                </form>
                <form action="modlin" method="get">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>Alineacion </button>
                    </div>
                </form>
            </div>
@stop
