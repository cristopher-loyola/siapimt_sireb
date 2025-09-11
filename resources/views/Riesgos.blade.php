@extends('plantillas/plantilla')
@section('contenido')

    <title>Riesgos</title>
        <br>
        <div>
        <h2 class="text-center" id="title"> Catálogo / Riesgos </h2>
        </div>
        <br>
        <a href="addlriesgo">
          <button type="submit" class="btn btn-success" id="redondb">
            <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
            Nuevo
          </button>
        </a>
        <br>  
        <br>
          <div> 
            <table class="table table-dark table-hover">
              <thead>
                <tr>
                  <th scope="col" class="">Nombre del riesgo</th>
                  <th scope="col" class="">Tipo de riesgo</th>
                  <th scope="col" class="">Acciones del riesgo</th>
                  <th scope="col" class="">Estatus</th>
                  <th scope="col" class="">Actualizar</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($riesgos as $risk)
                <tr>
                  <td>{{ $risk->tiporiesgo }}</td>
                  @if ($risk->tvarrisk == 1)
                    <td>Interno</td>
                  @elseif ($risk->tvarrisk == 2)
                    <td>Externo</td>
                  @else
                    <td>Ambos</td>
                  @endif
                  <td>{{$risk->resprisk}}</td>
                  <td><input type="checkbox" data-offstyle="danger"
                    class="toggle-class" data-id="{{$risk->id}}"
                    data-toggle="toggle" data-style="slow color:red"
                    data-on="<i class='bx bxs-show bx-fw  bx-sm bx-flashing-hover'></i>"
                    data-off="<i class='bx bxs-hide bx-fw bx-sm bx-flashing-hover'></i>"
                    {{$risk->status == true ? 'checked' : ''}}>
                  </td>
                  <td>
                    <form action="{{route('uplrisk', $risk->id)}}" method="get">
                      <button type="submit" class="btn btn-warning" id="redondb">
                        <i class='bx bxs-up-arrow-circle bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        <br> 
        <a href="addlriesgo">
          <button type="submit" class="btn btn-success" id="redondb">
            <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
             Nuevo
          </button>
        </a>
        <br>
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
                            url: '{{ route('changestatusrisk') }}',
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
@endpush