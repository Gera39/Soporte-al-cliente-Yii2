<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Recuperar Contraseña";
?>

<main>

    <div class="head-title ">
        <div class="left mb-5 text-center">
            <h1><?= Html::encode($this->title) ?></h1>
            <h3>Responda Correctamente las siguientes preguntas</h3>
            <div class="alert alert-warning text-center" role="alert">
                <h3><i class="bx bxs-error"></i>ADVERTENCIA</h3>
                <p>Por favor, responda correctamente.</p>
            </div>
        </div>
    </div>

    <div class="table-data">
        <?php Yii::$app->session->set('id', $id); ?>
        <div class="order">
            <div class="head d-flex justify-content-around">
            </div>
            <?php $form = ActiveForm::begin([
                'action' => Url::to(['pregunta/recover-password']),
                'method' => 'post',
            ]) ?>


            <div class="mb-3">
                <h4><?= Html::encode($model->pregunta1) ?></h4>
            </div>
            <div class="mb-3">
                <?= $form->field($model, 'respuesta1')->textInput(['maxlength' => true])->label('Respuesta') ?>
            </div>
            <div class="mb-3">
                <h4><?= Html::encode($model->pregunta2) ?></h4>
            </div>
            <div class="mb-3">
                <?= $form->field($model, 'respuesta2')->textInput(['maxlength' => true])->label('Respuesta') ?>
            </div>
            <div class="mb-3">
                <h4><?= Html::encode($model->pregunta3) ?></h4>
            </div>
            <div class="mb-3">
                <?= $form->field($model, 'respuesta3')->textInput(['maxlength' => true])->label('Respuesta') ?>
            </div>
            <div class="mb-3">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</main>