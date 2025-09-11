
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
        <link rel="stylesheet" href="{{ asset('css/SIAP.css') }}"> {{--ENCABEZADO--}}
        <link rel="stylesheet" href="{{ asset('css/mlat.css') }}"> {{--MENÚ LATERAL--}}
        <style>
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

    <header>
        <div class="container w-75 mt-5 roundedshadow p-3 mb-5 bg-body rounded font-weight-ligth col-xs-12 col-sm-6 col-md-8">


            <div class="user-info">
                <label id="custom-userid">{{ $LoggedUserInfo['usuario']}}</label>
                @if ($LoggedUserInfo['acceso'] == 2)
                    <label id="custom-sesion">Sesión de Ejecutivo</label>
                @elseif ($LoggedUserInfo['acceso'] == 3)
                    <label id="custom-sesion">Sesión de Usuario</label>
                @endif
            </div>

            <div>
                <img src="img/Logo_IMT.png" alt="65" width="100">
                <label id="custom-titulo">Instituto Mexicano del Transporte</label>
                <label id="custom-subtitulo">Sistema Informático de Administración de Proyectos</label>
                <label id="custom-dia">
                    <script type="text/javascript">
                        var d = new Date();
                        var mm = new Date();
                        var m2 = mm.getMonth() + 1;
                        var mesok = (m2 < 10) ? '0' + m2 : m2;
                        var mesok = new Array(12);
                        mesok[0] = "Enero";
                        mesok[1] = "Febrero";
                        mesok[2] = "Marzo";
                        mesok[3] = "Abril";
                        mesok[4] = "Mayo";
                        mesok[5] = "Junio";
                        mesok[6] = "Julio";
                        mesok[7] = "Agosto";
                        mesok[8] = "Septiembre";
                        mesok[9] = "Octubre";
                        mesok[10] = "Noviembre";
                        mesok[11] = "Diciembre";
                        document.write(d.getDate(), ' ' + mesok[mm.getMonth()], ' ' + d.getFullYear());
                    </script>
                </label>
            </div>
        </div>
    </header>

    {{-- Barra de navegacion lateral principio --}}
    <body>
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
                    <span class="links_name">{{ 'Usuario: '.$LoggedUserInfo['usuario'] }}</span>
                </a>
                <span class="tooltip">{{ 'Usuario: '.$LoggedUserInfo['usuario'] }}</span>
                </li>
            </ul>
            <hr color="white">

            <ul class="nav_list">
                <li class="{{ request()->is('iniciousuario') ? 'active-section' : '' }}">
                    <a href="iniciousuario">
                        <i class='bx bx-home'></i>
                      <span class="links_name">Inicio</span>
                    </a>
                    <span class="tooltip">Inicio</span>
                </li>

                @if ($LoggedUserInfo['acceso'] == 2)
                <li class="img-hover-effect i {{ request()->is('dashboardresp') ? 'active-section' : '' }}">
                    <a href="dashboardresp">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/project.png') }}" alt="Proyectos" style="width: 24px; height: 24px;">
                            <img class= "hover-image" src="{{ asset('Icons/project-hover.png') }}" alt="Proyectos" style="width: 24px; height: 24px;">
                        </i>
                        <span class="links_name">SIAPIMT</span>
                    </a>
                    <span class="tooltip">SIAPIMT</span>
                </li>
                @elseif ($LoggedUserInfo['acceso'] == 3)
                    <li class="img-hover-effect i {{ request()->is('dashboardauser') ? 'active-section' : '' }}">
                        <a href="dashboardauser">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/project.png') }}" alt="Proyectos" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/project-hover.png') }}" alt="Proyectos" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">SIAPIMT</span>
                        </a>
                        <span class="tooltip">SIAPIMT</span>
                    </li>
                @endif

                <li class="img-hover-effect i {{ request()->is('serciciosTecnologicos') ? 'active-section' : '' }}">
                    <a href="serciciosTecnologicos">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/customer-service.png') }}" alt="Servicios tecnológicos" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/customer-service-hover.png') }}" alt="Servicios tecnológicos" style="width: 24px; height: 24px;">
                        </i>
                        <span class="links_name">Servicios tecnológicos</span>
                    </a>
                    <span class="tooltip">Servicios tecnológicos</span>
                </li>

                <li class="img-hover-effect i {{ request()->is('reuniones') ? 'active-section' : '' }}">
                    <a href="reuniones">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/meeting-room.png') }}" alt="Reuniones" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/meeting-room-hover.png') }}" alt="Reuniones" style="width: 24px; height: 24px;">
                        </i>
                        <span class="links_name">Reuniones</span>
                    </a>
                    <span class="tooltip">Reuniones</span>
                </li>

                <li class="img-hover-effect i {{ request()->is('comites') ? 'active-section' : '' }}">
                    <a href="comites">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/meeting.png') }}" alt="Comités" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/meeting-hover.png') }}" alt="Comités" style="width: 24px; height: 24px;">
                        </i>
                    <span class="links_name">Comités</span>
                    </a>
                    <span class="tooltip">Comités</span>
                </li>

                <li class="img-hover-effect i {{ request()->is('solicitudes') ? 'active-section' : '' }}">
                    <a href="solicitudes">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/paper-plane.png') }}" alt="Solicitudes" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/paper-plane-hover.png') }}" alt="Solicitudes" style="width: 24px; height: 24px;">
                        </i>
                    <span class="links_name">Solicitudes</span>
                    </a>
                    <span class="tooltip">Solicitudes</span>
                </li>

                {{--Drop down menu--}}
                <li class="dropdown-btn img-hover-effect i {{ request()->is('revistas','memorias','boletines','ponenciasconferencias','documentostecnicos','docencia','libros') ? 'active-section' : '' }}">
                    <a>
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/book.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/book-hover.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                        </i>
                    <span class="links_name">Difusión</span>
                    </a>
                    <span class="tooltip">Difusión</span>
                </li>
                <div class="dropdown-container">
                    <li class="img-hover-effect i {{ request()->is('revistas') ? 'active-section' : '' }}">
                        <a href="revistas">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/magazine.png') }}" alt="Revistas" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/magazine-hover.png') }}" alt="Revistas" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">Revistas</span>
                        </a>
                        <span class="tooltip">Revistas</span>
                    </li>
                    <li class="img-hover-effect i {{ request()->is('memorias') ? 'active-section' : '' }}">
                        <a href="memorias">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/newspaper.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/newspaper-hover.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">Memorias</span>
                        </a>
                        <span class="tooltip">Memorias</span>
                    </li>
                    <li class="img-hover-effect i {{ request()->is('boletines') ? 'active-section' : '' }}">
                        <a href="boletines">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/blog.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/blog-hover.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">Boletín IMT</span>
                        </a>
                        <span class="tooltip">Boletín IMT</span>
                    </li>
                    <li class="img-hover-effect i {{ request()->is('documentostecnicos') ? 'active-section' : '' }}">
                        <a href="documentosT">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/manual-book.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/manual-book-hover.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">Documentos Técnicos</span>
                        </a>
                        <span class="tooltip">Documentos Técnicos</span>
                    </li>
                    <li class="img-hover-effect i {{ request()->is('ponenciasconferencias') ? 'active-section' : '' }}">
                        <a href="ponenciasconferencias">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/conference.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/conference-hover.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">Ponencias y Conferencias</span>
                        </a>
                        <span class="tooltip">Ponencias y Conferencias</span>
                    </li>
                    <li class="img-hover-effect i {{ request()->is('docencia') ? 'active-section' : '' }}">
                        <a href="docencia">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/certificate.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/certificate-hover.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">Cursos Impartidos</span>
                        </a>
                        <span class="tooltip">Cursos Impartidos</span>
                    </li>
                    <li class="img-hover-effect i {{ request()->is('libros') ? 'active-section' : '' }}">
                        <a href="libros">
                            <i>
                                <img class="normal-image" src="{{ asset('Icons/books.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                                <img class="hover-image" src="{{ asset('Icons/books-hover.png') }}" alt="Memorias" style="width: 24px; height: 24px;">
                            </i>
                            <span class="links_name">Libros</span>
                        </a>
                        <span class="tooltip">Libros</span>
                    </li>
                </div>

                {{--Fin del menu drop--}}



                <li class="img-hover-effect i {{ request()->is('cursosRecibidos') ? 'active-section' : '' }}">
                    <a href="cursosRecibidos">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/teacher.png') }}" alt="Cursos" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/teacher-hover.png') }}" alt="Cursos" style="width: 24px; height: 24px;">
                        </i>
                    <span class="links_name">Cursos</span>
                    </a>
                    <span class="tooltip">Cursos</span>
                </li>

                <li class="img-hover-effect i {{ request()->is('postgrados') ? 'active-section' : '' }}">
                    <a href="postgrados">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/cap.png') }}" alt="Estudios de postgrado" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/cap-hover.png') }}" alt="Estudios de postgrado" style="width: 24px; height: 24px;">

                        </i>
                    <span class="links_name">Estudios de postgrado</span>
                    </a>
                    <span class="tooltip">Estudios de postgrado</span>
                </li>

                <li class="img-hover-effect i {{ request()->is('tesis') ? 'active-section' : '' }}">
                    <a href="tesis">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/open-book.png') }}" alt="Tesis dirigidas" style="width: 24px; height: 24px;">
                            <img class="hover-image" src="{{ asset('Icons/open-book-hover.png') }}" alt="Tesis dirigidas" style="width: 24px; height: 24px;">
                        </i>
                    <span class="links_name">Tesis dirigidas</span>
                    </a>
                    <span class="tooltip">Tesis dirigidas</span>
                </li>

                <li class="img-hover-effect i {{ request()->is('otrasactividades') ? 'active-section' : '' }}">
                    <a href="otrasactividades">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/more-information.png') }}" alt="Otras actividades" style="width: 20px; height: 20px;">
                            <img class="hover-image" src="{{ asset('Icons/more-information-hover.png') }}" alt="Otras actividades" style="width: 20px; height: 20px;">
                        </i>
                    <span class="links_name">Otras actividades</span>
                    </a>
                    <span class="tooltip">Otras actividades</span>
                </li>

                <li class="img-hover-effect i {{ request()->is('menureportes') ? 'active-section' : '' }}">
                    <a href="menureportes">
                        <i>
                            <img class="normal-image" src="{{ asset('Icons/pdf.png') }}" alt="Reportes" style="width: 20px; height: 20px;">
                            <img class="hover-image" src="{{ asset('Icons/pdf-hover.png') }}" alt="Reportes" style="width: 20px; height: 20px;">
                        </i>
                        <span class="links_name">Reportes</span>
                    </a>
                    <span class="tooltip">Reportes</span>
                </li>

                <hr color="white">
                <li class="img-hover-effect i">
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

                var dropdown = document.getElementsByClassName("dropdown-btn");
                var i;

                for (i = 0; i < dropdown.length; i++) {
                dropdown[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var dropdownContent = this.nextElementSibling;
                    if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                    } else {
                    dropdownContent.style.display = "block";
                    }
                });
                }

                // JavaScript para mostrar/ocultar el formulario al hacer clic en el botón
                const mostrarFormularioButton = document.getElementById("mostrarFormulario");
                const myForm = document.getElementById("myForm");

                mostrarFormularioButton.addEventListener("click", function () {
                    if (myForm.style.display === "none" || myForm.style.display === "") {
                        myForm.style.display = "block";
                    } else {
                        myForm.style.display = "none";
                    }
                });

                </script>

    {{-- Fin Barra de navegacion lateral principio --}}

        {{--Cuerpo--}}
        <div class="container w-75 mt-5 roundedshadow p-3 mb-5 bg-body rounded font-weight-ligth col-xs-12 col-sm-6 col-md-8" >
            @yield('contenido')
            
                <div style="height:50px"></div>
        </div>
        {{--Fin del Cuerpo--}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
