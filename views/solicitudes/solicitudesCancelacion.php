<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Solicitudes de cancelacion";
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1><?= Html::encode($this->title) ?></h1>
          
        </div>
    </div>

    <div class="table-data">
        <div class="order">

            <div class="head d-flex justify-content-around">
                <h2><?= Html::encode('Tabla') ?></h2>
            </div>
            <?= $this->render('_cancelaciones',['solicitudes' => $solicitudes]);?>
        </div>
    </div>
</main>