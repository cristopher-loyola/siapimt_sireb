// javascript para el modal de nueva solicitud
$('.button').click(function(){
    var buttonId = $(this).attr('id');
    $('#modal-container').removeAttr('class').addClass(buttonId);
    $('body').addClass('modal-active');
  });

  // $('#modal-container').click(function(event){
  //   if (event.target === this) {
  //     $(this).addClass('out');
  //     $('body').removeClass('modal-active');

  //     // Esperar a que termine la animación de cierre antes de quitar la clase 'out'
  //     setTimeout(function() {
  //       $('#modal-container').removeClass('out');
  //     }, 300); // Ajusta el tiempo de acuerdo a la duración de tu animación CSS
  //   }
  // });

  // Selecciona el botón "Cancelar" por su ID
  var cancelButton = document.getElementById("cancel-button");
  // Agrega un evento click al botón "Cancelar"
  cancelButton.addEventListener("click", function() {
      // Obtén una referencia al modal-container por su ID
      var modalContainer = document.getElementById("modal-container");
      // Cierra el modal estableciendo su estilo "display" a "none"
      modalContainer.style.display = "none";
      // Recarga la página actual
      window.location.reload();
  });








  $(document).on("click", "#btnedit", function () {
    console.log('Código JavaScript ejecutado.');
    // Obtener los datos de la fila a través de los atributos de datos
    var id = $(this).data('id');
    var numeroregistro = $(this).data('numeroregistro');
    var nombrecliente = $(this).data('nombrecliente');
    var servicio = $(this).data('servicio');
    var costo = $(this).data('costo');
    var numerococ = $(this).data('numerococ');
    var fechainicio = $(this).data('fechainicio');
    var fechafin = $(this).data('fechafin');
    var duracion = $(this).data('duracion');
    var nombreservicio = $(this).data('nombreservicio');
    var porcentaje = $(this).data('porcentaje');
    var usuariosseleccionados = $(this).data('usuariosseleccionados');
    // Obtener la acción del formulario (a través del atributo de datos)
    var formAction = $(this).data('action');

    // Llenar los campos del formulario modal con los datos de la fila
    $('#numeroregistroedit').val(numeroregistro);
    $('#nombreclienteedit').val(nombrecliente);
    $('#servicioedit').val(servicio);
    $('#costoedit').val(costo);
    $('#numerocontratoedit').val(numerococ);
    $('#fechainicioedit').val(fechainicio);
    $('#fechafinedit').val(fechafin);
    $('#duracionedit').val(duracion);
    $('#nombreservicioedit').val(nombreservicio);
    $('#porcentajeedit').val(porcentaje);
    $('#usuarios_seleccionadosedit').val(usuariosseleccionados);
    $('#usuarios_seleccionadoseditMail').val(usuariosseleccionados);
    // Establecer la acción del formulario para el envío del formulario
    $('#editarForm').attr('action', formAction);


    // Declaración de variables para los elementos y arreglos
    const selectedOptionsListedit = document.getElementById("selected-options-editar");
    const usuariosSeleccionadosInputedit = document.getElementById("usuarios_seleccionadosedit");
    const selectedit = document.getElementById("oprtedit");
    const removeSelectedButtonedit = document.getElementById("remove-selected-edit");
    const removeAllButtonedit = document.getElementById("remove-all-edit");
    const usuariosSeleccionados = usuariosseleccionados.toString().split(','); // Convierte la cadena en un array

    // Función para actualizar el campo oculto y la lista de usuarios
    function actualizarUsuariosSeleccionados() {
      usuariosSeleccionadosInputedit.value = usuariosSeleccionados.join(",");
      selectedOptionsListedit.innerHTML = "";

      if (!usuariosSeleccionadosInputedit.value) {
      // Si no hay usuarios seleccionados, elimina cualquier elemento fantasma en la lista
      selectedOptionsListedit.innerHTML = "";
      usuariosSeleccionados.length = 0; // Vaciar el arreglo
      usuariosSeleccionadosInputedit.value = ""; // Vaciar el campo oculto
      } else {
      selectedOptionsListedit.innerHTML = ""; // Limpia la lista antes de agregar elementos nuevos
      usuariosSeleccionados.forEach(function (userId) {
        const listItem = document.createElement("li");
        listItem.dataset.userId = userId;
        const selectOption = selectedit.querySelector(`option[value="${userId}`);

        if (selectOption) {
          listItem.textContent = selectOption.getAttribute("data-nombre");
        } else {
          listItem.textContent = "Nombre del usuario desconocido";
        }

        selectedOptionsListedit.appendChild(listItem);
      });
    }
  }

// Evento para eliminar un usuario seleccionado
removeSelectedButtonedit.addEventListener("click", function () {
  const selectedItems = selectedOptionsListedit.querySelectorAll("li.selectedsoli");
  selectedItems.forEach(function (item) {
    const userId = item.dataset.userId;

    const index = usuariosSeleccionados.indexOf(userId);
    if (index !== -1) {
      usuariosSeleccionados.splice(index, 1);
    }

    item.remove();
  });

  actualizarUsuariosSeleccionados(); // Asegúrate de actualizar los usuarios seleccionados
});

    // Evento para eliminar todos los usuarios seleccionados
    removeAllButtonedit.addEventListener("click", function () {
      selectedOptionsListedit.innerHTML = "";
      usuariosSeleccionados.length = 0; // Vaciar el arreglo
      usuariosSeleccionadosInputedit.value = ""; // Vaciar el campo oculto
    });

    // Evento para seleccionar nuevos participantes con el select
    selectedit.addEventListener("change", function () {
      if (selectedit.value) {
        const optionText = selectedit.options[selectedit.selectedIndex].text;
        const optionValue = selectedit.value;

        const isDuplicate = Array.from(selectedOptionsListedit.children).some(item => item.dataset.userId === optionValue);

        if (isDuplicate) {
          errorContaineredit.textContent = "Este elemento ya está en la lista.";
          return;
        }

        const listItem = document.createElement("li");
        listItem.textContent = optionText;
        listItem.dataset.userId = optionValue;
        selectedOptionsListedit.appendChild(listItem);

        usuariosSeleccionados.push(optionValue);
        actualizarUsuariosSeleccionados();

        selectedit.value = "";
        errorContaineredit.textContent = "";
      }
    });

    selectedOptionsListedit.addEventListener("click", function (e) {
      const target = e.target;
      if (target.tagName === "LI") {
        target.classList.toggle("selectedsoli");
      }
    });

    actualizarUsuariosSeleccionados()


    // Abrir el modal
    $('#modal-container-editar').removeAttr('class').addClass('five-editar'); // O la clase específica de tu botón
    $('body').addClass('modal-active');

});

  // Resto de tu código para cerrar el modal y recargar la página al hacer clic en "Cancelar"
  var cancelButton = document.getElementById('cancel-button-editar');

  cancelButton.addEventListener('click', function () {
    var modalContainer = document.getElementById('modal-container-editar');
    modalContainer.style.display = 'none';
    window.location.reload();
  });



