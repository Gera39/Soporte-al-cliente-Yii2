<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


?>

<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Cambiar Contraseña: <?= $model->nombre ?></h1>
        </div>
        <?php
        if (Yii::$app->session->hasFlash('error')) {
            echo '<div class="alert alert-danger m-5" role="alert">';
            echo Yii::$app->session->getFlash('error');
            echo '</div>';
            Yii::$app->session->removeFlash('error');
        }elseif(Yii::$app->session->hasFlash('success')){
            echo '<div class="alert alert-success m-5" role="alert">';
            echo Yii::$app->session->getFlash('success');
            echo '</div>';
            Yii::$app->session->removeFlash('success');
        }
        ?>
    </div>
    <i class="bx bx-key" style="font-size:150px;"></i>
    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <label>Contraseña Actual</label>
        <input type="password" name="current_password" class="form-control" required>
    </div>
    <?= $form->field($model, 'password')->passwordInput(['required' => true,'value' => '']) ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary m-4']) ?>
        <?= Html::a('Cancelar', ['perfil'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</main>