<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "packages".
 *
 * @property int $id
 * @property string $nombre_paquete
 * @property string $descripcion
 * @property int $precio
 *
 * @property PaqueteServicios[] $paqueteServicios
 * @property PaquetesClientes[] $paquetesClientes
 * @property Services[] $servicios
 * @property Tickets[] $tickets
 */
class Paquete extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'packages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_paquete', 'descripcion', 'precio'], 'required'],
            [['precio'], 'integer'],
            [['nombre_paquete', 'descripcion'], 'string', 'max' => 100],
            [['estado'], 'string'],
            [['estado'], 'default', 'value' => 'activo'],
            [['estado'], 'in', 'range' => ['activo', 'inactivo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_paquete' => 'Nombre Paquete',
            'descripcion' => 'Descripcion',
            'precio' => 'Precio',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[PaqueteServicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaqueteServicios()
    {
        return $this->hasMany(PaqueteServicios::class, ['paquete_id' => 'id']);
    }

    /**
     * Gets query for [[PaquetesClientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaquetesClientes()
    {
        return $this->hasMany(PaquetesClientes::class, ['id_paquetes_servicios' => 'id']);
    }

    /**
     * Gets query for [[Servicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServicios()
    {
        return $this->hasMany(Services::class, ['id' => 'servicio_id'])->viaTable('paquete_servicios', ['paquete_id' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::class, ['id_package' => 'id']);
    }

}
