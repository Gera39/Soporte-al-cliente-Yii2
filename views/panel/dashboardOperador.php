<?php

use yii\helpers\Url;
use yii\helpers\Html;

$operador = $model->operadores;
$ticketsProceso = $operador->getTickets()->where(['estado_ticket' => 'En proceso'])->count();
$ticketsPendiente = $operador->getTickets()->where(['estado_ticket' => 'Pendiente'])->count();
$ticket = max($ticketsPendiente, $ticketsProceso);
$modal = false;
$todo = true;
$id = isset($id) ? $id : 0;
if(Yii::$app->session->hasFlash('id_asistencia')){
    $id = Yii::$app->session->getFlash('id_asistencia');
    Yii::$app->session->setFlash('id_asistencia',$id);
}
$url = Url::to(['asistencia/registro-asistencia']);
if (Yii::$app->session->hasFlash('mensaje')) {
    $mensaje = Yii::$app->session->getFlash('mensaje');
    echo '<div class="alert alert-success m-5" role="alert">';
    echo $mensaje;
    echo '</div>';
    Yii::$app->session->removeFlash('mensaje');
} else if (Yii::$app->session->hasFlash('mensaje-tarde')) {
    $mensaje = Yii::$app->session->getFlash('mensaje-tarde');
    echo '<div class="alert alert-danger m-5" role="alert">';
    echo $mensaje;
    echo '</div>';
    Yii::$app->session->removeFlash('mensaje-tarde');
    $modal = true;
}
else if (Yii::$app->session->hasFlash('mensaje-salida')) {
    $mensaje = Yii::$app->session->getFlash('mensaje-salida');
    echo '<div class="alert alert-success m-5" role="alert">';
    echo $mensaje;
    echo '</div>';
    Yii::$app->session->removeFlash('mensaje-salida');
    $url = Url::to(['asistencia/registrar-salida']);
}
?>

<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Vista Rapida</h1>
        </div>

        <?php if ($todo): ?>
            <?php if ($modal): ?>
                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModalAsistencia">
                    Motivo
                </a>
            <?php else: ?>
                <a href="<?= $url ?>" class="btn btn-primary"><?= (($id<=0) ? 'Registrar Asistencia' :'Registrar Salida')?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center">
                <h3 class="m-3">Horario y Dias de Trabajo</h3>
            </span>
        </li>
        <li>
            <i class='bx bx-time-five'></i>
            <span class="text">
                <h3><?= $operador->turno !== '' ? $operador->turno : 'No hay horario asginado' ?></h3>
                <p>Hora entrada y salida</p>
            </span>
        </li>

        <li style="display: flex; align-items: center; gap: 10px; list-style: none;">
            <span class="text" style="display: flex; flex-direction: column; max-width: 100%;">
                <h3 style="font-size: 16px; font-weight: bold; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; max-width: 100%;">
                    <?= $operador->dias !== '' ? $operador->dias : 'No hay días asignados' ?>
                </h3>
                <p style="font-size: 14px; color: #666; margin: 0;">Días</p>
            </span>
        </li>
    </ul>
    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center justify-content-around">
                <h3 class="m-3">Tickets</h3>
                <a class="btn btn-primary m-5" href="<?= Url::to(['operador/ticket']) ?>">Ver</a>
            </span>
        </li>
        <li>
            <i class='bx bxs-file-archive'></i>
            <span class="text">
                <h3><?= $operador->getTickets()->where(['estado_ticket' => 'En proceso'])->count() ?></h3>
                <p> En proceso</p>
            </span>
        </li>

        <li>
            <i class='bx bx-file'></i>
            <span class="text">
                <h3><?= $operador->getTickets()->where(['estado_ticket' => 'Pendiente'])->count() ?></h3>
                <p> Pendientes</p>
            </span>
        </li>
        <li>
            <i class='bx bx-file'></i>
            <span class="text">
                <h3><?= $operador->getTickets()->where(['estado_ticket' => 'Resuleto'])->count() ?></h3>
                <p> Resueltos</p>
            </span>
        </li>
    </ul>
    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center justify-content-between">
                <h3 class="m-3">Mi especialidad</h3>
            </span>
        </li>
        <li>
            <i class='bx bx-user' style='color:black; background-color:#ffffff;'></i>
            <span class="text">
                <h3><?= $operador->departamento ?></h3>
            </span>
        </li>
    </ul>
</main>
<?= $this->render('_modal_asistencia', ['asistencia' => $asistencia,'id' => $id]) ?>

<?php
$script = <<<JS
$(document).ready(function() {
    const ticketsEnProceso = $ticket;
    if (ticketsEnProceso > 0) {
        Swal.fire({
            title: '¡Tienes Tickets nuevos!',
            html: 'Tienes <b>'+ticketsEnProceso+'</b> ticket(s) que ver.',
            icon: 'info',
            confirmButtonText: 'Ver tickets',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?r=operador/ticket'; // Redirige a la lista de tickets
            }
        });
    }
});

JS;
$this->registerJs($script);
?>