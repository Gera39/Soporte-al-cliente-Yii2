<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = "Preguntas de Seguridad";
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1><?= Html::encode($this->title) ?></h1>
            <h3>Responda Correctamente las siguientes preguntas</h3>
        </div>
    </div>
    <?php Yii::$app->session->set('id_usuario',$id);?>
    <div class="table-data">
        <div class="order">
            <div class="head d-flex justify-content-around">
            </div>
        <?php $form= ActiveForm::begin([
            'action' => Url::to(['pregunta/crear-preguntas']),
            'method' => 'post',
        ])?>

        <div class="mb-3">
            <?= $form->field($model, 'pregunta1')->dropDownList([
                '¿Cuál es el nombre de tu primera mascota?' => '¿Cuál es el nombre de tu primera mascota?',
                '¿Cuál es tu comida favorita?' => '¿Cuál es tu comida favorita?',
                '¿En qué ciudad naciste?' => '¿En qué ciudad naciste?',
            ], ['prompt' => 'Seleccione una pregunta'])->label('Pregunta 1') ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'respuesta1')->textInput(['maxlength' => true])->label('Respuesta') ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'pregunta2')->dropDownList([
                '¿Cuál es el nombre de tu escuela primaria?' => '¿Cuál es el nombre de tu escuela primaria?',
                '¿Cuál es tu película favorita?' => '¿Cuál es tu película favorita?',
                '¿Cuál es el nombre de tu mejor amigo de la infancia?' => '¿Cuál es el nombre de tu mejor amigo de la infancia?',
            ], ['prompt' => 'Seleccione una pregunta'])->label('Pregunta 2') ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'respuesta2')->textInput(['maxlength' => true])->label('Respuesta') ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'pregunta3')->dropDownList([
                '¿Cuál es tu deporte favorito?' => '¿Cuál es tu deporte favorito?',
                '¿Cuál es el nombre de tu primer maestro?' => '¿Cuál es el nombre de tu primer maestro?',
                '¿Cuál es tu libro favorito?' => '¿Cuál es tu libro favorito?',
            ], ['prompt' => 'Seleccione una pregunta'])->label('Pregunta 3') ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'respuesta3')->textInput(['maxlength' => true])->label('Respuesta') ?>
        </div>
        <div class="mb-3">
            <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end();?>  
        </div>
    </div>
</main>