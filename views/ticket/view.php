<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Ticket ID: #".$model->id; 
?>
<main>

    <div class="head-title">
        <div class="left">
            <h1><?= Html::encode($this->title) ?></h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Administrador</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Tickets</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </p>

            <div class="head">
                <h2><?= Html::encode('Informacion del ticket') ?></h2>
            </div>
            <?= $this->render('_informacion',['model' => $model]);?>
        </div>
    </div>
</main>