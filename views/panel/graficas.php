<?php
	require_once ("../../Conexion/ConsumoApi.php");
	$apiClient = new DatabaseApiClient("https://apicomi.codetrail.store/api");

	$tickets = $apiClient->get("tickets");
	$abierto = 0;
	$cerrado = 0;
	
	
	
	foreach($tickets as $ticket){
		if(strtolower($ticket["estado"]) == "abierto"){
			$abierto++;
			
		}else if(strtolower($ticket["estado"]) == "cerrado"){
			$cerrado++;
		}
	}

	$resultados = $apiClient->get("servicios");
	$inter = 0;
	$otros = 0;
	$costo = 0;
	foreach($resultados as $servicio){
		if(substr($servicio["nombre_servicio"],0,4) == "Inte"){
			$inter ++;
		}else {
			$otros++;
		}
	}

	$serviciosCant = $apiClient->get("costos");




?>

<main>
    <script type="text/javascript">
    // Cargar las bibliotecas de Google Charts
    google.charts.load("current", {
        packages: ["corechart"]
    });

    // Configurar gráficos
    google.charts.setOnLoadCallback(drawFirstChart);
    google.charts.setOnLoadCallback(drawSecondChart);
    google.charts.setOnLoadCallback(drawBarras);

    // Primer gráfico
    function drawFirstChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Cerrados', <?=$cerrado?>],
            ['Abiertos', <?=$abierto?>]
        ]);

        var options = {

            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }

    // Segundo gráfico
    function drawSecondChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Internet', <?=$inter?>],
            ['Telefonia', <?=$otros?>]
        ]);

        var options = {

            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('dona'));
        chart.draw(data, options);
    }

    function drawBarras() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Density", {
                role: "style"
            }],
            ["Internet", <?=$serviciosCant[0]["cantidadInternet"]?>, "#0c85f1"], // Valores enteros directamente
            ["Telefonia", <?=$serviciosCant[0]["cantidadOtros"]?>, "#f1350c"] // Valores enteros directamente
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            width: 900,
            height: 400,
            bar: {
                groupWidth: "50%"
            }, // Hacer las barras más delgadas
            legend: {
                position: "none"
            },
            hAxis: { // Configuración del eje horizontal
                gridlines: {
                    count: 6
                }, // Número de líneas del grid (opcional)
                viewWindow: {
                    min: 0
                }, // Rango mínimo del eje
                format: 'decimal', // Asegura valores sin decimales
            },
            vAxis: { // Configuración del eje vertical
                ticks: [0, 2, 4, 6, 8, 10], // Valores específicos
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById("barras"));
        chart.draw(view, options);

    }
    </script>

    <div class="head-title">
        <div class="left">
            <h1>Gráficas</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Administrador</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Gráficas</a>
                </li>
            </ul>
        </div>
       
    </div>

    <ul class="box-info">
        <li style="background-color:#ffffff;">
            <i class='bx bxs-calendar-check'></i>
            <span class="text">
                <div id="donutchart" style="width: 400px; height: 350px;"></div>

                <p>Tickets</p>
            </span>
        </li>
        <li style="background-color:#ffffff;">
            <i class='bx bx-file'></i>
            <span class="text">
                <div id="dona" style="width: 400px; height: 350px;"></div>
                <p>Servicios en Oferta por Categorías</p>
            </span>
        </li>
        <!-- <li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>$2543</h3>
						<p>Total Sales</p>
					</span>
				</li> -->
    </ul>
    <ul class="box-info">
        <li style="background-color:#ffffff;">
            <i class='bx bx-money'></i>
            <span class="text">
                <div id="barras"></div>

                <p>Servicios Contratados</p>
            </span>

        </li>
    </ul>
</main>