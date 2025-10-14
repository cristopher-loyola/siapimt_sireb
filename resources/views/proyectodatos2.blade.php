<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datos proyecto</title>
    <link rel="icon" href="../img/Logo_IMT_mini.png" type="image/png" />
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script> --}}
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
            max-width: 500px;
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
    </style>
    <script>
        function autoResize(textarea) {
            const actualizar = document.getElementById('actualizar');
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
            textarea.style.borderColor  = "#ed2f39";
            actualizar.id = 'modificar';
        };

        window.addEventListener('load', () => {
            const textarea = document.getElementById('objetivo');
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
            const textarea1 = document.getElementById('alcance');
            textarea1.style.height = 'auto';
            textarea1.style.height = (textarea1.scrollHeight) + 'px';
            const textarea2 = document.getElementById('metodologia');
            textarea2.style.height = 'auto';
            textarea2.style.height = (textarea2.scrollHeight) + 'px';
            const textarea3 = document.getElementById('objetivoespc');
            textarea3.style.height = 'auto';
            textarea3.style.height = (textarea3.scrollHeight) + 'px';
            const textarea4 = document.getElementById('notasmetodologia');
            textarea4.style.height = 'auto';
            textarea4.style.height = (textarea4.scrollHeight) + 'px';
            const textarea5 = document.getElementById('notaobj');
            textarea5.style.height = 'auto';
            textarea5.style.height = (textarea5.scrollHeight) + 'px';
            const textarea6 = document.getElementById('notaobjes');
            textarea6.style.height = 'auto';
            textarea6.style.height = (textarea6.scrollHeight) + 'px';
            const textarea7 = document.getElementById('notalcance');
            textarea7.style.height = 'auto';
            textarea7.style.height = (textarea7.scrollHeight) + 'px';
            const textarea8 = document.getElementById('notametod');
            textarea8.style.height = 'auto';
            textarea8.style.height = (textarea8.scrollHeight) + 'px';
        });
        
        function toggleVisibility() {
            var element = document.getElementById("obj1");
            var checkbox = document.getElementById("mostrarOcultar");
            var textarea = document.getElementById('notaobj');

            if (checkbox.checked) {
                element.style.display = "block";
                textarea.style.width = `580px`;
                textarea.style.height = `60px`;
            } else {
                element.style.display = "none";
            }
        }

        function toggleVisibility1() {
            var element = document.getElementById("obj2");
            var checkbox = document.getElementById("mostrarOcultar1");
            var textarea = document.getElementById('notaobjes');

            if (checkbox.checked) {
                element.style.display = "block";
                textarea.style.width = `580px`;
                textarea.style.height = `60px`;
            } else {
                element.style.display = "none";
            }
        }

        function toggleVisibility2() {
            var element = document.getElementById("obj3");
            var checkbox = document.getElementById("mostrarOcultar2");
            var textarea = document.getElementById('notalcance');

            if (checkbox.checked) {
                element.style.display = "block";
                textarea.style.width = `580px`;
                textarea.style.height = `60px`;
            } else {
                element.style.display = "none";
            }
        }

        function toggleVisibility3() {
            var element = document.getElementById("obj4");
            var checkbox = document.getElementById("mostrarOcultar3");
            var textarea = document.getElementById('notametod');

            if (checkbox.checked) {
                element.style.display = "block";
                textarea.style.width = `580px`;
                textarea.style.height = `60px`;
            } else {
                element.style.display = "none";
            }
        }

        // tinymce.init({
        //     selector: '#metodologia',
        //     plugins: 'advlist autolink lists link image charmap print preview anchor',
        //     toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
        // });

        $(document).ready(function() {
            setTimeout(function() {
                $("#exito").fadeOut(1500);
                $("#fallo").fadeOut(1500);
            },3000);
        });
    </script>

    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill-table-ui.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
