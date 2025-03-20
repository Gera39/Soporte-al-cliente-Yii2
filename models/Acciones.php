<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acciones".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property SeccionesAcciones[] $seccionesAcciones
 */
class Acciones extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 20],
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
        ];
    }

    /**
     * Gets query for [[SeccionesAcciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeccionesAcciones()
    {
        return $this->hasMany(SeccionesAcciones::class, ['id_acciones' => 'id']);
    }

}
