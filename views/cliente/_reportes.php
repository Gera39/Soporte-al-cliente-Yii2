<?php
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$dataProvider = new ArrayDataProvider([
    'allModels' => $reportes,
    'pagination' => ['pageSize' => false],
]);
echo  GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Reporte',
            'format' => 'raw',
            'headerOptions' => ['style' => ' text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'value' => function ($model) {
                return $model->nombre_reporte;
            },
        ],
        'descripcion',
        'estado_reporte',
        [
            'label' => 'Fecha',
            'value' => function ($model) {
                return date('d/m/Y', strtotime($model->fecha_reporte));
            },
        ],
        [
            'label' => 'Ticket',
            'headerOptions' => ['style' => ' text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->getTicket()->one()->id, ['ticket/view', 'id' => $model->id_ticket]);
            },
        ],
        [
            'label' => 'Operador',
            'headerOptions' => ['style' => ' text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'visible' => Yii::$app->user->identity->role === 'admin',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->getOperador()->one()->getUsuario()->one()->nombre, ['operador/view', 'id' => $model->getOperador()->one()->getUsuario()->one()->id]);
            },
        ],

    ],
]) 
?>

