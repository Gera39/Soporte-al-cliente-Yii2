<?php
require_once ("../../Conexion/ConsumoApi.php");
require_once "../../Conexion/Sesion.php";
$apiClient = new DatabaseApiClient("https://apicomi.codetrail.store/api");

$username = Sesion::getUsername();
require_once "../modal.php";
$resultados = $apiClient->get("servicios");
$direccion = Sesion::get("direccion");
$cp = Sesion::get("cp");
$estado = Sesion::get("estado");

$idCliente = Sesion::getId();




?>



<main>
    <div class="head-title">
        <div class="left">
            <h1>Servicios</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Cliente</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Servicios</a>
                </li>
            </ul>
        </div>

    </div>

   

    <div class="table-data">

        <div class="todo">
            <div class="head">
                <h3>Servicios</h3>
               
                
            </div>
            <ul class="todo-list">
                <?php
						$clase = "";
							foreach($resultados as $servicio){
								if(substr($servicio["nombre_servicio"],0,4) == "Inte"){
									$clase = "completed";
								}else {
									$clase ="not-completed";
								}
								?>

                <li class="<?=$clase?>">

                    <p><strong><?=$servicio["nombre_servicio"]?></strong><br>
                        <?=$servicio["descripcion"]?><br>
                        $<?=$servicio["costo"]?></p>
                    <button id="botoncitoInfo" type="button" class="btn botonchido" data-bs-toggle="modal"
                        data-bs-target="#actualizarModal<?=$servicio["id_servicio"]?>">
                        <i class='bx bxs-shopping-bags bx-tada'  style="font-size:30px;"></i>
                    </button>
                </li>
                <?php
                if($direccion === "Calle modificar" || $estado === null || $cp === null){ 
                    mostrarAviso($servicio["id_servicio"]);
                }else{
                    mostrarServicio($servicio["id_servicio"],$idCliente,$servicio["nombre_servicio"],$servicio["descripcion"],$servicio["costo"]);
                }
                  
                 
							}
                           
						?>


            </ul>
        </div>
    </div>

    

   




</main>
