<?php
 use app\models\User;
?>



<main>
    <div class="head-title">
        <div class="left">
            <h1>Servicios</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Administrador</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Servicios</a>
                </li>
            </ul>
        </div>

    </div>

    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center justify-content-between">
                <h3 class="m-3">Contratados</h3>
            </span>
        </li>
        <li>
            <i class='bx bxs-dollar-circle'></i>
            <span class="text">
                <h3>78</h3>
                <p>Total de costos de servicios</p>
            </span>
        </li>
        <li>
            <i class='bx bx-phone-call'></i>
            <span class="text">
                <h3>78</h3>
                <p>Telecomunicación</p>
            </span>
        </li>
        <li>
            <i class='bx bx-wifi' style="background-color:#ffffff;"></i>
            <span class="text">
                <h3>78</h3>
                <p>Internet</p>
            </span>
        </li>
    </ul>


    <div class="table-data">

        <div class="todo">
            <div class="head">
                <h3>Servicios</h3>
                
 
                <a href="#" class="botonchido " style='font-size:35px; ' data-bs-toggle="modal" data-bs-target="#myModal"><i
                        class='bx bx-plus'></i></a>
                <i class='bx bx-filter'></i>
            </div>
            <ul class="todo-list">
            <li class="completed">

            <p><strong>Internet</strong><br>
                soy rapido soy veloz<br>
                $78878</p>
            <button id="botoncitoInfo" type="button" class="btn botonchido" data-bs-toggle="modal"
                data-bs-target="#actualizarModal7">
                <i class='bx bx-edit-alt' style="font-size:30px;"></i>
            </button>
            </li>
            </ul>
        </div>
    </div>

    

   




</main>