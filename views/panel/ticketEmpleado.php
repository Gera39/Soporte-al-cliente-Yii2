<?php
	require_once ("../../Conexion/ConsumoApi.php");
    require_once "../../Conexion/Sesion.php";
	$apiClient = new DatabaseApiClient("https://apicomi.codetrail.store/api");

    $username = Sesion::getUsername();

    $tickets = $apiClient->post("ticketEmpledo",["username"=> $username]);
    $abiertos = 0;
    $cerrados = 0;
    foreach ($tickets as $ticket) {
        if ($ticket["estado"] === "Abierto") {
            $abiertos++;
        }else if($ticket["estado"] === "Cerrado"){
            $cerrados++;
        }
    }
     

?>
<!-- MAIN -->
<main>
			<div class="head-title">
				<div class="left">
					<h1>Tickets</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Tickets</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">tickest</a>
						</li>
					</ul>
				</div>
				
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3><?=$abiertos?></h3>
						<p>Tickets Abiertos</p>
					</span>
				</li>
            </ul>

			<div class="table-data">
				<div class="todo">
					<div class="head">
						<h3>Tickets</h3>
						
					</div>
					<ul class="todo-list">
						<?php
							foreach ($tickets as $ticket) {
								$clase="";
								if ($ticket["estado"] === "Abierto") {
									$clase="completed";
									?>
									<li class="<?=$clase?>">
										<p><?=$ticket["nombre_servicio"]?> <br> <?=$ticket["descripcion"]?> <br><?=$ticket["fecha_creacion"]?></p>
										<i class='bx bx-message-square-dots bx-tada' style="font-size:30px;"></i>
									</li>
									<?php
								}else if($ticket["estado"] === "Cerrado"){
									$clase="not-completed";
									?>
									<li class="<?=$clase?>">
										<p><?=$ticket["nombre_servicio"]?> <br> <?=$ticket["descripcion"]?> <br><?=$ticket["fecha_creacion"]?></p>
										<i class='bx bxs-user-check' style="font-size:30px;"></i>
									</li>	
									<?php	
							}
						}
						?>
					
						
					</ul>
				</div>
			</div>
           
		</main>
