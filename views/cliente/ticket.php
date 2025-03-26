<?php

use yii\helpers\Html;
use yii\helpers\Url;

if (Yii::$app->session->hasFlash('success')) {
    $mensaje = Yii::$app->session->getFlash('success');
    echo '<div class="alert alert-success m-3" role="alert">';
    echo $mensaje;
    echo '</div>';
    Yii::$app->session->removeFlash('success');
} 
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
                    $idOperador = $cliente->id;
                    ?>
                    <button type="button" class="btn btn-danger filtro-btn" data-estado="Pendiente" data-id="<?= $idOperador ?>">
                        Pendientes
                        <span class="badge bg-red-500"><?= count($cliente->getTickets()->where(['estado_ticket' => 'Pendiente'])->all()) ?></span>
                    </button>
                    <button type="button" class="btn btn-warning filtro-btn" data-estado="En proceso" data-id="<?= $idOperador ?>">
                        En proceso
                        <span class="badge bg-yellow-500"><?= count($cliente->getTickets()->where(['estado_ticket' => 'En proceso'])->all()) ?></span>
                    </button>
                    <button type="button" class="btn btn-primary filtro-btn" data-estado="Resuelto" data-id="<?= $idOperador ?>">
                        Resueltos
                        <span class="badge bg-blue-500"><?= count($cliente->getTickets()->where(['estado_ticket' => 'Resuelto'])->all()) ?></span>
                    </button>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#myModalTicketCliente" class="btn btn-primary  p-2 "><i class='bx bx-plus'></i>Levantar tickets</a>
            </div>
            <div id="tickets-container">
            <?= $this->render('_tickets', ['tickets' => $tickets]); ?>
            </div>
        </div>
    </div>

</main>

<?= $this->render('_modal_ticket', ['ticketForm' => $ticketForm, 'categoria' => $categoria, 'paquetes' => array_filter($paquetes, function ($p) {
    return [$p->id => $p->nombre_paquete];
})]); ?>

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