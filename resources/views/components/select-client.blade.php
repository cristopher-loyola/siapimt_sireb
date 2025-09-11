{{--
    Este componente muestra las categorias de los clientes

--}}

<div>
    @push('scripts')
        <script type="module">
            //funcion que genera un id unico para cada componente de 8 digitos con numeros y letras
            function generateId(){
                return Math.random().toString(36).substring(2, 10);
            }

            //se maneja en milisegundos
            const timeLoad = 1000;

            const idElements = {
                "idCategoryN1Select": `id-category-${generateId()}`,
                "idCategoryN2Select": `id-client-user-n2-${generateId()}`,
                "idCategoryN3Select": `id-client-user-n3-${generateId()}`,
                "idClientFullName": `id-client-full-name-${generateId()}`,
                "idUserpot": `id-userpot-${generateId()}`,
                //spinners
               "idSpinnerCategoryN1": `id-spinner-categori-n1-${generateId()}`,
                "idSpinnerCategoryN2": `id-spinner-categori-n2-${generateId()}`,
                "idSpinnerCategoryN3": `id-spinner-categori-n3-${generateId()}`,
                "idSpinnerFullName": `id-spinner-full-name-${generateId()}`,
                //errores
                "idErrorCategoryN1": `error-category-n1-${generateId()}`,
                "idErrorCategoryN2": `error-category-n2-${generateId()}`,
                "idErrorCategoryN3": `error-category-n3-${generateId()}`,
                "idErrorFullName": `error-full-name-${generateId()}`,

                "idErrorComponent": `error-component-message-${generateId()}`,

                //id del contenedor
                'idSelectorClient':`selector-element-${generateId()}`
            }

            function setIdElements(){
                document.getElementById('id-category').setAttribute('id',idElements.idCategoryN1Select);
                document.getElementById('id-client-user-n2').setAttribute('id',idElements.idCategoryN2Select);
                document.getElementById('id-client-user-n3').setAttribute('id',idElements.idCategoryN3Select);
                document.getElementById('id-client-full-name').setAttribute('id',idElements.idClientFullName);
                document.getElementById('id-userpot').setAttribute('id',idElements.idUserpot);
                document.getElementById('id-spinner-categori-n1').setAttribute('id',idElements.idSpinnerCategoryN1);
                document.getElementById('id-spinner-categori-n2').setAttribute('id',idElements.idSpinnerCategoryN2);
                document.getElementById('id-spinner-categori-n3').setAttribute('id',idElements.idSpinnerCategoryN3);
                document.getElementById('id-spinner-full-name').setAttribute('id',idElements.idSpinnerFullName);
                document.getElementById('error-category-n1').setAttribute('id',idElements.idErrorCategoryN1);
                document.getElementById('error-category-n2').setAttribute('id',idElements.idErrorCategoryN2);
                document.getElementById('error-category-n3').setAttribute('id',idElements.idErrorCategoryN3);
                document.getElementById('error-full-name').setAttribute('id',idElements.idErrorFullName);
                document.getElementById('error-component-message').setAttribute('id',idElements.idErrorComponent);
                document.getElementById('selector-element').setAttribute('id',idElements.idSelectorClient);
            }
            setIdElements();

            //escuchamos el evento, cuando cambie la categoria n1 seleccionada
            $(`#${idElements.idCategoryN1Select}`).on('input', function(){

                let categoryN1 = $(this).prop('value');
                const filterN2 = document.getElementById(idElements.idSelectorClient).dataset.filter;
                //ruta para obtener todas las categorias n2 con filtro por area
                let urlApi = '{{route("clients.n2.get",["category_name"=>":category_name"])}}'.replace(':category_name',categoryN1);

                //comprobamos que no sea el valor por defecto o valor vacio
                if(isEmptyValue(categoryN1) ){
                    return;
                }

                //quitamos mensajes de error
                clearErrorComponentMessage();
                //mostramos el spin de carga y deshabilitamos el el select
                setDisplaySpinnerLoadCategory(idElements.idSpinnerCategoryN2,true);
                document.getElementById(idElements.idCategoryN1Select).setAttribute('disabled',true);
                document.getElementById(idElements.idCategoryN2Select).setAttribute('disabled',true);
                document.getElementById(idElements.idCategoryN3Select).setAttribute('disabled',true);
                //ruta para obtener todas las categorias n2 sin filtro por area
                if(filterN2 == 'false'){
                    urlApi = '{{route("clients.n2.all",["category_name_1"=>":category_name_1"])}}'.replace(':category_name_1',categoryN1);
                }

                $.ajax({
                    async: true,
                    type: 'GET',
                    dataType: 'json',
                    url: urlApi,

                    success:function(data){
                        //console.log(data);

                        //vaciamos el select y el campo donde se muestra el campo completo
                        $(`#${idElements.idCategoryN2Select}`).empty();
                        $(`#${idElements.idCategoryN3Select}`).empty();

                        clearFullName();

                        //agregamos una opcion por defecto
                        $(`#${idElements.idCategoryN2Select}`).append('<option value=""> Seleccione un tipo</option>');
                        $(`#${idElements.idCategoryN3Select}`).append('<option value=""> Seleccione un tipo</option>');


                        //agregamos las nuevas opciones
                        $.each(data, function(key,value){
                            $(`#${idElements.idCategoryN2Select}`).append(`<option value="${value}">${value}</option>`);
                        });

                        setTimeout(()=>{
                            //escondemos el spinner y habilitamos el select
                            setDisplaySpinnerLoadCategory(idElements.idSpinnerCategoryN2,false);
                            document.getElementById(idElements.idCategoryN1Select).removeAttribute('disabled');
                            document.getElementById(idElements.idCategoryN2Select).removeAttribute('disabled');
                            document.getElementById(idElements.idCategoryN3Select).removeAttribute('disabled');

                        },timeLoad);


                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        setErrorComponentMessage(`Ha ocurrido un error: ${xhr.status} - ${thrownError}.\n Por favor intente de nuevo`);
                        hiddeAllSpinners();
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }); 

            //escuchamos el evento, cuando cambie la categoria n2 seleccionada, buscamos el nivel 3 basado en los niveles anteriores
            $(`#${idElements.idCategoryN2Select}`).on('input', function(){
                let categoryN2 = $(this).prop('value'), 
                categoryN1 = $(`#${idElements.idCategoryN1Select}`).prop('value');

                //comprobamos que no sean los valores por defecto o valor vacio
                if(isEmptyValue(categoryN1) || isEmptyValue(categoryN2)){
                    return;
                }

                //quitamos mensajes de error
                clearErrorComponentMessage();
                 //mostramos el spin de carga y deshabilitamos el el select
                setDisplaySpinnerLoadCategory(idElements.idSpinnerCategoryN3,true);
                document.getElementById(idElements.idCategoryN1Select).setAttribute('disabled',true);
                document.getElementById(idElements.idCategoryN2Select).setAttribute('disabled',true);
                document.getElementById(idElements.idCategoryN3Select).setAttribute('disabled',true);


                $.ajax({
                    async: true,
                    type: 'GET',
                    dataType: 'json',
                    url: '{{route("clients.n3.get",["category_name_1"=>":category_name_1","category_name_2"=>":category_name_2"])}}'.replace(':category_name_1',categoryN1)
                                                                                                                                    .replace(':category_name_2',categoryN2),
                    success:function(data){

                        //vaciamos el select
                        $(`#${idElements.idCategoryN3Select}`).empty();
                        clearFullName();

                        //agregamos una opcion por defecto
                        $(`#${idElements.idCategoryN3Select}`).append('<option value=""> Seleccione un tipo</option>');


                        //agregamos las nuevas opciones
                        $.each(data, function(key,value){
                            $(`#${idElements.idCategoryN3Select}`).append(`<option value="${value}">${value}</option>`);
                        });

                        //ocultamos el spin de carga y habilitamos el el select
                        setTimeout(() => {
                            setDisplaySpinnerLoadCategory(idElements.idSpinnerCategoryN3,false);
                            document.getElementById(idElements.idCategoryN1Select).removeAttribute('disabled');
                            document.getElementById(idElements.idCategoryN2Select).removeAttribute('disabled');
                            document.getElementById(idElements.idCategoryN3Select).removeAttribute('disabled');
                        }, timeLoad);

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        setErrorComponentMessage(`Ha ocurrido un error: ${xhr.status} - ${thrownError}.\n Por favor intente de nuevo`);
                        hiddeAllSpinners();
                        console.log(xhr.status);
                        console.log(thrownError);

                    },
                });
            }); 


            //escuchamos el evento, cuando cambie la categoria n2 seleccionada, buscamos el id y nombre del cliente basado en los niveles anteriores
            $(`#${idElements.idCategoryN3Select}`).on('input', function(){
                let categoryN3 = $(this).prop('value'), 
                categoryN2 = $(`#${idElements.idCategoryN2Select}`).prop('value'),
                categoryN1 = $(`#${idElements.idCategoryN1Select}`).prop('value');

                //comprobamos que no sean los valores por defecto o valor vacio
                if(isEmptyValue(categoryN1) || isEmptyValue(categoryN2) || isEmptyValue(categoryN3)){
                    return;
                }

                //quitamos mensajes de error
                clearErrorComponentMessage();
                setDisplaySpinnerLoadCategory(idElements.idSpinnerFullName,true);


                //solicitamos el id y el nombre completo del registro con las 3 categorias
                $.ajax({
                    async: true,
                    type: 'GET',
                    dataType: 'json',
                    url: '{{route("clients.fullname",["nivel1"=>":nivel1","nivel2"=>":nivel2","nivel3"=>":nivel3"])}}'.replace(':nivel1',categoryN1)
                                                                                                                      .replace(':nivel2',categoryN2)
                                                                                                                      .replace(':nivel3',categoryN3),
                    success:function(data){
                        //limpiamos el campo del nombre completo
                        clearFullName();
                        setTimeout(()=>{
                            setDisplaySpinnerLoadCategory(idElements.idSpinnerFullName,false);
                            //mostramos el nombre completo y setamos el id del cliente
                            $(`#${idElements.idClientFullName}`).val(`${categoryN1} | ${categoryN2} | ${categoryN3}`);
                            $(`#${idElements.idUserpot}`).val(data[0].id);
                        },timeLoad);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        setErrorComponentMessage(`Ha ocurrido un error: ${xhr.status} - ${thrownError}.\n Por favor intente de nuevo`);
                        hiddeAllSpinners();
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }); 

            //funcion para comprobar que un valor no esta vacio
            function isEmptyValue(value){
                return (value == '' || value == null || value == undefined);
            }

            //mostrar/ocultar un spinner por su id
            function setDisplaySpinnerLoadCategory(id,visible=false){
                let display = visible == false ? 'none' : 'block';
                
                $('#'+id).css({'display':display});
            }

            function hiddeAllSpinners(){
                    //recuperamos todos los sppiners para ocultarlos
                    let spinners = $('.spinner-border');
                    $.each(spinners,function(index,item){
                        setDisplaySpinnerLoadCategory(item.id,false);
                    });
            }

            //limpiamos el campo de fullname
            function clearFullName(){
                $(`#${idElements.idClientFullName}`).val('');
            }

            //muestra el mensaje de error al usuario
            function setErrorComponentMessage(message){
                document.getElementById(idElements.idErrorComponent).textContent = message;
            }
            //limpia el contenido del mensaje de error del compoennte
            function clearErrorComponentMessage(){
                document.getElementById(idElements.idErrorComponent).textContent = '';
            }
            //mandamos a llamar la funcion para esconder el spinner
            hiddeAllSpinners();

        </script>
    @endpush


    <div class="container-client-select" id="selector-element" data-filter="{{ $filterN2 ? 'true' : 'false' }}">

        <div class="title-container pb-2">
            <label class="label-form"><strong>{{$label}}</strong></label>
        </div>
        <div class="row row-cols-3">
            <div class="col-2">
                <span>Categoría (Nivel 1)</span>
            </div>
            <div class="col-4"><span>Categoría (Nivel 2)</span></div>
            <div class="col-6"><span>Categoría (Nivel 3)</span></div>

            <div class="col-2">                
                <select name="category" id="id-category" class="form-select form-control" aria-label="Categoría">
                    <option value=""> Seleccione un tipo</option>
                    {{--- por si tiene un valor de cliente --}}
                    @if (!empty($cliente))
                        <option value="{{$cliente->nivel1}}" selected>{{$cliente->nivel1}}</option>

                        @foreach ($categories as $category)
                            @if($category != $cliente->nivel1)
                                <option value="{{$category}}">{{$category}}</option>
                            @endif
                        @endforeach
                    @else
                        @foreach ($categories as $category)
                            <option value="{{$category}}">{{$category}}</option>
                        @endforeach
                    @endif
                </select> 
                <div class="container-spinner pt-2 d-flex justify-content-center" >
                    <div class="spinner-border" role="status" id="id-spinner-categori-n1">
                        <span class="visually-hidden">Cargando...</span>
                    </div>

                    <div class="container-error-msg">
                        <span class="text-danger" id="error-category-n1"></span>
                    </div>

                </div>
            </div>

            <div class="col-4">
                <select name="client_user_n2" id="id-client-user-n2" class="form-select form-control" aria-label="Categoría (Nivel 2):">
                    <option value=""> Seleccione un tipo</option>

                     @if(!empty($cliente) && !empty($categoriesN2))
                         <option value="{{$cliente->nivel2}}" selected>{{$cliente->nivel2}}</option>

                         @foreach ($categoriesN2 as $categoryN2)
                            @if($categoryN2 != $cliente->nivel2)
                                <option value="{{$categoryN2}}">{{$categoryN2}}</option>
                            @endif
                             
                         @endforeach
                     @endif

                </select>

                <div class="container-spinner pt-2 d-flex justify-content-center" >
                    <div class="spinner-border" role="status" id="id-spinner-categori-n2">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    
                    <div class="container-error-msg">
                        <span class="text-danger" id="error-category-n2"></span>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <select name="client_user_n3"N3 id="id-client-user-n3" class="form-select form-control" aria-label="Categoría (Nivel 3):">
                    <option value=""> Seleccione un tipo</option>

                    @if(!empty($cliente) && !empty($categoriesN3))
                        <option value="{{$cliente->nivel3}}" selected>{{$cliente->nivel3}}</option>

                        @foreach ($categoriesN3 as $categoryN3)
                            @if($categoryN3 != $cliente->nivel3)
                                <option value="{{$categoryN3}}">{{$categoryN3}}</option>
                            @endif
                            
                        @endforeach
                    @endif
                </select>

                <div class="container-spinner pt-2 d-flex justify-content-center" >
                    <div class="spinner-border" role="status" id="id-spinner-categori-n3">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    
                    <div class="container-error-msg">
                        <span class="text-danger" id="error-category-n3"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="input-cliente p-3 row ">

            {{--- por si tiene un valor de cliente --}}
            @if (empty($cliente))
                <input name="client_full_name" id="id-client-full-name" class="form-control" type="text" value="" aria-label="{{$label}}" readonly>
                <input type="hidden" name="{{$nameField}}" id="id-userpot"  value="" />
            @else
                <input name="client_full_name" id="id-client-full-name" class="form-control" type="text" value=" {{$cliente->nivel1.' | '.$cliente->nivel2.' | '.$cliente->nivel3}}" aria-label="Cliente o usuario potencial" readonly>
                <input type="hidden" name="{{$nameField}}" id="id-userpot"  value="{{$cliente->id}}" />
            @endif

        <div class="container-spinner pt-2 d-flex justify-content-center" >
            <div class="spinner-border" role="status" id="id-spinner-full-name">
                <span class="visually-hidden">Cargando...</span>
            </div>
            
            <div class="container-error-msg">
                <span class="text-danger" id="error-full-name"></span>
            </div>
        </div>

        <div class=" pt-2 d-flex justify-content-center text-danger" >
            <p id="error-component-message"></p>
        </div>

        <span class="text-danger">@error($nameField) {{$message}} @enderror</span>
    </div>

</div>