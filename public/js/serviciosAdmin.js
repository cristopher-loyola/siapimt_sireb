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
  $(document).on("click", "#btneditC",function(){
    console.log('Código JavaScript ejecutado.');
    // Obtener los datos de la fila a través de los atributos de datos
    var nombre = $(this).data('nombre');

    // Obtener la acción del formulario (a través del atributo de datos)
    var formAction = $(this).data('action');

    // Llenar los campos del formulario modal con los datos de la fila
    $('#nombreservicioedit').val(nombre);

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







  // javascript para el modal de eliminar
  $(document).on("click", "#btnelim",function(){
    console.log('Código JavaScript ejecutado.');

    // Obtener la acción del formulario (a través del atributo de datos)
    var formActionElim = $(this).data('idelim');

    // Establecer la acción del formulario para el envío del formulario
    $('#elimForm').attr('action', formActionElim);

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







