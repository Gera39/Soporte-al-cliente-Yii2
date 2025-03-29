<?php

use app\models\SolicitudesCancelacion;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$dataProvider = new ArrayDataProvider([
    'allModels' => $paquetes,
    'pagination' => ['pageSize' => false],
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'sorter' => [
        'attributes' => ['id'],
        'defaultOrder' => ['id' => SORT_DESC],
    ],
    'columns' => [
        
        [
            'label' => 'Nombre',
            'format' => 'raw',
            'value' => 'nombre_paquete',
            'contentOptions' => function ($model) {
                return (Yii::$app->user->identity->role !== 'admin') ? ['style'=> 'text-align:center;'] : ['style' => 'text-align: center; background-color:' . ($model->estado == 'activo' ? '#d4edda' : '#f5c6cb')];
            },
            'headerOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'label' => 'Descripción',
            'value' => 'descripcion',
        ],
        [
            'attribute' => 'Precio',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'width: 10%;text-align: center;'],
            'value' => function ($model) {
                return '$' . $model->precio;
            }
        ],
        [
            'attribute' => 'Servicios',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->servicios != null) {
                    $servicios = $model->servicios;

                    $servicios = array_map(function ($servicio) {
                        return $servicio->nombre_service;
                    }, $servicios);
                    return implode(', ', $servicios);
                } else {
                    return "<span class='btn btn-danger' style='cursor:default;'>No hay servicios</span>";
                }
            }
        ],
        [
            'label' => 'Acciones',
            'format' => 'raw',
            'visible' => Yii::$app->user->identity->role === 'admin',
            'value' => function ($model) {

                $servicios = $model->servicios;

                $servicios = array_map(function ($servicio) {
                    return $servicio->id;
                }, $servicios);
                $clase = ($model->estado == 'activo') ? 'btn-success' : 'btn-danger';
                $estadoTexto = ($model && $model->estado == 'activo') ? 'Activo' : 'Bloqueado';
                return  Html::a('<i class="bx bx-pencil"></i>', '#', [
                    'class' => 'btn btn-primary btn-editar-paquete',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#myModalPaquete',
                    'data-id' => $model->id,
                    'data-nombre' => $model->nombre_paquete,
                    'data-descripcion' => $model->descripcion,
                    'data-precio' => $model->precio,
                    'data-servicios' => json_encode($servicios),
                ]) .
                    ' <a class="btn '.$clase.'" onclick="mostrarAlerta(' . $model->id . ',\'' . $estadoTexto . '\',\'paquete\')" href="#"><i class="bx bx-block"></i></a>';
            }
        ],
        [
            'label' => 'Cancelar',
            'visible' => (Yii::$app->user->identity->role === 'cliente' || Yii::$app->user->identity->role === 'operador') && $permiso === 'no' ,
            'format' => 'raw',
                'value' => function($model){
                    $id = Yii::$app->user->identity->id;
                    if(SolicitudesCancelacion::existeSolicitud($id,$model->id)){
                        return '<a href="index?r=solicitudes/index" class="btn btn-primary">Solicitud Enviada</a>';
                    }else if (SolicitudesCancelacion::existeSolicitudRechazadas($id,$model->id)) {
                        return '<a href="index?r=solicitudes/index" class="btn btn-danger">Solicitud Rechazada</a>';
                    }
                    return Html::a('Cancelar','#',[
                        'class' => 'btn btn-warning',
                        'onclick' => 'cancelacionPaquete('.$model->id.','.$id.')'
                    ]);
                }
        ],
        [
            'label' => 'Compra',
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align: center;'],
            'visible' => (Yii::$app->user->identity->role === 'cliente' || Yii::$app->user->identity->role === 'operador') && $permiso === 'comprados' ,
            'value' => function ($model) {
                $idCliente = Yii::$app->user->identity->cliente->id;
                if($model->servicios != null){
                    return Html::a('<i class="bx bx-cart"></i>', '#', [
                        'class' => 'btn btn-success',
                        'onclick' => 'mostrarCompra(' . $model->id . ', ' . $idCliente. ')',
                    ]);
                }
                return "<span class='btn btn-danger' style='cursor:default;'><i class='bx bx-cart'></i></span>";
            }
        ],
    ],
]);
?>
    <?php
    $url = Url::to(['paquete/update-paquete']);
    $script = <<<JS
        $('#myModalPaquete').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget); // Botón que abrió el modal
            let modal = $(this);

            let id = button.data('id');

            if (id) {
                // Actualización: cambiar título y llenar campos
                modal.find('.modal-title').text('Actualizar paquete');
                modal.find('#paqueteform-nombre_paquete').val(button.data('nombre'));
                modal.find('#paqueteform-descripcion').val(button.data('descripcion'));
                modal.find('#paqueteform-precio').val(button.data('precio'));
                
                var servicios = button.data('servicios'); // Asegúrate de que venga como array o JSON.parse()
                modal.find('input[name="PaqueteForm[servicios][]"]').each(function(){
                    var checkbox = $(this);
                    if (servicios.includes(parseInt(checkbox.val()))) {
                        checkbox.prop('checked', true);
                    } else {
                        checkbox.prop('checked', false);
                    }
                });
                modal.find('form').attr('action', '$url&id=' + id);
            } else {
                // Nuevo paquete: cambiar título y limpiar campos
                modal.find('.modal-title').text('Nuevo paquete');
                modal.find('#paqueteform-nombre_paquete').val('');
                modal.find('#paqueteform-descripcion').val('');
                modal.find('#paqueteform-precio').val('');
                modal.find('input[name="PaqueteForm[servicios][]"]').prop('checked', false);
            }
        });
    JS;
    $this->registerJs($script);
    ?>
