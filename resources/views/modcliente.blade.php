@extends('plantillas/plantilla')
@section('contenido')

@push('scripts')
    {{---busqueda y filtrado del cliente--}}
    <script type="module">


      document.addEventListener('clientResponse',handleResponseClient);

      function handleResponseClient(e){
        if(e.detail.data){
            //recuperamos los datos de la peticion
            const clients = e.detail.data;
            //no se hace nada si no hay proyectos por mostrar, se muestra aviso en el componente que realiza el response
            if(isEmptyResponse(clients)){
              return;
            }
            //limpiamos la tabla
            clearTableClients();

            let clientRow;
            //agregamos todas las repuestas a la tabla
            clients.forEach(function(item){
              
              clientRow = createRowClient(item.id,item.nivel1,item.nivel2,item.nivel3,item.status);

              document.getElementById('clients-table').appendChild(clientRow);
            });

        }

        if(e.detail.error){
          console.log(e.detail.error);
        }
      }

      //funcion para saber si no hay coincidencias (vacio)
      function isEmptyResponse(response){
        return (response.length == 0 || response == [] || response == null)
      }

      //limpia la tabla de clientes
      function clearTableClients(){
        document.getElementById('clients-table').innerHTML = '';
      }

      //crea la fila del cliente
      function createRowClient(id,nivel1,nivel2,nivel3,status){
        const tr = document.createElement('tr');

        tr.appendChild(createLevelClient(nivel1));
        tr.appendChild(createLevelClient(nivel2));
        tr.appendChild(createLevelClient(nivel3));
        tr.appendChild(createButtonStatus(id,status));
        tr.appendChild(createButtonUpdate(id));

        return tr;
      }

      function createLevelClient(nivel){
        const clientLevel = document.createElement('td');
        clientLevel.textContent = nivel;
        return clientLevel;
      }



      function createButtonStatus(id,status){

        const td = document.createElement('td');
        
        const checkboxStatus = document.createElement('input');
        checkboxStatus.type = 'checkbox';
        checkboxStatus.classList.add('toggle-class');
        checkboxStatus.classList.add('toggle');
        checkboxStatus.checked = status;
        checkboxStatus.role = "switch";

        //establecemos los datos para poder cambiar el status
        checkboxStatus.dataset.id = id;
        checkboxStatus.dataset.offstyle = 'danger';
        checkboxStatus.dataset.toggle = 'toggle';
        checkboxStatus.dataset.style = 'slow color:red';
        checkboxStatus.dataset.on = '<i class="bx bxs-show bx-fw  bx-sm bx-flashing-hover"></i>';
        checkboxStatus.dataset.off = '<i class="bx bxs-hide bx-fw bx-sm bx-flashing-hover"></i>';

        td.appendChild(checkboxStatus);

        return td;
      }

      function createButtonUpdate(id){

        const td = document.createElement('td');
        const form = document.createElement('form');
        const btnAction = document.createElement('button');
        //configuracines del formulario
        form.method = 'GET';
        form.action = '{{route("upcli", ":id" )}}'.replace(":id",id);

        btnAction.type = 'submit';btnAction.id = 'redondb';
        btnAction.classList.add('btn'); btnAction.classList.add('btn-warning');
        btnAction.innerHTML = '<i class="bx bxs-up-arrow-circle bx-fw bx-sm bx-flashing-hover"></i>';

        form.appendChild(btnAction);
        td.appendChild(form);
        
        return td; 
      }

      document.addEventListener('click',function(e){

        if(e.target.classList.contains('toggle-class')){
          const item = e.target; 

          //lanzamos el request 
            const status = item.checked == true ? 1 : 0;
            const id = item.dataset.id;

            $.ajax({
                async: true,
                type: 'GET',
                dataType: 'json',
                url: '{{ route('changestatucl') }}',
                data: {'status': status,'id': id},
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

        }
      });


  </script>
@endpush

<title>Clientes</title>
      <br>
      <div>
        <h2 class="text-center" id="title"> Catálogo / Cliente o Usuario Potencial </h2>
      </div>
      <div>    
        <x-search-client label="Buscar cliente" fieldName="client_to_search" eventName="clientResponse"/>
      </div>
      <br>
        <form action="newcli" method="get">
          <button type="submit" class="btn btn-success" id="redondb">
            <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
             Nuevo
          </button>
        </form>

      <br>
          <div> 
            <table class="table table-dark table-hover">
              <thead >
                <tr>
                  <th scope="col" class="">Nivel 1</th>
                  <th scope="col" class="">Nivel 2</th>
                  <th scope="col" class="">Nivel 3</th>
                  <th scope="col" class="">Status</th>
                  <th scope="col" class="">Actualizar</th>
                </tr>
              </thead>
              <tbody id="clients-table">
                @foreach ($clien as $cl)
                <tr>
                  <td>{{ $cl->nivel1 }}</td>
                  <td>{{ $cl->nivel2 }}</td>
                  <td>{{ $cl->nivel3}}</td>
                  <td>
                    <input type="checkbox" data-offstyle="danger" 
                    class="toggle-class" data-id="{{$cl->id}}" 
                    data-toggle="toggle" data-style="slow color:red" 
                    data-on="<i class='bx bxs-show bx-fw  bx-sm bx-flashing-hover'></i>" 
                    data-off="<i class='bx bxs-hide bx-fw bx-sm bx-flashing-hover'></i>" 
                    {{$cl->status == true ? 'checked' : ''}}>
                  </td>
                  <td>
                    <form action="{{route('upcli', $cl->id)}}" method="get">
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
          <form action="newcli" method="get">
            <button type="submit" class="btn btn-success" id="redondb">
              <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i>
               Nuevo
              </button>
            </form>
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
            <script lang="text/javascript" type="module">

                $(function(){
                   $('.toggle-class').on('change', function(){
                        var status = $(this).prop('checked') == true ? 1 : 0;
                        var id = $(this).data('id');

                        $.ajax({
                            async: true,
                            type: 'GET',
                            dataType: 'json',
                            url: '{{ route('changestatucl') }}',
                            data: {'status': status,'id': id},
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