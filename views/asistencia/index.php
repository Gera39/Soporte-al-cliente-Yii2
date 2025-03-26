<?php

use app\models\RegistroAsistencia;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Asistencia ";
?>
<main>

    <div class="head-title">
        <div class="left mb-5">
            <h1 class=" d-flex align-items-center"><?= Html::encode($this->title)  ?></h1>
        </div>
    </div>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h2><?= Html::encode('Lista de Asistencia') ?></h2>
                <div>
                    <button type="button" class="btn btn-danger filtro-btn" data-estado="Falta" >
                        Falta
                        <span class="badge bg-red-500"><?= RegistroAsistencia::find()->where(['estatus_trabajo' => 'Falta'])->count() ?></span>
                    </button>
                    <button type="button" class="btn btn-success filtro-btn" data-estado="Trabajando" >
                        Trabajando
                        <span class="badge bg-yellow-500"><?= RegistroAsistencia::find()->where(['estatus_trabajo' => 'Trabajando'])->count() ?></span>
                    </button>
                    <button type="button" class="btn btn-primary filtro-btn" data-estado="Finalizado" >
                        Finalizado
                        <span class="badge bg-blue-500"><?= RegistroAsistencia::find()->where(['estatus_trabajo' => 'Finalizado'])->count() ?></span>
                    </button>
                </div>
            </div>
            <div id="asistencia-container">
                <?= $this->render('_tabla_asistencia', ['asistencias' => $asistencias]); ?>
            </div>
        </div>
    </div>
</main>

<?php
$ajaxUrl = Url::to(['asistencia/filtrar']);
$script = <<<JS
            $(document).on('click', '.filtro-btn', function() {
            let estado = $(this).data('estado');
            let id = $(this).data('id');
            
            $.ajax({
                url: '$ajaxUrl',
                type: 'GET',
                data: { estado: estado},
                success: function(response) {
                    $('#asistencia-container').html(response);
                },
                error: function() {
                    alert('Error al filtrar los tickets.');
                }
            });
        });
JS;

$this->registerJs($script);
?>