<?php

namespace app\models;

use yii\base\Model;


class ServicioForm extends Model
{
    public $nombre_service;

    public function rules()
    {
        return [
            [['nombre_service'], 'required', 'message' => 'Este campo no debe de estar vacio'],
            ['nombre_service', 'string', 'max' => 25, 'message' => 'El nombre no debe de ser mayor a 25 caracteres'],
            ['nombre_service', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'El nombre solo debe contener letras y espacios'],
        ];
    }
}
?>