$(document).ready(function() {
  // Captura el evento de clic en el campo de búsqueda
  $("#searchInputedit").on("click", function() {
      // Abre el select y ajusta la altura
      $("#oprtedit").attr("size", 5); // Puedes ajustar el número de elementos visibles según tus preferencias
  });

  // Captura el evento de cambio en el campo de búsqueda
  $("#searchInputedit").on("input", function() {
      var searchText = $(this).val().toLowerCase();
      // Filtra las opciones del select
      $("#oprtedit option").each(function() {
          var optionText = $(this).text().toLowerCase();
          if (optionText.indexOf(searchText) !== -1) {
              $(this).show();
          } else {
              $(this).hide();
          }
      });
  });

  // Captura el evento de cierre de la lista al hacer clic en cualquier parte de la página
  $(document).on("click", function(event) {
      if (!$(event.target).closest("#searchInputedit, .select-container-edit").length) {
          // Cierra el select y ajusta la altura
          $("#oprtedit").removeAttr("size");
      }
  });
});








  // javascript para el modal de eliminar
  $(document).on("click", "#btnelimR",function(){
    console.log('Código JavaScript ejecutado.');

    // Obtener la acción del formulario (a través del atributo de datos)
    var formActionElim = $(this).data('idelim');

    // Establecer la acción del formulario para el envío del formulario
    $('#elimFormR').attr('action', formActionElim);

    $('#modal-container-eliminar').removeAttr('class').addClass('five-eliminar');
    $('body').addClass('modal-active');
  });
  // Resto de tu código para cerrar el modal y recargar la página al hacer clic en "Cancelar"
  var cancelButton = document.getElementById('cancel-button-eliminar');

  cancelButton.addEventListener('click', function () {
    var modalContainer = document.getElementById('modal-container-eliminar');
    modalContainer.style.display = 'none';
    window.location.reload();
  });


    $(document).on("click", "#btneliminar",function(){
      console.log('Código JavaScript ejecutado.');

      // Obtener la acción del formulario (a través del atributo de datos)
      var formActionEliminar = $(this).data('ideliminar');

      // Establecer la acción del formulario para el envío del formulario
      $('#eliminarForm').attr('action', formActionEliminar);

      $('#modal-container-eliminar-relacion').removeAttr('class').addClass('five-eliminar');
      $('body').addClass('modal-active');
    });
    // Resto de tu código para cerrar el modal y recargar la página al hacer clic en "Cancelar"
    var cancelButton = document.getElementById('cancel-button-eliminar-relacion');

    cancelButton.addEventListener('click', function () {
      var modalContainer = document.getElementById('modal-container-eliminar-relacion');
      modalContainer.style.display = 'none';
      window.location.reload();
    });







  // javascript para el modal de vizualizar
  $(document).on("click", "#btnviz",function(){
    console.log('Código JavaScript ejecutado.');

    // Obtener los datos de la fila a través de los atributos de datos
    var nombrepersona = $(this).data('nombrepersona');
    var numeroregistro = $(this).data('numeroregistro');
    var nombrecliente = $(this).data('nombrecliente');
    var servicio = $(this).data('servicio');
    var costo = $(this).data('costo');
    var numerococ = $(this).data('numerococ');
    var fechainicio = $(this).data('fechainicio');
    var fechafin = $(this).data('fechafin');
    var duracion = $(this).data('duracion');
    var nombreservicio = $(this).data('nombreservicio');
    var encargadoservicio = $(this).data('encargado');
    var usuariosseleccionados = $(this).data('usuariosseleccionados');

    // Llenar los campos del formulario modal con los datos de la fila
    $('#encargadoservicioviz').text(encargadoservicio);
    $('#numeroregistroviz').text(numeroregistro);
    $('#nombreregistroviz').text(nombrecliente);
    $('#servicioviz').text(servicio);
    $('#costoviz').text(costo);
    $('#numerocontratoviz').text(numerococ);
    $('#fechainicioviz').text(fechainicio);
    $('#fechafinviz').text(fechafin);
    $('#duracionviz').text(duracion);
    $('#nombreservicioviz').text(nombreservicio);

    // Declaración de variables para los elementos y arreglos
    const selectedOptionsParrafoEdit = document.getElementById("selected-options-paragraph-editar");
    const usuariosSeleccionadosInputEdit = document.getElementById("usuarios_seleccionadosedit");
    const selectedit = document.getElementById("oprtedit");
    const usuariosSeleccionados = usuariosseleccionados.toString().split(',');

    // Función para actualizar el campo oculto y el párrafo de usuarios seleccionados
    function actualizarUsuariosSeleccionadosEnParrafo() {
      usuariosSeleccionadosInputEdit.value = usuariosSeleccionados.join(",");

      if (!usuariosSeleccionadosInputEdit.value) {
        // Si no hay usuarios seleccionados
        selectedOptionsParrafoEdit.textContent = "No hay ningún participante seleccionado";
      } else {
        const usuariosSeleccionadosNombres = usuariosSeleccionados.map(function (userId) {
          const selectOption = selectedit.querySelector(`option[value="${userId}`);
          return selectOption ? selectOption.getAttribute("data-nombre") : nombreCompletoUsuario;
        });
        selectedOptionsParrafoEdit.textContent = usuariosSeleccionadosNombres.join("\n");
      }
    }


    actualizarUsuariosSeleccionadosEnParrafo();


    $('#modal-container-vizualizar').removeAttr('class').addClass('five-vizualizar');
    $('body').addClass('modal-active');
  });
  // Resto de tu código para cerrar el modal y recargar la página al hacer clic en "Cancelar"
  var cancelButton = document.getElementById('cancel-button-vizualizar');

  cancelButton.addEventListener('click', function () {
    var modalContainer = document.getElementById('modal-container-vizualizar');
    modalContainer.style.display = 'none';
    window.location.reload();
  });







    // javascript para el modal de avance
    $(document).on("click", "#btnavance",function(){
      console.log('Código JavaScript para avance ejecutado.');

      // Obtener la acción del formulario (a través del atributo de datos)
      var nombreservicio = $(this).data('nombreservicio');
      var numeroregistro = $(this).data('numeroregistro');
      var participacion = $(this).data('participacion');
      var descripcion = $(this).data('descripcion');
      var porcentaje = $(this).data('porcentaje');
      var id = $(this).data('id');
      // Obtener la acción del formulario (a través del atributo de datos)
      var formActionavance = $(this).data('idavance');

      // Llenar los campos del formulario modal con los datos de la fila
      $('#nombreservicioavance').val(nombreservicio);
      $('#numeroregistroavance').val(numeroregistro);
      $('#participacionavance').val(participacion);
      $('#descripcionavance').val(descripcion);
      $('#porcentajeavance').val(porcentaje);
      $('#registro_idedit').val(id);
      // Establecer la acción del formulario para el envío del formulario
      $('#avanceFormR').attr('action', formActionavance);


      $('#modal-container-avance').removeAttr('class').addClass('five-avance');
      $('body').addClass('modal-active');
    });
    // Resto de tu código para cerrar el modal y recargar la página al hacer clic en "Cancelar"
    var cancelButton = document.getElementById('cancel-button-avance');

    cancelButton.addEventListener('click', function () {
      var modalContainer = document.getElementById('modal-container-avance');
      modalContainer.style.display = 'none';
      window.location.reload();
    });





        // javascript para el modal de avance
        $(document).on("click", "#btnavance2",function(){
          console.log('Código JavaScript para avance ejecutado.');

          // Obtener la acción del formulario (a través del atributo de datos)
          var nombreservicio2 = $(this).data('nombreservicio');
          var numeroregistro2 = $(this).data('numeroregistro');
          var participacion2 = $(this).data('participacion');
          var descripcion2 = $(this).data('descripcion');
          var id2 = $(this).data('id');
          // Obtener la acción del formulario (a través del atributo de datos)
          var formActionavance2 = $(this).data('idavance2');

          // Llenar los campos del formulario modal con los datos de la fila
          $('#nombreservicioavance2').val(nombreservicio2);
          $('#numeroregistroavance2').val(numeroregistro2);
          $('#participacionavance2').val(participacion2);
          $('#descripcionavance2').val(descripcion2);
          $('#registro_idedit2').val(id2);
          // Establecer la acción del formulario para el envío del formulario
          $('#avanceFormR2').attr('action', formActionavance2);


          $('#modal-container-avance-integrante').removeAttr('class').addClass('five-avance-integrante');
          $('body').addClass('modal-active');

        });
        // Resto de tu código para cerrar el modal y recargar la página al hacer clic en "Cancelar"
        var cancelButton = document.getElementById('cancel-button-avance-integrante');

        cancelButton.addEventListener('click', function () {
          var modalContainer = document.getElementById('modal-container-avance-integrante');
          modalContainer.style.display = 'none';
          window.location.reload();
        });









