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
        <style>
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                /* font-family: "Poppins", sans-serif; */
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            body {
                background: #fff;
                background-size: 400% 400%;
                min-height: 100vh;
                width: 100%;
                overflow: hidden;
                height: 100vh;
                overflow-y:auto;
            }
            .sidebar{
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 90px;
                z-index: 1;
                background: #1e106d;
                padding: 6px 14px;
                transition: all 0.5s ease;
            }
            /*Da tamaño al navbar deplejsafo*/
            .sidebar.active{
                width: 300px;
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
            /* .sidebar ul li .tooltipalt{
                position: absolute;
                left: 122px;
                top: 50%;
                transform: translate(-50%,-50%);
                border-radius:6px; 
                height: 35px;
                width: 122px;
                background: rgb(42, 218, 26);
                line-height: 35px;
                text-align: center;
                box-shadow: 0 5px 10px rgba(0,0,0,0.2);
                transition: 0s;
                opacity: 0;
                pointer-events:none;
                display: block;
            } */
            /*Actica la navbar con el efecto ocultando los tooltip*/
            .sidebar.active ul li:hover .tooltip{
                opacity: 0;
                display: block;
            }
            #icon{
                opacity: 0;
                display: block;
            }
            /* .sidebar.active ul li:hover .tooltipalt{
                opacity: 0;
                display: block;
            } */
            /*Muesta los tooltips al pasar por encima y solo sin estar acticva la navbar*/
            .sidebar ul li:hover .tooltip{
                top: 50%;
                opacity: 1;
                transition: all 0.5s ease;
            }
            #icon{
                top: 50%;
                opacity: 1;
                transition: all 0.5s ease;
            }
            /* .sidebar ul li:hover .tooltipalt{
                top: 50%;
                opacity: 1;
                transition: all 0.5s ease;
            } */
             /*Da efectos a los botones*/
            #icon{
                color: #fff;
                display: flex;
                align-items: center;
                text-decoration: none;
                transition: all 0.5s ease;
                border-radius: 12px; 
                white-space: nowrap;
            }
            #icon:hover{
                color: #11101d;
                background: #fff;
            }
            #icon{
                height: 50px;
                min-width: 50px;
                border-radius: 12px;
                line-height: 50px;
                text-align: center;
            }
            .sidebar ul li a{
                color: #fff;
                display: flex;
                align-items: center;
                text-decoration: none;
                transition: all 0.5s ease;
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
            .sidebar .links_name_alt{
                opacity: 0;
                color: #fff;
                pointer-events: none;  
            }
            .sidebar.active .links_name_alt{
                opacity: 1;
                pointer-events: auto;
                color: #fff;
                transition: all 0.5s ease;
            }
            .sidebar .links_namealt{
                opacity: 0;
                pointer-events: none;  
            }
            .sidebar.active .links_namealt{
                opacity: 1;
                pointer-events: auto;
                transition: all 0.5s ease;
            }
            .sidebar .links_name{
                opacity: 0;
                pointer-events: none;
            }
            .sidebar.active .links_name{
                opacity: 1;
                pointer-events: auto;
                transition: all 0.5s ease;
            }
            /*redondea los botones*/
            #redond{
                border-radius: 100%;
            }
            #redondb{
                border-radius: 25px;
                height:40px;
            }
            #redondbc{
                border-radius: 100px;
            }
            /*Define el estilos de los titulos y subtitilos de la parte superios*/
            #titulo{
                font-size: 30px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #000000;
                text-align: center;
                position: absolute;
            }
            #subtitulo{
                font-size: 22px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #000000;
                text-align:center;
                position: relative;
                top: 15px;
            }
            #sesion{
                font-size: 20px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #000000;
                float: right;
                position: relative;
                top: 15px;
            }
            #userid{
                font-size: 20px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #0ebd42;
                float: right;
                position: relative;
                top: 15px;
            }
            #dia{
                font-size: 15px;
                font-family:Arial, Helvetica, sans-serif;
                color: #000000;
                text-indent: 150px;
                position: relative;
                top: 15px;
            }
            #notifDiv{
                z-index: 10000;
                display: none;
                background-color: rgb(29, 165, 63);
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
            #title{
                font-size: 30px;
                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif ;
                text-indent: 40px;
                color: #000000;
                text-align: center;
            }
            #menu{
                background: #1e106d;
                border-radius: 10px;
                transition: all 0.5s ease;
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
            <a href="#">
                <i class='bx bxs-user-pin'></i> 
                <span class="links_namealt">{{ 'Usuario: '.$LoggedUserInfo['usuario'] }}</span>
            </a>
            <span class="tooltip">{{ 'Usuario: '.$LoggedUserInfo['usuario'] }}</span>
            </li>
        </ul>
        <hr color="white">
        <ul class="nav_list">
            <li>
                <a href="dashboardafina">
                    <i class='bx bxs-wallet'></i>
                  <span class="links_name">Inicio</span>
                </a>
                <span class="tooltip">Inicio</span>
            </li>
            <hr color="white">
            <li>
                <a href="logout">
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
        {{-- Fin Barra de navegacion lateral principio --}}
        {{-- Inicio de la fecha --}}        
        <div class="container w-75 mt-5 roundedshadow p-3 mb-5 bg-body rounded font-weight-ligth col-xs-12 col-sm-6 col-md-8" >
            <div>
                <label id="userid">{{ $LoggedUserInfo['usuario']}}</label>
                <label id="sesion">Sesión de Usuario Financiero</label>
                
            </div>
            <div> 
                <img src="img/Logo_IMT.png" alt="65" width="100"><label id="titulo">Instituto Mexicano del Transporte</label> 
                <label id="subtitulo"> Sistema Informático de Administración de Proyectos </label>
                <label id="dia"><script type="text/javascript">
                var d = new Date();
                var mm=new Date();
                var m2 = mm.getMonth() + 1;
                var mesok = (m2 < 10) ? '0' + m2 : m2;
                var mesok=new Array(12);
                mesok[0]="Enero";
                mesok[1]="Febrero";
                mesok[2]="Marzo";
                mesok[3]="Abril";
                mesok[4]="Mayo";
                mesok[5]="Junio";
                mesok[6]="Julio";
                mesok[7]="Agosto";
                mesok[8]="Septiembre";
                mesok[9]="Octubre";
                mesok[10]="Noviembre";
                mesok[11]="Diciembre";
                document.write(d.getDate(),' '+mesok[mm.getMonth()],' '+d.getFullYear());
                </script></label>
            </div>
            {{-- Fin de fecha --}}
                @yield('contenido')
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
</html>