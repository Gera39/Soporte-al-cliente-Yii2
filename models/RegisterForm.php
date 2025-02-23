<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $nombre;
    public $apellido;
    public $password;
    public $role;
    public $email;
    public $telefono;

    public function rules()
    {
        return [
            [['nombre', 'apellido','role','email','telefono', 'password'], 'required'],
            // ... otras reglas de validación
        ];
    }
}
?>