</head>
@php
    // Modo solo lectura si NO viene ?crear=1
    $soloLectura = request('crear') != 1;
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
    <br>
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

            /* Efecto de iluminación y tooltip */
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

                /* Centrar el texto dentro del tooltip */
                display: flex;
                align-items: center; /* Centra verticalmente */
                justify-content: center; /* Centra horizontalmente */
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

            /* Tooltip específico para la pestaña activa */
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
            .ql-toolbar.ql-snow,
            .editor-quill {
                width: 800px;
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
                @if (($proyt->clavet == 'I' ||$proyt->clavet == 'E') && ($proyt->clavea == 'D' || $proyt->clavea == 'A' || $proyt->clavea == 'G'))
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
                {{--MENU PARA LOS PROYS EXTERNOS--}}
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
                    id="item6>
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
    <form action="{{ route('actulizarproyecto2', $proyt->id) }}" method="POST">
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
        <button name="oculto" type="submit" value="3" class="boton-ceja-carpeta-actual">
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
        <button name="oculto"  type="submit" value="5"
        @if($proyt->idlinea != '' && $proyt->idobjt != '' && $proyt->idalin != '' && $proyt->idmodot != '' && $proyt->referencias != '')
            class="boton-ceja-carpeta-success"
        @else
            class="boton-ceja-carpeta"
        @endif>
            E
        </button>
    </div>
    <br>
       @php
$soloLectura = in_array($proyt->estado, [2, 3, 4]); // Proyectos concluidos (2), cancelados (3) y no aceptados (4)
@endphp
    <div id="formulario">
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
                {{$proyt->clavea}}{{$proyt->clavet}}-@if($proyt->claven < 10)0{{$proyt->claven}}@else{{$proyt->claven}}@endif/{{$proyt->clavey}} -
                {{$proyt->nomproy}}
            </div>
            <br>
<label> Objetivo 
     <span class="hint-inline" title="Describe con precisión los propósitos de la investigación. Es necesario incluir el objetivo general y los objetivos específicos.">
            <img src="{{ asset('/img/noteimp.png') }}" alt="Nota">
</label>
<div style="height: 10px;"></div>

@php
    $objetivo = old('objetivo', $proyt->objetivo ?? '');
    $placeholderObj = '';
@endphp

<div class="form-group">
    @if($soloLectura)  <!-- Verifica si está en modo solo lectura (proyecto concluido) -->
        <!-- Modo solo lectura: Mostrar el contenido en un textarea solo lectura -->
        <textarea class="form-control" rows="5" readonly>{{ html_entity_decode(strip_tags($objetivo)) ?: $placeholderObj }}</textarea>
    @else
        <!-- Modo edición: Mostrar el editor Quill -->
        <div id="editor-objetivo" class="editor-quill" data-input="objetivo">
            @if(empty(strip_tags($objetivo)))
                <!-- Si no hay contenido, se muestra el placeholder -->
                <div class="ql-placeholder">{{ $placeholderObj }}</div>
            @else
                <!-- Si hay contenido, se muestra en el editor Quill -->
                {!! $objetivo !!}
            @endif
        </div>
    @endif

    <input type="hidden" name="objetivo" value="{{ $objetivo }}">
    <span class="text-danger">@error('objetivo') {{$message}} @enderror</span>
</div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Obtén el nombre del usuario (esto lo pasa Laravel con Blade)
                    const userName = @json($LoggedUserInfo['Nombre']);

                    // Selecciona el textarea
                    const contentField = document.getElementById('notaobj');

                    // Función para auto-ajustar la altura del textarea
                    function autoResizeuniq() {
                        // Restablecer la altura para que el contenido no se corte al redimensionar
                        contentField.style.height = 'auto';
                        contentField.style.height = (contentField.scrollHeight) + 'px';
                    }

                    // Variable para verificar si es el primer comentario
                    let firstComment = true;

                    // Escucha el evento keydown para detectar cuando se presiona "Enter"
                    contentField.addEventListener('keydown', function(event) {
                        // Verifica si la tecla presionada es "Enter" (código de tecla 13)
                        if (event.key === "Enter") {
                            // Prevenir el comportamiento por defecto del Enter (que agregue un salto de línea extra)
                            event.preventDefault();
                            
                            // Obtén el texto actual del textarea
                            const currentText = contentField.value.trim();

                            // Si el texto no está vacío, agrega el nombre de usuario seguido de un salto de línea
                            if (currentText.length > 0) {
                                // Añadir el nombre del usuario y luego un salto de línea
                                contentField.value = currentText + "\n" + userName + ": ";
                                
                                // Llamamos a la función para redimensionar el textarea después de agregar el nombre
                                autoResizeuniq();
                            }
                        }
                    });

                    // Escucha el evento input para agregar el nombre en el primer comentario
                    contentField.addEventListener('input', function() {
                        // Verifica si es el primer comentario
                        if (firstComment && contentField.value.trim().length > 0) {
                            contentField.value = userName + ": " + contentField.value.replace(/^.*?:\s*/, "");
                            firstComment = false;  // Después de esto, ya no será el primer comentario
                            autoResizeuniq();  // Asegura que se ajuste el tamaño después de agregar el nombre
                        }
                    });

                    // Inicializa la función de auto-resize al cargar la página
                    autoResizeuniq();
                });
            </script>
            @if ($proyt->aprobo == $LoggedUserInfo['id'])
                @if ($proyt->obsnotasobj == '')
                    <div>
                        <label for="mostrarOcultar">Agregar comentario:</label>
                        <input type="checkbox" id="mostrarOcultar" onclick="toggleVisibility()">
                    </div>
                    <br>
                    <div class="constpostick">
                        <div class="post-it" id="obj1" style="display: none">
                            <div class="post-it-title">Comentario: Objetivo</div>
                            <textarea type="text" id="notaobj" name="notaobj" rows="3" oninput="autoResize(this)">{{old('notaobj')}}</textarea>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="constpostick">
                        <div class="post-it">
                            <div class="post-it-title">Comentario: Objetivo</div>
                            <textarea type="text" id="notaobj" name="notaobj" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasobj}}</textarea>
                        </div>
                    </div>
                @endif
            @else
                @if ($proyt->obsnotasobj != '')
                    @if ($proyt->gprotocolo != 2)
                        <br>
                        <div class="constpostick">
                            <div class="post-it">
                                <div class="post-it-title">Comentario: Objetivo</div>
                                <textarea type="text" id="notaobj" name="notaobj" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasobj}}</textarea>
                            </div>
                        </div>
                    @endif
                @endif
            @endif

            <br>
  <label> Objetivo específicos 
    <span class="hint-inline" title="Describe los objetivos específicos de la investigación.">
            <img src="{{ asset('/img/noteimp.png') }}" alt="Nota">
