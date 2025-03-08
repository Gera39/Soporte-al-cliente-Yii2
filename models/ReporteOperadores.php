<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reporte_operadores".
 *
 * @property int $id
 * @property string $nombre_reporte
 * @property string $descripcion
 * @property string|null $fecha_reporte
 * @property string|null $estado_reporte
 * @property int $id_ticket
 * @property int $id_cliente
 * @property int $id_operador
 *
 * @property Cliente $cliente
 * @property Operadores $operador
 * @property Tickets $ticket
 */
class ReporteOperadores extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_REPORTE_PENDIENTE = 'Pendiente';
    const ESTADO_REPORTE_EN_PROCESO = 'En proceso';
    const ESTADO_REPORTE_RESUELTO = 'Resuelto';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reporte_operadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_reporte'], 'default', 'value' => 'Pendiente'],
            [['nombre_reporte', 'descripcion', 'id_ticket', 'id_cliente', 'id_operador'], 'required'],
            [['descripcion', 'estado_reporte'], 'string'],
            [['fecha_reporte'], 'safe'],
            [['id_ticket', 'id_cliente', 'id_operador'], 'integer'],
            [['nombre_reporte'], 'string', 'max' => 30],
            ['estado_reporte', 'in', 'range' => array_keys(self::optsEstadoReporte())],
            [['id_operador'], 'exist', 'skipOnError' => true, 'targetClass' => Operador::class, 'targetAttribute' => ['id_operador' => 'id']],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['id_cliente' => 'id']],
            [['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Tickets::class, 'targetAttribute' => ['id_ticket' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_reporte' => 'Nombre Reporte',
            'descripcion' => 'Descripcion',
            'fecha_reporte' => 'Fecha Reporte',
            'estado_reporte' => 'Estado Reporte',
            'id_ticket' => 'Id Ticket',
            'id_cliente' => 'Id Cliente',
            'id_operador' => 'Id Operador',
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
     * Gets query for [[Operador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperador()
    {
        return $this->hasOne(Operador::class, ['id' => 'id_operador']);
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Tickets::class, ['id' => 'id_ticket']);
    }


    /**
     * column estado_reporte ENUM value labels
     * @return string[]
     */
    public static function optsEstadoReporte()
    {
        return [
            self::ESTADO_REPORTE_PENDIENTE => 'Pendiente',
            self::ESTADO_REPORTE_EN_PROCESO => 'En proceso',
            self::ESTADO_REPORTE_RESUELTO => 'Resuelto',
        ];
    }

    /**
     * @return string
     */
    public function displayEstadoReporte()
    {
        return self::optsEstadoReporte()[$this->estado_reporte];
    }

    /**
     * @return bool
     */
    public function isEstadoReportePendiente()
    {
        return $this->estado_reporte === self::ESTADO_REPORTE_PENDIENTE;
    }

    public function setEstadoReporteToPendiente()
    {
        $this->estado_reporte = self::ESTADO_REPORTE_PENDIENTE;
    }

    /**
     * @return bool
     */
    public function isEstadoReporteEnProceso()
    {
        return $this->estado_reporte === self::ESTADO_REPORTE_EN_PROCESO;
    }

    public function setEstadoReporteToEnProceso()
    {
        $this->estado_reporte = self::ESTADO_REPORTE_EN_PROCESO;
    }

    /**
     * @return bool
     */
    public function isEstadoReporteResuelto()
    {
        return $this->estado_reporte === self::ESTADO_REPORTE_RESUELTO;
    }

    public function setEstadoReporteToResuelto()
    {
        $this->estado_reporte = self::ESTADO_REPORTE_RESUELTO;
    }
}
