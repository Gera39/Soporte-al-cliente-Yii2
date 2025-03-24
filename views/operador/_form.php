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
        <h4>Información del Empleado(no modificable)</h4>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'email')->input('email', ['required' => true, 'maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'telefono')->input('tel', ['maxlength' => true, 'readonly' => true]) ?>
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

        <?= $form->field($modelOperador, 'turno')->dropDownList([
            '1' => '06:00-14:00',
            '2' => '14:00-22:00',
            '3' => '22:00-06:00',
        ], [
            'prompt' => 'Selecciona un turno',
            'class' => 'form-select',
            'required' => true,
        ]) ?>
        <?php
        if ($modelOperador->dias == "") {
            $modelOperador->dias = "Vacio";
        }
        ?>
        <?= $form->field($modelOperador, 'dias')->checkboxList([
            'Lunes' => 'Lunes',
            'Martes' => 'Martes',
            'Miércoles' => 'Miércoles',
            'Jueves' => 'Jueves',
            'Viernes' => 'Viernes',
            'Sábado' => 'Sábado',
            'Domingo' => 'Domingo',
        ], [
            'item' => function ($index, $label, $name, $checked, $value) {
            return Html::checkbox($name, $checked, [
                'value' => $value,
                'label' => Html::encode($label),
            ]);
            },
        ]) ?>

    </div>

</div>

<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>