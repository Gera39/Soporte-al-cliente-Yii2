<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
		<div class="left mb-4">
			<h1>Empleados</h1>
		</div>
	</div>

	<ul class="box-info">
		<li>
			<?= Html::a("<i class='bx bxs-briefcase-alt-2'></i>",['panel/empleados']);?>
			<span class="text">
				<h3><?= ($empleados) ? $empleados[0]['cantidad'] : 0 ?></h3>
				<p>Empleados</p>
			</span>
		</li>
		<li>
			<button class="filtro-btn" data-estado='0'><i class='bx bx-ghost' style="background-color:#000000; color:#ffffff;"></i></button>
			<span class="text">
				<h3><?= ($empleados) ? $empleados[0]['inactivo'] : 0 ?></h3>
				<p>Bloqueados</p>
			</span>
		</li>
		<li>
			<button class="filtro-btn" data-estado='1'><i class='bx bx-user-voice' style="background-color:#ffffff; color:#000000;"></i></button>
			<span class="text">
				<h3><?= ($empleados) ? $empleados[0]['activo'] : 0?></h3>
				<p>Activos</p>
			</span>
		</li>
	</ul>
	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Lista de Empleados</h3>
				<?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['panel/empleados'], 
                ]); ?>
                <div class="d-flex justify-content-around">
                    <?= Html::textInput('search', $search, ['placeholder' => 'Buscar por username', 'class' => 'form-control']) ?>
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary m-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
				<?php $form = ActiveForm::begin([
					'method' => 'get',
					'action' => ['panel/empleados'],
				]);?>
				<?= Html::a('Ordenar por Calificación', ['panel/empleados', 'sort' => 'calificacion_promedio'], ['class' => 'btn btn-warning m-2']) ?>
				<?php ActiveForm::end();?>
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
								<?= $form->field($model, 'telefono')->textInput([
									'class' => 'form-control',
									'id' => 'telefonoEmpleado',
									'required' => true
								])->label('Teléfono', ['class' => 'form-label text-dark']) ?>
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
										'prompt' => 'Selecciona una carrera', 
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
			<div id="empleado-container">
			<?= $this->render('_empleados' ,['empleados' => $empleados])?>
			</div>
		</div>
	</div>
	<section id="mi_modal" class="modalito  <?= $clase?>">
		<div class="modal_container">
			<img class="modal_img" src="<?= Yii::getAlias('@web') ?>/images/modal.svg" alt="Descripción de la imagen">
			<h2 class="modal_title">Ups Algo salio mal!</h2>
			<p class="modal_paraghap">Este correo <span class="bg-danger text-white p-2" style="border-radius:6px;"><?= $correo?></span> ya esta en uso intenta con otro correo</p>
			<button id="cerrar-modal" class="btn btn-success" style="width: 200px;">Entendido</button>
		</div>
	</section>
</main>


<?php 
$ajaxUrl = Url::to(['panel/filtrar-operadores']);
$script = <<<JS
	  $(document).on('click', '.filtro-btn', function() {
            let estado = $(this).data('estado');
            $.ajax({
                url: '$ajaxUrl',
                type: 'GET',
                data: { estado: estado},
                success: function(response) {
                    $('#empleado-container').html(response);
                },
                error: function() {
                    alert('Error al filtrar los tickets.');
                }
            });
        });

JS;

$this->registerJs($script);
?>