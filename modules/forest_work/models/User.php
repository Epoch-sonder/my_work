<?php

namespace app\modules\forest_work\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property int|null $branch_id
 * @property string|null $position
 * @property string|null $fio
 * @property string|null $phone
 * @property string|null $email
 * @property int $enabled
 *
 * @property Branch $branch
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
            [['username', 'password'], 'required'],
            [['branch_id', 'enabled'], 'integer'],
            [['username', 'password', 'role'], 'string', 'max' => 255],
            [['position', 'fio'], 'string', 'max' => 300],
            [['phone'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['username'], 'unique'],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
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
            'role' => 'Роль',
            'branch_id' => 'Филиал',
            'position' => 'Должность',
            'fio' => 'Ф.И.О.',
            'phone' => 'Номер телефона',
            'email' => 'Электронная почта',
            'enabled' => 'Enabled',
        ];
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
}
