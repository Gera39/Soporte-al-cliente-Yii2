<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

echo  GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $reportes,
        'pagination' => false
    ]),
    'summary' => false,
    'columns' => [
        'nombre_reporte',
        [
            'label' => 'Descripción',
            'value' => 'descripcion',
        ],
        [
            'label' => 'Operador',
            'visible' => Yii::$app->user->identity->role === 'admin',
            'format' => 'raw',
            'value' => function($model){
                return Html::a($model->operador->usuario->nombre, ['operador/view', 'id' => $model->operador->usuario->id]);
            }
        ],
        [
            'label' => 'Cliente',
            'visible' => Yii::$app->user->identity->role === 'admin',
            'format' => 'raw',
            'value' => function($model){
                return Html::a($model->cliente->usuario->nombre, ['cliente/view', 'id' => $model->cliente->usuario->id]);
            }
        ],
        [
            'label' => 'Ticket',
            'format' => 'raw',
            'value' => function($model){
                return Html::a($model->ticket->id, ['ticket/view', 'id' => $model->ticket->id]);
            }
        ],
        [
            'label' => 'Remitente',
            'visible' => Yii::$app->user->identity->role === 'admin' ,
            'value' => function($model){
                return $model->id_remitente === $model->cliente->id ? 'Cliente' : 'Operador';
            }
        ],
        [
            'label' => 'Accion',
            'format' => 'raw',
            'visible' => Yii::$app->user->identity->role === 'operador' || Yii::$app->user->identity->role === 'cliente',
            'value' => function($model){
                return Html::a('Eliminar', ['panel/delete-reporte', 'id' => $model->id], ['class' => 'btn btn-danger']);
            }
        ]

    ]
])?>



