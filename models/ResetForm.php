<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model{

    public $email;

    public function rules()
    {
        return [
            [['email'], 'required', 'message' => 'Este campo es obligatorio'],
            ['email', 'email', 'message' => 'El formato del correo no es válido'],
        ];
    }
}
?>
