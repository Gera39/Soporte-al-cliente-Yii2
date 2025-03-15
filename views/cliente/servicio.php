<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Tienda ";
?>
<main>

    <div class="head-title">
        <div class="left">
            <h1 class=" d-flex align-items-center"><?= Html::encode($this->title)  ?><i class="bx bx-store"></i></h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Administrador</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="" href="#">Tienda</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h2><?= Html::encode('Paquetes') ?></h2>
                <div>
                    <button id="cargar-paquetes" type="button" class="btn btn-primary filtro-btn-comprita" data-permiso="no">
                        Paquetes Comprados
                        
                    </button>
                    <button  type="button" class="btn btn-success filtro-btn-comprita" data-permiso="comprar">
                        Comprar Paquetes
                    </button>
                </div>
            </div>
            <div id="paquetes-comprados">
                <?= $this->render('/servicio/_paquetes', ['paquetes' => array_filter($paquetes, function ($p) {
                    return $p->estado == 'activo';
                }), 'permiso' => $permiso]); ?>
            </div>
        </div>
    </div>
</main>
<?php
$ajaxUrl = Url::to(['cliente/paquetes-comprados']);
$script = <<<JS
$(document).on('click','.filtro-btn-comprita', function(){
    let permisoBoton = $(this).data('permiso');
    $.ajax({
        url: 'index.php?r=cliente/' + (permisoBoton === 'no' ?'paquetes-comprados' : 'servicios-cliente') ,
        type: 'GET',
        data: {
            estado: permisoBoton
        },
        success: function(response){
            $('#paquetes-comprados').html(response);
        },
        error: function(xhr, status, error) {
            console.log("Error AJAX:", xhr.responseText);
            alert('Error al filtrar los paquetes');
        }
    })
})


JS;
$this->registerJs($script);
?>