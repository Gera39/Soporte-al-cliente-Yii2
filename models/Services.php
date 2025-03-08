<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $nombre_service
 *
 * @property PaqueteServicios[] $paqueteServicios
 * @property Packages[] $paquetes
 */
class Services extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_service'], 'required'],
            [['nombre_service'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_service' => 'Nombre Service',
        ];
    }

    /**
     * Gets query for [[PaqueteServicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaqueteServicios()
    {
        return $this->hasMany(PaqueteServicios::class, ['servicio_id' => 'id']);
    }

    /**
     * Gets query for [[Paquetes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaquetes()
    {
        return $this->hasMany(Packages::class, ['id' => 'paquete_id'])->viaTable('paquete_servicios', ['servicio_id' => 'id']);
    }

}
