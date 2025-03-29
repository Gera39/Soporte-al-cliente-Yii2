<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Solicitudes de cancelacion";

if(Yii::$app->session->hasFlash('success'))
{
    echo '<span class="alert alert-success m-5">'.Yii::$app->session->getFlash('success').'</span>';
    Yii::$app->session->removeFlash('success');
}else if(Yii::$app->session->hasFlash('error')){
    echo '<span class="alert alert-error">'.Yii::$app->session->getFlash('error').'</span>';
    Yii::$app->session->removeFlash('error');
}
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1><?= Html::encode($this->title) ?></h1>

        </div>
    </div>
    <ul class="box-info">
        <li>
            <a href="<?= Url::to(['solicitudes/index']) ?>">
                <i class='bx bx-paper-plane'></i>
            </a>
            <span class="text d-flex align-items-center">
                <h3 class="m-3">Todos</h3>
            </span>
        </li>
        <li>
            <button class="filtro-btn" data-estado='Pendiente'>
                <i class='bx bx-time'></i>
            </button>
            <span class="text">
                <h3>Pendientes</h3>
            </span>
        </li>
        <li>
            <button class="filtro-btn" data-estado='Rechazado'>
                <i class='bx bxs-bell-minus'></i>
            </button>
            <span class="text">
                <h3>Rechazados</h3>
            </span>
        </li>
        <li>
            <button class="filtro-btn" data-estado='Aprobado'>
                <i class='bx bxs-bell-plus'></i>
            </button>
            <span class="text">
                <h3>Aprobados</h3>
            </span>
        </li>


    </ul>

    <div class="table-data">
        <div class="order">

            <div class="head d-flex justify-content-around">
                <h2><?= Html::encode('Solicitudes') ?></h2>
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'id' => 'search-pq',
                    'action' => ['solicitudes/index'], // Asegúrate de que el controlador sea correcto
                ]); ?>
                <div class="d-flex justify-content-around">
                    <?= Html::textInput('search', $search, ['placeholder' => 'Buscar Paquete', 'class' => 'form-control']) ?>
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div id="solicitudes-container">
                <?= $this->render('_cancelaciones', ['solicitudes' => $solicitudes]); ?>
            </div>
        </div>
    </div>
</main>


<?php
$ajaxUrl = Url::to(['solicitudes/filtrar']);
$script = <<<JS
 $(document).on('click', '.filtro-btn', function() {
            let estado = $(this).data('estado');
            $.ajax({
                url: '$ajaxUrl',
                type: 'GET',
                data: { estado: estado},
                success: function(response) {
                    $('#solicitudes-container').html(response);
                },
                error: function() {
                    alert('Error al filtrar los tickets.');
                }
            });
        });
JS;


$this->registerJs($script);


?>