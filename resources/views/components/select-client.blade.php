{{--
    Este componente muestra las categorias de los clientes

--}}

<div>
    @push('scripts')
        <script type="module">
            //se maneja en milisegundos
            const timeLoad = 1000;

            //escuchamos el evento, cuando cambie la categoria n1 seleccionada
            $('#id-category').on('input', function(){

                let categoryN1 = $(this).prop('value');

                //comprobamos que no sea el valor por defecto o valor vacio
                if(isEmptyValue(categoryN1) ){
                    return;
                }

                //mostramos el spin de carga y deshabilitamos el el select
                setDisplaySpinnerLoadCategory('id-spinner-categori-n2',true);
                document.getElementById('id-category').setAttribute('disabled',true);
                document.getElementById('id-client-user-n2').setAttribute('disabled',true);
                document.getElementById('id-client-user-n3').setAttribute('disabled',true);
                

                $.ajax({
                    async: true,
                    type: 'GET',
                    dataType: 'json',
                    url: '{{route("clients.n2.get",["category_name"=>":category_name"])}}'.replace(':category_name',categoryN1),

                    success:function(data){
                        //console.log(data);

                        //vaciamos el select y el campo donde se muestra el campo completo
                        $('#id-client-user-n2').empty();
                        $('#id-client-user-n3').empty();

                        clearFullName();

                        //agregamos una opcion por defecto
                        $('#id-client-user-n2').append('<option value=""> Seleccione un tipo</option>');
                        $('#id-client-user-n3').append('<option value=""> Seleccione un tipo</option>');


                        //agregamos las nuevas opciones
                        $.each(data, function(key,value){
                            $('#id-client-user-n2').append(`<option value="${value}">${value}</option>`);
                        });

                        setTimeout(()=>{
                            //escondemos el spinner y habilitamos el select
                            setDisplaySpinnerLoadCategory('id-spinner-categori-n2',false);
                            document.getElementById('id-category').removeAttribute('disabled');
                            document.getElementById('id-client-user-n2').removeAttribute('disabled');
                            document.getElementById('id-client-user-n3').removeAttribute('disabled');

                        },timeLoad);


                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }); 

            //escuchamos el evento, cuando cambie la categoria n2 seleccionada, buscamos el nivel 3 basado en los niveles anteriores
            $('#id-client-user-n2').on('input', function(){
                let categoryN2 = $(this).prop('value'), 
                categoryN1 = $('#id-category').prop('value');

                //comprobamos que no sean los valores por defecto o valor vacio
                if(isEmptyValue(categoryN1) || isEmptyValue(categoryN2)){
                    return;
                }

                 //mostramos el spin de carga y deshabilitamos el el select
                setDisplaySpinnerLoadCategory('id-spinner-categori-n3',true);
                document.getElementById('id-category').setAttribute('disabled',true);
                document.getElementById('id-client-user-n2').setAttribute('disabled',true);
                document.getElementById('id-client-user-n3').setAttribute('disabled',true);


                $.ajax({
                    async: true,
                    type: 'GET',
                    dataType: 'json',
                    url: '{{route("clients.n3.get",["category_name_1"=>":category_name_1","category_name_2"=>":category_name_2"])}}'.replace(':category_name_1',categoryN1)
                                                                                                                                    .replace(':category_name_2',categoryN2),
                    success:function(data){

                        //vaciamos el select
                        $('#id-client-user-n3').empty();
                        clearFullName();

                        //agregamos una opcion por defecto
                        $('#id-client-user-n3').append('<option value=""> Seleccione un tipo</option>');


                        //agregamos las nuevas opciones
                        $.each(data, function(key,value){
                            $('#id-client-user-n3').append(`<option value="${value}">${value}</option>`);
                        });

                        //ocultamos el spin de carga y habilitamos el el select
                        setTimeout(() => {
                            setDisplaySpinnerLoadCategory('id-spinner-categori-n3',false);
                            document.getElementById('id-category').removeAttribute('disabled');
                            document.getElementById('id-client-user-n2').removeAttribute('disabled');
                            document.getElementById('id-client-user-n3').removeAttribute('disabled');
                        }, timeLoad);

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);

                    },
                });
            }); 


            //escuchamos el evento, cuando cambie la categoria n2 seleccionada, buscamos el id y nombre del cliente basado en los niveles anteriores
            $('#id-client-user-n3').on('input', function(){
                let categoryN3 = $(this).prop('value'), 
                categoryN2 = $('#id-client-user-n2').prop('value'),
                categoryN1 = $('#id-category').prop('value');

                //comprobamos que no sean los valores por defecto o valor vacio
                if(isEmptyValue(categoryN1) || isEmptyValue(categoryN2) || isEmptyValue(categoryN3)){
                    return;
                }
                setDisplaySpinnerLoadCategory('id-spinner-full-name',true);


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
                            setDisplaySpinnerLoadCategory('id-spinner-full-name',false);
                            //mostramos el nombre completo y setamos el id del cliente
                            $('#id-client-full-name').val(`${categoryN1} | ${categoryN2} | ${categoryN3}`);
                            $('#id-userpot').val(data[0].id);
                        },timeLoad);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
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
                $('#id-client-full-name').val('');
            }


            //mandamos a llamar la funcion para esconder el spinner
            hiddeAllSpinners();

        </script>

    @endpush


    <div class="container-client-select" >

        <div class="title-container pb-2">
            <label class="label-form"><strong>{{$label}}</strong></label>
        </div>
        <div class="row row-cols-3">
            <div class="col-2">
                <span>Categoría (Nivel 1):</span>
            </div>
            <div class="col-4"><span>Categoría (Nivel 2):</span></div>
            <div class="col-6"><span>Categoría (Nivel 3):</span></div>

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
                        <span class="visually-hidden">Loading...</span>
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
                        <span class="visually-hidden">Loading...</span>
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
                        <span class="visually-hidden">Loading...</span>
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
                <span class="visually-hidden">Loading...</span>
            </div>
            
            <div class="container-error-msg">
                <span class="text-danger" id="error-full-name"></span>
            </div>
        </div>

        <span class="text-danger">@error($nameField) {{$message}} @enderror</span>
    </div>

</div>