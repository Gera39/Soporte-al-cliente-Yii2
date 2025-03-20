<?php
use yii\helpers\Html;
?>
<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Servicios</h1>
        </div>
    </div>
    <div class="table-data">
        <?= $this->render('_servicios', ['servicios' => $servicios, 'servicioForm' => $servicioForm]) ?>
    </div>
</main>