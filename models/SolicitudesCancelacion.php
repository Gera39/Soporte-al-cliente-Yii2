<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitudes_cancelacion".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_paquete
 * @property int|null $id_admin
 * @property string $fecha_solicitud
 * @property string|null $estado_solicitud
 * @property string|null $razon_cancelacion
 * @property string|null $razon_respuesta
 * @property string $fecha_resolucion
 *
 * @property Administradores $admin
 * @property Packages $paquete
 * @property Users $usuario
 */
class SolicitudesCancelacion extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_SOLICITUD_PENDIENTE = 'Pendiente';
    const ESTADO_SOLICITUD_RECHAZADO = 'Rechazado';
    const ESTADO_SOLICITUD_APROBADO = 'Aprobado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitudes_cancelacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_admin', 'razon_cancelacion', 'razon_respuesta'], 'default', 'value' => null],
            [['estado_solicitud'], 'default', 'value' => 'Pendiente'],
            [['id_usuario', 'id_paquete'], 'required'],
            [['id_usuario', 'id_paquete', 'id_admin'], 'integer'],
            [['fecha_solicitud', 'fecha_resolucion'], 'safe'],
            [['estado_solicitud', 'razon_cancelacion', 'razon_respuesta'], 'string'],
            ['estado_solicitud', 'in', 'range' => array_keys(self::optsEstadoSolicitud())],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_paquete'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::class, 'targetAttribute' => ['id_paquete' => 'id']],
            [['id_admin'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_admin' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
            'id_paquete' => 'Id Paquete',
            'id_admin' => 'Id Admin',
            'fecha_solicitud' => 'Fecha Solicitud',
            'estado_solicitud' => 'Estado Solicitud',
            'razon_cancelacion' => 'Razon Cancelacion',
            'razon_respuesta' => 'Razon Respuesta',
            'fecha_resolucion' => 'Fecha Resolucion',
        ];
    }

    /**
     * Gets query for [[Admin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Administradores::class, ['id' => 'id_admin']);
    }

    /**
     * Gets query for [[Paquete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaquete()
    {
        return $this->hasOne(Paquete::class, ['id' => 'id_paquete']);
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
     * column estado_solicitud ENUM value labels
     * @return string[]
     */
    public static function optsEstadoSolicitud()
    {
        return [
            self::ESTADO_SOLICITUD_PENDIENTE => 'Pendiente',
            self::ESTADO_SOLICITUD_RECHAZADO => 'Rechazado',
            self::ESTADO_SOLICITUD_APROBADO => 'Aprobado',
        ];
    }

    /**
     * @return string
     */
    public function displayEstadoSolicitud()
    {
        return self::optsEstadoSolicitud()[$this->estado_solicitud];
    }


    public static function existeSolicitud($idUsuario, $idPaquete) {
        return self::find()
            ->where([
                'id_usuario' => $idUsuario,
                'id_paquete' => $idPaquete,
                'estado_solicitud' => 'Pendiente' 
            ])
            ->exists();
    }

    public static function existeSolicitudRechazadas($idUsuario, $idPaquete){
        return self::find()
        ->where([
            'id_usuario' => $idUsuario,
            'id_paquete' => $idPaquete,
            'estado_solicitud' => 'Rechazado' 
        ])
        ->exists(); 
    }

    /**
     * @return bool
     */
    public function isEstadoSolicitudPendiente()
    {
        return $this->estado_solicitud === self::ESTADO_SOLICITUD_PENDIENTE;
    }

    public function setEstadoSolicitudToPendiente()
    {
        $this->estado_solicitud = self::ESTADO_SOLICITUD_PENDIENTE;
    }

    /**
     * @return bool
     */
    public function isEstadoSolicitudRechazado()
    {
        return $this->estado_solicitud === self::ESTADO_SOLICITUD_RECHAZADO;
    }

    public function setEstadoSolicitudToRechazado()
    {
        $this->estado_solicitud = self::ESTADO_SOLICITUD_RECHAZADO;
    }

    /**
     * @return bool
     */
    public function isEstadoSolicitudAprobado()
    {
        return $this->estado_solicitud === self::ESTADO_SOLICITUD_APROBADO;
    }

    public function setEstadoSolicitudToAprobado()
    {
        $this->estado_solicitud = self::ESTADO_SOLICITUD_APROBADO;
    }
}
