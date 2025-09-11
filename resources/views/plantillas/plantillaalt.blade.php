<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="icon" href="../img/Logo_IMT_mini.png" type="image/png" />
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
            /*redondea los botones*/
            #redond{
                border-radius: 100%;
            }
            #redondb{
                border-radius: 25px;
                height:45px;
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
            table{
                counter-reset: rowNumber;
            }
            table tr > td:first-child{
                counter-increment: rowNumber;
            }
            table tr td:first-child::before{
                content: counter(rowNumber);
                min-width: 1em;
                margin-right: 0.5em;
            }
            h4{ 
                font-size: 25px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #000000;
                text-align: center;
            }
            h3{ 
                font-size: 23px;
                font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                text-indent: 40px;
                color: #000000;
                text-align: center;
            }
            footer {
                color: #5C5C69;
                font-size: .8em;
                text-align: center;
                padding: 10px 0;
                background-color: #FFFFFF;
                border-top: 1px solid #ddd;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
                z-index: 1;
                margin-top: 24px;
            }
            </style>
    </head>
    <body>
      {{-- Barra de navegacion lateral principio --}}
        {{-- <div class="sidebar">
            <div class="logo_content">
                <div class="logo">
                    <img src="img/Logo_blanco.png" alt="48" width="48" id="blanco">
                    <div class="logo_name"></div>
                </div>
                <i class="bx bx-menu" id="btn"></i>
            </div>
            <ul class="nav_list">
                <li>
                    <a href="dashboardresp">
                      <i class='bx bx-home'></i>
                      <span class="links_name">Inicio</span>
                    </a>
                    <span class="tooltip">Inicio</span>
                </li>
                <li>
                    <a href="infoproyect">
                        <i class='bx bx-info-circle'></i>
                      <span class="links_name">Informacion General</span>
                    </a>
                    <span class="tooltip">Informacion</span>
                </li>
                <li>
                    <a href="tareaproyect">
                        <i class='bx bxs-id-card'></i>
                        <span class="links_name">Tareas del proyecto</span>
                    </a>
                    <span class="tooltip">Tareas</span>
                </li>
                <li>
                    <a href="recursosproyect">
                        <i class='bx bx-user-pin'></i>
                        <span class="links_name">Recursos del proyecto</span>
                    </a>
                    <span class="tooltip">Recursos</span>
                </li>
                <li>
                    <a href="personal">
                        <i class='bx bxs-user-detail'></i>
                        <span class="links_name">Personal del proyecto</span>
                    </a>
                    <span class="tooltip">Personal</span>
                </li>
                <li>
                    <a href="/">
                        <i class='bx bx-log-out-circle'></i>
                        <span class="links_name">Salir</span>
                    </a>
                    <span class="tooltip">Salir</span>
                </li>
            </ul>
        </div>     --}}
              
                <script>
                let btn = document.querySelector("#btn");
                let sidebar = document.querySelector(".sidebar");
                    btn.onclick = function(){
                        sidebar.classList.toggle("active");
                    }
                </script>
        <div class="container w-75 bg-white mt-5 roundedshadow p-3 mb-5 bg-body rounded font-weight-ligth col-xs-12 col-sm-6 col-md-8" >
            <div>
                <img src="../img/Logo_IMT.png" alt="65" width="100"><label id="titulo">Instituto Mexicano del Transporte</label>
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
                @yield('contenido')
                
                <div style="height:50px"></div>

        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
        @stack('scripts')
        <footer>
            2025 © Desarrollado por la División de Telemática
        </footer>
    </body>
</html>