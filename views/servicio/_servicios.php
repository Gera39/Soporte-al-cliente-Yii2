<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="todo">
    <div class="head">
        <h3>Servicios</h3>
        <a href="#" data-bs-toggle="modal" data-bs-target="#myModalServicio0" class="btn btn-primary  p-2 "><i class='bx bx-plus'></i>Añadir Servicio</a>
    </div>

    <div>
        <?php foreach ($servicios as $servi):
            $idServicio = $servi->id;
        ?>
            <ul class="todo-list">
                <li class="completed">
                    <h4><strong><?= htmlspecialchars($servi->nombre_service) ?></strong></h4>
                    <div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#myModalServicio<?=$idServicio?>" style="font-size:30px;"><i class="bx bx-edit-alt"></i></a>
                        <?= Html::a('<i class="bx bx-trash"></i>', ['servicio/delete', 'id' => $idServicio], ['style' => 'font-size:30px;']); ?>
                    </div>
                    
                    <?= $this->render('_modal', ['servicioForm' => $servi,'direccion' => 'update','id' => $idServicio]) ?>
            
                </li>
            </ul>
        <?php endforeach; ?>
    </div>

                    
    <?= $this->render('_modal', ['servicioForm' => $servicioForm,'direccion' => 'guardar','id' => '0']) ?>
  