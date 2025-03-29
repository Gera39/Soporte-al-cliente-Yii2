<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$rol = Yii::$app->user->identity->role;
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
                ['panel/dashboard']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="bx bxs-dashboard"></i> Solicitudes cancelacion',
                ['solicitudes/index']
            ) ?>
        </li>
        <?php if ($rol === 'admin'): ?>
            <li>
                <?= Html::a(
                    '<i class="bx bx-user"></i> Operadores',
                    ['panel/empleados']
                ) ?>
            </li>
            <li>
                <?= Html::a(
                    '<i class="bx bx-stats"></i> Asistencias Operadores',
                    ['asistencia/index']
                ) ?>
            </li>
            <li>
                <?= Html::a(
                    '<i class="bx bx-user"></i> Clientes',
                    ['panel/clientes']
                ) ?>
            </li>
            <li>
                <?= Html::a(
                    '<i class="bx bx-stats"></i> Tickets',
                    ['panel/tickets-empleado']
                ) ?>
            </li>
            <li>
                <?= Html::a(
                    '<i class="bx bxs-widget"></i> Paquetes',
                    ['panel/servicios']
                ) ?>
            </li>
            <li>
                <?= Html::a(
                    '<i class="bx bxs-key"></i> Manejo de Permisos',
                    ['permisos/index']
                ) ?>
            </li>
        <?php endif; ?>
        <li>
            <?= Html::a(
                '<i class="bx bxs-report"></i> Reportes',
                ['panel/reportes']
            ) ?>
        </li>
        <?php if ($rol === 'cliente'): ?>
            <li>
                <?= Html::a(
                    '<i class="bx bx-stats"></i> Tickets',
                    ['cliente/ticket-cliente']
                ) ?>
            </li>
        <?php endif; ?>
        <?php if ($rol === 'cliente' || $rol === 'operador'): ?>
            <li>
                <?= Html::a(
                    '<i class="bx bxs-report"></i> Servicios',
                    ['cliente/servicios-cliente']
                ) ?>
            </li>
        <?php endif; ?>
        <?php if ($rol === 'operador'): ?>
            <li>
                <?= Html::a(
                    '<i class="bx bx-stats"></i> Tickets',
                    ['operador/ticket']
                ) ?>
            </li>
        <?php endif; ?>
        <li>
            <?= Html::a(
                '<i class="bx bx-stats"></i> Soluciones de Tickets',
                ['panel/resoluciones']
            ) ?>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <?= Html::a(
                '<i class="bx bx-user"></i> Perfil',
                ['panel/perfil']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="bx bxs-log-out-circle"></i> Logout',
                ['login/logout']
            ) ?>
        </li>
    </ul>
</section>

<!-- SIDEBAR -->