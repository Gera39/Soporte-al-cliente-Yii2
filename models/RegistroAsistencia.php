<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_asistencia".
 *
 * @property int $id
 * @property int $id_operador
 * @property string $fecha
 * @property string $hora_entrada
 * @property string|null $hora_salida
 * @property string|null $estado
 * @property string|null $comentarios
 * @property string|null $estatus_trabajo
 *
 * @property Operadores $operador
 */
class RegistroAsistencia extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_A_TIEMPO = 'A tiempo';
    const ESTADO_RETARDO = 'Retardo';
    const ESTADO_FALTA = 'Falta';
    const ESTATUS_TRABAJO_FALTA = 'Falta';
    const ESTATUS_TRABAJO_TRABAJANDO = 'Trabajando';
    const ESTATUS_TRABAJO_FINALIZADO = 'Finalizado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_asistencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hora_salida', 'comentarios'], 'default', 'value' => null],
            [['fecha'], 'default', 'value' => 'curdate()'],
            [['hora_entrada'], 'default', 'value' => 'curtime()'],
            [['estado'], 'default', 'value' => 'A tiempo'],
            [['estatus_trabajo'], 'default', 'value' => 'Trabajando'],
            [['id_operador'], 'required'],
            [['id_operador'], 'integer'],
            [['fecha', 'hora_entrada', 'hora_salida'], 'safe'],
            [['estado', 'comentarios', 'estatus_trabajo'], 'string'],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            ['estatus_trabajo', 'in', 'range' => array_keys(self::optsEstatusTrabajo())],
            [['id_operador'], 'exist', 'skipOnError' => true, 'targetClass' => Operador::class, 'targetAttribute' => ['id_operador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_operador' => 'Id Operador',
            'fecha' => 'Fecha',
            'hora_entrada' => 'Hora Entrada',
            'hora_salida' => 'Hora Salida',
            'estado' => 'Estado',
            'comentarios' => 'Comentarios',
            'estatus_trabajo' => 'Estatus Trabajo',
        ];
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
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_A_TIEMPO => 'A tiempo',
            self::ESTADO_RETARDO => 'Retardo',
            self::ESTADO_FALTA => 'Falta',
        ];
    }

    /**
     * column estatus_trabajo ENUM value labels
     * @return string[]
     */
    public static function optsEstatusTrabajo()
    {
        return [
            self::ESTATUS_TRABAJO_FALTA => 'Falta',
            self::ESTATUS_TRABAJO_TRABAJANDO => 'Trabajando',
            self::ESTATUS_TRABAJO_FINALIZADO => 'Finalizado',
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
    public function isEstadoATiempo()
    {
        return $this->estado === self::ESTADO_A_TIEMPO;
    }

    public function setEstadoToATiempo()
    {
        $this->estado = self::ESTADO_A_TIEMPO;
    }

    /**
     * @return bool
     */
    public function isEstadoRetardo()
    {
        return $this->estado === self::ESTADO_RETARDO;
    }

    public function setEstadoToRetardo()
    {
        $this->estado = self::ESTADO_RETARDO;
    }

    /**
     * @return bool
     */
    public function isEstadoFalta()
    {
        return $this->estado === self::ESTADO_FALTA;
    }

    public function setEstadoToFalta()
    {
        $this->estado = self::ESTADO_FALTA;
    }

    /**
     * @return string
     */
    public function displayEstatusTrabajo()
    {
        return self::optsEstatusTrabajo()[$this->estatus_trabajo];
    }

    /**
     * @return bool
     */
    public function isEstatusTrabajoFalta()
    {
        return $this->estatus_trabajo === self::ESTATUS_TRABAJO_FALTA;
    }

    public function setEstatusTrabajoToFalta()
    {
        $this->estatus_trabajo = self::ESTATUS_TRABAJO_FALTA;
    }

    /**
     * @return bool
     */
    public function isEstatusTrabajoTrabajando()
    {
        return $this->estatus_trabajo === self::ESTATUS_TRABAJO_TRABAJANDO;
    }

    public function setEstatusTrabajoToTrabajando()
    {
        $this->estatus_trabajo = self::ESTATUS_TRABAJO_TRABAJANDO;
    }

    /**
     * @return bool
     */
    public function isEstatusTrabajoFinalizado()
    {
        return $this->estatus_trabajo === self::ESTATUS_TRABAJO_FINALIZADO;
    }

    public function setEstatusTrabajoToFinalizado()
    {
        $this->estatus_trabajo = self::ESTATUS_TRABAJO_FINALIZADO;
    }
}
