<?php

namespace app\models;
use Yii;
use yii\base\Model;

class PreguntaForm extends Model{
    public $pregunta1;
    public $pregunta2;
    public $pregunta3;
    public $respuesta1;
    public $respuesta2;
    public $respuesta3;

    public function rules()
    {
        return [
            [['pregunta1', 'pregunta2', 'pregunta3'], 'string', 'min' => 4, 'max' => 100, 'message' => 'La pregunta debe tener entre 4 y 100 caracteres'],
            [['pregunta1', 'pregunta2', 'pregunta3'], 'required', 'message' => 'Este campo es obligatorio'],
            [['respuesta1', 'respuesta2', 'respuesta3'], 'string', 'min' => 4, 'max' => 100, 'message' => 'La respuesta debe tener entre 4 y 100 caracteres'],
            [['respuesta1', 'respuesta2', 'respuesta3'], 'required', 'message' => 'Este campo es obligatorio'],
        ];
    }
}

?>
