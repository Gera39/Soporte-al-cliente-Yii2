<?php 
use yii\helpers\Url;
$operador = $model->operadores;
$ticketsProceso = $operador->getTickets()->where(['estado_ticket' => 'En proceso'])->count();
$ticketsPendiente = $operador->getTickets()->where(['estado_ticket' => 'Pendiente'])->count();
$ticket = max($ticketsPendiente,$ticketsProceso);
?>

<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Vista Rapida</h1>
        </div>
        <a href="#" class="btn btn-primary d-flex align-items-center justify-content-center">
            <i class="bx bx-timer" style="font-size:28px; margin-right: 8px;"></i>
            <span>Marcar Turno Activo</span>
        </a>
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
            <h3><?=$operador->turno !== '' ? $operador->turno: 'No hay horario asginado'?></h3>
            <p>Hora entrada y salida</p>
            </span>
        </li>

        <li>
            <i class='bx bx-sun'></i>
            <span class="text">
                <h3><?=$operador->dias !== '' ? $operador->dias: 'No hay dias asginados'?></h3>
                <p>Dias</p>
            </span>
        </li>


    </ul>
    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center justify-content-around">
                <h3 class="m-3">Tickets</h3>
                <a class="btn btn-primary m-5" href="<?=Url::to(['operador/ticket'])?>">Ver</a>
            </span>
        </li>
        <li>
            <i class='bx bxs-file-archive'></i>
            <span class="text">
                <h3><?= $operador->getTickets()->where(['estado_ticket' => 'En proceso'])->count()?></h3>
                <p> En proceso</p>
            </span>
        </li>

        <li>
            <i class='bx bx-file'></i>
            <span class="text">
            <h3><?= $operador->getTickets()->where(['estado_ticket' => 'Pendiente'])->count()?></h3>
            <p> Pendientes</p>
            </span>
        </li>
        <li>
            <i class='bx bx-file'></i>
            <span class="text">
            <h3><?= $operador->getTickets()->where(['estado_ticket' => 'Resuleto'])->count()?></h3>
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
                <h3><?= $operador->departamento?></h3>
            </span>
        </li>
    </ul>
</main>


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