<!DOCTYPE html>
<html>
<head>
    <title>Protocolo</title>
    <style>
        /* Estilo de la portada INICIO */
            .portada {
                text-align: center;
                padding-top: 100px; /* Ajusta para centrar el contenido */
            }

            .portada h1 {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                color: #333;
            }

            .portada p {
                font-size: 24px;
                color: #666;
            }

            .portada img {
                width: 300px; /* Ajusta el tamaño de la imagen */
                height: auto;
                margin-top: 30px;
            }
        /* Estilo de la portada FIN */
        
        /* Estilo para el contenido INICIO */
            .contenido {
                line-height: 1;
            }

            .contenido h2 {
                font-size: 16pt;
                color: #000000;
                margin-bottom: 10px;
                font-weight: bold;
            }

            .contenido h3 {
                font-size: 14pt;
                color: #000000;
                margin-bottom: 10px;
                font-weight: bold;
            }

            .contenido p {
                font-size: 12pt;
                color: #000000;
                margin-bottom: 0.5px;
                text-align: justify;
                white-space: normal;
                word-wrap: break-word;
            }

            .contenido img {
                max-width: 100%;
                height: auto;
                display: block;
                margin: 0 auto;
                /* border: #000 1px solid; */
            }

            .footer {
                position: fixed;
                bottom: -4mm;
                left: 0;
                width: 100%;
                font-size: 10pt;
                padding: 5px;
            }

            .header {
                position: fixed;
                width: 100%;
                top: -9mm;
                text-align: left;
                color: #000;
                font-size: 9px;
            }

            /* Ajuste para las secciones */
            .section {
                page-break-before: always;
            }

            .section h2 {
                font-size: 16pt;
                color: #000000;
                margin-bottom: 10px;
                font-weight: bold;
            }

            .section p {
                font-size: 12pt;
                color: #000000;
                margin-bottom: 0.5px;
                text-align: justify;
            }
            /* Centrar imágenes dentro de las secciones (contenido generado por Quill) */
            .section img {
                max-width: 100%;
                height: auto;
                display: block;
                margin: 0 auto 10px auto;
            }

            .cont {
                display: flex;
                text-align: center; /* Opcional: centra los divs dentro del contenedor */
            }

            .div1, .div2, .div3, .div4, .div5{
                display: inline-block;
                border: 1px solid #000;
                padding: 1px;
            }
        /* Estilo para el contenido FIN */
        /* */
        table {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            border-collapse: collapse;
            margin: 20px 0;
            page-break-inside: avoid;
        }
        thead {
            background-color: #003366;
            color: black;
        }
        body {
            margin: 0;
            padding: 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: center;
            word-wrap: break-word;
            white-space: normal;
        }
        th {
            font-weight: bold;
        }
        /* */
        
    </style>
