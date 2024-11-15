document.addEventListener('DOMContentLoaded', function() {
    // Obtén la fecha actual
    var d = new Date();

    // Obtiene el año actual y el mes actual
    var year = d.getFullYear();
    var month = d.getMonth();

    // Nombres de los meses en español
    var meses = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    ];

    // Nombres de los bimestres en español
    var bimestres = [
        "Enero-Febrero",
        "Marzo-Abril",
        "Mayo-Junio",
        "Julio-Agosto",
        "Septiembre-Octubre",
        "Noviembre-Diciembre"
    ];

    // Encuentra los selectores
    var slct1 = document.getElementById('slct1');
    var slct4 = document.getElementById('slct4');

    // Establece el año actual como opción seleccionada en el primer selector
    for (var i = 0; i < slct1.options.length; i++) {
        if (slct1.options[i].value == year) {
            slct1.options[i].selected = true;
            break;
        }
    }



    for (var i = 0; i < slct4.options.length; i++) {
        if (slct4.options[i].value == bimestres[Math.floor(month / 2)]) {
            slct4.options[i].selected = true;
            break;
        }
    }
});



document.addEventListener('DOMContentLoaded', function() {
    // Obtén la fecha actual
    var d = new Date();
    var currentYear = d.getFullYear();
    var slct1 = document.getElementById('slct1');
    var slct3 = document.getElementById('slct3');
    var yearOptionExists = false;

    // Verifica si el año actual ya está en el selector de años
    for (var i = 0; i < slct1.options.length; i++) {
        if (slct1.options[i].value == currentYear) {
            yearOptionExists = true;
            break;
        }
    }

    // Si el año actual no está en el selector de años, agrégalo como una nueva opción
    if (!yearOptionExists) {
        var newOption = document.createElement('option');
        newOption.value = currentYear;
        newOption.text = currentYear;
        slct1.add(newOption);
    }

    // Establece el año actual como seleccionado
    slct1.value = currentYear;
    slct3.value = currentYear;
});



function mostrarContenido() {
    // Seleccionamos el elemento que tiene el id "contenido"
    var elemento = document.getElementById("contenido");
    // Si el elemento está oculto, lo mostramos
    if (elemento.style.display === "none") {
        elemento.style.display = "block";
    // Si el elemento está visible, lo ocultamos
    } else {
        elemento.style.display = "none";
    }
}

