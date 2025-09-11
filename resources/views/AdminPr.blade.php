@extends('plantillas/plantilla')
@section('contenido')  
<title>Administrar proyectos</title>

            <div class="container shadow-lg rounded font-weight-light">
                <div>
                    <h2 class="text-center" id="title">Administración de proyectos</h2>
                </div>
                <label for="buscarp" class="form-label">Clave o Nombre del Proyecto</label>
                <div class="container mt-1">
                    <form action="{{ route('adpindex') }}" method="GET" enctype="multipart/form-data">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <input id="buscarp" name="buscarp" class="form-control" type="search"
                                    placeholder="Buscar..." value="{{ $texto }}">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary" type="submit" id="buscar">🔎
                                </button>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <a href="{{ route('vistareportesglobal') }}" class="btn btn-warning" id="redondb">
                                    <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i> Reportes
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Clave</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de fin</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Oculto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($proyt as $pr)
                            <th scope="row">{{$pr->id}}</th>
                            <td>{{$pr->clavea.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey}}</td>
                            <td>{{$pr->nomproy}}</td>
                            <td>{{$pr->fecha_inicio}}</td>
                            <td>{{$pr->fecha_fin}}</td>
                            <td>{{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}</td>
                            <td>
                                <input type="checkbox" data-offstyle="danger" 
                                class="toggle-class1" data-id="{{$pr->id}}" 
                                data-toggle="toggle" data-style="slow color:red" 
                                data-on="<i class='bx bxs-show bx-fw  bx-sm bx-flashing-hover'></i>" 
                                data-off="<i class='bx bxs-hide bx-fw bx-sm bx-flashing-hover'></i>" 
                                {{$pr->oculto == true ? 'checked' : ''}}>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                                url: '{{ route('changestatuspro') }}',
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
                {{-- este script ejecuta la funcion para actualizar el campo sin actualizar toda la pagina --}}
                <script>
                    /* Identifica el input que esta afectando */
                    $('.toggle-class1').on('change',function(){
                        var oculto = $(this).prop('checked') == true ? 1 : 0; /* esta funcion se encarga de verificar el valor actual del campo para cambiarlo*/
                        var pr_id = $(this).data('id');/* identifica el campo para afectarlo */
                        $.ajax({ /* Envia un archivo ajax para ejecutar el cambio sin actualizar la vista */
                            type: 'GET', /* define el tipo de envio */
                            dataType: 'json', /* el tipo de archivo */
                            url: '{{ route('changeStatusoculto') }}', /* la ruta de la funcion */
                            data: {
                                'oculto':oculto, /* los datos enviados para ejecutar la consulta con el cambio */
                                'pr_id': pr_id
                            },
                            success:function(data){ /* regreso del resultado correctamente*/
                                $('#notifDiv').fadeIn();
                                $('#notifDiv').css('background','green');
                                $('#notifDiv').text('Status changed Succesfully');
                                setTimeout(() => {
                                    $('#notifDiv').fadeOut();
                                },3000);
                            },
                            error: function (xhr, ajaxOptions, thrownError) { /* error en el resultado */
                                    alert(xhr.status);
                                    alert(thrownError);
                            },
                        });
                    });
                </script>
                 {{-- Nota: revisar el apartdo de web.php para ver como definir 
                    la ruta para acceder a la funcion en el archivo controlador --}}   
            @endpush