</head>
    <!-- Portada -->
    <body>
        <style>
            label{
                font-size: 20pt;
                font-weight: bold;
            }

            .rnadl{
                font-size: 16pt;
                font-weight: bold;
            }

            .rnadl1{
                font-size: 20pt;
                font-weight: bold;
            }

            .contport {
                display: flex;
                justify-content: space-between;
                height: 50px;
            }

            .div1port {
                display: inline-block;
                width: 15%; /* Ajusta el ancho según necesites */
                height: 100%;
            }

            .div2port {
                display: inline-block;
                width: 70%; /* Ajusta el ancho según necesites */
                height: 100%;
            }

            .div1port2, .div2port2 {
                display: inline-block;
                width: 40%; /* Ajusta el ancho según necesites */
                height: 100%;
            }

        </style>
        <div class="contenido" style="text-align: center">
            <br>
            <img src="{{ public_path('img/header_imt.png') }}" alt="Logo IMT"  width="600" height="65">

            <div style="padding-top: 2in">
            </div>

            <label>{{$areas->nombre_area}}</label>

            <div style="padding-top: 1in">
            </div>

            @if ($proyt->clavet == 'I')
                <label>Protocolo de investigación</label>
            @else
                <label>Propuesta técnico-económica</label>
            @endif

            <div style="padding-top: 1in">
            </div>

            <div class="contport">
                <div class="div1port"><p class="rnadl1" style="text-align: justify;">{{$clave}}</p></div>
                <div class="div2port"><p class="rnadl1" style="text-align: justify;">{{$proyt->nomproy}}</p></div>
            </div>

            <div style="padding-top: 3in">
            </div>

            <div class="footerport">
                <p style="text-align: right">
                    <?php
                        setlocale(LC_TIME, 'es_MX.UTF-8');
                        echo strftime("%d de %m de %Y");
                    ?>
                </p>
            </div>
        </div>

        <div style="page-break-after: always;">
        </div>

        <div class="contenido" style="text-align: center">
            <br>
            <img src="{{asset('/img/header_imt.png')}}" alt="Logo IMT"  width="600" height="65">

            <div style="padding-top: 2in">
            </div>

            <label>INSTITUTO MEXICANO DEL TRANSPORTE</label>
            <p style="text-align: center">
                Km 12+000, carretera estatal 431 “El Colorado - Galindo <br>
                Parque Tecnológico San Fandila <br>
                Mpio. Pedro Escobedo, Querétaro, México <br>
                CP 76703 <br>
                Teléfonos: +52(442) 2 16 97 77
            </p>

            <div style="padding-top: .5in">
            </div>
                
            <!--</div>
                <p class="rnadl" style="text-align: center">Autorizó:</p>
                <p style="text-align: center"></p>
                <hr style="width: 500px; color:#000">
                <p style="text-align: center; font-weight:bold">
                    {{--{{$director->Apellido_Paterno.' '.$director->Apellido_Materno.' '.$director->Nombre}} <br>--}}  
                    Director General
                </p>
            <div>-->
            
            <div style="padding-top: .2in">
            </div>

            </div>
                <p class="rnadl" style="text-align: center">Responsable del proyecto:</p>
                <p style="text-align: center"></p>
                <hr style="width: 500px; color:#000">
                <p style="text-align: center; font-weight:bold">
                    {{$users->Apellido_Paterno.' '.$users->Apellido_Materno.' '.$users->Nombre}}
                </p>
            <div>
            
            <div style="padding-top: .2in">
            </div>

            </div>
                <p class="rnadl" style="text-align: center">Aprobó</p>
                <p style="text-align: center"></p>
                <hr style="width: 500px; color:#000">
                <p style="text-align: center; font-weight:bold">
                    {{$respon->Apellido_Paterno.' '.$respon->Apellido_Materno.' '.$respon->Nombre}} <br>
                    {{$areas->nombre_area}}
                </p>
            <div>

            
            {{-- <div class="contport">
                <div class="div1port2">
                    <p class="rnadl" style="text-align: center">Responsable del proyecto:</p>
                    <p>{{$obs->fobsresponsble}}</p>
                    <hr>
                    <p style="text-align: center">
                        {{$users->Apellido_Paterno.' '.$users->Apellido_Materno.' '.$users->Nombre}}
                    </p>
                </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="div2port2">
                    <p class="rnadl" style="text-align: center">Autorizó</p>
                    <p>{{$obs->fobsmando}}</p>
                    <hr>
                    <p style="text-align: center">
                        {{$respon->Apellido_Paterno.' '.$respon->Apellido_Materno.' '.$respon->Nombre}} <br>
                        {{$areas->nombre_area}}
                    </p>
                </div>
            </div> --}}
        </div>
        
        <div style="page-break-after: always;">
        </div>

        <div class="contenido">
            <br>
            <h2 style="text-align: center">ÍNDICE</h2>
            <div style="padding-top: .5in"></div>
            <p>1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JUSTIFICACIÓN DEL PROYECTO</p>
            <p>2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANTECEDENTES</p>
            <p>3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBJETIVOS</p>
            <p>3.1&nbsp;&nbsp;&nbsp;OBJETIVOS ESPECÍFICOS</p>
            <p>4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALCANCES</p>
            <p>5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;METODOLOGÍA</p>
            <p>6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRODUCTOS POR OBTENER</p>
            <p>7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMPROMISOS DEL CLIENTE</p>
            <p>8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BENEFICIOS ESPERADOS</p>
            <p>9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PLAN DE ACTIVIDADES</p>
            <p>10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROPUESTA ECONÓMICA</p>
            <p>11&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANÁLISIS DE RIESGOS</p>
            <p>12&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REFERENCIAS</p>
            @if ($proyt->notasmetodologia != '')
                <p>13&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOTAS</p>
            @endif
        </div>

        <div style="page-break-after: always;">
        </div>

        <div class="header">
            <p class="title">{{$clave}}:&nbsp;{{Str::limit($proyt->nomproy, 120)}}</p>
            <hr>
        </div>
        <div class="footer">
            <div class="cont">
                <div class="div1" style="text-align: left">REV 06, FECHA: 20250130</div>
                {{-- <div class="div2"></div> --}}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="div3" style="height: 15px; width: 50px;"></div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{-- <div class="div4"></div> --}}
                <div class="div5" style="text-align: right">F1 RI-001</div>
            </div>
            
        </div>
        <div class="contenido">
            <h2>1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JUSTIFICACIÓN DEL PROYECTO</h2>
            <p>{!!$proyt->justificacion!!}</p>
            <br>
            <h2>2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANTECEDENTES</h2>
            <p>{!!$proyt->antecedente!!}</p>
            <br>
            <h2>3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBJETIVOS</h2>
            <p>{!!$proyt->objetivo!!}</p>
            <br>
            <h3>3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBJETIVOS ESPECÍFICOS</h3>
            <p>{!!$proyt->objespecifico!!}</p>
            <br>
            <h2>4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALCANCES</h2>
            <p>{!!$proyt->alcance!!}</p>
            <br>
            <h2>5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;METODOLOGÍA</h2>
            <p>{!!$proyt->metodologia!!}</p>
            <br>
            <h2>6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRODUCTOS POR OBTENER</h2>
            <p>{!!$proyt->producto!!}</p>
            <br>
            <h2>7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMPROMISOS DEL CLIENTE</h2>
            <p>{!!$proyt->comcliente!!}</p>
            <br>
            <h2>8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BENEFICIOS ESPERADOS</h2>
            <p>{!!$proyt->beneficios!!}</p>
            <br>
            <h2>9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PLAN DE ACTIVIDADES</h2>
            {!!$protocolocrono!!}
            <br>
            <h2>10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROPUESTA ECONÓMICA</h2>
                <h3> Recursos Financieros </h3>
                @if ($subtotalf != 0)
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Partida</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $e=1 ?>
                            @foreach ($rescf as $r)
                                <tr>
                                    <td scope="row">{{ $e }}</td>
                                    <td>{{ $r->partida }}</td>
                                    <td>{{ $r->concepto }}</td>
                                    <td>${{ $r->cantidad }}</td>
                                </tr>
                                <?php $e++ ?>
                            @endforeach
                                <tr>
                                    <td colspan="3">Subtotal</td>
                                    <td>{{'$'.$subtotalf}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No aplica para este proyecto</p>
                @endif
                
                <h3> Recursos Materiales</h3>
                @if ($subtotalm != 0)
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Partida</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $d=1 ?>
                            @foreach ($rescm as $r)
                                <tr>
                                    <td scope="row">{{ $d }}</td>
                                    <td>{{ $r->partida }}</td>
                                    <td>{{ $r->concepto }}</td>
                                    <td>${{ $r->cantidad }}</td>
                                </tr>
                                <?php $d++ ?>
                            @endforeach
                                <tr>
                                    <td colspan="3">Subtotal</td>
                                    <td>{{'$'.$subtotalm}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No aplica para este proyecto</p>
                @endif

                <h3> Recursos Tecnológicos</h3>
                @if ($subtotalt != 0)
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Partida</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $a=1 ?>
                            @foreach ($resct as $r)
                                <tr>
                                    <td scope="row">{{ $a }}</td>
                                    <td>{{ $r->partida }}</td>
                                    <td>{{ $r->concepto }}</td>
                                    <td>${{ $r->cantidad }}</td>
                                </tr>
                                <?php $a++ ?>
                            @endforeach
                                <tr>
                                    <td colspan="3">Subtotal</td>
                                    <td>{{'$'.$subtotalt}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No aplica para este proyecto</p>
                @endif

                <h3> Recursos Humanos</h3>
                @if ($subtotalh != 0)
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Partida</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $b=1 ?>
                            @foreach ($resch as $r)
                                <tr>
                                    <td scope="row">{{ $b }}</td>
                                    <td>{{ $r->partida }}</td>
                                    <td>{{ $r->concepto }}</td>
                                    <td>${{ $r->cantidad }}</td>
                                </tr>
                                <?php $b++ ?>
                            @endforeach
                                <tr>
                                    <td colspan="3">Subtotal</td>
                                    <td>{{'$'.$subtotalh}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No aplica para este proyecto</p>
                @endif
                

                <h3> Otros Recursos</h3>
                @if ($subtotalo != 0)
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Partida</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $c=1 ?>
                            @foreach ($resco as $r)
                                <tr>
                                    <td scope="row">{{ $c }}</td>
                                    <td>{{ $r->partida }}</td>
                                    <td>{{ $r->concepto }}</td>
                                    <td>${{ $r->cantidad }}</td>
                                </tr>
                                <?php $c++ ?>
                            @endforeach
                                <tr>
                                    <td colspan="3">Subtotal</td>
                                    <td>{{'$'.$subtotalo}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No aplica para este proyecto</p>
                @endif

                <h3> Presupuesto Global </h3>
                <div>
                    <table>
                        <thead>
                        <tr>
                            <th scope="col">Recursos</th>
                            <th scope="col">Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Recurso Financiero</td>
                            <td>{{'$'.$subtotalf}}</td>
                        </tr>
                        <tr>
                            <td>Recurso Materiales</td>
                            <td>{{'$'.$subtotalm}}</td>
                        </tr>
                        <tr>
                            <td>Recurso Tecnológico</td>
                            <td>{{'$'.$subtotalt}}</td>
                        </tr>
                        <tr>
                            <td>Recurso Humanos</td>
                            <td>{{'$'.$subtotalh}}</td>
                        </tr>
                        <tr>
                            <td>Otros Recursos</td>
                            <td>{{'$'.$subtotalo}}</td>
                        </tr>
                        @if ($proyt->clavet == "I")
                            <tr id="etotal">
                                <th style="text-align: end">Total</th>
                                <td >$ {{round($total,2)}}</td>
                            </tr>
                        @endif
                        @if ($proyt->clavet == "E")
                        <tr id="itotal">
                            <th style="text-align: end">Subtotal</th>
                            <td>$ {{round($total,2)}}</td>
                        </tr>
                        <tr id="miva">
                            <th style="text-align: end">IVA %</th>
                            <td>$ {{$iva=(16*round($total,2)/100)}}</td>
                        </tr>
                        <tr id="final">
                            <th style="text-align: end">Total</th>
                            <td>$ {{$iva+round($total,2)}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            <br>
            <h2>11&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANÁLISIS DE RIESGOS</h2>
            <style>
                #riesgotabla{
                  text-align: center;
                  vertical-align: middle;
                  font-size: 0.7em;
                }
            </style>
            <table id="riesgotabla">
                <caption></caption>
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Riesgo</th>
                        <th scope="col">Probabilidad</th>
                        <th scope="col">Impacto</th>
                        <th scope="col">Valor Esperado (VE)</th>
                        <th scope="col">Calificación</th>
                        <th scope="col">Respuesta al riesgo</th>
                        <th scope="col">Acciones</th>
                        <th scope="col">Fecha probable de ocurrencia</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($riesgos as $ari)
                    <tr>
                        <td>Internos</td>
                        <td>{{$ari->riesgo}}</td>
                        <td>{{$ari->probabilidad}}</td>
                        <td>{{$ari->impacto}}</td>
                        <td>{{$ari->vesperado}}</td>
                        <td>{{$ari->calificacion}}</td>
                        <td>{{$ari->respriesgo}}</td>
                        <td>{{$ari->acciones}}</td>
                        <td>{{$ari->fechaproable}}</td>
                    </tr>
                @endforeach
                @foreach ($riesgose as $ari)
                    <tr>
                        <td>Externos</td>
                        <td>{{$ari->riesgo}}</td>
                        <td>{{$ari->probabilidad}}</td>
                        <td>{{$ari->impacto}}</td>
                        <td>{{$ari->vesperado}}</td>
                        <td>{{$ari->calificacion}}</td>
                        <td>{{$ari->respriesgo}}</td>
                        <td>{{$ari->acciones}}</td>
                        <td>{{$ari->fechaproable}}</td>
                    </tr>
                @endforeach
                </tbody>
              </table>
            <br>
        </div>
        <div class="section">
            <h2>REFERENCIAS</h2>
            <div>{!! $proyt->referencias !!}</div>
            @if ($proyt->notasmetodologia != '')
                <br>
                <h2>NOTAS</h2>
                <p>{{$proyt->notasmetodologia}}</p>
            @endif
                
        </div>
    </body>

    <!-- SEGMENTO DEL PIE -->
    <!--FIN DEL SEGMENTO DEL PIE -->

</html>
