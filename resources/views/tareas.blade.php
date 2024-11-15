@extends('plantillas/plantilla2')
@section('contenido')
<title>Tarea</title>
            <div class="container jumbotron shadow-lg rounded font-weight-light">
                <div>
                    <h2 class="text-center">Tareas del proyecto</h2>
                </div>
            <br>
            <form action="newtarea" method="get">
                <div class="form-group ">
                    <div class="form-group">
                        <form action="newtarea" method="get">
                                <button type="submit" class="btn btn-success"><i class='bx bx-plus-circle'> Nueva Tarea</i></button>
                        </form>
                    </div>
                    <br>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tarea</th>
                                <th scope="col">Fecha de inicio</th>
                                <th scope="col">Fecha de fin</th>
                                <th scope="col">Duracion</th>
                                <th scope="col">Eliminar</th>
                                <th scope="col">Actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="bg-dark text-white">1</th>
                                <td>N/A</td>
                                <td>00/00/0000</td>
                                <tD>00/00/0000</tD>
                                <td>N/A</td>
                                <td>
                                    <form action="" method="get">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger" id="redond"><i class='bx bx-trash'></i></button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="get">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="redond"><i class='bx bx-up-arrow-circle'></i></button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <form action="" method="get">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning" id="redond"><i class='bx bxs-report'></i></button>
                        </div>
                    </form>
                </div>
            </form>

@stop