// Javascript para la selecion de los participantes con el Select
document.addEventListener("DOMContentLoaded", function () {
  const select = document.getElementById("oprt");
  const selectedOptionsList = document.getElementById("selected-options-solicitudes");
  const removeSelectedButton = document.getElementById("remove-selected");
  const removeAllButton = document.getElementById("remove-all");
  const errorContainer = document.getElementById("error-container");
  const usuariosSeleccionadosInput = document.getElementById("usuarios_seleccionados");

  const usuariosSeleccionados = []; // Arreglo para almacenar los IDs de usuarios seleccionados

  // Función para actualizar el campo oculto
  function updateHiddenInput() {
    usuariosSeleccionadosInput.value = usuariosSeleccionados.join(",");
  }

  select.addEventListener("change", function () {
    if (select.value) {
      const optionText = select.options[select.selectedIndex].text;
      const optionValue = select.value;

      const isDuplicate = Array.from(selectedOptionsList.children).some(function (item) {
        return item.dataset.userId === optionValue;
      });

      if (isDuplicate) {
        errorContainer.textContent = "Este elemento ya está en la lista.";
        return;
      }

      const listItem = document.createElement("li");
      listItem.textContent = optionText;
      listItem.dataset.userId = optionValue;
      selectedOptionsList.appendChild(listItem);

      usuariosSeleccionados.push(optionValue);
      updateHiddenInput(); // Actualizar el campo oculto

      select.value = "";
      errorContainer.textContent = "";
    }
  });

  removeSelectedButton.addEventListener("click", function () {
    const selectedItems = selectedOptionsList.querySelectorAll("li.selectedsoli");
    selectedItems.forEach(function (item) {
      const userId = item.dataset.userId;

      const index = usuariosSeleccionados.indexOf(userId);
      if (index !== -1) {
        usuariosSeleccionados.splice(index, 1);
      }

      item.remove();
    });

    updateHiddenInput(); // Actualizar el campo oculto después de eliminar usuarios
  });

  removeAllButton.addEventListener("click", function () {
    selectedOptionsList.innerHTML = "";
    usuariosSeleccionados.length = 0; // Vaciar el arreglo
    updateHiddenInput(); // Actualizar el campo oculto al borrar todos los usuarios
  });

  selectedOptionsList.addEventListener("click", function (e) {
    const target = e.target;
    if (target.tagName === "LI") {
      target.classList.toggle("selectedsoli");
    }
  });
});



