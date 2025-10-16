@extends('plantillas/plantillaClientForm3')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datos proyecto</title>
    <link rel="icon" href="../img/Logo_IMT_mini.png" type="image/png" />
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
           <style>
        *{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            box-sizing: border-box;
        }
        body {
            padding-left: 150px;
            overflow-x: hidden;
        }
        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }
            .sidebar {
                width: 100% !important;
                height: auto !important;
                position: relative !important;
                flex-direction: row !important;
                padding: 10px !important;
            }
            .sidebar-menu {
                flex-direction: row !important;
                flex-wrap: wrap;
                justify-content: center !important;
            }
            .sidebar-item, .sidebar-item-success, .sidebar-item-cancel {
                width: auto !important;
                padding: 5px 10px !important;
            }
            .sidebar-header {
                display: none;
            }
            .tooltip {
                display: none !important;
            }
        }
        header{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 10px;
        }
        header table{
            font-weight: bold;
            font-size: 1.7em;
        }
        #formulario{
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 15px;
        }
        input {
            border: 3px solid transparent;
            outline: none;
            padding: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        input:hover {
            border-color: #3498db;
        }
        input:focus {
            border-color: #3498db;
        }
        textarea {
            border: 3px solid transparent;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s;
            border-radius: 10px;
            text-align: justify;
            overflow: hidden;
            resize: none;
            border-color: #aacfe7;
            width: 100%;
        }
        textarea:hover {
            border-color: #3498db;
        }
        textarea:focus {
            border-color: #3498db;
        }
        textarea::placeholder {
            color: #84abf4;
            font-style: italic;
        }
        select {
            border: 3px solid transparent;
            outline: none;
            font-size: 1em;
            transition: border-color 0.3s;
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
            resize: none;
            width: 100%;
            max-width: 800px;
            border-color: #aacfe7;
        }
        select:hover {
            border-color: #3498db;
        }
        select:focus {
            border-color: #3498db;
        }
        .contenedor {
            display: flex;
            gap: 20px;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            flex-wrap: wrap;
        }
        .columna {
            flex: 1;
            min-width: 300px;
            padding: 20px;
            border: 1px solid #cccccc00;
        }
        #actualizar{
            background: #1e8719;
            color: #fff;
            border-radius: 5px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #actualizar:hover{
            background: #219d1a;
            transform: scale(1.1);
        }
        #modificar{
            background: #eeb93d;
            color: #fff;
            border-radius: 5px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            padding: .4em;
        }
        #modificar:hover {
            background-color: #d5a73b;
            transform: scale(1.1);
        }
        #cejas{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        .boton-ceja-carpeta-actual{
            display: inline-block;
            padding: 15px 20px;
            background-color: #007bff;
            border: none;
            border-top: 10px solid #0065d0;
            border-radius: 5px 5px 0 0;
            font-size: 16px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            position: relative;
            border-right: 1px solid #0065d0;
            min-width: 80px;
        }
        .boton-ceja-carpeta {
            display: inline-block;
            padding: 15px 20px;
            background-color: #3c4d8a;
            border: none;
            border-top: 10px solid #1A2C6E;
            border-radius: 5px 5px 0 0;
            font-size: 16px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #1A2C6E;
            min-width: 80px;
        }
        .boton-ceja-carpeta-success {
            display: inline-block;
            padding: 15px 20px;
            background-color: #1e7e19;
            border: none;
            border-top: 10px solid #3ba335;
            border-radius: 5px 5px 0 0;
            font-size: 16px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #3ba335;
            min-width: 80px;
        }
        .boton-ceja-carpeta:before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 8px;
            background-color: #1A2C6E;
            border-radius: 5px 5px 0 0;
        }
        .boton-ceja-carpeta:hover {
            background-color: #2742a5;
        }
        .boton-ceja-carpeta-success:hover {
            background-color: #1e8719;
        }
        label{
            text-align: justify;
            font-weight: 700;
            font-size: 1.2em;
            display: block;
            margin-top: 15px;
        }
        #exito{
            width: 100%;
            background: #1a831ade;
            color: #fff;
            font-size: 1.2em;
            border-radius: 5px;
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }
        #fallo{
            width: 100%;
            background: #9d1a1a9f;
            color: #fff;
            font-size: 1.2em;
            border-radius: 5px;
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }

        #antecedente, #justifica{
            width: 100%;
            max-width: 800px;
        }

        .constpostick{
            display: flex;
            justify-content: flex-end;
        }
        .post-it {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            background-color: #ffeb3b;
            border: 2px solid #fbc02d;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            color: #333;
            resize: none;
            position: relative;
        }
        .post-it-title {
            font-weight: bold;
            font-size: 18px;
            color: #333;
            position: absolute;
            top: -10px;
            left: 10px;
            background-color: #ffeb3b;
            padding: 0 5px;
            border-radius: 5px;
        }
        .post-it:focus {
            outline: none;
            border: 2px solid #f57f17;
        }
        #notajust, #notaant{
            width: 100%;
            height: 60px;
            background: transparent;
            text-align: justify;
            border: 1px transparent solid;
        }
        #clave{
            text-align: center;
            font-size: 1em;
            font-weight: bold;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            display: block;
        }

        .sidebar {
            width: 150px;
            height: 100vh;
            background-color: #001F5B;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
            z-index: 1000;
        }

        .sidebar-header {
            margin-bottom: 20px;
        }

        .sidebar-icon {
            width: 80px;
            object-fit: cover;
        }

        .sidebar-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .sidebar-item {
            width: 100%;
            text-align: center;
            padding: 10px 0;
            position: relative;
        }

        .sidebar-item a {
            text-decoration: none;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 100%;
        }

        .sidebar-image {
            width: 30px;
            height: 30px;
            object-fit: cover;
            margin-bottom: 5px;
        }

        .sidebar-item-cancel {
            width: 100%;
            text-align: center;
            padding: 10px 0;
            position: relative;
            background: #282828;
        }

        .sidebar-item-cancel a {
            text-decoration: none;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 100%;
        }

        .sidebar-item-success {
            width: 100%;
            text-align: center;
            padding: 10px 0;
            position: relative;
            background: #1e7e19;
        }

        .sidebar-item-success a {
            text-decoration: none;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 100%;
        }

        .sidebar-item:hover {
            background-color: #143882;
            cursor: pointer;
        }

        .sidebar-item.active {
            background-color: #007bff;
        }

        .sidebar-item.active .tooltip {
            background-color: #007bff;
        }

        .sidebar-item-cancel:hover {
            background-color: #3c3c3c;
            cursor: pointer;
        }

        .sidebar-item-success:hover {
            background-color: #1e7e19;
            cursor: pointer;
        }

        .tooltip {
            position: absolute;
            top: 50%;
            left: 90%;
            height: 120%;
            transform: translateY(-50%);
            background-color: #143882;
            padding: 5px;
            border-radius: 3px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
            margin-left: 10px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-item:hover .tooltip {
            opacity: 1;
        }

        .sidebar-item-success:hover .tooltip {
            opacity: 1;
        }

        .sidebar-item-cancel:hover .tooltip {
            opacity: 1;
        }

        .sidebar-item.active:hover .tooltip {
            background-color: #007bff;
            color: white;
        }

        .sidebar-item-success:hover .tooltip {
            background-color: #1e7e19;
            color: white;
        }

        .sidebar-item-cancel:hover .tooltip {
            background-color: #3c3c3c;
            color: white;
        }

        .logout-btn {
            margin-top: auto;
            padding: 10px 20px;
            background-color: #ff4c4c;
            color: white;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: button;
        }

        .logout-btn:hover {
            background-color: #ff2a2a;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .sidebar-menu {
                padding-left: 20px;
            }

            .sidebar-item a {
                flex-direction: row;
            }

            .sidebar-image {
                margin-bottom: 0;
                margin-right: 10px;
            }
        }

        #justifica-container{
            min-height: 100px;
        }
        .ql-toolbar.ql-snow,
        .editor-quill {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border-width: 3px !important;
            border-style: solid !important;
            border-color: #aacfe7 !important; 
            box-sizing: border-box;
            margin-bottom: 6px !important;
        }

        .ql-toolbar.ql-snow {
            background: #fff;
            border-radius: 10px 10px 0 0;
            border: 3px solid #aacfe7;
            border-bottom: none;
            padding: 10px;
        }

        .editor-quill {
            min-height: 150px;
            max-height: 300px;
            height: 200px;
            overflow-y: auto;
            background: #fff;
            border-radius: 0 0 10px 10px;
            border: 3px solid #aacfe7;
            border-top: none;
            padding: 10px;
        }
        .editor-quill.borde-azul, .ql-toolbar.ql-snow.borde-azul {
            border-color: #6bb3e3 !important;
        }
        .editor-quill.borde-rojo, .ql-toolbar.ql-snow.borde-rojo {
            border-color: #e74c3c !important;
        }
        .ql-toolbar .ql-formats button[title] {
            position: relative;
        }
        .ql-table::before {
            content: '▦'; 
            font-size: 16px;
            color: #444;
            display: inline-block;
            line-height: 1;
        }

        @media (max-width: 768px) {
            .ql-toolbar .ql-formats {
                display: flex;
                flex-wrap: wrap;
            }
            .ql-toolbar .ql-formats button {
                margin: 2px;
            }
        }

        .form-group {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .mb-4.col {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        .readonly {
    background-color: #f7f7f7; /* Color de fondo gris claro */
    pointer-events: none; /* Bloquea la interacción con el elemento */
    color: #888; /* Color del texto más apagado */
    padding: 8px; /* Espaciado dentro del div para igualar la altura del campo */
    border: 1px solid #ccc; /* Bordes suaves para igualar al campo de entrada */
    border-radius: 5px; /* Bordes redondeados */
    font-size: 16px; /* Tamaño de fuente coherente */
}
/* Ocultar solo las etiquetas de Categoría (Nivel 1/2/3) */
.select-client-wrapper.solo-lectura-categorias .hide-categorias label {
  display: none !important;
}

/* Mantener visibles el título principal del Cliente o Usuario Potencial */
.select-client-wrapper.solo-lectura-categorias label {
  display: block !important;
}

/* Si prefieres bloquear la edición de los selects también (opcional) */
.select-client-wrapper.solo-lectura-categorias select,
.select-client-wrapper.solo-lectura-categorias .form-select {
  pointer-events: none;
  background-color: #fff;
  color: inherit;
  border-color: #aacfe7;
  opacity: 1;
}
/* Para el textarea en modo solo lectura */
.readonly-textarea {
    background-color: white !important;  /* Fondo blanco para evitar gris */
    color: #333 !important;  /* Color normal del texto */
    border: 1px solid #ccc;  /* Borde gris normal */
    font-size: 16px; /* Tamaño de fuente */
    padding: 10px;  /* Relleno estándar */
    font-family: 'Arial', sans-serif; /* Familia de fuente común */
    resize: none; /* Para evitar el redimensionamiento */
}

/* Para asegurar que no haya fondo gris cuando el campo está en foco (solo lectura) */
.readonly-textarea:focus {
    background-color: white !important;  /* Fondo blanco */
    border: 1px solid #0076c5ff !important; /* Borde azul al enfocarse */
    outline: none; /* Eliminar el contorno del navegador */
}

/* Estilo para los elementos de Quill (solo edición) */
.editor-quill {
    background-color: white; /* Fondo blanco para la edición */
    border: 1px solid #ccc; /* Borde gris */
    padding: 10px; /* Relleno dentro del editor */
}

/* Estilo para el placeholder en Quill */
.ql-placeholder {
    color: #080808ff; /* Gris claro para el placeholder */
    font-style: italic; /* Cursiva */
    font-weight: normal; /* No negrita */
}




    </style>
        <script>
            function autoResize(textarea) {
                const actualizar = document.getElementById('actualizar');
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
                textarea.style.borderColor  = "#ed2f39";
                actualizar.id = 'modificar';
            }
            window.addEventListener('load', () => {
                const textarea = document.getElementById('referencias');
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
                const textarea4 = document.getElementById('notasmetodologia');
                textarea4.style.height = 'auto';
                textarea4.style.height = (textarea4.scrollHeight) + 'px';
            });

            function cambio(){
                const selectElement = document.getElementById('lins');
                const actualizar = document.getElementById('actualizar');
                if (selectElement.value === "") {
                    selectElement.style.border = "3px solid grey";
                    selectElement.style.background = '#95959528';
                } else {
                    selectElement.style.border = "3px solid #ed2f39";
                    selectElement.style.background = '#fff';
                }
                actualizar.id = 'modificar';
            };

            function cambio1(){
                const selectElement = document.getElementById('objs');
                const actualizar = document.getElementById('actualizar');
                if (selectElement.value === "") {
                    selectElement.style.border = "3px solid grey";
                    selectElement.style.background = '#95959528';
                } else {
                    selectElement.style.border = "3px solid #ed2f39";
                    selectElement.style.background = '#fff';
                }
                actualizar.id = 'modificar';
            };

            function cambio2(){
                const selectElement = document.getElementById('alin');
                const actualizar = document.getElementById('actualizar');
                if (selectElement.value === "") {
                    selectElement.style.border = "3px solid grey";
                    selectElement.style.background = '#95959528';
                } else {
                    selectElement.style.border = "3px solid #ed2f39";
                    selectElement.style.background = '#fff';
                }
                actualizar.id = 'modificar';
            };

            function cambio3(){
                const selectElement = document.getElementById('tran');
                const actualizar = document.getElementById('actualizar');

                getSelectValue = document.getElementById("tran").value;
                if(getSelectValue=="7"){
                    document.getElementById("otran").style.display = "inline-block";
                } else {
                    document.getElementById("otran").style.display = "none";
                    document.getElementById("otran").style.display = "disabled";
                    document.getElementById("otran").value= "N/A";
                }

                if (selectElement.value === "") {
                    selectElement.style.border = "3px solid grey";
                    selectElement.style.background = '#95959528';
                } else {
                    selectElement.style.border = "3px solid #ed2f39";
                    selectElement.style.background = '#fff';
                }
                actualizar.id = 'modificar';
            };

            function mostrarElemento() {
                var elemento = document.getElementById("notasmetodologia");
                if (elemento.style.display === "none") {
                    elemento.style.display = "block";  // Cambiar a "block" para mostrarlo
                    elemento.style.width = "800px";
                    elemento.style.height = "50px";
                } else if(elemento.style.display === "block"){
                    elemento.style.display = "none";
                    elemento.style.width = "800px";
                }
            };
        
            function cambioCliente() {
            const selectElement = document.getElementById('userpot');
            const actualizar = document.getElementById('actualizar');
            if (selectElement.value === "") {
                selectElement.style.border = "3px solid grey";
                selectElement.style.background = '#95959528';
            } else {
                selectElement.style.border = "3px solid #ed2f39";
                selectElement.style.background = '#fff';
            }
            actualizar.id = 'modificar';
            };

            $(document).ready(function() {
                setTimeout(function() {
                    $("#exito").fadeOut(1500);
                    $("#fallo").fadeOut(1500);
                },3000);
            });
             document.addEventListener("DOMContentLoaded", function () {
        // Seleccionamos todos los input y textarea en la página
        const inputs = document.querySelectorAll("input, textarea");

        // Iteramos sobre cada uno de ellos
        inputs.forEach(input => {
            // Aseguramos que estamos trabajando con el placeholder
            input.style.setProperty('color', '#000000ff', 'important'); // Cambia el color
            input.style.setProperty('font-weight', 'bold', 'important'); // Negrita
            input.style.setProperty('text-transform', 'uppercase', 'important'); // Mayúsculas
            input.style.setProperty('font-style', 'normal', 'important'); // Quitar cursiva
        });
    });
        </script>

        <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/quill/quill-table-ui.min.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    @php
    // Definir el estado de solo lectura si el proyecto no está en ejecución
    $soloLectura = ($proyt->estado != 1);  // Estado 1 significa en ejecución
@endphp

@if($soloLectura)
<style>
  /* apariencia de solo lectura y ocultar botones de submit */
  .solo-lectura input:not([type="hidden"]),
  .solo-lectura select,
  .solo-lectura textarea {
    background:#f7f7f7;
    pointer-events:none; /* bloquea clicks/ediciones */
  }
  .solo-lectura button[type="submit"],
  .solo-lectura input[type="submit"] {
    display:none !important; /* no mostrar guardar/envíos */
  }
</style>
@endif
    <body>
        <style>
            header{
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center
                ;
            }
            header table{
                font-weight: bold;
                font-size: 1.7em;
            }
        </style>
        <header>
            <img src="../img/Logo_IMT.png" alt="" height="100px" width="120px">
            <table>
                <caption></caption>
                <thead>
                    <tr>
                        <th scope="col">Instituto Mexicano del Transporte</th>
                    </tr>
                    <tr>
                        <th scope="col">Información general</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </header>
        {{-- Navegadir nuevas vistta Inicio --}}
        <style>
            .sidebar {
                width: 150px;
                height: 100vh;
                background-color: #001F5B;
                color: white;
                position: fixed;
                top: 0;
                left: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-between; /* Esto distribuye los elementos a lo largo del sidebar */
                padding-top: 20px;
            }

            .sidebar-header {
                margin-bottom: 20px;
            }

            .sidebar-icon {
                width: 80px;
                object-fit: cover;
            }

            /* Alineamos las pestañas al centro */
            .sidebar-menu {
                list-style-type: none;
                padding: 0;
                margin: 0;
                width: 100%;
                display: flex;
                flex-direction: column; /* Alinea las pestañas verticalmente */
                justify-content: center; /* Alinea verticalmente el contenido en el centro */
                align-items: center; /* Alinea los ítems de forma horizontal */
                flex-grow: 1; /* Asegura que las pestañas ocupen el espacio restante */
            }

            .sidebar-item {
                width: 100%;
                text-align: center;
                padding: 10px 0;
                position: relative;
            }

            .sidebar-item a {
                text-decoration: none;
                color: white;
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                width: 100%;
            }

            .sidebar-image {
                width: 30px;
                height: 30px;
                object-fit: cover;
                margin-bottom: 5px;
            }


            .sidebar-item-cancel {
                width: 100%;
                text-align: center;
                padding: 10px 0;
                position: relative;
                background: #282828;
            }

            .sidebar-item-cancel a {
                text-decoration: none;
                color: white;
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                width: 100%;
            }

            .sidebar-item-success {
                width: 100%;
                text-align: center;
                padding: 10px 0;
                position: relative;
                background: #1e7e19;
            }

            .sidebar-item-success a {
                text-decoration: none;
                color: white;
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                width: 100%;
            }

            /* Efecto de iluminación y tooltipes */
            .sidebar-item:hover {
                background-color: #143882;
                cursor: pointer;
            }

            .sidebar-item.active {
                background-color: #007bff;
            }

            .sidebar-item.active .tooltipes {
                background-color: #007bff;
            }

            .sidebar-item-cancel:hover {
                background-color: #3c3c3c;
                cursor: pointer;
            }

            .sidebar-item-success:hover {
                background-color: #1e7e19;
                cursor: pointer;
            }

            .tooltipes {
                position: absolute;
                top: 50%;
                left: 90%;
                height: 170%;
                height: 120%;
                transform: translateY(-50%);
                background-color: #143882;
                padding: 5px;
                border-radius: 3px;
                white-space: nowrap;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s;
                margin-left: 10px;
                z-index: 10;

                /* Centrar el texto dentro del tooltipes */
                display: flex;
                align-items: center; /* Centra verticalmente */
                justify-content: center; /* Centra horizontalmente */
            }

            .sidebar-item:hover .tooltipes {
                opacity: 1;
            }

            .sidebar-item-success:hover .tooltipes {
                opacity: 1;
            }

            .sidebar-item-cancel:hover .tooltipes {
                opacity: 1;
            }

            /* Tooltipes específico para la pestaña activa */
            .sidebar-item.active:hover .tooltipes {
                background-color: #007bff;
                color: white;
            }

            .sidebar-item-success:hover .tooltipes {
                background-color: #1e7e19;
                color: white;
            }

            .sidebar-item-cancel:hover .tooltipes {
                background-color: #3c3c3c;
                color: white;
            }

            /* Estilo para el botón de logout */
            .logout-btn {
                margin-top: auto;
                padding: 10px 20px;
                background-color: #ff4c4c;
                color: white;
                border: none;
                border-radius: 5px;
                width: 100%;
                cursor: pointer;
            }

            .logout-btn:hover {
                background-color: #ff2a2a;
            }

            /* Ajustar a la ventana */
            @media (max-width: 768px) {
                .sidebar {
                    width: 200px;
                }

                .sidebar-menu {
                    padding-left: 20px;
                }

                .sidebar-item a {
                    flex-direction: row;
                }

                .sidebar-image {
                    margin-bottom: 0;
                    margin-right: 10px;
                }
            }
        </style>
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{asset('/img/Logo_blanco.png')}}" alt="Icono" class="sidebar-icon">
            </div>
            <ul class="sidebar-menu">
                <li class="sidebar-item active" id="item1">
                    <a href="{{route('proydatos', $proyt->id)}}" class="sidebar-link">
                        <img src="{{asset('/img/info-gnrl.png')}}" alt="Información general" class="sidebar-image">
                        <span class="tooltip active">Información general</span>
                    </a>
                </li>
                @if(($proyt->clavet == 'I' ||$proyt->clavet == 'E') && ($proyt->clavea == 'D' || $proyt->clavea == 'A' || $proyt->clavea == 'G'))
                    <li
                    @if ($vequipo != 0 || $proyt->colaboradores == 1)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item2">
                        <a @if ($proyt->completado == 1) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                            <span class="tooltip">Participantes</span>
                        </a>
                    </li>
                    <li
                    @if ($vtarea != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item3">
                        <a @if($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                            <span class="tooltip">Programa de actividades</span>
                        </a>
                    </li>
                    <li
                    @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item4">
                        <a @if ($vtarea != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                            <span class="tooltip">Propuesta económica</span>
                        </a>
                    </li>
                    <li
                    @if ($vriesgo != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item5">
                        <a @if ($vrecurso != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                            <span class="tooltip">Análisis de riesgos</span>
                        </a>
                    </li>
                    <li class="sidebar-item-cancel" id="item6">
                        <a href="{{route('infoproys',$proyt->id)}}">
                            <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                            <span class="tooltip">Información del Proyecto</span>
                        </a>
                    </li>
                @elseif ($proyt->clavet == 'I')
                    {{-- Cambiar en las formas de mostrar el impacto --}}
                    @if ($proyt->actimpacto == 1)
                        <li
                        @if ($vimpacto!= 0)
                            class="sidebar-item-success"
                        @else
                            class="sidebar-item"
                        @endif
                        id="item2">
                            <a href="{{ route('impactoproy', $proyt->id) }}" class="sidebar-link">
                                <img src="{{asset('/img/impactosoceco.png')}}" alt="Plan de actividades" class="sidebar-image">
                                <span class="tooltip">Impacto Socioeconómico</span>
                            </a>
                        </li>    
                    @endif
                    <li
                    @if ($vcontri != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item3">
                        <a @if ($proyt->completado != 0) href="{{ route('contribuciones', $proyt->id)}}" @endif class="sidebar-link">
                            <img src="{{asset('/img/contribuciones.png')}}" alt="Contribuciones a…" class="sidebar-image">
                            <span class="tooltip">Contribuciones a…</span>
                        </a>
                    </li>
                    <li
                    @if ($vequipo != 0 || $proyt->colaboradores == 1)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item4">
                        <a @if ($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                            <span class="tooltip">Participantes</span>
                        </a>
                    </li>
                    <li
                    @if ($vtarea != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item5">
                        <a @if($vtarea != 0) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                            <span class="tooltip">Programa de actividades</span>
                        </a>
                    </li>
                    <li
                    @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item6">
                        <a @if ($vrecurso != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                            <span class="tooltip">Propuesta económica</span>
                        </a>
                    </li>
                    <li
                    @if ($vriesgo != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item7">
                        <a @if ($vriesgo != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                            <span class="tooltip">Análisis de riesgos</span>
                        </a>
                    </li>
                    <li class="sidebar-item-cancel" id="item8">
                        <a href="{{route('infoproys',$proyt->id)}}">
                            <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                            <span class="tooltip">Información del Proyecto</span>
                        </a>
                    </li>
                    {{--SECCION PARA LOS PROYECTOSS EXTERNOS--}}
                @else
                    <li
                    @if ($vcontri != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item2">
                        <a @if ($proyt->completado == 1) href="{{ route('contribuciones', $proyt->id)}}" @endif class="sidebar-link">
                            <img src="{{asset('/img/contribuciones.png')}}" alt="Contribuciones a…" class="sidebar-image">
                            <span class="tooltip">Contribuciones a…</span>
                        </a>
                    </li>
                    <li
                    @if ($vequipo != 0 || $proyt->colaboradores == 1)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item3">
                        <a @if ($vequipo != 0 || $proyt->colaboradores == 1) href="{{ route('Equipo', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/participantes.png')}}" alt="Participantes" class="sidebar-image">
                            <span class="tooltip">Participantes</span>
                        </a>
                    </li>
                    <li
                    @if ($vtarea != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item4">
                        <a @if($vtarea != 0) href="{{ route('tareag', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/tarea.png')}}" alt="Plan de actividades" class="sidebar-image">
                            <span class="tooltip">Programa de actividades</span>
                        </a>
                    </li>
                    <li
                    @if ($vrecurso != 0 || $proyt->notapresupuesto != null)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item5">
                        <a @if ($vrecurso != 0) href="{{ route('recursosproy', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/recursos.png')}}" alt="Propuesta económica" class="sidebar-image">
                            <span class="tooltip">Propuesta económica</span>
                        </a>
                    </li>
                    <li
                    @if ($vriesgo != 0)
                        class="sidebar-item-success"
                    @else
                        class="sidebar-item"
                    @endif
                    id="item6">
                        <a @if ($vriesgo != 0) href="{{ route('ariesgo', $proyt->id) }}" @endif class="sidebar-link">
                            <img src="{{asset('/img/analisis.png')}}" alt="IAnálisis de riesgos" class="sidebar-image">
                            <span class="tooltip">Análisis de riesgos</span>
                        </a>
                    </li>
                    <li class="sidebar-item-cancel" id="item7">
                        <a href="{{route('infoproys',$proyt->id)}}">
                            <img src="{{asset('/img/info-chat.png')}}" alt="Regresar" class="sidebar-image">
                            <span class="tooltip">Información del Proyecto</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    {{-- Navegadir nuevas vistta Fin --}}
        <br>
        <form action="{{ route('actulizarproyecto4', $proyt->id) }}" method="POST">
        <div id="cejas">
            <button name="oculto" type="submit" value="1"
            @if($proyt->nomproy != '' && $proyt->idusuarior != '' && $proyt->aprobo != '')
                class="boton-ceja-carpeta-success"
            @else
                class="boton-ceja-carpeta"
            @endif>
                A
            </button>
            <button name="oculto" type="submit" value="2"
            @if($proyt->antecedente != '' && $proyt->orientacion != '' && $proyt->materia != '' && $proyt->justificacion != '')
                class="boton-ceja-carpeta-success"
            @else
                class="boton-ceja-carpeta"
            @endif>
                B
            </button>
            <button name="oculto" type="submit" value="3"
            @if($proyt->objetivo != '' && $proyt->alcance != '' && $proyt->metodologia != '' && $proyt->objespecifico != '')
                class="boton-ceja-carpeta-success"
            @else
                class="boton-ceja-carpeta"
            @endif>
                C
            </button>
            <button name="oculto" type="submit" value="4"
            @if($proyt->producto != '' && $proyt->comcliente != '' && $proyt->beneficios != '')
                class="boton-ceja-carpeta-success"
            @else
                class="boton-ceja-carpeta"
            @endif>
                D
            </button>
            <button name="oculto"  type="submit" value="5" class="boton-ceja-carpeta-actual">
                E
            </button>
        </div>
        <br>
         @php
$soloLectura = ($proyt->estado != 1); // Solo editable si el estado es 1 (en ejecución)
@endphp
        <div id="formulario" @if($soloLectura) class="solo-lectura" @endif>
            <div class="container" style="max-width: 800px; width: 100%; margin: 0 auto;">
                <div>
                    @if (Session::has('success'))
                        <div id="exito">{{Session::get('success')}}</div>
                        <br>
                    @endif
                    @if (Session::has('fail'))
                        <div id="fallo">{{Session::get('fail')}}</div>
                        <br>
                    @endif
                    @csrf
                    <div id="clave">
                        {{$proyt->clavea}}{{$proyt->clavet}}-@if($proyt->claven < 10)0{{$proyt->claven}}@else{{$proyt->claven}}@endif/{{$proyt->clavey}} - {{$proyt->nomproy}}
                    </div>
{{-- CLIENTE O USUARIO POTENCIAL --}}
<div>
  <br>
  <div class="form-group select-client-wrapper {{ $soloLectura ? 'solo-lectura-categorias' : '' }}">

    <!-- Contenedor que solo se oculta si está en solo lectura -->
    <div class="{{ $soloLectura ? 'hide-categorias' : '' }}">
      <label> Categoría (Nivel 1) </label>
      <label> Categoría (Nivel 2) </label>
      <label> Categoría (Nivel 3) </label>
    </div>

    <x-select-client
      label="Cliente o Usuario Potencial"
      nameField="userpot"
      :categories="$categoriesN1"
      :cliente="$clienteSeleccionado"
      :categoriesN2="$categoriesN2"
      :categoriesN3="$categoriesN3"
    />
    <span class="text-danger">@error('userpot') {{ $message }} @enderror</span>
  </div>
</div>

                    

            <label> Línea de investigación </label>
            <div>
                @if($soloLectura)
                    <!-- Modo solo lectura: Mostrar el select, pero deshabilitarlo -->
                    <select name="lins" id="lins" style="width: 100%" disabled>
                        @if ($proyt->idlinea != '')
                            <option value="{{ $proyt->idlinea }}" selected>
                                @foreach ($invs as $inv)
                                    @if ($proyt->idlinea == $inv->id)
                                        {{ $inv->nombre_linea }}
                                    @endif
                                @endforeach
                            </option>
                        @endif
                        <!-- Asegúrate de que el resto de las opciones estén disponibles, pero no seleccionables -->
                        <option value="">{{ old('lins') ?? 'Selecciona...' }}</option>
                        @foreach ($invs as $inv)
                            <option value="{{ $inv->id }}" @if($proyt->idlinea == $inv->id) selected @endif>
                                {{ $inv->nombre_linea }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <!-- Modo edición: Mostrar el select editable -->
                    <select name="lins" id="lins" style="width: 100%" onchange="cambio(this)">
                        @if ($proyt->idlinea != '')
                            <option value="{{ $proyt->idlinea }}" selected>
                                @foreach ($invs as $inv)
                                    @if ($proyt->idlinea == $inv->id)
                                        {{ $inv->nombre_linea }}
                                    @endif
                                @endforeach
                            </option>
                        @endif
                        <option value="{{ old('lins') }}">Selecciona...</option>
                        @foreach ($invs as $inv)
                            <option value="{{ $inv->id }}" @if($proyt->idlinea == $inv->id) selected @endif>
                                {{ $inv->nombre_linea }}
                            </option>
                        @endforeach
                    </select>
                @endif
                <span class="text-danger">@error('lins') {{$message}} @enderror</span>
            </div>
                    <br>
                  <label>Objetivo sectorial</label>
            <div>
                <select name="objs" id="objs" onchange="cambio1(this)" style="width: 100%;" 
                    @if($soloLectura) disabled @endif>  <!-- Usamos 'disabled' para simular solo lectura -->

                    @if ($proyt->idobjt != '')
                        @foreach ($objs as $obj)
                            @if ($proyt->idobjt == $obj->id)
                                <option value="{{ $proyt->idobjt }}" title="{{ $obj->nombre_objetivosec }}" selected
                                    style="width: 100%;">{{ \Illuminate\Support\Str::limit($obj->nombre_objetivosec, 100, '...') }}</option>
                            @endif
                        @endforeach
                    @endif

                    <option value="{{ old('objs') }}">Selecciona...</option>

                    @foreach ($objs as $obj)
                        <option value="{{ $obj->id }}" title="{{ $obj->nombre_objetivosec }}"
                            style="width: 100%;">{{ \Illuminate\Support\Str::limit($obj->nombre_objetivosec, 100, '...') }}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('objs') {{$message}} @enderror</span>
            </div>
                    <br>
                    <label>Alineación al programa sectorial</label>
            <div>
                <select name="alin" id="alin" onchange="cambio2(this)" style="width: 100%;" 
                    @if($soloLectura) disabled @endif>  <!-- Usamos 'disabled' para simular solo lectura -->

                    @if ($proyt->idalin != '')
                        @foreach ($alins as $ali)
                            @if ($proyt->idalin == $ali->id)
                                <option value="{{ $proyt->idalin }}" selected>{{ $ali->nombre }}</option>
                            @endif
                        @endforeach
                    @endif

                    <option value="{{ old('alin') }}">Selecciona...</option>

                    @foreach ($alins as $ali)
                        <option value="{{ $ali->id }}">{{ $ali->nombre }}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('alin') {{$message}} @enderror</span>
            </div>

                    <br>

                    <label>Modo de transporte</label>
<div>
    <select name="tran" id="tran" onchange="cambio3(this)" style="width: 100%;" 
        @if($soloLectura) disabled @endif>  <!-- Usamos 'disabled' para simular solo lectura -->

        @if ($proyt->idmodot != '')
            @foreach ($trans as $tra)
                @if ($proyt->idmodot == $tra->id)
                    <option value="{{ $proyt->idmodot }}" selected>{{ $tra->nombre_transporte }}</option>
                @endif
            @endforeach
        @endif

        <option value="{{ old('tran') }}">Selecciona...</option>
        
        @foreach ($trans as $tra)
            <option value="{{ $tra->id }}" @if($proyt->idmodot == $tra->id) selected @endif>
                {{ $tra->nombre_transporte }}
            </option>
        @endforeach
    </select>
    
    <span class="text-danger">@error('tran') {{$message}} @enderror</span>
    
    <br>
    
    <!-- Mostrar campo de texto "Otro transporte" solo si la selección lo requiere -->
    @if ($proyt->idmodot == 'Otro')
        <input id="otran" name="otran" type="text" value="{{ old('otran', $proyt->otrotrans) }}" 
            @if($soloLectura) disabled @endif 
            placeholder="Otro transporte" />
    @else
        <input id="otran" name="otran" type="text" style="display: none;" 
            placeholder="Otro transporte" value="{{ old('otran') }}" />
    @endif
    
    <span class="text-danger">@error('otran') {{$message}} @enderror</span>
</div>
                    <br>
<label> Referencias 
     <span class="hint-inline" title="Describe las fuentes, libros, artículos, normativas o cualquier otro recurso relevante que haya sido consultado o que se utilice como base en la investigación.">
            <img src="{{ asset('/img/noteimp.png') }}" alt="Nota">
</label>
<br>
<div class="form-group">
    @php
        $referencias = old('referencias', $proyt->referencias ?? '');
        $placeholderRef = '';
    @endphp

    @if($soloLectura)
        <!-- Modo solo lectura: Mostrar el contenido con estilo normal, sin fondo gris -->
        <textarea class="form-control readonly-textarea" rows="5" readonly>{{ html_entity_decode(strip_tags($referencias)) ?: $placeholderRef }}</textarea>
    @else
        <!-- Modo edición con Quill -->
        <div id="editor-referencias" class="editor-quill" data-input="referencias" style="min-height:120px;">
            @if(empty(strip_tags($referencias)))
                <div class="ql-placeholder">{{ $placeholderRef }}</div>
            @else
                {!! $referencias !!}
            @endif
        </div>
    @endif
</div>




    <!-- Valor para enviar al backend -->
    <input type="hidden" name="referencias" value="{{ $referencias }}">
    <span class="text-danger">@error('referencias') {{$message}} @enderror</span>
</div>
                    <br>
                    <div>
                        @if ($proyt->notasmetodologia == '')
                            <button id="notas" onclick="mostrarElemento()" type="button">
                                <img src="../img/notebl.png" width="18px" height="18px" alt="">&nbsp;NOTAS
                            </button>
                            <br>
                            <textarea type="text" id="notasmetodologia" name="notasmetodologia" rows="3" style="display: none;" oninput="autoResize(this)">{{old('notasmetodologia')}}</textarea>
                        @else
                            <h4> Notas </h4>
                            <textarea type="text" id="notasmetodologia" name="notasmetodologia" rows="3" oninput="autoResize(this)">{{$proyt->notasmetodologia}}</textarea>
                        @endif
                    </div>
                    <br>
                    <div style="text-align: center">
                        <button type="submit" id="actualizar" value="6" name="oculto">
                            <img src="../img/save.png" width="25px" height="25px" alt="">
                            &nbsp;
                            Continuar
                        </button>
                    </div>
                    <br>
                </div>
            </div>
        </div>

    </form>
    <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill-table-ui.min.js') }}"></script>
    <script src="{{ asset('js/quill-config.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
@stack('scripts')       
</body>
</html>