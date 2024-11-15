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

    // Obtener los datos de la fila a través de los atributos de datos
    const idPosgrade = $(this).data('id');
    var grado = $(this).data('grado');
    var fechainicio = $(this).data('fechainicio');
    var fechatitulacion = $(this).data('fechatitulacion');
    var titulopostgrado = $(this).data('titulopostgrado');
    var institucion = $(this).data('institucion');
    var adesarrolladas = $(this).data('adesarrolladas');
    var titulotesis = $(this).data('titulotesis');
    var estado = $(this).data('estado');


    // Llenar los campos del formulario modal con los datos de la fila
    $('#gradoedit').val(grado);
    $('#fechainicioedit').val(fechainicio);
    $('#fechatitulacionedit').val(fechatitulacion);
    $('#nombrepostgradoedit').val(titulopostgrado);
    $('#D_pertenecienteedit').val(institucion);
    $('#A_desarrolladasedit').val(adesarrolladas);
    $('#nombretesisedit').val(titulotesis);
    $('#estadoedit').val(estado);
    $('#id-posgrade').val(idPosgrade);

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







  // javascript para el modal de eliminar
  $(document).on("click", "#btnelimpost",function(){
    console.log('Código JavaScript ejecutado.');

    // Obtener la acción del formulario (a través del atributo de datos)
    var formActionElim = $(this).data('idelim');

    // Establecer la acción del formulario para el envío del formulario
    $('#elimFormP').attr('action', formActionElim);

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







  // javascript para el modal de vizualizar
  $(document).on("click", "#btnviz",function(){
    console.log('Código JavaScript ejecutado.');

        // Obtener los datos de la fila a través de los atributos de datos
        var grado = $(this).data('grado');
        var fechainicio = $(this).data('fechainicio');
        var fechatitulacion = $(this).data('fechatitulacion');
        var titulopostgrado = $(this).data('titulopostgrado');
        var institucion = $(this).data('institucion');
        var adesarrolladas = $(this).data('adesarrolladas');
        var titulotesis = $(this).data('titulotesis');
        var estado = $(this).data('estado');
        var encargadoservicio = $(this).data('encargado');

        // Llenar los campos del formulario modal con los datos de la fila
        $('#gradoviz').text(grado);
        $('#fechainicioviz').text(fechainicio);
        $('#fechatitulacionviz').text(fechatitulacion);
        $('#nombrepostgradoviz').text(titulopostgrado);
        $('#D_pertenecienteviz').text(institucion);
        $('#A_desarrolladasviz').text(adesarrolladas);
        $('#nombretesisviz').text(titulotesis);
        $('#estadoviz').text(estado);
        $('#encargadoservicioviz').text(encargadoservicio);

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
  var table = $('#postgradosTable');
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







    // Obtén los elementos de entrada de fecha
    const fechaInicioInput = document.getElementById('fechainicio');
    const fechaFinInput = document.getElementById('fechatitulacion');

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
    const fechaFinEditInput = document.getElementById('fechatitulacionedit');

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
      var fechaEditInput = document.getElementById('fechatitulacion');
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
      var fechaEditInput = document.getElementById('fechatitulacionedit');
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
      var inputFecha = document.getElementById('fechatitulacion');

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
    var inputFechafin = document.getElementById('fechatitulacion');
    var inputFechaedit = document.getElementById('fechainicioedit');
    var inputFechafinedit = document.getElementById('fechatitulacionedit');

    if (sesionEspecial === 1) {
      // Si sesionEspecial es igual a 1, permite seleccionar fechas de los meses del bimestre actual y el anterior
      habilitarFechasBimestresActualesYAnteriores(inputFecha);
    } else {
      // Si sesionEspecial no es igual a 1, permite seleccionar fechas solo en el bimestre actual
      habilitarFechasBimestreActual(inputFecha);
    }
  });


  document.addEventListener("DOMContentLoaded", function () {
    // Obtén el elemento select
    var selectElement = document.getElementById('D_pertenecienteedit');

    // Obtén los options y conviértelos a un array
    var options = Array.from(selectElement.options);

    // Ordena los options alfabéticamente
    options.sort(function (a, b) {
        return a.text.localeCompare(b.text);
    });

    // Elimina los options existentes del select
    selectElement.innerHTML = '';

    // Agrega los options ordenados al select
    options.forEach(function (option) {
        selectElement.appendChild(option);
    });
});


//CREAR
    // Obtener el elemento select
    var selectElement = document.getElementById('D_perteneciente');

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
    var selectElement = document.getElementById('D_pertenecienteedit');

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
    var selectElement = document.getElementById('D_perteneciente');

    // Crear la opción de marcador de posición
    var placeholderOption = document.createElement('option');
    placeholderOption.textContent = 'Seleccione una dependencia o institución';
    placeholderOption.value = '';
    placeholderOption.disabled = true;
    placeholderOption.selected = true;

 // Agregar la opción de marcador de posición al principio del select
 selectElement.prepend(placeholderOption);


