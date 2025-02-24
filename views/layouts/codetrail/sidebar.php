<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
	<!-- SIDEBAR -->
    <section id="sidebar">
            <a href="#" class="brand">
                <i class='bx bxs-package' class='icon-sidebar'></i>
                <span class="text">CodeTrail</span>
            </a>
            <ul class="side-menu top">
                <li class="active">
                    <a href="#" >
                        <i class='bx bxs-dashboard' class='icon-sidebar'></i>
                        <span class="text">Inicio</span>
                    </a>
                </li>
                <li>
                <?= Html::a(
            '<i class="bx bx-user"></i> Empleados',
            ['panel/empleados'],
            [
                'data-pjax' => 1, // Activa PJAX
                'data-pjax-container' => '#pjax-container', // Contenedor a actualizar
            ]
        ) ?>    
                </li>
                <li>
                    <a href="#" >
                    <i class='bx bx-server' class='icon-sidebar' ></i>
                        <span class="text">Servicios</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class='bx bxs-report' class='icon-sidebar' ></i>
                        <span class="text">Reportes</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class='bx bx-stats' class='icon-sidebar'></i>
                        <span class="text">Gráficas</span>
                    </a>
                </li>
            </ul>
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='bx bxs-user' class='icon-sidebar'></i>
                        <span class="text">Perfil</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="logout">
                        <i class='bx bxs-log-out-circle'></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
               
               
            </ul>
        </section>

	<!-- SIDEBAR -->
