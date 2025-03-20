<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "secciones_acciones".
 *
 * @property int $id
 * @property int $id_secciones
 * @property int $id_acciones
 * @property int $id_usuario
 *
 * @property Acciones $acciones
 * @property Secciones $secciones
 * @property Users $usuario
 */
class SeccionesAcciones extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'secciones_acciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_secciones', 'id_acciones', 'id_usuario'], 'required'],
            [['id_secciones', 'id_acciones', 'id_usuario'], 'integer'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_secciones'], 'exist', 'skipOnError' => true, 'targetClass' => Secciones::class, 'targetAttribute' => ['id_secciones' => 'id']],
            [['id_acciones'], 'exist', 'skipOnError' => true, 'targetClass' => Acciones::class, 'targetAttribute' => ['id_acciones' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_secciones' => 'Id Secciones',
            'id_acciones' => 'Id Acciones',
            'id_usuario' => 'Id Usuario',
        ];
    }

    /**
     * Gets query for [[Acciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcciones()
    {
        return $this->hasOne(Acciones::class, ['id' => 'id_acciones']);
    }

    /**
     * Gets query for [[Secciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSecciones()
    {
        return $this->hasOne(Secciones::class, ['id' => 'id_secciones']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::class, ['id' => 'id_usuario']);
    }

}
