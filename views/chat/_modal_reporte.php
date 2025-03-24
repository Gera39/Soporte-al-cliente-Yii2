<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="modal fade" id="myModalReporte" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myModalLabel">Levantar Reporte al Operador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'reporte-form',
                    'action' => ['reporte/guardar'],
                    'method' => 'post',
                ]); ?>
                <div class="mb-3 text-center">
                    <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                        <i class='bx bxs-error-circle bx-lg me-2'></i>
                        <strong class="fs-4">ADVERTENCIA</strong>
                    </div>
                    <p class="mt-3 text-muted">
                        Al levantar un reporte, el administrador será notificado y se tomarán las medidas necesarias para resolver el problema.
                    </p>
                    <p class="mt-3 text-muted">
                        Le recomendamos que sea lo más específico posible en la descripción del problema y que levante otro ticket si es necesario.
                    </p>
                </div>
                <div class="mb-3">
                    <?= $form->field($reporteForm, 'nombre_reporte')->dropDownList([
                        'grosero' => 'Groser@',
                        'Responde lento' => 'Responde lento',
                        'Solo me deja en visto' => 'Solo me deja en visto',
                        'No sabe sobre el problema' => 'No sabe sobre el problema',
                        'otros' => 'Otros'
                    ], [
                        'class' => 'form-control',
                        'id' => 'nombreReporte',
                        'prompt' => 'Seleccione un problema',
                        'required' => true
                    ])->label('Tipo de Problema', ['class' => 'form-label text-dark']) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($reporteForm, 'descripcion')->textarea([
                        'class' => 'form-control',
                        'id' => 'descripcionReporte',
                        'required' => true,
                        'rows' => 4
                    ])->label('Explicacion', ['class' => 'form-label text-dark']) ?>
                </div>

                <?= $form->field($reporteForm, 'id_ticket')->hiddenInput(['value' => $id_ticket])->label(false) ?>
                <?= $form->field($reporteForm, 'id_cliente')->hiddenInput(['value' => $id_cliente])->label(false) ?>
                <?= $form->field($reporteForm, 'id_operador')->hiddenInput(['value' => $id_operador])->label(false) ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>