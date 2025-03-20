<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */

$this->title = "Servicio " . $model->nombre_service;
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Apoco si ?',
                        'method' => 'post',
                    ],
                ]) ?>

            </p>

            <div class="head">
                <h2><?= Html::encode('Paquetes  del servicio  ' . $model->nombre_service) ?></h2>
            </div>
                <?= $this->render('_paquetes', ['model' => $model->getServicios()->all()]);?>
            <br>
        </div>
    </div>
</main>