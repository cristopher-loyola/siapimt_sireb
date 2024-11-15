@extends('plantillas/plantilla')
@section('contenido')

<title>Catálogo / Comites</title>
    {{-- Header de la vista  --}}
    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Catálogo / Comités </h2>
        <br><br>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/comitesAdmin.css') }}">
</head>
    <body>

    <div id="app">
  <div class="container">



<!--///////////////////////modal para un nuevo comite/////////////////////// -->
<div id="modal-container">
    <div class="modal-background">
      <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Nuevo comité</h1>
        <br>
        <form action="{{route('nuevocomiteAdmin')}}" method="POST">
          @csrf

          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Nombre del comité</label>
                  <input id="nombrecomite" type="text" class="form-control" name="nombrecomite" placeholder="Nombre del comité" required>
                </div>
              </div>


              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label" for="tipo_solicitud">Tipo de comité</label>
                  <select name="tipocomite" id="tipocomite" class="form-control" style="height: 47px;" required>
                    <option value="" disabled selected>Seleccione el tipo de comité</option>
                    <option value="Interno">Interno</option>
                    <option value="Externo">Externo</option>
                  </select>
                </div>
              </div>
            </div>

          </div>
          <br>
          <div>
            <button type="button" class="btn btn-danger" id="cancel-button" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
            <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold;"><i class="bi bi-plus-circle"></i>Agregar</button>
          </div>
        </div>

        </form>
      </div>
    </div>
</div>








<!--///////////////////////modal para editar la solicitud/////////////////////// -->
<div id="modal-container-editar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">Actualizar comité</h1>
      <br>
      <form action="" id="editarForm">
          @csrf

          @method('PUT')

          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label bold" for="fecha">Nombre del comité</label>
                  <input id="nombrecomiteedit" type="text" class="form-control" name="nombrecomite" placeholder="Nombre del comité" required>
                </div>
              </div>


              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label" for="tipo_solicitud">Tipo de comité</label>
                  <select name="tipocomite" id="tipocomiteedit" class="form-control" style="height: 47px;" required>
                    <option value="" disabled selected>Seleccione el tipo de comité</option>
                    <option value="Interno">Interno</option>
                    <option value="Externo">Externo</option>
                  </select>
                </div>
              </div>
            </div>

        </div>
        <br>
        <div>
            <button type="button" class="btn btn-danger" id="cancel-button-editar" style="background-color: #FF0000; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>Cancelar</button>
            <button type="submit" class="btn btn-primary" style="background-color: #007BFF; font-weight: bold;"><i class="bi bi-plus-circle"></i> Editar comité</button>
          </div>
    </div>



        </form>
    </div>
  </div>
</div>








<!--///////////////////////modal para eliminar la solicitud/////////////////////// -->
<div id="modal-container-eliminar">
  <div class="modal-background">
    <div class="modal" style="background-color: #FFFFFF; color: #007BFF; font-weight: bold;">
      <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #007BFF; font-weight: bold;">¿Seguro de eliminar el comité?</h1>
      <br><br>
      <form action="" id="elimForm">
        @csrf

        @method('DELETE')

        <div>
          <button type="button" class="btn btn-danger" id="cancel-button-eliminar" style="background-color: #007BFF; color: #FFFFFF; font-weight: bold;"><i class='bx bxs-tag-x bx-fw bx-flashing-hover'></i>No, regresar</button>
          <button type="submit" class="btn btn-primary" style="background-color: #FF0000; font-weight: bold;"><i class="bi bi-check-lg"></i>Eliminar el comité</button>
        </div>
      </form>
    </div>
  </div>
</div>









<!--///////////////////////Boton para un nuevo comite/////////////////////// -->

<div class="">
  <div class="buttons">
    <div id="five" class="button"><button><i class="bi bi-plus-circle"></i>  Nuevo </button></div>
  </div>
</div>
    <br>




<!--///////////////////////Tabla con el contenido/////////////////////// -->
<table class="table table-dark table-hover" id="comitesTable">
  <thead class="thead-dark">
    <tr>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Nombre del comité</th>
        <th scope="col" style='text-align: center; vertical-align: middle;'>Tipo de comité</th>
        <th scope="col" colspan='2' style='text-align: center; vertical-align: middle;'>Acciones</th>
    </tr>
  </thead>
  <tbody>

  @foreach($comitesAdmin as $comitesAdmins)
    <tr>
        <td style='text-align: center; vertical-align: middle;'>{{ $comitesAdmins->nombre }}</td>
        <td style='text-align: center; vertical-align: middle;'>{{ $comitesAdmins->tipo }}</td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-editar">
            <button type="button" id="btneditC" class="button-editar btn btn-warning"
              data-id="{{ $comitesAdmins->id }}"
              data-nombre="{{ $comitesAdmins->nombre }}"
              data-tipo="{{ $comitesAdmins->tipo }}"
              data-action="{{ route('comitesAdminEditar', $comitesAdmins->id) }}">
              <i class='bx bxs-up-arrow-circle bx-sm bx-burst-hover'></i>
            </button>
          </div>
        </td>
        <td style='text-align: center; vertical-align: middle;'>
          <div id="five-eliminar" class="button-eliminar btn">
            <button type="button" id="btnelim"
              data-idelim="{{ route('comitesAdminEliminar', $comitesAdmins->id) }}">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </td>
    </tr>
    @endforeach

  </tbody>
</table>


    </body>
</html>



@stop
@push('scripts')
<script src="{{ asset('js/comitesAdmin.js') }}"></script>
<script>
  resp = document.getElementById('resp').value;
  team = document.getElementById('team').value;
  ref = document.getElementById('ref').value;
</script>
@endpush
