<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Operador $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="operador-form">

    <div>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,]) ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->input('email', ['required' => true, 'maxlength' => true]) ?>
        <?= $form->field($model, 'telefono')->input('tel', ['maxlength' => true]) ?>
    </div>

    <div>

        <?= $form->field($model, 'grado')->dropDownList([
            'Ingeniero' => 'Ingeniera',
            'Tecnico' => 'Técnico',
        ], [
            'class' => 'form-select',
            'id' => 'departamentoEmpleado',
            'prompt' => 'Selecciona un grado',
            'required' => true,
        ]) ?>
        <?= $form->field($modelOperador, 'departamento')->dropDownList([
            'Redes' => 'Redes',
            'Telecomunicaciones' => 'Telecomunicaciones',
            'Seguridad Informática' => 'Seguridad Informática',
            'Desarrollo de Software' => 'Desarrollo de Software',
            'Ciencia de Datos' => 'Ciencia de Datos',
            'Ciberseguridad' => 'Ciberseguridad',
            'Automatización y Robótica' => 'Automatización y Robótica',
        ], [
            'prompt' => 'Selecciona una carrera',
            'class' => 'form-select',
            'id' => 'carreraEmpleado',
            'required' => true,

        ]) ?>

        <?= $form->field($modelOperador, 'turno')->textInput(['maxlength' => true]) ?>
        <?php
        if ($modelOperador->dias == "") {
            $modelOperador->dias = "Vacio";
        }
        ?>
        <?= $form->field($modelOperador, 'dias')->textInput() ?>

    </div>

</div>

<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>