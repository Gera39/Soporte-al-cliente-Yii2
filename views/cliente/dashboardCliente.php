<?php

use yii\widgets\ListView;
use yii\data\ArrayDataProvider;



?>
<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Vista Rapida</h1>
        </div>
    </div>
    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center justify-content-between">
                <h3 class="m-3">Tickets</h3>
                <i class='bx bx-chevrons-right'></i>
            </span>
        </li>
        <li>
            <i class='bx bxs-file-archive'></i>
            <span class="text">
                <h3>90</h3>
                <p> Cerrados</p>
            </span>
        </li>

        <li>
            <i class='bx bx-file'></i>
            <span class="text">
                <h3>90</h3>
                <p> Abiertos</p>
            </span>
        </li>
        <li>
            <i class='bx bx-file'></i>
            <span class="text">
                <h3>90</h3>
                <p> En Progreso</p>
            </span>
        </li>
    </ul>
    <ul class="box-info">
        <li>
            <span class="text d-flex align-items-center justify-content-between">
                <h3 class="m-3">Paquetes Contratados</h3>
                <i class='bx bx-chevrons-right'></i>
            </span>
        </li>
        <li>
            <i class='bx bx-phone'></i>
            <span class="text">
                <h3>100</h3>
                <p>Telefonia</p>
            </span>
        <li>
            <i class='bx bx-wifi'></i>
            <span class="text">
                <h3>Internet</h3>
            </span>
        </li>

        <?= ListView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $paquetes,
                'pagination' => false,
            ]),
            'itemOptions' => ['tag' => false], // Evita que Yii2 envuelva cada ítem en un div
            'itemView' => '_item', // Renderiza cada servicio con una vista separada
            'summary' => false, // Oculta el resumen de resultados (ejemplo: "Mostrando 1-10 de 100")
        ]) ?>
    </ul>
</main>