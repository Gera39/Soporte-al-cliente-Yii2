<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model{

    public $nombre;
    public $password;
    public $email;
    public $telefono;
    public $username;

    public function rules()
    {
        return [
            [['nombre', 'email', 'telefono', 'password'], 'required', 'message' => 'Este campo es obligatorio'],
            ['email', 'email', 'message' => 'El formato del correo no es válido'],
            ['telefono', 'match', 'pattern' => '/^\+?[0-9]{10,15}$/', 'message' => 'El teléfono debe contener entre 10 y 15 dígitos y puede comenzar con un +'],
            ['password', 'string', 'min' => 8, 'message' => 'La contraseña debe tener al menos 8 caracteres'],
            ['nombre', 'string', 'max' => 50, 'message' => 'El nombre no puede exceder los 50 caracteres'],
            ['username', 'string', 'min' => 4, 'max' => 20, 'message' => 'El nombre de usuario debe tener entre 4 y 20 caracteres'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Este nombre de usuario ya ha sido tomado'],
        ];
    }
}
?>