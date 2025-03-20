<?php
use yii\helpers\Html;

?>

<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Tickets</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Tickets</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">tickets</a>
                </li>
            </ul>
        </div>

    </div>


    <div class="table-data">


        <div class="todo">
            <div class="head d-flex justify-content-between" >
                <h2><?= Html::encode('Tickets') ?></h2>
				<a href="#" data-bs-toggle="modal" data-bs-target="#myModalTicketCliente" class="btn btn-primary  p-2 "><i class='bx bx-plus'></i>Levantar tickets</a>
            </div>
            <?php usort($tickets, function($a, $b) { return $b->id - $a->id; }); ?>
            <?=$this->render('_tickets',['tickets' => $tickets]);?>
        </div>
    </div>

</main>

<?= $this->render('_modal_ticket',['ticketForm' => $ticketForm,'categoria' => $categoria,'paquetes' =>array_filter($paquetes,function($p){return [$p->id=>$p->nombre_paquete];})]);?>