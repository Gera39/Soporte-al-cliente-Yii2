<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operadores".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string|null $departamento
 * @property string|null $turno
 * @property string|null $dias
 *
 * @property EvaluacionesServicio[] $evaluacionesServicios
 * @property RegistroAsistencia[] $registroAsistencias
 * @property ReporteOperadores[] $reporteOperadores
 * @property Tickets[] $tickets
 * @property Users $usuario
 */
class Operador extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departamento','turno', 'dias'], 'default', 'value' => null],
            [['usuario_id'], 'required'],
            [['usuario_id'], 'integer'],
            [['departamento'], 'string', 'max' => 100],
            [['turno'], 'string', 'max' => 50],
            [['dias'], 'string', 'max' => 255],
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
            'departamento' => 'Departamento',
            'turno' => 'Turno',
            'dias' => 'Dias',
        ];
    }

    /**
     * Gets query for [[EvaluacionesServicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionesServicios()
    {
        return $this->hasMany(EvaluacionesServicio::class, ['id_operador' => 'id']);
    }

    /**
     * Gets query for [[RegistroAsistencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegistroAsistencias()
    {
        return $this->hasMany(RegistroAsistencia::class, ['id_operador' => 'id']);
    }

    /**
     * Gets query for [[ReporteOperadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReporteOperadores()
    {
        return $this->hasMany(ReporteOperadores::class, ['id_operador' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::class, ['id_operador' => 'id']);
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

}
