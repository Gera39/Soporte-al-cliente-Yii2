<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "secciones".
 *
 * @property int $id
 * @property string $nombre
 * @property int $estado
 *
 * @property SeccionesAcciones[] $seccionesAcciones
 */
class Secciones extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'secciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => 1],
            [['nombre'], 'required'],
            [['estado'], 'integer'],
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
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[SeccionesAcciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeccionesAcciones()
    {
        return $this->hasMany(SeccionesAcciones::class, ['id_secciones' => 'id']);
    }

    public function getAcciones()
    {
        return $this->hasMany(Acciones::class, ['id' => 'id_acciones'])
            ->viaTable('secciones_acciones', ['id_secciones' => 'id']);
    }
}
