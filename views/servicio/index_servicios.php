<?php
use yii\helpers\Html;
?>
<main>
    <div class="head-title">
        <div class="left">
            <h1>Servicios</h1>
            <ul class="breadcrumb">
                <li>
                    <?= Html::a('Administrador',['panel/dashboard-admin'],['class' => 'active']);?>
                </li>
                <li>
                    <i class='bx bx-chevron-right'></i>
                </li>
                <li>
                    <?=Html::a('Paquetes',['servicio/index'],['class' => 'active']);?>
                </li>
                <li>
                    <i class='bx bx-chevron-right'></i>
                </li>
                <li>
                    <a  href="#">Servicios</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="table-data">
        <?= $this->render('_servicios', ['servicios' => $servicios, 'servicioForm' => $servicioForm]) ?>
    </div>
</main>