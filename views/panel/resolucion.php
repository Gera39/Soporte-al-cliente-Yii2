<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Soluciones</h1>

        </div>

    </div>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Todas las soluciones</h3>
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['panel/resoluciones'], // Asegúrate de que el controlador sea correcto
                ]); ?>
                <div class="d-flex justify-content-around">
                    <?= Html::textInput('search', $search, ['placeholder' => 'Buscar resolución', 'class' => 'form-control']) ?>
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <?= GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $resoluciones,
                    'pagination' => false
                ]),
                'summary' => false,
                'columns' => [
                    [
                        'label' => 'Categoria',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'value' => 'name'
                    ],
                    [
                        'label' => 'Problema',
                        'headerOptions' => ['class' => 'text-center'],
                        'value' => 'descripcion'
                    ],
                    [
                        'label' => 'Solución',
                        'value' => 'comentario_resolucion'
                    ]
                ]
            ]) ?>
        </div>


    </div>
</main>