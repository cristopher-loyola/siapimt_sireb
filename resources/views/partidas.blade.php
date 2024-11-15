@extends($ext)
@section('contenido')

<title>Partidas</title>
        <br>
        <div>
        <h2 class="text-center" id="title"> Catálogo / Partidas</h2>
        </div>
        <br>
         <a href="addpartida">
          <button type="submit" class="btn btn-success" id="redondb">
            <i class='bx bxs-plus-circle bx-flashing-hover'></i>
            Nuevo
          </button>
        </a> 
        <br>  
        <br>
          <div> 
            <table class="table table-dark table-hover">
              <thead>
                <tr>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Status</th>
                  <th scope="col" class="">Actualizar</th>
                </tr>
              </thead>
              <tbody>
               @foreach ($allPartidas as $part)
                <tr>
                  <td>{{ $part->partida }}</td>
                  <td>{{ $part->concepto }}</td>
                  <td>
                    <input type="checkbox" data-offstyle="danger" class="toggle-class" 
                    data-id="{{$part->id}}" data-toggle="toggle" data-style="slow color:red" 
                    data-on="<i class='bi bi-eye-fill'></i>" 
                    data-off="<i class='bi bi-eye-slash-fill'></i>" {{$part->status == true ? 'checked' : ''}}>
                  </td>
                  <td>
                    <form action="{{route('uppartida', $part->id)}}" method="get">
                      <button type="submit" class="btn btn-warning" id="redondb">
                        <i class='bx bxs-up-arrow-circle bx-sm bx-burst-hover''></i>
                      </button>
                    </form> 
                  </td>
                </tr>
                @endforeach 
            </tbody>
            </table>
          </div>
          <br>
          <a href="addpartida">
            <button type="submit" class="btn btn-success" id="redondb">
              <i class='bx bxs-plus-circle bx-flashing-hover'></i>
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
                        url: '{{ route('changestatupart') }}',
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