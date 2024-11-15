<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="icon" href="img/Logo_IMT_mini.png" type="image/png" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script type="script/javascript" src=" {{asset('js/sumapartidas') }}"> </script>
        
        <style>

   
            
            body{
                position: relative;
                min-height: 100vh;
                width: 100%;
                overflow: hidden;
                background-image:url(img/fondo3.jpg);
                background-size:cover;
                background-repeat: repeat;
                overflow-y:auto;
                opacity: .95;
            }

            /* Container completo */ 
            #fondocaja{
                background-color: #e2e7ea;
                opacity: .95;
                padding: 30px 20px;
                box-shadow: 0px 0px 5px #848484;
            }

            /* Container pequeño */ 
            #fondocajita{
                background-color: #e2e7ea;
                opacity: .95;
                padding: 30px 20px;
            }

            /* SIDEBAR */ 
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

            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                /*font-family: "Poppins", sans-serif;*/
                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }

            /*Da tamaño al navbar desplegado*/
            .sidebar.active{
                width: 240px;
            }

            /*Define los elementos de la navbar de manera que se pueda manejar*/
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

            /* Termina la sidebar */

            /* Toggle activar/desactivar */
            
            #notifDiv{
                z-index: 10000;
                display: none;
                background-color: green;
                font-weight: 450;
                width: 350px;
                position: fixed;
                top: 80%;
                left: 5%;
                color: white;
                border-radius: 25PX;
                padding: 5px 20px;
            }
            .toggle{
                border-radius: 20px;
            }

            .slow .toggle-group{
                transition: left 0.7s;
                -webkit-transition: left 0.7s;
            }

            /*Termina Toggle */

            /*Define el estilos de los titulos y subtitilos de la parte superios*/
            #titulo{
                font-size: 30px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #2d4aa7;
                text-align: center;
                position: absolute;
            }
            #subtitulo{
                font-size: 22px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #2d4aa7;
                text-align:center;
                position: relative;
                top: 15px;
            }
            #dia{
                font-size: 15px;
                font-family:Arial, Helvetica, sans-serif;
                color: #2d4aa7;
                text-align:center;
                position: relative;
                left: 300px;
            }

            #tituloform{
                font-size: 40px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 42px;
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

            a:hover{
                text-decoration: none;
                opacity: 0;
                pointer-events: none;
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

                    <a href="moduloFinanciero">
                      <i class='bx bx-home'></i>
                      <span class="links_name">Inicio</span>
                    </a>
                    <span class="tooltip">Inicio</span>
                </li>
                 <li>
                    
                    <a href="partidas">
                        <i class='bx bx-customize'></i>
                      <span class="links_name">Partidas</span>
                    </a>
                    <span class="tooltip">Partidas</span>
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
            
        <div class="container jumbotron col-6 shadow-lg rounded font-weight-ligth col-xs-12 col-sm-6 col-md-8" id="fondocaja">
            <div>
                <img src="img/Logo_IMT.png" alt="65" width="100"><label id="titulo"> Instituto Mexicano del Transporte</label>
                <label id="subtitulo">Sistema Informático para la Administración de Proyectos </label>
                
            </div>
                @yield('contenido')
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
     
        @stack('hora')

    
    </body>
</html>