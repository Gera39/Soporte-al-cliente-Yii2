<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
?>
<div class="modal fade" id="myModalSeccion" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myModalLabel1">Agregar Seccion<i class="bx bx-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'seccion-form',
                'action' => ['permisos/agregar-seccion'],
                'method' => 'post',
            ]); ?>
            <div class="modal-body d-flex justify-content-around">
                <?= $form->field($model, 'nombre')->dropDownList(
                    ArrayHelper::map($secciones, 'id', 'nombre'),
                    [
                        'class' => 'form-select',
                        'id' => 'seccion',
                        'prompt' => 'Selecciona Seccion',
                        'required' => true,
                    ]
                ) ?>

                <?= $form->field($model, 'usuario_id')->hiddenInput(['value' => $id])->label(false) ?>

            </div>

            <div class="modal-footer">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']); ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>