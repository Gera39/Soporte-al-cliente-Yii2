<?php
use yii\widgets\DetailView;
use yii\helpers\Html;



echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Operador',
            'value' => function($model){
                return $model->operador->usuario->username;
            },
        ],
        [
            'label' => 'Cliente',
            'value' => function($model){
                return $model->cliente->usuario->username;
            },
        ],
        [
            'label' => 'Categoria',
            'value' => $model->getCategoria()->one()->name,
        ],
        [
            'label' => 'Paquete',
            'value' => $model->getPackage()->one()->nombre_paquete,
        ],
        'prioridad',    
        'estado_ticket',
        'descripcion:ntext',
        [
            'label' => 'fecha de creación',
            'value' => date('d/m/Y', strtotime($model->fecha_ticket)),  
        ],
        [
            'label' => 'Hora de creación',
            'value' => date('H:i', strtotime($model->fecha_ticket)) . ' horas',
        ],
        [
            'label' => 'fecha de resolución',
            'value' => ($model->fecha_resolucion) ? $model->fecha_resolucion : 'No resuelto',
        ],
        [
            'label' => 'Archivo',
            'format' => 'raw',
            'value' => function ($model) {
                $url = Yii::getAlias('@web/uploads/');
                $nombreArchivo = ($model->getArchivosAdjuntos()->one()) ? $model->getArchivosAdjuntos()->one()->nombre_archivo : null;
                if (isset($nombreArchivo)) {
                    return Html::a(
                        Html::img($url.$nombreArchivo, [
                            'style' => 'width:100px;',
                            'onerror' => "this.onerror=null;this.outerHTML='<a href=\"$url$nombreArchivo\" target=\"_blank\">Ver archivo adjunto</a>';"
                        ]),
                        $url.$nombreArchivo,
                        ['target' => '_blank']
                    );
                } else {
                    return 'No hay archivo adjunto';
                }
            }
        ]
    ],
]);
?>