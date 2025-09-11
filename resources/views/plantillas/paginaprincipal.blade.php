@extends('plantillas/plantilla')
@section('contenido')
<title>Inicio</title>
<style>
  #buscar{
    padding-top: 7px;
    background: #016099;
  }
  #buscar:hover{
    background: #3393cf;
  }
  
  .space-between-vertical{
    display: flex;
    gap: .2rem;
    flex-direction: column;
  }
  .center{
    display: flex;
    justify-content: center;
    align-content: center;
  }
  </style>
  
  <script type="module" lang="text/javascript">

      //escuchamos el evento de cuando se obtenga respuesta del select 
      document.addEventListener('selectResponse',function(e){

        if(e.detail.data){
          //recuperamos los datos de la peticion
          const projectsArea = e.detail.data;
          //no se hace nada si no hay proyectos por mostrar, se muestra aviso en el componente que realiza el response
          if(isEmptyResponse(projectsArea)){
            return;
          }

          const projectsTable = document.getElementById('projects-list');
          projectsTable.innerHTML = '';

          let itemProject;
          projectsArea.forEach(function(item){
            itemProject = createItemProject(item.id,getKeyProject(item.claven,item.clavea,item.clavet,item.clavey),
            item.nomproy,item.fecha_inicio,item.fecha_fin,`${item.Nombre} ${item.Apellido_Paterno} ${item.Apellido_Materno}`,item.duracionm,
            item.costo,item.progreso,item.estado,item.label_status,item.label_color,item.label_negotiation,item.porcent_program);
            projectsTable.appendChild(itemProject);
          });
        }

        if(e.detail.error){
          console.log(e.detail.error);
        }
 

      });

      //escuchamos el evento de respuesta de busqueda por input
      document.addEventListener('responseSearchInput',function(e){

        if(e.detail.data){
          //recuperamos los datos de la peticion
          const projectsArea = e.detail.data;
          //no se hace nada si no hay proyectos por mostrar, se muestra aviso en el componente que realiza el response
          if(isEmptyResponse(projectsArea)){
            return;
          }

          const projectsTable = document.getElementById('projects-list');
          projectsTable.innerHTML = '';

          let itemProject;
          projectsArea.forEach(function(item){
            itemProject = createItemProject(item.id,getKeyProject(item.claven,item.clavea,item.clavet,item.clavey),
            item.nomproy,item.fecha_inicio,item.fecha_fin,`${item.Nombre} ${item.Apellido_Paterno} ${item.Apellido_Materno}`,item.duracionm,
            item.costo,item.progreso,item.estado,item.label_status,item.label_color,item.label_negotiation,item.porcent_program);
            projectsTable.appendChild(itemProject);
          });

        }

        if(e.detail.error){
          console.log(e.detail.error);
        }

      });

      //crea la fila con el registro del proyecto 
      function createItemProject(id,claveProyecto,nombreProyecto,fechaInicio,fechaFin
      ,responsable,duracionMeses,costo,progreso,estado, etiquetaEstado,colorEtiqueta,negociacionEtiqueta,
      progresoProgramado
     ){

        let rowProject = document.createElement('tr');
        rowProject.classList.add('table');
        rowProject.classList.add('align-middle');

        const claveProy = document.createElement('td'); claveProy.textContent = claveProyecto;
        const tdNameProy = document.createElement('td'); 
        //agregamos el href para direccion a la pagina de edicion 
        const hrefNameProy = document.createElement('a');
        hrefNameProy.href = '{{route("infoproys",["id"=>":id"])}}'.replace(':id',id); hrefNameProy.textContent = nombreProyecto;
        tdNameProy.appendChild(hrefNameProy);
        const fechaI = document.createElement('td'); fechaI.textContent = fechaInicio;
        const fechaF = document.createElement('td'); fechaF.textContent = fechaFin;
        const userResp = document.createElement('td'); userResp.textContent = responsable;
        const durationM = document.createElement('td'); durationM.textContent = duracionMeses == null ? 'Por definir' : duracionMeses+' meses';
        const cost = document.createElement('td'); cost.textContent = '$'+costo;
        const tdProgresses = document.createElement('td');

        //const progress = getProgressProject(progreso,estado);

        const progressProgram = getProgressBar(progresoProgramado,estado,'P');
        const progress = getProgressBar(progreso,estado,'R');

        const status = getStatusProject(etiquetaEstado,colorEtiqueta,negociacionEtiqueta);

        const porcentsBar = document.createElement('div');
        porcentsBar.classList.add('container-progress-bar');
        porcentsBar.classList.add('space-between-vertical');
        //pegamos las barras al contenedor
        porcentsBar.appendChild(progressProgram);
        porcentsBar.appendChild(progress);
        //pegamso en la columna las barras de porcentaje
        tdProgresses.appendChild(porcentsBar);

        rowProject.appendChild(claveProy);
        rowProject.appendChild(tdNameProy);
        rowProject.appendChild(fechaI);
        rowProject.appendChild(fechaF);
        rowProject.appendChild(userResp);
        rowProject.appendChild(durationM);
        rowProject.appendChild(cost);
        rowProject.appendChild(tdProgresses);
        rowProject.appendChild(status);

        return rowProject;
      }

      //crea la clave del proyeto
      function getKeyProject(claveNumero,claveArea,claveTipo,claveAnio,){ 
        if( claveNumero < 10){
          return `${claveArea}${claveTipo}-0${claveNumero}/${claveAnio}`;
        }
        return `${claveArea}${claveTipo}-${claveNumero}/${claveAnio}`;
      }

      //determina el estado y color del proyecto
      function getStatusProject(etiquetaEstado,colorEtiqueta,etiquetaNegociacion){
        const td = document.createElement('td');
        const labelItem =  document.createElement('label'),
              span =  document.createElement('span'),
              label =  document.createElement('label');

        labelItem.classList.add('form-label');
        label.style.color = colorEtiqueta; label.textContent = etiquetaEstado;
        span.appendChild(label);

        if(etiquetaNegociacion != undefined ){
          const span2 = document.createElement('span'),
          br = document.createElement('br');
          span2.textContent = `(${etiquetaNegociacion})`;
          span2.style.color = colorEtiqueta;
          span.appendChild(br); span.appendChild(span2);
        }

        labelItem.appendChild(span);
        td.appendChild(labelItem);

        return td;
      }

      //retorna el color de la barra de progreso
      function getColorProgressBar(estado,type = ''){
        //posibles estados del proyecto        
        const progressColors = {
          //'1':'bg-primary',
          '1':'bg-success',
          '2':'bg-success',
          '3':'bg-warning',
          '4':'bg-info',
          '5':'bg-secondary',
        }
        const typePorgressColor = {
          'P':'bg-primary'
        }

        if(type == 'P'){
          return typePorgressColor['P'];
        }

        let colorProgress = progressColors[estado];

        if(colorProgress == undefined){
          colorProgress = 'bg-secondary';
        }

        return colorProgress;
      }

      //determina el progreso del proyecto
      function getProgressProject(progreso,estado,type){
        
        let colorProgress = getColorProgressBar(estado,type);

        let td = document.createElement('td');
        let div = document.createElement('div');
        let divProgressBar = document.createElement('div');
        div.classList.add('progress');div.style.height = '30px';div.style.background = '#575656';
        divProgressBar.classList.add('progress-bar');divProgressBar.classList.add('progress-bar-striped');divProgressBar.classList.add('progress-bar-animated');
        divProgressBar.classList.add(colorProgress);
        divProgressBar.role = 'progressbar';
        divProgressBar.style.width = `${progreso}%`;
        divProgressBar.ariaValueNow = '25';
        divProgressBar.ariaValueMin = '0';
        divProgressBar.ariaValueMax = '100';
        divProgressBar.textContent = `${progreso}%`;

        div.appendChild(divProgressBar);
        td.appendChild(div);

        return td;
      }

    function getProgressBar(progreso,estado,type){

      //elementos contenedores
      //contenedor del progressbar
      const divExpectedProgress = document.createElement('div'),
      //contains-progress-bar
      divContainProgressBar = document.createElement('div'),
      //contenedor de la etiqueta del tipo de porcentaje
      divContainType = document.createElement('div');

      //elementos para el progressbar
      let div = document.createElement('div'),
      divProgressBar = document.createElement('div'),
      tagType = document.createElement('strong');
      let colorProgress = getColorProgressBar(estado,type);

      //texto con el tipo de porcentaje
      divContainType.classList.add('pr-1');
      divContainType.style.float = 'left';
      tagType.textContent = type; 
      divContainType.appendChild(tagType);

      div.classList.add('progress');div.style.height = '30px';div.style.background = '#575656';
      divProgressBar.classList.add('progress-bar');divProgressBar.classList.add('progress-bar-striped');divProgressBar.classList.add('progress-bar-animated');
      divProgressBar.classList.add(colorProgress);
      divProgressBar.role = 'progressbar';
      divProgressBar.style.width = `${progreso}%`;
      divProgressBar.ariaValueNow = '25';
      divProgressBar.ariaValueMin = '0';
      divProgressBar.ariaValueMax = '100';
      divProgressBar.textContent = `${progreso}%`;
      div.appendChild(divProgressBar);

      divExpectedProgress.appendChild(divContainType);
      divContainProgressBar.appendChild(div);
      divExpectedProgress.appendChild(divContainProgressBar);

      return divExpectedProgress;
    }

      //funcion para saber si no hay proyectos en el area (vacio)
      function isEmptyResponse(response){
        return (response.length == 0 || response == [] || response == null)
      }

  </script>

    {{-- Principio de tabla de proyectos  --}}
    @if (Session::has('registered') && Session::has('key_project'))
    <script type="module">
      document.getElementById('btn-toogle-dialog-modal').click();
    </script>
      <div class="container-dialog-message">
      <div class="modal" tabindex="-1" id="modal-dialog-message" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{Session::get('registered')}}</h5>
              </div>
              <div class="modal-body">
                <p style="font-size: 2.5rem"><h6>La clave del proyecto registrado es: <strong class="text-primary">{{Session::get('key_project')}}</strong></h6></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog-message"
        id="btn-toogle-dialog-modal" style="display:none"></button> 
      </div>
    @endif



    <div class="container shadow-lg rounded font-weight-light">
        <br>
            <h2 class="text-center" id="title"> Proyectos</h2>
        <div>
          <form action="claveproy" method="get">
            <button type="submit" class="btn btn-success" id="redondb">
              <i class="bx bx-plus-circle bx-fw bx-flashing-hover"></i>
              Nuevo
            </button>
          </form>
          @if ($LoggedUserInfo['pcospii'] == 1)
            <form action="firmarcospiii" method="GET">
              <button type="submit" class="btn" id="redondb" style="background: #1373c1; color: white;">
                <img src="{{asset('/img/signature.png')}}" alt="" width="20px" height="20px" style="margin-bottom: 5px;">
                COSPIII
              </button>
            </form>
          @endif
        </div>
        <div class="container justify-content-center align-items-center mt-3">
                <div class="mb-0 input-group">
                  
                  <div class="mb-0 ">
                    <x-projects-by-area label="Área de adscripción:" :areasAdscripcion="$areasAdscripcion"/>
                  </div>

                  <div class="pl-4">
                    <x-projects-input-filter label="Clave, Nombre o Responsable" nameField="input_value_filter" nameEvent='responseSearchInput'/>
                  </div>

                </div>
        </div>
        <div class="text-right">
          <a href="{{ route('vistareportes')}}" class="btn btn-warning" tabindex="5" id="redondb">
            <i class="bx bxs-file-export bx-fw bx-flashing-hover"></i>
            Reportes
          </a>
        </div>
      <br>
      <table class=" table-sm table table-hover table-responsive-sm">
          <thead class="thead-dark">
              <tr>
                  <th scope="col" style="width: 5rem;">Clave</th>
                  <th scope="col" class="text-center">Nombre</th>
                  <th scope="col" class="text-center">Fecha de inicio</th>
                  <th scope="col" class="text-center">Fecha de fin</th>
                  <th scope="col" class="text-center">Responsable</th>
                  <th scope="col" class="text-center">Duración
                  </th>
                  <th scope="col" style="width: 7rem;" class="text-center">Costo</th>
                  <th scope="col" class="text-center" style="width: 7rem;">Progreso</th>
                  <th scope="col" style="width: 10rem;" class="text-center"> Estado</th>
                  <th scope="col">Reprogramado</th>
              </tr>
          </thead>
          <tbody id="projects-list">

            @foreach ($proy as $pr)
              <tr class="table align-middle" >

	     <?php if ($pr->claven < 10) { echo "<td>$pr->clavea$pr->clavet-0$pr->claven/$pr->clavey</td>"; }
          else{ echo "<td>$pr->clavea$pr->clavet-$pr->claven/$pr->clavey</td>"; }
            ?>
                  @if ($pr->completado == 1)
                    <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                  @else
                    @if($pr->estado != 4 && $pr->estado != 5)
                      <td><a href="{{ route('proydatos', $pr->id)}}">{{$pr->nomproy}}</a></td>
                    @else
                      <td><a href="{{ route('infoproys', $pr->id)}}">{{$pr->nomproy}}</a></td>
                    @endif
                  @endif
                  <td>{{$pr->fecha_inicio}}</td>
                  <td>{{$pr->fecha_fin}}</td>
                  <td>{{$pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno}}</td>
                  <td>
                    @if(isset($pr->duracionm))
                        {{$pr->duracionm}} Meses
                      @else
                        Por definir
                      @endif
                  </td>
                  <td>$ {{round($pr->costo,1)}}</td>
                  <td>
                    <div class="container-progress-bar space-between-vertical">

                      <a class="popup-link" href="{{route('resumenMensual', $pr->id)}}">

                        @if (isset($pr->porcent_program))
                        <div class="container-porcent-expected ">
                          <div class="contain-letter pr-1" style="float: left">
                            <strong>P</strong> 
                          </div>
                          <div class="contains-progress-bar">                          
                            <div class="progress" style="height: 30px; background:#575656; text-color">
                              <div
                                  class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                              role="progressbar" style="width: {{$pr->porcent_program}}%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                                {{$pr->porcent_program}}%
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif

                        <div style= "height: 3px"></div>

                        <div class="container-porcent-progress" >
                          @if (isset($pr->porcent_program))
                            <div class="contain-letter pr-1" style="float: left">
                            <strong>R</strong> 
                            </div>
                          @endif
                          <div class="contains-progress-bar">
                            @if ($pr->clavet == 'I')
                                @if ($pr->publicacion == 1)
                                    <div class="progress" style="height: 35px; background:#575656;">
                                        <div
                                        @if ($pr->estado == 5)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                        @elseif ($pr->estado == 3)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                        @elseif ($pr->estado == 2)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @elseif ($pr->estado == 1)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @else
                                            class="progress-bar progress-bar-striped progress-bar-animated  bg-success"
                                        @endif
                                        role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100" id="barra">
                                        <strong>{{$pr->progreso}}%</strong>
                                        <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                        </div>
                                    </div>
                                @elseif ($pr->publicacion == 2)
                                    <div class="progress" style="height: 35px; background:#575656;">
                                        <div
                                        @if ($pr->estado == 5)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                        @elseif ($pr->estado == 3)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                        @elseif ($pr->estado == 2)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @elseif ($pr->estado == 1)
                                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        @else
                                            class="progress-bar progress-bar-striped progress-bar-animated  bg-success"
                                        @endif
                                        role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100" id="barra">
                                        <strong>{{$pr->progreso}}%</strong>
                                        <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                        </div>
                                    </div>
                                @else
                                    @if ($pr->progreso == 100)
                                        <div class="progress" style="height: 35px; background:#575656;">
                                            <div
                                            @if ($pr->estado == 5)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            @elseif ($pr->estado == 3)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            @elseif ($pr->estado == 2)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @elseif ($pr->estado == 1)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @else
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @endif
                                            role="progressbar" style="width:98%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100" id="barra">
                                            <strong>98%</strong>
                                            <input type="text" value="98" id="progreso" name="progreso" hidden>
                                            </div>
                                        </div>
                                    @else
                                        <?php
                                            $pgreal = $pr->progreso;
                                            $comp = 98;
                                            $mult = ($comp*$pgreal);
                                            $div = ($mult/100);
                                            $psinp = round($div,0);
                                        ?>
                                        <div class="progress" style="height: 35px; background:#575656;">
                                            <div
                                            @if ($pr->estado == 5)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            @elseif ($pr->estado == 3)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            @elseif ($pr->estado == 2)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @elseif ($pr->estado == 1)
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            @else
                                                class="progress-bar progress-bar-striped progress-bar-animated  bg-success"
                                            @endif
                                            role="progressbar" style="width: {{$psinp}}%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100" id="barra">
                                            <strong>{{$psinp}}%</strong>
                                            <input type="text" value="{{$psinp}}" id="progreso" name="progreso" hidden>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @else
                                <div class="progress" style="height: 35px; background:#575656;">
                                    <div
                                    @if ($pr->estado == 5)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                    @elseif ($pr->estado == 3)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                    @elseif ($pr->estado == 2)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    @elseif ($pr->estado == 1)
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    @else
                                        class="progress-bar progress-bar-striped progress-bar-animated  bg-success"
                                    @endif
                                    role="progressbar" style="width: {{$pr->progreso}}%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" id="barra">
                                    <strong>{{$pr->progreso}}%</strong>
                                    <input type="text" value="{{$pr->progreso}}" id="progreso" name="progreso" hidden>
                                    </div>
                                </div>
                            @endif
                          </div>

                        </div>
                      </a>
                      </div>
                  </td>
                  <td>
                    <!-- se muestra la etiqueta del estado del proyecto, color y estado de negociacion -->
                    <label class="form-label" style="color: {{$pr->label_color}};">
                      <label >{{$pr->label_status}}</label>
                      <!---se muestra estado de negociacion del proyecto--->
                      @if(!empty($pr->label_negotiation)) 
                        <label style="color: {{$pr->label_color}};">
                            ({{$pr->label_negotiation}})
                        </label>
                      @endif
                    </label>
                  </td>
                  <td>
                    <?php
                      $contador = 0;
                      foreach ($tienerepro as $tmr) {
                        if ($tmr->idproyecto == $pr->id && $tmr->revisado == 1){
                          $contador++;
                        }
                      }
                    ?>
                    @if ($contador != 0)
                      REPROGRAMDO
                    @endif
                  </td>
              </tr>
            @endforeach
          </tbody>
      </table>
      <br>
      <div>
        <form action="claveproy" method="get">
            <button type="submit" class="btn btn-success" id="redondb">
              <i class="bx bx-plus-circle bx-fw bx-flashing-hover"></i>
              Nuevo
            </button>
        </form>
      </div>
      <div>
    </div>
    {{-- Fin de la tabla de proyectos --}}
@stop

@push('scripts')
<script>
  document.querySelectorAll(".popup-link").forEach(function(el) {
    el.addEventListener("click", function(e) {
      e.preventDefault();
      const url = el.getAttribute("href");
      window.open(url, "_popupResumen", "width=1040,height=350,scrollbars=yes, resizable=yes");  // Ajusta el tamaño
    });
  });
</script>
@endpush



