<?php
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;
?>

<!-- MAIN -->
<main>
	<div class="head-title">
		<div class="left mb-5">
			<h1>Vista Rapida</h1>
		</div>

	</div>

	<!-- <ul class="box-info">
		<li>
			<i class='bx bxs-calendar-check'></i>
			<span class="text">
				<h3>78</h3>
				<p>Tickets Abiertos</p>
			</span>
		</li>
	</ul> -->

	<div class="table-data">
		<div class="todo">
			<div class="head">
				<h3>Recientes</h3>
			</div>
            <?php

            $dataProvider = new ArrayDataProvider([
                'allModels' => $logs,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'itemView' => function ($model, $key, $index, $widget) {
                    return '<li class="completed">
                                <p><span style="font-weight:bold; font-size:1.2em;">' . $model['nombre'] . '</span><br>' . $model['accion'] . '<br>' . date('Y/m/d', strtotime($model['fecha_evento'])) . '</p>
                            </li>';
                },
                'options' => [
                    'tag' => 'ul',
                    'class' => 'todo-list',
                ],
                'itemOptions' => [
                    'tag' => false,
                ],
            ]);
            ?>
		</div>
	</div>

</main>