</label>
  </label>
<div style="height: 10px;"></div>

@php
    $objetivoespc = old('objetivoespc', $proyt->objespecifico ?? '');
    $placeholderObjEsp = '';
@endphp

<div class="form-group">
    @if($soloLectura)
        <!-- Solo lectura -->
        <textarea class="form-control" rows="5" readonly>{{ html_entity_decode(strip_tags($objetivoespc)) ?: $placeholderObjEsp }}</textarea>
    @else
        <!-- Edición con Quill -->
        <div id="editor-objetivoespc" class="editor-quill" data-input="objetivoespc">
            @if(empty(strip_tags($objetivoespc)))
                <div class="ql-placeholder">{{ $placeholderObjEsp }}</div>
            @else
                {!! $objetivoespc !!}
            @endif
        </div>
    @endif

    <!-- Donde se envía al servidor -->
    <input type="hidden" name="objetivoespc" value="{{ $objetivoespc }}">
    <span class="text-danger">@error('objetivoespc') {{$message}} @enderror</span>
</div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Obtén el nombre del usuario (esto lo pasa Laravel con Blade)
                    const userName = @json($LoggedUserInfo['Nombre']);

                    // Selecciona el textarea
                    const contentField = document.getElementById('notaobjes');

                    // Función para auto-ajustar la altura del textarea
                    function autoResizeuniq() {
                        // Restablecer la altura para que el contenido no se corte al redimensionar
                        contentField.style.height = 'auto';
                        contentField.style.height = (contentField.scrollHeight) + 'px';
                    }

                    // Variable para verificar si es el primer comentario
                    let firstComment = true;

                    // Escucha el evento keydown para detectar cuando se presiona "Enter"
                    contentField.addEventListener('keydown', function(event) {
                        // Verifica si la tecla presionada es "Enter" (código de tecla 13)
                        if (event.key === "Enter") {
                            // Prevenir el comportamiento por defecto del Enter (que agregue un salto de línea extra)
                            event.preventDefault();
                            
                            // Obtén el texto actual del textarea
                            const currentText = contentField.value.trim();

                            // Si el texto no está vacío, agrega el nombre de usuario seguido de un salto de línea
                            if (currentText.length > 0) {
                                // Añadir el nombre del usuario y luego un salto de línea
                                contentField.value = currentText + "\n" + userName + ": ";
                                
                                // Llamamos a la función para redimensionar el textarea después de agregar el nombre
                                autoResizeuniq();
                            }
                        }
                    });

                    // Escucha el evento input para agregar el nombre en el primer comentario
                    contentField.addEventListener('input', function() {
                        // Verifica si es el primer comentario
                        if (firstComment && contentField.value.trim().length > 0) {
                            contentField.value = userName + ": " + contentField.value.replace(/^.*?:\s*/, "");
                            firstComment = false;  // Después de esto, ya no será el primer comentario
                            autoResizeuniq();  // Asegura que se ajuste el tamaño después de agregar el nombre
                        }
                    });

                    // Inicializa la función de auto-resize al cargar la página
                    autoResizeuniq();
                });
            </script>
            @if ($proyt->aprobo == $LoggedUserInfo['id'])
                @if ($proyt->obsnotasobjes == '')
                    <div>
                        <label for="mostrarOcultar1">Agregar comentario:</label>
                        <input type="checkbox" id="mostrarOcultar1" onclick="toggleVisibility1()">
                    </div>
                    <br>
                    <div class="constpostick">
                        <div class="post-it" id="obj2" style="display: none">
                            <div class="post-it-title">Comentario: Objetivo específicos</div>
                            <textarea type="text" id="notaobjes" name="notaobjes" rows="3" oninput="autoResize(this)">{{old('notaobjes')}}</textarea>
                        </div>
                    </div>
                 @else
                    <br>
                    <div class="constpostick">
                        <div class="post-it">
                                <div class="post-it-title">Comentario: Objetivo específicos</div>
                            <textarea type="text" id="notaobjes" name="notaobjes" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasobjes}}</textarea>
                        </div>
                    </div>
                @endif
            @else
                @if ($proyt->obsnotasobjes != '')
                    @if ($proyt->gprotocolo != 2)
                        <br>
                        <div class="constpostick">
                            <div class="post-it">
                                <div class="post-it-title">Comentario: Objetivo específicos</div>
                                <textarea type="text" id="notaobjes" name="notaobjes" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasobjes}}</textarea>
                            </div>
                        </div>
                    @endif
                @endif
            @endif

            <br>
           <label> Alcances 
                <span class="hint-inline" title="Describe las metas que se deben cumplir o los resultados que se obtendrán a partir de la ejecución del proyecto, de tal manera que se acote el trabajo a realizar en términos de profundidad y extensión.">
            <img src="{{ asset('/img/noteimp.png') }}" alt="Nota">
           </label>
