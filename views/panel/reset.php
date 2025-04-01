<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Recuperar Contraseña";
if (Yii::$app->session->hasFlash('error')) {
    echo '<div class="alert alert-danger">' . Yii::$app->session->getFlash('error') . '</div>';
    Yii::$app->session->remove('error');
}else if(Yii::$app->session->hasFlash('success')){
    echo '<div class="alert alert-success">' . Yii::$app->session->getFlash('success') . '  <a href="index.php" class="btn btn-primary m-2">Ir a login</a></div>';
    Yii::$app->session->remove('success');
}
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1><?= Html::encode($this->title) ?></h1>
          
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head d-flex justify-content-around">
                <h2><?= Html::encode('Formulario') ?></h2>
            </div>
        <?php $form= ActiveForm::begin([
            'action' => Url::to(['panel/reset-password']),
            'method' => 'post',
        ])?>
        <div class="mb-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email') ?>
        </div>
        <div class="mb-3">
            <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end();?>  
        </div>
    </div>
</main>