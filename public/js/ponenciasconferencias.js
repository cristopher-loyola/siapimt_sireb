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








  // JavaScript para abrir el modal de edición al hacer clic en el botón "Editar"
  $(document).on("click", "#btnedit",function(){
    console.log('Código JavaScript ejecutado.');

    // Obtener los datos de la fila a través de los atributos de datos
    var tipopc = $(this).data('tipopc');
    var entidad = $(this).data('entidad');
    var titulo = $(this).data('titulo');
    var fechainicio = $(this).data('fechainicio');
    var fechafin = $(this).data('fechafin');
    var tipoparticipacion = $(this).data('tipoparticipacion');
    var publicacionpc = $(this).data('publicacionpc');
    var fechaponente = $(this).data('fechaponente');
    var nombreevento = $(this).data('nombreevento');
    var lugarevento = $(this).data('lugarevento');

    var usuariosseleccionados = $(this).data('usuariosseleccionados');




    // Obtener la acción del formulario (a través del atributo de datos)
    var formAction = $(this).data('action');

    // Llenar los campos del formulario modal con los datos de la fila
    $('#tipoedit').val(tipopc);
    $('#entidad_Oedit').val(entidad);
    $('#titulopocoedit').val(titulo);
    $('#fechainicioedit').val(fechainicio);
    $('#fechafinedit').val(fechafin);
    $('#tipoparticipacionedit').val(tipoparticipacion);
    $('#publicacionedit').val(publicacionpc);
    $('#fechaponenteedit').val(fechaponente);
    $('#nombreeventoedit').val(nombreevento);
    $('#lugaredit').val(lugarevento);

    $('#usuarios_seleccionadosedit').val(usuariosseleccionados);
    $('#usuarios_seleccionadoseditMail').val(usuariosseleccionados);

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



    // Establecer la acción del formulario para el envío del formulario
    $('#editarForm').attr('action', formAction);

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
  $(document).on("click", "#btnelimRe",function(){
    console.log('Código JavaScript ejecutado.');

    // Obtener la acción del formulario (a través del atributo de datos)
    var formActionElim = $(this).data('idelimre');

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
        // Obtener los datos de la fila a través de los atributos de datos
        var tipopc = $(this).data('tipopc');
        var entidad = $(this).data('entidad');
        var titulo = $(this).data('titulo');
        var fechainicio = $(this).data('fechainicio');
        var fechafin = $(this).data('fechafin');
        var tipoparticipacion = $(this).data('tipoparticipacion');
        var publicacionpc = $(this).data('publicacionpc');
        var fechaponente = $(this).data('fechaponente');
        var nombreevento = $(this).data('nombreevento');
        var lugarevento = $(this).data('lugarevento');
        var encargadoservicio = $(this).data('encargado');
        var usuariosseleccionados = $(this).data('usuariosseleccionados');


        // Llenar los campos del formulario modal con los datos de la fila
        $('#tipoponenciaviz').text(tipopc);
        $('#entidadviz').text(entidad);
        $('#tituloviz').text(titulo);
        $('#fechainicioviz').text(fechainicio);
        $('#fechafinviz').text(fechafin);
        $('#tipoparticipacionviz').text(tipoparticipacion);
        $('#publicacionpocoviz').text(publicacionpc);
        $('#fechaparticipacionviz').text(fechaponente);
        $('#nombreeventoviz').text(nombreevento);
        $('#lugarviz').text(lugarevento);
        $('#encargadoservicioviz').text(encargadoservicio);


      // Declaración de variables para los elementos y arreglos
    const selectedOptionsParrafoEdit = document.getElementById("selected-options-paragraph-editar");
    const usuariosSeleccionadosInputEdit = document.getElementById("usuarios_seleccionadosedit");
    const selectedit = document.getElementById("oprtedit");
    const usuariosSeleccionados = usuariosseleccionados.toString().split(',');

    // Función para actualizar el campo oculto y el párrafo de usuarios seleccionados
    function actualizarUsuariosSeleccionadosEnParrafo() {
      usuariosSeleccionadosInputEdit.value = usuariosSeleccionados.join(",");

      // Crear un array para todos los participantes
      const todosLosParticipantes = [];
      
      // Agregar primero a la persona loggeada (encargado del servicio)
      todosLosParticipantes.push( encargadoservicio);

      if (usuariosSeleccionadosInputEdit.value) {
        const usuariosSeleccionadosNombres = usuariosSeleccionados.map(function (userId) {
          const selectOption = selectedit.querySelector(`option[value="${userId}`);
          return selectOption ? selectOption.getAttribute("data-nombre") : nombreCompletoUsuario;
        }).filter(function(nombre) {
          // Filtrar para evitar duplicados del encargado del servicio
          return nombre !== encargadoservicio;
        });
        
        // Agregar los otros participantes
        todosLosParticipantes.push(...usuariosSeleccionadosNombres);
      }

      if (todosLosParticipantes.length === 1) {
        // Solo está el autor
        selectedOptionsParrafoEdit.textContent = todosLosParticipantes[0];
      } else {
        selectedOptionsParrafoEdit.textContent = todosLosParticipantes.join("\n");
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












  // Ordenar la tabla por fecha
  var table = $('#cursosRTable');
  var tbody = table.find('tbody');

  // Obtén las filas y ordénalas por la columna de fecha (segundo <td>)
  var rows = tbody.find('tr').toArray();
  rows.sort(function(a, b) {
    var dateA = new Date($(a).find('td:eq(1)').text());
    var dateB = new Date($(b).find('td:eq(1)').text());
    return dateA - dateB; //orden ascendente
    //return dateB - dateA; //orden decendente
  });

  // Vacía el cuerpo de la tabla y vuelve a agregar las filas ordenadas
  tbody.empty();
  $.each(rows, function(index, row) {
    tbody.append(row);
  });
7






// Obtén los elementos de entrada de fecha
const fechaInicioInput = document.getElementById('fechainicio');
const fechaFinInput = document.getElementById('fechafin');
const fechaPonenteInput = document.getElementById('fechaponente');

// Agrega un event listener al campo de fecha de inicio
fechaInicioInput.addEventListener('change', function() {
  // Habilita el campo de fecha de fin
  fechaFinInput.removeAttribute('disabled');
  // Configura la fecha mínima en el campo de fecha de fin para que no sea anterior a la fecha de inicio
  fechaFinInput.min = fechaInicioInput.value;
});

// Agrega un event listener al campo de fecha de fin
fechaFinInput.addEventListener('change', function() {
  // Habilita el campo de fecha de participación como ponente
  fechaPonenteInput.removeAttribute('disabled');
  // Configura la fecha mínima en el campo de fecha de participación como ponente para que no sea anterior a la fecha de inicio
  fechaPonenteInput.min = fechaInicioInput.value;
  // Configura la fecha máxima en el campo de fecha de participación como ponente para que no sea posterior a la fecha de fin
  fechaPonenteInput.max = fechaFinInput.value;
});





////////////parte del formulario de edicion/////////////////////
  // Obtén los elementos de entrada de fecha de inicio, fecha de fin y fecha de participación como ponente en la vista de edición
  const fechaInicioEditInput = document.getElementById('fechainicioedit');
  const fechaFinEditInput = document.getElementById('fechafinedit');
  const fechaPonenteEditInput = document.getElementById('fechaponenteedit');

  // Al cargar la página de edición, establece la fecha mínima en el campo de fecha de fin para que no sea anterior a la fecha de inicio actual
  fechaFinEditInput.min = fechaInicioEditInput.value;

  // Agrega event listeners para manejar cambios en los campos de fecha en la vista de edición
  fechaInicioEditInput.addEventListener('change', function() {
    // Si la nueva fecha de inicio es posterior a la fecha de fin actual, deselecciona la fecha de fin
    if (fechaInicioEditInput.value > fechaFinEditInput.value) {
      fechaFinEditInput.value = '';
    }
    // Actualiza la fecha mínima en el campo de fecha de fin
    fechaFinEditInput.min = fechaInicioEditInput.value;

    // Borra la fecha de participación como ponente si no está en el rango válido
    if (fechaPonenteEditInput.value < fechaInicioEditInput.value || fechaPonenteEditInput.value > fechaFinEditInput.value) {
      fechaPonenteEditInput.value = '';
    }
  });

  fechaFinEditInput.addEventListener('change', function() {
    // Si la nueva fecha de fin es anterior a la fecha de inicio, deselecciona la fecha de fin
    if (fechaFinEditInput.value < fechaInicioEditInput.value) {
      fechaFinEditInput.value = '';
    }

    // Borra la fecha de participación como ponente si no está en el rango válido
    if (fechaPonenteEditInput.value < fechaInicioEditInput.value || fechaPonenteEditInput.value > fechaFinEditInput.value) {
      fechaPonenteEditInput.value = '';
    }
  });

  // Agrega un event listener al campo de fecha de fin en la vista de edición para habilitar la fecha de participación como ponente
  fechaFinEditInput.addEventListener('change', function() {
    // Habilita el campo de fecha de participación como ponente en la vista de edición
    fechaPonenteEditInput.removeAttribute('disabled');
    // Configura la fecha mínima en el campo de fecha de participación como ponente para que no sea anterior a la fecha de inicio
    fechaPonenteEditInput.min = fechaInicioEditInput.value;
    // Configura la fecha máxima en el campo de fecha de participación como ponente para que no sea posterior a la fecha de fin
    fechaPonenteEditInput.max = fechaFinEditInput.value;

    // Borra la fecha de participación como ponente si no está en el rango válido
    if (fechaPonenteEditInput.value < fechaInicioEditInput.value || fechaPonenteEditInput.value > fechaFinEditInput.value) {
      fechaPonenteEditInput.value = '';
    }
  });

  // Agrega un event listener al campo de fecha de participación como ponente en la vista de edición para verificar si la fecha está dentro del rango
  fechaPonenteEditInput.addEventListener('change', function() {
    // Borra la fecha de participación como ponente si no está en el rango válido
    if (fechaPonenteEditInput.value < fechaInicioEditInput.value || fechaPonenteEditInput.value > fechaFinEditInput.value) {
      fechaPonenteEditInput.value = '';
    }
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




  function habilitarFechasBimestreActual2() {
    // Obten la fecha actual
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth() + 1; // Sumamos 1 porque los meses se indexan desde 0

    // Determina el bimestre actual en base al mes actual
    var bimestreActual = Math.ceil(mesActual / 2);

    // Obten los elementos de entrada de fecha
    var inputFecha = document.getElementById('fechainicioedit');

    // Calcula el primer y último día del bimestre actual
    var primerDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual - 1) * 2, 1);
    var ultimoDiaBimestre = new Date(fechaActual.getFullYear(), (bimestreActual * 2), 0);

    // Establece los atributos min y max en los elementos de entrada de fecha
    inputFecha.setAttribute('min', primerDiaBimestre.toISOString().split('T')[0]);
    inputFecha.setAttribute('max', ultimoDiaBimestre.toISOString().split('T')[0]);
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
    habilitarFechasBimestresActualesYAnteriores2(inputFechafin);
    habilitarFechasBimestresActualesYAnterioresedit(inputFechaedit);
    habilitarFechasBimestresActualesYAnterioresedit2(inputFechafinedit);
  } else {
    // Si sesionEspecial no es igual a 1, permite seleccionar fechas solo en el bimestre actual
    habilitarFechasBimestreActual(inputFecha);
    habilitarFechasBimestreActualEdit();
    habilitarFechasBimestreActual2(inputFecha);
    habilitarFechasBimestreActualEdit2();
  }
});
















