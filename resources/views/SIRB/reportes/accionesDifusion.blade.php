<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Acciones de difusión</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            header {
                display: flex; /* Utiliza flexbox */
                justify-content: start; /* Alinea los elementos a la izquierda */
                align-items: center; /* Centra los elementos verticalmente */
                margin-bottom: 1.5rem;
            }
            header img {
                display: block; /* Hace que la imagen se muestre como bloque */
                float: left;
                width: 12.5rem; /* Ajusta el ancho de la imagen según tus necesidades */
                height: 10rem;
                margin-top: -1rem; /* Ajusta la posición vertical de la imagen */
                margin-right: 1rem;
            }
            header h1 {
                font-size: 1.5rem;
            }
            header h2, header h3, header h4 {
                font-size: 1rem;
            }
            table {
                width: 100%;
                margin: auto;
                font-size: .5rem;
                border-collapse: collapse;
            }
            table th {
                background-color: #ffffff;
                
            }
            table td {
                background-color: #ffffff;
            }
            table th, table td {
                padding: .5rem;
                text-align: center;
                vertical-align: middle;
                align-content: center;
                align-items: center;
                border: 1px solid;
            }

            .small-text {
                font-size: 0.7em;
            }
        </style>
	</head>

	<body>
		<header>
            <img src="{{ public_path('img/Logo_IMT.png') }}" alt="Logo IMT">
            <h1 style="margin-top:0; margin-bottom:0;" >Instituto Mexicano del Transporte</h1>
            <h2 style="margin-top:10; margin-bottom:0;" ><strong>{{ $userData->Area }}</strong></h2>
            <h4 style="margin-top:10; margin-bottom:0;" ><strong>Sistema de Gestión de la Calidad</strong></h4>
            <h2 style="margin-top:10; margin-bottom:0;" ><strong>Reporte de Actividades de Difusión {{ $periodoConsultado }}</strong></h3>
        </header>
        <div>
            <table>
                <caption></caption>
                <thead style="font-size: 1em">
                    <tr>
                        <th scope="col" rowspan="3">Nombre del investigador</th>
                        <th scope="col" rowspan="2" colspan="2">Artículos publicados en revistas o memorias nacionales</th>
                        <th scope="col" rowspan="2" colspan="2">Artículos publicados en revistas o memorias internacionales</th>
                        <th scope="col" rowspan="3">Boletines del IMT</th>
                        <th scope="col" rowspan="1" colspan="3">Conferencias / ponencias en seminarios y congresos</th>
                        <th scope="col" rowspan="3">Publicaciones Técnicas del IMT</th>
                        <th scope="col" rowspan="2" colspan="2">Total</th>
                    </tr>
                    <tr>
                        <th scope="col" rowspan="2">Por invitación</th>
                        <th scope="col" colspan="2">Participación libre</th>
                    </tr>
                    <tr>
                        <th scope="col">Con arbitraje / Indizadas</th>
                        <th scope="col">Sin arbitraje</th>
                        <th scope="col">Con arbitraje / Indizadas</th>
                        <th scope="col">Sin arbitraje</th>
                        <th scope="col">Con arbitraje</th>
                        <th scope="col">Sin arbitraje</th>
                        <th scope="col">Con arbitraje (*)</th>
                        <th scope="col">Sin arbitraje</th>
                    </tr>
                </thead>
                <tbody>
                    {{$sum1 = 0}}
                    {{$sum2 = 0}}
                    {{$sum3 = 0}}
                    {{$sum4 = 0}}
                    {{$sum5 = 0}}
                    {{$sum6 = 0}}
                    {{$sum7 = 0}}
                    {{$sum8 = 0}}
                    {{$sum9 = 0}}
                    {{$sum10 = 0}}
                    {{$sum11 = 0}}
                    {{-- @foreach ($usuarios as $user)
                        <tr>
                            <td>{{$user->Nombre.' '.$user->Apellido_Paterno.' '.$user->Apellido_Materno}}</td>
                            <td>{{$user->crevistaind}}</td>
                            <td>{{$user->crevistanoind}}</td>
                            <td>{{$user->crevistaindint}}</td>
                            <td>{{$user->crevistanoindint}}</td>
                            <td>{{$user->boletines}}</td>
                            <td>{{$user->poninv}}</td>
                            <td>{{$user->poncon}}</td>
                            <td>{{$user->ponsin}}</td>
                            <td>{{$user->publicacion}}</td>
                            <td>
                                {{
                                    $totalcon = $user->crevistaind+$user->crevistaindint+$user->poncon+$user->poninv+$user->boletines
                                }}
                            </td>
                            <td>
                                {{
                                    $totalsin = $user->crevistanoind+$user->crevistanoindint+$user->ponsin+$user->publicacion
                                }}
                            </td>
                        </tr>
                        {{$sum1 = $user->crevistaind+$sum1}}
                        {{$sum2 = $user->crevistanoind+$sum2}}
                        {{$sum3 = $user->crevistaindint+$sum3}}
                        {{$sum4 = $user->crevistanoindint+$sum4}}
                        {{$sum5 = $user->boletines+$sum5}}
                        {{$sum6 = $user->poninv+$sum6}}
                        {{$sum7 = $user->poncon+$sum7}}
                        {{$sum8 = $user->ponsin+$sum8}}
                        {{$sum9 = $user->publicacion+$sum9}}
                        {{$sum10 = $totalcon+$sum10}}
                        {{$sum11 = $totalsin+$sum11}}
                    @endforeach --}}
                    @foreach ($revistas as $revista)
                        <tr>
                            <td>
                                @php
                                    $participantes = explode(',', $revista->participantes);
                                @endphp
                                {{ $revista->encargado }}
                                @if (!empty($participantes[0]))
                                    ,
                                    @foreach ($participantes as $participanteId)
                                        @php
                                            $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                        @endphp
                                        @if ($usuario)
                                            {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                            @if (!$loop->last), @endif
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            @if ($revista->tipo_revista == 'Nacional con arbitraje')
                                {{$sum1++}}
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalcon = 1}}</td>
                                <td></td>
                                {{$sum10 = $totalcon+$sum10}}
                            @endif
                            @if ($revista->tipo_revista == 'Nacional sin arbitraje')
                                {{$sum2++}}
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalsin = 1}}</td>
                                {{$sum11 = $totalsin+$sum11}}
                            @endif
                            @if ($revista->tipo_revista == 'Internacional con arbitraje')
                                {{$sum3++}}
                                <td></td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalcon = 1}}</td>
                                <td></td>
                                {{$sum10 = $totalcon+$sum10}}
                            @endif
                            @if ($revista->tipo_revista == 'Internacional sin arbitraje')
                                {{$sum4++}}
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalsin = 1}}</td>
                                {{$sum11 = $totalsin+$sum11}}
                            @endif
                        </tr>
                    @endforeach
                    @foreach ($memorias as $memoria)
                        <tr>
                            <td>
                                @php
                                    $participantes = explode(',', $memoria->participantes);
                                @endphp
                                {{ $memoria->encargado }}
                                @if (!empty($participantes[0]))
                                    ,
                                    @foreach ($participantes as $participanteId)
                                        @php
                                            $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                        @endphp
                                        @if ($usuario)
                                            {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                            @if (!$loop->last), @endif
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            @if ($memoria->tipo_memoria == 'Nacional con arbitraje')
                                {{$sum1++}}
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalcon = 1}}</td>
                                <td></td>
                                {{$sum10 = $totalcon+$sum10}}
                            @endif
                            @if ($memoria->tipo_memoria == 'Nacional sin arbitraje')
                                {{$sum2++}}
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalsin = 1}}</td>
                                {{$sum11 = $totalsin+$sum11}}
                            @endif
                            @if ($memoria->tipo_memoria == 'Internacional con arbitraje')
                                {{$sum3++}}
                                <td></td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalcon = 1}}</td>
                                <td></td>
                                {{$sum10 = $totalcon+$sum10}}
                            @endif
                            @if ($memoria->tipo_memoria == 'Internacional sin arbitraje')
                                {{$sum4++}}
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalsin = 1}}</td>
                                {{$sum11 = $totalsin+$sum11}}
                            @endif
                        </tr>
                    @endforeach
                    @foreach ($ponenciasconferencias as $conferencia)
                        <tr>
                            <td>@php
                                $participantes = explode(',', $conferencia->participantes);
                            @endphp
                            {{ $conferencia->encargado }}
                            @if (!empty($participantes[0]))
                                ,
                                @foreach ($participantes as $participanteId)
                                    @php
                                        $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                    @endphp
                                    @if ($usuario)
                                        {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                        @if (!$loop->last), @endif
                                    @endif
                                @endforeach
                            @endif
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @if ($conferencia->tipo_participacion == 'Invitación')
                                {{$sum6++}}
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$totalcon = 1}}</td>
                                <td></td>
                                {{$sum10 = $totalcon+$sum10}}
                            @endif
                            @if ($conferencia->tipo_participacion == 'Iniciativa propia con arbitraje')
                                {{$sum7++}}
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td>{{$totalcon = 1}}</td>
                                <td></td>
                                {{$sum10 = $totalcon+$sum10}}
                            @endif
                            @if ($conferencia->tipo_participacion == 'Iniciativa propia sin arbitraje')
                                {{$sum8++}}
                                <td></td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td>{{$totalsin = 1}}</td>
                                {{$sum11 = $totalsin+$sum11}}
                            @endif
                        </tr>
                    @endforeach
                        @php
                            // Convertir el array a una colección y eliminar duplicados
                            $boletinesUnicos = collect($boletines)->unique('ID_BOL_Articulo');
                        @endphp
                    @foreach ($boletinesUnicos as $boletin)
                        @php
                            $boletin->Anio = date('m-Y', strtotime($boletin->Anio));

                            if ($boletin->Jerarquia == 0) {
                                $boletin->Jerarquia = "Autor";
                            } else if ($boletin->Jerarquia != 0) {
                                $boletin->Jerarquia = "Coautor";
                            }
                        @endphp
                        <tr>
                            {{$sum5++}}
                            <td>
                                {{ $nombresParticipantes[$boletin->ID_BOL_Articulo] }}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$totalsin = 1}}</td>
                            {{$sum11 = $totalsin+$sum11}}
                        </tr>
                    @endforeach
                        @php
                            // Convertir el array a una colección y eliminar duplicados
                            $documentosUnicos = collect($documentos)->unique('ID_PUB_Publicacion');
                        @endphp
                    @foreach ($documentosUnicos as $documento)
                        @php
                            $documento->Anio = date('m-Y', strtotime($documento->Anio));
                            if ($documento->Jerarquia == 0) {
                                $documento->Jerarquia = "Autor";
                            } else if ($documento->Jerarquia != 0) {
                                $documento->Jerarquia = "Coautor";
                            }
                        @endphp
                        <tr>
                            {{$sum9++}}
                            <td>
                                {{ $nombresParticipantesII[$documento->ID_PUB_Publicacion] }}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                            <td></td>
                            <td>{{$totalsin = 1}}</td>
                            {{$sum11 = $totalsin+$sum11}}
                        </tr>
                    @endforeach
                        <th scope="col">Totales</th>
                        <th scope="col">{{$sum1}}</th>
                        <th scope="col">{{$sum2}}</th>
                        <th scope="col">{{$sum3}}</th>
                        <th scope="col">{{$sum4}}</th>
                        <th scope="col">{{$sum5}}</th>
                        <th scope="col">{{$sum6}}</th>
                        <th scope="col">{{$sum7}}</th>
                        <th scope="col">{{$sum8}}</th>
                        <th scope="col">{{$sum9}}</th>
                        <th scope="col">{{$sum10}}</th>
                        <th scope="col">{{$sum11}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <label for="" style="font-size: .6em">(*)	En el total “Con arbitraje” se incluyen las Conferencias / ponencias en seminarios y congresos “Por invitación”. </label>
        </div>
        <br>
        <div>
            <table>
                <tr>
                    <th colspan="2">Articulos publicados en revistas</th>
                </tr>
                @if($revistas->isEmpty())
                    <tr>
                        <td colspan="2">No aplica para este periodo</td>
                    </tr>
                @else
                    @foreach($revistas as $revista)
                        <tr>
                            <td>
                                @php
                                    $participantes = explode(',', $revista->participantes);
                                @endphp
                                <strong> {{ $revista->encargado }} </strong>
                                @if (!empty($participantes[0]))
                                    ,
                                    @foreach ($participantes as $participanteId)
                                        @php
                                            $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                        @endphp
                                        @if ($usuario)
                                            {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                            @if (!$loop->last), @endif
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>Artículo publicado en revista {{ $revista->tipo_revista }}: {{$revista->titulo}}. NO.{{$revista->numero_revista}}. {{$revista->ciudad_pais}}. {{$revista->fecha}}.</td>
                        </tr>
                    @endforeach
                @endif
            </table>
            <br>
    
            <table>
                <tr>
                    <th colspan="2">Articulos publicados en memorias</th>
                </tr>
                @if($memorias->isEmpty())
                    <tr>
                        <td colspan="2">No aplica para este periodo</td>
                    </tr>
                @else
                    @foreach($memorias as $memoria)
                        <tr>
                            <td>
                            @php
                                $participantes = explode(',', $memoria->participantes);
                            @endphp
                            <strong>{{ $memoria->encargado }}</strong>
                            @if (!empty($participantes[0]))
                                ,
                                @foreach ($participantes as $participanteId)
                                    @php
                                        $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                    @endphp
                                    @if ($usuario)
                                        {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                        @if (!$loop->last), @endif
                                    @endif
                                @endforeach
                            @endif</td>
                            <td>Artículo publicado en memoria {{ $memoria->tipo_memoria }}: {{ $memoria->titulo }}. {{ $memoria->tipo_memoria }}. {{ $memoria->nombre_seminario }}. {{ $memoria->ciudad_pais }}. {{ $memoria->fecha }}.</td>
                        </tr>
                    @endforeach
                @endif
            </table>
            <br>
    
            <table>
                <tr>
                    <th colspan="2">Conferencias en seminarios y congresos</th>
                </tr>
                @if($ponenciasconferencias->isEmpty())
                    <tr>
                        <td colspan="2">No aplica para este periodo</td>
                    </tr>
                @else
                    @foreach($ponenciasconferencias as $conferencia)
                    <tr>
                        <td>@php
                            $participantes = explode(',', $conferencia->participantes);
                        @endphp
                         <strong>{{ $conferencia->encargado }}</strong>
                        @if (!empty($participantes[0]))
                            ,
                            @foreach ($participantes as $participanteId)
                                @php
                                    $usuario = DB::table('usuarios')->where('id', $participanteId)->first();
                                @endphp
                                @if ($usuario)
                                    {{ $usuario->Nombre }} {{ $usuario->Apellido_Paterno }} {{ $usuario->Apellido_Materno }}
                                    @if (!$loop->last), @endif
                                @endif
                            @endforeach
                        @endif
                        </td>
                        <td>{{ $conferencia->tipo_PC }} por {{ $conferencia->tipo_participacion }}: {{$conferencia->nombre_evento}}. {{$conferencia->lugar_evento}}. {{$conferencia->fecha_fin}}.</td>
                    </tr>
                    @endforeach
                @endif
            </table>
            <br>
    
            <table>
                <tr>
                    <th colspan="2">Boletines publicados</th>
                </tr>
                @php
                    // Convertir el array a una colección y eliminar duplicados
                    $boletinesUnicos = collect($boletines)->unique('ID_BOL_Articulo');
                @endphp
                    @if($boletinesUnicos->isEmpty())
                        <tr>
                            <td colspan="2">No aplica para este periodo</td>
                        </tr>
                    @else
                        @foreach ($boletinesUnicos as $boletin)
                            @php
                                $boletin->Anio = date('m-Y', strtotime($boletin->Anio));
    
                                if ($boletin->Jerarquia == 0) {
                                    $boletin->Jerarquia = "Autor";
                                } else if ($boletin->Jerarquia != 0) {
                                    $boletin->Jerarquia = "Coautor";
                                }
                            @endphp
                            <tr>
                                <td>
                                    {{ $nombresParticipantes[$boletin->ID_BOL_Articulo] }}
                                </td>
                                <td>
                                    Boletín publicado {{ $boletin->titulo }}: {{ $boletin->Anio }}. Artículo NO.{{ $boletin->NoArticulo }}. Boletín NO. {{ $boletin->NoBoletin }}.
                                </td>
                            </tr>
                        @endforeach
                    @endif
            </table>
    
            <br>
            <table>
                <tr>
                    <th colspan="2">Documentos técnicos publicados</th>
                </tr>
                @php
                    // Convertir el array a una colección y eliminar duplicados
                    $documentosUnicos = collect($documentos)->unique('ID_PUB_Publicacion');
                @endphp
    
                    @if($documentosUnicos->isEmpty())
                    <tr>
                        <td colspan="2">No aplica para este periodo</td>
                    </tr>
                    @else
                        @foreach ($documentosUnicos as $documento)
                            @php
                                $documento->Anio = date('m-Y', strtotime($documento->Anio));
    
                                if ($documento->Jerarquia == 0) {
                                    $documento->Jerarquia = "Autor";
                                } else if ($documento->Jerarquia != 0) {
                                    $documento->Jerarquia = "Coautor";
                                }
                            @endphp
                            <tr>
                                <td>
                                    {{ $nombresParticipantesII[$documento->ID_PUB_Publicacion] }}
                                </td>
                                <td>
                                    {{ $documento->Nombre }} con fecha de publicación: {{ $documento->Anio }}. {{ $documento->Titulo }}. Documento NO.{{ $documento->NoPublicacion }}.
                                </td>
                            </tr>
                        @endforeach
                    @endif
            </table>
        </div>
        <div style="text-align: center;" class="small-text">
            <p>Aprobó</p><br><br>
            @if ($fcoordinador)
                <p>_____________________________</p>
                <p>{{ $fcoordinador->NombreCoordinador }} {{ $fcoordinador->ApellidoPaternoCoordinador }} {{ $fcoordinador->ApellidoMaternoCoordinador }} Coordinador de</p>
                <p> {{ $fcoordinador->Area }}</p>
            @else
                <p>_____________________________</p>
                <p>{{ $fcoordinador->NombreCoordinador }} {{ $fcoordinador->ApellidoPaternoCoordinador }} {{ $fcoordinador->ApellidoMaternoCoordinador }} Coordinador de</p>
                <p> {{ $fcoordinador->Area }}</p>
            @endif
        </div>
        <br>
        <span style="float: left; font-family: 'Times New Roman', Times, serif; color: gray; font-size: 11px;">Fecha de elaboración: <?php echo date('Y-m-d'); ?></span>
    </body>
</html>
