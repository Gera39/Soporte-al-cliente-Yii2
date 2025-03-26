<?php

use yii\helpers\Html;


?>

<li>
 <span class="text">
        <h3><?= Html::encode($model->nombre_paquete) ?></h3>
        <p><?= Html::encode($model->descripcion) ?> ------- $<?= Html::encode($model->precio)?></p>
    </span>
</li>