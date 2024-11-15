<title>Configurar Metas e Indicadores</title>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/configindicadores.css') }}">
</head>
<body>


<form action="insertarRegistrosIndicadores" method="post">
@csrf

<input type="hidden" name="añoReferencia" id="añoReferencia" value="{{ $sexenio }}">

<table>
        <thead>
            <tr>
                <td>
                    <img src="{{ asset('img/Logo_IMT.png') }}" alt="Logo IMT" width="150" height="100">
                </td>
                <td colspan="7">
                    <h1>Instituto Mexicano del Transporte</h1>
                    <h2>
                        Metas e indicadores del Plan Estratégico {{ reset($rangoDeAños) }} - {{ end($rangoDeAños) }}
                    </h2>
                    {{$nombrearea->nombre_area}}
                </td>
            </tr>
            <tr>
                <th>Indicador</th>
                <th>Concepto</th>
                @foreach ($rangoDeAños as $año)
                    <th>{{ $año }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.1</td>
                <td>Proyectos Internos</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="PI1años[{{ $dato->anio }}]" id="PI1año{{ $dato->anio }}">
                            @for ($i = 0; $i <= 50; $i++)
                                <option value="{{ $i }}" {{ $dato->PI1 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>CPT1 de proyectos Internos</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="CPT1-2años[{{ $dato->anio }}]" id="CPT1-2años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->{'CPT1-2'} == $i ? 'selected' : '' }}>{{ $i }}%</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>1.2</td>
                <td>Meta individual de proyectos en coordinación (internos y externos)</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="MIPC3años[{{ $dato->anio }}]" id="MIPC3años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->MIPC3 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de proyectos concluidos</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IPC4años[{{ $dato->anio }}]" id="IPC4años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->IPC4 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>2.1</td>
                <td>Proyectos Externos</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="PE5años[{{ $dato->anio }}]" id="PE5año{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->PE5 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>CPT2 de proyectos Externos</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="CPT2-6años[{{ $dato->anio }}]" id="CPT2-6años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->{'CPT2-6'} == $i ? 'selected' : '' }}>{{ $i }}%</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>2.2</td>
                <td>Meta individual de proyectos Externos en coordinación.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="MIPEC7años[{{ $dato->anio }}]" id="MIPEC7años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->MIPEC7 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>PIIE Porcentaje de proyectos Externos</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="PIIE8años[{{ $dato->anio }}]" id="PIIE8años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->PIIE8 == $i ? 'selected' : '' }}>{{ $i }}%</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>3.1</td>
                <td>Ensayos de laboratorio.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="EL9años[{{ $dato->anio }}]" id="EL9años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->EL9 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>ELC Indice de ensayos de laboratorio.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="ELC10años[{{ $dato->anio }}]" id="ELC10años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->ELC10 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>4.1</td>
                <td>Artículos publicados en revistas o memorias nacionales.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="APRMN11años[{{ $dato->anio }}]" id="APRMN11años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->APRMN11 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de artículos publicados en revistas o memorias nacionales.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IAPRMN12años[{{ $dato->anio }}]" id="IAPRMN12años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->IAPRMN12 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>4.2</td>
                <td>Artículos publicados en revistas o memorias internacionales.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="APRMI13años[{{ $dato->anio }}]" id="APRMI13años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->APRMI13 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de artículos publicados en revistas o memorias internacionales.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IAPRMI14años[{{ $dato->anio }}]" id="IAPRMI14años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->IAPRMI14 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>4.3</td>
                <td>Artículos en boletines.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="AB15años[{{ $dato->anio }}]" id="AB15años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->AB15 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de artículos en boletines.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IAB16años[{{ $dato->anio }}]" id="IAB16años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->IAB16 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>4.4</td>
                <td>Conferencias en Seminarios y Congresos.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="CSC17años[{{ $dato->anio }}]" id="CSC17años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->CSC17 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de Conferencias en Seminarios y Congresos</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="ICSC18años[{{ $dato->anio }}]" id="ICSC18años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->ICSC18 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>4.5</td>
                <td>Publicaciones técnicas</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="PT19años[{{ $dato->anio }}]" id="PT19años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->PT19 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de publicaciones técnicas</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IPT20años[{{ $dato->anio }}]" id="IPT20años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->IPT20 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>5.1</td>
                <td>Apoyos y consultas atendidas</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="ACA21años[{{ $dato->anio }}]" id="ACA21años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->ACA21 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de apoyos y consultas atendidas</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IACA22años[{{ $dato->anio }}]" id="IACA22años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->IACA22 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>6.1</td>
                <td>Investigadores que obtienen el grado de doctorado, maestría o licenciatura.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IOGDML23años[{{ $dato->anio }}]" id="IOGDML23años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->IOGDML23 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de Investigadores que obtienen el grado.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="IIOGDML24años[{{ $dato->anio }}]" id="IIOGDML24años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->IIOGDML24 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>6.2</td>
                <td>Capacitación Interna.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="CI25años[{{ $dato->anio }}]" id="CI25años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->CI25 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>PAC Indice de capacitación Interna.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="ICI26años[{{ $dato->anio }}]" id="ICI26años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->ICI26 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>7.1</td>
                <td>Cursos Internacionales y/o regionales.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="CIR27años[{{ $dato->anio }}]" id="CIR27años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->CIR27 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>CIR Indice de Cursos internacionales y/o regionales </td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="ICIR28años[{{ $dato->anio }}]" id="ICIR28años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->ICIR28 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>7.2</td>
                <td>Temas impartidos y tesis dirigidas.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="TITD29años[{{ $dato->anio }}]" id="TITD29años{{ $dato->anio }}">
                            @for ($i = 0; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ $dato->TITD29 == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td>Indice de temas impartidos y tesis dirigidas.</td>
                @foreach ($datosParaRango as $dato)
                    <td class="select-td">
                        <select class="select-list" name="ITITD30años[{{ $dato->anio }}]" id="ITITD30años{{ $dato->anio }}">
                            @for ($i = 0.00; $i <= 1.00; $i++)
                                <option value="{{ $i }}.00" {{ $dato->ITITD30 == $i ? 'selected' : '' }}>{{ $i }}.00</option>
                            @endfor
                        </select>
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
 <br>
 <div class="button-container">
    <button class="button red-button" onclick="location.href='menureportes'">Volver</button>
    <button type="submit" class="button">Guardar</button>
 </div>
 </form>

 <br>
 <br>
</body>
</html>
<script src="{{ asset('js/configindicadores.js') }}"></script>

