<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Modal;

$clase ="";
$correo ="";
if(Yii::$app->session->hasFlash('error')){
	$clase = "modal--show";
	$correo = Yii::$app->session->getFlash('error');
	Yii::$app->session->removeFlash('error');
}
?>
<main>
	<div class="head-title">
		<div class="left">
			<h1>Empleados</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Administrador</a>
				</li>
				<li><i class='bx bx-chevron-right'></i></li>
				<li>
					<a class="active" href="#">Empleados</a>
				</li>
			</ul>
		</div>
	</div>

	<ul class="box-info">
		<li>
			<i class='bx bxs-briefcase-alt-2'></i>
			<span class="text">
				<h3><?= $empleados[0]['cantidad'] ?></h3>
				<p>Empleados</p>
			</span>
		</li>
		<li>
			<i class='bx bx-ghost' style="background-color:#000000; color:#ffffff;"></i>

			<span class="text">
				<h3><?= $empleados[0]['inactivo'] ?></h3>
				<p>Bloqueados</p>
			</span>
		</li>
		<li>
			<i class='bx bx-user-voice' style="background-color:#ffffff; color:#000000;"></i>

			<span class="text">
				<h3><?= $empleados[0]["activo"] ?></h3>
				<p>Activos</p>
			</span>
		</li>

	</ul>
	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Lista de Empleados</h3>
				<a href="#" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary  p-2 "><i class='bx bx-plus'></i>Añadir empleado</a>
			</div>

			<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="myModalLabel">Agregar Empleado</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
						</div>

						<div class="modal-body">
							<?php $form = ActiveForm::begin([
								'id' => 'empleado-form',
								'action' => ['operador/guardar-operador'],
								'method' => 'post',
							]); ?>

							<div class="mb-3">
								<?= $form->field($model, 'nombre')->textInput([
									'class' => 'form-control',
									'id' => 'nombreEmpleado',
									'required' => true
								])->label('Nombre', ['class' => 'form-label text-dark'])
								 ?>
							</div>

							<div class="mb-3">
								<?= $form->field($model, 'email')->input('email', [
									'class' => 'form-control',
									'id' => 'emailEmpleado',
									'required' => true
								])->label('Correo Electrónico', ['class' => 'form-label text-dark']) ?>
							</div>

							<div class="mb-3">
								<?= $form->field($model, 'password')->passwordInput([
									'class' => 'form-control',
									'id' => 'passwordEmpleado',
									'required' => true,
								])->label('Password', ['class' => 'form-label text-dark']) ?>
							</div>

							<div class="row g-2 mb-3">
								<div class="col">
									<?= $form->field($model, 'departamento')->dropDownList([
										'Ingeniero' => 'Ingeniero',
										'Tecnico' => 'Técnico',
									], [
										'class' => 'form-select',
										'id' => 'departamentoEmpleado',
										'prompt' => 'Selecciona un grado'
									])->label('Departamento', ['class' => 'form-label text-dark']) ?>
								</div>

								<div class="col">
									<?= $form->field($model, 'carrera')->dropDownList([
										'Redes' => 'Redes',
										'Telecomunicaciones' => 'Telecomunicaciones',
										'Seguridad Informática' => 'Seguridad Informática',
										'Desarrollo de Software' => 'Desarrollo de Software',
										'Ciencia de Datos' => 'Ciencia de Datos',
										'Ciberseguridad' => 'Ciberseguridad',
										'Automatización y Robótica' => 'Automatización y Robótica',
									], [
										'prompt' => 'Selecciona una carrera', // Opción inicial vacía
										'class' => 'form-select',
										'id' => 'carreraEmpleado',
										'required' => true
									])->label('Carrera', ['class' => 'form-label text-dark']) ?>
								</div>

							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
								<?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
							</div>

							<?php ActiveForm::end(); ?>
						</div>
					</div>
				</div>
			</div>
			<?=
			GridView::widget([
				'dataProvider' => new ArrayDataProvider(['allModels' => $empleados]),
				'columns' => [
					
					[
						'attribute' => 'nombre',
						'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
					],
					[
						'attribute' => 'email',
						'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
						'contentOptions' => ['style' => 'text-align: center;'],
					],
					[
						'attribute' => 'departamento',
						'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
					],
					[
						'attribute' => 'Estado',
						'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
						'contentOptions' => function ($model) {
							return ['style' => 'text-align: center; background-color:' . ($model['estado'] == '1' ? '#d4edda' : '#f5c6cb')];
						},
						'value' => function ($model) {
							return ($model['estado']  == '1') ? 'Activo' : 'Bloqueado';
						}
					],
					[
						'attribute' => 'Permiso',
						'format' => 'raw',
						'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
						'contentOptions' => ['style' => 'text-align: center;'],
						'value' => function ($model) {
							$text = ($model['estado'] == '1') ? 'Bloquear' : 'Desbloquear';
							return Html::beginForm(['/operador/update-estatus', 'id' => $model['id']])
								. Html::hiddenInput('User[estado]', $model['estado'] == '1' ? '0' : '1')
								. Html::submitButton(
									$text,
									['class' => 'btn btn-sm ' . ($model['estado'] == '1' ? 'btn-danger' : 'btn-success')]
								)
								. Html::endForm();
						}
					],
					[
						'attribute' => 'Acciones',
						'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
						'contentOptions' => ['style' => 'text-align: center;'],
						'format' => 'raw',
						'value' => function ($model) {
							return Html::a('<i class="bx bx-user"></i>', ['operador/view', 'id' => $model['id']], ['class' => 'btn btn-sm btn-primary '])
								. Html::a('<i class="bx bx-edit"></i>', ['operador/update', 'id' => $model['id']], ['class' => 'btn btn-sm btn-warning'])
								. Html::a('<i class="bx bx-trash"></i>', ['operador/delete', 'id' => $model['id']], ['class' => 'btn btn-sm btn-danger']);
						}
					]
				],
			]);
			?>
		</div>
	</div>
	<section id="mi_modal" class="modalito <?= $clase?>">
		<div class="modal_container">
			<img class="modal_img" src="<?= Yii::getAlias('@web') ?>/images/modal.svg" alt="Descripción de la imagen">
			<h2 class="modal_title">Ups Algo salio mal!</h2>
			<p class="modal_paraghap">Este correo <span class="bg-danger text-white p-2" style="border-radius:6px;"><?= $correo?></span> ya esta en uso intenta con otro correo</p>
			<button id="cerrar_modal" class="btn btn-success" style="width: 200px;">Entendido</button>
		</div>
	</section>
</main>