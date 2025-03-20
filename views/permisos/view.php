<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

use app\models\Acciones;
use app\models\Secciones;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
$this->title = "Permisos del " . $model->role . " " . ucfirst($model->nombre);
?>

<main>
    <div class="head-title">
        <div class="left mb-5">
            <h1>Permisos</h1>

        </div>

    </div>
    <!-- ... encabezado se mantiene igual ... -->

    <div class="table-data">
        <div class="order">
            <!-- ... información del detalle ... -->
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nombre',
                    'role',
                    [
                        'label' => 'Días de acceso',
                        'value' => function ($model) {
                            $fecha = new DateTime($model->created_at);
                            $hoy = new DateTime();
                            $diferencia = $hoy->diff($fecha);
                            return $diferencia->days . ' días';
                        }
                    ]
                ],
            ])?>
           

            <div class="head d-flex justify-content-around">
                <h2><?= Html::encode('Secciones') ?></h2>
                <?= Html::a('Restablecer permisos: ' . $model->role,['permisos/restablecer' , 'id' => $model->id,'rol' => $model->role],['class' => 'btn btn-danger']);?>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModalSeccion">Agregar Seccion</a>
            </div>

           

            <?php $idUsurio =  $model->id ?>
            <?php
            echo GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => array_column($seccionesData, 'seccion'),
                    'pagination' => false,
                ]),
                'summary' => false,
                'columns' => [
                    'nombre',
                    [
                        'label' => 'Acciones',
                        'format' => 'raw',
                        'value' => function ($model) use ($seccionesData, $idUsurio) {
                            $acciones = $seccionesData[$model->id]['acciones'] ?? [];
                            $accionesNombres = [1 => 'crear', 2 => 'leer', 3 => 'modificar', 4 => 'borrar'];
                    
                            $output = Html::beginForm(['permisos/actualizar'], 'post');
                    
                            // Campo oculto para la estructura del array
                            $output .= Html::hiddenInput("Secciones[acciones][{$model->id}]", '');
                    
                            foreach ($accionesNombres as $id => $nombre) {
                                $accion = current(array_filter($acciones, function ($a) use ($nombre) {
                                    return $a->nombre === $nombre;
                                }));
                    
                                $output .= Html::checkbox("Secciones[acciones][{$model->id}][]", (bool)$accion, [
                                    'value' => $id,
                                    'label' => Html::encode($nombre),
                                    'class' => 'form-check-input',
                                    'labelOptions' => ['style' => 'margin-right: 10px;']
                                ]);
                            }
                    
                            $output .= Html::hiddenInput('idUsuario', $idUsurio); // Agrega el ID del usuario autenticado
                    
                            // Botón de enviar
                            $output .= Html::submitButton('Guardar cambios', [
                                'class' => 'btn btn-primary mt-2'
                            ]);
                    
                            $output .= Html::endForm();
                    
                            return $output ?: 'Sin acciones';
                        }
                    ],
                    
                    
                    [
                        'label' => 'Quitar Seccion',
                        'format' => 'raw',
                        'value' => function ($m) use ($model) {
                            return Html::a('Quitar', ['permisos/eliminar', 'id' => $m->id, 'idUsuario' => $model->id], [
                                'class' => 'btn btn-danger',
                            ]);
                        }
                    ]
                ]
            ]);
            ?>

         
        </div>
    </div>
</main>

<?= $this->render('_modal_secciones', ['model' => $seccionForm, 'secciones' => $seccionesFaltantes, 'id' => $model->id]) ?>