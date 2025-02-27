<?php
	require_once ("../../Conexion/ConsumoApi.php");
	$apiClient = new DatabaseApiClient("https://apicomi.codetrail.store/api");

	$tickets = $apiClient->get("tickets");
	$abierto = 0;
	$cerrado = 0;
	$internetA =0;
	$telefoniaA = 0;
	$internetC =0;
	$telefoniaC = 0;
	$beneficio = $apiClient->get("costos");

	
	foreach($tickets as $ticket){
		if(strtolower($ticket["estado"]) == "abierto"){
			if(strtolower(substr($ticket["nombre_servicio"],0,4)) == "inter"){
				$internetA++;
			} else {
				$telefoniaA++;
			}
			$abierto++;
			
		}else if(strtolower($ticket["estado"]) == "cerrado"){
			if(strtolower(substr($ticket["nombre_servicio"],0,4)) == "inter"){
				$internetC++;
			} else {
				$telefoniaC++;
			}
			$cerrado++;
		}
	}
	$internet = $internetA + $internetC;
	$telefonia = $telefoniaA + $telefoniaC;

?>


<main>
			<div class="head-title">
				<div class="left">
					<h1>Reportes</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Administrador</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Reportes</a>
						</li>
					</ul>
				</div>
				
			</div>

			<ul class="box-info">
				<h3>Tickets Reportados</h3>
				<li>
					<i class='bx bx-wifi' style="background-color:#ffffff; color:#000;"></i>
					<span class="text">
						<h3><?=$telefonia?></h3>
						<p>Telefonía</p>
					</span>
				</li>
				<li>
					<i class='bx bx-phone-call'></i>
					<span class="text">
						<h3><?=$internet?></h3>
						<p>Internet</p>
					</span>
				</li>
				<li>
					<i class='bx bx-money'></i>
					<span class="text">
						<h3>$<?=$beneficio[0]["total"]?></h3>
						<p>Ganancias Obtenidas</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Lista de Tickets</h3>
					
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>Ticket</th>
								<th>Fecha Creación</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($tickets as $ticket){
							?>
							<tr>
								<td>
									<i class="bx bx-file"></i>
									<p><?= $ticket["nombre_servicio"] ?></p>
								</td>
								<td><?= $ticket["fecha_creacion"]?></td>
								<!-- <td>
								//$ticket["descripcion"]</td> -->
								<?php 
									if(strtolower($ticket["estado"]) == "abierto"){
										$clase ="completed style='font-size:20px;'";
									}else {
										$clase ="process";
									}
								?>
								<td><span class="status <?=$clase?>"><?=$ticket["estado"]?></span></td>

							</tr>
							<?php 
						}?>
						</tbody>
					</table>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Cantidad</h3>
						
					</div>
					<ul class="todo-list">
						
						
						<li class="completed">
							<p class="lead"> <strong>Wi-Fi</strong> <br>
								Abiertos <br> </p>
								<strong class="display-5"><?=$internetA?></strong>
								<i class='bx bx-confused' style="font-size:40px;"></i>
						</li>
						<li class="completed">
							<p class="lead"> <strong>Wi-Fi</strong> <br>
								Cerrados 
							</p>
							<strong class="display-5"><?=$internetC?></strong>
							<i class='bx bx-happy-heart-eyes bx-tada' style=' font-size:40px; ' ></i>
						</li>
						<li class="not-completed">
							<p class="lead"> <strong>Telefonía</strong> <br> Abiertos </p>
							<strong class="display-5"><?=$telefoniaA?></strong>
							<i class='bx bx-confused' style="font-size:40px;"></i>
						</li>
						<li class="not-completed">
							<p class="lead"> <strong>Telefonía</strong> <br> Cerrrados</p>
							<strong class="display-5"><?=$telefoniaC?></strong>
							<i class='bx bx-happy-heart-eyes bx-tada' style=' font-size:40px;' ></i>
						</li>
					</ul>
				</div>
			</div>
		</main>