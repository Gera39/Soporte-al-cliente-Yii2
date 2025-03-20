<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Manejo de Permisos: Secciones";
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
                <?= Html::beginForm(['/permisos/update-seccion', 'id' => '0','rol' => 'todos'])
                . Html::submitButton(
                    'Cambiar todos',
                    ['class' => 'btn btn-sm btn-success']
                )
                . Html::endForm(); 
                
                ?>
            </div>
            <?= $this->render('_tabla_secciones',['secciones' => $secciones]);?>
        </div>
    </div>
</main>