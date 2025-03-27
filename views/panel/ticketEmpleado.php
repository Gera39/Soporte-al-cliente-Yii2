<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Tickets;
?>

<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Tickets</h1>

        </div>

    </div>


    <div class="table-data">


        <div class="todo">
            <div class="head d-flex justify-content-between">
                <h2><?= Html::encode('Tickets') ?></h2>
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['panel/tickets-empleado'], // Asegúrate de que el controlador sea correcto
                ]); ?>
                <div class="d-flex justify-content-around">
                    <?= Html::textInput('search', $search, ['placeholder' => 'Buscar Operador', 'class' => 'form-control']) ?>
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['panel/tickets-empleado'], // Asegúrate de que el controlador sea correcto
                ]); ?>
                <div class="d-flex justify-content-around">
                    <?= Html::textInput('searchCliente', $search, ['placeholder' => 'Buscar Cliente', 'class' => 'form-control']) ?>
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                <div>
                    <button type="button" class="btn btn-danger filtro-btn" data-estado="Pendiente">
                        Pendientes
                        <span class="badge bg-red-500"><?= count(Tickets::find()->where(['estado_ticket' => 'Pendiente'])->all()) ?></span>
                    </button>
                    <button type="button" class="btn btn-warning filtro-btn" data-estado="En proceso">
                        En proceso
                        <span class="badge bg-yellow-500"><?= count(Tickets::find()->where(['estado_ticket' => 'En proceso'])->all()) ?></span>
                    </button>
                    <button type="button" class="btn btn-primary filtro-btn" data-estado="Resuelto">
                        Resueltos
                        <span class="badge bg-blue-500"><?= count(Tickets::find()->where(['estado_ticket' => 'Resuelto'])->all()) ?></span>
                    </button>
                </div>
            </div>
            <div id="tickets-container">
                <?= $this->render('/cliente/_tickets', ['tickets' => $tickets]); ?>
            </div>
        </div>
    </div>

</main>
<?php
$ajaxUrl = Url::to(['panel/filtrar']);
$script = <<<JS
            $(document).on('click', '.filtro-btn', function() {
            let estado = $(this).data('estado');
            $.ajax({
                url: '$ajaxUrl',
                type: 'GET',
                data: { estado: estado },
                success: function(response) {
                    $('#tickets-container').html(response);
                },
                error: function() {
                    alert('Error al filtrar los tickets.');
                }
            });
        });
JS;

$this->registerJs($script);
?>