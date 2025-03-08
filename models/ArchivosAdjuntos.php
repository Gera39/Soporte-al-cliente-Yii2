<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "archivos_adjuntos".
 *
 * @property int $id
 * @property int $id_ticket
 * @property string $tipo_remitente
 * @property string $nombre_archivo
 * @property string $tipo_archivo
 * @property string $url_archivo
 * @property string|null $fecha_subida
 *
 * @property Tickets $ticket
 */
class ArchivosAdjuntos extends \yii\db\ActiveRecord
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
        return 'archivos_adjuntos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ticket', 'tipo_remitente', 'nombre_archivo', 'tipo_archivo', 'url_archivo'], 'required'],
            [['id_ticket'], 'integer'],
            [['tipo_remitente', 'url_archivo'], 'string'],
            [['fecha_subida'], 'safe'],
            [['nombre_archivo'], 'string', 'max' => 255],
            [['tipo_archivo'], 'string', 'max' => 50],
            ['tipo_remitente', 'in', 'range' => array_keys(self::optsTipoRemitente())],
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
            'tipo_remitente' => 'Tipo Remitente',
            'nombre_archivo' => 'Nombre Archivo',
            'tipo_archivo' => 'Tipo Archivo',
            'url_archivo' => 'Url Archivo',
            'fecha_subida' => 'Fecha Subida',
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
