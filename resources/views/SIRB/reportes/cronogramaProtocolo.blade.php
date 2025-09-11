<style>
    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: auto;
    }
    table, th, td {
        border: 1px solid #000;
    }
    th, td {
        padding: 8px;
        text-align: center;
        font-size: 9px;
        word-wrap: break-word;
    }
    th {
        background-color:rgb(222, 219, 219);
        color: black;
    }
    .fecha {
        text-align: center;
    }
    .meses {
        background-color:rgba(0, 94, 255, 0.79);
        color: black;
    }

    .actividad {
        text-align: left;
    }
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }
        table {
            page-break-inside: auto;
            page-break-before: always;
            width: 100%;
        }
    }
</style>

<table>
    <thead>
        <tr>
            <th colspan="{{ $newDuracion + 2 }}">
                Fecha Tentativa Inicio: &nbsp; 
                <strong>{{ \Carbon\Carbon::parse($proyt->fecha_inicio)->format('d-M-Y') }}</strong>
                &nbsp; - &nbsp;
                Fecha Tentativa Fin: &nbsp;
                <strong>{{ \Carbon\Carbon::parse($fechaTarea)->format('d-M-Y') }}</strong>
            </th>
        </tr>
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">Descripción</th>
            <th colspan="{{ $newDuracion }}">Duración (Meses)</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= $newDuracion; $i++)
                <th class="fecha">M{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @php
            $num = 1;
            $finiciop = \Carbon\Carbon::parse($proyt->fecha_inicio);
            $mmes = [];
            for ($h = 1; $h <= $newDuracion; $h++) {
                $mmes[$h] = $finiciop->format("M-y");
                $finiciop->addMonth();
            }
        @endphp

        @foreach ($tarea as $ta)
            @php
                $fechaInicioTarea = \Carbon\Carbon::parse($ta->fecha_inicio);
                $mesInicioTarea = $fechaInicioTarea->format("M-y");
                $colinicro = 1;
                for ($j = 1; $j <= $newDuracion; $j++) {
                    if ($mesInicioTarea == $mmes[$j]) {
                        $colinicro = $j;
                        break;
                    }
                }
            @endphp
            <tr>
                <td>{{ $num }}</td>
                <td class="actividad">{{ $ta->actividad }}</td>
                @for ($i = 1; $i <= $newDuracion; $i++)
                    @if ($i >= $colinicro && $i < ($colinicro + $ta->duracion))
                        <td class="meses"></td>
                    @else
                        <td></td>
                    @endif
                @endfor
            </tr>
            @php
                $num++;
            @endphp
        @endforeach
    </tbody>
</table>
