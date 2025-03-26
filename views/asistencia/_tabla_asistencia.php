<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $asistencias,
        'pagination' => false
    ]),
    'summary' => false,
    'columns' => [
        [
            'label' => 'Operador',
            'value' => function ($model) {
                return $model->operador->usuario->nombre;
            }
        ],
        [
            'label' => 'Hora entrada',
            'value' => function ($model) {
                $dateTime = new DateTime($model->hora_entrada);
               return $dateTime->format('H:i');

            },
        ],
        [
            'label' => 'Entrada',
            'format' => 'raw',
            'contentOptions' => function($model){
                if($model->estado === 'Retardo'){
                    return ['style' => 'background-color:#ff704B; text-align:center;'];
                }else{
                    return ['style' => 'background-color:#4db5ff; text-align:center;'];
                }
            },
            'value' => 'estado',
        ],
        [
            'label' => 'Estado Operador',
            'format' => 'raw',
            'contentOptions' => function($model){
                if($model->estado === 'Trabajando'){
                    return ['style' => 'background-color:#ff704B; text-align:center;'];
                }else{
                    return ['style' => 'background-color:#4db5ff; text-align:center;'];
                }
            },
            'value' => 'estatus_trabajo',
        ],
        [
            'label' => 'Motivo de retardo',
            'value' => function($model){return (($model->comentarios === null) ? 'No hay motivos' : $model->comentarios);}
        ],
        [
            'label' => 'Hora Salida',
            'value' => function($model){
               return  ($model->hora_salida === null?'No registro salida': $model->hora_salida); 
            }
        ],
    ],
]);
