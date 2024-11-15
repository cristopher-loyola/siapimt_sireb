<style >
    .column{
        display: flex;
        flex-direction: row;
        background-color: '#FF0000';
    }
</style>

@push('scripts')
    <script>
        //evento para cuando se haga click en el boton enter
        $('#btn-buscar').on('click',requestProjects);
            $('div.column').keypress(function(e){
            //realizar la busqueda al presioanr la tecla enter
            if(e.originalEvent.key == "Enter" || e.originalEvent.key == "enter"){
                requestProjects();
            }
        });

        function requestProjects(){
            const inputFilter = $('#search-for-input').val();

            //evaluamos  si esta vacia la entrada
            if(isEmpty(inputFilter)){return;}

            //mostramos spinner de carga
            setVisibilitySpinner(true);
            setEnableButtonSearch(false);
            clearErrorMessage();
            
            $.ajax({
                async:true,
                type:'GET',
                dataType: 'json',
                url:'{{route("projects.search.by")}}',
                data:{'value':inputFilter},
                success:function(response){

                    if(isEmptyResponse(response)){
                        setErrorMessage("No se muestran registros asociados la busqueda ("+inputFilter+")");
                    }
                    document.dispatchEvent(new CustomEvent('{{$nameEvent}}',{detail:{data:response}}));
                    setVisibilitySpinner(false);
                    setEnableButtonSearch(true);
                },
                //lanzamos un evento para que el componente padre pueda acceder a la respuesta 
                error:function(xhr, ajaxOptions, thrownError){
                    document.dispatchEvent(new CustomEvent('{{$nameEvent}}',{detail:{error:'Error al obtener'+thrownError}}));
                    clearErrorMessage();
                    setErrorMessage(thrownError);
                    setVisibilitySpinner(false);
                    setEnableButtonSearch(true);
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        //cambia la visibildiad del spinner de carga
        function setVisibilitySpinner(visible=false){
            const display = visible == true ? 'block' : 'none';
            $('#spinner-loading-input-filter').css('display',display);
        }

        //mostramos un mensaje de error en caso de que suceda
        function setErrorMessage(message){
            clearErrorMessage();
            $('#error-search-projects-input-filter').text(message);
        }
        //limpiamos o borramos el mensaje de error
        function clearErrorMessage(){
            $('#error-search-projects-input-filter').empty();
        }
        //habilitar deshabilitar boton de busqueda
        function setEnableButtonSearch(value){
            if(!value){
                $('#btn-buscar').prop('disabled',true);
            }else{
                $('#btn-buscar').removeAttr('disabled');
            }
        }

        //funcion para saber si tiene valor o no el area a buscar
        function isEmpty(value){
            return ( value == null || value == '' || value == undefined || value.length < 1);
        }

        //funcion para saber si no hay proyectos en el area (vacio)
        function isEmptyResponse(response){
            return (response.length == 0 || response == [] || response == null)
        }

    </script>
@endpush

<div class="column">
    <div class="">
        <div>
            <label for="">{{$label}}</label>
            <input id="search-for-input" name="{{$nameField}}" class="form-control" type="search"
            placeholder="Buscar....">

            <div class="spinner-grow text-primary " role="status" >
                <span class="visually-hidden" id="spinner-loading-input-filter" style="display: none">Buscando...</span>
            </div>

            <div class="container-error-msg">
                <span class="text-danger" id="error-search-projects-input-filter"></span>
            </div>

        </div>
    </div>

    <div class="pl-2">
        <label for="">.</label>
        <button class="btn form-control btn-sm bg-primary px-2 py-2 rounded" type="button" id="btn-buscar">
            <img width="23em" height="23em" src="img/search.png"
            alt="" style="margin-bottom: .1em">
        </button>
    </div>

</div>