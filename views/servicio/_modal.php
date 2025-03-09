<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="modal fade" id="myModalServicio<?= $id ?>" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myModalLabel">Agregar Servicio <i class="bx bx-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'servicio-form' .$id,
                    'action' => array_merge(['servicio/' . $direccion], ($direccion === 'update') ? ['id' => $id] : []),
                    'method' => 'post',
                ]); ?>

                <div class="mb-3">
                    <?= $form->field($servicioForm, 'nombre_service')->textInput([
                        'class' => 'form-control bostra',
                        'id' => 'nombreServicio'.$id,
                        'required' => true
                    ])
                    ?>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>