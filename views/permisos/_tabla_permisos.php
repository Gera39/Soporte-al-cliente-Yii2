<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$dataProvider = new ArrayDataProvider([
    'allModels' => $usuarios,
    'pagination' => false,
]);

echo GridView::widget([
    'dataProvider' =>$dataProvider,
    'summary' => false,
    'columns' => [
        'nombre',
        'email',
        [
            'label' => 'Teléfono',
            'value' => function($model){
                return ($model->telefono)? $model->telefono:'No hay numero de telefono';
            }
        ],
        [
            'label' => 'Rol',
            'format' => 'raw',
            'contentOptions' => function($model){
                return ['style'=> 'color:white; text-align:center; background-color:'.($model->role === 'operador'? 'green':'rgb(11, 75, 177)')];
            },
            'value' => function($model){
                return $model->role;
            }
        ],
        [
            'attribute' => 'Estado',
            'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
            'contentOptions' => function ($model) {
                return ['style' => 'text-align: center; background-color:' . ($model['estado'] == '1' ? '#d4edda' : '#f5c6cb')];
            },
            'value' => function ($model) {
                return ($model['estado']  == '1') ? 'Activo' : 'Bloqueado';
            }
        ],
        [
            'label' => 'Acciones',
            'format' => 'raw',
            'contentOptions' =>  ['style' => 'text-align:center;'],
            'value' => function($model){
                $text = ($model->estado == '1') ? 'Bloquear' : 'Desbloquear';
                return Html::a('permisos',['view','id' => $model->id],['class' => 'btn btn-primary m-2']).
                       Html::beginForm(['/permisos/update-estatus', 'id' => $model['id']])
								. Html::hiddenInput('User[estado]', $model['estado'] == '1' ? '0' : '1')
								. Html::submitButton(
									$text,
									['class' => 'btn btn-sm ' . ($model['estado'] == '1' ? 'btn-danger' : 'btn-success')]
								)
								. Html::endForm();
            }
            
        ]

    ]
]);


?>