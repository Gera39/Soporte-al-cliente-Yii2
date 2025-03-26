<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

$seccionesFiltradas = array_filter($secciones, function($seccion) {
    // Excluir las secciones llamadas "Admin" y "Configuración"
    return !in_array($seccion->nombre, ['logs_sistema']); 
});
echo GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $seccionesFiltradas,
        'pagination' => false,
    ]),
    'columns' => [
        [
            'label' => 'Nombre Seccion',
            'value' => 'nombre',
        ],
        [
            'label' => 'Clientes',
            'format' => 'raw',
            'contentOptions' => function($model) {
                return [
                    'style' => 'text-align:center;' . ($model->estado == '1' || $model['estado'] == '2'? '' : 'background-color:#F3464A;')
                ];
            },
            'value' => function ($model) {
                $text = ($model->estado == '1' || $model->estado == '2') ? 'Bloquear' : 'Desbloquear';
                return   Html::beginForm(['/permisos/update-seccion', 'id' => $model->id, 'rol' => 'cliente'])
                . Html::submitButton(
                    $text,
                    ['class' => 'btn btn-sm ' . ($model['estado'] == '1' || $model->estado == '2' ? 'btn-danger' : 'btn-success')]
                )
                . Html::endForm();
            }
        ],
        [
            'label' => 'Operadores',
            'format' => 'raw',
            'contentOptions' => function($model) {
                return [
                    'style' => 'text-align:center;' . ($model->estado == '1'|| $model->estado == '3' ? '' : 'background-color:#F3464A;')
                ];
            },
            'value' => function ($model) {
                $text = ($model->estado == '1' || $model->estado == '3') ? 'Bloquear' : 'Desbloquear';
                return   Html::beginForm(['/permisos/update-seccion', 'id' => $model['id'],'rol' => 'operador'])
                . Html::submitButton(
                    $text,
                    ['class' => 'btn btn-sm ' . ($model['estado'] == '1'|| $model->estado == '3' ? 'btn-danger' : 'btn-success')]
                )
                . Html::endForm();
            }
        ],

        
       
    ]
]);


?>