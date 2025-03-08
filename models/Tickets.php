<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tickets".
 *
 * @property int $id
 * @property int $id_categoria
 * @property int $id_package
 * @property int $id_cliente
 * @property int|null $id_operador
 * @property int|null $id_admin
 * @property string $descripcion
 * @property string|null $prioridad
 * @property string|null $fecha_ticket
 * @property string|null $fecha_resolucion
 * @property string|null $estado_ticket
 * @property string|null $comentario_resolucion
 *
 * @property Administradores $admin
 * @property ArchivosAdjuntos[] $archivosAdjuntos
 * @property Categories $categoria
 * @property Cliente $cliente
 * @property EvaluacionesServicio[] $evaluacionesServicios
 * @property HistorialResolucion[] $historialResolucions
 * @property MensajesTicket[] $mensajesTickets
 * @property Operadores $operador
 * @property Packages $package
 * @property ReporteOperadores[] $reporteOperadores
 */
class Tickets extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const PRIORIDAD_BAJA = 'Baja';
    const PRIORIDAD_MEDIA = 'Media';
    const PRIORIDAD_ALTA = 'Alta';
    const PRIORIDAD_CRITICA = 'Crítica';
    const ESTADO_TICKET_PENDIENTE = 'Pendiente';
    const ESTADO_TICKET_EN_PROCESO = 'En proceso';
    const ESTADO_TICKET_RESUELTO = 'Resuelto';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_operador', 'id_admin', 'fecha_resolucion', 'comentario_resolucion'], 'default', 'value' => null],
            [['prioridad'], 'default', 'value' => 'Media'],
            [['estado_ticket'], 'default', 'value' => 'Pendiente'],
            [['id_categoria', 'id_package', 'id_cliente', 'descripcion'], 'required'],
            [['id_categoria', 'id_package', 'id_cliente', 'id_operador', 'id_admin'], 'integer'],
            [['descripcion', 'prioridad', 'estado_ticket', 'comentario_resolucion'], 'string'],
            [['fecha_ticket', 'fecha_resolucion'], 'safe'],
            ['prioridad', 'in', 'range' => array_keys(self::optsPrioridad())],
            ['estado_ticket', 'in', 'range' => array_keys(self::optsEstadoTicket())],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['id_cliente' => 'id']],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['id_categoria' => 'id']],
            [['id_package'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::class, 'targetAttribute' => ['id_package' => 'id']],
            [['id_operador'], 'exist', 'skipOnError' => true, 'targetClass' => Operador::class, 'targetAttribute' => ['id_operador' => 'id']],
            [['id_admin'], 'exist', 'skipOnError' => true, 'targetClass' => Administradores::class, 'targetAttribute' => ['id_admin' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_categoria' => 'Id Categoria',
            'id_package' => 'Id Package',
            'id_cliente' => 'Id Cliente',
            'id_operador' => 'Id Operador',
            'id_admin' => 'Id Admin',
            'descripcion' => 'Descripcion',
            'prioridad' => 'Prioridad',
            'fecha_ticket' => 'Fecha Ticket',
            'fecha_resolucion' => 'Fecha Resolucion',
            'estado_ticket' => 'Estado Ticket',
            'comentario_resolucion' => 'Comentario Resolucion',
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
     * Gets query for [[ArchivosAdjuntos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArchivosAdjuntos()
    {
        return $this->hasMany(ArchivosAdjuntos::class, ['id_ticket' => 'id']);
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categories::class, ['id' => 'id_categoria']);
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
     * Gets query for [[EvaluacionesServicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionesServicios()
    {
        return $this->hasMany(EvaluacionesServicio::class, ['id_ticket' => 'id']);
    }

    /**
     * Gets query for [[HistorialResolucions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistorialResolucions()
    {
        return $this->hasMany(HistorialResolucion::class, ['id_ticket' => 'id']);
    }

    /**
     * Gets query for [[MensajesTickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesTickets()
    {
        return $this->hasMany(MensajesTicket::class, ['id_ticket' => 'id']);
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
     * Gets query for [[Package]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Paquete::class, ['id' => 'id_package']);
    }

    /**
     * Gets query for [[ReporteOperadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReporteOperadores()
    {
        return $this->hasMany(ReporteOperadores::class, ['id_ticket' => 'id']);
    }


    /**
     * column prioridad ENUM value labels
     * @return string[]
     */
    public static function optsPrioridad()
    {
        return [
            self::PRIORIDAD_BAJA => 'Baja',
            self::PRIORIDAD_MEDIA => 'Media',
            self::PRIORIDAD_ALTA => 'Alta',
            self::PRIORIDAD_CRITICA => 'Crítica',
        ];
    }

    /**
     * column estado_ticket ENUM value labels
     * @return string[]
     */
    public static function optsEstadoTicket()
    {
        return [
            self::ESTADO_TICKET_PENDIENTE => 'Pendiente',
            self::ESTADO_TICKET_EN_PROCESO => 'En proceso',
            self::ESTADO_TICKET_RESUELTO => 'Resuelto',
        ];
    }

    /**
     * @return string
     */
    public function displayPrioridad()
    {
        return self::optsPrioridad()[$this->prioridad];
    }

    /**
     * @return bool
     */
    public function isPrioridadBaja()
    {
        return $this->prioridad === self::PRIORIDAD_BAJA;
    }

    public function setPrioridadToBaja()
    {
        $this->prioridad = self::PRIORIDAD_BAJA;
    }

    /**
     * @return bool
     */
    public function isPrioridadMedia()
    {
        return $this->prioridad === self::PRIORIDAD_MEDIA;
    }

    public function setPrioridadToMedia()
    {
        $this->prioridad = self::PRIORIDAD_MEDIA;
    }

    /**
     * @return bool
     */
    public function isPrioridadAlta()
    {
        return $this->prioridad === self::PRIORIDAD_ALTA;
    }

    public function setPrioridadToAlta()
    {
        $this->prioridad = self::PRIORIDAD_ALTA;
    }

    /**
     * @return bool
     */
    public function isPrioridadCritica()
    {
        return $this->prioridad === self::PRIORIDAD_CRITICA;
    }

    public function setPrioridadToCritica()
    {
        $this->prioridad = self::PRIORIDAD_CRITICA;
    }

    /**
     * @return string
     */
    public function displayEstadoTicket()
    {
        return self::optsEstadoTicket()[$this->estado_ticket];
    }

    /**
     * @return bool
     */
    public function isEstadoTicketPendiente()
    {
        return $this->estado_ticket === self::ESTADO_TICKET_PENDIENTE;
    }

    public function setEstadoTicketToPendiente()
    {
        $this->estado_ticket = self::ESTADO_TICKET_PENDIENTE;
    }

    /**
     * @return bool
     */
    public function isEstadoTicketEnProceso()
    {
        return $this->estado_ticket === self::ESTADO_TICKET_EN_PROCESO;
    }

    public function setEstadoTicketToEnProceso()
    {
        $this->estado_ticket = self::ESTADO_TICKET_EN_PROCESO;
    }

    /**
     * @return bool
     */
    public function isEstadoTicketResuelto()
    {
        return $this->estado_ticket === self::ESTADO_TICKET_RESUELTO;
    }

    public function setEstadoTicketToResuelto()
    {
        $this->estado_ticket = self::ESTADO_TICKET_RESUELTO;
    }
    /**
     * Finds a single ticket by its ID.
     *
     * @param int $id
     * @return Tickets|null
     */
    public static function findOneById($id)
    {
        return self::findOne($id);
    }
}