<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $nombre
 * @property string $username
 * @property string $password
 * @property string $UID
 * @property string $email
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $last_login
 * @property int $estado
 *
 * @property Administradores $administradores
 * @property Cliente $cliente
 * @property HistorialResolucion[] $historialResolucions
 * @property MensajesTicket[] $mensajesTickets
 * @property Operadores $operadores
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * ENUM field values
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_OPERADOR = 'operador';
    const ROLE_CLIENTE = 'cliente';
    public $grado;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grado'], 'string'],
            [['last_login'], 'default', 'value' => null],
            [['role'], 'default', 'value' => 'cliente'],
            [['estado'], 'default', 'value' => 1],
            [['nombre', 'username', 'password', 'UID', 'email'], 'required'],
            [['role'], 'string'],
            [['created_at', 'updated_at', 'last_login'], 'safe'],
            [['estado'], 'integer'],
            [['nombre', 'email'], 'string', 'max' => 100],
            [['username'], 'string', 'max' => 50],
            [['password', 'UID'], 'string', 'max' => 250],
            ['role', 'in', 'range' => array_keys(self::optsRole())],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['email', 'email', 'message' => 'El correo ingresado no es válido.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'username' => 'Username',
            'password' => 'Password',
            'UID' => 'Uid',
            'email' => 'Email',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_login' => 'Last Login',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Administradores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdministradores()
    {
        return $this->hasOne(Administradores::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['usuario_id' => 'id']);
    } 

    public function getSeccionesAcciones(){
        return $this->hasMany(SeccionesAcciones::class,['id_usuario' => 'id']);
    }

    public function getSecciones()
    {
        return $this->hasMany(Secciones::class, ['id' => 'id_secciones'])
            ->via('seccionesAcciones')
            ->with('acciones'); // Carga las acciones relacionadas
    }

    /**
     * Acciones asignadas al usuario (a través de la tabla pivote).
     */
    public function getAcciones()
    {
        return $this->hasMany(Acciones::class, ['id' => 'id_accion'])
        ->viaTable('secciones_acciones', ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[HistorialResolucions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistorialResolucions()
    {
        return $this->hasMany(HistorialResolucion::class, ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[MensajesTickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesTickets()
    {
        return $this->hasMany(MensajesTicket::class, ['id_remitente' => 'id']);
    }

    /**
     * Gets query for [[Operadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperadores()
    {
        return $this->hasOne(Operador::class, ['usuario_id' => 'id']);
    }


    /**
     * column role ENUM value labels
     * @return string[]
     */
    public static function optsRole()
    {
        return [
            self::ROLE_ADMIN => 'admin',
            self::ROLE_OPERADOR => 'operador',
            self::ROLE_CLIENTE => 'cliente',
        ];
    }

    /**
     * @return string
     */
    public function displayRole()
    {
        return self::optsRole()[$this->role];
    }

    /**
     * @return bool
     */
    public function isRoleAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function setRoleToAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isRoleOperador()
    {
        return $this->role === self::ROLE_OPERADOR;
    }

    public function setRoleToOperador()
    {
        $this->role = self::ROLE_OPERADOR;
    }

    /**
     * @return bool
     */
    public function isRoleCliente()
    {
        return $this->role === self::ROLE_CLIENTE;
    }

    public function setRoleToCliente()
    {
        $this->role = self::ROLE_CLIENTE;
    }

    
    public static function findIdentity($id)
    {
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['username'], $username) === 0) {
        //         return new static($user);
        //     }
        // }

        return self::findOne(['username' => $username   ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

}
