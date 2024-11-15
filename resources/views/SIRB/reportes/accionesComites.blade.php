<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Comités</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            header {
                display: flex; /* Utiliza flexbox */
                justify-content: start; /* Alinea los elementos a la izquierda */
                align-items: center; /* Centra los elementos verticalmente */
                margin-bottom: 2rem;
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
                width: 80%;
                margin: auto;
                font-size: .9rem;
            }
            table th {
                background-color: #f0f0f0;
            }
            table th, table td {
                padding: .5rem;
                text-align: left;
            }
        </style>
	</head>
	<body>
        <header>
            <img src="{{ public_path('img/Logo_IMT.png') }}" alt="Logo IMT">
            <h1>Instituto Mexicano del Transporte</h1>
            <h2><strong>{{ $userData->Area }}</strong></h2>
            <h3><strong>Información de Participación en Comités Perteneciente a </strong>{{ $periodoConsultado }}</h3>
        </header>
        <!-- Comites -->
        <table>

                <tr>
                    <th>Participante(s)</th>
                    <th>Nombre del Comité</th>
                    <th>Actividades Desarrolladas</th>
                </tr>
                @foreach ($comites as $comite)
                <tr>
                    <td>
                    @php
                        $participantes = explode(',', $comite->participantes);
                    @endphp
                    <strong>{{ $comite->encargado }}</strong>
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
                    <td>{{ $comite->nombre_comite }}</td>
                    <td>{{ $comite->A_desarrolladas }} <strong>({{$comite->fechas}})</strong></td>
                </tr>
                <br><br>
                @endforeach
            </tbody>
        </table>
	</body>
</html>
