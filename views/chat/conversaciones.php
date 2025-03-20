<?php
use yii\helpers\Html;
?>

<section id="tickets">
    <ul class="text-center overflow-auto" style="padding-left: 0px; max-height: 600px;">
       <?php if($tickets):?>
        <li>
            <div class="alert text-center alert-primary" role="alert">
                Tickets
            </div>
        </li>
        <?php foreach ($tickets as $t): ?>
            <li>
                <?= Html::a('Ticket #' . $t->id . ':' . $t->categoria->name,['chat/mostrar-chat', 'id' => $t->id],
                ['class' => 'btn text-center btn-success w-100 mb-3']);?>
            </li>
        <?php endforeach; ?>
        <?php else:?>
            <div class="alert text-center alert-danger" role="alert">
                No hay tickets
            </div>
        <?php endif;?>
    </ul>
</section>
