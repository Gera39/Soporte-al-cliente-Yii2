<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="modal fade" id="myModalPaquete" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myModalLabel1">Crear nuevo paquete<i class="bx bx-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'paquete-form',
                    'action' => ['paquete/guardar-paquete'],
                    'method' => 'post',
                ]); ?>
            <div class="modal-body d-flex justify-content-around">
                <div>
                    <div class="mb-3">
                        <?= $form->field($paqueteForm, 'nombre_paquete')->textInput() ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($paqueteForm, 'precio')->input('number') ?>
                    </div>
                    <div class="mb-3">
                        <?= $form->field($paqueteForm, 'descripcion')->textarea(['class' => 'form-control']) ?>
                    </div>
                </div>
                <div>
                    <div class="mb-3">
                        <?= $form->field($paqueteForm, 'servicios')->checkboxList($servicios, [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '<div class="form-check">' .
                                    Html::checkbox($name, $checked, [
                                        'value' => $value,
                                        'class' => 'form-check-input',
                                        'id' => 'servicio-' . $index
                                    ]) .
                                    Html::label($label, 'servicio-' . $index, ['class' => 'form-check-label']) .
                                    '</div>';
                            }
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']); ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>