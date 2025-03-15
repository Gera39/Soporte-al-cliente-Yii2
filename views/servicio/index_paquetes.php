<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<main>
    <div class="head-title">
        <div class="left">
            <h1>Paquetes</h1>
            <ul class="breadcrumb">
                <li>
                    <?= Html::a('Administrador', ['panel/dashboard-admin'], ['class' => 'active']); ?>
                </li>
                <li>
                    <i class='bx bx-chevron-right'></i>
                </li>
                <li>
                    <a href="#">Paquetes</a>
                </li>
            </ul>
        </div>
        <?= Html::a('Ver servicios', ['servicio/servicios'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head d-flex justify-content-around">
                <h2><?= Html::encode('Lista de paquetes') ?></h2>
                <div>
                <button type="button" class="btn btn-danger filtro-btn-paquete" data-estado="inactivo" >
                    Suspendidos
                    <span class="badge bg-red-500"><?= count(array_filter($paquetes, function($paquete) { return $paquete->estado === 'inactivo'; })) ?></span>
                </button>
                <button type="button" class="btn btn-success filtro-btn-paquete" data-estado="activo">
                    Activos
                    <span class="badge bg-yellow-500"><?=count(array_filter($paquetes,function($paquete){return $paquete->estado === 'activo';}))?></span>
                </button>
                </div>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModalPaquete">Crear nuevo paquete</a>
            </div>
            <?php
            $ids = \yii\helpers\ArrayHelper::map($servicios, 'id', 'nombre_service');
            ?>
            <div id="paquetes-container">
                <?= $this->render('_paquetes', ['paquetes' => array_filter($paquetes, function($paquete) { return $paquete->estado === 'activo'; })]) ?>
            </div>
            <?= $this->render('_modal_paquete', ['paqueteForm' => $paqueteForm, 'servicios' => $ids]); ?>
        </div>
    </div>
</main>
<?php
$ajaxUrl = Url::to(['paquete/filtrar']);
$script = <<<JS
$(document).on('click','.filtro-btn-paquete', function(){
    let estado = $(this).data('estado');

    $.ajax({
        url: '$ajaxUrl',
        type: 'GET',
        data: {estado: estado},
        success: function(response){
            $('#paquetes-container').html(response);
        },
        error: function(){
            alert('Error al filtrar los paquetes');
        }
    })
})


JS;
$this->registerJs($script);
?>