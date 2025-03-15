<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="modal fade" id="myModalTicketCliente" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myModalLabel">Levantar Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'ticket-form',
                'action' => Url::to(['ticket/levantar-ticket']),
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data'] // Permitir subida de archivos
            ]); ?>

            <div class="modal-body">
                <div class="mb-3 d-flex justify-content-around">
                    <?= $form->field($ticketForm, 'id_categoria')->radioList(
                        ArrayHelper::map($categoria, 'id', 'name'),
                        [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '<div class="form-check">' .
                                    Html::radio($name, $checked, [
                                        'value' => $value,
                                        'class' => 'form-check-input',
                                        'id' => 'categoria-' . $index,
                                    ]) .
                                    Html::label($label, 'categoria-' . $index, ['class' => 'form-check-label', 'style' => 'font-size:20px;']) .
                                    '</div>';
                            },
                            'class' => 'form-control',
                            'style' => 'border:none;',
                        ]
                    )->label('Categorías', ['class' => 'form-label text-dark', 'style' => "font-size:24px;"]) ?>

                    <?= $form->field($ticketForm, 'prioridad')->radioList(
                        [
                            'Baja' => 'Baja',
                            'Media' => 'Media',
                            'Alta' => 'Alta'
                        ],
                        [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '<div class="form-check">' .
                                    Html::radio($name, $checked, [
                                        'value' => $value,
                                        'class' => 'form-check-input',
                                        'id' => 'prioridad-' . $index,
                                    ]) .
                                    Html::label($label, 'prioridad-' . $index, ['class' => 'form-check-label', 'style' => "font-size:20px;"]) .
                                    '</div>';
                            },
                            'class' => 'form-control',
                            'style' => 'border:none; ',
                        ]
                    )->label('Prioridad', ['class' => 'form-label text-dark', 'style' => "font-size:24px;"]) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($ticketForm, 'id_paquete')->dropDownList(
                        ArrayHelper::map($paquetes, 'id', 'nombre_paquete'),
                        [
                            'prompt' => 'Seleccione un paquete',
                            'class' => 'form-control',
                        ]
                    )->label('Paquetes Contratados', [
                        'class' => 'form-label text-dark',
                        'style' => 'font-size:24px;'
                    ]) ?>

                    <?= $form->field($ticketForm, 'descripcion')->textarea([
                        'rows' => 6,
                        'class' => 'form-control',
                        'style' => 'font-size:20px;',
                    ])->label('Descripción', ['class' => 'form-label text-dark', 'style' => "font-size:24px;"]) ?>
                </div>

                <div class="mb-3">
                    <label class="form-label text-dark" style="font-size:24px;">Adjuntar Archivo (no obligatorio)</label>
                        <?= $form->field($ticketForm, 'nombre_archivo')->fileInput([
                            'id' => 'ticket-archivo',
                        ])->label(false)?>
                </div>

            </div>

            <div class="modal-footer">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>