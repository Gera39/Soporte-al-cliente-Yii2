<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;



echo GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $clientes,
        'pagination' => false
    ]),
    'summary' => false,
    'columns' => [
        [
            'label' => 'Nombre',
            'value' => function($model){
                return $model->usuario->nombre;
            }
        ],
        [
            'label' => 'Email',
            'value' => function($model){
                return $model->usuario->email;
            }
        ],
        [
            'label' => 'Telefono',
            'value' => function($model){
                return ($model->usuario->telefono) ? $model->usuario->telefono : 'No tiene';
            }
        ],
        [
            'attribute' => 'Estado',
            'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
            'contentOptions' => function ($model) {
                $model = $model->usuario;
                return ['style' => 'text-align: center; background-color:' . ($model['estado'] == '1' ? '#d4edda' : '#f5c6cb')];
            },
            'value' => function ($model) {
                $model = $model->usuario;
                return ($model['estado']  == '1') ? 'Activo' : 'Bloqueado';
            }
        ],
        [
            'attribute' => 'Permiso',
            'format' => 'raw',
            'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                $model = $model->usuario;
                $text = ($model['estado'] == '1') ? 'Bloquear' : 'Desbloquear';
                return Html::beginForm(['/cliente/update-estatus', 'id' => $model['id']])
                    . Html::hiddenInput('User[estado]', $model['estado'] == '1' ? '0' : '1')
                    . Html::submitButton(
                        $text,
                        ['class' => 'btn btn-sm ' . ($model['estado'] == '1' ? 'btn-danger' : 'btn-success')]
                    )
                    . Html::endForm();
            }
        ],
        [
            'attribute' => 'Acciones',
            'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'format' => 'raw',
            'value' => function ($model) {
                $model = $model->usuario;
                return Html::a('<i class="bx bx-user"></i>', ['cliente/view', 'id' => $model['id']], ['class' => 'btn btn-sm btn-primary '])
                    . Html::a('<i class="bx bx-edit"></i>', ['operador/update', 'id' => $model['id']], ['class' => 'btn btn-sm btn-warning']);
            }
        ]
    ]
]);



?>