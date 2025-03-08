<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluaciones_servicio".
 *
 * @property int $id
 * @property int $id_ticket
 * @property int $id_cliente
 * @property int $id_operador
 * @property int|null $calificacion
 * @property string|null $comentario
 * @property string|null $fecha_evaluacion
 *
 * @property Cliente $cliente
 * @property Operadores $operador
 * @property Tickets $ticket
 */
class EvaluacionesServicio extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluaciones_servicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calificacion', 'comentario'], 'default', 'value' => null],
            [['id_ticket', 'id_cliente', 'id_operador'], 'required'],
            [['id_ticket', 'id_cliente', 'id_operador', 'calificacion'], 'integer'],
            [['comentario'], 'string'],
            [['fecha_evaluacion'], 'safe'],
            [['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Tickets::class, 'targetAttribute' => ['id_ticket' => 'id']],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['id_cliente' => 'id']],
            [['id_operador'], 'exist', 'skipOnError' => true, 'targetClass' => Operadores::class, 'targetAttribute' => ['id_operador' => 'id']],
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
            'id_cliente' => 'Id Cliente',
            'id_operador' => 'Id Operador',
            'calificacion' => 'Calificacion',
            'comentario' => 'Comentario',
            'fecha_evaluacion' => 'Fecha Evaluacion',
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
        return $this->hasOne(Operadores::class, ['id' => 'id_operador']);
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

}
