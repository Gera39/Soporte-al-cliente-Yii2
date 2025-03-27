<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historial_resolucion".
 *
 * @property int $id
 * @property int $id_ticket
 * @property int $id_usuario
 * @property string $rol_usuario
 * @property string $estado_anterior
 * @property string $estado_nuevo
 * @property string $comentario
 * @property string|null $fecha_cambio
 *
 * @property Tickets $ticket
 * @property Users $usuario
 */
class HistorialResolucion extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ROL_USUARIO_OPERADOR = 'Operador';
    const ROL_USUARIO_ADMINISTRADOR = 'Administrador';
    const ESTADO_ANTERIOR_PENDIENTE = 'Pendiente';
    const ESTADO_ANTERIOR_EN_PROCESO = 'En proceso';
    const ESTADO_ANTERIOR_RESUELTO = 'Resuelto';
    const ESTADO_ANTERIOR_CANCELADO = 'Cancelado';
    const ESTADO_ANTERIOR_ESCALADO = 'Escalado';
    const ESTADO_NUEVO_PENDIENTE = 'Pendiente';
    const ESTADO_NUEVO_EN_PROCESO = 'En proceso';
    const ESTADO_NUEVO_RESUELTO = 'Resuelto';
    const ESTADO_NUEVO_CANCELADO = 'Cancelado';
    const ESTADO_NUEVO_ESCALADO = 'Escalado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historial_resolucion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ticket', 'id_usuario', 'rol_usuario', 'estado_anterior', 'estado_nuevo', 'comentario'], 'required'],
            [['id_ticket', 'id_usuario'], 'integer'],
            [['rol_usuario', 'estado_anterior', 'estado_nuevo', 'comentario'], 'string'],
            [['fecha_cambio'], 'safe'],
            ['rol_usuario', 'in', 'range' => array_keys(self::optsRolUsuario())],
            ['estado_anterior', 'in', 'range' => array_keys(self::optsEstadoAnterior())],
            ['estado_nuevo', 'in', 'range' => array_keys(self::optsEstadoNuevo())],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
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
            'id_usuario' => 'Id Usuario',
            'rol_usuario' => 'Rol Usuario',
            'estado_anterior' => 'Estado Anterior',
            'estado_nuevo' => 'Estado Nuevo',
            'comentario' => 'Comentario',
            'fecha_cambio' => 'Fecha Cambio',
        ];
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
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::class, ['id' => 'id_usuario']);
    }


    /**
     * column rol_usuario ENUM value labels
     * @return string[]
     */
    public static function optsRolUsuario()
    {
        return [
            self::ROL_USUARIO_OPERADOR => 'Operador',
            self::ROL_USUARIO_ADMINISTRADOR => 'Administrador',
        ];
    }

    /**
     * column estado_anterior ENUM value labels
     * @return string[]
     */
    public static function optsEstadoAnterior()
    {
        return [
            self::ESTADO_ANTERIOR_PENDIENTE => 'Pendiente',
            self::ESTADO_ANTERIOR_EN_PROCESO => 'En proceso',
            self::ESTADO_ANTERIOR_RESUELTO => 'Resuelto',
            self::ESTADO_ANTERIOR_CANCELADO => 'Cancelado',
            self::ESTADO_ANTERIOR_ESCALADO => 'Escalado',
        ];
    }

    /**
     * column estado_nuevo ENUM value labels
     * @return string[]
     */
    public static function optsEstadoNuevo()
    {
        return [
            self::ESTADO_NUEVO_PENDIENTE => 'Pendiente',
            self::ESTADO_NUEVO_EN_PROCESO => 'En proceso',
            self::ESTADO_NUEVO_RESUELTO => 'Resuelto',
            self::ESTADO_NUEVO_CANCELADO => 'Cancelado',
            self::ESTADO_NUEVO_ESCALADO => 'Escalado',
        ];
    }

    /**
     * @return string
     */
    public function displayRolUsuario()
    {
        return self::optsRolUsuario()[$this->rol_usuario];
    }

    /**
     * @return bool
     */
    public function isRolUsuarioOperador()
    {
        return $this->rol_usuario === self::ROL_USUARIO_OPERADOR;
    }

    public function setRolUsuarioToOperador()
    {
        $this->rol_usuario = self::ROL_USUARIO_OPERADOR;
    }

    /**
     * @return bool
     */
    public function isRolUsuarioAdministrador()
    {
        return $this->rol_usuario === self::ROL_USUARIO_ADMINISTRADOR;
    }

    public function setRolUsuarioToAdministrador()
    {
        $this->rol_usuario = self::ROL_USUARIO_ADMINISTRADOR;
    }

    /**
     * @return string
     */
    public function displayEstadoAnterior()
    {
        return self::optsEstadoAnterior()[$this->estado_anterior];
    }

    /**
     * @return bool
     */
    public function isEstadoAnteriorPendiente()
    {
        return $this->estado_anterior === self::ESTADO_ANTERIOR_PENDIENTE;
    }

    public function setEstadoAnteriorToPendiente()
    {
        $this->estado_anterior = self::ESTADO_ANTERIOR_PENDIENTE;
    }

    /**
     * @return bool
     */
    public function isEstadoAnteriorEnProceso()
    {
        return $this->estado_anterior === self::ESTADO_ANTERIOR_EN_PROCESO;
    }

    public function setEstadoAnteriorToEnProceso()
    {
        $this->estado_anterior = self::ESTADO_ANTERIOR_EN_PROCESO;
    }

    /**
     * @return bool
     */
    public function isEstadoAnteriorResuelto()
    {
        return $this->estado_anterior === self::ESTADO_ANTERIOR_RESUELTO;
    }

    public function setEstadoAnteriorToResuelto()
    {
        $this->estado_anterior = self::ESTADO_ANTERIOR_RESUELTO;
    }

    /**
     * @return bool
     */
    public function isEstadoAnteriorCancelado()
    {
        return $this->estado_anterior === self::ESTADO_ANTERIOR_CANCELADO;
    }

    public function setEstadoAnteriorToCancelado()
    {
        $this->estado_anterior = self::ESTADO_ANTERIOR_CANCELADO;
    }

    /**
     * @return bool
     */
    public function isEstadoAnteriorEscalado()
    {
        return $this->estado_anterior === self::ESTADO_ANTERIOR_ESCALADO;
    }

    public function setEstadoAnteriorToEscalado()
    {
        $this->estado_anterior = self::ESTADO_ANTERIOR_ESCALADO;
    }

    /**
     * @return string
     */
    public function displayEstadoNuevo()
    {
        return self::optsEstadoNuevo()[$this->estado_nuevo];
    }

    /**
     * @return bool
     */
    public function isEstadoNuevoPendiente()
    {
        return $this->estado_nuevo === self::ESTADO_NUEVO_PENDIENTE;
    }

    public function setEstadoNuevoToPendiente()
    {
        $this->estado_nuevo = self::ESTADO_NUEVO_PENDIENTE;
    }

    /**
     * @return bool
     */
    public function isEstadoNuevoEnProceso()
    {
        return $this->estado_nuevo === self::ESTADO_NUEVO_EN_PROCESO;
    }

    public function setEstadoNuevoToEnProceso()
    {
        $this->estado_nuevo = self::ESTADO_NUEVO_EN_PROCESO;
    }

    /**
     * @return bool
     */
    public function isEstadoNuevoResuelto()
    {
        return $this->estado_nuevo === self::ESTADO_NUEVO_RESUELTO;
    }

    public function setEstadoNuevoToResuelto()
    {
        $this->estado_nuevo = self::ESTADO_NUEVO_RESUELTO;
    }

    /**
     * @return bool
     */
    public function isEstadoNuevoCancelado()
    {
        return $this->estado_nuevo === self::ESTADO_NUEVO_CANCELADO;
    }

    public function setEstadoNuevoToCancelado()
    {
        $this->estado_nuevo = self::ESTADO_NUEVO_CANCELADO;
    }

    /**
     * @return bool
     */
    public function isEstadoNuevoEscalado()
    {
        return $this->estado_nuevo === self::ESTADO_NUEVO_ESCALADO;
    }

    public function setEstadoNuevoToEscalado()
    {
        $this->estado_nuevo = self::ESTADO_NUEVO_ESCALADO;
    }
}
