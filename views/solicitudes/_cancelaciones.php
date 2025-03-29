<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $solicitudes,
        'pagination' => false
    ]),
    'summary' => false,
    'columns' => [
        'id',
        [
            'label' => 'Paquete',
            'value' => function($model){
                return $model->paquete->nombre_paquete;
            }
        ],
        [
            'label' => 'Usuario',
            'visible' => Yii::$app->user->identity->role === 'admin',
            'value' => function($model){
                return $model->usuario->username;
            }
        ],
        'fecha_solicitud',
        [
            'label' => 'Estado',
            'format' => 'raw',
            'contentOptions' => function($model) {
                $style = 'font-weight: 600; text-align-center padding: 4px 8px;';
                
                switch($model->estado_solicitud) {
                    case 'Pendiente':
                        return ['style' => $style . 'background-color: #FFA500; color: #FFF;']; // Naranja
                    case 'Rechazado':
                        return ['style' => $style . 'background-color: #FF3333; color: #FFF;']; // Rojo
                    case 'Aprobado':
                        return ['style' => $style . 'background-color: #3366FF; color: #FFF;']; // Azul
                    default:
                        return ['style' => $style . 'background-color: #EEE;'];
                }
            },
            'value' => function($model) {
                $icon = '';
                switch($model->estado_solicitud) {
                    case 'Pendiente':
                        $icon = '<i class="bx bx-time" style="font-size:20px; margin-right:5px"></i>';
                        break;
                    case 'Rechazado':
                        $icon = '<i class="bx bx-x-circle" style="font-size:20px; margin-right:5px"></i>';
                        break;
                    case 'Aprobado':
                        $icon = '<i class="bx bx-check-circle" style="font-size:20px;  margin-right:5px"></i>';
                        break;
                }
                
                return Html::tag('span', $icon . $model->estado_solicitud, [
                    'class' => 'estado-badge',
                    'style' => 'display: inline-flex; align-items: center;'
                ]);
            }
        ],
        'razon_cancelacion',
        [
            'label' => 'Razon Respuesta',
            'value' => function($model) {
                return $model->razon_respuesta ?? 'Esperando razón';
            }
        ],
        [
            'label' => 'Fecha Resolucion',
            'value' => function($model) {
                return $model->fecha_resolucion ?? 'No hay fecha';
            }
        ],
        [
            'label' => 'Acciones',
            'format' => 'raw',
            'value' => function($model) {
                if($model->estado_solicitud !== 'Pendiente'){
                    return '<span class="alert alert-success">No disponible</span>';
                } else {
                    return Html::a('Cerrar Solicitud', ['solicitudes/delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                    ]);
                }
            }
        ]
    ]

]);

?>