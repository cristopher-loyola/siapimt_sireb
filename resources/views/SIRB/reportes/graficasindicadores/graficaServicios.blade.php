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
        <center><h2>Cantidad de Servicios Tecnológicos por Bimestre</h2></center>

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
            var datosGrafica = {!! json_encode($serviciosPorBimestre) !!};

            var proyectosChart = new Chart(proyectosCanvas, {
                type: 'bar',
                data: {
                    labels: Object.keys(datosGrafica).map(bimestre => 'Bimestre ' + bimestre),
                    datasets: [{
                        label: 'Cantidad de Servicios',
                        data: Object.values(datosGrafica),
                        backgroundColor: getRandomColor(),
                        // backgroundColor: generateRandomColors(Object.keys(datosGrafica).length),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            // Función para obtener colores aleatorios
            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            // Función para generar un arreglo de colores aleatorios
            // function generateRandomColors(count) {
            //     var colors = [];
            //     for (var i = 0; i < count; i++) {
            //         colors.push(getRandomColor());
            //     }
            //     return colors;
            // }

            // // Función para obtener colores aleatorios
            // function getRandomColor() {
            //     var letters = '0123456789ABCDEF';
            //     var color = '#';
            //     for (var i = 0; i < 6; i++) {
            //         color += letters[Math.floor(Math.random() * 16)];
            //     }
            //     return color;
            // }
        });
    </script>
</body>
</html>
