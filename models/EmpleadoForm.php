<?php

namespace app\models;

use yii\base\Model;

class EmpleadoForm extends Model
{
    public $nombre;
    public $email;
    public $telefono;
    public $password;
    public $departamento;
    public $carrera;

    public function rules()
    {
        return [
            [['nombre', 'email','telefono', 'password', 'departamento', 'carrera'], 'required', 'message' => 'Este campo no debe de estar vacio'],
            ['nombre', 'string', 'max' => 10, 'message' => 'El nombre no debe de ser mayor a 10 caracteres'],
            ['nombre', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'El nombre solo debe contener letras y espacios'],
            ['email', 'email', 'message' => 'El correo no es valido'],
            ['telefono', 'match', 'pattern' => '/^\d{10}$/', 'message' => 'El teléfono debe contener exactamente 10 dígitos'],
            [['email'], 'unique', 'targetClass' => User::class, 'message' => 'El correo ya esta registrado'],
            ['password', 'string', 'min' => 8, 'message' => 'La contraseña debe de ser mayor a 8 caracteres']
        ];
    }
}