<div style="height: 10px;"></div>

@php
    $alcance = old('alcance', $proyt->alcance ?? '');
    $placeholderAlc = '';
@endphp

<div class="form-group">
    @if($soloLectura)
        <!-- Solo lectura -->
        <textarea class="form-control" rows="5" readonly>{{ html_entity_decode(strip_tags($alcance)) ?: $placeholderAlc }}</textarea>
    @else
        <!-- Edición con Quill -->
        <div id="editor-alcance" class="editor-quill" data-input="alcance">
            @if(empty(strip_tags($alcance)))
                <div class="ql-placeholder">{{ $placeholderAlc }}</div>
            @else
                {!! $alcance !!}
            @endif
        </div>
    @endif

    <!-- Valor para enviar al backend -->
    <input type="hidden" name="alcance" value="{{ $alcance }}">
    <span class="text-danger">@error('alcance') {{$message}} @enderror</span>
</div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Obtén el nombre del usuario (esto lo pasa Laravel con Blade)
                    const userName = @json($LoggedUserInfo['Nombre']);

                    // Selecciona el textarea
                    const contentField = document.getElementById('notalcance');

                    // Función para auto-ajustar la altura del textarea
                    function autoResizeuniq() {
                        // Restablecer la altura para que el contenido no se corte al redimensionar
                        contentField.style.height = 'auto';
                        contentField.style.height = (contentField.scrollHeight) + 'px';
                    }

                    // Variable para verificar si es el primer comentario
                    let firstComment = true;

                    // Escucha el evento keydown para detectar cuando se presiona "Enter"
                    contentField.addEventListener('keydown', function(event) {
                        // Verifica si la tecla presionada es "Enter" (código de tecla 13)
                        if (event.key === "Enter") {
                            // Prevenir el comportamiento por defecto del Enter (que agregue un salto de línea extra)
                            event.preventDefault();
                            
                            // Obtén el texto actual del textarea
                            const currentText = contentField.value.trim();

                            // Si el texto no está vacío, agrega el nombre de usuario seguido de un salto de línea
                            if (currentText.length > 0) {
                                // Añadir el nombre del usuario y luego un salto de línea
                                contentField.value = currentText + "\n" + userName + ": ";
                                
                                // Llamamos a la función para redimensionar el textarea después de agregar el nombre
                                autoResizeuniq();
                            }
                        }
                    });

                    // Escucha el evento input para agregar el nombre en el primer comentario
                    contentField.addEventListener('input', function() {
                        // Verifica si es el primer comentario
                        if (firstComment && contentField.value.trim().length > 0) {
                            contentField.value = userName + ": " + contentField.value.replace(/^.*?:\s*/, "");
                            firstComment = false;  // Después de esto, ya no será el primer comentario
                            autoResizeuniq();  // Asegura que se ajuste el tamaño después de agregar el nombre
                        }
                    });

                    // Inicializa la función de auto-resize al cargar la página
                    autoResizeuniq();
                });
            </script>
            @if ($proyt->aprobo == $LoggedUserInfo['id'])
                @if ($proyt->obsnotasalcn == '')
                    <div>
                        <label for="mostrarOcultar2">Agregar comentario:</label>
                        <input type="checkbox" id="mostrarOcultar2" onclick="toggleVisibility2()">
                    </div>
                    <br>
                    <div class="constpostick">
                        <div class="post-it" id="obj3" style="display: none">
                            <div class="post-it-title">Comentario: Alcances</div>
                            <textarea type="text" id="notalcance" name="notalcance" rows="3" oninput="autoResize(this)">{{old('notalcance')}}</textarea>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="constpostick">
                        <div class="post-it">
                            <div class="post-it-title">Comentario: Alcances</div>
                            <textarea type="text" id="notalcance" name="notalcance" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasalcn}}</textarea>
                        </div>
                    </div>
                @endif
            @else
                @if ($proyt->obsnotasalcn != '')
                    @if ($proyt->gprotocolo != 2)
                        <br>
                        <div class="constpostick">
                            <div class="post-it">
                                <div class="post-it-title">Comentario: Alcances</div>
                                <textarea type="text" id="notalcance" name="notalcance" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasalcn}}</textarea>
                            </div>
                        </div>
                    @endif
                @endif
            @endif

            <br>
           <label> Metodología 
             <span class="hint-inline" title="Describe el método a utilizar en la investigación (inductivo, deductivo o experimental, entre otros), las fases que la integran y sus relaciones lógicas. También se deben describir las técnicas (estadística descriptiva, regresión y correlación, optimización matemática, heurísticas o simulación, entre otras) que se utilizarán y las razones que explican su elección.">
            <img src="{{ asset('/img/noteimp.png') }}" alt="Nota">
           </label>
