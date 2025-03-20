<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Manejo de Permisos";
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
                <h2><?= Html::encode('Tabla de Usuarios') ?></h2>
                <?= Html::a('Secciones',['permisos/secciones'],['class' => 'btn btn-primary'])?>
            </div>
            <?= $this->render('_tabla_permisos',['usuarios' => $usuarios]);?>
        </div>
    </div>
</main>