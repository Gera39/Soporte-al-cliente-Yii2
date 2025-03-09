<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */

$this->title = "Actualizar informacion";
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
                <a class="active" href="#">Empleados</a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <p>
            <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apoco si ?',
                    'method' => 'post',
                ],
            ]) ?>

        </p>

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
