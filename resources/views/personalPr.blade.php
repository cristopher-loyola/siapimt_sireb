@extends('plantillas/plantilla2')
@section('contenido')
<title>Personal</title>
        <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
            <table class="table">
                <thead>
                   <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellido Paterno</th>
                    <th scope="col">Apellido Materno</th>
                    <th scope="col"> Rol </th>
                    <th scope="col"> FUNCION ELIMINAR </th> 
                   </tr>
                </thead>
  
                <tbody>
                 <tr>
                    <th scope="row">1</th>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                 </tr>
                
                 <tr>
                    <th scope="row">2</th>
                     <td>--</td>
                     <td>--</td>
                     <td>--</td>
                    </tr>
                 <tr>
                    <th scope="row">3</th>
                     <td colspan="2">--</td>
                     <td>--</td>
                 </tr>
                </tbody>
            </table>

            <div class="form-group text-center" >
                <button type="button" class="btn btn-danger"><i class="fas fa-sign-in-alt"></i>Regresar</button>
            </div>
        </div>

@stop