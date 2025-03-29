<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<main>
	<div class="head-title">
		<div class="left mb-5">
			<h1>Reportes</h1>

		</div>

	</div>
	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Todos los Reportes </h3>
				<?php if(Yii::$app->user->identity->role === "admin"):?>
                    <?php $form = ActiveForm::begin([
                    'method' => 'get',
					'id' => 'search-operador',
                    'action' => ['panel/reportes'], // Asegúrate de que el controlador sea correcto
                ]); ?>
                <div class="d-flex justify-content-around">
                    <?= Html::textInput('search', $search, ['placeholder' => 'Buscar Operador', 'class' => 'form-control']) ?>
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
					'id' => 'search-cliente',
                    'action' => ['panel/reportes'], // Asegúrate de que el controlador sea correcto
                ]); ?>
                <div class="d-flex justify-content-around">
                    <?= Html::textInput('searchCliente', $searchCliente, ['placeholder' => 'Buscar Cliente', 'class' => 'form-control']) ?>
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                    <?php endif;?>
			</div>
			<?= $this->render('_reportes', ['reportes' => $reportes]) ?>
		</div>


	</div>
</main>