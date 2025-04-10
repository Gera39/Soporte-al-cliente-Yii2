<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

echo GridView::widget([
	'dataProvider' => new ArrayDataProvider([
		'allModels' => $empleados,
		'pagination' => [
            'pageSize' => 5,
        ],
		'sort' => [
			'attributes' => ['id'],
			'defaultOrder' => ['id' => SORT_DESC],
		],
	]),
	'layout' => "{items}\n{pager}", 
	'pager' => [
        'options' => ['class' => 'pagination'], 
        'maxButtonCount' => 5,
    ],
	'columns' => [
		'username',

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
			'attribute' => 'Calificación',
			'format' => 'raw',
			'headerOptions' => ['style' => 'text-align: center; font-size:16px;'],
			'value' => function ($model) {
				$calificacion = is_array($model)
					? ($model['calificacion_promedio'] ?? 0)
					: ($model->calificacion ?? 0);

				$stars = min($calificacion, 5);
				$html = '<div class="star-rating">';

				for ($i = 1; $i <= 5; $i++) {
					$html .= ($i <= $stars)
						? '<i class="bx bxs-star text-warning"></i>'
						: '<i class="bx bx-star text-secondary"></i>';
				}
				$html .= '</div>';
				return ($calificacion > 0) ? $html : '<span class="text-muted">Sin calificación</span>';
			},
			'contentOptions' => ['style' => 'font-size: 1rem;']
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
					. Html::a('<i class="bx bx-edit"></i>', ['operador/update', 'id' => $model['id']], ['class' => 'btn btn-sm btn-warning']);
			}
		]
	],
	
]);
