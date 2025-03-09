<?php
use yii\widgets\DetailView;
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Estado',
            'format' => 'raw',
            'value' => function ($model) {
                $usuario = $model->getUsuario()->one();
                $estadoTexto = ($usuario && $usuario->estado == '1') ? 'Activo' : 'Bloqueado';
                $clase = ($usuario && $usuario->estado == '1') ? 'btn-success' : 'btn-danger';
                return "<span class='btn $clase btn-block' onclick='mostrarAlerta({$usuario->id},\"$estadoTexto\")' style='padding: 5px; display: block; cursor:default;'>$estadoTexto</span>";
            },
        ],
        [
            'label' => 'Nombre',
            'value' => function ($model) {
                return ucfirst($model->getUsuario()->one()->nombre);
            },
        ],
        [
            'label' => 'Email',
            'value' => function ($model) {
                return $model->getUsuario()->one()->email;
            },
        ],
        [
            'label' => 'Telefono',
            'value' => function ($model) {
                return ucfirst($model->getUsuario()->one()->telefono);
            },
        ],
        [
            'label' => 'Fecha de Registro',
            'value' => function ($model) {
                return date('d/m/Y',strtotime($model->getUsuario()->one()->created_at));
            },
        ],
        [
            'label' => 'Departamento',
            'value' => function ($model){
                return $model->departamento;
            },
            
        ],
        [
            'label' => 'Horario',
            'value' => function ($model){
                return $model->turno;
            },
    
        ],
        [
            'label' => 'Dias',
            'value' => function ($model){
                return $model->dias;
            },
    
        ],
    ],
]);
?>