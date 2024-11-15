<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas</title>
    <link rel="stylesheet" href="{{ asset('css/indicadoresrendimientotablas.css') }}">
</head>
<body>

    <div>
        <center><h2>Ponencias y conferencias</h2></center>

        <!-- Agrega un solo elemento canvas para el gráfico -->
        <canvas id="proyectosChart" width="600" height="300"></canvas>
    </div>

    <br>
    <br>
    <br>
    <br>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var proyectosCanvas = document.getElementById('proyectosChart');
        var datosGrafica = {!! json_encode($PonenciaPorAñoSexenio) !!};
        var datosParaRango = {!! json_encode($datosParaRango) !!};

        // Asegúrate de que ambos conjuntos de datos tienen las mismas etiquetas
        var labels = Array.from(new Set([...Object.keys(datosGrafica), ...Object.keys(datosParaRango)]));

        // Filtra las etiquetas y los datos para excluir los años con cero
        var filteredLabels = labels.filter(año => datosGrafica[año] !== 0 && datosParaRango[año] !== 0);

        // Ordena las etiquetas y los datos por año
        filteredLabels.sort((a, b) => a - b);
        var filteredDatosGrafica = filteredLabels.map(año => datosGrafica[año] || 0);
        var filteredDatosParaRango = filteredLabels.map(año => datosParaRango[año] || 0);

        var proyectosChart = new Chart(proyectosCanvas, {
            type: 'bar',
            data: {
                labels: filteredLabels,
                datasets: [
                    {
                        label: 'Realizado',
                        data: filteredDatosGrafica,
                        backgroundColor: getRandomColor(),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Propuesto',
                        data: filteredDatosParaRango,
                        backgroundColor: getRandomColor(),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        stacked: false  // Desactiva el apilado en el eje x
                    },
                    y: {
                        stacked: false,  // Desactiva el apilado en el eje y
                        beginAtZero: true
                    }
                }
            }
        });

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    });
</script>
</body>
</html>