<div style="height: 10px;"></div>

@php
    $metodologia = old('metodologia', $proyt->metodologia ?? '');
    $placeholderMet = '';
@endphp

<div class="form-group">
    @if($soloLectura)
        <!-- Solo lectura -->
        <textarea class="form-control" rows="5" readonly>{{ html_entity_decode(strip_tags($metodologia)) ?: $placeholderMet }}</textarea>
    @else
        <!-- Edición con Quill -->
        <div id="editor-metodologia" class="editor-quill" data-input="metodologia">
            @if(empty(strip_tags($metodologia)))
                <div class="ql-placeholder">{{ $placeholderMet }}</div>
            @else
                {!! $metodologia !!}
            @endif
        </div>
    @endif

    <!-- Valor para enviar al backend -->
    <input type="hidden" name="metodologia" value="{{ $metodologia }}">
    <span class="text-danger">@error('metodologia') {{$message}} @enderror</span>
</div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Obtén el nombre del usuario (esto lo pasa Laravel con Blade)
                    const userName = @json($LoggedUserInfo['Nombre']);

                    // Selecciona el textarea
                    const contentField = document.getElementById('notametod');

                    // Función para auto-ajustar la altura del textarea
                    function autoResizeuniq() {
                        // Restablecer la altura para que el contenido no se corte al redimensionar
                        contentField.style.height = 'auto';
                        contentField.style.height = (contentField.scrollHeight) + 'px';
                    }

                    // Variable para verificar si es el primer comentario
                    let firstComment = true;

                    // Escucha el evento keydown para detectar cuando se presiona "Enter"
                    contentField.addEventListener('keydown', function(event) {
                        // Verifica si la tecla presionada es "Enter" (código de tecla 13)
                        if (event.key === "Enter") {
                            // Prevenir el comportamiento por defecto del Enter (que agregue un salto de línea extra)
                            event.preventDefault();
                            
                            // Obtén el texto actual del textarea
                            const currentText = contentField.value.trim();

                            // Si el texto no está vacío, agrega el nombre de usuario seguido de un salto de línea
                            if (currentText.length > 0) {
                                // Añadir el nombre del usuario y luego un salto de línea
                                contentField.value = currentText + "\n" + userName + ": ";
                                
                                // Llamamos a la función para redimensionar el textarea después de agregar el nombre
                                autoResizeuniq();
                            }
                        }
                    });

                    // Escucha el evento input para agregar el nombre en el primer comentario
                    contentField.addEventListener('input', function() {
                        // Verifica si es el primer comentario
                        if (firstComment && contentField.value.trim().length > 0) {
                            contentField.value = userName + ": " + contentField.value.replace(/^.*?:\s*/, "");
                            firstComment = false;  // Después de esto, ya no será el primer comentario
                            autoResizeuniq();  // Asegura que se ajuste el tamaño después de agregar el nombre
                        }
                    });

                    // Inicializa la función de auto-resize al cargar la página
                    autoResizeuniq();
                });
            </script>
            @if ($proyt->aprobo == $LoggedUserInfo['id'])
                @if ($proyt->obsnotasmetd == '')
                    <div>
                        <label for="mostrarOcultar3">Agregar comentario:</label>
                        <input type="checkbox" id="mostrarOcultar3" onclick="toggleVisibility3()">
                    </div>
                    <br>
                    <div class="constpostick">
                        <div class="post-it" id="obj4" style="display: none">
                            <div class="post-it-title">Comentario: Metodología</div>
                            <textarea type="text" id="notametod" name="notametod" rows="3" oninput="autoResize(this)">{{old('notametod')}}</textarea>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="constpostick">
                        <div class="post-it">
                            <div class="post-it-title">Comentario: Metodología</div>
                            <textarea type="text" id="notametod" name="notametod" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasmetd}}</textarea>
                        </div>
                    </div>
                @endif
            @else
                @if ($proyt->obsnotasmetd != '')
                    @if ($proyt->gprotocolo != 2)
                        <br>
                        <div class="constpostick">
                            <div class="post-it">
                                <div class="post-it-title">Comentario: Metodología</div>
                                <textarea type="text" id="notametod" name="notametod" rows="3" oninput="autoResize(this)">{{$proyt->obsnotasmetd}}</textarea>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
            <br>
            <br>
            {{-- <div style="text-align: center">
                <button type="submit" id="actualizar">
                    <img src="../img/save.png" width="25px" height="25px" alt="">
                    &nbsp;
                    Guardar
                </button>
            </div> --}}
        </div>
    </div>
    </form>

    <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill-table-ui.min.js') }}"></script>
    <script src="{{ asset('js/quill-config.js') }}"></script>
</body>
</html>