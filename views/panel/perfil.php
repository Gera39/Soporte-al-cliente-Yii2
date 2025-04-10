<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

if (Yii::$app->session->hasFlash('error')) {
    echo '<div class="alert alert-danger m-5" role="alert">';
    echo Yii::$app->session->getFlash('error');
    echo '</div>';
    Yii::$app->session->removeFlash('error');
}
?>

<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Perfil</h1>
        </div>
        <?php if(Yii::$app->user->identity->role === 'operador'):?>
        <div class="m-5">
            <h3>Calificaciones</h3>
            <?php
            $calificaciones = \app\models\EvaluacionesServicio::find()->where(['id_operador' => Yii::$app->user->identity->operadores->id])->all();
            $totalCalificaciones = count($calificaciones);
            $sumaCalificaciones = array_sum(array_column($calificaciones, 'calificacion'));
            $promedio = $totalCalificaciones > 0 ? $sumaCalificaciones / $totalCalificaciones : 0;
            ?>
            <p>Total de calificaciones: <?= $totalCalificaciones ?></p>
            <p>Promedio: <?= number_format($promedio, 2) ?></p>
            <div>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="bx <?= $i <= round($promedio) ? 'bxs-star' : 'bx-star' ?>" style="color: gold;"></i>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif;?>
    </div>

    <i class="bx bx-user" style="font-size:150px;"></i> <!-- Tamaño 3 veces más grande -->
  
    
    <?php

    $form = ActiveForm::begin([
        'action' => ['user/update', 'id' => $model->id],
        'method' => 'post',
    ]);
    ?>
    <a class="btn btn-success" href="<?= Url::to(['panel/cambiar-pass']);?>">Cambiar contraseña</a>

    <?= $form->field($model, 'username')->textInput(['class' => 'form-control custom-input', 'required' => true]) ?>
    <?= $form->field($model, 'nombre')->textInput(['class' => 'form-control custom-input', 'required' => true]) ?>
    <?= $form->field($model, 'email')->input('email', ['class' => 'form-control custom-input', 'required' => true]) ?>
    <?= $form->field($model, 'telefono')->input('tel', ['class' => 'form-control custom-input', 'required' => true])->label('Teléfono') ?>
   
    <div class="text-center mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary btn-sm px-3']) ?>
        <?= Html::resetButton('Cancelar', ['class' => 'btn btn-secondary btn-sm px-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</main>