$(document).ready(function() {
  // Captura el evento de clic en el campo de búsqueda
  $("#searchInput").on("click", function() {
      // Abre el select y ajusta la altura
      $("#oprt").attr("size", 5); // Puedes ajustar el número de elementos visibles según tus preferencias
  });

  // Captura el evento de cambio en el campo de búsqueda
  $("#searchInput").on("input", function() {
      var searchText = $(this).val().toLowerCase();
      // Filtra las opciones del select
      $("#oprt option").each(function() {
          var optionText = $(this).text().toLowerCase();
          if (optionText.indexOf(searchText) !== -1) {
              $(this).show();
          } else {
              $(this).hide();
          }
      });
  });

  // Captura el evento de cierre de la lista al hacer clic en cualquier parte de la página
  $(document).on("click", function(event) {
      if (!$(event.target).closest("#searchInput, .select-container").length) {
          // Cierra el select y ajusta la altura
          $("#oprt").removeAttr("size");
      }
  });
});













  // Obtén los elementos de entrada de fecha
  const fechaInicioInput = document.getElementById('fechainicio');
  const fechaFinInput = document.getElementById('fechafin');

  // Agrega un event listener al campo de fecha de inicio
  fechaInicioInput.addEventListener('change', function() {
    // Habilita el campo de fecha de fin
    fechaFinInput.removeAttribute('disabled');

    // Configura la fecha mínima en el campo de fecha de fin para que no sea anterior a la fecha de inicio
    fechaFinInput.min = fechaInicioInput.value;
  });

