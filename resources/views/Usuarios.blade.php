@extends('plantillas/plantilla')
@section('contenido')
<title>Usuarios</title>
    <style>
        #buscar{
            padding-top: 7px;
            background: #016099;
        }
        
        #buscar:hover{
            background: #3393cf;
        }
    </style>
           {{--  <div class="container jumbotron shadow-lg rounded font-weight-light"> --}}
            <div class="container shadow-lg rounded font-weight-light">
                <div>
                    <h2 class="text-center" id="title"> Administración de Usuarios </h2>
                </div>
                <br>
                <div class="d-grid">
                    <form action="{{route('newuser')}}" method="GET" class="d-grid">
                      <button type="submit" class="btn btn-success" id="redondb">
                        <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i> Nuevo Usuario
                      </button>
                    </form>
                    <br>
                    <form action="{{route('difusionD')}}" method="GET" class="d-grid">
                      <button type="submit" class="btn btn-success" id="redondb" hidden>
                        <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i> Actualizar tablas DD
                      </button>
                    </form>
                </div>
                <div class="container justify-content-center align-items-center mt-2">
                    <form action="{{ route('userAdmin')}}" method="GET" enctype="multipart/form-data">
                        <div class="mb-0 input-group">
                            <div class="mb-0 col-3">
                                <input id="buscarpor" name="buscarpor" class="form-control" type="search"
                                placeholder="Buscar...." value="{{$texto}}">
                            </div>
                            <div class="mb-0">
                                &nbsp;
                            </div>
                            <div class="mb-0 col-0">
                                <button class="btn form-control btn-sm" type="submit" id="buscar">
                                    <img width="23em" height="23em" src="img/search.png"
                                    alt="" style="margin-bottom: .1em">
                                </button>
                            </div>
                            <div class="mb-0 col-6">
                                &nbsp;
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Apellido Paterno</th>
                            <th scope="col">Apellido Materno</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Activo</th>
                            <th scope="col">Responsable del Área</th>
                            <th scope="col">Sesión especial</th>
                            <th scope="col">Actualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->Apellido_Paterno}}</td>
                            <td>{{$user->Apellido_Materno}}</td>
                            <td>{{$user->Nombre}}</td>
                            <td>{{$user->usuario}}</td>
                            <td>{{$user->nom_acceso}}</td>
                            <td>
                                <input type="checkbox" data-offstyle="danger" class="toggle-class"
                                data-id="{{$user->id}}"
                                data-toggle="toggle" data-style="slow color:red"
                                data-on="<i class='bx bxs-show bx-fw  bx-sm bx-flashing-hover'></i>"
                                data-off="<i class='bx bxs-hide bx-fw bx-sm bx-flashing-hover'></i>"
                                {{$user->status == true ? 'checked' : ''}}>
                            </td>
                            <td>
                                <input type="checkbox" data-offstyle="danger" class="toggle-class1"
                                data-id="{{$user->id}}"
                                data-toggle="toggle" data-style="slow color:red"
                                data-on="<i class='bx bxs-show bx-fw  bx-sm bx-flashing-hover'></i>"
                                data-off="<i class='bx bxs-hide bx-fw bx-sm bx-flashing-hover'></i>"
                                {{$user->responsable == true ? 'checked' : ''}}>
                            </td>
                            <td>
                                <input type="checkbox" data-offstyle="danger" class="toggle-class2"
                                data-id="{{$user->id}}"
                                data-toggle="toggle" data-style="slow color:red"
                                data-on="<i class='bx bxs-show bx-fw  bx-sm bx-flashing-hover'></i>"
                                data-off="<i class='bx bxs-hide bx-fw bx-sm bx-flashing-hover'></i>"
                                {{$user->sesionespecial == true ? 'checked' : ''}}>
                            </td>
                            <td>
                                <form action="{{route('upusers', $user->id)}}" method="get">
                                    <button type="submit" class="btn btn-warning" id="redondbc">
                                        <i class='bx bxs-up-arrow-circle bx-fw bx-sm bx-flashing-hover'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <div class="d-grid">
                    <form action="{{route('newuser')}}" method="GET" class="d-grid">
                      <button type="submit" class="btn btn-success" id="redondb">
                        <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i> Nuevo Usuario
                      </button>
                    </form>
                </div>
            </div>


            @endsection
            @push('scripts')

                <script>

                    $(function() {
                        $('#toggle-two').bootstrapToggle({
                        on: 'Enabled',
                        off: 'Disabled'
                        });
                    })
                </script>
                <script>
                    $(function(){
                       $('.toggle-class').on('change', function(){
                            var status = $(this).prop('checked') == true ? 1 : 0;
                            var id = $(this).data('id');
                            $.ajax({
                                async: true,
                                type: 'GET',
                                dataType: 'json',
                                url: '{{ route('changestatuuser') }}',
                                data: {'status': status,'id': id },
                                success:function(data){
                                    $('#notifDiv').fadeIn();
                                    $('#notifDiv').css('background','green');
                                    $('#notifDiv').text('Estatus actualizado correctamente');
                                    setTimeout(() => {
                                        $('#notifDiv').fadeOut();
                                    });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status);
                                    alert(thrownError);
                                },
                            });
                        });
                    });

                </script>
                <script>
                    $(function(){
                       $('.toggle-class1').on('change', function(){
                            var responsable = $(this).prop('checked') == true ? 1 : 0;
                            var id = $(this).data('id');
                            $.ajax({
                                async: true,
                                type: 'GET',
                                dataType: 'json',
                                url: '{{ route('changestaturesp') }}',
                                data: {'responsable': responsable,'id': id },
                                success:function(data){
                                    $('#notifDiv').fadeIn();
                                    $('#notifDiv').css('background','green');
                                    $('#notifDiv').text('Estatus actualizado correctamente');
                                    setTimeout(() => {
                                        $('#notifDiv').fadeOut();
                                    });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status);
                                    alert(thrownError);
                                },
                            });
                        });
                    });

                </script>


                <script>
                    $(function(){
                       $('.toggle-class2').on('change', function(){
                            var sesionespecial = $(this).prop('checked') == true ? 1 : 0;
                            var id = $(this).data('id');
                            $.ajax({
                                async: true,
                                type: 'GET',
                                dataType: 'json',
                                url: '{{ route('changestatussesionespecial') }}',
                                data: {'sesionespecial': sesionespecial,'id': id },
                                success:function(data){
                                    $('#notifDiv').fadeIn();
                                    $('#notifDiv').css('background','green');
                                    $('#notifDiv').text('Estatus actualizado correctamente');
                                    setTimeout(() => {
                                        $('#notifDiv').fadeOut();
                                    });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status);
                                    alert(thrownError);
                                },
                            });
                        });
                    });

                </script>
            @endpush
