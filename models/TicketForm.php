<?php
namespace app\models;
use yii\base\Model;

class TicketForm extends Model
{
    public $id_categoria;
    public $id_paquete;
    public $prioridad;
    public $id_cliente;
    public $descripcion;
    public $nombre_archivo;

    public function rules()
    {
        $this->prioridad = ['baja', 'media', 'alta'];
        return [
            [['id_categoria','id_paquete','prioridad','id_cliente','descripcion'] ,'required', 'message' => 'Este campo es obligatorio'],
            [['id_categoria','id_paquete','id_cliente'], 'integer', 'message' => 'Este campo debe ser un número entero'],
            [['descripcion'], 'string', 'max' => 200, 'message' => 'La descripción no debe superar 200 caracteres'],
            [['nombre_archivo'], 'file', 'extensions' => 'pdf, jpg, png', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'El archivo no debe superar los 2MB', 'message' => 'Solo se permiten archivos PDF, JPG y PNG']
        ];
    }
}

?>