////////////parte del formulario de edicion/////////////////////
  // Obtén los elementos de entrada de fecha de inicio y fecha de fin
  const fechaInicioEditInput = document.getElementById('fechainicioedit');
  const fechaFinEditInput = document.getElementById('fechafinedit');

  // Al cargar la página, establece la fecha mínima en el campo de fecha de fin para que no sea anterior a la fecha de inicio actual
  fechaFinEditInput.min = fechaInicioEditInput.value;

  // Agrega event listeners para manejar cambios en los campos de fecha
  fechaInicioEditInput.addEventListener('change', function() {
    // Si la nueva fecha de inicio es posterior a la fecha de fin actual, deselecciona la fecha de fin
    if (fechaInicioEditInput.value > fechaFinEditInput.value) {
      fechaFinEditInput.value = '';
    }
    // Actualiza la fecha mínima en el campo de fecha de fin
    fechaFinEditInput.min = fechaInicioEditInput.value;
  });

  fechaFinEditInput.addEventListener('change', function() {
    // Si la nueva fecha de fin es anterior a la fecha de inicio, deselecciona la fecha de fin
    if (fechaFinEditInput.value < fechaInicioEditInput.value) {
      fechaFinEditInput.value = '';
    }
  });



  $(document).ready(function() {
    // Captura el evento de clic en el campo de búsqueda
    $("#searchInput").on("click", function() {
        // Abre el select y ajusta la altura
        $("#oprt").attr("size", 5); // Puedes ajustar el número de elementos visibles según tus preferencias
    });

    // Captura el evento de cambio en el campo de búsqueda
    $("#searchInput").on("input", function() {
        var searchText = $(this).val().toLowerCase();
        // Filtra las opciones del select
        $("#oprt option").each(function() {
            var optionText = $(this).text().toLowerCase();
            if (optionText.indexOf(searchText) !== -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Captura el evento de cierre de la lista al hacer clic en cualquier parte de la página
    $(document).on("click", function(event) {
        if (!$(event.target).closest("#searchInput, .select-container").length) {
            // Cierra el select y ajusta la altura
            $("#oprt").removeAttr("size");
        }
    });
  });






  function habilitarFechasBimestreActual() {
    // Obten la fecha actual
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth() + 1; // Sumamos 1 porque los meses se indexan desde 0

    // Determina el bimestre actual en base al mes actual
    var bimestreActual = Math.ceil(mesActual / 2);

    // Obten los elementos de entrada de fecha
    var inputFecha = document.getElementById('fechainicio');

    // Calcula el primer y último día del bimestre actual
    var primerDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual - 1) * 2, 1);
    var ultimoDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual * 2), 0);

    // Establece los atributos min y max en los elementos de entrada de fecha
    inputFecha.setAttribute('min', primerDiaBimestre.toISOString().split('T')[0]);
    inputFecha.setAttribute('max', ultimoDiaBimestre.toISOString().split('T')[0]);
  }



  function habilitarFechasBimestreActual2() {
    // Obten la fecha actual
    var fechaActualedit = new Date();
    var mesActualedit = fechaActualedit.getMonth() + 1; // Sumamos 1 porque los meses se indexan desde 0

    // Determina el bimestre actual en base al mes actual
    var bimestreActualedit = Math.ceil(mesActualedit / 2);

    // Obten los elementos de entrada de fecha
    var inputFechaedit = document.getElementById('fechainicioedit');

    // Calcula el primer y último día del bimestre actual
    var primerDiaBimestreedit = new Date(fechaActualedit.getFullYear(), (bimestreActualedit - 1) * 2, 1);
    var ultimoDiaBimestreedit = new Date(fechaActualedit.getFullYear(), (bimestreActualedit * 2), 0);

    // Establece los atributos min y max en los elementos de entrada de fecha
    inputFechaedit.setAttribute('min', primerDiaBimestreedit.toISOString().split('T')[0]);
    inputFechaedit.setAttribute('max', ultimoDiaBimestreedit.toISOString().split('T')[0]);
  }



  function habilitarFechasBimestreActualEdit() {
    // Obtén la fecha actual
    var currentDate = new Date();

    // Obtiene el año actual y el mes actual
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() + 1; // Los meses se indexan desde 0 (enero) hasta 11 (diciembre)

    // Define el rango de fechas permitidas para el bimestre actual
    var startDate, endDate;

    if (currentMonth >= 1 && currentMonth <= 2) {
      // Enero y febrero
      startDate = currentYear + '-01-01';
      endDate = currentYear + '-02-29'; // Considerando año bisiesto
    } else if (currentMonth >= 3 && currentMonth <= 4) {
      // Marzo y abril
      startDate = currentYear + '-03-01';
      endDate = currentYear + '-04-30';
    } else if (currentMonth >= 5 && currentMonth <= 6) {
      // Mayo y junio
      startDate = currentYear + '-05-01';
      endDate = currentYear + '-06-30';
    } else if (currentMonth >= 7 && currentMonth <= 8) {
      // Julio y agosto
      startDate = currentYear + '-07-01';
      endDate = currentYear + '-08-31';
    } else if (currentMonth >= 9 && currentMonth <= 10) {
      // Septiembre y octubre
      startDate = currentYear + '-09-01';
      endDate = currentYear + '-10-31';
    } else {
      // Noviembre y diciembre
      startDate = currentYear + '-11-01';
      endDate = currentYear + '-12-31';
    }

    // Configura el campo de entrada de fecha en el modal
    var fechaEditInput = document.getElementById('fechafin');
    fechaEditInput.max = endDate;
  }





  function habilitarFechasBimestreActualEdit2() {
    // Obtén la fecha actual
    var currentDate = new Date();

    // Obtiene el año actual y el mes actual
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() + 1; // Los meses se indexan desde 0 (enero) hasta 11 (diciembre)

    // Define el rango de fechas permitidas para el bimestre actual
    var startDate, endDate;

    if (currentMonth >= 1 && currentMonth <= 2) {
      // Enero y febrero
      startDate = currentYear + '-01-01';
      endDate = currentYear + '-02-29'; // Considerando año bisiesto
    } else if (currentMonth >= 3 && currentMonth <= 4) {
      // Marzo y abril
      startDate = currentYear + '-03-01';
      endDate = currentYear + '-04-30';
    } else if (currentMonth >= 5 && currentMonth <= 6) {
      // Mayo y junio
      startDate = currentYear + '-05-01';
      endDate = currentYear + '-06-30';
    } else if (currentMonth >= 7 && currentMonth <= 8) {
      // Julio y agosto
      startDate = currentYear + '-07-01';
      endDate = currentYear + '-08-31';
    } else if (currentMonth >= 9 && currentMonth <= 10) {
      // Septiembre y octubre
      startDate = currentYear + '-09-01';
      endDate = currentYear + '-10-31';
    } else {
      // Noviembre y diciembre
      startDate = currentYear + '-11-01';
      endDate = currentYear + '-12-31';
    }

    // Configura el campo de entrada de fecha en el modal
    var fechaEditInput = document.getElementById('fechafinedit');
    fechaEditInput.max = endDate;
  }








  function habilitarFechasBimestresActualesYAnteriores() {
    // Obten la fecha actual
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth() + 1; // Sumamos 1 porque los meses se indexan desde 0

    // Determina el bimestre actual en base al mes actual
    var bimestreActual = Math.ceil(mesActual / 2);

    // Obten los elementos de entrada de fecha
    var inputFecha = document.getElementById('fechainicio');

    // Calcula el primer y último día del bimestre actual
    var primerDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual - 1) * 2, 1);
    var ultimoDiaBimestre = new Date(fechaActual.getFullYear(), bimestreActual * 2, 0);

    // Calcula el primer y último día del bimestre anterior
    var bimestreAnterior = bimestreActual - 1;
    if (bimestreAnterior === 0) {
      bimestreAnterior = 6; // Si el bimestre actual es enero-febrero, el anterior es julio-agosto
    }
    var primerDiaBimestreAnterior = new Date(fechaActual.getFullYear(), (bimestreAnterior - 1) * 2, 1);
    var ultimoDiaBimestreAnterior = new Date(fechaActual.getFullYear(), bimestreAnterior * 2, 0);

    // Establece los atributos min y max para el bimestre actual y anterior
    inputFecha.setAttribute('min', primerDiaBimestreAnterior.toISOString().split('T')[0]);
    inputFecha.setAttribute('max', ultimoDiaBimestre.toISOString().split('T')[0]);
  }





  function habilitarFechasBimestresActualesYAnteriores2() {
    // Obten la fecha actual
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth() + 1; // Sumamos 1 porque los meses se indexan desde 0

    // Determina el bimestre actual en base al mes actual
    var bimestreActual = Math.ceil(mesActual / 2);

    // Obten los elementos de entrada de fecha
    var inputFecha = document.getElementById('fechafin');

    // Calcula el primer y último día del bimestre actual
    var primerDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual - 1) * 2, 1);
    var ultimoDiaBimestre = new Date(fechaActual.getFullYear(), bimestreActual * 2, 0);

    // Calcula el primer y último día del bimestre anterior
    var bimestreAnterior = bimestreActual - 1;
    if (bimestreAnterior === 0) {
      bimestreAnterior = 6; // Si el bimestre actual es enero-febrero, el anterior es julio-agosto
    }
    var primerDiaBimestreAnterior = new Date(fechaActual.getFullYear(), (bimestreAnterior - 1) * 2, 1);
    var ultimoDiaBimestreAnterior = new Date(fechaActual.getFullYear(), bimestreAnterior * 2, 0);

    // Establece los atributos min y max para el bimestre actual y anterior
    inputFecha.setAttribute('min', primerDiaBimestreAnterior.toISOString().split('T')[0]);
    inputFecha.setAttribute('max', ultimoDiaBimestre.toISOString().split('T')[0]);
  }






  function habilitarFechasBimestresActualesYAnterioresedit(inputFecha) {
    // Obten la fecha actual
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth() + 1; // Sumamos 1 porque los meses se indexan desde 0

    // Determina el bimestre actual en base al mes actual
    var bimestreActual = Math.ceil(mesActual / 2);

    // Obten los elementos de entrada de fecha

    // Calcula el primer y último día del bimestre actual
    var primerDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual - 1) * 2, 1);
    var ultimoDiaBimestre = new Date(fechaActual.getFullYear(), bimestreActual * 2, 0);

    // Calcula el primer y último día del bimestre anterior
    var bimestreAnterior = bimestreActual - 1;
    if (bimestreAnterior === 0) {
      bimestreAnterior = 6; // Si el bimestre actual es enero-febrero, el anterior es julio-agosto
    }
    var primerDiaBimestreAnterior = new Date(fechaActual.getFullYear(), (bimestreAnterior - 1) * 2, 1);
    var ultimoDiaBimestreAnterior = new Date(fechaActual.getFullYear(), bimestreAnterior * 2, 0);

    // Combina los rangos de fechas del bimestre actual y el bimestre anterior
    var startDate = primerDiaBimestreAnterior.toISOString().split('T')[0];
    var endDate = ultimoDiaBimestre.toISOString().split('T')[0];

    // Configura el campo de entrada de fecha en el modal
    inputFecha.min = startDate;
    inputFecha.max = endDate;
  }







  function habilitarFechasBimestresActualesYAnterioresedit2(inputFecha) {
    // Obten la fecha actual
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth() + 1; // Sumamos 1 porque los meses se indexan desde 0

    // Determina el bimestre actual en base al mes actual
    var bimestreActual = Math.ceil(mesActual / 2);

    // Obten los elementos de entrada de fecha

    // Calcula el primer y último día del bimestre actual
    var primerDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual - 1) * 2, 1);
    var ultimoDiaBimestre = new Date(fechaActual.getFullYear(), bimestreActual * 2, 0);

    // Calcula el primer y último día del bimestre anterior
    var bimestreAnterior = bimestreActual - 1;
    if (bimestreAnterior === 0) {
      bimestreAnterior = 6; // Si el bimestre actual es enero-febrero, el anterior es julio-agosto
    }
    var primerDiaBimestreAnterior = new Date(fechaActual.getFullYear(), (bimestreAnterior - 1) * 2, 1);
    var ultimoDiaBimestreAnterior = new Date(fechaActual.getFullYear(), bimestreAnterior * 2, 0);

    // Combina los rangos de fechas del bimestre actual y el bimestre anterior
    var startDate = primerDiaBimestreAnterior.toISOString().split('T')[0];
    var endDate = ultimoDiaBimestre.toISOString().split('T')[0];

    // Configura el campo de entrada de fecha en el modal
    inputFecha.min = startDate;
    inputFecha.max = endDate;
  }






