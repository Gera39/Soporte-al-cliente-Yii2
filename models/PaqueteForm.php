<?php

namespace app\models;

use yii\base\Model;


class PaqueteForm extends Model
{
    public $nombre_paquete;
    public $descripcion;
    public $precio;
    public $servicios;

    public function rules()
    {
        return [
            [['descripcion', 'precio', 'servicios','nombre_paquete'], 'required', 'message' => 'Este campo no debe estar vacío'],
            ['descripcion', 'string', 'max' => 200, 'message' => 'La descripción no debe superar 200 caracteres'],
            ['precio', 'number', 'min' => 1, 'message' => 'El precio debe ser un número mayor o igual a 1'],
            [
                'servicios',
                function ($attribute) {
                    if (is_array($this->$attribute)) {
                        if (count($this->$attribute) < 1) {
                            $this->addError($attribute, 'Selecciona al menos un servicio.');
                        } else {
                            foreach ($this->$attribute as $id) {
                                if (!is_numeric($id)) {
                                    $this->addError($attribute, 'Todos los servicios deben ser IDs válidos.');
                                    break;
                                }
                            }
                        }
                    } else {
                        if (!is_numeric($this->$attribute)) {
                            $this->addError($attribute, 'Selecciona un servicio válido.');
                        }
                    }
                }
            ],
        ];
    }
}
