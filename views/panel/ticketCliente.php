<?php
	require_once ("../../Conexion/ConsumoApi.php");
    require_once "../../Conexion/Sesion.php";
	$apiClient = new DatabaseApiClient("https://apicomi.codetrail.store/api");

    $username = Sesion::getUsername();
    
    $serviciosContratados = Sesion::getServicios();
    $tickets = Sesion::getTickets();
   
    $empleados = $apiClient->get("empleados");
	$idCliente = Sesion::getId();
    $empleadosIndexados = [];


$empleadosDisponibles = [];
foreach ($serviciosContratados as $servicio) {
	foreach ($empleados as $empleado) {
		if($servicio["id_servicio"] == $empleado["id_servicio"]){
			$empleadosDisponibles[] = $empleado;
		}

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
							<a class="active" href="#">tickets</a>
						</li>
					</ul>
				</div>
				
			</div>

           
            
			<div class="table-data">
				
          
				<div class="todo">
                <form action="../Controlador/insertTicket.php" method="POST">
                    <h3>Crear Ticket</h3>
					<input type="hidden" name="id_cliente" value="<?=$idCliente?>">
                    <select name="id_empleado" id="id_emp" class="form-select custom-select" required>
                        <option value="">Selecciona un Empleado y Servicio Disponible</option>
                    <?php
                         foreach ($empleadosDisponibles as $empleado) {
                            $nombreEmp = $empleado["nombre"];
                            $idEmp = $empleado["id_empleado"];
                            $estado = $empleado["status"];
                            $especialidad = $empleado["especialidad"];
							
							echo "<option value='" . $idEmp . "' class='" . ($estado == "activo" ? 'activo' : 'inactivo') . "'>" . ucfirst($nombreEmp) . " - " . $especialidad . " - " . ucfirst($estado) . "</option>";
							

                        }
                        
                        
                    ?>

                    </select>
                   
                    
                 
                   
                    <textarea class="form-control mt-3" id="descripcion" name="descripcion" placeholder="Descripción" rows="3" required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm px-3 mt-3">Crear</button>
                    </form>
					<div class="head m-4">
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
