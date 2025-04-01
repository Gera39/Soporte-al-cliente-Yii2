<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RecoverForm extends Model{

    
    public $respuesta;

    public function rules()
    {
        return [
            ['respuesta', 'string', 'min' => 4, 'max' => 100, 'message' => 'La respuesta debe tener entre 4 y 100 caracteres'],
            [['respuesta'], 'required', 'message' => 'Este campo es obligatorio'],
        ];
    }
}
?>
