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
                <li>
                <?= Html::a(
                    '<i class="bx bxs-dashboard"></i> Inicio',
                    ['panel/dashboard-admin']) ?>    
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bx-user"></i> Empleados',
                    ['panel/empleados']) ?>    
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bxs-widget"></i> Servicios',
                    ['panel/servicios']) ?>   
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bxs-report"></i> Reportes',
                    ['panel/reportes']) ?>   
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bxs-report"></i> Servicios Cliente',
                    ['panel/servicios-cliente']) ?>   
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bx-stats"></i> Graficas',
                    ['panel/graficas']) ?>   
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bx-stats"></i> Tickets',
                    ['panel/tickets-empleado']) ?>
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bx-stats"></i> Tickets Cliente',
                    ['panel/tickets-cliente']) ?>
                </li>
                <li>
                <?= Html::a(
                    '<i class="bx bx-conversation"></i> Chat',
                    ['panel/chat']) ?>
                </li>
            </ul>
            <ul class="side-menu">
                <li>
                <?= Html::a(
                    '<i class="bx bx-user"></i> Perfil',
                    ['panel/perfil']) ?>
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
