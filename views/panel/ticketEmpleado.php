<?php
use yii\helpers\Html;

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
            <div class="head d-flex justify-content-between" >
                <h2><?= Html::encode('Tickets') ?></h2>
            </div>
            <?=$this->render('/cliente/_tickets',['tickets' => $tickets]);?>
        </div>
    </div>

</main>
