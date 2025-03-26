<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="modal fade" id="myModalAsistencia" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myModalLabel">Motivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'asistencia-form',
                'action' => Url::to(['asistencia/motivo-asistencia','id'=> $id]),
                'method' => 'post',
            ]); ?>

            <div class="modal-body">
                <div class="mb-3 d-flex justify-content-around">
                <div class="mb-3">
                    <?= $form->field($asistencia, 'comentarios')->textarea([
                        'rows' => 6,
                        'class' => 'form-control',
                        'style' => 'font-size:20px;',
                    ])->label('Movito', ['class' => 'form-label text-dark', 'style' => "font-size:24px;"]) ?>
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