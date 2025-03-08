<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */

$this->title = "Cliente " . $model->nombre;
?>
<main>

    <div class="head-title">
        <div class="left">
            <h1><?= Html::encode($this->title) ?></h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Administrador</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Empleados</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Apoco si ?',
                        'method' => 'post',
                    ],
                ]) ?>

            </p>

            <div class="head">
                <h2><?= Html::encode('Informacion del operador  ' . $model->nombre) ?></h2>
            </div>
                <?= $this->render('_informacion', ['model' => $model->getCliente()->one()]);?>
            <br>
            <div class="head">
                <h2><?= Html::encode('Reportes del operador  ' . $model->nombre) ?><i class='bx bx-message-square-error' style="font-size: 50px; color:red;"></i></h2>
            </div>
            <?= $this->render('_reportes', ['reportes' =>  $model->getCliente()->one()->getReporteOperadores()->all()]);?>
            <br>
            <div class="head">
                <h2><?= Html::encode('Tickets asignados a ' . $model->nombre) ?></h2>
                <?php
                $idOperador = $model->getCliente()->one()->id;
                ?>
                <button type="button" class="btn btn-danger filtro-btn" data-estado="Pendiente" data-id="<?= $idOperador ?>">
                    Pendientes
                    <span class="badge bg-red-500"><?= count($model->getCliente()->one()->getTickets()->where(['estado_ticket' => 'Pendiente'])->all()) ?></span>
                </button>
                <button type="button" class="btn btn-warning filtro-btn" data-estado="En proceso" data-id="<?= $idOperador ?>">
                    En proceso
                    <span class="badge bg-yellow-500"><?= count($model->getCliente()->one()->getTickets()->where(['estado_ticket' => 'En proceso'])->all()) ?></span>
                </button>
                <button type="button" class="btn btn-primary filtro-btn" data-estado="Resuelto" data-id="<?= $idOperador ?>">
                    Resueltos
                    <span class="badge bg-blue-500"><?= count($model->getCliente()->one()->getTickets()->where(['estado_ticket' => 'Resuelto'])->all()) ?></span>
                </button>
            </div>
           

            <!-- Contenedor para la tabla filtrada -->
            <div id="tickets-container">
                <?= $this->render('_tickets', ['tickets' => $model->getCliente()->one()->getTickets()->where(['estado_ticket' => 'Pendiente'])->all()]) ?>
            </div>

            <?php
            $ajaxUrl = Url::to(['cliente/filtrar']);
           
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