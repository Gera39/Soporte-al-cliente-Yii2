<?php
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
$dataProvider = new ArrayDataProvider([
    'allModels' => $tickets,
    'pagination' => ['pageSize' => false],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Prioridad',
            'format' => 'raw',
            'contentOptions' => function ($model) {
                $prioridad = $model->prioridad; 
                if ($prioridad == 'Alta') {
                    return ['style' => 'text-align: center; background-color: rgb(255, 99, 71); color: white;'];
                } elseif ($prioridad == 'Media') {
                    return ['style' => 'text-align: center; background-color: rgb(249, 165, 22);'];
                } elseif ($prioridad == 'Baja') {
                    return ['style' => 'text-align: center; background-color: rgb(255, 231, 13);'];
                } else {
                    return ['style' => 'text-align: center;'];
                }
            },
            'value' => function ($model) {
                return $model->prioridad; 
            }
        ],
        [
            'label' => 'Categoria',
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                return $model->getCategoria()->one()->name;
            }
        ],
        [
            'label' => 'Paquete',
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                return $model->getPackage()->one()->nombre_paquete;
            }
        ],
        'descripcion',
        [
            'label' => 'Estado Ticket',
            'format' => 'raw',
            'contentOptions' => function ($model) {
                $estado = $model->estado_ticket; 
                if ($estado == 'En proceso') {
                    return ['style' => 'text-align: center; color:white; background-color: rgb(224, 160, 12);'];
                } elseif ($estado == 'Resuelto') {
                    return ['style' => 'text-align: center; color:white; background-color: rgb(81, 139, 231);'];
                } elseif ($estado == 'Pendiente') {
                    return ['style' => 'text-align: center; color:white; background-color: rgb(255, 99, 71); color: white;'];
                } else {
                    return ['style' => 'text-align: center;'];
                }
            },
            'value' => function ($model) {
                return $model->estado_ticket; 
            }
        ],
        [
            'label' => 'Fecha Creación',
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                return date('d/m/Y', strtotime($model->fecha_ticket));
            }
        ],
        [
            'label' => 'Acciones',
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                return Html::a('Ver Ticket', ['ticket/view', 'id' => $model->id], ['class' => 'btn btn-primary']).
                       Html::a('<i class="bx bx-pencil"></i>', ['ticket/view', 'id' => $model->id], ['class' => 'm-1 btn btn-success']);
            }
        ],
        [
            'label' => 'Chat',
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                return Html::a('<i class="bx bx-conversation" > </i>', ['cliente/chat', 'id' => $model->id], ['class' => 'btn btn-primary']);
            }
        ]
        
    ],
]);
?>
