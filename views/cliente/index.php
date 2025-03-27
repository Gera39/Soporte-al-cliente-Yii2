<?php

use app\models\Cliente;
use app\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<main>
	<div class="head-title">
		<div class="left mb-5">
			<h1>Clientes</h1>
		</div>
	</div>
	<ul class="box-info">
		<li>
			<?= Html::a("<i class='bx bxs-briefcase-alt-2'></i>", ['panel/empleados']); ?>
			<span class="text">
				<h3><?= User::find()->where(['role' => 'cliente'])->count(); ?>
				</h3>
				<p>Clientes</p>
			</span>
		</li>
		<li>
			<button class="filtro-btn" data-estado='0'><i class='bx bx-ghost' style="background-color:#000000; color:#ffffff;"></i></button>
			<span class="text">
				<h3><?= Cliente::find()
						->joinWith('usuario') // Relación directa
						->where(['users.estado' => 0])
						->andWhere(['users.role' => 'cliente'])
						->count(); ?>
				</h3>
				<p>Bloqueados</p>
			</span>
		</li>
		<li>
			<button class="filtro-btn" data-estado='1'><i class='bx bx-user-voice' style="background-color:#ffffff; color:#000000;"></i></button>
			<span class="text">
				<h3><?= Cliente::find()
						->joinWith('usuario') // Relación directa
						->where(['users.estado' => 1])
						->andWhere(['users.role' => 'cliente'])
						->count(); ?></h3>
				<p>Activos</p>
			</span>
		</li>
	</ul>
	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Todos los Clientes </h3>
				<?php $form = ActiveForm::begin([
					'method' => 'get',
					'action' => ['cliente/index'],
				]); ?>
				<div class="d-flex justify-content-around">
					<?= Html::textInput('search', $search, ['placeholder' => 'Buscar por username ó correo', 'class' => 'form-control', 'style' => 'width:450px;']) ?>
					<?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
				</div>

				<?php ActiveForm::end(); ?>
			</div>
			<div id="clientes-container">
			<?= $this->render('_clientes', ['clientes' => $clientes]) ?>
			</div>
		</div>


	</div>
</main>

<?php
$ajaxUrl = Url::to(['cliente/filtrar-cliente']);
$script = <<<JS
$(document).on('click','.filtro-btn',function(){
	let estado = $(this).data('estado');
	$.ajax({
		url: '$ajaxUrl',
		type: 'GET',
		data: {estado: estado},
		success: function(data){
			$('#clientes-container').html(data);
		}
	});
})
JS;

$this->registerJs($script);
?>