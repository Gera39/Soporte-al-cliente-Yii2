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
        ['class' => 'yii\grid\SerialColumn'],
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
        'fecha_ticket',
        
    ],
]);
?>
