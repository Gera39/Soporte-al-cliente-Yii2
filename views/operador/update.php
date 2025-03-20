<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */

$this->title = "Actualizar informacion";
?>
<main>

<div class="head-title">
    <div class="left mt-5">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</div>

<div class="table-data">
    <div class="order">
      

        <div class="head">
            <h2><?= Html::encode('Informacion del operador  ' . $model->nombre) ?></h2>
        </div>
        <?= $this->render('_form', [
        'model' => $model,
        'modelOperador' => $modelOperador,
    ]) ?>   
    
       
    </div>
</div>
</main>
