{{---
    Componente que solicita proyectos por un area de adscripcion 
--}}

<div>

    @push('scripts')
        <script type="module">
            //escuchamos el evento cuando se selecciona un area de adscripcion
            $('#id-area-adscripcion').on('input', function(){

                let areaAdscripcion = $('#id-area-adscripcion').prop('value');
                
                //si esta vacio no procedemos a la consulta
                if(isEmpty(areaAdscripcion)){return;}
                //mostramos el spinner de carga
                setVisibilitySpinner(true);
                clearErrorMessage();
                //lanzamos la peticion
                $.ajax({
                async:true,
                type:'GET',
                dataType: 'json',
                url: '{{route("projects.area",["name_area"=>":name_area"])}}'.replace(':name_area',areaAdscripcion),

                success:function(data){
                    //lanzamos un evento para que el componente padre pueda acceder a la respuesta 
                    if(isEmptyResponse(data)){
                        setErrorMessage("No se muestran registros asociados con el área ("+areaAdscripcion+")");
                    }
                    document.dispatchEvent(new CustomEvent('selectResponse',{detail:{data:data}}));
                    setVisibilitySpinner(false);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    document.dispatchEvent(new CustomEvent('selectResponse',{detail:{error:'Error al obtener'+thrownError}}));
                    setErrorMessage(thrownError);
                    setVisibilitySpinner(false);
                    alert(xhr.status);
                    alert(thrownError);
                    },
                });

                });
            //mostramos un mensaje de error en caso de que suceda
            function setErrorMessage(message){
                clearErrorMessage();
                $('#error-search-projects').text(message);
            }
            function clearErrorMessage(){
                $('#error-search-projects').empty();
            }
            //cambia la visibildiad del spinner de carga
            function setVisibilitySpinner(visible=false){
                const display = visible == true ? 'block' : 'none';
                $('#spinner-loading').css('display',display);
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

    <div class="container-content">
        <div class="select-container">
            <label for="">{{$label}}</label>
            {{---se muestran las areas de adsripcion que se envian con la pantalla desde la BD---}}
            <select name="area_adscripcion" id="id-area-adscripcion" class="form-select form-control" aria-label="Área de adscripción">
                <option value="">Seleccionar...</option>
            @foreach ($areasAdscripcion as $areaAdscripcion)
                <option value="{{$areaAdscripcion->nombre_area}}" class="item-area">{{$areaAdscripcion->nombre_area}} | {{$areaAdscripcion->inicial_clave}}</option>
            @endforeach

            </select>
        </div>

        <div class="spinner-grow text-primary " role="status" >
            <span class="visually-hidden" id="spinner-loading" style="display: none">Buscando...</span>
        </div>

        <div class="container-error-msg">
            <span class="text-danger" id="error-search-projects"></span>
        </div>

    </div>
</div>