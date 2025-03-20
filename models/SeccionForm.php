<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SeccionForm extends Model
{
    public $nombre;
    public $usuario_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'usuario_id'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['usuario_id'], 'integer'],

        ];
    }


    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'usuario_id' => 'Usuario',
        ];
    }
}
