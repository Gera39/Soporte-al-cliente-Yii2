<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paquetes_clientes".
 *
 * @property int $id
 * @property int $id_paquetes_servicios
 * @property int $id_cliente
 *
 * @property Cliente $cliente
 * @property Packages $paquetesServicios
 */
class PaquetesClientes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paquetes_clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paquetes_servicios', 'id_cliente'], 'required'],
            [['id_paquetes_servicios', 'id_cliente'], 'integer'],
            [['id_paquetes_servicios'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['id_paquetes_servicios' => 'id']],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['id_cliente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paquetes_servicios' => 'Id Paquetes Servicios',
            'id_cliente' => 'Id Cliente',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'id_cliente']);
    }

    /**
     * Gets query for [[PaquetesServicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaquetesServicios()
    {
        return $this->hasOne(Packages::class, ['id' => 'id_paquetes_servicios']);
    }

}
