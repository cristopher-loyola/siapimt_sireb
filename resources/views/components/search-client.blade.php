@push('scripts')

    <script lang="text/javascript" type="module">
        $('#btn-buscar').on('click',requestClients);
        $('#container-search-clients').keypress(function(e){
            //realizar la busqueda al presioanr la tecla enter
            if(e.originalEvent.key == "Enter" || e.originalEvent.key == "enter"){
                requestClients();
            }
        });

        //mostramos un mensaje de error en caso de que suceda
        function setErrorMessage(message){
            clearErrorMessage();
            $('#error-search-clients').text(message);
        }
        //borra el mensaje de error 
        function clearErrorMessage(){
            $('#error-search-clients').empty();
        }

        //cambia la visibildiad del spinner de carga
        function setVisibilitySpinner(visible=false){
            const display = visible == true ? 'block' : 'none';
            $('#spinner-loading-client').css('display',display);
        }

        //funcion para saber si tiene valor o no el area a buscar
        function isEmpty(value){
            return ( value == null || value == '' || value == undefined || value.length < 1);
        }

        //funcion para saber si no hay proyectos en el area (vacio)
        function isEmptyResponse(response){
                return (response.length == 0 || response == [] || response == null)
        }

        //habilitar deshabilitar boton de busqueda
        function setEnableButtonSearch(value){
            if(!value){
                $('#btn-buscar').prop('disabled',true);
            }else{
                $('#btn-buscar').removeAttr('disabled');
            }
        }

        //hace las solicitudes para obtener los clientes
        function requestClients(){
            const clientSearch = $('#search-for-input').val();
            //no se realiza la busqueda en caso de estar vacia la entrada
            if(isEmpty(clientSearch)){return;}

            //deshabilitamos el boton de busqueda hasta obtener respuesta o error
            setEnableButtonSearch(false);
            clearErrorMessage();
            //mostramos el spin de carga
            setVisibilitySpinner(true);

            //lanzamos la peticion para buscar 
            $.ajax({
                async:true,
                type:'GET',
                dataType: 'json',
                url: '{{route("clients.search",["client"=> ":client"])}}'.replace(":client",clientSearch),

                success:function(response){
                    //hacemos una pausa para baitear al usuario y hacerle creer que esta cargando
                    setTimeout(() => {
                        if(isEmptyResponse(response)){
                            setErrorMessage("No se encontraron coincidencias con ("+clientSearch+")");
                        }
                        //lanzamos un evento para que el componente padre pueda acceder a la respuesta 
                        document.dispatchEvent(new CustomEvent('{{$eventName}}',{detail:{data:response}}));
                        setVisibilitySpinner(false);
                        setEnableButtonSearch(true);

                    }, 1500);

                },
                error:function(xhr, ajaxOptions, thrownError){
                    //hacemos una pausa para baitear al usuario hacerle creer que esta cargando
                    setTimeout(() => {
                        document.dispatchEvent(new CustomEvent('{{$eventName}}',{detail:{error:'Error al obtener'+thrownError}}));
                        clearErrorMessage();
                        setErrorMessage(thrownError);
                        setEnableButtonSearch(true);
                        console.log(xhr.status);
                        console.log(thrownError);
                    }, 1500);
                }
            });
        }
    </script>

@endpush

<div id="container-search-clients">

    <div class="row">
        <div class="col">
            <div>
                <label for="">{{$label}}</label>
                <input id="search-for-input" name="{{$fieldName}}" class="form-control" type="search"
                placeholder="Buscar....">
    
                <div class="spinner-grow text-primary " role="status" >
                    <span class="visually-hidden" id="spinner-loading-client" style="display: none">Buscando...</span>
                </div>
    
                <div class="container-error-msg">
                    <span class="text-danger" id="error-search-clients"></span>
                </div>
    
            </div>
        </div>

        <div class="col-">
            <div >
                <label for="" style="opacity: 0">.</label>

                <button class="btn form-control btn-sm bg-primary px-2 py-2 rounded" type="button" id="btn-buscar" accesskey="enter">
                    <img width="23em" height="23em" src="img/search.png"
                    alt="" style="margin-bottom: .1em">
                </button>
            </div>
        </div>

    </div>
    
</div>