// Llama a la función cuando se carga el DOM
document.addEventListener('DOMContentLoaded', function() {
  // Obten la variable sesionEspecial desde algún lugar
  var sesionEspecial = $('#sesionEspecial').data('sesion-especial');

  // Obten los elementos de entrada de fecha
  var inputFecha = document.getElementById('fechainicio');
  var inputFechafin = document.getElementById('fechafin');
  var inputFechaedit = document.getElementById('fechainicioedit');
  var inputFechafinedit = document.getElementById('fechafinedit');

  if (sesionEspecial === 1) {
    // Si sesionEspecial es igual a 1, permite seleccionar fechas de los meses del bimestre actual y el anterior
    habilitarFechasBimestresActualesYAnteriores(inputFecha);
  } else {
    // Si sesionEspecial no es igual a 1, permite seleccionar fechas solo en el bimestre actual
    habilitarFechasBimestreActual(inputFecha);
  }
});


function autoResizeTextarea(element) {
    element.style.height = "auto";
    element.style.height = (element.scrollHeight) + "px";
}


// Aquí va el código JavaScript para crear la lista desplegable
var select = document.getElementById("porcentajeavance");

// Establecer el valor por defecto a '0%'
select.value = 0;

for (var i = 0; i <= 100; i += 5) {
    var option = document.createElement("option");
    option.value = i;
    option.text = i + "%";
    select.appendChild(option);
}


    //CREAR
    // Obtener el elemento select
    var selectElement = document.getElementById('nombrecliente');

    // Obtener las opciones y convertirlas a un array

    var options = Array.from(selectElement.options);

    // Ordenar el array de opciones alfabéticamente
    options.sort(function(a, b) {
        var textA = a.text.toUpperCase();
        var textB = b.text.toUpperCase();
        return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
    });

    // Limpiar las opciones actuales en el select
    selectElement.innerHTML = '';

    // Agregar las opciones ordenadas al select
    options.forEach(function(option) {
        selectElement.appendChild(option);
    });

    //EDITAR
    // Obtener el elemento select
    var selectElement = document.getElementById('nombreclienteedit');

    // Obtener las opciones y convertirlas a un array

    var options = Array.from(selectElement.options);

    // Ordenar el array de opciones alfabéticamente
    options.sort(function(a, b) {
        var textA = a.text.toUpperCase();
        var textB = b.text.toUpperCase();
        return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
    });

    // Limpiar las opciones actuales en el select
    selectElement.innerHTML = '';

    // Agregar las opciones ordenadas al select
    options.forEach(function(option) {
        selectElement.appendChild(option);
    });



// Obtener el elemento select
var selectElement = document.getElementById('nombrecliente');

// Crear la opción de marcador de posición
var placeholderOption = document.createElement('option');
placeholderOption.textContent = 'Seleccione una dependencia o institución';
placeholderOption.value = '';
placeholderOption.disabled = true;
placeholderOption.selected = true;

// Agregar la opción de marcador de posición al principio del select
selectElement.prepend(placeholderOption);



// Obtener el elemento select
var selectElement = document.getElementById('nombreclienteedit');

// Crear la opción de marcador de posición
var placeholderOption = document.createElement('option');
placeholderOption.textContent = 'Seleccione una dependencia o institución';
placeholderOption.value = '';
placeholderOption.disabled = true;
placeholderOption.selected = true;

// Agregar la opción de marcador de posición al principio del select
selectElement.prepend(placeholderOption);





