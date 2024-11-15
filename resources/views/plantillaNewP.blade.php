<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="icon" href="img/Logo_IMT_mini.png" type="image/png" />

        <style>
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                /*font-family: "Poppins", sans-serif;*/
                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            body{
                position: relative;
                min-height: 100vh;
                width: 100%;
                overflow: hidden;
                background: #1F4CF0;
                overflow-y:auto;
                background: linear-gradient(to right,#1F7CF0, #1c4aee)
            }
            /* define las propiedades de los option de los selct */
            #formao{
            }
            /* select {
                width: 200px;
                max-width: 100%;
            }
            option {
                -moz-white-space: pre-wrap;
                -o-white-space: pre-wrap;
                white-space: pre-wrap;
                overflow: hidden;
                text-overflow: Ellipsis;
                border-bottom: 1px solid #DDD;
            } */
            .sidebar{
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 78px;
                z-index: 1;
                background: #1A2C6E;
                padding: 6px 14px;
                transition: all 0.5s ease
            }
            /*Da tamaño al navbar deplejsafo*/
            .sidebar.active{
                width: 240px;
            }
            /*Define los elementos de la navbar de manera que se pueda manerja*/
            .sidebar .logo_content .logo{
                color: #fff;
                display: flex;
                height: 50px;
                width: 100%;
                align-items: center;
            }
            .sidebar.active .logo_content .logo{
                opacity: 1;
                pointer-events: none;
            }
            /*Oculta el logo y lo muestra al desplegar*/
            .sidebar #blanco{
                opacity: 0;
                pointer-events: none;
            }
            .sidebar.sidebar.active #blanco{
                opacity: 1;
                pointer-events: none;
            }
            /*Define el tamaño de los div mencionados*/
            .logo_content .logo{
                font-size: 28px;
                margin-right: 5px;
            }
            .logo_content .logo .logo_name{
                font-size: 28px;
                margin-right: 400;
            }
            .sidebar #btn{
                color: #fff;
                position: absolute;
                left: 50%;
                top: 6px;
                font-size: 20px;
                height: 50px;
                width: 50px;
                text-align: center;
                line-height: 50px;
                transform: translateX(-50%);
            }
            /*Activa la navbar para desplegarla*/
            .sidebar.active #btn{
                left: 90%;
            }
            /*Parametros de los elementos de la navbar*/
            .sidebar ul{
                margin-top: 20px;   
            }
            .sidebar ul li{
                position: relative;
                height: 50px;
                width: 100%;
                margin: 0 5px;
                list-style: none;
                line-height: 50px;
            }
            .sidebar ul li .tooltip{
                position: absolute;
                left: 122px;
                top: 50%;
                transform: translate(-50%,-50%);
                border-radius:6px; 
                height: 35px;
                width: 122px;
                background: #fff;
                line-height: 35px;
                text-align: center;
                box-shadow: 0 5px 10px rgba(0,0,0,0.2);
                transition: 0s;
                opacity: 0;
                pointer-events:none;
                display: block;
            }
            /*Actica la navbar con el efecto ocultando los tooltip*/
            .sidebar.active ul li:hover .tooltip{
                opacity: 0;
                display: block;
            }
            /*Muesta los tooltips al pasar por encima y solo sin estar acticva la navbar*/
            .sidebar ul li:hover .tooltip{
                top: 50%;
                opacity: 1;
                z-index: 2;
                transition: all 0.5s ease;
            }
            /*Da efectos a los botones*/
            .sidebar ul li a{
                color: #fff;
                display: flex;
                align-items: center;
                text-decoration: none;
                transition: all 0.4s ease;
                border-radius: 12px; 
                white-space: nowrap;
            }
            .sidebar ul li a:hover{
                color: #11101d;
                background: #fff;
            }
            .sidebar ul li i{
                height: 50px;
                min-width: 50px;
                border-radius: 12px;
                line-height: 50px;
                text-align: center;
            }
            /*Ocultan los links de los botones de la nav*/
            .sidebar .links_name{
                opacity: 0;
                pointer-events: none;
            }
            .sidebar.active .links_name{
                opacity: 1;
                transition: all 0.5s ease;
                pointer-events: auto;
            }
            #redond{
                border-radius: 100%;
            }
            /*Define el estilos de los titulos y subtitilos de la parte superios*/
            #titulo{
                font-size: 20px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #0c1c4e;
                text-align: center;
                position: absolute;
            }
            #subtitulo{
                font-size: 15px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #0c1c4e;
                text-align:center;
                position: relative;
                top: 5px;
            }
            #dia{
                font-size: 18px;
                font-family:Arial, Helvetica, sans-serif;
                color: #2d4aa7;
                position: relative;
                text-indent: 80px;
            }
            #tituloform{
                font-size: 25px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #0c1c4e;
                text-align: center;
            }
            #bgimg{
                background-image: url(img/imagen_login2.jpg);
                background-position: 50% 75%;
                background-size:cover;
                background-repeat: no-repeat;
                
            }
            #redond{
                border-radius: 25px;
                font-family:Verdana, Geneva, Tahoma, sans-serif; 
            }
            #colorform{
                background: #48515f;
            }
        </style>
    </head>
    <body>
      {{-- Barra de navegacion lateral principio --}}
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="img/Logo_blanco.png" alt="48" width="48" id="blanco">
                <div class="logo_name"></div>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <a href="ppindex">
                    <i class='bx bx-home'></i>
                  <span class="links_name">Inicio</span>
                </a>
                <span class="tooltip">Inicio</span>
            </li>
            <li>
                <a href="userAdmin">
                    <i class='bx bx-group'></i>
                    <span class="links_name">Admin. Usuarios</span>
                </a>
                <span class="tooltip">Admin. User</span>
            </li>
            <li>
                <a href="adpindex">
                    <i class='bx bx-folder'></i>
                    <span class="links_name">Gestion</span>
                </a>
                <span class="tooltip">Gestion</span>
            </li>
            <li>
                <a href="modt">
                    <i class='bx bxs-truck'></i>
                    <span class="links_name">Modo de transporte</span>
                </a>
                <span class="tooltip">Modo transporte</span>
            </li>
            <li>
                <a href="moda">
                    <i class='bx bxs-area'></i>
                    <span class="links_name">Area de adscripción</span>
                </a>
                <span class="tooltip">Área adscripción</span>
            </li>
            <li>
                <a href="contri">
                    <i class='bx bx-hive'></i>
                    <span class="links_name">Contribución a ..</span>
                </a>
                <span class="tooltip">Contribución a...</span>
            </li>
            <li>
                <a href="modinv">
                    <i class='bx bxs-analyse'></i>
                    <span class="links_name">Linea de Investigación</span>
                </a>
                <span class="tooltip">Línea investigación</span>
            </li>
            <li>
                <a href="modo">
                    <i class='bx bx-intersect'></i>
                    <span class="links_name">Objetivos Sectorial</span>
                </a>
                <span class="tooltip">Objetivo sectorial</span>
            </li>
            <li>
                <a href="modlin">
                    <i class='bx bxs-paper-plane'></i>
                    <span class="links_name">Prog. Sectorial</span>
                </a>
                <span class="tooltip">Programa sectorial</span>
            </li>
            <li>
                <a href="/">
                    <i class='bx bx-log-out-circle'></i>
                    <span class="links_name">Salir</span>
                </a>
                <span class="tooltip">Salir</span>
            </li>
        </ul>
    </div>          
    <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");
        btn.onclick = function(){
            sidebar.classList.toggle("active");
        }
    </script>
    <div class="container w-80 bg-white mt-4 rounded shadow">
                @yield('contenido')

    </div>
    <script src="bootstap.budle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>