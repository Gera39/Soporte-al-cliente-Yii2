<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Ticket ID: #".$model->id; 
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1><?= Html::encode($this->title) ?></h1>
          
        </div>
    </div>

    <div class="table-data">
        <div class="order">
           

            <div class="head">
                <h2><?= Html::encode('Informacion del ticket') ?></h2>
            </div>
            <?= $this->render('_informacion',['model' => $model]);?>
        </div>
    </div>
</main>