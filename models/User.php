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
 * @property string $email
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $last_login
 * @property int $is_active
 *
 * @property Messages[] $messages
 * @property TicketStatusHistory[] $ticketStatusHistories
 * @property Tickets[] $tickets
 * @property Tickets[] $tickets0
 */
class User extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_OPERATOR = 'operator';
    const ROLE_CLIENT = 'client';

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
            [['last_login'], 'default', 'value' => null],
            [['role'], 'default', 'value' => 'client'],
            [['is_active'], 'default', 'value' => 1],
            [['nombre', 'username', 'password', 'email'], 'required'],
            [['role'], 'string'],
            [['created_at', 'updated_at', 'last_login'], 'safe'],
            [['is_active'], 'integer'],
            [['nombre', 'email'], 'string', 'max' => 100],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 60],
            ['role', 'in', 'range' => array_keys(self::optsRole())],
            [['username'], 'unique'],
            [['email'], 'unique'],
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
            'email' => 'Email',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_login' => 'Last Login',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TicketStatusHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicketStatusHistories()
    {
        return $this->hasMany(TicketStatusHistory::class, ['changed_by' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tickets0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets0()
    {
        return $this->hasMany(Tickets::class, ['operator_id' => 'id']);
    }


    /**
     * column role ENUM value labels
     * @return string[]
     */
    public static function optsRole()
    {
        return [
            self::ROLE_ADMIN => 'admin',
            self::ROLE_OPERATOR => 'operator',
            self::ROLE_CLIENT => 'client',
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
    public function isRoleOperator()
    {
        return $this->role === self::ROLE_OPERATOR;
    }

    public function setRoleToOperator()
    {
        $this->role = self::ROLE_OPERATOR;
    }

    /**
     * @return bool
     */
    public function isRoleClient()
    {
        return $this->role === self::ROLE_CLIENT;
    }

    public function setRoleToClient()
    {
        $this->role = self::ROLE_CLIENT;
    }
}
