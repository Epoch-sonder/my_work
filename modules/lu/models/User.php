<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int|null $role_id
 * @property int|null $branch_id
 * @property string|null $position
 * @property string|null $fio
 * @property string|null $phone
 * @property string $email
 * @property int $enabled
 * @property string $timestamp
 *
 * @property LuProcess $luProcess
 * @property Branch $branch
 * @property Roles $role
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['role_id', 'branch_id', 'enabled'], 'integer'],
            [['timestamp'], 'safe'],
            [['username', 'password'], 'string', 'max' => 255],
            [['position', 'fio'], 'string', 'max' => 300],
            [['phone'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['username'], 'unique'],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['role_id' => 'role_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'role_id' => 'Role ID',
            'branch_id' => 'Branch ID',
            'position' => 'Position',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'email' => 'Email',
            'enabled' => 'Enabled',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[LuProcess]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuProcess()
    {
        return $this->hasOne(LuProcess::className(), ['person_responsible' => 'id']);
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['role_id' => 'role_id']);
    }
}
