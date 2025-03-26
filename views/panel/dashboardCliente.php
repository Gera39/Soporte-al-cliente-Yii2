<?php

use yii\widgets\ListView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;


?>
<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Vista Rapida</h1>
        </div>
    </div>
    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center justify-content-between">
                <h3 class="m-3">Paquetes Contratados</h3>
            </span>
        </li>
          <?php if($paquetes != null):?>
            <?= ListView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $paquetes,
                    'pagination' => false,
                ]),
                'itemOptions' => ['tag' => false],
                'itemView' => '_item',
                'summary' => false,
            ]) ?>
            <?php endif;?>
            <li>
            <span class="text d-flex align-items-center justify-content-between">
                <h3 class="m-3">Contrata YA</h3>
                <?= Html::a('<i class="bx bx-store"></i>',['cliente/servicios-cliente']);?>
            </span>
            </li>
    </ul>
</main>