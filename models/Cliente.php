<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string|null $estado
 *
 * @property EvaluacionesServicio[] $evaluacionesServicios
 * @property PaquetesClientes[] $paquetesClientes
 * @property ReporteOperadores[] $reporteOperadores
 * @property Tickets[] $tickets
 * @property Users $usuario
 */
class Cliente extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_SUSPENDIDO = 'suspendido';
    const ESTADO_ELIMINADO = 'eliminado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => 'activo'],
            [['usuario_id'], 'required'],
            [['usuario_id'], 'integer'],
            [['estado'], 'string'],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['usuario_id'], 'unique'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[EvaluacionesServicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionesServicios()
    {
        return $this->hasMany(EvaluacionesServicio::class, ['id_cliente' => 'id']);
    }

    /**
     * Gets query for [[PaquetesClientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaquetesClientes()
    {
        return $this->hasMany(PaquetesClientes::class, ['id_cliente' => 'id']);
    }

    /**
     * Gets query for [[ReporteOperadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReporteOperadores()
    {
        return $this->hasMany(ReporteOperadores::class, ['id_cliente' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::class, ['id_cliente' => 'id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::class, ['id' => 'usuario_id']);
    }


    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_ACTIVO => 'activo',
            self::ESTADO_SUSPENDIDO => 'suspendido',
            self::ESTADO_ELIMINADO => 'eliminado',
        ];
    }

    /**
     * @return string
     */
    public function displayEstado()
    {
        return self::optsEstado()[$this->estado];
    }

    /**
     * @return bool
     */
    public function isEstadoActivo()
    {
        return $this->estado === self::ESTADO_ACTIVO;
    }

    public function setEstadoToActivo()
    {
        $this->estado = self::ESTADO_ACTIVO;
    }

    /**
     * @return bool
     */
    public function isEstadoSuspendido()
    {
        return $this->estado === self::ESTADO_SUSPENDIDO;
    }

    public function setEstadoToSuspendido()
    {
        $this->estado = self::ESTADO_SUSPENDIDO;
    }

    /**
     * @return bool
     */
    public function isEstadoEliminado()
    {
        return $this->estado === self::ESTADO_ELIMINADO;
    }

    public function setEstadoToEliminado()
    {
        $this->estado = self::ESTADO_ELIMINADO;
    }
}
