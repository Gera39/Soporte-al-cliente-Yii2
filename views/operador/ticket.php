<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
                <div>
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
            </div>
            <div id="tickets-container">
                <?= $this->render('/cliente/_tickets', ['tickets' => $tickets]); ?>
            </div>
        </div>
    </div>
</main>
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