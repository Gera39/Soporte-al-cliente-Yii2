<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs_sistema".
 *
 * @property int $id
 * @property string $nombre
 * @property string $accion
 * @property string|null $fecha_evento
 */
class Logs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs_sistema';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'accion'], 'required'],
            [['accion'], 'string'],
            [['fecha_evento'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'accion' => 'Accion',
            'fecha_evento' => 'Fecha Evento',
        ];
    }

}
