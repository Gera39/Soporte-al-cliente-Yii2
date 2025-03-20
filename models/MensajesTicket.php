<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensajes_ticket".
 *
 * @property int $id
 * @property int $id_ticket
 * @property int $id_remitente
 * @property string $tipo_remitente
 * @property string $mensaje
 * @property string|null $fecha_envio
 * @property int|null $leido
 *
 * @property Users $remitente
 * @property Tickets $ticket
 */
class MensajesTicket extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TIPO_REMITENTE_CLIENTE = 'Cliente';
    const TIPO_REMITENTE_OPERADOR = 'Operador';
    const TIPO_REMITENTE_ADMINISTRADOR = 'Administrador';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajes_ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leido'], 'default', 'value' => 0],
            [['id_ticket', 'id_remitente', 'tipo_remitente', 'mensaje'], 'required'],
            [['id_ticket', 'id_remitente', 'leido'], 'integer'],
            [['tipo_remitente', 'mensaje'], 'string'],
            [['fecha_envio'], 'safe'],
            ['tipo_remitente', 'in', 'range' => array_keys(self::optsTipoRemitente())],
            [['id_remitente'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_remitente' => 'id']],
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
            'id_ticket' => 'Id Ticket',
            'id_remitente' => 'Id Remitente',
            'tipo_remitente' => 'Tipo Remitente',
            'mensaje' => 'Mensaje',
            'fecha_envio' => 'Fecha Envio',
            'leido' => 'Leido',
        ];
    }

    /**
     * Gets query for [[Remitente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRemitente()
    {
        return $this->hasOne(User::class, ['id' => 'id_remitente']);
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
     * column tipo_remitente ENUM value labels
     * @return string[]
     */
    public static function optsTipoRemitente()
    {
        return [
            self::TIPO_REMITENTE_CLIENTE => 'Cliente',
            self::TIPO_REMITENTE_OPERADOR => 'Operador',
            self::TIPO_REMITENTE_ADMINISTRADOR => 'Administrador',
        ];
    }

    /**
     * @return string
     */
    public function displayTipoRemitente()
    {
        return self::optsTipoRemitente()[$this->tipo_remitente];
    }

    /**
     * @return bool
     */
    public function isTipoRemitenteCliente()
    {
        return $this->tipo_remitente === self::TIPO_REMITENTE_CLIENTE;
    }

    public function setTipoRemitenteToCliente()
    {
        $this->tipo_remitente = self::TIPO_REMITENTE_CLIENTE;
    }

    /**
     * @return bool
     */
    public function isTipoRemitenteOperador()
    {
        return $this->tipo_remitente === self::TIPO_REMITENTE_OPERADOR;
    }

    public function setTipoRemitenteToOperador()
    {
        $this->tipo_remitente = self::TIPO_REMITENTE_OPERADOR;
    }

    /**
     * @return bool
     */
    public function isTipoRemitenteAdministrador()
    {
        return $this->tipo_remitente === self::TIPO_REMITENTE_ADMINISTRADOR;
    }

    public function setTipoRemitenteToAdministrador()
    {
        $this->tipo_remitente = self::TIPO_REMITENTE_ADMINISTRADOR;
    }
}
