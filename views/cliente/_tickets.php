<?php

use app\models\MensajesTicket;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$dataProvider = new ArrayDataProvider([
    'allModels' => $tickets,
    'pagination' => ['pageSize' => false],
]);
echo GridView::widget([
    'summary' => '',
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
                $buttons = Html::a('Ver', ['ticket/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                $role = Yii::$app->user->identity->role;
                if ($role === 'cliente') {
                    if ($model->estado_ticket === 'Pendiente') {
                        $buttons .= Html::a('Cerrar', '#', [
                            'class' => 'btn btn-danger m-2',
                            'onclick' => 'mostrarAlertaTicket(' . $model->id . ')'
                        ]);
                        $buttons .= Html::a('<i class="bx bx-pencil"></i>', '#', [
                            'class' => 'btn btn-success m-2 btn-editar-paquete',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#myModalTicketCliente',
                            'data-id_categoria' => $model->id_categoria,
                            'data-prioridad' => $model->prioridad,
                            'data-descripcion' => $model->descripcion,
                            'data-id_paquete' => $model->id_package,
                        ]);
                    }
                } elseif ($role === 'operador') {
                    if ($model->estado_ticket === 'En proceso') {
                        $buttons .= Html::a('Cerrar', '#', [
                            'class' => 'btn btn-danger m-2',
                            'onclick' => 'openSweetAlert(' . $model->id . ')',
                        ]);
                    }
                }
                return $buttons;
            }
        ],
        [
            'label' => 'Chat',
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                $user = Yii::$app->user->identity;
                $idUser = $user->id;
                $rol = $user->role;

                $count = MensajesTicket::find()
                    ->where(['id_ticket' => $model->id, 'leido' => 0])
                    ->andWhere(['!=', 'id_remitente' , Yii::$app->user->identity->id])
                    ->count();

                return Html::a(
                    '<div style="position: relative; display: inline-block;">
                        <i class="bx bx-conversation" style="font-size: 1.5em;"></i>
                        ' . ($count > 0 ? '<span class="badge-notification ">' . $count . '</span>' : '') . '
                    </div>',
                    ['chat/mostrar-chat', 'id' => $model->id, 'rol' => $rol, 'idUser' => $idUser],
                    [
                        'class' => 'btn btn-primary',
                        'style' => 'position: relative; padding: 5px 10px;'
                    ]
                );
            }
        ]

    ],
]);
?>


<?php
$url = Url::to(['ticket/update-ticket']);

$script = <<<JS
    $('#myModalTicketCliente').on('show.bs.modal', function(event){
    let button = $(event.relatedTarget); // Botón que abrió el modal
    let modal = $(this);

    let id = button.data('id_categoria');
    if(id){
        modal.find('.modal-title').text('Actualizar Ticket JAJAJAAJ');
        modal.find('input[name="TicketForm[id_categoria]"][value="' + button.data('id_categoria') + '"]').prop('checked', true);
        modal.find('input[name="TicketForm[prioridad]"][value="' + button.data('prioridad') + '"]').prop('checked', true);
        modal.find('#ticketform-descripcion').val(button.data('descripcion'));
        modal.find('#ticketform-id_paquete').val(button.data('id_paquete'));
        modal.find('#ticket-archivo').closest('.form-group').hide();                 
        modal.find('form').attr('action', '$url?id=' + id);// Asignar acción al formulario dentro del modal
    } else {
        modal.find('.modal-title').text('Crear Nuevo Ticket');
        modal.find('input[name="TicketForm[id_categoria]"]').prop('checked', false);
        modal.find('input[name="TicketForm[prioridad]"]').prop('checked', false);
        modal.find('#ticketform-descripcion').val('');
        modal.find('#ticketform-id_paquete').val('');
        modal.find('#ticket-archivo').closest('.form-group').show();
    }
});


JS;
$this->registerJs($script);
?>