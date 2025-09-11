<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Imprimible - Hoja Tamaño Carta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .pagina {
            width: 21.59cm; /* Ancho de la hoja tamaño carta */
            height: 27.94cm; /* Alto de la hoja tamaño carta */
            background-color: white;
            border: 1px solid #ccc;
            box-sizing: border-box;
            padding: 2cm; /* Espacio para márgenes */
            overflow: hidden;
        }

        .contenido {
            width: 100%;
            height: auto;
            min-height: 100%;
        }

        /* Estilo para impresión */
        @media print {
            body, .pagina {
                margin: 0;
                padding: 0;
                height: auto;
            }

            .pagina {
                width: 21.59cm;
                height: 27.94cm;
                page-break-before: always;
                border: none;
                padding: 0.5cm;
            }

            .contenido {
                min-height: 100%;
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="pagina">
        <div class="contenido">
            <h2>1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JUSTIFICACIÓN DEL PROYECTO</h2>
            <p>{{$proyt->justificacion}}</p>
            <br>
            <h2>2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANTECEDENTES</h2>
            <p>{{$proyt->antecedente}}</p>
            <br>
            <h2>3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBJETIVOS</h2>
            <p>{{$proyt->objetivo}}</p>
            <br>
            <h3>3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBJETIVOS ESPECÍFICOS</h3>
            <p>{{$proyt->objespecifico}}</p>
            <br>
            <h2>4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALCANCES</h2>
            <p>{{$proyt->alcance}}</p>
            <br>
            <h2>5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;METODOLOGÍA</h2>
            <p>{{$proyt->metodologia}}</p>
            <br>
            <h2>6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRODUCTOS POR OBTENER</h2>
            <p>{{$proyt->producto}}</p>
            <br>
            <h2>7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMPROMISOS DEL CLIENTE</h2>
            <p>{{$proyt->comcliente}}</p>
            <br>
            <h2>8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BENEFICIOS ESPERADOS</h2>
            <p>{{$proyt->beneficios}}</p>
            <br>
            <h2>9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PLAN DE ACTIVIDADES</h2>
            <table>
                <caption></caption>
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nombre de la tarea</th>
                        <th scope="col">Fecha inicio</th>
                        <th scope="col">Fecha fin</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $r=1 ?>
                        @foreach ($tarea as $t)
                        <tr>
                            <td>{{ $r }}</td>
                            <td>{{ $t->actividad }}</td>
                            <td>{{ $t->fecha_inicio }}</td>
                            <td>{{ $t->fecha_fin }}</td>
                        </tr>
                        <?php $r++ ?>
                        @endforeach
                    </tbody>
              </table>
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
                                    <th></th>
                                    <td></td>
                                    <td>Subtotal</td>
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
                                    <th></th>
                                    <td></td>
                                    <td>Subtotal</td>
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
                                    <th></th>
                                    <td></td>
                                    <td>Subtotal</td>
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
                                    <th></th>
                                    <td></td>
                                    <td>Subtotal</td>
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
                                    <th></th>
                                    <td></td>
                                    <td>Subtotal</td>
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
    </div>
</body>
</html>
