<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$mensaje = "none";
if (isset($_GET["mensaje"])) {
    $mensaje = "block";
}
/* @var $model \app\models\LoginForm */

?>

<div id="error-message" class="bg-danger text-white p-3 m-2" style="border-radius:33px; display: <?= $mensaje ?>; ">Error de Contraseña o Usuario</div>

<div class="container" id="container">
    <div class="form-container sign-up">
        <?php
        ?>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'action' => ['login/register-cliente'],
            'method' => 'post',
        ]); ?>


        <h1>Crear Cuenta</h1>
        <?= $form->field($modelCreate, 'nombre')->textInput(['placeholder' => 'Nombre', 'required' => true])->label(false) ?>
        <?= $form->field($modelCreate, 'email')->textInput(['placeholder' => 'Correo o Usuario', 'required' => true])->label(false) ?>
        <?= $form->field($modelCreate, 'password')->passwordInput(['placeholder' => 'Contraseña', 'required' => true])->label(false) ?>
        <?= $form->field($modelCreate, 'telefono')->textInput(['type' => 'tel', 'placeholder' => 'Teléfono', 'required' => true])->label(false) ?>

        <div id="error-message" style="color: red; display: none;">Las contraseñas no coinciden, vuelva intentarlo</div>

        <?= Html::submitButton('Crear Cuenta', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="form-container sign-in">
        <?php $form = ActiveForm::begin([
            'id' => 'sign-in-form',
            'action' => ['login/login-custom'],
            'method' => 'post',
        ]); ?>

        <h1>Iniciar Sesion</h1>
        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Correo o Usuario', 'required' => true])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contraseña', 'required' => true])->label(false) ?>
        <?= Html::submitButton('Iniciar', ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('Olvidé mi contraseña', ['panel/reset-password'], ['class' => 'btn btn-link text-decoration-none']) ?>
        <?php ActiveForm::end(); ?>

    </div>

    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Bienvenido a CodeTrail!</h1>
                <p>Esfuerzate al maximo</p>
                <button class="hidden" id="login">Iniciar Sesion</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Hola otra vez a CodeTrail!</h1>
                <p>Lo mejor es lo simple!
                    --Jerry´s
                </p>
                <button class="hidden" id="register">Crear Cuenta</button>
            </div>
        </div>
    </div>

</div>