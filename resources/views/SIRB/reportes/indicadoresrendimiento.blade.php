<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicadores de Rendimiento</title>
    <link rel="icon" href="img/Logo_IMT_mini.png" type="image/png" />
    <link rel="stylesheet" href="{{ asset('css/indicadoresrendimiento.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
</head>
<body>






<table id="miTablaUnica">
    <tr>
        <td>
            <img src="{{ asset('img/Logo_IMT.png') }}" alt="Logo IMT">
        </td>
        <td>
            <h1>Instituto Mexicano del Transporte</h1>
            <h2>
                Metas e indicadores del Plan Estratégico {{ reset($rangoDeAños) }} - {{ end($rangoDeAños) }}
            </h2>
            {{$nombrearea->nombre_area}}
        </td>
        <td>
            <span>Fecha de elaboración: <br><br><?php echo date('Y-m-d'); ?></span>
        </td>
    </tr>
</table>










<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES</th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="10">Desarrollar  metodologías e investigaciones para identificar los principales retos y  oportunidades de la integración modal, logística y territorial del transporte  de carga y pasajeros del país y proponer cauces de mejora.</td>
      <td width="354" rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
            <div class="details-container">
              <button onclick="OpenGrafics('{{ route('indicadorProyectosInternosGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                  <i class="bi bi-bar-chart-line"></i>
              </button>
            </div>
      <div align="justify">1.1 Cumplir con el  programa de trabajo de los proyectos de investigación de iniciativa interna.</div>
      </td>
    <td><strong>P</strong></td>
    @foreach ($datosParaRango as $dato)
      <td>
        <span id="PI1{{ $dato->anio }}" name="PI1{{ $dato->anio }}">{{ $dato->PI1 }}</span>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoProyectosIPorAño as $año => $conteoProyectosI)
        <td class="expandable-cell">
            @if ($conteoProyectosI != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadorProyectosInternosGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadorProyectosInternosTablas', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="PI1conteo{{ $año }}" name="PI1conteo{{ $año }}" class="expandable-button">{{ $conteoProyectosI }}</span>
            </div>
        </td>
    @endforeach
</tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosI = $conteoProyectosIPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->PI1;
                $porcentaje = ($valor != 0) ? ($conteoProyectosI / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp
            <span id="PI1porcentaje{{ $año }}" name="PI1porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">1.1 Grado de  cumplimiento del programa de trabajo (CPT1).</div></td>
    <td><strong>P</strong></td>
    @foreach ($datosParaRango as $dato)
        <td><span id="CPT1-2{{ $dato->anio }}" name="CPT1-2{{ $dato->anio }}">{{ $dato->{'CPT1-2'} }}%</span></td>
    @endforeach
  </tr> --}}
  {{-- <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosI = $conteoProyectosIPorAñoFull[$año];
                $dato = $datosParaRango->where('anio', $año)->first();
                $sumaProgresos = $conteoProyectosI->sum('progreso');
                $cptValue = $dato ? $dato->{'CPT1-2'} : 0;
                $promedio = $cptValue != 0 ? intval($sumaProgresos / $cptValue) : 0;
            @endphp

            {{ $promedio }}%
        </td>
    @endforeach
</tr> --}}
  <tr>
    <td rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorProyectosIn_Ex_ternosGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
          </div>
      <div align="justify">1.2 Cumplir con el  número de proyectos comprometidos en el programa de trabajo anual del IMT, de  acuerdo a la meta individual de la Coordinación.</div>
    </td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="MIPC3{{ $dato->anio }}" name="MIPC3{{ $dato->anio }}">{{ $dato->MIPC3 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($ProyectosIEPorAño as $año => $conteoProys)
      <td class="expandable-cell">
            @if ($conteoProys != 0)
                <div class="details-container">
                    <button onclick="OpenGrafics('{{ route('indicadorProyectosIntExtGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                        <i class="bi bi-bar-chart-line"></i>
                    </button>
                    <button onclick="OpenTables('{{ route('indicadorProyectosITodosTablas', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                    </button>
                </div>
            @endif
            <div class="conteo-container">
                <span id="MIPC3conteo{{ $año }}" name="MIPC3conteo{{ $año }}">{{ $conteoProys }}</span>
            </div>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosI = $ProyectosIEPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->MIPC3;
                $porcentaje = ($valor != 0) ? ($conteoProyectosI / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="MIPC3porcentaje{{ $año }}" name="MIPC3porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">1.2 Índice de proyectos  concluidos (PC1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IPC4{{ $dato->anio }}" name="IPC4{{ $dato->anio }}">{{ $dato->IPC4 }}</span></td>
      @endforeach
  </tr> --}}
  {{-- <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosI = $conteoProyectosIPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->MIPC3;
                $IPC4 = $datosParaRango->where('anio', $año)->first()->IPC4;
                $porcentaje = ($IPC4 == 0.00) ? 0.00 : ($conteoProyectosI / $valor);
            @endphp
            <span id="IPC4porcentaje{{ $año }}" name="IPC4porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}

    </tbody>
</table>

<br>
<br>

<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES </th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="10">Vincular a los investigadores y a sus procesos de investigación con los principales agentes de los sectores público, privado, académico y social pertinentes según la materia en estudio para la gestión y desarrollo de sus investigaciones.</td>
    <td width="354" rowspan="3"  class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorProyectosExternosGraficaAños1', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">2.1 Cumplir con el programa de trabajo de los proyectos de investigación de iniciativa externa.</div></td>
    <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="PE5{{ $dato->anio }}" name="PE5{{ $dato->anio }}">{{ $dato->PE5 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoProyectosEPorAño as $año => $conteoProyectosE)
      <td class="expandable-cell">
            @if ($conteoProyectosE != 0)
                <div class="details-container">
                    <button onclick="OpenGrafics('{{ route('indicadorProyectosExternosGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                        <i class="bi bi-bar-chart-line"></i>
                    </button>
                    <button onclick="OpenTables('{{ route('indicadorProyectosExternosTablas', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                    </button>
                </div>
            @endif
            <div class="conteo-container">
                <span id="PE5conteo{{ $año }}" name="PE5conteo{{ $año }}">{{ $conteoProyectosE }}</span>
            </div>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosE = $conteoProyectosEPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->PE5;
                $porcentaje = ($valor != 0) ? ($conteoProyectosE / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="PE5porcentaje{{ $año }}" name="PE5porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>

      <div align="justify">2.1 Grado de cumplimiento del programa de trabajo (CPT1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="CPT2-6{{ $dato->anio }}" name="CPT2-6{{ $dato->anio }}">{{ $dato->{'CPT2-6'} }}%</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosE = $conteoProyectosEPorAñoFull[$año];
                $dato = $datosParaRango->where('anio', $año)->first();
                $sumaProgresos = $conteoProyectosE->sum('progreso');
                $cptValue = $dato ? $dato->{'CPT2-6'} : 0;
                $promedio = $cptValue != 0 ? intval($sumaProgresos / $cptValue) : 0;
            @endphp

            {{ $promedio }}%
        </td>
    @endforeach
</tr> --}}
  <tr>
    <td rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorProyectosExternosGraficaAños2', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">2.2 Mantener al menos un 40% de proyectos de investigación de iniciativa externa.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="MIPEC7{{ $dato->anio }}" name="MIPEC7{{ $dato->anio }}">{{ $dato->MIPEC7 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoProyectosEPorAño as $año => $conteoProyectosE)
      <td class="expandable-cell">
            @if ($conteoProyectosE != 0)
                <div class="details-container">
                    <button onclick="OpenGrafics('{{ route('indicadorProyectosExternosGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                        <i class="bi bi-bar-chart-line"></i>
                    </button>
                    <button onclick="OpenTables('{{ route('indicadorProyectosExternosTablas', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                    </button>
                </div>
            @endif
            <div class="conteo-container">
               <span id="MIPEC7conteo{{ $año }}" name="MIPEC7conteo{{ $año }}">{{ $conteoProyectosE }}</span>
            </div>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosE = $conteoProyectosEPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->MIPEC7;
                $porcentaje = ($valor != 0) ? ($conteoProyectosE / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="MIPEC7porcentaje{{ $año }}" name="MIPEC7porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">2.2 Porcentaje de proyectos de investigación de iniciativa externa (PIIE1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="PIIE8{{ $dato->anio }}" name="PIIE8{{ $dato->anio }}">{{ $dato->PIIE8 }}%</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoProyectosE = $conteoProyectosEPorAñoFull[$año];
                $dato = $datosParaRango->where('anio', $año)->first();
                $sumaProgresos = $conteoProyectosE->sum('progreso');
                $cptValue = $dato ? $dato->{'PIIE8'} : 0;
                $promedio = $cptValue != 0 ? intval($sumaProgresos / $cptValue) : 0;
            @endphp

            {{ $promedio }}%
        </td>
    @endforeach
</tr> --}}
    </tbody>
</table>

<br>
<br>

<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES </th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="3">Apoyar al Sector transporte a través de ensayos de laboratorio para determinar las características o las propiedades de los materiales o elementos utilizados en la infraestructura o en los vehículos para el transporte.</td>
    <td width="354" rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorServiciosGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">3.1 Cumplir con el número de ensayos de laboratorio, comprometidos en el programa de trabajo anual del IMT.</div></td>
    <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="EL9{{ $dato->anio }}" name="EL9{{ $dato->anio }}">{{ $dato->EL9 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoServiciosTecnologicosPorAño as $año => $conteoST)
      <td class="expandable-cell">
            @if ($conteoST != 0)
                <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadorServiciosGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadorServiciosTablas', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
                </div>
            @endif
            <div class="conteo-container">
                <span id="EL9conteo{{ $año }}" name="EL9conteo{{ $año }}">{{ $conteoST }}</span>
            </div>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoST = $conteoServiciosTecnologicosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->EL9;
                $porcentaje = ($valor != 0) ? ($conteoST / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="EL9porcentaje{{ $año }}" name="EL9porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">3.1 Índice de ensayos de laboratorio (ELC).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="ELC10{{ $dato->anio }}" name="ELC10{{ $dato->anio }}">{{ $dato->ELC10 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoST = $conteoServiciosTecnologicosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->EL9;
                $ELC10 = $datosParaRango->where('anio', $año)->first()->ELC10;
                $porcentaje = ($ELC10 == 0.00) ? 0.00 : ($conteoST / $valor);
            @endphp
            <span id="ELC10porcentaje{{ $año }}" name="ELC10porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
  <tr>
    <td width="335" rowspan="5">Promover la divulgación y aplicación de los resultados de los proyectos de investigación en foros nacionales e internacionales y por medios diversos que tengan penetración entre los principales agentes de la actividad del transporte en México y entre los grupos académicos relacionados con la materia.</td>
    <td rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorMem_Rev_NacGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">4.1 Cumplir con el número de Artículos publicados en revistas o memorias nacionales, con o sin arbitraje, comprometidos en el programa de trabajo anual del IMT.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="APRMN11{{ $dato->anio }}" name="APRMN11{{ $dato->anio }}">{{ $dato->APRMN11 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($RevistaMemoriaNacionalPorAño as $año => $RevistaMemoriaNacional)
      <td class="expandable-cell">
            @if ($RevistaMemoriaNacional != 0)
                <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresRevistasMemoriasNacionalesGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresRevistasMemoriasNacionalestabla', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
                </div>
            @endif
            <div class="conteo-container">
                <span id="APRMN11conteo{{ $año }}" name="APRMN11conteo{{ $año }}">{{ $RevistaMemoriaNacional }}</span>
            </div>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $RevistaMemoriaNacional = $RevistaMemoriaNacionalPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->APRMN11;
                $porcentaje = ($valor != 0) ? ($RevistaMemoriaNacional / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="APRMN11porcentaje{{ $año }}" name="APRMN11porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">4.1 Índice de Artículos publicados en revistas o memorias nacionales, con o sin arbitraje (AN1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IAPRMN12{{ $dato->anio }}" name="IAPRMN12{{ $dato->anio }}">{{ $dato->IAPRMN12 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $RevistaMemoriaNacional = $RevistaMemoriaNacionalPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->APRMN11;
                $IAPRMN12 = $datosParaRango->where('anio', $año)->first()->IAPRMN12;
                $porcentaje = ($IAPRMN12 == 0.00) ? 0.00 : ($RevistaMemoriaNacional / $valor);
            @endphp
            <span id="IAPRMN12porcentaje{{ $año }}" name="IAPRMN12porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
    </tbody>
</table>

<br>
<br>

<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES </th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="10">Promover la divulgación y aplicación de los resultados de los proyectos de investigación en foros nacionales e internacionales y por medios diversos que tengan penetración entre los principales agentes de la actividad del transporte en México y entre los grupos académicos relacionados con la materia.</td>
    <td width="354" rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorMem_Rev_ItnacGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">4.2 Cumplir con el número de Artículos publicados en revistas o memorias internacionales, con o sin arbitraje, comprometidos en el programa de trabajo anual del IMT.</div></td>
    <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="APRMI13{{ $dato->anio }}" name="APRMI13{{ $dato->anio }}">{{ $dato->APRMI13 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($RevistaMemoriaInternacionalPorAño as $año => $RevistaMemoriaInternacional)
      <td class="expandable-cell">
            @if ($RevistaMemoriaInternacional != 0)
                <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresRevistasMemoriasInternacionalesGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresRevistasMemoriasInternacionalestabla', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
                </div>
            @endif
            <div class="conteo-container">
                <span id="APRMI13conteo{{ $año }}" name="APRMI13conteo{{ $año }}">{{ $RevistaMemoriaInternacional }}</span>
            </div>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $RevistaMemoriaInternacional = $RevistaMemoriaInternacionalPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->APRMI13;
                $porcentaje = ($valor != 0) ? ($RevistaMemoriaInternacional / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="APRMI13porcentaje{{ $año }}" name="APRMI13porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">4.2 Índice de Artículos publicados en revistas o memorias internacionales, con o sin arbitraje (AI1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IAPRMI14{{ $dato->anio }}" name="IAPRMI14{{ $dato->anio }}">{{ $dato->IAPRMI14 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $RevistaMemoriaInternacional = $RevistaMemoriaInternacionalPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->APRMI13;
                $IAPRMI14 = $datosParaRango->where('anio', $año)->first()->IAPRMI14;
                $porcentaje = ($IAPRMI14 == 0.00) ? 0.00 : ($RevistaMemoriaInternacional / $valor);
            @endphp
            <span id="IAPRMI14porcentaje{{ $año }}" name="IAPRMI14porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
  <tr>
    <td rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
            <div class="details-container">
              <button onclick="OpenGrafics('{{ route('indicadoresBoletinesGraficaporAño', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                  <i class="bi bi-bar-chart-line"></i>
              </button>
            </div>
      <div align="justify">4.3 Cumplir con el número de Artículos en boletines del IMT, comprometidos en el programa de trabajo anual del IMT.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="AB15{{ $dato->anio }}" name="AB15{{ $dato->anio }}">{{ $dato->AB15 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoBoletinesPorAño as $año => $conteoBoletines)
      <td class="expandable-cell">
            @if ($conteoBoletines != 0)
                <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresBoletinesGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresBoletinestabla', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
                </div>
            @endif
            <div class="conteo-container">
                <span id="AB15conteo{{ $año }}" name="AB15conteo{{ $año }}">{{ $conteoBoletines }}</span>
            </div>
      </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoBoletines = $conteoBoletinesPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->AB15;
                $porcentaje = ($valor != 0) ? ($conteoBoletines / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="AB15porcentaje{{ $año }}" name="AB15porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">4.3 Índice de Artículos en boletines del IMT (AB1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IAB16{{ $dato->anio }}" name="IAB16{{ $dato->anio }}">{{ $dato->IAB16 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoBoletines = $conteoBoletinesPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->AB15;
                $IAB16 = $datosParaRango->where('anio', $año)->first()->IAB16;
                $porcentaje = ($IAB16 == 0.00) ? 0.00 : ($conteoBoletines / $valor);
            @endphp
            <span id="IAB16porcentaje{{ $año }}" name="IAB16porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
    </tbody>
</table>

<br>
<br>

<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES </th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="10">Promover la divulgación y aplicación de los resultados de los proyectos de investigación en foros nacionales e internacionales y por medios diversos que tengan penetración entre los principales agentes de la actividad del transporte en México y entre los grupos académicos relacionados con la materia.</td>
    <td width="354" rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorPonenConfGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">4.4 Cumplir con el número de Conferencias en Seminarios y Congresos, comprometidos en el programa de trabajo anual del IMT.</div></td>
    <td><strong>P</strong></td>
    @foreach ($datosParaRango as $dato)
        <td><span id="CSC17{{ $dato->anio }}" name="CSC17{{ $dato->anio }}">{{ $dato->CSC17 }}</span></td>
    @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoPonenciasConferenciasPorAño as $año => $conteoPonenciasConferencias)
      <td class="expandable-cell">
            @if ($conteoPonenciasConferencias != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadorPonenciasConferenciasGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadorPonenciasConferenciasTablas', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="CSC17conteo{{ $año }}" name="CSC17conteo{{ $año }}">{{ $conteoPonenciasConferencias }}</span>
            </div>
        </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoPonenciasConferencias = $conteoPonenciasConferenciasPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->CSC17;
                $porcentaje = ($valor != 0) ? ($conteoPonenciasConferencias / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="CSC17porcentaje{{ $año }}" name="CSC17porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">4.4 Índice de Conferencias en Seminarios y Congresos (CSC1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="ICSC18{{ $dato->anio }}" name="ICSC18{{ $dato->anio }}">{{ $dato->ICSC18 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoPonenciasConferencias = $conteoPonenciasConferenciasPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->CSC17;
                $ICSC18 = $datosParaRango->where('anio', $año)->first()->ICSC18;
                $porcentaje = ($ICSC18 == 0.00) ? 0.00 : ($conteoPonenciasConferencias / $valor);
            @endphp
            <span id="ICSC18porcentaje{{ $año }}" name="ICSC18porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
  <tr>
    <td rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
      <div align="justify" >4.5 Cumplir con el número de Publicaciones Técnicas, comprometidos en el programa de trabajo anual del IMT.
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorDocTecGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
    </div>
  </td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="PT19{{ $dato->anio }}" name="PT19{{ $dato->anio }}">{{ $dato->PT19 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoDocumentosPorAño as $año => $conteoDocumentos)
      <td class="expandable-cell">
            @if ($conteoDocumentos != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadorDocumentosGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadorDocumentosTablas', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="PT19conteo{{ $año }}" name="PT19conteo{{ $año }}">{{ $conteoDocumentos }}</span>
            </div>
        </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoDocumentos = $conteoDocumentosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->PT19;
                $porcentaje = ($valor != 0) ? ($conteoDocumentos / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="PT19porcentaje{{ $año }}" name="PT19porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">4.5 Índice de Publicaciones Técnicas (PTEC1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IPT20{{ $dato->anio }}" name="IPT20{{ $dato->anio }}">{{ $dato->IPT20 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoDocumentos = $conteoDocumentosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->PT19;
                $IPT20 = $datosParaRango->where('anio', $año)->first()->IPT20;
                $porcentaje = ($IPT20 == 0.00) ? 0.00 : ($conteoDocumentos / $valor);
            @endphp
            <span id="IPT20porcentaje{{ $año }}" name="IPT20porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
    </tbody>
</table>

<br>
<br>

<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES </th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="3">Apoyar a los agentes de la actividad del transporte en México y los grupos académicos relacionados con la materia, a través de reuniones de trabajo y dando respuesta a sus consultas o apoyos solicitados.</td>
    <td width="354" rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorReu_solc_GraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">5.1 Número de apoyos realizados o consultas atendidas y participaciones en reuniones de trabajo.</div></td>
    <td><strong>P</strong></td>
    @foreach ($datosParaRango as $dato)
        <td><span id="ACA21{{ $dato->anio }}" name="ACA21{{ $dato->anio }}">{{ $dato->ACA21 }}</span></td>
    @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($ReunionSolicitudPorAño as $año => $conteoReunionSolicitud)
      <td class="expandable-cell">
            @if ($conteoReunionSolicitud != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresReunionesSolicitudesGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresReunionesSolicitudestabla', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="ACA21conteo{{ $año }}" name="ACA21conteo{{ $año }}">{{ $conteoReunionSolicitud }}</span>
            </div>
        </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoReunionSolicitud = $ReunionSolicitudPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->ACA21;
                $porcentaje = ($valor != 0) ? ($conteoReunionSolicitud / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="ACA21porcentaje{{ $año }}" name="ACA21porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">5.1 Número de apoyos realizados o consultas atendidas y participaciones en reuniones de trabajo / Número de solicitudes.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IACA22{{ $dato->anio }}" name="IACA22{{ $dato->anio }}">{{ $dato->IACA22 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoReunionSolicitud = $ReunionSolicitudPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->ACA21;
                $IACA22 = $datosParaRango->where('anio', $año)->first()->IACA22;
                $porcentaje = ($IACA22 == 0.00) ? 0.00 : ($conteoReunionSolicitud / $valor);
            @endphp
            <span id="IACA22porcentaje{{ $año }}" name="IACA22porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
  <tr>
  <td width="335" rowspan="3">Auspiciar el desarrollo académico de sus investigadores.</td>
    <td rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorPostgradosGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">6.1 Número de investigadores que obtienen el grado por estudios de doctorado, maestría o licenciatura.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IOGDML23{{ $dato->anio }}" name="IOGDML23{{ $dato->anio }}">{{ $dato->IOGDML23 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoPostgradosPorAño as $año => $conteoPostgrados)
      <td class="expandable-cell">
            @if ($conteoPostgrados != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresPostgradosGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresPostgradostabla', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="IOGDML23conteo{{ $año }}" name="IOGDML23conteo{{ $año }}">{{ $conteoPostgrados }}</span>
            </div>
        </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoPostgrados = $conteoPostgradosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->IOGDML23;
                $porcentaje = ($valor != 0) ? ($conteoPostgrados / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="IOGDML23porcentaje{{ $año }}" name="IOGDML23porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">6.1 Número de investigadores que obtuvieron el grado / Número de investigadores progrmados.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="IIOGDML24{{ $dato->anio }}" name="IIOGDML24{{ $dato->anio }}">{{ $dato->IIOGDML24 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoPostgrados = $conteoPostgradosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->IOGDML23;
                $IIOGDML24 = $datosParaRango->where('anio', $año)->first()->IIOGDML24;
                $porcentaje = ($IIOGDML24 == 0.00) ? 0.00 : ($conteoPostgrados / $valor);
            @endphp
            <span id="IIOGDML24porcentaje{{ $año }}" name="IIOGDML24porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
    </tbody>
</table>

<br>
<br>

<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES </th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="3">Auspiciar el desarrollo académico de sus investigadores.</td>
    <td width="354" rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorDocenciasGraficaAños1', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">6.2 Cumplir con el número de eventos de capacitación interna, comprometidos en el programa de trabajo anual del IMT.</div></td>
    <td><strong>P</strong></td>
    @foreach ($datosParaRango as $dato)
        <td><span id="CI25{{ $dato->anio }}" name="CI25{{ $dato->anio }}">{{ $dato->CI25 }}</span></td>
    @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoCursosPorAño as $año => $conteoDocencia)
      <td class="expandable-cell">
            @if ($conteoDocencia != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresDocenciaGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresDocenciatabla', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="CI25conteo{{ $año }}" name="CI25conteo{{ $año }}">{{ $conteoDocencia }}</span>
            </div>
        </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoDocencia = $conteoCursosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->CI25;
                $porcentaje = ($valor != 0) ? ($conteoDocencia / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="CI25porcentaje{{ $año }}" name="CI25porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">6.2 Índice de cumplimiento del programa anual de capacitación (PAC1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="ICI26{{ $dato->anio }}" name="ICI26{{ $dato->anio }}">{{ $dato->ICI26 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoDocencia = $conteoDocenciaPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->CI25;
                $ICI26 = $datosParaRango->where('anio', $año)->first()->ICI26;
                $porcentaje = ($ICI26 == 0.00) ? 0.00 : ($conteoDocencia / $valor);
            @endphp
            <span id="ICI26porcentaje{{ $año }}" name="ICI26porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}

  <tr>
  <td width="335" rowspan="3">Apoyar la especialización profesional y de posgrado de recursos humanos en temas de transporte.</td>
    <td rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorDocenciasGraficaAños2', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">7.1 Cumplir con el número de Cursos Internacionales y/o regionales, comprometidos en el programa de trabajo anual del IMT.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="CIR27{{ $dato->anio }}" name="CIR27{{ $dato->anio }}">{{ $dato->CIR27 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($conteoDocenciaPorAño as $año => $conteoDocencia)
      <td class="expandable-cell">
            @if ($conteoDocencia != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresDocenciaGrafica1', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresDocenciatabla1', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="CIR27conteo{{ $año }}" name="CIR27conteo{{ $año }}">{{ $conteoDocencia }}</span>
            </div>
        </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoDocencia = $conteoCursosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->CIR27;
                $porcentaje = ($valor != 0) ? ($conteoDocencia / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="CIR27porcentaje{{ $año }}" name="CIR27porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">7.1 Indice de Cursos internacionales y/o regionales (CIR1).</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="ICIR28{{ $dato->anio }}" name="ICIR28{{ $dato->anio }}">{{ $dato->ICIR28 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoDocencia = $conteoDocenciaPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->CIR27;
                $ICIR28 = $datosParaRango->where('anio', $año)->first()->ICIR28;
                $porcentaje = ($ICIR28 == 0.00) ? 0.00 : ($conteoDocencia / $valor);
            @endphp
            <span id="ICIR28porcentaje{{ $año }}" name="ICIR28porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
  </tr> --}}
    </tbody>
</table>

<br>
<br>

<table>
    <thead>
        <tr>
            <th rowspan="2">OBJETIVOS ESTRATÉGICOS</th>
            <th rowspan="2">METAS E INDICADORES </th>
            <th colspan="7">DESEMPEÑO</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            @foreach ($rangoDeAños as $año)
                <th>{{ $año }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    <tr>
    <td width="335" rowspan="10">Apoyar la especialización profesional y de posgrado de recursos humanos en temas de transporte.</td>
    <td width="354" rowspan="3" class="expandable-cell"><p align="justify"><strong>META</strong></p>
        <div class="details-container">
            <button onclick="OpenGrafics('{{ route('indicadorTesisCursosRecGraficaAños', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                <i class="bi bi-bar-chart-line"></i>
            </button>
        </div>
      <div align="justify">7.2 Número de temas impartidos y tesis dirigidas.</div></td>
    <td><strong>P</strong></td>
    @foreach ($datosParaRango as $dato)
        <td><span id="TITD29{{ $dato->anio }}" name="TITD29{{ $dato->anio }}">{{ $dato->TITD29 }}</span></td>
    @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($TesisCursosPorAño as $año => $conteoTesisCursos)
      <td class="expandable-cell">
            @if ($conteoTesisCursos != 0)
              <div class="details-container">
                  <button onclick="OpenGrafics('{{ route('indicadoresTesisCursosGrafica', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-bar-chart-line"></i>
                  </button>
                  <button onclick="OpenTables('{{ route('indicadoresTesisCursostabla', ['año' => $año, 'sexenio' => $sexenio]) }}')" type="button" class="option-button">
                      <i class="bi bi-card-list"></i>
                  </button>
              </div>
            @endif
            <div class="conteo-container">
                <span id="TITD29conteo{{ $año }}" name="TITD29conteo{{ $año }}">{{ $conteoTesisCursos }}</span>
            </div>
        </td>
    @endforeach
  </tr>
  <tr>
    <td><strong>I</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoTesisCursos = $TesisCursosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->TITD29;
                $porcentaje = ($valor != 0) ? ($conteoTesisCursos / $valor) * 100 : 0;
                $porcentaje = round($porcentaje);
            @endphp

            <span id="TITD29porcentaje{{ $año }}" name="TITD29porcentaje{{ $año }}">{{ $porcentaje }}%</span>
        </td>
    @endforeach
  </tr>
  {{-- <tr>
    <td rowspan="2"><p align="justify"><strong>INDICADOR</strong></p>
      <div align="justify">7.2 Número de temas impartidos y tesis dirigidas / Número de temas y tesis programadas.</div></td>
      <td><strong>P</strong></td>
      @foreach ($datosParaRango as $dato)
        <td><span id="ITITD30{{ $dato->anio }}" name="ITITD30{{ $dato->anio }}">{{ $dato->ITITD30 }}</span></td>
      @endforeach
  </tr>
  <tr>
    <td><strong>R</strong></td>
    @foreach ($rangoDeAños as $año)
        <td>
            @php
                $conteoTesisCursos = $TesisCursosPorAño[$año];
                $valor = $datosParaRango->where('anio', $año)->first()->TITD29;
                $ITITD30 = $datosParaRango->where('anio', $año)->first()->ITITD30;
                $porcentaje = ($ITITD30 == 0.00) ? 0.00 : ($conteoTesisCursos / $valor);
            @endphp
            <span id="ITITD30porcentaje{{ $año }}" name="ITITD30porcentaje{{ $año }}">{{ sprintf("%.2f", $porcentaje) }}</span>
          </td>
    @endforeach
</tr> --}}
    </tbody>
</table>

<br>
<br>

 <div class="button-container">
    <button class="button red-button" onclick="location.href='menureportes'">Volver</button>
    <button type="button" class="button" onclick="window.print()">Generar PDF</button>
 </div>




<script src="{{ asset('js/indicadoresrendimiento2.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-a2AfeDQTxgx5quGIUQZtP8Ujll7GzNfI5Z0aCzOs9boISdAenXf7d4z5MWVlTxH" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyIxk5P+cpJ3UuqF7igl5GKE2fTx4Iw7gj" crossorigin="anonymous"></script>

</body>
</html>
