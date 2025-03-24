<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Perfil</h1>
        </div>
    </div>

    <i class="bx bx-user" style="font-size:150px;"></i> <!-- Tamaño 3 veces más grande -->


    <?php

    $form = ActiveForm::begin([
        'action' => ['login/actualizar-perfil'],
        'method' => 'post',
    ]);
    ?>

    <?= $form->field($modelUpdate, 'username')->textInput(['class' => 'form-control custom-input', 'value' =>  $model->nombre, 'required' => true]) ?>
    <?= $form->field($modelUpdate, 'nombre')->textInput(['class' => 'form-control custom-input', 'value' => $model->username, 'required' => true]) ?>
    <?= $form->field($modelUpdate, 'correo')->input('email', ['class' => 'form-control custom-input', 'value' => $model->email, 'required' => true]) ?>
    <?= $form->field($modelUpdate, 'telefono')->input('tel', ['class' => 'form-control custom-input', 'value' => $model->telefono, 'required' => true]) ?>
    <?= $form->field($modelUpdate, 'password')->passwordInput(['class' => 'form-control custom-input', 'value' => 'Nueva contraseña', 'required' => true]) ?>
    <div class="text-center mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary btn-sm px-3']) ?>
        <?= Html::resetButton('Cancelar', ['class' => 'btn btn-secondary btn-sm px-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

     








</main>