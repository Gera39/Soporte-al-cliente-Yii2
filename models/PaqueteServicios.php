<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paquete_servicios".
 *
 * @property int $id
 * @property int $paquete_id
 * @property int $servicio_id
 *
 * @property Packages $paquete
 * @property Services $servicio
 */
class PaqueteServicios extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paquete_servicios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paquete_id', 'servicio_id'], 'required'],
            [['paquete_id', 'servicio_id'], 'integer'],
            [['paquete_id', 'servicio_id'], 'unique', 'targetAttribute' => ['paquete_id', 'servicio_id']],
            [['paquete_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::class, 'targetAttribute' => ['paquete_id' => 'id']],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['servicio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paquete_id' => 'Paquete ID',
            'servicio_id' => 'Servicio ID',
        ];
    }

    /**
     * Gets query for [[Paquete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaquete()
    {
        return $this->hasOne(Paquete::class, ['id' => 'paquete_id']);
    }

    /**
     * Gets query for [[Servicio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(Services::class, ['id' => 'servicio_id']);
    }

}
