<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

/* @var $model \app\models\LoginForm */
?>
    
    <div id="error-message" class="bg-danger text-white p-3" style="border-radius:33px; display: block; ">Holaaa</div>

    <div class="container" id="container">
        <div class="form-container sign-up">
        <?php
        ?>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'action' => ['login/login-custom'],
            'method' => 'post',
        ]); ?>

        <h1>Crear Cuenta</h1>
        <div class="social-icons">
            <?= Html::a('<i class="fa-brands fa-google"></i>', '#', ['class' => 'icon']) ?>
        </div>
        <span>o crea el registro</span>
        <?= $form->field($model, 'nombre')->textInput(['placeholder' => 'Nombre', 'required' => true])->label(false) ?>
        <?= $form->field($model, 'apellido')->textInput(['placeholder' => 'Apellido', 'required' => true])->label(false) ?>
        <?= $form->field($model, 'correo')->input('email', ['placeholder' => 'Correo', 'required' => true])->label(false) ?>
        <?= $form->field($model, 'telefono')->input('tel', ['placeholder' => 'Telefono', 'required' => true])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'required' => true])->label(false) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Confirmar Password', 'required' => true])->label(false) ?>
        <?= $form->field($model, 'rol')->hiddenInput(['value' => 'c'])->label(false) ?>

     
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
            <div class="social-icons">
                <?= Html::a('<i class="fa-brands fa-google"></i>', '#', ['class' => 'icon']) ?>
            </div>
            <span>o iniciar por usuario y contraseña</span>

            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Correo o Usuario', 'required' => true])->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contraseña', 'required' => true])->label(false) ?>

            <?= Html::submitButton('Iniciar', ['class' => 'btn btn-primary']) ?>

            <?php ActiveForm::end(); ?>

        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bienvenido a CodeTrail!</h1>
                    <p>El que sirve mejor es el que más se beneficia</p>
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

