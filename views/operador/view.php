<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */

$this->title = "Operador " . $model->nombre;
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </p>

            <div class="head">
                <h2><?= Html::encode('Informacion del operador  ' . $model->nombre) ?></h2>
            </div>
                <?= $this->render('/tables/_informacion', ['model' => $model->getOperadores()->one()]);?>
            <br>
            <div class="head">
                <h2><?= Html::encode('Reportes del operador  ' . $model->nombre) ?><i class='bx bx-message-square-error' style="font-size: 50px; color:red;"></i></h2>
            </div>
            <?= $this->render('/tables/_reportes', ['reportes' =>  $model->getOperadores()->one()->getReporteOperadores()->where(['!=','id_remitente',$model->getOperadores()->one()->id])->all()]);?>
            <br>
            <br>
            <br>
            <div class="head">
                <h2><?= Html::encode('Tickets asignados a ' . $model->nombre) ?></h2>
                <?php
                $idOperador = $model->getOperadores()->one()->id;
                ?>
                <button type="button" class="btn btn-danger filtro-btn" data-estado="Pendiente" data-id="<?= $idOperador ?>">
                    Pendientes
                    <span class="badge bg-red-500"><?= count($model->getOperadores()->one()->getTickets()->where(['estado_ticket' => 'Pendiente'])->all()) ?></span>
                </button>
                <button type="button" class="btn btn-warning filtro-btn" data-estado="En proceso" data-id="<?= $idOperador ?>">
                    En proceso
                    <span class="badge bg-yellow-500"><?= count($model->getOperadores()->one()->getTickets()->where(['estado_ticket' => 'En proceso'])->all()) ?></span>
                </button>
                <button type="button" class="btn btn-primary filtro-btn" data-estado="Resuelto" data-id="<?= $idOperador ?>">
                    Resueltos
                    <span class="badge bg-blue-500"><?= count($model->getOperadores()->one()->getTickets()->where(['estado_ticket' => 'Resuelto'])->all()) ?></span>
                </button>
            </div>

            <!-- Contenedor para la tabla filtrada -->
            <div id="tickets-container">
                <?= $this->render('/tables/_tickets', ['tickets' => $model->getOperadores()->one()->getTickets()->where(['estado_ticket' => 'Pendiente'])->all()]) ?>
            </div>

            <?php
            $ajaxUrl = Url::to(['operador/filtrar']);
            $script = <<<JS
            $(document).on('click', '.filtro-btn', function() {
            let estado = $(this).data('estado');
            let id = $(this).data('id');
            
            $.ajax({
                url: '$ajaxUrl',
                type: 'GET',
                data: { estado: estado, idOperador: id },
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
        </div>
    </div>
</main>